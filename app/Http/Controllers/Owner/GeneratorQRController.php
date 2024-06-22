<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Scen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class GeneratorQRController extends Controller
{
    public function create()
    {
        return view('owner.qr.create');
    }

    public function qrCode()
    {
        $getQrcode = Scen::where('restaurant_id', Auth::user()->restaurant->id)->paginate(100);
        $data['header_title'] = 'QR Code';

        return view('owner.qr.generateQRCode', compact('getQrcode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_no' => 'required', // Add any validation rules as needed
        ]);

        try {
            // Create a new Scen instance
            $scen = new Scen;
            $scen->table_no = $request->table_no;
            $scen->restaurant_id = Auth::user()->restaurant->id;
            $scen->save();

            // Redirect to the download route with the Scen ID as a parameter
            return redirect()->route('downloadQrCode', ['scenId' => $scen->id]);
        } catch (\Exception $e) {
            return redirect()->route('generateQRCode')->with('error', 'Error creating Scen record: ' . $e->getMessage());
        }
    }

    public function downloadQrCode($scenId)
    {
        try {
            // Retrieve the Scen record
            $scen = Scen::findOrFail($scenId);

            // Generate QR code data
            $qrData = json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]);
            $qrCode = QrCode::size(200)
                ->format('png')
                ->errorCorrection('H')
                ->backgroundColor(255, 255, 255)
                ->color(0, 0, 0)
                ->margin(2)
                ->generate($qrData);

            // Set the image name with table number
            $imageName = 'qrcode_table_' . $scen->table_no . '.png';

            // Save QR code to storage
            Storage::disk('public')->put($imageName, $qrCode);

            // Get the full path to the image
            $path = Storage::disk('public')->path($imageName);

            // Set headers for the download
            $headers = [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $imageName . '"',
            ];

            // Return the file as a download response
            return response()->download($path, $imageName, $headers)->deleteFileAfterSend();
        } catch (\Exception $e) {
            Log::error('Error generating or downloading QR Code: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return redirect()->route('qrCode')->with('error', 'Unable to generate or download QR Code');
        }
    }

    public function deleteQrCode($scen)
    {
        try {
            $qrcode = Scen::findOrFail($scen);
            $qrcode->delete();
            return redirect()->route('generateQRCode')->with('success', 'QR Code successfully deleted.');
        } catch (\Exception $e) {
            return redirect()->route('generateQRCode')->with('error', 'Error deleting QR Code: ' . $e->getMessage());
        }
    }
}

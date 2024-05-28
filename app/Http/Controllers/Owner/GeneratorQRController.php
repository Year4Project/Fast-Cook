<?php

namespace App\Http\Controllers\Owner;


use App\Http\Controllers\Controller;
use App\Models\Scen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class GeneratorQRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            return view('owner/qr/download-qrcode/', ['scen' => $scen]);
        } catch (\Exception $e) {
            return redirect('owner/qr/generateQRCode')->with('error', 'Error creating Scen record: ' . $e->getMessage());
        }
    }
// old code downloadqr

public function downloadQrCode($scenId)
{
    try {
        // Retrieve the Scen record
        $scen = Scen::findOrFail($scenId);
        Log::info('Scen record found: ' . $scen->id);

        // Generate QR code data
        $qrData = json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]);
        $qrCode = QrCode::size(200)
            ->format('png')
            ->errorCorrection('H')
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(2)
            ->generate($qrData);
        Log::info('QR Code generated for data: ' . $qrData);

      

        // Set the image name with table number
        $imageName = 'qrcode_table_' . $scen->table_no . '.png';
        Log::info('Image name set: ' . $imageName);

        // Save QR code to storage
        $saved = Storage::disk('public')->put($imageName, $qrCode);
        if ($saved) {
            Log::info('QR Code saved at: ' . Storage::disk('public')->path($imageName));
        } else {
            Log::error('Failed to save QR Code at: ' . Storage::disk('public')->path($imageName));
            return response()->json(['error' => 'Unable to save QR Code.'], 500);
        }

        // Verify if the file was actually saved
        if (!Storage::disk('public')->exists($imageName)) {
            Log::error('File does not exist after save attempt: ' . Storage::disk('public')->path($imageName));
            return response()->json(['error' => 'Unable to save QR Code.'], 500);
        }

        // Get the full path to the image
        $path = Storage::disk('public')->path($imageName);
        Log::info('Full image path: ' . $path);

        // Set headers for the download
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $imageName . '"',
        ];

        // Return the file as a download response
        return response()->download($path, $imageName, $headers)->deleteFileAfterSend();

    } catch (\Exception $e) {
        Log::error('Error generating or downloading QR Code: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
        return response()->json(['error' => 'Unable to generate or download QR Code'], 500);
    }
}





    public function deleteQrCode($scen){

        $qrcode = Scen::findOrFail($scen);
        $qrcode->delete();
        return redirect('owner/qr/generateQRCode')->with('success', "QrCode successfully Delete.");
    }

}

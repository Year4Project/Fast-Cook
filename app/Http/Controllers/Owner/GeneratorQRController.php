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

        $getQrcode = Scen::where('restaurant_id', Auth::user()->restaurant->id)->paginate(10);

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
    // Retrieve the Scen record
    $scen = Scen::findOrFail($scenId);

    // Generate QR code
    $qrData = json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]);
    $qrCode = QrCode::size(200)
        ->format('png')
        ->errorCorrection('H')
        ->backgroundColor(255, 255, 255) // White background color (RGB)
        ->color(0, 0, 0) // Black QR code color (RGB)
        ->margin(2) // Add margin for border
        ->generate($qrData);

    // Set the image name with table number
    $imageName = 'qrcode_table_' . $scen->table_no . '.png';

    // Save QR code to storage
    Storage::disk('public')->put($imageName, $qrCode);

    $path = Storage::disk('public')->path($imageName); // Get the full path to the image

    // Set headers for the download
    $headers = [
        'Content-Type' => 'image/png', // Set the content type to PNG
    ];

    // Return the file as a download response
    return response()->download($path, $imageName, $headers)->deleteFileAfterSend();
}



    public function deleteQrCode($scen){

        $qrcode = Scen::findOrFail($scen);
        $qrcode->delete();
        return redirect('owner/qr/generateQRCode')->with('success', "QrCode successfully Delete.");
    }

}

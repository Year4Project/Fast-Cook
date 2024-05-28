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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

    // public function downloadQrCode($scenId)
    // {
    //     // Retrieve the Scen record
    //     $scen = Scen::findOrFail($scenId);
    //     Log::info('Scen record found: ' . $scen->id);

    //     // Generate QR code data
    //     $qrData = json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]);
    //     $qrCode = QrCode::size(200)
    //         ->format('png')
    //         ->errorCorrection('H')
    //         ->backgroundColor(255, 255, 255)
    //         ->color(0, 0, 0)
    //         ->margin(2)
    //         ->generate($qrData);

    //     // Define the filename
    //     $filename = 'qrcode_res_' . $scen->restaurant_id . '_table_' . $scen->table_no . '.png';

    //     // Define the directory path
    //     $directory = storage_path('app/public/qrcodes');

    //     // Create the directory if it doesn't exist
    //     File::makeDirectory($directory, $mode = 0777, true, true);

    //     // Save the QR code image with the filename
    //     $path = $directory . '/' . $filename;
    //     file_put_contents($path, $qrCode);

    //     // Set headers for file download
    //     $headers = [
    //         'Content-Type' => 'image/png',
    //         'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //     ];

    //     // Return response with QR code image
    //     return response($qrCode, 200, $headers);
    // }

    public function downloadQrCode($scenId)
    {
        // Retrieve the Scen record
        $scen = Scen::findOrFail($scenId);
        Log::info('Scen record found: ' . $scen->id);

        // Generate QR code data
        $qrData = json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]);

        // Generate QR code
        $qrCode = QrCode::format('png')->size(200)->generate($qrData);

        // Set headers for file download
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qrcode.png"',
        ];

        // Return response with QR code image
        return Response::make($qrCode, 200, $headers);
    }






    public function deleteQrCode($scen)
    {

        $qrcode = Scen::findOrFail($scen);
        $qrcode->delete();
        return redirect('owner/qr/generateQRCode')->with('success', "QrCode successfully Delete.");
    }
}

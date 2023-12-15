<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Scen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function downloadQrCode($scenId)
    {
        // Retrieve the Scen record
        $scen = Scen::findOrFail($scenId);

        // Set the margin (border) to 10 (adjust as needed)
        $marginSize = 10;

        // Generate QR code
        $qrCode = QrCode::size(100)
            ->margin($marginSize)
            ->generate(json_encode(['restaurant_id' => $scen->restaurant_id, 'table_no' => $scen->table_no]));

        // Set response headers
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qrcode.png"',
        ];

        // Return the response with QR code image
        $response = response($qrCode, 200, $headers);

        // Add a custom header to indicate that the download has occurred
        $response->header('Downloaded', true);

        return $response;
    }
}

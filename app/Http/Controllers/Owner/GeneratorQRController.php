<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Scen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneratorQRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(){
        
        return view('owner.qr.create');
    }
    public function qrCode(){

        $data['getListMenu'] = Scen::getScen();
        $data['header_title'] = 'QR Code';
        
        return view('owner.qr.generateQRCode',$data);
    }


    public function store(Request $request){
        $number = mt_rand(1000000000,9999999999);
         
        if ($this->tableCodeExists($number)) {
            $number = mt_rand(1000000000,999999999);
        }
         
        $request['table_code'] = $number;
        Scen::create($request->all());
 
        return redirect('owner/qr/generateQRCode');
    }

    public function tableCodeExists($number){
        return Scen::whereTableCode($number)->exists();
    }
    // public function download(){
    //     $imageName = 'qrcode';

    //     $header = array('Content-Type' => ['png','svg','eqs']);

    //     $qrcode = Scen::format('png')->size(200)->errorCorrection('H')->generate(Scen::all());
        
    //     Scen::disk('public')->put($imageName, $qrcode);
        
    //     return response()->download('storage/'.$imageName, $imageName.'.png', $header)->deleteFileAfterSend();
    // }
}

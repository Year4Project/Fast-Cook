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

        $data['getQrcode'] = Scen::getQrcode();
        $data['header_title'] = 'QR Code';
        
        return view('owner.qr.generateQRCode',$data);
    }


    public function store(Request $request){
        $number = mt_rand(1000000000,9999999999);
         
        if ($this->tableCodeExists($number)) {
            $number = mt_rand(1000000000,999999999);
        }
        
        $scen = new Scen;
        $scen->table_no = $request->table_no;
        $scen->table_code = $number;
        $scen->restaurant_id= Auth::user()->id;
        $scen->save();
        return redirect('owner/qr/generateQRCode');
    }

    public function tableCodeExists($number){
        return Scen::whereTableCode($number)->exists();
    }

}

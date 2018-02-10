<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class GetQrCodeController extends Controller
{
    public function index(){
        if(!file_exists(public_path('qrcodes')))
            mkdir(public_path('qrcodes'));

        QrCode::format('png')->size(300)->generate('Hello,LaravelAcademy!',public_path('qrcodes/qrcode.png'));


        $QrCodePath="qrcodes/qrcode.png";
        return $QrCodePath ;
    }
}

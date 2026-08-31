<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class speed_cache_pro_license_api extends Controller
{
    function generate_license_key(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $licenseKey = '';
        for($i = 0; $i < 10; $i++){
            $licenseKey .= $characters[rand(0,(strlen($characters)-1))];        
        }

        return $licenseKey;
    }
    function create_license_key(Request $createKeyParams){
        $licenseKey = generate_license_key();
        $newKey = new speed_cache_pro_license();
        $newKey->license_key = $licenseKey;
        $newKey->whmcs_service_id = $createKeyParams->$whmserviceid;
        $newKey->status = 'Active';
        $newKey->package = $createKeyParams->status;
        $newKey->expiry_date = '2026-09-30';

    }
}

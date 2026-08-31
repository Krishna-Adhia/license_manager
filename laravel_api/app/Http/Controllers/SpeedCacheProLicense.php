<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\license;

class SpeedCacheProLicense extends Controller
{
    function generate_license_key(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $licenseKey = '';
        for($i = 0; $i < 10; $i++){
            $licenseKey .= $characters[rand(0,(strlen($characters)-1))];        
        }

        return $licenseKey;
    }

    function createLicenseKey(Request $createKeyParams){
        $licenseKey = generate_license_key();
        $newKey = new license();
        $newKey->license_key = $licenseKey;
        $newKey->whmcs_service_id = $createKeyParams->$whmserviceid;
        $newKey->status = 'Active';
        $newKey->package = $createKeyParams->packagetype;
        $newKey->expiry_date = '2026-09-30';

        if($newKey->save()){
            return ["result"=>"License key created successfully"];
        } else {
            return ["result"=>"Something went wrong while creating license key"];
        }

    }

    function terminateLicenseKey(Request $terminateKeyParams){
        $terminateKey = new license();        
        //find the license key in db
        $key = license::where('license_key',$terminateKeyParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else {
            $terminateKey->status = 'Terminated';
            if($terminateKey->save()){
                return ["result"=>"License key terminated"];
            } else{
                return ["result"=>"Something went wrong while terminating license key"];
            }
        }
    }

    function suspendLicenseKey(Request $suspendKeyParams){
        $suspendKey = new license();        
        //find the license key in db
        $key = license::where('license_key',$suspendKeyParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else {
            $suspendKey->status = 'Suspended';
            if($suspendKey->save()){
                return ["result"=>"License key suspended"];
            } else{
                return ["result"=>"Something went wrong while suspending license key"];
            }
        }
    }

    function unsuspendLicenseKey(Request $unsuspendKeyParams){
        $unsuspendKey = new license();

        //find the license key in db        
        $key = license::where('license_key',$unsuspendKeyParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else{
            $unsuspendKey->status = 'Active';
            if($unsuspendKey->save()){
                return ["result"=>"License key unsuspended"];
            } else{
                return ["result"=>"Something went wrong while unsuspending license key"];
            }
        }
    }

    function updatePlan(Request $updatePlanParams){
        $updatePlan = new license();
        $key = license::where('license_key',$updatePlanParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else{
            $updatePlan->package = $updatePlanParams->package;
            if($updatePlan->save()){
                return ["result"=>"Plan upgraded"];
            } else{
                ["result"=>"Something went wrong while upgrading plan"];
            }
        }
    }    

    function deleteLicenseKey(Request $deleteKeyParams){
        $deleteKey = new license();

        //delete the license key
        $key = license::where('license_key',$deleteKeyParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else{
            if($deleteKey->destroy($deleteKeyParams->licenseKey)){
                return ["result"=>"License key deleted"];
            } else{
                return ["result"=>"Something went wrong while deleting license key"];
            }
        }
    }

    function getLicenseKey(Request $getKeyParams){
        $getKeyDetails = new license();
        $key = license::where('license_key',$getKeyParams->licenseKey)->first();
        if(!$key){
            return ["result"=>"Key not found"];
        } else{
            return ["result"=>$key];
        }
    }
}

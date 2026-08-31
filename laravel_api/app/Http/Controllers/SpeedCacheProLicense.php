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
        $licenseKey = $this->generate_license_key();
        $newKey = new license();
        $newKey->license_key = $licenseKey;
        $newKey->whmcs_service_id = $createKeyParams->whmserviceid;
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
        //find the license key in db
        $terminateLicenseKey = license::where('license_key',$terminateKeyParams->licenseKey)->first();
        if(!$terminateLicenseKey){
            return ["result"=>"Key not found"];
        } else {
            $terminateLicenseKey->status = 'Terminated';
            if($terminateLicenseKey->save()){
                return ["result"=>"License key terminated"];
            } else{
                return ["result"=>"Something went wrong while terminating license key"];
            }
        }
    }

    function suspendLicenseKey(Request $suspendKeyParams){        
        //find the license key in db
        $suspendLicenseKey = license::where('license_key',$suspendKeyParams->licenseKey)->first();
        if(!$suspendLicenseKey){
            return ["result"=>"Key not found"];
        } else {
            $suspendLicenseKey->status = 'Suspended';
            if($suspendLicenseKey->save()){
                return ["result"=>"License key suspended"];
            } else{
                return ["result"=>"Something went wrong while suspending license key"];
            }
        }
    }

    function unsuspendLicenseKey(Request $unsuspendKeyParams){       
        //find the license key in db        
        $unsuspendLicenseKey = license::where('license_key',$unsuspendKeyParams->licenseKey)->first();
        if(!$unsuspendLicenseKey){
            return ["result"=>"Key not found"];
        } else{
            $unsuspendLicenseKey->status = 'Active';
            if($unsuspendLicenseKey->save()){
                return ["result"=>"License key unsuspended"];
            } else{
                return ["result"=>"Something went wrong while unsuspending license key"];
            }
        }
    }

    function updatePlan(Request $updatePlanParams){        
        $updatePlanLicenseKey = license::where('license_key',$updatePlanParams->licenseKey)->first();
        if(!$updatePlanLicenseKey){
            return ["result"=>"Key not found"];
        } else{
             $updatePlanLicenseKey->package = $updatePlanParams->package;
            if($updatePlanLicenseKey->save()){
                return ["result"=>"Plan upgraded"];
            } else{
                ["result"=>"Something went wrong while upgrading plan"];
            }
        }
    }    

    function deleteLicenseKey(Request $deleteKeyParams){        
        //delete the license key
        $deleteLicenseKey = license::where('license_key',$deleteKeyParams->licenseKey)->first();
        if(!$deleteLicenseKey){
            return ["result"=>"Key not found"];
        } else{
            if($deleteLicenseKey->delete()){
                return ["result"=>"License key deleted"];
            } else{
                return ["result"=>"Something went wrong while deleting license key"];
            }
        }
    }

    function getLicenseKey(Request $getKeyParams){       
        $getKeyDetails = license::where('license_key',$getKeyParams->licenseKey)->first();
        if(!$getKeyDetails){
            return ["result"=>"Key not found"];
        } else{
            return ["result"=>$getKeyDetails];
        }
    }
}

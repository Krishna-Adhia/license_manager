<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\license;

class SpeedCacheProLicense extends Controller
{
    function generate_license_key(){        
        $licenseKey = '';
        $licenseKey = strtoupper(implode('-', str_split(bin2hex(random_bytes(8)), 4)));     
        
        return $licenseKey;
    }

    function createLicenseKey(Request $createKeyParams){
        //validate input (missing/wrong data returns 422)
        $data = $createKeyParams->validate([
            'whmserviceid' => 'required|integer',
            'billingcycle' => 'required|string|max:50',
            'domainsAvailable' => 'required|integer|min:1'            
        ]);

        //for existing serice second liscense should not get created
        $existing = license::where('whmcs_service_id',$data['whmserviceid'])->first();
        if($existing){
            return response()->json([
                "result" => "License already exists for this service",
                "license_key" => $existing->license_key,
            ],200);
        }
        try{
            $newKey = new license();
            $licenseKey = $this->generate_license_key();        
            $newKey->license_key = $licenseKey;
            $newKey->whmcs_service_id = $createKeyParams->whmserviceid;
            $newKey->max_domain = $createKeyParams->domainsAvailable;
            $newKey->status = 'Active';
            $newKey->billingcycle = $createKeyParams->billingcycle;
            $newKey->expiry_date = $createKeyParams->nextduedate;
            $newKey->save();
        } catch (\Exception $e){
            \Log::error('Create license failed: '.$e->getMessage());
            return response()->json(["result" => "Could not create license key"], 500);
        }

        return response()->json([
            "result"      => "License key created successfully",
            "license_key" => $newKey->license_key,
        ], 201);

    }

    //reads and validates whmcs serviceid, and find the license key and return it, if not found return null
    private function findLicense(Request $request){
        $data = $request->validate([
            'whmserviceid' => 'required|integer',
        ]);

        return license::where('whmcs_service_id',$data['whmserviceid'])->first();
    }

    private function notFoundLicense(){
        return response()->json(["result" => "License key not found"], 404);
    }

    private function serverError($action, \Exception $e){
        \Log::error("$action failed: ".$e->getMessage());
        return response()->json(["result" => "Could not $action license key"], 500);
    }

    function terminateLicenseKey(Request $terminateKeyParams){                        
        //find the license key in db
        $license = $this->findLicense($terminateKeyParams);
        if (!$license){
            return $this->notFoundLicense();
        }

        if($license->status == 'Terminated'){
            return response()->json(["result" => "License key already terminated"], 200);
        }

        try {
            $license->status = 'Terminated';
            $license->save();
        } catch (\Exception $e){
            return $this->serverError('terminate', $e);
        }

        return response()->json(["result" => "License key terminated"], 200);
    }

    function suspendLicenseKey(Request $suspendKeyParams){        
        $license = $this->findLicense($suspendKeyParams);
        if(!$license){
            return $this->notFoundLicense();
        }

        if($license->status == 'Suspended'){
            return response()->json(["result" => "License key already suspended"], 200);
        }

        if($license->status != 'Active'){
            return response()->json(["result" => "Only an active license can be suspended"], 409);
        }

        try{
            $license->status = 'Suspended';
            $license->save();
        } catch(\Exception $e){
            return $this->serverError('suspend', $e);
        }
        return response()->json(["result" => "License key suspended"], 200);
    }


    function unsuspendLicenseKey(Request $unsuspendKeyParams){       
        $license = $this->findLicense($unsuspendKeyParams);
        if(!$license){
            return $this->notFoundLicense();            
        }

        if($license->status == 'Active'){
            return response()->json(["result" => "License key already active"], 200);
        }

        if($license->status != 'Suspended'){
            return response()->json(["result" => "Only an suspended license can be unsuspended"], 409);
        }

        try{
            $license->status = 'Active';
            $license->save();
        } catch(\Exception $e){
            return $this->serverError('unsuspend',$e);
        }
        return response()->json(["result" => "License key unsuspended"], 200);
    }

    function updatePlan(Request $updatePlanParams){        
        $data = $updatePlanParams->validate([
            'whmserviceid'     => 'required|integer',
            'billingcycle'     => 'required|string|max:50',
            'domainsAvailable' => 'required|integer|min:1',
        ]);

        $license = license::where('whmcs_service_id', $data['whmserviceid'])->first();
        if(!$license){
            return $this->notFoundLicense();
        }

        if($license->status == 'Terminated'){
            return response()->json(["result" => "A terminated license cannot be changed"], 409);
        }

        try {
            $license->billingcycle = $data['billingcycle'];
            $license->max_domain   = $data['domainsAvailable'];
            $license->save();
        } catch (\Exception $e) {
            return $this->serverError('update plan of', $e);
        }
        return response()->json(["result" => "Plan updated"], 200);
    }    

    function deleteLicenseKey(Request $deleteKeyParams){        
        $license = $this->findLicense($deleteKeyParams);
        if(!$license){
            return $this->notFoundLicense();
        }

        try{
            $license->delete();
        } catch (\Exception $e){
            return $this->serverError('delete', $e);
        }

        return response()->json(["result" => "License key deleted"], 200);
    }

    function getLicenseByServiceId(Request $getKeyParams){       
        $license = $this->findLicense($getKeyParams);
        if (!$license){
            return $this->notFoundLicense();
        } 

        return response()->json([
            "result"  => "OK",
            "license" => [
                "license_key"   => $license->license_key,
                "status"        => $license->status,
                "billingcycle"  => $license->billingcycle,
                "max_domain"    => $license->max_domain,
                "expiry_date"   => $license->expiry_date,
            ],
        ], 200);
    }    
}

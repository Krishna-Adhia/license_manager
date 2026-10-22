<?php
    require_once __DIR__ . '/../../../../includes/scp-custom/http-rest.php';

    function createLicenseKey($apiKey, $licenseCreationArray){                        
        $url = "http://127.0.0.1:8000/api/createkey";        
        $headers = ["x-api-key:".trim($apiKey),"accept: application/json"];
        $body = [
            'whmserviceid' => $licenseCreationArray['serviceId'],
            'domainsAvailable' => $licenseCreationArray['domainsAvailable'],
            'billingcycle' => $licenseCreationArray['billingCycle'],
            'nextduedate' => $licenseCreationArray['nextDueDate']
        ];        
        $response = CallAPIv2("POST", $url, $headers, $body);                
        return $response;
    }

    function suspendLicenseKey($apiKey, $serviceId){
        $url = "http://127.0.0.1:8000/api/suspendkey";
        $headers = ["x-api-key:".trim($apiKey),"accept: application/json"];
        $body = [
            'whmserviceid' => $serviceId
        ];        
        $response = CallAPIv2("PUT", $url, $headers, $body);
        return $response;
    }

    function unsuspendLicenseKey($apiKey, $serviceId){
        $url = "http://127.0.0.1:8000/api/unsuspendkey";
        $headers = ["x-api-key:".trim($apiKey),"accept: application/json"];
        $body = [
            'whmserviceid' => $serviceId
        ];        
        $response = CallAPIv2("PUT", $url, $headers, $body);
        return $response;
    }

    function terminateLicenseKey($apiKey, $serviceId){
        $url = "http://127.0.0.1:8000/api/terminatekey";
        $headers = ["x-api-key:".trim($apiKey),"accept: application/json"];
        $body = [
            'whmserviceid' => $serviceId
        ];
        $response = CallAPIv2("PUT", $url, $headers, $body);
        return $response;
    }

    function changePlan($apiKey, $serviceId, $billingCycle, $domainsAvailable){
        $url = "http://127.0.0.1:8000/api/updateplan";
        $body = [
            'whmserviceid' => $serviceId,
            'billingcycle'     => $billingCycle,
            'domainsAvailable' => $domainsAvailable
        ];        
        $headers = ["x-api-key:".trim($apiKey),"accept: application/json"];
        $response = CallAPIv2("PUT", $url, $headers);
        return $response;
    }
?>
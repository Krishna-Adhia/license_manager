<?php
    function CallAPIv2($method, $url, $headers = [], $data = false)
    {
        $curl = curl_init();
        
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                break;
            case "PUT":
            case "DELETE":
            case "PATCH":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                break;
            default:
        }
        
        if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        
        array_push($headers,"content-type: application/json");
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        return ['status' => $http_status_code, 'body' => $result, 'error' => $curl_error];
    }
?>
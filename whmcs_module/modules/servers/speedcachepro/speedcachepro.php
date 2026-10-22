<?php
    require_once 'lib/api-functions.php';
    use Illuminate\Database\Capsule\Manager as Capsule;
	
	if (!defined("WHMCS")) {
	    die("This file cannot be accessed directly");
	}

    /**
	 * Define module related meta data.
	 *
	 * Values returned here are used to determine module related abilities and
	 * settings.
	 *
	 * @see http://docs.whmcs.com/Provisioning_Module_Meta_Data_Parameters
	 *
	 * @return array
	 */
	function speedcachepro_MetaData() {
	  return array(
	    'DisplayName'       => 'Speed Cache Pro',
	    'APIVersion'        => '1.0', // Use API Version 1.1	    
	  );
    }

    /**
	 * Define product configuration options.
	 *
	 * The values you return here define the configuration options that are
	 * presented to a user when configuring a product for use with the module. These
	 * values are then made available in all module function calls with the key name
	 * configoptionX - with X being the index number of the field from 1 to 24.
	 *
	 * You can specify up to 24 parameters, with field types:
	 * * text
	 * * password
	 * * yesno
	 * * dropdown
	 * * radio
	 * * textarea
	 *
	 * Examples of each and their possible configuration parameters are provided in
	 * this sample function.
	 *
	 * @return array
	 */

	function speedcachepro_ConfigOptions() {
	    return array(
	    // a text field type allows for single line text input	    
	    'SpeedCachePro API Key' => array(
	      'Type'        => 'text',
	      'Size'        => '100',
	      'Default'     => '',
	      'Description' => 'API Token for Speed Cache Pro',
	    ),
        'Available Domains' => array(
	      'Type'        => 'text',
	      'Size'        => '100',
	      'Default'     => '',
	      'Description' => 'How many domains are allowed with this plan',
	    ),	    
	    'Upgrade Product ID' => array(
	      'Type'        => 'text',
	      'Size'        => '100',
	      'Default'     => '',
	      'Description' => 'Auto upgrade product ID (If trial product)',
	    ),
	    'Upgrade Product List' => array(
	      'Type'        => 'text',
	      'Size'        => '100',
	      'Default'     => '',
	      'Description' => 'Comma Separated Product IDs',
	    ),
	    'Downgrade Product List' => array(
	      'Type'        => 'text',
	      'Size'        => '100',
	      'Default'     => '',
	      'Description' => 'Comma Separated Product IDs',
	    )	    
	  );	    
	}

    /**
	 * Provision a new instance of a product/service.
	 *
	 * Attempt to provision a new instance of a given product/service. This is
	 * called any time provisioning is requested inside of WHMCS. Depending upon the
	 * configuration, this can be any of:
	 * * When a new order is placed
	 * * When an invoice for a new order is paid
	 * * Upon manual request by an admin user
	 *
	 * @param array $params common module parameters
	 *
	 * @see http://docs.whmcs.com/Provisioning_Module_SDK_Parameters
	 *
	 * @return string "success" or an error message
	 */

	 function speedcachepro_CreateAccount(array $params) {
        try{                 
            $serviceId = $params["serviceid"];            
            $apiKey = $params['configoption1'];
            $domainsAvailable = $params['configoption2'];
            $billingCycle = strtolower($params['model']->billingcycle); 
            $nextDueDate = $params['model']->nextduedate;     
            $licenseCreationArray = [
                'serviceId' => $serviceId,
                'billingCycle' => $billingCycle,
                'domainsAvailable' => $domainsAvailable,
                'nextDueDate' => $nextDueDate
            ];
            $createResponse = createLicenseKey($apiKey,$licenseCreationArray);
            $decodedCreateResponse = json_decode($createResponse['body'], true);            

            //201 = license created
            if($createResponse['status'] == 201){
                $licenseKey = $decodedCreateResponse['license_key'];
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "$serviceId created successfully",
                    $createResponse
                );

                //insert the data into scpkeys
                $insertServiceData = Capsule::INSERT("INSERT INTO scpkeys (license_key, whmserviceid, domainsAvailable) VALUES (?, ?, ?)",[$licenseKey,$serviceId,$domainsAvailable]);                
            } else { 
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "Something went wrong while creating service: $serviceId (HTTP ".$createResponse['status'].")",
                    $createResponse
                );

                $postData = array(
                    'deptid' => '1', //Error Handling
                    'subject' => 'Speed Cache Pro API Failed - '.__FUNCTION__,
                    'message' => "Service ID: $serviceId\nHTTP status: ".$createResponse['status']."\nResponse: ".$createResponse['body']."\nCurl error: ".$createResponse['error'],
                    'name' => 'Automatic',
                    'email' => 'support@example.com'
                );
                $results = localAPI('OpenTicket', $postData);
            }                          

        } catch(Exception $e){
            logModuleCall(
                "speedcachepro",
                __FUNCTION__,
                "serviceId: $serviceId",
                $e->getMessage()                
            );

            return $e->getMessage();
        }  
        return "success";     
     }


     function speedcachepro_SuspendAccount(array $params) {
        try{
            $serviceId = $params["serviceid"];
            $apiKey = $params['configoption1'];
            $suspendResponse = suspendLicenseKey($apiKey, $serviceId);                        
            if($suspendResponse['status'] == 200){
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "$serviceId suspended successfully",
                    $suspendResponse                
                );
            } else {
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "Something went wrong while suspending: $serviceId",
                    $suspendResponse                
                );

                $postData = array(
                    'deptid' => '1', //Error Handling
                    'subject' => 'Speed Cache Pro API Failed - '.__FUNCTION__,
                    'message' => "Service ID: $serviceId\nHTTP status: ".$suspendResponse['status']."\nResponse: ".$suspendResponse['body']."\nCurl error: ".$suspendResponse['error'],
                    'name' => 'Automatic',
                    'email' => 'support@example.com'
                );
                $results = localAPI('OpenTicket', $postData);
            }                        

        } catch(Exception $e){
            logModuleCall(
                "speedcachepro",
                __FUNCTION__,
                "serviceId: $serviceId",
                $e->getMessage()
            );

            return $e->getMessage();
        }   
        return "success";     
     }

     function speedcachepro_UnsuspendAccount(array $params) {
        try{
            $serviceId = $params["serviceid"];
            $apiKey = $params['configoption1'];
            $unsuspendResponse = unsuspendLicenseKey($apiKey, $serviceId);            
            if($unsuspendResponse['status'] == 200){
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "$serviceId unsuspended successfully",
                    $unsuspendResponse                
                );
            } else {
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "Something went wrong while unsuspending: $serviceId",
                    $unsuspendResponse                
                );

                $postData = array(
                    'deptid' => '1', //Error Handling
                    'subject' => 'Speed Cache Pro API Failed - '.__FUNCTION__,
                    'message' => "Service ID: $serviceId\nHTTP status: ".$unsuspendResponse['status']."\nResponse: ".$unsuspendResponse['body']."\nCurl error: ".$unsuspendResponse['error'],
                    'name' => 'Automatic',
                    'email' => 'support@example.com'
                );
                $results = localAPI('OpenTicket', $postData);
            }                   

        } catch(Exception $e){
            logModuleCall(
                "speedcachepro",
                __FUNCTION__,
                "serviceId: $serviceId",
                $e->getMessage()
            );

            return $e->getMessage();
        }     
        return "success";        
     }

     function speedcachepro_TerminateAccount(array $params) {
        try{
            $serviceId = $params["serviceid"];
            $apiKey = $params['configoption1'];
            $terminateResponse = terminateLicenseKey($apiKey, $serviceId);            
            if($terminateResponse['status'] == 200){
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "$serviceId terminated successfully",
                    $terminateResponse                
                );
            } else{
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "something went wront while terminating $serviceId",
                    $terminateResponse                
                );

                $postData = array(
                    'deptid' => '1', //Error Handling
                    'subject' => 'Speed Cache Pro API Failed - '.__FUNCTION__,
                    'message' => "Service ID: $serviceId\nHTTP status: ".$terminateResponse['status']."\nResponse: ".$terminateResponse['body']."\nCurl error: ".$terminateResponse['error'],
                    'name' => 'Automatic',
                    'email' => 'support@example.com'
                );
                $results = localAPI('OpenTicket', $postData);
            }                        

        } catch(Exception $e){
            logModuleCall(
                "speedcachepro",
                __FUNCTION__,
                "serviceId: $serviceId",
                $e->getMessage()
            );

            return $e->getMessage();
        }  
        return "success";           
     }

    //  function speedcachepro_RenewAccount(array $params) {
    //     try{
    //         $serviceId = $params["serviceid"];
    //         $apiKey = $params['configoption1'];
    //         $renewResponse = renewLicenseKey($apiKey, $serviceId);
    //         $renewResponseDecoded = json_decode($renewResponse, true);
    //         if($renewResponseDecoded['result'] == "")
    //         logModuleCall(
    //             "speedcachepro",
    //             __FUNCTION__,
    //             "serviceId: $serviceId",
    //             $response                
    //         );

    //         return "success";

    //     } catch(Exception $e){
    //         logModuleCall(
    //             "speedcachepro",
    //             __FUNCTION__,
    //             "serviceId: $serviceId",
    //             $response                
    //         );

    //         return $e->getMessage();
    //     }
    //     return "success";
    //  }

     function speedcachepro_ChangePackage(array $params) {
        try{
            $serviceId = $params["serviceid"];
            $apiKey = $params['configoption1'];
            $billingCycle = strtolower($params['model']->billingcycle);
            $domainsAvailable = $params['configoption2'];
            $changePlanArray = [
                'serviceId' => $serviceId,
                'billingCycle' => $billingCycle,
                'domainsAvailable' => $domainsAvailable
            ];
            $changePlanResponse = changePlan($apiKey,$changePlanArray);            
            if($changePlanResponse['status'] == 200){
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "$serviceId plan changed successfully",
                    $changePlanResponse                
                );
            } else {
                logModuleCall(
                    "speedcachepro",
                    __FUNCTION__,
                    "Something went wront while changing plan of $serviceId",
                    $changePlanResponse                
                );

                $postData = array(
                    'deptid' => '1', //Error Handling
                    'subject' => 'Speed Cache Pro API Failed - '.__FUNCTION__,
                    'message' => "Service ID: $serviceId\nHTTP status: ".$changePlanResponse['status']."\nResponse: ".$changePlanResponse['body']."\nCurl error: ".$changePlanResponse['error'],
                    'name' => 'Automatic',
                    'email' => 'support@example.com'
                );
                $results = localAPI('OpenTicket', $postData);
            }
                        

        } catch(Exception $e){
            logModuleCall(
                "speedcachepro",
                __FUNCTION__,
                "serviceId: $serviceId",
                $e->getMessage()
            );
            return $e->getMessage();
        }        
        return "success";     
     }
?>
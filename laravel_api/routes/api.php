<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpeedCacheProLicense;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('verify.api.key')->group(function () {
    //Create license key
    Route::post('/createkey/{whmserviceid}/{packagetype}',[SpeedCacheProLicense::class,'createLicenseKey']);

    //Terminate license key
    Route::put('/terminatekey/{licenseKey}',[SpeedCacheProLicense::class,'terminateLicenseKey']);

    //Suspend license key
    Route::put('/suspendkey/{licenseKey}',[SpeedCacheProLicense::class,'suspendLicenseKey']);

    //Unsuspend license key
    Route::put('/unsuspendkey/{licenseKey}',[SpeedCacheProLicense::class,'unsuspendLicenseKey']);

    //Update plan
    Route::put('/updateplan/{licenseKey}/{package}',[SpeedCacheProLicense::class,'updatePlan']);

    //Delete plan
    Route::delete('/deleteplan/{licenseKey}',[SpeedCacheProLicense::class,'deleteLicenseKey']);

    //Get details of license key
    Route::get('/getlicensekey/{licenseKey}',[SpeedCacheProLicense::class,'getLicenseKey']);
});
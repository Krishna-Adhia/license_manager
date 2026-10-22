<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpeedCacheProLicense;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('verify.api.key')->group(function () {
    //Create license key
    Route::post('/createkey',[SpeedCacheProLicense::class,'createLicenseKey']);

    //Terminate license key
    Route::put('/terminatekey',[SpeedCacheProLicense::class,'terminateLicenseKey']);

    //Suspend license key
    Route::put('/suspendkey',[SpeedCacheProLicense::class,'suspendLicenseKey']);

    //Unsuspend license key
    Route::put('/unsuspendkey',[SpeedCacheProLicense::class,'unsuspendLicenseKey']);

    //Update plan
    Route::put('/updateplan',[SpeedCacheProLicense::class,'updatePlan']);

    //Delete plan
    Route::delete('/deletekey',[SpeedCacheProLicense::class,'deleteLicenseKey']);

    //Get details of license key
    Route::get('/getLicenseByServiceId',[SpeedCacheProLicense::class,'getLicenseByServiceId']);
});
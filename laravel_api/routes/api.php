<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpeedCacheProLicense;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Create license key
Route::POST('/createkey/{whmserviceid}/{packagetype}',[SpeedCacheProLicense::class,'createLicenseKey']);

//Terminate license key
Route::PUT('/terminatekey/{licenseKey}',[SpeedCacheProLicense::class,'terminateLicenseKey']);

//Suspend license key
Route::PUT('/suspendkey/{licenseKey}',[SpeedCacheProLicense::class,'suspendLicenseKey']);

//Unsuspend license key
Route::PUT('/unsuspendkey/{licenseKey}',[SpeedCacheProLicense::class,'unsuspendLicenseKey']);

//Update plan
Route::PUT('/updateplan/{licenseKey}',[SpeedCacheProLicense::class,'updatePlan']);

//Delete plan
Route::DELETE('/deleteplan/{licenseKey}',[SpeedCacheProLicense::class,'deleteLicenseKey']);

//Get details of license key
Route::GET('/getlicensekey/{licenseKey}',[SpeedCacheProLicense::class,'getLicenseKey']);t

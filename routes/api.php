<?php

use App\Http\Controllers\ApexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApexController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('createaccount', 'createaccount');
    Route::post('logout', 'logout');
});

Route::group(['middleware' => ['auth.apexrole:admin,user']], function () {
    Route::get("/viewallusers", [ApexController::class, "viewallusers"]);
    Route::get("/viewuser/{id}", [ApexController::class, "viewuser"]);
    Route::get("/updateuser/{id}", [ApexController::class, "updateuser"]);
});

Route::group(['middleware' => ['auth.apexrole:admin']], function () {
    Route::get("/deleteuser/{id}", [ApexController::class, "deleteuser"]);
});

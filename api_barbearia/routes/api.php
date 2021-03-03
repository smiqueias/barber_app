<?php

namespace App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'



], function ($router) {

    Route::get('/', function () {
        return response()->json(['API BARBERAPP' => 'CONECTADO']);
    });

    //User Routers
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);

    //Companies Routers
    Route::resource('companies', CompanyController::class)->except(['create','edit']);

    //Employees Routers
    Route::resource('employee', EmployeeController::class)->except(['create','edit']);

    //Schedules Routers
    Route::resource('schedule', ScheduleController::class)->except(['create','edit']);

    //Service Routers
    Route::resource('service', ServiceController::class)->except(['create','edit']);

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TradeOrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MarketTradeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\BankCardController;
use App\Http\Controllers\ExchangeHistoryController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });upda



    Route::middleware('auth:api')->group(function () {
    Route::get('/master/permissions', [PermissionController::class, 'index']);
    
    Route::get('/master/roles', [RoleController::class, 'index']);

    Route::get('/AccountInfo', [UserController::class, 'index']);
    Route::post('/user/update/{user}', [UserController::class, 'update']);
    Route::post('/user/update2/{user}', [UserController::class, 'update2']);
    Route::post('/adminprocess', [UserController::class, 'adminprocess']);
    Route::post('/BetDeduction', [UserController::class, 'BetDeduction']);

    Route::post('/Dashboard/store', [TradeOrderController::class, 'store']);
    Route::get('/TradeOrders', [TradeOrderController::class, 'index']);
    Route::get('/TradeOrders/{id}', [TradeOrderController::class, 'index2']);
    Route::put('/Dashboard/update', [TradeOrderController::class, 'update']);
    Route::get('/GetTID', [TradeOrderController::class, 'GetTID']);


    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/account/store', [AccountController::class, 'store']);
Route::get('/getMarketTables/{symbolDisplayName}', [MarketTradeController::class, 'getMarketTables']);    Route::post('/account/update/{account}', [AccountController::class, 'update']);

Route::get('/bankcards/{id}', [BankCardController::class, 'index']);
    Route::get('/basicinfo/{name}', [BankCardController::class, 'basicinfo']);
    Route::post('/bankcard/store', [BankCardController::class, 'store']);
    Route::post('/bankcard/update', [BankCardController::class, 'update']);
    Route::post('/bankcard/Delete', [BankCardController::class, 'Delete']);

    Route::get('/market', [MarketTradeController::class, 'index']);
    Route::post('/market/store', [MarketTradeController::class, 'store']);
    Route::put('/market/update', [MarketTradeController::class, 'update']);

    Route::post('/calculateCount', [TradeOrderController::class, 'calculateCount']);
    // Route::get('/companies/show', [CompanyController::class, 'show']);
    // Route::get('/companies', [CompanyController::class, 'index']);
    // Route::post('/companies/store', [CompanyController::class, 'store']);
    // Route::post('/companies/update', [CompanyController::class, 'update']);
    // Route::get('/companies/deleted', [CompanyController::class, 'deleted']);
    // Route::post('/companies/restore', [CompanyController::class, 'restore']);
    // Route::post('/companies/destroy', [CompanyController::class, 'destroy']);

    Route::get('/RechargeDetails', [DepositController::class, 'index']);
    Route::post('/RechargeDetails/store', [DepositController::class, 'store']);
    Route::post('/RechargeDetails/update', [DepositController::class, 'update']);
    Route::post('/CancelOrder/update', [DepositController::class, 'CancelOrderClient']);
    //adminside
    Route::post('/RechargeDetails/update2', [DepositController::class, 'update2']);
    Route::get('/RechargeDetailsAdmin', [DepositController::class, 'RechargeDetailsAdmin']);
    Route::post('/CancelOrderAdmin/update', [DepositController::class, 'CancelOrderAdmin']);
    Route::get('/GetHistory/{id}', [DepositController::class, 'GetHistory']);
    Route::get('/getMarketTables/{symbolDisplayName}', [MarketTradeController::class, 'getMarketTables']);

    Route::post('/withdrawAdd', [ExchangeHistoryController::class, 'withdrawAdd']);//kuku
    Route::get('/admin/{admin}/clients', [AgentClientController::class, 'index']);//kuku


});
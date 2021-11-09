<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->prefix('maintenance')->group(function () {
    Route::post("/units/save","UnitController@save");
    Route::get("/units/all","UnitController@all");
    Route::get("/units/get","UnitController@get");
    Route::delete("/units/delete","UnitController@delete");

    Route::post("/brands/save","BrandController@save");
    Route::get("/brands/all","BrandController@all");
    Route::get("/brands/get","BrandController@get");
    Route::delete("/brands/delete","BrandController@delete");

    Route::post("/suppliers/save","SupplierController@save");
    Route::get("/suppliers/all","SupplierController@all");
    Route::get("/suppliers/get","SupplierController@get");
    Route::delete("/suppliers/delete","SupplierController@delete");

    Route::post("/product_locations/save","ProductLocationController@save");
    Route::get("/product_locations/all","ProductLocationController@all");
    Route::get("/product_locations/get","ProductLocationController@get");
    Route::delete("/product_locations/delete","ProductLocationController@delete");

    Route::post("/price_categories/save","PriceCategoryController@save");
    Route::get("/price_categories/all","PriceCategoryController@all");
    Route::get("/price_categories/get","PriceCategoryController@get");
    Route::delete("/price_categories/delete","PriceCategoryController@delete");

    Route::post("/staffs/save","StaffController@save");
    Route::get("/staffs/all","StaffController@all");
    Route::get("/staffs/get","StaffController@get");
    Route::delete("/staffs/delete","StaffController@delete");

    Route::post("/staffs/save","StaffController@save");
    Route::get("/staffs/all","StaffController@all");
    Route::get("/staffs/get","StaffController@get");
    Route::delete("/staffs/delete","StaffController@delete");

    Route::get("/customers/all","CustomerController@all");
    Route::post("/customers/save","CustomerController@save");
    Route::get("/customers/get","CustomerController@get");
    Route::get("/customers/charged_transactions","CustomerController@charged");
    Route::get("/customers/manual_entries","CustomerController@manualEntries");
    Route::post("/customers/add_manual_entries","CustomerController@addManualEntries");
    Route::delete("/customers/delete_manual_entries","CustomerController@deleteManualEntries");
    Route::get("/customers/payments","CustomerController@payments");
    Route::get("/customers/logs","CustomerController@logs");

});
Route::middleware(['auth:api'])->prefix('products')->group(function () {
    Route::post("/save","ProductController@save");
    Route::get("/all","ProductController@all");
    Route::get("/search","ProductController@search");
    Route::get("/get","ProductController@get");
    Route::delete("/delete","ProductController@delete");

    Route::get("/fields","ProductController@fields");
    Route::post("/reset_inventory","ProductController@resetInventory");

});

Route::middleware(['auth:api'])->prefix('sales')->group(function () {
    Route::get("/ticket/get","TicketController@get");
    Route::post("/ticket/save","TicketController@save");
    Route::post("/ticket/add_details","TicketController@addDetails");
    Route::delete("/ticket/delete_details","TicketController@deleteDetails");

    Route::get("/settings","SaleController@settings");
    Route::post("/save","SaleController@save");
    Route::get("/all","SaleController@all");
    Route::get("/get","SaleController@get");
    Route::delete("/delete","SaleController@delete");
    Route::post("/return","SaleController@return");
});

Route::middleware(['auth:api'])->prefix('authorization')->group(function () {
    Route::post("/check","AuthorizationController@check");
});
Route::post('oauth/token', 'AuthController@auth');
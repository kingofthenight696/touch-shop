<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["namespace" => "FrontSide"], function () {
    Route::get("/", "IndexController@index");

    /*
     * Cart
     */
    Route::get("/cart", "CartController@index")->name('cart');
    Route::post("/changeCartItem", "CartController@changeCartItem")->name('changeCartItem');
    Route::post("/removeCartItem", "CartController@removeCartItem")->name('removeCartItem');
    Route::post("/removeCart", "CartController@removeCart")->name('removeCart');
});

Route::get("/login", "LoginController@index")->name('login');
Route::get("/register", "RegisterController@index")->name('register');


//Route::group(["namespace" => "AdminSide"], function () {
//    Route::get("admin/", "IndexController@index");
//});

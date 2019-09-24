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
        Route::get("/", "IndexController@index")->name('index');

        Route::get("cart", "CartController@index")->name('cart');
        Route::post("cart/add", "CartController@changeCartItem")->name('changeCartItem');
        Route::delete("cart/remove", "CartController@removeCart")->name('removeCart');
        Route::delete("cart/remove/{id}", "CartController@removeCartItem")->name('removeCartItem');
});

Route::get("/login", "LoginController@index")->name('login');
Route::get("/register", "RegisterController@index")->name('register');



Auth::routes();

Route::group(['middleware' => ['web'], "namespace" => "AdminSide"], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/product/add', 'ProductController@addProduct')->name('addProduct');
    Route::put('/product/edit/{$productId}', 'ProductController@addProduct')->name('editProduct');
    Route::delete('/product/{$productId}', 'ProductController@addProduct')->name('deleteProduct');
});
//Route::middleware('Authenticate')


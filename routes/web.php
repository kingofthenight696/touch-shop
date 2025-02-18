<?php

/*
|--------------------------------------------------------------------------
| Web Routes                    <a href="{{ url('/dashboard') }}">Home</a>
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post("cart/add", "FrontSide\CartController@changeCartItem")->name('changeCartItem');
Route::group(["namespace" => "FrontSide"], function () {
        Route::get("/", "IndexController@index")->name('index');

        Route::get("cart", "CartController@index")->name('cart');
        Route::delete("cart/remove", "CartController@removeCart")->name('removeCart');
        Route::post("cart/remove/{id}", "CartController@removeCartItem")->name('removeCartItem');
});

Route::get("/login", "LoginController@index")->name('login');
Route::get("/register", "RegisterController@index")->name('register');



Auth::routes();

Route::group(['middleware' => ['web'], "namespace" => "AdminSide"], function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/product/download', 'ProductController@download')->name('downloadProduct');
    Route::post('/product/upload', 'ProductController@upload')->name('uploadProduct');
    Route::post('/product/add', 'ProductController@addProduct')->name('addProduct');
    Route::post('/product/edit/{productId}', 'ProductController@editProduct')->name('editProduct');
    Route::post('/product/delete/{productId}', 'ProductController@deleteProduct')->name('deleteProduct');
    Route::get('/product/{productId}', 'ProductController@getProduct');

    Route::post('/board/upload', 'BoardController@uploadBoard')->name('uploadBoard');

});
//Route::middleware('Authenticate')


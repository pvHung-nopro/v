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




Route::namespace('Api')->middleware(['api'])->prefix('user')->group(function ($router) {

    // Route::post('verfication_code','AuthController@verfication_code');
    Route::post('register','AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::delete('logout','AuthController@logout');
    Route::get('me', 'AuthController@me');


    // Route::get('auth/{ocialite}', 'AuthController@redirectToGoogle')->name('login.ocialite');
    // Route::get('auth/{ocialite}/callback', 'AuthController@handleGoogleCallback')->name('login.ocialite.callback');

});



Route::namespace('Api\Frontend')->middleware(['api'])->prefix('frontend')->group(function ($router){
     Route::get('product/home/{page}','ProductController@home')->name('product.home');
     Route::get('product/{id}','ProductController@productId')->name('product.id');
     Route::get('product/sale/{limit}','ProductController@productSale')->name('productSale');

    //category

     Route::get('category/list/{limit}','CategoryController@categoryList')->name('category.list');
     Route::get('category/product/{id}/{page}','CategoryController@categoryProduct')->name('category.product');

     // sub_category
     Route::get('sub_category/{id}/{page}','SubCategoryController@subcategoryProduct')->name('subcategory.product');
    // brand
    Route::get('brand/{id}/{page}','BrandController@brandProduct')->name('brand.product');
    // search
    Route::get('search/product/{page}','ProductController@searchProduct')->name('search.product');
    //filter
    Route::get('filter/product/{page}','ProductController@filterProduct')->name('filter.product');
    //cart
    Route::get('cart/store/{id}','CartController@store')->name('cart.store');
    Route::get('cart/show','CartController@showCart')->name('cart.show');
    Route::post('cart/update/{id}','CartController@update')->name('cart.update');
    Route::delete('cart/deleted/{id}','CartController@deletedCart')->name('cart.deleted');
    Route::delete('carts/deleted/all','CartController@deltedCartall')->name('cart.deleted.all');
    //order
    Route::post('order/product','OrderController@order')->name('order.product')->middleware(['token.valid']);




});


Route::namespace('Api')->middleware(['api'])->group(function ($router) {
    //   Route::get('auth/{ocialite}', 'AuthController@redirectToGoogle')->name('login.ocialite');
    // Route::get('auth/{ocialite}/callback', 'AuthController@handleGoogleCallback')->name('login.ocialite.callback');


Route::get('auth/{ocialite}/url', 'OcialiteController@loginUrl');
Route::get('auth/{ocialite}/callback', 'OcialiteController@loginCallback');

//    Route::get('auth/{ocialite}', 'AuthController@redirectToGoogle')->name('login.ocialite');
//     Route::get('auth/{ocialite}/callback', 'AuthController@handleGoogleCallback')->name('login.ocialite.callback');


   });

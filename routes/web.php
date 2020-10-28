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

Route::get('/', function () {
    return view('welcome');
});
Route::get('index',[
    'as' => 'trang-chu',
    'uses' =>'PageController@getIndex'
]);
Route::get('loai-san-pham/{type}',[
    'as' => 'loaisanpham',
    'uses'=>'PageController@getLoaiSP'
]);
Route::get('chi-tiet-san-pham/{id}',[
    'as' => 'chitietsanpham',
    'uses'=>'PageController@getChiTiet'
]);
Route::get('lien-he',[
    'as' => 'lienhe',
    'uses'=>'PageController@getLienHe'
]);
//Route::get('ve-chung-toi',[
//    'as' => 'vechungtoi',
//    'uses'=>'PageController@getVeChungToi'
//]);
Route::get('ve-chung-toi','PageController@getVeChungToi')->name('vechungtoi');
Route::get('add-to-cart/{id}','PageController@getAddToCart')->name('themgiohang');
Route::get('delete/{id}','PageController@getDelItemCart')->name('xoagiohang');
Route::get('dat-hang','PageController@getCheckOut')->name('dathang');
Route::post('dat-hang','PageController@postCheckOut')->name('dathang');
Route::get('dang-nhap','PageController@getLogin')->name('login');
Route::post('dang-nhap','PageController@postLogin')->name('login');
Route::get('dang-ky','PageController@getSigin')->name('sigin');
Route::post('dang-ky','PageController@postSigin')->name('sigin');
Route::get('dang-xuat','PageController@postLogout')->name('logout');
Route::get('search','PageController@getSearch')->name('search');




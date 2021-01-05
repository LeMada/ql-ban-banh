<?php

use Illuminate\Support\Facades\Route;

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
Route::get('index', [
	'as'=>'trang-chu',
	'uses'=>'PageController@getIndex'
]);
Route::get('loai-san-pham/{type}',[
	'as'=>'loaisanpham',
	'uses'=>'PageController@getLoaiSp'
]);
Route::get('chi-tiet-san-pham/{id}', [
	'as'=> 'chitietsanpham',
	'uses'=>'PageController@getChitiet'
]);
Route::get('lien-he', [
	'as'=>'lienhe', 
	'uses'=>'PageController@getLienhe'
]);
Route::get('gioi-thieu', [
	'as'=>'gioithieu', 
	'uses'=>'PageController@getGioiThieu'
]);
Route::get('add-to-cart/{id}', [
	'as'=>'themgiohang',
	'uses'=>'PageController@getAddtoCart'
]);
Route::get('del-cart/{id}', [
	'as'=>'xoagiohang',
	'uses'=>'PageController@getDelItemCart'
]);
Route::get('dat-hang', [
	'as'=>'dathang',
	'uses'=>'PageController@getCheckout'
]);
Route::post('dat-hang', [
	'as'=>'dathang',
	'uses'=>'PageController@postCheckout'
]);
Route::get('dang-nhap', [
	'as'=>'login',
	'uses'=>'PageController@getLogin'
]);
Route::post('dang-nhap', [
	'as'=>'login',
	'uses'=>'PageController@postLogin'
]);
Route::get('dang-ky', [
	'as'=>'signin',
	'uses'=>'PageController@getSignin'
]);
Route::post('dang-ky', [
	'as'=>'signin',
	'uses'=>'PageController@postSignin'
]);
Route::get('dang-xuat', [
	'as'=>'logout',
	'uses'=>'PageController@getLogout'
]);
Route::get('search', [
	'as'=>'search',
	'uses'=>'PageController@getSearch'
]);

/*---------------trang admin -----------------------------*/
Route::get('trang-admin', [
	'as'=>'admin',
	'uses'=>'AdminController@trangAdmin'
]);
Route::get('dashboard', [
	'as'=>'dashboard',
	'uses'=>'AdminController@show_dashboard'
]);
Route::post('admin-dashboard', [
	'as'=>'admin-dashboard',
	'uses'=>'AdminController@dashboard'
]);
Route::get('add-category-product',[
	'as'=>'add-category-product',
	'uses'=>'CategoryProduct@add_category_product'
]);
Route::get('all-category-product',[
	'as'=>'all-category-product',
	'uses'=>'CategoryProduct@all_category_product'
]);
Route::post('save-category-product',[
	'as'=>'save-category-product',
	'uses'=>'CategoryProduct@save_category_product'
]);

/*Route::get('/admin','AdminController@trangAdmin');
Route::get('/dashboard','AdminController@show_dashboard');*/
Route::get('/logout','AdminController@logout');
/*Route::post('/admin-dashboard','AdminController@dashboard');*/
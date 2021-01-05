<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facedes\Redirect;
session_start();

class CategoryProduct extends Controller
{
    public function add_category_product(){
    	return view('admin.add_category_product');
    }
    public function all_category_product(){
    	return view('admin.all_category_product');
    }
    public function save_category_product(Request $request){
    	$data = array();
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_desc;
    	$data['category_status'] = $request->category_product_status;

    	DB::table('tbl_category_product')->insert($data);
    	Session::put('message','Thêm danh mục sản phẩm thành công');
    	return Redirect::to('add_category_product');
    }
}

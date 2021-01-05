<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facedes\Redirect;
session_start();

class AdminController extends Controller
{
    public function trangAdmin(){
    	return view('admin.admin_login');
    }
    public function show_dashboard(){
    	return view('admin.dashboard');
    }
    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password= md5($request->admin_password);
    	$result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    	if($result){
    		Session::put('admin_name', $result->admin_name);
    		Session::put('admin_id', $result->admin_id);
    		/*return Redirect::to('/dashboard');*/
    		return redirect()->route('dashboard');
    	}else{
    		Session::put('message','Mật khẩu hoặc tài khoản bị sai. Hãy nhập lại!');
    		/*return Redirect::to('/admin');*/
    		return redirect()->route('admin');
    	}
    }
    public function logout(){
    	Session::put('admin_name', null);
    	Session::put('admin_id', null);
    	return redirect()->route('admin');
    }

}

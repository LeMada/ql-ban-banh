<?php

namespace App\Http\Controllers;
use App\Slide;
use App\Product;
use App\ProductType;
use Illuminate\Http\Request;
use App\Cart;
use Session;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\user;
use Hash;
use Auth;
class PageController extends Controller
{
    public function getIndex(){
    	$slide = Slide::all();
    	$new_product = Product::where('new',1)->paginate(8);
    	$sanpham_khuyenmai = Product::where('promotion_price', '<>', 0)->paginate(8);
    	return view('page.trangchu', compact('slide', 'new_product', 'sanpham_khuyenmai'));
    }
    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id', $type)->first();
    	return view('page.loai_sanpham', compact('sp_theoloai', 'sp_khac', 'loai', 'loai_sp'));
    }
    public function getChitiet(Request $req){
        $sanpham = Product::where('id', $req->id)->first();
        $sp_tuongtu = Product::where('id_type', $sanpham->id_type)->paginate(6);
    	return view('page.chitiet_sanpham', compact('sanpham','sp_tuongtu'));
    }
    public function getLienhe(){
    	return view('page.lienhe');
    }
    public function getGioiThieu(){
        return view('page.gioithieu');
    }
    public function getAddtoCart(Request $req, $id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);

        return redirect()->back();
    }
    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items)>0)
        {
            Session::put('cart', $cart);
            echo $cart->totalPrice;
        }
        else
        {
            Session::forget('cart');
        }
        //return redirect()->back();
    }
    //thieu getCheckout
    /*public function postCheckout(){

    }*/
    public function getCheckout(){
        if(Session('cart')){
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            
            return view('page.dat_hang',['product_cart'=>$cart->items, 'totalPrice'=>$cart->totalPrice, 'totalQty'=>$cart->totalQty]); 
        }
        else{
            return view('page.dat_hang');
        }
    }
    public function postCheckout(Request $req){
        $cart = Session::get('cart');

        $customer = new Customer;
        $customer->name = $req->full_name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key; //$value['item']['id'];
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price= $value['price']/$value['qty'];
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công');
        
    }
    public function getLogin(){
        return view('page.dangnhap');
    }
    public function getSignin(){
        return view('page.dangky');
    }
    public function postSignin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 ký tự'
            ]);
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }
    public function postLogin(Request $req){
        $this->validate($req,[
            'email'=> 'required|email',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Email không đúng định dạng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max'=>'Mật khẩu không quá 20 ký tự'
        ]);
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }
    public function getLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }
    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')
                        ->orwhere('unit_price',$req->key)
                        ->orwhere('id', $req->key)
                        ->get();
        return view('page.search',compact('product'));
    }
}

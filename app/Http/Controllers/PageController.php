<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillDetail;
use App\Cart;
use App\Customer;
use App\Product;
use App\ProductType;
use App\Slide;
use App\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;
use Auth;

class PageController extends Controller
{
    public function getIndex()
    {
        $slide = Slide::all();
//        $new_product = Product::where('new',1)->get();
        $new_product = Product::where('new', 1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price', '<>', 0)->paginate(8);

//        return view('Page.trangchu',['slide'=>$slide]);
        return view('Page.trangchu', compact('slide', 'new_product', 'sanpham_khuyenmai'));
    }

    public function getLoaisp($type)
    {
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(4);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id', $type)->first();
        return view('Page.loai_sanpham', compact('sp_theoloai', 'sp_khac', 'loai', 'loai_sp'));
    }

    public function getChiTiet(Request $req)
    {
        $sanpham = Product::where('id', $req->id)->first();
        $sp_tuongtu = Product::where('id_type', $sanpham->id)->paginate(3);
        return view('Page.chitiet_sanpham', compact('sanpham', 'sp_tuongtu'));
    }

    public function getLienHe()
    {
        return view('Page.lienhe');
    }

    public function getVeChungToi()
    {
        return view('Page.ve-chung-toi');
    }

    public function getAddToCart(Request $req, $id)
    {
        $product = Product::find($id);

        $oldCart = Session('cart') ? Session::get('cart') : Null;

        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);

        return redirect()->back();
    }

    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : Null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();

    }

    public function getCheckOut()
    {
        return view('Page.checkout');
    }

    public function postCheckOut(Request $req)
    {

        $cart = Session::get('cart');
        $customer = new Customer();
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->adress;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill();
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $billdetail = new BillDetail();
            $billdetail->id_bill = $bill->id;
            $billdetail->id_product = $key;
            $billdetail->quantity = $value['qty'];
            $billdetail->unit_price = ($value['price']/$value['qty']);
            $billdetail->save();
        }

        Session::forget('cart');
        return redirect()->back()->with('Thongbao','Dat hang thanh cong');
    }
    public function getLogin(){
        return view('Page.dangnhap');
    }
    public function getSigin(){
        return view('Page.dangki');
    }
    public function postSigin(Request $req){
        $this->validate($req,[
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:20',
            're_password'=>'required|same:password',
            'fullname'=>'required',
        ],[
            'email.email'=> 'khong dung dang email',
            'email.required' => "Vui long nhap email",
            'email.unique'=>'Email da ton tai',
            're_password.same'=>'mat khau khong giong nhau',
            'password.required'=>'vui long nhap mat',
            're_password.required'=>'chua nhap lai mk',
        ]);
        $user = new User();

            $user->full_name = $req->fullname;
            $user->email =$req->email;
            $user->password= Hash::make($req->password);
            $user->phone = $req->phone;
            $user->address =$req->adress;
            $user->save();
            return redirect()->back()->with('Thanhcong','tao tai khoan thaanh cong');
    }
    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20',
            ],
            [
                'email.required'=>"vui long nhap email",
                'password.required'=>'Vui long nhap mat khau'
            ])  ;

        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            return redirect()->back()->with(['flag'=>'success','message'=>'thanh cong']);
        }else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'thanh that bai']);

        }
    }
    public function postLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }
    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')
        ->orWhere('unit_price',$req->key)->get();
        return view('Page.search',compact('product'));
    }
}

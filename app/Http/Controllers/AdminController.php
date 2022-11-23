<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\admin;
use Session;
use DB;
class AdminController extends Controller
{
    protected $admin;

    public function __construct(){
      $this->admin = new admin();
    }

    public function index(){
       return view('admin.login');
    }

    public function login(Request $request){
       // echo "<pre>"; print_r($request->all());
        $check = DB::table('admin')->where('username',$request->username)->where('password',$request->password)->first();

        if(!empty($check)){
            Session::put('id',$check->id);
            return redirect('deshboard');
        } else {
            return redirect()->back()->with('error',"Username & Password Not Match!");
        }
    }
    public function DeshBoard(){
        return view('admin/deshboard');
    }
}

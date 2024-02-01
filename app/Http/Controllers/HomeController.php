<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Meetuser;
use DB;
use Session;
session_start();
class HomeController extends Controller
{
    public function index()
    {
        $this->check_auth();
        return view('front.landing.index');
    }
    public function login(Request $request)
    {
        $Meetuser = new Meetuser();
        $email = $request->input('email');
        $password = md5($request->input('password'));
        $Meetuserinfo = Meetuser::where(['email' => $email, 'password' => $password])->first();
        
        if($Meetuserinfo){
            $data['msg'] = 'true';
            Session::put('user_id',$Meetuserinfo->id);
            //Redirect::to('/home')->send();
        }else{
             $data['msg'] = 'false';
         }
        return response()->json($data);
    }
    public function userlogin(Request $request)
    {
        $Meetuser = new Meetuser();
        $email = $request->input('email');
        $password = md5($request->input('password'));
        $Meetuserinfo = Meetuser::where(['email' => $email, 'password' => $password])->first();
        
        if($Meetuserinfo){
            $data['msg'] = 'true';
            Session::put('user_id',$Meetuserinfo->id);
            Redirect::to('/home')->send();
        }else{
            Session::flash('notification_type', 'success');
            Session::flash('notification_msg', 'Email or password not match.');
            Redirect::to('/')->send();
        }
    }
    public function register_user(Request $request)
    {
        $Meetuser = new Meetuser();
        $check_email = Meetuser::where('email',  $request->input('email'))->count();

        if($check_email > 0)
        {
           $data['msg'] = 'false';
           return response()->json($data);
        }else{   
            $Meetuser->name = $request->name;
            $Meetuser->email = $request->email;
            $Meetuser->username = strstr("$request->email",'@',true);
            $Meetuser->password = md5($request->password);
            $Meetuser->gender = $request->gender;
            $Meetuser->user_photo = '';
            $Meetuser->save();
            $data['msg'] = 'true';
            return response()->json($data);
        }

        
    }
    public function get_user($id)
    {
        $Meetuser = Meetuser::findOrFail($id);
        return response()->json($Meetuser);
    }

    private function check_auth() {
        $Meetuser_id = Session::get('user_id');
        if($Meetuser_id != NULL){
            Session::flash('notification_type', 'success');
            Session::flash('notification_msg', 'you are already logged in!');
            Redirect::to('/home')->send();
       }
    }
    
}

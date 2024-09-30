<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;
use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    //
    public function loginForm(Request $request){
        $data = [
            'pageTitle'=> 'Login'
        ];
        return view('back.pages.auth.login',$data);
    }

    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id,FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($fieldType === 'email'){
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5|max:45',
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'Email is not exists in system',

                'password.required'=>'Password is required',
            ]);
        }else{
            $request->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5|max:45',
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.exists'=>'Username is not exists in system',

                'password.required'=>'Password is required',
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if(Auth::attempt($creds)){
            if(auth()->user()->status === UserStatus::Inactive){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->withInput()->with('fail','Your account is currently inactive. Please contact at (support@smyth.test) for further assistance.');
            }

            if( auth()->user()->status === UserStatus::Pending){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->withInput()->with('fail','Your account is currently pending approval. Please check your email for further intructions or contact at (support@smyth.test) assistance.');
            }
            
            return redirect()->route('admin.dashboard');

        }else{
            //session()->flash('fail','Incorrect credentials');
            return redirect()->route('admin.login')->withInput()->with('fail','Incorrect credentials');
        }
    }   

    public function forgotForm(Request $request){
        $data = [
            'pageTitle'=> 'Forgot Password'
        ];
        return view('back.pages.auth.forgot',$data);
    }

    public function sendPasswordResetLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The email is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The email does not exist in the system',
        ]);

        //get User details
        $user = User::where('email',$request->email)->first();
        //Generate token
        $token = base64_encode(Str::random(64));

        //Check old Token

        $oldToken = DB::table('password_reset_tokens')
                    ->where('email',$user->email)
                    ->first();

        if ($oldToken) {
            DB::table('password_reset_tokens')
                    ->where('email',$user->email)
                    ->update([
                        'token'         => $token,
                        'created_at'    => Carbon::now(),
                    ]);
        } else {
            DB::table('password_reset_tokens')
                    ->insert([
                        'email'         => $user->email,
                        'token'         => $token,
                        'created_at'    => Carbon::now(),
                    ]);
                    
        }

        $actionLink = route('admin.reset_password_form',['token' => $token]);

        $data = [
            'actionLink'    => $actionLink,
            'user'          => $user
        ];

        $mail_body = view('email-templates.forgot-template',$data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset password',
            'body' => $mail_body,
        );


        
        if (CMail::send($mailConfig)) {
            return redirect()->route('admin.forgot')->with('success','We have e-mailed your password reset link.');
        } else {
            return redirect()->route('admin.forgot')->with('fail','Something went wrong. Resetting password link not sent. Please try again later.');
        }
        
    }

}

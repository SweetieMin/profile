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

        $cred = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if(Auth::attempt($cred)){
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
                return redirect()->route('admin.login')->withInput()->with('fail','Your account is currently pending approval. Please check your email for further instructions or contact at (support@smyth.test) assistance.');
            }
            return redirect()->route('admin.dashboard');
            
            

        }else{
            //session()->flash('fail','Incorrect credentials');
            return redirect()->route('admin.login')->withInput()->with('fail','Incorrect credentials');
        }
    }
    
    public function showAddEmailForm(){
        $data = [
            'pageTitle'=> 'Add email'
        ];
        return view('back.pages.auth.add-email',$data);
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

    public function resetForm(Request $request, $token = null){
        $isTokenExists = DB::table('password_reset_tokens')
                        ->where('token',$token)
                        ->first();
        if (!$isTokenExists) {
            return redirect()->route('admin.forgot')->with('fail','Invalid token. Please reset another reset password link.');
        } else {

            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $isTokenExists->created_at)->diffInMinutes(Carbon::now());

            if($diffMins > 15){
                return redirect()->route('admin.forgot')->with('fail','The link has expired. Please request new link.');
            }

            $data = [
                'pageTitle'    => 'Reset password',
                'token'        => $token,
            ];

            return view('back.pages.auth.reset',$data);
        }
        
    }

    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password'  => 'required|min:5|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        $dbToken = DB::table('password_reset_tokens')
                    ->where('token',$request->token)
                    ->first();
        //get User detail
        $user = User::where('email',$dbToken->email)->first();
        //Update password
        User::where('email',$dbToken->email)->update([
            'password'  =>  Hash::make($request->new_password),
        ]);


        //Send email 
        $data = array(
            'user'  => $user,
            'new_password'  => $request->new_password,
        );

        $mail_body = view('email-templates.password-changes-template',$data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Password changed',
            'body' => $mail_body,
        );
        
        if (CMail::send($mailConfig)) {
            DB::table('password_reset_tokens')->where([
                'email' => $dbToken->email,
                'token' => $dbToken->token
            ])->delete();
            return redirect()->route('admin.login')->with('success','Done! Your password has been changed successfully. Please use your new password for login into system.');
        } else {
            return redirect()->route('admin.reset_password_form',['token'=>$dbToken->token])->with('fail','Something went wrong. Please try again later.');
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SawaStacks\Utils\Library\Kropify;


class AdminController extends Controller
{
    //
    public function adminDashboard(Request $request){
        $data = [
            'pageTitle'=> 'Dashboard'
        ];
        return view('back.pages.dashboard',$data);
    }

    public function logoutHandler(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->withInput()->with('success','You are logout successfully!');
    }

    public function profileView(Request $request){
        $data = [
            'pageTitle' => 'Profile',
        ];
        return view('back.pages.profile',$data);
    }

    public function updateProfilePicture(Request $request){
        $user = User::findOrFail(auth()->id());
        $path = 'images/users/';
        $file = $request->file('profilePictureFile');
        $oldPicture = $user->getAttributes()['picture'];
        $filename = 'IMG_'.uniqid().'.png';

        $upload = Kropify::getFile($file,$filename)->maxWoH(255)->save($path);

        if ($upload) {
            //delete picture old
            if($oldPicture != null && File::exists(public_path($path.$oldPicture))){
                File::delete(public_path($path.$oldPicture));
            }
            //update new picture

            $user->update(['picture'=>$filename]);

            return response()->json(['status'=>1,'message'=>'Your profile picture has been updated successfully.']);

        } else {
            return response()->json(['status'=>0,'message'=>'Something went wrong. Please try again.']);
        }
        
    }

    public function generalSettings(Request $request){
        $data = [
            'pageTitle' => 'General settings',
        ];
        return view('back.pages.general-settings',$data);
    }

    public function updateLogo(Request $request){
        $settings = GeneralSetting::take(1)->first();
        if ( !is_null($settings) ) {
            $path = 'images/site/';
            $old_logo = $settings->site_logo;
            $file = $request->file('site_logo');
            $filename = 'LOGO_'.uniqid().'.png';

            if ($request->hasFile('site_logo')) {
                $upload = $file->move(public_path($path),$filename);

                if ($upload) {
                    if ($old_logo != null && File::exists(public_path($path.$old_logo))) {
                        File::delete(public_path($path.$old_logo));
                    }
                    $settings->update(['site_logo' => $filename]);

                    return response()->json(['status'=>1, 'image_path' => $path.$filename ,'message'=>'Site logo has been updated successfully.']);
                } else {
                    return response()->json(['status'=>0,'message'=>'Something went wrong. Please try later.']);
                }
                

            }
            
        } else {
            return response()->json(['status'=>0,'message'=>'Make sure you updated general settings form first.']);
        }
        
    }
}

<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helpers\CMail;
use App\Models\UserSocialLink;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'=>['keep'=>true]];

    public $name, $email, $username, $bio;

    public $current_password, $new_password, $new_password_confirmation;

    public $facebook_url, $instagram_url, $youtube_url, $github_url;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        $user = User::with('social_links')->findOrFail(auth()->id());

        //show Personal detail
        $this->name  = $user->name ;
        $this->username  = $user->username ;
        $this->email  = $user->email ;
        $this->bio  = $user->bio ;

        //show social link
        if(!is_null($user->social_links)){
            $this->facebook_url = $user->social_links->facebook_url;
            $this->instagram_url = $user->social_links->instagram_url;
            $this->youtube_url = $user->social_links->youtube_url;
            $this->github_url = $user->social_links->github_url;
        }
        

    }

    protected $listeners = [
        'updateProfile' => '$refresh'
    ];

    public function updatePersonalDetails(){
        $user = User::findOrFail(auth()->id());

        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
        ]);

        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $update = $user->save();

        sleep(0.5);

        if ($update) {
            $this->dispatch('showToastr',['type'=>'success','message'=>'Your personal details have been updated successfully.']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        } else {
            $this->dispatch('showToastr',['type'=>'fail','message'=>'Something went wrong! Please try later.']);
        }
        
    }

    public function updatePassword(){
        $user = User::findOrFail(auth()->id());

        $this->validate([
            'current_password' => [
                'required',
                'min:5',
                function($attribute,$value,$fail) use ($user){
                    if(Hash::check($value,$user->password)){
                        return $fail(__('Your current password does not match in system.'));
                    }
                }
            ],
            'new_password' => 'required|min:5|confirmed'
        ]);

        //update password

        $update = $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        if ($update) {
            $data = array(
                'user' => $user,
                'new_password' => $this->new_password
            );

            $mail_body = view('email-templates.password-changes-template',$data)->render();

            $mail_config = array(
                'recipient_address' => $user->email,
                'recipient_name' => $user->name,
                'subject' => 'Password changed',
                'body' => $mail_body
            );

            CMail::send($mail_config);

            //Logout and back to login

            auth()->logout();

            Session::flash('info','Your password has been successfully changed. Please login with new password.');
            $this->redirectRoute('admin.login');
        } else {
            $this->dispatch('showToastr',['type'=>'fail','message'=>'Something went wrong! Please try later.']);
        }
        
    }

    public function updateSocialLinks(){
        $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        $user = User::findOrFail(auth()->id());

        $data = array(
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url' => $this->youtube_url,
            'github_url' => $this->github_url
        );

        if(!is_null($user->social_links)){
            //update
            $query = $user->social_links()->update($data);
        }else{
            $data['user_id'] = $user->id;
            $query = UserSocialLink::insert($data);
        }

        if ($query) {
            # code...
            $this->dispatch('showToastr',['type'=>'success','message'=>'Your social links have been updated successfully.']);
        } else {
            # code...
            $this->dispatch('showToastr',['type'=>'fail','message'=>'Something went wrong! Please try later.']);
        }
        
    }

    public function render(){
        return view('livewire.admin.profile',[
            'user' => User::findOrFail(auth()->id())
        ]);
    }
}

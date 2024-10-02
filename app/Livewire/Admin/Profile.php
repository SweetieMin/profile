<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helpers\CMail;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'=>['keep'=>true]];

    public $name, $email, $username, $bio;

    public $current_password, $new_password, $new_password_confirmation;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        $user = User::findOrFail(auth()->id());

        $this->name  = $user->name ;
        $this->username  = $user->username ;
        $this->bio  = $user->bio ;

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

    public function render(){
        return view('livewire.admin.profile',[
            'user' => User::findOrFail(auth()->id())
        ]);
    }
}

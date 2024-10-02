<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'=>['keep'=>true]];

    public $name, $email, $username, $bio;

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

    public function render()
    {
        return view('livewire.admin.profile',[
            'user' => User::findOrFail(auth()->id())
        ]);
    }
}

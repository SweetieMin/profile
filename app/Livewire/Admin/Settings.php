<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\GeneralSetting;
use Livewire\Attributes\Validate;

use function PHPUnit\Framework\isNull;

class Settings extends Component
{   

    public $tab = null;
    public $tabname = 'general_settings';
    protected $queryString = ['tab'=>['keep'=>true]];

    public $site_title, $site_email,$site_phone,$site_meta_keywords,$site_meta_description,$site_logo,$site_favicon;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        //show site general

        $settings = GeneralSetting::take(1)->first();

        if( !is_null($settings)){
            $this->site_title = $settings->site_title;
            $this->site_email = $settings->site_email;
            $this->site_phone = $settings->site_phone;
            $this->site_meta_keywords = $settings->site_meta_keywords;
            $this->site_meta_description = $settings->site_meta_description;
        }
    }

    public function updateSiteInfo(){
        $this->validate([
            'site_title' => 'required',
            'site_email' => 'required|email'
        ]);

        $settings = GeneralSetting::take(1)->first();

        $data = array(
            'site_title' => $this->site_title,
            'site_email' => $this->site_email,
            'site_phone' => $this->site_phone,
            'site_meta_keywords' => $this->site_meta_keywords,
            'site_meta_description' => $this->site_meta_description,
        );

        if (!is_null($settings)) {
            $query = $settings->update($data);
        } else {
            $query = GeneralSetting::insert($data);
        }

        if ($query) {
            # code...
            $this->dispatch('showToastr',['type'=>'success','message'=>'General settings have been updated successfully.']);
        } else {
            # code...
            $this->dispatch('showToastr',['type'=>'fail','message'=>'Something went wrong! Please try later.']);
        }
        
    }

    public function render()
    {   
        return view('livewire.admin.settings');
    }
}

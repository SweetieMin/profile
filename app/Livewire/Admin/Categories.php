<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;

    public $pCategory_id, $pCategory_name;

    public function addParentCategory(){
        $this->pCategory_id = null;
        $this->pCategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModalForm();
    }

    public function createParentCategory(){
        $this->validate([
            'pCategory_name' => 'required|unique:parent_categories,name'
        ],[
            'pCategory_name.required' => 'Parent category field is required.',
            'pCategory_name.unique' => 'Parent category name is already exists.'
        ]);

        /** Store new parent category */

        $pCategory = new ParentCategory();
        $pCategory->name = $this->pCategory_name;
        $saved = $pCategory->save();

        if ($saved) {
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'New parent category has been created successfully.']);
        } else {
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
        
    }

    public function editParentCategory($id){
        $pCategory = ParentCategory::findOrFail($id);
        $this->pCategory_id = $pCategory->id;
        $this->pCategory_name = $pCategory->name;
        $this->isUpdateParentCategoryMode = true;
        $this->showParentCategoryModalForm();
    }

    public function updateParentCategory(){
        $pCategory = ParentCategory::findOrFail($this->pCategory_id);   

        $this->validate([
            'pCategory_name' => 'required|unique:parent_categories,name,'.$pCategory->id
        ],[
            'pCategory_name.required' => 'Parent category field is required.',
            'pCategory_name.unique' => 'Parent category name is already exists.'
        ]);

        /** Store new parent category */
        $pCategory->name = $this->pCategory_name;
        $pCategory->slug = null;
        $update = $pCategory->save();

        if ($update) {
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Update parent category has been created successfully.']);
        } else {
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }

    }

    public function showParentCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm(){
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pCategory_id = $this->pCategory_name = null;

    }

    public function render()
    {
        return view('livewire.admin.categories',[
            'pCategories' => ParentCategory::orderBy('ordering','asc')->get()
        ]);
    }
}

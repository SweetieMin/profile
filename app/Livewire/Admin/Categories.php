<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;

    public $pCategory_id, $pCategory_name;

    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteCategoryAction'
    ];

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

    public function updateParentCategoryOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id',$index)->update([
                'ordering'=>$new_position
            ]);
            $this->dispatch('showToastr',['type'=>'success','message'=>'Parent categories ordering have been updated successfully.']);
        }
    }

    public function updateCategoryOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$new_position
            ]);
            $this->dispatch('showToastr',['type'=>'success','message'=>'Categories ordering have been updated successfully.']);
        }
    }

    public function deleteParentCategory($id){
        $this->dispatch('deleteParentCategory',['id'=>$id]);
    }

    public function deleteCategoryAction($id){
        $pCategory = ParentCategory::findOrFail($id);
        //check if this parent category as children

        //delete parent category
        $delete = $pCategory->delete();

        if ($delete) {
            $this->dispatch('showToastr',['type'=>'success','message'=>'Parent category has been delete successfully.']);
        } else {
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
        
    }

    public function addCategory(){
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->isUpdateCategoryMode = false;
        $this->showCategoryModalForm();
    }

    public function createCategory(){
        $this->validate([
            'category_name' => 'required|unique:categories,name,'
        ],[
            'category_name.required' => 'Category field is required.',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        //Store category


        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $save = $category->save();

        if ($save) {
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Category has been created successfully.']);
        } else {
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
        
    }

    public function editCategory($id){
        $category = Category::query()->findOrFail($id);
        $this->category_id = $category->id;
        $this->parent = $category->parent;
        $this->category_name = $category->name;
        $this->isUpdateCategoryMode = true;
        $this->showCategoryModalForm();
    }

    public function updateCategory(){
        $category = Category::query()->findOrFail($this->category_id);
        $this->validate([
            'category_name' => 'required|unique:categories,name,'.$category->id
        ],[
            'category_name.required' => 'Category field is required.',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        $category->name = $this->category_name;
        $category->parent = $this->parent;
        $category->slug = null;

        $update = $category->save();

        if ($update) {
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Update category has been created successfully.']);
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

    public function showCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm(){
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function render()
    {
        return view('livewire.admin.categories',[
            'pCategories' => ParentCategory::orderBy('ordering','asc')->get(),
            'Categories' => Category::orderBy('ordering','asc')->get()
        ]);
    }
}

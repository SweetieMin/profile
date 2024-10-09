<div>
    
    <div class="row">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <div class="h4 text-blue">
                            Parent categories
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:;" wire:click="addParentCategory()" class="btn btn-primary btn-sm">Add P. categories</a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Name</th>
                            <th>N. of categories</th>
                            <th>Actions</th>
                        </thead>
                        <tbody id="sortable_parent_categories">

                            @forelse ($pCategories as $item)

                            <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>-</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="javascript:;" wire:click="editParentCategory({{$item->id}})" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="deleteParentCategory({{$item->id}})" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-danger">No item found!</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <div class="h4 text-blue">
                            Categories
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="" class="btn btn-primary btn-sm">Add categories</a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Name</th>
                            <th>Parent categories</th>
                            <th>Name of posts</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Name</td>
                                <td>Parent</td>
                                <td>4</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div wire:ignore.self class="modal fade" id="pcategory_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit="{{ $isUpdateParentCategoryMode ? 'updateParentCategory()' : 'createParentCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateParentCategoryMode ? 'Update P. Category' : 'Add P. Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateParentCategoryMode)
                        <input type="hidden" wire:model="pCategory_id">
                    @endif
                    <div class="form-group">
                        <label for="pCategory_name"><b>Parent category name</b></label>
                        <input type="text" class="form-control" id="pCategory_name" wire:model="pCategory_name" placeholder="Enter parent category name here.....">
                        @error('pCategory_name')
                            <span class="text-danger ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateParentCategoryMode ? 'Save changes' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

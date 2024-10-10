@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page pageTitle')
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Categories</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Categories
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @livewire('admin.categories')

@endsection
@push('scripts')

<script>
    window.addEventListener('showParentCategoryModalForm', function(){
        $('#pcategory_modal').modal('show');
    });
    window.addEventListener('hideParentCategoryModalForm', function(){
        $('#pcategory_modal').modal('hide');
    });

    window.addEventListener('showCategoryModalForm', function(){
        $('#category_modal').modal('show');
    });
    window.addEventListener('hideCategoryModalForm', function(){
        $('#category_modal').modal('hide');
    });

    $('table tbody#sortable_parent_categories').sortable({
        cursor:"move",
        update: function(event, ui){
            $(this).children().each(function(index){
                if($(this).attr('data-ordering') != (index + 1)){
                    $(this).attr('data-ordering', (index + 1)).addClass('updated');
                }
            });
            var positions = [];
            $('.updated').each(function(){
                positions.push([$(this).attr('data-index'),$(this).attr('data-ordering')]);
                $(this).removeClass('updated');
            });
            Livewire.dispatch('updateCategoryOrdering',[positions]);
        }
    });

    window.addEventListener('deleteParentCategory',function(event){
        var id = event.detail[0].id;
        $().konfirma({
            title:'Are you sure?',
            html:'You want to delete this parent category.',
            cancelButtonText:'Cancel',
            confirmButtonText:'Yes, delete',
            cancelButtonColor:'#d33',
            confirmButtonColor:'#3085d6',
            width:320,
            allowOutsideClick:false,    
            fontSide:'0.87rem',
            done: function(){
                Livewire.dispatch('deleteCategoryAction',[id]);
            }
        });
    });
</script>
    
@endpush
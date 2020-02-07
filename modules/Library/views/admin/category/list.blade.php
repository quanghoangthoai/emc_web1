@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-tree7 mr-2"></i> <span class="font-weight-semibold">Thư viện</span> - Danh mục</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <div class="row">
        <div class="col-xl-4">
            @include('Library::admin.category.component_add')
        </div>
        <div class="col-xl-8">
            @include('Library::admin.category.component_list')
        </div>
    </div>
</div>

@endsection
@section('custom_js')
{{-- <script>
    $(document).ready(function () {
        CKEDITOR.replace('content', {
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })

    });

</script> --}}

@endsection
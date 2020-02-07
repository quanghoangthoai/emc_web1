@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-comments mr-2"></i> <span class="font-weight-semibold">Mẫu phản hồi</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <div class="row">
        <div class="col-xl-7">
            @include('Recruitment::admin.email_template.component_add')
        </div>
        <div class="col-xl-5">
            @include('Recruitment::admin.email_template.component_list')
        </div>
    </div>
</div>
@endsection

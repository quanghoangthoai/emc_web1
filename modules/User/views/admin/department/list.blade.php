@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-tree7 mr-2"></i> <span class="font-weight-semibold">Quản lý phòng ban</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <div class="row">
        <div class="col-xl-4">
            @include('User::admin.department.component_add')
        </div>
        <div class="col-xl-8">
            @include('User::admin.department.component_list')
        </div>
    </div>
</div>
@endsection

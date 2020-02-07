@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-image mr-2"></i> <span class="font-weight-semibold">Quản lý file</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div style="height: 600px;">
    <div id="fm"></div>
</div>
@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection

@section('custom_js')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection

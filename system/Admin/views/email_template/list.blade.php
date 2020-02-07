@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-envelope mr-2"></i> <span class="font-weight-semibold">Mẫu email</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<!-- Form inputs -->
<div class="card-body">
    @if ($list_email_templates && count($list_email_templates) > 0)
    <div class="alert alert-info alert-styled-left">
        Cập nhật nội dung mẫu email của hệ thống.
    </div>

    <div class="card-group-control card-group-control-right">
        @foreach ($list_email_templates as $mod => $email_tpl)
        @php
        $mod_info = module_info($mod);
        @endphp
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    <a data-toggle="collapse" class="text-default" href="#collapsible-mod-{{ $mod }}"><i class="{{ $mod_info['icon'] }} mr-2"></i><strong>{{ $mod_info['title'] }}</strong></a>
                </h6>
            </div>

            <div id="collapsible-mod-{{ $mod }}" class="collapse show">
                <div class="card-body">
                    <div class="list-group list-group-bordered">
                        @foreach ($email_tpl as $iEmail)
                        <a href="{{ route('cms.admin.edit_email_template', $iEmail['id']) }}" class="list-group-item">
                            <strong>{{ $iEmail['title'] }}</strong>
                            <small class="ml-3 text-muted">{{ $iEmail['description'] }}</small>
                            <i class="fa fa-edit ml-auto"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info alert-styled-left">
        Không có mẫu email hệ thống.
    </div>
    @endif
</div>
@endsection

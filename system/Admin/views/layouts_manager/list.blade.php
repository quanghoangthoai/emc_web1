@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-desktop mr-2"></i> <span class="font-weight-semibold">Thiết lập layout</span></h4>
        {{-- <i href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></i> --}}
    </div>
</div>
@endsection
@section('page_content')
<!-- Form inputs -->
<div class="card-body">
    <div class="alert alert-info alert-styled-left">
        Thay đổi layout các trang hiển thị ngoài website
    </div>
    <div class="row card-group-control card-group-control-right">
        @foreach ($list_view_layout as $mod => $arr_layout)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        <a data-toggle="collapse" class="text-default" href="#collapsible-mod-{{ $mod }}"><i class="{{ module_info($mod)['icon'] }} mr-2"></i><strong>{{ module_info($mod)['title'] }}</strong></a>
                    </h6>
                </div>

                <div id="collapsible-mod-{{ $mod }}" class="collapse show">
                    <div class="card-body">
                        <ul class="list-group list-group-bordered">
                            @foreach ($arr_layout as $iLayout)
                            <li class="list-group-item">
                                <div class="col-form-label">{{ $iLayout['title'] }}</div>
                                <div class="ml-auto" style="width:45%">
                                    <select data-id="{{ $iLayout['id'] }}" onchange="change_layout_view(this);" class="form-control">
                                        @foreach (web_layouts() as $item)
                                        <option value="{{ $item }}" {{ $iLayout['layout'] == $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('custom_js')
<script>
    function loading_cards()
    {
        var cards = $('.content .card').toArray();
        cards.forEach((e, i) => {
            loading(e);
        });
    }

    function unblock_cards()
    {
        var cards = $('.content .card').toArray();
        cards.forEach((e, i) => {
            $(e).unblock();
        });
    }

    var inProcess = false;
    function change_layout_view(el)
    {
        if(!inProcess) {
            loading_cards();
            $.ajax({
                type: 'post',
                url: "{{ route('cms.admin.ajax_layout') }}",
                data: {
                    _token: _token,
                    id: $(el).data('id'),
                    layout: $(el).val()
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status) {
                        app.showNotify(res.message, "success");
                    } else {
                        app.showNotify(res.message, "error");
                    }
                    setTimeout(()=>{
                        unblock_cards();
                    }, 200);
                }
            });
        }
    }
</script>
@endsection

@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-th-list mr-2"></i> <span class="font-weight-semibold">Widget</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="javascript:;" onclick="load_widget_to_group();" class="btn-sm btn btn-warning"><i class="fa fa-sync mr-1" style="font-size:13px"></i> Tải lại</a>
        </div>
    </div>
</div>
@endsection
@section('custom_css')
<style>
    .add-widget>a {
        display: block;
        color: #ddd;
        padding: 10px;
        background: #f9f9f9;
        border: 1px dashed #dcdcdc;
        border-radius: 5px;
        text-align: center;
        transition: 0.3s;
    }

    .add-widget>a:hover {
        color: #fff;
        background: rgba(96, 125, 139, 0.61);
        border-color: rgba(96, 125, 139, 0.61);
        border-style: solid;
        transition: 0.3s;
    }

    #listWidget {
        overflow: auto;
        max-height: 75vh;
        padding: 5px;
    }

    #listWidget>li {
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    #listWidget>li>p,
    #listWidget>li>h6 {
        margin: 0
    }

    #listWidget>li:hover {
        background: #fafafa;
    }

    #listWidget>li.active {
        background: #455a64;
        color: #fff;
        border-color: #455a64;
        transition: 0.45s
    }

    #listWidget>li.active .text-muted {
        color: #fafafa !important;
        transition: 0.45s
    }

    /* width */
    #listWidget::-webkit-scrollbar {
        width: 5px;
        border-radius: 2px;
    }

    /* Track */
    #listWidget::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }

    /* Handle */
    #listWidget::-webkit-scrollbar-thumb {
        background: #9c9c9c;
        border-radius: 2px;
    }

    /* Handle on hover */
    #listWidget::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection
@section('page_content')
@if ($listGroup && count($listGroup) > 0)
<div class="card-body">
    <div class="row card-group-control card-group-control-right" id="accordion-control-right">
        @foreach ($listGroup as $k => $group)
        <div class="col-12 col-md-4 col-sm-6">
            <div class="card border-top-3 border-top-slate">
                <div class="card-header">
                    <h5 class="card-title">
                        <a data-toggle="collapse" class="text-default" href="#collapsible-{{ $group['name'] }}">
                            <strong>{{ $group['title'] }}</strong>
                            <small class="text-muted d-block">{!! $group['description'] !!}</small>
                        </a>
                    </h5>
                </div>

                <div id="collapsible-{{ $group['name'] }}" class="collapse show">
                    <div class="card-body" style="border-top: 1px solid rgba(0,0,0,.125);padding: 1.25rem;padding-bottom: 0;">
                        <div class="add-widget"><a onclick="openAddWidget('{{ $group['name'] }}', '{{ $group['title'] }}');" href="javascript:;" data-popup="tooltip" title="Thêm widget"><i class="fa fa-plus fa-2x"></i></a></div>
                    </div>
                    <div class="card-body border-top-0 collapsible-target" data-group="{{ $group['name'] }}">
                        <div class="text-muted text-center">
                            <em>Đang tải...</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div id="modalAddWidget" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height:90vh;">
            <div class="modal-header">
                <h5 class="modal-title"><small>Thêm widget:</small> <strong id="groupWidget" style="text-transform:uppercase"></strong></h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Hủy <strong>(ESC)</strong></button>
            </div>
            <div class="modal-body">
                @if ($listActiveWidget && count($listActiveWidget) > 0)
                <div class="row" style="height:100%">
                    <div class="col-md-4" style="border-right:1px solid #ddd;height:100%">
                        <ul id="listWidget" class="media-list">
                            @foreach ($listActiveWidget as $iActiveW)
                            <li onclick="selectWidget(this);" class="media-item" data-module="{{ $iActiveW['module'] }}" data-widget="{{ $iActiveW['name'] }}">
                                <h6><strong>{{ $iActiveW['title'] }}</strong></h6>
                                <p class="text-muted"><small>Tên widget:</small> <strong>{{ $iActiveW['name'] }}</strong></p>
                                <p class="text-muted"><small>Module:</small> <strong>{{ $iActiveW['module_title'] }}</strong></p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-8" style="height:100%" id="contentAddWidget">
                        <div class="text-center text-muted" style="position: absolute;top: 30%;left: 50%;transform: translate(-50%, -50%);opacity: 0.75;">
                            <i class="fas fa-th-list fa-4x mb-1"></i>
                            <p><em>Chọn widget để thêm</em></p>
                        </div>
                    </div>
                </div>
                @else
                <div class="row" style="height:100%">
                    <div class="col-12" style="height:100%">
                        <div class="text-center text-muted" style="position: absolute;top: 30%;left: 50%;transform: translate(-50%, -50%);opacity: 0.75;">
                            <i class="fab fa-linode fa-4x mb-1"></i>
                            <p><em>Không có widget khả dụng</em></p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    var add_to_group = '';

    function loading_cards()
    {
        var cards = $('.card.border-top-3.border-top-slate').toArray();
        cards.forEach((e, i) => {
            loading(e);
        });
    }

    function unblock_cards()
    {
        var cards = $('.card.border-top-3.border-top-slate').toArray();
        cards.forEach((e, i) => {
            $(e).unblock();
        });
    }

    function submitUpdateWidget(form)
    {
        loading($(form));
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxSubmitUpdateWidget') }}",
            data: $(form).serialize(),
            dataType: 'JSON',
            success: function(res) {
                $(form).unblock();
                if (res.status) {
                    app.showNotify(res.message, "success");
                    load_widget_to_group();
                } else {
                    app.showNotify(res.message, "error");
                }
            }
        });
    }

    function submitDeleteWidget(id)
    {
        if(confirm('Bạn có chắc chắn muốn xóa WIDGET này?')) {
            $.ajax({
                type: 'post',
                url: "{{ route('cms.admin.ajaxSubmitDeleteWidget') }}",
                data: {
                    _token: _token,
                    id: id
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status) {
                        app.showNotify(res.message, "success");
                        load_widget_to_group();
                    } else {
                        app.showNotify(res.message, "error");
                    }
                }
            });
        }
    }

    function load_widget_to_group()
    {
        loading_cards();
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxLoadWidgetToGroup') }}",
            data: {
                _token: _token
            },
            dataType: 'JSON',
            success: function(res) {
                if (res.status) {
                    $('.card-body.border-top-0.collapsible-target').toArray().forEach((e, i) => {
                        $(e).html('');
                    });
                    for (group in res.html) {
                        $('#collapsible-' + group + ' .card-body.border-top-0.collapsible-target').html(res.html[group]);
                    }
                } else {
                    $('.card-body.border-top-0.collapsible-target').toArray().forEach((e, i) => {
                        $(e).html('<div class="text-danger text-center"><em>Đã xảy ra lỗi</em></div>');
                    });
                    app.showNotify(res.message, "error");
                }
                setTimeout(() => {
                    unblock_cards();
                }, 200)
            }
        });
    }

    function submitAddWidget(el)
    {
        loading($(el));
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxSubmitAddWidget') }}",
            data: $('#frmAddWidget').serialize(),
            dataType: 'JSON',
            success: function(res) {
                $(el).unblock();
                if (res.status) {
                    $('#modalAddWidget').modal('hide');
                    app.showNotify(res.message, "success");
                    load_widget_to_group();
                } else {
                    app.showNotify(res.message, "error");
                }
            }
        });
    }

    function openAddWidget(group_name, group_title = '')
    {
        add_to_group = group_name;
        $('#groupWidget').text(group_title != '' ? group_title : group_name);
        $('#listWidget>li.active').removeClass('active');
        $('#contentAddWidget').html('<div class="text-center text-muted" style="position: absolute;top: 30%;left: 50%;transform: translate(-50%, -50%);opacity: 0.75;"><i class="fas fa-th-list fa-4x mb-1"></i><p><em>Chọn widget để thêm</em></p></div>');
        $('#modalAddWidget').modal({
            backdrop: 'static'
        }).modal('show');
    }

    function selectWidget(el)
    {
        if(!$(el).hasClass('active')) {
            loading('#modalAddWidget .modal-content');
            $('#listWidget>li.active').removeClass('active');
            $(el).addClass('active');
            $.ajax({
                type: 'post',
                url: "{{ route('cms.admin.ajaxLoadAddWidget') }}",
                data: {
                    _token: _token,
                    module: $(el).data('module'),
                    widget: $(el).data('widget'),
                    group: add_to_group
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status) {
                        $('#contentAddWidget').html(res.html);
                    } else {
                        $('#listWidget>li.active').removeClass('active');
                        $('#contentAddWidget').html('<div class="text-center text-muted" style="position: absolute;top: 30%;left: 50%;transform: translate(-50%, -50%);opacity: 0.75;"><i class="fas fa-th-list fa-4x mb-1"></i><p><em>Chọn widget để thêm</em></p></div>');
                        app.showNotify(res.message, "error");
                    }
                    setTimeout(() => {
                        $('#modalAddWidget .modal-content').unblock();
                    }, 200);
                }
            });
        }
    }

    function init_drag_drop()
    {
        var containers = $('.collapsible-target').toArray();
        // Init dragula
        dragula(containers, {
            mirrorContainer: document.querySelector('.collapsible-target')
        }).on('drop', function (el, target, source) {
            var widget_id = $(el).data('id'),
            from_group = $(source).data('group'),
            to_group = $(target).data('group'),
            arr_source = [], arr_target = [];

            // target
            $(target).children().each((i,e) => {
                arr_target.push($(e).data('id'));
            });
            $(source).children().each((i,e) => {
                if($(e).data('id') != widget_id) arr_source.push($(e).data('id'));
            });

            var cards = $('.card.border-top-3.border-top-slate').toArray();
            cards.forEach((e, i) => {
                loading(e);
            });

            $.ajax({
                type: 'post',
                url: "{{ route('cms.admin.ajaxUpdatePositionWidget') }}",
                data: {
                    _token: _token,
                    widget_id: widget_id,
                    from_group: from_group,
                    to_group: to_group,
                    arr_source: arr_source.unique(),
                    arr_target: arr_target.unique()
                },
                dataType: 'JSON',
                success: function(res) {
                    if (res.status) {
                        app.showNotify(res.message, "success");
                    } else {
                        app.showNotify(res.message, "error");
                    }
                    setTimeout(()=>{
                        cards.forEach((e, i) => {
                            $(e).unblock();
                        });
                    }, 200);
                }
            });
        });
    }
    $(document).ready(() => {
        $('body').addClass('sidebar-xs');
        load_widget_to_group();
        init_drag_drop();

    });

</script>
@endsection

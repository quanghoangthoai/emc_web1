@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="far fa-newspaper mr-2"></i> <span class="font-weight-semibold">Bài viết</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_post.admin.add_post')}}" class="btn btn-primary btn-sm">Thêm bài viết</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
@if (isset($listPost) && count($listPost) > 0)
<div class="table-responsive">
    <table class="table table-td-middle" id="post-list-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Tiêu đề</th>
                <th class="text-center">Danh mục</th>
                <th class="text-center">Đăng bởi</th>
                <th class="text-center"><i class="fa fa-eye"></i></th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Đăng lúc</th>
                <th style="width:100px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPost as $post)
            <tr>
                <td class="text-center">{{ $post['id'] }}</td>
                <td>
                    <a href="#"><strong>{{ $post['title'] }}</strong></a>
                </td>
                <td class="text-center">
                    <a href="#"><strong>{{ $post->category['title'] }}</strong></a>
                </td>
                <td class="text-center">{{ user_display_name($post['created_by']) }}</td>
                <td class="text-center">{{ $post['totalhits'] }}</td>
                <td class="text-center">
                    <span style="display:none;">{{ $post['status'] }}</span>
                    <div class="form-check form-check-switchery form-check-switchery-sm">
                        <label class="form-check-label">
                            <input data-id="{{ $post['id'] }}" type="checkbox" class="form-input-switchery" {{ $post['status'] ? 'checked' : '' }}>
                        </label>
                    </div>
                </td>
                <td class="text-center"><span data-popup="tooltip" title="{{ $post['created_at'] }}">{{ cms_time_elapsed_string($post['created_at']) }}</span></td>
                <td class="text-center">
                    <a href="{{ route('mod_post.admin.edit_post', $post['id']) }}" class="text-warning mr-2" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_post.admin.delete_post', $post['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card-body">
    <div class="alert alert-info">
        Chưa có dữ liệu
    </div>
</div>
@endif
@endsection
@section('custom_js')
<script src="{{asset('assets/admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready( function () {

        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                sInfo:"Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                search: '<span>Tìm kiếm:</span> _INPUT_',
                searchPlaceholder: 'Nhập tìm kiếm...',
                lengthMenu: '<span>Hiển thị:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
        $('#post-list-table').DataTable({
            order: [[0, "desc" ]],
            columnDefs: [
                {targets: [7], searchable: false, orderable: false, visible: true }
            ],
        });

        var switches = Array.prototype.slice.call(document.querySelectorAll('.form-input-switchery'));
        switches.forEach(function (html) {
            var switchery = new Switchery(html, {
                secondaryColor: '#d8201c'
            });
        });
        var inProcess = false;
        $(document).find('.form-input-switchery').each(function (i, html) {
            $(html).on('click', function(e){
                if (!inProcess) {
                    if (typeof $(this).attr('checked') !== typeof undefined) {
                        // 1 => 0
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('mod_post.ajax.changeStatusPost') }}",
                            data: {
                                _token: _token,
                                id: $(this).data('id'),
                                status: 0
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).removeAttr('checked');
                                    app.showNotify(res.msg, 'success');
                                } else {
                                    app.showNotify(res.msg, 'error');
                                    setTimeout(function(){
                                        var newEl = new Switchery(html, {
                                            secondaryColor: '#d8201c'
                                        });
                                        setSwitchery(newEl, true);
                                    }, 200);
                                }
                            }
                        });
                    }
                    if (typeof $(this).attr('checked') === typeof undefined) {
                        // 0 => 1
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('mod_post.ajax.changeStatusPost') }}",
                            data: {
                                _token: _token,
                                id: $(this).data('id'),
                                status: 1
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).attr('checked', 'checked');
                                    app.showNotify(res.msg, 'success');
                                } else {
                                    app.showNotify(res.msg, 'error');
                                    setTimeout(function(){
                                        var newEl = new Switchery(html, {
                                            secondaryColor: '#d8201c'
                                        });
                                        setSwitchery(newEl, false);
                                    }, 200);
                                }
                            }
                        });
                    }
                } else {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection

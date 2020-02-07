@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">SẢN PHẨM</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_product.admin.add_product')}}" class="btn btn-primary btn-sm">Thêm sản phẩm</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
@if (count($listPost) > 0)
<div class="table-responsive">
    <table class="table datatable-basic">
        <thead class="bg-light">
            <tr>
                <th class="text-center">Hình ảnh</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Danh mục</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Đăng lúc</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPost as $post)
            <tr>
                <td class="text-center">
                    @if (isset($post['image']))
                    <img src="{{ $post['image'] }}" alt="{{ $post['name'] }}" style="max-width:80px;max-height:100px">
                    @else
                    <em>Không có</em>
                    @endif
                </td>
                <td class="text-center">{{ $post['name'] }}</td>
                <td class="text-center">{{ $post->category['name'] }}</td>
                <td class="text-center">
                    @if ($post['enable_sale'])
                    <strong>{{ number_format($post['sale_price']) }}</strong>đ{{ $post['unit_type'] ? '/' . $post['unit_type'] : '' }}
                    <br>
                    <del><small>{{ number_format($post['price']) }}đ</small></del>
                    @else
                    <strong>{{ number_format($post['price']) }}</strong>đ{{ $post['unit_type'] ? '/' . $post['unit_type'] : '' }}
                    @endif
                </td>
                <td class="text-center">
                    <div class="form-check form-check-switchery form-check-switchery-sm">
                        <label class="form-check-label">
                            <input data-id="{{ $post['id'] }}" type="checkbox" class="form-input-switchery" {{ $post['status'] ? 'checked' : '' }}>
                        </label>
                    </div>
                </td>
                <td class="text-center"><span data-popup="tooltip" title="{{ $post['created_at'] }}">{{ cms_time_elapsed_string($post['created_at']) }}</span></td>
                <td class="text-center">
                    <a href="{{ route('mod_product.admin.edit_product', $post['id']) }}" class="text-warning mr-2" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_product.admin.delete_product', $post['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
<script src="{{ asset('assets/admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script>
    function setSwitchery(switchElement, checkedBool) {
        if((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
            switchElement.setPosition(true);
            switchElement.handleOnchange(true);
        }
    }
    $(document).ready(function(){
        $('.uniform-checker').click(function (e) {
            if ($(this).find('input[type="checkbox"]').hasClass('all')) {
                $('input[type="checkbox"].form-check-input-styled:not(.all)').prop('checked', !$(this).find('span').first().hasClass('checked'));
            } else {
                if ($(this).find('span').first().hasClass('checked'))
                    $('.selectAll .uniform-checker .form-check-input-styled').prop('checked', false);
                else {
                    if ($('.uniform-checker span:not(.checked)').length == $('.uniform-checker').length - 1)
                        $('.selectAll .uniform-checker .form-check-input-styled').prop('checked', true);
                }
            }
            $.uniform.update();
        });
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

        $('.datatable-basic').DataTable({
            order: [[1, "asc" ]],
            columnDefs: [
                {targets: [0,4,5,6], searchable: false, orderable: false, visible: true }
            ]
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
                            url: "{{ route('mod_product.ajax.changeStatus') }}",
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
                            url: "{{ route('mod_product.ajax.changeStatus') }}",
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
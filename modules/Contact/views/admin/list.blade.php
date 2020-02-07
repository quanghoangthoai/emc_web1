@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-envelope mr-2"></i> <span class="font-weight-semibold">Liên hệ</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection

@section('page_content')
<div class="content p-2">
    @if (count($listContact) > 0)
    <form class="delete" action="{{ route('mod_contact.admin.bulkaction') }}" method="post">
        {{ csrf_field() }}
        <div class="table-responsive">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th class="text-center selectAll" style="width:50px;">
                            <input type="checkbox" class="form-check-input-styled all">
                        </th>
                        <th>Tên người gửi</th>
                        <th>Tiêu đề</th>
                        <th class="text-center">Dịch vụ</th>
                        <th class="text-center">Nhân viên xử lý</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Tạo lúc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listContact as $contact)
                    <tr>
                        <td class="text-center"><input name="ids[]" type="checkbox" class="form-check-input-styled" value="{{ $contact['id'] }}"></td>
                        <td onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');">{{ $contact['sender_name'] ? $contact['sender_name'] : '-' }}</td>
                        <td onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');">{{ $contact['title'] ? $contact['title'] : '-' }}</td>
                        <td class="text-center" onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');">{{ $contact['service'] ? $contact['service'] : '-' }}</td>
                        <td class="text-center" onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');">
                            {{ $contact['reply_by'] ? user_display_name($contact['reply_by']) : '-' }}
                        </td>
                        <td class="text-center" onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');">{!! mod_contact_get_html_status($contact['status']) !!}</td>
                        <td onclick="viewcontact('{{ route('mod_contact.admin.viewcontact', $contact['id']) }}');" class="text-center"><span data-popup="tooltip" title="{{ $contact['created_at'] }}">{{ cms_time_elapsed_string($contact['created_at']) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-secondary mr-1 btn-sm" name="delMulti" value="1"><i class="fa fa-trash"></i> Xóa chọn</button>
            <button class="btn btn-danger btn-sm" name="delAll" value="1"><i class="fa fa-trash"></i> Xóa tất cả</button>
        </div>
    </form>
    @else
    <div class="alert alert-info">
        Chưa có liên hệ nào gửi đến.
    </div>
    @endif
</div>
@endsection
@section('custom_css')
<style>
    tbody>tr>td {
        cursor: pointer;
    }
</style>
@endsection
@section('custom_js')

<script>
    $('document').ready(function () {
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
    });
</script>
<script>
    function viewcontact(link)
        {
            window.location.href = link;
        }
</script>
<script>
    $(".delete").on("submit", function(){
        return confirm("Dữ liệu không thể khôi phục. Bạn có thật sự muốn xóa?");
    });
</script>

<script src="{{ asset('assets/admin/js/plugins/tables/datatables/datatables.min.js') }}"></script>
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
        $('.datatable-basic').DataTable({
            order: [[1, "desc" ]],
            columnDefs: [
                {targets: [0], searchable: false, orderable: false, visible: true }
            ]
        });
    });
</script>

@endsection
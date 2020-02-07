@extends('Admin::layouts.default')
@section('custom_css')
<style>
    #button-search-document {
        width: 70%;
        float: right;
    }
</style>
@endsection
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-tree7 mr-2"></i> <span class="font-weight-semibold">Thư viện</span> - Danh sách tài liệu
        </h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <a href="{{ route('mod_library.admin.get_add_document') }}" class="btn btn-success">THÊM TÀI LIỆU</a>
</div>
@endsection
@section('page_content')
<div class="card-body">



    <form method="GET">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <input type="text" placeholder="Nhập tên tài liệu" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select class="form-control" name="documentType" id="">
                        <option value="" disabled selected>Chọn loại tài liệu</option>
                        @if(mod_library_list_document_type())
                        @foreach(mod_library_list_document_type() as $key => $value)
                        <option value={{ $key }} {{old('documentType') === $key ? 'selected' : ''}}>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select class="form-control" name="categoryId" id="">
                        <option value="" disabled selected>Chọn danh mục</option>
                        @if(mod_library_list_category())
                        @foreach(mod_library_list_category() as $iCat)
                        <option value="{{$iCat['id']}}" {{old('categoryId') == $iCat['id'] ? 'selected' : ''}}>{{$iCat['prefix']}} {{$iCat['name']}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <input value="" type="date" class="form-control" name="startDate" id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <input value="" type="date" class="form-control" name="endDate" id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary" id="button-search-document">Tìm kiếm</button>
            </div>
        </div>
    </form>
    @if ($listDoc && count($listDoc) > 0)
    <table id="tree-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Tên tài liệu</th>
                <th class="text-center">Loại tài liệu</th>
                <th class="text-center">Danh mục tài liệu</th>
                <th class="text-center">Thời gian tải lên</th>
                <th class="text-center">Lượt xem</th>
                <th class="text-center">Lượt tải</th>
                <th class="text-center" style="width:100px"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($listDoc as $iDoc)
            <tr>
                <td class="text-center">{{ $iDoc['id'] }}</td>
                <td class="text-center"><a href="{{route('mod_library.admin.get_detail_document', $iDoc['id'])}}">{{ $iDoc['name'] }}</a></td>
                <td class="text-center">{{ mod_library_get_document_type($iDoc['document_type']) }}</td>
                <td class="text-center">{{ $iDoc->category['name'] }}</td>
                <td class="text-center"><span data-popup="tooltip" title="{{ $iDoc['created_at'] }}">{{ $iDoc['created_at'] }}</span></td>
                <td class="text-center">{{ $iDoc['view_count'] }}</td>
                <td class="text-center">{{ $iDoc['download_count'] }}</td>
                <td class="text-center">
                    <a href="{{ route('mod_library.admin.get_edit_document',$iDoc['id']) }}" class="text-warning mr-1" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_library.admin.get_delete_document',$iDoc['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    </form>

    {{-- </div> --}}
    @else
    <div class="alert alert-info">Không có tài liệu nào.</div>
    @endif
</div>
@endsection

@section('custom_js')

<script>
    $('document').ready(function () {
        $('.uniform-checker').click(function (e) {
            if ($(this).find('input[type="checkbox"]').hasClass('all')) {
                $('input[type="checkbox"].form-check-input-styled:not(.all)').prop('checked', !$(this)
                    .find('span').first().hasClass('checked'));
            } else {
                if ($(this).find('span').first().hasClass('checked'))
                    $('.selectAll .uniform-checker .form-check-input-styled').prop('checked', false);
                else {
                    if ($('.uniform-checker span:not(.checked)').length == $('.uniform-checker')
                        .length - 1)
                        $('.selectAll .uniform-checker .form-check-input-styled').prop('checked', true);
                }
            }
            $.uniform.update();
        });
    });

</script>
<script src="{{asset('assets/admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function () {

        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                sInfo: "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                search: '<span>Tìm kiếm:</span> _INPUT_',
                searchPlaceholder: 'Nhập tìm kiếm...',
                lengthMenu: '<span>Hiển thị:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });
        $('#tree-table').DataTable({
            order: [
                [4, "desc"]
            ],
            columnDefs: [{
                targets: [],
                searchable: false,
                orderable: false,
                visible: true
            }]
        });
    });

</script>

@endsection
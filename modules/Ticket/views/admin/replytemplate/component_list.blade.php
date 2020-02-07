<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline">
        <h5 class="card-title">DANH SÁCH MẪU PHẢN HỒI</h5>
    </div>
    @if (isset($listReplyTemplate) && count($listReplyTemplate))
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th>Tên mẫu phản hồi</th>
                    <th class="text-center" style="width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listReplyTemplate as $cat)
                <tr>
                    <td>{{ $cat['prefix'] }} <strong style="color: #2196f3">{{ $cat['name'] }}</strong></td>
                    <td class="text-center">
                        <a href="{{ route('mod_ticket.admin.edit_replytemplate', $cat['id']) }}" class="text-warning mr-1" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_ticket.admin.delete_replytemplate', $cat['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="col-12 mt-2">
        <div class="alert alert-info">Chưa có dữ liệu</div>
    </div>
    @endif
</div>
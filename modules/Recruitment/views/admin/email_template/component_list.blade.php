<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title"><i class="fas fa-comments mr-1"></i> <strong>DANH SÁCH MẪU PHẢN HỒI</strong></h6>
    </div>
    @if ($listMail && count($listMail) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th>Tên mẫu phản hồi</th>
                    <th class="text-center" style="width:100px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listMail as $iMail)
                <tr>
                    <td>
                        {{ $iMail['name'] }}
                    </td>
                    <td class="text-center">
                        <a href="{{route('mod_recruitment.admin.edit_email_template', $iMail['id'])}}" class="text-warning mr-1" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{route('mod_recruitment.admin.delete_email_template', $iMail['id'])}}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @else
    <div class="card-body pb-0">
        <div class="alert alert-info">Chưa có mẫu phản hồi nào.</div>
    </div>
    @endif
</div>

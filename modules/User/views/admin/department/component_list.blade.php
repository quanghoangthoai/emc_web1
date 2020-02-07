<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">DANH SÁCH PHÒNG BAN </h5>
    </div>
    @if (isset($listDepartment) && count($listDepartment) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-td-middle">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width:75px">#</th>
                    <th class="text-center" style="width:40%">Tên</th>
                    <th class="text-center">Mô tả</th>
                    <th style="width:120px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listDepartment as $department)
                <tr>
                    <td class="text-center">{{ $department['id'] }}</td>
                    <td>
                        <a href="#"><strong>{{ $department['name'] }}</strong></a>
                    </td>
                    <td>{{ $department['description'] }}</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <a href="{{ route('mod_user.admin.edit_department', $department['id']) }}" class="list-icons-item text-primary-600" data-popup="tooltip" title="Sửa"><i class="icon-pencil7"></i></a>
                            <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_user.admin.delete_department', $department['id']) }}" data-popup="tooltip" title="Xóa" class=" list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-3">
        <div class="alert alert-info">
            Chưa có dữ liệu
        </div>
    </div>
    @endif
</div>

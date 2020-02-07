<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline">
        <h5 class="card-title">DANH SÁCH MODULE BÌNH LUẬN</h5>
    </div>
    @if (isset($listModule) && count($listModule))
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th>Tên danh mục</th>
                    <th class="text-center" style="width:150px">Trạng thái</th>
                    <th class="text-center" style="width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listModule as $mod)
                <tr>
                    <td>{{ $mod['prefix'] }} <a href="#"><strong>{{ $mod['name'] }}</strong></a></td>
                    <td class="text-center">
                        <div class="form-check form-check-switchery form-check-switchery-sm">
                            <label class="form-check-label">
                                <input data-id="{{ $mod['id'] }}" type="checkbox" class="form-input-switchery" {{ $mod['status'] ? 'checked' : '' }}>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_comment.admin.deltete_module', $mod['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline">
        <h5 class="card-title">DANH SÁCH DANH MỤC</h5>
    </div>
    @if (isset($listCategory) && count($listCategory))
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th>Tên danh mục</th>
                    <th class="text-center" style="width:100px">Thứ tự</th>
                    <th class="text-center" style="width:150px">Trạng thái</th>
                    <th class="text-center" style="width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listCategory as $cat)
                <tr>
                    <td>{{ $cat['prefix'] }} <a href="#"><strong>{{ $cat['name'] }}</strong></a></td>
                    <td class="text-center">
                        <input type="number" data-id="{{ $cat['id'] }}" value="{{ $cat['order'] }}" class="form-control changOrder" onchange="change_order(this);">
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-switchery form-check-switchery-sm">
                            <label class="form-check-label">
                                <input data-id="{{ $cat['id'] }}" type="checkbox" class="form-input-switchery" {{ $cat['status'] ? 'checked' : '' }}>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('mod_product.admin.edit_category', $cat['id']) }}" class="text-warning mr-1" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_product.admin.delete_category', $cat['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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

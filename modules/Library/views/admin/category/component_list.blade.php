<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline">
        <h5 class="card-title">{{ isset($parentCat['title']) ? '"' . $parentCat['title'] . '"' : 'DANH MỤC' }}</h5>
        <div class="mod_library">
            @if (isset($parentCat))
            <a href="{{ route('mod_library.admin.get_list_category') }}?parent_id={{ $parentCat['parent_id'] }}" class="btn btn-default">&larr; Quay lại</a>
            @endif
        </div>

    </div>

    @if (count($listCat) > 0)
    <div class="table-responsive table-striped">
        <table id="tree-table" class="table table-bordered table-td-middle">
            <thead>
                <tr>

                    <th class="text-center" style="width: 220px">Tên danh mục</th>
                    <th class="text-center">Mô tả</th>
                    <th class="text-center" style="width: 130px">Định dạng</th>
                    <th class="text-center" style="width: 130px">Trạng thái</th>
                    <th class="text-center" style="width: 85px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listCat as $cat)

                <tr>
                    <td class="text-left" ">
                        @if ($cat)
                        
                        {{ $cat['prefix'] }} <a class=" category-parrent-title" style="color: #2196f3;font-weight: bold;font-size: 13px;" href="{{ route('mod_library.admin.get_edit_category', $cat['id']) }}">{{ $cat['name'] }}</a>
                        @endif
                    </td>
                    <td class="text-center">
                        {{mod_library_str_limit($cat['description'], 20)}}
                    </td>
                    <td class="text-center">{{ mod_library_get_list_format_type_name($cat['format_type']) }}</td>
                    <td class="text-center">
                        @if ($cat['status'])
                        <span class="text-success"> <i class="fa fa-check"></i> Hoạt động</span>
                        @else
                        <span class="text-danger"> <i class="fa fa-times"></i> Tạm ngưng</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('mod_library.admin.get_edit_category', $cat['id']) }}" class="text-warning" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_library.admin.get_delete_category', $cat['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>

                {{-- @if(count($cat->children))
                        @include('Post::admin.category.subCategory',['subcategories' => $cat->children, 'dataParent' => $cat->id , 'dataLevel' => 1])
                    @endif   --}}


                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="col-12 mt-2">
        <div class="alert alert-info">{{ ('Không có dữ liệu') }}</div>
    </div>
    @endif

</div>
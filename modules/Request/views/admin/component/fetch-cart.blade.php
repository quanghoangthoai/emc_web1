<div class="table-responsive">
    <table class="table tableShoppingCart" style="border: 1px solid #ddd">
        <thead class="thead-light">
            <tr>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Danh mục</th>
                <th class="text-center">Đơn giá</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @if($shoppingCart)
            @foreach ($shoppingCart as $item)
            <tr>
                <input name="product_ids[]" value="{{ $item['id'] }}" type="hidden">
                <td class="text-center">{{ $item['name'] }}</td>
                <td class="text-center">{{ $item->category['name'] }}</td>
                <td class="text-center">
                    @if ($item['enable_sale'])
                    <strong>{{ number_format($item['sale_price']) }}</strong>đ{{ $item['unit_type'] ? '/' . $item['unit_type'] : '' }}
                    <br>
                    <del><small>{{ number_format($item['price']) }}đ</small></del>
                    @else
                    <strong>{{ number_format($item['price']) }}</strong>đ{{ $item['unit_type'] ? '/' . $item['unit_type'] : '' }}
                    @endif
                </td>

                <td class="text-center">
                    <a href="javascript:;" name="delete" class="text-danger delete" data-popup="tooltip" title="Xóa" id="{{ $item['id'] }}"><i class="fas fa-trash-alt"></i></a>
            </tr>


            @endforeach
            @else

            <td colspan="5" align="center">
                Chưa có sản phẩm
            </td>
            @endif
        </tbody>
    </table>
</div>
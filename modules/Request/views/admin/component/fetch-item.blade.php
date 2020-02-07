<div class="table-responsive">
    <table class="table datatable-basic" id="datatable-product-item">
        <thead class="bg-light">
            <tr>
                <th class="text-center selectAll" style="width:50px;">

                </th>
                <th class="text-center">Hình ảnh</th>
                <th class="text-center">Sản phẩm</th>
                <th class="text-center">Danh mục</th>
                <th class="text-center">Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listProduct as $iProduct)
            <tr>
                <td class="text-center"><input type="checkbox" class="select_product"
                        data-product_id="{{ $iProduct['id'] }}" value=""></td>
                <td class="text-center">
                    @if (isset($iProduct['image']))
                    <img src="{{ $iProduct['image'] }}" alt="{{ $iProduct['name'] }}"
                        style="max-width:80px;max-height:100px">
                    @else
                    <em>Không có</em>
                    @endif
                </td>
                <td class="text-center">{{ $iProduct['name'] }}</td>
                <td class="text-center">{{ $iProduct->category['name'] }}</td>
                <td class="text-center">
                    @if ($iProduct['enable_sale'])
                    <strong>{{ number_format($iProduct['sale_price']) }}</strong>đ{{ $iProduct['unit_type'] ? '/' . $iProduct['unit_type'] : '' }}
                    <br>
                    <del><small>{{ number_format($iProduct['price']) }}đ</small></del>
                    @else
                    <strong>{{ number_format($iProduct['price']) }}</strong>đ{{ $iProduct['unit_type'] ? '/' . $iProduct['unit_type'] : '' }}
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>
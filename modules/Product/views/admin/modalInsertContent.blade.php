<div class="row">
    <div class="col-md-9" style="border-right: 1px solid #ddd">
        <div class="d-md-flex" style="border-top: 1px solid #ddd;">
            <ul class="nav nav-tabs nav-tabs-vertical flex-column mr-md-3 wmin-md-200 mb-md-0 border-bottom-0" style="margin-top: -1px;">
                @if (isset($listCategory) && count($listCategory))
                @foreach ($listCategory as $k => $cat)
                <li class="nav-item"><a href="#category-tab-{{ $k }}" class="nav-link {{ $k == 0 ? 'active' : '' }}" data-toggle="tab">{{ $cat['prefix'] }} {{ $cat['name'] }}</a></li>
                @endforeach
                @endif
            </ul>

            <div class="tab-content" style="width:100%;padding-top: 20px;">
                @if (isset($listCategory) && count($listCategory))
                @foreach ($listCategory as $k => $cat)
                <div class="tab-pane fade {{ $k == 0 ? 'active show' : '' }}" id="#category-tab-{{ $k }}">
                    @if ($listProduct[$cat['id']]->count() > 0)
                    <div class="row">
                        @foreach ($listProduct[$cat['id']] as $product)
                        <div class="col-md-4 col-6 mb-3">
                            <div data-id="{{ $product['id'] }}" id="itemProduct_{{ $product['id'] }}" class="card itemSelectProduct">
                                <div class="card-body html-info">
                                    <h6 class="mb-0 pr-3"><strong>{{ $product['name'] }}</strong></h6>
                                    <hr>
                                    @if ($product['enable_sale'])
                                    <strong>{{ number_format($product['sale_price']) }}</strong>đ{{ $product['unit_type'] ? '/' . $product['unit_type'] : '' }}
                                    <br>
                                    <del><small>{{ number_format($product['price']) }}đ</small></del>
                                    @else
                                    <strong>{{ number_format($product['price']) }}</strong>đ{{ $product['unit_type'] ? '/' . $product['unit_type'] : '' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    Không có sản phẩm
                    @endif
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3" style="border-left: 1px solid #ddd">
        <h6 class="text-center"><strong>SẢN PHẨM ĐÃ CHỌN</strong></h6>
        <div id="listSelectedItem" class="media-list"></div>
        <hr>
        <div class="text-right">
            <button class="btn btn-primary btn-sm btnInsertShortcodeProduct">Thêm vào nội dung</button>
        </div>
    </div>
</div>

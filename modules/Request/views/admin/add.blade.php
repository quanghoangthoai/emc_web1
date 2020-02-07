@extends('Admin::layouts.default')


@section('custom_css')
<style>
    #resultSearchCustomer {
        position: relative;
        display: none
    }

    #resultSearchCustomer>ul {
        position: absolute;
        background: #fff;
        z-index: 9999;
        border: 1px solid #dcdcdc;
        width: 100%;
        list-style: none;
        padding: 0;
        top: -3px;
        border-radius: 0 0 4px 4px;
    }

    #resultSearchCustomer>ul>li {
        padding: 5px 10px;
        border-bottom: 1px dotted #ddd;
        cursor: pointer;
    }

    #resultSearchCustomer>ul>li:last-child {
        border-bottom: none;
    }

    #resultSearchCustomer>ul>li:hover {
        background: #f5f5f5;
    }

    #resultSearchCustomer>ul>li>span {
        display: block;
    }

    .img-request {
        width: 100%;
        height: 200px;
    }

    .img-responsive {
        width: 100%;
    }

    .border-bottom {
        border-bottom-width: thin;
        margin-left: 20px;
        margin-right: 20px;
    }

    .thumbnail {
        position: relative;

    }

    .thumbnail:hover>.caption {
        opacity: 1;
    }

    .caption {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        opacity: 0;
        transition: 0.4s;
    }

    .tableShoppingCart tbody {
        display: block;
        max-height: 200px;
        overflow-y: scroll;
    }

    .tableShoppingCart thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
@endsection
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu</span> - Thêm</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_request.admin.list_request')}}" class="btn btn-primary btn-sm">Danh sách yêu
                cầu</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_request.admin.post_add_request') }}" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0" style="border-bottom: 1px solid #ddd">
        {{-- start client info --}}
        <div class="col-lg-8 p-0" style="border-right: 1px solid #ddd; border-bottom: 1px solid #ddd">
            <div class="col-md-12 p-0" style="border-bottom: 1px solid #ddd">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="fas fa-user"></i> Thông tin cá nhân</h5>

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Họ tên</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input placeholder="Nhập họ tên" id="inputFullname" name="client_name" value="{{ old('client_name') }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Số điện thoại</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input id="inputPhone" onfocus="searchCustomer();" onkeydown="searchCustomer();" autocomplete="new-password" name="client_phone" type="text" value="{{ old('client_phone') }}" placeholder="Nhập số điện thoại" class="form-control">
                            <div id="resultSearchCustomer"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Địa chỉ email</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input id="inputEmail" placeholder="Nhập địa chỉ email" name="client_email" value="{{ old('client_email') }}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-0" style="border-bottom: 1px solid #ddd">
                <div class="card-body">
                    <div class="form-group row mb-0">
                        <label class="col-md-3 col-form-label"><strong>Phương thức thanh toán</strong> </label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" type="radio" class="form-check-input-styled" {{ old('payment_method') == 1 ? 'checked' : '' }} value=1>
                                        </div>
                                    </div>
                                    <span class="text-success">Chuyển khoản</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" type="radio" class="form-check-input-styled" {{ old('payment_method') == 0 ? 'checked' : '' }} value=0>
                                        </div>
                                    </div>
                                    <span class="text-danger">Tiền mặt</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" type="radio" class="form-check-input-styled" {{ old('payment_method') == 2 ? 'checked' : '' }} value=2>
                                        </div>
                                    </div>
                                    <span class="text-dark">Khác</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-0">

                {{ csrf_field() }}
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Thông tin đăng ký dịch vụ</h5>
                    <div class="btn-group">
                        <button type="button" name="clear_cart" id="clear_cart" class="btn btn-warning btn-xs">XÓA TẤT CẢ</button>
                        <button type="button" onclick="openInsertProduct2Request()" class="btn btn-dark btn-xs">THÊM SẢN PHẨM</button>
                    </div>
                </div>
                <div class="card-body row ml-0 mr-0">
                    <div class="col-md-12 pd-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-body" style="width: 100%" id="shopping_cart">
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
                                                        @if(old('product_ids'))
                                                        @foreach (mod_request_get_product_from_array(old('product_ids')) as $item)
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
                                                                <a href="javascript:;" class="text-danger delete" id="{{ $item['id'] }}"><i class="fas fa-trash-alt"></i></a>
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
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="bill_cart" style="border:1px solid #ddd;border-top:0;">

                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- end client info --}}

        {{-- start status --}}
        <div class="col-lg-4 p-0" style="border-bottom: 1px solid #ddd">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><i class="fas fa-download"></i> Trạng thái</h5>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="form-label"><strong>Trạng thái thanh toán</strong> <sup class="text-danger">(∗)</sup></label>
                    <select name="status" class="form-control">
                        <option value="">-- Chọn trạng thái --</option>
                        @if (mod_request_list_status())
                        @foreach (mod_request_list_status() as $key => $value)
                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                @include('Request::admin.component.fetch-image', ['actionType' => 'edit'])
                <div class="form-group">
                    <label class="form-label"><strong>Ghi chú</strong></label>
                    <div>
                        <textarea placeholder="Nhập nội dung ghi chú" style="height: 200px" name="note" type="text" class="form-control">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-info btn-sm">Tạo yêu cầu</button>
                </div>
            </div>
        </div>
        {{-- end status --}}
        <hr>
    </div>
</form>

@endsection
@section('custom_js')
<script>
    $(document).click(function() {
        $('#resultSearchCustomer').hide();
    });

    $("#inputPhone").click(function(e) {
        e.stopPropagation();
    });

    function insertData2Input(el)
    {
        $('#inputPhone').val($(el).find('span#txtPhone').first().html());
        $('#inputFullname').val($(el).find('span#txtFullname').first().html());
        $('#inputEmail').val($(el).find('span#txtEmail').first().html());
    }

    function searchCustomer()
    {
        var valInputPhone = $('#inputPhone').val();

        if (valInputPhone.length > 6) {
            $.ajax({
                type: 'post',
                url: "{{ route('mod_request.ajax.searchCustomer') }}",
                data: {
                    _token: _token,
                    client_phone: valInputPhone
                },
                dataType: 'JSON',
                success: function(res) {
                    $('#resultSearchCustomer').html(res.html);
                    $('#resultSearchCustomer').slideDown(200);
                }
            });
        } else {
            $('#resultSearchCustomer').slideUp(100);
        }
    }

        $(document).ready(function () {
            var productids = {!! json_encode(old('product_ids')) !!};
            load_cart_data(productids);
        });        
        function load_cart_data(productids = null) {
            var payment_status = $('input[type=radio][name=payment_method]:checked').val();
            var vat_percent = $('input[type=number][name=vat_percent]').val();
            var actionType = '{{ isset($actionType) ? $actionType : null }}';
            $.ajax({
                url: '{{ route('mod_request.ajax.fetchCart') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: "POST",
                data:{product_ids: productids,actionType: actionType},
                success: function (data) {
                    $('#shopping_cart').html(data.html);
                    load_bill_data(payment_status, vat_percent);
                }
            });
            
        }
    
        function load_bill_data(payment_status, vat_percent = 10) {
            var actionType = '{{ isset($actionType) ? $actionType : null }}';
            $.ajax({
                url: '{{ route('mod_request.ajax.fetchBill') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: "POST",
                data: { payment_status: payment_status, vat_percent: vat_percent, 'actionType': actionType},
                success: function (data) {
                    $('#bill_cart').html(data.html);
                }
            });
        }
    
        $('input[type=radio][name=payment_method]').on('change', function () {
            var payment_status = $('input[type=radio][name=payment_method]:checked').val();
            var vat_percent = $('input[type=number][name=vat_percent]').val();
            load_bill_data(payment_status, vat_percent);
        });
    
        function actionInsert2Cart (product_id) {
            var action = 'add';
            if (product_id.length > 0) {
                $.ajax({
                    url: '{{ route('mod_request.ajax.fetchAction') }}',
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: { product_id: product_id, action: action },
                    success: function (data) {
                        load_cart_data();
                        app.showNotify(data.message, data.type);
                    }
                });
            }
            else {
                app.showNotify('Hãy chọn ít nhất một sản phẩm', 'error');
            }
    
        };
    
       
        
        $(document).on('click', '.delete', function () {
            var product_id = $(this).attr("id");
            
            
            var action = 'remove';
            if (confirm("Are you sure you want to remove this product?")) {
                $.ajax({
                    url: '{{ route('mod_request.ajax.fetchAction') }}',
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: { product_id: product_id, action: action },
                    success: function (data) {
                        load_cart_data();
                        app.showNotify(data.message, data.type);
                    }
                })
            }
            else {
                return false;
            }
        
        });
        
        $(document).on('click', '#clear_cart', function () {
            var action = 'empty';
            $.ajax({
                url: '{{ route('mod_request.ajax.fetchAction') }}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: { action: action },
                success: function (data) {
                    load_cart_data();
                    app.showNotify(data.message, data.type);
                }
            });
        });
    var listSelectedItem = [];
    function openInsertProduct2Request() {
        $.ajax({
            type: "post",
            url: '{{ route('mod_request.ajax.modalInsertRequest') }}',
            data: {
                _token: _token
            },
            dataType: "JSON",
            success: function (res) {
                
                $("#modalInsertProduct2Content .modal-title").text('THÊM SẢN PHẨM');
                
                $("#modalInsertProduct2Content .modal-body").html(res);
                $("#modalInsertProduct2Content .btnInsertShortcodeProduct").text('Thêm vào giỏ sản phẩm');
                $("#modalInsertProduct2Content").modal("show");
                const myTabs = document.querySelectorAll("ul.nav-tabs > li > a");
                const panes = document.querySelectorAll(".tab-pane");
                const tabAction = Object.keys(myTabs).map(tab => {
                    myTabs[tab].addEventListener("click", e => {
                        makeInactive(panes);
                        activateTabContent(e);
                        e.preventDefault();
                    });
                });
    
                listSelectedItem = [];
    
                $(".btnInsertShortcodeProduct").click(e => {
                    var ids = listSelectedItem;
                    if (ids == []) alert("Chưa chọn sản phẩm nào");
                    else {
                        actionInsert2Cart(ids);
                        $('#modalInsertProduct2Content').modal('hide');
                    }
                });
    
                $(".itemSelectProduct").click(e => {
                    if (!$(e.currentTarget).hasClass("bg-dark")) {
                        var html =
                            '<div class="media itemSelected" style="display:none;">' +
                            '<div class="col-left">' +
                            '<button class="btn btn-light dragula-handle"><i class="icon-dots"></i></button>' +
                            '<button class="btn btn-danger btn-remove-selected-item" data-id="' +
                            $(e.currentTarget).data("id") +
                            '"><i class="fa fa-trash-alt"></i></button>' +
                            "</div>" +
                            '<div class="col-right">' +
                            $(e.currentTarget)
                                .find(".html-info")
                                .first()
                                .html() +
                            "</div></div>";
                        $(e.currentTarget).addClass("bg-dark");
                        $("#listSelectedItem").append(html);
                        $("#listSelectedItem .itemSelected:last-child").fadeIn(300);
                        $("#listSelectedItem").scrollTop(
                            $("#listSelectedItem")[0].scrollHeight
                        );
    
                        // dragula([document.getElementById("listSelectedItem")], {
                        //     mirrorContainer: document.querySelector(
                        //         "listSelectedItem"
                        //     ),
                        //     moves: function(el, container, handle) {
                        //         return handle.classList.contains("dragula-handle");
                        //     }
                        // });
    
                        // DragAndDrop.init();
    
                        listSelectedItem.push($(e.currentTarget).data("id"));
    
                        $(".btn-remove-selected-item").click(e => {
                            $(
                                "#itemProduct_" + $(e.currentTarget).data("id")
                            ).removeClass("bg-dark");
                            $(e.currentTarget)
                                .parent()
                                .parent()
                                .remove();
                            for (var i = 0; i < listSelectedItem.length; i++) {
                                if (
                                    listSelectedItem[i] ===
                                    $(e.currentTarget).data("id")
                                ) {
                                    listSelectedItem.splice(i, 1);
                                }
                            }
                        });
                    }
                });
            }
        });
    }
</script>
@endsection
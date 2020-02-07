{{ csrf_field() }}
<div class="card-header header-elements-inline">
    <h5 class="card-title"><i class="fas fa-user"></i> Thông tin đăng ký dịch vụ</h5>
</div>
<div class="card-body row ml-0 mr-0">
    <div class="col-md-7 ">
        <div class="card">
            <div class="card-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5><b>Thông tin giỏ hàng</b></h5>
                            </div>
                            @if(!isset($actionType) || $actionType != 'edit')
                            <div class="col-md-6" align="right">

                                <button type="button" name="clear_cart" id="clear_cart" class="btn btn-warning btn-xs">XÓA TẤT CẢ</button>
                                <button type="button" onclick="openInsertProduct2Request();" class="btn btn-dark btn-xs">THÊM SẢN PHẨM</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">


                            <div class="col-md-12">
                                <div class="panel-body" style="width: 100%" id="shopping_cart">

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 ">
        <div id="bill_cart">

        </div>
    </div>
</div>
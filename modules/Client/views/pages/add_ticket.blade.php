@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="add-ticket">
                <h3 class="title">Tạo yêu cầu hỗ trợ</h3>
                <div class="alert alert-info mb-4" role="alert">
                    Quý khách vui lòng cung cấp đầy đủ thông tin để bộ phận hỗ trợ EMC có thể liên hệ phối hợp xử lý yêu cầu cho Quý khách được thuận tiện. Cảm ơn Quý khách hợp tác.
                </div>
                <form action="" name="" method="">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Dịch vụ <span>*</span></label>
                        <div class="col-sm-10">
                            <select class="custom-select" id="inputGroupSelect01">
                                <option selected>Tư vấn pháp lý</option>
                                <option value="1">Dịch vụ kế toán</option>
                                <option value="2">Tư vấn quản lý</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <small>Vui lòng chọn chính xác một trong những hạng mục cần được hỗ trợ sau đây: <span>*</span></small>
                            <div class="row mt-3 mb-3">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="custom-control custom-radio ">
                                        <input type="radio" id="option1" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option1">Hỗ trợ tư vấn đăng ký mới dịch vụ</label>
                                    </div>
                                    <div class="custom-control custom-radio ">
                                        <input type="radio" id="option2" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option2">Hỗ trợ các vấn đề về đơn hàng thanh toán Online</label>
                                    </div>
                                    <div class="custom-control custom-radio ">
                                        <input type="radio" id="option3" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option3">Than Phiền- Góp ý (KHÔNG xử lý tức thời vấn)</label>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="option4" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option4">Hỗ trợ tư vấn gia hạn dịch vụ</label>
                                    </div>
                                    <div class="custom-control custom-radio >
                                        <input type=" radio" id="option4" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option5">Hỗ trợ thay đổi Thông tin - Hồ sơ - Hợp đồng</label>
                                    </div>
                                    <div class="custom-control custom-radio ">
                                        <input type="radio" id="option6" name="option" class="custom-control-input">
                                        <label class="custom-control-label" for="option6">Hỗ trợ chuyên sâu về nghiệp vụ kế toán</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Tiêu đề <span>*</span></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nội dung</label>
                        <div class="col-sm-10">
                            <div id="summernote"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Đính kèm</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                            <span class="help-block">Hỗ trợ định dạng: .jpg, .gif, .jpeg, .png, .zip, .7z, .tar, .gzip, .doc, .docx, .xls, .xlsx, .pdf</span>
                        </div>
                    </div>
                    <div class="mt-2 text-right">
                        <button type="button" class="btn btn-warning" id="">Hủy</button>
                        <button type=" button" class="btn btn-success" id="">Gửi yêu cầu</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
@endsection
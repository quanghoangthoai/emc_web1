@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-ticket">
                <h3 class="title">Yêu cầu hỗ trợ</h3>
                <div class="required-content ">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p><strong>Hỗ trợ gia hạn hợp đồng</strong></p>
                            <p>Hỗ trợ gia hạn hợp đồng dịch vụ kế toán</p>
                            <a class="reply" data-toggle="collapse" href="#reply" role="button" aria-expanded="false" aria-controls="reply">
                                <i class="fa fa-reply mr-2"></i> Trả lời <span><i class="fas fa-plus"></i></span>
                            </a>
                            <div class="collapse" id="reply">
                                <div class="card card-body">
                                    <form action="" name="" method="">
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
                                            <button type="button" class="btn btn-warning" id="" data-toggle="collapse" href="#reply" role="button" aria-expanded="false" aria-controls="reply">Hủy bỏ</button>
                                            <button type=" button" class="btn btn-success" id="">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="answer mb-3">
                                <span class="name">Huỳnh Quốc Đạt</span>
                                <span class="date">17/06/2019 12:32:56</span>
                            </div>
                            <div class="message">
                                <p>Kính chào Quý khách,</p>
                                <p>EMC rất vui khi nhận được phản hồi tích cực từ quý khách. EMC đã hỗ trợ hoàn tất vì thế chúng tôi xin phép đóng ticket này.</p>
                                <p>Xin trân trọng cảm ơn quý khách.</p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="answer mb-3">
                                <span class="name guest">Mitech Center</span>
                                <span class="date">17/06/2019 12:30:15</span>
                            </div>
                            <div class="message">
                                <p>Dịch vụ tốt, hỗ trợ nhanh, tuyệt vời</p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="answer mb-3">
                                <span class="name">Huỳnh Quốc Đạt</span>
                                <span class="date">17/06/2019 11:41:58</span>
                            </div>
                            <div class="message">
                                <p>Kính thưa Quý khách,</p>
                                <p>EMC đã tiếp nhận yêu cầu của quý khách về việc <strong>Hỗ trợ gia hạn hợp đồng</strong>.</p>
                                <p>Chúng ta vẫn biết rằng, làm việc với một đoạn văn bản dễ đọc và rõ nghĩa dễ gây rối trí và cản trở việc tập trung vào yếu tố trình bày văn bản. Lorem Ipsum có ưu điểm hơn so với đoạn văn bản chỉ gồm nội dung kiểu "Nội dung, nội dung, nội dung" là nó khiến văn bản giống thật hơn, bình thường hơn. Nhiều phần mềm thiết kế giao diện web và dàn trang ngày nay đã sử dụng Lorem Ipsum làm đoạn văn bản giả, và nếu bạn thử tìm các đoạn "Lorem ipsum" trên mạng thì sẽ khám phá ra nhiều trang web hiện vẫn đang trong quá trình xây dựng. Có nhiều phiên bản khác nhau đã xuất hiện, đôi khi do vô tình, nhiều khi do cố ý (xen thêm vào những câu hài hước hay thông tục).</p>
                                <p>Trân trọng cảm ơn quý khách!</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
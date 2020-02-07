@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="request">
                <h3 class="title">Danh sách yêu cầu đăng ký mới</h3>
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-success" id="" onclick="location.href='{{ route('client.products') }}'"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                </div>
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Danh mục sản phẩm</th>
                            <th class="th-sm" style="width: 25%;">Sản phẩm</th>
                            <th class="th-sm">Thời gian</th>
                            <th class="th-sm">Tổng tiền</th>
                            <th class="th-sm">Ủy nhiệm chi</th>
                            <th class="th-sm">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tư vấn pháp luật</td>
                            <td>
                                <ul>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Gói dịch vụ tư vấn pháp lý</a></li>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Dịch vụ kế toán</a></li>
                                </ul>
                            </td>
                            <td>18/10/2019</td>
                            <td>
                                <ul>
                                    <li>1.100.000đ</li>
                                    <li>2.000.000đ</li>
                                </ul>
                            </td>
                            <td><a href="#" data-toggle="modal" data-target="#uploadfile">Tải lên</a></td>
                            <td><span class="text-danger">Chưa thanh toán</span></td>
                        </tr>
                        <tr>
                            <td>Tư vấn ly hôn</td>
                            <td><a href="https://www.emcvn.vn/vn" target="_blank">Dịch vụ kế toán</a></td>
                            <td>18/10/2019</td>
                            <td>1.340.000đ</td>
                            <td><a href="#" data-toggle="modal" data-target="#uploadfile">Tải lên</a></td>
                            <td><span class="text-danger">Chưa thanh toán</span></td>
                        </tr>
                        <tr>
                            <td><a>Tư vấn về hôn nhân đồng giới :((</a></td>
                            <td><a href="https://www.emcvn.vn/vn" target="_blank">Gói dịch vụ tuyển dụng nhân sự</a></td>
                            <td>20/07/2018</td>
                            <td>1.200.000đ</td>
                            <td> --- </td>
                            <td><span class="text-success">Đã thanh toán</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="" method="" name="">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center w-100" id="exampleModalLabel" style="font-size: 18px;font-weight: 600;text-transform: uppercase;">Tải lên</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-file" lang="es">
                                                <input type="file" class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">Chọn file...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-success" id=""="">Tải lên</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <div class="info-account">
                <section id="my-account">
                    <h3 class="title">Thông tin tài khoản</h3>
                    <form method="" action="" name="">
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tên doanh nghiệp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="" name="" value="Trung tâm CNTT & NN Trường Đại học Thông tin Liên Lạc">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tên hiển thị</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="Mitech Center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Mã số thuế</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="" name="" value="225670082">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Người đại diện</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="Nguyễn Lê Đông Sơn">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="info@mitechcenter.vn">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="+84-583892288">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="+84-583892288">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Fax</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly="readonly" id="myEdit" name="" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Địa chỉ</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="myEdit" name="" readonly="readonly" value="101B Mai Xuân Thưởng, Vĩnh Hải, Nha Trang, Khánh Hòa, Việt Nam">
                            </div>
                        </div>
                        @php
                        $userSocialFB = auth('web')->user()->social()->where('provider', 'facebook')->first();
                        $userSocialGG = auth('web')->user()->social()->where('provider', 'google')->first();
                        @endphp
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Liên kết Facebook</label>
                            <div class="col-sm-9 col-form-label">
                                {!! $userSocialFB ? '<strong>' . $userSocialFB['social_id'] . '</strong> <a class="btn btn-danger btn-sm ml-3" href="' . route('client.unlink_social', 'facebook') . '">Xóa</a>' : '<em>Chưa liên kết</em> <a class="btn btn-info btn-sm ml-3" onclick="login_social(\''. route('login.social', 'facebook') .'\');" href="javascript:;">Liên kết</a>' !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Liên kết Google</label>
                            <div class="col-sm-9 col-form-label">
                                {!! $userSocialGG ? '<strong>' . $userSocialGG['social_id'] . '</strong> <a class="btn btn-danger btn-sm ml-3" href="' . route('client.unlink_social', 'google') . '">Xóa</a>' : '<em>Chưa liên kết</em> <a class="btn btn-info btn-sm ml-3" onclick="login_social(\''. route('login.social', 'google') .'\');" href="javascript:;">Liên kết</a>' !!}
                            </div>
                        </div>
                        <div class="mt-2 text-right">
                            <button type="button" class="btn btn-danger" id="btn_edit">Chỉnh sửa</button>
                            <button type="button" class="btn btn-warning" id="btn_cancel">Hủy</button>
                            <button type="button" class="btn btn-success" id="btn_save">Lưu thay đổi</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</main>
@endsection

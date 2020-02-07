@extends('Web::layouts.home')
@section('page_content')
<nav aria-label="breadcrumb" class="text-center">
    <div id="breadcrumb">
        <h1>LIÊN HỆ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
        </ol>
    </div>
</nav>
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="contact">
                <div class="contact-info">
                    <div class="info">
                        {!! isset($contact['value']) ? $contact['value'] : '-' !!}
                    </div>
                    <div class="map-emc mt-5">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.981572206926!2d109.18425931442475!3d12.249526191332485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170677e945caa8b%3A0xc6b54a3d9f360997!2zQ8O0bmcgVHkgVMawIFbhuqVuIFF14bqjbiBMw70gRG9hbmggTmdoaeG7h3AgKEVNQyk!5e0!3m2!1svi!2s!4v1572583343592!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                    <div class="form-contact">
                        <div class="form-ct">
                            <div class="text-center">
                                <h3>LIÊN HỆ TRỰC TUYẾN</h3>
                            </div>
                            <form action="{{ route('mod_contact.web.post_send_contact') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <label for="services">Dịch vụ *</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                        <div class="form-group">
                                            <select name="service" class="form-control" id="services">
                                                @foreach (mod_contact_list_service() as $key => $iService)
                                                <option value="{{ $iService }}" {{ (old('service') == $iService) ? 'selected' : '' }}>{{ $iService }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Họ tên *" name="sender_name" id="sender_name" value="{{ old('sender_name') }}">
                                        </div>
                                        <div style="color: red">
                                            @if ($errors->first('sender_name') != null)
                                            {!! '<i class="fa fa-times-circle"></i> '.$errors->first('sender_name') !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Email *" name="sender_email" id="sender_email" value="{{ old('sender_email') }}">
                                        </div>
                                        <div style="color: red">
                                            @if ($errors->first('sender_email') != null)
                                            {!! '<i class="fa fa-times-circle"></i> '.$errors->first('sender_email') !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Số điện thoại *" name="sender_phone" id="sender_phone" value="{{ old('sender_phone') }}">
                                        </div>
                                        <div style="color: red">
                                            @if ($errors->first('sender_phone') != null)
                                            {!! '<i class="fa fa-times-circle"></i> '.$errors->first('sender_phone') !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Tiêu đề *" name="title" id="title" value="{{ old('title') }}">
                                        </div>
                                        <div style="color: red">
                                            @if ($errors->first('title') != null)
                                            {!! '<i class="fa fa-times-circle"></i> '.$errors->first('title') !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="5" placeholder="Nội dung *" name="sender_content">{{ old('sender_content') }}</textarea>
                                        </div>
                                        <div style="color: red">
                                            @if ($errors->first('sender_content') != null)
                                            {!! '<i class="fa fa-times-circle"></i> '.$errors->first('sender_content') !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="btnsend text-center">
                                    <button class="btn btn-primary btn-sendd" type="submit">GỬI ĐI</button>
                                </div>
                                @if (session('success'))
                                <div style="display: none" id="check-success">{!! session('success') !!}</div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
{{-- modal --}}
<button type="button" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="showModel">Open Modal</button>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center" style="color: #00a859">
                    <i class="fas fa-check-circle fa-4x pb-2"></i>
                    <p> <strong>Gửi liên hệ đến EMC thành công. Cám ơn bạn!</strong></p>
                </div>
            </div>
            <div class="text-center pb-3">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
<script>
    $(document).ready(function(){
            if ($("#check-success").text() == "1") {
                $("#showModel").click();
            };
        });
</script>
@endsection

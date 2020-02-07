@extends('Client::layouts.default')
@section('custom_css')
<style>
    section#detail-ticket .form-control-file {
        border: 1px solid #ced4da;
        padding: 5px;
        border-radius: 4px;
        height: auto !important;
    }

    section#detail-ticket span.help-block {
        font-size: 12px;
        padding-top: 0;
        color: #a2a2a2;
        display: inline-block;
        margin-top: 14px;
    }
</style>
@endsection
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-ticket">
                <h3 class="title">Chi tiết yêu cầu hỗ trợ</h3>
                <div class="required-content ">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p>Tiêu đề: <strong>{{ $request_detail['title'] }}</strong></p>
                            <p>Dịch vụ: <strong>{{ mod_ticket_get_name_product($request_detail['product_id']) }}</strong></p>
                            <a class="reply" data-toggle="collapse" href="#reply" role="button" aria-expanded="false" aria-controls="reply">
                                <i class="fas fa-reply-all"></i> Trả lời <span><i class="fas fa-plus"></i></span>
                            </a>
                            <div class="collapse" id="reply">
                                <div class="card card-body">
                                    <form action="{{ route('client.post_detail_ticket',$request_detail['id']) }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Nội dung <span style="color: red">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea name="content" id="summernote">{{ old('content') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Đính kèm <a href="javascript:;" class="ml-2 mb-2" id="add-input-file"> <i class="fas fa-plus-circle" title="Thêm file"></i></a></label>
                                            <div class="col-sm-10">
                                                <div class="add-file">
                                                    <input type="file" class="form-control-file" name="attachments[]" id="attachments">
                                                </div>
                                                <span class="help-block">Hỗ trợ định dạng: .jpg, .gif, .jpeg, .png, .zip, .7z, .tar, .gzip, .doc, .docx, .xls, .xlsx, .pdf</span>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <a style="padding:8px 10px !important;min-width: 112px;" href="{{ route('client.tickets') }}" class="btn btn-warning" id="">Hủy bỏ</a>
                                            <button type=" button" class="btn btn-success" id="">Trả lời</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @if (isset($listHistory) && count($listHistory))
                        @foreach ($listHistory as $iHis)
                        @if (mod_ticket_check_role_customer($iHis['user_id']))
                        <li class="list-group-item">
                            <div class="answer mb-3">
                                <span class="name">{{ user_display_name($iHis['user_id']) }}</span>
                                <span class="date">{!! date('H:i:s d/m/Y', strtotime($iHis['reply_at'])) !!}</span>
                            </div>
                            <div class="message">
                                <p>{!! $iHis['content'] !!}</p>
                            </div>
                            @if ($iHis['attachments'] != [])
                            @php
                            $attachHistory = json_decode($iHis['attachments'], true);
                            @endphp
                            @if (isset($attachHistory) && count($attachHistory))
                            <p><strong>File đính kèm</strong></p>
                            @foreach ($attachHistory as $iAtt)
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="mb-3">{{ $iAtt }} </p>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('client.download_ticket',$iAtt) }}" class="btn btn-dark btn-sm float-right legitRipple"><i class="fas fa-download mr-1"></i> Tải về</a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @endif
                        </li>
                        @else
                        <li class="list-group-item">
                            <div class="answer mb-3">
                                <span class="name guest">{{ user_display_name($iHis['user_id']) }}</span>
                                <span class="date">{!! date('H:i:s d/m/Y', strtotime($iHis['reply_at'])); !!}</span>
                            </div>
                            <div class="message">
                                <p>{!! $iHis['content'] !!}</p>
                            </div>
                            @if ($iHis['attachments'] !== [])
                            @php
                            $attachHistory = json_decode($iHis['attachments'], true);
                            @endphp
                            @if (isset($attachHistory) && count($attachHistory))
                            <p><strong>File đính kèm</strong></p>
                            @foreach ($attachHistory as $iAtt)
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="mb-3">{{ mod_ticket_get_name_file($iAtt) }} </p>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('client.download_ticket',mod_ticket_get_name_file($iAtt)) }}" class="btn btn-dark btn-sm float-right legitRipple"><i class="fas fa-download mr-1"></i> Tải về</a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @endif
                        </li>
                        @endif
                        @endforeach
                        @else
                        <div class="alert alert-info">Chưa có phản hồi nào</div>
                        @endif
                    </ul>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection

@section('custom_js')
<script>
    $('#summernote').summernote({
            height: 200,
            placeholder: 'Nhập nội dung trả lời ...'
        });
</script>
<script>
    $(document).ready(function(){
            $("#add-input-file").click(function(){
                $(".add-file").append('<div><input style="width: 95%;float:left;" type="file" class="form-control-file mt-2 fileinput" name="attachments[]" id="attachments"><a href="javascript:;" class="btn btn-default mt-2" onclick="removeFile(this);" style="width: 5%;float:right;"><i class="fas fa-times-circle" aria-hidden="true" style="color:red" title="Xóa"></i></a></div>');
            });
        });
        function removeFile(el)
        {
            $(el).parent().remove();
        }
</script>
@endsection
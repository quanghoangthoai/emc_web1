@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-ticket-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu hỗ trợ</span> - Yêu cầu #{{ $ticket_detail['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('custom_css')
<style>
    .card-body {
        padding: 0;
    }

    .content-wrapper {
        overflow: hidden;
    }

    .container {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
    }

    .darker {
        border-color: #ccc;
        background-color: #ddd;
    }

    .container::after {
        content: "";
        clear: both;
        display: table;
    }

    .container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
    }

    .container img.right {
        float: right;
        margin-left: 20px;
        margin-right: 0;
    }

    .time-right {
        float: right;
        color: #aaa;
    }

    .time-left {
        float: left;
        color: #999;
    }

    .chat-css {
        width: 100%;
        border: solid 1px #ddd;
        border-radius: 5px;
        padding: 10px;
        overflow-y: scroll;
        height: 400px;
    }
</style>
@endsection
@section('page_content')
<div class="content">
    <div class="card-header border-bottom mb-0 header-elements-inline">
        <div class="row" style="width: 100%">
            <div class="col-md-6 pt-2">
                <h5 class="card-title">#{{ $ticket_detail['id'] }} {{ $ticket_detail['title'] }}</h5>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <div class="d-inline-flex">
                        <div class="col-md-7 mt-1">
                            <div class="row float-right">
                                <div class="col-md-4" style="padding-top: 10px">
                                    <p><strong> Trạng thái</strong></p>
                                </div>
                                <div class="col-md-8">
                                    <select name="status_id" class="form-control" id="status_id" data-id="{{ $ticket_detail['id'] }}">
                                        <option value="" disabled>-- Chọn trạng thái --</option>
                                        <option value="2" {{ $ticket_detail['status'] == 2 ? 'selected' : '' }}>Đã tiếp nhận</option>
                                        <option value="3" {{ $ticket_detail['status'] == 3 ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="4" {{ $ticket_detail['status'] == 4 ? 'selected' : '' }} disabled>Đã trả lời</option>
                                        <option value="7" {{ $ticket_detail['status'] == 7 ? 'selected' : '' }} disabled>Đợi phản hồi</option>
                                        <option value="5" {{ $ticket_detail['status'] == 5 ? 'selected' : '' }}>Tạm ngưng</option>
                                        <option value="6" {{ $ticket_detail['status'] == 6 ? 'selected' : '' }}>Hoàn tất</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mt-1">
                            <a href="javascript:;" data-toggle="modal" data-target="#modalHistory" class="btn btn-light float-right"><i class="fa fa-history mr-1"></i>Lịc sử phản hồi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin: 0">
        <div style="width: 100%">
            <div class="row">
                <div class="col-md-6 pl-4 pt-2" style="border-right: solid 1px #ddd">
                    <h6><i class="fas fa-user-tie mr-2"><strong></i> THÔNG TIN KHÁCH HÀNG </strong>
                        <div class="float-right mb-5" id="status_cus">{!! mod_ticket_get_html_status($ticket_detail['status']) !!}</div>
                    </h6>
                    <table>
                        <tr>
                            <td style="padding-bottom: 15px"><strong>Họ và tên:</strong></td>
                            <td style="padding-left: 30px;padding-bottom: 15px">{{ user_display_name($ticket_detail['customer_id']) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 15px"><strong>Email:</strong></td>
                            <td style="padding-left: 30px;padding-bottom: 15px">{{ $ticket_detail->custom['email'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 15px"><strong>Số điện thoại:</strong> </td>
                            <td style="padding-left: 30px;padding-bottom: 15px">{{ $ticket_detail->custom->info['phone'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 15px"><strong>Yêu cầu tạo lúc:</strong></td>
                            <td style="padding-left: 30px;padding-bottom: 15px">{{ date('H:i:s d/m/Y', strtotime($ticket_detail['created_at'])) }}</td>
                        </tr>
                    </table>
                    <div class="row" style="margin: 0;border-top: solid 1px #ddd;">
                        <div style="width: 100%">
                            <h6 class="mt-2"><strong>NỘI DUNG MỚI NHẤT</strong></h6>
                            <div class="table-responsive" style="margin-right: 30px;border: solid 1px #ddd;">
                                <table class="table">
                                    <tr>
                                        <td style="width: 25%;border-right: solid 1px #ddd"><strong>Dịch vụ</strong> </td>
                                        <td style="width: 75%">{{ mod_ticket_get_name_product($ticket_detail->product_id) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%;border-right: solid 1px #ddd"><strong>Hạng mục</strong></td>
                                        <td style="width: 75%">{{ mod_ticket_category_display_name($ticket_detail['id']) }}</td>
                                    </tr>
                                    <tr style="height: auto">
                                        <td style="width: 25%;border-right: solid 1px #ddd"><strong>Nội dung</strong></td>
                                        <td style="width: 75%">
                                            <p class="mb-0 pt-1 pb-1">{!! mod_ticket_get_last_request($ticket_detail['id']) !!}</p>
                                        </td>
                                    </tr>
                                    <tr style="height: auto">
                                        <td style="width: 25%;border-right: solid 1px #ddd"><strong>Đính kèm</strong></td>
                                        <td style="width: 75%">
                                            @if (isset($listAttachment) && count($listAttachment) > 0)
                                            @foreach ($listAttachment as $iAtt)
                                            <div class="row">
                                                <div class="col-md-10" style="word-break: break-all;">
                                                    <p class="mb-0 pt-1 pb-1">{{ $iAtt }} </p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p class="mb-0 pt-1 pb-1"><a href="{{ route('mod_ticket.admin.download',$iAtt) }}" class="float-right legitRipple" title="Tải về"><i class="fas fa-download"></i></a></p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            {{ 'Không có file đính kèm' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%;border-right: solid 1px #ddd"><strong>Thời gian gửi </strong></td>
                                        <td style="width: 75%">{{ date('H:i:s d/m/Y', strtotime(mod_ticket_get_last_reply($ticket_detail['id']))) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-3 pt-2">
                    <h6 class="pl-2"><strong><i class="fas fa-envelope mr-2"></i> GỬI PHẢN HỒI</strong></h6>
                    <form action="{{ route('mod_ticket.admin.post_detail_ticket',$ticket_detail['id']) }}" method="post" enctype="multipart/form-data" style="width: 100%">
                        {{ csrf_field() }}
                        <div class="row" style="margin: 0">
                            <div style="width: 100%">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>Câu trả lời mẫu</strong></label>
                                            <div class="input-group areaBrowserFile">
                                                <select name="reply_template_id" class="form-control" id="reply_template_id">
                                                    <option value="">-- Chèn mẫu trả lời --</option>
                                                    @if (isset($listReply) && count($listReply))
                                                    @foreach ($listReply as $rep)
                                                    <option value="{{ $rep['id'] }}">{{ $rep['name'] }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div class="input-group-prepend mr-0">
                                                    <a href="javascript:;" class="btn btn-dark btn-sm" data-popup="tooltip" title="Xóa bỏ" id="del_reply"><em class="fa fa-times"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12"><strong>Nội dung trả lời </strong> <sup class="text-danger">(∗)</sup></label>
                                            <div class="col-lg-12">
                                                <textarea id="content" name="content_reply" class="form-control">{{ old('content_reply') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group add-file">
                                            <label for="attachments"><strong>File đính kèm</strong> </label>
                                            <b class="ml-2 mb-2 btn" id="add-input-file" title="Thêm file"><i class="fa fa-plus-circle"></i></b>
                                            <div class="col-lg-12" style="padding: 0">
                                                <input type="file" style="height: auto" class="form-control" name="attachments[]" id="attachments">
                                            </div>
                                        </div>
                                        <div class="text-right" style="margin-bottom: 15px">
                                            <a href="{{ route('mod_ticket.admin.list_ticket') }}" class="btn btn-dark btn-sm mt-2">Hủy bỏ</a>
                                            <button class="btn btn-success btn-sm mt-2" name="send_reply">Gửi phản hồi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- model --}}
<div id="modalHistory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-history mr-1"></i> LỊCH SỬ PHẢN HỒI</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @if (isset($listHistory) && count($listHistory))
                <h6 class="modal-title">Tiêu đề: {{ $listHistory[0]->ticket['title'] }}</h6>
                <div class="chat-css">
                    @foreach ($listHistory as $iHis)
                    @if (mod_ticket_check_role_customer($iHis['user_id']))
                    <div class="container" style="word-break: break-all">
                        {{-- <img src="https://thietkenhahaiphong.vn/Data/images/icons/man-icon-1.png" alt="Avatar" style="width:100%;"> --}}
                        <p>{!! $iHis['content'] !!}</p>
                        @if ($iHis['attachments'] != null)
                        <p><strong>File đính kèm</strong></p>
                        @php
                        $attachHistory = json_decode($iHis['attachments'], true);
                        @endphp

                        @foreach ($attachHistory as $iAtt)
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-3">{{ $iAtt }} </p>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('mod_ticket.admin.download',$iAtt) }}" class="float-right" title="Tải về"><i class="fa fa-download"></i></a>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <span class="time-right">{!! date('H:i d/m/Y', strtotime($iHis['reply_at'])); !!}</span>
                        <span class="time-left">Khách hàng: {{ user_display_name($iHis['user_id']) }}</span>
                    </div>
                    @else
                    <div class="container darker" style="word-break: break-all">
                        {{-- <img src="http://www.visicadcam.vn/images/icons/hexagon/darkblue/MI_DARK_BLUE_ICON_SUPPORT.png" alt="Avatar" class="right" style="width:100%;"> --}}
                        <p>{!! $iHis['content'] !!}</p>
                        @if ($iHis['attachments'] !== null)
                        <p><strong>File đính kèm</strong></p>
                        @php
                        $attachHistory = json_decode($iHis['attachments'], true);
                        @endphp
                        @foreach ($attachHistory as $iAtt)
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-3">{{ $iAtt }} </p>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('mod_ticket.admin.downloadfilemanager',$iAtt) }}" class="float-right" title="Tải về"><i class="fa fa-download"></i></a>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <span class="time-left">{!! date('H:i d/m/Y', strtotime($iHis['reply_at'])); !!}</span>
                        <span class="time-right">Nhân viên: {{ user_display_name($iHis['user_id']) }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="alert alert-info">Chưa có dữ liệu</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
{{-- load ckeditor --}}
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })

    });
</script>
<script>
    $(document).ready(function(){
            // get content reply
            $("#reply_template_id").change(function(){
                var reply_id = $(this).val();
                $.get("getContentReply/"+reply_id,function(data){
                    CKEDITOR.instances.content.setData(data);
                });
            });
            // change status ticket
            $('#status_id').change(function(){
                $.ajax({
                    type:'POST',
                    url:"{{ route('mod_ticket.ajax.changeStatusTicket') }}",
                    data: {
                        _token: _token,
                        id: $(this).data('id'),
                        status: $(this).val()
                    },
                    dataType: 'JSON',
                    success:function(res) {
                        if (res.status) {
                            app.showNotify(res.msg, 'success');
                            $("#status_cus").load(" #status_cus");
                        } else {
                            app.showNotify(res.msg, 'error');
                        }
                    }
                });
            });
            $("#del_reply").click(function(){
                CKEDITOR.instances.content.setData('');
                $("#reply_template_id").val('');
            });
        });
</script>


{{-- js add input file --}}
<script>
    $(document).ready(function(){
                $("#add-input-file").click(function(){
                    $(".add-file").append('<div><input style="width: 88%;float:left;height: auto;" type="file" class="form-control mt-2 fileinput" name="attachments[]" id="attachments"><a class="btn btn-default mt-2" onclick="removeFile(this);" style="width: 10%;float:right;line-height: 30px;"><i class="fa fa-times-circle" aria-hidden="true" style="color:red"></i></a></div>');
                });
            });
            function removeFile(el)
            {
                 $(el).parent().remove();
            }
</script>
@endsection
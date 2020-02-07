@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-user-tie mr-2"></i> <span class="font-weight-semibold">Hồ sơ ứng tuyển</span> - #{{ $iRec['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="row ml-0 mr-0" style="border-bottom: 1px solid #ddd">
    <div class="col-md-6 p-0" style="border-right: 1px solid #ddd">
        <div class="card-body">
            <h6>
                <i class="fas fa-user-tie mr-2"></i> <strong>THÔNG TIN ỨNG VIÊN</strong>
                <span class="float-right">{!! mod_recruitment_get_status($iRec['status']) !!}</span>
            </h6>
            @if ($iRec->personal)
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Họ tên</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ $iRec->personal->info->fullname }}
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Email</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ $iRec->personal->email }}
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Điện thoại</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ $iRec->personal->info->phone }}
                </div>
            </div>
            @else
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-12"><em>Thông tin tài khoản đã bị xóa</em></label>
            </div>
            @endif

            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Hồ sơ tạo lúc</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ date('H:i:s, d/m/Y', strtotime($iRec['created_at'])) }}
                </div>
            </div>
            <hr>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Tin tuyển dụng</strong></label>
                <div class="col-lg-9 col-form-label">
                    <a href="#"><strong>{{ $iRec->job['title'] }}</strong> <i class="fas fa-external-link-alt ml-1" style="font-size:12px;"></i></a>
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Vị trí tuyển dụng</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ $iRec->job['position'] }}
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Mức lương</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ $iRec->job['salary'] }}
                </div>
            </div>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-3"><strong>Hạn chót nhận hồ sơ</strong></label>
                <div class="col-lg-9 col-form-label">
                    {{ date('d/m/Y', strtotime($iRec->job['expired_at'])) }}
                </div>
            </div>
            <hr>
            <div class="form-group row mb-0">
                <label class="col-form-label col-lg-12">
                    <h6>
                        <i class="far fa-file-pdf"></i>
                        <strong>HỒ SƠ</strong>
                        <a target="_blank" href="{{ route('mod_recruitment.admin.get_download', $iRec['id']) }}" class="btn btn-dark btn-sm float-right"><i class="fa fa-download mr-1"></i> Tải hồ sơ</a>
                    </h6>
                </label>
                <div class="col-lg-12">
                    <iframe src="https://docs.google.com/viewer?url={{ asset($iRec['attach_file']) }}&embedded=true" style="width:100%; height:400px;" frameborder="0"></iframe>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6 p-0">
        <div class="card-body">
            <h6 class="mb-3">
                <i class="fas fa-envelope mr-2"></i> <strong>GỬI PHẢN HỒI</strong>
                <a href="javascript:;" data-toggle="modal" data-target="#modalHistory" class="btn btn-light btn-sm float-right"><i class="fa fa-history mr-1"></i> Lịch sử phản hồi</a>
            </h6>
            <form action="{{route('mod_recruitment.admin.send_mail_recruitment', $iRec['id'])}}" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><strong>Trạng thái xử lý</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            @if (mod_recruitment_list_status())
                            @foreach (mod_recruitment_list_status() as $key => $value)
                            <option value="{{ $key }}" {{ old('status', $iRec['status']) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><strong>Nội dung phản hồi</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select class="form-control" name="template_id" id="mail-template-select">
                                <option value="">Chọn mẫu phản hồi</option>
                                @if (mod_recruitment_list_mail_template())
                                @foreach (mod_recruitment_list_mail_template() as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="input-group-prepend mr-0">
                                <button data-popup="tooltip" title="Xóa trắng nội dung phản hồi" class="btn btn-dark btn-sm" id="resfresh-mail-button" type="button"><i class="fa fa-undo"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea id="content" name="content"></textarea>
                </div>
                <div class="text-right">
                    <a href="{{ route('mod_recruitment.admin.list_recruitment') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                    <button type="submit" class="btn btn-info btn-sm">Gửi phản hồi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalHistory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-history mr-1"></i> LỊCH SỬ PHẢN HỒI</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @if ($Progs && count($Progs))
                @foreach ($Progs as $iProg)
                <div class="row mb-2 propress-component">
                    <div class="col-sm-1"><i class="fas fa-history"></i></div>
                    <div class="col-sm-8">{!! '<b>'.$iProg['user_fullname'].'</b> phòng: '.$iProg['user_department'] .' đã ' .
                        mod_recruitment_get_status($iProg['status']) !!}</div>
                    <div class="col-sm-3"><span data-popup="tooltip" title="{{ $iProg['created_at'] }}">{{ cms_time_elapsed_string($iProg['created_at']) }}</span></div>
                    {{-- content of email --}}
                    <div class="col-sm-1"></div>
                    <div class="col-sm-11 content-email-text">{{mod_recruitment_str_limit($iProg['content'],50)}}</div>
                </div>
                @endforeach
                @else
                <div class="alert alert-info">Chưa có dữ liệu.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 450,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })

    });
</script>
<script>
    $(function() {
        $("#mail-template-select").change(function () {
            var id = $('option:selected', this).val();
            show_mail_template(id)
        });
        $('#resfresh-mail-button').click(function(){
            $('#mail-template-select').prop('selectedIndex',0);
            var editor = CKEDITOR.instances.content;
            editor.setData();
        });
    });
    function show_mail_template(id)
    {
        // call ajax to chang order
        $.ajax({
            type: 'post',
            url: "{{ route('mod_recruitment.admin.ajaxshowmailtemplate') }}",
            data: {
                _token: _token,
                id: id,
            },
            dataType: 'json',
            success: function(response) {;
                var editor = CKEDITOR.instances.content;
                editor.insertHtml(response.data);
                app.showNotify(response.flash_data.message,response.flash_data.type);

            }
        });
    }
</script>
@endsection

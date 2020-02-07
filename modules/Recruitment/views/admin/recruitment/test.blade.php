@extends('Admin::layouts.default')
@section('page_content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Kiểm thử ứng tuyển</h3>
        <div class="row">
            <div class="col-xl-8">
                <h1>{{$iJob['title']}}</h1>
                <em>Mức lương: {!! $iJob['salary'] !!}</em>
                <p>Vị trí tuyển: {!! $iJob['position'] !!}</p>
                <p>{!! $iJob['content'] !!}</p>

                <div class="card border-primary-300 col-xl-4">
                    <div class="card-body">
                        <h4 class="card-title">Liên hệ</h4>
                        <p class="card-text">{!! $iJob['contact_info'] !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Nộp hồ sơ
                </button>

            </div>
        </div>
    </div>
</div>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nộp hồ sơ xin việc</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{route('mod_recruitment.admin.post_test',$iJob['id'])}}"
                enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">Vị trí ứng tuyển <sup
                                class="text-danger">(∗)</sup></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="" name="position" value="{{$iJob['position']}}"
                                readonly>
                        </div>
                    </div>
                    <input type="text" class="form-control" hidden name="job_id" value="{{$iJob['id']}}" readonly>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">File đính kèm</label>
                        <div class="col-sm-9">
                            <div class="input-group areaBrowserFile">
                                <input type="file" name="attach_file" required="true">
                            </div>
                        </div>

                    </div>



                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Nộp</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
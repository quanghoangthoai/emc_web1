@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Khối menu</span> - Sửa</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('mod_menu.admin.list_menu') }}" class="btn btn-primary btn-sm">Danh sách menu</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <form action="{{ route('mod_menu.admin.post_edit_menu', $menu['id']) }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="card">
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col class="w200">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td><strong>Tiêu đề</strong> <sup class="required text-danger">(∗)</sup></td>
                                <td>
                                    <input name="title" value="{{ old('title', $menu['title']) }}" type="text" class="form-control" placeholder="Nhập tiêu đề ">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-info">Lưu thay đổi</button>
            </div>
        </div>
    </form>
</div>
@endsection
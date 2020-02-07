@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="recruitment">
                <h3 class="title">Vị trí đã ứng tuyển</h3>
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 25%;">Vị trí ứng tuyển</th>
                            <th class="th-sm">Thời gian ứng tuyển</th>
                            <th class="th-sm">Hồ sơ ứng tuyển</th>
                            <th class="th-sm">Trạng thái hồ sơ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#" target="_blank">Nhân viên thiết kế đồ họa</a></td>
                            <td>
                                30/10/2019 08:37
                            </td>
                            <td>
                                <a href="#" download="">Hồ sơ</a>
                            </td>
                            <td>Đã tiếp nhận</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
@endsection
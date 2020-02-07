@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="library">
                <h3 class="title">Danh sách tệp</h3>
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 25%;">Tên tài liệu</th>
                            <th class="th-sm">Lần tải gần nhất</th>
                            <th class="th-sm">Loại văn bản</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <ul>
                                    <li><a href="{{ route('client.detail_history_download') }}">Home_V2_Layout.jpg</a></li>
                                    <li><a href="{{ route('client.detail_history_download') }}">Contact_Layout.png</a></li>
                                </ul>
                            </td>
                            <td>29/10/2019 07:15</td>
                            <td>Văn bản hành chính</td>
                        </tr>
                        <td>
                            <a href="{{ route('client.detail_history_download') }}">Detail_Page_Layout.jpg</a>
                        </td>

                        <td>
                            29/10/2019 07:15
                        </td>
                        <td>
                            Văn bản pháp luật
                        </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
@endsection
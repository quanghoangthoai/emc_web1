@extends('Client::layouts.default')

@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="list-ticket">
                <h3 class="title">Danh sách yêu cầu hỗ trợ</h3>
                <div class="text-right mb-3">
                    <a style="padding:8px 10px !important;min-width: 112px;" href="{{ route('client.add_ticket') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tạo yêu cầu</a>
                </div>
                @if (isset($listTicket) && count($listTicket))
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">STT</th>
                            <th class="th-sm">Tiêu đề</th>
                            <th class="th-sm">Dịch vụ</th>
                            <th class="th-sm">Ngày khởi tạo</th>
                            <th class="th-sm">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listTicket as $key => $iTick)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><a href="{{ route('client.detail_ticket',$iTick['id']) }}">{{ $iTick['title'] }}</a></td>
                            <td><a href="{{ route('client.detail_ticket',$iTick['id']) }}">{{ mod_ticket_get_name_product($iTick['product_id']) }}</a></td>
                            <td><a href="{{ route('client.detail_ticket',$iTick['id']) }}">{{ date('H:i:s d/m/Y', strtotime($iTick['created_at'])) }}</a></td>
                            <td><a href="{{ route('client.detail_ticket',$iTick['id']) }}">{!! mod_ticket_get_html_status_customer($iTick['status']) !!}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">Chưa có yêu cầu hỗ trợ nào</div>
                @endif
            </section>
        </div>
    </div>
</main>
@endsection
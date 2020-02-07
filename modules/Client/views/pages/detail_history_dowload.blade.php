@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-library">
                <!-- <h3 class="title">Danh sách tệp đã tải lên</h3> -->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Nội dung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Tải tệp tin</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">1</div>
                    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">2</div>
                    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">3</div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
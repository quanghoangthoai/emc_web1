@extends('Web::layouts.home')

@section('page_content')
<nav aria-label="breadcrumb" class="text-center">
    <div id="breadcrumb">
        <h1>DỊCH VỤ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dịch vụ</li>
        </ol>
    </div>
</nav>
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-service">
                <div class="container">
                    <header class="text-center">
                        <h3>{{ $service['name'] }}</h3>
                        <P>{{ $service['description'] }}</P>
                    </header>
                    {!! $service['content'] !!}
                </div>
            </section>
            <section id="comment">
                @include('Comment::admin.comment.comment')
            </section>
        </div>
    </div>
</main>
@endsection
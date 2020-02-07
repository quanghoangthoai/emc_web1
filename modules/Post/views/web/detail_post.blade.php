@extends('Web::layouts.' . cms_layout_view('detail_post', 'Post'))

@section('breadcrums')
<nav aria-label="breadcrumb" class="text-center">
    <div id="breadcrumb">
        <h1> {{ $post['title'] }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('executeSlug', $post->category['slug']) }}"> {{ $post->category['title'] }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}}</li>
        </ol>
    </div>
</nav>
@endsection

@section('page_content')
<section id="detail-blog">
    <article>
        <header>
            <h3>
                {{ $post->title }}
            </h3>
            <div class="time-view">
                <span><i class="far fa-clock"></i> {{ date('d/m/Y', strtotime($post['created_at'])) }}</span>
                <span><i class="far fa-eye"></i> {{ number_format($post['totalhits']) }}</span>
            </div>
        </header>
        <div class="blog-content">
            {!! $post['content'] !!}
        </div>
    </article>
</section>
<section id="comment">
    @include('Comment::admin.comment.comment')
</section>
@endsection

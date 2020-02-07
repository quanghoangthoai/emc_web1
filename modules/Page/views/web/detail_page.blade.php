@extends('Web::layouts.main')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <header class="entry-header pt-3">
                <h1 class="entry-title">{{ $page['title'] }}</h1>
            </header>
            <section id="contact" class="pb-5">
                {!! $page['content'] !!}
            </section>
        </div>
    </div>
</main>
@endsection

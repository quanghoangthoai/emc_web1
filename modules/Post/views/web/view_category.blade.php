@extends('Web::layouts.home')
@section('page_content')
<nav aria-label="breadcrumb" class="text-center">
    <div id="breadcrumb">
        <h1>{{ $category->title }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
    </div>
</nav>
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            {{-- <section id="blog-top">
                <div class="row listpost">
                    <div class="left col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <article class="item">

                            <div class="image">
                                <figure>
                                    <a href="detail-blog.html">
                                        <img alt="anh" src="assets/images/hay-den-voi-chung-toi-emc.jpg">
                                    </a>
                                </figure>
                            </div>
                            <div class="content">
                                <div class="title">
                                    <h5> <a href="detail-blog.html">[THÔNG BÁO] Thay đổi email theo tên miền mới EMC.VN</a></h5>
                                </div>
                                <div class="des">
                                    <p>
                                        Quy định mới về đăng ký doanh nghiệpn 11:01 16/10/2017 115917 Từ ngày 10/10/2018, hộ kinh doanh có thể chuyển thẳng lên doanh nghiệp, địa điểm kinh doanh của doanh nghiệp cũng có thể ở ngoài địa chỉ đăng ký trụ sở chính. Bãi bỏ quy định doanh nghiệp chỉ được lập địa điểm kinh doanh tại tỉnh...
                                    </p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="right col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <article class="item">
                            <div class="image">
                                <figure>
                                    <a href="detail-blog.html">
                                        <img alt="anh" src="assets/images/hay-den-voi-chung-toi-emc.jpg">
                                    </a>
                                </figure>
                            </div>
                            <div class="content">
                                <h5>
                                    <a href="detail-blog.html">EMC- văn hóa nghỉ dưỡng và đào tạo</a>
                                </h5>
                                <div class="des">
                                    Quy định mới về đăng ký doanh nghiệpn 11:01 16/10/2017 115917 Từ ngày 10/10/2018, hộ kinh doanh có thể chuyển thẳng lên doanh nghiệp, địa điểm kinh doanh của doanh nghiệp cũng có thể ở ngoài địa...
                                </div>
                            </div>
                        </article>
                        <article class="item">
                            <div class="image">
                                <figure>
                                    <a href="detail-blog.html">
                                        <img alt="anh" src="assets/images/hay-den-voi-chung-toi-emc.jpg">
                                    </a>
                                </figure>
                            </div>
                            <div class="content">
                                <h5>
                                    <a href="detail-blog.html">Những quy định cần biết của luật thuế 2019</a>
                                </h5>
                                <div class="des">
                                    Quy định mới về đăng ký doanh nghiệpn 11:01 16/10/2017 115917 Từ ngày 10/10/2018, hộ kinh doanh có thể chuyển thẳng lên doanh nghiệp, địa điểm kinh doanh của doanh nghiệp cũng có thể ở ngoài địa...
                                </div>
                            </div>
                        </article>
                        <article class="item">
                            <div class="image">
                                <figure>
                                    <a href="detail-blog.html">
                                        <img alt="anh" src="assets/images/hay-den-voi-chung-toi-emc.jpg">
                                    </a>
                                </figure>
                            </div>
                            <div class="content">
                                <h5>
                                    <a href="detail-blog.html">Những quy định cần biết của luật thuế 2019</a>
                                </h5>
                                <div class="des">
                                    Quy định mới về đăng ký doanh nghiệpn 11:01 16/10/2017 115917 Từ ngày 10/10/2018, hộ kinh doanh có thể chuyển thẳng lên doanh nghiệp, địa điểm kinh doanh của doanh nghiệp cũng có thể ở ngoài địa...
                                </div>
                            </div>
                        </article>
                      
                    </div>
                </div>
            </section> --}}
            <div class="row mt-3">
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <section id="blog-bottom">
                        <div class="title">
                            <h3><span>{{ $category->title }}</span></h3>
                        </div>
                        <div class="most-read">
                            @foreach ($listPosts as $iPost)
                            <article class="row-most-read">
                                <div class="image">
                                    <figure class="image-mread">
                                        <a href="{{ route('mod_post.web.detail_post', $iPost['slug']) }}"><img src="{{ get_img_src($iPost['image']) }}" alt="{{ $iPost['title'] }}"></a>
                                    </figure>
                                </div>
                                <div class="content">
                                    <div class="mread">
                                        <div class="title-mread">
                                            <h5>
                                                <a href="{{ route('mod_post.web.detail_post', $iPost['slug']) }}">{{ $iPost['title'] }}</a>
                                            </h5>

                                        </div>
                                        <div class="timeview">
                                            <span><i class="far fa-clock"></i> {{ date('H:i d/m/Y', strtotime($iPost['created_at'])) }}</span>
                                            <span><i class="far fa-eye"></i> {{ number_format($iPost['totalhits']) }}</span>
                                        </div>
                                        <div class="description">
                                            <p>
                                                {!! $iPost['description'] !!}
                                            </p>
                                        </div>
                                        <a href="{{ route('mod_post.web.detail_post', $iPost['slug']) }}" class="detail">Xem chi tiết</a>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                            {{ $listPosts->links() }}
                        </div>
                    </section>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <aside class="sidebar">
                        <div class="widget form-group form-search">
                            <form action="" name="" method="">
                                <input type="text" class="form-control input" placeholder="Nhập từ khoá cần tìm">
                                <button type="button" class="btn btn-primary btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="widget categories">
                            <h3><span>CHUYÊN MỤC TIN</span></h3>
                            <ul class="list-item">
                                <li class="item">
                                    <a href="">
                                        <i class="far fa-file-alt"></i> Hỗ trợ doanh nghiệp
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="">
                                        <i class="far fa-file-alt"></i> Tin công ty
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget most-read">
                            <h3><span>ĐỌC NHIỀU NHẤT</span></h3>
                            <ul class="list-item">
                                <li class="item">
                                    <div class="image">
                                        <figure>
                                            <img src="assets/images/hay-den-voi-chung-toi-emc.jpg" alt="anh">
                                        </figure>
                                    </div>
                                    <div class="content">
                                        <a href="detail-post.html">Quy định quan trọng về trích lập các khoản dự phòng</a>
                                        <div class="time-view">
                                            <span><i class="far fa-clock"></i> 16/10/2017</span>
                                            <span><i class="far fa-eye"></i> 115917</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="image">
                                        <figure>
                                            <img src="assets/images/hay-den-voi-chung-toi-emc.jpg" alt="anh">
                                        </figure>
                                    </div>
                                    <div class="content">
                                        <a href="detail-post.html">Quy định quan trọng về trích lập các khoản dự phòng</a>
                                        <div class="time-view">
                                            <span><i class="far fa-clock"></i> 16/10/2017</span>
                                            <span><i class="far fa-eye"></i> 115917</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="image">
                                        <figure>
                                            <img src="assets/images/hay-den-voi-chung-toi-emc.jpg" alt="anh">
                                        </figure>
                                    </div>
                                    <div class="content">
                                        <a href="detail-post.html">Quy định quan trọng về trích lập các khoản dự phòng</a>
                                        <div class="time-view">
                                            <span><i class="far fa-clock"></i> 16/10/2017</span>
                                            <span><i class="far fa-eye"></i> 115917</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="image">
                                        <figure>
                                            <img src="assets/images/hay-den-voi-chung-toi-emc.jpg" alt="anh">
                                        </figure>
                                    </div>
                                    <div class="content">
                                        <a href="detail-post.html">Quy định quan trọng về trích lập các khoản dự phòng</a>
                                        <div class="time-view">
                                            <span><i class="far fa-clock"></i> 16/10/2017</span>
                                            <span><i class="far fa-eye"></i> 115917</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="image">
                                        <figure>
                                            <img src="assets/images/hay-den-voi-chung-toi-emc.jpg" alt="anh">
                                        </figure>
                                    </div>
                                    <div class="content">
                                        <a href="detail-post.html">Quy định quan trọng về trích lập các khoản dự phòng</a>
                                        <div class="time-view">
                                            <span><i class="far fa-clock"></i> 16/10/2017</span>
                                            <span><i class="far fa-eye"></i> 115917</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="widget categories">
                            <h3><span>THƯ VIỆN EMC</span></h3>
                            <ul class="list-item">
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Chiến lược (9)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Kỹ năng (6)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Cuộc sống (25)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Luật (3)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Kế toán (10)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> kiểm toán (11)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Luật thuế (05)</a>
                                </li>
                                <li class="item">
                                    <a href=""><i class="far fa-file-alt"></i> Đầu tư (16)</a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
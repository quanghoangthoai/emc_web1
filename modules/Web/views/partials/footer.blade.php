<footer>
    <div class="support">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                    <a href="tel:123456789" title="Support 24/7">
                        <div class="d-flex flex-row">
                            <div class="icon"><img src="{{ asset('assets/web/images/phone-call.svg') }}" alt="24/7"></div>
                            <div class="content align-self-center">
                                <label>Hỗ trợ 24/7</label>
                                <p>0258 351 2222</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                    <a href="tel:123456789" title="Kinh Doanh">
                        <div class="d-flex flex-row">
                            <div class="icon"> <img src="{{ asset('assets/web/images/customer-service.svg') }}" alt="24/7"></div>
                            <div class="content align-self-center">
                                <label>Kinh Doanh</label>
                                <p>091 2345 222</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                    <a href="tel:123456789" title="Hotline">
                        <div class="d-flex flex-row">
                            <div class="icon"><img src="{{ asset('assets/web/images/telephone.svg') }}" alt="24/7"></div>
                            <div class="content align-self-center">
                                <label>HOTLINE</label>
                                <p>0916 676 878</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-services">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <h2>EMC</h2>
                    <ul>
                        <li>
                            <a href="about.html">Giới thiệu</a>
                        </li>
                        <li>
                            <a href="contact.html">Liên hệ</a>
                        </li>
                        <li>
                            <a href="#">Nhận báo giá</a>
                        </li>
                        <li>
                            <a href="library.html">Thư viện</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <h2>Thông tin cần biết</h2>
                    <ul>
                        <li>
                            <a href="#">Thỏa thuận sử dụng</a>
                        </li>
                        <li>
                            <a href="#">Thỏa thuận bảo mật thông tin</a>
                        </li>
                        <li>
                            <a href="#">Hướng dẫn thanh toán</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <h2>Câu hỏi thường gặp</h2>
                    <ul>
                        <li>
                            <a href="#">Cách tạo yêu cầu hỗ trợ</a>
                        </li>
                        <li>
                            <a href="#">Lưu ý khi đặt tên công ty</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <h2>Tin tức</h2>
                    <ul>
                        <li>
                            <a href="#">Tin hỗ trợ doanh nghiệp</a>
                        </li>
                        <li>
                            <a href="blog.html">Tin công ty</a>
                        </li>
                        <li>
                            <a href="recruitment.html">Tin tuyển dụng</a>
                        </li>
                        <li>
                            <a href="#">Hiểu về trái tim</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="address">
                <h6>TRỤ SỞ CHÍNH</h6>
                <p>62 Yesin, Phường Phương Sài, Thành phố Nha Trang, Tỉnh Khánh Hòa, Việt Nam</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="item">
                        <p>Copyright © EMC. All Reserved.</p>
                        <p>Sử dụng nội dung ở trang này và dịch vụ tại EMC có nghĩa là bạn đồng ý với <a href="#">Thỏa thuận sử dụng</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi.</p>
                        <p>Công ty Tư Vấn Quản Lý Doanh Nghiệp - Giấy phép kinh doanh số: 4201 172 253 cấp ngày 02/09/2009 bởi Sở Kế Hoạch và Đầu Tư Tp. Nha Trang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="hotline-phone-ring-wrap">
    <div class="hotline-phone-ring">
        <div class="hotline-phone-ring-circle"></div>
        <div class="hotline-phone-ring-circle-fill"></div>
        <div class="hotline-phone-ring-img-circle">
            <a id="show-contact" href="javascript:void(0);" class="pps-btn-img">
                <img src="https://nguyenhung.net/wp-content/uploads/2019/05/icon-call-nh.png" alt="Gọi điện thoại" width="50">
            </a>
        </div>
    </div>
</div>
<div id="cart-scroll">
    <a href="{{ route('mod_request.web.view-cart') }}">
        <img src="{{ asset('assets/web/images/icon-cart-only.svg') }}" width="40" alt="gio hang">
        <span class="badge badge-1" id="amount">4</span>
    </a>
</div>
<a id="button-to-top">
    <i class="fa fa-chevron-up" aria-hidden="true"></i>
</a>
<div id="float-contact">
    <button class="hotline-1"> <a href="tel:0916676878"><small>HOTLINE:</small> <strong>0916 676 878</strong></a>
    </button>
    <button class="hotline-2">
        <a href="tel:0912345222"><small>KINH DOANH:</small> <strong>091 2345 222</strong></a>
    </button>
    <button class=" hotline-3">
        <a href="tel:02583512222"><small>HỖ TRỢ 24/7:</small> <strong>0258 351 2222</strong></a>
    </button>
</div>
<div id="fixed-social">
    <div>
        <a href="#" class="fixed-facebook toggle" target="_blank"><i class="fab fa-facebook"></i> <span>Facebook</span></a>
    </div>
    <div>
        <a href="#" class="fixed-twitter toggle" target="_blank"><i class="fab fa-twitter"></i> <span>Twitter</span></a>
    </div>
    <div>
        <a href="#" class="fixed-gplus toggle" target="_blank"><i class="fab fa-google"></i> <span>Google+</span></a>
    </div>
    <div>
        <a href="#" class="fixed-linkedin toggle" target="_blank"><i class="fab fa-linkedin"></i> <span>LinkedIn</span></a>
    </div>
    <div>
        <a href="#" class="fixed-instagrem toggle" target="_blank"><i class="fab fa-instagram"></i> <span>Instagram</span></a>
    </div>
    <div id="js-toggleShowHidden">
        <a class="fixed-share"><i class="fas fa-share-alt"></i> </a>
    </div>

</div>

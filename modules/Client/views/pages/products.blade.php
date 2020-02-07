@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="list-services">
                <div class="tab-list">
                    <div class="d-flex flex-row">
                        <ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
                            <li class="nav-item">
                                <a href="#product" class="nav-link active" data-toggle="tab" role="tab" aria-controls="all">Tư vấn pháp lý</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product1" class="nav-link" data-toggle="tab" role="tab" aria-controls="naptien">Dịch vụ kế toán</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product2" class="nav-link " data-toggle="tab" role="tab" aria-controls="thanhtoan">Tuyển dụng nhân sự</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product3" class="nav-link " data-toggle="tab" role="tab" aria-controls="thanhtoan">Tư vấn quản lý</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product4" class="nav-link " data-toggle="tab" role="tab" aria-controls="thanhtoan">Thiết lập bộ máy quản lý</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product5" class="nav-link " data-toggle="tab" role="tab" aria-controls="thanhtoan">Tái cấu trúc doanh nghiệp</a>
                            </li>
                        </ul>
                        <div class="tab-content w-100 services">
                            <div class="tab-pane fade show active" id="product" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product1" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product2" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product3" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product4" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product5" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-uppercase text-center">Gói cơ bản</h5>
                                                <h6 class="card-price text-center"><span class="price">1.200.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-muted text-uppercase text-center">Gói nâng cao</h5>
                                                <h6 class="card-price text-center"><span class="price">5.000.000đ</span><span class="period">/tháng</span></h6>
                                                <hr>
                                                <ul class="fa-ul text-center">
                                                    <li>Single User</li>
                                                    <li>5GB Storage</li>
                                                    <li>Unlimited Public Projects</li>
                                                    <li>Community Access</li>
                                                    <li>Unlimited Private Projects</li>
                                                    <li>Dedicated Phone Support</li>
                                                    <li>Free Subdomain</li>
                                                    <li>Monthly Status Reports</li>
                                                </ul>
                                                <a href="#" class="btn btn-block btn-primary text-uppercase">Đặt ngay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
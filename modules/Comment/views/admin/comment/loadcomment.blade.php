
<h3 class="title">Bình luận</h3>
<div class="comment-area">
    <div class="col-lg-12 reply">
        @if (auth('web')->id() == null)
        <div class="alert alert-primary" role="alert">
            Quý khách vui lòng <button type="button" class="p-0" data-toggle="modal" data-target="#login-apply">đăng nhập</button> để tham gia bình luận. Nếu chưa có tài khoản <button type="button" class="p-0" data-toggle="modal" data-target="#registration">đăng ký tại đây</button>.
        </div>
        @else
        <div id="formComment">
            <div class="form-group">
                <textarea class="form-control" id="body" name="body" placeholder="Viết bình luận..."></textarea>
                <input type="hidden" id="post_id" name="post_id" value="{{ $post_id }}" />
                <input type="hidden" id="post_link" name="post_link" value="{{ isset($link) ? base64_decode($link) : '' }}" />
                <input type="hidden" id="module_id" name="module_id" value="{{ isset($module_id) ? $module_id : '' }}" />
                <div class="d-flex">
                    <div class="align-self-center">

                    </div>
                    <div class="flex-grow-1 text-right">
                        <button type="submit" class="btn btn-primary btn-reply">Gửi</button>

                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <ul class="listComment">
        @if (isset($comments) && count($comments))
        @foreach($comments as $comment)
        @if ($comment->parent_id == null)
        <li>
            <div class="info-user">
                <div class="d-flex flex-row">
                    <div class="image">
                        <img src="https://scontent.fdad3-1.fna.fbcdn.net/v/t1.0-9/68950821_1065451293653168_7660483538633883648_n.jpg?_nc_cat=110&_nc_oc=AQnqBp9pSxlDgMu-ghZ9ef7knqLBIla9RgPz-9rpk5f98kM7bsgeHj8XU1gDAF6VHsYAAsPXow3Enx3zZ4Rx29IG&_nc_ht=scontent.fdad3-1.fna&oh=c626a5d552b09bcf684d93d3bf87b83c&oe=5E517B5C" id="imageuser">
                    </div>
                    <div class="align-self-center pl-2">
                        <span class="name">
                            {{ user_display_name($comment->user_id) }}
                        </span>
                        <span class="time">{{ cms_time_elapsed_string($comment->created_at) }}</span>
                        <input type="hidden" id="{{ 'user_id'.$comment->id }}" value="{{ user_display_name($comment->user_id) }}" />
                    </div>
                </div>
            </div>
            <div class="question">
                {!! $comment->body !!}
            </div>
            <div class="replybutton btn4 like">
                <span class="btn" id="replyb"><a style="text-decoration: none" data-user="{{ $comment->id }}" data-id="{{ $comment->id }}" href="{{ '#collapsible-comment'.$comment->id }}" data-toggle="collapse" class="text-default collapsed"><i class="far fa-comment-dots mr-2"></i>Trả lời</a></span>
            </div>
            <ul style="display: {{ (count($comment->replies) == 0) ? 'none' : '' }}">
                @foreach ($comments as $iCom)
                @if ($iCom->parent_id == $comment->id)
                <li>
                    <div class="info-user">
                        <div class="d-flex flex-row">
                            <div class="image">
                                <img src="https://scontent.fdad3-3.fna.fbcdn.net/v/t1.0-9/72915906_1112518872279743_9029896164035526656_n.jpg?_nc_cat=109&_nc_oc=AQk1XBdX3eABNeLpJQUz-Hv3IACI7NxvkSjxUopCTVatMxt-0zBbZrb3X_SFcMgABFZGdY9y1UyHFtVbB8Topy3M&_nc_ht=scontent.fdad3-3.fna&oh=ac7f54ee4f1addc208b887a37e6ba83c&oe=5E5B967A" id="imageuser_parent">
                            </div>
                            <div class="align-self-center pl-2">
                                <span class="name">{{ user_display_name($iCom->user_parent_id) }}</span>
                                <input type="hidden" id="{{ 'user_id'.$iCom->id }}" value="{{ user_display_name($iCom->user_parent_id) }}" />
                                <span class="time">{{ cms_time_elapsed_string($iCom->created_at) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="question">{!! $iCom->body !!}</div>
                    <div class="replybutton btn4 like">
                        <span class="btn" id="replyb"><a style="text-decoration: none" data-user="{{ $iCom->id }}" data-id="{{ $iCom->parent_id }}" href="{{ '#collapsible-comment'.$iCom->parent_id }}" data-toggle="collapse" class="text-default collapsed"><i class="far fa-comment-dots mr-2"></i>Trả lời</a></span>
                    </div>
                </li>
                @endif
                @endforeach
            </ul>
        </li>
        @else
        {{ '' }}
        @endif
        <div id="{{ 'collapsible-comment'.$comment->id }}" class="collapse">
            <div class="form-group" id="formComment">
                <textarea class="form-control" id="{{ 'body_parent'.$comment->id }}" name="body_parent" placeholder="Viết trả lời..."></textarea>
                <div class="d-flex">
                    <div class="align-self-center">

                    </div>
                    <div class="flex-grow-1 text-right">
                        <button data-id="{{ $comment->id }}" type="submit" class="btn btn-primary btn-reply-parent">Gửi</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="info text-info">Chưa có bình luận nào hoặc chức năng bình luận đã bị tắt.</div>
        @endif
    </ul>
</div>
{{-- modal --}}
<div class="modal fade" id="login-apply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <section id="login-form">
                    <div class="row">
                        <div class="col-xs-12 col-flogin">
                            <div class="wrap-login100">
                                <div class="login100-form validate-form">
                                    <figure class="text-center">
                                        <img src="assets/web/images/logo-emc.png" alt="EMC" style="width:50%">
                                    </figure>
                                    <span class="login100-form-title">
                                        Đăng nhập
                                    </span>
                                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                                        <input class="input100" type="text" id="username" name="username" placeholder="Tài khoản">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                                        <input class="input100" type="password" id="password" name="password" placeholder="Mật khẩu">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_remember" id="is_remember">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Ghi nhớ mật khẩu.
                                        </label>
                                    </div>
                                    <div class="container-login100-form-btn">
                                        <span id="resultLoginMessage" class="mt-1 mb-1" style="display:none;"></span>
                                        <button class="login100-form-btn" id="btn-login-comment">
                                            Đăng nhập
                                        </button>
                                    </div>
                                    <div class="text-center p-t-12">
                                        <span class="txt1">
                                            Quên
                                        </span>
                                        <a class="txt2" href="javascript:void(0);" data-toggle="modal" data-target="#forgotpassword" data-dismiss="modal">
                                            Tài Khoản / Mật khẩu?
                                        </a>
                                    </div>
                                    <hr>
                                    <div class="text-center p-t-221">
                                        <p>Đăng nhập bằng mạng xã hội - <span style="color: #ed3237; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Dành cho thành viên đã kết nối ID với Google hoặc Facebook">Lưu ý</span></p>

                                    </div>
                                    <div class="login-social">
                                        <a href="#" class="lg-facebook">
                                            <span><i class="fab fa-facebook-f"></i>Facebook</span>
                                        </a>
                                        <a href="#" class="lg-google">
                                            <span><i class="fab fa-google"></i>Google</span>
                                        </a>
                                    </div>
                                    <div class="text-center p-t-136">
                                        <a class="txt2" href="javascript:void(0);" data-toggle="modal" data-target="#registration" data-dismiss="modal">
                                            Tạo tài khoản mới <span><i class="fas fa-long-arrow-alt-right"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <section id="login-form">
                    <div class="row">
                        <div class="col-xs-12 col-flogin">
                            <div class="wrap-login100">
                                <form class="login100-form validate-form" action="" method="" name="">
                                    <figure class="text-center">
                                        <img src="assets/web/images/logo-emc.png" alt="EMC" style="width:50%">
                                    </figure>
                                    <span class="login100-form-title">
                                        Đăng ký tài khoản
                                    </span>
                                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                                        <input class="input100" type="text" name="" placeholder="Họ và tên" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                                        <input class="input100" type="email" name="" placeholder="Email" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="wrap-input100 validate-input" data-validate="Phone username is required">
                                        <input class="input100" type="text" name="" placeholder="Số điện thoại" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fas fa-phone-alt"></i>
                                        </span>
                                    </div>
                                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                                        <input class="input100" type="password" name="pass" placeholder="Mật khẩu" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                                        <input class="input100" type="password" name="pass" placeholder="Nhập lại mật khẩu" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required="required">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Tôi đồng ý với các <a href="#">điều khoản</a> và <a href="#">chính sách bảo mật</a>.
                                        </label>
                                    </div>
                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn">
                                            Đăng ký
                                        </button>
                                    </div>
                                    <div class="text-center p-t-12 p-t-136">
                                        <span class="txt1">
                                            Đã có tài khoản?
                                        </span>
                                        <a class="txt2" href="javascript:void(0);" data-toggle="modal" data-target="#login-apply" data-dismiss="modal">
                                            Đăng nhập
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="forgotpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <section id="login-form">
                    <div class="row">
                        <div class="col-xs-12 col-flogin">
                            <div class="wrap-login100">
                                <form class="login100-form validate-form" action="" method="" name="">
                                    <figure class="text-center">
                                        <img src="assets/web/images/logo-emc.png" alt="EMC" style="width:50%">
                                    </figure>
                                    <span class="login100-form-title">
                                        Khôi phục mật khẩu
                                    </span>
                                    <p>
                                        <div class="alert alert-info" role="alert">
                                            Vui lòng nhập địa chỉ Email đăng ký tài khoản. <br>
                                            Mật khẩu mới sẽ được gửi cho quý khách qua Email!
                                        </div>
                                    </p>
                                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                                        <input class="input100" type="text" name="" placeholder="Nhập Email" required="required">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn">
                                            Khôi phục mật khẩu
                                        </button>
                                    </div>
                                    <div class="text-center p-t-136">
                                        <a class="txt2" href="javascript:void(0);" data-toggle="modal" data-target="#login-apply" data-dismiss="modal">
                                            <i class="fas fa-long-arrow-alt-left"></i>
                                            Quay về trang Đăng nhập
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}
{{-- modal error--}}
<button type="button" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="showModel">Open Modal</button>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center" style="color: red">
                    <h4><strong>Chưa đăng nhập hoặc chức năng bình luận đã bị tắt.</strong></h4>
                </div>
            </div>
            <div class="text-center" style="padding-bottom: 10px;">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
    var _token = '{{ csrf_token() }}';
        function load_comment()
        {
            var check_tags = false;
            $('.btn-reply').on('click', function(){
                $.ajax({
                    type:'POST',
                    url:"{{ route('mod_comment.web.post_comment') }}",
                    data: {
                        _token: _token,
                        id: $(this).data('id'),
                        post_id: $("#post_id").val(),
                        module_id: $("#module_id").val(),
                        post_link: $("#post_link").val(),
                        body: $("#body").val()
                    },
                    dataType: 'JSON',
                    success:function(res) {
                        if (res.status) {
                            $("#body").val('');
                            $('#comment').load('{{ route('mod_comment.web.loadcomment',['id'=>$post_id,'module'=>$module,'link'=>$link]) }}')
                        } else {
                            console.log('Error');
                            $("#showModel").click();
                        }
                    }
                });
            });

            // reply parent
            $('.btn-reply-parent').click(function(){

                var parent = "#body_parent" + $(this).data('id');
                $.ajax({
                    type:'POST',
                    url:"{{ route('mod_comment.web.post_comment_parent') }}",
                    data: {
                        _token: _token,
                        id: $(this).data('id'),
                        body_parent: $(parent).val()
                    },
                    dataType: 'JSON',
                    success:function(res) {
                        if (res.status) {
                            $("#body_parent").val('');
                            $('#comment').load('{{ route('mod_comment.web.loadcomment',['id'=>$post_id,'module'=>$module,'link'=>$link]) }}')
                        } else {
                            console.log('Error');
                            $("#showModel").click();
                        }
                    }
                });
            });
        }
        $(document).ready(function(){
            load_comment();
        });
</script>
<script>
    var _token = '{{ csrf_token() }}';
    $(document).ready(function(){
        $('#btn-login-comment').click(function(){
                $.ajax({
                    type:'POST',
                    url:"{{ route('mod_comment.web.post_login') }}",
                    data: {
                        _token: _token,
                        username: $('#username').val(),
                        password: $('#password').val(),
                        is_remember: $('#is_remember').val()
                    },
                    dataType: 'JSON',
                    success:function(res) {
                        if (res.status) {
                            $("#resultLoginMessage")
                            .removeClass("text-danger")
                            .addClass("text-success")
                            .text(res.message)
                            .slideDown(100);

                            setTimeout(() => {
                                $("#resultLoginMessage").slideUp(100);
                                window.location.reload();
                            }, 1500);
                        } else {
                            $("#resultLoginMessage")
                            .addClass("text-danger")
                            .removeClass("text-success")
                            .text(res.message)
                            .slideDown(100);

                            setTimeout(() => {
                                $("#resultLoginMessage").slideUp(100);
                            }, 1500);
                        }
                    }
                });
            });
    });
</script>

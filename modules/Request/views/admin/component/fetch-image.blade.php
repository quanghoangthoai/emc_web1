<div class="form-group">
    <label class="form-label"><strong>Hình ảnh chứng từ thanh toán</strong></label>
    <div class="thumbnail">
        <img src="{{ isset($iRequest['confirm_image']) ? $iRequest['confirm_image'] : 'http://view.dreamstalk.ca/breeze5/images/no-photo.png'}}" alt="..." id="request-thumbnail" class="img-request">
        <input type="text" value="{{ isset($iRequest['confirm_image']) ? $iRequest['confirm_image'] : ''}}" id="confirm_image_check" hidden name="confirm_image_check">
        <div class="caption">
            <button type="button" style="float:right;" data-toggle="modal" data-target="#myModal" class="btn btn-light btn-sm"><i class="fas fa-search-plus"></i></button>
        </div>
        @if(!(isset($actionType) && $actionType == 'detail'))
        {{-- <div class="input-group areaBrowserFile">

            <input type="text" hidden id="request-image" class="form-control" name="confirm_image" value="{{ isset($iRequest['confirm_image']) ? $iRequest['confirm_image'] : '' }}">
        <div class="btn-group" style="width: 100%;">
            <a class="btn btn-secondary btn-sm btn-remove-file text-warning" type="button"><i class="fa fa-times"></i>Xóa ảnh</a>
            <a class="btn btn-secondary btn-sm btn-choose-file" data-id="request-image" type="button"><i class="fa fa-image mr-1"></i> Up ảnh</a>
            @if(isset($iRequest['confirm_image']))
            <a target="_blank" href="{{ route('mod_request.admin.getDownload', $iRequest['id']) }}" class="btn btn-secondary btn-sm" data-id="request-image" type="button"><i class="fa fa-download mr-1"></i> Tải ảnh</a>
            @endif

        </div>

    </div> --}}
    <div class="input-group">
        <input type="file" name="confirm_image" id="image" hidden>
        <input type="checkbox" id="change_image_flag" hidden name="change_image_flag" value=1>
        <div class="btn-group" style="width: 100%;">
            <a class="btn btn-dark legitRipple btn-sm" href="javascript:removeImage()" type="button"><i class="fa fa-times"></i>Xóa ảnh</a>
            <a class="btn btn-dark legitRipple btn-sm" href="javascript:changeProfile()" data-id="request-image" type="button"><i class="fa fa-image mr-1"></i> Up ảnh</a>
            @if(isset($iRequest['confirm_image']))
            <a target="_blank" href="{{ route('mod_request.admin.getDownload', $iRequest['id']) }}" class="btn btn-dark legitRipple btn-sm" data-id="request-image" type="button"><i class="fa fa-download mr-1"></i> Tải ảnh</a>
            @endif
        </div>
    </div>
    @endif
</div>
<div class="text-center">
    <i>File là hình ảnh, dung lượng tối đa 2mb</i>
</div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img id="request-thumbnail-modal" src="{{ isset($iRequest['confirm_image']) ? $iRequest['confirm_image'] : 'http://view.dreamstalk.ca/breeze5/images/no-photo.png' }}" class="img-responsive">
            </div>
        </div>
    </div>
</div>
<script>
    // $('#request-image').change(function(){
    //     var path = $(this).val();
    //     checkImageExist('request-thumbnail', path)
    // });
    // function checkImageExist(tagID, path){
    //     if(path != ''){
    //         $("#" + tagID).attr("src",path);
    //         $("#" + tagID + '-modal').attr("src",path);

    //     }       
    //     else{
    //         $("#" + tagID).attr("src",'http://view.dreamstalk.ca/breeze5/images/no-photo.png');
    //         $("#" + tagID + '-modal').attr("src",'http://view.dreamstalk.ca/breeze5/images/no-photo.png');
    //     }    
    // }
    function changeProfile() {
        $('#image').click();
    }
    $('#image').change(function () {
        $('#change_image_flag').attr('checked', true);
        var imgPath = this.value;
        var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
            readURL(this);
        else
            alert("Xin chọn file là hình ảnh (jpg, jpeg, png).")
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                $('#request-thumbnail').attr('src', e.target.result);
                $('#request-thumbnail-modal').attr('src', e.target.result);
                $('#confirm_image_check').val(e.target.result);
                //$("#remove").val(0);
            };
        }
    }
    function removeImage() {
        $('#change_image_flag').attr('checked', true);
        $('#request-thumbnail').attr('src', 'http://view.dreamstalk.ca/breeze5/images/no-photo.png');
        $('#confirm_image_check').val('');
        $('#image').val(null);
//      $("#remove").val(1);
    }
</script>
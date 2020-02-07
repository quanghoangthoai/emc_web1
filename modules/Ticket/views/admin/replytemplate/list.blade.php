@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-ticket-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu hỗ trợ</span> - Mẫu phản hồi</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <div class="row">
        <div class="col-xl-7">
            @include('Ticket::admin.replytemplate.component_add')
        </div>
        <div class="col-xl-5">
            @include('Ticket::admin.replytemplate.component_list')
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    function change_order(el)
    {
        var id = $(el).data('id');
        var order = $(el).val();
        // call ajax to chang order
        $(document).find('.changOrder').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('mod_ticket.admin.ajaxChangeOrderReplyTemplate') }}",
            data: {
                _token: _token,
                id: id,
                order: order
            },
            dataType: 'JSON',
            success: function(data) {
                window.location.reload();
            }
        });
    }
    
</script>
{{-- load ckeditor --}}
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })

    });
</script>
@endsection
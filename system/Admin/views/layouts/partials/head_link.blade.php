<!-- Global stylesheets -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/admin/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/components.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/colors.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/noty.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/admin/css/dev.custom.css') }}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<!-- Core JS files -->
<script src="{{ asset('assets/admin/js/main/jquery.min.js') }}"></script>

<script>
    var _token = '{{ csrf_token() }}';
    var app_url = '{{ config("app.url") }}';
    var notification_url_load = "{{ route('cms.ajax.loadNotification') }}";
    @if (in_array('Product', $active_modules))
    var url_ajax_modal_product = "{{ route('mod_product.ajax.loadModalInsertContent') }}";
    @endif
</script>

<li class="header"><strong>Thông báo</strong> <a href="javascript:;" class="mark-read-all" onclick="notify_mark_read_all();return false;">Đánh dấu đã xem tất cả</a></li>
<li>
    <ul class="menu">
        @if (count($listNotifications) > 0)
        @foreach ($listNotifications as $notify)
        @if (empty($notify['read_at']))
        <li class="new">
            <a href="javasscript:;" data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;">
                {!! $notify['data']['message'] !!}
                <br>
                <small class="timer"><i class="fa fa-clock-o"></i>
                    {{ cms_time_elapsed_string($notify['created_at']) }}</small>
            </a>
        </li>
        @else
        <li>
            <a href="javasscript:;" data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;">
                {!! $notify['data']['message'] !!}
                <br>
                <small class="timer"><i class="fa fa-clock-o"></i>
                    {{ cms_time_elapsed_string($notify['created_at']) }}</small>
            </a>
        </li>
        @endif
        @endforeach
        @else
        <p style="margin: 0;padding: 10px;text-align: center;font-size:12px;font-style:italic;">Chưa có thông báo</p>
        @endif
    </ul>
</li>
<li class="footer"><a href="{{ route('cms.admin.list_notification') }}">Xem tất cả</a></li>

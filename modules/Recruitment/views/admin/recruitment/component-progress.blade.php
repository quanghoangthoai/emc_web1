<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><i class="fas fa-user"></i> Tiến độ xử lý</h5>
    </div>
    <div class="card-body" id="content-progress-scroll">
        @foreach ($Progs as $iProg)
        <div class="row mb-2 propress-component">
            <div class="col-sm-1"><i class="fas fa-history"></i></div>
            <div class="col-sm-8">{!! '<b>'.$iProg['user_fullname'].'</b> phòng: '.$iProg['user_department'] .' đã ' .
                mod_recruitment_get_status($iProg['status']) !!}</div>
            <div class="col-sm-3"><span data-popup="tooltip"
                    title="{{ $iProg['created_at'] }}">{{ cms_time_elapsed_string($iProg['created_at']) }}</span></div>
            {{-- content of email --}}
            <div class="col-sm-1"></div>
            <div class="col-sm-11 content-email-text">{{mod_recruitment_str_limit($iProg['content'],50)}}</div>
        </div>
        @endforeach

    </div>
</div>
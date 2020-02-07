<div id="modalHistory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-history mr-1"></i> LỊCH SỬ YÊU CẦU</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="height: 300px; overflow-y: auto;">
                @if ($listActivity && count($listActivity))
                @foreach ($listActivity as $iAct)
                <div class="row mb-2 propress-component">
                    <div class="col-sm-1"><i class="fas fa-history"></i></div>
                    <div class="col-sm-8">
                        @if ($iAct->causer->info->department)
                        {!! '<b>'.$iAct->causer->info->fullname.'</b> phòng: '.$iAct->causer->info->department->name !!}<br>
                        @else
                        <strong>Ai đó</strong>
                        @endif

                        <span>Hành động: {!! $iAct['description'] !!} </span><br>
                        @if(isset($iAct->properties['type']))
                        @if($iAct->properties['type'] == 'status')
                        <span> {!! $iAct->properties['action'] .' '. mod_request_get_status($iAct->properties['value'])!!} </span><br>
                        @elseif($iAct->properties['type'] == 'image')
                        <span> {{ $iAct->properties['action']}}</span><br>
                        @endif
                        @if(isset($iAct->properties['note']))
                        Ghi chú: {{ $iAct->properties['note'] }}
                        @endif
                        @endif
                    </div>
                    <div class="col-sm-3"><span data-popup="tooltip" title="{{ $iAct['created_at'] }}">{{ cms_time_elapsed_string($iAct['created_at']) }}</span></div>

                    {{-- content of email --}}
                    {{-- <div class="col-sm-1"></div>
                    <div class="col-sm-11 content-email-text">{{mod_recruitment_str_limit($iAct['content'],50)}}
                </div> --}}
            </div>
            <hr>
            @endforeach
            @else
            <div class="alert alert-info">Chưa có dữ liệu.</div>
            @endif
        </div>
    </div>
</div>
</div>

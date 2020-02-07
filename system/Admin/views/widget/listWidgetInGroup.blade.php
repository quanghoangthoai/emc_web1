@foreach ($listWidget as $iWidget)
<div class="card item-widget" data-id="{{ $iWidget['id'] }}">
    <form onsubmit="submitUpdateWidget(this);return false;">
        @csrf
        <input type="hidden" name="id" value="{{ $iWidget['id'] }}">
        <div class="card-header bg-slate">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white collapsed" href="#widget-{{ $iWidget['id'] }}" aria-expanded="false">
                    {{ $iWidget['title'] }}
                </a>
            </h6>
        </div>
        <div id="widget-{{ $iWidget['id'] }}" class="collapse">
            <div class="card-body">
                <div class="form-group">
                    <em>Widget:</em> <strong>{{ config($iWidget['module'] . '::widget.web.' . $iWidget['name'] . '.title' ) }}</strong>
                </div>
                <div class="form-group">
                    <label><strong>Tiêu đề</strong></label>
                    <input name="title" type="text" class="form-control" placeholder="Nhập tiêu đề" value="{{ $iWidget['title'] }}">
                </div>
                <hr>
                <button type="submit" class="btn btn-sm btn-info">Lưu lại</button>
                <button onclick="submitDeleteWidget('{{ $iWidget['id'] }}');" type="button" class="btn btn-sm btn-link float-right"><span class="text-danger"><i class="fa fa-trash-alt"></i></span></button>
            </div>
        </div>
    </form>
</div>
@endforeach

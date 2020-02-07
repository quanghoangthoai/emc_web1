<form id="frmAddWidget">
    {{ csrf_field() }}
    <div class="form-group row mb-0">
        <label class="col-form-label col-lg-2"><em>Vị trí</em></label>
        <div class="col-form-label col-lg-10">
            <strong>{{ $group['title'] }}</strong>
            <input type="hidden" name="group" value="{{ $group['name'] }}">
        </div>
    </div>
    <div class="form-group row mb-0">
        <label class="col-form-label col-lg-2"><em>Module</em></label>
        <div class="col-form-label col-lg-10">
            <strong>{{ $module['title'] }}</strong>
            <input type="hidden" name="module" value="{{ $module['name'] }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-lg-2"><em>Widget</em></label>
        <div class="col-form-label col-lg-10">
            <strong>{{ $widget['title'] }}</strong>
            <input type="hidden" name="name" value="{{ $widget['name'] }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-lg-2"><strong>Tiêu đề </strong> <sup class="text-danger">(*)</sup></label>
        <div class="col-lg-10">
            <input type="text" name="title" class="form-control" value="{{ $widget['title'] }}">
        </div>
    </div>
    <div class="text-center">
        <button type="button" onclick="submitAddWidget(this);" class="btn btn-primary">Thêm widget</button>
    </div>
</form>

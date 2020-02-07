<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">THÊM MODULE BÌNH LUẬN</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_comment.admin.post_add_module') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label><strong>Chọn module</strong></label>
                <select name="module" class="form-control">
                    <option value="">-- Chọn module --</option>
                    @if (isset($module) && count($module))
                    @foreach ($module as $mod)
                    <option value="{{ $mod['name'] }}" {{ old('name') == $mod['name'] ? 'selected' : '' }}>{{ $mod['title'] }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <hr>
            <div class="float-right">
                <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
            </div>
        </form>
    </div>
</div>
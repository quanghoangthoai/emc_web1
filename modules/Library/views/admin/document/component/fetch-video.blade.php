<input type="text" hidden name='doc_type_flag' value="video">
<div class="form-group row">
    <label class="col-sm-5 col-form-label">Link video</label>
    <div class="col-sm-7">
        <input value="{{ old('video_url', isset($doc['video_url']) ? $doc['video_url'] : '')}}" type="text" placeholder="Nhập link video" class="form-control" name="video_url">
    </div>
</div>
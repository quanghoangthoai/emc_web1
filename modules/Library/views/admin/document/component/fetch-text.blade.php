<div class="form-group row">
    <input type="text" hidden name='doc_type_flag' value="text">
    <label class="col-sm-5 col-form-label">Số hiệu <sup class="text-danger">(*)</sup></label>
    <div class="col-sm-7">
        <input value="{{ old('text_code', isset($doc['text_code']) ? $doc['text_code'] : '')}}" type="text" placeholder="Nhập số hiệu" class="form-control" name="text_code">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-5 col-form-label">Loại văn bản <sup class="text-danger">(*)</sup></label>
    <div class="col-sm-7">
        <select class="form-control" name="text_type">
            <option selected value="">Chọn văn bản</option>
            @if (mod_library_list_text_type())
            @foreach (mod_library_list_text_type() as $key => $value)
            <option value="{{ $key }}" {{ old('text_type', isset($doc['text_type']) ? $doc['text_type'] : null ) ==  $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
            @endif
        </select>
    </div>
</div>
<div class="form-group select-date-input row">
    <label class="col-sm-5 col-form-label">Ngày ban hành</label>
    <div class="col-sm-7">
        <input placeholder="Chọn ngày ban hành" value="{{ old('issued_date', isset($doc['issued_date']) ? mod_library_format_date($doc['issued_date'],'d-m-Y') : '' )}}" type="text" class="form-control" name="issued_date" id="issued-date-picker">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-5 col-form-label">Nơi ban hành</label>
    <div class="col-sm-7">
        <input value="{{ old('issued_location', isset($doc['issued_location']) ? $doc['issued_location'] : '')}}" type="text" placeholder="Nhập nơi ban hành" class="form-control" name="issued_location">
    </div>
</div>
<div class="form-group row select-date-input">
    <label class="col-sm-5 col-form-label">Ngày hiệu lực</label>
    <div class="col-sm-7">
        <input placeholder="Chọn ngày bắt đầu" value="{{ old('started_date', isset($doc['started_date']) ? mod_library_format_date($doc['started_date'], 'd-m-Y') : '' )}}" type="text" class="form-control" name="started_date" id="started-date-picker">
    </div>
</div>
<div class="form-group row select-date-input">
    <label class="col-sm-5 col-form-label">Ngày hết hiệu lực</label>
    <div class="col-sm-7">
        <input placeholder="Chọn ngày kết thúc" value="{{ old('expired_date', isset($doc['expired_date']) ? mod_library_format_date($doc['expired_date'], 'd-m-Y') : '' )}}" type="text" class="form-control" name="expired_date" id="expired-date-picker">
    </div>
</div>



<script>
    $(document).ready(function(){
        var $input1 = $('#issued-date-picker').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
        });
        
        var $input2 = $('#expired-date-picker').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
        });

        var $input3 = $('#started-date-picker').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'yyyy-mm-dd',
        });
        var issue_date = $input1.pickadate('picker');
        var start_picker = $input3.pickadate('picker');
        var end_picker = $input2.pickadate('picker');
        issue_date.on('set', function (event){
            if ( event.select ) { 
                start_picker.set('min', new Date(event.select))
                end_picker.set('min', new Date(event.select))
            }
        });
        start_picker.on('set', function(event) 
        {
            if ( event.select ) { 
                issue_date.set('max', new Date(event.select))
                
                end_picker.set('min', new Date(event.select))
            }
        })
        end_picker.on('set', function(event) 
        {
            if ( event.select ) { 
                issue_date.set('max', new Date(event.select))
                start_picker.set('max', new Date(event.select))
            }
        })
    });
    
    
</script>
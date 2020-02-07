<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-5 col-form-label"><strong>Tạm tính(Chưa VAT):</strong></label>
        <div class="col-lg-7">
            <input readonly value="{{ $total_price }}" name="total" type="text" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-5 col-form-label"><strong>Giảm giá:</strong></label>
        <div class="col-lg-5">
            <div class="input-group">
                <input type="number" name="sale_percent" value="{{ $sale_percent }}" readonly class="form-control" aria-label="">
                <div class="input-group-append ml-0">
                    <span class="input-group-text ml-0">%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-5 col-form-label"><strong>Thuế(VAT):</strong></label>
        <div class="col-lg-5">
            @if(isset($iRequest))
            <div class="input-group">
                <input type="number" min="0" max="100" readonly name="vat_percent" oninput="this.value = Math.abs(this.value)" id="input-vat-percent" value="{{ $vat_percent }}" class="form-control" aria-label="">
                <div class="input-group-append ml-0">
                    <span class="input-group-text ml-0">%</span>
                </div>
            </div>
            @else
            <div class="input-group">
                <input type="number" min="0" max="100" name="vat_percent" oninput="this.value = Math.abs(this.value)" id="input-vat-percent" value="{{ $vat_percent }}" class="form-control" aria-label="">
                <div class="input-group-append ml-0">
                    <span class="input-group-text ml-0">%</span>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-5 col-form-label"><strong>Thành tiền:</strong></label>
        <div class="col-lg-7">
            <div class="percentInput">
                <input readonly name="payment" value="{{ $payment_price }}" type="text" class="form-control">
            </div>
        </div>
    </div>
</div>

<script>
    $("input[type=number][name=vat_percent]").on("change keyup", debounce(function(){
            var payment_status = $('input[type=radio][name=payment_method]:checked').val();
            var vat_percent = $(this).val()
            load_bill_data(payment_status, vat_percent);
    },300));
    function debounce(callback, delay) {
        var timeout
        return function() {
            var args = arguments
            clearTimeout(timeout)
            timeout = setTimeout(function() {
            callback.apply(this, args)
            }.bind(this), delay)
        }
    };
</script>
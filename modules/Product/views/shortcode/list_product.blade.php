<div class="row">
    @foreach ($listProduct as $item)
    <div class="col-4">
        <p class="{{ $item['featured'] ? 'alert alert-danger' : 'alert alert-info' }}">{{ $item['name'] }}</p>
    </div>
    @endforeach
</div>

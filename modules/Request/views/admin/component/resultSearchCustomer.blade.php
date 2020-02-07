@if (count($listResult) > 0)
<ul>
    @foreach ($listResult as $iResult)
    <li onclick="insertData2Input(this);">
        <span id="txtPhone">{{ $iResult->info['phone'] }}</span>
        <span id="txtFullname">{{ $iResult->info['fullname'] }}</span>
        <span id="txtEmail">{{ $iResult['email'] }}</span>
    </li>
    @endforeach
</ul>
@else

@endif
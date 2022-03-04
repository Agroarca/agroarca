@php
    $single = isset($single) && $single ? true : false;
    $multiple = isset($multiple) && $multiple ? true : false;
    // dd([$multiple, is_array($data) ,count($data) > 1]);
@endphp

{{-- @TODO: Quando modularizar, implementar upload assim :  asset("storage/banners/$bg->nome_arquivo") --}}

@if($single)
<section class="container banner-info" style="@isset($data['image']) background-image:url({{$data['image']}}) @endisset">
    <div class="banner-overlay">
        <div class="banner-text-overlay">
            @isset($data['subtitle'])<b>{{ $data['subtitle'] }}</b>@endisset
            <h2>{{ $data['title'] ?? '' }}</h2>
            @isset($data['description'])<p>{{ $data['description'] }}</p>@endisset
            @if(isset($data['action']) && isset($data['actionTitle']))<a class="btn btn-secondary" href="{{ $data['action'] }}"target="__blank">{{ $data['actionTitle'] }}</a>@endisset
        </div>
    </div>
</section>
@elseif($multiple && is_array($data) && count($data) > 1)
<section class="container container-banners-carousel">
    <div class="section-nav">
        <button id="banners-nav-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
        <button id="banners-nav-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>

    <div class="owl-carousel owl-theme"  id="banners-carousel">
        @foreach($data as $item)
            <div class="banner-info" style="@isset($item['image']) background-image:url({{$item['image']}}) @endisset">
                <div class="banner-overlay">
                    <div class="banner-text-overlay">
                        @isset($item['subtitle'])<b>{{ $item['subtitle'] }}</b>@endisset
                        <h2>{{ $item['title'] ?? '' }}</h2>
                        @isset($item['description'])<p>{{ $item['description'] }}</p>@endisset
                        @if(isset($item['action']) && isset($item['actionTitle']))<a class="btn btn-secondary" href="{{ $item['action'] }}"target="__blank">{{ $item['actionTitle'] }}</a>@endisset
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </section>
@endif

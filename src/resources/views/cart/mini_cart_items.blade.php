@forelse($cart as $item)
<li>
    <div class="media-left">
        <a href="#" class="thumb">
            <img width="80" src="{{ asset('layout/images/products/' . $item['image']) }}">
        </a>
    </div>

    <div class="media-body">
        <a href="#" class="tittle">
            {{ $item['name'] }}
        </a>

        <span>
            {{ number_format($item['price'],0,',','.') }}₫
            x {{ $item['quantity'] }}
        </span>
    </div>
</li>

@empty

<li class="text-center p-3">
    Giỏ hàng trống
</li>

@endforelse

<li class="btn-cart">
    <a href="{{ route('layout.cart') }}" class="btn-round">
        Xem giỏ hàng
    </a>
</li>
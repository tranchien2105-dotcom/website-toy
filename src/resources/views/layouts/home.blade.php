@extends('welcome')
@section('main')
    <!-- Shipping Info -->
    <section class="slid-sec with-bg-wide">
        <!-- Main Slider Start -->
        <div class="tp-banner-container">
            <div class="tp-banner-full">
                <ul>

                    @foreach($banners as $banner)
                        <li data-transition="random" data-slotamount="7" data-masterspeed="300" data-saveperformance="off">

                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}">
                                    <img src="{{ asset('layout/images/banners/' . $banner->image_url) }}" alt="{{ $banner->title }}"
                                        data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                        style="width:100%; height:500px; object-fit:cover;">
                                </a>
                            @else
                                <img src="{{ asset('layout/images/banners/' . $banner->image_url) }}" alt="{{ $banner->title }}"
                                    data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                    style="width:100%; height:500px; object-fit:cover;">
                            @endif

                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </section>

    <section class="shipping-info">
        <div class="container">
            <ul>

                <!-- Free Shipping -->
                <li>
                    <div class="media-left">
                        <i class="flaticon-delivery-truck-1"></i>
                    </div>

                    <div class="media-body">
                        <h5>{{ __('messages.free_shipping') }}</h5>
                        <span>{{ __('messages.free_shipping_desc') }}</span>
                    </div>
                </li>

                <!-- Money Return -->
                <li>
                    <div class="media-left">
                        <i class="flaticon-arrows"></i>
                    </div>

                    <div class="media-body">
                        <h5>{{ __('messages.money_back') }}</h5>
                        <span>{{ __('messages.money_back_desc') }}</span>
                    </div>
                </li>

                <!-- Support -->
                <li>
                    <div class="media-left">
                        <i class="flaticon-operator"></i>
                    </div>

                    <div class="media-body">
                        <h5>{{ __('messages.support') }}</h5>
                        <span>{{ __('messages.support_desc') }}</span>
                    </div>
                </li>

                <!-- Safe Payment -->
                <li>
                    <div class="media-left">
                        <i class="flaticon-business"></i>
                    </div>

                    <div class="media-body">
                        <h5>{{ __('messages.secure_payment') }}</h5>
                        <span>{{ __('messages.secure_payment_desc') }}</span>
                    </div>
                </li>

            </ul>
        </div>
    </section>

    <!-- tab Section -->
    <section class="featur-tabs padding-top-60 padding-bottom-60">
        <div class="container">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-pills margin-bottom-40" role="tablist">

                <li role="presentation" class="active">
                    <a href="#featur" aria-controls="featur" role="tab" data-toggle="tab">
                        {{ __('messages.latest') }}
                    </a>
                </li>

                <li role="presentation">
                    <a href="#special" aria-controls="special" role="tab" data-toggle="tab">
                        {{ __('messages.featured') }}
                    </a>
                </li>

                <li role="presentation">
                    <a href="#on-sal" aria-controls="on-sal" role="tab" data-toggle="tab">
                        {{ __('messages.sale') }}
                    </a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <!-- Featured -->
                <div role="tabpanel" class="tab-pane active fade in" id="featur">
                    <div class="item-slide-5 with-bullet no-nav">

                        @foreach($products as $product)
                            <div class="product">
                                <article>

                                    <img class="img-responsive" src="{{ asset('layout/images/products/' . $product->image) }}"
                                        alt="{{ $product->name }}">

                                    <span class="tag">
                                        {{ $product->category->name ?? 'Category' }}
                                    </span>

                                    <a href="{{ route('layout.product.detail', $product->slug) }}" class="tittle">
                                        {{ $product->name }}
                                    </a>

                                    <p class="rev">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->star))
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor

                                        <span class="margin-left-10">
                                            {{ $product->review_count }}
                                            {{ __('messages.reviews') }}
                                        </span>
                                    </p>

                                    <div class="price">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </div>

                                    <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}">
                                        <i class="icon-basket-loaded"></i>
                                    </a>

                                </article>
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- Special -->
                <div role="tabpanel" class="tab-pane fade" id="special">
                    <div class="item-slide-5 with-bullet no-nav">

                        @foreach($products as $product)
                            <div class="product">
                                <article>

                                    <img class="img-responsive" src="{{ asset('layout/images/products/' . $product->image) }}"
                                        alt="{{ $product->name }}">

                                    <span class="tag">
                                        {{ $product->category->name ?? 'Category' }}
                                    </span>

                                    <a href="{{ route('layout.product.detail', $product->slug) }}" class="tittle">
                                        {{ $product->name }}
                                    </a>

                                    <p class="rev">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->star))
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor

                                        <span class="margin-left-10">
                                            {{ $product->review_count }}
                                            {{ __('messages.reviews') }}
                                        </span>
                                    </p>

                                    <div class="price">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </div>

                                    <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}">
                                        <i class="icon-basket-loaded"></i>
                                    </a>

                                </article>
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- On Sale -->
                <div role="tabpanel" class="tab-pane fade" id="on-sal">
                    <div class="item-slide-5 with-bullet no-nav">

                        @foreach($products as $product)
                            <div class="product">
                                <article>

                                    <img class="img-responsive" src="{{ asset('layout/images/products/' . $product->image) }}"
                                        alt="{{ $product->name }}">

                                    <span class="tag">
                                        {{ $product->category->name ?? 'Category' }}
                                    </span>

                                    <a href="{{ route('layout.product.detail', $product->slug) }}" class="tittle">
                                        {{ $product->name }}
                                    </a>

                                    <p class="rev">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($product->star))
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor

                                        <span class="margin-left-10">
                                            {{ $product->review_count }}
                                            {{ __('messages.reviews') }}
                                        </span>
                                    </p>

                                    <div class="price">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </div>

                                    <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}">
                                        <i class="icon-basket-loaded"></i>
                                    </a>

                                </article>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Top Selling Week -->
    <section class="light-gry-bg padding-top-60 padding-bottom-30">
        <div class="container">

            <!-- heading -->
            <div class="heading">
                <h2>{{ __('messages.top_selling_week') }}</h2>
                <hr>
            </div>

            <!-- Items -->
            <div class="item-col-5">

                <!-- Product -->
                <div class="product col-2x">
                    <div class="like-bnr">
                        <div class="position-center-center">
                            <a href="#." class="btn-round">
                                {{ __('messages.view_detail') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product -->
                @foreach($topSellingProducts as $product)
                    <div class="product">
                        <article> <img class="img-responsive" src="{{ asset("layout/images/products/" . $product->image) }}"
                                alt=""> <span class="sale-tag">-25%</span>

                            <!-- Content -->
                            <span class="tag">{{ $product->category->name ?? '' }}</span> <a
                                href="{{ route('layout.product.detail', $product->slug) }}"
                                class="tittle">{{ $product->name }}</a>
                            <!-- Reviews -->
                            <p class="rev">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= ceil($product->star))
                                        <i class="fa fa-star"></i>
                                    @else
                                        <i class="fa fa-star-o"></i>
                                    @endif
                                @endfor

                                <span class="margin-left-10">
                                    ({{ $product->review_count }})
                                    {{ __('messages.reviews') }}
                                </span>
                            </p>
                            <div class="price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}"><i
                                    class="icon-basket-loaded"></i></a>
                        </article>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Main Tabs Sec -->
    <section class="main-tabs-sec padding-top-60 padding-bottom-0">
        <div class="container">

            {{-- Tabs --}}
            <ul class="nav margin-bottom-40" role="tablist">

                @foreach($tagsCategory as $key => $category)
                    <li role="presentation" class="{{ $key == 0 ? 'active' : '' }}">
                        <a href="#tab{{ $category->id }}" aria-controls="tab{{ $category->id }}" role="tab" data-toggle="tab">

                            <i class="flaticon-cart"></i>

                            {{ $category->name }}

                            <span>
                                ({{ $category->products->where('status', 1)->count() }})
                                {{ __('messages.products') }}
                            </span>
                        </a>
                    </li>
                @endforeach

            </ul>

            {{-- Content --}}
            <div class="tab-content">

                @foreach($tagsCategory as $key => $category)

                    <div role="tabpanel" class="tab-pane fade {{ $key == 0 ? 'active in' : '' }}" id="tab{{ $category->id }}">

                        <div class="item-slide-5 with-bullet no-nav">

                            @forelse($category->products->where('status', 1)->take(8) as $product)

                                <div class="product">
                                    <article>

                                        <img class="img-responsive" src="{{ asset('layout/images/products/' . $product->image) }}"
                                            alt="{{ $product->name }}">

                                        <span class="tag">
                                            {{ $category->name }}
                                        </span>

                                        <a href="{{ route('layout.product.detail', $product->slug) }}" class="tittle">
                                            {{ $product->name }}
                                        </a>

                                        <p class="rev">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $product->star)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="fa fa-star-o"></i>
                                                @endif
                                            @endfor

                                            <span class="margin-left-10">
                                                {{ $product->review_count }} {{ __('messages.reviews') }}
                                            </span>
                                        </p>

                                        <div class="price">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </div>

                                        <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}">
                                            <i class="icon-basket-loaded"></i>
                                        </a>

                                    </article>
                                </div>

                            @empty

                                <p class="text-center py-5">
                                    {{ __('messages.no_products') }}
                                </p>

                            @endforelse

                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </section>
    <!-- Top Selling Week -->
    <section class="padding-top-60 padding-bottom-60">
        <div class="container">

            <!-- heading -->
            <div class="heading">
                <h2>{{ __('messages.our_blog') }}</h2>
                <hr>
            </div>
            <div id="blog-slide" class="with-nav">

                @foreach ($blogs as $blog)
                    <div class="blog-post">
                        <article> <img class="img-responsive" src="{{ asset('layout/images/blogs/' . $blog->image) }}"
                                alt="{{ $blog->title }}"> <span><i class="fa fa-bookmark-o"></i>
                                {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</span> <span><i
                                    class="fa fa-comment-o"></i> {{ $blog->comment  }}
                                {{ __('messages.comments') }}</span> <a href="#." class="tittle">{{ $blog->title  }}</a>
                            <p>
                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 150) }}
                            </p>
                            <a href="#.">{{ __('messages.read_more') }}</a>
                        </article>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Clients img -->
    <section class="light-gry-bg clients-img">
        <div class="container">
            <ul>
                <li><img src="images/c-img-1.png" alt=""></li>
                <li><img src="images/c-img-2.png" alt=""></li>
                <li><img src="images/c-img-3.png" alt=""></li>
                <li><img src="images/c-img-4.png" alt=""></li>
                <li><img src="images/c-img-5.png" alt=""></li>
            </ul>
        </div>
    </section>

    <!-- Newslatter -->
    <section class="newslatter">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <h3>
                        {{ __('messages.newsletter') }}
                        <span>
                            {{ __('messages.newsletter_desc') }}
                        </span>
                    </h3>
                </div>

                <div class="col-md-6">
                    <form>
                        <input type="email" placeholder="{{ __('messages.email_placeholder') }}" required>
                        <button type="submit">
                            {{ __('messages.subscribe') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <style>
        .tittle {
            display: -webkit-box !important;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;

            overflow: hidden;
            text-overflow: ellipsis;

            white-space: normal;
            line-height: 24px;
            max-height: 48px;
        }
    </style>
@endsection
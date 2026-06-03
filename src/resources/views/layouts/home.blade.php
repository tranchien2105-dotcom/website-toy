@extends('welcome')
@section('main')
    <!-- Shipping Info -->
      <section class="slid-sec with-bg-wide">
            <!-- Main Slider Start -->
            <div class="tp-banner-container">
                <div class="tp-banner-full">
                    <ul>

                        @foreach($banners as $banner)
                            <li data-transition="random" data-slotamount="7" data-masterspeed="300"
                                data-saveperformance="off">

                                {{-- MAIN IMAGE --}}
                                @if($banner->link_url)
                                    <a href="{{ $banner->link_url }}">
                                        <img src="{{ asset('layout/images/banners/' . $banner->image_url) }}"
                                            alt="{{ $banner->title }}" data-bgposition="center center" data-bgfit="cover"
                                            data-bgrepeat="no-repeat">
                                    </a>
                                @else
                                    <img src="{{ asset('layout/images/banners/' . $banner->image_url) }}"
                                        alt="{{ $banner->title }}" data-bgposition="center center" data-bgfit="cover"
                                        data-bgrepeat="no-repeat">
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
                    <div class="media-left"> <i class="flaticon-delivery-truck-1"></i> </div>
                    <div class="media-body">
                        <h5>Miễn phí vận chuyển</h5>
                        <span>Cho đơn hàng trên 500.000đ</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-left"> <i class="flaticon-arrows"></i> </div>
                    <div class="media-body">
                        <h5>Hoàn tiền</h5>
                        <span>30 Ngày hoàn tiền</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-left"> <i class="flaticon-operator"></i> </div>
                    <div class="media-body">
                        <h5>Hỗ trợ 24/7</h5>
                        <span>Hotline: (+84) 123 456 7890</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-left"> <i class="flaticon-business"></i> </div>
                    <div class="media-body">
                        <h5>Thanh toán an toàn</h5>
                        <span>Bảo vệ thanh toán trực tuyến</span>
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
                <li role="presentation" class="active"><a href="#featur" aria-controls="featur" role="tab"
                        data-toggle="tab">Featured</a></li>
                <li role="presentation"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">Special</a>
                </li>
                <li role="presentation"><a href="#on-sal" aria-controls="on-sal" role="tab" data-toggle="tab">Onsale</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Featured -->
                <div role="tabpanel" class="tab-pane active fade in" id="featur">
                    <!-- Items Slider -->
                    <div class="item-slide-5 with-nav">
                        <!-- Product -->
                        @foreach ($products as $product)
                            <div class="product">
                                <article> <img class="img-responsive"
                                        src="{{ asset("layout/images/products/" . $product->image) }}" alt="">
                                    <!-- Content -->
                                    <span class="tag">{{ $product->category->name }}</span> <a href="#."
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
                                            ({{ $product->review_count }}) Nhận xét
                                        </span>
                                    </p>
                                    <div class="price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                    <a href="javascript:void(0)" class="cart-btn add-cart-btn" data-id="{{ $product->id }}"><i class="icon-basket-loaded"></i></a>
                                </article>
                            </div>
                        @endforeach
                        <!-- Product -->

                    </div>
                </div>

                <!-- Special -->
                <div role="tabpanel" class="tab-pane fade" id="special">
                    <!-- Items Slider -->
                    <div class="item-col-5">

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-11.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">{{ $categories->first()->name ?? 'Category' }}</span> <a href="#."
                                    class="tittle">Laptop Alienware 15
                                    i7 Perfect For Playing Game</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00 </div>
                                <a href="{{ route('cart.add', $product->id) }}" class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-9.jpg" alt=""> <span
                                    class="sale-tag">-25%</span>

                                <!-- Content -->
                                <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible
                                    Deportivo Slim Con 8GB</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00 <span>$200.00</span></div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-8.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj
                                    Inteligente Smart Watch M26 Touch Bluetooh </a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-7.jpg" alt=""> <span
                                    class="new-tag">New</span>

                                <!-- Content -->
                                <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado
                                    Inalambrico Bluetooth Con Air Mouse</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-6.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook
                                    7" 128GB full HD</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>
                    </div>
                </div>

                <!-- on sale -->
                <div role="tabpanel" class="tab-pane fade" id="on-sal">
                    <!-- Items Slider -->
                    <div class="item-col-5">

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-3.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">Latop</span> <a href="#." class="tittle">Laptop Alienware 15
                                    i7 Perfect For Playing Game</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span
                                        class="margin-left-10">5
                                        Review(s)</span></p>
                                <div class="price">$350.00 </div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-1.jpg" alt=""> <span
                                    class="sale-tag">-25%</span>

                                <!-- Content -->
                                <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible
                                    Deportivo Slim Con 8GB</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star"></i> <span
                                        class="margin-left-10">5 Review(s)</span>
                                </p>
                                <div class="price">$350.00 <span>$200.00</span></div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-2.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj
                                    Inteligente Smart Watch M26 Touch Bluetooh </a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star"></i> <span
                                        class="margin-left-10">5 Review(s)</span>
                                </p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-5.jpg" alt=""> <span
                                    class="new-tag">New</span>

                                <!-- Content -->
                                <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado
                                    Inalambrico Bluetooth Con Air Mouse</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star"></i> <span
                                        class="margin-left-10">5 Review(s)</span>
                                </p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>

                        <!-- Product -->
                        <div class="product">
                            <article> <img class="img-responsive" src="images/item-img-1-4.jpg" alt="">
                                <!-- Content -->
                                <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook
                                    7" 128GB full HD</a>
                                <!-- Reviews -->
                                <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i> <i class="fa fa-star"></i> <span
                                        class="margin-left-10">5 Review(s)</span>
                                </p>
                                <div class="price">$350.00</div>
                                <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                            </article>
                        </div>
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
                <h2>Top Selling of the Week</h2>
                <hr>
            </div>

            <!-- Items -->
            <div class="item-col-5">

                <!-- Product -->
                <div class="product col-2x">
                    <div class="like-bnr">
                        <div class="position-center-center">
                            <h5>Smart Watch 2.0</h5>
                            <p>Space Gray Aluminum Case
                                with Black/Volt Real Sport Band <span>38mm | 42mm</span> </p>
                            <a href="#." class="btn-round">View Detail</a>
                        </div>
                    </div>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-6.jpg" alt=""> <span
                            class="sale-tag">-25%</span>

                        <!-- Content -->
                        <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible Deportivo
                            Slim Con 8GB</a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00 <span>$200.00</span></div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-7.jpg" alt="">
                        <!-- Content -->
                        <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente Smart
                            Watch M26 Touch Bluetooh </a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-8.jpg" alt=""> <span
                            class="new-tag">New</span>

                        <!-- Content -->
                        <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado Inalambrico
                            Bluetooth Con Air Mouse</a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-9.jpg" alt="">
                        <!-- Content -->
                        <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook 7"
                            128GB full HD</a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-10.jpg" alt="">
                        <!-- Content -->
                        <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente Smart
                            Watch M26 Touch Bluetooh </a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-11.jpg" alt=""> <span
                            class="new-tag">New</span>

                        <!-- Content -->
                        <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado Inalambrico
                            Bluetooth Con Air Mouse</a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="{{ route('cart.add', $product->id) }}" class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-12.jpg" alt="">
                        <!-- Content -->
                        <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook 7"
                            128GB full HD</a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>

                <!-- Product -->
                <div class="product">
                    <article> <img class="img-responsive" src="images/item-img-1-13.jpg" alt="">
                        <!-- Content -->
                        <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente Smart
                            Watch M26 Touch Bluetooh </a>
                        <!-- Reviews -->
                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                class="fa fa-star"></i> <i class="fa fa-star"></i>
                            <span class="margin-left-10">5 Review(s)</span>
                        </p>
                        <div class="price">$350.00</div>
                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                    </article>
                </div>
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

                            <span>({{ $category->products->where('status', 1)->count() }}) sản phẩm</span>
                        </a>
                    </li>
                @endforeach

            </ul>

            {{-- Content --}}
            <div class="tab-content">

                @foreach($tagsCategory as $key => $category)

                    <div role="tabpanel" class="tab-pane fade {{ $key == 0 ? 'active in' : '' }}" id="tab{{ $category->id }}">

                        <div class="row">

                            @forelse($category->products->where('status', 1)->take(8) as $product)

                                <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
                                    <div class="product">
                                        <article>

                                            {{-- Image --}}
                                            <img class="img-responsive" src="{{ asset('layout/images/products/' . $product->image) }}"
                                                alt="{{ $product->name }}">

                                            {{-- Tag --}}
                                            <span class="tag">
                                                {{ $category->name }}
                                            </span>

                                            {{-- Name --}}
                                            <a href="" class="tittle">
                                                {{ $product->name }}
                                            </a>

                                            {{-- Reviews --}}
                                            <p class="rev">

                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $product->star)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-o"></i>
                                                    @endif
                                                @endfor

                                                <span class="margin-left-10">
                                                    {{ $product->review_count }} Nhận xét
                                                </span>

                                            </p>

                                            {{-- Price --}}
                                            <div class="price">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </div>

                                            {{-- Cart --}}
                                            <a href="{{ route('cart.add', $product->id) }}" class="cart-btn">
                                                <i class="icon-basket-loaded"></i>
                                            </a>

                                        </article>
                                    </div>
                                </div>

                            @empty

                                <div class="col-12 text-center py-5">
                                    No products found.
                                </div>

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
                <h2>From our Blog</h2>
                <hr>
            </div>
            <div id="blog-slide" class="with-nav">

                <!-- Blog Post -->
                <div class="blog-post">
                    <article> <img class="img-responsive" src="images/blog-img-1.jpg" alt=""> <span><i
                                class="fa fa-bookmark-o"></i> 25 Dec, 2017</span> <span><i class="fa fa-comment-o"></i> 86
                            Comments</span> <a href="#." class="tittle">It’s
                            why there’s nothing else like Mac. </a>
                        <p>Etiam porttitor ante non tellus pulvinar, non vehicula lorem fermentum. Nulla vitae
                            efficitur mi [...] </p>
                        <a href="#.">Readmore</a>
                    </article>
                </div>

                <!-- Blog Post -->
                <div class="blog-post">
                    <article> <img class="img-responsive" src="images/blog-img-2.jpg" alt=""> <span><i
                                class="fa fa-bookmark-o"></i> 25 Dec, 2017</span> <span><i class="fa fa-comment-o"></i> 86
                            Comments</span> <a href="#." class="tittle">Get
                            the power to take your business to the
                            next level. </a>
                        <p>Etiam porttitor ante non tellus pulvinar, non vehicula lorem fermentum. Nulla vitae
                            efficitur mi [...] </p>
                        <a href="#.">Readmore</a>
                    </article>
                </div>

                <!-- Blog Post -->
                <div class="blog-post">
                    <article> <img class="img-responsive" src="images/blog-img-3.jpg" alt=""> <span><i
                                class="fa fa-bookmark-o"></i> 25 Dec, 2017</span> <span><i class="fa fa-comment-o"></i> 86
                            Comments</span> <a href="#." class="tittle">It’s
                            why there’s nothing else like Mac. </a>
                        <p>Etiam porttitor ante non tellus pulvinar, non vehicula lorem fermentum. Nulla vitae
                            efficitur mi [...] </p>
                        <a href="#.">Readmore</a>
                    </article>
                </div>
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
                    <h3>Subscribe our Newsletter <span>Get <strong>25% Off</strong> first purchase!</span></h3>
                </div>
                <div class="col-md-6">
                    <form>
                        <input type="email" placeholder="Your email address here...">
                        <button type="submit">Subscribe!</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
@endsection
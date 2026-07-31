<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="M_Adnan" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Document Title -->
    <title>Tạp hoá MinhChien</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('layout/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('layout/images/favicon.png') }}" type="image/x-icon">

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('layout/rs-plugin/css/settings.css') }}" media="screen" />

    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('layout/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/responsive.css') }}">

    <!-- Fonts Online -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100i,300,400,700,900" rel="stylesheet">

    <!-- JavaScripts -->
    <script src="{{ asset('layout/js/vendors/modernizr.js') }}"></script>
    <style>
        :root {
            --primary:
                {{ $setting?->primary_color }}
            ;
            --secondary:
                {{ $setting?->secondary_color }}
            ;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>

    <!-- Page Wrapper -->
    <div id="wrap" class="layout-1">

        <!-- Top bar -->
        <div class="top-bar">
            <div class="container">
                <p>{{ __('messages.store_name') }}</p>
                <div class="right-sec">
                    <ul>

                        @guest
                            <li>
                                <a href="{{ route('layout.login') }}">{{ __('messages.login_register') }}</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="">{{ __('messages.profile') }}</a>
                                    </li>

                                    <li>
                                        <a href="">{{ __('messages.orders') }}</a>
                                    </li>

                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                style="background:none;border:none;padding:8px 20px;width:100%;text-align:left;">
                                                {{ __('messages.logout') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest

                        <li>
                            <select class="selectpicker" onchange="window.location.href=this.value">

                                <option value="{{ route('language', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                                    English
                                </option>

                                <option value="{{ route('language', 'vi') }}" {{ app()->getLocale() == 'vi' ? 'selected' : '' }}>
                                    Tiếng Việt
                                </option>

                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Header -->
        <header>
            <div class="container">
                <div class="logo">
                    <a href="{{ route('layout.home') }}">
                        <img src="{{ asset('layout/images/logoNewv2.png') }}" alt="Tạp Hoá MinhChien"
                            style="width: 220px; height:66px">
                    </a>
                </div>
                <div class="search-cate">
                    <select class="selectpicker" name="category_id" id="category-search">
                        <option value="">{{ __('messages.all_categories') }}</option>

                        @php
                            $categories = getCategories(true);
                        @endphp

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <input id="search-product" type="search" placeholder="{{ __('messages.search_product') }}"
                        autocomplete="off">

                    <button class="submit">
                        <i class="icon-magnifier"></i>
                    </button>

                    <div id="search-result" class="search-result"></div>

                </div>

                <!-- Cart Part -->
                @php
                    $cartItems = session('cart', []);
                    $totalQty = 0;
                    $grandTotal = 0;

                    foreach ($cartItems as $item) {
                        $totalQty += $item['quantity'];
                        $grandTotal += $item['price'] * $item['quantity'];
                    }
                @endphp

                <ul class="nav navbar-right cart-pop">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">

                            <span class="itm-cont">{{ $totalQty }}</span>
                            <i class="flaticon-shopping-bag"></i>
                            <strong>{{ __('messages.cart') }}</strong> <br>

                            <span>
                                ({{ $totalQty }}) {{ __('messages.products') }} -
                                {{ number_format($grandTotal, 0, ',', '.') }}₫
                            </span>
                        </a>

                        <ul class="dropdown-menu mini-cart-list">

                            @forelse ($cartItems as $item)
                                <li>
                                    <div class="media-left">
                                        <a href="#" class="thumb">
                                            <img src="{{ asset('layout/images/products/' . $item['image']) }}"
                                                class="img-responsive" alt="{{ $item['name'] }}">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <a href="#" class="tittle">
                                            {{ $item['name'] }}
                                        </a>

                                        <span>
                                            {{ number_format($item['price'], 0, ',', '.') }}₫
                                            x {{ $item['quantity'] }}
                                        </span>
                                    </div>
                                </li>

                            @empty
                                <li class="text-center" style="padding:15px;">
                                    {{ __('messages.cart_is_empty') }}
                                </li>
                            @endforelse

                            <li class="btn-cart">
                                <a href="{{ route('layout.cart') }}" class="btn-round">
                                    {{ __('messages.view_cart') }}
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Nav -->
            <nav class="navbar ownmenu">
                <div class="container">

                    <!-- Categories -->
                    @php
                        $categories = getCategories();

                        // category cha
                        $parents = $categories->whereNull('parent_id');
                    @endphp

                    <div class="cate-lst">
                        <a data-toggle="collapse" class="cate-style" href="#cater">
                            <i class="fa fa-list-ul"></i> {{ __('messages.all_categories') }}
                        </a>

                        <div class="cate-bar-in">
                            <div id="cater" class="collapse">
                                <ul>

                                    @foreach($parents as $parent)

                                        @php
                                            $children = $categories->where('parent_id', $parent->id);
                                        @endphp

                                        {{-- có menu con --}}
                                        @if($children->count() > 0)

                                            <li class="sub-menu">
                                                <a href="{{ url($parent->slug) }}">
                                                    {{ $parent->name }}
                                                </a>

                                                <ul>
                                                    @foreach($children as $child)
                                                        <li>
                                                            <a href="{{ url($child->slug) }}">
                                                                {{ $child->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                        @else

                                            {{-- không có menu con --}}
                                            <li>
                                                <a href="{{ url($parent->slug) }}">
                                                    {{ $parent->name }}
                                                </a>
                                            </li>

                                        @endif

                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navbar Header -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#nav-open-btn" aria-expanded="false"> <span><i
                                    class="fa fa-navicon"></i></span> </button>
                    </div>
                    <!-- NAV -->
                    <div class="collapse navbar-collapse" id="nav-open-btn">
                        <ul class="nav">
                            <li> <a href="/">{{ __('messages.home')}} </a></li>
                            <li> <a href="/blog">{{ __('messages.blog') }} </a></li>
                            <li> <a href="/about">{{ __('messages.about_us') }} </a></li>
                            <li> <a href="/contact">{{ __('messages.contact') }} </a></li>
                            <li class="dropdown"> <a href="index.html" class="dropdown-toggle" data-toggle="dropdown">
                                    {{ __('messages.page') }} </a>
                                <ul class="dropdown-menu multi-level animated-2s fadeInUpHalf">
                                    <li><a href="About.html"> About </a></li>
                                    <li><a href="LoginForm.html"> Login Form </a></li>
                                    <li><a href="GridProducts_3Columns.html"> Products 3 Columns </a></li>
                                    <li><a href="GridProducts_4Columns.html"> Products 4 Columns </a></li>
                                    <li><a href="ListProducts.html"> List Products </a></li>
                                    <li><a href="Product-Details.html"> Product Details </a></li>
                                    <li><a href="ShoppingCart.html"> Shopping Cart</a></li>
                                    <li><a href="PaymentMethods.html"> Payment Methods </a></li>
                                    <li><a href="DeliveryMethods.html"> Delivery Methods</a></li>
                                    <li><a href="Confirmation.html"> Confirmation </a></li>
                                    <li><a href="CheckoutSuccessful.html"> Checkout Successful </a></li>
                                    <li><a href="Error404.html"> Error404 </a></li>
                                    <li><a href="contact.html"> Contact </a></li>
                                    <li class="dropdown-submenu"><a href="#."> Dropdown Level </a>
                                        <ul class="dropdown-menu animated-2s fadeInRight">
                                            <li><a href="#.">Level 1</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>



                        </ul>
                    </div>

                    <!-- NAV RIGHT -->
                    <div class="nav-right"> <span class="call-mun"><i class="fa fa-phone"></i>
                            <strong>{{ __('messages.phone') }}:</strong>
                            {{ $setting?->phone }}</span> </div>
                </div>
            </nav>
        </header>

        <!-- Slid Sec -->

        <!-- Content -->
        <div id="content">

            @yield('main')

        </div>
        <!-- End Content -->

        <!-- Footer -->
        <footer>
            <div class="container">

                <!-- Footer Upside Links -->
                <div class="foot-link">
                    <ul>
                        <li><a href="#.">{{ __('messages.about') }}</a></li>
                        <li><a href="#.">{{ __('messages.customer_support') }}</a></li>
                        <li><a href="#.">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="#.">{{ __('messages.sitemap') }}</a></li>
                        <li><a href="#.">{{ __('messages.search_product') }}</a></li>
                        <li><a href="#.">{{ __('messages.advanced_search') }}</a></li>
                        <li><a href="#.">{{ __('messages.order_return') }}</a></li>
                        <li><a href="#.">{{ __('messages.contact') }}</a></li>
                    </ul>
                </div>
                <div class="row">

                    <!-- Contact -->
                    <div class="col-md-4">
                        <h4>{{ __('messages.contact_us') }}</h4>
                        <p>{{ __('messages.address') }}: 102/46 Hồ Biểu Chánh, Phường 11, Quận Phú Nhuận, TP.HCM</p>
                        <p>{{ __('messages.phone') }}: {{ $setting?->phone }}</p>
                        <p>{{ __('messages.email') }}: {{ $setting?->email }}</p>
                        <div class="social-links"> <a href="#."><i class="fa fa-facebook"></i></a> <a href="#."><i
                                    class="fa fa-twitter"></i></a> <a href="#."><i class="fa fa-linkedin"></i></a> <a
                                href="#."><i class="fa fa-pinterest"></i></a> <a href="#."><i
                                    class="fa fa-instagram"></i></a> <a href="#."><i class="fa fa-google"></i></a>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="col-md-3">
                        <h4>{{ __('messages.all_categories') }}</h4>
                        <!-- #region -->
                        @php
                            $categorieParent = getCategories(true);
                        @endphp

                        <ul class="links-footer">
                            @foreach ($categorieParent as $category)
                                <li><a href="#.">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div class="col-md-3">
                        <h4>{{ __('messages.customer_support') }}</h4>

                        <ul class="links-footer">
                            <li><a href="#.">{{ __('messages.shipping_policy') }}</a></li>
                            <li><a href="#.">{{ __('messages.refund_policy') }}</a></li>
                            <li><a href="#.">{{ __('messages.buying_guide') }}</a></li>
                            <li><a href="#.">{{ __('messages.payment_method') }}</a></li>
                            <li><a href="#.">{{ __('messages.contact_support') }}</a></li>
                        </ul>
                    </div>

                    <!-- Information -->
                    <div class="col-md-2">
                        <h4>{{ __('messages.information') }}</h4>

                        <ul class="links-footer">
                            <li><a href="#.">{{ __('messages.about') }}</a></li>
                            <li><a href="#.">{{ __('messages.news') }}</a></li>
                            <li><a href="#.">{{ __('messages.privacy_policy') }}</a></li>
                            <li><a href="#.">{{ __('messages.terms') }}</a></li>
                            <li><a href="#.">{{ __('messages.store_system') }}</a></li>
                            <li><a href="#.">{{ __('messages.faq') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Rights -->
        <div class="rights">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <p> {{ $setting?->copyright }} <a href="#." class="ri-li"> {{ $setting?->site_name }}</a></p>
                    </div>
                    <div class="col-sm-6 text-right"> <img src="{{ asset('layout/images/card-icon.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- End Footer -->

        <!-- GO TO TOP  -->
        <a href="#" class="cd-top"><i class="fa fa-angle-up"></i></a>
        <!-- GO TO TOP End -->
    </div>
    <!-- End Page Wrapper -->

    <!-- JavaScripts -->
    <script src="{{ asset('layout/js/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('layout/js/vendors/wow.min.js') }}"></script>
    <script src="{{ asset('layout/js/vendors/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/js/vendors/own-menu.js') }}"></script>
    <script src="{{ asset('layout/js/vendors/jquery.sticky.js') }}"></script>
    <script src="{{ asset('layout/js/vendors/owl.carousel.min.js') }}"></script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="{{ asset('layout/rs-plugin/js/jquery.tp.t.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('layout/rs-plugin/js/jquery.tp.min.js') }}"></script>
    <script src="{{ asset('layout/js/main.js') }}"></script>
    <script>
        $(document).on('click', '.add-cart-btn', function (e) {

            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                url: '/cart/add/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },

                success: function (res) {

                    $('.itm-cont').text(res.qty);

                    $('.cart-pop strong')
                        .next('br')
                        .next('span')
                        .html('(' + res.qty + ') Sản phẩm - ' + res.total);


                    $('.mini-cart-list').load(location.href + ' .mini-cart-list > *');

                    alert('Đã thêm vào giỏ hàng');
                }
            });

        });
    </script>
    <script>

        let timeout;

        $('#search-product').on('keyup', function () {

            clearTimeout(timeout);

            let keyword = $(this).val();

            timeout = setTimeout(function () {

                let category = $('#category-search').val();

                $.ajax({
                    url: "{{ route('search.suggestion') }}",
                    type: "GET",
                    data: {
                        keyword: keyword,
                        category_id: category
                    },
                    success: function (products) {

                        let html = '';

                        products.forEach(product => {

                            html += `
                        <a class="search-item"
                           href="/products/${product.slug}">
                            <img src="/layout/images/products/${product.image}">
                            <span>${product.name}</span>
                        </a>
                    `;

                        });

                        $('#search-result').html(html).show();

                    }
                });

            }, 300);

        });

        $(document).click(function (e) {

            if (!$(e.target).closest('.search-box').length) {

                $('#search-result').hide();

            }

        });

    </script>
    <style>
        .search-cate {
            position: relative;
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        .search-result {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;

            background: #fff;
            border: 1px solid #eee;

            z-index: 9999;

            display: none;

            max-height: 400px;
            overflow-y: auto;

            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
        }

        .search-item {

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 10px;

            text-decoration: none;

            color: #333;
        }

        .search-item:hover {
            background: #f7f7f7;
        }

        .search-item img {

            width: 55px;
            height: 55px;

            object-fit: cover;
        }

        .search-item span {

            font-size: 14px;
        }
    </style>
</body>

</html>
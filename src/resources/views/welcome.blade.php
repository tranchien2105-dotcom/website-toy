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
                <p>Tạp hoá MinhChien</p>
                <div class="right-sec">
                    <ul>
                        <li><a href="#.">Đăng nhập/ Đăng ký </a></li>

                        <li>
                            <select class="selectpicker">
                                <option>English</option>
                                <option>Vietnamese</option>
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
                    <select class="selectpicker" name="category_id">
                        <option value="">Tất cả danh mục</option>

                        @php
                            $categories = getCategories();
                        @endphp

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="search" placeholder="Tìm kiếm sản phẩm...">
                    <button class="submit" type="submit"><i class="icon-magnifier"></i></button>
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
                            <strong>Giỏ hàng</strong> <br>

                            <span>
                                ({{ $totalQty }}) Sản phẩm -
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
                                    Giỏ hàng trống
                                </li>
                            @endforelse

                            <li class="btn-cart">
                                <a href="{{ route('layout.cart') }}" class="btn-round">
                                    Xem giỏ hàng
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
                            <i class="fa fa-list-ul"></i> Thể loại sản phẩm
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
                          
                            <li class="dropdown"> <a href="index.html" class="dropdown-toggle"
                                    data-toggle="dropdown">Trang web </a>
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
                    <div class="nav-right"> <span class="call-mun"><i class="fa fa-phone"></i> <strong>Điện thoại:</strong>
                            (+84) 123 456 7890</span> </div>
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
                        <li><a href="#.">Giới thiệu</a></li>
                        <li><a href="#.">Hỗ trợ khách hàng</a></li>
                        <li><a href="#.">Chính sách bảo mật</a></li>
                        <li><a href="#.">Sơ đồ website</a></li>
                        <li><a href="#.">Tìm kiếm sản phẩm</a></li>
                        <li><a href="#.">Tìm kiếm nâng cao</a></li>
                        <li><a href="#.">Đơn hàng & Đổi trả</a></li>
                        <li><a href="#.">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="row">

                    <!-- Contact -->
                    <div class="col-md-4">
                        <h4>Liện hệ với chúng tôi!</h4>
                        <p>Địa chỉ: 102/46 Hồ Biểu Chánh, Phường 11, Quận Phú Nhuận, TP.HCM,</p>
                        <p>Điện thoại: (+84) 123 456 7890</p>
                        <p>Email: info@minhchienstore.com</p>
                        <div class="social-links"> <a href="#."><i class="fa fa-facebook"></i></a> <a href="#."><i
                                    class="fa fa-twitter"></i></a> <a href="#."><i class="fa fa-linkedin"></i></a> <a
                                href="#."><i class="fa fa-pinterest"></i></a> <a href="#."><i
                                    class="fa fa-instagram"></i></a> <a href="#."><i class="fa fa-google"></i></a>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="col-md-3">
                        <h4>Thể loại</h4>
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
                        <h4>Hỗ trợ khách hàng</h4>
                        <ul class="links-footer">
                            <li><a href="#.">Chính sách giao hàng</a></li>
                            <li><a href="#.">Đổi trả & hoàn tiền</a></li>
                            <li><a href="#.">Hướng dẫn mua hàng</a></li>
                            <li><a href="#.">Phương thức thanh toán</a></li>
                            <li><a href="#.">Liên hệ hỗ trợ</a></li>
                        </ul>
                    </div>

                    <!-- Information -->
                    <div class="col-md-2">
                        <h4>Thông tin</h4>
                        <ul class="links-footer">
                            <li><a href="#.">Giới thiệu</a></li>
                            <li><a href="#.">Tin tức</a></li>
                            <li><a href="#.">Chính sách bảo mật</a></li>
                            <li><a href="#.">Điều khoản sử dụng</a></li>
                            <li><a href="#.">Hệ thống cửa hàng</a></li>
                            <li><a href="#.">Câu hỏi thường gặp</a></li>
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
                        <p>Copyright © 2026 <a href="#." class="ri-li"> Tạp hoá MinhChien</a>
                        <p>
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
</body>

</html>
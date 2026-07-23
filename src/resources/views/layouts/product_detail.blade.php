@extends('welcome')
@section('main')
    <div class="linking">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Trang chủ</a></li>
                <li><a href="#">{{ $product->category->name }}</a></li>
                <li class="active">{{ $product->name }}</li>
            </ol>
        </div>
    </div>

    <!-- Content -->
    <div id="content">

        <!-- Products -->
        <section class="padding-top-40 padding-bottom-60">
            <div class="container">
                <div class="row">

                    <!-- Shop Side Bar -->
                    <div class="col-md-3">
                        <div class="shop-side-bar">

                            <!-- Categories -->
                            <h6>Categories</h6>
                            <div class="checkbox checkbox-primary">
                                <ul></ul>
                                @forelse ($categories as $key => $category)

                                    <li>
                                        <input id="cate{{ $key }}" class="styled" type="checkbox">
                                        <label for="cate{{ $key }}"> {{ $category->name }} </label>
                                    </li>

                                @empty
                                    <p>No categories available.</p>
                                @endforelse
                                </ul>

                            </div>

                            <!-- Featured Brands -->
                            <h6>Featured Brands</h6>
                            <div class="checkbox checkbox-primary">
                                <ul>
                                    <li>
                                        <input id="brand1" class="styled" type="checkbox">
                                        <label for="brand1"> Apple <span>(217)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand2" class="styled" type="checkbox">
                                        <label for="brand2"> Acer <span>(79)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand3" class="styled" type="checkbox">
                                        <label for="brand3"> Asus <span>(283)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand4" class="styled" type="checkbox">
                                        <label for="brand4">Samsung <span>(116)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand5" class="styled" type="checkbox">
                                        <label for="brand5"> LG <span>(29)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand6" class="styled" type="checkbox">
                                        <label for="brand6"> Electrolux <span>(179)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand7" class="styled" type="checkbox">
                                        <label for="brand7"> Toshiba <span>(38)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand8" class="styled" type="checkbox">
                                        <label for="brand8"> Sharp <span>(205)</span> </label>
                                    </li>
                                    <li>
                                        <input id="brand9" class="styled" type="checkbox">
                                        <label for="brand9"> Sony <span>(35)</span> </label>
                                    </li>
                                </ul>
                            </div>

                            <!-- Rating -->
                            <h6>Rating</h6>
                            <div class="rating">
                                <ul>
                                    <li><a href="#."><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star-o"></i> <span>(218)</span></a></li>
                                    <li><a href="#."><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star-o"></i><i
                                                class="fa fa-star-o"></i> <span>(178)</span></a></li>
                                    <li><a href="#."><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i
                                                class="fa fa-star-o"></i> <span>(79)</span></a></li>
                                    <li><a href="#."><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i
                                                class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i
                                                class="fa fa-star-o"></i> <span>(188)</span></a></li>
                                </ul>
                            </div>

                            <!-- Colors -->
                            <h6>Size</h6>
                            <div class="sizes"> <a href="#.">S</a> <a href="#.">M</a> <a href="#.">L</a> <a href="#.">XL</a>
                            </div>

                            <!-- Colors -->
                            <h6>Colors</h6>
                            <div class="checkbox checkbox-primary">
                                <ul>
                                    <li>
                                        <input id="colr1" class="styled" type="checkbox">
                                        <label for="colr1"> Red <span>(217)</span> </label>
                                    </li>
                                    <li>
                                        <input id="colr2" class="styled" type="checkbox">
                                        <label for="colr2"> Yellow <span> (179) </span> </label>
                                    </li>
                                    <li>
                                        <input id="colr3" class="styled" type="checkbox">
                                        <label for="colr3"> Black <span>(79)</span> </label>
                                    </li>
                                    <li>
                                        <input id="colr4" class="styled" type="checkbox">
                                        <label for="colr4">Blue <span>(283) </span></label>
                                    </li>
                                    <li>
                                        <input id="colr5" class="styled" type="checkbox">
                                        <label for="colr5"> Grey <span> (116)</span> </label>
                                    </li>
                                    <li>
                                        <input id="colr6" class="styled" type="checkbox">
                                        <label for="colr6"> Pink<span> (29) </span></label>
                                    </li>
                                    <li>
                                        <input id="colr7" class="styled" type="checkbox">
                                        <label for="colr7"> White <span> (38)</span> </label>
                                    </li>
                                    <li>
                                        <input id="colr8" class="styled" type="checkbox">
                                        <label for="colr8">Green <span>(205)</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-md-9">
                        <div class="product-detail">
                            <div class="product">
                                <div class="row">
                                    <!-- Slider Thumb -->
                                    <div class="col-xs-5">
                                        <article class="slider-item on-nav">
                                            <div class="thumb-slider">
                                                <ul class="slides">
                                                    @foreach ($product->images as $image_data)
                                                        <li
                                                            data-thumb="{{ asset('layout/images/products/'. $product->slug . '/' . $image_data->image) }}">
                                                            <img src="{{ asset('layout/images/products/' . $product->slug . '/' . $image_data->image) }}"
                                                                alt="">
                                                        </li>

                                                    @endforeach
                                                </ul>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- Item Content -->
                                    <div class="col-xs-7"> <span class="tags">{{ $product->category->name }}</span>
                                        <h5>{{ $product->name }}</h5>
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span
                                                class="margin-left-10">({{ $product->review_count }}) Nhận xét</span>
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-6"><span
                                                    class="price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>Trạng thái: <span class="in-stock">Còn hàng</span></p>
                                            </div>
                                        </div>
                                        <!-- List Details -->
                                        <ul class="bullet-round-list">
                                            <li>Screen: 1920 x 1080 pixels</li>
                                            <li>Processor: 2.5 GHz None</li>
                                            <li>RAM: 8 GB</li>
                                            <li>Hard Drive: Flash memory solid state</li>
                                            <li>Graphics : Intel HD Graphics 520 Integrated</li>
                                            <li>Card Description: Integrated</li>
                                        </ul>
                                        <!-- Colors -->
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <div class="clr"> <span style="background:#068bcd"></span> <span
                                                        style="background:#d4b174"></span> <span
                                                        style="background:#333333"></span> </div>
                                            </div>
                                            <!-- Sizes -->
                                            <div class="col-xs-7">
                                                <div class="sizes"> <a href="#.">S</a> <a class="active" href="#.">M</a> <a
                                                        href="#.">L</a> <a href="#.">XL</a> </div>
                                            </div>
                                        </div>
                                        <!-- Compare Wishlist -->
                                        <ul class="cmp-list">
                                            <li><a href="#."><i class="fa fa-heart"></i> Add to Wishlist</a></li>
                                            <li><a href="#."><i class="fa fa-navicon"></i> Add to Compare</a></li>
                                            <li><a href="#."><i class="fa fa-envelope"></i> Email to a friend</a></li>
                                        </ul>
                                        <!-- Quinty -->
                                        <div class="quinty">
                                            <input type="number" value="01">
                                        </div>
                                        <a href="{{ route('cart.add', $product->id) }}" class="btn-round"><i
                                                class="icon-basket-loaded margin-right-5"></i> Thêm vào giỏ hàng</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Tab Section-->
                            <div class="item-tabs-sec">

                                <!-- Nav tabs -->
                                <ul class="nav" role="tablist">
                                    <li role="presentation" class="active"><a href="#pro-detil" role="tab"
                                            data-toggle="tab">Product Details</a></li>
                                    <li role="presentation"><a href="#cus-rev" role="tab" data-toggle="tab">Customer
                                            Reviews</a></li>
                                    <li role="presentation"><a href="#ship" role="tab" data-toggle="tab">Shipping &
                                            Payment</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="pro-detil">
                                        <!-- List Details -->
                                        <ul class="bullet-round-list">
                                            <li>Power Smartphone 7s G930F 128GB International version - Silver</li>
                                            <li> 2G bands: GSM 850 / 900 / 1800 / 1900 3G bands: HSDPA 850 / 900 / 1900 /
                                                2100 4G bands: LTE 700 / 800 / 850<br>
                                                900 / 1800 / 1900 / 2100 / 2600</li>
                                            <li> Dimensions: 142.4 x 69.6 x 7.9 mm (5.61 x 2.74 x 0.31 in) Weight 152 g
                                                (5.36 oz)</li>
                                            <li> IP68 certified - dust proof and water resistant over 1.5 meter and 30
                                                minutes</li>
                                            <li> Internal: 128GB, 4 GB RAM </li>
                                        </ul>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Carrier</th>
                                                        <th>Compatibility Rating </th>
                                                        <th>Voice / Text </th>
                                                        <th>Voice / Text </th>
                                                        <th>2G Data </th>
                                                        <th>3G Data </th>
                                                        <th>4G LTE Data </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>AT&T </td>
                                                        <td>Fully Compatible</td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sprint </td>
                                                        <td>No Voice/Text and Partial Data Connection</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Q-Mobile </td>
                                                        <td>Partial Data Connection</td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Verizon Wireless </td>
                                                        <td>No Votice/Text and Partial Data Connection</td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                        <td class="text-center"><i class="fa fa-check"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="cus-rev"></div>
                                    <div role="tabpanel" class="tab-pane fade" id="ship"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Related Products -->
                        <section class="padding-top-30 padding-bottom-0">
                            <!-- heading -->
                            <div class="heading">
                                <h2>Related Products</h2>
                                <hr>
                            </div>
                            <!-- Items Slider -->
                            <div class="item-slide-4 with-nav">
                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-1.jpg" alt="">
                                        <!-- Content -->
                                        <span class="tag">Latop</span> <a href="#." class="tittle">Laptop Alienware 15 i7
                                            Perfect For Playing Game</a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00 </div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>
                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-2.jpg" alt=""> <span
                                            class="sale-tag">-25%</span>

                                        <!-- Content -->
                                        <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible
                                            Deportivo Slim Con 8GB</a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00 <span>$200.00</span></div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>

                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-3.jpg" alt="">
                                        <!-- Content -->
                                        <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente
                                            Smart Watch M26 Touch </a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00</div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>

                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-4.jpg" alt=""> <span
                                            class="new-tag">New</span>

                                        <!-- Content -->
                                        <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado Inalambrico
                                            Bluetooth Con Air Mouse</a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00</div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>

                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-5.jpg" alt="">
                                        <!-- Content -->
                                        <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook 7"
                                            128GB full HD</a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00</div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>

                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-6.jpg" alt=""> <span
                                            class="sale-tag">-25%</span>

                                        <!-- Content -->
                                        <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible
                                            Deportivo Slim Con 8GB</a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00 <span>$200.00</span></div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>

                                <!-- Product -->
                                <div class="product">
                                    <article> <img class="img-responsive" src="images/item-img-1-7.jpg" alt="">
                                        <!-- Content -->
                                        <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente
                                            Smart Watch M26 Touch </a>
                                        <!-- Reviews -->
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
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
                                        <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                class="fa fa-star"></i><i class="fa fa-star"></i> <i
                                                class="fa fa-star-o"></i> <span class="margin-left-10">5 Review(s)</span>
                                        </p>
                                        <div class="price">$350.00</div>
                                        <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                                    </article>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>

        <!-- Your Recently Viewed Items -->
        <section class="padding-bottom-60">
            <div class="container">

                <!-- heading -->
                <div class="heading">
                    <h2>Your Recently Viewed Items</h2>
                    <hr>
                </div>
                <!-- Items Slider -->
                <div class="item-slide-5 with-nav">
                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-1.jpg" alt="">
                            <!-- Content -->
                            <span class="tag">Latop</span> <a href="#." class="tittle">Laptop Alienware 15 i7 Perfect For
                                Playing Game</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00 </div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>
                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-2.jpg" alt=""> <span
                                class="sale-tag">-25%</span>

                            <!-- Content -->
                            <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible Deportivo Slim Con
                                8GB</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00 <span>$200.00</span></div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-3.jpg" alt="">
                            <!-- Content -->
                            <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente Smart Watch
                                M26 Touch Bluetooh </a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00</div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-4.jpg" alt=""> <span
                                class="new-tag">New</span>

                            <!-- Content -->
                            <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado Inalambrico Bluetooth
                                Con Air Mouse</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00</div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-5.jpg" alt="">
                            <!-- Content -->
                            <span class="tag">Appliances</span> <a href="#." class="tittle">Funda Para Ebook 7" 128GB full
                                HD</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00</div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-6.jpg" alt=""> <span
                                class="sale-tag">-25%</span>

                            <!-- Content -->
                            <span class="tag">Tablets</span> <a href="#." class="tittle">Mp3 Sumergible Deportivo Slim Con
                                8GB</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00 <span>$200.00</span></div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-7.jpg" alt="">
                            <!-- Content -->
                            <span class="tag">Appliances</span> <a href="#." class="tittle">Reloj Inteligente Smart Watch
                                M26 Touch Bluetooh </a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00</div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
                        </article>
                    </div>

                    <!-- Product -->
                    <div class="product">
                        <article> <img class="img-responsive" src="images/item-img-1-8.jpg" alt=""> <span
                                class="new-tag">New</span>

                            <!-- Content -->
                            <span class="tag">Accessories</span> <a href="#." class="tittle">Teclado Inalambrico Bluetooth
                                Con Air Mouse</a>
                            <!-- Reviews -->
                            <p class="rev"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span class="margin-left-10">5
                                    Review(s)</span></p>
                            <div class="price">$350.00</div>
                            <a href="#." class="cart-btn"><i class="icon-basket-loaded"></i></a>
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
    </div>
@endsection
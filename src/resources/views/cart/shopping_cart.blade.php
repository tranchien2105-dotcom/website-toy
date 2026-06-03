@extends('welcome')

@section('main')
    <!-- Ship Process -->
    <div class="ship-process padding-top-30 padding-bottom-30">
        <div class="container">
            <ul class="row">

                <!-- Step 1 -->
                <li class="col-sm-3 current">
                    <div class="media-left"><i class="flaticon-shopping"></i></div>
                    <div class="media-body">
                        <span>Bước 1</span>
                        <h6>Giỏ hàng</h6>
                    </div>
                </li>

                <!-- Step 2 -->
                <li class="col-sm-3">
                    <div class="media-left"><i class="flaticon-business"></i></div>
                    <div class="media-body">
                        <span>Bước 2</span>
                        <h6>Thanh toán</h6>
                    </div>
                </li>

                <!-- Step 3 -->
                <li class="col-sm-3">
                    <div class="media-left"><i class="flaticon-delivery-truck"></i></div>
                    <div class="media-body">
                        <span>Bước 3</span>
                        <h6>Giao hàng</h6>
                    </div>
                </li>

                <!-- Step 4 -->
                <li class="col-sm-3">
                    <div class="media-left"><i class="fa fa-check"></i></div>
                    <div class="media-body">
                        <span>Bước 4</span>
                        <h6>Xác nhận</h6>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Shopping Cart -->
    <section class="shopping-cart padding-bottom-60">
        <div class="container">

            @php $grandTotal = 0; @endphp

            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Thành tiền</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($cartItems as $item)
                        @php
                            $subTotal = $item['price'] * $item['quantity'];
                            $grandTotal += $subTotal;
                        @endphp

                        <tr class="cart-row">
                            <td>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="img-responsive"
                                                src="{{ asset('layout/images/products/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                width="80">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <p>{{ $item['name'] }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center padding-top-60 price"
                                data-price="{{ $item['price'] }}">
                                {{ number_format($item['price'], 0, ',', '.') }}₫
                            </td>

                            <td class="text-center">
                                <div class="quinty padding-top-20">
                                    <input type="number"
                                        class="qty-input"
                                        value="{{ $item['quantity'] }}"
                                        min="1">
                                </div>
                            </td>

                            <td class="text-center padding-top-60 row-total">
                                {{ number_format($subTotal, 0, ',', '.') }}₫
                            </td>

                            <td class="text-center padding-top-60">
                                <a href="{{ route('layout.cart.remove', $item['id']) }}" class="remove">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Giỏ hàng trống
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Promotion -->
            <div class="promo">
                <div class="coupen">
                    <label>
                        Mã giảm giá
                        <input type="text" placeholder="Nhập mã giảm giá">
                        <button type="submit">
                            <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </label>
                </div>

                <!-- Grand total -->
                <div class="g-totel">
                    <h5>
                        Tổng cộng:
                        <span id="grand-total">
                            {{ number_format($grandTotal, 0, ',', '.') }}₫
                        </span>
                    </h5>
                </div>
            </div>

            <!-- Button -->
            <div class="pro-btn">
                <a href="{{ url('/') }}" class="btn-round btn-light">
                    Tiếp tục mua hàng
                </a>

                <a href="" class="btn-round">
                    Thanh toán
                </a>
            </div>

        </div>
    </section>

    <script>
        function formatMoney(number) {
            return new Intl.NumberFormat('vi-VN').format(number) + '₫';
        }

        function updateCart() {
            let grandTotal = 0;

            document.querySelectorAll('.cart-row').forEach(function(row) {
                let price = parseInt(row.querySelector('.price').dataset.price);
                let qty = parseInt(row.querySelector('.qty-input').value);

                if (qty < 1 || isNaN(qty)) qty = 1;

                let total = price * qty;

                row.querySelector('.qty-input').value = qty;
                row.querySelector('.row-total').innerText = formatMoney(total);

                grandTotal += total;
            });

            document.getElementById('grand-total').innerText = formatMoney(grandTotal);
        }

        document.querySelectorAll('.qty-input').forEach(function(input) {
            input.addEventListener('input', updateCart);
        });
    </script>
@endsection
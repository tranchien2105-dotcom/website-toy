@extends('welcome')

@section('main')
    <!-- Ship Process -->
    @include('cart.ship_process', ['step' => 1])

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
                                                alt="{{ $item['name'] }}" width="80">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <p>{{ $item['name'] }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center padding-top-60 price" data-price="{{ $item['price'] }}">
                                {{ number_format($item['price'], 0, ',', '.') }}₫
                            </td>

                            <td class="text-center">
                                <div class="quinty padding-top-20">
                                    <input type="number" class="qty-input" data-id="{{ $item['id'] }}"
                                        value="{{ $item['quantity'] }}" min="1">
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

                <a href="{{ route('checkout') }}" class="btn-round">
                    Thanh toán
                </a>
            </div>

        </div>
    </section>

    <script>
        function updateQty(input) {

            let id = input.dataset.id;
            let qty = parseInt(input.value);

            if (qty < 1 || isNaN(qty)) {
                qty = 1;
                input.value = 1;
            }

            fetch("{{ route('layout.cart.update') }}", {

                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },

                body: JSON.stringify({
                    id: id,
                    quantity: qty
                })

            })
                .then(res => res.json())
                .then(data => {

                    let row = input.closest(".cart-row");

                    row.querySelector(".row-total").innerText = data.rowTotal;

                    document.getElementById("grand-total").innerText = data.grandTotal;

                });

        }

        document.querySelectorAll(".qty-input").forEach(function (input) {

            input.addEventListener("change", function () {

                updateQty(this);

            });

        });
    </script>
@endsection
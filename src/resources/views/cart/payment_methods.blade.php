@extends('welcome')

@section('main')

    @include('cart.ship_process', ['step' => 2])

    <section class="padding-bottom-60">
        <div class="container">

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- LEFT --}}
                    <div class="col-lg-7">

                        <div class="heading">
                            <h2>Thông tin giao hàng</h2>
                            <hr>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <label>Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Trần Minh Chiến"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label>Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="03xxxxxxxx" required>
                            </div>

                            <div class="col-md-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@gmail.com">
                            </div>

                            <div class="col-md-12">
                                <label>Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" placeholder="123 Nguyễn Huệ"
                                    required>
                            </div>

                            <div class="col-md-12">
                                <label>Ghi chú</label>
                                <textarea name="note" rows="4" class="form-control"
                                    placeholder="Giao giờ hành chính..."></textarea>
                            </div>

                        </div>

                        <br>

                        <div>
                            <h2 style="font-size: 20px; margin: 0px; margin-bottom: 20px;">Phương thức thanh toán</h2>
                            <hr>
                        </div>

                        <div>
                            <label>
                                <input type="radio" name="payment_method" value="COD" checked>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div>
                            <label>
                                <input type="radio" name="payment_method" value="BANK">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>

                        <div>
                            <label>
                                <input type="radio" name="payment_method" value="VNPAY">
                                Thanh toán qua VNPay
                            </label>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-lg-5">

                        <div class="heading">
                            <h2>Đơn hàng của bạn</h2>
                            <hr>
                        </div>

                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">SL</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($cartItems as $item)

                                    <tr>

                                        <td>

                                            <div class="media">

                                                <div class="media-left">

                                                    <img src="{{ asset('layout/images/products/' . $item['image']) }}"
                                                        width="60" class="img-responsive" alt="{{ $item['name'] }}">

                                                </div>

                                                <div class="media-body" style="padding-left:10px">

                                                    <strong>{{ $item['name'] }}</strong>

                                                    <br>

                                                    <small>
                                                        {{ number_format($item['price'], 0, ',', '.') }}₫
                                                    </small>

                                                </div>

                                            </div>

                                        </td>

                                        <td class="text-center">
                                            {{ $item['quantity'] }}
                                        </td>

                                        <td class="text-right">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="text-center">
                                            Giỏ hàng đang trống.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                            <tfoot>

                                <tr>

                                    <th colspan="2">
                                        Tạm tính
                                    </th>

                                    <th class="text-right">
                                        {{ number_format($subtotal, 0, ',', '.') }}₫
                                    </th>

                                </tr>

                                <tr>

                                    <th colspan="2">
                                        Phí vận chuyển
                                    </th>

                                    <th class="text-right">
                                        {{ number_format($shipping, 0, ',', '.') }}₫
                                    </th>

                                </tr>

                                <tr>

                                    <th colspan="2">
                                        Giảm giá
                                    </th>

                                    <th class="text-right text-success">
                                        -{{ number_format($discount, 0, ',', '.') }}₫
                                    </th>

                                </tr>

                                <tr class="success">

                                    <th colspan="2">
                                        Tổng thanh toán
                                    </th>

                                    <th class="text-right" style="font-size:22px;color:#e60000">

                                        {{ number_format($total, 0, ',', '.') }}₫

                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal"
                            data-target="#confirmOrderModal">

                            <i class="fa fa-shopping-cart"></i>
                            ĐẶT HÀNG

                        </button>

                    </div>

                </div>

                <div class="modal fade" id="confirmOrderModal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">

                            <div class="modal-header" style="background:#337ab7;color:#fff;">

                                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1">
                                    &times;
                                </button>

                                <h4 class="modal-title" style="color: #fff;">
                                    <i class="fa fa-check-circle" style="color: #fff;"></i>
                                    Xác nhận đặt hàng
                                </h4>

                            </div>

                            <div class="modal-body">

                                <div class="alert alert-info text-center">

                                    <i class="fa fa-shopping-cart fa-3x"></i>

                                    <h4 style="margin-top:15px;margin-bottom:10px;">
                                        Bạn sắp đặt một đơn hàng
                                    </h4>

                                    <p style="margin-bottom:0">
                                        Vui lòng kiểm tra lại thông tin trước khi xác nhận.
                                    </p>

                                </div>

                                <table class="table table-bordered table-striped">

                                    <tbody>

                                        <tr>
                                            <td>
                                                <i class="fa fa-money text-primary"></i>
                                                Tạm tính
                                            </td>

                                            <td class="text-right">
                                                {{ number_format($subtotal) }}₫
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa fa-truck text-info"></i>
                                                Phí vận chuyển
                                            </td>

                                            <td class="text-right">
                                                {{ number_format($shipping) }}₫
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa fa-tag text-success"></i>
                                                Giảm giá
                                            </td>

                                            <td class="text-right text-success">
                                                -{{ number_format($discount) }}₫
                                            </td>
                                        </tr>

                                        <tr class="danger">

                                            <th style="font-size:17px">
                                                Tổng thanh toán
                                            </th>

                                            <th class="text-right text-danger" style="font-size:22px">

                                                {{ number_format($total) }}₫

                                            </th>

                                        </tr>

                                    </tbody>

                                </table>

                                <div class="alert alert-warning" style="margin-bottom:0">

                                    <i class="fa fa-exclamation-triangle"></i>

                                    Sau khi xác nhận, đơn hàng sẽ được tạo và gửi đến hệ thống.
                                    Bạn sẽ không thể chỉnh sửa trực tiếp đơn hàng sau khi đặt.

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal">

                                    <i class="fa fa-times"></i>
                                    Hủy

                                </button>

                                <button type="submit" class="btn btn-success">

                                    <i class="fa fa-check"></i>
                                    Xác nhận đặt hàng

                                </button>

                            </div>

                        </div>
                    </div>
                </div>

            </form>

        </div>
    </section>



@endsection
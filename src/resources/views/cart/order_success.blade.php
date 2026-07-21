@extends('welcome')

@section('main')

    @include('cart.ship_process', ['step' => 4])

    <section class="padding-top-60 padding-bottom-60">
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-12">

                    <div class="panel panel-default text-center">

                        <div class="panel-body" style="padding:50px">

                            <i class="fa fa-check-circle text-success" style="font-size:80px;margin-bottom:20px;"></i>

                            <h2 class="text-success">
                                Đặt hàng thành công!
                            </h2>

                            <p class="text-muted">
                                Cảm ơn bạn đã mua sắm tại cửa hàng.
                                Chúng tôi sẽ xác nhận đơn hàng trong thời gian sớm nhất.
                            </p>

                            <hr>

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>
                                        <th width="35%">Mã đơn hàng</th>
                                        <td>
                                            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Ngày đặt</th>
                                        <td>
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Phương thức thanh toán</th>
                                        <td>
                                            {{ strtoupper($order->payment_method) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span class="label label-warning">
                                                Chờ xác nhận
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Tổng thanh toán</th>
                                        <td style="font-size:22px;color:#d9534f;font-weight:bold">

                                            {{ number_format($order->total, 0, ',', '.') }}₫

                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                            <div style="margin-top:30px">

                                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">

                                    <i class="fa fa-shopping-bag"></i>

                                    Tiếp tục mua sắm

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
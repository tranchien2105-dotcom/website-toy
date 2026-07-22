<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật đơn hàng</title>
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd;color:#fff;padding:20px;text-align:center;">
                            <h1 style="margin:0;">🛒 Toy Store</h1>
                            <p style="margin:8px 0 0;">Thông báo cập nhật đơn hàng</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;color:#333;">

                            <h2>Xin chào {{ $order->customer_name }},</h2>

                            <p>
                                Cảm ơn bạn đã mua hàng tại
                                <strong>Toy Store</strong>.
                            </p>

                            <p>
                                Đơn hàng <strong>#{{ $order->order_code }}</strong>
                                vừa được cập nhật trạng thái.
                            </p>

                            <table width="100%" cellpadding="10" style="border-collapse:collapse;margin:25px 0;">
                                <tr style="background:#f8f9fa;">
                                    <td><strong>Mã đơn hàng</strong></td>
                                    <td>#{{ $order->order_code }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Khách hàng</strong></td>
                                    <td>{{ $order->customer_name }}</td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <td><strong>Trạng thái</strong></td>
                                    <td>
                                        <span
                                            style="background:#198754;color:#fff;padding:6px 12px;border-radius:20px;">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p>
                                Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với
                                chúng tôi để được hỗ trợ.
                            </p>

                            <div style="text-align:center;margin-top:30px;">
                                <a href="{{ url('/') }}"
                                    style="background:#0d6efd;color:#fff;text-decoration:none;padding:12px 25px;border-radius:5px;display:inline-block;">
                                    Truy cập cửa hàng
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8f9fa;padding:20px;text-align:center;color:#777;font-size:13px;">
                            © {{ date('Y') }} Toy Store. All rights reserved.<br>
                            Email này được gửi tự động, vui lòng không trả lời.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
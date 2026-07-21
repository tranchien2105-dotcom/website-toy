<template>
    <div class="order-page">

        <h1 class="title">Quản lý đơn hàng</h1>

        <div class="toolbar">

            <input v-model="keyword" type="text" class="input" placeholder="🔍 Tìm kiếm khách hàng...">

            <select v-model="status" class="select">
                <option value="">Tất cả trạng thái</option>
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="shipping">Đang giao hàng</option>
                <option value="completed">Hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>

            <button class="search-btn" @click="loadData">
                🔍 Tìm kiếm
            </button>

        </div>
        

        <table class="order-table">

            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <tr v-if="orders.data.length === 0">
                    <td colspan="7" class="empty">
                        📭 Không có đơn hàng nào
                    </td>
                </tr>

                <tr v-for="item in orders.data" :key="item.id">
                    <td>
                        <strong>#{{ item.order_code }}</strong>
                    </td>

                    <td>
                        {{ item.fullname }}
                    </td>

                    <td>
                        {{ item.phone }}
                    </td>

                    <td>
                        {{ formatMoney(item.total) }}
                    </td>

                    <td>
                        {{ paymentText(item.payment_method) }}
                    </td>

                    <td>
                        <span class="status" :class="badge(item.status)">
                            {{ statusText(item.status) }}
                        </span>
                    </td>

                    <td>
                        {{ formatDate(item.created_at) }}
                    </td>

                    <td>
                        <router-link :to="'/orders/' + item.id" class="view-btn">
                            👁️ Xem
                        </router-link>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const orders = ref({
    data: []
});

const keyword = ref("");
const status = ref("");

const loadData = async () => {
    try {
        const res = await axios.get("/api/orders", {
            params: {
                keyword: keyword.value,
                status: status.value
            }
        });

        orders.value = res.data.orders;
    } catch (error) {
        console.error("Lỗi tải danh sách đơn hàng:", error);
    }
};

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "2-digit", day: "2-digit" };
    return new Date(dateString).toLocaleDateString("vi-VN", options);
};

onMounted(() => {
    loadData();
});

const formatMoney = (value) => {
    if (!value) return "0 đ";

    return Number(value).toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND",
        maximumFractionDigits: 0
    });
};

/**
 * Hiển thị trạng thái bằng tiếng Việt
 */
const statusText = (status) => {
    status = String(status).trim().toLowerCase();

    const map = {
        pending: "Chờ xác nhận",
        confirmed: "Đã xác nhận",
        shipping: "Đang giao hàng",
        completed: "Hoàn thành",
        cancelled: "Đã hủy"
    };

    return map[status] || "Không xác định";
};

/**
 * Class màu badge
 */
const badge = (status) => {
    status = String(status).trim().toLowerCase();

    const map = {
        pending: "pending",
        confirmed: "confirmed",
        shipping: "shipping",
        completed: "completed",
        cancelled: "cancelled"
    };

    return map[status] || "unknown";
};

/**
 * Phương thức thanh toán
 */
const paymentText = (payment) => {
    payment = String(payment).trim().toLowerCase();

    const map = {
        cod: "💵 Thanh toán khi nhận",
        bank: "🏦 Chuyển khoản",
        vnpay: "💳 VNPay"
    };

    return map[payment] || payment;
};
</script>
<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f5f7fb;
}

.order-page {
    width: 95%;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
    overflow-x: auto;
}

.title {
    margin-bottom: 25px;
    color: #222;
    font-size: 28px;
    font-weight: bold;
}

.toolbar {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

.input,
.select {
    height: 46px;
    padding: 0 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: .25s;
    font-size: 15px;
}

.input {
    width: 320px;
}

.select {
    width: 180px;
}

.input:focus,
.select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
}

.search-btn {
    height: 46px;
    padding: 0 24px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: .25s;
    font-weight: 600;
}

.search-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

.order-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.order-table th {
    background: #2563eb;
    color: white;
    padding: 16px;
    text-transform: uppercase;
    letter-spacing: .5px;
    font-size: 13px;
}

.order-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    text-align: center;
    font-size: 14px;
}

.order-table tbody tr:nth-child(even) {
    background: #fafafa;
}

.order-table tbody tr:hover {
    background: #eef5ff;
    transition: .2s;
}

/* ID */
.order-table td:nth-child(1) {
    font-weight: bold;
    color: #333;
}

/* Khách hàng */
.order-table td:nth-child(2) {
    text-align: left;
    font-weight: 600;
}

/* SĐT */
.order-table td:nth-child(3) {
    font-family: monospace;
}

/* Tổng tiền */
.order-table td:nth-child(4) {
    color: #dc2626;
    font-weight: bold;
    font-size: 15px;
}

/* Badge */
.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 130px;
    height: 34px;
    padding: 0 16px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
    font-weight: 600;
}

.pending {
    background: #f59e0b;
}

.confirmed {
    background: #10b981;
}

.shipping {
    background: #3b82f6;
}

.completed {
    background: #22c55e;
}

.cancelled {
    background: #ef4444;
}

.unknown {
    background: #6b7280;
}

/* Button */
.view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    background: #2563eb;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: .25s;
}

.view-btn:hover {
    background: #1e40af;
    transform: translateY(-1px);
}

/* Empty */
.empty {
    padding: 50px;
    text-align: center;
    color: #999;
    font-size: 16px;
}

/* Responsive */
@media (max-width: 768px) {

    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .input,
    .select,
    .search-btn {
        width: 100%;
    }

    .title {
        font-size: 22px;
    }
}
</style>
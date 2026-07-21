    <template>

        <div class="page">

            <div class="header">

                <router-link to="/orders" class="back-btn">
                    ← Quay lại
                </router-link>

                <h1>Chi tiết đơn hàng #{{ order.order_code }}</h1>

            </div>

            <div v-if="loading" class="loading">

                Đang tải...

            </div>

            <template v-else>

                <div class="card">

                    <h2>Thông tin khách hàng</h2>

                    <div class="info-grid">

                        <div>

                            <label>Họ tên</label>

                            <p>{{ order.fullname }}</p>

                        </div>

                        <div>

                            <label>Số điện thoại</label>

                            <p>{{ order.phone }}</p>

                        </div>

                        <div>

                            <label>Email</label>

                            <p>{{ order.email }}</p>

                        </div>

                        <div>

                            <label>Thanh toán</label>

                            <p>{{ order.payment_method }}</p>

                        </div>

                        <div>

                            <label>Địa chỉ</label>

                            <p>{{ order.address }}</p>

                        </div>

                        <div>

                            <label>Ghi chú</label>

                            <p>{{ order.note || "Không có" }}</p>

                        </div>

                    </div>

                </div>

                <div class="card">

                    <h2>Sản phẩm</h2>

                    <table class="product-table">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr v-for="(item, index) in order.details" :key="item.id">

                                <td>{{ index + 1 }}</td>

                                <td>{{ item.product.name }}</td>

                                <td>{{ money(item.price) }}</td>

                                <td>{{ item.quantity }}</td>

                                <td>{{ money(item.price * item.quantity) }}</td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="card total-card">

                    <h2>Thanh toán</h2>

                    <div class="row">

                        <span>Tạm tính</span>

                        <span>{{ money(order.subtotal) }}</span>

                    </div>

                    <div class="row">

                        <span>Phí vận chuyển</span>

                        <span>{{ money(order.shipping) }}</span>

                    </div>

                    <div class="row">

                        <span>Giảm giá</span>

                        <span>- {{ money(order.discount) }}</span>

                    </div>

                    <div class="row total">

                        <span>Tổng cộng</span>

                        <span>{{ money(order.total) }}</span>

                    </div>

                    <div class="status-box">

                        <label>Trạng thái</label>

                        <select v-model="order.status">
                            <option value="pending">Chờ xử lý</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="shipping">Đang giao hàng</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>

                    </div>

                    <button class="save-btn" @click="updateStatus">
                        Cập nhật trạng thái
                    </button>

                </div>

            </template>

        </div>

    </template>

<script setup>

import { ref, onMounted } from "vue";

import { useRoute } from "vue-router";

import axios from "axios";

const route = useRoute();

const loading = ref(true);

const order = ref({

    details: []

});

const loadOrder = async () => {

    const res = await axios.get("/api/orders/" + route.params.id);

    order.value = res.data.order;

    loading.value = false;

}

const updateStatus = async () => {

    await axios.put("/api/orders/status/" + order.value.id, {

        status: order.value.status

    });

    alert("Cập nhật thành công.");

}

const money = (value) => {

    return Number(value).toLocaleString("vi-VN") + " đ";

}

onMounted(loadOrder);

</script>

<style scoped>
* {
    box-sizing: border-box;
}

.page {
    max-width: 1300px;
    margin: auto;
    padding: 20px;
    background: #f4f6f9;
    min-height: 100vh;
}

/* ================= Header ================= */

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header h1 {
    margin: 0;
    font-size: 32px;
    color: #2c3e50;
    font-weight: 700;
}

.back-btn {
    text-decoration: none;
    background: #3498db;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    transition: .25s;
    font-weight: 600;
}

.back-btn:hover {
    background: #2980b9;
}

/* ================= Card ================= */

.card {
    background: white;
    border-radius: 14px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
}

.card h2 {
    margin: 0 0 20px;
    color: #34495e;
    font-size: 22px;
    border-left: 5px solid #3498db;
    padding-left: 12px;
}

/* ================= Customer Info ================= */

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 22px;
}

.info-grid label {
    display: block;
    color: #888;
    font-size: 13px;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.info-grid p {
    margin: 0;
    font-size: 17px;
    color: #2c3e50;
    font-weight: 500;
}

/* ================= Table ================= */

.product-table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
}

.product-table thead {
    background: #3498db;
    color: white;
}

.product-table th,
.product-table td {
    padding: 16px;
    text-align: center;
}

.product-table tbody tr {
    border-bottom: 1px solid #eee;
    transition: .2s;
}

.product-table tbody tr:hover {
    background: #f8fbff;
}

.product-table td:nth-child(2) {
    text-align: left;
}

/* ================= Total ================= */

.total-card {
    max-width: 500px;
    margin-left: auto;
}

.row {
    display: flex;
    justify-content: space-between;
    margin: 15px 0;
    font-size: 17px;
    color: #555;
}

.total {
    border-top: 2px dashed #ddd;
    padding-top: 18px;
    margin-top: 18px;
    font-size: 24px;
    font-weight: bold;
    color: #27ae60;
}

/* ================= Status ================= */

.status-box {
    margin-top: 25px;
}

.status-box label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #444;
}

.status-box select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    outline: none;
    transition: .2s;
}

.status-box select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, .2);
}

/* ================= Button ================= */

.save-btn {
    margin-top: 25px;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    font-size: 17px;
    cursor: pointer;
    transition: .25s;
    font-weight: bold;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(52, 152, 219, .35);
}

.save-btn:active {
    transform: scale(.98);
}

/* ================= Loading ================= */

.loading {
    text-align: center;
    padding: 80px;
    font-size: 22px;
    color: #777;
}

/* ================= Responsive ================= */

@media (max-width:768px) {

    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .header h1 {
        font-size: 24px;
    }

    .product-table {
        display: block;
        overflow-x: auto;
    }

    .total-card {
        max-width: 100%;
    }
}
</style>
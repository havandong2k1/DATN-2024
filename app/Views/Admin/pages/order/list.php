<div class="dash-content">
    <h1 class="dash-title">Trang chủ / Danh sách đơn hàng</h1>
    <div class="row">
        <div class="col-lg-12">
            <?= view('messages/message') ?>
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="easion-card-title">Danh sách đơn hàng</div>
                </div>
                <div class="card-body">
                    <!-- Kiểm tra nếu có đơn hàng -->
                    <?php if (!empty($orders)): ?>
                        <table class="table table-striped" id="order-table">
                            <thead>
                                <tr>
                                    <th>ID Đơn hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số tiền</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Trạng thái thanh toán</th>
                                    <th>Trạng thái đơn hàng</th> <!-- Thêm cột trạng thái đơn hàng -->
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Duyệt qua tất cả đơn hàng -->
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= $order['order_code'] ?></td>
                                        <td><?= $order['customer_name'] ?></td>
                                        <td style="width: 150px"><?= number_format($order['total_amount'], 0, ',', '.') ?> ₫</td>
                                        <td><?= $order['customer_email'] ?></td>
                                        <td><?= $order['customer_phone'] ?></td>
                                        <td><?= $order['customer_address'] ?></td>
                                        <td style="width: 200px">
                                            <span class="payment-status <?= $order['payment_status'] == 'paid' ? 'paid' : 'unpaid' ?>">
                                                <?= $order['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                            </span>
                                        </td>
                                        <td style="width: 150px">
                                            <span class="order-status <?= $order['order_status'] ?>">
                                                <?php
                                                    switch ($order['order_status']) {
                                                        case 'pending':
                                                            echo 'Chờ xử lý';
                                                            break;
                                                        case 'processing':
                                                            echo 'Đang xử lý';
                                                            break;
                                                        case 'shipped':
                                                            echo 'Đang giao hàng';
                                                            break;
                                                        case 'delivered':
                                                            echo 'Đã giao';
                                                            break;
                                                        case 'cancelled':
                                                            echo 'Đã hủy';
                                                            break;
                                                        default:
                                                            echo 'Chưa xác định';
                                                    }
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/order/edit/' . $order['id_order']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                                            <a href="<?= base_url('admin/order/delete/' . $order['id_order']) ?>" class="btn btn-danger btn-sm">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Không có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Tooltip for payment status
    $('.payment-status').hover(function() {
        var status = $(this).text();
        $(this).attr('title', 'Trạng thái thanh toán: ' + status);
    });

    // Tooltip for order status
    $('.order-status').hover(function() {
        var status = $(this).text();
        $(this).attr('title', 'Trạng thái đơn hàng: ' + status);
    });
</script>
<style>
    /* Payment status styles */
.payment-status {
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 4px;
}

.payment-status.paid {
    background-color: #28a745; /* Green for paid */
    color: white;
}

.payment-status.unpaid {
    background-color: #dc3545; /* Red for unpaid */
    color: white;
}

/* Order status styles */
.order-status {
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 4px;
}

.order-status.pending {
    background-color: #ffc107; /* Yellow for pending */
    color: black;
}

.order-status.processing {
    background-color: #17a2b8; /* Blue for processing */
    color: white;
}

.order-status.shipped {
    background-color: #007bff; /* Blue for shipped */
    color: white;
}

.order-status.delivered {
    background-color: #28a745; /* Green for delivered */
    color: white;
}

.order-status.cancelled {
    background-color: #dc3545; /* Red for cancelled */
    color: white;
}

</style>
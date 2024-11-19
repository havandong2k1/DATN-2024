<?php include 'templates/header.php'; ?>
<style>
    .icon-pending { color: orange; }
    .icon-processing { color: blue; }
    .icon-shipped { color: purple; }
    .icon-delivered { color: green; }
    .icon-cancelled { color: red; }
    .tooltip-inner {
        text-align: center;
    }
</style>

<div class="container gray-background mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <h1>Thông tin người dùng</h1>
                    <h5>Tên người dùng: <?= session()->get("customer_name") ?></h5>
                    <hr>
                    <h5>Email: <?= session()->get("customer_email") ?></h5>
                    <hr>
                    <h5>Ngày tạo: <?= session()->get("created_at") ?></h5>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <h2>Danh sách đơn hàng gần đây</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class='text-center'>Mã đơn hàng</th>
                        <th class='text-center'>Ngày đặt</th>
                        <th class='text-center'>Tổng tiền</th>
                        <th class='text-center'>Trạng thái</th>
                        <th class='text-center'>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class='text-center'><?= $order['order_code'] ?></td>
                            <td class='text-center'><?= date('d-m-Y', strtotime($order['created_at'])) ?></td>
                            <td class='text-center'><?= number_format($order['total_amount'], 0, ',', '.') ?> VND</td>
                            <td class='text-center'>
                                <?php 
                                // Hiển thị biểu tượng tương ứng với trạng thái đơn hàng
                                switch ($order['order_status']) {
                                    case 'pending':
                                        echo '<i class="bi bi-hourglass-split icon-pending" data-toggle="tooltip" title="Chờ xử lý"></i>';
                                        break;
                                    case 'processing':
                                        echo '<i class="bi bi-gear icon-processing" data-toggle="tooltip" title="Đang xử lý"></i>';
                                        break;
                                    case 'shipped':
                                        echo '<i class="bi bi-truck icon-shipped" data-toggle="tooltip" title="Đã vận chuyển"></i>';
                                        break;
                                    case 'delivered':
                                        echo '<i class="bi bi-check-circle icon-delivered" data-toggle="tooltip" title="Đã giao hàng"></i>';
                                        break;
                                    case 'cancelled':
                                        echo '<i class="bi bi-x-circle icon-cancelled" data-toggle="tooltip" title="Đã hủy"></i>';
                                        break;
                                    default:
                                        echo '<i class="bi bi-question-circle" data-toggle="tooltip" title="Không rõ"></i>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class='text-center'>
                                <a href="<?= base_url('order/status/'.$order['id_order']) ?>" class="btn btn-info">Xem chi tiết</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Chưa có đơn hàng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); // Khởi động tooltip
    });
</script>

<?php include 'templates/footer.php'; ?>

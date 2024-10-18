<?php include 'templates/header.php'; ?>
<div class="container">
    <h1>Đặt hàng</h1>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    <?php if (session()->getFlashdata('msg_success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('msg_success') ?>
        </div>
    <?php elseif (session()->getFlashdata('msg_error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('msg_error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('order/placeOrder') ?>" method="post">
        <div class="form-group">
            <label for="customer_name">Tên khách hàng</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="customer_email">Email</label>
            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
        </div>
        <div class="form-group">
            <label for="customer_address">Địa chỉ</label>
            <input type="address" class="form-control" id="customer_address" name="customer_address" required>
        </div>
        <div class="form-group">
            <label for="customer_phone">Số điện thoại</label>
            <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
        </div>
        <div>
            <h3>Tổng tiền: <?= number_format($totalAmount, 0, ',', '.') ?> VND</h3>
        </div>
        <button type="submit" class="btn btn-success">Đặt hàng</button>
    </form>
</div>
<?php include 'templates/footer.php'; ?>

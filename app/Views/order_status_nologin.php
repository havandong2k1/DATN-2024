<!-- order_status_form.php -->
<?php include 'templates/header.php'; ?>
<div class="container gray-background mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <h1>Tìm kiếm đơn hàng</h1>
                    <form action="<?= base_url('/order/status') ?>" method="post">
                        <div class="form-group">
                            <label for="order_code">Mã đơn hàng</label>
                            <input type="text" class="form-control" id="order_code" name="order_code" placeholder="Nhập mã đơn hàng" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_email">Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Nhập số điện thoại của bạn" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php'; ?>

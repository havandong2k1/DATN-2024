<?php include 'templates/header.php'; ?>
<div class="container gray-background mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <h1>Trạng thái Đơn hàng</h1>
                    <?php if (isset($order)): ?>
                        <p><strong>Mã đơn hàng:</strong> <?= $order['order_code'] ?></p>
                        <p><strong>Tên khách hàng:</strong> <?= $order['customer_name'] ?></p>
                        <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
                        <p><strong>Số điện thoại:</strong> <?= $order['customer_phone'] ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $order['customer_address'] ?></p>
                        <p><strong>Tổng số tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VND</p>
                        <p><strong>Trạng thái thanh toán:</strong> <?= $order['payment_status'] ?></p>

                        <h3>Sản phẩm đã mua:</h3>
                        <?php if (isset($products) && count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="product-item">
                                    <img src="<?= $product['images'] ?>" alt="<?= $product['name'] ?>" width="100" />
                                    <p><strong>Tên sản phẩm:</strong> <?= $product['name'] ?></p>
                                    <p><strong>Số lượng:</strong> <?= $product['quantity'] ?></p>
                                    <p><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                                    <p><strong>Trạng thái sản phẩm:</strong> <?= $product['status'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không có sản phẩm nào trong đơn hàng.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Không tìm thấy thông tin đơn hàng.</p>
                    <?php endif; ?>
                    <a href="<?= base_url('/') ?>">Quay về trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php'; ?>

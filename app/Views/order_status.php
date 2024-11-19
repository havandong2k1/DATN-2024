<?php include 'templates/header.php'; ?>
<div class="container gray-background mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="text-center mb-4">
                <h1 class="display-4">Trạng thái Đơn hàng</h1>
                <?php if (isset($order)): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin đơn hàng</h5>
                            <p><strong>Mã đơn hàng:</strong> <?= esc($order['order_code']) ?></p>
                            <p><strong>Tên khách hàng:</strong> <?= esc($order['customer_name']) ?></p>
                            <p><strong>Email:</strong> <?= esc($order['customer_email']) ?></p>
                            <p><strong>Số điện thoại:</strong> <?= esc($order['customer_phone']) ?></p>
                            <p><strong>Địa chỉ:</strong> <?= esc($order['customer_address']) ?></p>
                            <p><strong>Tổng số tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VND</p>
                            <p><strong>Trạng thái thanh toán:</strong> <?= esc($order['payment_status']) ?></p>
                        </div>
                    </div>

                    <h3 class="mt-4">Sản phẩm đã mua:</h3>
                    <div class="row">
                        <?php if (isset($products) && count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="<?= !empty($product['images']) ? base_url('uploads/' . esc($product['images'])) : base_url('uploads/default_image.jpg') ?>" 
                                             alt="<?= esc($product['name']) ?>" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                                            <p class="card-text"><strong>Số lượng:</strong> <?= esc($product['quantity']) ?></p>
                                            <p class="card-text"><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                                            <p class="card-text"><strong>Trạng thái sản phẩm:</strong> <?= esc($product['status']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không có sản phẩm nào trong đơn hàng.</p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p>Không tìm thấy thông tin đơn hàng.</p>
                <?php endif; ?>
                <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Quay về trang chủ</a>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/footer.php'; ?>

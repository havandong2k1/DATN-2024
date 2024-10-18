<?php include 'templates/header.php'; ?>
<div class="container">
    <h1>Đặt Hàng</h1>

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
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng cộng</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($cartItems)) : ?>
            <?php 
            $totalAmount = 0;
            foreach ($cartItems as $item) : 
                $itemTotal = $item['price'] * $item['quantity'];
                $totalAmount += $itemTotal;
            ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td><img src="<?= !empty($item['images']) ? 'uploads/' . esc($item['images']) : 'uploads/default_image.jpg' ?>" alt="<?= esc($item['name']) ?>" width="100"></td>
                    <td><?= esc($item['quantity']) ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                    <td><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                <td><strong><?= number_format($totalAmount, 0, ',', '.') ?> VND</strong></td>
            </tr>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Giỏ hàng trống.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Form đặt hàng -->
    <form action="<?= base_url('order') ?>" method="post">
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ của bạn" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán</label>
            <select class="form-control" id="payment_method" name="payment_method">
                <option value="credit_card">Thẻ tín dụng</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Xác nhận đặt hàng</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>

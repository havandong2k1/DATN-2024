<?php include 'templates/header.php'; ?>
<div class="container">
    <h1>Giỏ Hàng</h1>

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

    <!-- Bảng hiển thị các sản phẩm trong giỏ hàng -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class='text-center'>Sản phẩm</th>
                <th class='text-center'>Ảnh</th>
                <th class='text-center'>Số lượng</th>
                <th class='text-center'>Giá</th>
                <th class='text-center'>Tổng cộng</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($cartItems)) : ?>
            <?php 
            $totalAmount = 0;
            foreach ($cartItems as $item) : 
                // Tính tổng tiền của từng sản phẩm
                $itemTotal = $item['price'] * $item['quantity'];
                $totalAmount += $itemTotal;
            ?>
                <tr>
                    <td class='text-center'><?= esc($item['name']) ?></td>
                    <td class='text-center'>
                        <img src="<?= !empty($item['images']) ? base_url('uploads/' . esc($item['images'])) : base_url('uploads/default_image.jpg') ?>" 
                             alt="<?= esc($item['name']) ?>" 
                             width="100">
                    </td>
                    <td class='text-center'><?= esc($item['quantity']) ?></td>
                    <td class='text-center'><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                    <td class='text-center'><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                <td class = 'text-center'><strong><?= number_format($totalAmount, 0, ',', '.') ?> VND</strong></td>
            </tr>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Giỏ hàng trống.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($cartItems)) : ?>
        <div class="button-card text-center mt-4">
            <a href="<?= base_url('order') ?>" class="btn btn-primary btn-lg px-4 py-2">
                <i class="bi bi-cart-check"></i> Đặt hàng
            </a>
        </div>
    <?php endif; ?>

</div>

<!-- CSS tùy chỉnh cho giỏ hàng -->
<style>
    .cart-item img {
        width: 100px;
        height: auto;
        object-fit: cover;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .button-card {
        padding: 10px 10px 50px 10px;
    }
</style>

<?php include 'templates/footer.php'; ?>

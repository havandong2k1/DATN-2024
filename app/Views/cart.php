<?php include 'templates/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

<div class="container">
    <h1>Giỏ Hàng</h1>

    <!-- Display success or error messages -->
    <?php if (session()->getFlashdata('msg_success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('msg_success') ?>
        </div>
    <?php elseif (session()->getFlashdata('msg_error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('msg_error') ?>
        </div>
    <?php endif; ?>

    <!-- Cart table -->
    <table class="table table-bordered">
    <thead>
        <tr>
            <th class='text-center'>Sản phẩm</th>
            <th class='text-center'>Ảnh</th>
            <th class='text-center'>Số lượng</th>
            <th class='text-center'>Giá</th>
            <th class='text-center'>Tổng cộng</th>
            <th class='text-center'>Hành động</th>
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
                <td class='text-center'><?= esc($item['name']) ?></td>
                <td class='text-center'>
                    <img src="<?= !empty($item['images']) ? base_url('uploads/' . esc($item['images'])) : base_url('uploads/default_image.jpg') ?>" 
                         alt="<?= esc($item['name']) ?>" 
                         width="100">
                </td>
                <td class='text-center'>
                    <!-- Quantity control buttons -->
                    <a href="<?= base_url('cart/decrease/' . $item['id_product']) ?>" class="btn btn-light btn-sm">-</a>
                    <?= esc($item['quantity']) ?>
                    <a href="<?= base_url('cart/increase/' . $item['id_product']) ?>" class="btn btn-light btn-sm">+</a>
                </td>
                <td class='text-center'><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                <td class='text-center'><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                <td class='text-center'>
                    <a href="<?= base_url('cart/remove/' . $item['id_product']) ?>" class="btn btn-danger btn-sm" title="Xóa">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
            <td class='text-center'><strong><?= number_format($totalAmount, 0, ',', '.') ?> VND</strong></td>
            <td></td>
        </tr>
    <?php else : ?>
        <tr>
            <td colspan="6" class="text-center">Giỏ hàng trống.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

    <!-- Order button -->
    <div class="button-card text-center mt-4">
        <?php if (!empty($cartItems)) : ?>
            <a href="<?= base_url('order') ?>" class="btn btn-primary btn-lg px-4 py-2">
                <i class="bi bi-cart-check"></i> Đặt hàng
            </a>
        <?php else : ?>
            <button class="btn btn-primary btn-lg px-4 py-2" disabled>
                <i class="bi bi-cart-check"></i> Đặt hàng
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Custom CSS -->
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
    .btn-light {
        border: 1px solid #ddd;
        font-weight: bold;
        padding: 2px 10px;
        margin: 0 5px;
    }
    .btn-primary[disabled] {
        background-color: #ddd;
        border-color: #ddd;
        cursor: not-allowed;
    }
</style>

<?php include 'templates/footer.php'; ?>

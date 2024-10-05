<!-- File: views/cart.php -->
<div class="container">
    <h1>Giỏ hàng của bạn</h1>
    <?php if (session()->getFlashdata('msg_success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('msg_success') ?>
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

    <!-- Nút thanh toán -->
    <form action="checkout.php" method="POST">
        <input type="hidden" name="totalAmount" value="<?= $totalAmount ?>">
        <button type="submit" class="btn btn-success">Thanh toán</button>
    </form>
</div>

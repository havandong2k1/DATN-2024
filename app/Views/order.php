<?php include 'templates/header.php'; ?>
<div class="container">
    <h1 class="mt-4">Tạo đơn hàng</h1>

    <!-- Success/Error Messages -->
    <?php if (session()->getFlashdata('msg_success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('msg_success') ?>
        </div>
    <?php elseif (session()->getFlashdata('msg_error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('msg_error') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Product Information -->
        <div class="col-md-6">
            <h4>Thông tin sản phẩm</h4>
            <?php if (!empty($cartItems)) : ?>
                <?php foreach ($cartItems as $item) : ?>
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?= !empty($item['images']) ? base_url('uploads/' . esc($item['images'])) : base_url('uploads/default_image.jpg') ?>" 
                                     alt="<?= esc($item['name']) ?>" 
                                     class="img-fluid img-thumbnail">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                    <p class="card-text">Số lượng: <?= esc($item['quantity']) ?></p>
                                    <p class="card-text">Giá: <?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                                    <p class="card-text">Thành tiền: <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Giỏ hàng của bạn trống.</p>
            <?php endif; ?>
        </div>

        <!-- Shipping Information and Order Form -->
        <div class="col-md-6">
            <h4>Địa chỉ giao hàng</h4>
            <form action="<?= base_url('order/placeOrder') ?>" method="post">
                <!-- Customer Information Fields -->
                <div class="form-group">
                    <label for="customer_name">Họ và tên</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                </div>
                <div class="form-group">
                    <label for="customer_email">Email</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                </div>
                <div class="form-group">
                    <label for="customer_address">Địa chỉ chi tiết</label>
                    <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                </div>

                <!-- Province, City, and District Selection -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="province">Tỉnh / Thành phố</label>
                        <select id="province" class="form-control" name="province" required>
                            <option selected>Chọn tỉnh / thành phố</option>
                            <?php if (!empty($provinces)): ?>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= esc($province['province_id']) ?>"><?= esc($province['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="district">Huyện / Quận</label>
                        <select id="district" class="form-control" name="district" required>
                            <option selected>Chọn huyện / quận</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ward">Xã / Phường</label>
                    <select id="ward" class="form-control" name="ward" required>
                        <option selected>Chọn xã / phường</option>
                    </select>
                </div>

                <!-- Shipping and Payment Options Box -->
                <h4>Vận chuyển và thanh toán</h4>
                <div class="card p-3 mb-4" style="border: 1px solid #ddd;">
                    <!-- <div class="form-group">
                        <label>Phương thức giao hàng:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping_saver" value="saver" checked>
                            <label class="form-check-label" for="shipping_saver">
                                <i class="fas fa-box"></i> Giao hàng tiết kiệm
                            </label>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label>Phương thức thanh toán:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                            <label class="form-check-label" for="payment_cod">
                                <i class="fas fa-money-bill-wave"></i> Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Note and Total Amount -->
                <div class="form-group">
                    <label for="note">Ghi chú đơn hàng</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <div class="mt-4 d-flex justify-content-end">
                    <h3 class="text-primary">Giá tạm tính: <?= number_format($totalAmount, 0, ',', '.') ?> VND</h3>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Đặt hàng ngay</button>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    $('#province').change(function() {
        var provinceId = $(this).val();
        $.ajax({
            url: '<?= base_url('order/get-districts') ?>',
            type: 'POST',
            data: { 
                province_id: provinceId,
                [csrfName]: csrfHash
            },
            success: function(data) {
                var districtSelect = $('#district');
                districtSelect.empty();
                districtSelect.append('<option selected>Chọn huyện / quận</option>');
                $.each(data, function(index, district) {
                    districtSelect.append('<option value="' + district.district_id + '">' + district.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });

    $('#district').change(function() {
        var districtId = $(this).val();
        $.ajax({
            url: '<?= base_url('order/get-wards') ?>',
            type: 'POST',
            data: { 
                district_id: districtId,
                [csrfName]: csrfHash
            },
            success: function(data) {
                var wardSelect = $('#ward');
                wardSelect.empty();
                wardSelect.append('<option selected>Chọn xã / phường</option>');
                $.each(data, function(index, ward) {
                    wardSelect.append('<option value="' + ward.id + '">' + ward.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });
});
</script>

<?php include 'templates/footer.php'; ?> 

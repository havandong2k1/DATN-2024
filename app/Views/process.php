<?php include 'templates/header.php'; ?>
<div class="container">
    <h1>Xử lý Thanh Toán</h1>

    <!-- Thông báo nếu thanh toán thành công -->
    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('msg_success') ?>
        </div>
    <?php elseif (session()->getFlashdata('msg_error')): ?>
        <!-- Thông báo nếu có lỗi xảy ra trong quá trình thanh toán -->
        <div class="alert alert-danger">
            <?= session()->getFlashdata('msg_error') ?>
        </div>
    <?php endif; ?>

    <p>Cảm ơn bạn đã thanh toán. Nếu có vấn đề gì, vui lòng liên hệ bộ phận hỗ trợ.</p>
</div>
<?php include 'templates/footer.php'; ?>

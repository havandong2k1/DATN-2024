<?php include 'templates/header.php'; ?>
<style>
    /* Định dạng background xám */
    .gray-background {
        background-color: #f8f9fa; /* Màu xám nhạt */
        padding-left: 15px; /* Thụt lề bên trái */
        padding-right: 15px; /* Thụt lề bên phải */
        margin-bottom: 50px;
    }
</style>
<div class="container gray-background mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <h1>Thông tin người dùng</h1>
                    <h5>Tên người dùng: <?= session()->get("customer_name") ?></h5>
                    <hr>
                    <h5>Email: <?= session()->get("customer_email") ?></h5>
                    <hr>
                    <h5>Ngày tạo: <?= session()->get("created_at") ?></h5>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa đơn hàng</title>
    <!-- Đảm bảo Bootstrap được load đúng -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="your_custom_styles.css"> <!-- Nếu có thêm CSS tùy chỉnh -->
   
</head>
<body>
    <div class="container mt-5">
        <h1 class="dash-title">Trang chủ / Đơn hàng / Chỉnh sửa</h1>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Hiển thị thông báo nếu có -->
                <?= view('messages/message') ?> 

                <div class="card easion-card">
                    <div class="card-header rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="easion-card-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="easion-card-title">Chỉnh sửa đơn hàng</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form chỉnh sửa đơn hàng -->
                        <form action="<?= base_url('admin/order/update/' . $order['id_order']) ?>" method="post">
                            <!-- CSRF Token -->
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                            <!-- Hiển thị lỗi nếu có -->
                            <?php if (session()->has('msg_error')): ?>
                                <div class="alert alert-danger mb-4">
                                    <?= session('msg_error') ?>
                                </div>
                            <?php endif; ?>

                            <!-- Hiển thị thành công nếu có -->
                            <?php if (session()->has('msg_success')): ?>
                                <div class="alert alert-success mb-4">
                                    <?= session('msg_success') ?>
                                </div>
                            <?php endif; ?>

                            <!-- Tên khách hàng -->
                            <div class="form-group">
                                <label for="customer_name">Tên khách hàng:</label>
                                <input type="text" class="form-control <?= session('errors.customer_name') ? 'is-invalid' : '' ?>" id="customer_name" name="customer_name" value="<?= old('customer_name', $order['customer_name']) ?>" required>
                                <?php if (session('errors.customer_name')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.customer_name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Email khách hàng -->
                            <div class="form-group">
                                <label for="customer_email">Email:</label>
                                <input type="email" class="form-control <?= session('errors.customer_email') ? 'is-invalid' : '' ?>" id="customer_email" name="customer_email" value="<?= old('customer_email', $order['customer_email']) ?>" required>
                                <?php if (session('errors.customer_email')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.customer_email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Số điện thoại khách hàng -->
                            <div class="form-group">
                                <label for="customer_phone">Số điện thoại:</label>
                                <input type="text" class="form-control <?= session('errors.customer_phone') ? 'is-invalid' : '' ?>" id="customer_phone" name="customer_phone" value="<?= old('customer_phone', $order['customer_phone']) ?>" required>
                                <?php if (session('errors.customer_phone')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.customer_phone') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Địa chỉ khách hàng -->
                            <div class="form-group">
                                <label for="customer_address">Địa chỉ:</label>
                                <input type="text" class="form-control <?= session('errors.customer_address') ? 'is-invalid' : '' ?>" id="customer_address" name="customer_address" value="<?= old('customer_address', $order['customer_address']) ?>" required>
                                <?php if (session('errors.customer_address')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.customer_address') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="payment_status">Trạng thái thanh toán:</label>
                                <select class="form-control" id="payment_status" name="payment_status" required>
                                    <option value="paid" <?= $order['payment_status'] == 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                                    <option value="unpaid" <?= $order['payment_status'] == 'unpaid' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order_status">Trạng thái đơn hàng:</label>
                                <select class="form-control" id="order_status" name="order_status" required>
                                    <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                    <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                    <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Đã lấy hàng</option>
                                    <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Đã giao hàng</option>
                                    <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Đơn đã hủy</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="<?= base_url('admin/order/list') ?>" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đảm bảo Bootstrap JS được load -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .dash-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #495057;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 10px 10px 0 0;
        }
        .easion-card-icon {
            font-size: 30px;
            margin-right: 10px;
        }
        .easion-card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .alert {
            border-radius: 10px;
        }
    </style>

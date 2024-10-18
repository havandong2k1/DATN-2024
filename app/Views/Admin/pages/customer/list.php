<div class="dash-content">
    <h1 class="dash-title">Trang chủ / Danh sách khách hàng</h1>
    <div class="row">
        <div class="col-lg-12">
            <?= view('messages/message') ?> <!-- Hiển thị thông báo thành công hoặc lỗi -->
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="easion-card-title">Danh sách khách hàng</div>
                </div>
                <div class="card-body">
                    <!-- Kiểm tra nếu có khách hàng -->
                    <?php if (!empty($listCustomer)): ?>
                        <table class="table table-striped" id="customer-table">
                            <thead>
                                <tr>
                                    <th>ID KH</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Duyệt qua tất cả khách hàng -->
                                <?php foreach ($listCustomer as $customer): ?>
                                    <tr>
                                        <td><?= $customer['customer_id'] ?></td>
                                        <td><?= $customer['customer_name'] ?></td>
                                        <td><?= $customer['customer_email'] ?></td>
                                        <td><?= $customer['status_customer'] == 1 ? 'Hoạt động' : 'Bị khóa' ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/customer/toggle-status/' . $customer['customer_id']) ?>" class="btn btn-warning btn-sm">
                                                <?= $customer['status_customer'] == 1 ? 'Khóa' : 'Mở khóa' ?>
                                            </a>
                                            <a href="<?= base_url('admin/customer/delete/' . $customer['customer_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Không có khách hàng nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

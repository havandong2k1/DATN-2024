<div class="container-fluid">
    <h1 class="dash-title">Trang chủ / Tài khoản ADMIN</h1>
    <script src="public/vendor/toastr/build/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <?php if (session()->getFlashdata('msg_success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('msg_success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('msg_error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('msg_error') ?>
                </div>
            <?php endif; ?>
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="easion-card-title">Danh sách tài khoản ADMIN</div>
                </div>
                <div class="card-body ">
                    <table id="datatable" class="cell-border stripe">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Danh sách</th>
                                <th class="text-center" scope="col">Tên</th>
                                <th class="text-center" scope="col">Chức vụ</th>
                                <th class="text-center" scope="col">Email</th>
                                <th class="text-center" scope="col">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td class="text-center"><?= $user['name'] ?></td>
                                    <td class="text-center">
                                        <?php
                                            // Chuyển đổi trạng thái số thành chuỗi trạng thái
                                            switch ($user['status_users']) {
                                                case 1:
                                                    echo 'Admin';
                                                    break;
                                                case 2:
                                                    echo 'Quản lý';
                                                    break;
                                                case 3:
                                                    echo 'Nhân viên';
                                                    break;
                                                case 0:
                                                    echo 'Khóa';
                                                    break;
                                                default:
                                                    echo 'Không xác định';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $user['email'] ?></td>
                                    <td class="text-center">
                                        <a href="admin/user/edit/<?= $user['id'] ?>" class="btn btn-primary btn-sm ___js-edit-user">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/user/delete/') . $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?= $this->include("Modals/Users/delete") ?>

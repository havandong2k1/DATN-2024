<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="dash-content">
    <h1 class="dash-title">Trang chủ / Sản phẩm</h1>
    <div class="row">
        <div class="col-lg-12">
            <!-- Hiển thị thông báo -->
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="easion-card-title">Danh sách sản phẩm</div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/product/add') ?>" class="btn btn-primary rounded-pill">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="cell-border stripe">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Giá</th>
                                <th>Mô tả sản phẩm</th>
                                <th>Sẩn phẩm</th>                           
                                <th class="text-center">Trạng thái sản phẩm</th>
                                <th class="text-center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)) : ?>
                            <?php foreach ($products as $index => $product) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td>
                                        <img src="uploads/<?= $product['images']; ?>" alt="" height="60" width="60">
                                    </td>
                                    <td style="width: 100px"><?= number_format($product['price'], 0, ',', '.') ?> ₫</td>

                                    <td><?= $product['description'] ?></td>
                                    <td><?= $product['category'] ?></td>
                                    <td class="text-center">
                                        <?php 
                                            if ($product['status_product'] == 2) {
                                                echo 'Sản phẩm hot';
                                            } elseif ($product['status_product'] == 1) {
                                                echo 'Bật';
                                            } else {
                                                echo 'Tắt';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="admin/product/edit/<?= $product['id_product'] ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/product/delete/') . $product['id_product'] ?>" class="btn btn-danger btn-sm ___js-delete-product"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
</script>
</body>
</html>

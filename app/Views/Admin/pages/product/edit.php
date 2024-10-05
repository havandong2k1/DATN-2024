<main class="dash-content">
    <div class="container-fluid">
        <h1 class="dash-title">Trang chủ / Sản phẩm / Chỉnh sửa</h1>
        <div class="row">
            <div class="col-xl-12">
                <?= view('messages/message') ?>
                <div class="card easion-card rounded-4">
                    <div class="card-header rounded-4">
                        <div class="easion-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="easion-card-title"> Thông tin sản phẩm </div>
                    </div>
                    <div class="card-body">
                            <form action="<?= base_url('admin/product/edit/'.@$product['id_product']) ?>" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <?php if (session()->has('success')) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session('success') ?>
                                    </div>
                                <?php endif; ?>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tên sản phẩm</label>
                                    <input value="<?= $product['name'] ?>" name="name" type="text" class="form-control" placeholder="Nhập tên sản phẩm" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status_product">Trạng thái sản phẩm nổi bật</label>
                                    <select name="status_product" class="form-control" required>
                                        <option value="0" <?php echo ($product['status_product'] == 0) ? 'selected' : ''; ?>>Ẩn sản phẩm</option>
                                        <option value="1" <?php echo ($product['status_product'] == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                                        <option value="2" <?php echo ($product['status_product'] == 2) ? 'selected' : ''; ?>>Hiển thị SP hot</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Giá</label>
                                    <input value="<?= $product['price'] ?>" name="price" type="text" class="form-control" placeholder="Nhập giá bán sản phẩm" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description</label></br>
                                    <textarea name="description" id="description"><?= $product['description'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="category">Danh mục</label>
                                <select name="category" class="form-control" id="category" required>
                                    <option value="">Chọn danh mục sản phẩm</option>
                                    <option value="MÀN HÌNH" <?= ($product['category'] == 'MÀN HÌNH') ? 'selected' : '' ?>>MÀN HÌNH</option>
                                    <option value="THÙNG MÁY" <?= ($product['category'] == 'THÙNG MÁY') ? 'selected' : '' ?>>THÙNG MÁY</option>
                                    <option value="CHIP" <?= ($product['category'] == 'CHIP') ? 'selected' : '' ?>>CHIP</option>
                                    <option value="RAM" <?= ($product['category'] == 'RAM') ? 'selected' : '' ?>>RAM</option>
                                    <option value="SSD" <?= ($product['category'] == 'SSD') ? 'selected' : '' ?>>SSD</option>
                                    <option value="HDD" <?= ($product['category'] == 'HDD') ? 'selected' : '' ?>>HDD</option>
                                    <option value="CARD ĐỒ HỌA" <?= ($product['category'] == 'CARD ĐỒ HỌA') ? 'selected' : '' ?>>CARD ĐỒ HỌA</option>
                                    <option value="CHUỘT" <?= ($product['category'] == 'CHUỘT') ? 'selected' : '' ?>>CHUỘT</option>
                                    <option value="BÀN, GHẾ GAMING" <?= ($product['category'] == 'BÀN, GHẾ GAMING') ? 'selected' : '' ?>>BÀN, GHẾ GAMING</option>
                                    <option value="QUẠT TẢN NHIỆT" <?= ($product['category'] == 'QUẠT TẢN NHIỆT') ? 'selected' : '' ?>>QUẠT TẢN NHIỆT</option>
                                    <option value="TAI NGHE" <?= ($product['category'] == 'TAI NGHE') ? 'selected' : '' ?>>TAI NGHE</option>
                                    <option value="TABLET" <?= ($product['category'] == 'TABLET') ? 'selected' : '' ?>>TABLET</option>
                                    <option value="BÀN PHÍM" <?= ($product['category'] == 'BÀN PHÍM') ? 'selected' : '' ?>>BÀN PHÍM</option>
                                    <option value="LOA" <?= ($product['category'] == 'LOA') ? 'selected' : '' ?>>LOA</option>
                                    <option value="LAPTOP" <?= ($product['category'] == 'LAPTOP') ? 'selected' : '' ?>>LAPTOP</option>
                                    <option value="IPAD" <?= ($product['category'] == 'IPAD') ? 'selected' : '' ?>>IPAD</option>
                                </select>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-4">Cập nhật</button>
                            <button id="btn-reset-edit-product" type="reset" class="btn btn-secondary rounded-4" onclick="return confirm('Are you sure you want to reset?')">Reset</button>
                                <a style="background-color: red" href="<?= base_url('admin/product/list') ?>" class="btn btn-secondary rounded-4">Hủy</a>
                                <a style="background-color: yellow" href="<?= base_url('admin/product/list') ?>" class="btn btn-warning rounded-4 ">Quay lại</a>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        // Lấy giá trị từ thẻ hidden và thiết lập giá trị cho select
        var savedCategory = $('#hidden-category').val();
        if (savedCategory) {
            $('#category').val(savedCategory);
        }
        // Cập nhật thẻ hidden khi người dùng thay đổi select
        $('#category').on('change', function() {
            $('#hidden-category').val($(this).val());
        });
    });
</script>
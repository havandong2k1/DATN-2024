<!-- app/Views/admin/pages/product/add.php -->

<div class="dash-content">
    <div class="container-fluid">
        <h1 class="dash-title">Trang chủ / Sản phẩm / Thêm mới</h1>
        <?php if (session()->has("error")): { ?>
            <div id="error" class="alert alert-danger p-1 " role="alert">
                <?= session()->get("error") ?>
            </div>
        <?php } endif; ?>
        <?php if (session()->has("success")): { ?>
            <div class="alert alert-success p-1 " role="alert">
                <?= session()->get("success") ?>
            </div>
        <?php } endif; ?>

        <div class="card easion-card rounded-4">
            <div class="card-header rounded-4">
                <div class="easion-card-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="easion-card-title">Thông tin sản phẩm</div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/product/create') ?>" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Tên sản phẩm</label>
                            <input value="<?= old('name') ?>" name="name" type="text" class="form-control" id="name"
                                   placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="images">Ảnh sản phẩm</label>
                            <input name="images" type="file" accept="image/*" class="form-control-file" id="images"
                                   required>
                            <div class="form-group">
                                <img id="img-show" src="" class="img-fluid" alt="Hình đại diện." style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Giá</label>
                            <input value="<?= old('price') ?>" name="price" type="text" class="form-control"
                                   placeholder="Nhập giá bán sản phẩm" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Thông số sản phẩm</label>
                            <textarea name="description" id="description"
                                      class="form-control"><?= old('description') ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="category">Danh mục</label>
                            <!--                            <input value="-->
                            <? //= old('category') ?><!--" name="category" type="text" class="form-control" id="category" placeholder="Nhập danh mục" required>-->
                            <select value="<?= old('category') ?>" name="category" class="form-control" id="category"
                                    required>
                                <option>Nhập danh mục sản phẩm</option>
                                <option>MÀN HÌNH</option>
                                <option>THÙNG MÁY</option>
                                <option>CHIP</option>
                                <option>RAM</option>
                                <option>SSD</option>
                                <option>HDD</option>
                                <option>CARD ĐỒ HỌA</option>
                                <option>CHUỘT</option>
                                <option>BÀN, GHẾ GAMING</option>
                                <option>QUẠT TẢN NHIỆT</option>
                                <option>TAI NGHE</option>
                                <option>TABLET</option>
                                <option>BÀN PHÍM</option>
                                <option>LOA</option>
                                <option>LAPTOP</option>
                                <option>IPAD</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">Số lượng</label>
                            <input value="<?= old('amount') ?>" name="amount" type="number" class="form-control"
                                   id="amount" placeholder="Nhập số lượng" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status_product">Trạng thái sản phẩm nổi bật</label>
                            <select name="status_product" class="form-control" required>
                                <option value="0" <?php echo (old('status_product') == 0) ? 'selected' : ''; ?>>Ẩn sản
                                    phẩm
                                </option>
                                <option value="1" <?php echo (old('status_product') == 1) ? 'selected' : ''; ?>>Hiển
                                    thị
                                </option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success rounded-4">Thêm mới</button>
                    <button type="reset" class="btn btn-secondary rounded-4">Nhập lại</button>
                    <a style="background-color: yellow" href="<?= base_url('admin/product/list') ?>"
                       class="btn btn-warning rounded-4 ">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for file input preview -->
<script>
    document.getElementById('images').addEventListener('change', function (event) {
        var input = event.target;
        var img = document.getElementById('img-show');
        img.style.display = 'block';

        var reader = new FileReader();
        reader.onload = function () {
            img.src = reader.result;
        };

        reader.readAsDataURL(input.files[0]);
    });
</script>

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
                        <input value="<?= old('price') ?>" name="price" type="text" class="form-control" id="price"
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
                            <input type="hidden" id="category" name="category" value="">
                            <select name="category" class="form-control" id="category" required>
                                <option value="">Nhập danh mục sản phẩm</option>
                                <option value="MÀN HÌNH" <?= old('category') == 'MÀN HÌNH' ? 'selected' : '' ?>>MÀN HÌNH</option>
                                <option value="THÙNG MÁY" <?= old('category') == 'THÙNG MÁY' ? 'selected' : '' ?>>THÙNG MÁY</option>
                                <option value="CHIP" <?= old('category') == 'CHIP' ? 'selected' : '' ?>>CHIP</option>
                                <option value="RAM" <?= old('category') == 'RAM' ? 'selected' : '' ?>>RAM</option>
                                <option value="SSD" <?= old('category') == 'SSD' ? 'selected' : '' ?>>SSD</option>
                                <option value="HDD" <?= old('category') == 'HDD' ? 'selected' : '' ?>>HDD</option>
                                <option value="CARD ĐỒ HỌA" <?= old('category') == 'CARD ĐỒ HỌA' ? 'selected' : '' ?>>CARD ĐỒ HỌA</option>
                                <option value="CHUỘT" <?= old('category') == 'CHUỘT' ? 'selected' : '' ?>>CHUỘT</option>
                                <option value="BÀN, GHẾ GAMING" <?= old('category') == 'BÀN, GHẾ GAMING' ? 'selected' : '' ?>>BÀN, GHẾ GAMING</option>
                                <option value="QUẠT TẢN NHIỆT" <?= old('category') == 'QUẠT TẢN NHIỆT' ? 'selected' : '' ?>>QUẠT TẢN NHIỆT</option>
                                <option value="TAI NGHE" <?= old('category') == 'TAI NGHE' ? 'selected' : '' ?>>TAI NGHE</option>
                                <option value="TABLET" <?= old('category') == 'TABLET' ? 'selected' : '' ?>>TABLET</option>
                                <option value="BÀN PHÍM" <?= old('category') == 'BÀN PHÍM' ? 'selected' : '' ?>>BÀN PHÍM</option>
                                <option value="LOA" <?= old('category') == 'LOA' ? 'selected' : '' ?>>LOA</option>
                                <option value="LAPTOP" <?= old('category') == 'LAPTOP' ? 'selected' : '' ?>>LAPTOP</option>
                                <option value="IPAD" <?= old('category') == 'IPAD' ? 'selected' : '' ?>>IPAD</option>
                            </select>
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
                                <option value="2" <?php echo (old('status_product') == 2) ? 'selected' : ''; ?>>Hiển
                                    thị SPH
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
    
    function formatVND(value) {
        return value.toString().replace(/\D/g, '') // Loại bỏ ký tự không phải số
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' VND'; // Thêm dấu phân cách hàng nghìn
    }

    // Bắt sự kiện khi người dùng nhập giá sản phẩm
    document.getElementById('price').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\./g, ''); // Loại bỏ dấu chấm cũ
        e.target.value = formatVND(value); // Gán lại giá trị đã được định dạng
    });

    // hàm jquery cấu hình ảnh khi được update lên website
    $('#images').on('change', function() {
        var file = this.files[0];
        if (file) {
            var img = new Image();
            var objectUrl = URL.createObjectURL(file);
            img.onload = function() {
                if (this.width > 1080 || this.height > 1080) {
                    alert('Kích thước ảnh phải nhỏ hơn hoặc bằng 1080x1080.');
                    $('#images').val('');  // Clear the file input
                    $('#img-show').hide();
                } else {
                    $('#img-show').attr('src', objectUrl).show(); // Show the image preview
                }
                URL.revokeObjectURL(objectUrl);
            };
            img.src = objectUrl;
        }
    });
</script>

<div class="dash-content">
    <div class="container-fluid">
        <h1 class="dash-title">Trang chủ / Bài viết / Thêm</h1>
        <div class="row">
            <div class="col-xl-12">
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-<?= session()->getFlashdata('message_type'); ?> alert-dismissible fade show"
                         role="alert">
                        <?= session()->getFlashdata('message'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="card easion-card">
                    <div class="card-header">
                        <div class="easion-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="easion-card-title"> Thông tin bài viết </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('admin/blog/create') ?>" enctype="multipart/form-data" method="post">
                            <!-- Add CSRF token for security -->
                            <?= csrf_field() ?>
                            <div>
                                <label>Tiêu đề:</label>
                                <input type="text" name="title" placeholder="Tiêu đề" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image">Ảnh blog</label>
                                <input name="image" type="file" accept="image/*" class="form-control-file" id="image" required>
                                <div class="form-group">
                                    <img id="img-show" src="" class="img-fluid" alt="Hình đại diện." style="display: none;">
                                </div>
                            </div>
                            <div style="padding-top: 20px">
                                <label>Nội dung</label>
                                <textarea name="content" id="content"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-4">Đăng bài</button>
                            <a href="<?= base_url('admin/blog/list') ?>" class="btn btn-warning mt-4">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TinyMCE Script -->
<script src="https://cdn.tiny.cloud/1/hbozepm8v83oquejurp97p1x4p1eymqxvifr4r4izmvfi34i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
    });

    document.getElementById('image').addEventListener('change', function (event) {
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

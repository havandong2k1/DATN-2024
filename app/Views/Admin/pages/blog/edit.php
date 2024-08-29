
<main class="dash-content">
    <div class="container-fluid">
        <h1 class="dash-title">Trang chủ / Bài viết / Chỉnh sửa</h1>
        <div class="row">
            <div class="col-xl-12">
                <?= view('messages/message') ?>
                <div class="card easion-card">
                    <div class="card-header">
                        <div class="easion-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="easion-card-title"> Thông tin bài viết </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/blog/edit/'.@$blog['id_blogs']) ?>" method="post">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <?php if (session()->has('success')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session('success') ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="title">Tiêu đề:</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= $blog['title'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="content">Nội dung:</label>
                                <textarea class="form-control" id="content" name="content"><?= $blog['content'] ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a style="background-color: red" href="<?= base_url('admin/blog/list') ?>" class="btn btn-secondary">Hủy</a>
                            <button id="btn-reset-edit-product" type="reset" class="btn btn-secondary"
                                onclick="return confirm('Are you sure you want to reset?')">Reset</button>
                            <a style="background-color: yellow" href="<?= base_url('admin/blog/list') ?>" class="btn btn-warning ">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

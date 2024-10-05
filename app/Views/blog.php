<?= view('templates/header'); ?>
<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Tin công nghệ mới nhất</h2>
            </div>
        </div>
        <?php if (!empty($blogsObj) && is_array($blogsObj)): ?>
            <div class="row"> <!-- Tạo một hàng -->
                <?php foreach ($blogsObj as $blog) : ?>
                    <div class="col-sm-4"> <!-- Mỗi bài viết sẽ chiếm 1/3 chiều ngang màn hình -->
                        <div class="blog-item">
                            <a href="<?= base_url('views/viewblog/' . $blog['id_blogs']) ?>"> <!-- Liên kết đến trang chi tiết -->
                                <img src="<?= $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; max-width: 100%;"> <!-- Hiển thị ảnh -->
                                <h2><?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> <!-- Kết thúc hàng -->
        <?php else: ?>
            <p>Không có bài viết nào để hiển thị.</p>
        <?php endif; ?>
    </div>
</div>
<style>
    .blog-item {
    margin-bottom: 20px;
    text-align: center;
    }
    .blog-item img {
        border-radius: 10px;
    }
</style>
<?= view('templates/footer'); ?>

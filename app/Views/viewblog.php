<?= view('templates/header'); ?>
<div class="container">
    <article class="news-article">
        <?php if (!empty($blog)): ?>
            <h1 class="article-title"><?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?></h1>

            <div class="article-meta">
                <span class="article-date">
                    Ngày đăng: <?= date('d/m/Y', strtotime($blog['created_at'])) ?>
                </span>
            </div>

            <?php if (!empty($blog['image'])): ?>
                <div class="article-image text-center">
                    <img src="<?= base_url('uploads/' . $blog['image']) ?>" alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" class="img-centered blog-image">
                </div>
            <?php else: ?>
                <div class="article-image text-center">
                    <img src="<?= base_url('uploads/placeholder.png') ?>" alt="No image" class="img-centered blog-image">
                </div>
            <?php endif; ?>

            <div class="article-content">
                    <p><?= nl2br(htmlspecialchars_decode($blog['content'], ENT_QUOTES)) ?></p>
            </div>
        <?php else: ?>
            <p>Bài viết không tồn tại.</p>
        <?php endif; ?>
    </article>
</div>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif; /* Sửa font cho toàn bộ trang */
    }
    .news-article {
        margin-top: 20px;
        line-height: 1.6;
    }
    .article-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center; /* Căn giữa tiêu đề */
    }
    .article-meta {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 15px;
        text-align: center; /* Căn giữa ngày đăng */
    }
    .article-image {
        margin-bottom: 20px;
    }
    .img-centered {
        max-width: 100%; /* Đảm bảo hình ảnh không bị vượt quá kích thước container */
        height: auto; /* Giữ tỷ lệ hình ảnh */
        display: block;
        margin-left: auto;
        margin-right: auto; /* Căn giữa ảnh */
        border-radius: 10px;
    }
    .article-content {
        font-size: 18px; /* Tăng kích thước chữ cho nội dung */
        color: #333;
        text-align: justify; /* Căn đều văn bản */
    }
</style>

<!-- Thêm jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Xử lý các hình ảnh không tải được
        $('.blog-image').on('error', function() {
            $(this).attr('src', '<?= base_url('uploads/placeholder.png') ?>'); // Thay thế bằng ảnh mặc định nếu ảnh bị lỗi
        });

        // Thêm CSS class nếu hình ảnh quá lớn
        $('.blog-image').each(function() {
            var imgWidth = $(this).width();
            if (imgWidth > 500) { 
                $(this).addClass('large-image');
            }
        });
    });
</script>

<?= view('templates/footer'); ?>

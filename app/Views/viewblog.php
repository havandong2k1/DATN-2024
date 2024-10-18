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
                <!-- Hiển thị ảnh bài viết nếu có -->
                <div class="article-image text-center">
                    <img src="<?= base_url('uploads/' . $blog['image']) ?>" alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" class="img-centered">
                </div>
            <?php else: ?>
                <!-- Hiển thị placeholder nếu không có ảnh -->
                <div class="article-image text-center">
                    <img src="<?= base_url('uploads/placeholder.png') ?>" alt="No image" class="img-centered">
                </div>
            <?php endif; ?>

            <div class="article-content">
                <!-- Hiển thị nội dung bài viết -->
                <p><?= nl2br(htmlspecialchars_decode($blog['content'], ENT_QUOTES)) ?></p>
            </div>
        <?php else: ?>
            <p>Bài viết không tồn tại.</p>
        <?php endif; ?>
    </article>
</div>

<style>
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
        width: 50%; /* Giảm kích thước ảnh đi 50% */
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
<?= view('templates/footer'); ?>

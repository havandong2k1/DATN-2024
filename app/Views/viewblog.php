<?= view('templates/header'); ?>
<div class="container">
    <?php if (!empty($blog)): ?>
        <h1><?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <img src="<?= $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" style="width: 100%;">
        <p><?= nl2br(htmlspecialchars($blog['content'], ENT_QUOTES, 'UTF-8')) ?></p>
    <?php else: ?>
        <p>Bài viết không tồn tại.</p>
    <?php endif; ?>
</div>
<?= view('templates/footer'); ?>

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
                    <?php if ($blog['status_blogs'] == 1): ?> <!-- Kiểm tra trạng thái bài viết -->
                        <div class="col-sm-4"> <!-- Mỗi bài viết sẽ chiếm 1/3 chiều ngang màn hình -->
                            <div class="blog-item">
                                <a href="<?= base_url('views/viewblog/' . $blog['id_blogs']) ?>"> <!-- Liên kết đến trang chi tiết -->
                                    <img src="<?= base_url('uploads/' . $blog['image']) ?>" 
                                    alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" class="blog-img"> 
                                    <h2 class="blog-title"><?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?> <!-- Kết thúc kiểm tra trạng thái -->
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
    .blog-img {
        border-radius: 10px;
        width: 50%;
        object-fit: cover;
    }
    .blog-title {
        font-size: 1.2em;
        margin-top: 10px;
        color: #333;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Tìm chiều cao lớn nhất của các phần tử hình ảnh
        var maxHeight = 0;
        $('.blog-img').each(function(){
            var thisHeight = $(this).height();
            if (thisHeight > maxHeight) {
                maxHeight = thisHeight;
            }
        });

        // Đặt chiều cao lớn nhất cho tất cả các ảnh
        $('.blog-img').height(maxHeight);

        // Tìm chiều cao lớn nhất của tiêu đề
        var maxTitleHeight = 0;
        $('.blog-title').each(function(){
            var thisHeight = $(this).height();
            if (thisHeight > maxTitleHeight) {
                maxTitleHeight = thisHeight;
            }
        });

        // Đặt chiều cao lớn nhất cho tất cả các tiêu đề
        $('.blog-title').height(maxTitleHeight);
    });
</script>
<?= view('templates/footer'); ?>

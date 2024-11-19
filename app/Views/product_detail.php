<?= view('templates/header'); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Danh mục sản phẩm</h2>
                    <div class="panel-group category-products" id="accordian">
                        <!-- Danh sách danh mục sản phẩm -->
                        <?php foreach ($categories as $category): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#"><?= esc($category) ?></a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="product-details">
                    <div class="col-sm-5">
                        <div>
                            <img src="uploads/<?= esc($productObj['images']); ?>" alt="images" height="300.6px" width="279.29px">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="product-information">
                            <h2><?= esc($productObj['name']) ?></h2>
                            <p>Giá: <?= number_format($productObj['price'], 0, ',', '.') ?> VND</p>
                            <p>Danh mục: <?= esc($productObj['category']) ?></p>
                            <span>
                                <label>Số lượng:</label>
                                <input type="number" name="quantity" min="1" value="1" id="productQuantity" required>
                            </span>
                            <form action="<?= site_url('cart/add') ?>" method="post" id="cartForm">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?= esc($productObj['id_product']) ?>">
                                <input type="hidden" name="quantity" id="hiddenQuantity">
                                <button type="button" onclick="addToCart()" class="btn btn-success">Thêm vào giỏ hàng</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="category-tab shop-details-tab">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
                            <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="details">
                            <p><?= esc($productObj['description']) ?></p>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="col-sm-12">
                                <!-- Hiển thị danh sách đánh giá -->
                                <?php if (!empty($reviews)): ?>
                                    <?php foreach ($reviews as $review): ?>
                                        <div class="review">
                                            <p>
                                                <strong><?= esc($review['customer_name'] ?? 'Người ẩn danh') ?>:</strong>
                                            </p>
                                            <p class="rating">
                                                <?php 
                                                $rating = esc($review['rating'] ?? 0);
                                                for ($i = 1; $i <= 5; $i++): 
                                                ?>
                                                    <span class="fa fa-star <?= $i <= $rating ? 'checked' : '' ?>"></span>
                                                <?php endfor; ?>
                                            </p>
                                            <p><?= esc($review['review'] ?? 'Nội dung không có') ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                <?php endif; ?>

                                <!-- Form thêm đánh giá -->
                                <h3>Thêm đánh giá của bạn</h3>
                                <form action="/product/addReview" method="post" id="reviewForm">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id_product" value="<?= esc($productObj['id_product']) ?>">
                                    <input type="hidden" name="customer_id" value="<?= session()->get('customer_id') ?? ''; ?>">
                                    <label for="rating">Đánh giá:</label>
                                    <div class="rating-stars">
                                        <span class="fa fa-star" data-value="1"></span>
                                        <span class="fa fa-star" data-value="2"></span>
                                        <span class="fa fa-star" data-value="3"></span>
                                        <span class="fa fa-star" data-value="4"></span>
                                        <span class="fa fa-star" data-value="5"></span>
                                        <input type="hidden" name="rating" id="rating" required>
                                    </div>
                                    <br>
                                    <label for="review">Nội dung:</label>
                                    <textarea name="review" required></textarea> <br>
                                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="recommended_items">
                    <h2 class="title text-center">Sản phẩm đề xuất</h2>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($recommendedProducts as $product): ?>
                                <div class="item <?= ($product === reset($recommendedProducts)) ? 'active' : '' ?>">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="uploads/<?= esc($product['images']); ?>" alt="images" height="200" width="100">
                                                    <h2><?= number_format($product['price'], 0, ',', '.') ?> VND</h2>
                                                    <p><?= esc($product['name']) ?></p>
                                                    <a href="javascript:void(0);" onclick="addToCart(<?= esc($product['id_product']) ?>)" class="btn btn-success">Thêm vào giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function addToCart() {
        var quantity = document.getElementById('productQuantity').value;
        document.getElementById('hiddenQuantity').value = quantity; // Set the hidden input value
        document.getElementById('cartForm').submit(); // Submit the form
    }

    // JavaScript cho phần đánh giá
    const stars = document.querySelectorAll('.rating-stars .fa-star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            resetStars();
            const currentStarValue = star.getAttribute('data-value');
            highlightStars(currentStarValue);
        });

        star.addEventListener('mouseout', () => {
            resetStars();
            // Ghi nhớ đánh giá đã chọn (nếu có)
            if (ratingInput.value) {
                highlightStars(ratingInput.value);
            }
        });

        star.addEventListener('click', () => {
            ratingInput.value = star.getAttribute('data-value');
            resetStars();
            highlightStars(ratingInput.value);
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= rating) {
                star.classList.add('checked');
            }
        });
    }

    function resetStars() {
        stars.forEach(star => {
            star.classList.remove('checked');
        });
    }
</script>

<style>
    .rating-stars {
        display: flex; /* Đặt chế độ hiển thị thành flex để các ngôi sao nằm ngang */
        direction: row; /* Đảm bảo các ngôi sao được sắp xếp theo chiều ngang */
    }

    .rating-stars .fa-star {
        font-size: 20px; /* Kích thước ngôi sao */
        cursor: pointer;
        color: #ccc; /* Màu xám cho ngôi sao chưa được chọn */
        margin-right: 5px; /* Khoảng cách giữa các ngôi sao */
    }

    .rating-stars .fa-star.checked {
        color: #ffcc00; /* Màu vàng cho ngôi sao đã được chọn */
    }
</style>

<?= view('templates/footer'); ?>

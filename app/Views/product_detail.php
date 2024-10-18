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
                                        <a href="#"><?= $category ?></a>
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
                                <input type="number" name="quantity" min="1" value="1" id="productQuantity">
                                <form action="/addToCart" method="post" id="cartForm">
                                    <input type="hidden" name="product_id" value="<?= esc(data: $productObj['id_product']) ?>">
                                    <input type="hidden" name="quantity" id="hiddenQuantity">
                                    <a href="javascript:void(0);" onclick="addToCart()" class="btn btn-success">Thêm vào giỏ hàng</a>
                                </form>
                            </span>
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
                                        <p><strong><?= esc($review['customer_name']) ?>:</strong> <?= esc($review['review']) ?></p>
                                        <p>Đánh giá: <?= esc($review['rating']) ?>/5</p>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                <?php endif; ?>

                                <!-- Form thêm đánh giá -->
                                <h3>Thêm đánh giá của bạn</h3>
                                <form action="/users/products/addReview" method="post">
                                    <input type="hidden" name="id_product" value="<?= esc($productObj['id_product']) ?>">
                                    <input type="hidden" name="customer_id" value="<?= session()->get('customer_id') ?>">
                                    <label for="rating">Đánh giá:</label>
                                    <input type="number" name="rating" min="1" max="5" required> / 5 <br>
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
                                <div class="item <?= $loop->first ? 'active' : '' ?>">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="uploads/<?= esc($product['images']); ?>" alt="images" height="100" width="100">
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
        document.getElementById('hiddenQuantity').value = quantity;
        document.getElementById('cartForm').submit();
    }
</script>

<?= view('templates/footer'); ?>

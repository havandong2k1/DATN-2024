<!-- views/cart/index.php -->

<?php include 'templates/header.php'; ?>
<section>
    <div class="container">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
        <div class="row">
            <div class="col-sm-3">
                <h2>Danh mục sản phẩm</h2>
                <ul class="list-group">
                    <?php if(isset($categories) && !empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <li class="list-group-item">
                                <a href="<?= base_url('views/product/' . urlencode($category)) ?>"><?= $category ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">Không có danh mục sản phẩm</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Sản phẩm</h2>
                    <div id="dataContainer" class="row">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img id="images" src="uploads/<?= $product['images']; ?>" alt="images">
                                                <h2 id="price"><?= $product['price']; ?> VND</h2>
                                                <p id="product"><?= $product['name']; ?></p>
                                                <p id="amount">Số lượng:<?= $product['amount']; ?></p>
                                                <p id="category">Danh mục: <?= $product['category'] ?></p>
                                                <!-- Modified the link to call addToCart() function -->
                                                <a href="#" onclick="addToCart(<?= $product['id_product'] ?>)" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <ul class="nav nav-pills nav-justified">
                                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào sở thích</a></li>
                                                <li><a href="<?= base_url('product/product_detail/' . $product['id_product']) ?>"><i class="fa fa-plus-square"></i>Chi tiết sản phẩm</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không có sản phẩm nào trong danh mục này.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Hiển thị phân trang -->
                    <div class="col-sm-12">
                        <?php echo $pager->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Function to add item to cart via AJAX
    function addToCart(productId) {
        console.log("id", productId);
        // Retrieve the CSRF token name and value
        const csrfName = $('[name="csrf_token"]').attr('name');
        const csrfHash = $('[name="csrf_token"]').val();

        // Make the AJAX request
        $.ajax({
            url: '<?= site_url('views/cart') ?>',
            type: 'POST',
            headers: {
                '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
            },
            data: {
                product_id: productId
            },
            success: function(response) {
                console.log("data", response);
                alert('Sản phẩm đã được thêm vào giỏ hàng.');
            },
            error: function(xhr, status, error) {
                alert('Đã xảy ra lỗi: ' + error);
            }
        });
    }
</script>
<?php include 'templates/footer.php'; ?>

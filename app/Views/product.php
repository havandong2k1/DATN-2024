<?php include 'templates/header.php'; ?>
<section>
    <div class="container">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
        <div class="row">
            <div class="col-sm-3">
                <h2>Danh mục sản phẩm</h2>
                <ul class="list-group">
                    <?php if (isset($categories) && !empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <li class="list-group-item">
                                <a href="<?= base_url('views/product/' . urlencode($category)) ?>"><?= esc($category) ?></a>
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
                    <?php if (session()->getFlashdata('msg_success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('msg_success') ?>
                        </div>
                    <?php endif; ?> 
                    <div id="dataContainer" class="row">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <a href="<?= base_url('product/product_detail/' . $product['id_product']) ?>">
                                                    <img id="images" src="uploads/<?= esc($product['images']); ?>" alt="images">
                                                </a>
                                                <h2 id="price"><?= number_format($product['price'], 0, ',', '.') ?> VND</h2>
                                                <p id="product"><?= esc($product['name']); ?></p>
                                                <p id="category">Danh mục: <?= esc($product['category']) ?></p>
                                                <form action="<?= site_url('cart/add') ?>" method="POST" style="display:inline;">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?= esc($product['id_product']) ?>">
                                                    <input type="hidden" name="quantity" min="1" value="1" style="width: 70px; display: inline;">
                                                    <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
                                                </form>
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
                    <div id="paginationContainer" class="text-center"></div> <!-- Phân trang -->
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'templates/footer.php'; ?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include ScrollUp Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>

<script>
$(document).ready(function () {
    // Sản phẩm phân trang
    const products = $('#dataContainer .col-sm-4');
    const itemsPerPage = 9;
    const totalPages = Math.ceil(products.length / itemsPerPage);

    function showPage(page) {
        products.hide();
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        products.slice(start, end).show();
    }

    function createPagination() {
        const pagination = $('<ul class="pagination"></ul>');
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = $(`<li class="page-item"><a class="page-link" href="#">${i}</a></li>`);
            pageItem.click(function (e) {
                e.preventDefault();
                showPage(i);
                $('.pagination .page-item').removeClass('active');
                $(this).addClass('active');
            });
            pagination.append(pageItem);
        }
        $('#paginationContainer').html(pagination);
        $('.pagination .page-item:first').addClass('active');
    }

    if (products.length > itemsPerPage) {
        createPagination();
    }
    showPage(1);

    // ScrollUp Plugin
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        scrollDistance: 300,   // Distance from top/bottom before showing element
        scrollFrom: 'top',     // 'top' or 'bottom'
        scrollSpeed: 300,      // Speed back to top
        easingType: 'linear',
        animation: 'fade',     // Fade, slide, none
        animationSpeed: 200,   // Animation speed
        scrollText: 'Scroll to top', // Text for element
        zIndex: 2147483647     // Z-Index for the element
    });
});
</script>

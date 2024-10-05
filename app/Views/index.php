<?= view('templates/header'); ?>  
<?= view('templates/slider'); ?>  
<hr>  
<section>  
    <div class="container">  
        <div class="row">  
            <div class="col-sm-3">  
                <div class="left-sidebar">  
                    <h2></h2>  
                    <div class="panel-group category-products" id="accordian">  
                    </div>  
                    <div class="shipping text-center">  
                        <img src="/assets/user/images/home/shipping.jpg" alt=""/>  
                    </div>  
                </div>  
            </div>  
            <div class="col-sm-9 padding-right">  
                <div class="features_items">  
                    <h2 class="title text-center">SẢN PHẨM NỔI BẬT</h2>  
                    <div class="row">  
                        <?php   
                        // Lấy 10 sản phẩm đầu tiên  
                        $featuredProducts = array_slice($cateObj, 0, 10);  
                        foreach ($featuredProducts as $product) : ?>  
                            <!-- Chỉ hiển thị sản phẩm có điều kiện == 1 -->  
                            <?php if ($product['status_product'] == 2) : ?>  
                                <div class="col-sm-4">  
                                    <div class="product-image-wrapper">  
                                        <div class="single-products">  
                                            <div class="productinfo text-center">  
                                                <img src="uploads/<?php echo $product['images']; ?>" alt="images">  
                                                <h2><?= ($product['name']) ?></h2>  
                                                <p>Giá: <?= number_format($product['price'], 0, ',', '.') ?> VND</p>  
                                                <p>Thông tin máy: <?= ($product['description']) ?></p> 
                                                <p>Sản phẩm: <?= ($product['category']) ?></p>  
                                                <form class="btn btn-default add-to-cart" action="" method="post">  
                                                <a href="javascript:void(0);" onclick="addToCart(<?= $product['id_product'] ?>)" class="btn btn-success">Thêm vào giỏ hàng</a>
                                                </form>  
                                            </div>  
                                        </div>  
                                        <div class="choose">  
                                            <ul class="nav nav-pills nav-justified">  
                                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào sở thích</a></li>  
                                                <li>  
                                                    <a href="<?= base_url('product/product_detail/' . $product['id_product']) ?>"><i  
                                                                class="fa fa-plus-square"></i>Chi tiết sản phẩm</a>  
                                                </li>  
                                            </ul>  
                                        </div>  
                                    </div>  
                                </div>  
                            <?php endif; ?>  
                        <?php endforeach; ?>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
</section>  
<script>
     function addToCart(productId) {
        // Chuyển hướng tới URL thêm sản phẩm vào giỏ hàng
        window.location.href = "<?= site_url('cart/add/') ?>" + productId;
    }
</script>
<?= view('templates/footer'); ?>
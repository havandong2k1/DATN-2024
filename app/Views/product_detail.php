<?= view('templates/header'); ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian">
                            <!--category-productsr-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">MÀN HÌNH</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">THÙNG MÁY</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">CHIP</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">RAM</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">SSD</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">HDD</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">CARD ĐỒ HỌA</a></h4>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">CHUỘT</a></h4>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">BÀN, GHẾ GAMING</a></h4>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="">QUẠT TẢN NHIỆT</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">TAI NGHE</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">TABLET</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">BÀN PHÍM</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">LAPTOP</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">IPAD</a></h4>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">LOA</a></h4>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-5">
                            <div>
                                <img src="uploads/<?php echo $productObj['images']; ?>" alt="images" height="300.6px"
                                     width="279.29px">
                            </div>
                            <!--                            <div id="similar-product" class="carousel slide" data-ride="carousel">-->
                            <!--                                -->
                            <!--                                  Wrapper for slides -->
                            <!--                                    <div style="padding-top: 20px" class="carousel-inner">-->
                            <!--                                        <div class="item active">-->
                            <!--                                          <a href=""><img src="images/product-details/similar1.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar2.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar3.jpg" alt=""></a>-->
                            <!--                                        </div>-->
                            <!--                                        <div class="item">-->
                            <!--                                          <a href=""><img src="images/product-details/similar1.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar2.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar3.jpg" alt=""></a>-->
                            <!--                                        </div>-->
                            <!--                                        <div class="item">-->
                            <!--                                          <a href=""><img src="images/product-details/similar1.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar2.jpg" alt=""></a>-->
                            <!--                                          <a href=""><img src="images/product-details/similar3.jpg" alt=""></a>-->
                            <!--                                        </div>-->
                            <!--                                        -->
                            <!--                                    </div>-->
                            <!---->
                            <!--                                Controls -->
                            <!--                                  <a class="left item-control" href="#similar-product" data-slide="prev">-->
                            <!--                                    <i class="fa fa-angle-left"></i>-->
                            <!--                                  </a>-->
                            <!--                                  <a class="right item-control" href="#similar-product" data-slide="next">-->
                            <!--                                    <i class="fa fa-angle-right"></i>-->
                            <!--                                  </a>-->
                            <!--                            </div>-->

                        </div>

                        <div class="col-sm-7">
                            <div class="product-information"><!--/product-information-->
                                <!--                                <img src="images/product-details/new.jpg" class="newarrival" alt="" />-->
                                <h2><?= $productObj['name'] ?></h2>
                                <p>Số lượng: <?= $productObj['amount'] ?></p>
                                <img src="images/product-details/rating.png" alt=""/>
                                <span>
                                   <p>Giá: <?= $productObj['price'] . ' ' . 'VND' ?></p>
                                    <label>Quantity:</label>
                                    <input type="number" min="1" value="1"/>
                                    <form action="addToCart" method="post" id="cartForm">
                                                    <input type="hidden" name="product_id" id="productId">
                                                    <button type="submit" class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                        </form>

                                </span>
                                <p>Danh mục: <?= $productObj['category'] ?></p>

                            </div><!--/product-information-->
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li><a href="#details" data-toggle="tab" class="active">Chi tiết sản phẩm</a></li>
                                <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="details" class="active">
                                <?php if (!empty ($productObj) && is_array($productObj)): ?>
                                    <?php foreach ($productObj as $key => $value): ?>
                                        <?php if ($key === 'description'): ?>
                                            <!-- Hiển thị mô tả sản phẩm -->
                                            <p><?= $value ?></p>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="tab-pane fade active in" id="reviews">
                                <div class="col-sm-12">
                                    <ul>
                                        <li><a><i class="fa fa-user"><?= session()->get("customer_name") ?></i></a></li>
                                        <li><a id="realtime-time" href=""><i class="fa fa-clock-o"></i></a></li>
                                        <li><a id="realtime-date" href=""><i class="fa fa-calendar-o"></i></a></li>
                                    </ul>

                                    <?= view('reviews/sendreviews'); ?>
                                </div>
                            </div>
                        </div>
                    </div><!--/category-tab-->

                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>
                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">

                                                    <a href="javascript:void(0)" onclick="addtocart()"
                                                       class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <a href="javascript:void(0)" onclick="addtocart()"
                                                       class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel"
                               data-slide="prev"><i
                                        class="fa fa-angle-left"></i></a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel"
                               data-slide="next"><i
                                        class="fa fa-angle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script>
        function addtocart() {
            // Get product ID (replace with your logic)
            var productId = document.getElementById("yourProductIdElement").value;

            // Set product ID in hidden field
            document.getElementById("productId").value = productId;

            // Submit the form
            document.getElementById("cartForm").submit();
        }
    </script>

<?= view('templates/footer'); ?>
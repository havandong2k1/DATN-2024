<?php include 'templates/header.php'; ?>

    <section id="cart_items">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>

        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Giỏ hàng</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="id_product">ID</td>
                        <td class="images">Ảnh sản phẩm</td>
                        <td class="name">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="subtotal">Tổng</td>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </section>
<?php include 'templates/footer.php'; ?>
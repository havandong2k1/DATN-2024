<?php
// Khởi tạo biến $current_page lấy phần cuối của URL hiện tại
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Trang chủ</title>
	<base href="http://localhost:8080/">
	<link href="/assets/user/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/user/css/font-awesome.min.css" rel="stylesheet">
	<link href="/assets/user/css/prettyPhoto.css" rel="stylesheet">
	<link href="/assets/user/css/price-range.css" rel="stylesheet">
	<link href="/assets/user/css/animate.css" rel="stylesheet">
	<link href="/assets/user/css/main.css" rel="stylesheet">
	<link href="/assets/user/css/responsive.css" rel="stylesheet">
	<!--[if lt IE 9]>
    <script src="/assets/user/html5shiv./assets/user"></script>
    <script src="/assets/user/respond.min./assets/user"></script>
    <![endif]-->
	<link rel="shortcut icon" href="/assets/user/images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/user/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/user/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/user/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/assets/user/images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>
	<header id="header">
		<div class="header_top">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i>0943 9979 01</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> testwithdraw001@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="https://www.facebook.com/DuongDinh1703"><i class="fa fa-facebook"></i></a></li>
								<li><a href="https://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
								<li><a href="https://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="header-middle">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php?page=Trang-chu"><img src="/assets/images/logo.png" alt="" width="270" height="120"/></a>
						</div>
					</div>
					<div class="shop-menu pull-right">
						<?php if (session()->has("customer_name")): ?>
							<ul class="nav navbar-nav">
								<li>
									<a href="views/profile"><i class="fa fa-user"></i><?= session()->get("customer_name") ?></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-star"></i> Yêu thích</a>
								</li>
								<li>
									<a href="views/cart">
										<i class="fa fa-shopping-cart"></i> Giỏ hàng
										<?php if (isset($totalQuantity) && $totalQuantity > 0): ?>
											<span class="badge badge-warning" style="background-color: #f39c12; border-radius: 50%; padding: 5px 10px;">
												<?= esc($totalQuantity) ?>
											</span>
										<?php endif; ?>
									</a>
								</li>
								<li>
									<a href="/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a>
								</li>
							</ul>
						<?php else: ?>
							<ul class="nav navbar-nav">
								<li><a href="views/profile"><i class="fa fa-user"></i>Tài khoản</a></li>
								<li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
								<li><a href="views/cart"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								<li><a href="/login"><i class="fa fa-lock"></i> Đăng nhập</a></li>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div id="Header" class="header-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
                            <ul class="nav navbar-nav">
                                <li class="<?= ($current_page == 'Trang-chu' || $current_page == '') ? 'active' : '' ?>">
                                    <a href="index.php?page=Trang-chu">Trang chủ</a>
                                </li>
                                <li class="<?= ($current_page == 'product/0') ? 'active' : '' ?>">
                                    <a href="/views/product/0">Cửa hàng</a>
                                </li>
                                <li class="<?= ($current_page == 'blog') ? 'active' : '' ?>">
                                    <a href="/views/blog">Tin tức công nghệ</a>
                                </li>
                                <li class="<?= ($current_page == 'intro') ? 'active' : '' ?>">
                                    <a href="/views/intro">Giới thiệu</a>
                                </li>
                                <li class="<?= ($current_page == 'contact') ? 'active' : '' ?>">
                                    <a href="/views/contact">Liên hệ</a>
                                </li>
                            </ul>
                        </div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<label for="search-input" class="sr-only">Tìm kiếm sản phẩm</label>
							<input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." />
							<div id="search-results" style="display: none; position: absolute; background: white; width: 100%; border: 1px solid #ddd; border-radius: 5px; z-index: 1000;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<style>
        .product {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
    $(document).ready(function() {
        let searchTimeout;

        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimeout); // Xóa timeout trước đó (nếu có)

            var csrfName = '<?= csrf_token() ?>';  // Lấy tên token CSRF
            var csrfHash = '<?= csrf_hash() ?>';  // Lấy giá trị token CSRF
            var keyword = $(this).val().trim();  // Lấy giá trị từ input tìm kiếm

            if (keyword.length > 2) {  // Nếu từ khóa tìm kiếm dài hơn 2 ký tự
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: '/product/search',  // Đảm bảo URL chính xác
                        type: 'POST',  // POST request
                        dataType: 'json',  // Đảm bảo dữ liệu trả về ở định dạng JSON
                        data: {
                            keyword: keyword,
                            [csrfName]: csrfHash  // Thêm CSRF token vào dữ liệu gửi đi
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#search-results').html(response.html).show(); // Hiển thị HTML từ server
                            } else {
                                $('#search-results').html('<p>Không tìm thấy sản phẩm nào.</p>').show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', xhr.responseText);  // Log lỗi trong console
                            $('#search-results').html('<p>Có lỗi xảy ra khi tìm kiếm.</p>').show();
                        }
                    });
                }, 300); // Delay 300ms để giảm số lượng request
            } else {
                $('#search-results').hide();  // Ẩn kết quả tìm kiếm nếu từ khóa ngắn hơn 3 ký tự
            }
        });

        // Ẩn kết quả tìm kiếm khi click ra ngoài
        $(document).click(function(event) {
            if (!$(event.target).closest('#search-input').length && !$(event.target).closest('#search-results').length) {
                $('#search-results').hide();
            }
        });
    });
</script>

</body>
</html>

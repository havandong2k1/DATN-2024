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
	<link rel="shortcut icon" href="/assets/user//assets/user/images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/user/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/user/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/user/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/assets/user/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i>0812453363</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> dduong1703@gmail.com</a></li>
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
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php?page=Trang-chu"><img src="/assets/images/logo.png" alt="" width="270" height="120"/></a>
						</div>
						<!-- <div class="btn-group pull-right">
							<div class="btn-group">
							</div>
							
							<div class="btn-group">
							</div>
						</div> -->
					</div>
                    <div class="shop-menu pull-right">
                        <?php if(session()->has("customer_name")): ?>
                            <!-- Hiển thị khi người dùng đã đăng nhập -->
                            <ul class="nav navbar-nav --bs-breadcrumb-divider: '>'">
                                <li><a class="breadcrumb-item" href="views/profile"><i class="fa fa-user"></i><?= session()->get("customer_name") ?></a></li>
                                <li><a class="breadcrumb-item" href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                                <li><a class="breadcrumb-item" href="views/cart"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                <li><a class="breadcrumb-item" href="/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
                            </ul>
                        <?php else: ?>
                            <!-- Hiển thị khi người dùng chưa đăng nhập -->
                            <ul class="nav navbar-nav --bs-breadcrumb-divider: '>'">
                                <li><a class="breadcrumb-item" href="views/profile"><i class="fa fa-user"></i>Tài khoản</a></li>
                                <li><a class="breadcrumb-item" href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                                <li><a class="breadcrumb-item" href="views/cart"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                <li><a class="breadcrumb-item" href="/login"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                </div>
			</div>
		</div><!--/header-middle-->

		<div id="Header" class="header-bottom"><!--header-bottom-->
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
						<div  class="mainmenu pull-left">
							<ul  class="nav navbar-nav collapse navbar-collapse">
								<li><a  href="index.php?page=Trang-chu" id="myactive" class=" breadcrumb-item active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Cửa hàng<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a class="breadcrumb-item" href="views/product/0">Sản phẩm</a></li>
										<!-- <li><a href="product-details.html">Product Details</a></li> -->
									</ul>
								</li>
								
								<!-- <li><a href="404.html">404</a></li> -->
								<li><a class="breadcrumb-item" href="views/blog">Tin tức công nghệ</a></li>
                                <li><a class="breadcrumb-item" href="views/intro">Giới thiệu</a></li>
								<li><a class="breadcrumb-item" href="views/contact">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search" />
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	<style>
        .product {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
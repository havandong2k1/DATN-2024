<?php

use App\Controllers\Users\HomeControllers;
use App\Controllers\Users\ProductsController;
use App\Controllers\Admin\ProductController;
use CodeIgniter\Router\RouteCollection;
use CodeIgniter\RESTful\ResourceController;
use App\Filters\AuthFilter;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Users\HomeControllers::index');
$routes->get('views/index', 'Users\HomeControllers::index');

// Đăng nhập User
$routes->get('login', 'Users\HomeControllers::login');
$routes->post('/login', 'Users\HomeControllers::login');

// Đăng ký User
$routes->get('views/register', 'Users\HomeControllers::register');
$routes->post('views/register', 'Users\HomeControllers::register');

// Đăng xuất
$routes->get('logout', 'Users\HomeControllers::logout');
// Lấy lại mk
$routes->get('forgot-password', 'Users\HomeControllers::forgotPassword');
$routes->post('forgot-password', 'Users\HomeControllers::forgotPassword');
$routes->get('password/reset/(:any)', 'Users\HomeControllers::resetPassword/$1');
$routes->post('password/update', 'Users\HomeControllers::updatePassword');




// Hồ sơ và các trang khác
$routes->get('views/profile', 'Users\HomeControllers::profile');
$routes->get('views/blog', 'Users\HomeControllers::blog');
$routes->get('views/viewblog/(:num)', 'Users\HomeControllers::viewBlog/$1');
$routes->get('views/intro', 'Users\HomeControllers::intro');
$routes->get('views/contact', 'Users\HomeControllers::contact');
$routes->get('views/product/(:segment)', 'Users\HomeControllers::product/$1');
$routes->get('product_detail/(:num)', 'Users\HomeControllers::product_detail/$1');

// Giỏ hàng
$routes->get('views/cart', 'Users\CartControllers::index');
// $routes->get('cart/add/(:num)', 'Users\CartControllers::addCart/$1');
$routes->post('cart/add', 'Users\CartControllers::addCart');
$routes->get('cart/remove/(:num)', 'Users\CartControllers::removeFromCart/$1');
$routes->get('cart/increase/(:num)', 'Users\CartControllers::increaseQuantity/$1');
$routes->get('cart/decrease/(:num)', 'Users\CartControllers::decreaseQuantity/$1');



// Product - User
$routes->group('product', function ($routes) {
    // Route cho chi tiết sản phẩm, sử dụng phương thức GET
    // $routes->get('product_detail/(:num)', 'Users\ProductsController::productDetail/$1');
    $routes->get('product_detail/(:num)/(:segment)', 'Users\ProductsController::productDetail/$1/$2');
    $routes->get('product_detail/(:num)', 'Users\ProductsController::productDetail/$1');
    $routes->post('addReview', 'Users\ProductsController::addReview');  
    $routes->post('search', 'Users\ProductsController::search');
});


// Đặt hàng
$routes->get('order', 'Users\OrderController::index');
$routes->post('order/placeOrder', 'Users\OrderController::placeOrder');
$routes->get('success', 'Users\OrderController::orderSuccess');

// Đơn hàng
$routes->get('/order-status-form', 'Users\OrderController::orderStatusForm');
$routes->post('/check-order-status', 'Users\OrderController::checkOrderStatus');
$routes->match(['get', 'post'], '/order/status', 'Users\OrderController::orderStatus');
$routes->get('order/status/(:any)', 'Users\OrderController::orderStatusView/$1');

// Order management routes for Admin
$routes->group('admin/order', ['filter' => 'AdminFilter'], function ($routes) {
    $routes->get('list', 'Admin\OrderControllers::list');
    $routes->get('edit/(:num)', 'Admin\OrderControllers::edit/$1');
    $routes->post('update/(:num)', 'Admin\OrderControllers::update/$1');
    $routes->post('delete/(:num)', 'Admin\OrderControllers::deletedOrder/$1');
});

// Mail
$routes->get('views/mail', 'Users\EmailController::index');
$routes->match(['get', 'post'], 'contact/mail', 'Users\EmailController::sendMail');

// Testup
$routes->get('admin/pages/product/add', 'UploadControllers::add'); // Thêm sản phẩm
$routes->post('public/upload', 'UploadControllers::upload'); // Upload file

// Checkout
$routes->get('views/checkout', 'Users\HomeControllers::checkout');

// ajax
$routes->post('order/get-districts', 'Users\OrderController::getDistricts');
$routes->post('order/get-wards', 'Users\OrderController::getWards');

// Trang lỗi
$routes->get('error/404', function () {
    return view('errors/html/error_404');
});

// Hiển thị file
$routes->get('showfile/(:any)', 'Admin\FileControllers::index/$1');

// Admin-web
$routes->get('admin/login', 'Admin\LoginControllers::index');
$routes->post('admin/login', 'Admin\LoginControllers::login');

$routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
    $routes->get('pages/home', 'Admin\HomeControllers::index');
    $routes->get('logout', 'Admin\LoginControllers::logout');

    // Quản lý tài khoản admin
    $routes->group('user', function ($routes) {
        $routes->get('list', 'Admin\UserControllers::list');
        $routes->get('add', 'Admin\UserControllers::add');
        $routes->post('create', 'Admin\UserControllers::create');
        $routes->get('edit/(:num)', 'Admin\UserControllers::edit/$1');
        $routes->post('update', 'Admin\UserControllers::update');
        $routes->get('delete/(:num)', 'Admin\UserControllers::delete/$1');
    });

    // Quản lý khách hàng
    $routes->group('customer', function ($routes) {
        $routes->get('list', 'Admin\CustomerControllers::listCustomer');
        $routes->get('toggle-status/(:num)', 'Admin\CustomerControllers::toggleStatus/$1');
        $routes->get('delete/(:num)', 'Admin\CustomerControllers::delete/$1');
    });

    // Quản lý sản phẩm
    $routes->group('product', function ($routes) {
        $routes->get('list', 'Admin\ProductControllers::list');
        $routes->get('add', 'Admin\ProductControllers::add');
        $routes->post('create', 'Admin\ProductControllers::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\ProductControllers::editOrUpdate/$1'); // Sửa và cập nhật
        $routes->get('delete/(:num)', 'Admin\ProductControllers::delete/$1');
    });

    // Quản lý blog
    $routes->group('blog', function ($routes) {
        $routes->get('list', 'Admin\BlogControllers::list');
        $routes->get('add', 'Admin\BlogControllers::add');
        $routes->post('create', 'Admin\BlogControllers::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\BlogControllers::editOrUpdate/$1'); // Sửa và cập nhật
        $routes->post('delete', 'Admin\BlogControllers::delete');
    });

    // Quản lý đánh giá
    $routes->group('reviews', function ($routes) {
        $routes->get('list', 'Admin\ReviewsControllers::list');
    });

    // Thông số
    $routes->group('parameter', function ($routes) {
        $routes->get('countCus', 'Admin\HomeControllers::totalCustomer');
    });
});

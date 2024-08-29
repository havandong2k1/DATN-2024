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
//WEB-GUI
$routes->get('/', 'Users\HomeControllers::index');
$routes->get('views/index', 'HomeControllers::index');

//Đăng nhập web
$routes->get('login', 'Users\HomeControllers::login');
$routes->post('/login', 'Users\HomeControllers::login');

//Đăng ký web
$routes->get('views/register', 'Users\HomeControllers::register');
$routes->post('views/register', 'Users\HomeControllers::register');

//Đăng xuất
$routes->get('logout', 'Users\HomeControllers::logout');


//$routes->get('views/login', 'Users\HomeControllers::profile');
$routes->get('views/profile', 'Users\HomeControllers::profile');
$routes->get('views/blog', 'Users\HomeControllers::blog');
$routes->get('views/intro', 'Users\HomeControllers::intro');
$routes->get('views/contact', 'Users\HomeControllers::contact');
$routes->get('views/product/(:segment)', 'Users\HomeControllers::product/$1');
$routes->get('product_detail/(:num)', 'Users\HomeControllers::product_detail/$1');

//giỏ hàng
$routes->match(['get', 'post'], 'views/cart', 'Users\CartControllers::addCart');
$routes->post('addToCart', 'Users\CartControllers::addToCart');

// Product - User
$routes->group('product', function ($routes) {
    $routes->get('product_detail/(:num)', 'Users\ProductsController::productDetail/$1');
});


//Mail
$routes->get('/', 'Users\EmailController::index');
$routes->match(['get', 'post'], 'contact/mail', 'Users\EmailController::sendMail');


//testup
$routes->get('admin/pages/product/add', 'UploadControllers::add');// Add this line.
$routes->post('public/upload', 'UploadControllers::upload'); // Add this line.


//Checkout
$routes->get('views/checkout', 'Users\HomeControllers::checkout');


$routes->get('error/404', function () {
    return view('errors/html/error_404');
});


$routes->get('showfile/(:any)', 'Admin\FileControllers::index/$1');


//Admin-web
$routes->get('admin/login', 'Admin\LoginControllers::index');
$routes->post('admin/login', 'Admin\LoginControllers::login');


$routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
    $routes->get('pages/home', 'Admin\HomeControllers::index');
//    $routes->get('home', 'Admin\HomeControllers::index');
    $routes->get('logout', 'Admin\LoginControllers::logout');

    $routes->group('user', function ($routes) {
        $routes->get('list', 'Admin\UserControllers::list');
        $routes->get('add', 'Admin\UserControllers::add');
        $routes->post('create', 'Admin\UserControllers::create');
        $routes->get('edit/(:num)', 'Admin\UserControllers::edit/$1');
        $routes->post('update', 'Admin\UserControllers::update');
        $routes->get('delete/(:num)', 'Admin\UserControllers::delete/$1');
    });

    $routes->group('product', function ($routes) {
        $routes->get('list', 'Admin\ProductControllers::list');
        $routes->get('add', 'Admin\ProductControllers::add');
        $routes->post('create', 'Admin\ProductControllers::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\ProductControllers::editOrUpdate/$1'); // Use match for both GET and POST
        $routes->post('delete', 'Admin\ProductControllers::delete');
    });

    $routes->group('blog', function ($routes) {
        $routes->get('list', 'Admin\BlogControllers::list');
        $routes->get('add', 'Admin\BlogControllers::add');
        $routes->post('create', 'Admin\BlogControllers::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\BlogControllers::editOrUpdate/$1'); // Use match for both GET and POST
        $routes->post('delete', 'Admin\BlogControllers::delete');
    });

    $routes->group('order', function ($routes) {
        $routes->get('list', 'Admin\OrderControllers::list');
    });

    $routes->group('reviews', function ($routes) {
        $routes->get('list', 'Admin\ReviewsControllers::list');
    });
});


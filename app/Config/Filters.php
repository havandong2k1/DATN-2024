<?php

namespace Config;

use App\Filters\AuthFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'AdminFilter'   => AuthFilter::class,
    ];

    public array $globals = [
        'before' => [
            'csrf' => ['except' => [
                'order/placeOrder', // Tắt CSRF cho route đặt hàng
                'cart/add/*', // Tắt CSRF cho route thêm vào giỏ hàng
                'process', // Tắt CSRF cho route xử lý thanh toán
                'admin/order/edit/*', // Tắt CSRF cho các route chỉnh sửa đơn hàng
                'admin/order/update/*', // Tắt CSRF cho các route cập nhật đơn hàng
                'order/get-wards', // Tắt CSRF cho route lấy xã/phường
                'order/get-districts', // Tắt CSRF cho route lấy quận/huyện
                'product/search', // Tắt CSRF cho route tìm kiếm sản phẩm

            ]],
        ],
        'after' => [
            'toolbar',
        ],
    ];
    
    
    public array $methods = [];

    public array $filters = [];
}

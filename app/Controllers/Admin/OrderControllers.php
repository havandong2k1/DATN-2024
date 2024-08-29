<?php


namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Common\ResultUtils;
use App\Models\BaseModel;
use App\Services\CartService;
use Exception;

class OrderControllers extends BaseController
{

    /**
     * @var Service
     */
    private $service;

    public function __construct()
    {
        $this->service = new CartService();
    }

    public function list(): string
    {
        $data = [];
        $cssFiles = [
            'http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
            base_url() . '/assets/admin/js/event.js',
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css'
        ];

        $order = [];
        $dataLayout = [];
        if ($order) {
            $dataLayout['orders'] = $order;
        }
        $data = $this->loadMasterLayout($data, 'Danh sách đơn hàng', 'admin/pages/order/list', $dataLayout, $cssFiles, $jsFiles);
        return view('admin/main', $data);
    }
}
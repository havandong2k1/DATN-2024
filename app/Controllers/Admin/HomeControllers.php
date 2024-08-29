<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProductModel;

class HomeControllers extends BaseController
{

    public function __construct()
    {
        $db      = \Config\Database::connect();
    }


    public function index(): string
    {

        $userModel = new UserModel();
        $data = [];
        $cssFiles = [];
        $jsFiles = [];
        $data = $this->loadMasterLayout ($data, 'Trang chủ', 'admin/pages/home', $jsFiles, $cssFiles);
        return view('admin/main', $data );
    }



}
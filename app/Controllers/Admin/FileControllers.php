<?php

namespace App\Controllers;


class FileControllers extends BaseController
{
    public function index()
    {
        dd($this->request);
        return view('admin/pages/product/add', ['errors' => []]);
    }
}
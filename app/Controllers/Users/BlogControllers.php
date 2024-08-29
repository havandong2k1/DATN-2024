<?php


namespace App\Controllers;


use App\Models\BlogModel;

class BlogControllers extends BaseController
{
    public function index($id_blogs)
    {
        $BlogModel = new BlogModel();

        $data['blogs'] = $BlogModel->findAll($id_blogs);

        return view('blog', $data);
    }
}
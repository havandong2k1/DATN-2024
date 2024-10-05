<?php


namespace App\Controllers;


use App\Models\BlogModel;

class BlogControllers extends BaseController
{
    public function index($id_blogs)
    {
        $blogModel = new BlogModel();

        $data['blogs'] = $blogModel->findAll($id_blogs);

        return view('blog', $data);
    }
}
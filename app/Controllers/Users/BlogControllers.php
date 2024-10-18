<?php


namespace App\Controllers;

use App\Models\BlogModel;

class BlogControllers extends BaseController
{
    public function index($id_blogs)
    {
        $blogModel = new BlogModel();
        $blog = $blogModel->find($id_blogs);
        if (!$blog) {
            return redirect()->to('/error/404')->with('error', 'Không tìm thấy bài viết.');
        }
        $data['blog'] = $blog; 
        return view('blog', $data); 
    }
}
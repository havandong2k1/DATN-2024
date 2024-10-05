<?php

namespace App\Controllers\Admin;

use App\Common\ResultUtils;
use App\Models\BaseModel;
use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\ProductModel;
use App\Services\BlogsService;
use Exception;

class BlogControllers extends BaseController
{
    /**
     * @var Service
     */
    private $service;

    public function __construct()
    {
        $this->service = new BlogsService();
    }

    public function list(): string
    {
        $data = [];
        //$data = $this->service->getAllBlogs();
        //dd($data);
        $cssFiles = [
            'http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
            base_url() . '/assets/admin/js/event.js',
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css'
        ];

        $blogModel = new BlogModel();
        $blogs = $blogModel->findAll();
        // print_r($blogs);
        // die();
        $dataLayout = [];
        if ($blogs) {
            $dataLayout['blogs'] = $blogs;
        }
        $data = $this->loadMasterLayout($data, 'Danh sách bài viết', 'admin/pages/blog/list', $dataLayout, $cssFiles, $jsFiles);
        return view('admin/main', $data);
    }


    public function add()
    {
        $data = [];
        $blogs = new BlogModel();
        $data['blogs'] = $blogs->findAll();
        $data = $this->loadMasterLayout($data, 'Thêm bài viết', 'admin/pages/blog/add');
        return view('admin/main', $data);
    }

    public function create()
    {
        // Kiểm tra xem form có được submit hay không
        if ($this->request->getMethod() === 'post') {
            $blogModel = new BlogModel();

            // Lấy dữ liệu từ form
            $content = $this->request->getPost('content');
            $title = $this->request->getPost('title');

            // Lấy file hình ảnh từ form
            $imageFile = $this->request->getFile('image');
            $imageName = '';

            // Kiểm tra xem file ảnh có hợp lệ không
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                // Đặt tên ngẫu nhiên cho file để tránh trùng lặp
                $imageName = $imageFile->getRandomName();

                // Đường dẫn thư mục lưu trữ ảnh
                $uploadDirectory = WRITEPATH . 'ingBlog';

                // Di chuyển file vào thư mục lưu trữ
                if ($imageFile->move($uploadDirectory, $imageName)) {
                    // Lưu tên file ảnh vào cơ sở dữ liệu
                    $data = [
                        'content' => $content,
                        'title' => $title,
                        'image' => $imageName, // Lưu tên file ảnh
                    ];

                    // Lưu dữ liệu vào cơ sở dữ liệu
                    $blogModel->save($data);
                    
                    // Đặt thông báo thành công và chuyển hướng
                    session()->setFlashdata('msg_success', 'Thêm bài viết thành công');
                    return redirect()->to('admin/blog/list');
                } else {
                    session()->setFlashdata('msg_error', 'Có lỗi xảy ra khi lưu ảnh');
                }
            } else {
                session()->setFlashdata('msg_error', 'Tệp ảnh không hợp lệ hoặc không được chọn');
            }
        }

        // Hiển thị form nếu chưa submit
        return view('admin/blog/create');
    }

    public function editOrUpdate($id_blogs)
    {
        $blogModel = new BlogModel();
        $blogs = $this->service->getBlogsByID($id_blogs);

        if (!$blogs) {
            return redirect()->to('error/404')->with('error', 'Không tìm thấy bài viết với ID: ' . $id_blogs);
        }
        if ($this->request->getMethod() === 'post') {
            // Xử lý biểu mẫu khi người dùng gửi để cập nhật thông tin sản phẩm
            $updatedData = [
                'content' => $this->request->getPost('content'),
                'title' => $this->request->getPost('title'),

            ];
            // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
            $blogModel->update($id_blogs, $updatedData);
            // Chuyển hướng đến trang sản phẩm đã chỉnh sửa hoặc bất kỳ trang nào khác mong muốn
            session()->setFlashdata('success', 'Sửa thành công');
            return redirect()->to('admin/blog/edit/' . $id_blogs);
        }
        // Hiển thị biểu mẫu chỉnh sửa
        $cssFiles = [
            base_url() . '/assets/admin/js/event.js'
        ];
        $dataLayout['blog'] = $blogs;
        $data = $this->loadMasterLayout([], 'Sửa tài khoản', 'admin/pages/blog/edit', $dataLayout, $cssFiles, []);
        return view('admin/main', $data);
    }

    public function delete()
    {

        $blogModel = new BlogModel();
        $ids = $this->request->getPost('id_blogs');

        // Chuyển $ids thành một mảng nếu nó không phải là mảng
        if (!is_array($ids)) {
            $ids = explode(',', $ids); // Phân tách chuỗi thành mảng dựa trên dấu phẩy
        }
        // Kiểm tra xem có id nào được gửi lên không
        if (!empty($ids)) {
            foreach ($ids as $id) {
                // Xóa bài viết với id được chỉ định
                $blogModel->delete($id);
            }
            session()->setFlashdata('msg_success', 'Thành công');
        } else {
            session()->setFlashdata('msg_error', 'Không thành công');
        }

        return redirect()->to(base_url('admin/blog/list'));
    }
}
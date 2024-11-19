<?php

namespace App\Controllers\Admin;

use App\Common\ResultUtils;
use App\Models\BaseModel;
use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Services\BlogsService;

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
            $uploadDirectory = WRITEPATH . 'uploads'; // Thư mục lưu trữ tạm

            // Di chuyển file vào thư mục lưu trữ
            if ($imageFile->move($uploadDirectory, $imageName)) {
                // Di chuyển ảnh từ writable/uploads sang public/uploads
                $targetPath = FCPATH . 'uploads/' . $imageName; // Đường dẫn đích
                copy($uploadDirectory . '/' . $imageName, $targetPath); // Sao chép tệp vào thư mục public

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
            // Lấy dữ liệu từ form
            $updatedData = [
                'content' => $this->request->getPost('content'),
                'title' => $this->request->getPost('title'),
                'status_blogs' => $this->request->getPost('status_blogs'),
            ];

            // Lấy file hình ảnh từ form
            $imageFile = $this->request->getFile('image');
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                // Đặt tên ngẫu nhiên cho file để tránh trùng lặp
                $imageName = $imageFile->getRandomName();
                $uploadDirectory = WRITEPATH . 'uploads'; // Đường dẫn lưu ảnh

                // Di chuyển file vào thư mục lưu trữ
                if ($imageFile->move($uploadDirectory, $imageName)) {
                    $updatedData['image'] = $imageName; // Cập nhật tên ảnh mới
                }
            }

            // Cập nhật thông tin bài viết trong cơ sở dữ liệu
            $blogModel->update($id_blogs, $updatedData);
            session()->setFlashdata('msg_success', 'Sửa thành công');
            return redirect()->to('admin/blog/list');
        }
        // Hiển thị biểu mẫu chỉnh sửa
        $cssFiles = [
            base_url() . '/assets/admin/js/event.js'
        ];
        $dataLayout['blog'] = $blogs;
        $data = $this->loadMasterLayout([], 'Sửa bài viết', 'admin/pages/blog/edit', $dataLayout, $cssFiles, []);
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
            session()->setFlashdata('msg_success', 'Xóa bài viết thành công');
        } else {
            session()->setFlashdata('msg_error', 'Không có bài viết nào để xóa');
        }

        return redirect()->to(base_url('admin/blog/list'));
    }
}

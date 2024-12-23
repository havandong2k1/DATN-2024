<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\ProductsService;
use App\Models\ProductModel;


class ProductControllers extends BaseController
{

    /**
        @var Service
     */
    private $service;

    public function __construct()
    {
        $this->service = new ProductsService();
        // $this->validation = \Config\Services::validation();

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
        $dataLayout['products'] = $this->service->getAllProduct();
        $data = $this->loadMasterLayout($data, 'Danh sách sản phẩm', 'admin/pages/product/list', $dataLayout, $cssFiles, $jsFiles);
        return view('admin/main', $data);
    }

   
    public function add()
    {
        $data = [];
        $products = new ProductModel();
        $data = $this->loadMasterLayout($data, 'Thêm sản phẩm', 'admin/pages/product/add');

        return view('admin/main', $data);
    }

    public function create()
    {
        $productModel = new ProductModel();

        // Lấy dữ liệu post
        $productObj = $this->request->getPost();

        // Xử lý giá tiền: loại bỏ dấu chấm để đảm bảo giá trị số đúng
        if (isset($productObj['price'])) {
            $productObj['price'] = preg_replace('/\D/', '', $productObj['price']); // Loại bỏ tất cả ký tự không phải số
        }

        // Kiểm tra xem đã có tệp ảnh được tải lên hay chưa
        if ($imageFile = $this->request->getFile('images')) {
            // Đường dẫn thư mục lưu trữ ảnh
            $uploadDirectory = FCPATH . 'uploads'; // Thư mục lưu trữ trên máy chủ

            // Tạo tên file duy nhất để tránh trùng lặp
            $newName = $imageFile->getRandomName();

            // Di chuyển ảnh vào thư mục lưu trữ
            if ($imageFile->move($uploadDirectory, $newName)) {
                // Lưu đường dẫn của ảnh vào mảng dữ liệu sản phẩm
                $productObj['images'] = $newName; // Chỉ lưu đường dẫn tương đối
            }
        } else {
            // Nếu không có ảnh được tải lên, đặt giá trị của trường ảnh là chuỗi rỗng
            $productObj['images'] = '';
        }
        $productObj['id_product'] = null;
        try {
            $productModel->protect(false)->insert($productObj);
            session()->setFlashdata('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Có lỗi xảy ra khi thêm sản phẩm');
        }
        return redirect()->to(base_url('admin/product/list'));
    }


    public function editOrUpdate($id)
    {
        $productModel = new ProductModel();
        $product = $this->service->getProductByID($id);

        if (!$product) {
            return redirect()->to('error/404')->with('error', 'Không tìm thấy sản phẩm với ID: ' . $id);
        }
        if ($this->request->getMethod() === 'post') {
            // Xử lý biểu mẫu khi người dùng gửi để cập nhật thông tin sản phẩm
            $updatedData = [
                'name' => $this->request->getPost('name'),
                'price' => $this->request->getPost('price'),
                'status_product' => $this->request->getPost('status_product'),
                'description' => $this->request->getPost('description'),
                'amount' => $this->request->getPost('amount'),
                'category' => $this->request->getPost('category'),
            ];  
            // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
            $productModel->update($id, $updatedData);
            // Chuyển hướng đến trang sản phẩm đã chỉnh sửa hoặc bất kỳ trang nào khác mong muốn
            session()->setFlashdata('success', 'Sửa thành công');
            return redirect()->to('admin/product/edit/' . $id);
        }
        // Hiển thị biểu mẫu chỉnh sửa
        $cssFiles = [
            base_url() . '/assets/admin/js/event.js'
        ];
        $dataLayout['product'] = $product;
        $data = $this->loadMasterLayout([], 'Sửa sản phẩm', 'admin/pages/product/edit', $dataLayout, $cssFiles, []);
        return view('admin/main', $data);
    }
    public function delete($id)
    {
        // Tìm sản phẩm theo ID
        $productModel = new ProductModel();
        $product = $productModel->find($id);
        // Nếu sản phẩm tồn tại
        if ($product) {
            $productModel->delete($id);
            return redirect()->to(base_url('admin/product/list'))->with('msg_success', 'Sản phẩm đã được xóa thành công!');
        } else {
            return redirect()->to(base_url('admin/product/list'))->with('msg_error', 'Sản phẩm không tồn tại!');
        }
    }
    public function search(){
        $ProductModel = new ProductModel();
        $name = $this -> request ->getPost('name');
        $data = $ProductModel->getdata($name);
        return view('admin/product/list', ['data'=>$data]);
    }

}

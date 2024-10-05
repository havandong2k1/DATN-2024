<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\CustomerModel;

class HomeControllers extends BaseController
{
    public function index(): string
    {
        $productModel = new ProductModel();
        $allParam = $productModel->findAll();
        $products = [];
        $data['cateObj'] = $allParam;
        $data['recommendedProducts'] = $productModel->findAll();
        $cartModel = new CartModel();
        $session = session();
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $customerId = $session->get('customer_id');
        // Khởi tạo biến tổng số lượng sản phẩm
        $totalQuantity = 0;
        // Nếu người dùng đã đăng nhập, tính toán tổng số sản phẩm trong giỏ hàng
        if ($customerId) {
            $condition = [
                'deleted_at' => null,
                'customer_id' => $customerId,
            ];
            $withSelect = 'quantity, id_product';
            $dataCartUser = $cartModel->getByConditions($condition, '', $withSelect);
            
            if ($dataCartUser) {
                foreach ($dataCartUser as $item) {
                    $totalQuantity += $item['quantity'];
                }
            }
        }
        // Lưu tổng số lượng sản phẩm vào mảng dữ liệu
        $data['totalQuantity'] = $totalQuantity; 
        // Trả về view với dữ liệu
        return view('index', $data);
    }


    public function login()
    {
        // Kiểm tra nếu đã đăng nhập và là người dùng, chuyển hướng đến trang chính
        if (session()->has('logged_in') && session()->has('customer_id')) {
            return redirect()->to('/');
        }
        // Kiểm tra nếu có dữ liệu được gửi từ form đăng nhập
        if ($this->request->getMethod() === 'post') {
            // Lấy email và mật khẩu từ form đăng nhập
            $email = $this->request->getPost('customer_email');
            $password = $this->request->getPost('customer_password');
            // Kiểm tra xác thực đăng nhập
            $customerModel = new CustomerModel();
            $customer = $customerModel->where('customer_email', $email)->first();
            if ($customer && password_verify($password, $customer['customer_password'])) {
                // Đăng nhập thành công, lưu thông tin người dùng vào session và chuyển hướng đến trang chính
                session()->set('logged_in', true);
                session()->set('customer_id', $customer['customer_id']);
                session()->set('customer_name', $customer['customer_name']);
                session()->set('customer_email', $customer['customer_email']);
                session()->set('created_at', $customer['created_at']);
                return redirect()->to('/');
            } else {
                // Đăng nhập không thành công, lưu thông báo lỗi vào session và chuyển hướng lại đến trang đăng nhập
                session()->setFlashdata('error', 'Email hoặc mật khẩu không chính xác.');
                return redirect()->back()->withInput();
            }
        }
        return view('login');
    }


    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('customer_email');
            $password = $this->request->getPost('customer_password');
            $nameCustomer = $this->request->getPost('customer_name');
            $confirmPassword = $this->request->getPost('confirm_password');
            $email = strtolower($email);
            $rules = [
                'customer_email' => 'required|valid_email',
                'customer_password' => 'required|min_length[8]',
                'confirm_password' => 'matches[customer_password]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('register', $data);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $customerModel = new CustomerModel();
                $data = [
                    'customer_email' => $email,
                    'customer_password' => $hashedPassword,
                    'customer_name' => $nameCustomer,
                ];
                $customerModel->insert($data);
                return redirect()->to('views/login');
            }
        }
        return view('register');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }


    public function contact()
    {
        return view('contact');
    }

    public function reviews()
    {
        return view('reviews');
    }

    public function intro(){
        return view('intro');
    }

    public function blog()
    {
        $blogModel = new BlogModel();

        // Lấy dữ liệu từ model và sắp xếp theo ngày tạo mới nhất
        $data['blogsObj'] = $blogModel->orderBy('created_at', 'ASEC')->findAll();
        
        // Tải view và truyền dữ liệu
        return view('blog', $data);
    }
    public function viewBlog($id)
    {
        $model = new BlogModel();
        $data['blog'] = $model->find($id); // Tìm bài viết theo ID
        return view('viewblog', $data); // Gọi view 'viewblog' để hiển thị nội dung chi tiết
    }

    
    public function product($category = null){
        $productModel = new ProductModel();
        $data = [];
        if($category){
            // Nếu có danh mục được chọn, lọc sản phẩm theo danh mục
            $data['products'] = $productModel->where('category', $category)->paginate(12);
        } else {
            // Nếu không có danh mục được chọn, hiển thị tất cả sản phẩm
            $data['products'] = $productModel->paginate(12);
        }
        // Khởi tạo đối tượng Pager và truyền vào view
        $pager = $productModel->pager;
        $data['pager'] = $pager;
        // Danh sách các danh mục cố định
        $data['categories'] = [
            'MÀN HÌNH',
            'THÙNG MÁY',
            'CHIP',
            'RAM',
            'SSD',
            'HDD',
            'CARD ĐỒ HỌA',
            'CHUỘT',
            'BÀN PHÍM',
            'BÀN, GHẾ GAMING',
            'QUẠT TẢN NHIỆT',
            'TAI NGHE',
            'LAPTOP',
            'BALO MÁY TÍNH',
            'IPAD',
            'TABLET',
            'LOA'
        ];
        return view('product', $data);
    }

    public function product_detail()
    {
        return view('product_detail');
    }

    public function profile()
    {
        $customerModel = new CustomerModel();
        $customer_id = session()->get('customer_id');
        $customer = $customerModel->find($customer_id);
        if (!$customer) {
            return redirect()->route('error')->with('error', 'Không tìm thấy!');
        }
        return view('profile', ['customer' => $customer]);
    }


    public function checkout()
    {
        return view('checkout');
    }
}
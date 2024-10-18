<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\BlogModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;

class HomeControllers extends BaseController
{
    protected $cartModel;
    protected $productModel;
    protected $blogModel;
    protected $customerModel;
    protected $orderModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->blogModel = new BlogModel();
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
    }

    private function getTotalCartQuantity()
    {
        $session = session();
        $customerId = $session->get('customer_id');
        $totalQuantity = 0;

        if ($customerId) {
            $dataCartUser = $this->cartModel->where(['deleted_at' => null, 'customer_id' => $customerId])->findAll();
            if ($dataCartUser) {
                foreach ($dataCartUser as $item) {
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        return $totalQuantity;
    }

    public function index()
    {
        $data['cateObj'] = $this->productModel->findAll();
        $data['recommendedProducts'] = $this->productModel->findAll();
        $data['totalQuantity'] = $this->getTotalCartQuantity();

        return view('index', $data);
    }

    public function login()
    {
        if (session()->has('logged_in') && session()->has('customer_id')) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('customer_email');
            $password = $this->request->getPost('customer_password');
            $customer = $this->customerModel->where('customer_email', $email)->first();

            if ($customer && password_verify($password, $customer['customer_password'])) {
                session()->set([
                    'logged_in' => true,
                    'customer_id' => $customer['customer_id'],
                    'customer_name' => $customer['customer_name'],
                    'customer_email' => $customer['customer_email'],
                    'created_at' => $customer['created_at'],
                ]);
                return redirect()->to('/');
            } else {
                session()->setFlashdata('error', 'Email hoặc mật khẩu không chính xác.');
                return redirect()->back()->withInput();
            }
        }

        return view('login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $email = strtolower($this->request->getPost('customer_email'));
            $password = $this->request->getPost('customer_password');
            $nameCustomer = $this->request->getPost('customer_name');
            $confirmPassword = $this->request->getPost('confirm_password');

            $rules = [
                'customer_email' => 'required|valid_email',
                'customer_password' => 'required|min_length[8]',
                'confirm_password' => 'matches[customer_password]',
            ];

            if (!$this->validate($rules)) {
                return view('register', ['validation' => $this->validator]);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $data = [
                    'customer_email' => $email,
                    'customer_password' => $hashedPassword,
                    'customer_name' => $nameCustomer,
                ];
                if ($this->customerModel->insert($data)) {
                    session()->setFlashdata('msg_success', 'Đăng ký thành công.');
                    return redirect()->to('login');
                } else {
                    session()->setFlashdata('msg_error', 'Đăng ký không thành công.');
                    return redirect()->to('register');
                }
            }
        }

        return view('register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function blog()
    {
        $data['blogsObj'] = $this->blogModel->orderBy('created_at', 'ASC')->findAll();
        $data['totalQuantity'] = $this->getTotalCartQuantity();

        return view('blog', $data);
    }

    public function viewBlog($id)
    {
        $data['blog'] = $this->blogModel->find($id);
        $data['totalQuantity'] = $this->getTotalCartQuantity();

        return view('viewblog', $data);
    }

    public function product($category = null)
    {
        $data['products'] = $category ? 
            $this->productModel->where('category', $category)->paginate(12) : 
            $this->productModel->paginate(12);

        $data['pager'] = $this->productModel->pager;
        $data['categories'] = [
            'MÀN HÌNH', 'THÙNG MÁY', 'CHIP', 'RAM', 'SSD', 'HDD',
            'CARD ĐỒ HỌA', 'CHUỘT', 'BÀN PHÍM', 'BÀN, GHẾ GAMING',
            'QUẠT TẢN NHIỆT', 'TAI NGHE', 'LAPTOP', 'BALO MÁY TÍNH',
            'IPAD', 'TABLET', 'LOA',
        ];
        
        $data['totalQuantity'] = $this->getTotalCartQuantity();

        return view('product', $data);
    }

    public function product_detail()
    {
        $data['totalQuantity'] = $this->getTotalCartQuantity();
        return view('product_detail', $data);
    }

    public function profile()
    {
        $customer_id = session()->get('customer_id');
        $customer = $this->customerModel->find($customer_id);

        if (!$customer) {
            return redirect()->route('error')->with('error', 'Không tìm thấy!');
        }

        $orders = $this->orderModel->where('customer_id', $customer_id)->findAll();

        return view('profile', [
            'customer' => $customer,
            'orders' => $orders,
        ]);
    }

    public function checkout()
    {
        $data['totalQuantity'] = $this->getTotalCartQuantity(); 
        return view('checkout', $data);
    }

    public function intro()
    {
        $data['totalQuantity'] = $this->getTotalCartQuantity(); 
        return view('intro', $data);
    }

    public function contact()
    {
        $data['totalQuantity'] = $this->getTotalCartQuantity(); 
        return view('contact', $data);
    }
    
}

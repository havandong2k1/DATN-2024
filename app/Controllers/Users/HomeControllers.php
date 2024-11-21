<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\BlogModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\UserModel;

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

            // Quy tắc và thông báo lỗi bằng tiếng Việt
            $rules = [
                'customer_email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Vui lòng nhập {field}.',
                        'valid_email' => '{field} phải là một địa chỉ email hợp lệ.',
                    ],
                ],
                'customer_password' => [
                    'label' => 'Mật khẩu',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => 'Vui lòng nhập {field}.',
                        'min_length' => '{field} phải có ít nhất {param} ký tự.',
                    ],
                ],
                'confirm_password' => [
                    'label' => 'Xác nhận mật khẩu',
                    'rules' => 'matches[customer_password]',
                    'errors' => [
                        'matches' => '{field} không khớp với mật khẩu.',
                    ],
                ],
            ];

            // Xác thực dữ liệu
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
                    return redirect()->to('views/register');
                } else {
                    session()->setFlashdata('msg_error', 'Đăng ký không thành công.');
                    return redirect()->to('views/register');
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
    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $customer = $this->customerModel->where('customer_email', $email)->first();

            if (!$customer) {
                session()->setFlashdata('msg_error', 'Email không tồn tại trong hệ thống.');
                return redirect()->to('forgot-password');
            }

            // Tạo token khôi phục
            $token = bin2hex(random_bytes(32));
            $this->customerModel->update($customer['customer_id'], [
                'reset_token' => $token,
                'reset_token_expiry' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ]);

            // Gửi email
            $this->sendResetPasswordEmail($email, $token);

            session()->setFlashdata('msg_success', 'Link khôi phục mật khẩu đã được gửi tới email của bạn.');
            return redirect()->to('forgot-password');
        }

        return view('forgot_password');
    }

    public function resetPassword($token)
    {
        $customer = $this->customerModel->where('reset_token', $token)->first();

        if (!$customer || strtotime($customer['reset_token_expiry']) < time()) {
            session()->setFlashdata('msg_error', 'Token không hợp lệ hoặc đã hết hạn.');
            return redirect()->to('forgot-password');
        }

        return view('reset_password', ['token' => $token]);
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('password');

        $customer = $this->customerModel->where('reset_token', $token)->first();

        if (!$customer || strtotime($customer['reset_token_expiry']) < time()) {
            session()->setFlashdata('msg_error', 'Token không hợp lệ hoặc đã hết hạn.');
            return redirect()->to('forgot-password');
        }

        // Cập nhật mật khẩu
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->customerModel->update($customer['customer_id'], [
            'customer_password' => $hashedPassword,
            'reset_token' => null,
            'reset_token_expiry' => null,
        ]);

        session()->setFlashdata('msg_success', 'Mật khẩu của bạn đã được cập nhật.');
        return redirect()->to('/login');
    }

    // Hàm gửi email khôi phục mật khẩu
    private function sendResetPasswordEmail($email, $token)
    {
        $resetLink = base_url('password/reset/' . $token);
        $message = "Click vào liên kết sau để đặt lại mật khẩu của bạn: $resetLink";
    
        // Load the email service
        $emailService = \Config\Services::email();
    
        // Access the email configuration
        $emailConfig = new \Config\Email();
    
        // Set the email parameters
        $emailService->setTo($email);
        $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName);  // Corrected line
        $emailService->setSubject('Yêu cầu đặt lại mật khẩu');
        $emailService->setMessage($message);
    
        // Send the email and check for success
        if (!$emailService->send()) {
            session()->setFlashdata('msg_error', 'Gửi email không thành công!');
        }
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

    // public function product_detail($category = null)
    // {
    //     $data['totalQuantity'] = $this->getTotalCartQuantity();
    //     $data['products'] = $category ? 
    //     $this->productModel->where('category', $category)->paginate(12) : 
    //     $this->productModel->paginate(12);
    //     $data['pager'] = $this->productModel->pager;
    //     $data['categories'] = [
    //     'MÀN HÌNH', 'THÙNG MÁY', 'CHIP', 'RAM', 'SSD', 'HDD',
    //     'CARD ĐỒ HỌA', 'CHUỘT', 'BÀN PHÍM', 'BÀN, GHẾ GAMING',
    //     'QUẠT TẢN NHIỆT', 'TAI NGHE', 'LAPTOP', 'BALO MÁY TÍNH',
    //     'IPAD', 'TABLET', 'LOA',
    // ];
    
    // $data['totalQuantity'] = $this->getTotalCartQuantity();
    //     return view('product_detail', $data);
    // }

    public function profile()
    {
        $customer_id = session()->get('customer_id');
        $customer = $this->customerModel->find($customer_id);
    
        // Kiểm tra nếu không tìm thấy khách hàng
        if (!$customer) {
            return redirect()->route('error')->with('error', 'Không tìm thấy!');
        }

        $orders = $this->orderModel->where('customer_id', $customer_id)->findAll();
        $totalQuantity = $this->getTotalCartQuantity();  // Lấy tổng số lượng giỏ hàng
    
        // Truyền dữ liệu vào view
        return view('profile', [
            'customer' => $customer,
            'orders' => $orders,
            'totalQuantity' => $totalQuantity,  
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

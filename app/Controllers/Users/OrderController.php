<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    public function index()
    {
        $cartModel = new CartModel();
        
        // Check if customer is logged in
        $customerId = session()->get('customer_id');
        
        if ($customerId) {
            // Get cart from database for logged-in users
            $data['cartItems'] = $cartModel->getCartWithProducts($customerId);
        } else {
            // Get cart from session for guest users
            $data['cartItems'] = session()->get('cart') ?? [];
        }

        // Calculate total
        $data['totalAmount'] = $this->calculateTotal($data['cartItems']);

        return view('order', $data);
    }

    public function placeOrder()
    {
        $customerId = session()->get('customer_id');
        if (!$customerId) {
            $customerId = null;
        }
        $customerName = $this->request->getPost('customer_name');
        $customerEmail = $this->request->getPost('customer_email');
        $customerPhone = $this->request->getPost('customer_phone');
        $customerAddress = $this->request->getPost('customer_address');

        // Get cart items
        $cartModel = new CartModel();
        
        if ($customerId) {
            // For logged-in users, get cart from database
            $cartItems = $cartModel->getCartWithProducts($customerId);
        } else {
            // For guest users, get cart from session
            $cartItems = session()->get('cart') ?? [];
        }

        // Calculate total amount
        $totalAmount = $this->calculateTotal($cartItems);

        // Check if cart is empty
        if (empty($cartItems)) {
            session()->setFlashdata('msg_error', 'Giỏ hàng trống, không thể đặt hàng.');
            return redirect()->to('/order');
        }

        // Create new order
        $orderModel = new OrderModel();
        $orderData = [
            'customer_id' => $customerId,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'total_amount' => $totalAmount,
            'customer_address' => $customerAddress,
            'payment_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($orderModel->createOrder($orderData)) {
            session()->setFlashdata('msg_success', 'Đặt hàng thành công.');
            // Clear the cart
            $this->clearCart($customerId);
            return redirect()->to('/success');
        } else {
            session()->setFlashdata('msg_error', 'Đặt hàng không thành công, vui lòng thử lại.');
            return redirect()->to('/order');
        }        
    }

    public function clearCart($customerId)
    {
        $cartModel = new CartModel();

        if ($customerId) {
            // For logged-in users, clear cart in database
            $cartModel->where('customer_id', $customerId)->delete();
        } else {
            // For guest users, clear session cart
            session()->remove('cart');
        }
    }

    public function calculateTotal($cartItems)
    {
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        return $totalAmount;
    }

    public function orderSuccess()
    {
        return view('success');
    }

    public function orderStatus()
    {
        // Lấy thông tin từ form tìm kiếm
        $orderCode = $this->request->getPost('order_code');
        $customerEmail = $this->request->getPost('customer_email');
        $customerPhone = $this->request->getPost('customer_phone');

        $orderModel = new OrderModel();

        // Kiểm tra thông tin nhập vào
        if (!empty($orderCode) && !empty($customerEmail) && !empty($customerPhone)) {
            // Điều kiện tìm kiếm đơn hàng
            $condition = [
                'orders.order_code' => $orderCode,
                'orders.customer_email' => $customerEmail,
                'orders.customer_phone' => $customerPhone,
                'orders.deleted_at' => null,
            ];
            // Lấy thông tin đơn hàng từ database
            $orderObj = $orderModel->getFirstByConditions($condition);
            // Nếu tìm thấy đơn hàng
            if ($orderObj) {
                $data['order'] = $orderObj;
                return view('order_status', $data);  // View hiển thị đơn hàng
            } else {
                // Nếu không tìm thấy đơn hàng, hiển thị thông báo lỗi
                session()->setFlashdata('msg_error', 'Không tìm thấy đơn hàng với thông tin đã nhập.');
                return redirect()->to('/order/status');  // Trở lại trang tìm kiếm
            }
        } else {
            // Nếu người dùng không nhập đầy đủ thông tin
            session()->setFlashdata('msg_error', 'Vui lòng nhập đầy đủ thông tin tìm kiếm.');
            return redirect()->to('/order/status');
        }
    }

    // Hàm hiển thị thông tin đơn hàng (dành cho khách vãng lai và đã đăng nhập)
    public function orderStatusView($orderId)
    {
        $orderModel = new OrderModel();
        $cartModel = new CartModel();
        $productModel = new ProductModel();
    
        // Lấy thông tin đơn hàng theo order_id
        $order = $orderModel->find($orderId);
        if (!$order) {
            session()->setFlashdata('msg_error', 'Không tìm thấy đơn hàng.');
            return redirect()->to('/');
        }
        // Lấy thông tin sản phẩm trong giỏ hàng dựa trên customer_id
        $cartItems = $cartModel->where('customer_id', $order['customer_id'])->findAll();
        // Truy vấn sản phẩm từ bảng products dựa trên id_product từ giỏ hàng
        $products = [];
        foreach ($cartItems as $item) {
            $product = $productModel->find($item['id_product']);
            if ($product) {
                $product['quantity'] = $item['quantity'];  // Thêm số lượng từ giỏ hàng
                $product['status'] = $order['payment_status'];  // Thêm trạng thái thanh toán từ đơn hàng
                $products[] = $product;
            }
        }
   
        $data['order'] = $order;
        $data['products'] = $products;
    
        return view('order_status', $data);
    }
    
    
}

<?php
namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\DistrictsModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ProvincesModel;
use App\Models\WardsModel;

class OrderController extends BaseController
{
    public function index()
    {
        $cartModel = new CartModel();
        $provinceModel = new ProvincesModel(); 
        $districtModel = new DistrictsModel();
        $wardsModel = new WardsModel();
        $customerId = session()->get('customer_id');
        if ($customerId) {
            $data['cartItems'] = $cartModel->getCartWithProducts($customerId);
        } else {   
            $data['cartItems'] = session()->get('cart') ?? [];
        }
        $data['totalAmount'] = $this->calculateTotal($data['cartItems']);
        $data['provinces'] = $provinceModel->findAllProvinces();
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
        $provinceId = $this->request->getPost('province'); // Nhận ID tỉnh
        $districtId = $this->request->getPost('district'); // Nhận ID quận
        $wardId = $this->request->getPost('ward'); // Nhận ID phường
        $customerNote = $this->request->getPost('note');

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
            'province_id' => $provinceId,
            'district_id' => $districtId, 
            'ward_id' => $wardId, 
            'note' => $customerNote,
            'payment_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($orderId = $orderModel->createOrder($orderData)) {
            // Lưu thông tin sản phẩm vào order_items
            $orderItemsModel = new OrderItemsModel();
            foreach ($cartItems as $item) {
                $orderItemData = [
                    'id_order' => $orderId, // ID của đơn hàng vừa tạo
                    'id_product' => $item['id_product'], // ID sản phẩm
                    'quantity' => $item['quantity'], // Số lượng sản phẩm
                    'price' => $item['price'], // Giá sản phẩm
                ];
                $orderItemsModel->insert($orderItemData);
            }

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
        $orderCode = $this->request->getPost('order_code');
        $customerEmail = $this->request->getPost('customer_email');
        $customerPhone = $this->request->getPost('customer_phone');

        $orderModel = new OrderModel();

        // Kiểm tra thông tin nhập vào
        if (!empty($orderCode) && !empty($customerEmail) && !empty($customerPhone)) {
            // Điều kiện tìm kiếm đơn hàng
            $condition = [
                'order_code' => $orderCode,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'deleted_at' => null,
            ];
            
            // Lấy thông tin đơn hàng từ database
            $order = $orderModel->where($condition)->first();
            
            // Nếu tìm thấy đơn hàng
            if ($order) {
                // Gọi phương thức để lấy thông tin sản phẩm
                return $this->orderStatusView($order['id_order']);
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


    // Hàm hiển thị thông tin đơn hàng 
    public function orderStatusView($orderId)
    {
        $orderModel = new OrderModel();
        $orderItemsModel = new OrderItemsModel(); 
        $productModel = new ProductModel();

        // Lấy thông tin đơn hàng theo order_id
        $order = $orderModel->find($orderId);
        if (!$order) {
            session()->setFlashdata('msg_error', 'Không tìm thấy đơn hàng.');
            return redirect()->to('/');
        }

        // Lấy thông tin sản phẩm trong đơn hàng dựa trên order_id
        $orderItems = $orderItemsModel->where('id_order', $orderId)->findAll(); // Sửa lại để lấy thông tin sản phẩm
        $products = [];
        
        foreach ($orderItems as $item) {
            $product = $productModel->find($item['id_product']); // Lấy sản phẩm dựa trên id_product
            if ($product) {
                $product['quantity'] = $item['quantity']; // Số lượng sản phẩm trong đơn hàng
                $product['status'] = $order['payment_status']; // Trạng thái thanh toán
                $product['image'] = !empty($product['images']) ? base_url('uploads/' . esc($product['images'])) : base_url('uploads/default_image.jpg');
                $products[] = $product;
            }
        }

        // Pass data to view
        $data['order'] = $order;
        $data['products'] = $products;

        return view('order_status', $data);
    }
   
    public function getDistricts()
    {
        $provinceId = $this->request->getPost('province_id');
        if (!$provinceId) {
            return $this->response->setJSON(['error' => 'Province ID missing']);
        }
        $districtsModel = new DistrictsModel();
        $districts = $districtsModel->getDistrictsByProvince($provinceId);
        return $this->response->setJSON($districts);
    }
    
    public function getWards()
    {
        if ($this->request->isAJAX()) {
            $districtId = $this->request->getPost('district_id');
    
            if (!$districtId) {
                return $this->response->setJSON(['error' => 'District ID missing']);
            }
            $wardsModel = new WardsModel();
            $wards = $wardsModel->getWardsByDistrict($districtId);
            return $this->response->setJSON($wards);
        } else {
            return $this->response->setStatusCode(403, 'Forbidden');
        }
    }

}

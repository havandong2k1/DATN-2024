<?php

namespace App\Controllers\Users;

use App\Models\CartModel;
use CodeIgniter\Controller;

class CartControllers extends Controller
{
    public function index()
    {
        $session = session();

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$session->get('logged_in')) {
            return redirect()->to('login');
        }

        $customerId = $session->get('customer_id'); // Giả sử ID khách hàng được lưu trong session

        // Lấy dữ liệu giỏ hàng cùng với thông tin sản phẩm
        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartWithProducts($customerId);

        $data['cartItems'] = $cartItems;

        // Trả dữ liệu về view
        return view('cart', $data);
    }

    public function addCart($productId)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('login');
        }

        // Tạo đối tượng model giỏ hàng
        $cartModel = new CartModel();
        // Lấy thông tin sản phẩm từ database
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($productId);

        // Kiểm tra xem sản phẩm có tồn tại hay không
        if (!$product) {
            return redirect()->back()->with('msg_error', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cart = $cartModel->where('id_product', $productId)
                          ->where('customer_id', $session->get('customer_id'))
                          ->first();

        if ($cart) {
            // Nếu đã có, cập nhật số lượng
            $cartModel->update($cart['id'], [
                'quantity' => $cart['quantity'] + 1
            ]);
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $cartModel->insert([
                'customer_id' => $session->get('customer_id'),
                'id_product' => $productId,
                'quantity' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        $session->setFlashdata('msg_success', 'Sản phẩm đã được thêm vào giỏ hàng.');
         return redirect()->to('views/product/0'); // Chuyển hướng về trang giỏ hàng
    }
}

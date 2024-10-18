<?php

namespace App\Controllers\Users;

use App\Models\CartModel;
use CodeIgniter\Controller;

class CartControllers extends Controller
{
    public function index()
    {
        $session = session();
    
        // Kiểm tra nếu người dùng đã đăng nhập
        if ($session->get('logged_in')) {
            $customerId = $session->get('customer_id'); 
            // Nếu đã đăng nhập, lấy dữ liệu giỏ hàng từ cơ sở dữ liệu
            $cartModel = new CartModel();
            $cartItems = $cartModel->getCartWithProducts($customerId);
    
            $data['cartItems'] = $cartItems;
        } else {
            // Nếu chưa đăng nhập, lấy giỏ hàng từ session
            $cartItems = $session->get('cart') ?? [];
            $data['cartItems'] = $cartItems;
        }
        // Trả dữ liệu về view giỏ hàng
        return view('cart', $data);
    }
    

    public function addCart($productId)
    {
        // Khởi tạo session
        $session = session();       
        // Tạo đối tượng model giỏ hàng
        $cartModel = new CartModel();
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($productId);

        // Kiểm tra sản phẩm có tồn tại không
        if (!$product) {
            return redirect()->back()->with('msg_error', 'Sản phẩm không tồn tại.');
        }
        // Kiểm tra người dùng đã đăng nhập chưa
        if ($session->get('logged_in')) {
            // Người dùng đã đăng nhập: xử lý giỏ hàng với cơ sở dữ liệu
            $customerId = $session->get('customer_id');
            // Kiểm tra sản phẩm có trong giỏ hàng của khách hàng hay không
            $condition =[
                'deleted_at' => null,
                'id_product' => $productId,
                'customer_id' => $customerId,
            ];
            $cart = $cartModel->getFirstByConditions($condition);
            if ($cart) {
                // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
                $cartModel->update($cart['id'], [
                    'quantity' => $cart['quantity'] + 1
                ]);
            } else {
                // Nếu chưa có, thêm sản phẩm vào giỏ hàng
                $cartModel->insert([
                    'customer_id' => $customerId,
                    'id_product' => $productId,
                    'quantity' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            $session->setFlashdata('msg_success', 'Sản phẩm đã được thêm vào giỏ hàng.');
            return redirect()->to('views/product/0'); 
            // Else Xử lý người dùng chưa đăng nhập
        } else {
            // Người dùng chưa đăng nhập: xử lý giỏ hàng trong session
            $cart = $session->get('cart') ?? [];
            // Kiểm tra sản phẩm có trong giỏ hàng session chưa
            $productExists = false;
            foreach ($cart as &$item) {
                if ($item['id_product'] == $productId) {
                    $item['quantity'] += 1;
                    $productExists = true;
                    break;
                }
            }
            if (!$productExists) {
                $cart[] = [
                    'id_product' => $productId,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1,
                    'images' => $product['images']
                ];
            }
            $session->set('cart', $cart);
            $session->setFlashdata('msg_success', 'Sản phẩm đã được thêm vào giỏ hàng.');
            return redirect()->to('views/product/0');
        }
    }
}

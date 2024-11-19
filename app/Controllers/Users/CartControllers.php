<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\CartModel;
use CodeIgniter\Controller;

class CartControllers extends BaseController
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
    

    public function addCart()
    {
        // Khởi tạo session
        $session = session();       
        // Tạo đối tượng model giỏ hàng
        $cartModel = new CartModel();
        $productModel = new \App\Models\ProductModel();
        
        // Lấy product_id và quantity từ request
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        // Tìm sản phẩm
        $product = $productModel->find($productId);

        // Kiểm tra sản phẩm có tồn tại không
        if (!$product) {
            return redirect()->back()->with('msg_error', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra người dùng đã đăng nhập chưa
        if ($session->get('logged_in')) {
            // Xử lý giỏ hàng với cơ sở dữ liệu
            $customerId = $session->get('customer_id');
            $condition = [
                'deleted_at' => null,
                'id_product' => $productId,
                'customer_id' => $customerId,
            ];
            $cart = $cartModel->getFirstByConditions($condition);
            if ($cart) {
                // Tăng số lượng nếu sản phẩm đã có trong giỏ hàng
                $cartModel->update($cart['id'], [
                    'quantity' => $cart['quantity'] + $quantity
                ]);
            } else {
                // Thêm sản phẩm vào giỏ hàng
                $cartModel->insert([
                    'customer_id' => $customerId,
                    'id_product' => $productId,
                    'quantity' => $quantity,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            $session->setFlashdata('msg_success', 'Sản phẩm đã được thêm vào giỏ hàng.');
            return redirect()->to('views/product/0'); 
        } else {
            // Người dùng chưa đăng nhập: xử lý giỏ hàng trong session
            $cart = $session->get('cart') ?? [];
            $productExists = false;
            foreach ($cart as &$item) {
                if ($item['id_product'] == $productId) {
                    $item['quantity'] += $quantity;
                    $productExists = true;
                    break;
                }
            }
            if (!$productExists) {
                $cart[] = [
                    'id_product' => $productId,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'images' => $product['images']
                ];
            }
            $session->set('cart', $cart);
            $session->setFlashdata('msg_success', 'Sản phẩm đã được thêm vào giỏ hàng.');
            return redirect()->to('views/product/0');
        }
    }
    public function removeFromCart($productId)
    {
        $session = session();
        $cartModel = new CartModel();

        // Check if the user is logged in
        if ($session->get('logged_in')) {
            // Remove item from database cart if the user is logged in
            $customerId = $session->get('customer_id');
            
            // Use the product ID and customer ID to identify the correct item
            $cartModel->where('customer_id', $customerId)
                    ->where('id_product', $productId)
                    ->where('deleted_at', null)
                    ->delete();
                    
            $session->setFlashdata('msg_success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        } else {
            // Remove item from session cart if the user is not logged in
            $cart = $session->get('cart') ?? [];
            
            // Filter out the product that needs to be removed
            $cart = array_filter($cart, function($item) use ($productId) {
                return $item['id_product'] != $productId;
            });

            $session->set('cart', $cart);
            $session->setFlashdata('msg_success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        }

        return redirect()->to('views/cart');  
    }
    public function increaseQuantity($productId)
    {
        $session = session();
        $cartModel = new CartModel();

        if ($session->get('logged_in')) {
            // If logged in, update quantity in the database
            $customerId = $session->get('customer_id');
            $cart = $cartModel->where('customer_id', $customerId)
                            ->where('id_product', $productId)
                            ->where('deleted_at', null)
                            ->first();

            if ($cart) {
                $cartModel->update($cart['id'], ['quantity' => $cart['quantity'] + 1]);
            }
        } else {
            // If not logged in, update quantity in the session
            $cart = $session->get('cart') ?? [];
            foreach ($cart as &$item) {
                if ($item['id_product'] == $productId) {
                    $item['quantity'] += 1;
                    break;
                }
            }
            $session->set('cart', $cart);
        }

        return redirect()->to('views/cart');
    }

    public function decreaseQuantity($productId)
    {
        $session = session();
        $cartModel = new CartModel();

        if ($session->get('logged_in')) {
            // If logged in, update quantity in the database
            $customerId = $session->get('customer_id');
            $cart = $cartModel->where('customer_id', $customerId)
                            ->where('id_product', $productId)
                            ->where('deleted_at', null)
                            ->first();

            if ($cart && $cart['quantity'] > 1) {
                $cartModel->update($cart['id'], ['quantity' => $cart['quantity'] - 1]);
            } else {
                // Remove item if quantity is 1
                $cartModel->delete($cart['id']);
            }
        } else {
            // If not logged in, update quantity in the session
            $cart = $session->get('cart') ?? [];
            foreach ($cart as &$item) {
                if ($item['id_product'] == $productId) {
                    if ($item['quantity'] > 1) {
                        $item['quantity'] -= 1;
                    } else {
                        // Remove item if quantity is 1
                        $cart = array_filter($cart, function ($i) use ($productId) {
                            return $i['id_product'] != $productId;
                        });
                    }
                    break;
                }
            }
            $session->set('cart', $cart);
        }

        return redirect()->to('views/cart');
    }
}

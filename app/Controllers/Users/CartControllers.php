<?php

namespace App\Controllers\Users;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Controllers\BaseController;

class CartControllers extends BaseController
{
    // Trong CartControllers.php hoặc controller tương ứng
    public function addCart()
    {
        // Tạo mã CSRF và gửi nó cùng với yêu cầu POST
        $data['csrf'] = csrf_hash();
        // Lấy product_id từ yêu cầu POST
        $productId = $this->request->getPost('product_id');
        // Kiểm tra xem product_id có tồn tại không
        if (!$productId) {
            // Trả về mã CSRF qua JSON nếu product_id không tồn tại
            return $this->response->setJSON($data);
        }
        // Tạo đối tượng CartModel
        $cartModel = new CartModel();
        // Tìm sản phẩm trong cơ sở dữ liệu bằng cách sử dụng find()
        $product = $cartModel->find($productId);
        // Nếu không tìm thấy sản phẩm, trả về phản hồi lỗi
        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
        }
        // Trả về mã CSRF trong phản hồi JSON
        return $this->response->setJSON($data);
    }

}
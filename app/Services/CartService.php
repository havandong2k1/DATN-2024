<?php


namespace App\Services;
use App\Models\CartModel;
use Exception;

class CartService extends BaseService
{
    private $cart;
    /**
    Tạo hàm constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->cart = new CartModel();
        $this->cart->protect(false);
    }

    public function addToCart($productId, $images, $name ,$description, $price , $quantity)
    {
        // Thêm sản phẩm vào giỏ hàng
        $data = array([
            'id'      => $productId,
            'images'      => $images,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity'     => $quantity,
            // Thêm các thông tin khác của sản phẩm nếu cần
        ]);

        $this->cart->insert($data);
    }

}
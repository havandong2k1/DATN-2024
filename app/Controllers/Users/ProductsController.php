<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ReviewModel;

class ProductsController extends BaseController
{
    protected $categories;

    public function __construct()
    {
        // Khởi tạo danh sách các danh mục sản phẩm
        $this->categories = [
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
            'LOA',
        ];
    }

    public function index($category)
    {
        $data = [];
        $productModel = new ProductModel();
        $products = $productModel->where('category', $category)->findAll();
        if (empty($products)) {
            // Trả về thông báo lỗi
            return view('category', [
                'categories' => $this->categories,
                'products' => [], // không có sản phẩm nào
            ]);
        }
        $data['categories'] = $this->categories;
        $data['products'] = $products;
        return view('category', $data);
    }

    public function product($category = null)
    {
        $productModel = new ProductModel();
        $data = [];

        if ($category) {
            $data['products'] = $productModel->where('category', $category)->paginate(12);
        } else {
            $data['products'] = $productModel->paginate(12);
        }
        $data['pager'] = $productModel->pager;
        $data['categories'] = $this->categories;

        return view('product', $data);
    }

    public function productDetail($productId, $category = null)
    {
        $productModel = new ProductModel();
        $reviewModel = new ReviewModel();
        $product = $productModel->find($productId);
        if (!$product) {
            return redirect()->to('/');
        }
        $reviews = $reviewModel->where('id_product', $productId)->findAll();
        $recommendedProducts = $productModel->where('category', $product['category'])
            ->where('id_product !=', $productId)
            ->findAll();
        $data['products'] = $category ? 
            $productModel->where('category', $category)->paginate(12) : 
            $productModel->paginate(12);
        $data['pager'] = $productModel->pager;
        $data['categories'] = [
            'MÀN HÌNH', 'THÙNG MÁY', 'CHIP', 'RAM', 'SSD', 'HDD',
            'CARD ĐỒ HỌA', 'CHUỘT', 'BÀN PHÍM', 'BÀN, GHẾ GAMING',
            'QUẠT TẢN NHIỆT', 'TAI NGHE', 'LAPTOP', 'BALO MÁY TÍNH',
            'IPAD', 'TABLET', 'LOA',
        ];
        $data['productObj'] = $product;
        $data['productId'] = $productId;
        $data['reviews'] = $reviews;
        $data['recommendedProducts'] = $recommendedProducts;
        return view('product_detail', $data);
    }



    public function addReview()
    {
        $model = new ReviewModel();
        $data = [
            'id_product' => $this->request->getPost('id_product'),
            'customer_id' => session()->get('customer_id'), 
            'customer_name' => session()->get('customer_name') ?? 'Người ẩn danh', 
            'rating' => $this->request->getPost('rating'),
            'review' => $this->request->getPost('review'),
        ];
        if (empty($data['id_product']) || empty($data['rating']) || empty($data['review'])) {
            return redirect()->back()->with('error', 'Vui lòng điền đầy đủ thông tin đánh giá.');
        }
        if ($model->insert($data) === false) {
            log_message('error', 'Insert error: ' . print_r($model->errors(), true));
            return redirect()->back()->with('error', 'Không thể lưu đánh giá.');
        }
        return redirect()->back()->with('message', 'Đánh giá đã được lưu thành công.');
    }

    public function products()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->getAllProducts();
        $data['categories'] = $this->categories;
        return view('products', $data);
    }

    public function category($category)
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->getProductsByCategory($category);
        $data['categories'] = $this->categories;
        return view('category', $data);
    }

    public function countProductsByCategory()
    {
        $productModel = new ProductModel();
        $categories = $productModel->groupBy('category')->findAll();
        $categoryCounts = [];
        foreach ($categories as $category) {
            $count = $productModel->where('category', $category['category'])->countAllResults();
            $categoryCounts[$category['category']] = $count;
        }
        return view('category', ['categoryCounts' => $categoryCounts, 'categories' => $this->categories]);
    }

    public function search()
    {
        $keyword = $this->request->getPost('keyword'); // Lấy từ khóa từ AJAX request
        $response = ['success' => false, 'html' => ''];

        if (!empty($keyword)) {
            $productModel = new ProductModel();
            $products = $productModel->searchProducts($keyword);

            if (!empty($products)) {
                $html = '';
                foreach ($products as $product) {
                    // Sử dụng đúng trường 'images' cho tên ảnh
                    $html .= '
                    <div class="product">
                        <a href="/product/product_detail/' . $product['id_product'] . '">
                            <h4>' . esc($product['name']) . '</h4>
                            <img src="' . base_url('public/uploads/products/' . $product['images']) . '" alt="' . esc($product['name']) . '" style="width:150px;height:150px;object-fit:cover;" />
                            <p>Giá: ' . number_format($product['price'], 0, ',', '.') . ' VND</p>
                        </a>
                    </div>';
                }
                $response['success'] = true;
                $response['html'] = $html;
            } else {
                $response['html'] = '<p>Không tìm thấy sản phẩm nào.</p>';
            }
        } else {
            $response['html'] = '<p>Vui lòng nhập từ khóa tìm kiếm.</p>';
        }

        return $this->response->setJSON($response);
    }
}

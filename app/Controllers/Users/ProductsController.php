<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
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

        // Truy vấn các sản phẩm thuộc danh mục được chọn
        $products = $productModel->where('category', $category)->findAll();

        // Kiểm tra nếu không có sản phẩm nào thuộc danh mục này
        if (empty($products)) {
            // Trả về thông báo lỗi
            return view('category', [
                'categories' => $this->categories,
                'products' => [], // không có sản phẩm nào
            ]);
        }

        // Truyền danh sách sản phẩm vào view để hiển thị
        $data['categories'] = $this->categories;
        $data['products'] = $products;

        // Truyền dữ liệu sang view
        return view('category', $data);
    }

    public function product($category = null)
    {
        $productModel = new ProductModel();
        $data = [];

        if ($category) {
            // Nếu có danh mục được chọn, lọc sản phẩm theo danh mục
            $data['products'] = $productModel->where('category', $category)->paginate(12);
        } else {
            // Nếu không có danh mục được chọn, hiển thị tất cả sản phẩm
            $data['products'] = $productModel->paginate(12);
        }

        // Khởi tạo đối tượng Pager và truyền vào view
        $data['pager'] = $productModel->pager;
        // Truyền danh sách danh mục
        $data['categories'] = $this->categories;

        return view('product', $data);
    }

    public function productDetail($productId)
    {
        $productModel = new ProductModel();
        $reviewModel = new ReviewModel();

        // Lấy thông tin sản phẩm
        $product = $productModel->find($productId);
        if (!$product) {
            return false; // Trả về false nếu không tìm thấy sản phẩm
        }

        $condition = [
            'deleted_at' => null,
            'id_product' => $productId
        ];
        $withSelect = 'name, description, price, images, amount, category';
        $productObj = $productModel->getFirstByConditions($condition, '', $withSelect);
        if (!$productObj) {
            return false; // Trả về false nếu không tìm thấy sản phẩm
        }

        // Lấy danh sách đánh giá cho sản phẩm
        $reviews = $reviewModel->where('id_product', $productId)->findAll();

        // Truyền thông tin sản phẩm và đánh giá vào view
        $data['productObj'] = $productObj;
        $data['productId'] = $productId;
        $data['reviews'] = $reviews;  // Truyền đánh giá vào view
        $data['categories'] = $this->categories; // Truyền danh mục vào view

        return view('product_detail', $data);
    }

    public function addReview()
    {
        $reviewModel = new ReviewModel();

        // Nhận dữ liệu từ form
        $data = [
            'id_product' => $this->request->getPost('id_product'),
            'customer_id' => $this->request->getPost('customer_id'),
            'rating' => $this->request->getPost('rating'),
            'review' => $this->request->getPost('review')
        ];

        // Lưu đánh giá vào database
        $reviewModel->save($data);

        // Chuyển hướng về trang chi tiết sản phẩm
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được thêm!');
    }

    public function products()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->getAllProducts();
        $data['categories'] = $this->categories; // Thêm danh mục vào view

        // Load view và truyền dữ liệu sản phẩm vào view
        return view('products', $data);
    }

    public function category($category)
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->getProductsByCategory($category);
        $data['categories'] = $this->categories; // Thêm danh mục vào view

        return view('category', $data);
    }

    public function countProductsByCategory()
    {
        $productModel = new ProductModel();

        // Fetch the counts of products for each category
        $categories = $productModel->groupBy('category')->findAll();

        // Loop through each category and get the count of products
        $categoryCounts = [];
        foreach ($categories as $category) {
            $count = $productModel->where('category', $category['category'])->countAllResults();
            $categoryCounts[$category['category']] = $count;
        }

        // Pass $categoryCounts array to the view
        return view('category', ['categoryCounts' => $categoryCounts, 'categories' => $this->categories]);
    }
}

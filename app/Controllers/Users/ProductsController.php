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
            return redirect()->to('/'); // Hoặc trang lỗi nếu không tìm thấy
        }

        // Lấy danh sách đánh giá cho sản phẩm
        $reviews = $reviewModel->where('id_product', $productId)->findAll();

        // Lấy sản phẩm đề xuất (ví dụ: sản phẩm cùng danh mục)
        $recommendedProducts = $productModel->where('category', $product['category'])
            ->where('id_product !=', $productId) // Tránh lấy sản phẩm hiện tại
            ->findAll();

        // Truyền thông tin sản phẩm và đánh giá vào view
        $data['productObj'] = $product; // Đảm bảo $product có cấu trúc chính xác
        $data['productId'] = $productId;
        $data['reviews'] = $reviews;  // Truyền đánh giá vào view
        $data['categories'] = $this->categories; // Truyền danh mục vào view
        $data['recommendedProducts'] = $recommendedProducts; // Truyền sản phẩm đề xuất vào view

        return view('product_detail', $data);
    }

    public function addReview()
    {
        $model = new ReviewModel();

        // Lấy dữ liệu từ request
        $data = [
            'id_product' => $this->request->getPost('id_product'),
            'customer_id' => session()->get('customer_id'), // Lấy customer_id từ session
            'customer_name' => session()->get('customer_name') ?? 'Người ẩn danh', // Nếu không có customer_name thì dùng 'Người ẩn danh'
            'rating' => $this->request->getPost('rating'),
            'review' => $this->request->getPost('review'),
        ];

        // Kiểm tra nếu tất cả các trường đều có dữ liệu
        if (empty($data['id_product']) || empty($data['rating']) || empty($data['review'])) {
            return redirect()->back()->with('error', 'Vui lòng điền đầy đủ thông tin đánh giá.');
        }

        // Thêm đánh giá vào database
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
    // ProductController.php

    public function search()
{
    // Lấy CSRF token từ POST data
    $csrfToken = $this->request->getPost('csrf_token');

    // Kiểm tra nếu CSRF token không hợp lệ
    if (!$csrfToken || $csrfToken !== csrf_hash()) {
        return $this->response->setJSON(['success' => false, 'message' => 'CSRF token is invalid']);
    }

    // Lấy giá trị từ input tìm kiếm
    $keyword = $this->request->getPost('keyword');

    if (empty($keyword)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Keyword is required']);
    }

    // Tiến hành tìm kiếm sản phẩm
    $productModel = new \App\Models\ProductModel();
    $products = $productModel->searchProducts($keyword);

    // Kiểm tra nếu có sản phẩm tìm thấy
    if (count($products) > 0) {
        // Nếu có sản phẩm tìm thấy, trả về dữ liệu
        $html = view('product/search_results', ['products' => $products]);
        return $this->response->setJSON(['success' => true, 'html' => $html]);
    } else {
        // Nếu không có sản phẩm nào tìm thấy
        return $this->response->setJSON(['success' => false, 'message' => 'No products found']);
    }
}

}

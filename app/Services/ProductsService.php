<?php

namespace App\Services;

use App\Common\ResultUtils;
use App\Models\ProductModel;
use Exception;

class ProductsService extends BaseService
{


    private $product;
    /**
        Tạo hàm constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->product = new ProductModel();
        $this->product->protect(false);

        //$this->users->protect(false);
    }

    public function getAllProduct()
    {
        return $this->product->findAll();
    }


    public function getProductByID($idProduct)
    {

        //return $this->product->where('id_product', $id_Product)->first();

        return $this->product->where('id_product', $idProduct)->first();

    }


    public function addProductsInfo($requestData)
    {

        // Thực hiện xác thực dữ liệu
        $validate = $this->validateAddProducts($requestData);
        if ($validate->getErrors()) {
            // Trả về thông báo lỗi nếu có lỗi xác thực
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getErrors() // Sử dụng $validate->getErrors() để lấy thông báo lỗi
            ];
        }

        // Lấy dữ liệu từ yêu cầu POST
        $dataSave = $requestData->getPost();
        $file = $requestData->getFile('images');

        // Kiểm tra xem file có hợp lệ và chưa được di chuyển hay không
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $dataSave['images'] = $newName;

            // Di chuyển file vào thư mục 'uploads'
            if (!$file->move('uploads', $newName)) {
                // Trả về thông báo lỗi nếu không thể di chuyển file
                return [
                    'status' => ResultUtils::STATUS_CODE_ERR,
                    'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                    'messages' => ['success' => 'Không thể di chuyển file']
                ];
            }
        } else {
            // Trả về thông báo lỗi nếu file không hợp lệ
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => 'File không hợp lệ hoặc đã được di chuyển']
            ];
        }

        try {
            // Thêm sản phẩm vào cơ sở dữ liệu
            $this->product->insert($dataSave);

            // Trả về thông báo thành công nếu không có lỗi
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'messageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Thêm sản phẩm thành công']
            ];
        } catch (Exception $e) {
            // Trả về thông báo lỗi nếu có lỗi khi thêm sản phẩm
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => $e->getMessage()]
            ];
        }
    }


    //public function addProductsInfo($requestData)
    //{
    //
    //    $validate = $this->validateAddProducts($requestData);
    //    if ($validate->getErrors()) {
    //        return [
    //            'status' => ResultUtils::STATUS_CODE_ERR,
    //            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
    //            'messages' => $validate->getError()
    //        ];
    //    }
    //    $dataSave = $requestData->getPost();
    //    $file = $requestData->getFile('images');
    //    if ($file->isValid() && !$file->hasMoved()) {
    //        $newName = $file->getRandomName();
    //        $dataSave['images'] = $newName;
    //        $file->move('uploads', $newName);
    //    }
    //    try {
    //        $this->product->insert($dataSave);
    //        return [
    //            'status' => ResultUtils::STATUS_CODE_OK,
    //            'messageCode' => ResultUtils::MESSAGE_CODE_OK,
    //            'messages' => ['success' => 'Thêm sản phẩm thành công']
    //        ];
    //    } catch (Exception $e) {
    //        return [
    //            'status' => ResultUtils::STATUS_CODE_ERR,
    //            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
    //            'messages' => ['success' => $e->getMessage()]
    //        ];
    //    }
    //}

    public function validateAddProducts($requestData)
    {
        $rule = [
            'images' => 'max_length[4]',
            'name' => 'max_length[100]',
            'price' => 'max_length[255]',
            'description' => 'max_length[255]',
            'category' => 'max_length[255]',
            'amount' => 'max_length[255]',

        ];
        $message = [
            'images' => [
                'max_length' => 'Ảnh quá lớn, vui lòng chọn ảnh khác.',
            ],

            'name' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự.',
            ],

            'price' => [
                'max_length' => 'Gía quá dài, vui lòng nhập {param} ký tự.',
            ],

            'description' => [
                'max_length' => 'Mô tả quá dài, vui lòng nhập {param} ký tự.',
            ],

            'category' => [
                'max_length' => 'Danh mục quá dài, vui lòng nhập {param} ký tự.',
            ],

            'amount' => [
                'max_length' => 'Số lượng quá dài, vui lòng nhập {param} ký tự.',
            ],
        ];
        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }


    public function deleteProduct($idProduct)
    {
        try {
            $this->product->delete($idProduct);
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Xóa thông tin thành công']
            ];
        } catch (Exception $e) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => $e->getMessage()]
            ];
        }
    }

    public function updateProductInfo($requestData)
    {

        $validate = $this->validateEditProduct($requestData);

        if ($validate->getErrors()) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getError()
            ];
        }
    }

    public function validateEditProduct($requestData)
    {
        $rule = [
            'id_product' => [
                'rules' => 'is_unique[products.id,id,' . $$this->request->getPost('id_product') . ']',
                'errors' => [
                    'is_unique' => 'ID must be unique'
                ]

            ],
            'name' => 'max_length[100]',
            'images' => 'max_length[100]',
            'description' => 'max_length[100]',
            'amount' => 'max_length[100]',
            'category' => 'max_length[100]',

        ];

        $message = [
            'name' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
            ],

            'images' => [
                'max_length' => 'Ảnh quá lớn, vui lòng sử dụng {param} size !',
            ],

            'description' => [
                'max_length' => 'Mô tả quá dài, vui lòng nhập {param} ký tự!',
            ],

            'amount' => [
                'max_length' => 'Số lượng quá nhiều vui lòng nhập {param} ký tự!',
            ],

            'category' => [
                'max_length' => 'Tên danh mục dài, vui lòng nhập {param} ký tự!',
            ],
        ];


        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }
}

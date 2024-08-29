<?php

namespace App\Services;
use App\Models\BlogModel;
use App\Models\BaseModel;
use App\Common\ResultUtils;
use Exception;

class BlogsService extends BaseService
{
    private $blogs;
    /**
        Tạo hàm constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->blogs = new BlogModel();
        $this->blogs->protect(false);

        //$this->users->protect(false);
    }

    public function getAllBlogs()
    {
        return $this->blogs->findAll();
    }

    public function getBlogsByID($blogs)
    {
        return $this->blogs->where('id_blogs', $blogs)->first();
    }

    public function addBlogsInfo($requestData)
    {

        // Thực hiện xác thực dữ liệu
        $validate = $this->validateAddBlogs($requestData);
        if ($validate->getErrors()) {
            // Trả về thông báo lỗi nếu có lỗi xác thực
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getErrors() // Sử dụng $validate->getErrors() để lấy thông báo lỗi
            ];
        }
        
        
    }

    public function validateAddBlogs($requestData)
    {
        $rule = [
            'id' => 'max_length[255]',
            'title' => 'max_length[255]',
            'content' => 'max_length[255]',
            'created_at' => 'max_length[255]',
            'updated_at' => 'max_length[255]',
            'deleted_at' => 'max_length[255]',
           

        ];
        $message = [
            'title' => [
                'max_length' => 'Tiêu đề quá dài, vui lòng nhập {param} ký tự.',
            ],

            'content' => [
                'max_length' => 'Nội dung quá dài, vui lòng nhập {param} ký tự.',
            ],

            'created_at' => [
                'max_length' => 'Ngày tạo sai, vui lòng nhập {param} ký tự.',
            ],

            'updated_at' => [
                'max_length' => 'Ngày cập nhật sai, vui lòng nhập {param} ký tự.',
            ],

            'deleted_at' => [
                'max_length' => 'Ngày xóa lỗi, vui lòng nhập {param} ký tự.',
            ],
        ];
        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }

    public function deleteById($id)
    {
        try {
            $this->blogs->delete($id);
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Xóa bài viết thành công']
            ];
        } catch (Exception $e) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['error' => $e->getMessage()]
            ];
        }
    }

    public function updateBlogsInfo($requestData)
    {

        $validate = $this->validateEditBlogs($requestData);

        if ($validate->getErrors()) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getError()
            ];
        }
    }

    public function validateEditBlogs($requestData)
    {
        $rule = [
            'id' => [
                'rules' => 'is_unique[products.id,id,' . $$this->request->getPost('id') . ']',
                'errors' => [
                    'is_unique' => 'ID must be unique'
                ]

            ],
            'title' => 'max_length[255]',
            'content' => 'max_length[255]',
            'created_at' => 'max_length[255]',
            'updated_at' => 'max_length[255]',
            'deleted_at' => 'max_length[255]',

        ];

        $message = [
            'title' => [
                'max_length' => 'Tiêu đề quá dài, vui lòng nhập {param} ký tự.',
            ],

            'content' => [
                'max_length' => 'Nội dung quá dài, vui lòng nhập {param} ký tự.',
            ],

            'created_at' => [
                'max_length' => 'Ngày tạo sai, vui lòng nhập {param} ký tự.',
            ],

            'updated_at' => [
                'max_length' => 'Ngày cập nhật sai, vui lòng nhập {param} ký tự.',
            ],

            'deleted_at' => [
                'max_length' => 'Ngày xóa lỗi, vui lòng nhập {param} ký tự.',
            ],
        ];

        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }

}
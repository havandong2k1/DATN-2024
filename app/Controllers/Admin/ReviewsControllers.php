<?php


namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Common\ResultUtils;
use App\Models\BaseModel;
use App\Models\ReviewModel;
use App\Services\CartService;
use Exception;

class ReviewsControllers extends BaseController
{

    /**
     * @var Service
     */
    //private $service;

    public function __construct()
    {
        //$this->service = new ReviewService();
    }

    public function list(): string
    {   
        $dataReview = $this->listReview();
   
        $data = [
            'dataReview' => $dataReview,
        ];
        $cssFiles = [
            'http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
            base_url() . '/assets/admin/js/event.js',
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css'
        ];

        $order = [];
        $dataLayout = [];
        if ($order) {
            $dataLayout['orders'] = $order;
        }
        $data = $this->loadMasterLayout($data, 'Danh sách đánh giá', 'admin/pages/reviews/list', $dataLayout, $cssFiles, $jsFiles);
        return view('admin/main', $data);
    }
    
    public function listReview()
    {
        $reviewModel = new ReviewModel();
        $conditions = [
            'reviews.deleted_at' => null,
        ];
        $withSelect = 'reviews.id, reviews.rating, reviews.review, reviews.created_at, products.id_product, products.images';
        $joinTable1 = 'products';
        $withJoinCondition1 = 'reviews.id_product = products.id_product AND products.deleted_at is null';
        $reviewObj = $reviewModel->getByConditions($conditions, '', $withSelect, $joinTable1, $withJoinCondition1);
        
        if(!$reviewObj){
            return false;
        }
        return $reviewObj;
    }
    
}
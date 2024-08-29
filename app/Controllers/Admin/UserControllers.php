<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\UserService;
use App\Services\getUserByID;


class UserControllers extends BaseController
{
    /**
        @var Service
    */
    private $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index()
    {
        $userModel = new UserModel();
        $data['totalUsers'] = $userModel->countAllResults();
        dd($data);
        return view('admin/pages/home', $data);
    }


    public function list(): string
    {
        $data = [];

    
        $cssFiles = [
            'http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
            base_url() . '/assets/admin/js/event.js',
            
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css'

        ];
        $dataLayout['users'] = $this->service->getAllUsers();
        $data = $this->loadMasterLayout($data, 'Tài khoản', 'admin/pages/user/list',$dataLayout, $cssFiles, $jsFiles);
        return view('admin/main', $data);
    }

    public function add()
    {
        $data = []; 
        $data = $this->loadMasterLayout($data, 'Thêm tài khoản', 'admin/pages/user/add');
        return view('admin/main', $data);
       
    }

    public function create()
    {
        $result = $this->service->addUserInfo($this->request);
        return redirect()->back()->withInput()->with($result['massageCode'], $result['messages']);
    }

    public function edit($id)
    {
        $user = $this->service->getUserByID($id);

        if(!$user){
            return redirect('error/404');
        }

        $cssFiles = [
            base_url() . '/assets/admin/js/event.js'
            
        ];

        $dataLayout['user'] = $user;
        $data = $this->loadMasterLayout([], 'Sửa tài khoản', 'admin/pages/user/edit', $dataLayout, $cssFiles, [] );
        return view('admin/main', $data);
    }

    public function update()
    {   
        $result = $this->service->updateUserInfo($this->request);
        return redirect()->back()->withInput()->with($result['massageCode'], $result['messages']);
    }

    public function delete($id)
    {
        $user = $this->service->getUserByID($id);

        if(!$user){
            return redirect('error/404');
        }

        $result = $this->service->deleteUser($id);
        return redirect('admin/user/list')->with($result['massageCode'], $result['messages']);
    }
}

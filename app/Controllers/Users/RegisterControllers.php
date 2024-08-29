<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class RegisterControllers extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('register', $data);
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
        ];

        if($this->validate($rules)){
            $userModel = new UserModel();
            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return redirect()->to('views/login');
        }else{
            $data['validation'] = $this->validator;
            echo view('register', $data);
        }
    }
}
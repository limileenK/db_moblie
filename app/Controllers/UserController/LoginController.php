<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\EmployerModel;
use App\Models\User_model\StudentModel;
use App\Models\Admin_model\AdminModel;


class LoginController extends ResourceController
{
    use ResponseTrait;
    public function Login()
    {
        $EmployerModel = new EmployerModel();
        $StudentModel = new StudentModel();
        $AdminModel = new AdminModel();

        $User_id =  $this->request->getVar('User_id');
        $User_password = $this->request->getVar('User_password');
        $password = md5($User_password);

        $wherestd = [
            "std_id" =>  $User_id,
            "std_password" =>  $password
        ];
        $whereemp = [
            "em_username" =>  $User_id,
            "em_password" =>  $password
        ];
        $whereadm = [
            "am_username" =>  $User_id,
            "am_password" =>  $password
        ];

        $checkStudentModel = $StudentModel->where($wherestd)->find();
        $checkEmployerModel = $EmployerModel->where($whereemp)->find();
        $checkAdminModel = $AdminModel->where($whereadm)->find();


        if (count($checkStudentModel) == 1) {
            foreach ($checkStudentModel as $row) {
                $username = $row['std_id'];
                $user_fname = $row['std_fname'];
                $user_lname = $row['std_lname'];
                $status = $row['status'];
                $user_img = $row['std_image'];

                $response = [
                    'username' => $username,
                    'fname' => $user_fname,
                    'lname' => $user_lname,
                    'status' => $status,
                    'img' => $user_img,
                    'message' =>  'success'
                ];
                return $this->respond($response);
            }
        } elseif (count($checkEmployerModel) == 1) {
            foreach ($checkEmployerModel as $row) {
                $username = $row['em_username'];
                $user_fname = $row['em_fname'];
                $user_lname = $row['em_lname'];
                $user_img = $row['em_image'];
                $status = $row['status'];

                $response = [
                    'username' => $username,
                    'fname' => $user_fname,
                    'lname' => $user_lname,
                    'status' => $status,
                    'img' => $user_img,
                    'message' =>  'success'
                ];
                return $this->respond($response);
            }
        } elseif (count($checkAdminModel) == 1) {
            foreach ($checkAdminModel as $row) {
                $username = $row['am_username'];
                $status = $row['status'];
                $user_fname = $row['am_name'];
                $user_img = $row['am_image'];

                $response = [
                    'username' => $username,
                    'status' => $status,
                    'fname' => $user_fname,
                    'lname' => "-",
                    'img' => $user_img,
                    'message' =>  'success'
                ];
                return $this->respond($response);
            }
        } else {

            $response = [
                'message' =>  'Fail Login'
            ];
            return $this->respond($response);
        }
    }
}

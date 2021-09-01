<?php

namespace App\Controllers\AdminController\Manageuser;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\StudentModel;
use App\Models\User_model\EmployerModel;

class Managemember extends ResourceController
{
    use ResponseTrait;

    public function getStudent()
    {
        $student = new StudentModel();
        $data =  $student->select('*')
            ->join('major', 'major.major_id = student.std_marjor_id')
            ->join('faculty', 'faculty.fac_id = major.major_id')
            ->findAll();
        return $this->respond($data);
    }
    public function getEmployer()
    {
        $student = new EmployerModel();
        $data =  $student->select('em_username,em_fname,em_lname,em_email,em_phone,em_image,em_date_regis,status')
            ->findAll();
        return $this->respond($data);
    }
}
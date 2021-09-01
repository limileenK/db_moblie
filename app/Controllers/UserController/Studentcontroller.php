<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\StudentModel;
use App\Models\Work_model\EmploymentModel;
use App\Models\Work_model\PostworkModel;

class Studentcontroller extends ResourceController
{
    use ResponseTrait;

    public function getStudentData($id = null){
        $student = new StudentModel();

        $data =  $student->select('*')
        ->join('major', 'major.major_id = student.std_marjor_id')
        ->join('faculty', 'faculty.fac_id = major.major_id')
        ->where('std_id',$id)
        ->findAll();
        return $this->respond($data);
    }
    public function editProfileFree($id = null){
        $student = new StudentModel();

        $fname = $this->request->getVar('std_fname');
        $lname = $this->request->getVar('std_lname');
        $phone = $this->request->getVar('std_phone');
        $std_description = $this->request->getVar('std_description');
        $data = [
            "std_fname" =>  $fname,
            "std_lname" => $lname,
            "std_phone" => $phone,
            "std_description" => $std_description,
        ];
        $student->update($id, $data);

        $response = [
            'messages' => 'success'
        ];
        return $this->respond($response);

    }

    public function addimgFree($id = null){
        $student = new StudentModel();

        $std_image = $this->request->getVar('std_image');
        
        
        $data = [
            "std_image" =>  $std_image,
            
        ];
        $student->update($id, $data);

        $response = [
            'messages' => 'success'
        ];
        return $this->respond($response);

    }



    public function getHistoryFree($id = null){
        $employ = new EmploymentModel();

        $data =  $employ->select('*')
        ->join('package', 'package.pk_id = employment.emm_pk_id')
        ->join('all_work', 'all_work.aw_id = package.pk_aw_id')
        ->where('emm_status','เสร็จสิ้นและรีวิว')->where("emm_std_id",$id)
        ->findAll();
        return $this->respond($data);
    }

    public function getStudentaccount($id = null)  //แสดงข้อมูลหน้าโปรไฟล์
    {
        $student = new StudentModel();
        $data = $student->select('*')
        ->where('std_id',$id)

        ->findAll();
        return $this->respond($data);

    }
public function getStudentwork($id = null)  //แสดงงานหน้าโปรไฟล์
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
        ->select('*')
        ->join('package', 'package.pk_aw_id = all_work.aw_id')
        ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')

        ->where('aw_std_id',$id)

        ->findAll();
        return $this->respond($data);

    }

    public function changePass($id = null){
        $student = new StudentModel();

        $pass = $this->request->getVar('std_password');
        $password = md5($pass);
        $data = [
            "std_password" => $password,
        ];
        $student->update($id, $data);
        $response = [
            'messages' => 'success'
        ];
        return $this->respond($response);
    }
}
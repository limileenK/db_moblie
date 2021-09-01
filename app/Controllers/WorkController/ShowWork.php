<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\PostworkModel;
use App\Models\Work_model\Work_img;
use App\Models\Work_model\PackageModel;
use App\Models\Work_model\Comment;
use App\Models\Work_model\EmploymentModel;


class ShowWork extends ResourceController
{
    use ResponseTrait;
    public function ShowAllWork()
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
        ->join('package', 'package.pk_aw_id = all_work.aw_id')
        ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
        ->join('student', 'student.std_id = all_work.aw_std_id')
        ->where('aw_status', 'ผ่านการอนุมัติ')->groupBy('aw_id')
        ->findAll();
        return $this->respond($data);
    }



    public function ShowWorkCount() //หน้าhome
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel

            ->select('aw_id,aw_name,aw_detail,pk_price,pk_time_period,aw_sub_cate_id,std_fname,std_lname,w_img_name,')
            ->selectCount('emm_std_id')
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('employment', 'employment.emm_std_id = all_work.aw_std_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('emm_status', 'success')->groupBy('emm_std_id')
            ->orderBy('emm_std_id', 'DESC')
            ->where('aw_status', 'ผ่านการอนุมัติ')->groupBy('aw_id')

            ->findAll();
        return $this->respond($data);
    }

    public function getDetailPost($id = null) //หน้าโชว์ข้อมูล
    {

        $PostworkModel = new PostworkModel();
        $Work_img = new Work_img();
        $PackageModel = new PackageModel();

        $workbyid = $PostworkModel->where('aw_id', $id)->first();
        $packagebyid = $PackageModel->select('pk_id,pk_name,pk_detail,pk_price,pk_time_period')->where('pk_aw_id', $id)->findAll();
        $imgbyid = $Work_img
            ->select('w_img_name')
            ->where('w_aw_id', $id)
            ->findAll();
        $data = [
            $workbyid,
            $packagebyid,
            $imgbyid
        ];
        return $this->respond($data);
    }
    public function ShowPIC($id = null) //หน้าโชว์ข้อมูล
    {
        $WorkimgModel = new Work_img();
        $img = $WorkimgModel
            ->select('*')
            ->where('w_aw_id', $id)->orderBy('w_aw_id')
            ->findAll();
        return $this->respond($img);
    }
    public function Mypost($id = null)
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->join('student', 'student.std_id =all_work.aw_std_id')
            ->where('aw_std_id', $id)
            ->groupBy('package.pk_aw_id')
            ->findAll();
        return $this->respond($data);
    }
    
    public function DeleteMypost($id = null)
    {
        $PostworkModel = new PostworkModel();
        $Work_img = new Work_img();
        $PackageModel = new PackageModel();

        $data = $PostworkModel->where('aw_id', $id);
        $data2 = $Work_img->where('w_aw_id', $id);
        $data3 = $PackageModel->where('pk_aw_id', $id);
        if ($data || $data2 || $data3) {
            $Work_img->delete($id);
            $response = [
                "message" => 'Delete success'
            ];
            return $this->respond($response);
        }
        if ($data || $data2 || $data3) {
            $PackageModel->delete($id);
            $response2 = [
                "message" => 'Delete success2'
            ];
            return $this->respond($response2);
        }
        // $PostworkModel->delete($id);
        // else {
        //     return $this->failNotFound('No Category found');
        // }

        // return $this->respond($data);
    }

    public function getPackage($id = null)
    {
        $PackageModel = new PackageModel();
        $packageData = $PackageModel
            ->select('*')
            ->where('pk_aw_id ', $id)->orderBy('pk_id', 'ASC')
            ->findAll();
        return $this->respond($packageData);
    }

    public function deletePackage($id = null)
    {
        $PackageModel = new PackageModel();
        $packageData = $PackageModel->where('pk_id', $id)->find();
        if ($packageData) {
            $PackageModel->delete($id);
            $response = [
                "message" => 'Delete success'
            ];
            return $this->respond($response);
        } else {
            $response = [
                "message" => 'Delete No success'
            ];
            return $this->respond($response);
        }
    }

    public function getPackagebyId($id = null)
    {
        $PackageModel = new PackageModel();
        $packageData = $PackageModel
            ->select('*')
            ->where('pk_id ', $id)
            ->findAll();
        return $this->respond($packageData);
    }

    public function updatePack($id = null)
    {
        $PackageModel = new PackageModel();
        $dataPack = [
            "pk_name" => $this->request->getVar('pk_name'),
            "pk_detail" => $this->request->getVar('pk_detail'),
            "pk_price" => $this->request->getVar('pk_price'),
            "pk_time_period" => $this->request->getVar('pk_time_period')
        ];
        $PackageModel->update($id, $dataPack);
        $response = [
            "message" => 'success'     
        ];
        return $this->respond($response);
    }


    public function Selectbyid($id = null) //หน้าhome
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
            // ->join('package', 'package.pk_aw_id = all_work.aw_id')
            // ->join('student', 'student.std_id = all_work.aw_std_id')
            // ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('aw_id', $id)
            ->findAll();
        return $this->respond($data);
    }


    public function Selectfreebyid($id = null) //หน้าhome
    {
        $PostworkModel = new PostworkModel();
        $data = $PostworkModel
           
            ->join('student', 'student.std_id = all_work.aw_std_id')
           
            ->where('aw_id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function Reviewbyid($id = null) //หน้าhome
    {
        $comment = new EmploymentModel();
        $data = $comment
        ->select('emm_user_id , emm_review')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->where('all_work.aw_id', $id)->orderBy('all_work.aw_id')
        ->where('emm_status','เสร็จสิ้นและรีวิว')
        ->findAll();

            
        return $this->respond($data);
    }
}

<?php

namespace App\Controllers\AdminController\ManageWork;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\PostworkModel;
use App\Models\Work_model\PackageModel;
use App\Models\Admin_model\AdminModel;
use App\Models\Work_model\Work_img;


class ManagePost extends ResourceController
{
    use ResponseTrait;
    public function ShowPostNotpass()
    {
        $PostworkModel = new PostworkModel();
        $res = $PostworkModel->select('aw_id,aw_name,aw_detail,sub_cate_name,std_id,Comment')
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('sub_cate', 'sub_cate.sub_cate_id = all_work.aw_sub_cate_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('aw_status', 'ไม่ผ่านการอนุมัติ')->groupBy('aw_id')
            ->findAll();
        return $this->respond($res);
    }

    public function ShowWait()
    {
        $PostworkModel = new PostworkModel();
        $res = $PostworkModel->select('aw_id,aw_name,aw_detail,sub_cate_name,std_id')
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('sub_cate', 'sub_cate.sub_cate_id = all_work.aw_sub_cate_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('aw_status', 'รอดำเนินการ')->groupBy('aw_id')
            ->findAll();
        return $this->respond($res);
    }

    public function ShowPostPass()
    {
        $PostworkModel = new PostworkModel();
        $res = $PostworkModel->select('aw_id,aw_name,aw_detail,sub_cate_name,std_id')
            ->join('package', 'package.pk_aw_id = all_work.aw_id')
            ->join('sub_cate', 'sub_cate.sub_cate_id = all_work.aw_sub_cate_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->join('work_img', 'work_img.w_aw_id = all_work.aw_id')
            ->where('aw_status', 'ผ่านการอนุมัติ')->groupBy('aw_id')
            ->findAll();
        return $this->respond($res);
    }

    public function ManagePost($id = null)
    {
        $AdminModel = new AdminModel();
        $PostworkModel = new PostworkModel();

        $UpdateStatus = $this->request->getVar('Work_status');
        $Comment = $this->request->getVar('Comment');
        $Adminstatus = $this->request->getVar('Adminstatus');
        $checkAdmin = $AdminModel->where('status', $Adminstatus)->find();
        if (count($checkAdmin) != 0 && $UpdateStatus != null) {
            if ($UpdateStatus == "ผ่านการอนุมัติ") {
                $data = [
                    'aw_status' => $UpdateStatus,
                    'Comment' => " "
                ];
                $PostworkModel->update($id, $data);
                $response = [
                    'message' =>  'success'
                ];
                return $this->respond($response);
            } else if ($UpdateStatus == "ไม่ผ่านการอนุมัติ") {
                $data = [
                    'aw_status' => $UpdateStatus,
                    'Comment' => $Comment
                ];
                $PostworkModel->update($id, $data);
                $response = [
                    'message' =>  'success'
                ];
                return $this->respond($response);
            }
        } else {
            return $this->failNotFound("Reset err");
        }
    }

    public function Checkpost($id = null)
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
}

<?php

namespace App\Controllers\AdminController\Category;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Admin_model\MaincategoryModel;

class MainCategory extends ResourceController
{
    use ResponseTrait;

    public function addCategory()
    {
        $Main_Cate_model = new MaincategoryModel();
        $main_cate_name = $this->request->getVar('main_cate_name');
        $main_cate_img = $this->request->getVar('main_cate_img');
        $status = $this->request->getVar('status');
        $dataCate = [
            "main_cate_name" => $main_cate_name,
            "main_cate_img" => $main_cate_img
        ];
        $data =  $Main_Cate_model->where('main_cate_name', $main_cate_name)->find();
        if ($status === 'Admin') {
            if (count($data) > 0) {
                $response = [
                    'status' => 201,
                    'error' => null,
                    'message' => 'dupicate category'
                ];
                return $this->respond($response);
            } else {
                $Main_Cate_model->insert($dataCate);
                $response = [
                    'status' => 201,
                    'error' => null,
                    'message' => 'success'
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                'status' => 201,
                'error' => null,
                "message" => [
                    'success' => 'คุณไม่ใช่แอดมิน'
                ]
            ];
            return $this->respond($response);
        }
    }
    public function showCate()
    {
        $Main_Cate_model = new MaincategoryModel();
        $data = $Main_Cate_model->orderBy('main_cate_id', 'DESC')->findAll();
        return $this->respond($data);
    }
    public function showCatebyid($id = null)
    {
        $model = new MaincategoryModel();
        $data = $model->where('main_cate_id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No main_cate');
        }
    }
    public function editCate($id = null)
    {
        $Main_Cate_model = new MaincategoryModel();
        $dataCate = [
            "main_cate_name" => $this->request->getVar('main_cate_name')
        ];
        $Main_Cate_model->update($id, $dataCate);
        $response = [
            'status' => 201,
            'error' => null,
            "message" => [
                'success' => 'แก้ไขประเภทงานเรียบร้อย'
            ]
        ];
        return $this->respond($response);
    }
    public function showWorkbyMaincate($id = null)
    {
        $model = new MaincategoryModel();
        $data = $model
            ->select('*')
            ->join('sub_cate', 'sub_cate.main_cate_id = main_cate.main_cate_id')
            ->join('all_work', 'all_work.aw_sub_cate_id = sub_cate.sub_cate_id')
            ->join('work_img', 'all_work.aw_id = work_img.w_aw_id')
            ->join('package', ' all_work.aw_id = package.pk_aw_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->where('main_cate.main_cate_id', $id)
            ->where('all_work.aw_status',  'ผ่านการอนุมัติ')
            ->groupBy('all_work.aw_id')
            ->findAll();
        return $this->respond($data);
    }
}

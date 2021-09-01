<?php

namespace App\Controllers\AdminController\Category;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Admin_model\Subcategory;
use App\Models\Admin_model\MaincategoryModel;

class SubCategoryControl extends ResourceController
{
    use ResponseTrait;

    public function showSub()
    {
        $Submodel = new Subcategory();
        $data = $Submodel->orderBy('sub_cate_id', 'DESC')->findAll();
        return $this->respond($data);
    }
    public function showSubJoin()
    {
        $Submodel = new Subcategory();
        $data = $Submodel->join('main_cate', 'main_cate.main_cate_id = sub_cate.main_cate_id')->findAll();
        return $this->respond($data);
    }
    public function addsubCategory()
    {
        $Submodel = new Subcategory();

        $main_cate_id = $this->request->getVar('main_cate_id');
        $sub_cate_name = $this->request->getVar('sub_cate_name');
        $status = $this->request->getVar('status');
        $dataCate = [
            "main_cate_id" => $main_cate_id,
            "sub_cate_name" => $sub_cate_name
        ];
        $data =  $Submodel->select('sub_cate_name')->where($dataCate)->find();
        if ($status === 'Admin') {
            if ($data) {
                $response = [
                    "message" => 'fail'
                ];
                return $this->respond($response);
            } else {
                $Submodel->insert($dataCate);
                $response = [
                    "message" => 'success'
                ];
                return $this->respond($response);
            }
        } else {
            $response = ["message" => 'YouNotAdmin'];
            return $this->respond($response);
        }
    }
    public function editSubcate($id = null)
    {
        $Submodel = new Subcategory();

        $dataCate = [
            "main_cate_id" => $this->request->getVar('main_cate_id'),
            "sub_cate_name" => $this->request->getVar('sub_cate_name')
        ];
        $Submodel->update($id, $dataCate);
        $response = [
            "message" => [
                'success' => 'แก้ไขประเภทงานเรียบร้อย'
            ]
        ];
        return $this->respond($response);
    }
    
    public function deleteSub($id = null)
    {
        $Submodel = new Subcategory();
        $data = $Submodel->find($id);
        if ($data) {
            $Submodel->delete($id);
            $response = [
                "message" => [
                    'success' => 'Delete Category success'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Category found');
        }
    }
    public function subcatebyid($id = null)
    {
        $model = new MaincategoryModel();  //อิมพอท
        $data = $model
            ->select('*')
            ->join('sub_cate', 'sub_cate.main_cate_id = main_cate.main_cate_id')
            ->where('main_cate.main_cate_id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function showSubcatebyid($id = null)
    {
        $Submodel = new Subcategory();
        $data = $Submodel->where('sub_cate_id', $id)->join('main_cate', 'main_cate.main_cate_id = sub_cate.main_cate_id')->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Product');
        }
    }

    public function selectworkbySubcate($id = null)
    {
        $model = new MaincategoryModel();  //อิมพอท
        $data = $model
            ->select('*')
            ->join('sub_cate', 'sub_cate.main_cate_id = main_cate.main_cate_id')
            ->where('sub_cate.main_cate_id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function showWorkbySubcate($id = null)
    {
        $model = new Subcategory();
        $data = $model
            ->select('*')
            
            ->join('all_work', 'all_work.aw_sub_cate_id = sub_cate.sub_cate_id')
            ->join('work_img', 'all_work.aw_id = work_img.w_aw_id')
            ->join('package', ' all_work.aw_id = package.pk_aw_id')
            ->join('student', 'student.std_id = all_work.aw_std_id')
            ->where('sub_cate.sub_cate_id', $id)
            ->where('all_work.aw_status',  'ผ่านการอนุมัติ')
            ->groupBy('all_work.aw_id')
            ->findAll();
        return $this->respond($data);
    }
}

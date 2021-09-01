<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\StudentModel;
use App\Models\Work_model\PostworkModel;
use App\Models\Work_model\PackageModel;
use App\Models\Work_model\Work_img;

class Postwork extends ResourceController
{
    use ResponseTrait;
    public function Postwork()
    {
        $StudentModel  = new StudentModel();
        $PostworkModel = new PostworkModel();
        $PackageModel  = new PackageModel();
        $Work_imgModel = new Work_img();

        $uniqid = date('y') . date('d') . date('m') . microtime(true);
        $User_id =  $this->request->getVar('User_id');
        $Work_name = $this->request->getVar('Work_name');
        $Work_detail = $this->request->getVar('Work_detail');
        $Work_category = $this->request->getVar('Work_category');
        $Work_img = $this->request->getVar('Work_img');
        $Pk_name = $this->request->getVar('Pk_name');
        $Pk_detail = $this->request->getVar('Pk_detail');
        $Pk_price = $this->request->getVar('Pk_price');
        $timeperiod = $this->request->getVar('timeperiod');
        $emp_id = str_replace(".", "", $uniqid);
        $checkStudentModel = $StudentModel->where('std_id', $User_id)->find();

        if (count($checkStudentModel) != 0) {
            $work = [
                'aw_id' => $emp_id,
                'aw_std_id' => $User_id,
                'aw_name' => $Work_name,
                'aw_detail' => $Work_detail,
                'aw_sub_cate_id' => $Work_category,
                'aw_status' => 'ไม่ผ่านการอนุมัติ'
            ];
            $PostworkModel->insert($work);
            if ($PostworkModel) {
                $pack = [
                    'pk_name' => $Pk_name,
                    'pk_detail' => $Pk_detail,
                    'pk_price' => $Pk_price,
                    'pk_aw_id' => $emp_id,
                    'pk_time_period' => $timeperiod
                ];
                $postpack =  $PackageModel->insert($pack);
                if ($postpack) {
                    $result = array();
                    foreach ($Work_img as $key => $val) {
                        $result = [
                            'w_aw_id'  => $emp_id,
                            'w_img_name' => $val,
                        ];
                        $workimg = $Work_imgModel->insert($result);
                    }
                    if ($workimg) {
                        $response = [
                            'messages' => 'success'
                        ];
                        return $this->respond($response);
                    } else {
                        $response = [
                            'messages' => 'FailImg'
                        ];
                        return $this->respond($response);
                    }
                } else {
                }
                $response = [
                    'messages' => 'success'
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'messages' => 'Failpack'
                ];
                return $this->respond($response);
            }
        } else {
            $response = [
                'messages' => 'FailPost'
            ];
            return $this->respond($response);
        }
    }
    public function EditPost($id = null){
        $PostworkModel = new PostworkModel();

        $dataPost = [
            "aw_name" => $this->request->getVar('aw_name'),
            "aw_detail" => $this->request->getVar('aw_detail'),
            "aw_status" => $this->request->getVar('aw_status')
        ];
        $PostworkModel->update($id, $dataPost);
        $response = [
            "message" => 'success'     
        ];
        return $this->respond($response);
    }
    public function insertPacks(){
        $PackageModel  = new PackageModel();
        $pk_name = $this->request->getVar('pk_name');
        $pk_detail = $this->request->getVar('pk_detail');
        $pk_price = $this->request->getVar('pk_price');
        $pk_aw_id = $this->request->getVar('pk_aw_id');
        $pk_time_period = $this->request->getVar('pk_time_period');

        $dataPacks = [
            'pk_name'=>$pk_name,
            'pk_detail'=>$pk_detail,
            'pk_price'=>$pk_price,
            'pk_aw_id'=>$pk_aw_id,
            'pk_time_period'=>$pk_time_period,
        ];
        $PackageModel->insert($dataPacks);
        $response = [
            "message" => 'success'     
        ];
        return $this->respond($response);

    }
    public function deletePhotos($id = null)
    {    
        $Work_imgModel = new Work_img();
        $photo = $Work_imgModel->where('w_img_id', $id)->find();
        if ($photo) {
            $Work_imgModel->delete($id);
            $response = [
                "message" => 'Delete success'
            ];
            return $this->respond($response);
     
        }
        else {
            $response = [
                "message" => 'Delete No success'
            ];
            return $this->respond($response);
        }
    }
    public function addMorePhotos(){
        $Work_imgModel = new Work_img();
        $Work_img = $this->request->getVar('w_img_name');
        $emp_id = $this->request->getVar('w_aw_id');
        $result = array();
        foreach ($Work_img as $key => $val) {
            $result = [
                'w_aw_id'  => $emp_id,
                'w_img_name' => $val,
            ];
            $workimg = $Work_imgModel->insert($result);
        }
        if ($workimg) {
            $response = [
                'messages' => 'success'
            ];
            return $this->respond($response);
        } else {
            $response = [
                'messages' => 'FailImg'
            ];
            return $this->respond($response);
        }
    }
    
}

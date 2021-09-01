<?php

namespace App\Controllers\UserController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Admin_model\ReportModel;
use CodeIgniter\I18n\Time;

class ReportControll extends ResourceController
{
    use ResponseTrait;

    public function addReport(){
        $repModel= new ReportModel();
        $rp_user_id = $this->request->getVar('rp_user_id');
        $rp_title = $this->request->getVar('rp_title');
        $rp_detail = $this->request->getVar('rp_detail');
        $rp_importance = $this->request->getVar('rp_importance');
        $rp_status = $this->request->getVar('rp_status');
        $timeNow = Time::now('Asia/Bangkok');

        $dataReport = [
            "rp_user_id" => $rp_user_id,
            "rp_title" => $rp_title,
            "rp_detail" => $rp_detail,
            "rp_date"=>$timeNow,
            "rp_importance" => $rp_importance,
            "rp_status" => $rp_status
        ];
        if(!$dataReport){
        $response=[ 
            "message"=>'fail'
            ];
            return $this->respond($response);
        }else{
            $repModel->insert($dataReport);
            $response = [ "message"=>'success',  ];
             return $this->respond($response); 
        }
        
    }
}

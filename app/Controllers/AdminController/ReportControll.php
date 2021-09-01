<?php

namespace App\Controllers\AdminController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Admin_model\ReportModel;

class ReportControll extends ResourceController
{
    use ResponseTrait;

    public function showReport(){
        $repModel= new ReportModel();
        $Read= 'NotRead';
        $data = $repModel->where("rp_status",$Read)->orderBy('rp_importance', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function showreadReport(){
        $repModel= new ReportModel();
        $Read= 'Read';
        $data = $repModel->where("rp_status",$Read)->orderBy('rp_importance', 'DESC')->findAll();
        return $this->respond($data);
    }
    
    public function updateReport($reportId=null){
        $repModel= new ReportModel();

            $data = [
                "rp_status" => $this->request->getVar('rp_status'),
            ];
            $repModel->update($reportId, $data);
            $response = [ "message"=>'success',  ];
            return $this->respond($response);
        
    }
}
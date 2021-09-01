<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\EmploymentModel;

class Employment extends ResourceController
{
    use ResponseTrait;
    public function addEmployment()
    {
        $employment = new EmploymentModel();
        $emm_user_id = $this->request->getVar('emm_user_id');
        $emm_std_id = $this->request->getVar('emm_std_id');
        $emm_pk_id = $this->request->getVar('emm_pk_id');
        $emm_status = $this->request->getVar('emm_status');

        $data = [
            "emm_user_id" =>$emm_user_id,
            "emm_std_id" => $emm_std_id,
            "emm_pk_id"=>$emm_pk_id,
            "emm_status"=>$emm_status,
        ];
        $employment->insert($data);
        $response = ["message" =>'success' ];
        return $this->respond($response);
    }

    public function selectEmploymentForFl($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_std_id', $id)
        ->where('emm_status','รอการตอบรับ')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }

      public function selEmploymentForFltoProgress($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_std_id', $id)
        ->where('emm_status','กำลังดำเนินการ')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }

    public function selEmploymentForFltoSuccess($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_std_id', $id)
        ->where('emm_status','เสร็จสิ้นและรีวิว')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }

    public function selectEmploymentForEpy($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_user_id', $id)
        ->where('emm_status','รอการตอบรับ')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }
    public function selectEmploymentForEpytoProgress($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_user_id', $id)
        ->where('emm_status','กำลังดำเนินการ')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }
    public function selEmploymentForEpytoSuccess($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_user_id', $id)
        ->where('emm_status','เสร็จสิ้น')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }
    public function acceptFromFl($emm_id = null)
    {
        $employment = new EmploymentModel();
        $data = [
            "emm_status" => $this->request->getVar('emm_status'),
        ];
        $employment->update($emm_id, $data);
        $response = ["message"=>'success'];
        return $this->respond($response);
    }
    public function insertreview($emm_id = null)
    {
        $employment = new EmploymentModel();
        $data = [
            "emm_review" => $this->request->getVar('emm_review'),
            "emm_status" => $this->request->getVar('emm_status')
        ];
        $employment->update($emm_id, $data);
        $response = ["message"=>'success'];
        return $this->respond($response);
    }
    public function deleteFromEpy($emm_id = null)
    {
        $employment = new EmploymentModel();
        $employment->delete($emm_id);
        $response = ["message"=>'success'];
        return $this->respond($response);
    }
    public function successFromEpy($emm_id = null)
    {
        $employment = new EmploymentModel();
        $data = [
            "emm_status" => $this->request->getVar('emm_status'),
        ];
        $employment->update($emm_id, $data);
        $response = ["message"=>'success'];
        return $this->respond($response);
    }
    public function selEmploymentForEpytoSuccessAndReview($id = null)
    {
        $employment = new EmploymentModel();
        $data =  $employment->select('*')
        ->where('emm_user_id', $id)
        ->where('emm_status','เสร็จสิ้นและรีวิว')
        ->join('package','package.pk_id = employment.emm_pk_id')
        ->join('all_work','all_work.aw_id = package.pk_aw_id')
        ->orderBy('emm_date_time', 'ASC')
        ->findAll();    
        return $this->respond($data);
    }

    public function deleteemploymentFree($id = null)
    {
        $employment = new EmploymentModel();
        $data = $employment->find($id);
        if ($data) {
            $employment->delete($id);
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

}

<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\EmploymentModel;


class Showcom extends ResourceController
{
    use ResponseTrait;
    public function showcomment($id = null)
    {
        $datacomment = new EmploymentModel();

        $data =  $datacomment->select('*')
            ->where('emm_id', $id)
            ->join('student', 'student.std_id = employment.emm_std_id')
            ->join('package', 'package.pk_id = employment.emm_pk_id')
            ->join('all_work', 'all_work.aw_id = package.pk_aw_id')
            ->join('work_img', 'all_work.aw_id = work_img.w_aw_id')
            ->GROUPBY('emm_id')
            ->findAll();
            // SELECT * FROM `employment`,`all_work`,`package` WHERE employment.emm_pk_id= package.pk_id AND all_work.aw_id= package.pk_aw_id AND employment.emm_pk_id=00000000002
        return $this->respond($data);
    }

    
}

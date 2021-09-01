<?php

namespace App\Controllers\WorkController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Work_model\Comment;

class Insertcomment extends ResourceController
{
    use ResponseTrait;
    public function addcomment()
    {
        $Comment = new Comment(); 
        $wr_emm_username_id = $this->request->getVar('wr_emm_username_id');
        $wr_std_id = $this->request->getVar('wr_std_id');
        $wr_comment = $this->request->getVar('wr_comment');
        $wr_pk_id = $this->request->getVar('wr_pk_id');
        $wr_aw_id = $this->request->getVar('wr_aw_id');

        $data = [
            "wr_emm_username_id" =>$wr_emm_username_id,
            "wr_std_id" => $wr_std_id,
            "wr_comment"=>$wr_comment,
            "wr_pk_id"=>$wr_pk_id,
            "wr_aw_id"=>$wr_aw_id,
        ];
        $Comment->insert($data);
        $response = ["message" =>'success' ];
        return $this->respond($response);
    }
}
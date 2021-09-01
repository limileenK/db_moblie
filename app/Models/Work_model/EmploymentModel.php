<?php

namespace App\Models\Work_model;
use CodeIgniter\Model;

class EmploymentModel extends Model{
    protected $table = 'employment';
    protected $primaryKey = 'emm_id';
    protected $allowedFields = ['emm_id','emm_user_id','emm_std_id','emm_am_id','emm_pk_id','emm_date_time','emm_img_tax','emm_status','emm_review'];
}
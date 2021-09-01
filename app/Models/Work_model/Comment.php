<?php

namespace App\Models\Work_model;
use CodeIgniter\Model;

class Comment extends Model{
    protected $table = 'work_review';
    protected $primaryKey = 'wr_id';
    protected $allowedFields = ['wr_id','wr_emm_username_id','wr_std_id','wr_comment','wr_pk_id','wr_aw_id'];
}
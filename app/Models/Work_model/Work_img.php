<?php

namespace App\Models\Work_model;

use CodeIgniter\Model;

class Work_img extends Model
{
    protected $table = 'work_img';
    protected $primaryKey = 'w_img_id';
    protected $allowedFields = ['w_aw_id', 'w_img_name'];
}

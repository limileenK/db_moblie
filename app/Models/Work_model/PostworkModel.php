<?php

namespace App\Models\Work_model;

use CodeIgniter\Model;

class PostworkModel extends Model
{
    protected $table = 'all_work';
    protected $primaryKey = 'aw_id';
    protected $allowedFields = ['aw_id', 'aw_name', 'aw_detail', 'aw_date_post', 'aw_sub_cate_id', 'aw_std_id', 'aw_status', 'Comment'];
}

<?php

namespace App\Models\Admin_model;
use CodeIgniter\Model;

class MaincategoryModel extends Model{
    protected $table = 'main_cate';
    protected $primaryKey = 'main_cate_id';
    protected $allowedFields = ['main_cate_id','main_cate_name','main_cate_img'];
}

<?php

namespace App\Models\Admin_model;

use CodeIgniter\Model;

class Subcategory extends Model
{
    protected $table = 'sub_cate';
    protected $primaryKey = 'sub_cate_id';
    protected $foreignKey = 'main_cate_id';
    protected $allowedFields = ['sub_cate_id', 'main_cate_id', 'sub_cate_name'];
}

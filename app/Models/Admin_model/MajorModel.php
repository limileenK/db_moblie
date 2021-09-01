<?php

namespace App\Models\Admin_model;
use CodeIgniter\Model;

class MajorModel extends Model{
    protected $table = 'major';
    protected $primaryKey = 'major_id';
    protected $allowedFields = ['major_id','fac_id','major_name'];
}

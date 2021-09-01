<?php

namespace App\Models\Admin_model;
use CodeIgniter\Model;

class FacultyModel extends Model{
    protected $table = 'faculty';
    protected $primaryKey = 'fac_id';
    protected $allowedFields = ['fac_id','fac_name'];
}
?>
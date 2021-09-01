<?php

namespace App\Models\User_model;
use CodeIgniter\Model;

class StudentModel extends Model{
    protected $table = 'student';
    protected $primaryKey = 'std_id';
    protected $allowedFields = ['std_id','std_password','std_fname','std_lname','std_email','std_phone','std_regis','std_marjor_id','std_image','status','std_description'];
}
?>


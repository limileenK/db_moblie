<?php

namespace App\Models\User_model;
use CodeIgniter\Model;

class EmployerModel extends Model{
    protected $table = 'employer';
    protected $primaryKey = 'em_username';
    protected $allowedFields = ['em_username','em_password','em_fname','em_lname','em_email','em_phone','em_image','em_date_regis','status'];
}
?>
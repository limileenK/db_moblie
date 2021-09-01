<?php

namespace App\Models\Admin_model;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'am_id';
    protected $allowedFields = ['am_id', 'am_password', 'am_username', 'am_name', 'status', 'am_image'];
}

<?php

namespace App\Models\Admin_model;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 'report';
    protected $primaryKey = 'rp_id';
    protected $allowedFields = ['rp_user_id', 'rp_title', 'rp_detail', 'rp_date', 'rp_importance','rp_status'];
}

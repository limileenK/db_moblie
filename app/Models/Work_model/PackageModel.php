<?php

namespace App\Models\Work_model;

use CodeIgniter\Model;

class PackageModel extends Model
{
    protected $table = 'package';
    protected $primaryKey = 'pk_id';
    protected $allowedFields = ['pk_id', 'pk_name', 'pk_detail', 'pk_price', 'pk_aw_id', 'pk_time_period'];
}

<?php

namespace App\Models\User_model;

use CodeIgniter\Model;

class VerifyModel extends Model
{
    protected $table = 'verifyregister';
    protected $primaryKey = 'u_email';
    protected $allowedFields = ['u_email', 'u_otp', 'otp_timer', 'end_timer'];
}

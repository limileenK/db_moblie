<?php

namespace App\Models\User_model;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'message';
    protected $primaryKey = 'm_id';
    protected $allowedFields = ['m_id', 'Username', 'To_Username', 'm_message', 'm_time', "m_room" , "status"];
}

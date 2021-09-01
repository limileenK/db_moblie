<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\MessageModel;


use CodeIgniter\I18n\Time;

class MessageController extends ResourceController
{
    use ResponseTrait;

    public function sendmessage()
    {
        $MessageModel = new MessageModel();
        $User_id = $this->request->getVar('User_id');
        $toUser_id = $this->request->getVar('toUser_id');
        $message = $this->request->getVar('message');
        $room = $User_id . "&" . $toUser_id;
        $user = "Username = '$User_id' AND To_Username='$toUser_id' OR Username='$toUser_id' AND To_Username = '$User_id'";

        $checkroom = $MessageModel->distinct()->select("m_room")->where($user)->find();
        if (count($checkroom) >= 1) {
            foreach ($checkroom as $row) {
                $data = [
                    "Username" => $User_id,
                    "To_Username" => $toUser_id,
                    "m_message" => $message,
                    "m_room" =>  $row['m_room'],
                    "status" => "unraed"
                ];
                $MessageModel->insert($data);
                $response = [
                    'message' =>  "success"
                ];
                return $this->respond($response);
            }
        } else if (count($checkroom) != 1) {
            $data = [
                "Username" => $User_id,
                "To_Username" => $toUser_id,
                "m_message" => $message,
                "m_room" => $room,
                "status" => "unraed"
            ];
            $MessageModel->insert($data);
            $response = [
                'message' =>  'success'
            ];
            return $this->respond($response);
        }
    }
    public function showmessagebyid($id = null)
    {
        $MessageModel = new MessageModel();
        $data = $MessageModel->select("m_message , m_time , Username , To_Username")->where('m_room', $id)->findAll();
        return $this->respond($data);
    }

    public function readmessage($id = null)
    {
        $MessageModel = new MessageModel();
        $m_room = $this->request->getVar('m_room');
        $whereuser = "To_Username = '$id' AND m_room ='$m_room'";
        $MessageModel->where($whereuser)->set(['status' => "read"])->update();
    }
    public function notificationsmessage($id = null)
    {
        $MessageModel = new MessageModel();
        $whereuser = "To_Username = '$id'  AND status ='unread'";
        $data =  $MessageModel->selectCount('To_Username')->where($whereuser)->findAll();
        return $this->respond($data);
    }
    public function showallusermessage($id = null)
    {
        $MessageModel = new MessageModel;
        $data = $MessageModel->select("m_id,Username,std_image,em_image,m_room")
            ->join('student', 'student.std_id = message.Username', 'LEFT')
            ->join('employer', 'employer.em_username = message.Username', 'LEFT')
            ->where("To_Username", $id)->orderby('m_id', 'DESC')->groupby('Username')->findAll();
        return $this->respond($data);
    }
    public function showalluserandstatusmessage($id = null)
    {
        $MessageModel = new MessageModel;
        $data = $MessageModel->select("m_id,Username,m_message,message.status")->where("To_Username", $id)->findAll();
        return $this->respond($data);
    }
}

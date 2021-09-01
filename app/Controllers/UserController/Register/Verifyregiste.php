<?php

namespace App\Controllers\UserController\Register;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\VerifyModel;
use App\Models\User_model\EmployerModel;
use App\Models\User_model\StudentModel;
use CodeIgniter\I18n\Time;


class Verifyregiste extends ResourceController
{
    use ResponseTrait;

    public function Verifyregistre()
    {
        $VerifyModel = new VerifyModel();
        $EmployerModel = new EmployerModel();
        $StudentModel = new StudentModel();

        $User_id =  $this->request->getVar('User_id');
        $User_email = $this->request->getVar('User_email');

        if ($User_id != null && $User_email != null) {
            $otp = rand(100000, 999999);
            $step1 = md5($otp);
            $step2 = strrev($step1);
            $step3 = md5($step2);
            $concealotp = strrev($step3);

            $timeNow = Time::now('Asia/Bangkok');
            $settime = $timeNow->addMinutes(+5);
            $timeEnd = $settime->toDateTimeString();

            $wherestd = "std_id = '$User_id' OR std_email='$User_email'";
            $whereemp = "em_username = '$User_id' OR em_email='$User_email'";

            $checkStudentModel = $StudentModel->where($wherestd)->find();
            $checkEmployerModel = $EmployerModel->where($whereemp)->find();
            $checkVerifyModel =  $VerifyModel->where('u_email', $User_email)->find();

            $data = [
                'u_email' => $User_email,
                'u_otp' => $concealotp,
                'otp_timer' => $timeNow,
                'end_timer' =>  $timeEnd

            ];

            if (count($checkStudentModel) == 0 && count($checkEmployerModel) == 0 && count($checkVerifyModel) == 0) {
                $VerifyModel->insert($data);
                if ($VerifyModel) {
                    $to = $User_email;
                    $email = \Config\Services::email();
                    $email->setFrom('flashwork.co@gmail.com', 'flashwork');
                    $email->setTo($to);
                    $email->setSubject('ยืนยันรหัส OTP');
                    $email->setMessage('รหัส OTP ของคุณคือ' . $otp);
                    $email->send();
                    $response = [
                        'messages' => 'success'
                    ];
                    return $this->respond($response);
                } else {
                    return $this->failNotFound('send err');
                }
            } elseif (count($checkVerifyModel) > 0) {
                $VerifyModel->update($User_email, $data);

                if ($VerifyModel) {
                    $to = $User_email;
                    $email = \Config\Services::email();
                    $email->setFrom('flashwork.co@gmail.com', 'flashwork');
                    $email->setTo($to);
                    $email->setSubject('ยืนยันรหัส OTP');
                    $email->setMessage('รหัส OTP ของคุณคือ' . $otp);
                    $email->send();
                    $response = [
                        'messages' => 'success'
                    ];
                    return $this->respond($response);
                } else {
                    return $this->failNotFound('Update err');
                }
            } else {
                $response = [
                    'messages' => 'Dupicate Member'
                ];
                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('Empty Data');
        }
    }



    public function resetotp($id = null)
    {
        $VerifyModel = new VerifyModel();

        $Status_reset =  $this->request->getVar('Status_reset');
        $User_email = $this->request->getVar('User_email');
        $otp = rand(100000, 999999);
        $step1 = md5($otp);
        $step2 = strrev($step1);
        $step3 = md5($step2);
        $concealotp = strrev($step3);

        $timeNow = Time::now('Asia/Bangkok');
        $settime = $timeNow->addMinutes(+5);
        $timeEnd = $settime->toDateTimeString();

        if ($Status_reset == true) {
            $data = [
                'u_otp' => $concealotp,
                'otp_timer' => $timeNow,
                'end_timer' =>  $timeEnd,
            ];
            $to = $User_email;
            $email = \Config\Services::email();
            $email->setFrom('flashwork.co@gmail.com', 'flashwork');
            $email->setTo($to);
            $email->setSubject('ยืนยันรหัส OTP');
            $email->setMessage('รหัส OTP ของคุณคือ' . $otp);
            $email->send();
            $VerifyModel->update($id, $data);
        } elseif ($Status_reset == false) {
            $data = [
                'u_otp' => ""
            ];
            $VerifyModel->update($id, $data);
        } else {
            return $this->failNotFound("Reset err");
        }
    }
}

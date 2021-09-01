<?php

namespace App\Controllers\UserController\Register;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\VerifyModel;
use App\Models\User_model\EmployerModel;
use CodeIgniter\I18n\Time;

class Employerregistre extends ResourceController
{
    use ResponseTrait;

    public function register()
    {
        $VerifyModel = new VerifyModel();
        $EmployerModel = new EmployerModel();

        $User_id =  $this->request->getVar('User_id');
        $User_email = $this->request->getVar('User_email');
        $otp = $this->request->getVar('otp');
        $step1 = md5($otp);
        $step2 = strrev($step1);
        $step3 = md5($step2);
        $concealotp = strrev($step3);
        $chkpassword = $this->request->getVar('password');
        $password = md5($chkpassword);
        $firstname = $this->request->getVar('firstname');
        $lastname = $this->request->getVar('lastname');
        $chkotp = [
            'u_email' => $User_email,
            'u_otp' =>  $concealotp
        ];
        $req = [
            'em_username' => $User_id,
            'em_password' => $password,
            'em_fname' => $firstname,
            'em_lname' => $lastname,
            'em_email' => $User_email,
            'status' => 'Employer'
        ];

        $timeNow = Time::now('Asia/Bangkok');
        $timeNowToString = $timeNow->toDateTimeString();
        $timeNowToArray = [
            $timeNowToString
        ];

        $timeEnd = $VerifyModel->select('end_timer , u_email')->where('u_email', $User_email)->findColumn('end_timer');

        if ($timeNowToArray < $timeEnd) {
            if ($chkotp != null && $req != null) {
                $checkVerifyModel =  $VerifyModel->where($chkotp)->findAll();
                if (count($checkVerifyModel) > 0) {
                    $EmployerModel->insert($req);
                    if ($EmployerModel) {
                        $VerifyModel->find($User_email);
                        $VerifyModel->delete($User_email);
                        $response = [
                            'messages' => 'Register Success'
                        ];
                        return $this->respond($response);
                    } else {
                        $response = [
                            'messages' => 'Fail'
                        ];
                        return $this->respond($response);
                    }
                } else {
                    $response = [
                        'messages' => 'Register Fail'
                    ];
                    return $this->respond($response);
                }
            } else {
                $response = [
                    'messages' => 'Empty Data'
                ];
                return $this->respond($response);
            }
        }
        elseif ($timeNowToArray > $timeEnd) {
            $response = [
                'messages' => 'FAIL OVERTIME',
                'เวลาปัจจุบัน'=> $timeNow,
                'เวลาสิ้นสุด'=> $timeEnd

            ];
            return $this->respond($response);
        }
    }
}

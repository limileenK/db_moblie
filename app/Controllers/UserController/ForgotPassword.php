<?php

namespace App\Controllers\UserController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User_model\VerifyModel;
use App\Models\User_model\EmployerModel;
use App\Models\User_model\StudentModel;
use CodeIgniter\I18n\Time;

class ForgotPassword extends ResourceController
{
    use ResponseTrait;

    public function Forgot_Pass()
    {
        $VerifyModel = new VerifyModel();
        $EmployerModel = new EmployerModel();
        $StudentModel = new StudentModel();

        $User_email = $this->request->getVar('User_email');
        if ($User_email != null) {
            $otp = rand(100000, 999999);
            $step1 = md5($otp);
            $step2 = strrev($step1);
            $step3 = md5($step2);
            $concealotp = strrev($step3);

            $timeNow = Time::now('Asia/Bangkok');
            $settime = $timeNow->addMinutes(+15);
            $timeEnd = $settime->toDateTimeString();

            $checkStudentModel = $StudentModel->where('std_email', $User_email)->find();
            $checkEmployerModel = $EmployerModel->where('em_email', $User_email)->find();
            $checkVerifyModel =  $VerifyModel->where('u_email', $User_email)->find();

            $data = [
                'u_email' => $User_email,
                'u_otp' => $concealotp,
                'otp_timer' => $timeNow,
                'end_timer' =>  $timeEnd

            ];
            if (count($checkEmployerModel) != 0 && count($checkVerifyModel) == 0) {
                $VerifyModel->insert($data);
                if ($VerifyModel) {
                    $to = $User_email;
                    $email = \Config\Services::email();
                    $email->setFrom('flashwork.co@gmail.com', 'flashwork');
                    $email->setTo($to);
                    $email->setSubject('การขอเปลี่ยนรหัสผ่าน');
                    $email->setMessage('ลิงค์มีอายุใช้งาน 15 นาที กรุณายืนยันการขอเปลี่ยนรหัสผ่านตามลิงค์ด้านล่าง');
                    $email->setMessage('<a href="' . base_url() . '/public/resetlink/' . $concealotp . '">Click here to Reset Password</a><br><br>');
                    $email->send();
                    $response = [
                        'messages' => 'success'
                    ];
                    return $this->respond($response);
                } else {
                    return $this->failNotFound('send err');
                }
            } elseif (count($checkStudentModel) != 0 && count($checkVerifyModel) == 0) {
                $VerifyModel->insert($data);
                if ($VerifyModel) {
                    $to = $User_email;
                    $email = \Config\Services::email();
                    $email->setFrom('flashwork.co@gmail.com', 'flashwork');
                    $email->setTo($to);
                    $email->setSubject('การขอเปลี่ยนรหัสผ่าน');
                    $email->setMessage('ลิงค์มีอายุใช้งาน 15 นาที กรุณายืนยันการขอเปลี่ยนรหัสผ่านตามลิงค์ด้านล่าง');
                    $email->setMessage('<a href="' . base_url() . '/public/resetlink/' . $concealotp . '">Click here to Reset Password</a><br><br>');
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
                    $email->setSubject('การขอเปลี่ยนรหัสผ่าน');
                    $email->setMessage('ลิงค์มีอายุใช้งาน 15 นาที กรุณายืนยันการขอเปลี่ยนรหัสผ่านตามลิงค์<a href="' . base_url() . '/public/resetlink/' . $concealotp . '">Click here to Reset Password</a><br><br>');
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
                    'messages' => 'ERRR'
                ];
                return $this->respond($response);
            }
        } else {
            return $this->failNotFound('Empty Data');
        }
    }

    public function Resetlink($id = null)
    {
        $VerifyModel = new VerifyModel();

        $timeNow = Time::now('Asia/Bangkok');
        $timeNowToString = $timeNow->toDateTimeString();
        $timeNowToArray = [
            $timeNowToString
        ];

        $checkemail =  $VerifyModel->where('u_otp', $id)->findColumn('u_email');
        if (count(array($checkemail)) != 0) {
            $timeEnd = $VerifyModel->select('end_timer , u_email')->where('u_email', $checkemail)->findColumn('end_timer');
            if ($timeNowToArray <  $timeEnd) {
                return redirect()->to('http://localhost:3000/repassword/' . $checkemail[0] . '/' . $id);
            } else {
                return redirect()->to('http://localhost:3000/repassword/' .  'unknow' . '/' . 'unknow');
            }
        } else {
            return false;
        };
    }
    public function Resetpassword()
    {
        $VerifyModel = new VerifyModel();
        $EmployerModel = new EmployerModel();
        $StudentModel = new StudentModel();

        $User_email = $this->request->getVar('user');
        $uid = $this->request->getVar('id');
        $password = $this->request->getVar('password');
        $hidepassword = md5($password);

        if ($User_email != null && $uid != null && $password != null) {
            $whereverify = "u_email = '$User_email' AND u_otp='$uid'";
            $checkVerifyModel =  $VerifyModel->where($whereverify)->find();

            if (count($checkVerifyModel) != 0) {
                $checkStudentModel = $StudentModel->where('std_email', $User_email)->find();;
                $checkEmployerModel = $EmployerModel->where('em_email', $User_email)->find();;

                if (count($checkStudentModel) != 0) {
                    foreach ($checkStudentModel as $row) {

                        $data = [
                            'std_email' => $User_email,
                            'std_password' => $hidepassword,

                        ];
                        $StudentModel->update($row['std_id'], $data);
                        $VerifyModel->delete($User_email);

                        $response = [
                            'messages' => 'success'
                        ];
                        return $this->respond($response);
                    }
                } elseif (count($checkEmployerModel) != 0) {
                    foreach ($checkEmployerModel as $row) {

                        $data = [
                            'em_email' => $User_email,
                            'em_password' => $hidepassword,
                        ];
                        $EmployerModel->update($row['em_username'], $data);
                        $VerifyModel->delete($User_email);

                        $response = [
                            'messages' => 'success'
                        ];
                        return $this->respond($response);
                    }
                } else {
                    $response = [
                        'messages' => 'reseterr'
                    ];
                    return $this->respond($response);
                }
            }
        } else {
            $response = [
                'messages' => 'reseterr'
            ];
            return $this->respond($response);
        }
    }
}

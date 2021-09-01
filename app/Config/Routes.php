<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//------------------------------------register & Login----------------------------------------------

$routes->post('/Verifyregiste', 'UserController/Register/Verifyregiste::Verifyregistre');
$routes->put('/Verifyregiste/(:any)', 'UserController\Register\Verifyregiste::Resetotp/$1');
$routes->get('/selectmajor', 'UserController/Register/Studentregiste::Selectmajor');
$routes->post('/studentregistre', 'UserController/Register/Studentregiste::Register');
$routes->post('/employerregistre', 'UserController/Register/Employerregistre::Register');
$routes->post('/login_user', 'UserController/LoginController::Login');
$routes->post('/forgetpassword', 'UserController/ForgotPassword::Forgot_Pass');
$routes->get('/resetlink/(:any)', 'UserController\ForgotPassword::Resetlink/$1');
$routes->post('/resetpassword', 'UserController/ForgotPassword::Resetpassword');

//-------------------------------------Work--------------------------------------------------------

$routes->post('/postwork', 'WorkController/Postwork::Postwork');
$routes->get('/show_work', 'WorkController/ShowWork::ShowAllWork');
$routes->get('/PIC/(:any)', 'WorkController\ShowWork::showPIC/$1');
$routes->get('/show_workCount', 'WorkController/ShowWork::ShowWorkCount');
$routes->get('/detailpost/(:any)', 'WorkController\ShowWork::Selectbyid/$1');
$routes->get('/freepost/(:any)', 'WorkController\ShowWork::Selectfreebyid/$1');
$routes->get('/search/(:any)', 'UserController\SearchPost::searchWork/$1');
$routes->post('/insertcomment', 'WorkController/Insertcomment::addcomment');
$routes->get('/show_comment/(:any)','WorkController\Showcom::showcomment/$1');
$routes->get('/mypost/(:any)', 'WorkController\ShowWork::Mypost/$1');
$routes->delete('/deletemypost/(:any)', 'WorkController\ShowWork::DeleteMypost/$1');
$routes->put('/editpost/(:any)', 'WorkController\Postwork::EditPost/$1');
$routes->get('/getPackage/(:any)', 'WorkController\ShowWork::getPackage/$1');
$routes->delete('/deletePackage/(:any)', 'WorkController\ShowWork::deletePackage/$1');
$routes->get('/getPackagebyId/(:any)', 'WorkController\ShowWork::getPackagebyId/$1');
$routes->put('/editpackage/(:any)', 'WorkController\ShowWork::updatePack/$1');
$routes->post('/newpackage', 'WorkController/Postwork::insertPacks');
$routes->delete('/deletePhotos/(:any)', 'WorkController\Postwork::deletePhotos/$1');
$routes->post('/addphotos', 'WorkController/Postwork::addMorePhotos');
$routes->get('/reviewpost/(:any)', 'WorkController\ShowWork::Reviewbyid/$1');

//------------------------------------Admin-------------------------------------------

$routes->get('/showpostnotpass', 'AdminController/ManageWork/ManagePost::ShowPostNotpass');
$routes->get('/showpostwait', 'AdminController/ManageWork/ManagePost::ShowWait');
$routes->get('/showpostpass', 'AdminController/ManageWork/ManagePost::ShowPostPass');
$routes->put('/managestatus/(:any)', 'AdminController\ManageWork\ManagePost::ManagePost/$1');
$routes->get('/Checkpostbyid/(:any)', 'AdminController\ManageWork\ManagePost::Checkpost/$1');
$routes->get('/report', 'AdminController/ReportControll::showReport');
$routes->get('/readreport', 'AdminController/ReportControll::showreadReport');
$routes->put('/report/(:any)', 'AdminController\ReportControll::updateReport/$1');
$routes->get('/Managestudent', 'AdminController/Manageuser/Managemember::getStudent');
$routes->get('/Manageemployer', 'AdminController/Manageuser/Managemember::getEmployer');

//------------------------------------Admin cate------------------------------------------------------

$routes->get('/maincate', 'AdminController/Category/MainCategory::showCate');
$routes->get('/maincate/(:any)', 'AdminController\Category\MainCategory::showCatebyid/$1');
$routes->post('/maincate', 'AdminController/Category/MainCategory::addCategory');
$routes->put('/maincate/(:any)', 'AdminController\Category\MainCategory::editCate/$1');
$routes->get('/subcate', 'AdminController/Category/SubCategoryControl::showSub');
$routes->get('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::showSubcatebyid/$1');
$routes->post('/subcate', 'AdminController/Category/SubCategoryControl::addsubCategory');
$routes->put('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::editSubcate/$1');
$routes->delete('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::deleteSub/$1');
$routes->get('/subcateJoin', 'AdminController/Category/SubCategoryControl::showSubJoin');
$routes->get('/subcatebyid/(:any)', 'AdminController\Category\SubCategoryControl::subcatebyid/$1');
$routes->get('/showWorkbyMaincate/(:any)', 'AdminController\Category\MainCategory::showWorkbyMaincate/$1');
$routes->get('/showWorkbySubcate/(:any)', 'AdminController\Category\SubCategoryControl::showWorkbySubcate/$1');

//-------------------------------------usercontroll------------------------------

$routes->get('/getStudent/(:any)', 'UserController\Studentcontroller::getStudentData/$1');
$routes->put('/getStudent/(:any)', 'UserController\Studentcontroller::editProfileFree/$1');
$routes->put('/editimgfree/(:any)', 'UserController\Studentcontroller::addimgFree/$1');
$routes->get('/getEmp/(:any)', 'UserController\Employercontroller::getEmpData/$1');
$routes->put('/getEmp/(:any)', 'UserController\Employercontroller::editProfileEmp/$1');
$routes->put('/editimgemp/(:any)', 'UserController\Employercontroller::addimgEmp/$1');
$routes->get('/getHistory/(:any)', 'UserController\Studentcontroller::getHistoryFree/$1');
$routes->post('/report', 'UserController/ReportControll::addReport');
$routes->put('/changePassEmp/(:any)', 'UserController\Employercontroller::changePassEmp/$1');


//-----------------------------student------------------------------------------------------
$routes->get('/getStudent/(:any)', 'UserController\Studentcontroller::getStudentaccount/$1');
$routes->get('/getStudentwork/(:any)', 'UserController\Studentcontroller::getStudentwork/$1');
$routes->put('/changePass/(:any)', 'UserController\Studentcontroller::changePass/$1');

//-------------------------chat---------------------------------

$routes->post('/message', 'UserController/MessageController::sendmessage');
$routes->get('/showmessagebyid/(:any)', 'UserController\MessageController::showmessagebyid/$1');
$routes->put('/readmessage/(:any)', 'UserController\MessageController::readmessage/$1');
$routes->get('/notificationsmessage/(:any)', 'UserController\MessageController::notificationsmessage/$1');
$routes->get('/showallusermessage/(:any)', 'UserController\MessageController::showallusermessage/$1');
$routes->get('/showalluserandstatusmessage/(:any)', 'UserController\MessageController::showalluserandstatusmessage/$1');

//---------------------------------Employment Freeland------------------------------------------------------
$routes->post('/employment', 'WorkController/Employment::addEmployment');
$routes->get('/employmentFlReq/(:any)', 'WorkController\Employment::selectEmploymentForFl/$1');
$routes->get('/employmentFlProgress/(:any)', 'WorkController\Employment::selEmploymentForFltoProgress/$1');
$routes->get('/employmentFlSuc/(:any)', 'WorkController\Employment::selEmploymentForFltoSuccess/$1');

//---------------------------------Employment Employer------------------------------------------------------
$routes->get('/employmentEpyReq/(:any)', 'WorkController\Employment::selectEmploymentForEpy/$1');
$routes->get('/employmentEpyProgress/(:any)', 'WorkController\Employment::selectEmploymentForEpytoProgress/$1');
$routes->get('/employmentEpySuc/(:any)', 'WorkController\Employment::selEmploymentForEpytoSuccess/$1');
$routes->get('/employmentEpySucAndReview/(:any)', 'WorkController\Employment::selEmploymentForEpytoSuccessAndReview/$1');
$routes->put('/employmentEpyReq/(:any)', 'WorkController\Employment::acceptFromFl/$1');
$routes->put('/addreview/(:any)', 'WorkController\Employment::insertreview/$1');

$routes->delete('/deleteemploymentReq/(:any)', 'WorkController\Employment::deleteFromEpy/$1');
$routes->put('/employmentEpySuc/(:any)', 'WorkController\Employment::successFromEpy/$1');
$routes->get('/getHistoryEmp/(:any)', 'UserController\Employercontroller::getHistoryEmp/$1');
$routes->delete('/deleteemploymentfree/(:any)', 'WorkController\Employment::deleteemploymentFree/$1');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

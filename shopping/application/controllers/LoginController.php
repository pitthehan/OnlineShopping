<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Users.php';
//this controller is used to control login response and exit request
class LoginController extends BaseController
{

	public function loginAction()
	{
		$userModel =  new Users();
		
		$id = $this->getRequest()->getParam("id","");
		$pwd = $this->getRequest()->getParam("pwd","");
		
		$db = $userModel->getAdapter();
		$where = $db->quoteInto("id=?",$id).$db->quoteInto("AND pwd=?", md5($pwd));
	
		$loginuser = $userModel->fetchAll($where)->toArray();
		if (count($loginuser)==1) {
		    session_start();
		    //$loginuser is array[][], two-dimensional array
		    $_SESSION['loginuser'] = $loginuser[0];
		    $this->forward('gohallui','hall');
		} else {
		    $this->view->err = "<font color='red'>your name or password might be wrong</font>";
		    $this->forward('index','index');
		}
	}
    
	public function logoutAction()
	{
	    
	}

}

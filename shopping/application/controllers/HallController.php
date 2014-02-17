<?php
require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/Book.php';

class HallController extends BaseController
{

	public function gohalluiAction()
	{

 		$bookModel = new Book();
 		$this->view->books = $bookModel->fetchAll()->toArray();
		session_start();
		$this->view->loginuser = $_SESSION['loginuser'];
 		$this->render('hall');
	}


}

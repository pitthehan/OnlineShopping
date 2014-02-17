<?php 

require_once 'BaseController.php';
require_once APPLICATION_PATH.'/models/MyCart.php';

class ShoppingController extends BaseController
{

	public function addproductAction()
	{
		// obtain product id
		
	    $bookid = $this->getRequest()->getParam('bookid');
	    
	    $mycart = new MyCart();
	    session_start();
	    if ($mycart->addProduct($_SESSION['loginuser']['id'], $bookid)) {
	        $this->view->info = 'add successfully';
	        $this->view->gourl = '/hall/gohallui';
	        $this->_forward('ok','global');
	    } else {
	        $this->view->info = 'failed to add';
	        $this->_forward('err','global');
	    }
	}
	
	public  function delproductAction() 
	{
	    $id = $this->getRequest()->getParam('id');
	    $mycart = new MyCart();
	    session_start();
	    if ($mycart->delProduct($_SESSION['loginuser']['id'], $id)) {
	        $this->view->info = 'delete successfully from mycart';
	        $this->view->gourl = '/shopping/showcart';
	        $this->_forward('ok','global');
	    } else {
	        $this->view->info = 'failed to delete from mycart';
	        $this->_forward('err','global');
	    }
	}
	
	public function updatecartAction() 
	{   
	    $bookids=$this->getRequest()->getParam('bookids');
	    $booknums=$this->getRequest()->getParam('booknums');
	    
        $mycart = new MyCart();
        session_start();
        $userId = $_SESSION['loginuser']['id'];
	    for($i=0;$i<count($bookids);$i++) {
	        //echo $bookids[$i].'--'.$booknums[$i].'<br/>';
	        $mycart->updateProduct($userId, $bookids[$i], $booknums[$i]);
	    }
	    $this->view->info = 'update successfully';
	    $this->view->gourl = '/shopping/showcart';
	    $this->_forward('ok','global');
	}
	
	public function showcartAction() 
	{    
	    $mycart = new MyCart();
	    session_start();
	    $this->view->books = $mycart->showMyCart($_SESSION['loginuser']['id']);
	    $this->view->total_price = $mycart->total_price;
	    $this->render('mycart');
	}
       

}


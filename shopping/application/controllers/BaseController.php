<?php
class BaseController extends Zend_Controller_Action
{
	public function init()
	{
		$url = constant ( "APPLICATION_PATH" ) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'application.ini';
		$dbconfig = new Zend_Config_Ini ( $url, "mysql" );
		$db = Zend_Db::factory ( $dbconfig->db );
		$db->query ( 'SET NAMES UTF8' );
		Zend_Db_Table::setDefaultAdapter ( $db );
	}
}
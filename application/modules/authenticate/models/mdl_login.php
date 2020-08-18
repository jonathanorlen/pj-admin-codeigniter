<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_login extends MY_Model {

	public function login($param='')
	{
		$password = paramEncrypt($param['login-password']);
		$where = array('uname' => $param['login-email'],'upass' => $password);
		$query = $this->find('master_user', $where , $field = NULL, $limit = NULL, $orderby = NULL, $join = FALSE, $like = FALSE);
		if($query==NULL){
			$data=FALSE;
		} else {
			$data = $query->result();
		}
		return $data;
	}

}

/* End of file mdl_login.php */
/* Location: ./application/modules/cashier/models/mdl_login.php */
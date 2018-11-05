<?php

class Company extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//회원등록시 필요한 업체의 정보를 가져온다.
	public function allCompanyNameId(){
		$this->db->trans_start();
	
		$array = array('stat = ' => 2, 'cogubun = ' => 1);

		$this->db->select('id, coname')->from('company')->where($array)->order_by("stat desc, coname asc");
		$obj = $this->db->get()->result();
		
		$this->db->trans_complete();
		
		return $obj;
	}
	
	//업체 가입을 승인 한다.
	public function comOk($mid){
		$this->db->trans_start();
	
		$data = array(
               'stat' => 2
            );

		$this->db->where('id', $mid);
		$this->db->update('company', $data); 
	
		$this->db->trans_complete();
	}
	
	//업체 가입승인을 보류 한다.
	public function comNo($mid){
	
		$this->db->trans_start();
	
		$data = array(
               'stat' => 3
            );

		$this->db->where('id', $mid);
		$this->db->update('company', $data); 
	
		$this->db->trans_complete();
	
	}
	
	
	//모든 업체의 정보를 가져온다.
	public function allcompany(){
	
		$this->db->trans_start();
	
		$this->db->select('*')->from('company')->order_by("stat asc, coname asc");
		$obj = $this->db->get()->result();
		
		$this->db->trans_complete();
		
		return $obj;
	
	}
	
}


?>

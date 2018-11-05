<?php

class Jumun extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//나의 주문내역을 가져온다.
	public function myJumunList($email){
	
		$this->db->select('*')->from('jumun')->where("email", $email)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	
	//전체 간단문의 내역을 가져온다.
	public function myjumun($email){
	
		$this->db->select('*')->from('gandanQ')->where("email", $email)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}

	//전체 주문내역을 가져온다.
	public function alljumun(){
	
		$this->db->select('*')->from('jumun')->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	

	//주문등록 
	public function jumunonput($data, $datamd){
	
		if($datamd["idmd"] == "on"){
		
			$this->db->trans_start();
	
			$this->db->insert('jumun', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
		
		}else{
		
				$this->db->trans_start();
		
				$this->db->where('id', $datamd["idgab"])->limit(1);
				$this->db->update('jumun', $data); 
				$rowid = $datamd["idgab"];
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
		
		}
	
		return $rowid;
	
	}

	
	

	//간단문이 등록 
	public function munonput($data, $datamd){
	
		if($datamd["idmd"] == "on"){
		
			$this->db->trans_start();
	
			$this->db->insert('gandanQ', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
		
		}else{
		
				$this->db->trans_start();
		
				$this->db->where('id', $datamd["idgab"])->limit(1);
				$this->db->update('gandanQ', $data); 
				$rowid = $datamd["idgab"];
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
		
		}
	
		return $rowid;
	
	}





	
}


?>

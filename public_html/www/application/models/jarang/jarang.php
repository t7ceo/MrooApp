<?php

class Jarang extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	
		//전체 주문내역을 가져온다.
	public function getAllJrDet($jid){
	
		$this->db->select('*')->from('myjarangDet')->where("idgab", $jid)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}


	//간단문이 등록 
	public function jronput($data, $datamd){
	
		if($datamd["idmd"] == "on"){
		
			$this->db->trans_start();
	
			$this->db->insert('myjarangDet', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
		
		}else{
		
				$this->db->trans_start();
		
				$this->db->where('id', $datamd["idgab"])->limit(1);
				$this->db->update('myjarangDet', $data); 
				$rowid = $datamd["idgab"];
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
		
		}
	
		return $rowid;
	
	}


	
	
	//노래자랑 좋아요 숫자
	public function likesu($rid){
	
			//앨범에 사전등록여부를 확인
			$wh = array("rid" => $rid);
			$this->db->select('count(rid) as su')->from('myjarangLike')->where($wh);
			$obj = $this->db->get()->row();
			
			return $obj;
	
	}
	
	//노래자랑 좋아요 추가 
	public function likeon($rid, $email){
	
			//앨범에 사전등록여부를 확인
			$wh = array("rid" => $rid, "email" => $email);
			$this->db->select('count(rid) as su')->from('myjarangLike')->where($wh);
			$obj = $this->db->get()->row();
			
			if($obj->su < 1){
				
				$this->db->trans_start();
				$sday = date("Y-m-d H:i:s", time());
				//다운로드 준비 레코드를 만들어 둔다.
				$idata = array("rid"=>$rid, "email"=>$email, "onday"=>$sday);
				$this->db->insert('myjarangLike', $idata); 					
				
					$this->db->trans_complete();		
					if ($this->db->trans_status() === FALSE)
					{
						//$rr = 0;
					}
			
			}
			
			$su = $this->likesu($rid);
			
			return $su->su;

	
	}
	

}

?>

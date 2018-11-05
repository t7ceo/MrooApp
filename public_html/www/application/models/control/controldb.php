<?php

class Controldb extends CI_Model{
	function __construct(){
		parent::__construct();
	}


	//==================================
	//업체의 회원 리스트를 가져온다.
	//===================================
	public function comemListAll($coid){

		$this->db->trans_start();
		
		$this->db->select('*')->from('member');
		$this->db->where('coid = '.$coid);
		$rt = $this->db->get()->result();
		foreach($rt as $rtrow){
			//레코드의 갯수를 구한다.
			$this->db->select('count(memid) as su')->from('memberAct')->where('memid', $rtrow->memid);
			$subrt = $this->db->get()->row();
			
			$rtrow->adminsu = $subrt->su;
		}
		
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;  //수정 실패 이다.
		}
		
		return $rt;
	
	}	
	//==================================
	//관리자 리스트를 가져온다.
	//===================================
	public function adminListAll(){

		$this->db->trans_start();
		
		$this->db->select('b.*, a.id as actid, a.actgubun, a.actonday')->from('memberAct as a left join member as b on(a.memid = b.memid)');
		$this->db->where('b.cogubun = 3 and b.potion >= 4');
		$rt = $this->db->get()->result();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;  //수정 실패 이다.
		}
		
		return $rt;
	
	}
	//==========================================
	//배너리스트를 가져온다.
	//==========================================
	public function getBannerAll(){
	
		$this->db->select('*')->from('banner');
		$rt = $this->db->get()->result();
		$this->db->trans_complete();			
		if ($this->db->trans_status() === FALSE)
		{
				$rt = 0;
		}else{
		
		
		}
	
		return $rt;
	}
	//==========================================
	//배너를 등록한다.
	//==========================================
	public function bannerOnput($md, $arr, $id){
	
		$this->db->trans_start();
		
		if($md == "insert"){
			$this->db->insert('banner', $arr); 
			$rowid = $this->db->insert_id(); 
		}else{
			$this->db->where('id', $id);
			$this->db->update('banner', $arr); 
			$rowid =  $id;
		}

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;	
	}
	//==========================================
	//배너의 내용을 가져온다.
	//==========================================	
	public function getBanner($rid){
	
		$this->db->select('*')->from('banner')->where('id',$rid);
		return $this->db->get()->row();	
	}
	//==========================================
	//
	//==========================================	
	
	

	//게시판을 삭제 한다.
	public function delBorderRec($did){
		
		$array = array('bdid = ' => $did);
		$this->db->select('*')->from('fborder')->where($array);
		$su = $this->db->get()->result();
		if(count($su) < 1){
			
			$this->db->trans_start();
			
			$this->db->delete('mkborder', array('id' => $did)); 
			
			
			
			$this->db->trans_complete();			
			if ($this->db->trans_status() === FALSE)
			{
				$did = 0;
			}
			
		}else{
		
			$did = "not";
		
		}

		return $did;
	}
	


	
}


?>

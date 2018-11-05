<?php

class Notice extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	//모든 공지를 가져온다.
	public function allgongji(){
	
		$this->db->select('*')->from('mrGongji')->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}

	//모든 공지를 가져온다.
	public function allFaq($gubun){
	
		if($gubun == 1){
			$this->db->select('*')->from('mrFaq')->where("gubun > ", 0)->order_by("id","desc");
		}else{
			$this->db->select('*')->from('mrFaq')->where("gubun = ", $gubun)->order_by("id","desc");
		}
		
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}


	//메일 수진자를 가져온다.
	public function getMailSusin($mid){
		$ss = "select b.id, b.name, a.email from mailSusin as a left join member as b on(a.susinMem = b.memid) where a.messid = ".$mid." ";
		$row = $this->db->query($ss)->result();

		return $row;
	}


	
	//메시지 수진잘 리스트
	public function getMessSusin($mid){
		$ss = "select b.id, b.name from messSusin as a left join member as b on(a.susinMem = b.memid) where a.messid = ".$mid." ";
		$row = $this->db->query($ss)->result();

		return $row;
	}



	//알림을 삭제 한다.
	public function notiRecDel($md, $did){
		$this->db->trans_start();
		
		switch($md){
		case 1:
			//$this->db->delete('messList', array('id' => $did)); 
			$this->db->delete('messSusin', array('messid' => $did, 'susinMem' => $this->session->userdata('memid'))); 
		break;
		case 2:
			//$this->db->delete('mailList', array('id' => $did)); 
			$this->db->delete('mailSusin', array('messid' => $did, 'susinMem' => $this->session->userdata('memid'))); 
		break;
		case 3:
			//$this->db->delete('pushList', array('id' => $did)); 
			$this->db->delete('pushSusin', array('messid' => $did, 'susinMem' => $this->session->userdata('memid'))); 
		break;
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$did = 0;
		}
		return $did;
	
	}


	//푸쉬 상세보기 가져온다.
	public function getSeMail($mrid){
	
		$array = array('id = ' => $mrid);
		$this->db->select('*')->from('mailList')->where($array);
		return $this->db->get()->row();
	}	

	//푸쉬 상세보기 가져온다.
	public function getSePush($mrid){
	
		$array = array('id = ' => $mrid);
		$this->db->select('*')->from('pushList')->where($array);
		return $this->db->get()->row();
	}


	//메시지 상세보기 가져온다.
	public function getSeMess($mrid){
	
		$array = array('id = ' => $mrid);
		$this->db->select('*')->from('messList')->where($array);
		return $this->db->get()->row();
	}
	
	public function getAllMail($mm){
	
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (content like "%'.$fndg.'%" or tit like "%'.$fndg.'%") ';
			break;
			}
		}
		
		$array = array('susinMem = ' => $mm['memid']);
		$this->db->select('messid')->from('mailSusin')->where($array)->order_by("messid desc");
		$obj = $this->db->get()->row();
		
		$ii = 0;
		foreach($obj as $row){
			
			$ss = "select * from mailList where id = ".$row->messid." ".$findTxt." ";
			$rtt = $this->db->query($ss)->row();
			if(count($rtt) > 0){
				$rr[$ii++] = array("id"=>$rtt->id, "wr"=>$rtt->wrMemid, "txt"=>$rtt->content, "tit"=>$rtt->tit, "day"=>$rtt->onday);
			}

		}
		if($ii == 0) $rr = 0;
		
		return $rr;
	
	}
	
	
	
	
	public function getAllMess($mm){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (content like "%'.$fndg.'%" or tit like "%'.$fndg.'%") ';
			break;
			}
		}
		
	
		$array = array('susinMem = ' => $mm['memid']);
		$this->db->select('messid')->from('messSusin')->where($array)->order_by("messid desc");
		$obj = $this->db->get()->result();
		
		$ii = 0;
		foreach($obj as $row){
			
			$ss = "select * from messList where id = ".$row->messid." ".$findTxt." ";
			$rtt = $this->db->query($ss)->row();
			if(count($rtt) > 0){
				$rr[$ii++] = array("id"=>$rtt->id, "wr"=>$rtt->wrMemid, "txt"=>$rtt->content, "tit"=>$rtt->tit, "day"=>$rtt->onday);
			}

		}
		if($ii == 0) $rr = 0;
		
		return $rr;
	
	}
	
	
	//배열을 리턴한다.
	public function getAllPush($mm){
	
		$array = array('susinMem = ' => $mm['memid']);
		$this->db->select('messid')->from('pushSusin')->where($array)->order_by("messid desc");
		$obj = $this->db->get()->result();
		
		$ii = 0;
		foreach($obj as $row){
			$array2 = array('id = ' => $row->messid);
			$this->db->select('*')->from('pushList')->where($array2);
			$rtt = $this->db->get()->row();
			$rr[$ii++] = array("id"=>$rtt->id, "wr"=>$rtt->wrMemid, "linkp"=>$rtt->plink, "txt"=>$rtt->content, "tit"=>$rtt->tit, "day"=>$rtt->onday);
		}
		if($ii == 0) $rr = 0;
		
		return $rr;
	
	}
	

	
	//푸쉬메시지를 저장한다.
	public function setMessMail($mem, $data){
		$ad_date = date("Y-m-d H:i:s");
		
				$this->db->trans_start();
	
		$mm = array("wrMemid" => $data['wrmem'], "content"=> $data['txt'], "tit"=> $data['tit'], "onday"=>$ad_date);
		$this->db->insert('mailList', $mm); 
		$rowid = $this->db->insert_id();

		//echo "mmmm=".count($mem)."///".$mem[0]['memid']."///".$mem[1]['memid'];
		$su = count($mem);
		for($c = 0; $c < $su; $c++){
			//if($su == 1) $kk = $mem[$c];
			//else $kk = $mem[$c];
			
			$mm2 = array("messid" => $rowid, "susinMem"=> $mem[$c]['memid'], "email"=>$mem[$c]['email']);
			$this->db->insert('mailSusin', $mm2); 
		}

				$this->db->trans_complete();
	
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;
				}
		
				return $rowid;
	}
	
	
	
	//푸쉬메시지를 저장한다.
	public function setMessPush($mem, $data){
		$ad_date = date("Y-m-d H:i:s");
		
				$this->db->trans_start();
	
		$mm = array("wrMemid" => $data['wrmem'], "plink"=> $data['link'], "content"=> $data['txt'], "tit"=> $data['tit'], "onday"=>$ad_date);
		$this->db->insert('pushList', $mm); 
		$rowid = $this->db->insert_id();

		//echo "mmmm=".count($mem)."///".$mem[0]['memid']."///".$mem[1]['memid'];
		$su = count($mem);
		for($c = 0; $c < $su; $c++){
			//if($su == 1) $kk = $mem[$c];
			//else $kk = $mem[$c];
			
			$mm2 = array("messid" => $rowid, "susinMem"=> $mem[$c]['memid']);
			$this->db->insert('pushSusin', $mm2); 
		}

				$this->db->trans_complete();
	
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;
				}
		
				return $rowid;
	}
	
	
	
	
	public function setMess($mem, $data){
		$ad_date = date("Y-m-d H:i:s");
		
				$this->db->trans_start();
	
		$mm = array("wrMemid" => $data['wrmem'], "content"=> $data['txt'], "tit"=> $data['tit'], "onday"=>$ad_date);
		$this->db->insert('messList', $mm); 
		$rowid = $this->db->insert_id();

		//echo "mmmm=".count($mem)."///".$mem[0]['memid']."///".$mem[1]['memid'];
		$su = count($mem);
		for($c = 0; $c < $su; $c++){
			//if($su == 1) $kk = $mem[$c];
			//else $kk = $mem[$c];
			
			$mm2 = array("messid" => $rowid, "susinMem"=> $mem[$c]['memid']);
			$this->db->insert('messSusin', $mm2); 
		}

				$this->db->trans_complete();
	
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;
				}
		
				return $rowid;
	}

	
}


?>

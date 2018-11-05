<?php

class Communitybd extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	
	//게시판 이미지의 정보를 가져온다.
	public function getFborderInfo($tb, $id){
		$ss = "select * from ".$tb." where id = ".$id." ";
		$row = $this->db->query($ss)->row();
		
		return $row;
	}
	
	
	

	
	//댓글을 삭제한다.
	public function delDet($did){
	
		$this->db->trans_start();
		
		$this->db->delete('gongjiDet', array('id' => $did)); 
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$did = 0;
		}
		
		return $did;
	
	}
	
	
	//모든 댓글 
	public function getDet($gid, $md){
	
		$ss = 'select a.id, a.md, a.gid, a.det, a.wmemid, a.onday, b.name, b.coname from gongjiDet as a left join member as b on(a.wmemid = b.memid) where gid = '.$gid.' and md = '.$md.' order by onday desc';
		$row = $this->db->query($ss)->result();
	
		
		return $row;
	
	}
	
	
	
	//댓글을 단다.
	public function onputDet($dat){
	
	
		$this->db->trans_start();
		
			$this->db->insert('gongjiDet', $dat); 
			$rowid = $this->db->insert_id(); 

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	
	}
	
	
	//질문을 가져온다.
	public function getFaqBd($gid){
	
		$array = array('id = ' => $gid);

		$this->db->select('*')->from('mrFaqBd')->where($array);
		$obj = $this->db->get()->result();
		//$obj[0]->bdtit = "kkkkkk";
		
		return $obj;
	
	
	}	
	
	//Faq를 가져온다.
	public function getFaq($gid){
	
		$array = array('id = ' => $gid);

		$this->db->select('*')->from('mrFaq')->where($array);
		$obj = $this->db->get()->result();
		//$obj[0]->bdtit = "kkkkkk";
		
		return $obj;
	
	
	}	
	
	//공지사항을 가져온다.
	public function getGongji($gid){
	
		$array = array('id = ' => $gid);

		$this->db->select('*')->from('mrGongji')->where($array);
		$obj = $this->db->get()->result();
		//$obj[0]->bdtit = "kkkkkk";
		
		return $obj;
	
	
	}
	
	//본사 공지사항을 가져온다.
	public function getView($md, $gid){
	
		$array = array('id = ' => $gid);
		
		if($md == 1) $tb = "mrGongji";
		else if($md == 2) $tb = "mrFaq";
		else $tb = "mrFaqBd";
		
		$this->db->select('*')->from($tb)->where($array);

		$obj = $this->db->get()->result();
		//$obj[0]->bdtit = "kkkkkk";
		
		return $obj;
	
	}
	
	
	public function delEvent($md, $did){
	
		if($md == 2){
			$tb = "mrFaq";
		}else if($md == 1){
			$tb = "mrGongji";
		}else{
			$tb = "mrFaqBd";
		}
	
		$ss = 'select * from '.$tb.' where id = '.$did.' limit 1 ';
		$row = $this->db->query($ss)->row();
					
		$this->db->trans_start();
		$this->db->delete($tb, array('id' => $did)); 
		
		
		
		$ss2 = 'select fnam from addfilelist where tb = "'.$tb.'" and recid = '.$did.' ';
		$row2 = $this->db->query($ss2)->result();
		
		foreach($row2 as $drow){
			$del_img = FILEUP.$drow->fnam;
			unlink($del_img);
		}
		
		
		$this->db->trans_complete();
		
		return $did;
	
	}
	
	
		//게시판을 가져온다.
	public function getBorder($gid){
	
		$array = array('id = ' => $gid);

		$this->db->select('*')->from('fborder')->where($array);
		$obj = $this->db->get()->result();
		//$obj[0]->bdtit = "kkkkkk";
		
		return $obj;
	
	
	}

	
	//faq 리스트를 가져온다.
	public function faqbdList($gb, $page = 0, $pagePerNum = 10){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				//$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		$sql = "select * from mrFaqBd where ";
		$sql .= " stat = 1 ";
		$sql .= " and gubun = ".$gb." ";
		$sql .= $findTxt;

		//$sql .= " order by onday desc";
		$sql .= " order by gongji desc, onday desc limit ".$page.",".$pagePerNum;
		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}
	
	//faq 리스트를 가져온다.
	public function faqList($gb, $page = 0, $pagePerNum = 10){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				//$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		$sql = "select * from mrFaq where ";
		$sql .= " stat = 1 ";
		$sql .= " and gubun = ".$gb." ";
		$sql .= $findTxt;

		//$sql .= " order by onday desc";
		$sql .= " order by gongji desc, onday desc limit ".$page.",".$pagePerNum;
		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}
	
	//공지 리스트를 가져온다.
	public function gongjiList($gb, $page = 0, $pagePerNum = 10){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		$sql = "select a.*, b.name from mrGongji as a left join member as b on(a.wrMemid = b.memid) where ";
		$sql .= " a.stat = 1";
		$sql .= " and a.gubun = ".$gb." ";
		$sql .= $findTxt;
		

		//$sql .= " order by onday desc";
		$sql .= " order by a.gongji desc, a.onday desc limit ".$page.",".$pagePerNum;
		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}

	public function faqbdTotalCount($gb, $page = 0, $pagePerNum = 10){
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
				$findTxt = ' and (tit like "%'.$fndg.'%" or content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				//$findTxt = ' and (name like "%'.$fndg.'%" or wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		
		$sql = "select * from mrFaqBd where ";
		$sql .= " stat = 1";
		$sql .= " and gubun = ".$gb."";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;
		
	}
	
	public function faqTotalCount($gb, $page = 0, $pagePerNum = 10){
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
				$findTxt = ' and (tit like "%'.$fndg.'%" or content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				//$findTxt = ' and (name like "%'.$fndg.'%" or wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		
		$sql = "select * from mrFaq where ";
		$sql .= " stat = 1";
		$sql .= " and gubun = ".$gb."";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;
		
	}
		
	public function gongjiTotalCount($gb, $page = 0, $pagePerNum = 10){
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		

		$sql = "select a.*, b.name from mrGongji as a left join member as b on(a.wrMemid = b.memid) where ";
		$sql .= " a.stat = '1'";
		$sql .= " and a.gubun = '".$gb."'";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}
	
	//자유게시판 리스트를 가져온다.
	public function borderList($gb, $page = 0, $pagePerNum = 10){
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		//$gb: 1-본사공지 , 2-조합 공지

		
		$sql = "select a.*, b.name from fborder as a left join member as b on(a.wrMemid = b.memid) where ";
		$sql .= " a.stat = '1'";
		$sql .= " and a.gubun = '".$gb."' and a.bdid = ".$this->session->userdata('bdid')." ";
		$sql .= $findTxt;


		$sql .= " order by a.gongji desc, a.onday desc limit ".$page.",".$pagePerNum;
		//$sql .= " order by onday desc";
		$obj = $this->db->query($sql)->result();

		return $obj;

	}

	public function borderTotalCount($gb, $page = 0, $pagePerNum = 10){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		
		
		//$gb: 1-본사공지 , 2-조합 공지

		
		$sql = "select a.*, b.name from fborder as a left join member as b on(a.wrMemid = b.memid) where ";
		$sql .= " a.stat = '1'";
		$sql .= " and a.gubun = '".$gb."' and a.bdid = ".$this->session->userdata('bdid')." ";
		$sql .= $findTxt;
		
		$obj = $this->db->query($sql)->result();

		return $obj;

	}
	
	
	//생성한게시판리스트
	public function allBoard($gb, $bid = 0){
		//echo $this->session->userdata('cogubun')."/";
		if($this->session->userdata('cogubun') == 3){
			$sql = "select * from mkborder where stat = 1 and gubun = ".$gb." and cogubunWR <= 3 ";
		}else{
			$sql = "select * from mkborder where stat = 1 and gubun = ".$gb." and cogubunWR = 1 ";
		}
		
		if($bid == 0) $sql .= ""; //$array = array('stat = ' => 1, 'gubun = ' => $gb, 'cogubunWR = ' => $cgb);
		else $sql .= " and id = ".$bid." "; //$array = array('stat = ' => 1, 'gubun = ' => $gb, 'id = ' => $bid, 'cogubunWR = ' => $cgb);

		//$this->db->select('*')->from('mkborder')->where($array)->order_by("bdtit asc");
		$obj = $this->db->query($sql)->result();

		
		return $obj;
	
	
	}
	
	
	
	
	//공지사항을 작성한다.
	public function ongongji($md, $arr){
	
	
		$this->db->trans_start();
		
		if($md == "insert"){
			$this->db->insert('mrGongji', $arr); 
			$rowid = $this->db->insert_id(); 
		}else{
			$this->db->where('id', $arr['id']);
			$this->db->update('mrGongji', $arr); 
			$rowid =  $arr['id'];
		}

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	}

	
	//공지사항을 작성한다.
	public function onFAQ($md, $arr){
	
	
		$this->db->trans_start();
		
		if($md == "insert"){
			$this->db->insert('mrFaq', $arr); 
			$rowid = $this->db->insert_id(); 
		}else{
			$this->db->where('id', $arr['id']);
			$this->db->update('mrFaq', $arr); 
			$rowid =  $arr['id'];
		}

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	}

	//질문을 작성한다.
	public function onFAQBd($md, $arr){
	
	
		$this->db->trans_start();
		
		if($md == "insert"){
			$this->db->insert('mrFaqBd', $arr); 
			$rowid = $this->db->insert_id(); 
		}else{
			$this->db->where('id', $arr['id']);
			$this->db->update('mrFaqBd', $arr); 
			$rowid =  $arr['id'];
		}

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	}


	
	//자유게시판을 등록한다.
	public function onfreebd($arr, $tt){
	
		$this->db->trans_start();
		if($tt['type'] == "insert"){
			$this->db->insert('fborder', $arr); 
			$rowid = $this->db->insert_id(); 
			
		}else{
			$this->db->where('id', $tt['id']);
			$this->db->update('fborder', $arr); 
			$rowid = $tt['id'];
			
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

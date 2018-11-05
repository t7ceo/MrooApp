<?php

class Statisdb extends CI_Model{
	function __construct(){
		parent::__construct();
	}


//================================
//회원가입 통계
//================================
public function memberAnz(){

	$this->db->group_by("stat");
	$this->db->order_by("stat");
	$this->db->select("count(memid) as su, stat");
	$this->db->from("member");
	
	return $this->db->get()->result();

}
//================================
//상품별 판매내역 - 이용권 구매통계
//================================
public function gumeAnz($gb){

	$this->db->where("stat", 1);
	$this->db->where("gubun", $gb);
	$this->db->select("*");	
	$this->db->from("mrSangpum");
	$imsi = $this->db->get()->result();
	foreach($imsi as $row){
		$this->db->where("sangpumid", $row->sangpumid);
		$this->db->select("count(sangpumid) as su");
		$this->db->from("cupon");
		$imsi2 = $this->db->get()->row();
		
		$row->su = $imsi2->su;
	}

	return $imsi;

}
//================================
//사용 통계
//스트리밍 통계와 다운로드 통계로 구분한다.
//================================
public function mechulAnz($gb, $songid = "*"){

		if($songid == "*"){
			$this->db->where("songid <> ''");
		}else{
			$this->db->where("songid = '".$songid."'");
		}
		
	switch($gb){
	case "st":   //스트리밍 통계 
		$this->db->select("count(songid) as su");	
		
		$this->db->from("mrStreaming");
	break;
	case "down":    //다운로드 통계
		$this->db->select("count(songid) as su");
		$this->db->from("mrDownmp");	
	break;
	}
	

	return $this->db->get()->row();

}
//================================
//
//================================
	public function statisTotalCount($gb, $page = 0, $pagePerNum = 10){
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "tit":
				//$findTxt = ' and a.tit like "%'.$fndg.'%" ';
			break;
			case "content":
				//$findTxt = ' and (a.tit like "%'.$fndg.'%" or a.content like "%'.$fndg.'%" ) ';
			break;
			case "wr":
				//$findTxt = ' and (b.name like "%'.$fndg.'%" or a.wrMemid like "%'.$fndg.'%" ) ';
			break;
			}
		}
		$findTxt = "";
		
		

		$sql = "select a.*, b.name from mrDownmp as a left join member as b on(a.email = b.email) where ";
		$sql .= " a.stat = '1'";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}
//================================
//
//================================
	public function statisAll(){
	
		$this->db->select('*')->from('mrDownmp');
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}

//================================
//
//================================





//================================
//
//================================





//================================
//
//================================
	
}


?>

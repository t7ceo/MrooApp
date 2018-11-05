<?php

class Noreanzdb extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function noreanzTotalCount($gb, $page = 0, $pagePerNum = 10){
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
		
		

		$sql = "select a.*, b.name from myjarang as a left join member as b on(a.onemail = b.email) where ";
		$sql .= " a.stat = '1'";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}

	public function jarangAll(){
	
		$this->db->select('a.*, b.name, b.nicname')->from('myjarang as a left join member as b on(a.onemail = b.email)');
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}
	
}


?>

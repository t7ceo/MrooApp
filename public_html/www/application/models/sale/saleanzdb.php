<?php

class Saleanzdb extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function saleanzTotalCount($gb, $page = 0, $pagePerNum = 10){
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
		
		

		$sql = "select * from mrDownmp where ";
		$sql .= " stat = '1'";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}

	public function saleAll(){
	
		$this->db->select('*')->from('mrDownmp');
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}
	
}


?>

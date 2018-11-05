<?php

class Orderdb extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function orderTotalCount($gb, $page = 0, $pagePerNum = 10){
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
		
		

		$sql = "select a.*, b.name from jumun as a left join member as b on(a.email = b.email) where ";
		$sql .= " a.stat = '1'";
		$sql .= $findTxt;

		//echo $sql;
		$obj = $this->db->query($sql)->result();
		
		return $obj;

	}

	public function orderAll(){
	
		$this->db->select('*')->from('jumun');
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}
	
}


?>

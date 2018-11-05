<?php

class Commondb extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	//===============================
	//DB에 특정 레코드를 추가한다.
	//===============================
	public function addRecodTb($mode, $tb, $val){

		$this->db->trans_start();
		switch($mode){
		case "gasuup":
			//가수의 존재여부를 확인한다.
			$this->db->where("gasu = '".$val['gasu']."'");
			$this->db->select("count(gasu) as su, id, gasu, fdir")->from($tb);
			$rrr = $this->db->get()->row();
			
			if($rrr->su > 0){
				return array("rs"=>"ok", "fdir"=>$rrr->fdir);
			}else{
			
				//가수의 폴더 생성
				$fdir = "f".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			
				$val['fdir'] = $fdir; 
				$this->db->insert($tb, $val); 
			
				$rowid = "ok";
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = "no";
				}else{
					if(!is_dir("../mrphp/music/1se/".$fdir)){
						mkdir("../mrphp/music/1se/".$fdir);
						mkdir("../mrphp/music/2se/".$fdir);
						mkdir("../mrphp/music/3se/".$fdir);
						mkdir("../mrphp/music/4se/".$fdir);
					}else{
						$ww = $fdir;
						$this->db->where("fdir", $ww);
						$this->from($tb);
						$fdir = "a".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
						$this->update("fdir",$fdir);
						
						mkdir("../mrphp/music/1se/".$fdir);
						mkdir("../mrphp/music/2se/".$fdir);
						mkdir("../mrphp/music/3se/".$fdir);
						mkdir("../mrphp/music/4se/".$fdir);
					}
				}
			
				return array("rs"=>$rowid, "fdir"=>$fdir);
			
			}
		
		break;
		}
				
	}	
	//===============================
	//특정레코드의 자료를 삭제한다.
	//===============================
	public function recodeDel($tb, $rid){

		$this->db->trans_start();
				
		$this->db->where('id', $rid);
		$this->db->delete($tb); 
				
		$rowid = $rid;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}
				
		return $rowid;
	}	
	//===============================
	//파일만 삭제+++++++
	//===============================
	public function fileDelOnly($gubun, $fnam){
				
				$rowid = 0;
				//파일 삭제
				if($gubun == "photoon"){
					unlink(PREDIR0."/images/scene/".$fnam);
					unlink(PREDIR0."/images/scene/thumb/s_".$fnam);
					
					$rowid = 1;
					
				}else if($gubun == "banner"){
					unlink(BANNERFILE.$fnam);
					
					$rowid = 1;
				
				}else{
					unlink(FILEUP.$fnam);
					
					$rowid = 1;
				}
				
		return $rowid;
	}	
	//===============================
	//파일과 레코드 삭제+++++++
	//===============================
	public function fileDel($gubun, $recid, $num, $md, $md2, $md3){
	
		$tb = "addfilelist";
		switch($gubun){
		case "banner":
			$tb = getDBTableName($gubun, $md3);
			$fnam = "img";
		break;
		case "community":
			$fnam = "fnam";
		break;
		case "saup":
			$fnam = "fnam";
		break;
		case "gongsa":
			$fnam = "fnam";
		break;
		case "photoon":
			$tb = "sceneImg";
			$fnam = "imgname";
		break;
		}

				//파일 이름을 가져온다.
				$ss = "select ".$fnam." from ".$tb." where id = ".$recid." limit 1";
				$row = $this->db->query($ss)->row();
		
		//파일 삭제
		switch($gubun){
		case "banner":
			$rowid = $this->fileDelOnly($gubun, $row->img);
		break;
		case "community":
			$rowid = $this->fileDelOnly($gubun, $row->fnam);
		break;
		case "saup":
			$rowid = $this->fileDelOnly($gubun, $row->fnam);
		break;
		case "gongsa":
			$rowid = $this->fileDelOnly($gubun, $row->fnam);
		break;
		case "photoon":
			$rowid = $this->fileDelOnly($gubun, $row->imgname);
		break;
		}
		if($rowid > 0) $rowid = $recid; //정상적으로 삭제 되었다.
		
					
					$this->db->trans_start();
							
					$this->db->delete($tb, array('id' => $recid)); 
							
					$this->db->trans_complete();
					
					if ($this->db->trans_status() === FALSE)
					{
						$rowid = 0;
					}
				
		return $rowid;
	}
	//==================================================
	//첨부파일 리스트를 가져온다.----addfilelist 에서 첨부파일 리스트를 가져온다.
	//==================================================
	public function getAddF($cntrol, $md1, $md3, $rid){

		switch($cntrol){
		default:
			$se = " * ";
			$tb = "addfilelist";
			$wh = "mainMenu = '".$cntrol."' and tb = '".$tb."' and recid = ".$rid." ";
		break;
		}

		$ss = "select ".$se." from ".$tb." where ".$wh; 
		$adf = $this->db->query($ss)->result();
		
		return $adf;
	}
	//==================================================
	//addfilelist 에 파일을 등록한다.
	//==================================================
	public function onputAddF($cntrol, $md1, $md3, $rid, $arr){
	
		$this->db->trans_start();
		
		//$main = $this->session->userdata('mainMenu');
		$tb = getTable($cntrol, $md1, $md3);
		$lstid = 0;
		for($c = 1; $c <= count($arr); $c++){
			if($arr['fnam'.$c] != "0"){
				$rrr = array("mainMenu"=> $cntrol, "tb"=> $tb, "recid"=>$rid, "fnam"=>$arr['fnam'.$c], "indx"=>$c); 
				$this->db->insert('addfilelist', $rrr); 
				$lstid++;
			}
		}

		$this->db->trans_complete();		
		if ($this->db->trans_status() === FALSE)
		{
			$lstid = 0;
		}	

		return $lstid;
	}
	//==================================================
	//
	//==================================================



	//삭제후 모든 첨부파일의 리스트를 가져온다.
	public function getAddFaftDel($gubun, $md1, $md3, $rid){
	
		//gubun============
		/*
		case "gongsa":
		case "saup":
		case "community":
		case "photoon":
		*/////////////////////////////
		
		$cntr = "hjang";
		if($gubun == "community") $cntr = "community";
		
		$tb = getTable($cntr, $md1, $md3);

		$ss = "select * from addfilelist where mainMenu = '".$cntr."' and tb = '".$tb."' and recid = ".$rid." "; 
		$adf = $this->db->query($ss)->result();
		
		return $adf;
	}



	
	



}


?>

<?php

class Musiconm extends CI_Model{
	function __construct(){
		
		parent::__construct();
		
		//echo "kkkkkk";
	}

//==========================================
//음원등록 내용을 DB에 저장한다.
//========================================	
	public function musicOnDB($arr){
		//가수의 이름을 가져온다.
		$this->db->select("gasu")->from("mr_s_AAgasu_dir")->where("fdir", $arr['gasu']);
		$gg = $this->db->get()->row();
		$gasunm = $gg->gasu;
		
		//기본정보를 저장한다.
		$this->db->trans_start();
		
		$sedd = $arr['sede'];
		if($arr['sede'] == "4seM" or $arr['sede'] == "4seF") $sedd = "4se";
		if($arr['sex'] == 0) $sex = "m";
		else if($arr['sex'] == 1) $sex = "f";
		else $sex = "d";


		$uarr = array("gasu"=>$gasunm, "sede"=>$sedd, "tit"=>$arr['tit'], "sex"=>$sex, "oldnam"=>"not", "newnam"=>"not", "project"=>"mrapp");
		$this->db->insert('mr_s_AAmusic_bas', $uarr); 	
		$inrecid = $this->db->insert_id();
		$rowid = $inrecid;
		
		//상세정보를 저장한다.
		for($ii = 0; $ii < count($arr['songid']); $ii++){
			$sarr = array("songid"=>$arr['songid'][$ii], "basid"=>$inrecid, "prefix"=>$arr['prefix'][$ii], "endfix"=>$arr['endfix'][$ii], "fdir"=>"../mrphp/music/".$sedd."/".$arr['gasu'], "project"=>"mrapp");
			$this->db->insert('mr_s_AAmusic_sangse', $sarr);
		}

				
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;  //수정 실패 이다.
		}

		return $rowid;
	}
//======================================
//전체 가수의 이름을 반환한다.
//========================================	
	public function getAllGasu(){
	
		$this->db->select("*")->from("mr_s_AAgasu_dir")->order_by("gasu, id desc");
	
		return $this->db->get()->result();
	}
//======================================
//상세음원 리스트 출력
//========================================	
	public function allMusic_SangseList($row){

		$sql = 'select * from mrSongPoint as a left join mr_s_AAmusic_sangse as b on(a.songid = b.songid) left join mr_s_AAmusic_bas as c on(b.basid = c.id) where ';
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = ' a.songid <> "" ';
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = ' a.songid <> "" ';
			break;
			}
		}		
		$sql .= $findTxt;
		$sql .= ' and a.gubun = '.$row['gubun'];
		$sql .= ' order by a.hit desc';
		$sql .= ' limit '.$row['page'] .','.$row['ppn'];
		

		return $this->db->query($sql)->result();		;
	}
//======================================
//전체 음원 리스트
//========================================	
	public function allMusic_list($row){

		$sql = 'select * from mr_s_AAmusic_bas where ';
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = " id > 0 ";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = ' id > 0 ';
			break;
			case "tit":
				$findTxt = ' tit like "%'.rawurldecode($fndg).'%" ';
			break;
			case "gasu":
				$findTxt = ' gasu like "%'.rawurldecode($fndg).'%" ';
			break;
			}
		}
		if($row['md3'] == 3 or $row['md3'] == 1) $sql .= $findTxt." and stat = 1";
		else $sql .= $findTxt." and stat = 2";
		
		$sql .= ' order by id desc';
		$sql .= " limit ".$row['page'] .",".$row['ppn'];
		
		
		$result = $this->db->query($sql)->result();		

		return $result;
	}
//사업관련=================================================

	public function musicdelAll($did){
	
		$sql = "select * from mr_s_AAmusic_bas where id = ".$did." limit 1 ";
		$result = $this->db->query($sql)->row();	
		
		
		$sql2 = "select * from mr_s_AAmusic_sangse where basid = ".$did."  ";
		$result2 = $this->db->query($sql2)->result();	
		
		$cc = 0;
		$thinkid = "";
		foreach($result2 as $drow){
			if($drow->prefix == "txt"){
				$sid = explode("-", $drow->songid);
				$desang = $sid[0]."_gasa.txt";
				$thinkid = $sid[0]."-Think.txt";
			}else $desang = $drow->songid.$drow->endfix;
			
			$dd[$cc++] = $desang;
		}
		
		
		$ff = str_replace("../", "", $result2->fdir);
		$ff = "../mrphp/".$ff;
		
		$dc = rmdirFile($ff, $dd);
		
		if($dc > 0){
			//압축파일 삭제
			 @unlink('../mrphp/musicorg/'.$result->newnam);
			 

			$this->db->trans_start();
			
			//상세정보 삭제
			$this->db->delete('mr_s_AAmusic_sangse', array('basid' => $did)); 
			//압축파일 정보 삭제
			$this->db->delete('mr_s_AAmusic_bas', array('id' => $did)); 
			
			$this->db->trans_complete();
		
		}
		
		$dd[0] = $thinkid;
		$dc2 = rmdirFile($ff, $dd);
		
		
		return $dc;

	}

	


	public function getKeyMusic($mlist, $md = 0){
		
		$kkk = array();
		
		
		if($md == 0){  //음원 상세리스트를 가져온다.
		
			foreach($mlist as $row){
				
				//echo "8888=".$row->id."/".count($mlist);  //압추파일의 아이디
				
				$sql = 'select * from mr_s_AAmusic_sangse where basid = '.$row->id.' and prefix <> "txt" and prefix <> "img" order by prefix ';
				$uu = $this->db->query($sql)->result();
				
				//echo var_dump($uu);
				
				$stxt = "";
				foreach($uu as $rowr){
				  $mm = str_replace("(MR man","남자키", rawurldecode($rowr->prefix));
				  $mm = str_replace("(MR wom","여자키", $mm);
				  $mm = str_replace("(MR ","", $mm);
				  $mm = str_replace("(Melody)","멜로디포함", $mm);
				  $mm = str_replace("(Org)", "원키", $mm);
				  $mm = str_replace(")", "", $mm);
				  
				  $ff = str_replace("../", "", $rowr->fdir);
				  
				  $stxt .= " / <a href='#' onclick='webplay(\"".$rowr->songid."\", \"".$rowr->endfix."\", \"".$ff."\")'>".$mm."</a>";
			   }
			   //echo "------".$stxt;
			   
			   $kkk[$row->id] = substr($stxt, 2);
			}

		
		}else if($md == 1){   //가사리스트 

			foreach($mlist as $row){
				
				//echo "8888=".$row->id."/".count($mlist);  //압추파일의 아이디
				
				$sql = 'select * from mr_s_AAmusic_sangse where basid = '.$row->id.' and prefix = "txt" order by prefix ';
				$uu = $this->db->query($sql)->result();
				
				
				$stxt = "";
				$simg = "";
				foreach($uu as $rowr){
					  	$aa = explode("-", $rowr->songid);
				  		$stxt .= " / <a href='#' onclick='webplay4(\"".$aa[0]."-gasa".$rowr->endfix."\", \"".$rowr->endfix."\", \"txt\")'><img src='/images/common/ico_file.gif'></a>";
				  
			   }
			   
			   $rrtxt = substr($stxt, 2);
			   
			   $kkk[$row->id] = $rrtxt;
			   
			}

		}else if($md == 2){   //이미지 리스트

			foreach($mlist as $row){
				
				//echo "8888=".$row->id."/".count($mlist);  //압추파일의 아이디
				
				$sql = 'select * from mr_s_AAmusic_sangse where basid = '.$row->id.' and prefix = "img" order by prefix ';
				$uu = $this->db->query($sql)->result();
				
				
				$stxt = "";
				$simg = "";
				foreach($uu as $rowr){

				  		$simg .= " / <a href='#' onclick='webplay4(\"".$rowr->songid.".jpg\", \"".$rowr->endfix."\", \"img\")'><img src='/images/common/ico_img.jpg'></a>";
				  
			   }
			   
			   $rrimg = substr($simg, 2);
			   
			   $kkk[$row->id] = $rrimg;
			   
			}

		}
		

		return $kkk;
	}


	public function allMusic_totalCount($md3){

		$sql = 'select count(id) as su from mr_s_AAmusic_bas where ';
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = ' id > 0 ';
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = ' id > 0';
			break;
			case "tit":
				$findTxt = ' tit like "%'.rawurldecode($fndg).'%"';
			break;
			case "gasu":
				$findTxt = ' gasu like "%'.rawurldecode($fndg).'%"';
			break;
			}
		}		
		
		if($md3 == 3 or $md3 == 1) $sql .= $findTxt." and stat = 1";
		else $sql .= $findTxt." and stat = 2";
	
		
		$result = $this->db->query($sql)->row();		

		//echo $result->su;

		return $result;
	}
//대상자관련===========================================================



}

?>

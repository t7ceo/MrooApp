<?php

class Scene extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	
//사업관련=================================================
	//사업의 이름과 아이디를 반환한다.
	public function field_control_name($row){
		$sql = 'select id, business_nm from field_control where coid = '.$row["coid"].' order by onday desc';
		$result = $this->db->query($sql)->result();		

		return $result;
	}
	
	
	
	//사업 리스트를 반환한다.
	public function field_control_list($row){

		if($row['coid'] > 0) $qq = " where a.coid = ".$row["coid"]." ";
		else $qq = " where a.coid > 0 ";
		
		$sql = 'select id, coid, (select coname from member where id = a.coid) as coname, (select name from member where memid = a.wrmemid) as wrname, memid, business_nm, business_explane, start_dt, end_dt, wrmemid, onday, (select count(id) from saupdesang x where x.saupid = a.id) as dssu from field_control a';
		$sql .= $qq;
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "saupnam":
				$findTxt = ' and business_nm like "%'.$fndg.'%" ';
			break;
			case "nammemo":
				$findTxt = ' and (business_nm like "%'.$fndg.'%" or business_explane like "%'.$fndg.'%") ';
			break;
			}
		}		
		$sql .= $findTxt;
		$sql .= ' order by onday desc';
		$sql .= " limit ".$row['page'] .",".$row['pagePerNum'];
		
		
		$result = $this->db->query($sql)->result();		
		//echo $sql."/".count($result);

		return $result;
	}



	public function field_control_totalCount($row){

		if($row['coid'] > 0) $qq = " where coid = ".$row["coid"]." ";
		else $qq = " where coid > 0 ";
		
		$sql = 'select count(id) as su from field_control '; 
		$sql .= $qq;
		
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "saupnam":
				$findTxt = ' and business_nm like "%'.$fndg.'%" ';
			break;
			case "nammemo":
				$findTxt = ' and (business_nm like "%'.$fndg.'%" or business_explane like "%'.$fndg.'%") ';
			break;
			}
		}		
		
		$sql .= $findTxt;
		
		
		
		$result = $this->db->query($sql)->row();		

		return $result;
	}
//대상자관련===========================================================



	//사업의 대상자리스트를 가져온다.
	public function ds_list($data){
		$sql = 'select a.id, a.coid, a.saupid, a.dsname, a.post, a.addr, a.addr2, b.business_nm, a.tel from desang as a left join field_control as b on(a.saupid = b.id) where a.coid = '.$data["coid"].' order by a.onday desc';
		$result = $this->db->query($sql)->result();		
		

		return $result;
	
	}
	
	
		//업체의 대상자 리스트
	public function desangInfo($data){
		
		$fndg2 = $this->session->userdata("find");
		$ord = "";
		//정렬 기능을 처리 한다.=======================
		///*
		$fndg = substr($fndg2, 2);
		
		
		$fgb = substr($fndg2, 0, 1);
		$fgb2 = (int)substr($fndg2, 1, 1);
		$ff = substr($fndg2, 0, 2);
		
		
			switch($fgb){
			case "A":
				if($ff == "A0"){
					$ord = "";
				}else{
					$ord = " and sugub = ".$fgb2." ";
				}
			break;
			case "B":
				if($ff == "B0"){
					$ord = "";
				}else{
					$ord = " and bojang = ".$fgb2." ";
				}
			break;
			case "C":
				if($ff == "C0"){
					$ord = "";
				}else{
					$ord = " and gaguinf = ".$fgb2." ";
				}
			break;
			}

		//========================================
		
		
		if($fndg == ""){
			$findTxt = " and 1 ";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = " and 1 ";
			break;
			case "name":
				$findTxt = ' and a.dsname like "%'.$fndg.'%" ';
			break;
			case "tel":
				$findTxt = ' and ( a.tel like "%'.$fndg.'%" or a.htel like "%'.$fndg.'%") ';
				//$findTxt = ' and ( base64decode(a.tel) like "%'.$fndg.'%" or base64decode(a.htel) like "%'.$fndg.'%") ';
			break;
			case "addr":
				$findTxt = ' and (a.addr like "%'.$fndg.'%" or a.addr2 like "%'.$fndg.'%") ';
			break;
			case "wr":
				$findTxt = ' and (a.wrmemid like "%'.$fndg.'%" or b.name like "%'.$fndg.'%") ';
			break;
			}
		}		
		
		
		$sql = 'select a.*, b.coname, b.name from desang as a left join member as b on(a.wrmemid = b.memid) ';
		$cc = ' a.coid > 0 ';
		if($data["coid"] > 0) $cc = ' a.coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt.$ord;
		

		$sql .= ' order by a.onday desc';
		
		
		if($data['pagePerNum'] > 0) $sql .= " limit ".$data['page'] .",".$data['pagePerNum'];
		$result = $this->db->query($sql)->result();		
		

		return $result;
	
	}



	public function desangInfoTotalCount($data){
		
		//$fndg = $this->session->userdata("find");
		
		$fndg2 = $this->session->userdata("find");
		$ord = "";
		//정렬 기능을 처리 한다.=======================
		///*
		$fndg = substr($fndg2, 2);
		
		
		$fgb = substr($fndg2, 0, 1);
		$fgb2 = (int)substr($fndg2, 1, 1);
		$ff = substr($fndg2, 0, 2);
		

			switch($fgb){
			case "A":
				if($ff == "A0"){
					$ord = "";
				}else{
					$ord = " and sugub = ".$fgb2." ";
				}
			break;
			case "B":
				if($ff == "B0"){
					$ord = "";
				}else{
					$ord = " and bojang = ".$fgb2." ";
				}
			break;
			case "C":
				if($ff == "C0"){
					$ord = "";
				}else{
					$ord = " and gaguinf = ".$fgb2." ";
				}
			break;
			}
		//========================================
		
		

		if($fndg == ""){
			$findTxt = " and 1 ";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = " and 1 ";
			break;
			case "name":
				$findTxt = ' and a.dsname like "%'.$fndg.'%" ';
			break;
			case "tel":
				$findTxt = ' and ( a.tel like "%'.$fndg.'%" or a.htel like "%'.$fndg.'%") ';
				//$findTxt = ' and ( base64decode(a.tel) like "%'.$fndg.'%" or base64decode(a.htel) like "%'.$fndg.'%") ';
			break;
			case "addr":
				$findTxt = ' and (a.addr like "%'.$fndg.'%" or a.addr2 like "%'.$fndg.'%") ';
			break;
			case "wr":
				$findTxt = ' and (a.wrmemid like "%'.$fndg.'%" or b.name like "%'.$fndg.'%") ';
			break;
			}
		}		
		
		
		
		$sql = 'select count(a.id) as su from desang as a left join member as b on(a.wrmemid = b.memid) ';
		$cc = ' a.coid > 0 ';
		if($data["coid"] > 0) $cc = ' a.coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt.$ord;
		

		$sql .= ' order by a.onday desc';
		$result = $this->db->query($sql)->row();		
		

		return $result;
	
	}
	

//=====================================================




	
	//공사 사진관련 리스트를 출력 
	public function ds_photolist($data){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "desang":
				$yy = 'select id from desang where dsname like "%'.$fndg.'%" ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "gongsa":
				$findTxt = ' and gsname like "%'.$fndg.'%"  ';
			break;
			case "ptcontent":  //대상자+공사명
				$findTxt = ' and ( dsname like "%'.$fndg.'%" or gsname like "%'.$fndg.'%")  ';
			break;
			}
		}		
		
		
		$sql = 'select id, gsname, saupid, coid, (select coname from member where id = A.coid) as coname, dange, dsname, saupnam, onday from (';
		$sql .= 'select id, gsname, saupid, coid, dange, onday, (select dsname from desang x where x.id = a.dsid) as dsname, (select business_nm from field_control x where x.id = a.saupid) as saupnam, a.dsid from gongsa a';
		$sql .= ') A';
		
		$cc = ' coid > 0 ';
		if($data["coid"] > 0) $cc = ' coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt;


		$sql .= ' order by onday desc';
		$sql .= " limit ".$data['page'] .",".$data['pagePerNum'];
		$result = $this->db->query($sql)->result();		
		

		return $result;
	
	
	}

	public function ds_photolistTotalCount($data){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "desang":
				$yy = 'select id from desang where dsname like "%'.$fndg.'%" ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "gongsa":
				$findTxt = ' and gsname like "%'.$fndg.'%"  ';
			break;
			case "ptcontent":  //대상자+공사명
				$findTxt = ' and ( dsname like "%'.$fndg.'%" or gsname like "%'.$fndg.'%")  ';
			break;
			}
		}		
		
		
		
		$sql = 'select count(id) as su from (';
		$sql .= 'select id, gsname, saupid, coid, dange, onday, (select dsname from desang x where x.id = a.dsid) as dsname, (select business_nm from field_control x where x.id = a.saupid) as saupnam, a.dsid from gongsa a';
		$sql .= ') A';
		
		$cc = ' coid > 0 ';
		if($data["coid"] > 0) $cc = ' coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt;
		
		$result = $this->db->query($sql)->row();		
		

		return $result;
	
	
	}


	
	
	//공사 리스트를 출력 
	public function ds_gongsalist($data){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "name":
				$yy = 'select id from desang where dsname like "%'.$fndg.'%" ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "tel":
				$yy = 'select id from desang where (tel like "%'.$fndg.'%" or htel like "%'.$fndg.'%") ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "tit":
				$findTxt = ' and gsname like "%'.$fndg.'%"  ';
			break;
			case "wr":
				$findTxt = ' and ( name like "%'.$fndg.'%" or wmemid like "%'.$fndg.'%")  ';
			break;
			}
		}		

		
		$sql = 'select id, coid, (select coname from member where id = A.coid) as coname, gsname, dsid, onday, wmemid, name, saupid, start_dt, end_dt, dsname, htel, saupnam from (';
		$sql .= 'select id, coid, gsname, dsid, onday, wmemid, (select name from member where memid = wmemid) as name, saupid, start_dt, end_dt, (select dsname from desang x where x.id = a.dsid) as dsname, (select htel from desang x where x.id = a.dsid) as htel, (select business_nm from field_control x where x.id = a.saupid) as saupnam, a.content from gongsa a';
		$sql .= ') A';
		
		$cc = ' coid > 0 ';
		if($data["coid"] > 0) $cc = ' coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt;		

		
		$sql .= ' order by onday desc';
		$sql .= " limit ".$data['page'] .",".$data['pagePerNum'];
		//echo $sql;
		$result = $this->db->query($sql)->result();		
		

		return $result;
	
	
	}

	public function ds_gongsalistTotalCount($data){
		
		$fndg = $this->session->userdata("find");
		if($fndg == ""){
			$findTxt = "";
		}else{
			switch($this->session->userdata("findMd")){
			case "0":
				$findTxt = "";
			break;
			case "name":
				$yy = 'select id from desang where dsname like "%'.$fndg.'%" ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "tel":
				$yy = 'select id from desang where (tel like "%'.$fndg.'%" or htel like "%'.$fndg.'%") ';
				$yyr = $this->db->query($yy)->result();
				if(count($yyr) > 0){
					$ytxt = " and (";
					$y = 0;
					foreach($yyr as $rowy){
						if($y > 0) $ytxt .= " or ";
						$ytxt .= " dsid = ".$rowy->id." ";
						$y++;
					}
					$ytxt .= " ) ";
				}else $ytxt = " and id = 0 ";
			
				$findTxt = $ytxt;
			break;
			case "tit":
				$findTxt = ' and gsname like "%'.$fndg.'%"  ';
			break;
			case "wr":
				$findTxt = ' and ( name like "%'.$fndg.'%" or wmemid like "%'.$fndg.'%")  ';
			break;
			}
		}		
		
		
		$sql = 'select count(id) as su, (select coname from member where id = A.coid) as coname, name from (';
		$sql .= 'select id, coid, gsname, dsid, onday, wmemid, (select name from member where memid = wmemid) as name, saupid, start_dt, end_dt, (select dsname from desang x where x.id = a.dsid) as dsname, (select htel from desang x where x.id = a.dsid) as htel, (select business_nm from field_control x where x.id = a.saupid) as saupnam, a.content from gongsa a';
		$sql .= ') A';
		
		$cc = ' coid > 0 ';
		if($data["coid"] > 0) $cc = ' coid = '.$data["coid"]; 
		$sql .= ' where '.$cc.$findTxt;		


		$result = $this->db->query($sql)->row();		
		

		return $result;
	
	
	}




	//회원 리스트
	public function member_list($row){
		$sql = 'select id, memid, name from member where 1=1';
		if($row['potion']){
			$sql .= " and potion = '".$row['potion']."'";
		}
		$sql .= " order by id desc";
		$result = $this->db->query($sql)->result();		

		return $result;
	}

	
}


?>

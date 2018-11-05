<?php

class Musicdb extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	

	
	
	//사진 수정을 위해 사정 정보를 가져온다.
	public function getGongsaPhoto($ptid){
	
		$yy = 'select * from sceneImg where id = '.$ptid.'  ';
		$yyr = $this->db->query($yy)->row();
		
		return $yyr;
	}
	
	

	//사업아이디로 사업의 대상자리스트를 가져온다.
	public function getSaupDesang($data){
		$sql = 'select a.id, a.desang, a.saupid, b.business_nm, c.dsname, c.addr, c.tel, c.htel, a.coid from saupdesang as a left join field_control as b on(a.saupid = b.id) left join desang as c on(a.desang = c.id) where a.saupid = '.$data.' order by c.dsname desc';
		$result = $this->db->query($sql)->result();		
		

		return $result;
	}
	//선택한 사업의 아이디로 사업대상자 리스트를 반환한다.
	public function coSangDamDesangList($supid){
	
		$ss = 'select a.id, b.id, b.dsname, b.tel, b.htel from saupdesang as a left join desang as b on(a.desang = b.id) where a.saupid = '.$supid.' order by b.dsname desc ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	}
	//선택한 사업의 아이디로 공사리스트를 가져온다.
	public function getSaupGongsa($supid){
	
		$ss = 'select a.id, a.dsid, a.gsname, b.dsname from gongsa as a left join desang as b on(a.dsid = b.id) where a.saupid = '.$supid.' order by a.onday desc ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	}
	//선택한 사업의 아이디로 사업대상자 리스트를 반환한다.
	public function coSaupDesangList($coid, $supid){
	
		$ss = 'select a.id, a.dsid, a.gsname, b.dsname from gongsa as a left join desang as b on(a.dsid = b.id) where a.coid = '.$coid.' and a.saupid = '.$supid.' order by a.onday desc ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	}

	public function getSaupSS($supid){
		//echo "kkkk=".$supid;
	
		$ss = 'select a.id, a.dsid, a.gsname, a.content, b.dsname, c.business_nm, c.start_dt, c.end_dt from gongsa as a left join desang as b on(a.dsid = b.id) left join field_control as c on(a.saupid = c.id) where c.id = '.$supid.' order by a.onday desc ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	}

	
	
	public function toExcel($data){
	
		/*
		if($data['coid'] == 0){
			$sql = 'select a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2, a.sugub, a.bojang, a.bojangetc, a.gagusu, a.gaguinf, a.gagumemo, a.onday, b.coname, b.name from desang as a left join member as b on(a.coid = b.id) where a.coid > 0 order by a.onday desc';
		}else{
			$sql = 'select a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2, a.sugub, a.bojang, a.bojangetc, a.gagusu, a.gaguinf, a.gagumemo, a.onday, b.coname, b.name from desang as a left join member as b on(a.coid = b.id) where a.coid = '.$data['coid'].' order by a.onday desc';
		}
		*/
	
		
		//$result = $this->db->query($sql)->result();		
		
		toExcel($data);
	
	}
	
	
	public function getScjul($data){
	
		//$std = $data['start']." 00:00:00";
		//$edd = $data['end']." 23:59:59";
	
		//업체의 이름을 가져온다.
		$ss = 'select * from schedule where gubun = '.$data['bdgubun'].' '; // and (startdate >= "'.$std.'" and enddate <= "'.$edd.'") ';
		$row = $this->db->query($ss)->result();
		
		return $row;
	
	}
	
	//모바일에서 선택한 사업의 대상자이름과 공사이름을 가져온다.
	public function getAllSaupGongsa($saupid){
	
		$ss = 'select id, coid, dsid, (select dsname from desang x where x.id = a.dsid) as dsnam, gsname from gongsa a  where saupid = '.$saupid.' order by onday desc ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	}
	
	
	//공사의 대상자 정보를 가져온다.
	public function getDesangInfo($gsid){
	
		$ss = 'select b.id, a.dange, b.coid, a.dsid, b.dsname, b.bday, b.tel, b.htel, b.addr, b.addr2, b.latpo, b.langpo, b.sugub, b.bojang, b.bojangetc, b.gagusu, b.gaguinf, b.gagumemo, b.onday from gongsa as a left join desang as b on(a.dsid = b.id) where a.id = '.$gsid.' limit 1 ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	//공사의 대상자 정보를 가져온다.
	public function getDesangSangseId($dsid){
	
		$ss = 'select *, (select coname from member where id = a.coid limit 1) as conam, a.gagumemo from desang a where id = '.$dsid.' limit 1 ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	//대상자의 사업설정 정보를 가져온다.
	public function getDesangSaupSeInfo($dsid){
	
		$ss = 'select saupid from saupdesang where desang = '.$dsid.'  ';
		$aa = $this->db->query($ss)->result();
		
		$rr = "";
		$c = 0;
		foreach($aa as $row){
			if($c > 0) $rr .= "-";
			$rr .= $row->saupid;
			$c++;
		}
		
		return $rr;
	
	}
	
	
	
	//대상자의 상세정보를 가져온다.-사업과 연계된 대상자 리스트
	public function getDesangSangse($spid){
	
		$ss = 'select a.id, a.coid, a.saupid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr,  a.addr2, a.latpo, a.langpo, a.onday, a.wrmemid, (select coname from member x where x.id = a.coid) as conam, (select business_nm from field_control y where y.id = a.saupid) as spnam, a.sugub, a.bojang, a.bojangetc, a.gagusu, a.gaguinf, a.gagumemo from desang a where a.id = '.$spid.' limit 1';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	//사진의 정보를 가져온다.
	public function getPhotoInfo($pid){
	
		$ss = 'select id, memo, tit, onday, wrmemid, imgname, desangmemid, dange, gsid, (select gsname from gongsa where id = a.gsid limit 1) as gsnam from sceneImg a where id = '.$pid.' limit 1 ';
		return $this->db->query($ss)->row();
	}
	
	
	
	//선택한 대상자의 공사 리스트를 가져온다.
	public function getGongsaList($dsid){
	
		$ss = 'select a.id, a.dsid, b.dsname, a.gsname from gongsa as a left join desang as b on(a.dsid = b.id) where a.dsid = '.$dsid.' order by a.onday desc ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	
	}
	
	
	
	//사업이 내용과 공사의 정보를 가져온다.
	public function getAllSaupGongsaSS($gsid){
	
		$ss = 'select id, coid, dsid, (select business_explane from field_control x where x.id = a.saupid) as sptext, content, fnam, don, dange, start_dt, end_dt from gongsa a  where id = '.$gsid.' limit 1 ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	

	
	
	//선택한 업체의 모든 사업리스트를 가져온다.
	public function getAllSaup($seco){
	
		$ss = 'select * from field_control where coid = '.$seco.' ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	
	
	}
	
	
	//공사 상세보기
	public function getGongsaSS($gsid, $dsid = 0){  //공사 아이디/대상자 아이디 
		
		$qq = ' a.id = '.$gsid.' and a.dsid = '.$dsid.' ';
		if($dsid == 0) $qq = ' a.id = '.$gsid.' ';
		
	
		$ss = 'select id, coid, gsname, content, don, saupid, dsid, start_dt, end_dt, onday, wmemid, dange, (select business_nm from field_control y where y.id = a.saupid) as spnam, (select dsname from desang where id = a.dsid) as dsname from gongsa a where '.$qq.' limit 1  ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	
	
	
	
	
	//공사의 단계와 대상자 아이디를 가져온다.
	public function getDange($gsid){
	
		$ss = 'select dsid, dange from gongsa where id = '.$gsid.' ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	}
	
	
	//엑셀로 만들 자료를 가져온다.
	public function getExData($data){
	
	
	
	}
	
	
	
	
	//업체의 대상자 정보를 가져온다.
	//대상자명, 공사명, 사업명, 상담제목, 전화번호
	/*
	<select id="findSe" name="findSe" onchange="meminf.chnSelect(this, 1)">
  	<option value="0" <?=$uu[0]?>>전체</option>
    <option value="1" <?=$uu[1]?>>대상자명</option>
    <option value="2" <?=$uu[2]?>>공사명</option>
    <option value="3" <?=$uu[3]?>>사업명</option>
    <option value="4" <?=$uu[4]?>>상담제목</option>
    <option value="5" <?=$uu[5]?>>전화번호</option>
   	</select>
	*/
	
	public function getCoDesangAll($coid, $se, $fnd){
		
		if($coid > 0) $ww = " a.coid = ".$coid." ";
		else $ww = " a.coid > 0 ";
		
		if($se == 0) $ww = " a.coid = 0 ";
		
		
		$fndq = "";
		if($fnd != "" and (int)$se > 0){
			
			switch((int)$se){
			case 0:  //선태
				$fndq = " and ((a.dsname like '%".$fnd."%' or b.gsname like '%".$fnd."%' or a.tel like '%".$fnd."%' or a.htel like '%".$fnd."%') or ((select count(id) from field_control where business_nm like '%".$fnd."%') > 0) or  ((select count(id) from sangdam where tit like '%".$fnd."%') > 0)) ";
				
$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, (select coname from member where id = a.coid) as coname, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by a.dsname ';
				
			break;
			case 1: //대상자명
				$fndq = " and a.dsname like '%".$fnd."%' ";
				
$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.post, (select coname from member where id = a.coid) as coname, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by a.dsname ';
			break;
			case 2: //공사명 
				$fndq = " and a.gsname like '%".$fnd."%' ";
				
$ss = 'select a.id, a.coid, b.dsname, b.bday, b.tel, b.post, b.addr, b.addr2 from gongsa as a left join desang as b on(a.dsid = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';


			break;
			case 3: //사업명 
				$fndq = " and a.business_nm like '%".$fnd."%' and ((select count(id) from gongsa where saupid = a.id) > 0) ";
				
				$ss = 'select b.id, b.coid, c.dsname, c.bday, c.tel, c.post, c.addr, c.addr2, a.business_nm from field_control as a left join gongsa as b on(a.id = b.saupid) left join desang as c on (c.id = b.dsid) where '.$ww.' '.$fndq.' order by c.dsname ';


			
			break;
			case 4: //상담제목
				$fndq = " and a.tit like '%".$fnd."%' ";
				
//$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) left join sangdam as c (b.dsid = c.desang) where '.$ww.' '.$fndq.' order by a.dsname ';

				$ss = 'select b.id, b.coid, b.dsname, b.bday, b.tel, b.htel, b.post, b.addr, b.addr2 from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				
			break;
			case 5: //전화번호 
				$fndq = " and (tel like '%".$fnd."%' or htel like '%".$fnd."%')";
			
				$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2 from desang as a where '.$ww.' '.$fndq.' order by a.dsname ';

			break;
			}
			
		}else{
			
			$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, (select coname from member where id = a.coid) as coname, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.'  order by a.dsname ';
		
		}
		

		$aa = $this->db->query($ss)->result();
		
		return $aa;
		
	}
	

	public function getCoSaupAll($coid, $se, $fnd){
		
		if($coid > 0) $ww = " a.coid = ".$coid." ";
		else $ww = " a.coid > 0 ";
		
		if($se == 0) $ww = " a.coid = 0 ";
		
		
		$fndq = "";
		if($fnd != "" and (int)$se > 0){
			
			switch((int)$se){
			case 0:  //선태
				//$fndq = " and ((a.dsname like '%".$fnd."%' or b.gsname like '%".$fnd."%' or a.tel like '%".$fnd."%' or a.htel like '%".$fnd."%') or ((select count(id) from field_control where business_nm like '%".$fnd."%') > 0) or  ((select count(id) from sangdam where tit like '%".$fnd."%') > 0)) ";
				
//$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by a.dsname ';
				
			break;
			case 1: //대상자명
				$fndq = " and c.dsname like '%".$fnd."%' ";
				
				$ss = 'select a.id, b.coid, c.dsname, c.bday, c.tel, b.gsname, a.business_nm, a.start_dt, a.end_dt from field_control as a left join gongsa as b on(a.id = b.saupid) left join desang as c on (c.id = b.dsid) where '.$ww.' '.$fndq.' order by c.dsname ';
			
			
				//$fndq = " and a.dsname like '%".$fnd."%' ";
				
//$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by a.dsname ';
			break;
			case 2: //공사명 
				$fndq = " and a.gsname like '%".$fnd."%' ";
				
$ss = 'select a.id, a.coid, b.dsname, b.bday, b.tel, b.post, b.addr, b.addr2 from gongsa as a left join desang as b on(a.dsid = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';


			break;
			case 3: //사업명 
				$fndq = " and a.business_nm like '%".$fnd."%' and ((select count(id) from gongsa where saupid = a.id) > 0) ";
				
				$ss = 'select b.id, b.coid, c.dsname, c.bday, c.tel, c.post, c.addr, c.addr2, a.business_nm from field_control as a left join gongsa as b on(a.id = b.saupid) left join desang as c on (c.id = b.dsid) where '.$ww.' '.$fndq.' order by c.dsname ';


			
			break;
			case 4: //상담제목
				$fndq = " and a.tit like '%".$fnd."%' ";
				
//$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) left join sangdam as c (b.dsid = c.desang) where '.$ww.' '.$fndq.' order by a.dsname ';

				$ss = 'select b.id, b.coid, b.dsname, b.bday, b.tel, b.htel, b.post, b.addr, b.addr2 from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				
			break;
			case 5: //전화번호 
				$fndq = " and (tel like '%".$fnd."%' or htel like '%".$fnd."%')";
			
				$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2 from desang as a where '.$ww.' '.$fndq.' order by a.dsname ';

			break;
			}
			
		}else{
			
			$ss = 'select a.id, a.coid, a.dsname, a.bday, a.tel, a.htel, a.post, a.addr, a.addr2 from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.'  order by a.dsname ';
		
		}
		

		$aa = $this->db->query($ss)->result();
		
		return $aa;
		
	}



	//업체의 공사정보를 가져온다.
	public function getCoGongSaAll($coid, $se, $fnd){
		
		if($coid > 0) $ww = " a.coid = ".$coid." ";
		else $ww = " a.coid > 0 ";
		
		if($se == 0) $ww = " a.coid = 0 ";
		
		$fndq = "";
		if($fnd != "" and (int)$se > 0){
			
			switch((int)$se){
			case 0:  //전체 
				//$fndq = " and ((b.dsname like '%".$fnd."%' or a.gsname like '%".$fnd."%' or b.tel like '%".$fnd."%' or b.htel like '%".$fnd."%') or ((select count(id) from field_control where business_nm like '%".$fnd."%') > 0) or  ((select count(id) from sangdam where tit like '%".$fnd."%') > 0)) ";


				//$ss = 'select a.id, a.coid, a.dsid, a.saupid, (select business_nm from field_control where id = a.saupid) as spnam, a.gsname, a.start_dt, a.end_dt, b.dsname from gongsa as a left join desang as b on(a.dsid = b.id) where '.$ww.' '.$fndq.' order by a.gsname ';

				
			break;
			case 1: //대상자명
				$fndq = " and a.dsname like '%".$fnd."%' and b.dsid > 0 ";
				
				$ss = 'select b.id, a.coid, (select coname from member where id = a.coid) as coname, a.dsname, b.gsname, b.saupid, (select business_nm from field_control where id = b.saupid) as spnam, b.start_dt, b.end_dt from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by b.gsname ';
				
			break;
			case 2: //공사명 
				$fndq = " and b.gsname like '%".$fnd."%' ";
				
$ss = 'select a.id, a.coid, a.dsname, b.gsname, b.saupid, (select business_nm from field_control where id = b.saupid) as spnam, b.start_dt, b.end_dt from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by b.gsname ';

			break; 
			case 3: //사업명 
				$fndq = " and c.business_nm like '%".$fnd."%' ";
				
$ss = 'select a.id, a.coid, a.dsname, b.gsname, b.saupid, (select business_nm from field_control where id = b.saupid) as spnam, b.start_dt, b.end_dt from desang as a left join gongsa as b on(a.id = b.dsid) left join field_control as c on(b.saupid = c.id) where '.$ww.' '.$fndq.' order by b.gsname ';
			 
			break;
			case 4: //상담제목으로 공사리스트를 가져온다.-상담과 관련있는 사업의 공사 리스트를 가져온다.
				$fndq = " and a.tit like '%".$fnd."%' ";
				
				$ss = 'select a.id, a.coid, c.dsname, b.gsname, b.saupid, (select business_nm from field_control where id = b.saupid) as spnam, b.start_dt, b.end_dt from sangdam as a left join gongsa as b on(a.gongsaid = b.id) left join desang as c on(a.desang = c.id) where '.$ww.' '.$fndq.' order by b.gsname ';


				
			break;
			case 5: //전화번호 - 대상자의 공사 리스트
				$fndq = " and (a.tel like '%".$fnd."%' or a.htel like '%".$fnd."%') and b.dsid > 0 ";
			
$ss = 'select a.id, a.coid, a.dsname, b.gsname, b.saupid, (select business_nm from field_control where id = b.saupid) as spnam, b.start_dt, b.end_dt  from desang as a left join gongsa as b on(a.id = b.dsid) where '.$ww.' '.$fndq.' order by b.gsname ';

			break;
			}
			
		}else{
			
			$ss = 'select a.id, a.coid, (select coname from member where id = a.coid) as coname, a.dsid, a.saupid, (select business_nm from field_control where id = a.saupid) as spnam, a.gsname, a.start_dt, a.end_dt, b.dsname from gongsa as a left join desang as b on(a.dsid = b.id) where '.$ww.' order by a.gsname ';
		
		}
		

		$aa = $this->db->query($ss)->result();
		
		return $aa;
		
	}
	

	
	//업체의 사진리스트를 가져온다.
	public function getCoPhotoAll($coid, $se, $fnd){
		
		if($coid > 0) $ww = " b.coid = ".$coid." ";
		else $ww = " b.coid > 0 ";
		
		if($se == 0) $ww = " b.coid = 0 ";
		
		
		$fndq = "";
		if($fnd != "" and (int)$se > 0){
			
			
			switch((int)$se){
			case 0:  //전체 
				$fndq = " and ((b.dsname like '%".$fnd."%' or c.gsname like '%".$fnd."%' or b.tel like '%".$fnd."%' or b.htel like '%".$fnd."%') or ((select count(id) from field_control where business_nm like '%".$fnd."%') > 0) or  ((select count(id) from sangdam where tit like '%".$fnd."%') > 0)) ";


				$ss = 'select a.id, a.gsid, b.coid, a.dsrecid, a.sprecid, c.gsname, a.desangmemid, a.dange, a.memo, a.imgname, b.dsname from sceneImg as a left join desang as b on(a.dsrecid = b.id) left join gongsa as c on(a.gsid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';

				
			break;
			case 1: //대상자명,				
				
				$fndq = " and b.dsname like '%".$fnd."%' ";


				$ss = 'select a.id, a.tit, a.gsid, b.coid, a.dsrecid, a.sprecid, c.gsname, a.desangmemid, (select coname from member where id = b.coid) as coname, (select business_nm from field_control where id = c.saupid) as saupnam, a.dange, a.memo, a.imgname, b.dsname, c.saupid from sceneImg as a left join desang as b on(a.dsrecid = b.id) left join gongsa as c on(a.gsid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';
				
			break;
			case 2: //공사명 
				$fndq = " and c.gsname like '%".$fnd."%' ";
				
				$ss = 'select a.id, a.gsid, b.coid, a.dsrecid, a.sprecid, c.gsname, a.desangmemid, a.dange, a.memo, a.imgname, b.dsname from sceneImg as a left join desang as b on(a.dsrecid = b.id) left join gongsa as c on(a.gsid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';


			break;
			case 3: //사업명 

				$fndq = " and (b.business_nm like '%".$fnd."%') ";
			
			
				$ss = 'select a.id, a.gsid, c.coid, a.dsrecid, a.sprecid, c.gsname, a.desangmemid, a.dange, a.memo, a.imgname from sceneImg as a left join field_control as b on(a.sprecid = b.id) left join gongsa as c on(a.gsid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';
			
			break;
			case 4: //상담제목

				$fndq = " and b.tit like '%".$fnd."%' ";
				
				$ss = 'select a.id, a.gsid, b.coid, a.dsrecid, a.sprecid, c.gsname, a.desangmemid, a.dange, a.memo, a.imgname from sceneImg as a left join sangdam as b on(a.gsid = b.gongsaid) left join gongsa as c on(b.gongsaid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';

				
			break;
			case 5: //전화번호 
				$fndq = " and (b.tel like '%".$fnd."%' or b.htel like '%".$fnd."%') and a.dsrecid > 0 ";
			
$ss = 'select a.id, b.coid, a.gsid, a.desangmemid, a.dange, a.memo, a.imgname, c.gsname from sceneImg as a left join desang as b on(a.dsrecid = b.id) left join gongsa as c on(a.gsid = c.id) where '.$ww.' '.$fndq.' order by a.gsid, a.dange desc, a.onday desc ';

			break;
			}
			
			
			
		}else{
			$ss = 'select a.id, a.tit, a.gsid, a.desangmemid, (select coname from member where id = b.coid) as coname, (select business_nm from field_control where id = b.saupid) as saupnam, a.dange, a.memo, a.imgname, b.gsname, b.saupid from sceneImg as a left join gongsa as b on(a.gsid = b.id) where '.$ww.' order by a.gsid, a.dange desc, a.indx, a.onday desc ';		
		
		}
		

		$aa = $this->db->query($ss)->result();
		
		return $aa;
		
	}
	
	
	//업체의 상담정보를 가져온다.
	public function getCoSangdamAll($coid, $se, $fnd){
		
		if($coid > 0) $ww = " a.coid = ".$coid." ";
		else $ww = " a.coid > 0 ";
		
		if($se == 0) $ww = " a.coid = 0 ";
		
		$fndq = "";
		if($fnd != "" and (int)$se > 0){
			
			switch((int)$se){
			case 0:  //전체 
				//$fndq = " and ((b.dsname like '%".$fnd."%' or b.tel like '%".$fnd."%' or b.htel like '%".$fnd."%' or a.tit like '%".$fnd."%') or ((select count(id) from field_control where business_nm like '%".$fnd."%') > 0)) ";
				//$ss = 'select a.id, a.coid, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';

				
			break;
			case 1: //대상자명
				
				$fndq = " and b.dsname like '%".$fnd."%' ";
				$ss = 'select a.id, a.coid, b.htel, (select coname from member where id = a.coid) as coname, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				
				
			break;
			case 2: //공사명 
				
				$fndq = " and c.gsname like '%".$fnd."%' ";
				$ss = 'select a.id, a.coid, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) left join gongsa as c on(a.gongsaid = c.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				
				

			break;
			case 3: //사업명 

				$fndq = " and c.business_nm like '%".$fnd."%' ";
				$ss = 'select a.id, a.coid, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) left join field_control as c on(a.saup = c.id) where '.$ww.' '.$fndq.' order by b.dsname ';
			
			
			break;
			case 4: //상담제목
				
				$fndq = " and a.tit like '%".$fnd."%' ";
				$ss = 'select a.id, a.coid, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				
				
			break;
			case 5: //전화번호 

				$fndq = " and (b.tel like '%".$fnd."%' or b.htel like '%".$fnd."%') ";
				$ss = 'select a.id, a.coid, a.desang, a.saup, (select business_nm from field_control where id = a.saup) as spnam, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' '.$fndq.' order by b.dsname ';
				

			break;
			}
			
		}else{
			
			$ss = 'select a.id, a.coid, b.htel, (select coname from member where id = a.coid) as coname, a.saup, (select business_nm from field_control where id = a.saup) as spnam, a.desang, b.dsname, a.tit, a.sday from sangdam as a left join desang as b on(a.desang = b.id) where '.$ww.' order by a.saup ';
		
		}
		
		
		$aa = $this->db->query($ss)->result();
		
		return $aa;
		
	}
	
	
	
	
	//통합검색을 실행한다.
	public function allFindGet($data){
		
		//대상자 정보를 가져온다.
		$ds = $this->getCoDesangAll($data['coid'], $data['findSe'], rawurldecode($data['findTxt']));
		
		$sp = $this->getCoSaupAll($data['coid'], $data['findSe'], rawurldecode($data['findTxt']));
		
		$gs = $this->getCoGongSaAll($data['coid'], $data['findSe'], rawurldecode($data['findTxt']));
	
		$pt = $this->getCoPhotoAll($data['coid'], $data['findSe'], rawurldecode($data['findTxt']));
	
		$sd = $this->getCoSangdamAll($data['coid'], $data['findSe'], rawurldecode($data['findTxt']));
		


		
		return array("ds"=>$ds, "gs"=>$gs, "pt"=>$pt, "sd"=>$sd, "sp"=>$sp);
	
	
	}

	public function allFindGetTotalCount($data){
	
		/*
		<select id="findSe" name="findSe" onchange="meminf.chnSelect(this, 1)">
		<option value="0">전체</option>
		<option value="1">사업명</option>
		<option value="2">사업명+내용</option>
		<option value="3">대상자명</option>
		<option value="4">대상자명+내용</option>
		<option value="5">전화번호</option>
		</select>
		*/
		
		$whD = "";
		$whS = "";
		if($data['coid'] > 0){
			$whD = " a.coid = ".$data['coid']." and ";
			$whS = " b.coid = ".$data['coid']." and ";
		}else{
			$whD = " a.coid > 0 and ";
			$whS = " b.coid > 0 and ";
		}
		
		
		if($data['findTxt'] != ""){
		
			switch($data['findSe']){  //findTxt
			case 0:   //전체
				$ss = 'select count(b.id) as su from field_control as a left join desang as b on (a.id = b.saupid) where '.$whS.' (a.business_nm like "%'.$data['findTxt'].'%" or b.tel like "%'.$data['findTxt'].'%" or b.dsname like "%'.$data['findTxt'].'%" or a.business_explane like "%'.$data['findTxt'].'%") order by a.business_nm ';
			break;
			case 1:   //사업명
				$ss = 'select count(b.id) as su from field_control as a left join desang as b on (a.id = b.saupid) where '.$whS.' (a.business_nm like "%'.$data['findTxt'].'%") order by a.business_nm ';
			break;
			case 2:    //사업명+내용
				$ss = 'select count(a.id) as su from field_control as a left join desang as b on (a.id = b.saupid) where '.$whS.' (a.business_nm like "%'.$data['findTxt'].'%" or a.business_explane like "%'.$data['findTxt'].'%") order by a.business_nm ';
			break;
			case 3:   //대상자명 
				$ss = 'select count(a.id) as su from desang as a left join field_control as b on (a.saupid = b.id) where '.$whD.' (a.dsname like "%'.$data['findTxt'].'%") order by a.dsname ';
			break;
			case 4:   //대상자명+내용
				$ss = 'select count(a.id) as su from desang as a left join field_control as b on (a.saupid = b.id) where '.$whD.' (a.dsname like "%'.$data['findTxt'].'%" order by a.dsname ';
			break;
			case 5:   //전화번호 
				$ss = 'select count(a.id) as su from desang as a left join field_control as b on(a.saupid = b.id) where '.$whD.' (a.tel like "%'.$data['findTxt'].'%") order by a.tel ';
			
			break;
			}
		
		}else{
		
			if($data['coid'] > 0){
		
				$ss = 'select count(b.id) as su from field_control as a left join desang as b on (a.id = b.saupid) where b.coid = '.$data['coid'].' ';
		
			}else{
				$ss = 'select count(b.id) as su from field_control as a left join desang as b on (a.id = b.saupid) where b.coid > 0 ';
			}
		
		}
		$ss .= " limit ".$data['page'] .",".$data['pagePerNum'];
		


		
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	
	
	}
	
	
	//대상자 사진을 가져온다.
	public function getDesangPhoto($data){
	
		$ss = 'select * from sceneImg where gsid = '.$data['gsid'].' order by dange desc, indx desc, onday desc ';
		$aa = $this->db->query($ss)->result();
		
		
		return $aa;
	}
	
	
	
	//사업의 상세정보를 가져온다.
	public function getSaupSangse($spid){
	
		$sql = 'select a.id, b.id as listid, a.saupid, b.business_nm, b.start_dt, b.end_dt, b.wrmemid, (select name from member where memid = b.wrmemid) as wrname, b.business_explane, a.dsname, a.addr, a.tel, b.coid, (select coname from member x where x.id = b.coid) as conam, (select memid from member y where y.id = b.memid) as memid from field_control as b left join desang as a on(b.id = a.saupid) where b.id = '.$spid.' limit 1';
		$result = $this->db->query($sql)->row();		
		

		return $result;
	
	}
	






	
	
	//대상자 등록을 한다.
	public function onputDesang($data, $mode, $dsid, $dsaup){
	
		$this->db->trans_start();
		
		if($mode == "edit"){
			$this->db->where('id', $dsid);
			$this->db->update('desang', $data); 
			
			//모든 사업과 대상자 정보를 삭제한다.
			//사업이 대상자 정보를 모두 삭제 한다.
			$this->db->delete('saupdesang', array('coid' => $data['coid'], 'desang' => $dsid)); 
			$sp = explode("-", $dsaup); //
			for($c = 0; $c < count($sp); $c++){
				
				$this->db->insert('saupdesang', array('saupid' => $sp[$c], 'desang' => $dsid, 'coid' => $data['coid'])); 
				//$rowid = $this->db->insert_id(); 
			
			}		
			
			$rowid = $dsid;
		}else{
			$this->db->insert('desang', $data); 
			$rowid = $this->db->insert_id(); 
			
			$sp = explode("-", $dsaup);
			for($c = 0; $c < (count($sp) - 1); $c++){

				$this->db->insert('saupdesang', array('saupid' => $sp[$c], 'desang' => $rowid, 'coid' => $data['coid'])); 

			}

		}

		$this->db->trans_complete();		

		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	}
	
	
	//사진등록을 한다.
	public function onputPhoto($data, $dange, $gsid, $mode, $ptid, $fnam){
	
		$this->db->trans_start();
		
		if($fnam != "0"){
			$data['imgname'] = $fnam;
		}

		if($mode == "edit"){
				$this->db->where('id', $ptid);
				$this->db->update('sceneImg', $data); 
		}else{
			$this->db->insert('sceneImg', $data); 
			$rowid = $this->db->insert_id(); 
		}


		$this->db->where('id', $gsid);
		$arr2 = array("dange"=>$dange);
		$this->db->update('gongsa', $arr2); 
		


		$this->db->trans_complete();		

		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	
	}
	

	//공사를 등록한다.
	public function onputGongsa($data, $gsid){
	
		$this->db->trans_start();
		
		if($gsid > 0){  //수정 모드 
			$this->db->where('id', $gsid);
			$this->db->update('gongsa', $data); 
			$rowid = $gsid;
			
			/*
			$this->db->delete('saupdesang', array('gongsa' => $gsid, 'saupid' => $data['saupid'], 'desang')); 
			
			$this->db->where(array('gongsa = ' => $gsid));
			$gs = array("saupid"=>$data['saupid'], "desang"=>$data['dsid'], "gongsa"=>$rowid);
			$this->db->update('gongsa', $data); 
			*/
			
		}else{   //등록모드
			$this->db->insert('gongsa', $data); 
			$rowid = $this->db->insert_id(); 
			
			//$gs = array("saupid"=>$data['saupid'], "desang"=>$data['dsid'], "gongsa"=>$rowid);
			//$this->db->insert('saupdesang', $gs); 
			
		}
		
		$this->db->trans_complete();		

		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	
	}


	
	//사업 등록을 한다.
	public function onputSaup($data, $mode, $listid){
	
		$this->db->trans_start();
		
		if($mode == "edit"){
			$this->db->where('id', $listid);
			$this->db->update('field_control', $data); 
			$rowid = $listid;
		}else{
			$this->db->insert('field_control', $data); 
			$rowid = $this->db->insert_id(); 
		}

		$this->db->trans_complete();		

		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	
	}
	
	
	//상담을 삭제한다.
	public function sangdamDel($arr){
	
		$this->db->trans_start();
		
		$this->db->delete('sangdam', array('id' => $arr['id'])); 
		
		$this->db->trans_complete();
	
	}
	
	
	//대상삭제한다.
	public function delDesang($arr){
	
		$this->db->trans_start();
		

		//공사 삭제
				$ss0 = "select * from gongsa where dsid = ".$arr." ";
				$rowab = $this->db->query($ss0)->result();
				
		foreach($rowab as $gs){
			//공사의 첨부파일 삭제
			$ss = 'select fnam from addfilelist where tb = "gongsa" and recid = '.$gs->id.' ';
			$rowg = $this->db->query($ss)->result();
			foreach($rowg as $fnamg){
				$del_img = FILEUP.$fnamg->fnam;
				unlink($del_img);
			}
		
		}
				
		$this->db->delete('gongsa', array('dsid' => $arr)); 
		
		
		//사진삭제
				$ss1 = "select imgname as fnam from sceneImg where dsrecid = ".$arr." ";
				$rowaa = $this->db->query($ss1)->result();
				foreach($rowaa as $rowa){
					if($rowa->fnam != "0"){
						unlink(PREDIR0."/images/scene/".$rowa->fnam);
						unlink(PREDIR0."/images/scene/thumb/s_".$rowa->fnam);
					}
				}
		$this->db->delete('sceneImg', array('dsrecid' => $arr));
		
		
		//상담삭제 
		$this->db->delete('sangdam', array('desang' => $arr)); 
		
		//사업과 대상자 연동을 삭제 한다.
		$this->db->delete('saupdesang', array('desang' => $arr)); 
		
		
		
		$this->db->delete('desang', array('id' => $arr)); 
		
		$this->db->trans_complete();
	
	}
	
	
	//사업을 삭제한다.
	public function delSaup($sid){
	
		$this->db->trans_start();
		

		//첨부파일 삭제
		$ss = 'select fnam from addfilelist where tb = "field_control" and recid = '.$sid.' ';
		$row = $this->db->query($ss)->result();
		foreach($row as $fnam){
			$del_img = FILEUP.$fnam->fnam;
			unlink($del_img);
		}
		
		
		//사업 공사정보 삭제
		//공사 첨부파일을 삭제한다.
		$ssp = 'select * from gongsa where saupid = '.$sid.' ';
		$rowp = $this->db->query($ssp)->result();
		foreach($rowp as $rgp){
			//공사의 첨부파일 삭제
			$ss = 'select fnam from addfilelist where tb = "gongsa" and recid = '.$rgp->id.' ';
			$rowg = $this->db->query($ss)->result();
			foreach($rowg as $fnamg){
				$del_img = FILEUP.$fnamg->fnam;
				unlink($del_img);
			}
		
		}
		//공사정보 삭제
		$this->db->delete('gongsa', array('saupid' => $sid)); 
		
		
		//공사 이미지를 삭제 한다.
		$sspi = 'select * from sceneImg where sprecid = '.$sid.' ';
		$rowpi = $this->db->query($sspi)->result();
		foreach($rowpi as $rgpi){
		
			unlink(PREDIR0."/images/scene/".$rgpi->imgname);
			unlink(PREDIR0."/images/scene/thumb/s_".$rgpi->imgname);

		}
		$this->db->delete('sceneImg', array('sprecid' => $sid)); 
		
		
		
		//상담정보 삭제 
		$this->db->delete('sangdam', array('saup' => $sid)); 
		
		//echo "kkkkk===".$sid;
		
		
		//대상자를 삭제 한다.
		$sspd = 'select count(id) as su, desang from saupdesang where saupid = '.$sid.' ';
		$rowpd = $this->db->query($sspd)->row();
		if($rowpd->su > 0){
		
			//echo "cccccc====".$rowpd->desang;
			
			
			$sspd2 = 'select count(id) as su from saupdesang where desang = '.$rowpd->desang.' ';
			$rowpd2 = $this->db->query($sspd2)->row();
			if($rowpd2->su == 1){
				//대상자를 삭제 한다.
				$this->delDesang($rowpd->desang);
			}

		}
		
		//사업과 대상자 연결정보 삭제 
		$this->db->delete('saupdesang', array('saupid' => $sid)); 
		
		//사업정보 삭제
		$this->db->delete('field_control', array('id' => $sid)); 
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}else{
			return 1;
		}

	
	}
	
	//공사를 삭제한다.
	public function delGongsa($gid){
	
		$this->db->trans_start();
		

			//공사의 첨부파일 삭제
			$ss = 'select fnam from addfilelist where tb = "gongsa" and recid = '.$gid.' ';
			$rowg = $this->db->query($ss)->result();
			foreach($rowg as $fnamg){
				$del_img = FILEUP.$fnamg->fnam;
				unlink($del_img);
			}
		

		
		//공사 이미지 삭제
		$ss = 'select id, imgname from sceneImg where gsid = '.$gid.' ';
		$rowimg = $this->db->query($ss)->result();
		foreach($rowimg as $simg){
			unlink(PREDIR0."/images/scene/".$simg->imgname);
			unlink(PREDIR0."/images/scene/thumb/s_".$simg->imgname);
		
			$this->db->delete('sceneImg', array('id' => $simg->id)); 
		}
		
		//공사 삭제
		$this->db->delete('gongsa', array('id' => $gid)); 
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}else{
			return 1;
		}

	}
	
	
	//상담을 수정한다.
	public function sangdamEdit($arr){
	
		$this->db->trans_start();

		$arr2 = array("coid"=>$arr['coid'], "wrMemid"=>$arr['wrMemid'], "saup"=>$arr['saup'], "desang"=>$arr['desang'], "content"=>$arr['content'], "memo"=>$arr['memo'], "tit"=>$arr['tit'], "moth"=>$arr['moth'], "mothetc"=>$arr['mothetc'], "sday"=>$arr['sday'], "onday"=>$arr['onday']);

		$this->db->where('id', $arr['listid']);
		$this->db->update('sangdam', $arr2); 
		$this->db->trans_complete();
				
		if ($this->db->trans_status() === FALSE)
		{
			return array("rs"=>"no");
		}else{
			return array("rs"=>"ok");
		}

	}
	
	
	
	//상담을 등록한다.
	public function onputSangdam($data){
	
		$this->db->trans_start();
		
		$this->db->insert('sangdam', $data); 
		$rowid = $this->db->insert_id(); 

		$this->db->trans_complete();		

		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;
		}	

		return $rowid;
	
	}
	
	
	//상담 등록을 한다.-모바일
	public function sangdamOnPut($arr){
	
		$this->db->insert('sangdam', $arr);
	
		return array("rs"=>"ok");
	
	}
	
	
	//상담 상세정보를 가져온다.
	public function getSangdamSS($row){
	
		$ss = 'select a.id, a.gongsaid, b.dsname, a.saup, a.gongsaid, a.coid, a.wrMemid, a.desang, a.content, a.memo, a.tit, a.moth, a.mothetc, a.onday, b.tel, b.htel, b.addr, b.addr2, b.latpo, b.langpo, b.sugub, b.bojang, b.bojangetc, b.gagusu, b.gaguinf, b.gagumemo, b.bday from sangdam as a left join desang as b on(a.desang = b.id) where a.id = '.$row['id'].' ';
		$aa = $this->db->query($ss)->row();
		
		//$aa->dsname = "홍길동";
		
		return $aa;
	}
	
	
		//선택한 사업의 상담리스트를 가져온다.
	public function coSangdamList($row){
		
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
			case "saup":
				$findTxt = ' and (saupnam like "%'.$fndg.'%") ';
				break;
			break;
			case "wrmem":
				$findTxt = ' and (wrName like "%'.$fndg.'%" or wrMemid like "%'.$fndg.'%") ';
				break;
			break;
			case "content":
				$findTxt = ' and (tit like "%'.$fndg.'%" or content like "%'.$fndg.'%") ';
			break;
			case "memo":
				$findTxt = ' and (tit like "%'.$fndg.'%" or memo like "%'.$fndg.'%") ';
			break;
			case "desang":
				
				$cc = ' coid > 0 ';
				if($row["coid"] > 0) $cc = ' coid = '.$row["coid"].' ';
				
				$oo = "select id from desang where dsname like '%".$fndg."%' and ".$cc." ";
				$oor = $this->db->query($oo)->result();
				
				if(count($oor) > 0){
					$nn = " and ( ";
					$yy = 0;
					foreach($oor as $rowo){
						if($yy > 0) $nn .= " or ";
						$nn .= "desang = ".$rowo->id." ";
						$yy++;
					}
					$nn .= " ) ";
				}else $nn = " and id < 0 ";
				

				$findTxt = $nn;
			break;
			}
		}		
		
		
		$ss = 'select id, saup, saupnam, dsname, coid, (select coname from member where id = A.coid) as coname, wrMemid, (select name from member where memid = wrMemid) as wrname, desang, content, memo, tit, moth, tel, mothetc, onday, sday from (';
		$ss .= ' select a.id, a.saup, (select business_nm from field_control where id = a.saup limit 1) as saupnam, (select name from member where memid = a.wrMemid) as wrName, b.dsname, a.coid, a.wrMemid, a.desang, a.content, a.memo, a.tit, a.moth, b.tel, a.mothetc, a.onday, a.sday from sangdam as a';
		$ss .= ' left join desang as b on (a.desang = b.id)';
		$ss .= ') A';
		
		$cc = ' coid > 0 ';
		if($row["coid"] > 0) $cc = ' coid = '.$row["coid"].' '; 
		$ss .= ' where '.$cc.$findTxt;		
		
		
		$ss .= ' order by onday desc ';
		$ss .= " limit ".$row['page'] .",".$row['pagePerNum'];
		$aa = $this->db->query($ss)->result();
		
		
		return $aa;

	}

	public function coSangdamListTotalCount($row){
		
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
			case "saup":
				$findTxt = ' and (saupnam like "%'.$fndg.'%") ';
				break;
			break;
			case "wrmem":
				$findTxt = ' and (wrName like "%'.$fndg.'%" or wrMemid like "%'.$fndg.'%") ';
				break;
			break;
			case "content":
				$findTxt = ' and (tit like "%'.$fndg.'%" or content like "%'.$fndg.'%") ';
			break;
			case "memo":
				$findTxt = ' and (tit like "%'.$fndg.'%" or memo like "%'.$fndg.'%") ';
			break;
			case "desang":
				
				$cc = ' coid > 0 ';
				if($row["coid"] > 0) $cc = ' coid = '.$row["coid"].' ';
				
				$oo = "select id from desang where dsname like '%".$fndg."%' and ".$cc." ";
				$oor = $this->db->query($oo)->result();
				
				if(count($oor) > 0){
					$nn = " and ( ";
					$yy = 0;
					foreach($oor as $rowo){
						if($yy > 0) $nn .= " or ";
						$nn .= "desang = ".$rowo->id." ";
						$yy++;
					}
					$nn .= " ) ";
				}else $nn = " and id < 0 ";
				

				
				$findTxt = $nn;
			break;
			}
		}		
		
		
		$ss = 'select count(id) as su from (';
		$ss .= ' select a.id, a.saup, (select business_nm from field_control where id = a.saup limit 1) as saupnam, (select name from member where memid = a.wrMemid) as wrName, b.dsname, a.coid, a.wrMemid, a.desang, a.content, a.memo, a.tit, a.moth, b.tel, a.mothetc, a.onday, a.sday from sangdam as a';
		$ss .= ' left join desang as b on (a.desang = b.id)';
		$ss .= ') A';
		
		$cc = ' coid > 0 ';
		if($row["coid"] > 0) $cc = ' coid = '.$row["coid"].' '; 
		$ss .= ' where '.$cc.$findTxt;		
		
		
		$ss .= ' order by onday desc ';
		$aa = $this->db->query($ss)->row();
		
		
		return $aa;

	}
	
	
	//대상자의 이름을 가져온다.
	public function getDesangNam($data){
	
		$ss = 'select dsname from desang where id = '.$data['id'].' ';
		$aa = $this->db->query($ss)->row();
		
		return $aa;
	}
	

	
	
	
	
	//업체의 대상자 리스트를 가져온다.
	public function getCoDesang($coid){
	
		$ss = 'select * from desang where coid = '.$coid.' order by dsname ';
		$aa = $this->db->query($ss)->result();
		
		return $aa;
	}
	
	

	
	
	//사진을 삭제한다.
	public function photoDel($did){
	
		$ss = 'select imgname from sceneImg where id = '.$did.' limit 1 ';
		$row = $this->db->query($ss)->row();
		$imgN = $row->imgname;
		
		$this->db->trans_start();
		
		$this->db->delete('sceneImg', array('id' => $did)); 
		
		//이미지를 삭제한다.
		$del_img = PREDIR0."/images/scene/".$imgN;
		unlink($del_img);
		
		$del_img = PREDIR0."/images/scene/thumb/s_".$imgN;
		unlink($del_img);
		
		
		
		$this->db->trans_complete();
		
		/*
		if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}else{
			return $imgN;
		}
		*/
		
		return $imgN;
		
	}
	
	
	

	
	//이미지리스트를 가져온다.
	public function getPhoto($gsid){
	
		$ss = 'select id, imgname from sceneImg where gsid = '.$gsid.' order by dange desc, indx desc, onday desc';
		return $this->db->query($ss)->result();
	
	}
	
	
	//이미지 파일을 업로드 한다.
	public function imgUppro($row){
		$ad_date = date("Y-m-d H:i:s");
	
	//$arrgab = array("saupRec"=>(int)$this->input->post('seSaup', TRUE), "gsRec"=>(int)$this->input->post('seRec', TRUE), "wrMem"=>$this->input->post('memid', TRUE), "memo"=>$this->input->post('memo', TRUE), "fname"=>$rsfilenam);
		//$arrgab = array("saupRec"=>$this->input->post('seSaup', TRUE), "dsRec"=>$this->input->post('seRec', TRUE), "memid"=>$this->input->post('seMemid', TRUE), "wrMem"=>$this->input->post('memid', TRUE), "memo"=>$this->input->post('memo', TRUE));
	
		$gs = $this->getDesangInfo((int)$row['gsRec']);
	
	
		//db에 파일 정보를 저장한다.
		$data = array("gsid"=>$row['gsRec'], "dange"=>$gs->dange, "wrmemid"=>$row['wrMem'], "desangmemid"=>$gs->dsname, "dsrecid"=>$gs->id, "sprecid"=>$row['saupRec'], "memo"=>$row['memo'], "imgname"=>$row['fname'], "onday"=>$ad_date);
		$this->db->insert('sceneImg', $data); 
		//$rowid = $this->db->insert_id(); 
		
		echo "imgok";
	
	}



	
}


?>

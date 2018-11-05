<?php

class Cupon extends CI_Model{
	function __construct(){
		parent::__construct();
		
		
	}
	
	//이메일 중복확인
	public function findReEmail($email){
	
			//앨범에 사전등록여부를 확인
			$wh = array("email" => $email);
			$this->db->select('count(id) as su')->from('member')->where($wh)->order_by("id", "desc");
			$obj = $this->db->get()->row();
			
			return $obj;
	
	}
	
	
	//노래자랑 등록 
	public function uploadMb($tit, $content, $email, $fnam){
	
			$rr = 1;
			$this->db->trans_start();
			$sday = date("Y-m-d H:i:s", time());
			//이미지 업로드 DB처리 
			$idata = array("onemail"=>$email, "tit"=>$tit, "content"=>$content, "fname"=>$fnam, "onday"=>$sday);
			$this->db->insert('myjarang', $idata); 					
			
				$this->db->trans_complete();		
				if ($this->db->trans_status() === FALSE)
				{
					$rr = 0;
				}
				
			return $rr;
	
	}
	
	//나의 노래자랑 가져오기 
	public function getMyJarangAll($email){
	
			//앨범에 사전등록여부를 확인
			$wh = array("onemail" => $email);
			$this->db->select('*')->from('myjarang')->where($wh)->order_by("id", "desc");
			$obj = $this->db->get()->result();
			
			return $obj;
	
	}
	

	//나의 노래자랑 가져오기 
	public function getJarangBest($su){
	
			//앨범에 사전등록여부를 확인
			$wh = array("mlike >= " => 0);
			if($su > 0){
				$this->db->select('*')->from('myjarang')->where($wh)->order_by("mlike", "desc")->limit($su);
			}else{
				$this->db->select('*')->from('myjarang')->where($wh)->order_by("mlike", "desc");
			}
			$obj = $this->db->get()->result();
			
			return $obj;
	
	}
	
	//나의 노래자랑 가져오기 
	public function getJarangNew($su){
	
			//앨범에 사전등록여부를 확인
			$wh = array("stat" => 1);
			if($su > 0){
				$this->db->select('*')->from('myjarang')->where($wh)->order_by("id", "desc")->limit($su);
			}else{
				$this->db->select('*')->from('myjarang')->where($wh)->order_by("id", "desc");
			}
			$obj = $this->db->get()->result();
			
			return $obj;
	
	}

	
	//앨범에 노래 설정
	public function seAlbumSet($sid, $alid, $email){
	
		$rr = "ok";
		$aa = explode("/", $sid);
		for($c = 0; $c < (count($aa) - 1); $c++){
			//앨범에 사전등록여부를 확인
			$wh = array("email" => $email, "songid" => $aa[$c], "gubun" => $alid);
			$this->db->select('count(id) as su')->from('myalbum')->where($wh)->order_by("id", "desc");
			$obj = $this->db->get()->row();
			if($obj->su > 0){
				
			}else{

				$wh = array("a.songid" => $aa[$c]);
				$this->db->select('a.fdir, a.prefix, a.endfix, a.songid, b.gasu, b.tit')->from(' mr_s_AAmusic_sangse as a left join mr_s_AAmusic_bas as b on(a.basid = b.id) ')->where($wh);
				$kk = $this->db->get()->row();
				
				
				$this->db->trans_start();
				$sday = date("Y-m-d H:i:s", time());
				//다운로드 준비 레코드를 만들어 둔다.
				$idata = array("email"=>$email, "tit"=>$kk->tit, "songid"=>$kk->songid, "onday"=>$sday, "fdir"=>$kk->fdir, "endfix"=>$kk->endfix, "gubun"=>$alid);
				$this->db->insert('myalbum', $idata); 					
				
					$this->db->trans_complete();		
					if ($this->db->trans_status() === FALSE)
					{
						//$rr = 0;
					}
		
			}
	
		}
	
		return $rr;
	}
	
	
	//앨범삭제
	public function albumEdit($did, $tit){
	
		$this->db->trans_start();
		
			$sday = date("Y-m-d H:i:s", time());
						
					$ud = array("tit"=>$tit, "onday"=>$sday);
					$wh = array("id"=>$did);
					$this->db->where($wh)->order_by("id")->limit(1);
					$this->db->update('albumgubun', $ud); 
 
		
		$this->db->trans_complete();
		
		return 1;
	
	}
	
	
	//앨범삭제
	public function albumDel($did){
	
		$this->db->trans_start();
		
		$this->db->delete('albumgubun', array('id' => $did)); 
		
		$this->db->trans_complete();
		
		return 1;
	
	}
	
	//나의 앨범을 가져온다.
	public function getMyAlbumAllUl($email){
	
		$wh = array("a.email" => $email);
		$this->db->select(' a.id, a.songid, a.fdir, a.endfix, a.gubun, a.tit, a.onday, b.tit as albumtit ')->from(' myalbum as a left join albumgubun as b on(a.gubun = b.id) ')->where($wh)->order_by("a.gubun","desc")->order_by("a.id","desc");
		$obj = $this->db->get()->result();


		$rr = '{"rs":[';
		$cc = 0;
		foreach($obj as $row){
			if($cc > 0) $rr .= ',';
			
			$rr .= '{"gubun":'.$row->gubun.', "albumtit":"'.$row->albumtit.'", "tit":"'.$row->tit.'", "songid":"'.$row->songid.'", "fdir":"'.$row->fdir.'", "endfix":"'.$row->endfix.'", "onday":"'.$row->onday.'"}';
			
			$cc++;
		}
		$rr .= ']}';
		
		return $rr;
	
	}
	
	//설정한 모든 앨범값을 가져온다.
	public function getMyAlbumAll($email){
	
		$wh = array("email" => $email);
		$this->db->select('*')->from('albumgubun')->where($wh)->order_by("id", "desc");
		$obj = $this->db->get()->result();
		
		return $obj;
	
	}
	
	//앨범추가
	public function albumAddPro($email, $tit){
	
		$rr = 1;
		$wh = array("email" => $email, "tit" => $tit);
		$this->db->select('count(id) as su')->from('albumgubun')->where($wh)->order_by("id", "desc");
		$obj = $this->db->get()->row();

		if($obj->su < 1){
			
			$this->db->trans_start();
			$sday = date("Y-m-d H:i:s", time());
			//다운로드 준비 레코드를 만들어 둔다.
			$idata = array("email"=>$email, "tit"=>$tit, "onday"=>$sday);
			$this->db->insert('albumgubun', $idata); 					
			
				$this->db->trans_complete();		
				if ($this->db->trans_status() === FALSE)
				{
					$rr = 0;
				}
		
		}else{
			$rr = "re";
		}

		return $rr;
	}
	
	//쿠폰에 음원다운로드시 다운로드 설정을 한다.
	public function setDown($cpid, $sid){
	
		$this->db->select('stat')->from('cupon')->where("id",$cpid)->limit(1);
		$obj = $this->db->get()->row();
		
		if($obj->stat == 2){
		
			$this->db->trans_start();
		
			$sday = date("Y-m-d H:i:s", time());
						
					$ud = array("songid"=>$sid, "downday"=>$sday,"stat"=>2);
					$wh = array("ygrid"=>$cpid, "stat"=>1);
					$this->db->where($wh)->order_by("id")->limit(1);
					$this->db->update('mrDownmp', $ud); 
					
				$this->db->trans_complete();		
				if ($this->db->trans_status() === FALSE)
				{
					$cpid = 0;
				}

		}else{
			$cpid = "not";
		}
	
		return $cpid;
	
	}
	
	
	//쿠폰을 사용하는 것으로 설정 한다.(시작날자, 종료날짜)
	public function cuponUser($email, $cid){
	
		$this->db->trans_start();
	
		$sday = date("Y-m-d H:i:s", time());
		
		$year = date('Y');
   		$month = date('m');
   		$day = date('d');
		
		$hh = date('H');
		$mm = date('i');
		$ss = date('s');
		
		$eday = date("Y-m-d H:i:s", mktime( $hh, $mm, $ss, $month, $day+30, $year ));
		
				$ud = array("sday"=>$sday, "eday"=>$eday, "stat"=>2);
				$this->db->where('id', $cid)->limit(1);
				$this->db->update('cupon', $ud); 
				
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$cid = 0;
			}
	
		return $cid;
	}
	
	//구입한 쿠폰의 정보를 출력
	public function downmp($email){
		$wh = array("email" => $email, "gubun > " => 1);
		$this->db->select('*')->from('cupon')->where($wh)->order_by("id", "desc");
		$obj = $this->db->get()->result();
		
		$su = count($obj);
		
		///*
		if($su > 0){
			foreach($obj as $row){
				//잔여 곡수를 반환 한다.
				$whh = array("ygrid" => $row->id, "stat = " => 1);
				$this->db->select('count(id) as su')->from('mrDownmp')->where($whh)->group_by("ygrid");
				$rrt = $this->db->get()->row();
				$row->jansu = $rrt->su;
				
				$ud = array("jansu"=>$rrt->su);
				$this->db->where('id', $row->id)->limit(1);
				$this->db->update('cupon', $ud); 

			}
		}else{
			$obj = "not";  //결재한 쿠폰이 없다.
		}
		//*/
		
		return $obj;
	}
	
	//mp3구매 리스트
	public function gumeMpList($email){
		
		$sql = "select b.don, b.tit, b.daysu, a.downday, a.stat, b.id, c.fdir, c.prefix, c.endfix, c.songid, d.tit as mptit from mrDownmp as a left join cupon as b on(a.ygrid = b.id) left join mr_s_AAmusic_sangse as c on(a.songid = c.songid) left join mr_s_AAmusic_bas as d on(c.basid = d.id) where a.email = '".$email."' and a.stat > 1 and a.songid <> '0' order by a.downday desc";
		$obj = $this->db->query($sql)->result();	
		
		
		return $obj;
	}
	
	
	//쿠폰요금제를 출력한다.
	public function gumeyg($email){
		$this->db->select('*')->from('cupon')->where("email", $email)->order_by("id", "desc");
		$obj = $this->db->get()->result();	
		
		return $obj;
	}
	
	
	//쿠폰구매 처리 및 다운로드 레코드 처리
	public function gumeOn($data){
	
			$this->db->trans_start();
	
			switch($data['gubun']){
			case 1:  //24시간 스트리밍
				$gg = 0;
			break;
			case 2:  //10곡
				$gg = 10;
			break;
			case 3:  //30곡
				$gg = 30;
			break;
			case 4:  //50곡
				$gg = 50;
			break;
			}
			$data['jansu'] = $gg;
	
			$this->db->insert('cupon', $data); 		
			$rowid = $this->db->insert_id();
	
			
			//다운로드 준비 레코드를 만들어 둔다.
			$idata = array("ygrid"=>$rowid, "gubun"=>$data['gubun'], "email"=>$data['email'], "tit"=>$data['tit'], "stat"=>1);
			for($c = 0; $c < $gg; $c++){
				$this->db->insert('mrDownmp', $idata); 					
			}
			
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
			
			return $rowid;
			
	}
	
	
	//나의 주문내역을 가져온다.
	public function myJumunList($email){
	
		$this->db->select('*')->from('jumun')->where("email", $email)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	

	//전체 주문내역을 가져온다.
	public function alljumun(){
	
		$this->db->select('*')->from('gandanQ')->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	


	//주문등록 
	public function jumunonput($data, $datamd){
	
		if($datamd["idmd"] == "on"){
		
			$this->db->trans_start();
	
			$this->db->insert('jumun', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
		
		}else{
		
				$this->db->trans_start();
		
				$this->db->where('id', $datamd["idgab"])->limit(1);
				$this->db->update('jumun', $data); 
				$rowid = $datamd["idgab"];
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
		
		}
	
		return $rowid;
	
	}

	
	

	//간단문이 등록 
	public function munonput($data, $datamd){
	
		if($datamd["idmd"] == "on"){
		
			$this->db->trans_start();
	
			$this->db->insert('gandanQ', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}
		
		}else{
		
				$this->db->trans_start();
		
				$this->db->where('id', $datamd["idgab"])->limit(1);
				$this->db->update('gandanQ', $data); 
				$rowid = $datamd["idgab"];
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
		
		}
	
		return $rowid;
	
	}





	
}


?>

<?php

class Member extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	
	
	
	
	//==================================
	//신고회 리스트
	//===================================
	public function singoListAll($wh = "0", $limit = 0){

		$this->db->trans_start();
		
		if($wh != "0"){
			$this->db->where($wh);
		}
		if($limit > 0){
			$this->db->limit($limit);
		}
		
		$this->db->order_by("onday desc");
		
		$row = $this->db->get('singoAll')->result();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;  //수정 실패 이다.
		}
		
		return $row;
	
	}
	//==================================
	//전체회원리스트를 가져온다.
	//===================================
	public function memListAll($wh = "0"){

		$this->db->trans_start();
		
		if($wh != "0"){
			$this->db->where($wh);
		}
		
		$row = $this->db->get('member')->result();
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$rowid = 0;  //수정 실패 이다.
		}
		
		return $row;
	
	}
	//==================================
	//회원의 정보를 가져온다.
	//===================================
	public function memInfoId($memid){

		$this->db->select('a.*, b.id, b.actgubun')->from('member as a left join memberAct as b on(a.memid = b.memid)')->where('a.memid = ', $memid)->limit(1);
	
		return $this->db->get()->row();
	
	}
	//========================================
	//관리자를 추가한다.
	//=========================================
	public function setAdminAct($arr, $memid, $actgubun, $id){
	
			$this->db->where('id', $id);
			$this->db->update('member', $arr); 
			
			$this->db->select('count(actgubun) as su')->from('memberAct')->where('memid = "'.$memid.'" and actgubun = '.$actgubun.' ');
			$su = $this->db->get()->row();
			if($su->su > 0){	
				//$this->db->where('memid', $memid);
				//$uarr = array("actgubun"=>$actgubun);
				//$this->db->update('memberAct', $uarr);
				$rowid =  1; 
			}else{
				$day = date("Y-m-d H:i:s");
				$uarr = array("memid"=>$memid, "actgubun"=>$actgubun, "actonday"=>$day);
				$this->db->insert('memberAct', $uarr); 	
				$rowid =  1; 	
			}
			
	
		return $rowid;
	}
	//============================================








	//회원정보 수정을 위해 정보를 가져온다.
	public function myInfo($em){
			
		$this->db->select('*')->from('member')->where('email = ', $em)->limit(1);
		$obj = $this->db->get()->row();
	
		return $obj;
	}

	//비밀번호 변경 
	public function passchange($data, $datamd){
		$rr = $this->getEmailId($datamd["email"]);
		$rowid = $rr->su;
		if($datamd["oldpass"] == $rr->passwd){
			if($rowid > 0){
			
					$this->db->trans_start();
					
					$this->db->where('id', $rr->id)->limit(1);
					$this->db->update('member', $data); 
					$rowid = $rr->id;
							
					$this->db->trans_complete();
					
					if ($this->db->trans_status() === FALSE)
					{
						$rowid = 0;  //수정 실패 이다.
					}
			}
		}else{
			$rowid = "dif";
		}
		
		return $rowid;
	
	}


	//신규회원등록을 한다.
	public function onMemberData($data, $datamd){

		$rr = $this->getEmailId($data["email"]);
		$rowid = $rr->su;
		

		if($datamd["idmd"] == "on" and $rr->su < 1){   //회원 가입 처리

			$this->db->trans_start();
	
			$this->db->insert('member', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}

		}else{
			if($datamd["idmd"] != "on"){
				//수정모드 
				$this->db->trans_start();
		
				if(!$data['passwd']) $data['passwd'] = $rr->passwd;  //비밀번호 변경하지 않는 경우
		
				$this->db->where('id', $rr->id)->limit(1);
				$this->db->update('member', $data); 
				$rowid = $rr->id;
						
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$rowid = 0;  //수정 실패 이다.
				}
				
			}else{
				$rowid = "two";  //이미 가입된 회원이다.
			}
		}



		return $rowid;
	}
	

	
	
	//이메일 중복확인을 한다.
	public function getEmailId($mid){
	
		$ss = 'select count(email) as su, id, passwd from member where email = "'.$mid.'" ';
		$row = $this->db->query($ss)->row();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $row;   // .$mid.var_dump($su)."||".$su[0];
	}
	
	


	//비밀번호 찾기를 한다.
	public function onFindMemPw($tel, $em){
		
		$ttl = base64encode(str_replace("-", "", $tel));
		$ss = 'select count(name) as su, id, passwd from member where tel = "'.$ttl.'" and email = "'.$em.'"';
		$row = $this->db->query($ss)->row();
		
		if($row->su > 0){

			$this->email->from('g1915@naver.com', 'MROO');
			$this->email->to($em); 
			//$this->email->cc('another@another-example.com'); 
			//$this->email->bcc('them@their-example.com'); 
			$imsi = base64decode($meminf->passwd); //base64encode("1234");
			
			
			$this->email->subject('임시비밀번호 발송');
			$this->email->message('MROO 관리자 입니다. 로그인을 위한 임시비밀번호는 "'.$imsi.'" 입니다.');	
			
			$this->email->send();
				
		}
		
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $row;   // .$mid.var_dump($su)."||".$su[0];
	}
		


	
	public function onFindMemId($name, $tel){
		
		$ttl = base64encode(str_replace("-", "", $tel));
		$ss = 'select count(name) as su, email from member where name = "'.$name.'" and tel = "'.$ttl.'"';
		$row = $this->db->query($ss)->row();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $row;   // .$mid.var_dump($su)."||".$su[0];
	}
	
	
	public function getLoginW($mid, $pss){
		$ss = 'select count(memid) as su, id, tel, email, name, potion, cogubun, coid, stat, passwd from member where memid = "'.$mid.'" and passwd = "'.$pss.'" ';
		$su = $this->db->query($ss)->row();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $su;   // .$mid.var_dump($su)."||".$su[0];
	}
	
	

	public function getLogin($mid, $pss){
		$ss = 'select count(memid) as su, id, tel, email, nicname, name, potion, cogubun, coid, stat, passwd from member where email = "'.$mid.'" and passwd = "'.$pss.'" ';
		$su = $this->db->query($ss)->row();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $su;   // .$mid.var_dump($su)."||".$su[0];
	}
	

	
	//캡챠를 확인한다ㅣ.
	public function captchaInf($arr){
	
		//캡차를 확인 한다.
		$ss = "select count(captcha_id) as su from captcha where captcha_time = ".$arr['time']." and ip_address = '".$arr['ip']."' and word = '".$arr['word']."'  ";
		$row = $this->db->query($ss)->row();
		
		return $row->su;
	}
	

	

	
	//수신자의 레코드을 아이디로 memid를 반환한다.
	public function susinMemid($sumem){
		if($sumem['susin'] == "all"){
			
			//가입회원 전체를 반환한다.
			if($sumem['coid'] == BONSAID){
				if($sumem['seGab'] == 0){
					//모든 가입 회원에게 발송 한다.
					$array = array('stat = ' => 2);
				}else{
					//선택한 업체에 발송의 모든회원에게 발송.
					$array = array('stat = ' => 2, 'coid = ' => $sumem['seGab']);
				}
			}else{
				$array = array('stat = ' => 2, 'coid = ' => $sumem['coid']);
			}
			$this->db->select('memid, email')->from('member')->where($array);
			$obj = $this->db->get()->result_array();
		}else{
			$mm = explode("-", $sumem['susin']);
			//echo "====".$mm[0];
			for($c =0; $c < count($mm); $c++){
				$array = array('id = ' => $mm[$c]);
				$this->db->select('memid, email')->from('member')->where($array);
				$rr = $this->db->get()->row();
				$obj[] = array("memid" => $rr->memid, "email"=> $rr->email); 
			}
		}
		return $obj;
	}
	
	



	
	//회원삭제 한다.
	public function memDelOk($mid, $po){

		
		$coidr = $this->myInfoRow($mid);
		
		
		$this->db->trans_start();
		
		$data = array(
               'tel' => "***", "email" => "***", "juminnum" => "***", "conum" => "***", "passwd" => "***", "stat" => 4
            );

		if($coidr->potion > 4){
			//슈퍼관리자를 삭제 하면 하위 직원도 모두 삭제 한다.
			$this->db->where('coid', $coidr->coid);
			$this->db->update('member', $data); 
		}else{
			$this->db->where('id', $mid);
			$this->db->update('member', $data); 
		}

		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$mid = 0;
		}
		
		return $mid;
	}
	

	
	//메시지와 메일의 수신가능자 리스트
	//업체 아이디 0: 전체 가입자이 리스트, > 0: 업체의 가입자 리스트
	public function susinMemList($row){
		$fndg = $row['fnd'];
		
		

		if(!$fndg){
			$findTxt = "";
		}else{
			$findTxt = ' and (memid like "%'.$fndg.'%" or name like "%'.$fndg.'%" or coname like "%'.$fndg.'%" or tel like "%'.base64encode($fndg).'%" or email like "%'.$fndg.'%" or conum like "%'.$fndg.'%") ';
		}
		
		
		if($row['secoid'] == 0){
			//전체 업체에 발송 
			$wh = ' stat = 2 '.$findTxt;
			
		}else{
			//선택한 업체에 발송 
			$wh = ' stat = 2 and coid = '.$row['secoid'].' '.$findTxt;
			
		}
		
		
		$ss = 'select id, memid, name, tel, potion, cogubun, coname, gubun, onday from member where '.$wh.' order by cogubun desc, gubun asc';
		$obj = $this->db->query($ss)->result();
		

		return $obj;

	}
	
		



	//회원정보
	public function myInfoRow($rid){
	
		$this->db->select('*')->from('member')->where('id = ', $rid);
		$obj = $this->db->get()->row();
		
		return $obj;
	
	}
	

	
	//회원의 현재 비밀번호를 가져온다. 
	public function myPass($rid){
	
		$this->db->select('passwd')->from('member')->where('id = ', $rid);
		$obj = $this->db->get()->row();
		
		return $obj;
	
	}
	
	

	
	//해당아이디의 멤버존재여부 숫자로 표시
	public function getMemId($mid){
		
		$ss = 'select count(memid) as su from member where memid = "'.$mid.'" ';
		$row = $this->db->query($ss)->result_array();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $row[0]['su'];   // .$mid.var_dump($su)."||".$su[0];
	}
	
	
		//사업자 번호 중복확인을 한다.
	public function getSaupNum($sn){
	
		$ss = 'select count(memid) as su, conum from member where conum = "'.$sn.'" ';
		$row = $this->db->query($ss)->result_array();
		
		//echo $mid.var_dump($su)."||".$su[0]['su'];
		return $row;   // .$mid.var_dump($su)."||".$su[0];
	}
	
	



	
}


?>

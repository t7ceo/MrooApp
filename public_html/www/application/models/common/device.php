<?php

class Device extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//삭제테이블을 삭제한다.
	public function setDelFile($type, $uid, $name){
	
		$this->db->delete('newDidDel', array('type' => $type, 'uid' => $uid, 'name' => $name)); 
		
		return '{"rs":"ok"}';
	}
	
	
	//삭제할 파일이름을 반환한다.
	public function getDelFile($type, $uid){
	
		$wh = array("type"=>$type, "uid"=>$uid);
		$this->db->select('*')->from('newDidDel')->where($wh);
		$obj = $this->db->get()->result();
	
		return $obj;
	
	}
	
	
	//파일을 삭제대기 상태로 만든다.
	public function delOn($type, $uid, $name){
		
		$this->db->insert('newDidDel', array('type' => $type, 'uid' => $uid, 'name' => $name));
		
		$wh = array("type"=>$type, "uid"=>$uid, "name"=>$name);
		$this->db->where($wh);
		$arr2 = array("delinf"=>"del");
		$this->db->update('newDidFileList', $arr2); 
		
		return '{"rs":"ok"}';
	
	}
	
	//앱의 생존기록
	public function liveWr($type, $msg, $uid, $uuid){
	
		$day = date("Y-m-d H:i:s", time());
	
		$this->db->insert('newDidLive', array('type' => $type, 'didip' => $_SERVER['REMOTE_ADDR'], 'wday' => $day, 'uid' => $uid, 'mess' => $msg, 'uuid' => $uuid));
		return '{"rs":"ok"}';
	
	}
	
	
	//로컬파일의 리스트를 저장한다.
	public function localList($type, $fil, $uid, $uuid){
	
		$this->db->delete('newDidFileList', array('uid' => $uid)); 
		
		$ff = explode(",", $fil);
		for($c=0; $c < count($ff); $c++){
			$this->db->insert('newDidFileList', array('type' => $type, 'didip' => $_SERVER['REMOTE_ADDR'], 'uid' => $uid, 'name' => $ff[$c], 'uuid' => $uuid));
		}
		
		return '{"rs":"ok"}';
	
	}
	
	
	//새로운 영상정보를 가져온다.
	public function newMove($type){
	
		$this->db->select('*')->from('newmov')->where("type", $type)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	
	
	//나의 주문내역을 가져온다.
	public function myDevice($email){
	
		$this->db->select('*')->from('device')->where("email", $email)->order_by("id","desc");
		$obj = $this->db->get()->result();
	
		return $obj;
	}
	
	//기기의 존재여부 확인
	public function deviceInf($data){
	
		$this->db->select('count(email) as su')->from('device')->where("email = ", $data['email'])->where("stat = ",1);
		$obj = $this->db->get()->row();
		
		if($obj->su < 2){
			$this->db->select('count(device) as su')->from('device')->where("device = ", $data['device'])->where("cosa = ", $data['cosa'])->where("email = ", $data['email']);
			$obj2 = $this->db->get()->row();
			$su = $obj2->su;

		}else{
			$su = 9;
		}
	
		return $su;
	}
	
	
	//쿠폰구매등록
	public function deviceOn($data){
	
		$su = $this->deviceInf($data);
		if($su < 2){
			$this->db->trans_start();
	
			$this->db->insert('device', $data); 		
			$rowid = $this->db->insert_id();
	
	
			$this->db->trans_complete();		
			if ($this->db->trans_status() === FALSE)
			{
				$rowid = 0;
			}		
		}else{
			$rowid = 0;
		}
	
		return $rowid;
			
	}



	
}


?>

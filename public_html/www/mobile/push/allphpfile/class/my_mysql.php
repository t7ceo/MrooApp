<?
/*======================================================================================================
�� ������		::	
�� ���ʰ�����	::	5�� 27��
�� ������		::	
�� ����Ʈ		::	http://twin7.co.kr
�� ������		::	�輺��
�� ������		::	2013�� 5�� 27��
======================================================================================================*/
//����ϴ� ���̺�
//Anyting_gcmid

class MyMySQL extends MySQL
{
	//udid �� ���� ������ ��� ���� �Ѵ�.
	function errUdidRecDelete($inf){
		$ss = "delete from Anyting_gcmid where (udid = '' or udid = null or udid = 'udid error') ";
		$this->query($ss);
		

	}

	//gcm id ���� �ش� �ϴ� ���ڵ带 ���� �Ѵ�.
	function delGcmIdRec($did){
		$ss = "delete from AAmyGcm where id = ".$did." limit 1";
		parent::query($ss);
	}

	//gcm �� mypo ���� ���ο� ���� ������ ���ÿ� ���ڵ� ���� �Ѵ�.
	function delMyPoGcmRec($did){
		$ss = "delete from AAmyGcm where recnum = ".$did." limit 1";
		parent::query($ss);
		
		$ss = "delete from AAmyPo where messid = ".$did." limit 1";
		parent::query($ss);
	}



	
	//���ο� �޽����� Ȯ���� ���� ���� ó�� �Ѵ�.
	function newmessDel($memid, $udid, $messcom){
		$rt = "ok";
		$smff = "delete from AAmyPo where companyid = '".$messcom."' and tomemid = '".$memid."'  ";  
		if(parent::query($smff)){
			$smff1 = "delete from AAmyGcm  where  (tomemid = '".$memid."' or tomemid = 'All')  and  companyid  = '".$messcom."' and  udid = '".$udid."' ";  		
			if(parent::query($smff1)){
				$rt = "ok";		
			}else{
				$rt = "err";
			}
		}else{
			$rt = "err";
		}
		return $rt;
	}
	
	
	//���� udid ���� ���� �´�.
	function getUdid($memid, $project){
		
		$udid = parent::get_result("Anyting_memberAdd", "memid =  '".$memid."' and project = '".$project."'   limit 1 ", "udid");
		
		if(!$udid || $udid == "0"){
			$udid = parent::get_result("Anyting_gcmid", "memid =  '".$memid."'  and project = '".$project."' limit 1 ", "uiu");
		}
		
		return $udid;
	}

	//project ���� ���� �´�..
	function getProject1($project, $uiug, $myid){
		
		if(!$project){
			$proj = parent::get_result("Anyting_gcmid", " udid = '".$uiug."' and memid = '".$myid."'   limit 1", "project");
		}else{
			$proj = $project;
		}
		
		return $proj;
	}


	
	//gcmid �� ���Ӱ� ���� �Ѵ�.
	function editGCMID($regid, $udid, $pnum, $project){
		//�ش� ������Ʈ�� ������ ����� gcmid �� �ִ��� Ȯ�� �Ѵ�.
		$wh = " udid = '".$udid."' ";
		if($this->get_count("Anyting_gcmid", $wh) > 0){
			//$wh1 = " gcmid = '".$regid."' and udid = '".$udid."'  ";
			//$arr = Array( 'login' => 'kok', 'project' => 'autocampcc' );  //$project.'ko');
			//MySQL::sql_update("Anyting_gcmid", $arr, $wh1);
			
			$rr = "update Anyting_gcmid set login='rok', phonum='".$pnum."', project='".$project."', gcmid='".$regid."' where udid = '".$udid."'  ";
			$this->query($rr);
		}else{
			$gcmid = "okN";
			if(!$udid) $udid = "udid New";
			//$arr = Array( 'udid' => "$udid", 'gcmid' => "$regid", 'project' => "$project", 'login' => "$gcmid");
			/*
			$arr['udid'] = $udid;
			$arr['gcmid'] = $regid;
			$arr['project'] = $project;
			$arr['login'] = $gcmid;
			
			$this->sql_insert("Anyting_gcmid", $arr);
			*/
			
			
			$aa = "insert into Anyting_gcmid (udid, phonum, gcmid, project, login)values('".$udid."', '".$pnum."', '".$regid."', '".$project."','".$gcmid."' )";
			$this->query($aa);
		}
	}






}
?>
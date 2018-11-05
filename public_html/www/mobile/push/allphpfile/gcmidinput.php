<?
//==========================================================
include 'config.php';
//include 'util.php';
//==========================================================
//위에서 처리하는 것은
//==========================================================
include_once $my_path.'class/class_mysql.php';  //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스
//==========================================================
	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
//==========================================================
//위에서 처리 하는 것은 
//==========================================================

	if(!$_POST[phonenum]) $_POST[phonenum] = "000-000-000";    //폰의 번호가 넘어 오지 않는 경우 강제로 임의의 폰번호를 설정한다.

	$ad_date = date("Y-m-d H:i:s");     //현재 날짜와 시간을 가져온다.
	
	
	//Anyting_gcmid 테이블에 현재 등록된 레코드중 회원 아이디 없는 레코드는 삭제 한다.
	$ddk = "delete from Anyting_gcmid where (memid = '' or memid = ' ' or udid = '0' or udid = ' ') and project = '".$project."' ";
	$dd2 = mysql_query($ddk, $rs);
	
	
	
	//푸시받는 회원 테이블에서 회원 아이디로 회원정보를 찾는다.
	//$project 는 config.php 파일에 정의 되어 있으며 값은 "hcchd" 이다. 
	$ss = "select * from Anyting_gcmid where udid = '".$_POST['udid']."' and project = '".$project."' limit 1";
	$rr = mysql_query($ss, $rs);
	if(mysql_num_rows($rr) > 0){
		
		$row = mysql_fetch_array($rr);
		
		//기존의 회원 정보가 있는 경우 클라이언트에서 넘어온 값으로 회원정보를 수정한다.
		$aa = "update Anyting_gcmid set phonum = '".$_POST['phonenum']."', gcmid = '".$_POST['regid']."', memid = '".$_POST['memid']."', endtime = '".$ad_date."', login = 'ok' where id = ".$row['id']." limit 1";    
		$aago = mysql_query($aa, $rs);
	
	}else{
			
			//처음으로 앱을 실행하여 등록하는 경우 Anyting_gcmid 테이블에 관련 레코드를 추가한다.
			$aa = "insert into Anyting_gcmid (memid, udid, phonum, gcmid, project, endtime, login)values('".$_POST['memid']."', '".$_POST['udid']."', '".$_POST['phonenum']."', '".$_POST['regid']."', '".$project."', '".$ad_date."', 'ok')";
			
			$aa2 = mysql_query($aa, $rs);
			
		
	}
	
	
	//관련정보를 클라이언트에게 리턴 한다.
	echo '{"rs":"ok", "memid":"'.$_POST[memid].'", "udid":"'.$_POST[udid].'", "tel":"'.$_POST[phonenum].'", "proj":"'.$project.'"}';	

	$mycon->sql_close();	

?>
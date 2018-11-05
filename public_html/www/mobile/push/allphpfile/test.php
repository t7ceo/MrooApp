<?
include 'config.php';
//include 'util.php';
include 'gcmutil.php';
include 'class/class_mysql.php';   //부모 클래스
include 'class/member_admin.php';      //회원 관련
include '../../../application/helpers/common/hsrt.php';




	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();
//====================================================================================
			$ll = "http://naver.com";
					

			
			//echo("<meta http-equiv='refresh' content='uuuu' url='http://mroo.co.kr/home/getWebHesh'>"); 
					
			//echo "kkkkkkk".rtrt();		
					
			//실제 메시지를 발송 한다.
			sendMessageGCM("test","wwwww", "Master/77", "All", "0", $project, $ll, "0");



//===============================================================================================



	//$mycon->sql_close();



	//echo($jsongab);


?>

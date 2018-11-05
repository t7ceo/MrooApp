<?
include 'config.php';
include 'util.php';
include 'gcmutil.php';

	//데이트베이스 연결
	//$rs = my_connect($host,$dbid,$dbpass,$dbname);
	
	$mdinf = "det";
	$tit = $_POST['fnam']." (댓글)";
	if($_POST['md'] == "dap"){
		 $tit = $_POST['fnam']." (답글)";
		 $mdinf = "dap";
	}

	//실제 메시지를 발송 한다.
	hddMessageGcm($tit, $_POST['txt'], $_POST['ctjmMd'], $_POST['to'], $project, $_POST['txtNum']);


	echo("<script>history.go(-1);</script>");

?>
	
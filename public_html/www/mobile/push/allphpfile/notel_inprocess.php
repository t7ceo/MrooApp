<?
include 'config.php';
include 'util.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	$ad_date = date("Y-m-d H:i:s");

	$notel = str_replace("-", "", $_POST["tel"]);
	

/*
$gtit1 = str_replace("+", "%20", rawurlencode($_POST[gtit1]));
$gtit2 = str_replace("+", "%20", rawurlencode($_POST[gtit2]));
$gtit1 = str_replace("%2C", ",", $gtit1);
$gtit2 = str_replace("%2C", ",", $gtit2);
*/
/*
$memo = str_replace("+", "%20", urlencode($memo));
$addr = str_replace("+", "%20", urlencode($addr));
$memo = str_replace("%2C", ",", $memo);
$addr = str_replace("%2C", ",", $addr);
*/

			//공지사항을 저장한다.
			$gg = "insert into AAmySusinNo (tel, wmemid, memo, onday)values('".$notel."', '".$_SESSION['memid']."', '".$_POST['gtit1']."', ".mktime().")";
			$ggq = mysql_query($gg, $rs);
	



	mysql_close($rs);

	echo "<script>history.go(-1)</script>";

?>
	
<?
include 'config.php';
include 'util.php';
include_once $my_path.'class/class_mysql.php';  //부모 클래스
include_once $my_path.'class/my_mysql.php';      //자식 클래스

	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	$ss = "update Anyting_gcmid set bell = ".$_GET[md]." where udid = '".$_GET[uiu]."' ";
	$aa = mysql_query($ss, $rs);


	$mycon->sql_close();	

	$jsongab = '{"rs":"ok"}';
	echo($jsongab);
?>
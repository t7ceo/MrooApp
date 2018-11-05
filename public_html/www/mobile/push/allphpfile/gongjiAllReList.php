<?
include 'config.php';
include 'util.php';



	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if(!$_POST[mode]) $_POST[mode] = "0";


	if($_POST[mode] == 0){

	
	}else if($_POST[mode] == 1){

		//발송한 공지 내용을 모두 표시 한다.
		
		$rr = mysql_query("select * from AAmyGongji where project = '".$project."'  order by indate desc",$rs);
		if(!$rr){
			die("AAmyGongji select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				$urlg = $row[url];
				$urlg2 = str_replace("http://","",$urlg);
				$urlg1 = "http://".$urlg2;
	
				$jsongab .= '{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "su":'.$row[allinf].', "url":"'.$urlg1.'", "urlp":"pushv://'.$urlg2.'", "day":"'.$row[indate].'", "img":"'.$row[jangso].'"}';
				
				$i++;
			}
			$jsongab .= ']}';
		}
		
		//$jsongab = '{"ok":"111"}';
		
	
	}else{
		
		
	
		$rr = mysql_query("select jangso from AAmyGongji where id = ".$_POST[did]." limit 1 ",$rs);
		if(!$rr){
			die("AAmyGongji select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			$row = mysql_fetch_array($rr);
			if($row[jangso] != "0"){
				unlink($my_imgpath.$row[jangso]);
			}
		}
	
		$aa = mysql_query("delete from AAmyGongji where id = ".$_POST[did]." limit 1 ", $rs);
		
		$jsongab = '{"rs":"ok"}';
	
	}



	mysql_close($rs);

	echo($jsongab);
?>
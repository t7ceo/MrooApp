<?
include 'config.php';
include 'util.php';
include 'gcmutil.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	$ad_date = date("Y-m-d H:i:s");
	$img_id = "odei".substr(md5($ad_date),0,6);
	//$img_id = $id_session.substr(md5($ad_date),0,7)."_".$pm_gubun;

	$img_path = "../images/";

			//그림파일 업로드
	    /*=============================================================================
	      파일 업로드
	
	      사용방법 :
	        첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
	        두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
	        세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
	        네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
			*/
	$max_width = 800;

	   	$s="fd1";
	   	if($_FILES[$s]['name']){
			$pic_arr = file_upload_thumbmu($_FILES[$s],$img_path,'gif,jpg',$img_id);
	    }else{
			$pic_arr = "0";
		}



$gtit1 = str_replace("+", "%20", rawurlencode($_POST[gtit1]));
$gtit2 = str_replace("+", "%20", rawurlencode($_POST[gtit2]));
$gtit1 = str_replace("%2C", ",", $gtit1);
$gtit2 = str_replace("%2C", ",", $gtit2);

/*
$memo = str_replace("+", "%20", urlencode($memo));
$addr = str_replace("+", "%20", urlencode($addr));
$memo = str_replace("%2C", ",", $memo);
$addr = str_replace("%2C", ",", $addr);
*/

			//공지사항을 저장한다.
			$gg = "insert into AAmyGongji (companyid, project, title, title2, url, gongji, fromid, gjtel, jangso, vinf, indate, webrec)values('".$project."', '".$project."', '".$gtit1."', '".$gtit2."', '".$_POST[url]."', 'text', 'Master', '000-0000', '".$pic_arr."', 1, '".$ad_date."', 77)";
			$ggq = mysql_query($gg, $rs);
	
				//echo $srnum;
	
			//마지막으로 삽입된 글의 번호를 반환 한다.
			$rrlst=mysql_query("select last_insert_id() as num",$rs); 
			if(!$rrlst) die("AAmyGongji last id err".mysql_error());
			$rowlast = mysql_fetch_array($rrlst);

			$srnum = $rowlast[num];


			if($_POST[desang] != "All"){
				$gcmid = $_POST[desang];
			}else{
				$gcmid =  "All";
			}

			//실제 메시지를 발송 한다.
			sendMessageGCM($gtit1, $gtit2, "Image/".$srnum, $gcmid, $rs, $project, $_POST[url], $pic_arr);





	mysql_close($rs);

	echo("<script>history.go(-1);</script>");

//echo("<meta http-equiv='Refresh' content='0; URL=$_base_url$homepage?mgmd=3'>");
?>
	
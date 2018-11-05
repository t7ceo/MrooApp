<?
include 'config.php';
include 'util.php';
include 'gcmutil.php';

	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);


	if($_POST[mode] == "input"){   //새로운 정보 설정 또는 수정=================================

		$ad_date = date("Y-m-d H:i:s");
		$img_id1 = "mms1".substr(md5($ad_date),-6);
		//$img_id = $id_session.substr(md5($ad_date),0,7)."_".$pm_gubun;
		$img_path = "../images/";
	
		//기존 정보의 존재 여부를 확인한다.
		$ss = "select * from AAmyMMS where telco = '".$_POST[telu]."' order by id desc limit 1";
		$ssr = mysql_query($ss, $rs); 
		$ininf = "input";
		if(mysql_num_rows($ssr) > 0){
			$rowOrg = mysql_fetch_array($ssr);
			$ininf = "edit";
		}
		
		
			//그림파일 업로드
			/*=============================================================================
			  파일 업로드
		
			  사용방법 :
				첫번째 파라미터 : 업로드 파일의 정보를 담은 $_FILES 배열 변수를 넘김
				두번째 파라미터 : 업로드할 폴터(절대 혹은 상대경로 모두 가능)를 넘김(경로뒤에 / 을 꼭 붙여야 함)
				세번째 파라미터 : 허용할 확장자(,콤마로 구분)를 넘김
				네번째 파라미터 : 새로 정의할 파일 이름(확장자 없이)을 넘김
				*/
			$max_width = 600;
	
			$s1="fd1";
			if($_FILES[$s1]['name']){
				if($ininf == "edit"){
					if($rowOrg[img1] != "0"){
						unlink($my_imgpath.$rowOrg[img1]);
					}			
				}
				$pic_arr1 = file_upload_thumbmu($_FILES[$s1],$img_path,'gif,jpg',$img_id1);
			}else{
				$pic_arr1 = "0";
			}
	
	
			$img_id2 = "mms2".substr(md5($ad_date),-6);
			$s2="fd2";
			if($_FILES[$s2]['name']){
				if($ininf == "edit"){
					if($rowOrg[img2] != "0"){
						unlink($my_imgpath.$rowOrg[img2]);
					}			
				}
				$pic_arr2 = file_upload_thumbmu($_FILES[$s2],$img_path,'gif,jpg',$img_id2);
			}else{
				$pic_arr2 = "0";
			}

			$img_id3 = "mms3".substr(md5($ad_date),-6);
			$s3="fd3";
			if($_FILES[$s3]['name']){
				if($ininf == "edit"){
					if($rowOrg[img3] != "0"){
						unlink($my_imgpath.$rowOrg[img3]);
					}			
				}
				$pic_arr3 = file_upload_thumbmu($_FILES[$s3],$img_path,'gif,jpg',$img_id3);
			}else{
				$pic_arr3 = "0";
			}
	
	
			$img_id4 = "mms4".substr(md5($ad_date),-6);
			$s4="fd4";
			if($_FILES[$s4]['name']){
				if($ininf == "edit"){
					if($rowOrg[img4] != "0"){
						unlink($my_imgpath.$rowOrg[img4]);
					}			
				}
				$pic_arr4 = file_upload_thumbmu($_FILES[$s4],$img_path,'gif,jpg',$img_id4);
			}else{
				$pic_arr4 = "0";
			}

			$tit = rawurlencode($_POST[tit]);
			$sangho = rawurlencode($_POST[sangho]);
			$gtit1 = str_replace("+", "%20", rawurlencode($_POST[gtit1]));
			$gtit1 = str_replace("%2C", ",", $gtit1);
			
			
			///*
			$sday = explode("-", $_POST[sday]);
			$smk = mktime(0,0,0, date($sday[1]), date($sday[2]), date($sday[0]));
			$eday = explode("-", $_POST[eday]);
			$emk = mktime(23,59,59, date($eday[1]), date($eday[2]), date($eday[0]));
			//*/
			if($smk > $emk) $emk = $smk + 1;
			
			if($ininf == "edit"){
				if($pic_arr1 == "0") $pic_arr1 = $rowOrg[img1];
				if($pic_arr2 == "0") $pic_arr2 = $rowOrg[img2];
				if($pic_arr3 == "0") $pic_arr3 = $rowOrg[img3];
				if($pic_arr4 == "0") $pic_arr4 = $rowOrg[img4];
				
				$aa = "update AAmyMMS set sangho = '".$sangho."', telmu = '".$_POST[telmu]."', telco = '".$_POST[telu]."', title = '".$tit."', title2 = '".$gtit1."', sday = ".$smk.", eday = ".$emk.", img1 = '".$pic_arr1."', img2 = '".$pic_arr2."', img3 = '".$pic_arr3."', img4 = '".$pic_arr4."', url = '".$_POST[url]."', memo1 = '".rawurlencode($_POST[memo1])."', memo2 = '".rawurlencode($_POST[memo2])."', memo3 = '".rawurlencode($_POST[memo3])."', daysu = ".$_POST[sendday]." where id = ".$rowOrg[id]." limit 1";     
				$aarr = mysql_query($aa, $rs);
				
			}else{
			
				//mms 설정을 저장한다.
				$gg = "insert into AAmyMMS (sangho, telmu, telco, project, title, title2, sday, eday, img1, img2, img3, img4, url, memo1, memo2, memo3, memid, daysu, indate)values('".$sangho."', '".$_POST[telmu]."', '".$_POST[telu]."', '".$project."', '".$tit."', '".$gtit1."', ".$smk.", ".$emk.", '".$pic_arr1."', '".$pic_arr2."', '".$pic_arr3."', '".$pic_arr4."', '".$_POST[url]."', '".rawurlencode($_POST[memo1])."', '".rawurlencode($_POST[memo2])."', '".rawurlencode($_POST[memo3])."', '".$_POST[memid]."', ".$_POST[sendday].", '".$ad_date."')";
				$ggq = mysql_query($gg, $rs);
			
			}
		
	
				//앱에서 새로운 mms설정을 읽는다.
				//sendMessageGCM("NewSet", "set", "Image/0", $_POST[telmu], $rs, $project, "no", "0");	
	
		
		
	}else{    //mms 발송==================================================
	
			$gtit1 = str_replace("+", "%20", rawurlencode($_POST[gtit1]));
			$gtit1 = str_replace("%2C", ",", $gtit1);

			$proj = $project;
			$ll = "http://naver.com";

			
			//발송주기와 문자발송 폰번번호를 가져온다.
			$a0 = "select * from AAmyMMS where telco = '".$_POST[telu]."' limit 1";
			$aa0 = mysql_query($a0, $rs);
			$row0 = mysql_fetch_array($aa0);
			$stday = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
			$endday = mktime(0, 0, 0, date("m"), date("d")+$row0[daysu], date("Y"));



			//받는 사람의 전화번호를 설정한다.
			//$ss = "update AAmyMMS set telto = '".$_POST[desang]."' where id = ".$row0[id]." limit 1";
			//$ggq = mysql_query($ss, $rs);
	
	

			//발송기록을 가져온다.
			$aa = "select * from AAmyMMSsend where telmu = '".$_POST[telmu]."' and telu = '".$row0[telco]."' order by id desc limit 1";
			$aar = mysql_query($aa, $rs);
			if(mysql_num_rows($aar) > 0){
				if($row0[daysu] == 0){
					//발송기록이 있다.
					$rowa = mysql_fetch_array($aar);
					$su = ++$rowa[sendsu];
					//무조건 발송한다.
					//발송기록을 저장한다.
					$bb = "update AAmyMMSsend set telu = '".$row0[telco]."', telmu = '".$_POST[telmu]."', telto = '".$_POST[desang]."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", enddate = ".$endday." where id = ".$rowa[id]." limit 1";
					$bbr = mysql_query($bb, $rs);
					
					//발송기록이 없다.-무조건 발송한다.
					sendMessageGCM($_POST[desang],"mms", "Master/77", $_POST[telmu], "0", $proj, $ll, $_POST[telu]);
					
				}else{
					//발송기록이 있다.
					$rowa = mysql_fetch_array($aar);
					//날짜 계산하여 발송한다.
					if($stday >= $rowa[enddate]){
						$su = ++$rowa[sendsu];
						//발송기록을 저장한다.
						$bb = "update AAmyMMSsend set telu = '".$row0[telco]."', telmu = '".$_POST[telmu]."', telto = '".$_POST[desang]."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", enddate = ".$endday." where id = ".$rowa[id]." limit 1";
						$bbr = mysql_query($bb, $rs);
						
						//발송기록이 없다.-무조건 발송한다.
						sendMessageGCM($_POST[desang],"mms", "Master/77", $_POST[telmu], "0", $proj, $ll, $_POST[telu]);
						
					}
					
				}
			}else{
				//발송기록을 저장한다.
				$bb = "insert into AAmyMMSsend (telu, telmu, telto, project, sendsu, senddate, enddate)values('".$row0[telco]."', '".$_POST[telmu]."', '".$_POST[desang]."', '".$proj."', 1, ".$stday.", ".$endday.")";
				$bbr = mysql_query($bb, $rs);
				
				//발송기록이 없다.-무조건 발송한다.
				sendMessageGCM($_POST[desang],"mms", "Master/77", $_POST[telmu], "0", $proj, $ll, $_POST[telu]);
			}

	
	}




	mysql_close($rs);

	echo("<script>history.go(-1);</script>");

?>
	
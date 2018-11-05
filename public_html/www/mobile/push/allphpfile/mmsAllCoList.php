<?
include 'config.php';
include 'util.php';
include 'gcmutil.php';


	//데이트베이스 연결
	$rs = my_connect($host,$dbid,$dbpass,$dbname);

	if(!$_POST[mode]) $_POST[mode] = "0";


	if($_POST[mode] == 0){

	
	}else if($_POST[mode] == 1){

		//MMS 업체설정내용 리스트를 출력
		//오늘 날짜의 일수를 구한다.
		$today = date("Y-m-d");
		$td = explode("-", $today);
		$nowdaysu = mktime(0, 0, 0, $td[1], $td[2], $td[0]);
		
		$findg = "";
		if($_POST[fnd]){
			$findg = " and (sangho like '%".$_POST[fnd]."%' or telco like '%".$_POST[fnd]."%' or telmu like '%".$_POST[fnd]."%' or title2 like '%".$_POST[fnd]."%' or memo1 like '%".$_POST[fnd]."%' or memo2 like '%".$_POST[fnd]."%' or memo3 like '%".$_POST[fnd]."%') ";
		}

		
		if($_POST[ilsumd] == 1){
			//올림차순
			$ilmd = " order by ilsu desc ";
		}else if($_POST[ilsumd] == 0){
			//내림 차순
			$ilmd = " order by ilsu ";
		}else{
			$ilmd = " order by indate desc ";
		}
		
		if($_SESSION["memid"] == "admin") $wh = "";
		else $wh = " and memid = '".$_SESSION["memid"]."' ";
		
		
		
		$oo = "select id, sangho, telmu, title, title2, daysu, url, indate, img1, img2, img3, img4, telco, sday, eday, (eday - ".$nowdaysu.") as ilsu, memo1, memo2, memo3,  webrec from AAmyMMS where project = '".$project."' ".$wh." ".$findg." ".$ilmd;
		$rr = mysql_query($oo,$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	
				$urlg = $row[url];
				$urlg2 = str_replace("http://","",$urlg);
				$urlg1 = "http://".$urlg2;
				

				$sd = date("Y-m-d", $row[sday]);   //계약시작일자
				$ed = date("Y-m-d", $row[eday]);   //계약종료일자
				
				$day1 = ((60*60) * 24);     //하루를 초로 환산
				if($row[ilsu] > 0 && $row[ilsu] <= $day1){
					$iisu = 1;
				}else if($row[ilsu] < 1){
					//남은 시간이 1보다 작은 경우 
					$iisu = 0;
				}else{
					$addsu = 0;
					$na = ($row[ilsu] % $day1);
					if($na > 0) $addsu = 1;
					$iisu = ((($row[ilsu] - $na) / $day1) + $addsu);
				}
				
				if($iisu < 1){
					//잔여일수가 없다.
					$iisu = 0;
					$row[telmu] = str_replace("(X)", "", $row[telmu]);
					$row[telmu] = $row[telmu]."(X)";
					$row[daysu] = 5000;
					$ii = "update AAmyMMS set telmu = '".$row[telmu]."', daysu = ".$row[daysu]." where id = ".$row[id]." limit 1";
					$iir = mysql_query($ii, $rs);
				}else{
					if(strpos($row[telmu], "x)") > 0){
						$row[telmu] = str_replace("(X)", "", $row[telmu]);
						$row[daysu] = 0;
						$ii = "update AAmyMMS set telmu = '".$row[telmu]."', daysu = ".$row[daysu]." where id = ".$row[id]." limit 1";
						$iir = mysql_query($ii, $rs);
					}
				}
				
				
				$jsongab .= '{"id":'.$row[id].', "sangho":"'.$row[sangho].'", "telmu":"'.$row[telmu].'", "tit":"'.$row[title].'", "mess":"'.$row[title2].'", "su":'.$row[daysu].', "url":"'.$urlg1.'", "sday":"'.$sd.'", "eday":"'.$ed.'", "ilsu":'.$iisu.', "day":"'.$row[indate].'", "img1":"'.$row[img1].'", "img2":"'.$row[img2].'", "img3":"'.$row[img3].'", "img4":"'.$row[img4].'", "telco":"'.$row[telco].'", "wrec":'.$row[webrec].', "memo1":"'.$row[memo1].'", "memo2":"'.$row[memo2].'", "memo3":"'.$row[memo3].'"}';
				
				$i++;
			}
			$jsongab .= ']}';
		}
		
		//$jsongab = '{"ok":"111"}';
		
	
	}else if($_POST[mode] == 2){
		//수정하기 위해 업체의 설정내용을 가져온다.
		$rr = mysql_query("select * from AAmyMMS where id = ".$_POST[eid]." limit 1 ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			$jsongab = '{"rs":"err"}';
		}else{
			$row = mysql_fetch_array($rr);
			
			$sd = date("Y-m-d", $row[sday]);
			$ed = date("Y-m-d", $row[eday]);
			
			
			
			
			$jsongab = '{"rs":"ok", "id":'.$row[id].', "sangho":"'.$row[sangho].'", "telmu":"'.$row[telmu].'", "telu":"'.$row[telco].'", "tit":"'.$row[title].'", "mess":"'.$row[title2].'", "sday":"'.$sd.'", "eday":"'.$ed.'", "img1":"'.$row[img1].'", "img2":"'.$row[img2].'", "img3":"'.$row[img3].'", "img4":"'.$row[img4].'", "url":"'.$row[url].'", "daysu":'.$row[daysu].', "memo1":"'.$row[memo1].'", "memo2":"'.$row[memo2].'", "memo3":"'.$row[memo3].'"}';
		}
	}else if($_POST[mode] == 3){
		
		if($_POST[md] == 1){
		
			//삭제한다.
			$rr = mysql_query("select img1, img2, img3, img4 from AAmyMMS where id = ".$_POST[did]." limit 1 ",$rs);
			if(!$rr){
				die("AAmyMMS select err".mysql_error());
				//$jsongab = '{"rs":"err"}';
			}else{
				$row = mysql_fetch_array($rr);
				if($row[img1] != "0"){
					unlink($my_imgpath.$row[img1]);
				}
				if($row[img2] != "0"){
					unlink($my_imgpath.$row[img2]);
				}
				if($row[img3] != "0"){
					unlink($my_imgpath.$row[img3]);
				}
				if($row[img4] != "0"){
					unlink($my_imgpath.$row[img4]);
				}
			}
		
			$aa = mysql_query("delete from AAmyMMS where id = ".$_POST[did]." limit 1 ", $rs);
		
		
		}else if($_POST[md] == 2){
		
			$aa = mysql_query("delete from AAmySusinNo where id = ".$_POST[did]." limit 1 ", $rs);
		
		}else{
		
			$aa = mysql_query("delete from AAmyMember where id = ".$_POST[did]." limit 1 ", $rs);
		}
				
		$jsongab = '{"rs":"ok", "rt":"'.$_SESSION[memid].'"}';
	
	}else if($_POST[mode] == 4){
	
		$rr = mysql_query("select ".$_POST[img]." as img, telmu from AAmyMMS where id = ".$_POST[coid]." limit 1 ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			$row = mysql_fetch_array($rr);
			if($row[img] != "0"){
				unlink($my_imgpath.$row[img]);
				
				$ss = "update AAmyMMS set ".$_POST[img]." = '0' where id = ".$_POST[coid]." limit 1";
				$ssr = mysql_query($ss,$rs);
				
				
				//앱에서 새로운 mms설정을 읽는다.-문자발송 하는 전화번호를 인자로 준다.
				//sendMessageGCM("NewSet", "set", "Image/0", $row[telmu], $rs, $project, "no", "0");	
				
			}

		}
		$jsongab = '{"rs":"ok"}';
	
	
	}else if($_POST[mode] == 5){
	
		
		$rr = mysql_query("select * from AAmyMMS where telmu = '".$_POST[mutel]."' ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			
			if(mysql_num_rows($rr) > 1){
				
				$ss = "update AAmyMMS set webrec = 0 where telmu = '".$_POST[mutel]."' ";
				$ssr = mysql_query($ss,$rs);
				
				$ss2 = "update AAmyMMS set webrec = 1 where id = ".$_POST[rid]." limit 1";
				$ssr2 = mysql_query($ss2,$rs);
				$jsongab = '{"rs":"ok"}';
				
			}else{
				$jsongab = '{"rs":"no"}';
			}
			

		}

	}else if($_POST[mode] == 6){
		
		$ff = "";
		if($_POST['fnd']) $ff = " and (tel like '%".$_POST['fnd']."%' or wmemid like '%".$_POST['fnd']."%' or memo like '%".$_POST['fnd']."%') ";
		
		if($_SESSION["memid"] == "admin") $wh = " ".$ff;
		else $wh = " and wmemid = '".$_SESSION["memid"]."' ".$ff;
		
		
		//수신거부 리스트를 가져온다.
		$rr = mysql_query("select * from AAmySusinNo where vinf = 1 ".$wh." ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	

				$onday = date("Y-m-d H:i:s", $row[onday]);
				
				$jsongab .= '{"id":'.$row[id].', "tel":"'.$row[tel].'", "memo":"'.$row[memo].'", "wmemid":"'.$row[wmemid].'", "onday":"'.$onday.'"}';
				
				$i++;
			}
			$jsongab .= ']}';
			

		}
		
		
	
	}else if($_POST[mode] == 7){
		
		$ff = "";
		if($_POST['fnd']) $ff = " (memid like '%".$_POST['fnd']."%' or wmemid like '%".$_POST['fnd']."%') and ";

		if($_SESSION["memid"] == "admin") $wh = " (id > 0) ";
		else $wh = " (wmemid = '".$_SESSION['memid']."' and po < 9) ";
		
		$ss = "select * from AAmyMember where ".$ff.$wh." ";
		
		//회원정보를 가져온다.
		$rr = mysql_query($ss,$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	

				$onday = date("Y-m-d H:i:s", $row[onday]);
				
				$jsongab .= '{"id":'.$row[id].', "memid":"'.$row[memid].'", "po":'.$row[po].', "onday":"'.$onday.'"}';
				
				$i++;
			}
			$jsongab .= ']}';
			

		}
		
		
	
	}else if($_POST[mode] == 8){
		
		$mid = str_replace("-", "", $_POST[mid]);
		
		//회원 로그인을 한다.
		$rr = mysql_query("select * from AAmyMember where memid = '".$mid."' and pass = '".$_POST[pass]."' limit 1 ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
			//$jsongab = '{"rs":"err"}';
		}else{
			
			if(mysql_num_rows($rr) > 0){
				$row = mysql_fetch_array($rr);
				//로그인 성공
				$_SESSION["memid"] = $mid;
				$_SESSION["mempo"] = $row[po];
				
				$jsongab = '{"rs":"ok"}';
				
			}else{
				//로그인 실패
				$_SESSION["memid"] = "0";
				$_SESSION["mempo"] = 0;
				
				$jsongab = '{"rs":"no"}';
			}


		}
		
	}else if($_POST[mode] == 9){
		
				//로그아웃
				$_SESSION["memid"] = "0";
				$_SESSION["mempo"] = 0;
				//session_destory();
				
				
				$jsongab = '{"rs":"ok"}';
		
	}else if($_POST[mode] == 10){
		//비밀번호 초기화
		
		//회원정보를 가져온다.
		$rr = mysql_query("select * from AAmyMember where id = ".$_POST['did']." and (wmemid = '".$_SESSION['memid']."' or memid = '".$_SESSION['memid']."') limit 1 ",$rs);
		if(!$rr){
			die("AAmyMMS select err".mysql_error());
		}else{
			if(mysql_num_rows($rr) > 0){
				//$row = mysql_fetch_array($rr);
				$ss = "update AAmyMember set pass = '1234' where id = ".$_POST['did']." limit 1";
				$cc = mysql_query($ss, $rs);
				
				$jsongab = '{"rs":"ok"}';
			}else{
				$jsongab = '{"rs":"no"}';
			}
		}
	
	}else if($_POST[mode] == 11){
		//자격을 변경한다.
		$rr = mysql_query("select * from AAmyMember where memid = '".$_SESSION['memid']."' limit 1",$rs);
		$row = mysql_fetch_array($rr);
		if($row['po'] > 4){
			if($_POST['po'] > 8 and $_SESSION['memid'] != "admin"){
				$jsongab = '{"rs":"not"}';	
			}else{
				$ss = "update AAmyMember set po = ".$_POST['po']." where id = ".$_POST['mid']." limit 1";
				$cc = mysql_query($ss, $rs);
				
				$jsongab = '{"rs":"ok"}';			
			}
		}else{
		
			$jsongab = '{"rs":"no"}';
		}
		

	
	}else if($_POST[mode] == 12){
		//비번을 변경한다.
		$rr = mysql_query("select * from AAmyMember where id = ".$_POST['mid']." and pass = '".$_POST['oldpass']."' ",$rs);
		if(mysql_num_rows($rr) > 0){
			//변경완료
			$ss = "update AAmyMember set pass = '".$_POST['newpass']."' where id = ".$_POST['mid']." limit 1";
			$cc = mysql_query($ss, $rs);
				
			$jsongab = '{"rs":"ok"}';			
		}else{
			//비번오류
			$jsongab = '{"rs":"no"}';	
		}
	
	}else if($_POST[mode] == 13){
		//장비에서 모든 mms 발송리스트를 가져온다.
		
		$rr = mysql_query("select a.id, a.sinf, a.sendrs, b.telto, b.telmu, a.senddate from AAmyMMSinf as a left join AAmyMMSsend as b on(a.sendid = b.id) where a.telu = '".$_POST['utel']."' order by a.id desc limit 70 ",$rs);
			
			$jsongab = '{"rs":[';
			$i = 1;
			while($row=mysql_fetch_array($rr)){
				if($i > 1) $jsongab .= ",";
	

				$onday = date("Y-m-d H:i:s", $row[senddate]);
				
				$jsongab .= '{"id":'.$row[id].', "telto":"'.$row['telto'].'", "telmu":"'.$row['telmu'].'", "sinf":'.$row['sinf'].', "sday":"'.$onday.'"}';
				
				$i++;
			}
			$jsongab .= ']}';	
	}




	mysql_close($rs);

	echo($jsongab);
?>
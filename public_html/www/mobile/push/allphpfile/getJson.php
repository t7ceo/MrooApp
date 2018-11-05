<?
include 'config.php';
include 'util.php';
include $my_path.'class/class_mysql.php';   //부모 클래스
include $my_path.'class/member_admin.php';      //회원 관련



	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	
	
	$ad_date = date("Y-m-d H:i:s");
	
	
	//$mycon->sql_close();
//====================================================================================
	
		switch($_GET[mode]){
		case "mess":   //메시지 내용을 가져온다.
		
			$ss = "select id, title, title2, url, img1, img2, img3, img4, telto from AAmyMMS  where  telmu = '".$_GET[telmu]."' and project = '".$project."'  limit 1";
			$rr = mysql_query($ss, $rs); 
			
			if(!$rr){
				die("AAmyGongji select err".mysql_error());
				$s1 = "err";
			}else{
				$s1 = "ok";
				$row = mysql_fetch_array($rr);		
				
				
				$jsongab = '[{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "url":"'.$row[url].'", "telto":"'.$row[telto].'", "img1":"'.$row[img1].'", "img2":"'.$row[img2].'", "img3":"'.$row[img3].'", "img4":"'.$row[img4].'"}]';
				
			}
		
		break;
		case "mess2":   //메시지 내용을 가져온다.
		
			$ss = "select id, title, title2, url, img1, img2, img3, img4, telto from AAmyMMS  where  telco = '".$_GET[telu]."' and telmu = '".$_GET[telmu]."' and project = '".$project."'  limit 1";
			$rr = mysql_query($ss, $rs); 
			
			if(!$rr){
				die("AAmyGongji select err".mysql_error());
				$s1 = "err";
			}else{
				$s1 = "ok";
				$row = mysql_fetch_array($rr);		
				
				
				$jsongab = '[{"id":'.$row[id].', "tit":"'.$row[title].'", "tit2":"'.$row[title2].'", "url":"'.$row[url].'", "telto":"'.$row[telto].'", "img1":"'.$row[img1].'", "img2":"'.$row[img2].'", "img3":"'.$row[img3].'", "img4":"'.$row[img4].'"}]';
				
			}
		
		break;
		case "MMSrs":
			//String urlAddr = MainActivity.LK+"getJson.php?mode=MMSrs&totel="+MmsUtil.mmsTo+"&stel="+MainActivity.telconum+"&rr="+i;
			//발송기록에 발송결과를 저장한다.
			
			
			
			$ss = "update AAmyMMSinf set sendrs = ".$_GET["rr"]." where id = ".$_GET["sid"]." limit 1";
			//echo $ss;
			
			$qq = mysql_query($ss, $rs);
			
			$jsongab = '[{"rs":"ok"}]';
		
		
		break;
		case "mbsend":
			//폰에서 푸시발송하기 위해 웹에서 정보를 가져와서 푸시 발송을 한다.
			
			//유선전화로 전화가 온경우 발송주기를 검사하여 발송 여부를 결정하고 발송명령을 내린다.
			//유선에서 전화가 오면 푸시 발송하고 발송마감을 하지 않는다.
			//mms를 받은 사람이 무의식적으로 mms를 발송한 무선폰으로 전화를 거는 경우 발송 마감 여부를 확인하고 
			//발송마감전이면 마감을 하면서 업체로 전화 하라는 문자를 발송한다.


		
			$proj = $project;
			//발송주기와 문자발송 폰번번호를 가져온다.
			//mms를 발송하는 무선전화의 번호 $_GET[stel]     webrec 1 디폴트
			$a0 = "select * from AAmyMMS where telmu = '".$_GET[stel]."' and webrec = 1 ";
			$aa0 = mysql_query($a0, $rs);
			$numsu = mysql_num_rows($aa0);
			
			//echo "stel=".$_GET[stel]."/su=".$numsu;
			if($numsu > 0){
				$gombsend = true;
				//여러 업체가 등록되어 있다.
				//기본 업체를 선택하여 정보를 가져온다.
				//$a00 = "select * from AAmyMMS where telmu = '".$_GET[stel]."' and webrec = 1 limit 1";
				//$aa00 = mysql_query($a00, $rs);
				//단일 업체 등록 이다.
				$row0 = mysql_fetch_array($aa0);
				//============================================================		
			}else{
				//등록된 업체가 없다.
				$gombsend = false;
				
				//============================================================
			}
			
			
			if($gombsend){
				//등록된 업체 정보를 이용하여 푸시 발송 기록을 저장한다.
				$stday = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
				$endday = mktime(0, 0, 0, date("m"), date("d")+$row0[daysu], date("Y"));
				
				
	
				//발송기록을 가져온다.
				//업체 유선전화 $row0[telco] / 발송하는 무선전화 : $_GET[stel] / 받을 사람번호 : _GET[totel]
				$aa = "select * from AAmyMMSsend where telmu = '".$_GET[stel]."' and telu = '".$row0[telco]."' and telto = '".$_GET[totel]."' and vinf = 1 order by id desc limit 1";
				$aar = mysql_query($aa, $rs);
				if(mysql_num_rows($aar) > 0){
					//이전에 발송한 내역이 있다.
					$rowa = mysql_fetch_array($aar);				
					
					
					
						//전화를 건사람에게 유선에서 푸시발송하고 마감 처리 않한 내역이 있는지 확인한다.
						$uu = "select * from AAmyMMSsend where telmu = '".$_GET[stel]."' and telu = '".$row0[telco]."' and telto = '".$_GET[totel]."' and (vinf = 0 or vinf = 2) and magam = 1 ";
						$uur = mysql_query($uu, $rs);
						$su = mysql_num_rows($uur);
						if($su > 0){
							$uurow = mysql_fetch_array($uur);
							//유선에서 발송하고 마감 처리 않한 내역이 있다.
							//마감처리 한다.
							$uu2 = "update AAmyMMSsend set magam = 2 where id = ".$uurow[id]." limit 1";
							$uu2r = mysql_query($uu2, $rs);
							
						
							//푸시 발송 불가능하며 업체로 전화를 달라는 문자 발송 한다.
							$jsongab = '[{"rs":"cotel", "cotel":"'.$row0[telco].'"}]';
							
								
						}else{  //======================================================
						
						
						
											
							if(($rowa['senddate'] + $mmsSendNoTime) > $stday){  //*****************
								//10이내에는 발송을 하지 않는다.
								$jsongab = '[{"rs":"ten"}]';
								
							}else{   //******************
								
								
								if($row0[daysu] == 0){
									//매번 발송한다.
									
									$su = ++$rowa[sendsu];
									//무조건 발송한다.
									//발송기록을 저장한다.
									$bb = "update AAmyMMSsend set telu = '".$row0[telco]."', telmu = '".$_GET[stel]."', telto = '".$_GET[totel]."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", enddate = ".$endday.", vinf = 1 where id = ".$rowa[id]." limit 1";
									$bbr = mysql_query($bb, $rs);
									
									
															
									//mms 발송결과 테이블을 생성
									$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowa[id].", 1, ".$stday.", '".$row0[telco]."', 'mobile1')";
									$kkr = mysql_query($kk, $rs);
																			
									//마지막으로 삽입된 글의 번호를 반환 한다.
									$rrlst=mysql_query("select last_insert_id() as num",$rs); 
									if(!$rrlst) die("AAmyMMSinf last id err".mysql_error());
									$rowlast = mysql_fetch_array($rrlst);
								
								
									$jsongab = '[{"rs":"ok", "id":'.$row0[id].', "tit":"'.$row0[title].'", "tit2":"'.$row0[title2].'", "url":"'.$row0[url].'", "telto":"'.$row0[telto].'", "img1":"'.$row0[img1].'", "img2":"'.$row0[img2].'", "img3":"'.$row0[img3].'", "img4":"'.$row0[img4].'", "sndid":'.$rowlast[num].'}]';
								
								}else{
									//날짜 주기를 계산하여 발송한다.
									//날짜 계산하여 발송한다.
									if($stday >= $rowa[enddate]){
										$su = ++$rowa[sendsu];
										//발송기록을 저장한다.
										$bb = "update AAmyMMSsend set telu = '".$row0[telco]."', telmu = '".$_GET[stel]."', telto = '".$_GET[totel]."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", enddate = ".$endday.", vinf = 1 where id = ".$rowa[id]." limit 1";
										$bbr = mysql_query($bb, $rs);
										
										
									//mms 발송결과 테이블을 생성
									$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowa[id].", 1, ".$stday.", '".$row0[telco]."', 'mobile2')";
									$kkr = mysql_query($kk, $rs);
																			
									//마지막으로 삽입된 글의 번호를 반환 한다.
									$rrlst=mysql_query("select last_insert_id() as num",$rs); 
									if(!$rrlst) die("AAmyMMSinf last id err".mysql_error());
									$rowlast = mysql_fetch_array($rrlst);
										
										
										
															
										$jsongab = '[{"rs":"ok", "id":'.$row0[id].', "tit":"'.$row0[title].'", "tit2":"'.$row0[title2].'", "url":"'.$row0[url].'", "telto":"'.$row0[telto].'", "img1":"'.$row0[img1].'", "img2":"'.$row0[img2].'", "img3":"'.$row0[img3].'", "img4":"'.$row0[img4].'", "sndid":'.$rowlast[num].'}]';
										
									
									}else{
										$jsongab = '[{"rs":"no"}]';
									}
									
								}
		
								
								
						
							}   //*******************************
						
	
						}    //===========================

					

				
					
				}else{
					//이전에 발송한 내역이 없어 무조건 발송 한다.
					//발송기록을 저장한다.
					$bb = "insert into AAmyMMSsend (telu, telmu, telto, project, sendsu, senddate, enddate, vinf)values('".$row0[telco]."', '".$_GET[stel]."', '".$_GET[totel]."', '".$proj."', 1, ".$stday.", ".$endday.", 1)";
					$bbr = mysql_query($bb, $rs);
					
							//마지막으로 삽입된 글의 번호를 반환 한다.
							$rrlst=mysql_query("select last_insert_id() as num",$rs); 
							if(!$rrlst) die("AAmyMMSsend last id err".mysql_error());
							$rowlast = mysql_fetch_array($rrlst);
								
					
					
							//mms 발송결과 테이블을 생성
							$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowlast[num].", 1, ".$stday.", '".$row0[telco]."', 'mobile3')";
							$kkr = mysql_query($kk, $rs);
																	
							//마지막으로 삽입된 글의 번호를 반환 한다.
							$rrlst2=mysql_query("select last_insert_id() as num2",$rs); 
							if(!$rrlst2) die("AAmyMMSinf last id err".mysql_error());
							$rowlast2 = mysql_fetch_array($rrlst2);
								
								
										
					$jsongab = '[{"rs":"ok", "id":'.$row0[id].', "tit":"'.$row0[title].'", "tit2":"'.$row0[title2].'", "url":"'.$row0[url].'", "telto":"'.$row0[telto].'", "img1":"'.$row0[img1].'", "img2":"'.$row0[img2].'", "img3":"'.$row0[img3].'", "img4":"'.$row0[img4].'", "sndid":'.$rowlast2[num2].'}]';
					
	
				}
				
		
			}else{
				
				//등록된 업체정보가 없다.
				$jsongab = '[{"rs":"not"}]';
			
			}
	
			
	
		break;
		}
	
	


//===============================================================================================



	$mycon->sql_close();



	echo($jsongab);


?>
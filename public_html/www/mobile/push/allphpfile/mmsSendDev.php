<?
include 'config.php';
//include 'util.php';
include 'gcmutil.php';
include 'class/class_mysql.php';   //부모 클래스
include 'class/member_admin.php';      //회원 관련

//유선전화로 전화가 온경우 발송주기를 검사하여 발송 여부를 결정하고 발송명령을 내린다.
//유선에서 전화가 오면 푸시 발송하고 발송마감을 하지 않는다.
//mms를 받은 사람이 무의식적으로 mms를 발송한 무선폰으로 전화를 거는 경우 발송 마감 여부를 확인하고 
//발송마감전이면 마감을 하면서 업체로 전화 하라는 문자를 발송한다.




	$mycon = new MySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);
	//$mycon->sql_close();
//====================================================================================
//date("Ymd", mktime(0,0,0, date("m"), date("d")-1, date("Y"))); //어제
//date("Ymd", mktime(0,0,0, date("m"), date("d")+1, date("Y"))); //내일
			
			//수신거부 전화번호 여부를 확인 한다.
			//수신한 유선전화 $_GET[utel] / 발송하는 무선전화 : $row0[telmu] / 받을 사람번호 : _GET[mutel]
			$yy0 = "select * from AAmySusinNo where (tel = '".$_GET[utel]."' or tel = '".$_GET[totel]."') ";
			$yy1 = mysql_query($yy0, $rs);
			if(mysql_num_rows($yy1) > 0){
				//수신거부된 번호가 있다.
				echo('[{"rs":"no"}]');
			}else{
				//수신거부 번호가 없다.
			
				$proj = "chuncheon";
				$ll = "http://naver.com";
				
				//발송주기와 문자발송 폰번번호를 가져온다.
				$a0 = "select * from AAmyMMS where telco = '".$_GET[utel]."' limit 1";
				$aa0 = mysql_query($a0, $rs);
				//장비에서 감지한 업체의 번호가 등록된 업체인지 확인한다.
				if(mysql_num_rows($aa0) > 0){  //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				
				
						$row0 = mysql_fetch_array($aa0);
						$stday = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
						$endday = mktime(0, 0, 0, date("m"), date("d")+$row0[daysu], date("Y"));
						
						
						//발송기록을 가져온다.
						//수신한 유선전화 $_GET[utel] / 발송하는 무선전화 : $row0[telmu] / 받을 사람번호 : _GET[mutel]   vinf : 0-유선전화에서 전송, 1-모바일에서 전송 2-장비에서 전송
						$aa = "select * from AAmyMMSsend where (telmu = '".$row0['telmu']."' and telu = '".$_GET['utel']."' and telto = '".$_GET['totel']."') and vinf = 2 order by id desc limit 1";
						$aar = mysql_query($aa, $rs);
						
						//무조건 발송한다.
						$rowa = mysql_fetch_array($aar);
						
						
						if(mysql_num_rows($aar) > 0){
							//이전에 발송한 내역이 있다.
							if(($rowa['senddate'] + $mmsSendNoTime) > $stday){  //*****************
								//10이내에는 발송을 하지 않는다.
								$jsongab = '[{"rs":"ten"}]';
									
							}else{   //******************
		
		
								if($row0[daysu] == 0){
				
									$su = ++$rowa[sendsu];
									//무조건 발송한다.
									//발송기록을 저장한다. 수신한 유선전화 $_GET[utel] / 발송하는 무선전화 : $row0[telmu] / 받을 사람번호 : _GET[mutel]
									$bb = "update AAmyMMSsend set telu = '".$_GET['utel']."', telmu = '".$row0['telmu']."', telto = '".$_GET['totel']."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", vinf = 2, enddate = ".$endday." where id = ".$rowa[id]." limit 1";
									$bbr = mysql_query($bb, $rs);
									
									
									//mms 발송결과 테이블을 생성
									$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowa[id].", 3, ".$stday.", '".$_GET['utel']."', 'Dev')";
									$kkr = mysql_query($kk, $rs);
																			
									//마지막으로 삽입된 글의 번호를 반환 한다.
									$rrlst=mysql_query("select last_insert_id() as num",$rs); 
									if(!$rrlst) die("AAmyMMSinf last id err".mysql_error());
									$rowlast = mysql_fetch_array($rrlst);
			
									
									//일수 관계 없이-무조건 발송한다.
									sendMessageGCM($_GET['totel'], "mms", "Master/".$rowlast['num'], $row0['telmu'], "0", $proj, $ll, $_GET['utel']);
									echo('[{"rs":"ok"}]');
									
								}else{
									//일수 계산하여 발송한다.
									$rowa = mysql_fetch_array($aar);
									//날짜 계산하여 발송한다.
									if($stday >= $rowa[enddate]){
										$su = ++$rowa[sendsu];
										//발송기록을 저장한다.
										$bb = "update AAmyMMSsend set telu = '".$_GET[utel]."', telmu = '".$row0[telmu]."', telto = '".$_GET['totel']."', project = '".$proj."', sendsu = ".$su.", senddate = ".$stday.", vinf = 2, enddate = ".$endday." where id = ".$rowa[id]." limit 1";
										$bbr = mysql_query($bb, $rs);
										
										
										
										//mms 발송결과 테이블을 생성
										$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowa[id].", 3, ".$stday.", '".$_GET['utel']."', 'Dev')";
										$kkr = mysql_query($kk, $rs);
																				
										//마지막으로 삽입된 글의 번호를 반환 한다.
										$rrlst=mysql_query("select last_insert_id() as num",$rs); 
										if(!$rrlst) die("AAmyMMSinf last id err".mysql_error());
										$rowlast = mysql_fetch_array($rrlst);
											
										
									
										//발송기록이 없다.-무조건 발송한다.
										sendMessageGCM($_GET['totel'], "mms", "Master/".$rowlast[num], $row0[telmu], "0", $proj, $ll, $_GET[utel]);
										echo('[{"rs":"ok"}]');
										
									}
									
								}
			
		
		
							} //**************************
						
										
			
							
							
						}else{
						//이전에 발송한 기록이 없다.
							//발송기록을 저장한다.
							$bb = "insert into AAmyMMSsend (telu, telmu, telto, project, sendsu, vinf, senddate, enddate)values('".$_GET[utel]."', '".$row0[telmu]."', '".$_GET[totel]."', '".$proj."', 1, 2, ".$stday.", ".$endday.")";
							$bbr = mysql_query($bb, $rs);
							
							
							//마지막으로 삽입된 글의 번호를 반환 한다.
							$rrlst=mysql_query("select last_insert_id() as num",$rs); 
							if(!$rrlst) die("AAmyMMSsend last id err".mysql_error());
							$rowlast = mysql_fetch_array($rrlst);
		
		
									//mms 발송결과 테이블을 생성
									$kk = "insert into AAmyMMSinf (sendid, sinf, senddate, telu, bigo)values(".$rowlast[num].", 3, ".$stday.", '".$_GET['utel']."', 'Dev')";
									$kkr = mysql_query($kk, $rs);
																			
									//마지막으로 삽입된 글의 번호를 반환 한다.
									$rrlst2=mysql_query("select last_insert_id() as num2",$rs); 
									if(!$rrlst2) die("AAmyMMSinf last id err".mysql_error());
									$rowlast2 = mysql_fetch_array($rrlst2);
		
							
							//발송기록이 없다.-무조건 발송한다.
							sendMessageGCM($_GET['totel'], "mms", "Master/".$rowlast2[num2], $row0[telmu], "0", $proj, $ll, $_GET[utel]);
							
							echo('[{"rs":"ok"}]');
						}

				
				
				
				}  //+++++++++++++++++++++++++++
				
				
			}
//===============================================================================================



	$mycon->sql_close();


	echo('[{"rs":"ok"}]');



?>
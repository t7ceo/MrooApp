<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//파일만 삭제한다.
function rmdirFile($dir, $arr) {
   $dirs = dir($dir);
   $cc = 0;
   while(false !== ($entry = $dirs->read())) {
      if(($entry != '.') && ($entry != '..')) {
		  
         if(is_dir($dir.'/'.$entry)) {
            rmdirFile($dir.'/'.$entry, $arr);
         } else {
			 if(in_array($entry, $arr)){
			 	 @unlink($dir.'/'.$entry);
			 }
         }
       }
	   $cc++;
    }
    $dirs->close();
 
	
	return $cc;
}		





//폴더와 파일을 모두 삭제 한다.
function rmdirAll($dir) {
   $dirs = dir($dir);
   $cc = 0;
   while(false !== ($entry = $dirs->read())) {
      if(($entry != '.') && ($entry != '..')) {
         if(is_dir($dir.'/'.$entry)) {
            rmdirAll($dir.'/'.$entry);
         } else {
            @unlink($dir.'/'.$entry);
         }
       }
	   $cc++;
    }
    $dirs->close();
    @rmdir($dir);
	
	return $cc;
}		




//첨부파일 리스트를 출력한다.
function dispAllFile($main, $md1, $md3, $baseUrl, $allfile, $mode){
	//$MCI =& get_instance();
	//$main = $MCI->session->userdata('mainMenu');

	//if($main == "saup") $main = "hjang";
	switch($main){
	case "community":
		if($md1 == 1){
			switch($md3){
			case 3:   //상세보기
				$bg = "#fafafa";
				$ww = 41;
			break;
			case 4:  //수정
				$delmd = "community";
				$bg = "#dedede";
				$ww = 45;
			break;
			}
		}else if($md1 == 2){
			switch($md3){
			case 3:   //상세보기
				$bg = "#fafafa";
				$ww = 41;
			break;
			case 4:  //수정
				$delmd = "community";
				$bg = "#dedede";
				$ww = 45;
			break;
			}
		
		}else if($md1 == 3){
			switch($md3){
			case 3:   //상세보기
				$bg = "#fafafa";
				$ww = 41;
			break;
			case 4:  //수정
				$delmd = "community";
				$bg = "#dedede";
				$ww = 45;
			break;
			}
		
		}

	break;
	}

	$ss = "<ul style='width:100%; display:block; margin:0; padding:0; text-align:left;'>";
	$c = 1;
	
	if($mode == "view"){
		foreach($allfile as $row){
			$ss .= "<li style='width:50%; display:inline-block; text-align:center; padding:0; border-bottom:#dedede 1px solid;'>";
			$ss .="<p style='width:98%; display:block; margin:0; padding:0; text-align:left;'>";
			$ss .= "<span style='width:".$ww."%; text-align:center; margin:0 3% 0 0; display:inline-block; background-color:".$bg."; padding:8px 0;'>첨부파일 ".$c."</span>";
			$ss .= "<a href='".$baseUrl.$row->mainMenu."/file_download/".$row->fnam."'>".$row->fnam."&nbsp;&nbsp;<img src='".PREDIR."/images/community/ico_file.gif' alt='파일다운로드' style='vertical-align:middle;'></a></p></li>";
			$c++;
		}
	}else{  //수정 모드 
		foreach($allfile as $row){
			$ss .= "<li style='width:50%; display:inline-block; text-align:center; padding:0; border-bottom:#dedede 1px solid;'>";
			$ss .="<p style='width:98%; display:block; margin:0; padding:0; text-align:left;'>";
			$ss .= "<span style='width:".$ww."%; text-align:center; margin:0 3% 0 0; display:inline-block; background-color:".$bg."; padding:8px 0;'>첨부파일 ".$c."</span>";
			$ss .= "<a href='#' onclick='appBasInfo.delFileGo(\"".$delmd."\", ".$md1.", ".$md2.", ".$md3.", ".$row->id.", ".$c.")'>".$row->fnam." <img src='".PREDIR."/images/common/btn_commt_del.gif' alt='파일삭제' style='vertical-align:middle;'></a></p></li>";
			$c++;
		}
	}
	
	$ss .= "</ul>";

	return $ss;
}



//테이블의 이름을 가져온다.
function getTable($mode, $md1, $md3){

	//$MCI =& get_instance();
	//$main = $MCI->session->userdata('mainMenu');

	switch($mode){
	case "banner":
		if($md1 == 1){
			switch($md3){
			case 2:
			case 3:     //상세보기 
			case 4:     //등록/수정
				$rt = "banner";
			break;
			}
		}else if($md1 == 2){
			switch($md3){
			case 2:
			case 3:    //상세보기 
			case 4:     //등록/수정
				$rt = "";
			break;
			}
		}
	break;
	case "community":
		if($md1 == 1){
			switch($md3){
			case 2:
			case 3:     //상세보기 
			case 4:     //등록/수정
				$rt = "gongji";
			break;
			}
		}else if($md1 == 2){
			switch($md3){
			case 2:
			case 3:    //상세보기 
			case 4:     //등록/수정
				$rt = "faq";
			break;
			}
		}else if($md1 == 3){
			switch($md3){
			case 2:    //등록 
			case 3:    //상세보기 
			case 4:     //등록/수정
				$rt = "fborder";
			break;
			}
		}
	break;
	}

	return $rt;
}


//자격에 따라 처리가능/불가능을 돌려준다.
function keyMan($md, $obj){
	$rt = false;
	$MCI =& get_instance();
	$po = $MCI->session->userdata('potion');
	$rid = $MCI->session->userdata('id');
	$mycoid = $MCI->session->userdata('coid');
	$mygb =  $MCI->session->userdata('cogubun');
	
	//echo "/////".$md;
	//------------------------------------
	switch($md){
	case "mkbdED":   //보드의 수정, 삭제 
	
		if($obj->cogubunWR == 3){
			if($mygb == BONSA) $rt = true;
			else $rt = false;
		}else $rt = true;
			
	break;	
	case "mkbdWR":
	
		if($obj->cogubunWR == 3){
			if($mygb == BONSA) $rt = true;
			else $rt = false;
		}else $rt = true;
			
	break;
	case "bonsa":
		if($mygb == BONSA) $rt = true;
		else $rt = false;
	break;	
	case "jasa":
		if($mygb == JASA) $rt = true;
		else $rt = false;
	break;
	case "wrman":
		//등록자여부 확인 
		if($obj == $MCI->session->userdata('memid')) $rt = true;
		else $rt = false;
	break;
	case "txtdel":
		//작성자 본인 또는 업체의 관리자는 지울수 있게 한다.
		if($obj['wr'] == $MCI->session->userdata('memid') or ((($obj['md'] == 1 and $mygb == BONSA) and $po > SAWON) or (($obj['md'] == 2 and $mygb == JOHAPG) and $po > SAWON))) $rt = true;
		else $rt = false;
		
		
		break;
	case "johap":
		if($mygb == JOHAPG) $rt = true;
		else $rt = false;
	break;
	case "bonsaadmin":
		if($mygb == BONSA and $po > SAWON) $rt = true;
		else $rt = false;
	
	break;
	case "johapUp":
		if($po >= JOHAP) $rt = true;
		else $rt = false;
	break;
	case "sawon":
		$rt = false;
		if($po >= SAWON) $rt = true;
	break;
	case "admin":
		$rt = false;
		if($po > SAWON) $rt = true;
	break;
	case "pochn":  //자격변경의 처리 여부 

		if(($obj['cgb'] == 2) || $obj['st'] != 2){  //무조건 false 조건
			
			//echo "1";
			$rt = false;  //조합의 경우 직책변경이 불가능 하다.
			
		}else{  //조합이 아닌 경우

			if($po == MASTER){  //마스터로 로그인한 경우 
				//echo "2";
				if($obj['po'] == MASTER) $rt = false;  //마스터는 마스터를 변경할 수 없다.
				else $rt = true;
			}else{
				if($po == SUPER or $po == ADMIN){
					//자신의 업체관련 정보만 출력된 상태라는 것이 기본전체조건
					if($mycoid == $obj['coid']){
						//echo "3";
						if($po < $obj['po']) $rt = false;
						else $rt = true;
					}else{
						//echo "4";
						$rt = false;
					}
				}else{
					//echo "5";
					$rt = false;
				}
			}
			//업체회원의 경우 직책변경 불가능하고 무조건 슈퍼관리자 이다.
			if($rt and $obj['gb'] == 1) $rt = true;
			else $rt = false;  //업체회원은 모두 슈퍼관리자 이므로 직책변경 불가능
			
			//echo "rt=".$rt;
			
		}
	break;
	case "gaip":  //가입회원 리스트
		if($po > SAWON) $rt = true;
	break;
	}

	return $rt;
}



function returnHs(){




}

function logout(){
	$MCI =& get_instance();
	
	$newdata = array('memid' => '', 'password' => '', 'main' => '', 'potion' => 0, 'coid' => 0, 'id' => 0, 'cogubun' => 0, 'find' => "", 'findMd' => "", 'logged_in' => FALSE);
	$MCI->session->unset_userdata($newdata);
	redirect("/home");

}


//검색 처리 
function proFind($ftxt, $md = 1){
	$MCI =& get_instance();
			
	if($md == 0){
		//검색설정 초기화 
		$MCI->session->set_userdata("find", "");
		$MCI->session->set_userdata("findMd", "0");
		return;
	}
	
	
		$fnd = $MCI->session->userdata("findMd");
		if($fnd == "0" and $ftxt == ""){
			//검색 모드값이 전체 이고 검색어가 없는 경우는 검색설정을 초기화 한다.
			$MCI->session->set_userdata("find", "");
		}else{
			
			$faa = rawurldecode($ftxt);
			if($faa == ""){
				//검색 모드 값도 없고 검색어도 없는 경우는 기존의 검색 설정을 그대로 적용한다.
				
			}else{
				//검색 설정을 변경한다.
				if($faa == "0") $faa = "0--";
				$fff = explode("--", $faa);

					if($fff[0] == "0"){      
						if(strlen($fff[1]) == 2){
							$hh = substr($fff[1], 0, 1);
							if($hh == "A" or $hh == "B" or $hh == "C"){
								$MCI->session->set_userdata("find", $fff[1]);
								$MCI->session->set_userdata("findMd", $fff[0]);
							}else{
								$MCI->session->set_userdata("find", "");
								$MCI->session->set_userdata("findMd", "0");
							}
						}else{
							$MCI->session->set_userdata("find", "");
							$MCI->session->set_userdata("findMd", "0");
						}
					}else{   //새로운 검색값이 있는 경우 
						if($fff[1] == ""){
							$MCI->session->set_userdata("find", "");
							$MCI->session->set_userdata("findMd", "0");
						}else{
							$MCI->session->set_userdata("find", $fff[1]);
							$MCI->session->set_userdata("findMd", $fff[0]);
						}
					}
				
			}
		}

}


//업체구분 
function getCogubun($dg){
	switch($dg){
	case 0:
		$tt = "";
	break;
	case 1:
		$tt = "전체회원 누구나";
	break;
	case 2:
		$tt = "";
	break;
	case 3:
		$tt = "본사회원만";
	break;
	}

	return $tt;
}

//사업자 번호 
function anzSaupnum($telg){
	$su = strlen($telg);
	
	if($su < 1){
		return "-";
	}
	
	$rr = substr($telg, 0, 3)."-".substr($telg, 3, 2)."-".substr($telg, 5, 5);
	
	return $rr;

}

//생년월일 출력 
function anzBday($telg){
	$su = strlen($telg);
	
	if($su < 1){
		return "-";
	}
	
	$rr = substr($telg, 0, 2)."-".substr($telg, 2, 2)."-".substr($telg, 4, 2);
	
	return $rr;

}


//전화번호 형태로 출력
function anzTel($telg){
	$su = strlen($telg);
	
	if($su < 9 and $su > 0){
		return $telg;
	}else if($su < 1){
		return "-";
	}
	
	if(substr($telg, 0, 2) == "02"){
		if($su == 9){
			$rr = substr($telg, 0, 2)."-".substr($telg, 2, 3)."-".substr($telg, 5, 4);
		}else{
			$rr = substr($telg, 0, 2)."-".substr($telg, 2, 4)."-".substr($telg, 6, 4);
		}
	}else{
	
		if($su == 10){
			$rr = substr($telg, 0, 3)."-".substr($telg, 3, 3)."-".substr($telg, 6, 4);
		}else if($su == 11){
			$ff = substr($telg, 0, 3);
			if($ff != "010" and $ff != "070"){
				if($su == 11) $rr = substr($telg, 0, 3)."-".substr($telg, 3, 4)."-".substr($telg, 7, 4);
				else $rr = substr($telg, 0, 3)."-".substr($telg, 3, 3)."-".substr($telg, 6, 4);
			}else{
				$rr = substr($telg, 0, 3)."-".substr($telg, 3, 4)."-".substr($telg, 7, 4);
			}
		}
		
	}
	

	return $rr;

}


//단계값을 가져온다.
function getDanget($dg){

	switch($dg){
	case 1:
		$tt = "전";
	break;
	case 2:
		$tt = "중";
	break;
	case 3:
		$tt = "후";
	break;
	}

	return $tt;
}


//수급여주를 가져온다.
function dispSugub($md){
	
	switch($md){
	case 0:
		$rt = "미상";
	break;
	case 1:
		$rt = "일반수급";
	break;
	case 2:
		$rt = "조건부수급";
	break;
	case 3:
		$rt = "인증차상위";
	break;
	case 4:
		$rt = "일반저소득";
	break;
	}
	
	return $rt;


}


//가구원 특기사항 가져온다.
function dispGagu($md, $gab = ""){
	//echo $md."/".$gab;
	
	switch($md){
	case 0:
		$rt = "미상";
	break;
	case 1:
		$rt = "노인부부";
	break;
	case 2:
		$rt = "독거노인";
	break;
	case 3:
		$rt = "조손가정";
	break;
	case 4:
		$rt = "장애인가구";
	break;
	case 5:
		$rt = "기타 ( ".$gab." )";
	break;
	}
	
	return $rt;
}



//수급여부를 가져온다.
function dispBojang($md, $gab = ""){
	switch($md){
	case 0:
		$rt = "미상";
	break;
	case 1:
		$rt = "의료보호1종";
	break;
	case 2:
		$rt = "의료보호2종";
	break;
	case 3:
		$rt = "직장의료보험";
	break;
	case 4:
		$rt = "지역의료보험";
	break;
	case 5:
		$rt = "기타 ( ".$gab." )";
	break;
	}
	
	return $rt;
}


//엑셀로 처리한다.
function toExcel($data){
	
	$nm = "대상자리스트_".date("Y-m-d");

	header( "Content-type: application/vnd.ms-excel" );   
	header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
	header( "Content-Disposition: attachment; filename = ".$nm.".xls" );   
	header( "Content-Description: PHP4 Generated Data" );   
	  

	  
	// 테이블 상단 만들기  
	$EXCEL_STR = "  
	<table border='1'>  
	<tr>  
	   <td>순번</td>  
	   <td>세대주</td>  
	   <td>생년월일</td>  
	   <td>업체이름</td>  
	   <td>전화번호</td> 
	   <td>핸드폰</td>  
	   <td>주소</td>  
	   <td>수급여부</td> 
	   <td>의료보장</td> 
	   <td>가구원특기사항</td> 
	   <td>등록일</td>
	</tr>";
	
	
	$su = count($data);
	$i = 0;
	foreach($data as $row){
	   $EXCEL_STR .= "  
	   <tr>  
		   <td>".($su - $i)."</td>  
		   <td>".$row->dsname."</td>  
		   <td>".$row->bday."</td>  
		   <td>".$row->coname."</td>  
		   <td>".$row->tel."</td>
		   <td>".$row->htel."</td>  
		   <td>( ".$row->post." ) ".$row->addr." ".$row->addr2."</td>  
		   <td>".dispSugub($row->sugub)."</td> 
		   <td>".dispBojang($row->bojang, $row->bojangetc)."</td> 
		   <td>".dispGagu($row->gaguinf, $row->gagumemo)."</td> 
		   <td>".$row->onday."</td> 
	   </tr>  
	   ";  
	   $i++;
	}
	 
	  
	$EXCEL_STR .= "</table>";  
	  
	echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";  
	echo $EXCEL_STR;  


}






//페이지 처리
function disp_page($allRec, $page){
	//disp_page(8, 2);
	//출력하고자 하는 페이지가 한번에 표시하는 페이지수 보다 작은 경우 
		//전체페이지를 구한다.
		$pp = $allRec % PAGELINE;
		$allRec += $pp;
		$allPage = $allRec / PAGELINE;
		
		
		if($allPage < $page){
			$page = $allPage;
		}
		
		if($allPage < $page) $stpg = 1;
		else{
			
			
			$stpg = $page;
		}
		
		//마지막 페이지를 구한다.
		$imsiend = $stpg + (PAGESU - 1);
		if($imsiend > $allPage) $endpg = $allPage;
		else $endpg = $imsiend;
		
		//시작 레코드를 구한다.
		$stRec = ($page - 1) * PAGELINE;
		//레코드 갯수 
		$suRec = PAGELINE;
		
		

	//페이지를 표시한다.
	//echo $stpg."/".$endpg."/".$page."/ stRec=".$stRec;
	
	
	
}



//경로표시
function disp_path($main, $md){
	
	$menuS = getSeMenu($main);
	
	return "<a href='".$menuS['url']."'>".$menuS['title']."</a> > <span><a href='".$menuS['sub'][($md-1)]['url']."'>".$menuS['sub'][($md-1)]['title']."</a></span>";
}

//특정 컨트로롤을 강제로 호출 한다.
function go_path($link, $md){
	return "/".$link.$md;
}


//사이드메뉴의 상단과 메인메뉴에 출력하는 메인 메뉴의 이름을 리턴한다.
function get_MainMenuName($main){

	$mm = getSeMenu($main);

	return $mm['title'];
}






//직책별 디폴터 서버메뉴를 설정한다.
function set_defaultSub(){

		$MCI =& get_instance();
		$myPo = $MCI->session->userdata('potion');
		$mygb = $MCI->session->userdata('cogubun');
		$rt = 0;
		switch($MCI->session->userdata('mainMenu')){
		case "mypage":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 1;
			break;
			case JOHAP:  //조합 
				$rt = 1;
			break;
			case SAWON:  //직원
				$rt = 1;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}
		break;
		case "main":  //회원관리 메뉴
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 0;
			break;
			case JOHAP:  //조합 
				$rt = 0;
			break;
			case SAWON:  //직원
				$rt = 0;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}
		break;
		case "musicon":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 1;
			break;
			case JOHAP:  //조합 
				$rt = 1;
			break;
			case SAWON:  //직원
				$rt = 1;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}		
		break;
/*
		case "hjang":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 1;
			break;
			case JOHAP:  //조합 
				$rt = 1;
			break;
			case SAWON:  //직원
				$rt = 1;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}		
		break;
*/
		case "gongji":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 0;
			break;
			case JOHAP:  //조합 
				$rt = 1;
			break;
			case SAWON:  //직원
				$rt = 0;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}		

		break;
		case "community":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //회원
				$rt = 2;
			break;
			case JOHAP:  //조합 
				$rt = 1;
			break;
			case SAWON:  //직원
				$rt = 2;
			break;
			case ADMIN:  //관리자
				$rt = 2;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 2;
			break;
			case MASTER:  //마스터
				$rt = 2;
			break;
			}				
		break;
		case "schedule":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 0;
			break;
			case JOHAP:  //조합 
				$rt = 2;
			break;
			case SAWON:  //직원
				if($mygb == BONSA) $rt = 1;
				else{
					if($mygb == JASA) $rt = 3;
					else $rt = 2;
				}
			break;
			case ADMIN:  //관리자
				if($mygb == BONSA) $rt = 1;
				else{
					if($mygb == JASA) $rt = 3;
					else $rt = 2;
				}
			break;
			case SUPER:  //슈퍼관리자
				if($mygb == BONSA) $rt = 1;
				else{
					if($mygb == JASA) $rt = 3;
					else $rt = 2;
				}
			break;
			case MASTER:  //마스터
				if($mygb == BONSA) $rt = 1;
				else{
					if($mygb == JASA) $rt = 3;
					else $rt = 2;
				}
			break;
			}		
		break;
		case "control":
			switch($myPo){
			case 0: //비로그인 
				$rt = 0;
			break;
			case USER:  //대상자 
				$rt = 0;
			break;
			case JOHAP:  //조합 
				$rt = 0;
			break;
			case SAWON:  //직원
				$rt = 0;
			break;
			case ADMIN:  //관리자
				$rt = 1;
			break;
			case SUPER:  //슈퍼관리자
				$rt = 1;
			break;
			case MASTER:  //마스터
				$rt = 1;
			break;
			}		

		break;
		}
		
		return $rt;

}





//서버메뉴 출력
//나의 지위와 현재 메뉴 위치이에 따라서 서버메뉴 출력
function disp_SubMenu($main, $md = 0, $bd = 0){
	
	$MCI =& get_instance();
	$myPo = $MCI->session->userdata('potion');
	$mygb = $MCI->session->userdata('cogubun');

	//$nowControl 값으로 서버메뉴를 가져온다.
	$menu = getSeMenu($main);
	
	$ji = '<ul class="NG">';
	for($m = 0; $m < count($menu['sub']); $m++){
	
		$ses = (($md - 1) == $m) ? ' class="on" ' : '' ;
		$ji .= '<li '.$ses.'><a href="'.$menu['sub'][$m]['url'].'">'.$menu['sub'][$m]['title'].'</a></li>';
	}
	$ji .= '</ul>';
	
	
	return $ji;
}


//메인메뉴 출력
function disp_MainMenu($mm){
	$MCI =& get_instance();
	$myPo = $MCI->session->userdata('potion');
	$baseUrl = $MCI->session->userdata('mrbaseUrl');


	$menu = getAllMenu();
	
	$ji = '<ul class="NG">';
	for($m = 0; $m < count($menu); $m++){
		if($mm == $menu[$m]['nowpg']){
			$ji .= '<li class="on"><a href="'.$menu[$m]['url'].'">'.$menu[$m]['title'].'</a></li>';
		}else{
			$ji .= '<li><a href="'.$menu[$m]['url'].'">'.$menu[$m]['title'].'</a></li>';
		}
	}
	$ji .= '</ul>';
	
	return $ji;

}




//포지션값으로 직위를 출력한다.
function potiontojigwi(){
	$MCI =& get_instance();
	$myPo = $MCI->session->userdata('potion');
	
	$ji = potiontojigwiP($myPo);

	return $ji;
}

//포지션값으로 직위를 출력한다.
function potiontojigwiP($myPo){

	
	$ji = "";
	switch($myPo){
	case 0: //비로그인 
		$ji = "모든회원";
	break;
	case USER:  //회원
		$ji = "직원";
	break;
	case JOHAP:  //조합 
		$ji = "직원";
	break;
	case SAWON:  //직원
		$ji = "직원";
	break;
	case ADMIN:  //관리자
		$ji = "관리자";
	break;
	case SUPER:  //슈퍼관리자
		$ji = "슈퍼관리자";
	break;
	case MASTER:  //마스터
		$ji = "마스터";
	break;
	}
	
	return $ji;
}


//각 컨트롤에서 회원의 자격에 따라 접근불가능한 메뉴접근시 강제로 돌려보낸다.
function pageGoInf($cnt){
	$MCI =& get_instance();
	$myPo = $MCI->session->userdata('potion');
	
	$pgPo = 3;
	switch($cnt){
	case "home":
	
	break;
	case "mypage":
	case "main":
		$pgPo = USER;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
	case "musion":
		$pgPo = USER;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
/*
	case "hjang":
		$pgPo = USER;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
*/
	case "gongji":
		$pgPo = JOHAP;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
	case "community":
		$pgPo = JOHAP;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
	case "schedule":
		$pgPo = JOHAP;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
	case "control":
		$pgPo = ADMIN;  //최소 페이지이 접근 자격 이다.
		$rt['page'] = rtPathP("musicon")."musicon";  //강제로 보내질 페지이 설정
	break;
	}
	
	
	$rt['rs'] = false;
	if($pgPo > $myPo) $rt['rs'] = true;  //true: 강제페이지 전환 대상이다.
	
	
	return $rt;
}




//암호화
function base64encode($string) {  
    $data = str_replace(array('+','/','='),array('-','_',''),base64_encode($string));  
    return $data;  
 }  

//복호화
function base64decode($string) {  
    $data = str_replace(array('-','_'),array('+','/'),$string);  
    $mod4 = strlen($data) % 4;  
    if ($mod4) {  
        $data .= substr('====', $mod4);  
    }  
    return base64_decode($data);  
}  



//자동으로 현재 경로를 리턴한다.
function rtPath(){
	$MCI =& get_instance();
	$mm = $MCI->router->fetch_class();

	//메뉴 선택설정
	switch($mm){
	case "mainod":
		$rt = 'order/';
	break;
	case "saleanz":
		$rt = 'sale/';
	break;
	case "mainS":
		$rt = 'statis/';
	break;
	case "noreAnz":
		$rt = 'nore/';
	break;
	case "mypage":
	case "main":
		$rt = 'member/';
	break;
	case "musicon":
		$rt = 'music/';
	break;
	case "gongji":
		$rt = 'notice/';
	break;
	case "community":
		$rt = 'community/';
	break;
	case "schedule":
		$rt = 'schedule/';
	break;
	case "control":
		$rt = 'control/';
	break;
	case "homect":
		$rt = 'homect/';
	break;
	}
	
	return $rt;

}


//파라미터에 따라 현재 경로를 리턴한다.
function rtPathP($mm){

	//메뉴 선택설정
	switch($mm){
	case "mainod":
		$rt = 'order/';
	break;
	case "saleanz":
		$rt = 'sale/';
	break;
	case "mainS":
		$rt = 'statis/';
	break;
	case "noreAnz":
		$rt = 'nore/';
	break;
	case "mypage":
	case "main":
		$rt = 'member/';
	break;
	case "musicon":
		$rt = 'music/';
	break;
	case "gongji":
		$rt = 'notice/';
	break;
	case "community":
		$rt = 'community/';
	break;
	case "schedule":
		$rt = 'schedule/';
	break;
	case "control":
		$rt = 'control/';
	break;
	case "homect":
		$rt = 'homect/';
	break;
	}
	
	return $rt;

}


function disp_cogubun($gb){
	$rt = "";
	switch($gb){
	case 1:  //계열사
		$rt = " 계열사";
	break;
	case 2:  //조함 
		$rt = "조합";
	break;
	case 3:  //본사 
		$rt = "본사";
	break;
	}
	return $rt;
}

//푸시 발송 처리 
function hddMessageGcm($tit, $txt, $mdinf, $to, $tnum){

	$MCI =& get_instance();
	
	
	$auth = "AIzaSyDd-Tpei_SBzIji0zKZa5CTMaQaRnNE7Bo";	  //383749398154
	$headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $auth);
	

			$arr   = array();
			$arr['data'] = array();
			$arr['data']['message'] = $txt; 
			$arr['data']['title'] = $tit;
			$arr['data']['msgcnt'] = 1;
			$arr['data']['listInf'] = $mdinf;   //ct, jumun
			$arr['data']['notId'] = $tnum;
			$arr['data']['defaults'] = 2;   //기본 진동 모드 
			$arr['registration_ids'] = array();


		$t = 0;
		for($c=0; $c < count($to); $c++){
			$ss = 'select gcmid from Anyting_gcmid where memid = "'.$to[$c]['memid'].'" ';
			$row = $MCI->db->query($ss)->result_array();

			for($a = 0; $a < count($row); $a++){
				$arr['registration_ids'][$t++] = $row[$a]['gcmid'];
			}
		}
		

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,    'https://android.googleapis.com/gcm/send');
			curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
			curl_setopt($ch, CURLOPT_POST,    true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
			$response = curl_exec($ch);
			
			if ($response === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}else{
				
			
			}
			curl_close($ch);

		

		//echo $response;
		//echo '{"rs":"ok", "to":"'.$to.'", "su":'.$allmesssu.', "arr":"'.$arr['registration_ids'][0].'"}';	

}





//-----------파일 처리

//파일 업로드 함수
function file_upload($file, $folder, $allowExt, $file_name) {
	$max_width = 800;
	
	$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
  
  if($ext) {
			$allow = explode(',', $allowExt);
      if(is_array($allow)) {
		      $check = in_array($ext, $allow);
      } else {
          $check = ($ext == $allow) ? true : false;
      }
	}

  if(!$ext || !$check) exit($ext.'<script type="text/javascript">alert(\''.$ext.'-ext1 파일은 업로드 하실수 없습니다!\'); history.go(-1);</script>');
	
	$upload_file = $folder.$file_name.".".strtolower($ext);
	

  if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
  		@chmod($upload_file, 0707);
      $return = '<script type="text/javascript">function copy(str) { clipboardData.setData("Text", str); alert("경로가 복사 되였습니다."); }</script>';
      $return.= '업로드 된 파일 경로 : <a href="#" onclick="copy(\''.$upload_file.'\'); return false;">'.$upload_file.'</a>';
 
 		//화일의 크기 검사
		$img_info=@getimagesize($upload_file);
		if($img_info[0] > $max_width){
			
			//echo $img_info[0];
			//이미지 크기줄이기 위해 원본의 이름변경.
			rename($upload_file,$folder."bak-".$file_name.".".strtolower($ext));
				  
			//이미지 크기를 줄여서 생성한다
			GD2_resize_imgX($max_width,"",$folder."bak-".$file_name.".".strtolower($ext));
			unlink($folder."bak-".$file_name.".".strtolower($ext));
		}
 
                    
      GD2_make_thumb(120,120,'thumb/s_',$upload_file);  //썸네일 생성
                    
      return $file_name.".".$ext;
  } else {
   		exit('<script type="text/javascript">'.$file['name'].' - alert('.$ext.'-ext2 \'123업로드에 실패하였습니다!\''.$upload_file.'); history.go(-1);</script>');
  }
}



//이미지 가로크기 변경여 줍니다.
function GD2_resize_imgX($max_x,$dst_name/*생성될 이미지파일이름*/,$src_file/*원본 파일이름*/) {
        $img_info=@getimagesize($src_file);
        $sx = $img_info[0];
        $sy = $img_info[1];
		
		
        //썸네일 보다 큰가?
        if ($sx > $max_x) {
                $nanum = $max_x / $sx;
                $thumb_y = $sy * $nanum;
                $thumb_x = $max_x;
        } else {
                $thumb_y=$sy; //이미지의 세로 크기 설정
                $thumb_x=$sx; //이미지의 가로 크기 설정
        }


                $_dq_tempFile=basename($src_file);                          //파일명 추출
                $_dq_tempDir=str_replace($_dq_tempFile,"",$src_file);       //경로 추출
                $ss = substr($_dq_tempFile,4);                              //'bak-' 뻰 순수 파일 이름 구함
                $_dq_tempFile=$_dq_tempDir.$dst_name.$ss;                   //경로 + 새 파일명 생성





                $_create_thumb_file = true;
                if (file_exists($_dq_tempFile)) { //섬네일 파일이 이미 존제한다면 이미지의 사이즈 비교
                        $oldjy_img=@getimagesize($_dq_tempFile);
                        if($oldjy_img[0] != $thumb_x) $_create_thumb_file = true; else $_create_thumb_file = false;
                } 
                
                
                if ($_create_thumb_file) {
                        // 복제
                  	if ($img_info[2]=="2") {
                        $src_img=imagecreatefromjpeg($src_file);
                    }elseif($img_info[2]=="1"){
                        $src_img=imagecreatefromgif($src_file);
                    }else{
						$src_img=imagecreatefrompng($src_file);
					}

 
                    $dst_img=imagecreatetruecolor($thumb_x, $thumb_y);
                    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_x,$thumb_y,$sx,$sy);
                    imagejpeg($dst_img,$_dq_tempFile,100);
                    // 메모리 초기화
                    imagedestroy($dst_img);

                }
}


//작은 썸네일 이미지 생성
function GD2_make_thumb($max_x,$max_y/*줄여줄 이미지의 가로세로 크기*/,$dst_name/*생성될 이미지파일이름*/,$src_file/*원본 파일이름*/) {
        $img_info=@getimagesize($src_file);
        $sx = $img_info[0];
        $sy = $img_info[1];
        //썸네일 보다 큰가?
        if ($sx>$max_x || $sy>$max_y) {
                if ($sx>$sy) {
                                $thumb_y=ceil(($sy*$max_x)/$sx);
                                $thumb_x=$max_x;
                } else {
                                $thumb_x=ceil(($sx*$max_y)/$sy);
                                $thumb_y=$max_y;
                }
        } else {
                $thumb_y=$sy;
                $thumb_x=$sx;
        }

                $_dq_tempFile=basename($src_file);                                //파일명 추출
                $_dq_tempDir=str_replace($_dq_tempFile,"",$src_file);        //경로 추출
                $_dq_tempFile=$_dq_tempDir.$dst_name.$_dq_tempFile;        //경로 + 새 파일명 생성

                $_create_thumb_file = true;
                if (file_exists($_dq_tempFile)) { //섬네일 파일이 이미 존제한다면 이미지의 사이즈 비교
                        $oldjy_img=@getimagesize($_dq_tempFile);
                        if($oldjy_img[0] != $thumb_x) $_create_thumb_file = true; else $_create_thumb_file = false;
                        if($oldjy_img[1] != $thumb_y) $_create_thumb_file = true; else $_create_thumb_file = false;
                } 
                if ($_create_thumb_file) {
                        // 복제
						//echo "info======".$img_info[2];
						
						
                  	if ($img_info[2]=="2") {
                        $src_img=ImageCreateFromjpeg($src_file);
                    }elseif($img_info[2]=="1"){
                        $src_img=ImageCreateFromgif($src_file);
                    }else{
						 $src_img=ImageCreateFrompng($src_file);
					}
					
                        $dst_img=ImageCreateTrueColor($thumb_x, $thumb_y);
                        ImageCopyResampled($dst_img,$src_img,0,0,0,0,$thumb_x,$thumb_y,$sx,$sy);
                        Imagejpeg($dst_img,$_dq_tempFile,100);
                        // 메모리 초기화
                        ImageDestroy($dst_img);
                }
}






//테스트용 함수-----------------------
function my_echo($ss){
	echo "My_".$ss;
}

?>
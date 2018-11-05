<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define ("JASA", 1);  //계열사의 구분
define ("BONSA", 3);  //업체구분 본사인 경우
define ("JOHAPG", 2);   //업체구분 조합
define ("BONSAID", 7);   //본사의 레코드 아이디

define ("USER", 1);    //대상자
define ("JOHAP", 2);   //조합원 - 직위
define ("SAWON", 3);   //직원  - 직위
define ("ADMIN", 4);   //관리자 - 직위 
define ("SUPER", 5);   //각업체 슈퍼관리자 
define ("MASTER", 7);   //본사의 슈퍼관리자


define ("PAGESU", 3);  //전체페이지의 표시 갯수
define ("PAGELINE", 10);  //페이지당 라인의 수 

define ("PREDIR0", "");   //서버의 기본 링크 
define ("PREDIR", "/");   //서버의 기본 링크 

define ("FILEUP", "fileUp/");  //파일 업로드 경로
define ("BANNERFILE", "images/banner/");  //배너파일 경로


//=================================
//부적절한 접근 차단
//=================================
function NotReadyNotGo($ct){
	$MCI =& get_instance();
	
	if(!$MCI->session->userdata('memid')){  //로그아웃
		redirect("/home") ;
	}else{
		//회원의 자격으로 열수 없는 페이지는 강제로 페이지 전환한다.
		$rra = pageGoInf($ct);
		if($rra['rs']) redirect($rra['page']);
	}

}
//=================================
//중요환경변수 값을 설정한다.
//=================================
function setArrayToConfig($arr){
	$MCI =& get_instance();
	
	foreach(array_keys($arr) as $key){
		$MCI->config->set_item($key, $arr[$key]);
	}

}
//=================================
//md 값 설정
//=================================
function setMdGab($md1, $md2, $md3, $md4){
	$MCI =& get_instance();
	$arr = array("md1"=>$md1, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4);

	setArrayToConfig($arr);
	
}
//=================================
//md 값을 가져온다.
//=================================
function getConfigGab($md){
	$MCI =& get_instance();

	return $MCI->config->item($md);
}
//=================================
//전체 가수의 이름을 가져온다.
//=================================
function getAllGasu(){
	$MCI =& get_instance();
	$MCI->load->model('music/musiconm');
	
	$arr = $MCI->musiconm->getAllGasu();
	
	$ss = "";
	foreach($arr as $arrg){
		$ss .= "<option value=".$arrg->fdir.">".$arrg->gasu."</option>";
	}
	
	return $ss;
}
//=================================
//관리자 권한 옵션 돌려주기
//=================================
function getAdminGubunAll(){
	$tbname = array("0"=>"권한없음", "1"=>"음원업로드","2"=>"고객상담(회원조회)","3"=>"통계조회","4"=>"주문제작 CMS");
	
	return $tbname;
}
//=================================
//선택한 권한 이름을 반환한다.
//=================================
function getArrayFieldGab($gb, $inx){
	
	switch($gb){
	case "adminGubun":
		$tbname = getAdminGubunAll();
	break;
	}
	
	return $tbname[$inx];
}
//=================================
//관리자 권한 옵션 엘레멘트를 돌려 준다.
//=================================
function getAdminGubunAllDisp(){
	
	$arr = getAdminGubunAll();
	$ss = "";
	for($c =0; $c < count($arr); $c++){
		$ss .= "<option value=".$c.">".$arr[$c]."</option>";
	}
	
	return $ss;
}
//=================================
//구분값으로 테이블 이름을 가져온다.
//=================================
function getDBTableName($gb, $md3){
	$tbname['banner'] = array("", "banner","banner","banner","banner");
	
	
	
	return $tbname[$gb][$md3];
}
//=================================
//DB 테이블 이름 리턴
//=================================
function getDBTable($md, $md2, $md3){
	$MCI =& get_instance();
	$main = $MCI->session->userdata('mainMenu');

	$tball['musicon'] = array("", 
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //신규음원등록 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //추천mr등록 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //등록음원 조회 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);

	$tball['mainS'] = array("", 
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //음원매출 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //이용권구매 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //가입자 통계 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);

	$tball['saleanz'] = array("", 
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "aa", "aa", "aa", "aa"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);
	
	$tball['mainod'] = array("", 
		array("", 
			array("", "jumun", "jumun", "jumun", "jumun"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);

	$tball['main'] = array("", 
		array("", 
			array("", "member", "member", "member", "member"),  //전체회원 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "member", "member", "member", "member"),  //가입회원 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "member", "member", "member", "member"),  //탈퇴회원 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
	);

	$tball['gongji'] = array("", 
		array("", 
			array("", "pushList", "pushList", "pushList", "pushList"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);

	$tball['noreAnz'] = array("", 
		array("", 
			array("", "myjarang", "myjarang", "myjarang", "myjarang"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		)
	);
	
	$tball['community'] = array("", 
		array("", 
			array("", "gongji", "gongji", "gongji", "gongji")  //공지사항 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
		),
		array("", 
			array("", "mrFaq", "mrFaq", "mrFaq", "mrFaq"),
			array("", "mrFaq", "mrFaq", "mrFaq", "mrFaq"),
			array("", "mrFaq", "mrFaq", "mrFaq", "mrFaq"),
			array("", "mrFaq", "mrFaq", "mrFaq", "mrFaq"),
			array("", "mrFaq", "mrFaq", "mrFaq", "mrFaq")
		),   //FAQ),
		array("", 
			array("", "mrFaqBd", "mrFaqBd", "mrFaqBd", "mrFaqBd")
		)  //질문관리
	);
	
	$tball['control'] = array("", array("", 
	array("", "banner", "banner", "banner", "banner"),  //베너관리 1:리스트, 2:추가, 3:상세보기 삭제, 4:수정
	array("", "member", "member", "member", "member")   //계정관리
	));

	
	return $tball[$main][$md][$md2][$md3];
}

//menu===============
function getAllMenu(){
	$MCI =& get_instance();
	$baseUrl = $MCI->session->userdata("mrbaseUrl");

	$menuG[] = array("nowpg"=>"homect", "title"=>"Home", "mainUrl"=>$baseUrl."homect/homect/", "url"=>$baseUrl."homect/homect/getView/1/1/1", "sub"=>array(
		array("title"=>"Home", "url"=>$baseUrl."homect/homect/getView/1/1/1", "npage"=>"homect",
			"sub2"=>array(
				array("title"=>"Home", "url"=>$baseUrl."homect/homect/getView/1/1/1")
			)
		),
	));
	
	$menuG[] = array("nowpg"=>"musicon", "title"=>"음원관리", "mainUrl"=>$baseUrl."music/musicon/", "url"=>$baseUrl."music/musicon/getView/1/1/1", "sub"=>array(
		array("title"=>"음원관리", "url"=>$baseUrl."music/musicon/getView/1/1/1", "npage"=>"musicon",
			"sub2"=>array(
				array("title"=>"음원관리", "url"=>$baseUrl."music/musicon/getView/1/1/1"),
				array("title"=>"곡별 음원등록", "url"=>$baseUrl."music/musicon/getView/1/1/2"),
				array("title"=>"압축해제 음원등록", "url"=>$baseUrl."music/musicon/getView/1/1/3"),
				array("title"=>"압축해제 실패내역", "url"=>$baseUrl."music/musicon/getView/1/1/4"),
				array("title"=>"가수 리스트", "url"=>$baseUrl."music/musicon/getView/1/1/5"),
				array("title"=>"노래 리스트", "url"=>$baseUrl."music/musicon/getView/1/1/6")
			)
		), 
		array("title"=>"통계", "url"=>$baseUrl."music/musicon/getView/2/1/1", "npage"=>"musicon",
			"sub2"=>array(
				array("title"=>"통계", "url"=>$baseUrl."music/musicon/getView/2/1/1")
			)
		), 
		array("title"=>"통합검색", "url"=>$baseUrl."music/musicon/getView/3/1/1", "npage"=>"musicon",
			"sub2"=>array(
				array("title"=>"통합검색", "url"=>$baseUrl."music/musicon/getView/3/1/1")
			)
		) 
	));	
	
	$menuG[] = array("nowpg"=>"mainS", "title"=>"통계", "mainUrl"=>$baseUrl."statis/mainS/", "url"=>$baseUrl."statis/mainS/getView/1/1/1", "sub"=>array(
		array("title"=>"전체현황", "url"=>$baseUrl."statis/mainS/getView/1/1/1", "npage"=>"statis",
			"sub2"=>array(
				array("title"=>"전체현황", "url"=>$baseUrl."statis/mainS/getView/1/1/1")
			)
		), 
		array("title"=>"음원매출 통계", "url"=>$baseUrl."statis/mainS/getView/2/1/1", "npage"=>"statis",
			"sub2"=>array(
				array("title"=>"음원매출 통계", "url"=>$baseUrl."statis/mainS/getView/2/1/1")
			)
		), 
		array("title"=>"이용권구매 통계", "url"=>$baseUrl."statis/mainS/getView/3/1/1", "npage"=>"statis",
			"sub2"=>array(
				array("title"=>"이용권구매 통계", "url"=>$baseUrl."statis/mainS/getView/3/1/1")
			)
		), 
		array("title"=>"가입자 통계", "url"=>$baseUrl."statis/mainS/getView/4/1/1", "npage"=>"statis",
			"sub2"=>array(
				array("title"=>"가입자 통계", "url"=>$baseUrl."statis/mainS/getView/4/1/1")
			)
		) 
	));
	
	
	$menuG[] = array("nowpg"=>"saleanz", "title"=>"이용권관리", "mainUrl"=>$baseUrl."sale/saleanz/", "url"=>$baseUrl."sale/saleanz/getView/1/1/1", "sub"=>array(
		array("title"=>"이용권관리", "url"=>$baseUrl."sale/saleanz/getView/1/1/1", "npage"=>"saleanz",
			"sub2"=>array(
				array("title"=>"이용권관리", "url"=>$baseUrl."sale/saleanz/getView/1/1/1")
			)
		),
		array("title"=>"이벤트", "url"=>$baseUrl."sale/saleanz/getView/2/1/1", "npage"=>"saleanz",
			"sub2"=>array(
				array("title"=>"이벤트관리", "url"=>$baseUrl."sale/saleanz/getView/2/1/1")
			)
		)
	));
		
	$menuG[] = array("nowpg"=>"mainod", "title"=>"주문제작", "mainUrl"=>$baseUrl."order/mainod/", "url"=>$baseUrl."order/mainod/getView/1/1/1", "sub"=>array(
		array("title"=>"주문관리", "url"=>$baseUrl."order/mainod/getView/1/1/1", "npage"=>"order",
			"sub2"=>array(
				array("title"=>"주문관리", "url"=>$baseUrl."order/mainod/getView/1/1/1")
			)
		)
	));

	
	$menuG[] = array("nowpg"=>"noreAnz", "title"=>"노래자랑", "mainUrl"=>$baseUrl."nore/noreAnz/", "url"=>$baseUrl."nore/noreAnz/getView/1/1/1", "sub"=>array(
		array("title"=>"노래자랑", "url"=>$baseUrl."nore/noreAnz/getView/1/1/1", "npage"=>"noreAnz",
			"sub2"=>array(
				array("title"=>"노래자랑 관리", "url"=>$baseUrl."nore/noreAnz/getView/1/1/1")
			)
		)
	));
	
	
	$menuG[] = array("nowpg"=>"main", "title"=>"회원관리", "mainUrl"=>$baseUrl."member/main/", "url"=>$baseUrl."member/main/getView/1/1/1", "sub"=>array(
		array("title"=>"전체 회원관리", "url"=>$baseUrl."member/main/getView/1/1/1", "npage"=>"main",
			"sub2"=>array(
				array("title"=>"전체 회원관리", "url"=>$baseUrl."member/main/getView/1/1/1")
			)
		),
		array("title"=>"신고관리", "url"=>$baseUrl."member/main/getView/2/1/1", "npage"=>"main",
			"sub2"=>array(
				array("title"=>"신고관리", "url"=>$baseUrl."member/main/getView/2/1/1")
			)
		),  
	));
			
	$menuG[] = array("nowpg"=>"gongji", "title"=>"알림관리", "mainUrl"=>$baseUrl."notice/gongji/", "url"=>$baseUrl."notice/gongji/getView/1/1/1", "sub"=>array(
		array("title"=>"푸쉬 메시지", "url"=>$baseUrl."notice/gongji/getView/1/1/1", "npage"=>"gongji",
			"sub2"=>array(
				array("title"=>"발송리스트", "url"=>$baseUrl."notice/gongji/getView/1/1/1"),
				array("title"=>"푸쉬 발송", "url"=>$baseUrl."notice/gongji/getView/1/1/2")
			)
		)
	));
	

	
	$menuG[] = array("nowpg"=>"community", "title"=>"커뮤니티", "mainUrl"=>$baseUrl."community/community/", "url"=>$baseUrl."community/community/getView/1/1/1", "sub"=>array(
		array("title"=>"공지사항", "url"=>$baseUrl."community/community/getView/1/1/1", "npage"=>"community",
			"sub2"=>array(
				array("title"=>"공지사항 리스트", "url"=>$baseUrl."community/community/getView/1/1/1"),
				array("title"=>"공지사항 등록", "url"=>$baseUrl."community/community/getView/1/1/2")
			)
		), 
		array("title"=>"FAQ", "url"=>$baseUrl."community/community/getView/2/1/1", "npage"=>"community", 
			"sub2"=>array(
				array("title"=>"결제/구매", "url"=>$baseUrl."community/community/getView/2/1/1"),
				array("title"=>"회원정보", "url"=>$baseUrl."community/community/getView/2/2/1"),
				array("title"=>"듣기및 다운로드", "url"=>$baseUrl."community/community/getView/2/3/1"),
				array("title"=>"오류해결", "url"=>$baseUrl."community/community/getView/2/4/1"),
				array("title"=>"기타", "url"=>$baseUrl."community/community/getView/2/5/1")
			)
		), 
		array("title"=>"질문관리", "url"=>$baseUrl."community/community/getView/3/1/1", "npage"=>"community",
			"sub2"=>array(
				array("title"=>"질문관리", "url"=>$baseUrl."community/community/getView/3/1/1"),
				array("title"=>"질문등록", "url"=>$baseUrl."community/community/getView/3/1/2")
			)
		) 
	));
	
	$menuG[] = array("nowpg"=>"control", "title"=>"운영관리", "mainUrl"=>$baseUrl."control/control/", "url"=>$baseUrl."control/control/getView/1/1/1", "sub"=>array(
		array("title"=>"배너관리", "url"=>$baseUrl."control/control/getView/1/1/1", "npage"=>"control",
			"sub2"=>array(
				array("title"=>"배너 리스트", "url"=>$baseUrl."control/control/getView/1/1/1"),
				array("title"=>"배너 추가", "url"=>$baseUrl."control/control/getView/1/1/2"),
				array("title"=>"배너 보기", "url"=>$baseUrl."control/control/getView/1/1/3"),
				array("title"=>"배너 수정", "url"=>$baseUrl."control/control/getView/1/1/4")
			)
		), 
		array("title"=>"계정관리", "url"=>$baseUrl."control/control/getView/2/1/1", "npage"=>"control",
			"sub2"=>array(
				array("title"=>"관리자 리스트", "url"=>$baseUrl."control/control/getView/2/1/1"),
				array("title"=>"관리자 추가", "url"=>$baseUrl."control/control/getView/2/1/2")
			)
		) 
		/*
		array("title"=>"게시판 생성", "url"=>$baseUrl."control/control/getView/1/1/1", "npage"=>"control",
			"sub2"=>array(
				array("title"=>"게시판 생성", "url"=>$baseUrl."control/control/getView/1/1/1")
			)
		), 
		array("title"=>"게시판 리스트", "url"=>$baseUrl."control/control/getView/2/1/1", "npage"=>"control",
			"sub2"=>array(
				array("title"=>"게시판 리스트", "url"=>$baseUrl."control/control/getView/2/1/1")
			)
		), 
		*/
	));
		
			
	return $menuG;
}

function getSeMenu($keyg){
	$menuG = getAllMenu();
	
	for($m = 0; $m < count($menuG); $m++){
		if($menuG[$m]['nowpg'] == $keyg){
			$mm = $menuG[$m];
			break;
		}
	}
	
	return $mm;
}



//====================


?>
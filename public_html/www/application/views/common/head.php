<?php

$nowControl = $this->session->userdata('mainMenu');

//echo "mmm===".$nowControl;

$baseUrl = $this->session->userdata('mrbaseUrl');  //http://mroo.co.kr/

//echo $baseUrl;

$baseOrg = $baseUrl;

$baseImgUrl = $baseUrl."images/scene/";

$this->session->set_userdata('bannerImgPath', $baseUrl."images/banner/");

$baseUrlMy = $baseUrl."member/";


//$this->config->set_item("kimss","99999");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="stylesheet" type="text/css" href="<?=PREDIR?>templt/lib/css/admin/admin.css" />



  <!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->



  <script src="/jquery-mobile/jquery-3.3.1.min.js"></script>
  <script src="/jquery-mobile/jquery.easing.1.3.js"></script>

    
	<title>MROO</title>

	<script>
		var pageMode = "<?=$mode?>";
		var pageMd = <?=$md?>;
		var pageMd2 = <?=$md2?>;
		var pageMd3 = <?=$md3?>;
		
		var baseURL = "<?=$baseOrg?>";

		
		var baseImgUrl = "<?=$baseImgUrl?>";
		
		
		var imsiLat, imsiLang;
		
				
			var date = new Date();
			var sdd = date.getDate();
			var sdm = (date.getMonth() + 1);
			if(sdm < 10) sdm = "0"+sdm;
			var sdy = date.getFullYear();
			if(sdd < 10) sdd = "0"+sdd;

		
    </script>


	<script type="text/javascript" src="<?=$baseOrg?>navertext/js/HuskyEZCreator.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?=$baseOrg?>apis/fontas.js" charset="utf-8"></script>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDd-Tpei_SBzIji0zKZa5CTMaQaRnNE7Bo"></script>
    
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

	<!--<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>-->

   
	<script type="text/javascript">

	$(document).ready(function(e) {



		function openpost(){
		
			new daum.Postcode({
				oncomplete: function(data) {
					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
						var fullAddr = data.address; // 최종 주소 변수
						var extraAddr = ''; // 조합형 주소 변수
						
						// 기본 주소가 도로명 타입일때 조합한다.
						if(data.addressType === 'R'){
							//법정동명이 있을 경우 추가한다.
							if(data.bname !== ''){
								extraAddr += data.bname;
							}
							// 건물명이 있을 경우 추가한다.
							//if(data.buildingName !== ''){
								//extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							//}
							// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
							//fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
						}
		
						// 우편번호와 주소 정보를 해당 필드에 넣는다.
						document.getElementById('copost').value = data.zonecode; //5자리 새우편번호 사용
						document.getElementById('coaddress').value = fullAddr;
						
	
				}
	
			}).open();
		
		}

            
    });
	



	</script> 
    
</head>


<body>
<div id="wrapper">


<!------레이어 팝업------------------>
       	<div class="window windowClose windowStyle">
            <input type="button" href="#" class="close" value="가운데 띄워지는 레이어 팝업 입니다. (닫기)"/>
        </div>
<!------레이어 팝업 종료--------------->
        
 

  		<div id="allBg">
        
        	<div id="popupBox" class="deldiv" style="display:none;">
                <h2>삭제 알림</h2>
                <div id="BoxMess" class="deldiv">정말로 삭제 할까요?<br />삭제하시면 복구 불가능합니다.<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.memDelOk('del')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupBoxChadan" style="display:none;">
                <h2>차단 알림</h2>
                <div id="BoxMess" class="chadan">회원자격 차단 할까요?<br />차단시 로그인 불가능 합니다.<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.memDelOk('chadan')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupBoxOnOk" style="display:none;">
                <h2>가입승인 알림</h2>
                <div id="BoxMess">가입요청을 승인할 까요?<br />승인후 상세보기에서 회원자격을 설정하셔야 합니다.<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.memDelOk('onok')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupBoxOnRt" style="display:none;">
                <h2>가입취소 알림</h2>
                <div id="BoxMess">승인된 가입요청을 취소 합니다.<br />취소된 요청은 미가입회원관리에서 확인.<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.memDelOk('onrt')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
        
            <div id="popupBoxPo" style="display:none;">
                <h2>직책변경 알림</h2>
                <div id="BoxMess">직책변경을 하려고 합니다.<br />승인하시겠습니까?<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.poChange('0', 0, 'g', 0)"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupMessDel" style="display:none;">
                <h2>메시지 발송내역 삭제 알림</h2>
                <div id="BoxMess">선택한 메시지를 삭제할 까요?<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('mess')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupMailDel" style="display:none;">
                <h2>메일 발송내역 삭제 알림</h2>
                <div id="BoxMess">선택한 내역을 삭제할 까요?<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('mail')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupPushDel" style="display:none;">
                <h2>푸쉬 발송내역 삭제 알림</h2>
                <div id="BoxMess">선택한 내역을 삭제할 까요?<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('push')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupBdDel" style="display:none;">
                <h2>게시판 삭제 알림</h2>
                <div id="BoxMess">선택한 게시판을 삭제할 까요?<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('mkbd')"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            <div id="popupEvent" style="display:none;">
                <h2>이벤트 관리</h2>
                <div id="BoxMess">이벤트의 수정/삭제 가능합니다. 삭제시 복구 불가능 합니다.<br /><br />
                <textarea name="pEvent" id="pEvent" style="width:98%; height:94px;"></textarea>
                <p style="width:100%; padding:5px 0; text-align:center;"><span>시작날자 : </span><input type="date" id="stday" value="" /> <span>시간 : </span><input type="time" id="sttime" value="" /></p>
                <p style="width:100%; padding:5px 0; text-align:center;"><span>종료날자 : </span><input type="date" id="endday" value="" /> <span>시간 : </span><input type="time" id="edtime" value="" /></p>
                </div>
                <ul>
                <li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('anzevDel')"><span>삭제</span></a></li>
                <li><a href="#" class="btn_gray" onclick="meminf.noticeDelOk('anzevEdit')"><span>수정</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
            
            
        
        </div>
        
<?

if($mode == "community") $ddt = array("dat"=>$datbd);
else $ddt = 0;

$menuS = getSeMenu($nowControl);
            
?>          


            
  <!-- container -->
  <div id="container">
  
        <!-- header -->
        <div id="header">
          <h1 id="logo"><img src="<?=PREDIR?>templt/imgs/admin/logo.png" alt="두꺼비하우징" style="width:16%;margin:3px 0 0;"></h1>
          <div id="gnb">
            <ul>
              <li class="home"><a href="<?=$baseUrlMy?>mypage/getView/1/<?=$this->session->userdata('id')?>">&nbsp;&nbsp;&nbsp;마이페이지</a></li>
              <li class="log"><a href="<?=$baseUrl.rtPath().$nowControl?>/logout" class="logout">로그아웃</a></li>
              <li><strong><?=potiontojigwi($this->session->userdata('potion'))?></strong> (<?=$this->session->userdata('memid')?>)</li>
            </ul>
          </div>
          <div id="lnb">
			<?=disp_MainMenu($nowControl); //나의 지위에 따라서 메인메뉴 출력?>
          </div>
        </div>
        <!-- //header -->


    
    	<div id="snb">
        	<div class="title NG"><?=$menuS['title']; ?></div>
            
            <div id="side_menu"><?=disp_SubMenu($nowControl, $md, $ddt); //사이드메뉴 출력 ?></div>
    	</div>
        
        
        <!--<div class="path"><table style="width:96%;"><tr><td style="width:60%;"> <?=disp_path($nowControl, $md)?></td><td style="width:40%;"> <span></span> </td></tr></table></div>-->
        <div id="contents">
     
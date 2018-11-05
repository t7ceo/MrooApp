<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "schedule/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.




switch($md){
case 1:
	$tt = "본사 스케줄 등록";
break;
case 2:
	$tt = "조합 스케줄 등록";
break;
case 3:
	$tt = "자사 스케줄 등록";
break;
}



$su = 0; //count($gaip);
?>
<script src='/spectrum/spectrum.js'></script>
<link rel='stylesheet' href='/spectrum/spectrum.css' />
<script language = "javascript">
$(function() {
  $( "#dt1" ).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
});

$(function() {
  $( "#dt2" ).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
});
</script>




	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$tt?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 대상자 등록 -->
      

   <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; width:750px; height:auto; border:none; display:block;">
 
<form name="frmMem" action="<?=$baseUrl?>schedule/onputSchedule" method="POST">
<input type="hidden" name= "ci_t" value="<?=$cihs?>">
<input type="hidden" name="coid" value="<?=$coid?>">
<input type="hidden" id="color_code" name="color">
<input type="hidden" name="md" value="<?=$md?>">
<input type="hidden" name="md2" value="<?=$onmd?>">
<input type="hidden" name="type" value="insert">
 



        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>제목</span></th><td>
            <input type="text" id="title" name="title" maxlength="50" value="" style="width:88%;"  />
        </td></tr>
        <tr><th><span class="pilsuno">*</span><span>일정</span></th><td>
            <input type="text" id="start_dt" name="start_dt" style="width:100px" readonly placeholder="시작일" /> ~ <input type="text" id="end_dt" name="end_dt" style="width:100px" readonly placeholder="종료일" />
        </td></tr>
        
        <tr><th><span class="pilsu">*</span><span>배경색</span></th><td>
            <input type='text' id="color" value="#000" />
        </td></tr>

        
        <tr><th colspan="2"><span>내용</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
         
    <textarea name="content" id="content" style="width:99%; margin:0; height:250px;"></textarea>
    
    </td></tr>
    </table>
    

        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org" onclick="fnSend();"><span>스케줄 등록</span></a>
        <a href="<?=$baseUrl?>schedule/getView/<?=$md?>"class="btn_gray"><span>목록</span></a>
        </p>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>

 
</form>
   

  </div>
  
  


<script>

$("#color").spectrum({
    color: "#000"
});

	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


	var dd = document.getElementById("start_dt");
	//dd.value = sdy+"-"+sdm+"-"+sdd;


var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "content",
	sSkinURI: "SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : false,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});

function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
	oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["content"].getIR();
	//alert(sHTML);
}

function fnSend(){
	oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.


	var color = $("#color").spectrum('get').toHexString();
	if(color){
		$('#color_code').val(color);
	}

	if($('#title').val() == ''){
		alert('제목을 입력하세요.');
		$('#title').focus();
		return false;
	}

	if($('#start_dt').val() == ''){
		alert('시작일을 입력하세요.');
		$('#start_dt').focus();
		return false;
	}

	if($('#end_dt').val() == ''){
		alert('종료일을 입력하세요.');
		$('#end_dt').focus();
		return false;
	}

	var stday = $('#start_dt').val();
	var endday = $('#end_dt').val();
	if(dayVar.betweenDayToDay(stday, endday) == 0){
		appUtil.alertgo("알림","종료일자는 시작일자 이후의 날짜로 입력하세요.");
		return;
	}


	if($('#content').val() == ''){
		alert('내용을 입력하세요.');
		return false;
	}

	document.frmMem.submit();
}
</script>     
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

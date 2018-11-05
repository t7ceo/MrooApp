<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$su = 0; //count($gaip);

	//echo "kkkk".count($allds);

?>

<style>
table tr td span.radioSpan{
	width:13%;
	display:inline-block;
	margin:0 12px 0 0;
}


div div.formJ p span.pilsu, div div.formJ p span.pilsuno{
	width:12px;
	display:inline-block;
	color:red;
	font-size:0.8em;
}
div div.formJ p span.pilsuno{
	color:white;
}

</style>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:100%;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#">상담일지 등록</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 대상자 등록 -->
      
 
      

   <div id="join_mem" class="join_mem finder_div2" style="position:relative; width:755px; margin:25px auto 0; height:auto; border:none; display:block;">
    
    				<form id="frmSangdamOn" action="<?=$baseUrl?>hjang/onputSangdam" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "coid" value="<?=($md2 == 5)? $sss->coid : $this->session->userdata("coid");?>"> 
                    <input type="hidden" name= "listid" value="<?=($md2 == 5)? $sid : 0;?>">
                    <input type="hidden" name= "mode" value="<?=$md2?>">
                    
 
 
     
        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>사업/대상자 :</span></th><td>
                    <select id="sangdamSaup" name="sangdamSaup" onchange="meminf.chnSelect(this, 0)"><option value="0">사업선택</option> 
<?
	foreach($saup as $srow){
?>        
        <option value="<?=$srow->id?>" <? if($md2 == 5) echo ($sss->saup == $srow->id)? "selected='selected'" : "";?>><?=$srow->business_nm?></option>
        
<?
	}
?>
		</select>
        
  
  
  			<select id="sangdamDesang" name="sangdamDesang" onchange="meminf.chnSelect(this, 0)">
	<option value="0">대상자선택</option>            
<? if($md2 == 5){ //수정모드  
		foreach($allds as $dsrow){
?>
			<option value="<?=$dsrow->id?>" <?=($sss->desang == $dsrow->id)? "selected='selected'" : "";?>><?=$dsrow->dsname?></option>

<? 
		}
	}else{ ?>
<? 	} ?>            
 	<select>
    
        
        </td></tr>
        
        <tr><th><span class="pilsu">*</span><span>상담일자 :</span></th><td>
           <input type="text" id="sdonday" style="width:74%;" name="sdonday" value="<?=($md2 == 5)? $sss->onday : "";?>"/>
        </td></tr>
        
        <tr><th><span class="pilsuno">*</span><span>상담방법 :</span></th><td>
        <span class="radioSpan"><label for="moth1"><input type="radio" name="moth" id="moth1" value="1" <? if($md2 == 5) echo ($sss->moth == 1)? "checked" : ""; else echo ""; ?> /> 전화</label></span>
        <span class="radioSpan"><label for="moth2"><input type="radio" name="moth" id="moth2" value="2" <? if($md2 == 5) echo ($sss->moth == 2)? "checked" : "";?> /> 내방</label></span>
        <span class="radioSpan"><label for="moth3"><input type="radio" name="moth" id="moth3" value="3" <? if($md2 == 5) echo ($sss->moth == 3)? "checked" : "";?> /> 방문</label></span>
        <span class="radioSpan"><label for="moth4"><input type="radio" name="moth" id="moth4" value="4" <? if($md2 == 5) echo ($sss->moth == 4)? "checked" : "";?> /> 기타</label></span>
        <span class="radioSpan"><input type="text" name="mothetc" id="mothetc" value="<? if($md2 == 5) echo $sss->mothetc;?>" style="border:#dedede 1px solid;" /></span>
        </td></tr>

        <tr><th><span class="pilsu">*</span><span>제목 :</span></th><td>
           <input type="text" name="tit" id="tit" style="width:74%;" value="<?=($md2 == 5)? $sss->tit : "";?>" />
        </td></tr> 
        
        <tr><th colspan="2"><span>내용</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
    <textarea name="contentS" id="contentS" style="width:99%; margin:0; height:200px; display:none;"><? if($md2 == 5) echo $sss->content;?></textarea> 
         
        </td></tr>
        
       <tr><th colspan="2"><span>견해</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
    <textarea name="memo" id="memo" style="width:99%; margin:0; height:200px;"><? if($md2 == 5) echo $sss->memo;?></textarea>
         
        </td></tr>
        
        
        </table>
        
        
  
  
 
 
        

    <p style="text-align:center; padding:25px 0;">
    <a href="#" class="btn_org" onclick="sangdamOnPut()"><span><?=($md2 == 2)? "상담등록" : "상담수정";?></span></a>
    <a href="<?=$baseUrl?>hjang/getView/3" class="btn_gray"><span>목록</span></a>
    </p>

        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
 
 
				</form>
    

  </div>
  
  

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	$(document).ready(function($){
		
					
	
		if(<?=$md2?> == 5){
			//수정모드 

			meminf.memSeCoId = <?=$coid?>;
			
		}else{
			//추가 모드 
			meminf.selectDesang = 0;

		}
		

		//var aa = new GetServer();     //spdsList 에 사업리스트를 출력한다.
		//aa.getSaupList(meminf.selectSaup, aa, meminf);
		
		
		
		
	});



var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "contentS",
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


nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "memo",
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
	oEditors.getById["contentS"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["contentS"].getIR();
	//alert(sHTML);
}




function sangdamOnPut(){
	oEditors.getById["contentS"].exec("UPDATE_CONTENTS_FIELD", [0]);	// 에디터의 내용이 textarea에 적용됩니다.
	oEditors.getById["memo"].exec("UPDATE_CONTENTS_FIELD", [1]);	// 에디터의 내용이 textarea에 적용됩니다.



	var frm = document.getElementById("frmSangdamOn");
	
	var moth = frm.moth.value;

	
	
	if($('#sangdamSaup').val() == 0){
		appUtil.alertgo('알림', '사업을 선택하세요.');
		$('#sangdamSaup').focus();
		return false;
	}
	
/*	
	if($('#sangdamGongsa').val() == 0){
		appUtil.alertgo('알림', '공사를 선택하세요.');
		$('#sangdamGongsa').focus();
		return false;
	}
*/	
	
	if($('#sangdamDesang').val() == 0){
		appUtil.alertgo('알림', '대상자를 선택하세요.');
		$('#sangdamDesang').focus();
		return false;
	}
	

	if($('#sdonday').val() == ''){
		appUtil.alertgo('알림', '상담일자를 입력하세요.');
		$('#sdonday').focus();
		return false;
	}
	
	if(!moth){
		appUtil.alertgo("알림","상담방법을 선택하세요.");
		frm.moth.focus();
		return;
	}
	
	if(moth == 4 && frm.mothetc.value == ""){
		appUtil.alertgo("알림","상담방법 기타내용을 입력하세요.");
		frm.mothetc.focus();
		return;
	}



	if($('#tit').val() == ''){
		appUtil.alertgo('알림', '상담제목을 입력하세요.');
		$('#tit').focus();
		return false;
	}





	frm.submit();
}



</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

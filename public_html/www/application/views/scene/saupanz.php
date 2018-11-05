<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

/*
$ondisp = "none";
$mn[0] = "class='on'";
$mn[1] = "";
if($onmd == 2){
	$ondisp = "block";
	$mn[0] = "";
	$mn[1] = "class='on'";
}
*/
$su = 0; //count($gaip);
?>

<style>
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


		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="<?=$baseUrl?>hjang/getView/1/2">사업등록</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; width:755px; height:auto; border:none; display:block;">
    
    				<form name="frmSaup" id="frmSaup" action="<?=$baseUrl?>hjang/onputSaup" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "coid" value="<?=($mode == "edit")? $spss->coid : $this->session->userdata("coid")?>">
                    <input type="hidden" name= "mode" value="<?=$mode?>">
                    <input type="hidden" name= "md" value="<?=$md?>">
                    <input type="hidden" name= "md2" value="<?=$md2?>">
                    <input type="hidden" name= "listid" value="<?=($mode == "edit")? $spss->listid : 0?>">
                    
 

    <!--<div class="formJ" style="padding:0 0 20px;">-->
    
    
        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>사업명 :</span></th><td>
            <input type="text" id="business_nm" name="business_nm" value="<?=($mode == "edit")? $spss->business_nm : "";?>" style="width:74%;" placeholder="사업명" />
        </td></tr>
        <tr><th><span>일정 :</span></th><td>
            <input type="text" id="start_dt" name="start_dt" value="<?=($mode == "edit")? $spss->start_dt : "";?>" style="width:100px" readonly placeholder="시작일" /> ~ <input type="text" id="end_dt" name="end_dt" value="<?=($mode == "edit")? $spss->end_dt : "";?>" style="width:100px" readonly placeholder="종료일" />
        </td></tr>
        <tr><th colspan="2"><span>사업설명</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
         
    <textarea name="business_explane" id="business_explane" style="width:99%; margin:0; height:250px; display:none;"><?=($mode == "edit")? $spss->business_explane : "";?></textarea>
         
        </td></tr>
        
    
	<tr><td colspan="2" id="allAddFile" style="padding:0; border-bottom:#aaa 1px solid;">    

<?    
    	//첨부파일을 출력한다.
		if($mode == "edit") echo dispAllFile("hjang", $md, $md2, "#", $allfile, "edit");    
?>
    
    </td></tr>
   

        <tr><th><span>첨부파일1 :</span></th><td><input type="file" name="file1" /></td></tr>
        <tr><th><span>첨부파일2 :</span></th><td><input type="file" name="file2" /></td></tr>
        <tr><th><span>첨부파일3 :</span></th><td><input type="file" name="file3" /></td></tr>
        <tr><th><span>첨부파일4 :</span></th><td><input type="file" name="file4" /></td></tr>
        <tr><th><span>첨부파일5 :</span></th><td><input type="file" name="file5" /></td></tr>
        
        </table>
        

        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org" onclick="saupOnPut()"><span><?=($mode == "edit")? "사업수정" : "사업등록"?></span></a>
        <a href="<?=$baseUrl?>hjang/getView/1" class="btn_gray"><span>목록</span></a>
        </p>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
    
    
    <!--</div>-->


				</form>
    

  </div>
  

<script>


	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	$(document).ready(function($){

		//var dd = document.getElementById("start_dt");
		//dd.value = sdy+"-"+sdm+"-"+sdd;

		
		
	});



var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "business_explane",
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
	oEditors.getById["business_explane"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["business_explane"].getIR();
	//alert(sHTML);
}






function saupOnPut(){
	oEditors.getById["business_explane"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.


	if($('#business_nm').val() == ''){
		alert('사업명을 입력하세요.');
		$('#business_nm').focus();
		return false;
	}



	document.frmSaup.submit();
}





</script>    
      

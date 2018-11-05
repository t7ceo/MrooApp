<?php

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);


$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

$subTit = $seMenu['sub'][($md-1)]['title'];
$sub2Tit = $seMenu['sub'][($md-1)]['sub2'][$md2-1]['title'];


//echo $baseUrl;

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

if($md == 1){
	$ptit = "공지사항";
}else{
	$ptit = $sub2Tit;
}

?>


		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
			$oninf = ($ii == ($md3 - 1))? "class='on'" : "" ;
		?>
          <li <?=$oninf?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
				$ii++;
			} 
		?>          
        </ul>
      </div>


<form name="gongjiOn" id="gongjiOn" action="<?=$baseUrl?>community/ongongji" method="post" enctype="multipart/form-data">
<input type="hidden" name="ci_t" value="<?=$cihs?>" />
<input type="hidden" name="gubun" value="<?=$md?>" />
<input type="hidden" name="wrMemid" value="<?=$this->session->userdata('memid')?>" />
<input type="hidden" name="coid" value="<?=$this->session->userdata('coid')?>" />
<input type="hidden" name="md" value="<?=$md?>" />
<input type="hidden" name="md2" value="<?=$md2?>" />
<input type="hidden" name="md3" value="<?=$md3?>" />
<input type="hidden" name="type" value="insert">



        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>제목 :</span></th><td>
            <input type="text" name="tit" style="width:88%; padding:4px 0; margin:2px 10px 2px 0; border:#ccc 1px solid;" value="" />
        </td></tr>
        
        <? if($md == 1){ ?>
        
        <tr><th><span class="pilsuno">*</span><span>공지 :</span></th><td>
            <input type="checkbox" name="gongji" value="Y" <?=(keyMan("admin", 0))? "" : "disabled"?>> 공지설정
        </td></tr>
        
        <? }else{ ?>
        	
            <input type="hidden" name="gongji" value="N" />
        
        <? } ?>
        
    
        <tr><th colspan="2"><span>내용</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
         
    <textarea name="content" id="content" style="width:99%; margin:0; height:250px;"></textarea>
    
    </td></tr>
    
        <tr><th><span>첨부파일1 :</span></th><td><input type="file" name="file1" /></td></tr>
        <tr><th><span>첨부파일2 :</span></th><td><input type="file" name="file2" /></td></tr>
        <tr><th><span>첨부파일3 :</span></th><td><input type="file" name="file3" /></td></tr>
        <tr><th><span>첨부파일4 :</span></th><td><input type="file" name="file4" /></td></tr>
        <tr><th><span>첨부파일5 :</span></th><td><input type="file" name="file5" /></td></tr>

    
    
    </table>
    
         
         

	
	<!--textarea name="ir1" id="ir1" rows="10" cols="100" style="width:100%; height:412px; min-width:610px; display:none;"></textarea-->
	<p style="padding:12px 3%; width:96%; text-align:center;">
		<!--<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />-->
		<!--<input type="button" onclick="showHTML();" value="본문 내용 가져오기" />-->
        <a href="#" class="btn_org" onclick="submitContents(this);"><span>등록</span></a>
        <a href="<?=$baseUrl?>community/getView/<?=$md?>/<?=$md2?>/1" class="btn_gray"><span>목록</span></a>
		<!--<input type="button" onclick="setDefaultFont();" value="기본 폰트 지정하기 (궁서_24)" />-->
	</p>
</form>

<script type="text/javascript">
var oEditors = [];


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
		//alert("kkk");
		
	},
	fCreator: "createSEditor2"
});

/*
function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
	oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["content"].getIR();
	//alert(sHTML);
}
*/

function submitContents(elClickedObj) {
	oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	
	//alert(document.getElementById("ir1").value);
	var frm = document.getElementById("gongjiOn");
	if(!frm.tit.value){
		appUtil.alertgo("알림","제목을 입력하세요.");
		frm.tit.focus();
		return;
	}
	if(!document.getElementById("content").value){
		appUtil.alertgo("알림","내용을 입력하세요.");
		return;
	}
	
	
	try {
		frm.submit();
		//elClickedObj.form.submit();
	} catch(e) {
		//alert("errrr"+e);
	}
}

/*
function setDefaultFont() {
	var sDefaultFont = '궁서';
	var nFontSize = 24;
	oEditors.getById["ir1"].setDefaultFont(sDefaultFont, nFontSize);
}
*/
</script>


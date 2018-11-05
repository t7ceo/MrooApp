<?php
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseOrg = $baseUrl;
$baseUrl .= "community/";

//echo $baseOrg."//".$baseUrl;

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


foreach($bdinf as $bdinfrow){
	$ptit = $bdinfrow->bdtit;
	$bdgo = false;
	if($bdinfrow->cogubunW == 0) $bdgo = true;
	else if($bdinfrow->cogubunW >= $this->session->userdata("potion")) $bdgo = true;
}


?>


		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$ptit?></a></li>
        </ul>
      </div>

<? foreach($bd as $rows){ ?>   

<form name="borderOn" id="borderOn" action="<?=$baseUrl?>community/onborder" method="post" enctype="multipart/form-data">
<input type="hidden" name="ci_t" value="<?=$cihs?>" />
<input type="hidden" name="gubun" value="<?=$md?>" />
<input type="hidden" name="wrMemid" value="<?=$this->session->userdata('memid')?>" />
<input type="hidden" name="coid" value="<?=$this->session->userdata('coid')?>" />
<input type="hidden" name="md" value="<?=$md?>" />
<input type="hidden" name="md2" value="<?=$md2?>" />
<input type="hidden" name="md3" value="<?=$md3?>" />
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="type" value="modify">
<input type="hidden" id = "mkbd" name="mkbd" value="<?=$rows->bdid?>">




        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>제목 :</span></th><td>
            <input type="text" name="tit" style="width:50%; padding:7px 0; margin:2px 10px 2px 0; border:#ccc 1px solid;" value="<?=$rows->tit?>" />
        </td></tr>
        <tr><th><span class="pilsuno">*</span><span>공지 :</span></th><td>
            <input type="checkbox" name="gongji" value="Y" <?if($rows->gongji == 'Y'){?>checked<?}?> <?=(keyMan("admin", 0))? "" : "disabled"?>> 공지설정
        </td></tr>




        
        <tr><th colspan="2"><span>내용</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
         
    <textarea name="ir1" id="ir1" rows="10" cols="100" style="width:99%; margin:0; height:250px;"><?=$rows->content?></textarea>
    
    </td></tr>
    
	<tr><td colspan="2" id="allAddFile" style="padding:0; border-bottom:#aaa 1px solid;">
    
	<?    
            
			//echo $md."/".$md2."/".$md3."/".count($allfile);
			
			//첨부파일을 출력한다.
            if($md3 > 0) echo dispAllFile("community", $md, $md3, "#", $allfile, "edit");    
    ?>
    

    
    </td></tr>
    
        <tr><th><span>첨부파일1 :</span></th><td><input type="file" name="file1" /></td></tr>
        <tr><th><span>첨부파일2 :</span></th><td><input type="file" name="file2" /></td></tr>
        <tr><th><span>첨부파일3 :</span></th><td><input type="file" name="file3" /></td></tr>
        <tr><th><span>첨부파일4 :</span></th><td><input type="file" name="file4" /></td></tr>
        <tr><th><span>첨부파일5 :</span></th><td><input type="file" name="file5" /></td></tr>

    
    </table>
    


	<!--textarea name="ir1" id="ir1" rows="10" cols="100" style="width:100%; height:412px; min-width:610px; display:none;"></textarea-->
	<p style="padding:12px 3%; width:96%; text-align:right;">
		<!--<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />-->
		<!--<input type="button" onclick="showHTML();" value="본문 내용 가져오기" />-->
<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("wrman", $rows->wrMemid)) or keyMan("wrman", $rows->wrMemid)){ ?>   
        <a href="#" class="btn_gray" onclick="submitContents(this);"><span>수정</span></a>
<? } ?>        
        
        <a href="<?=$baseUrl?>community/getView/<?=$md?>/1/0/<?=$md4?>" class="btn_gray"><span>목록</span></a>
		<!--<input type="button" onclick="setDefaultFont();" value="기본 폰트 지정하기 (궁서_24)" />-->
	</p>
</form>
<?}?>

<script type="text/javascript">
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "ir1",
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
	var sHTML = oEditors.getById["ir1"].getIR();
	//alert(sHTML);
}
	
function submitContents(elClickedObj) {
	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	
	//alert(document.getElementById("ir1").value);
	var frm = document.getElementById("borderOn");
	if(!frm.tit.value){
		appUtil.alertgo("알림","제목을 입력하세요.");
		frm.tit.focus();
		return;
	}
	if(!document.getElementById("ir1").value){
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

function setDefaultFont() {
	var sDefaultFont = '궁서';
	var nFontSize = 24;
	oEditors.getById["ir1"].setDefaultFont(sDefaultFont, nFontSize);
}
</script>


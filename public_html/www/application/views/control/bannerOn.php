<?php

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);


$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "control/";

$subTit = $seMenu['sub'][($md-1)]['title'];
$sub2Tit = $seMenu['sub'][($md-1)]['sub2'][$md3-1]['title'];

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$ptit = $sub2Tit;


?>

<style>
table.onputPage td{
	width:20%;
}
table.onputPage td span{

}
</style>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
         <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
				if($ii > 1) break;
			$oninf = ($ii == ($md3 - 1))? "class='on'" : "" ;
		?>
          <li <?=$oninf?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
				$ii++;
			} 
		?>          
        </ul>
      </div>


<form name="bannerOn" id="bannerOn" action="<?=$baseUrl?>control/bannerOn" method="post" enctype="multipart/form-data">
<input type="hidden" name="ci_t" value="<?=$cihs?>" />
<input type="hidden" name="md" value="<?=$md?>" />
<input type="hidden" name="md2" value="<?=$md2?>" />
<input type="hidden" name="md3" value="<?=$md3?>" />
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="id" value="<?=$id?>">


        <table class="onputPage">
        <tr><th><span class="pilsu">*</span><span>구분 :</span></th><td>
        	<select name="gubun">
            <option value="main">Main</option>
            <option value="sub">Sub</option>
            </select>
        </td>
        <th><span class="pilsu"></span><span>구분항목 추가 :</span></th><td>
        	<input type="text" name="gubunadd" value="" />
        </td><td>    
            <a href="#" class="btn_gray" onclick=""><span>등록</span></a>
        </td>
        </tr>

		<tr><th><span class="pilsu">*</span><span>노출시작 :</span></th><td colspan="4">
            <input type="date" name="stday" value="" />
        </td></tr>
  
 		<tr><th><span class="pilsu">*</span><span>노출종료 :</span></th><td colspan="4">
            <input type="date" name="endday" value="" />
        </td></tr>
        
 		<tr><th><span class="pilsu">*</span><span>노출인덱스 :</span></th><td colspan="4">
            <input type="number" name="indx" value="1" />
        </td></tr>

 		<tr><th><span class="pilsu">*</span><span>노출여부 :</span></th><td colspan="4">
        	<select name="oninf">
            <option value="1">배너 즉시노출</option>
            <option value="0">배너 숨기기</option>
            </select>
        </td></tr>
                
        
        <tr><th><span class="pilsu">*</span><span>배너이미지 :</span></th><td colspan="4"><input type="file" name="file1" /></td></tr>
    
    	<tr class="oldBanner"><th><span>기존배너 :</span></th><td colspan="4">없음</td></tr>
    </table>
    
  
	
	<!--textarea name="ir1" id="ir1" rows="10" cols="100" style="width:100%; height:412px; min-width:610px; display:none;"></textarea-->
	<p style="padding:12px 3%; width:96%; text-align:center;">
		<!--<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />-->
		<!--<input type="button" onclick="showHTML();" value="본문 내용 가져오기" />-->
        <a href="#" class="btn_org" onclick="submitContents(this);"><span><?=($type == "insert") ? "등록": "수정"; ?></span></a>
        <a href="<?=$baseUrl?>control/getView/<?=$md?>/<?=$md2?>/1" class="btn_gray"><span>목록</span></a>
		<!--<input type="button" onclick="setDefaultFont();" value="기본 폰트 지정하기 (궁서_24)" />-->
	</p>
</form>

<script type="text/javascript">
	var dbgab = Array();
	<?
	//====================================
	//php 배열을 자바스크립트 배열로 반환한다.
	//====================================
	$imsi = json_encode($bd);   //json 으로 만든다.
	$bdg = json_decode($imsi, true);   //배열로 만든다.
	$bdkey = array_keys($bdg);
	if($type != "insert"){
		for($c = 0; $c < count($bdkey); $c++){
	?>
		dbgab['<?=$bdkey[$c]?>'] = "<?=$bdg[$bdkey[$c]]?>";
	<?
		}
	}
	//====================================
	?>
	
	
	var frm = document.getElementById("bannerOn");
	$(document).ready(function(e) {
	
		if(frm.type.value != "insert"){
			//저장된 값을 입력필드에 뿌려준다.
			formPro.setFormEditVal(frm, dbgab);
		}
	
	});


	function submitContents(elClickedObj) {
		//oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
		
		// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
		
		//alert(document.getElementById("ir1").value);
		var frm = document.getElementById("bannerOn");
	
		
		try {
			frm.submit();
			//elClickedObj.form.submit();
		} catch(e) {
			//alert("errrr"+e);
		}
	}

</script>


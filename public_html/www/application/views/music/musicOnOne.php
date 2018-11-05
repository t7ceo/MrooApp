<?php

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

$subTit = $seMenu['sub'][($md-1)]['title'];
$sub2Tit = $seMenu['sub'][($md-1)]['sub2'][$md3-1]['title'];

$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "music/";



$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$ptit = $sub2Tit;


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


<form name="musicOn" id="musicOn" action="<?=$baseUrl?>musicon/musicfileOn" method="post" enctype="multipart/form-data">
<input type="hidden" name="ci_t" value="<?=$cihs?>" />
<input type="hidden" name="md" value="<?=$md?>" />
<input type="hidden" name="md2" value="<?=$md2?>" />
<input type="hidden" name="md3" value="<?=$md3?>" />
<input type="hidden" name="type" value="insert">



        <table id="musicOnOneTb" class="onputPage">
        <tr><th><span class="pilsu">*</span><span>곡명 :</span></th><td>
            <input type="text" name="tit" style="width:88%; padding:4px 0; margin:2px 10px 2px 0; border:#ccc 1px solid;" value="" />
        </td></tr>
        <tr><th><span class="pilsu">*</span><span>아티스트 :</span></th><td>
        	<select name="gasu">
            <!-----전체 가수의 이름을 가나다 순으로 가져온다.-------->
            <?=getAllGasu()?>
            </select>
        	
            <input type="text" name="gasuadd" value="" />
            <a href="#" class="btn_gray gasuName" style="vertical-align:middle;"><span>검색 or 추가</span></a>
            
        </td></tr>
		<tr><th><span class="pilsu">*</span><span>가사파일 (.txt) :</span></th><td><input type="file" name="gasa" /></td></tr>
        <!--<tr><th><span class="pilsu">*</span><span>대표사진 (jpg, png) :</span></th><td><input type="file" name="albumimg" /></td></tr>-->
        
        <tr><th><span class="pilsu">*</span><span>키선택 :</span></th><td>
        	<input type="radio" name="mkey" value="1se" class="mkeySet" checked="checked" /> 원키&nbsp;&nbsp;&nbsp;
            <input type="radio" name="mkey" value="2se" class="mkeySet" /> 2세대&nbsp;&nbsp;&nbsp;
            <input type="radio" name="mkey" value="3se" class="mkeySet" /> 3세대&nbsp;&nbsp;&nbsp;
            <input type="radio" name="mkey" value="4seM" class="mkeySet" /> 4세대(남)&nbsp;&nbsp;&nbsp;
        	<input type="radio" name="mkey" value="4seF" class="mkeySet" /> 4세대(여)
        </td></tr>
        <tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>
    </table>
    
         
         

	
	<!--textarea name="ir1" id="ir1" rows="10" cols="100" style="width:100%; height:412px; min-width:610px; display:none;"></textarea-->
	<p style="padding:12px 3%; width:96%; text-align:center;">
		<!--<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />-->
		<!--<input type="button" onclick="showHTML();" value="본문 내용 가져오기" />-->
        <a href="#" class="btn_org" onclick="submitContents(this);"><span>등록</span></a>
        <a href="<?=$baseUrl?>musicon/getView/<?=$md?>/<?=$md2?>/1" class="btn_gray"><span>목록</span></a>
		<!--<input type="button" onclick="setDefaultFont();" value="기본 폰트 지정하기 (궁서_24)" />-->
	</p>
</form>

<script type="text/javascript">

	
function submitContents(elClickedObj) {
	
	var frm = document.getElementById("musicOn");
	
	if(!frm.tit.value){
		alert("곡명을 입력하세요.");
		return false;
	}

	if(!frm.gasu.value){
		alert("아티스트를 입력하세요.");
		return false;
	}

	if(!frm.gasa.value){
		alert("가사파일을 선택하세요.");
		return false;
	}
	

	var gasaf = frm.gasa.value;
	if(gasaf.substr(-4) != ".txt"){
		alert("가사는 .txt 파일을 올려야 합니다.");
		return;
	}
	/*
	if(!frm.albumimg.value){
		alert("앨범 이미지 파일을 선택하세요.");
		return false;
	}
	gasaf = frm.albumimg.value;
	if((gasaf.substr(-4) != ".png") && (gasaf.substr(-4) != ".jpg")){
		alert("엘범 이미지는 .png 또는 .jpg 파일을 올려야 합니다.");
		return;
	}
	*/
	
	
	switch(frm.mkey.value){
	case "1se":
		if(!frm.orgkey.value){
			alert("원키 음원파일을 선택하세요.");
			return false;
		}
		
		if(frm.orgkey.value.substr(-3) != "mp3"){
			alert("음원은 mp3 파일을 올려 주세요.");
			return false;
		}
	
		
	break;
	case "2se":
		if(!frm.orgkey.value){
			alert("원키 음원파일을 선택하세요.");
			return false;
		}else if(!frm.inmelody.value){
			alert("멜로디 포함 음원파일을 선택하세요.");
			return false;		
		}
		
		if(frm.orgkey.value.substr(-3) != "mp3" || frm.inmelody.value.substr(-3) != "mp3"){
			alert("음원은 mp3 파일을 올려 주세요.");
			return false;
		}
		
	break;
	case "3se":
		if(!frm.orgkey.value){
			alert("원키 음원파일을 선택하세요.");
			return false;
		}else if(!frm.shap1.value){
			alert("#1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.shap2.value){
			alert("#2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.shap3.value){
			alert("#3 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb1.value){
			alert("b1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb2.value){
			alert("b2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb3.value){
			alert("b3 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.inmelody.value){
			alert("멜로디 포함 음원파일을 선택하세요.");
			return false;		
		}
		
		if(frm.orgkey.value.substr(-3) != "mp3" || frm.inmelody.value.substr(-3) != "mp3" || frm.shap1.value.substr(-3) != "mp3" || frm.shap2.value.substr(-3) != "mp3" || frm.shap3.value.substr(-3) != "mp3" || frm.bb1.value.substr(-3) != "mp3" || frm.bb2.value.substr(-3) != "mp3" || frm.bb3.value.substr(-3) != "mp3"){
			alert("음원은 mp3 파일을 올려 주세요.");
			return false;
		}
		
	break;
	case "4seM":
		if(!frm.orgkey.value){
			alert("원키 음원파일을 선택하세요.");
			return false;
		}else if(!frm.shap1.value){
			alert("#1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb1.value){
			alert("b1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb2.value){
			alert("b2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.wmkey.value){
			alert("여자키 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.wshap1.value){
			alert("여자키 #1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.wbb1.value){
			alert("여자키 b1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.wbb2.value){
			alert("여자키 b2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.inmelody.value){
			alert("멜로디 포함 음원파일을 선택하세요.");
			return false;		
		}
		
		if(frm.orgkey.value.substr(-3) != "mp3" || frm.inmelody.value.substr(-3) != "mp3" || frm.shap1.value.substr(-3) != "mp3" || frm.bb1.value.substr(-3) != "mp3" || frm.bb2.value.substr(-3) != "mp3" || frm.wmkey.value.substr(-3) != "mp3" || frm.wshap1.value.substr(-3) != "mp3" || frm.wbb1.value.substr(-3) != "mp3" || frm.wbb2.value.substr(-3) != "mp3"){
			alert("음원은 mp3 파일을 올려 주세요.");
			return false;
		}
		
	break;
	case "4seF":
		if(!frm.orgkey.value){
			alert("원키 음원파일을 선택하세요.");
			return false;
		}else if(!frm.shap1.value){
			alert("#1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb1.value){
			alert("b1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.bb2.value){
			alert("b2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.mnkey.value){
			alert("남자키 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.mnshap1.value){
			alert("남자키 #1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.mnbb1.value){
			alert("남자키 b1 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.mnbb2.value){
			alert("남자키 b2 음원파일을 선택하세요.");
			return false;		
		}else if(!frm.inmelody.value){
			alert("멜로디 포함 음원파일을 선택하세요.");
			return false;		
		}
		
		if(frm.orgkey.value.substr(-3) != "mp3" || frm.inmelody.value.substr(-3) != "mp3" || frm.shap1.value.substr(-3) != "mp3" || frm.bb1.value.substr(-3) != "mp3" || frm.bb2.value.substr(-3) != "mp3" || frm.mnkey.value.substr(-3) != "mp3" || frm.mnshap1.value.substr(-3) != "mp3" || frm.mnbb1.value.substr(-3) != "mp3" || frm.mnbb2.value.substr(-3) != "mp3"){
			alert("음원은 mp3 파일을 올려 주세요.");
			return false;
		}
		
	break;
	}
	
	//alert(frm.mkey.value);
	//alert(frm.orgkey.value);
	
	try {
		frm.submit();
	} catch(e) {
		//alert("errrr"+e);
	}
}


</script>


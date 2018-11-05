<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);
?>

<style>

table.desnagOnTb{
	width:90%;
	margin:10px 5%;
	border:#cdcdcd 2px solid;
}
table.desnagOnTb td{
	width:35%;
	padding:9px 8px;
	text-align:left;
	border:#dedede 0.5px solid;
}
table.desnagOnTb td.tit{
	width:15%;
}
table.desnagOnTb td span{
	width:15%;
	margin:0 12px 0 0;
}

.map{
	width:100%;
	height:300px;
}

ul#seSaup{
	width:100%;
	display:block;
	margin:0;
	padding:0;
}
ul#seSaup li{
	width:48%;
	display:inline-block;
	margin:0;
	padding:0;
}


</style>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="<?=$baseUrl?>hjang/getView/2/2">대상자 등록</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 대상자 등록 -->
      

   <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; width:98%; margin:0 1%; height:auto; border:none; display:block;">
    
    				<form id="frmDsang" action="<?=$baseUrl?>hjang/onputDesang" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "lat" value="">
                    <input type="hidden" name= "lan" value="">
                    <input type="hidden" name= "dsaup" id = "dsaup" value="">
                    <input type="hidden" name= "listid" value="<?=($mode == "edit")? $dsid : 0 ?>">
                    <input type="hidden" name= "mode" value="<?=$mode?>">
                    <input type="hidden" name= "coid" value="<?=($mode == "edit")? $dsss->coid : $this->session->userdata('coid') ?>">
 

    
    <table class="desnagOnTb">
    
    <tr><td class="tit">사업선택 : </td><td colspan="3">
    	<ul id="seSaup">
        
<? 
if($mode == "edit"){
	$ssr = explode("-", $sinfo);
}
foreach($saup as $srow){ 
	$rrr = false;
	if($mode == "edit") $rrr = in_array($srow->id, $ssr);
?>
	
		<li><label for = "saupchk<?=$srow->id?>"><input type="checkbox" name="saupchk" value="<?=$srow->id?>" id="saupchk<?=$srow->id?>" <?=($mode == "edit" && $rrr)? "checked = 'checked'": ""?> /> <?=$srow->business_nm?></label></li>

<? } ?>        
        
        </ul>
    </td></tr>
    
    
    <tr><td class="tit">세대주명 : (*)</td><td><input type="text" name="sedeju" value="<?=($mode == "edit")? $dsss->dsname : "" ?>" /></td>
    <td class="tit">생년월일 : </td><td><input type="number" name="bthday" id="bthday1" maxlength="6" value="<?=($mode == "edit")? $dsss->bday : "" ?>" placeholder="앞6자리" /></td></tr>
    <tr><td class="tit">전화번호 : </td><td><input type="tel" name="tel" id="dstel" maxlength="11" value="<?=($mode == "edit")? $dsss->tel : "" ?>" placeholder="'-'빼고 입력" /></td>
    <td class="tit">핸드폰 : (*)</td><td><input type="tel" name="htel" id="dshtel" maxlength="11" value="<?=($mode == "edit")? $dsss->htel : "" ?>" placeholder="'-'빼고 입력" /></td></tr>
    

    
    
    <tr><td class="tit">우편번호 : (*)</td><td><input type="text" id="copost" name="copost" value="<?=($mode == "edit")? $dsss->post : "" ?>" placeholder="우편번호" style="width:60%" />
        <a type="button" name="" style="width:35%;" class="button2" onclick="openpost()">우편번호</a></td>
        
	<td colspan="2"></td>
    </tr>
    <tr><td class="tit">주소 : (*)</td><td colspan="3"><input type="text" id="coaddress" name="coaddress" value="<?=($mode == "edit")? $dsss->addr : "" ?>" style="width:100%;" /></td></tr>
    <tr><td class="tit">상세주소 : </td><td colspan="3"><input type="text" id="coaddress2" name="coaddress2" value="<?=($mode == "edit")? $dsss->addr2 : "" ?>" style="width:56%; margin:0 10px 0 0;" /><a type="button" name="" style="width:18%;" class="button2" onclick="appUtil.getMap()">약도보기</a></td></tr>
    <tr><td class="tit">약도 : </td><td colspan="3">
    	<div class="map" id="desangMap"></div>
    
    </td></tr>
    <tr><td class="tit">수급여부 : </td><td colspan="3">
    	<?
			$aa = array("","","","", "");
			if($mode == "edit") $aa[$dsss->sugub] = "checked";
			else $aa[0] = "checked";
		?>
    
    	<span><label for="sugub0"><input type="radio" name="sugub" id="sugub0" value="0" <?=$aa[0]?> /> 미상</label></span>
    	<span><label for="sugub1"><input type="radio" name="sugub" id="sugub1" value="1" <?=$aa[1]?> /> 일반수급</label></span>
        <span><label for="sugub2"><input type="radio" name="sugub" id="sugub2" value="2" <?=$aa[2]?> /> 조건부수급</label></span>
        <span><label for="sugub3"><input type="radio" name="sugub" id="sugub3" value="3" <?=$aa[3]?> /> 인증차상위</label></span>
        <span><label for="sugub4"><input type="radio" name="sugub" id="sugub4" value="4" <?=$aa[4]?> /> 일반저소득</label></span>
    </td></tr>
    <tr><td class="tit">의료보장 : </td><td colspan="3">
    
        <?
			$aa = array("","","","", "", "");
			if($mode == "edit") $aa[$dsss->bojang] = "checked";
			else $aa[0] = "checked";
		?>
    
    	<span><label for="bojang0"><input type="radio" name="bojang" id="bojang0" value="0" <?=$aa[0]?> /> 미상</label></span>
    	<span><label for="bojang1"><input type="radio" name="bojang" id="bojang1" value="1" <?=$aa[1]?> /> 의료보호1종</label></span>
        <span><label for="bojang2"><input type="radio" name="bojang" id="bojang2" value="2" <?=$aa[2]?> /> 의료보호2종</label></span>
        <span><label for="bojang3"><input type="radio" name="bojang" id="bojang3" value="3" <?=$aa[3]?> /> 직장의료보험</label></span>
        <span><label for="bojang4"><input type="radio" name="bojang" id="bojang4" value="4" <?=$aa[4]?> /> 지역의료보험</label></span>
        <span><label for="bojang5"><input type="radio" name="bojang" id="bojang5" value="5" <?=$aa[5]?> /> 기타</label></span>
        <span><input type="text" name="etc" id="etc" value="<?=($mode == "edit")? $dsss->bojangetc : "" ?>" style="border:#dedede 1px solid;" /></span>
    
    </td></tr>
    <tr><td class="tit">가구원수 : </td><td colspan="3">
    	<span><input type="text" name="gagusu" id="gagusu" value="<?=($mode == "edit")? $dsss->gagusu : "1" ?>" style="border:#dedede 1px solid;" /> 명 (세대주포함)</span>
    
    </td></tr>
    <tr><td class="tit">가구권 특기사항 : </td><td colspan="3">
    
       <?
			$aa = array("","","","", "", "");
			if($mode == "edit") $aa[$dsss->gaguinf] = "checked";
			else $aa[0] = "checked";
		?>
    
    	<span><label for="gagu0"><input type="radio" name="gagu" id="gagu0" value="0" <?=$aa[0]?> /> 미상</label></span>
        <span><label for="gagu1"><input type="radio" name="gagu" id="gagu1" value="1" <?=$aa[1]?> /> 노인부부</label></span>
        <span><label for="gagu2"><input type="radio" name="gagu" id="gagu2" value="2" <?=$aa[2]?> /> 독거노인</label></span>
        <span><label for="gagu3"><input type="radio" name="gagu" id="gagu3" value="3" <?=$aa[3]?> /> 조손가정</label></span>
        <span><label for="gagu4"><input type="radio" name="gagu" id="gagu4" value="4" <?=$aa[4]?> /> 장애인가구</label></span>
        <span><label for="gagu5"><input type="radio" name="gagu" id="gagu5" value="5" <?=$aa[5]?> /> 기타</label></span>
        <span><input type="text" name="gaguetc" id="gaguetc" value="<?=($mode == "edit")? $dsss->gagumemo : "" ?>" style="border:#dedede 1px solid;" /></span>
    </td></tr>
    </table>
    
    
 
        
        <p style="text-align:center; padding:25px 0;">
        
        <a href="#" class="btn_org" onclick="meminf.desangOn()"><span><?=($mode == "edit")? "수정" : "등록" ?></span></a>
        <a href="<?=$baseUrl?>hjang/getView/2/1/0/0/<?=$this->session->userdata("backFind")?>" class="btn_gray"><span>목록</span></a>
        </p>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>

 
				</form>
    

  </div>
  
  
  




<script>


<? if($mode == "edit"){  ?>

	imsiLat = <?=$dsss->latpo?>;
	imsiLang = <?=$dsss->langpo?>;
	
	//alert(imsiLat+"/////"+imsiLang+"||||");
	
<? } ?>



	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      


    
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

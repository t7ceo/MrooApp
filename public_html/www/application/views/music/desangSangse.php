<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";


$this->session->set_userdata("backFind", $this->session->userdata("findMd")."--".$this->session->userdata("find"));
  
?>

		<div id="gaipSangseMess" class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">대상자 상세보기</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->    
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>자료실</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">대상자이름</td><td class="alLeft"><?=$ssinfo->dsname?></td></tr>
      <tr><td class="titcell">소속업체</td><td class="alLeft"><?=$ssinfo->conam?></td></tr>
      <tr><td class="titcell">생년월일</td><td class="alLeft"><?=anzBday($ssinfo->bday)?></td></tr>
      <tr><td class="titcell">전화번호</td><td class="alLeft"><?=anzTel($ssinfo->tel)?></td></tr>
      <tr><td class="titcell">휴대폰</td><td class="alLeft"><?=anzTel($ssinfo->htel)?></td></tr>
      <tr><td class="titcell">수급여부</td><td class="alLeft"><?=dispSugub($ssinfo->sugub)?></td></tr>
      <tr><td class="titcell">의료보장</td><td class="alLeft"><?=dispBojang($ssinfo->bojang)." (".$ssinfo->bojangetc.")"?></td></tr>
      <tr><td class="titcell">가구수</td><td class="alLeft"><?=$ssinfo->gagusu?></td></tr>
      <tr><td class="titcell">가구특기사항</td><td class="alLeft"><?=dispGagu($ssinfo->gaguinf, $ssinfo->gagumemo)?></td></tr>
      <tr><td class="titcell">주소</td><td class="alLeft"><?="( ".$ssinfo->post." ) ".$ssinfo->addr." ".$ssinfo->addr2?></td></tr>
      <tr><td class="titcell">등록일자</td><td class="alLeft"><?=$ssinfo->onday?></td></tr>
      <tr><td class="titcell">등록자</td><td class="alLeft"><?=$ssinfo->wrmemid?></td></tr>
      <tr><td class="titcell">약도</td><td><div style="width:100%; height:300px;" id="dsmap"></div></td></tr>
      </tbody>
      </table>

  </div>
  
<? if($md == 1){  //사업관리에서 호출 ?>
	<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/<?=$md?>/<?=$md2?>/<?=$coid?>/<?=$ds?>/<?=$saup?>" class="btn_gray"><span>목록</span></a></div>
<? }else{ 


  	if($md == 1) $md2 = 3;
	else if($md2 == 4) $md2 = 1;
	else if($md2 == 44) $md2 = 6;


?>

 		<div style="width:755px; text-align:right;">
        
<? if(keyMan("wrman", $ssinfo->wrmemid) or keyMan("admin","po")){   ?>        
        <a href="#" onclick="appBasInfo.delDesang(<?=$md?>,<?=$md2?>,<?=$this->session->userdata('coid')?>, <?=$ssinfo->id?>)" class="btn_gray"><span>삭제</span></a>
        <a href="<?=$baseUrl?>hjang/getView/2/2/<?=$this->session->userdata('coid')?>/<?=$ds?>" class="btn_gray"><span>수정</span></a>
<? }  ?>        
        
        <a href="<?=$baseUrl?>hjang/getView/<?=$md?>/<?=$md2?>/<?=$coid?>/0/<?=$this->session->userdata("backFind")?>" class="btn_gray"><span>목록</span></a>
        </div>    
    
<? } ?>



<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	imsiLat = <?=$ssinfo->latpo?>;
	imsiLang = <?=$ssinfo->langpo?>;



</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

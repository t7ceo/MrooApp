<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

if($md == 1){
	$bdtit = "공지사항";
	$recid = $md4;
	$pam1 = $md;
	$pam2 = 1; //$md2;
	$pam3 = 1; //$md3;
	$pam4 = $md4;
}else if($md == 2){
	$subTit = $seMenu['sub'][($md-1)]['title'];
	$sub2Tit = $seMenu['sub'][($md-1)]['sub2'][$md2-1]['title'];
	$bdtit = $sub2Tit;
	$recid = $md4;
	$pam1 = $md;
	$pam2 = $md2;
	$pam3 = 1;
	$pam4 = 0;
}else if($md == 3){
	$bdtit = "질문관리";
	$recid = $md4;
	$pam1 = $md;
	$pam2 = 1; //$md2;
	$pam3 = 1; //$md3;
	$pam4 = $md4;
}



foreach($sebd as $row){
	
	
?>

<style>
#viewTxtImg3 img, #viewTxtImg4 img {max-width:90%; margin:0;}
#viewTxtImg3, #viewTxtImg4 {width:747px; margin:0; padding:0;}
</style>


		<div id="gaipSangseMess" class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$bdtit?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->
      
    <div id="join_mem" class="join_mem finder_divS" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0; width:500px;">
      <caption>회원상세보기</caption>
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
      
      <tr>
		<td class="titcell">제목</td>
		<td style="text-align:left;padding-left:5px;"><?=$row->tit?></td>
	  </tr>

	  <tr>
		<td class="titcell">작성자</td>
		<td style="text-align:left;padding-left:5px;"><?=$row->wrMemid?></td>
	  </tr>
      <tr>
		<td class="titcell">작성일자</td>
		<td style="text-align:left;padding-left:5px;"><?=$row->onday?></td>
	  </tr>
      <tr>
		<td class="titcell" colspan="2">내용</td>
	  </tr>
      <tr>
		<td style="text-align:left;padding-left:5px; border-bottom:#ccc 2px solid;" colspan="2"><div id="viewTxtImg3"><?=$row->content?></div></td>
	  </tr>


	<tr><td colspan="2" style="padding:0; border-top:#ccc 2px solid; border-bottom:#ccc 2px solid;">
    
    <?
    	//첨부파일을 출력한다.
		$aa = $md3;
		echo dispAllFile("community", $md, $md3, $baseUrl, $allfile, "view");
		
	?>
    
 
    
    </td></tr>




      <tr><td colspan="2" style="border-bottom:#ccc 1px solid;">
      
          <div class="comment">
            <div class="title"></div>
            <div class="commt_box">
            
				<textarea id="detTxt" style="width:70%;"></textarea>             

              	<a href="#" onclick="appBasInfo.onputDet(<?=$row->id?>, <?=$md?>, <?=$md2?>)"><span>등록</span></a>
            </div>
            <div class="commt_list">
            
<? foreach($det as $rowdet){ 
	$cc = " [ ".$rowdet->coname." ] ";
	if($rowdet->coname == "본사") $cc = "";
?>
            
            
              <div class="view" style="text-align:left;">
                <p class="info"><span><?=$rowdet->wmemid." [ ".$rowdet->name." ]".$cc?></span><?=$rowdet->onday?>
                
<?
	if(keyMan("txtdel", array("wr"=>$rowdet->wmemid, "md"=>$md))){
?>
                <a href="#" onclick="appBasInfo.delDet(<?=$rowdet->id?>, <?=$md?>, <?=$md2?>, <?=$row->id?>)"><img src="<?=PREDIR?>images/common/btn_commt_del.gif" alt="삭제"></a>
                
<? } ?>                     
                </p>
                <p class="text"><?=$rowdet->det?></p>
    
              </div>

<? } ?>

            </div>
          </div>
      
      
      
      </td></tr>

      </tbody>
      </table>

  </div>
  
<? } ?>  
  
  

 		<div style="width:755px; text-align:right;">
        
 <? if(keyMan("bonsaadmin", "po") or keyMan("wrman", $row->wrMemid)){ ?>       
        <a href="#" class="btn_gray" onclick="appBasInfo.delGongji(<?=$md?>, <?=$md2?>, <?=$row->id?>)"><span style="display:inline-block;width:30px;">삭제</span></a>
		<a href="<?=$baseUrl?>community/getView/<?=$md?>/<?=$md2?>/4/<?=$row->id?>" class="btn_org"><span style="display:inline-block;width:30px;">수정</span></a>
		
<? } ?>        
        
        <a href="<?=$baseUrl?>community/getView/<?=$pam1?>/<?=$pam2?>/<?=$pam3?>/<?=$pam4?>" class="btn_gray"><span>목록</span></a>
		</div>
      

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

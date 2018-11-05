<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "schedule/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);
?>


<style>
#viewTxtImg3 img, #viewTxtImg4 img {max-width:90%; margin:0;}
#viewTxtImg3, #viewTxtImg4 {width:747px; margin:0; padding:0;}
</style>



<script src='/spectrum/spectrum.js'></script>
<link rel='stylesheet' href='/spectrum/spectrum.css' />



	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?if($md == '1'){?>본사<?}else{?>조합<?}?>스케줄 보기</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 대상자 등록 -->
      

   <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; width:90%; height:500px; border:none; display:block;">


 
<? foreach($bd as $rows){?>

        <table class="onputPage" style="width:100%; margin:0 0 18px;">
        <tr><th><span class="pilsu">*</span><span>제목</span></th><td>
            <?=$rows->title?>
        </td></tr>
        <tr><th><span class="pilsu">*</span><span>작성자</span></th><td>
            <?=$rows->name?>
        </td></tr>
        <tr><th><span class="pilsu">*</span><span>등록/수정 일시</span></th><td>
            <?=$rows->regdate?> / <?=$rows->moddate?>
        </td></tr>
        <tr><th><span class="pilsu">*</span><span>시작일/종료일</span></th><td>
            <?=$rows->start_dt?> ~ <?=$rows->end_dt?>
        </td></tr>
       
        
        
        <tr><th colspan="2"><span>내용</span></th></tr>
        <tr><td colspan="2" class="longTd" style="padding:14px 0; text-align:left;">
         
         <div id="viewTxtImg3"><?=nl2br($rows->content)?></div>
    
    </td></tr>
    </table>


 
        
        <div class="srch" style="text-align:right"><p style="text-align:center">
        
<? if((keyMan("bonsaadmin", 0)) or ($md==2 and keyMan("johap", 0)) or $rows->wrmem == $this->session->userdata('memid')){  ?>   
		<a href="#" onclick="appBasInfo.delSc(<?=$md?>, <?=$rows->id?>)" class="btn_gray"><span>삭제</span></a>
        <a href="<?=$baseUrl?>schedule/getView/<?=$md?>/4/<?=$rows->id?>" class="btn_gray"><span>수정</span></a>
<? } ?>        
        <a href="<?=$baseUrl?>schedule/getView/<?=$md?>/1" class="btn_gray"><span>목록</span></a>
		</p></div>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
 
 <? } ?>
    

  </div>
  
  
<script>
$("#color").spectrum({
    color: "#f00"
});
</script>




<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


	//var dd = document.getElementById("start_dt");
	//dd.value = sdy+"-"+sdm+"-"+sdd;

</script>     
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

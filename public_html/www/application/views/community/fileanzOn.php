<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$ondisp = "none";
$mn[0] = "class='on'";
$mn[1] = "";
if($onmd == 2){
	$ondisp = "block";
	$mn[0] = "";
	$mn[1] = "class='on'";
}
$su = 0; //count($gaip);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">자료실</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; height:350px; border:none; display:block;">
    
    				<form id="frmMem" action="<?=$baseUrl?>community/community/onputSaup" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
 

    <div class="formJ">
    	<p><span>제목</span><input type="text" name="" maxlength="10" value="" disabled /></p>
        
        
        <p><span>간략한 설명</span><textarea name=""></textarea></p>
               
        <p><span>첨부파일</span><input type="file" name="addfile" /></p>
        
        <p><span>등록일시</span><input type="date" name="" maxlength="15" /></p>
        

<? if(keyMan("admin", "po")){ ?>	
        <p style="text-align:center; padding:25px 0;"><a type="button" name=""  class="button1" class="onsubmit" onclick="meminf.edtMember2()">자료실 등록</a></p>
<? } ?>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
    </div>


				</form>
    

  </div>
  
  


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="<?=$baseUrl?>hjang/getView/1/2" class="btn_gray"><span>글쓰기</span></a>
      <!--<a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

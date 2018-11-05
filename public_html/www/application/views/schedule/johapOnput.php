<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);
?>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#">조합스케줄 등록</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 대상자 등록 -->
      

   <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; height:500px; border:none; display:block;">
    
    				<form id="frmMem" action="<?=$baseUrl?>scene/hjang/onputSaup" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
 
    <div class="formJ">
    	<p><span>제목</span><input type="text" name="name" maxlength="10" value="" disabled /></p>
        
        <p><span>내용</span><textarea name=""></textarea></p>
       
        
        <p><span>시작일시</span><input type="date" name="" value="" placeholder="시작일자 ~ 종료일자" /></p>
        <p><span>종료일시</span><input type="date" name="" value="" placeholder="시작일자 ~ 종료일자" /></p>


        
        <p style="text-align:center; padding:25px 0;">
        <a type="button" name=""  class="button1" class="onsubmit" onclick="meminf.edtMember2()">스케줄 등록</a>
        <a type="button" href="<?=$baseUrl?>schedule/getView/2" class="button1" class="onsubmit">목록</a>
        </p>
        
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
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

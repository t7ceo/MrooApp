<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "control/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">게시판 생성</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div" style="position:relative; margin:60px auto 0; height:350px; border:none; display:block;">
    
    				<form name="frmBd" id="frmBd" action="<?=$baseUrl?>control/onBorder" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "gubun" value="2">
 


        <table class="onputPage">
        <tr><th><span>게시판 이름</span></th><td>
            <input type="text" id="bdtit" name="bdtit" maxlength="10" style="width:70%;" value="" />
        </td></tr>
        
        <tr><th><span>게시판 노출설정</span></th><td>
			<select id="cogubunWR" name="cogubunWR"><option value="0">선택</option><option value="1">전체 ( 본사+조합+계열사 )</option><option value="3">본사</option></select>
        </td></tr>
        

    </table>
   
        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org" onclick="bdONEdit();"><span>게시판 생성</span></a>
        <a href="<?=$baseUrl?>control/getView/2" class="btn_gray"><span>목록</span></a>
        </p>
        
 
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

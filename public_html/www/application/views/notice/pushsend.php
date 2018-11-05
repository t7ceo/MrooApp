<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "notice/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = count($gaip);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">푸쉬 발송</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 20px; height:auto; display:block; border:#dedede 3px solid;">
    
                    <form id="frmPush" name="frmPush" action="<?=$baseUrl?>gongji/senPush" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "susin" value="">
                    <input type="hidden" name= "coid" value="<?=$this->session->userdata('coid')?>">
                    <input type="hidden" name= "sendCo" value="">
                    <input type="hidden" name= "wr" value="<?=$this->session->userdata('memid')?>">
 
 

    <div class="formJ">

        <p><span>제목 :</span><input type="text" id="pushTit" name="pushTit" value="" style="width:77%;"/></p>
        <p><span>링크 :</span><input type="text" id="pushLink" name="pushLink" value="" style="width:77%;"/></p>
        
        <p><span>내용 :</span><textarea id="pushMess" name="pushMess" style="width:100%; height:120px;"></textarea></p>

        
        <p style="text-align:center; padding:25px 0;"><a type="button" name=""  class="button1" class="onsubmit" id="pushSendGo">푸쉬발송</a></p>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
    </div>


				</form>
    

  </div>
  
  
  
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">발송 선택한 회원 <strong><?=$su?></strong> 명 </p>
      <div class="srch">
      
      <select id="pushMem" name="memgubun">
      <?  
	  if($this->session->userdata('cogubun') == BONSA){ 
	  		$seinf = "";
			if($md3 == 0) $seinf = "selected = 'selected'";
	  ?>
      			<option value="0">전체회원</option>
    <?
			$seinf = "";
	
	  }
	  foreach($allco as $rowco){
		  if($md3 == $rowco->id) $seinf = "selected = 'selected'";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
			$seinf = "";
	  }
	  ?>
             </select>
      
      
      
      
        <input type="text" id="gaipFindTxt" value="<?=$this->session->userdata("find")?>" name="findRec"/>
        <p><a href="#" class="btn" id="gaipFind"><span>검색</span></a></p>
      </div>
      <table class="table_list">
      <caption>메시지 전송</caption>
      <colgroup>
      <col width="4%">
      <col width="8%">
      <col width="14%">
      <col width="16%">
      <col width="20%">
      <col width="20%">
      <col width="18%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th><input type="checkbox" name="messSend" value="all" id="pushChkAll" /></th>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>연락처</th>
        <th>업체명</th>
        <th>직책</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	$c = 0;
	foreach($gaip as $rows){   
?>   
      <tr id="tr-<?=$rows->id?>">
		<td><input type="checkbox" name="pushSend" class="pushSend" value="<?=$rows->id?>" /></td><td><?=($su - $c++)?></td>
        <td><?=$rows->memid?></td><td>-</td><td><?=base64decode($rows->tel)?></td><td><?=$rows->coname?></td><td><?=potiontojigwiP($rows->potion)?></td>
      </tr>
<? } ?>      
      
      </tbody>
      </table>


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

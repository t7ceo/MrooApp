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
          <li class="on"><a href="#">선택한 회원에게 메시지 전송</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div2" style="position:relative; top:0; margin:10px auto 20px; padding-bottom:0; display:block; height:auto; border:#dedede 3px solid;">
    
    				<form id="frmMess" name="frmMess" action="<?=$baseUrl?>gongji/senMess" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "susin" value="">
                    <input type="hidden" name= "coid" value="<?=$this->session->userdata('coid')?>">
                    <input type="hidden" name= "sendCo" value="">
                    <input type="hidden" name= "wr" value="<?=$this->session->userdata('memid')?>">
 

    <div class="formJ" style="margin-bottom:0;">
    	<p><span>제목 :</span><input type="text" id="messTit" name="messTit" value="" style="width:77%;"/></p>
        
        
        <p><span>내용 :</span><textarea id="messMess" name="messMess" style="width:100%; height:120px;"></textarea></p>

        
        <div style="width:100%; text-align:center; padding:20px 0;"><a href="#" name="onsubmit" id="messSendGo"  class="btn_org"><span>메시지 전송</span></a></div>
        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
    </div>
				</form>
  </div>
  
  
  
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">발송 선택한 회원 <strong><?=$su?></strong> 명 </p>
      <div class="srch">
      
      
      <select id="messMem" name="memgubun">
      <?  
	  if($this->session->userdata('cogubun') == BONSA or $this->session->userdata('cogubun') == JOHAPG){ 

			if($md3 == 0) $seinf = "selected = 'selected'";
			else $seinf = "";
	  ?>
      			<option value="0">전체회원</option>
    <?

	
	  }
	  foreach($allco as $rowco){
		  if($md3 == $rowco->id) $seinf = "selected = 'selected'";
		  else $seinf = "";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
	
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
        <th><input type="checkbox" name="messSend" value="all" id="messChkAll" /></th>
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
	if($su < 1){
?>		
			<tr><td colspan="7">대상자 리스트가 없습니다.</td></tr>	
<?		
	}else{

	$c = 0;
	foreach($gaip as $rows){   
?>   
      <tr id="tr-<?=$rows->id?>">
		<td><input type="checkbox" name="messSend" class="messSend" value="<?=$rows->id?>" /></td><td><?=($su - $c++)?></td>
        <td><?=$rows->memid?></td><td><?=$rows->name?></td><td><?=base64decode($rows->tel)?></td><td><?=$rows->coname?></td><td><?=potiontojigwiP($rows->potion)?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>gongji/getView/<?=$md?>/<?=$md2?>/1" class="btn_gray"><span>메시지전송 목록</span></a></div>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

<?php
	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      
      

<script language = "javascript">
function fnSearch(){
	if(document.searchform.search_text.value == ''){
		alert('검색어를 입력하세요.');
		document.searchform.search_text.focus();
		return;
	}

	document.searchform.submit();
}
</script>
  
  
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <div class="srch">
		<select id="selectMdGBonsa">
        	<option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
			<option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>제목</option>
			<option value="content" <?=($this->session->userdata("findMd") == "content")? "selected='selected'":""?>>제목+내용</option>
            <option value="wr" <?=($this->session->userdata("findMd") == "wr")? "selected='selected'":""?>>작성자</option>
		</select>
        
        <input type="text" name="bonsaFindTxt" id="bonsaFindTxt" value="<?=$this->session->userdata("find")?>"/>
		<p><a href="#" class="btn" id="bonsaFind"><span>검색</span></a></p>
      </div>


      <table class="table_list">
      <caption>aaa</caption>
      <colgroup>
      <col width="50%">
      <col width="50%">
      </colgroup>
      <thead>
      <tr>
        <th>통계전체 현황</th>
      </tr>
      </thead>
      <tbody>
      <tr><td class="mrsaleAll">


            <div class="divAllWidth">
        
            
                <p><i class="fab fa-qq"></i>&nbsp;&nbsp;&nbsp;이용 통계</p>

      <table class="table_list3">
      <caption>매출통계</caption>
      <colgroup>
      <col width="50%">
      <col width="50%">
      </colgroup>
      <thead>
      <tr>
        <th>스트리밍</th>
        <th>다운로드</th>
      </tr>
      </thead>
      <tbody>
 
      <tr>
        <td><i class="fas fa-assistive-listening-systems" style="font-size:1.3em;"></i><br /><?=$mechulSt->su?></td>
		<td><i class="fas fa-folder-open" style="font-size:1.3em;"></i><br /><?=$mechulDown->su?></td>
      </tr>

      </tbody>
      </table>


		</div>


            <div class="divAllWidth">
        
            
                <p><i class="fab fa-qq"></i>&nbsp;&nbsp;&nbsp;이용권구매 통계</p>

      <table class="table_list3">
      <caption>주문리스트</caption>
      <colgroup>
      <col width="50%">
      <col width="50%">
      </colgroup>
      <thead>
      <tr>
        <th>상품명</th>
        <th>매출</th>
      </tr>
      </thead>
      <tbody>
      
<?
	foreach($cuponMechul as $rows){   
?>   
      <tr>
        <td><?=$rows->tit?></td>
		<td><?=$rows->su?></td>   
      </tr>
<?  }?>      
      
      

      
      </tbody>
      </table>


		</div>


            <div class="divAllWidth">
        
            
                <p><i class="fab fa-qq"></i>&nbsp;&nbsp;&nbsp;가입자 통계</p>

      <table class="table_list3">
      <caption>주문리스트</caption>
      <colgroup>
      <col width="50%">
      <col width="50%">
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>회원 수</th>
      </tr>
      </thead>
      <tbody>
      
<?	
	foreach($memberAnz as $rowsM){   
?>   
      <tr>
		<td><?=$rowsM->stat?></td>
        <td><?=$rowsM->su?></td>
      </tr>
<?  }?>      
      
      

      
      </tbody>
      </table>



	</td></tr></tbody></table>



<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

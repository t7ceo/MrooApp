<?php
	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;


?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>


      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
			$oninf = ($ii == ($md2 - 1))? "class='on'" : "" ;
		?>
          <li <?=$oninf?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
				$ii++;
			} 
		?>          
        </ul>
      </div>
      <!-- //tab -->
      
      
      
      

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
      <p class="total">메시지 건수 <strong><?=$su?></strong> 건 </p>
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
      <caption>주문리스트</caption>
      <colgroup>
      <col width="15%">
      <col width="42%">
      <col width="20%">
      <col width="22%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>음원제목</th>
        <th>매출</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="4">등록된 공지사항이 없습니다.</td></tr>

<?   }else{
	
	
		$num = ($page * ($ppn / $ppn));
		
	foreach($allbd as $rows){   
	
?>   
      <tr>
		<td><?=($su - $num++)?></td>
        <td><?=$rows->tit?></td>
		<td>0</td>
		<td>상세</td>        
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>

<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:755px; text-align:right;"><a href="<?=$wrlink?>/2" class="btn_gray"><span>글쓰기</span></a></div>
<? } ?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

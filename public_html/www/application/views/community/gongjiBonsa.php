<?php
	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su1 = $totalCount1;

$su2 = $totalCount2;

$su3 = $totalCount3;

?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>


      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
			$oninf = ($ii == ($md3 - 1))? "class='on'" : "" ;
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
      <p class="total">메시지 건수 <strong><?=$su1?></strong> 건 </p>
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


<table class="table_list2"><tr><td class="gongjiAll">

	<div class="divAllWidth">
    
		<p>공지사항</p>
        
      <table class="table_list3">
      <caption>본사 공지사항</caption>
      <colgroup>
      <col width="15%">
      <col width="42%">
      <col width="20%">
      <col width="22%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su1 < 1){
?>		
	
		<tr><td colspan="4">등록된 공지사항이 없습니다.</td></tr>

<?   }else{
	
	//$c = 0;
	
		$num = ($page * ($ppn / $ppn));
		
	foreach($allbd as $rows){   
	
?>   
      <tr>
		
<?if($rows->gongji == 'Y'){?>
		<td>공지<?($su1 - $num++)?></td>
<?}else{?>
		<td><?=($su1 - $num++)?></td>
<?}?>
		<td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows->tit?></a></td>
		<td><?=$rows->onday?></td>
        
		<td><?
		
		if($md == 1){
			echo $rows->wrMemid." ( ".$rows->name." )";
		}
		
		?></td>
        
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>
  
<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:100%; text-align:right;"><a href="<?=$wrlink?>/2" class="btn_gray"><span>글쓰기</span></a></div>
<? } ?>



	</div>



	<div class="divAllWidth">
    
    	<p>FAQ</p>

      <table class="table_list3">
      <caption>본사 공지사항</caption>
      <colgroup>
      <col width="15%">
      <col width="42%">
      <col width="20%">
      <col width="22%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su2 < 1){
?>		
	
		<tr><td colspan="4">등록된 공지사항이 없습니다.</td></tr>

<?   }else{
	
	//$c = 0;
	
		$num = ($page * ($ppn / $ppn));
		
	foreach($faq as $rows2){   
	
?>   
      <tr>
		
<?if($rows->gongji == 'Y'){?>
		<td>공지<?($su2 - $num++)?></td>
<?}else{?>
		<td><?=($su2 - $num++)?></td>
<?}?>
		<td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows2->id."/".$md4?>"><?=$rows2->tit?></a></td>
		<td><?=$rows2->onday?></td>
        
		<td><?
		
		if($md == 1){
			echo $rows2->wrMemid." ( ".$rows2->wrMemid." )";
		}
		
		?></td>
        
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>

<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:100%; text-align:right;"><a href="<?=$wrlink?>/2" class="btn_gray"><span>글쓰기</span></a></div>
<? } ?>


	</div>



	<div class="divAllWidth">
    
		<p>질문</p>

      <table class="table_list3">
      <caption>본사 공지사항</caption>
      <colgroup>
      <col width="15%">
      <col width="42%">
      <col width="20%">
      <col width="22%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su3 < 1){
?>		
	
		<tr><td colspan="4">등록된 공지사항이 없습니다.</td></tr>

<?   }else{
	
	//$c = 0;
	
		$num = ($page * ($ppn / $ppn));
		
	foreach($qna as $rows3){   
	
?>   
      <tr>
		
<?if($rows->gongji == 'Y'){?>
		<td>공지<?($su3 - $num++)?></td>
<?}else{?>
		<td><?=($su3 - $num++)?></td>
<?}?>
		<td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->tit?></a></td>
		<td><?=$rows3->onday?></td>
        
		<td><?
		
		if($md == 1){
			echo $rows3->wrMemid." ( ".$rows3->name." )";
		}
		
		?></td>
        
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>

<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:100%; text-align:right;"><a href="<?=$wrlink?>/2" class="btn_gray"><span>글쓰기</span></a></div>
<? } ?>


	</div>




</td></tr>
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

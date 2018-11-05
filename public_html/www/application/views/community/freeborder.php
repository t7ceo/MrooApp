<?php
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">자유게시판</a></li>
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
      <form name="searchform" method="post" action="<?=$baseUrl?>community/getView/<?=$md?>">
      <div class="srch">
		<select name="search_field">
			<option value="tit" <?if($search_field == 'tit'){?>selected<?}?>>제목</option>
			<option value="content" <?if($search_field == 'content'){?>selected<?}?>>내용</option>
			<option value="wrMemid" <?if($search_field == 'wrMemid'){?>selected<?}?>>작성자</option>
		</select>
        <input type="text" name="search_text" id="gaipFindTxt" value="<?=$search_text?>"/>
        <!--<p><a href="javascript:fnSearch();" class="btn" id="gaipFind"><span>검색</span></a></p>-->
		<p><a href="javascript:fnSearch();" class="btn"><span>검색</span></a></p>
      </div>
	  </form>
      <table class="table_list">
      <caption>자유게시판</caption>
      <colgroup>
      <col width="10%">
      <col>
      <col width="10%">
	  <col width="30%">
      <col width="15%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>작성자</th>
		<th>파일</th>
        <th>등록일</th>
      </tr>
      </thead>
      <tbody>
     
     
<? 
	$c = 0;
	foreach($allbdL as $rows){   
?>   
      <tr>
		<td><?=($su - $c++)?></td>
		<td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrl."community/getView/".$md."/3/".$rows->id."/".$md4?>"><?=$rows->tit?></a></td>
		<td><?=$rows->wrMemid?></td>
<?if($rows->filename){?>
		<td><a href="<?=$baseUrl."community/file_download/".$rows->filename?>"><img src="<?=PREDIR?>images/community/ico_file.gif" alt="파일"></a></td>
<?}else{?>
		<td>&nbsp;</td>
<?}?>
		<td><?=$rows->onday?></td>
      </tr>
<? } ?>      
      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>

<? if(keyMan("johapUp", "po")){ ?>	
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>community/getView/4/2" class="btn_gray"><span>글쓰기</span></a></div>
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

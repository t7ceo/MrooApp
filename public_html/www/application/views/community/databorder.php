<?php
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;

foreach($bdinf as $bdinfrow){
	//게시판의 쓰기 버튼 출력 
	$bdgo = keyMan("mkbdWR", $bdinfrow);
}
?>


		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$bdinfrow->bdtit?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      

  
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
      <caption><?=$bdinfrow->bdtit?></caption>
      <colgroup>
      <col width="15%">
      <col width="40%">
	  <col width="23%">
      <col width="22%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>작성자</th>
        <th>등록일</th>
      </tr>
      </thead>
      <tbody>
     
     
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="5">등록된 글이 없습니다.</td></tr>

<?   }else{
	
		$num = ($page * ($ppn / $ppn));
	
	foreach($allbdL as $rows){   
	

	
?>   
      <tr>
		<td><?=($su - $num++)?></td>
		<td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrl."community/getView/".$md."/3/".$rows->id."/".$md4?>"><?=$rows->tit?></a></td>
		<td><?=$rows->wrMemid." ( ".$rows->name." )"?></td>
		<td><?=$rows->onday?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>



<? 

if(keyMan("bonsaadmin", "po") or $bdgo){ ?>	
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>community/getView/<?=$md?>/2" class="btn_gray"><span>글쓰기</span></a></div>
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

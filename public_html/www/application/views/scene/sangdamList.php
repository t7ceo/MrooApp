<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;
?>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#">상담 리스트</a></li>
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
      <p class="total">총 건수 <strong><?=$su?></strong> 건 </p>


      <div class="srch">
      
	<select id="dsConame" name="dsConame" onchange="meminf.chnSelect(this, 3)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA or $this->session->userdata('cogubun') == JOHAPG){ 
			if($coid == 0) $seinf = "selected = 'selected'";
			else $seinf = "";
	  ?>
      			<option value="0">전체</option>
    <?
	
	  }
	  foreach($allco as $rowco){
		  if($coid == $rowco->id) $seinf = "selected = 'selected'";
		  else $seinf = "";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
	  }
	  ?>
      </select>
      
      
      <select id="selectMdsd">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>제목</option>
      <option value="saup" <?=($this->session->userdata("findMd") == "saup")? "selected='selected'":""?>>사업명</option>
      <option value="desang" <?=($this->session->userdata("findMd") == "desang")? "selected='selected'":""?>>대상자</option>
      <option value="wrmem" <?=($this->session->userdata("findMd") == "wrmem")? "selected='selected'":""?>>등록자</option>
      </select>      
      
        <input type="text" id="sdFindTxt" value="<?=$this->session->userdata("find")?>" name="sdFindTxt"/>
        <p><a href="#" class="btn" id="sdFind"><span>검색</span></a></p>
      </div>


      <table class="table_list">
      <caption>상담일지</caption>
      <colgroup>
      <col width="10%">
      <col width="20%">
      <col width="17%">
      <col width="13%">
      <col width="12%">
      <col width="9%">
      <col width="9%">
      <col width="10%">

      <col>
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>사업명</th>
        <th>대상자</th>
        <th>업체명</th>
        <th>상담일시</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="8">등록된 데이터가 없습니다.</td></tr>

<?   }else{
	
		$num = ($page * ($ppn / $ppn)); 
	foreach($sdlist as $rows){  
	
?>   
      <tr>
		<td><?=($su-$num++)?></td>
		<td><a href="<?=$baseUrl?>hjang/getView/3/3/<?=$coid?>/<?=$rows->id?>"><?=$rows->tit?></a>
		</td>
        <td><?=$rows->saupnam?></td>
		<td><?=$rows->dsname?></td>
        <td><?=$rows->coname?></td>
		<td><?=substr($rows->sday, 0, 10)?></td>
		<td><?=$rows->onday?></td>
		<td><?=$rows->wrname?></td>
      </tr>
<? } }?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>

<? if(keyMan("sawon", "po")){ ?>		
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/3/2" class="btn_gray"><span>상담등록</span></a></div>
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

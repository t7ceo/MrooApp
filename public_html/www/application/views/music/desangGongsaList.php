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
          <li><a href="<?=$baseUrl?>hjang/getView/2/1/0/0/0--n">대상자정보 관리</a></li>
          <li class="on"><a href="#">대상자별 공사관리</a></li>
          <li><a href="<?=$baseUrl?>hjang/getView/2/5/0/0/0--n">대상자별 사진대장</a></li>
        </ul>
      </div>
      <!-- //tab -->
      


</script>  

      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">총 공사 <strong><?=$su?></strong> 건 </p>
      <div class="srch">
      
	<select id="dsConame" name="search_field" onchange="meminf.chnSelect(this, 6)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA or $this->session->userdata('cogubun') == JOHAPG){ 
			if($secoid == 0) $seinf = "selected = 'selected'";
			else $seinf = "";
	  ?>
      			<option value="0">전체</option>
    <?

	
	  }
	  foreach($allco as $rowco){
		  if($secoid == $rowco->id) $seinf = "selected = 'selected'";
		  else $seinf = "";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
	  }
	  ?>
      </select>
      

      <select id="selectMdgongsa">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="name" <?=($this->session->userdata("findMd") == "name")? "selected='selected'":""?>>대상자명</option>
      <option value="tel" <?=($this->session->userdata("findMd") == "tel")? "selected='selected'":""?>>전화+휴대폰</option>
      <option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>공사명</option>
      <option value="wr" <?=($this->session->userdata("findMd") == "wr")? "selected='selected'":""?>>등록자</option>
      </select>
      
      
      
        <input type="text" id="gongsaFindTxt" value="<?=$this->session->userdata("find")?>" name="gongsaFindTxt"/>
        <p><a href="#" class="btn" id="gongsaFind"><span>검색</span></a></p>
      </div>


      <table class="table_list">
      <caption>대상자관리</caption>
      <colgroup>
      <col width="8%">
      <col width="10%">
      <col width="10%">
      <col width="20%">
      <col width="28%">
      <col width="12%">
      <col width="14%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>대상자명</th>
        <th>대상자 휴대폰</th>
        <th>사업명</th>
        <th>공사명</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="7">등록된 데이터가 없습니다.</td></tr>

<?   }else{
	
	
		$num = ($page * ($ppn / $ppn));
	foreach($gslist as $gsrow){   
	
	
?>   
      <tr>
		<td><?=($su - $num++)?></td>
		<td><a href="<?=$baseUrl?>hjang/getView/2/44/<?=$secoid?>/<?=$gsrow->dsid?>"><?=$gsrow->dsname?></a></td>
        <td><?=anzTel($gsrow->htel)?></td>
		<td><a href="<?=$baseUrl?>hjang/getView/2/3/<?=$secoid?>/<?=$gsrow->saupid?>"><?=$gsrow->saupnam?><br />( <?=$gsrow->coname?> )</a></td>
        <td><a href="<?=$baseUrl?>hjang/getView/2/77/<?=$gsrow->id?>/<?=$gsrow->dsid?>"><?=$gsrow->gsname?></a></td>
		<td><?=$gsrow->onday?></td>
		<td><?=$gsrow->wmemid?><br />( <?=$gsrow->name?> )</td>
      </tr>
<? } }?>      
      
      </tbody>
      </table>
	  <div class="paging"><?=$this->pagination->create_links();?></div>
<?
if(keyMan("admin", "po")){ ?>		
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/2/7/<?=$secoid?>/0" class="btn_gray"><span>공사등록</span></a></div>
<? }?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

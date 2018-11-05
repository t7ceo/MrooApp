<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$ff = substr($this->session->userdata("find"), 2);
$Aff0 = substr($this->session->userdata("find"), 0, 2);

	$Aff = "A0";
	$Bff = "B0";
	$Cff = "C0";
$fgb = substr($Aff0, 0, 1);
switch($fgb){
case "A":
	$Aff = $Aff0;
	$Bff = "B0";
	$Cff = "C0";
break;
case "B":
	$Aff = "A0";
	$Bff = $Aff0;
	$Cff = "C0";
break;
case "C":
	$Aff = "A0";
	$Bff = "B0";
	$Cff = $Aff0;
break;
}




//$ff = str_replace($Aff, "", $ff);
$su = $totalCount;

?>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#">대상자정보 관리<?=$bb?></a></li>
          <li><a href="<?=$baseUrl?>hjang/getView/2/6/0/0/0--n">대상자별 공사관리</a></li>
          <li><a href="<?=$baseUrl?>hjang/getView/2/5/0/0/0--n">대상자별 사진대장</a></li>
        </ul>
      </div>
      <!-- //tab -->
      




      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
     <table style="width:100%;"><tr><td>       
            
      <p class="total">총 대상자 <strong><?=$su?></strong> 명 </p>
     </td><td style="text-align:right; vertical-align:middle;"> 
      
      
      <div class="srch" style="vertical-align:middle;">
		
        정렬조건 :       

      <select id="selectFF" name="selectFF" onchange="meminf.chnSelect(this, 0)" style="vertical-align:top; margin:0 0 4px;">
      <option value="A0" <?=($Aff == "A0" or "")? "selected='selected'":""?>>수급 선택</option>
      <option value="A1" <?=($Aff == "A1")? "selected='selected'":""?>>일반수급</option>
      <option value="A2" <?=($Aff == "A2")? "selected='selected'":""?>>조건부수급</option>
      <option value="A3" <?=($Aff == "A3")? "selected='selected'":""?>>인증차상위</option>
      <option value="A4" <?=($Aff == "A4")? "selected='selected'":""?>>일반저소득</option>
      </select>      
      
      
      <select id="selectBJ" name="selectBJ" onchange="meminf.chnSelect(this, 0)" style="vertical-align:top; margin:0 0 4px;">
      <option value="B0" <?=($Bff == "B0" or "")? "selected='selected'":""?>>의료보장 선택</option>
      <option value="B1" <?=($Bff == "B1")? "selected='selected'":""?>>의료보호1종</option>
      <option value="B2" <?=($Bff == "B2")? "selected='selected'":""?>>의료보호2종</option>
      <option value="B3" <?=($Bff == "B3")? "selected='selected'":""?>>직장의료보험</option>
      <option value="B4" <?=($Bff == "B4")? "selected='selected'":""?>>지역의료보험</option>
      <option value="B5" <?=($Bff == "B5")? "selected='selected'":""?>>기타</option>
      </select>      
      
      <select id="selectGG" name="selectGG" onchange="meminf.chnSelect(this, 0)" style="vertical-align:top; margin:0 0 4px;">
      <option value="C0" <?=($Cff == "C0" or "")? "selected='selected'":""?>>가구 선택</option>
      <option value="C1" <?=($Cff == "C1")? "selected='selected'":""?>>노인부부</option>
      <option value="C2" <?=($Cff == "C2")? "selected='selected'":""?>>독거노인</option>
      <option value="C3" <?=($Cff == "C3")? "selected='selected'":""?>>조손가정</option>
      <option value="C4" <?=($Cff == "C4")? "selected='selected'":""?>>장애인가구</option>
      <option value="C5" <?=($Cff == "C5")? "selected='selected'":""?>>기타</option>
      </select>      
      
      <br />
      
      검색조건 : 
	<select id="dsConame" name="search_field" onchange="meminf.chnSelect(this, 2)" style="vertical-align:top;">
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
      
      
      <select id="selectMdds" style="vertical-align:top;">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="name" <?=($this->session->userdata("findMd") == "name")? "selected='selected'":""?>>이름</option>
      <option value="tel" <?=($this->session->userdata("findMd") == "tel")? "selected='selected'":""?>>전화+휴대폰</option>
      <option value="addr" <?=($this->session->userdata("findMd") == "addr")? "selected='selected'":""?>>주소</option>
      <option value="wr" <?=($this->session->userdata("findMd") == "wr")? "selected='selected'":""?>>등록자</option>
      
      </select>      
      
      
      
        <input type="text" id="dsFindTxt" value="<?=$ff?>" name="dsFindTxt" style="vertical-align:top;"/>
        <p><a href="#" class="btn" id="dsFind"><span>검색</span></a></p>
        
        
      </div>

	</td></tr></table>


      <table class="table_list">
      <caption>대상자관리</caption>
      <colgroup>
      <col width="8%">
      <col width="8%">
      <col width="10%">
      <col width="26%">
      <col width="9%">
      <col width="9%">
      <col width="12%">
      <col width="8%">
      <col width="10%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>세대주</th>
        <th>핸드폰</th>
        <th>주소</th>
        <th>수급여부</th>
        <th>의료보장</th>
        <th>가구원특기사항</th>
        <th>등록일</th>
        <th>등록자</th>
      </tr>
      </thead>
      <tbody>


      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="9">대상자 회원데이터가 없습니다.</td></tr>

<?   }else{
	
		$num = ($page * ($ppn / $ppn));
	foreach($dslist as $dsrow){   
	
?>   
      <tr>
		<td><?=($su - $num++)?></td><td><a href="<?=$baseUrl?>hjang/getView/2/4/<?=$secoid?>/<?=$dsrow->id?>"><?=$dsrow->dsname?></a></td><td><?=anzTel($dsrow->htel)?></td><td><?=$dsrow->addr." ".$dsrow->addr2?></td><td><?=dispSugub($dsrow->sugub)?></td><td><?=dispBojang($dsrow->bojang, $dsrow->bojangetc)?></td><td><?=dispGagu($dsrow->gaguinf, $dsrow->gagumemo)?></td><td><?=$dsrow->onday?></td><td><?=$dsrow->wrmemid?><br /> ( <?=$dsrow->name?> )</td>
      </tr>
<? } }?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>

<?
if(keyMan("admin", "po")){ ?>		      
		<div style="width:755px; text-align:right;">
        <a href="#" class="btn_gray" onclick="appBasInfo.toExcel(<?=$secoid?>)"><span>엑셀전환</span></a>
        <a href="<?=$baseUrl?>hjang/getView/2/2/<?=$this->session->userdata('coid')?>/0" class="btn_org"><span>대상자등록</span></a>
        </div>
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

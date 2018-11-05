<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

//echo $this->session->userdata('myMenu');
//http://mroo.co.kr/scene/hjang/getView/1/3/54/0/2   (사업관리/사업대상자 리스트/업체아이디/0/사업아이디)

?>

<style>
#tbClose0, #tbClose1, #tbClose2, #tbClose3, #tbClose4{
	text-align:right;
	cursor:pointer;
}
</style>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">통합검색</a></li>
        </ul>
      </div>
      <!-- //tab -->
      


      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <!--<p class="total">총 건수 <strong><?=$su?></strong> 건 </p>-->
      <div class="srch">


	<select id="allfind" name="allfind" onchange="meminf.chnSelect(this, 0)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA){ 
			if($coid == 0) $seinf = "selected = 'selected'"; 
			else $seinf = "";
	  ?>
      			<option value="0" <?=$seinf?>>전체</option>
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
      
	
    <? $uu = array('', '', '', '', '', ''); 
		$uu[$sef] = "selected = 'selected'";
		
		
		/*대상자명, 공사명, 사업명, 상담제목, 전화번호로 검색 한다.*/
	?>


      
	<select id="findSe" name="findSe" onchange="meminf.chnSelect(this, 1)">
  	<option value="0" <?=$uu[0]?>>선택</option>
    <option value="1" <?=$uu[1]?>>대상자명</option>
    <!--
    <option value="2" <?=$uu[2]?>>공사명</option>
    <option value="3" <?=$uu[3]?>>사업명</option>
    <option value="4" <?=$uu[4]?>>상담제목</option>
    <option value="5" <?=$uu[5]?>>전화번호</option>-->
   	</select>
      
      
      
      
        <input type="text" id="allFindTxt" value="<?=$fnd?>" name="allFindTxt"/>
        <p><a href="#" class="btn" id="allFindGet"><span>검색</span></a></p>
      </div>
      



<!--사업 리스트----------------------->      
      
<?	$su = count($allfnd['sp']);  ?>
          
      <table class="table_list" style="border-bottom:none;">
      <caption>사업 리스트</caption>
      <colgroup>
      <col width="8%">
      <col width="40%">
      <!--<col width="30%">-->
      <col width="21%">
      <col width="31%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th colspan="3" style="text-align:left;">&nbsp;&nbsp;<img src="<?=PREDIR?>images/btn_next.gif" />&nbsp;&nbsp;사업 리스트&nbsp;&nbsp;( <?=$su?> )</th>
        <th onclick="viewWindow(4)" id="tbClose4">닫기&nbsp;&nbsp;</th>
      </tr>
      <tr class="trTit4">
        <th>순번</th>
        <th>사업명</th>
        <!--<th>공사명</th>-->
        <th>대상자명</th>
        <th>일정</th>
      </tr>
      </thead>
      <tbody id="sptbody">
      

<?   
	
	$c = 0;
	
	if($su < 1){
	
?>
		<tr><td colspan="4">검색된 데이터가 없습니다.</td></tr>
        
	
<?  }else{ 
	
		foreach($allfnd['sp'] as $rowds){   
	
		
	
?>   
      <tr>
		<td><?=($su - $c++)?></td><td><a href="#" onclick="javascript:window.open('<?=$baseUrl?>hjang/getSaupSS/<?=$rowds->id?>', '사업 상세보기', 'width=600 height=650 menubar=no status=no location=no scrollbars=yes')"><?=$rowds->business_nm?></a></td>
        <!--<td><?=$rowds->gsname?></td>-->
        <td><?=$rowds->dsname?></td><td><?=$rowds->start_dt." ~ ".$rowds->end_dt?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
      
    
      
<!--대상자 리스트----------------------->      
      
<?	$su = count($allfnd['ds']);  ?>
          
      <table class="table_list" style="border-bottom:none;">
      <caption>대상자 리스트</caption>
      <colgroup>
      <col width="8%">
      <col width="14%">
      <col width="12%">
      <col width="12%">
      <col width="20%">
      <col width="35%">
      </colgroup>
      <thead>
      <tr>
        <th colspan="5" style="text-align:left;">&nbsp;&nbsp;<img src="<?=PREDIR?>images/btn_next.gif" />&nbsp;&nbsp;대상자 리스트&nbsp;&nbsp;( <?=$su?> )</th>
        <th onclick="viewWindow(0)" id="tbClose0">닫기&nbsp;&nbsp;</th>
      </tr>
      <tr class="trTit0">
        <th>순번</th>
        <th>대상자명</th>
        <th>생년월일</th>
        <th>전화</th>
        <th>업체명</th>
        <th>주소</th>
      </tr>
      </thead>
      <tbody id="dstbody">
      

<?   
	
	$c = 0;
	
	if($su < 1){
	
?>
		<tr><td colspan="6">검색된 데이터가 없습니다.</td></tr>
        
	
<?  }else{ 
	
		foreach($allfnd['ds'] as $rowds){   
	
		
	
?>   
      <tr>
		<td><?=($su - $c++)?></td><td><a href="#" onclick="javascript:window.open('<?=$baseUrl?>hjang/getDesangSS/<?=$rowds->id?>', '대상자 상세보기', 'width=600 height=700 menubar=no status=no location=no scrollbars=yes')"><?=$rowds->dsname?></a></td><td><?=anzBday($rowds->bday)?></td><td><?=anzTel($rowds->tel)?></td><td><?=$rowds->coname?></td><td><?=$rowds->addr." ".$rowds->addr2?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
      
	


<!--공사----------------------->

<? 	$su = count($allfnd['gs']); ?>
      
      <table class="table_list" style="border-bottom:none;">
      <caption>대상자 리스트</caption>
      <colgroup>
      <col width="8%">
      <col width="18%">
      <col width="22%">
      <col width="23%">
      <col width="30%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th colspan="4" style="text-align:left;">&nbsp;&nbsp;<img src="<?=PREDIR?>images/btn_next.gif" />&nbsp;&nbsp;공사 리스트&nbsp;&nbsp;( <?=$su?> )</th>
        <th onclick="viewWindow(1)" id="tbClose1">닫기&nbsp;&nbsp;</th>
      </tr>
      <tr class="trTit1">
        <th>순번</th>
        <th>공사명</th>
        <th>대상자명</th>
        <th>업체명</th>
        <th>사업명</th>
      </tr>
      </thead>
      <tbody id="gstbody">
      

<?   
	

	$c = 0;

	
	if($su < 1){
	
?>
		<tr><td colspan="5">검색된 데이터가 없습니다.</td></tr>
        
	
<?  }else{ 
	
		foreach($allfnd['gs'] as $rowgs){   
	
		
	
?>   
      <tr>
		<td><?=($su - $c++)?></td><td><a href="#" onclick="javascript:window.open('<?=$baseUrl?>hjang/getGongsaSSPop/<?=$rowgs->id?>', '공사 상세보기', 'width=600 height=650 menubar=no status=no location=no scrollbars=yes')"><?=$rowgs->gsname?></a></td><td><?=$rowgs->dsname?></td><td><?=$rowgs->coname?></td><td><?=$rowgs->spnam?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
      


<!--사진----------------------->

<? 	$su = count($allfnd['pt']); ?>

      <table class="table_list" style="border-bottom:none;">
      <caption>사진 리스트</caption>
      <colgroup>
      <col width="8%">
      <col width="16%">
      <col width="12%">
      <col width="10%">
      <col width="23%">
      <col width="32%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th colspan="5" style="text-align:left;">&nbsp;&nbsp;<img src="<?=PREDIR?>images/btn_next.gif" />&nbsp;&nbsp;사진 리스트&nbsp;&nbsp;( <?=$su?> )</th>
        <th onclick="viewWindow(2)" id="tbClose2">닫기&nbsp;&nbsp;</th>
      </tr>
      <tr class="trTit2">
        <th>순번</th>
        <th>공사명</th>
        <th>대상자명</th>
        <th>단계</th>
        <th>업체명 (사업명)</th>
        <th>제목</th>
      </tr>
      </thead>
      <tbody id="pttbody">
      

<?   
	

	$c = 0;

	
	if($su < 1){
	
?>
		<tr><td colspan="6">검색된 데이터가 없습니다.</td></tr>
        
	
<?  }else{ 
	
		foreach($allfnd['pt'] as $rowpt){   
	
			
	
?>   
      <tr>
		<td><?=($su - $c++)?></td><td><a href="#" onclick="javascript:window.open('<?=$baseUrl?>hjang/getPhotoSSPop/<?=$rowpt->id?>', '사진 상세보기', 'width=600 height=700 menubar=no status=no location=no scrollbars=yes')"><?=$rowpt->gsname?></a></td><td><?=$rowpt->desangmemid?></td><td><?=getDanget($rowpt->dange)?></td>
        <td><?=$rowpt->coname?><br /> ( <?=$rowpt->saupnam?> )</td><td><?=$rowpt->tit?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
      



<!--상담----------------------->

<? 	$su = count($allfnd['sd']); ?>

<div style="border-bottom:#333 1px solid;">
      <table class="table_list" style="border-bottom:none;">
      <caption>대상자 리스트</caption>
      <colgroup>
      <col width="8%">
      <col width="25%">
      <col width="12%">
      <col width="10%">
      <col width="12%">
      <col width="21%">
      <col width="13%">
      </colgroup>
      <thead>
      <tr>
        <th colspan="6" style="text-align:left;">&nbsp;&nbsp;<img src="<?=PREDIR?>images/btn_next.gif" />&nbsp;&nbsp;상담 리스트&nbsp;&nbsp;( <?=$su?> )</th>
        <th onclick="viewWindow(3)" id="tbClose3">닫기&nbsp;&nbsp;</th>
      </tr>
      <tr class="trTit3">
        <th>순번</th>
        <th>상담제목</th>
        <th>대상자</th>
        <th>휴대폰</th>
        <th>업체명</th>
        <th>사업명</th>
        <th>상담일자</th>
      </tr>
      </thead>
      <tbody id="sdtbody">
      

<?   
	

	$c = 0;
	
	if($su < 1){
	
?>
		<tr><td colspan="7">검색된 데이터가 없습니다.</td></tr>
        
	
<?  }else{ 
	
		foreach($allfnd['sd'] as $rowsd){   
	
		
	
?>   
      <tr>
		<td><?=($su - $c++)?></td><td><a href="#" onclick="javascript:window.open('<?=$baseUrl?>hjang/getSangdamSSPop/<?=$rowsd->id?>', '상담 상세보기', 'width=600 height=800 menubar=no status=no location=no scrollbars=yes')"><?=$rowsd->tit?></a></td><td><?=$rowsd->dsname?></td><td><?=anzTel($rowsd->htel)?></td>
        <td><?=$rowsd->coname?></td><td><?=$rowsd->spnam?></td><td><?=substr($rowsd->sday, 0, 10)?></td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
</div>      




<script>
	var wdom = new Array("dstbody", "gstbody", "pttbody", "sdtbody", "sptbody");
	var view = new Array(0,0,0,0,0);
	
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	function dispWindow(){
		for(var c = 0; c < 5; c++){
			if(view[c] == 0){
				$("tr.trTit"+c).hide();
				$("#"+wdom[c]+" tr").hide();
				$("#tbClose"+c).html("열기&nbsp;&nbsp;&nbsp;&nbsp;");
				
			}else{
				$("tr.trTit"+c).show();
				$("#"+wdom[c]+" tr").show();
				$("#tbClose"+c).html("닫기&nbsp;&nbsp;&nbsp;&nbsp;");
				
			}
		}
	}
	
	function viewWindow(indx){
		if(view[indx] == 0) view[indx] = 1;
		else view[indx] = 0;
		
		dispWindow();
	}

	dispWindow();
</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

<?
$baseUrl = $this->session->userdata('mrbaseUrl');  //http://mroo.co.kr/




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="stylesheet" type="text/css" href="<?=PREDIR?>templt/lib/css/admin/admin.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDd-Tpei_SBzIji0zKZa5CTMaQaRnNE7Bo"></script>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<style>
#viewTxtImg3 img, #viewTxtImg4 img {max-width:96%; margin:0;}
#viewTxtImg3, #viewTxtImg4 {width:455px; margin:0 0 0 7px; padding:0; text-align:left;}
</style>



</head>
<body>
  

<div class="layer_pop" style="width:100%;height:100%; padding:0 0 20px;">

 	<div style="width:100%; text-align:right;"><a href="#" class="btn_gray" style="margin:9px 12px 9px 0;" onclick="vpring()"><span>출력</span></a></div>

  	<div class="layer_pop_area" id="layer_pop_area">
        
        
      <table class="table_list" style="margin:0;">
      <caption>상담일지 상세보기</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      
      <thead>
      <tr><td colspan="2" style="padding:12px 0; text-align:center; font-size:1.4em; border-bottom:#ccc 1px solid;">상담 상세보기</td></tr>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">제목</td><td><?=$sss->tit?></td></tr>
      
      <tr><td class="titcell">내용</td><td><div id="viewTxtImg3"><?=$sss->content?></div></td></tr>
      
      <?
      	$mt = "";
		switch($sss->moth){
		case 1:
			$mt = "전화";
		break;
		case 2:
			$mt = "내방";
		break; 
		case 3:
			$mt = "방문";
		break;
		case 4:
			$mt = "기타 ( ".$sss->mothetc." )";
		break;
		}
	  ?>
      
      
      <tr><td class="titcell">방법</td><td><?=$mt?></td></tr>
      
	<tr><td class="titcell">견해</td><td><div id="viewTxtImg4"><?=$sss->memo?></div></td></tr>
      
      <tr><td class="titcell">상담일자</td><td><?=$sss->onday?></td></tr>
      
      <tr>
         <th></th>
        <th>대상자 정보</th>
      </tr>      
      <tr><td class="titcell">대상자이름</td><td><?=$sss->dsname?></td></tr>
      <tr><td class="titcell">생년월일</td><td><?=anzBday($sss->bday)?></td></tr>
      <tr><td class="titcell">전화번호</td><td><?=anzTel($sss->tel)?></td></tr>
      <tr><td class="titcell">휴대폰</td><td><?=anzTel($sss->htel)?></td></tr>
      <tr><td class="titcell">수급여부</td><td><?=dispSugub($sss->sugub)?></td></tr>
      <tr><td class="titcell">의료보장</td><td><?=dispBojang($sss->bojang)." (".$sss->bojangetc.")"?></td></tr>
      <tr><td class="titcell">가구수</td><td><?=$sss->gagusu?></td></tr>
      <tr><td class="titcell">가구특기사항</td><td><?=dispGagu($sss->gaguinf, $sss->gagumemo)?></td></tr>
      <tr><td class="titcell">주소</td><td><?=$sss->addr." ".$sss->addr2?></td></tr>
      <tr><td class="titcell">등록일자</td><td><?=$sss->onday?></td></tr>
      <tr><td class="titcell">약도</td><td><div style="width:98%; margin:1px 2% 1px 0; height:300px;" id="dsmap"></div></td></tr>
      </tbody>
      </table>      
      


	</div>

</div>

<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onBeforeShow.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/printThis.js"></script>


<script>
var mapObj = new coMappro("dsmap");

var imsiLat = <?=$sss->latpo?>;
var imsiLang = <?=$sss->langpo?>;

mapObj.map = null;
							
mapObj.dispMap(imsiLat, imsiLang, "위치");

function vpring(){
	$("#layer_pop_area").printThis();

}


</script>


</body>
</html>
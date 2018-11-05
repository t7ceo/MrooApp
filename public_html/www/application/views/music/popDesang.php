<?





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

</head>
<body>
  

<div class="layer_pop" style="width:100%;height:100%; padding:0 0 20px;">

	<div style="width:100%; text-align:right;"><a href="#" class="btn_gray" style="margin:9px 12px 9px 0;" onclick="vpring()"><span>출력</span></a></div>

  	<div class="layer_pop_area" id="layer_pop_area">
        
        
 
      <table class="table_list" style="margin:0;">
      <caption>자료실</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr><td colspan="2" style="padding:12px 0; text-align:center; font-size:1.4em; border-bottom:#ccc 1px solid;">대상자 상세보기</td></tr>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">대상자이름</td><td><?=$ssinfo->dsname?></td></tr>
      <tr><td class="titcell">소속업체</td><td><?=$ssinfo->conam?></td></tr>
      <tr><td class="titcell">생년월일</td><td><?=anzBday($ssinfo->bday)?></td></tr>
      <tr><td class="titcell">전화번호</td><td><?=anzTel($ssinfo->tel)?></td></tr>
      <tr><td class="titcell">휴대폰</td><td><?=anzTel($ssinfo->htel)?></td></tr>
      <tr><td class="titcell">수급여부</td><td><?=dispSugub($ssinfo->sugub)?></td></tr>
      <tr><td class="titcell">의료보장</td><td><?=dispBojang($ssinfo->bojang)." (".$ssinfo->bojangetc.")"?></td></tr>
      <tr><td class="titcell">가구수</td><td><?=$ssinfo->gagusu?></td></tr>
      <tr><td class="titcell">가구특기사항</td><td><?=dispGagu($ssinfo->gaguinf, $ssinfo->gagumemo)?></td></tr>
      <tr><td class="titcell">주소</td><td><?="( ".$ssinfo->post." ) ".$ssinfo->addr." ".$ssinfo->addr2?></td></tr>
      <tr><td class="titcell">등록일자</td><td><?=$ssinfo->onday?></td></tr>
      <tr><td class="titcell">등록자</td><td><?=$ssinfo->wrmemid?></td></tr>
      <tr><td class="titcell">약도</td><td><div style="width:98%; margin:1px 2% 1px 0; height:300px;" id="dsmap"></div></td></tr>
      </tbody>
      </table>


	</div>

</div>

<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onBeforeShow.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/printThis.js"></script>

<script>



var mapObj2 = new coMappro("dsmap");
mapObj2.map = null;

var imsiLat = <?=$ssinfo->latpo?>;
var imsiLang = <?=$ssinfo->langpo?>;




mapObj2.dispMap(imsiLat, imsiLang, "위치");


function vpring(){
	$("#layer_pop_area").printThis();

}


</script>


</body>
</html>
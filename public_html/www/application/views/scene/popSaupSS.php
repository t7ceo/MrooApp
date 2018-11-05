<?
$baseUrl = $this->session->userdata('mrbaseUrl');  //http://mroo.co.kr/

$baseUrl .= "scene/";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="stylesheet" type="text/css" href="<?=PREDIR?>templt/lib/css/admin/admin.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


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
      <caption>자료실</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr><td colspan="2" style="padding:12px 0; text-align:center; font-size:1.4em; border-bottom:#ccc 1px solid;">사업 상세보기</td></tr>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">사업명</td><td><?=$gsss->business_nm?></td></tr>
      <tr><td class="titcell">공사명</td><td><?=$gsss->gsname?></td></tr>
      
		<tr><td class="titcell">공사설명</td><td><div id="viewTxtImg3"><?=$gsss->content?></div></td></tr>
      
      <tr><td class="titcell">대상자명</td><td><?=$gsss->dsname?></td></tr>


      <tr><td class="titcell">일정</td><td><?=$gsss->start_dt." ~ ".$gsss->end_dt?></td></tr>
      
	<tr><td colspan="2" style="padding:0; border-top:#ccc 2px solid;">
    
    <?
    	//첨부파일을 출력한다.
		echo dispAllFile("hjang", $md, $md2, $baseUrl, $allfile, "view");
		
	?>
    


    
    </td></tr>      
      
      
      
      </tbody>
      </table>


	</div>

</div>

<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onBeforeShow.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/printThis.js"></script>

<script>

function vpring(){
	$("#layer_pop_area").printThis();

}

</script>


</body>
</html>
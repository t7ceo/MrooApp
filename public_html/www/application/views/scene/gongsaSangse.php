<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

/*

$si = ($mem[0]['stat'] == 2)? $si = "승인완료" : $si = "승인대기";

$cogubun = "계열사";
if($mem[0]['cogubun'] == 2) $cogubun = "조합";
else $cogubun = "본사";
*/


?>

<style>
#viewTxtImg3 img, #viewTxtImg4 img {max-width:90%; margin:0;}
#viewTxtImg3, #viewTxtImg4 {width:747px; margin:0; padding:0;}
</style>

		<div id="gaipSangseMess" class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">공사 상세보기</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->    
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>자료실</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">사업명</td><td class="alLeft"><?=$gsss->spnam?></td></tr>
      <tr><td class="titcell">공사명</td><td class="alLeft"><?=$gsss->gsname?></td></tr>

      <tr>
		<td class="titcell" colspan="2">공사설명</td>
	  </tr>
      <tr>
		<td style="text-align:left;padding-left:5px; border-bottom:#ccc 2px solid;" colspan="2"><div id="viewTxtImg3"><?=$gsss->content?></div></td>
	  </tr>



      <tr><td class="titcell">일정</td><td class="alLeft"><?=$gsss->start_dt." ~ ".$gsss->end_dt?></td></tr>
      
	<tr><td colspan="2" style="padding:0; border-top:#ccc 2px solid;">
    
     <?
    	//echo $md."/".$md2."/".count($allfile);
		
		//첨부파일을 출력한다.
		echo dispAllFile("hjang", $md, $md2, $baseUrl, $allfile, "view");
		
	?>
    
    </td></tr>
      
      </tbody>
      </table>

  </div>
  
 
  		<div style="width:755px; text-align:right;">
        
<? if(keyMan("wrman", $gsss->wmemid) or keyMan("admin", "po")){ ?>        
        <a href="#" class="btn_gray" onclick="appBasInfo.delGongsa(<?=$md?>, <?=$gsss->id?>, <?=$gsss->coid?>)"><span>삭제</span></a>
        <a href="<?=$baseUrl?>hjang/getView/2/7/<?=$gsid?>/<?=$dsid?>" class="btn_gray"><span>수정</span></a>
<? } ?>        
        
        <a href="<?=$baseUrl?>hjang/getView/2/6/<?=$gsss->coid?>" class="btn_gray"><span>목록</span></a>
        </div>


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

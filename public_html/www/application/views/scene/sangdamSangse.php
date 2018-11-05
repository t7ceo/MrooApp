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
          <li class="on"><a href="#">상담일지 상세보기</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->
      
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>상담일지 상세보기</caption>
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
      
      <tr><td class="titcell">제목</td><td class="alLeft"><?=$sss->tit?></td></tr>
     
      <tr>
		<td class="titcell" colspan="2">내용</td>
	  </tr>
      <tr>
		<td style="text-align:left;padding-left:5px; border-bottom:#ccc 2px solid;" colspan="2"><div id="viewTxtImg3"><?=$sss->content?></div></td>
	  </tr>

      
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
      
      
      <tr><td class="titcell">방법</td><td class="alLeft"><?=$mt?></td></tr>
      
     <tr>
		<td class="titcell" colspan="2">견해</td>
	  </tr>
      <tr>
		<td style="text-align:left;padding-left:5px; border-bottom:#ccc 2px solid;" colspan="2"><div id="viewTxtImg3"><?=$sss->memo?></div></td>
	  </tr>
      
      
      <tr><td class="titcell">상담일자</td><td class="alLeft"><?=$sss->onday?></td></tr>
      
      <tr>
         <th></th>
        <th>대상자 정보</th>
      </tr>      
      <tr><td class="titcell">대상자이름</td><td class="alLeft"><?=$sss->dsname?></td></tr>
      <tr><td class="titcell">생년월일</td><td class="alLeft"><?=anzBday($sss->bday)?></td></tr>
      <tr><td class="titcell">전화번호</td><td class="alLeft"><?=anzTel($sss->tel)?></td></tr>
      <tr><td class="titcell">휴대폰</td><td class="alLeft"><?=anzTel($sss->htel)?></td></tr>
      <tr><td class="titcell">수급여부</td><td class="alLeft"><?=dispSugub($sss->sugub)?></td></tr>
      <tr><td class="titcell">의료보장</td><td class="alLeft"><?=dispBojang($sss->bojang)." (".$sss->bojangetc.")"?></td></tr>
      <tr><td class="titcell">가구수</td><td class="alLeft"><?=$sss->gagusu?></td></tr>
      <tr><td class="titcell">가구특기사항</td><td class="alLeft"><?=dispGagu($sss->gaguinf, $sss->gagumemo)?></td></tr>
      <tr><td class="titcell">주소</td><td class="alLeft"><?=$sss->addr." ".$sss->addr2?></td></tr>
      <tr><td class="titcell">등록일자</td><td class="alLeft"><?=$sss->onday?></td></tr>
      <tr><td class="titcell">약도</td><td><div style="width:100%; height:300px;" id="dsmap"></div></td></tr>
      </tbody>
      </table>      
      

      


  </div>
  
  

 		<div style="width:755px; text-align:right;">
        
<? if(keyMan("wrman", $sss->wrMemid) or keyMan("admin", "po")){ ?>
        <a href="#" class="btn_gray" onclick="sddel(<?=$coid?>, <?=$sss->id?>)"><span>삭제</span></a>
        <a href="<?=$baseUrl?>hjang/getView/3/5/<?=$coid?>/<?=$sss->id?>" class="btn_gray"><span>수정</span></a>
<? } ?>
        
        <a href="<?=$baseUrl?>hjang/getView/3/1/<?=$coid?>" class="btn_gray"><span>목록</span></a>
        </div>
      

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	imsiLat = <?=$sss->latpo?>;
	imsiLang = <?=$sss->langpo?>;


function sddel(coid, id){

	if (window.confirm("상담내용을 삭제 할 까요?")) { 
	//alert(coid+"/"+id);
	
	  location.href = "<?=$baseUrl?>hjang/getView/3/4/"+coid+"/"+id;
	}

}



</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

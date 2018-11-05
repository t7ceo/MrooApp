<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($spdsList);
?>

<style>
#viewTxtImg3 img, #viewTxtImg4 img {max-width:90%; margin:0;}
#viewTxtImg3, #viewTxtImg4 {width:747px; margin:0; padding:0;}
</style>


	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li class="on"><a href="#">사업 상세보기</a></li>
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
      
      <tr><td class="titcell">사업명</td><td class="alLeft"><?=$sps->business_nm?></td></tr>
      
      <tr>
		<td class="titcell" colspan="2">사업설명</td>
	  </tr>
      <tr>
		<td style="text-align:left;padding-left:5px; border-bottom:#ccc 2px solid;" colspan="2"><div id="viewTxtImg3"><?=$sps->business_explane?></div></td>
	  </tr>
      
      <tr><td class="titcell">업체명</td><td class="alLeft"><?=$sps->conam?></td></tr>
      <tr><td class="titcell">등록자</td><td class="alLeft"><?=$sps->wrmemid." ( ".$sps->wrname?> )</td></tr>
      
      <tr><td class="titcell">일정</td><td class="alLeft"><?=$sps->start_dt."  ~  ".$sps->end_dt?></td></tr>
      
      
	<tr><td colspan="2" style="padding:0; border-top:#ccc 2px solid;">
    
    <?
    	//첨부파일을 출력한다.
		echo dispAllFile("hjang", $md, $md2, $baseUrl, $allfile, "view");
		
	?>
    
    
    </td></tr>
      
      </tbody>
      </table>

  </div>
  



      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
            
 
      
<?

	if($md4 == "all"){  //통합검색에서 호출 했다.
?>	
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/4/0/0/0" class="btn_gray"><span>목록</span></a></div>
<?	
	}else{
		
		if($md == 1) $md2 = 1;
		else if($md == 2) $md2 = 6;
		
		
?>
		<div style="width:755px; text-align:right;">
        
<? if(keyMan("admin", "po") or keyMan("wrman", $sps->wrmemid)){ ?>        
        <a href="#"  class="btn_gray" onclick="appBasInfo.delSaup(<?=$md?>,<?=$md2?>,<?=$coid?>, <?=$md4?>)"><span>삭제</span></a>
        <a href="<?=$baseUrl?>hjang/getView/1/2/<?=$coid?>/<?=$md4?>"  class="btn_gray"><span>수정</span></a>
<? } ?>
        
        <a href="<?=$baseUrl?>hjang/getView/<?=$md?>/<?=$md2?>/<?=$coid?>/0/0/<?=$page?>" class="btn_gray"><span>목록</span></a>

        
        </div>
        
<? } ?>        


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

	var cc = document.getElementById("viewTxtImg3");
	var ii = cc.getElementsByTagName("img");
	//alert(ii.length+"/"+ii[0].src);
	//$(ii[0]).remove();
	


</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

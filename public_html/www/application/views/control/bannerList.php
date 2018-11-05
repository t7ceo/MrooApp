<?php
//미가입회원관리

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);


//echo getDBTable($md, $md2, $md3);

$su = $totalCount;
?>





		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
				if($ii > 1) break;
			$oninf = ($ii == ($md3 - 1))? "class='on'" : "" ;
		?>
          <li <?=$oninf?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
				$ii++;
			} 
		?>          
        </ul>
      </div>
      <!-- //tab -->
      

      
      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">총 게시판수 <strong><?=$totalCount?></strong> 개</p>
      <div class="srch">
      

      </div>
      <table class="table_list">
      <caption>게시판 리스트</caption>
      <colgroup>
      <col width="6%">
      <col width="10%">
      <col width="22%">
      <col width="20%">
      <col width="20%">
      <col width="7%">
      <col width="15%">
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>구분</th>
        <th>배너</th>
        <th>시작일시</th>
        <th>종료일시</th>
        <th>노출여부</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
		<tr><td colspan="7">등록된 배너가 없습니다.</td></tr>

<?   }else{
	
	$num = ($page * ($ppn / $ppn));
	
	$c = 1;
	$i = 1;
	foreach($banner as $rows){   
		
?> 

	<tr id="tr-<?=$rows->id?>">
    <td><?=($c + $num++)?></td>
    <td><?=$rows->gubun?></td>
    <td><img src='<?=$this->session->userdata("bannerImgPath").$rows->img?>' width="100%" /></td>
    <td><?=$rows->stday?></td>
    <td><?=$rows->endday?></td>
    <td><?=($rows->oninf == 1)? '노출' : '종료';?></td>
    <td>
        <a href="#" class="btn" onclick="appBasInfo.delFileGo('banner', <?=$md?>, <?=$md2?>, <?=$md3?>, <?=$rows->id?>, <?=$i?>)"><span>삭제</span></a>
        <a href="<?=$wrlink?>/4/<?=$rows->id?>" class="btn"><span>수정</span></a>
    </td>
    </tr>

      
<? 
	$i++;
} } ?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
 
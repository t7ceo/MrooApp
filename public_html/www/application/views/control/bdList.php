<?php
//미가입회원관리

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);


//echo $this->session->userdata('myMenu');
$su = count($totalCount);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
			$oninf = ($ii == ($md2 - 1))? "class='on'" : "" ;
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
      <p class="total">총 게시판수 <strong><?=$su?></strong> 개</p>
      <div class="srch">
      

      </div>
      <table class="table_list">
      <caption>게시판 리스트</caption>
      <colgroup>
      <col width="6%">
      <col width="22%">
      <col width="57%">
      <col width="15%">
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>게시판 이름</th>
        <th>게시판 노출설정</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
		<tr><td colspan="4">생성된 게시판이 없습니다.</td></tr>

<?   }else{
	
	$num = ($page * ($ppn / $ppn));
	
	$c = 1;
	foreach($banner as $rows){   
		//$c++;
		
		$wrpo = "읽기/쓰기 (  )";
		//$rdpo = "읽기 ( ".getCogubun($rows->cogubunR)."-".potiontojigwiP($rows->rdpo)." 이상 )";

		//$push = "푸쉬발송 - 발송";
		//if($rows->pushinf == 1) $push = "푸쉬발송 - 미발송"; 
		
?> 

	<tr id="tr-<?=$rows->id?>"><td><?=($c + $num++)?></td><td><?=$rows->bdtit?></td><td><?=$wrpo?></td>
    <td><a href="#" class="btn" onclick="meminf.anzBd(<?=$rows->id?>, 'del')"><span>삭제</span></a><a href="<?=$baseUrl?>control/getView/3/<?=$rows->id?>" class="btn"><span>수정</span></a></td></tr>

      
      
<? } } ?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

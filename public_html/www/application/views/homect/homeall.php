<?php
//전체회원관리
	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

/*
$baseUrl = $seMenu['sub'][($md-1)]['url'];
$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
*/

$golink = "http://mroo.co.kr/";


$su1 = count($migaip);

$su3 = count($chadan);

$newMusicsu = count($newMusic);

$qnasu = $totalCount3;

$ingiMusic = count($ingiMusic);

$chucheonsu = count($chucheon);

?>


<style>
table.table_list tr td.noniterList{
	padding:8px auto;
}
table.table_list tr td.noniterList i.fas{
	font-size:4em;
}

</style>


      <!-------------------------------------------------------------------->
      
            <!-- list -->
 
      
      <table class="table_list">
      <caption>aaa</caption>
      <colgroup>
      <col width="50%">
      <col width="50%">
      </colgroup>
      <thead>
      <tr>
        <th>Infomation</th>
      </tr>
      </thead>
      <tbody>
      
<? 
if($su1 < 1){
?>	
	<tr class="noniterList"><td>등록된 정보가 없습니다.</td></tr>
	
<? }else{ 
	
	$indx = 1;
	$th = array("모니터링", "공지사항", "설치요청내역", "A/S접수내역", "신규콘텐츠", "신규질문");
	$thicon = array("fa-desktop", "fa-bullhorn", "fa-dolly-flatbed", "fa-shipping-fast", "fa-video", "fa-comments");
	$td = array(array("fa-code-branch fa-spin", "fa-ban", "fa-crosshairs"), array("fa-sync", ""), array("fa-sync", ""), array("fa-sync", ""), array("fa-sync", ""), array("fa-sync", ""));
	

		
?>
 
<!---첫번째 라인---------------------->
      
      <tr class="noniterList">
        <td class="td1">

            <div class="divAllWidth">
        
            
                <p><i class="fab fa-qq"></i>&nbsp;&nbsp;&nbsp;신규회원</p>
                
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="17%">
              <col width="52%">
              <col width="30%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>이름</th>
                <th>등록일</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($su1 < 1){
        ?>		
            
                <tr><td colspan="3">등록된 신규회원이 없습니다.</td></tr>
        
        <?   }else{
            
 
        	$num = 1;
            foreach($migaip as $rows){   
            	
        ?>   
              <tr>
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows->name." (".$rows->memid.")"?></a></td>
                <td><?=$rows->onday?></td>
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
            </div>
    

        
            <div class="divAllWidth">
            
                <p><i class="fas fa-address-book"></i>&nbsp;&nbsp;&nbsp;신고회원</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="17%">
              <col width="30%">
              <col width="30%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>피신고인</th>
               	<th>신고인</th>
                <th>등록일</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($su3 < 1){
        ?>		
            
                <tr><td colspan="4">등록된 신고회원이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
            $num = 1;
            foreach($singo as $rows3){   
            
        ?>   
              <tr>
                
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->PiSingo?></a></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->wrSingo?></a></td>
                <td><?=$rows3->onday?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>


           <div class="divAllWidth">
            
                <p><i class="fab fa-drupal"></i>&nbsp;&nbsp;&nbsp;차단회원</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>이름</th>
                <th>등록일</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($su3 < 1){
        ?>		
            
                <tr><td colspan="3">등록된 차단회원이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
               
			$num = 0;
            foreach($chadan as $rows3){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->name?></a></td>
                <td><?=$rows3->onday?></td>
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>



        
        </td>
      </tr>
      
<!---두번째 라인---------------------->
      
      <tr class="noniterList">
        <td class="td2">

            <div class="divAllWidth">
        
            
                <p><i class="far fa-clone"></i>&nbsp;&nbsp;&nbsp;신규음원</p>
                
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>가수</th>
                <th>세대구분</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($newMusicsu < 1){
        ?>		
            
                <tr><td colspan="4">등록된 신규음원이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
        	$num = 1;
            foreach($newMusic as $rows){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>

                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows->tit?></a></td>
                <td><?=$rows->gasu?></td>
                <td><?=$rows->sede?></td>
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
            </div>
    

        
            <div class="divAllWidth">
            
                <p><i class="fas fa-boxes"></i>&nbsp;&nbsp;&nbsp;인기곡</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>가수</th>
                <th>Hit</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($ingiMusic < 1){
        ?>		
            
                <tr><td colspan="4">인기뮤직 자료가 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
            $num = 1;
            foreach($qna as $rows3){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>

                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->tit?></a></td>
                <td><?=$rows3->gasu?></td>
          		<td><?=$rows3->hit?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>


           <div class="divAllWidth">
            
                <p><i class="fas fa-hand-point-left"></i>&nbsp;&nbsp;&nbsp;추천 MR</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>가수</th>
                <th>등록일</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($chucheonsu < 1){
        ?>		
            
                <tr><td colspan="4">추천MR이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
            $num = 1;
            foreach($chucheon as $rows3){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->tit?></a></td>
                <td><?=$rows3->onday?></td>
                
                <td><?
                
                if($md == 1){
                    echo $rows3->wrMemid." ( ".$rows3->name." )";
                }
                
                ?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>



        
        </td>
      </tr>
      


<!---세번째 라인---------------------->
      
      <tr class="noniterList">
        <td class="td3">


           <div class="divAllWidth">
            
                <p><i class="far fa-play-circle"></i>&nbsp;&nbsp;&nbsp;노래자랑</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>등록일</th>
                <th>등록자</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($su3 < 1){
        ?>		
            
                <tr><td colspan="4">등록된 노래자랑이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
            $num = 1;
            foreach($qna as $rows3){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->tit?></a></td>
                <td><?=$rows3->onday?></td>
                
                <td><?
                
                if($md == 1){
                    echo $rows3->wrMemid." ( ".$rows3->name." )";
                }
                
                ?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>
            


            <div class="divAllWidth">
        
            
                <p><i class="fas fa-bullhorn"></i>&nbsp;&nbsp;&nbsp;공지사항</p>
                
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>등록일</th>
                <th>등록자</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($su1 < 1){
        ?>		
            
                <tr><td colspan="4">등록된 공지사항이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
        
            foreach($allbd as $rows){   
            
        ?>   
              <tr>
                
        <?if($rows->gongji == 'Y'){?>
                <td>공지</td>
        <?}else{?>
                <td><?=($su1 - $num++)?></td>
        <?}?>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows->tit?></a></td>
                <td><?=$rows->onday?></td>
                
                <td><?
                
                if($md == 1){
                    echo $rows->wrMemid." ( ".$rows->name." )";
                }
                
                ?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
            </div>
    

        
            <div class="divAllWidth">
            
                <p><i class="fas fa-comments"></i>&nbsp;&nbsp;&nbsp;질문</p>
        
              <table class="table_list3">
              <caption>본사 공지사항</caption>
              <colgroup>
              <col width="15%">
              <col width="42%">
              <col width="20%">
              <col width="22%">
              </colgroup>
              <thead>
              <tr>
                <th>순번</th>
                <th>제목</th>
                <th>등록일</th>
                <th>등록자</th>
              </tr>
              </thead>
              <tbody>
              
        <? 
            if($qnasu < 1){
        ?>		
            
                <tr><td colspan="4">등록된 질문이 없습니다.</td></tr>
        
        <?   }else{
            
            //$c = 0;
            
            $num = 1;
            foreach($qna as $rows3){   
            
        ?>   
              <tr>
                <td><?=($num++)?></td>
                <td style="text-align:left;padding-left:5px;"><a href="<?=$baseUrlRoot."/3/".$rows->id."/".$md4?>"><?=$rows3->tit?></a></td>
                <td><?=$rows3->onday?></td>
                
                <td><?
                
                if($md == 1){
                    echo $rows3->wrMemid." ( ".$rows3->wrMemid." )";
                }
                
                ?></td>
                
              </tr>
        <? } }?>      
              
              
        
              
              </tbody>
              </table>
        
        
            </div>


        
        </td>
      </tr>

      
<? } ?>      
      
      </tbody>
      </table>


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


</script>    
      
 
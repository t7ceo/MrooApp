<?php
//메시지 리스트
//$baseUrl = $this->session->userdata('mrbaseUrl');
//$baseUrl .= "notice/";

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);


$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

if($allmess == 0) $su = 0;
else $su = count($allmess);
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
      <p class="total">메시지 건수 <strong><?=$su?></strong> 건 </p>
      <div class="srch">
      
      <select id="selectMdmess">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>제목</option>
      <option value="content" <?=($this->session->userdata("findMd") == "content")? "selected='selected'":""?>>제목+내용</option>
      </select>
      
      
        <input type="text" id="messFindTxt" value="<?=$this->session->userdata("find")?>" name="messFindTxt"/>
        <p><a href="#" class="btn" id="messFind"><span>검색</span></a></p>
      </div>
      <table class="table_list">
      <caption>발송한 메시지 리스트</caption>
      <colgroup>
      <col width="10%">
      <col width="45%">
      <col width="15%">
      <col width="15%">
      <col width="15%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>발송자</th>
        <th>일시</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="5">전송된 메시지가 없습니다.</td></tr>

<?   }else{

		$num = ($page * ($ppn / $ppn));
	for($a=0; $a < $su; $a++){   
	

	
?>   
      <tr>
		<td><?=($su - $num++)?></td><td><a href="#" class="messView" id="<?=$allmess[$a]['id']?>"><?=$allmess[$a]['tit']?></a></td><td><?=$allmess[$a]['wr']?></td><td><?=$allmess[$a]['day']?></td><td><a href="#" class="btn" onclick="meminf.delNotice(<?=$allmess[$a]['id']?>, 'mess')"><span>삭제</span></a></td>
      </tr>
<? } }?>      
      
      </tbody>
      </table>

<? if(keyMan("admin", "po") or keyMan("johap", 0)){ ?>	
		<div style="width:755px; text-align:right;"><a href="<?=$wrlink?>/2" class="btn_gray"><span>메시지 전송</span></a></div>
<? } ?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

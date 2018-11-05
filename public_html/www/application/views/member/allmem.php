<?php
//전체회원관리
$baseUrl = $seMenu['sub'][($md-1)]['url'];
$tabmenu = $seMenu['sub'][($md-1)]['sub2'];

$su = count($allMem);
$misu = count($migaipMem);
$chasu = count($chadanMem);
?>



		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <!--
      <div class="tab">
        <ul>
        
        <? foreach($tabmenu as $rowtab){ ?>
        
          <li class="on"><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
          
        <? } ?>  
          
        </ul>
      </div>
      -->
      <!-- //tab -->
      

      
      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">총 회원수 <strong><?=$su?></strong> 명</p>
      <div class="srch">
      
              <select id="memgubun" name="memgubun" onchange="meminf.chnSelect(this, 2)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA){ 
	  		$seinf = "";
			if($md3 == 0) $seinf = "selected = 'selected'";
	  ?>
      			<option value="0">전체회원</option>
    <?
			$seinf = "";
	
	  }
	  foreach($allco as $rowco){
		  if($md3 == $rowco->id) $seinf = "selected = 'selected'";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
			$seinf = "";
	  }
	  ?>
             </select>
      
      
      <select id="selectMd">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="name" <?=($this->session->userdata("findMd") == "name")? "selected='selected'":""?>>이름</option>
      <option value="tel" <?=($this->session->userdata("findMd") == "tel")? "selected='selected'":""?>>전화번호</option>
      </select>
      
      
        <input type="text" id="gaipFindTxt" value="<?=$this->session->userdata("find")?>" name="gaipFindTxt"/>
        <p><a href="#" class="btn" id="gaipFind"><span>검색</span></a></p>
      </div>
      
<table class="table_list2">
<tr><td class="memlist">

	<div class="divAllWidth">

<p>가입회원 : <?=$su?> 명</p>
      <table class="table_list3">
      <caption>aaa</caption>
      <colgroup>
      <col width="10%">
      <col width="13%">
      <col width="19%">
      <col width="10%">
      <col width="21%">
      <col width="9%">
      <col width="18%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>이름</th>
        <th>전화번호</th>
        <th>직책</th>
        <th>업체명</th>
        <th>등록일</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
if($su < 1){
?>	
	<tr><td colspan="7">등록된 회원데이터가 없습니다.</td></tr>
	
<? }else{ 


	$num = 0; //($page * ($ppn / $ppn));
	
	foreach($allMem as $rows){   
	
?>   
      <tr id="tr-<?=$rows->id?>">
        <td><?=($su - $num++)?></td>
        <td><a href="#" id="<?="ga-".$rows->id?>" class="desangList"><?=$rows->name?></a></td>
        <td><?=anzTel(base64decode($rows->tel))?></td>
        <td class="tdpotion">
        <?=potiontojigwiP($rows->potion)?>
        </td>
        <td>
		<? 
			if($rows->cogubun == 2 ||  $rows->cogubun == 3){
				echo "-";
			}else{
				echo $rows->coname;		
			}
		?>
        </td>
        <td><?=$rows->onday?></td>
        <td>
        <?
		if($rows->memid == $this->session->userdata('memid')){
		?>
        본인
        <? }else{ ?>
        <a href="#" class="btn" onclick="meminf.delMem(<?=$rows->id?>, 'del', <?=$rows->potion?>, 0)"><span>삭제</span></a><a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'chadan', <?=$rows->potion?>, 0)" class="btn"><span>차단</span></a><!--<a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'onrt')" class="btn"><span>가입취소</span></a>-->
        <? } ?>
        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

    </div>

<!-------------------------->

	<div class="divAllWidth">

<p>미가입회원 : <?=$misu?> 명</p>

      <table class="table_list3">
      <caption>aaa</caption>
      <colgroup>
      <col width="10%">
      <col width="13%">
      <col width="19%">
      <col width="10%">
      <col width="21%">
      <col width="9%">
      <col width="18%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>이름</th>
        <th>전화번호</th>
        <th>직책</th>
        <th>업체명</th>
        <th>등록일</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
if($misu < 1){
?>	
	<tr><td colspan="7">등록된 회원데이터가 없습니다.</td></tr>
	
<? }else{ 


	$num = 0; //($page * ($ppn / $ppn));
	
	foreach($migaipMem as $rows){   
	
?>   
      <tr id="tr-<?=$rows->id?>">
        <td><?=($su - $num++)?></td>
        <td><a href="#" id="<?="ga-".$rows->id?>" class="desangList"><?=$rows->name?></a></td>
        <td><?=anzTel(base64decode($rows->tel))?></td>
        <td class="tdpotion">
        <?=potiontojigwiP($rows->potion)?>
        </td>
        <td>
		<? 
			if($rows->cogubun == 2 ||  $rows->cogubun == 3){
				echo "-";
			}else{
				echo $rows->coname;		
			}
		?>
        </td>
        <td><?=$rows->onday?></td>
        <td>
        <?
		if($rows->memid == $this->session->userdata('memid')){
		?>
        본인
        <? }else{ ?>
        <a href="#" class="btn" onclick="meminf.delMem(<?=$rows->id?>, 'del', <?=$rows->potion?>, 0)"><span>삭제</span></a><a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'chadan', <?=$rows->potion?>, 0)" class="btn"><span>차단</span></a><!--<a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'onrt')" class="btn"><span>가입취소</span></a>-->
        <? } ?>
        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

    </div>


<!-------------------------->

	<div class="divAllWidth">


<p>삭제회원 : <?=$chasu?> 명</p>
      <table class="table_list3">
      <caption>aaa</caption>
      <colgroup>
      <col width="10%">
      <col width="13%">
      <col width="19%">
      <col width="10%">
      <col width="21%">
      <col width="9%">
      <col width="18%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>이름</th>
        <th>전화번호</th>
        <th>직책</th>
        <th>업체명</th>
        <th>등록일</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
if($chasu < 1){
?>	
	<tr><td colspan="7">등록된 회원데이터가 없습니다.</td></tr>
	
<? }else{ 


	$num = 0; //($page * ($ppn / $ppn));
	
	foreach($chadanMem as $rows){   
	
?>   
      <tr id="tr-<?=$rows->id?>">
        <td><?=($su - $num++)?></td>
        <td><a href="#" id="<?="ga-".$rows->id?>" class="desangList"><?=$rows->name?></a></td>
        <td><?=anzTel(base64decode($rows->tel))?></td>
        <td class="tdpotion">
        <?=potiontojigwiP($rows->potion)?>
        </td>
        <td><?=$rows->onday?></td>
        <td>
        <?
		if($rows->memid == $this->session->userdata('memid')){
		?>
        본인
        <? }else{ ?>
        <a href="#" class="btn" onclick="meminf.delMem(<?=$rows->id?>, 'del', <?=$rows->potion?>, 0)"><span>삭제</span></a><a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'chadan', <?=$rows->potion?>, 0)" class="btn"><span>차단</span></a><!--<a href="#" onclick="meminf.delMem(<?=$rows->id?>, 'onrt')" class="btn"><span>가입취소</span></a>-->
        <? } ?>
        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

    </div>


</td></tr>
</table>      
      
	  <div class="paging"><?=$this->pagination->create_links();?></div>


<a href="#" class="adminAdd">ㅁㅁㅁㅁㅁ</a>


<!------레이어 팝업------------------>
		<div class="mask"></div>
       	<div class="windowAddAdmin windowClose windowStyle" style="width:400px;">
        	<ul class="btton1Head"><li>설치요청 상세보기</li><li><a href="#" class="close">닫기</a></li></ul>


  <div id="view_deviceCall" class="join_mem finder_div" style="position:relative; margin:60px auto 0; height:auto; border:none; display:block;">
    
 
        <table class="onputPage">
        <tr><th style="width:100px;"><span>제목</span></th><td style="width:250px;">
            <input type="text" name="tit" value="" disabled/>
        </td><td rowspan="7" style="width:50%;">
        	<img src="" id="devImg" style="width:90%;" />
        </td></tr>
        <tr><th><span>내용</span></th><td style="width:250px;">
			<textarea name="content"></textarea>
        </td></tr>
        <tr><th><span>처리메모</span></th><td style="width:250px;">
			<textarea name="memo"></textarea>
        </td></tr>
        <tr><th><span>대상장비</span></th><td style="width:250px;">
			<input type="text" name="devGb" value="" disabled/>
        </td></tr>
        <tr><th><span>요청자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="mejang" value="" disabled/>
        </td></tr>
        <tr><th><span>담당자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="gisa" value="" />
        </td></tr>
        <tr><th><span>상태</span></th><td style="width:250px;">
			<input type="text" name="stat" value="" />
        </td></tr>     
    	</table>
   
        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org adminAddgo"><span>확인</span></a>
        <a href="#" class="btn_gray close"><span>닫기</span></a>
        </p>
        

  </div>
        
 
        </div>
<!------레이어 팝업 종료--------------->


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


		
		
		//관리자 추가를 클릭시 작동하며 검은 마스크 배경과 레이어 팝업을 띄웁니다.
		$('.adminAdd').click(function(e){
            // preventDefault는 href의 링크 기본 행동을 막는 기능입니다.
            e.preventDefault();
			nowRecId = this.id;
			
				
			//var frm = document.getElementById("deviceCall");
			var aj = 'menu=getDeviceCall&callid='+nowRecId;
			realAjax("getDeviceCall", aj, "mu");
			
			
			$('.windowAddAdmin').css({'width':'700px','height':'500px'});
			
            wrapWindowByMask('.windowAddAdmin');
        });
		
		
		$('.adminAddgo').click(function(e){
			
			/*
			var frmA = document.getElementById("frmAdminOn");
			
			if(frmA.actgubun.value == 0){
				alert("권한을 선택하세요.");
				return false;
			}
			
			
			try {
				frmA.submit();
			} catch(e) {
				//alert("errrr"+e);
			}
			*/
		
		});
		
				

</script>    
      
 
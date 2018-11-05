<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "member/";




//echo $this->session->userdata('myMenu');
$su = count($totalCount);
?>



		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">가입회원관리</a></li>
        </ul>
      </div>
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
      <table class="table_list">
      <caption>가입회원관리</caption>
      <colgroup>
      <col width="6%">
      <col width="10%">
      <col width="7%">
      <col width="13%">
      <col width="6%">
      <col width="10%">
      <col width="21%">
      <col width="9%">
      <col width="18%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>전화번호</th>
        <th>구분</th>
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
	<tr><td colspan="9">등록된 회원데이터가 없습니다.</td></tr>
	
<? }else{ 


	$num = ($page * ($ppn / $ppn));
	
	foreach($gaip as $rows){   
	
?>   
      <tr id="tr-<?=$rows->id?>">
        <td><?=($su - $num++)?></td>
        <td><a href="#" id="<?="ga-".$rows->id?>" class="desangList"><?=$rows->memid?></a></td>
        <td><?=$rows->name?></td>
        <td><?=anzTel(base64decode($rows->tel))?></td>
        <td><?

			echo disp_cogubun($rows->cogubun);
		
		?></td>
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

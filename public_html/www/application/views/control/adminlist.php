<?php
//전체회원관리
$baseUrl = $seMenu['sub'][($md-1)]['url'];
$tabmenu = $seMenu['sub'][($md-1)]['sub2'];

$su = count($allmem);
?>



		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>


      <!-- tab -->
      <div class="tab">
        <ul>
        
        <? 
		$i = 1;
		foreach($tabmenu as $rowtab){ ?>
          <li <?=($i == $md3)? 'class="on"' : '';?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
			$i++;
		} ?>  
          
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
      <caption>aaa</caption>
      <colgroup>
      <col width="6%">
      <col width="13%">
      <col width="10%">
      <col width="13%">
      <col width="8%">
      <col width="8%">
      <col width="20%">
      <col width="9%">
      <col width="13%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>전화번호</th>
        <th>부서</th>
        <th>직책</th>
        <th>권한</th>
        <th>등록일</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
if($su < 1){
?>	
	<tr><td colspan="9">등록된 관리자 데이터가 없습니다.</td></tr>
	
<? }else{ 


	$num = 0; //($page * ($ppn / $ppn));
	
	foreach($allmem as $rows){   
	
?>   
      <tr id="tr-<?=$rows->id?>">
        <td><?=($su - $num++)?></td>
        <td><a href="#" id="<?="ga-".$rows->id?>" class="desangList"><?=$rows->memid?></a></td>
        <td><?=$rows->name?></td>
        <td><?=anzTel(base64decode($rows->tel))?></td>
        <td class="tdpotion">
        <?=$rows->buseo?>
        </td>
        <td>
		<? 
			echo $rows->jigcheg;		
		?>
        </td>
        <td><?=getArrayFieldGab("adminGubun", $rows->actgubun)?></td>
        <td><?=$rows->actonday?></td>
        <td>
        
        	<a href="#" id="<?=$rows->actid?>" class="btn adminDel"><span>삭제</span></a>
		<!--
        <a href="#" id="<?=$rows->id?>" class="btn adminDel"><span>삭제</span></a>
        <a href="#" id="<?=$rows->memid?>" class="btn adminAdd"><span>추가</span></a>
        -->
        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>


<script>

$(document).ready(function(e) {
	
	
		//관리자 추가를 클릭시 작동하며 검은 마스크 배경과 레이어 팝업을 띄웁니다.
		$('.adminAdd').click(function(e){
            // preventDefault는 href의 링크 기본 행동을 막는 기능입니다.
            e.preventDefault();
			nowRecId = this.id;
			
			var frm = document.getElementById("frmAdminOn");
			var aj = 'menu=control&memid='+nowRecId;
			realAjax("adminOn", aj, frm);
			
			
			$('.windowAddAdmin').css({'width':'400px','height':'470px'});
			
            wrapWindowByMask('.windowAddAdmin');
        });
		
		
		$('.adminAddgo').click(function(e){
			
			var frmA = document.getElementById("frmAdminOn");
			try {
				frmA.submit();
			} catch(e) {
				//alert("errrr"+e);
			}
		
		});
		
		
	
});



	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
 
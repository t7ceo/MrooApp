<?php
//전체회원관리
$baseUrl = $seMenu['sub'][($md-1)]['url'];
$tabmenu = $seMenu['sub'][($md-1)]['sub2'];


$baseUrl0 = $this->session->userdata('mrbaseUrl');

$su = count($allmem);

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
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
      <col width="19%">
      <col width="13%">
      <col width="10%">
      <col width="10%">
      <col width="15%">
      <col width="14%">
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
        <th>권한 상태</th>
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
        <td><?=$rows->adminsu?></td>
        <td>

        <a href="#" id="<?=$rows->memid?>" class="btn adminAdd"><span>추가</span></a>

        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>



<!------레이어 팝업------------------>
		<div class="mask"></div>
       	<div class="windowAddAdmin windowClose windowStyle">
        	<ul class="btton1Head"><li>관리자 추가</li><li><a href="#" class="close">닫기</a></li></ul>


  <div id="join_mem" class="join_mem finder_div" style="position:relative; margin:60px auto 0; height:auto; border:none; display:block;">
    
    	<form name="frmAdminOn" id="frmAdminOn" action="<?=$baseUrl0?>control/control/adminOn" method="POST">
        <input type="hidden" name= "ci_t" value="<?=$cihs?>">
        <input type="hidden" name= "id" value="">
        <input type="hidden" name= "memid" value="">

        <table class="onputPage">
        <tr><th><span>사용자 ID</span></th><td>
            <input type="text" name="memid" value="" disabled/>
        </td></tr>
        <tr><th><span>사용자명</span></th><td>
			<input type="text" name="name" value="" />
        </td></tr>
        <tr><th><span>전화번호</span></th><td>
			<input type="tel" name="tel" value="" disabled/>
        </td></tr>
        <tr><th><span>이메일</span></th><td>
			<input type="email" name="email" value="" disabled/>
        </td></tr>
        <tr><th><span>부서</span></th><td>
			<input type="text" name="buseo" value="" />
        </td></tr>
        <tr><th><span>직책</span></th><td>
			<input type="text" name="jigcheg" value="" />
        </td></tr>
        <tr><th><span>권한</span></th><td>
        	<select name="actgubun">
            <?=getAdminGubunAllDisp()?>
            </select>
        </td></tr>
    	</table>
   
        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org adminAddgo"><span>관리자 추가</span></a>
        <a href="#" class="btn_gray close"><span>닫기</span></a>
        </p>
        
 
				</form>
  </div>
        
 
        </div>
<!------레이어 팝업 종료--------------->


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
			
			if(frmA.actgubun.value == 0){
				alert("권한을 선택하세요.");
				return false;
			}
			
			
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
      
 
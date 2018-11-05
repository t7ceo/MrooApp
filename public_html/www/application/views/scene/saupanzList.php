<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

//if($coid == 0) $coid= 51; //$this->session->userdata('secoid');

$su = $totalCount; //count($gaip);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="<?=$baseUrl?>hjang/getView/1/1">사업 리스트</a></li>
        </ul>
      </div>
      <!-- //tab -->
        
  
      <!-------------------------------------------------------------------->
 
            <!-- list -->
      <p class="total">총 건수 <strong><?=$su?></strong> 건</p>

      <div class="srch">
      
            <select id="sauList" name="sauList" onchange="meminf.chnSelect(this, 1)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA or $this->session->userdata('cogubun') == JOHAPG){ 

	  ?>
      		<option value="0" <?=($coid == 0)? "selected = 'selected'":""?>>전체</option>
    <?
	
	  }
	  foreach($allco as $rowco){
		  if($rowco->id == $coid) $seinf = "selected = 'selected'";
		  else $seinf = "";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	  }
	  ?>
             </select>
      
      
      <select id="selectMdsaup">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="saupnam" <?=($this->session->userdata("findMd") == "saupnam")? "selected='selected'":""?>>사업명</option>
      <option value="nammemo" <?=($this->session->userdata("findMd") == "nammemo")? "selected='selected'":""?>>사업명+내용</option>
      </select>      
      
      
        <input type="text" id="saupFindTxt" name="saupFindTxt" value="<?=$this->session->userdata("find")?>" />
        <p><a href="#" class="btn" id="saupFind"><span>검색</span></a></p>
      </div>



      <table class="table_list">
      <caption>사업관리</caption>
      <colgroup>
      <col width="11%">
      <col width="16%">
      <col width="33%">
      <col width="10%">
      <col width="12%">
      <col width="18%">
      <!--<col width="12%">-->
      </colgroup>
      <thead>
      <tr>
        <th>번호</th>
        <th>업체명</th>
        <th>사업명</th>
        <th>대상자수</th>
        <th>등록일</th>
        <th>등록자</th>
        <!--<th>처리</th>-->
      </tr>
      </thead>
      <tbody>
     
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="6">등록된 사업이 없습니다.</td></tr>

<?   }else{
	

	$c = 0;
	
		$num = ($page * ($ppn / $ppn));
	foreach($list as $rows){   

	
		if(!$rows->dssu) $rows->dssu = 0;
?>   
      <tr>
		<td><?=($su - $num++)?></td>
        <td><?=$rows->coname?></td>
		<td><a href="<?=$baseUrl?>hjang/getView/1/3/<?=$coid?>/<?=$rows->id?>/0/<?=$page?>"><?=$rows->business_nm?></a></td>
		<td><?=$rows->dssu?></td>
		<td><?=$rows->onday?></td>
        <td><?=$rows->wrmemid?><br  />( <?=$rows->wrname?> )</td>
        
      </tr>
<? } } ?>      
      
      
      </tbody>
      </table>
		<div class="paging"><?=$this->pagination->create_links();?></div>

<? 
if(keyMan("admin", "po")){ ?>		
        <div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/1/2/<?=$this->session->userdata('coid')?>/0" class="btn_gray"><span>사업등록</span></a></div>
<? } ?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


	$(document).ready(function($){
		var coid = <?=$coid?>;
		meminf.memSeCoId = coid;
		if(coid==0){
			var obj = document.getElementById("sauList");
			//console.log("documentid="+obj.id+"/coid="+coid);
			//meminf.memSeCoId = coid;
			//meminf.chnSelect(obj, 1);
		}
		
		$("#sauList").val(coid).attr("selected", "selected");
		
		
	});


</script>    
      
      
            <!-- botton -->
      
      <!--<a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

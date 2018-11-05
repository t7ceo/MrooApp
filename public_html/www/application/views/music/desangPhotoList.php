<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;
?>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li><a href="<?=$baseUrl?>hjang/getView/2/1/0/0/0--n">대상자정보 관리</a></li>
          <li><a href="<?=$baseUrl?>hjang/getView/2/6/0/0/0--n">대상자별 공사관리</a></li>
          <li class="on"><a href="#">대상자별 사진대장</a></li>
        </ul>
      </div>
      <!-- //tab -->
      


      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">총 공사 <strong><?=$su?></strong> 건 </p>
      <div class="srch">
      
	<select id="dsConame" name="dsConame" onchange="meminf.chnSelect(this, 5)">
      <?  
	  if($this->session->userdata('cogubun') == BONSA or $this->session->userdata('cogubun') == JOHAPG){ 
			if($secoid == 0) $seinf = "selected = 'selected'";
			else $seinf = "";
	  ?>
      			<option value="0">전체</option>
    <?

	
	  }
	  foreach($allco as $rowco){
		  if($secoid == $rowco->id) $seinf = "selected = 'selected'";
		  else $seinf = "";
		  
	?>
        <option value="<?=$rowco->id?>" <?=$seinf?>><?=$rowco->coname?></option>
	<? 
	
	  }
	  ?>
      </select>
      
      
      <select id="selectMdpt">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="desang" <?=($this->session->userdata("findMd") == "desang")? "selected='selected'":""?>>대상자명</option>
      <option value="gongsa" <?=($this->session->userdata("findMd") == "gongsa")? "selected='selected'":""?>>공사명</option>
      <option value="ptcontent" <?=($this->session->userdata("findMd") == "ptcontent")? "selected='selected'":""?>>대상자+공사명</option>
      </select>
      
      
      
        <input type="text" id="ptFindTxt" value="<?=$this->session->userdata("find")?>" name="ptFindTxt"/>
        <p><a href="#" class="btn" id="ptFind"><span>검색</span></a></p>
      </div>


      <table class="table_list">
      <caption>대상자관리</caption>
      <colgroup>
      <col width="8%">
      <col width="10%">
      <col width="20%">
      <col width="25%">
      <col width="10%">
      <col width="27%">
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>대상자명</th>
        <th>사업명</th>
        <th>공사명</th>
        <th>업체명</th>
        <th>사진</th>
      </tr>
      </thead>
      <tbody>

<? 
	if($su < 1){
?>		
	
		<tr><td colspan="6">등록된 데이터가 없습니다.</td></tr>

<?   }else{
	
		$num = ($page * ($ppn / $ppn));
	foreach($gslist as $gsrow){   
		

	
?>   
      <tr>
		<td><?=($su - $num++)?></td>
		<td><?=$gsrow->dsname?></td>
		<td><?=$gsrow->saupnam?></td>
		<td><?=$gsrow->gsname?></td><td>
        
        <?=$gsrow->coname;
			/*
			if($gsrow->dange == 1) echo "전";
		   	else if($gsrow->dange == 2) echo "중";
		   	else echo "후";
			*/
        ?>
        </td><td>
        <a href="<?=$baseUrl?>hjang/getView/2/8/<?=$gsrow->coid?>/<?=$gsrow->id?>" class="btn"><span>사진보기</span></a>
        
     <? if(keyMan("sawon","po")){ ?>
        
        <a href="<?=$baseUrl?>hjang/getView/5/0/<?=$gsrow->coid?>/<?=$gsrow->id?>/<?=$gsrow->dange?>" class="btn"><span>사진등록</span></a>
     
     <? } ?>    
        
        </td>
      </tr>
<? } }?>      
      
      </tbody>
      </table>

	  <div class="paging"><?=$this->pagination->create_links();?></div>
      
      
<?
if(keyMan("admin", "po")){ ?>		
		<!--<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/2/7" class="btn_gray"><span>사진등록</span></a></div>-->
<? }?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

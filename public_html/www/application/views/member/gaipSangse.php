<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "member/";


switch($menu){
case 1:
	$gtit = "미가입 회원관리";
break;
case 2:
	$gtit = "가입 회원관리";
break;
case 3:
	$gtit = "차단 회원관리";
break;
}

//echo "mem=".$mem[0]['memid'];
$dispgb[0] = "block";
$dispgb[1] = "none";
if($mem->gubun == 2){
	$dispgb[0] = "none";
	$dispgb[1] = "block";
}

$si = ($mem->stat == 2)? $si = "승인완료" : $si = "승인대기";

$cogubun = "계열사";
if($mem->cogubun == JOHAPG) $cogubun = "조합";
else if($mem->cogubun == BONSA) $cogubun = "본사";



?>

		<div id="gaipSangseMess" class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$gtit?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->
      
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:<?=$dispgb[0]?>;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>회원상세보기</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">아이디</td><td><?=$mem->memid?></td></tr>
      <tr><td class="titcell">이메일</td><td><?=$mem->email?></td></tr>
      <tr><td class="titcell">휴대폰번호</td><td><?=anzTel($mem->tel)?></td></tr>
      <tr><td class="titcell">구분</td><td><?=$cogubun?></td></tr>
      <tr><td class="titcell">업체명</td><td><?=$mem->coname?></td></tr>
      <? 
	  $pp = $mem->potiontxt;
	  if($pp == "조합") $pp = "직원";
	  ?>
      <tr><td class="titcell">직책</td><td class="jpotion"><span><?=$pp?></span>
      
      <? 
	  	$adt = array("cgb"=>$mem->cogubun, "po"=>$mem->potion, "gb"=>$mem->gubun, "coid"=>$mem->coid, "st"=>$mem->stat);
	  	if(keyMan("pochn", $adt)){
	?>		
		<select name="mempo" onchange="meminf.poChange(<?=$rid?>, this, 'p', 'po')">
        <option value="0">변경</option>
        <option value="3">직원</option>
        <option value="4">관리자</option>
        </select> 
    <?	
		}
	?>
      
      </td></tr>
      <tr><td class="titcell">등록일자</td><td><?=$mem->onday?></td></tr>
      <tr><td class="titcell">현재상태</td><td><?=($mem->stat == 2)? "승인완료" : "승인대기";?></td></tr>
      </tbody>
      </table>

  </div>
  
  
      <!--업종상세보기-->
      
  
  
 
  <div id="join_company" class="join_company finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:<?=$dispgb[1]?>;">


      <table class="table_list">
      <caption>회원상세보기</caption>
      <colgroup>

      <col width="30%">
      <col width="70%">
      
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      
      <tr><td class="titcell">아이디</td><td><?=$mem->memid?></td></tr>
      <tr><td  class="titcell">업체명</td><td><?=$mem->coname?></td></tr>
      <tr><td class="titcell">대표자명</td><td><?=$mem->name?></td></tr>
      <tr><td class="titcell">이메일</td><td><?=$mem->email?></td></tr>
      <tr><td class="titcell">휴대폰번호</td><td><?=anzTel($mem->tel)?></td></tr>
      <tr><td class="titcell">소속</td><td><?=$mem->coname?></td></tr>
      <tr><td class="titcell">구분</td><td><?=$cogubun?></td></tr>
      <tr><td class="titcell">사업자 번호</td><td><?=anzSaupnum($mem->conum)?></td></tr>
      <!--<tr><td class="titcell">직책</td><td class="jpotion"><span><?=$mem->potiontxt?></span>-->
      
      <? 
	  	$adt = array("cgb"=>$mem->cogubun, "po"=>$mem->potion, "gb"=>$mem->gubun, "coid"=>$mem->coid, "st"=>$mem->stat); 
		if(keyMan("pochn", $adt)){
	?>		
		<select name="mempo" onchange="meminf.poChange(<?=$rid?>, this, 'p', 'po')">
        <option value="0">변경</option>
        <option value="3">직원</option>
        <option value="4">관리자</option>
        </select> 
    <?	
		}
	?>

      </td></tr>
      <tr><td class="titcell">등록일자</td><td><?=$mem->onday?></td></tr>
      <tr><td class="titcell">현재상태</td><td><?=($mem->stat == 2)? "승인완료" : "승인대기";?></td></tr>
      </tbody>
      </table>

  </div>
      
 		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>main/getView/<?=$menu?>/1/<?=$md3?>/<?=$md4?>/<?=$fnd?>/<?=$page?>" class="btn_gray"><span>목록</span></a></div>
      

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

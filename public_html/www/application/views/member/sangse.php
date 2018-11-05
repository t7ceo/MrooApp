<?php
//미가입회원관리 MTExMTExMTExMTE
$baseUrl = $this->session->userdata('mrbaseUrl');  ////http://mroo.co.kr/

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

//var_dump($sangse);


//foreach($sangse as $row){
	
	//echo "gb=".$row->gubun;

	
	
	$memdiv = "none";
	$codiv = "none";
	if($row->gubun == 1){
		$memdiv = "block";
		$tit = $row->memid." 상세정보";
	}else{
		$codiv = "block";
		$tit = $row->coname." 상세정보";
	}
	
	$stat = "승인대기";
	if($row->stat == 2) $stat = "승인완료";
	
	//$row->cogubun = 1;
	$selarray = array("", "계열사", "조합", "본사");
	$seco = array("none","none");
	if($row->cogubun == 1){
		//계열사를 선택한 경우
		$seco[0] = "none";
		$seco[1] = "block";
		
	}else{
		$seco[0] = "block";
		$seco[1] = "none";
	}
	

	$em = explode("@", $row->email);
	
?>
      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$tit?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      


  <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; border:none; display:<?=$memdiv?>;">
    
    				<form id="frmMem" action="<?=$baseUrl?>member/main/personFormEdit" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "memrecid" value="<?=$row->id?>">
                    <input type="hidden" id="oldMEmail" name= "oldEmail" value="<?=$row->email?>" />
                    <input type="hidden" id="passchn" name= "passchn" value="no" />


        <table class="onputPage" style="width:98%; margin:7px 1%;">
        <tr><th><span>아이디</span></th><td>
            <?=$row->memid?>
        </td></tr>     
        <tr><th><span>이름</span></th><td>
            <?=$row->name?>
        </td></tr>
        <tr><th><span>이메일</span></th><td>
            <?=$row->email?>
        </td></tr>
        <tr><th><span>휴대폰 번호</span></th><td>
            <?=anzTel(base64decode($row->tel))?>
        </td></tr>
        <tr><th><span>구분</span></th><td>
            <?=$selarray[$row->cogubun]?>
        </td></tr>
        <tr><th><span>회사명</span></th><td>
                    <?=$row->coname?>
        </td></tr>
        <tr><th><span>직책</span></th><td>
                  <span><?=potiontojigwiP($row->potion)?></span>
                  
            <? if($row->stat == 2){ ?> 
                <select name="mempo" onchange="meminf.poChange(<?=$row->id?>, this, 'p', <?=$row->potion?>)">
                <option value="0">변경</option>
                <option value="3">직원</option>
                <option value="4">관리자</option>
                </select>
            <? } ?>
        </td></tr>
        <tr><th><span>등록일자</span></th><td>
                    <?=$row->onday?>
        </td></tr>
        <tr><th><span>현재상태</span></th><td>
                    <?=$stat?>
        </td></tr>
    	</table>



				</form>
    

  </div>
  
  
  
  
 
  <div id="join_company" class="join_company finder_div2" style="position:relative; height:600px; margin:25px auto 0; border:none; display:<?=$codiv?>;">

    
                    <form id="frmMemco" action="<?=$baseUrl?>member/main/coFormEdit" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "corecid" value="<?=$row->id?>">
                    <input type="hidden" id="oldCEmail" name= "oldEmail" value="<?=$row->email?>" />
                    <input type="hidden" id="oldConum" name= "oldConum" value="<?=$row->conum?>" />
                    <input type="hidden" id="passchn" name= "passchn" value="no" />
                    <input type="hidden" name= "gubun" value=2>
                    <input type="hidden" name= "potion" value=5>
                    <input type="hidden" name= "cogubun" value=1>


        <table class="onputPage" style="width:98%; margin:7px 1%;">
        <tr><th><span>아이디</span></th><td>
            <?=$row->memid?>
        </td></tr> 
        <tr><th><span>업체명</span></th><td>
            <?=$row->coname?>
        </td></tr>    
        <tr><th><span>대표자명</span></th><td>
            <?=$row->name?>
        </td></tr>
        <tr><th><span>이메일</span></th><td>
            <?=$row->email?>
        </td></tr>
        <tr><th><span>휴대폰 번호</span></th><td>
            <?=anzTel(base64decode($row->tel))?>
        </td></tr>
        <tr><th><span>구분</span></th><td>
            <?=$selarray[$row->cogubun]?>
        </td></tr>
        <tr><th><span>사업자등록 번호</span></th><td>
            <?=anzSaupnum($row->conum)?>
        </td></tr>
        <tr><th><span>직책</span></th><td>
            <span><?=potiontojigwiP($row->potion)?></span>
			<? if($row->stat == 2){ ?>
                <select name="mempo" onchange="meminf.poChange(<?=$row->id?>, this, 'p', <?=$row->potion?>)">
                <option value="0">변경</option>
                <option value="3">직원</option>
                <option value="4">관리자</option>
                </select>
            <? } ?>	  
        </td></tr>
        <tr><th><span>등록일자</span></th><td>
                    <?=$row->onday?>
        </td></tr>
        <tr><th><span>주소</span></th><td>
                    <?="(".$row->post.")  ".$row->address?>
        </td></tr>
        <tr><th><span>현재상태</span></th><td>
                    <?=$stat?>
        </td></tr>
    	</table>

      		
				</form>

  </div>
  
  
  
  
  
  
  
  


      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

<?php
//미가입회원관리 MTExMTExMTExMTE
$baseUrl = $this->session->userdata('mrbaseUrl');  ////http://mroo.co.kr/

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

foreach($myinfo as $row){
	
	
	$memdiv = "none";
	$codiv = "none";
	if($row->gubun == 1){
		$memdiv = "block";
		$tit = "회원정보 수정";
	}else{
		$codiv = "block";
		$tit = "업체정보 수정";
	}
	
	//$row->cogubun = 1;
	$selarray = array("", "계열사", "조합", "본사");
	//$selarray[$row->cogubun] = 'selected = "selected"';
	$seco = array("none","none");
	///*
	if($row->cogubun == 1){
		//계열사를 선택한 경우
		$seco[0] = "block";
		$seco[1] = "none";
		
	}else{
		$seco[0] = "block";
		$seco[1] = "none";
	}
	//*/

	$em = explode("@", $row->email);
	
?>

<style>

table.onputPage td input{
	padding:5px 0 5px 10px;
	border:#dedede 1px solid;
}

</style>


      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#"><?=$tit?></a></li>
        </ul>
      </div>
      <!-- //tab -->
      


  <div id="join_mem" class="join_mem finder_div2" style="position:relative; width:700px; margin:25px auto 0; border:none; display:<?=$memdiv?>;">
    
    				<form id="frmMem" action="<?=$baseUrl?>member/mypage/personFormEdit" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "memrecid" value="<?=$row->id?>">
                    <input type="hidden" name= "conameSe" value="<?=$row->coid?>" />
                    <input type="hidden" id="oldMEmail" name= "oldEmail" value="<?=$row->email?>" />
                    <input type="hidden" id="passchn" name= "passchn" value="no" />


    
        <table class="onputPage" style="width:98%; margin:7px 1%;">
        <tr><th><span>아이디</span></th><td>
            <input type="text" name="memid" maxlength="16" value="<?=$row->memid?>" disabled />
        </td></tr>     
        <tr><th><span>이름</span></th><td>
            <input type="text" name="name" maxlength="20" value="<?=$row->name?>" />
        </td></tr>
        <tr><th><span>이메일</span></th><td>
            <input id="email1" name="email1" type="email" value="<?=$em[0]?>" style="width:14%;" />
      &nbsp;@&nbsp;
      <input id="email2" name="email2" type="email" value="<?=$em[1]?>" style="width:18%;" />
      &nbsp;
      <select class="language" style="width:18%;" onchange="meminf.seEmailSet(this, '')">
      <option value="0">직접입력</option>
      <option value="naver.com">naver.com</option>
      <option value="daum.net">daum.net</option>
      <option value="nate.com">nate.com</option>
      <option value="google.com">google.com</option>
      </select>
      
      <a type="button" name="" style="width:16%;" class="button2" onclick="meminf.emailOkInf('<?=$cihs?>', '')">중복확인</a>
        </td></tr>
        <tr><th><span>기존 비밀번호</span></th><td>
            <input type="password" name="mempass"  maxlength="15" placeholder="영문,숫자조합 6자 이상" />
        </td></tr>
        <tr><th><span>신규 비밀번호</span></th><td>
            <input type="password" name="newmempass"  maxlength="15" placeholder="영문,숫자조합 6자 이상" />
        </td></tr>
        <tr><th><span>신규비번 확인</span></th><td>
            <input type="password" name="newmemrepass" maxlength="15" placeholder="입력한 비밀번호 재확인" />
        </td></tr>
        <tr><th><span>휴대폰 번호</span></th><td>
            <input type="tel" id="edtmemtel" name="memtel" value="<?=base64decode($row->tel)?>" maxlength="11" placeholder="'-' 빼고 입력" />
        </td></tr>
        <tr><th><span>구분</span></th><td>
            <input type="text" name="memid" maxlength="16" value="<?=$selarray[$row->cogubun]?>" disabled />
        </td></tr>
        <tr><th><span>회사명</span></th><td>
                    <input id="conameSeT" style="display:<?=$seco[0]?>;" value="<?=$row->coname?>" disabled />
        <select id="myCompanySe2" name="conameSe2" style="width:60%; margin:19px 0 0; display:<?=$seco[1]?>;" onchange="meminf.conameChange(this)" >
        <option value="0">선택</option>
			<? 
				foreach($coary as $rowc){
                	$ss = ($rowc->id == $row->coid)? 'selected = "selected"' : '';
            ?>
            	<option value="<?=$rowc->id?>" <?=$ss?>><?=$rowc->coname?></option>
            <? } ?>
 
        </select>
        </td></tr>
    	</table>
       
       <p style="text-align:center; padding:25px 0;"><a href="#" class="btn_org" onclick="meminf.edtMember()"><span>개인정보 수정</span></a></p>


         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
 

				</form>
    

  </div>
  
  
  
  
 
  <div id="join_company" class="join_company finder_div2" style="position:relative; width:700px; height:600px; margin:25px auto 0; border:none; display:<?=$codiv?>;">

    
                    <form id="frmMemco" action="<?=$baseUrl?>member/mypage/coFormEdit" method="POST">
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
            <input type="text" name="memid" maxlength="10" value="<?=$row->memid?>"  disabled />
        </td></tr>  
        <tr><th><span>업체명</span></th><td>
            <input id="coname" name="coname" type="text" value="<?=$row->coname?>" placeholder="회사명 신규등록" />
        </td></tr>   
        <tr><th><span>대표자명</span></th><td>
            <input id="name" name="name" type="text" value="<?=$row->name?>" placeholder="대표의 이름" />
        </td></tr>
        <tr><th><span>이메일</span></th><td>
            <input id="coemail1" name="coemail1" type="email" value="<?=$em[0]?>" style="width:14%;" />
              &nbsp;@&nbsp;
              <input id="coemail2" name="coemail2" type="email" value="<?=$em[1]?>" style="width:18%;" />
              &nbsp;
              <select class="language" style="width:18%;" onchange="meminf.seEmailSet(this, 'co')">
              <option value="0">직접입력</option>
              <option value="naver.com">naver.com</option>
              <option value="daum.net">daum.net</option>
              <option value="nate.com">nate.com</option>
              <option value="google.com">google.com</option>
              </select>
              
              <a type="button" name="" style="width:16%;" class="button2" onclick="meminf.emailOkInf('<?=$cihs?>', 'co')">중복확인</a>
        </td></tr>
        <tr><th><span>기존 비밀번호</span></th><td>
            <input type="password" name="copass" maxlength="15" placeholder="영문,숫자조합 6자 이상" />
        </td></tr>
        <tr><th><span>신규 비밀번호</span></th><td>
            <input type="password" name="newcopass" maxlength="15" placeholder="영문,숫자조합 6자 이상" />
        </td></tr>
        <tr><th><span>신규비번 확인</span></th><td>
            <input type="password" name="newcorepass" maxlength="15" placeholder="입력한 비밀번호 재확인" />
        </td></tr>
        <tr><th><span>휴대폰 번호</span></th><td>
            <input type="text" id="cotel" name="cotel" maxlength="11" value="<?=base64decode($row->tel)?>" placeholder="'-' 빼고 입력" />
        </td></tr>
        <tr><th><span>사업자 번호</span></th><td>
            <input type="text" id="cosaupnum" name="cosaupnum" value="<?=anzSaupnum($row->conum)?>" maxlength="10" style="width:57%;" placeholder="'-' 빼고 입력" /> <a type="button" name="" style="width:18%;" class="button2" onclick="meminf.conumOkInf('<?=$cihs?>', 'co')">중복확인</a>
        </td></tr>
        <tr><th><span>우편번호</span></th><td>
            <input type="text" id="copost" name="copost" value="<?=$row->post?>" placeholder="우편번호" style="width:57%" />
        <a type="button" name="" style="width:18%;" class="button2" onclick="openpost()">우편번호</a>
        </td></tr>
        
        <tr><th><span>주소</span></th><td>
             <input type="text" id="coaddress" name="coaddress" style="width:80%;" value="<?=$row->address?>" placeholder="업체의 주소를 입력하세요." />
        </td></tr>
    	</table>
    
        <div class="mess" style="margin:20px 0 0;"><?=$this->session->flashdata('coedit')?></div>
 
        <p style="text-align:center; padding:25px 0;"><a href="#" class="btn_org" onclick="meminf.edtCompany()"><span>업체정보 수정</span></a></p>
        
      
 
 

				</form>

  </div>
  
  
 
  
 
 
 <? } ?> 




      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

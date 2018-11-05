<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//자동로그인 : onclick="meminf.setAutoLogin()"
//회원가입 : http://mroo.co.kr/common/ajaxc/personJoin

$baseUrl = $this->session->userdata('mrbaseUrl');

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.



if(!$md) $md = "0";




?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="stylesheet" type="text/css" href="templt/lib/css/admin/admin.css" />
<link rel="stylesheet" type="text/css" href="templt/lib/css/admin/jquery.omniwindow.css" />


<script src="jquery-mobile/jquery-3.3.1.min.js"></script>

<script type="text/javascript" src="templt/lib/js/jquery.omniwindow.js"></script>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<!--[if lt IE 7]>
<script type="text/javascript" src="<?=PREDIR?>templt/lib/css/js/unitpngfix.js"></script>
<![endif]-->
<title>MALO</title>
<style>
	#selectJoin{
		position:absolute;
		top:186px;
		margin:0 0 -4px;
	}
	
	div.formJ p span span.astc, div.formJ p span span.astcw{
		width:auto;
		display:inline-block;
		margin:0 3px 2px 0;
		font-size:0.8em;
		color:red;
	}
	div.formJ p span span.astcw{
		color:white;
	}
	
</style>
<script>

	var mode = "<?=$md?>";

	$(document).ready(function(){
	
		$modal = $('div.modal').omniWindow();
		
		
		$("#show_id").click(function(){
		
			$modal.trigger('show');
			
			$("#popClose").css('display' , 'block');
			$(".finder_id").css('display' , 'block');
			$("#join_mem").css('display' , 'none');
			$("#join_company").css('display' , 'none');
			
		
		});
		
		$("#show_pw").click(function(){
		
			$modal.trigger('show');
			$("#popClose").css('display' , 'block');
			$(".finder_pw").css('display' , 'block');
			$("#join_mem").css('display' , 'none');
			$("#join_company").css('display' , 'none');
		
		});
		
		
		
		$('.close-button').click(function(e){
		
			e.preventDefault();
			$modal.trigger('hide');
			$(".finder_div").css('display' , 'none');
		
		});
		
		$('.close-button').click(function(e){
		
			e.preventDefault();
			$modal.trigger('hide');
			$(".finder_div").css('display' , 'none');
		
		});
	
		$('#join_mode').change(function(){

			var obj = this;

			if(obj.value == "mem"){

				location.href = "<?=$baseUrl?>home/personJoin";
				
			}else{

				location.href = "<?=$baseUrl?>home/companyJoinChn";
				
			}
			
		});
	

			$(".finder_id").css('display' , 'none');
			$(".finder_pw").css('display' , 'none');
			$("#popClose").css('display' , 'none');	
			
			
		switch(mode){
		case "login":
		
		
		break;
		case "co":
			$modal.trigger('show');
	
			$("#join_mem").css('display' , 'none');
			$("#join_company").css('display' , 'block');
		break;
		case "mem":
		
			$modal.trigger('show');
	
			$("#join_company").css('display' , 'none');
			$("#join_mem").css('display' , 'block');
		break;
		case "pwok":  //비밀번호 찾기 성공
			$modal.trigger('hide');
			$(".finder_pw").css('display' , 'none');
		break;
		case "pwnot":   //비밀번호 찾기 실패
			$modal.trigger('show');
			$("#join_company").css('display' , 'none');
			$("#join_mem").css('display' , 'none');
			
			$(".finder_pw").css('display' , 'block');
			$("#popClose").css('display', 'block');
		break;
		case "cook":
			$modal.trigger('hide');
			$(".finder_id").css('display' , 'none');

		break;
		case "ok":
			$modal.trigger('hide');
			$(".finder_id").css('display' , 'none');
			
			$("#logid").val("<?=$fmemid?>");
			
		break;
		case "not":
			$modal.trigger('show');
			$("#join_company").css('display' , 'none');
			$("#join_mem").css('display' , 'none');
			
			$(".finder_id").css('display' , 'block');
			$("#popClose").css('display', 'block');
		
		break;
		}
	
	
	});
	
//----------------------------------------------------------------------------


	function popupContro(){
	
		$("div.mess").html("").css({"background-color":"none"});
		
	}
	
	function openpost(){
	
		new daum.Postcode({
			oncomplete: function(data) {
				// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
					var fullAddr = data.address; // 최종 주소 변수
					var extraAddr = ''; // 조합형 주소 변수
					
					// 기본 주소가 도로명 타입일때 조합한다.
					if(data.addressType === 'R'){
						//법정동명이 있을 경우 추가한다.
						if(data.bname !== ''){
							extraAddr += data.bname;
						}
						// 건물명이 있을 경우 추가한다.
						if(data.buildingName !== ''){
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
						fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
					}
	
					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById('copost').value = data.zonecode; //5자리 새우편번호 사용
					document.getElementById('coaddress').value = fullAddr;

			}

    	}).open();
	
	}

</script>
</head>

<body>
<div id="log_bg">

  		<div id="allBg">
        
        	<div id="popupBox" style="display:block;">
                <h2>알림</h2>
                <div id="BoxMess">정말로 삭제 할까요?<br />삭제하시면 복구 불가능합니다.<br /><br /></div>
                <ul><li><a href="#" class="btn_gray" onclick="meminf.memDelOk()"><span>확인</span></a></li><li><a href="#" class="btn_org" onclick="meminf.memDelNo()"><span>취소</span></a></li></ul>
        	</div>
        
        </div>
        

  <div id="log_box">
    <div class="logo">
      <img src="<?=PREDIR?>templt/imgs/admin/logo.png" width="80px;" alt="MROO">
      <!-- <span><img src="imgs/admin/admin_login.gif" alt="관리자로그인"></span> -->
    </div>
    <p class="user">
    </p>
    <ul>
      <li>
      <input id="logid" name="logid" type="text" placeholder="아이디를 입력하세요.">
      </li>
      <li>
      <input id="logpass" name="logpass" type="password" placeholder="비밀번호를 입력하세요.">
      </li>
      <li id="btn"><a href="#" onclick="meminf.login('<?=$cihs?>')"><img src="<?=PREDIR?>templt/imgs/admin/login_btn.png" width="67" height="66" alt="로그인"></a></li>
    </ul>
    <p class="btn"><a href="#"  id='show_id' >아이디 찾기</a><a href="#"  id='show_pw' >비밀번호 찾기</a> 
    	<select id="join_mode" name="join_mode" style="margin:4px 0 0;">
        <option value="se">회원가입</option>
        <option value="mem">개인</option>
        <option value="co">업체</option>
        </select>
    </p><br />
    
    <div class="mess"><?=$this->session->flashdata('loginf')?></div>
    
    <p class="copy">Copyright ⓒ <strong>MROO</strong> All rights reserved.</p>
  </div>
  
</div>









<div id="modal" class="modal ow-closed" style="height:264px;">
  <div class="finder_id  finder_div">
    <h1><img src="<?=PREDIR?>templt/imgs/admin/txt_id.png" alt="아이디 찾기" /></h1>
    
                    <form id="frmFindId" name="frmFindId" action="<?=$baseUrl?>common/ajaxc/findId" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
    
    <div class="form">
      <p><span>휴대폰 번호</span><input id="idtel" name="idtel" type="text" maxlength="11" placeholder="'-' 빼고 입력" style="width:46%;" /></p>
      <p><span>이메일</span><input id="idemail1" name="idemail1" type="text" style="width:18%;" />
      &nbsp;@&nbsp;
      <input id="idemail2" name="idemail2" type="text" style="width:20%;" />
      &nbsp;
      <select class="language" style="width:20%;" onchange="meminf.seEmailSet(this, 'id')">
      <option value="0">직접입력</option>
      <option value="naver.com">naver.com</option>
      <option value="daum.net">daum.net</option>
      <option value="nate.com">nate.com</option>
      <option value="google.com">google.com</option>
      </select>
      </p>
      <p><a id="findIdOk" href="#" onclick="idfindgo()">확인</a></p>
    </div>
    
    			</form>
    
     <div class="mess" style="position:absolute; margin:98px 0 0; width:100%; text-align:center; color:red;"><?=$this->session->flashdata('idnotfind')?></div>
  </div>





  <div class="finder_pw finder_div" style="height:264px;">
    <h1><img src="<?=PREDIR?>templt/imgs/admin/txt_pw.png" alt="비밀번호 찾기" /></h1>
    
                    <form id="frmFindPw" name="frmFindPw" action="<?=$baseUrl?>common/ajaxc/findPw" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
    
    <div class="form">
      <p><span>휴대폰 번호</span><input id="pwtel" name="pwtel" type="text" maxlength="11" placeholder="휴대폰 번호를 입력하세요." style="width:46%;" /></p>
      <p><span>아이디</span><input id="pwid" name="pwid" type="text" placeholder="아이디를 입력하세요." style="width:46%;" /></p>
      <p><span>이메일</span><input id="pwemail1" name = "pwemail1" type="text" style="width:18%;" />
      &nbsp;@&nbsp;
      <input id="pwemail2" name="pwemail2" type="text" style="width:20%;" />
      &nbsp;
      <select class="language" style="width:20%;" onchange="meminf.seEmailSet(this, 'pw')">
      <option value="0">직접입력</option>
      <option value="naver.com">naver.com</option>
      <option value="daum.net">daum.net</option>
      <option value="nate.com">nate.com</option>
      <option value="google.com">google.com</option>
      </select>
      </p>
      

      
      <p><a href="#" onclick="meminf.findPw()">확인</a></p>
    </div>
    
    				</form>
                    
	<div class="mess" style="position:absolute; margin:55px 0 0; width:100%; text-align:center; padding:8px 0; color:red;"><?=$this->session->flashdata('pwnotfind')?></div>
    
  </div>









  <div id="join_mem" class="join_mem finder_div2" style="display:none;">
    <h1 style="width:90%; margin:10px 5% 0;">개인 회원가입</h1>
    
    				<form id="frmMem" action="<?=$baseUrl?>home/personFormOn" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "captcha_time" value="<?=($md == "mem")? $captcha_time : ""?>">
                    <input type="hidden" name= "ip_address" value="<?=($md == "mem")? $ip_address : ""?>">


    <div class="formJ">
    	<p><span><span class="astc">*</span>아이디</span><input type="text" id="memid" name="memid" maxlength="10" style="width:58%;" placeholder="4 ~ 10자 이내" /> <a type="button" name="" class="button2" style="width:18%;" onclick="meminf.memidGoOk('<?=$cihs?>', '')">중복확인</a></p>
        
        <p><span><span class="astc">*</span>이메일</span><input id="email1" name="email1" type="email" style="width:14%;" />
      &nbsp;@&nbsp;
      <input id="email2" name="email2" type="email" style="width:18%;" />
      &nbsp;
      <select class="language" style="width:18%;" onchange="meminf.seEmailSet(this, '')">
      <option value="0">직접입력</option>
      <option value="naver.com">naver.com</option>
      <option value="daum.net">daum.net</option>
      <option value="nate.com">nate.com</option>
      <option value="google.com">google.com</option>
      </select>
      
      <a type="button" name="" style="width:16%;" class="button2" onclick="meminf.emailOkInf('<?=$cihs?>', '')">중복확인</a>
      </p>
        
        <p><span><span class="astc">*</span>이름</span><input type="text" name="name" placeholder="회원의 실명" /></p>
        <p><span><span class="astc">*</span>비밀번호</span><input type="password" name="mempass" maxlength="15" placeholder="영문,숫자조합 6자 이상" /></p>
        <p><span><span class="astc">*</span>비밀번호 확인</span><input type="password" name="memrepass" maxlength="15" placeholder="입력한 비밀번호 재확인" /></p>
        <p><span><span class="astc">*</span>휴대폰 번호</span><input type="text" id="memtel" name="memtel" maxlength="11" placeholder="'-' 빼고 입력" /></p>
        <p><span><span class="astc">*</span>구분</span>
   		<select id="seGubunID" name="gubun" style="margin:7px 0;" onchange="meminf.gubunChange(this)">
        <option value="0">선택</option>
        <option value="3">본사</option>
        <option value="2">조합</option>
        <option value="1">계열사</option>
        </select>        
        </p>
        <p><span><span class="astc">*</span>회사명</span><input id="conameSeT" style="display:block;" value="미선택" disabled>
        <select id="myCompanySe" name="conameSe" style="width:60%; margin:19px 0 0; display:none;" onchange="meminf.conameChange(this)">
        <option value="0">선택</option>
        <? foreach($coary as $row){ ?>
        <option value="<?=$row->id?>"><?=$row->coname?></option>
        <? } ?>
        </select>
        </p>
        
        <p><span><span class="astc">*</span>자동가입 방지</span>
        
 		<? if($md == "mem") echo $cap['image']?><input type="text" name="captcha" style="width:20%; margin:0 0 0 5px;" value="" /></p>
        
        
        <p style="text-align:center; padding:8px 0;"><a type="button" name=""  class="button1" onclick="meminf.onMember()">회원가입</a></p>
    </div>


				</form>
    


    
    <a id="popCloseMem" class='close-button' style="margin:7px 15px 0 0;" href='#'><img src="<?=PREDIR?>templt/imgs/admin/pop_close.png" alt="" /></a>
  </div>
  
  
  
  
  
  
  
  
  
  
  
  <div id="join_company" class="join_company finder_div2" style="display:none; height:640px;">
    <h1 style="width:90%; margin:15px 5% 0;">업체회원가입</h1>
    
                    <form id="frmMemco" action="<?=$baseUrl?>common/ajaxc/coFormOn" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" name= "gubun" value=2>
                    <input type="hidden" name= "potion" value=5>
                    <input type="hidden" name= "cogubun" value=1>
                   	<input type="hidden" name= "captcha_time" value="<?=($md == "co")?$captcha_time : ""?>">
                    <input type="hidden" name= "ip_address" value="<?=($md == "co")? $ip_address : ""?>">
                    

    <div class="formJ">
		<p><span><span class="astc">*</span>아이디</span><input type="text" id="cmemid" name="memid" maxlength="10" style="width:58%;" placeholder="4 ~ 10자 이내" /> <a type="button" name="" style="width:18%;" class="button2" onclick="meminf.memidGoOk('<?=$cihs?>', 'co')">중복확인</a></p>    
    
    	<p><span><span class="astc">*</span>업체명</span><input id="coname" name="coname" type="text" placeholder="회사명 신규등록" /></p>
        <p><span><span class="astc">*</span>대표자명</span><input id="name" name="name" type="text" placeholder="대표의 이름" /></p>
        
       <p><span><span class="astc">*</span>이메일</span><input id="coemail1" name="coemail1" type="email" style="width:14%;" />
      &nbsp;@&nbsp;
      <input id="coemail2" name="coemail2" type="email" style="width:18%;" />
      &nbsp;
      <select class="language" style="width:18%;" onchange="meminf.seEmailSet(this, 'co')">
      <option value="0">직접입력</option>
      <option value="naver.com">naver.com</option>
      <option value="daum.net">daum.net</option>
      <option value="nate.com">nate.com</option>
      <option value="google.com">google.com</option>
      </select>
      
      <a type="button" name="" style="width:16%;"class="button2" onclick="meminf.emailOkInf('<?=$cihs?>', 'co')">중복확인</a>
      </p>        
        
        <p><span><span class="astc">*</span>비밀번호</span><input type="password" name="copass" maxlength="15" placeholder="영문,숫자조합 6자 이상" /></p>
        <p><span><span class="astc">*</span>비밀번호 확인</span><input type="password" name="corepass" maxlength="15" placeholder="입력한 비밀번호 재확인" /></p>
        
        <p><span><span class="astc">*</span>휴대폰 번호</span><input type="text" id="cotel" name="cotel" maxlength="11" placeholder="'-' 빼고 입력" /></p>
        
     
		<p><span><span class="astc">*</span>사업자 번호</span><input type="text" id="cosaupnum" name="cosaupnum" maxlength="10" style="width:58%;" placeholder="'-' 빼고 입력" /> <a type="button" name="" style="width:18%;" class="button2" onclick="meminf.conumOkInf('<?=$cihs?>', 'co')">중복확인</a></p>    

		<p><span><span class="astc">*</span>우편번호</span><input type="text" id="copost" name="copost" placeholder="우편번호" style="width:58%" />
        <a type="button" name="" style="width:18%;" class="button2" onclick="openpost()">우편번호</a>
        </p>
		<p><span><span class="astc">*</span>주소</span><input type="text" id="coaddress" name="coaddress" placeholder="업체의 주소를 입력하세요." />
        </p>

        <p><span><span class="astc">*</span>자동가입 방지</span>
        
 		<? if($md == "co") echo $cap['image']?><input type="text" name="cocaptcha" style="width:20%; margin:0 0 0 5px;" value="" /></p>

        
        <p style="text-align:center; padding:2px 0 3px;"><a type="button" name=""  class="button1" class="onsubmit" onclick="meminf.onCompany()">업체등록</a></p>
    </div>

				</form>


    <a id="popCloseCo" class='close-button' style="margin:14px 15px 0 0;" href='#'><img src="<?=PREDIR?>templt/imgs/admin/pop_close.png" alt="" /></a>
  </div>


  <a id="popClose" class='close-button' href='#' onclick="popupContro()"><img src="<?=PREDIR?>templt/imgs/admin/pop_close.png" alt="" /></a>
</div>


<script>
String.prototype.replaceAll = replaceAll;
function replaceAll(str1, str2){
	var strTemp = this;
	strTemp = strTemp.replace(new RegExp(str1, "g"), str2);
	return strTemp;
}

		//===========================================================================================
		function idfindgo(){
			//var telgab = $("#idtel").val();
			//var emailgab2 = $("#idemail1").val();
			//var email2 = $("#idemail2").val();
			
			//alert(telgab+"/"+emailgab1+"/"+emailgab2);
			//아이디 찾기 클릭
			if(telgab && emailgab1 && emailgab2){ 
				meminf.findId();
			}else{
				appUtil.alertgo("알림","전화번호와 이메일을 다시 확인 하세요.");
				
				/*
				if(meminf.email2inf){
					meminf.findId();
				}else{
					appUtil.alertgo("알림","전화번호와 이메일을 다시 확인 하세요.");
				}
				*/
			}
		}		


	//코드이그나이터 헤시값을 가져온다.
    var CIHS = "<?=$cihs?>";
	var MASTER = <?=MASTER?>;
	var SUPER = <?=SUPER?>;
	var ADMIN = <?=ADMIN?>;
	var SAWON = <?=SAWON?>;
	var JOHAP = <?=JOHAP?>;
	var USER = <?=USER?>;
	
	
	var mypotion = 0;
	var myrecid = 0;
	var mymemid = "";
	<? if($this->session->userdata("logged_in")){ ?>
	mypotion = <?=$this->session->userdata("potion")?>;
	myrecid = <?=$this->session->userdata("id")?>;
	mymemid = "<?=$this->session->userdata("memid")?>";
	<? } ?>

			//엔터키 처리를 한다.
		$("#logid, #logpass").keydown(function(e){
			
			switch(e.keyCode){
			case 13:
				meminf.login(CIHS);
			break;
			}

			
		});




//============================================================
</script>

    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onBeforeShow.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/hdmem.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/classAll.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/getserver.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/apputil.js"></script>    
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/base64.js"></script>



<script>

	meminf.md1 = "<?=$md?>";
	meminf.md2 = <?=$md2?>;
	meminf.md3 = <?=$md3?>;
	meminf.md4 = <?=$md4?>;
	meminf.fnd = "<?=$fnd?>";
	meminf.page = <?=$page?>;

</script>


</body>
</html>

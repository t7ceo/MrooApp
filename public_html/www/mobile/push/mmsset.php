<?
include './allphpfile/config.php';
//include 'util.php';
include './allphpfile/gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련

	
	$memid = $_SESSION["memid"];
	
	if(!$_SESSION["mempo"]) $mpo = "0";
	else $mpo = $_SESSION["mempo"];


	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	
	$ntime = mktime();

	$vid = 0;
	if($_GET[vid]) $vid = $_GET[vid];
	
	$findg = "";
	if($_GET[findg]) $findg = $_GET[findg];
	
	$ilsumd = 0;
	if($_GET[ilsumd]) $ilsumd = $_GET[ilsumd];
	
	
	$login_inf = true;
	if(!$memid or $memid == "0"){
		$login_inf = false;
		$memid = "0";
	}


?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title>모바일앱 MMS발송</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.css" /> 	
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.structure-1.4.0.min.css" />
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.theme-1.4.0.min.css" />
	
    <link rel="stylesheet" href="./allphpfile/apis/getmoney.css" />

	<script src="./allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>
	<script src="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>


	<script type="text/javascript">
		var proje = "<?=$project?>";
		var memid = "<?=$memid?>";
		var pass = "";
		var mempo = <?=$mpo?>;
		var nnt = <?=$ntime?>;
		var gurl = "<?=$gurl?>";
		var lk = "<?=$gurl?>/app/push/images/";
		var editId = <?=$vid?>;
		var findg = "<?=$findg?>";
		var ilsumd = <?=$ilsumd?>;
		var all_path = "<?=$all_path?>";
		
    </script>
	<script src="./util.js"></script>

</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="AdInput">
    
        <div class="GmStrMenuHead" style="text-align:center; width:1500px;">
        	<table style="width:80%; margin:0 10%;"><tr>
            
            <td width="60%"><h2><?=$tit?></h2></td>
            <td></td>
            
            <? if($login_inf){ //로그인 했다.?>
            
                <td>아이디:</td>
            	<td><?=$memid?></td>
            	<td><input type="button" value="로그아웃" style="margin:1px auto;" class="whiteBtn" onclick="goLogout('<?=$memid?>')"></td>
            
            <? }else{   //로그인 실패 ?>
            
                <td>아이디:</td>
            	<td><input type="text" id="mid" value=""></td>
            	<td>비번:</td>
            	<td><input type="password" id="pass" value=""></td>
            	<td><input type="button" value="로그인" style="margin:1px auto;" class="whiteBtn" onclick="goLogin()"></td>
            
            <? } ?>
            </tr></table>
        </div>
                

                
        <div class="pageBodyR" id="pageBodyR" style="width:1500px;">
       		<form name="incamp" action="<?=$all_path?>mms_inprocess.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="gtit2" value="mms">
            <input type="hidden" name="mode" value = "">
            <input type="hidden" name="memid" value = "<?=$memid?>">
            
            <table border="0" width="90%" style="margin:5px 5%;">
                <tr>
                    <td>MMS 제목</td>
                    <td><input type="text" name="tit" id="tit" value="전화주셔서 감사합니다" /></td>
                    <td align="center">링크 URL(옵션)</td>
                    <td><input type="text" name="url" id="url" value="" placeholder="MMSURL"/></td>
                    <td align="center">계약시작</td>
                    <td><input type="text" name="sday" id="datepicker1" /></td>                
                    <td align="center">계약종료</td>
                    <td><input type="text" name="eday" id="datepicker2" /></td>
                </tr>  
                <tr>
                    <td>MMS 내용</td>
                    <!--<td colspan="7"><input type="text" name="gtit1" id="gtit1" value="" placeholder="MMS내용" /></td>-->
                    <td colspan="7"><textarea name="gtit1" id="gtit1" rows="6"></textarea></td>
                </tr>
                <tr>
                    <td>*업체유선 번호</td>
                    <td colspan="3"><input type="text" name="telu" id="telu" value="" placeholder="유선전화번호" /></td>
                    <td align="center">*무선전화(문자발송)</td>
                    <td colspan="3"><input type="text" name="telmu" id="telmu" value="" placeholder="MMS 발송용 무선전화" /></td>
                </tr>              
                <tr>
                    <td>상호</td>
                    <td colspan="3"><input type="text" name="sangho" id="sangho" value="" placeholder="업체상호" /></td>
                    <td align="center">발송주기</td>
                    <td colspan="3"><input type="text" name="sendday" id="sendday" value="" placeholder="0:매번,숫자:날짜" /></td>
                </tr>
                <tr>
                    <td>*MMS 수신자 번호</td>
                    <td colspan="3"><input type="text" name="desang" id="desang" value="0" /></td>
                    <td align="center">*비밀번호</td>
                    <td colspan="3"><input type="text" name="pass" id="passwd" value="1234" /></td>
                </tr>
                <tr>
                    <td>이미지 등록1</td>
                    <td colspan="3">
                    	<table><tr><td>
                    <input type="file" id="img1" name="fd1" style="padding:4px 0px 1px 0px;" size=45><br />
                    메인 이미지: (필수로 올려야 하는 항목 입니다.)<br />
					* 관련이미지는 600픽셀 최적화.                        
                        </td><td>
                        	<img src="" id="fdimg1" width="70px">
                            <input type="button" id="delbtn1" value="삭제" onclick="delimg('1')">
                        </td></tr></table>
                    </td>
                    <td align="center">이미지 등록2</td>
                    <td colspan="3">
                    	<table><tr><td>
                    <input type="file" id="img2" name="fd2" style="padding:4px 0px 1px 0px;" size=45><br />
                    추가 이미지: (필수로 올려야 하는 항목 입니다.)<br />
					* 관련이미지는 600픽셀 최적화.                        
                        </td><td>
                        	<img src="" id="fdimg2" width="70px">
                            <input type="button" id="delbtn2" value="삭제" onclick="delimg('2')">
                        </td></tr></table>
                    </td>
                </tr>                
                <tr>
                    <td>이미지 등록3</td>
                    <td colspan="3">
                    	<table><tr><td>
                    <input type="file" id="img3" name="fd3" style="padding:4px 0px 1px 0px;" size=45><br />
                    메인 이미지: (필수로 올려야 하는 항목 입니다.)<br />
					* 관련이미지는 600픽셀 최적화.                        
                        </td><td>
                        	<img src="" id="fdimg3" width="70px">
                            <input type="button" id="delbtn3" value="삭제" onclick="delimg('3')">
                        </td></tr></table>
                    </td>
                    <td align="center">이미지 등록4</td>
                    <td colspan="3">
                    	<table><tr><td>
                    <input type="file" id="img4" name="fd4" style="padding:4px 0px 1px 0px;" size=45><br />
                    추가 이미지: (필수로 올려야 하는 항목 입니다.)<br />
					* 관련이미지는 600픽셀 최적화.                        
                        </td><td>
                        	<img src="" id="fdimg4" width="70px">
                            <input type="button" id="delbtn4" value="삭제" onclick="delimg('4')">
                        </td></tr></table>
                    </td>
                </tr>
                <tr>
                    <td>메모1:</td>
                    <td colspan="7"><input type="text" name="memo1" id="memo1" value="" placeholder="메모를 입력하세요." /></td>
                    <!--<td colspan="7"><textarea name="gtit1" id="gtit1" rows="6"></textarea></td>-->
                </tr>
                <tr>
                    <td>메모2:</td>
                    <td colspan="7"><input type="text" name="memo2" id="memo2" value="" placeholder="메모를 입력하세요." /></td>
                    <!--<td colspan="7"><textarea name="gtit1" id="gtit1" rows="6"></textarea></td>-->
                </tr>
                <tr>
                    <td>메모3:</td>
                    <td colspan="7"><input type="text" name="memo3" id="memo3" value="" placeholder="메모를 입력하세요." /></td>
                    <!--<td colspan="7"><textarea name="gtit1" id="gtit1" rows="6"></textarea></td>-->
                </tr>       
            </table>
			</form>
    		
          </div>
    
        <div style="width:90%; margin:10px 4%; text-align:center; width:1500px;">
        	* MMS 발송시 "*"항목은 필수 입력 항목입니다. - 설정된 정보를 MMS 수신자 번호로 보낸다.
            
        	<table width="1450px"><tr><td width="50%">
            
                <table id="contBtn" width="100%">
                <tr>
                <td>
                    <input type="button" value="입력초기화" style="margin:5px auto;" class="whiteBtn" onclick="locationgoNew()">
                </td>
                <td>
                    <input type="button" value="등록업체 추가/수정 요청" style="margin:5px auto;" class="whiteBtn" onclick="input_mms()">
                </td>
                <?
                if($mpo > 4){
                ?>
                
                <td>
                    <input type="button" value="회원관리" style="margin:5px auto;" class="whiteBtn" onclick="goPage('member')">
                </td>
                
				<? } ?>
				
				<td>
                    <input type="button" value="수신거부 설정" style="margin:5px auto;" class="whiteBtn" onclick="goPage('susinno')">
                </td><td>
                    <input type="button" value="MMS 발송" style="margin:5px auto;" class="whiteBtn" onclick="sendMMS()">
                </td><td>
                    <input type="button" value="설정 보이기/닫기" style="margin:5px auto;" class="whiteBtn" onclick="setShowHide()">
                </td>
                <td>|</td>
                </tr></table>
            
            </td><td width="50%">
            
                <table width="100%"><tr>
                <td>
                    <input type="button" value="잔여일수 올림" id="ilsudown" class="whiteBtn" style="margin:5px auto;" onclick="ilsuGet(0)">
                </td>
                <td>
                    <input type="button" value="잔여일수 내림" id="ilsuup" class="whiteBtn" style="margin:5px auto;" onclick="ilsuGet(1)">
                </td>
                <td>
                    <input type="button" value="최신순" id="ilsunew" class="whiteBtn" style="margin:5px auto;" onclick="ilsuGet(2)">
                </td>
                <td>
                    <input type="button" value="전체리스트 보기" class="whiteBtn" style="margin:5px auto;" onclick="cfindAll(1)">
                </td>
                <td>
                    <input type="text" name="findg" id="findg" value="" style="margin:5px auto;" placeholder="검색어" />
                </td>
                <td width="10%">
                    <input type="button" value="검색" class="whiteBtn" style="margin:5px auto;" onclick="cfind(1)">
                </td>
                </tr></table>
			
            </td></tr></table>
            
            <!--<a href="#" class="redBtn" style="margin:5px auto 20px;" onclick="pushsend()">푸시발송</a>-->
        </div>
        
        
        <div id="pushSendList" style="width:1500px;">
        </div>
        
        
    
    </div>

	<script type="text/javascript">

		
		document.getElementById("url").value = "<?=$gurl?>";	
		document.getElementById("findg").value = findg;
		
		dispLogin();
		

		if(memid == "0"){
			document.getElementById("mid").value = "";
			document.getElementById("pass").value = "";
		}
				

		$(function() {
		  $( "#datepicker1" ).datepicker({
			dateFormat: 'yy-mm-dd'
		  });
		  $( "#datepicker2" ).datepicker({
			dateFormat: 'yy-mm-dd'
		  });
		  
		});


		
		
			
		getPushList();
		
		if(ilsumd == 1){
			//일수 올림
			$("#ilsudown").attr("class","whiteBtn");
			$("#ilsuup").attr("class","greenBtn");
			$("#ilsunew").attr("class","whiteBtn");
		}else if(ilsumd == 0){
			//일수 다운
			$("#ilsudown").attr("class", "greenBtn");
			$("#ilsuup").attr("class", "whiteBtn");
			$("#ilsunew").attr("class","whiteBtn");
		}else{
			$("#ilsudown").attr("class", "whiteBtn");
			$("#ilsuup").attr("class", "whiteBtn");
			$("#ilsunew").attr("class","greenBtn");
		}
		
		
		

    </script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>
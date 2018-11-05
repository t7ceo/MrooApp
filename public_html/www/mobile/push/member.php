<?
include './allphpfile/config.php';
//include 'util.php';
include './allphpfile/gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련

	

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
	
	$memid = $_SESSION["memid"];
	if(!$_SESSION["mempo"]) $mpo = "0";
	else $mpo = $_SESSION["mempo"];
	
	$addon = 0;
	if($_GET["addon"]) $addon = $_GET["addon"];
	

?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title>회원관리</title>

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
		var nnt = <?=$ntime?>;
		var gurl = "<?=$gurl?>";
		var lk = "<?=$gurl?>/app/push/images/";
		var editId = <?=$vid?>;
		var findg = "<?=$findg?>";
		var ilsumd = <?=$ilsumd?>;
		var all_path = "<?=$all_path?>";
		var memid = "<?=$memid?>";
		var mempo = <?=$mpo?>;
		var addon = <?=$addon?>;
		
		
    </script>
	<script src="./util.js"></script>

</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="AdInput">
    
        <div class="GmStrMenuHead" style="text-align:center;"><h2><?=$membertit?></h2></div>
                

                
        <div class="pageBodyR">
       		<form name="memberOn" action="<?=$all_path?>memOn_inprocess.php" method="post">
            
            <table border="0" width="90%" style="margin:5px 5%;">
                <tr>
                    <td>신규 아이디</td>
                    <td><input type="email" name="memid" id="memid" value="" placeholder="전화번호를 아이디로 사용" /></td>
                    <td align="center"></td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                    <td>등록자 아이디</td>
                    <td colspan="3"><input type="email" name="wmemid" id="wmemid" value="<?=$memid?>" placeholder="등록자아이디" /></td>                
                </tr>  
                <tr>
                    <td>비밀번호</td>
                    <td colspan="2"><input type="password" name="pass1" id="pass1" value="" placeholder="비밀번호" /></td>
                   	<td>&nbsp;&nbsp;&nbsp;</td>
                    <td>비밀번호 확인</td>
                    <td colspan="3"><input type="password" name="pass2" id="pass2" value="" placeholder="비밀번호확인" /></td>                    
                </tr>

            </table>
			</form>
    
          </div>
    
        <div style="width:90%; margin:10px 4%; text-align:center;">
        	<table width="100%">
            <tr>
            <td>
            	<input type="button" value="메인으로 돌아가기" style="margin:5px auto;" class="whiteBtn" onclick="goPage('mmsset')">
            </td>
            <td>
            	<input type="button" value="회원등록" style="margin:5px auto;" class="whiteBtn" onclick="input_memon()">
            </td>
            <td>
            	<input type="button" value="전체리스트 보기" class="whiteBtn" style="margin:5px auto;" onclick="cfindAll(2)">
            </td>
            <td>
            	<input type="text" name="findg" id="findg" value="" style="margin:5px auto;" placeholder="검색어" />
            </td>
            <td width="10%">
            	<input type="button" value="검색" class="whiteBtn" style="margin:5px auto;" onclick="cfind(2)">
            </td>
            </tr></table>
			
        </div>
        
        
        <div id="pushSendList" style="width:100%;">
        </div>
        
        
    
    </div>


	<script type="text/javascript">


		document.getElementById("findg").value = findg;
		
		
		if(addon == 1){
			alert("회원 등록 완료 하였습니다.");
		}else if(addon == 2){
			alert("이미 등록된 아이디 입니다. 검색 후 사용하세요.");
		}
		
		
		
		//회원 리스트를 가져온다.
		getMember();
		
		
	</script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>
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

?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title>수신거부설정</title>

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
    </script>
	<script src="./util.js"></script>

</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="AdInput">
    
        <div class="GmStrMenuHead" style="text-align:center;"><h2><?=$susinnotit?></h2></div>
                

                
        <div class="pageBodyR">
       		<form name="notel" action="<?=$all_path?>notel_inprocess.php" method="post">
            
            <table border="0" width="90%" style="margin:5px 5%;">
                <tr>
                    <td>거부번호</td>
                    <td><input type="email" name="tel" id="tel" value="" placeholder="수신거부번호" /></td>
                    <td align="center"></td>
                    <td></td>
                    <td align="center"></td>
                    <td></td>                
                    <td align="center"></td>
                    <td></td>
                </tr>  
                <tr>
                    <td>메모</td>
                    <!--<td colspan="7"><input type="text" name="gtit1" id="gtit1" value="" placeholder="MMS내용" /></td>-->
                    <td colspan="7"><textarea name="gtit1" id="gtit1" rows="6"></textarea></td>
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
            	<input type="button" value="거부등록" style="margin:5px auto;" class="whiteBtn" onclick="input_susinno()">
            </td>
            <td>
            	<input type="button" value="전체리스트 보기" class="whiteBtn" style="margin:5px auto;" onclick="cfindAll(3)">
            </td>
            <td>
            	<input type="text" name="findg" id="findg" value="" style="margin:5px auto;" placeholder="검색어" />
            </td>
            <td width="10%">
            	<input type="button" value="검색" class="whiteBtn" style="margin:5px auto;" onclick="cfind(3)">
            </td>
            </tr></table>
			
        </div>
        
        
        <div id="pushSendList" style="width:100%;">
        </div>
        
        
    
    </div>


	<script type="text/javascript">


		document.getElementById("findg").value = findg;
		
	
		
		//수신거부 리스트를 가져온다.
		getSusinNo();
		
		
	</script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>
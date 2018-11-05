<?
include './allphpfile/config.php';
//include 'util.php';
include './allphpfile/gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //부모 클래스
include_once './allphpfile/class/member_admin.php';      //회원 관련

	

	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	$udid = $_GET[uiu];
	
	$ss = "select * from Anyting_gcmid where udid = '".$udid."' ";
	$aa = mysql_query($ss, $rs);
	$susin = "수신거부";
	while($row = mysql_fetch_array($aa)){
		if($row[bell] == 1) $susin = "푸시수신";
	}
	
	$ntime = mktime();
?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="euc-kr">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
	<title></title>


	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.css" /> 	
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.structure-1.4.0.min.css" />
	<link rel="stylesheet" href="./allphpfile/jquery-mobile/jquery.mobile.theme-1.4.0.min.css" />
	
    <link rel="stylesheet" href="./allphpfile/apis/getmoney.css" />

	<script src="./allphpfile/jquery-mobile/jquery-1.10.2.min.js"></script>
	<script src="./allphpfile/jquery-mobile/jquery.mobile-1.4.0.min.js"></script>


</head>


<body  topmargin="0" leftmargin="0" width="100%">


    <div data-role="page" id="pushList">

		<table cellpadding="0" cellspacing="0" border="0" style="width:90%; margin:35px 5%;">
        <tr><td style="padding:10px 5px; text-align:right;">현재상태 : </td><td id="nowinf" style="padding:10px 5px; text-align:left;"><?=$susin?></td></tr>
        <tr><td><input type="button" value="푸시수신" onClick="setPush(1)"></td><td><input type="button" value="수신거부" onClick="setPush(0)"></td></tr>
        </table>


        
    
    </div>

	<script type="text/javascript">
		String.prototype.replaceAll = replaceAll;
		
		
		var proje = "<?=$project?>";
		var nnt = <?=$ntime?>;

		
		function setPush(md){
		
			var qr = "<?=$all_path?>setpush.php";
			var param = "uiu=<?=$udid?>&md="+md;
			//alert(param);
			var chn = input_smstext(param,0);
			$.ajax({type:"GET", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				
				
				if(md == 0){
					alert("수신거부 설정 완료하였습니다.");
					document.getElementById("nowinf").innerHTML = "수신거부";
				}else{
					alert("수신 설정 완료하였습니다.");
					document.getElementById("nowinf").innerHTML = "푸시수신";
				}
				
				
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});
		
		}

		
		
		function replaceAll(str1, str2){
			var strTemp = this;
			strTemp = strTemp.replace(new RegExp(str1, "g"), str2);
			return strTemp;
		}

		//메세지 전송 관련 글자 입력
		function input_smstext(str,tsu){
			
			var ss = encodeURI(str);
			var rst = encodeURI(ss);
			
			
			return rst;
		}
		
		
		//모든 내용 출력
		function disp_smstext1(str,tsu){
		
			var rst = decodeURI(str);
			
			//&기호 처리
			rst = rst.replaceAll("~and~", "&");
			rst = rst.replaceAll("~pls~", "+");
		
			
			return rst;
		}
		


    </script>



</body>

</html>

<?

	$mycon->sql_close();

	echo($jsongab);
?>
<?
include './allphpfile/config.php';
//include 'util.php';
include './allphpfile/gcmutil.php';
include_once './allphpfile/class/class_mysql.php';   //�θ� Ŭ����
include_once './allphpfile/class/member_admin.php';      //ȸ�� ����

	

	$mycon = new Member;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);

	$udid = $_GET[uiu];
	
	$ss = "select * from Anyting_gcmid where udid = '".$udid."' ";
	$aa = mysql_query($ss, $rs);
	$susin = "���Űź�";
	while($row = mysql_fetch_array($aa)){
		if($row[bell] == 1) $susin = "Ǫ�ü���";
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
        <tr><td style="padding:10px 5px; text-align:right;">������� : </td><td id="nowinf" style="padding:10px 5px; text-align:left;"><?=$susin?></td></tr>
        <tr><td><input type="button" value="Ǫ�ü���" onClick="setPush(1)"></td><td><input type="button" value="���Űź�" onClick="setPush(0)"></td></tr>
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
					alert("���Űź� ���� �Ϸ��Ͽ����ϴ�.");
					document.getElementById("nowinf").innerHTML = "���Űź�";
				}else{
					alert("���� ���� �Ϸ��Ͽ����ϴ�.");
					document.getElementById("nowinf").innerHTML = "Ǫ�ü���";
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

		//�޼��� ���� ���� ���� �Է�
		function input_smstext(str,tsu){
			
			var ss = encodeURI(str);
			var rst = encodeURI(ss);
			
			
			return rst;
		}
		
		
		//��� ���� ���
		function disp_smstext1(str,tsu){
		
			var rst = decodeURI(str);
			
			//&��ȣ ó��
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
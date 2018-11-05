<?
include './allphpfile/config.php';
include './allphpfile/util.php';
include_once './allphpfile/xmlrpc.inc'; 
include_once './allphpfile/class/class_mysql.php';  //부모 클래스
include_once './allphpfile/class/my_mysql.php';      //자식 클래스

include_once './allphpfile/class/naverLogin.php';      //네입 로그인 관련 처리


	$mycon = new MyMySQL;
	$rs = $mycon->connect($host,$dbid,$dbpass);
	$mycon->select($dbname);


	switch($_POST['mode']){
	case "fileDown":
	
		$fp = fopen("/sohoring/loca.jpg", "w");
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $_POST['fnam']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)");
		curl_setopt($ch, CURLOPT_FILE, $fp);
		
		curl_exec($ch);
		
		fclose($fp);
		curl_close($ch);
		
	
		$jsongab = '{"rs":"ok"}';
	
	break;
	case "stateTk":
	
	
		$request = new OAuthRequest( $client_id, $clientSecret, $nid_RedirectURL);
		$state = $request -> set_state();
		$ll = $request -> get_request_url();
	
	
		$jsongab = '{"rs":"ok", "state":"'.$state.'", "ll":"'.$ll.'"}';
	
	break;
	case "getIdNicName":
	
		$jsongab = '{"rs":"ok", "memid":"'.$_SESSION['memid'].'", "nicnam":"'.$_SESSION['nicname'].'", "st":"'.$_SESSION['state'].'"}';
		
	break;
	case "textBlogOn":
	
	
		$tit =  rawurldecode($_POST['tit']); //rawurldecode($tit);
			
		$memo = rawurldecode($_POST['cont']); //rawurldecode($memo);
		$memo = str_replace("\n", "<br />",$memo);
		
		$memo .= "<br><br><div style='width:96%; padding:10px 0; text-align:center; border:#ccc 1px solid;'><span>담당자 : ".trim($_POST['tel'])."</span>"; 
		$memo .= "&nbsp;&nbsp;&nbsp;&nbsp;<span>지점 : ".trim($_POST['cotel'])."</span></div>";
		
		
		$memo .= "<br><br><div>메인이미지</div>"; //$_POST['img'];

	
		$cate = rawurldecode($_POST['cate']);
	
	
		$ad_date = date("Y-m-d");

				
		$imgg = explode("^^", $_POST['img']);
		$su = count($imgg) - 1;
		
		$mm = "";
		for($c = 0; $c < $su; $c++){
			if($c > 0) $mm .= "<br>이미지".$c."<br>";
			$mm .= "<a href='#'><img src='".$imgg[$c]."' style='width:100%; margin:0 0 10px;'></a><br>";
		}
				

		//newPost($tit, $memo.$mm, $cate, "handeultalk", "9fc275e6f793dbd1090318ae60a19935");	
		
		
		$jsongab = '{"rs":"ok"}';
	
	
	break;
	}


	$mycon->sql_close();	


	echo($jsongab);
?>
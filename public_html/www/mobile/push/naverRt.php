<?
include './allphpfile/config.php';
include './allphpfile/util.php';
include_once './allphpfile/class/class_mysql.php';  //부모 클래스
include_once './allphpfile/class/my_mysql.php';      //자식 클래스


include_once './allphpfile/class/naverLogin.php';      //네입 로그인 관련 처리


header("Content-Type: text/html; charset=UTF-8");


	//네이버 로그인 완료된 상태에서 이쪽으로  온다.
	//회원의 로그인 정보를 DB에 저장하고 뒤로 돌아 간다.
	
	$request = new OAuthRequest( $client_id, $clientSecret, $nid_RedirectURL );
	$request -> call_accesstoken();
	$request -> get_user_profile();



	//정보를 세션에 저장한다.
	$_SESSION['memid'] = $request->get_userID();
	$_SESSION['nicname'] = $request->get_nickname();
	
	
/*	
	if($request->state == $_SESSION['state']) {
		$r = new HttpRequest($access_token_url, HttpRequest::METH_GET);

		$r->addQueryData(array(
		'client_id' => $client_id,
		'client_secret' => $clientSecret,
		'grant_type' => 'authorization_code',
		'state' => $request->state,
		'code' => $request->code
		));

		$r -> addSslOptions(array(
		'version' => HttpRequest::SSL_VERSION_SSLv3
		));

		$auth_token_result = json_decode($r->send()->getBody());

		if($auth_token_result->access_token) {
			// 튜토리얼에서는 access_token값만 사용하였지만 실제 어플레케이션에서는 유효 기간 관리가 필요합니다.
			$_SESSION['access_token'] = $auth_token_result->access_token;
	
			echo "tk=".$auth_token_result->access_token;
			//header('Location: ' . $index_uri);
		} else {
			echo '인증 실패했습니다.';
		}

	} else {
		echo '인증 실패했습니다.';
	}


*/

	//echo $request->state."/".$_SESSION['state']."===".$request->code;



	//$jsongab = '{"rs":"rtok", "id":"'.$request->get_userID().'", "st3":"'.$_SESSION['state'].'"}';
	

/*
	$ss = "<script>history.go(-1);</script>";
	echo $ss;
*/


?>
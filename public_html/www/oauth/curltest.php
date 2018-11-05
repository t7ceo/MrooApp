<?

$CLIENT_ID     = '3d838f8ddb54a3490cacb6cbf769ab36';
$REDIRECT_URI  = 'http://mroo.co.kr/oauthkk';
$params = "?client_id=".$CLIENT_ID."&redirect_uri=".$REDIRECT_URI."&response_type=code";
$url = 'https://kauth.kakao.com/oauth/authorize' . $params;

$s = curl_init();
curl_setopt($s, CURLOPT_URL, $url);
curl_setopt($s, CURLOPT_POST, false);
curl_setopt($s, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($s);


$status_code = curl_getinfo($s, CURLINFO_HTTP_CODE);
curl_close($s);

echo '[Status] ' .$status_code;
echo ' [Result] ' . $result;


/*

// Step 1
$cSession = curl_init(); 
// Step 2




$post_param = "?grant_type=authorization_code";
$post_param = "&client_id=3d838f8ddb54a3490cacb6cbf769ab36";
$post_param = "&redirect_uri=http://mroo.co.kr/oauth";
$post_param = "&code=GGIX6h15K9iTl3gWhG7SMSPHvNbiQoakzHNCmAopdgcAAAFkXwG7uw";




curl_setopt($cSession,CURLOPT_URL,"https://kapi.kakao.com/v1/user/signup".$post_param);
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_POST, false); 
//curl_setopt($cSession,CURLOPT_HTTPHEADER, false); 

//curl_setopt($cSession, CURLOPT_POSTFIELDS, $post_param);
$response = curl_exec($cSession);
curl_close($cSession);


// Step 5
echo $response;
*/

?>
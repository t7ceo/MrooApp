<?
//=================================================================
ob_start();
session_start();
//=================================================================

//=================================================================
//=================================================================
$host="localhost";
$dbid="toadsys";
$dbpass="toadsys8700!";
$dbname="toadsys";

$urlPath="mroo.co.kr";        //url
$all_path = "http://".$urlPath."/mobile/push/allphpfile/";
$psimgpath = "http://".$urlPath."/mobile/push/images/";
$project = "nowField";
$tit = "MMS설정 및 발송";
$susinnotit = "수신거부 등록";
$membertit = "회원관리";
$gurl = "http://".$urlPath;   //푸시 보기시 보여지는 링크
//================================================================



$my_path = "../allphpfile/";
$my_imgpath = "../images/";

//푸시를 발송한 경우 같은 번호에 다시 푸시 발송 가능할때 까지 기다리는 초단위 시간
$mmsSendNoTime = 10;

//네이버 로그인관련===================================
$client_id = "";
$clientSecret = "";
$nid_RedirectURL = $gurl."/mobile/push/naverRt.php";
//====================================================
//네이버 불르그 관련
//=================================================
$authorize_url = 'https://nid.naver.com/oauth2.0/authorize';
$access_token_url = 'https://nid.naver.com/oauth2.0/token';
$index_uri = ''; // tutorial에서는 "도메인주소/index.php"


$list_category_api_uri = 'https://openapi.naver.com/blog/listCategory.json';
$write_post_api_uri = 'https://openapi.naver.com/blog/writePost.json';
//==============================================================================




?>

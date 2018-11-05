<?



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
<title>Login Demo - Kakao JavaScript SDK</title>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

</head>
<body>
<a id="kakao-login-btn"></a>
<a href="http://developers.kakao.com/logout"></a>
<script type='text/javascript'>
  //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('YOUR APP KEY');
    // 카카오 로그인 버튼을 생성합니다.
    Kakao.Auth.createLoginButton({
      container: '#kakao-login-btn',
      success: function(authObj) {
        alert(JSON.stringify(authObj));
      },
      fail: function(err) {
         alert(JSON.stringify(err));
      }
    });
  //]]>
</script>

</body>
</html>
위 예제의 데모를 바로 확인해 보세요! 데모 보러가기

로그인과 관련된 자세한 내용이 궁금하다면? Kakao.Auth 레퍼런스


예제: 커스톰 로그인 버튼을 이용한 카카오 로그인Copy URL
커스톰 로그인 버튼과 카카오 로그인을 연결하는 예제입니다.
직접 로그인 버튼을 제작할 필요가 없는 경우에는 로그인 버튼 추가 를 참조하세요.
카카오 로그인 버튼 이미지는 여기에서 다운로드 할 수 있습니다.
앱 등록 과정을 통해 도메인을 등록해야 합니다.
'YOUR APP KEY'를 등록한 앱의 JavaScript 키로 변경해 주세요.
커스톰 로그인 버튼을 추가하고, 로그인 성공 시 액세스 토큰을 알림창으로 출력합니다.

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
<title>Custom Login Demo - Kakao JavaScript SDK</title>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

</head>
<body>
<a id="custom-login-btn" href="javascript:loginWithKakao()">
<img src="//mud-kage.kakao.com/14/dn/btqbjxsO6vP/KPiGpdnsubSq3a0PHEGUK1/o.jpg" width="300"/>
</a>
<script type='text/javascript'>
  //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('4bcc362eec4026e4ea9481bcddaf2978');
    function loginWithKakao() {
      // 로그인 창을 띄웁니다.
      Kakao.Auth.login({
        success: function(authObj) {
          alert(JSON.stringify(authObj));
        },
        fail: function(err) {
          alert(JSON.stringify(err));
        }
      });
    };
  //]]>
</script>

</body>
</html>
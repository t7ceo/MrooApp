<?php
/**
 * 본인 인증 유틸리티 클래스
 * @file    Cert.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Cert
{
    /**
     * 휴대폰 본인 인증 요청
     * @param array $data
     * @return array
     */
    public static function requestPhone($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // API별로 실행
        if (PHONE_API == 'okname') {
            $result = static::requestPhoneOkName($data);
        }

        return $result;
    }

    /**
     * 휴대폰 본인 인증 응답
     * @param array $data
     * @return array
     */
    public static function responsePhone($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // API별로 실행
        if (PHONE_API == 'okname') {
            $result = static::responsePhoneOkName($data);
        }

        return $result;
    }

    /**
     * 휴대폰 > 오케이네임 본인 인증 요청
     * @param array $data
     * @return array
     */
    private static function requestPhoneOkName($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // API 요청 경로
        $request_uri = 'http://safe.ok-name.co.kr/KcbWebService/OkNameService';
        $action_uri = 'https://safe.ok-name.co.kr/CommonSvl';
        if (PHONE_MODE == 'test') {
            $request_uri = 'http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService';
            $action_uri = 'https://tsafe.ok-name.co.kr:2443/CommonSvl';
        }

        // API 요청모드
        $req_mode = 'QU';
        $req_mode .= (LOG_CERTIFICATION) ? 'D' : 'L';
        File::makeDirectory(LOG_PATH . '/certification');

        $ct_id = Str::makeTimeCode();

        // 전송 데이터 세팅
        $arr = array(
            $ct_id,                                                                     // 0. 고유번호
            Str::getWithoutNull($data['ct_name'], 'x'),                              // 1. 이름
            $data['ct_birthday'] = Str::getWithoutNull($data['ct_birthday'], 'x'),   // 2. 생년월일
            $data['ct_gender'] = Str::getWithoutNull($data['ct_gender'], 'x'),       // 3. 성별
            $data['ct_nation'] = Str::getWithoutNull($data['ct_nation'], 'x'),       // 4. 내외국인구분
            $data['ct_company'] = Str::getWithoutNull($data['ct_company'], 'x'),     // 5. 이통사
            $data['ct_phone'] = Str::getWithoutNull($data['ct_phone'], 'x'),             // 6. 휴대폰번호
            $data['ct_etc1'],                                                           // 7. 토큰
            $data['ct_etc2'],                                                           // 8. 추가컬럼1
            $data['ct_etc3'],                                                           // 9. 추가컬럼2
            'x',                                                                        // 10. 리턴 메시지
            $data['return_uri'],                                                        // 11. 리턴 URI
            Str::getWithoutNull($data['ct_req_type'], '0'),                          // 12. 입력유형
            '10',                                                                       // 13. 인증수단 (휴대폰)
            Str::getWithoutNull($data['ct_req_reason'], '10'),                       // 14. 요청사유
            PHONE_KEY,                                                                  // 15. API 키
            'x',                                                                        // 16. 서버 아이피
            HOMEPAGE_TITLE,                                                             // 17. 발송자정보
            $request_uri,                                                               // 18. 요청 URI
            LOG_PATH . '/certification',                                                // 19. 로그 경로
            $req_mode                                                                   // 20. 요청 모드
        );

        // 이름 유효성 검사
        if ($arr[1] != 'x' && preg_match('~[^\x{ac00}-\x{d7af}a-zA-Z ]~u', $arr[1])) {
            $result['msg'] = '이름이 유효하지 않습니다.';
            return $result;
        }

        // 생년월일 유효성 검사
        if ($arr[2] != 'x' && preg_match('~[^0-9]~', $arr[2])) {
            $result['msg'] = '생년월일이 유효하지 않습니다.';
            return $result;
        }

        // 성별 유효성 검사
        if ($arr[3] != 'x' && preg_match('~[^01]~', $arr[3])) {
            $result['msg'] = '성별이 유효하지 않습니다.';
            return $result;
        }

        // 내외국인 구분 유효성 검사
        if ($arr[4] != 'x' && preg_match('~[^12]~', $arr[4])) {
            $result['msg'] = '내외국인 구분이 유효하지 않습니다.';
            return $result;
        }

        // 이통사코드 유효성 검사
        if ($arr[5] != 'x' && preg_match('~[^0-9]~', $arr[5])) {
            $result['msg'] = '통신사 코드가 유효하지 않습니다.';
            return $result;
        }

        // 휴대폰 번호 유효성 검사
        if ($arr[6] != 'x' && preg_match('~[^0-9]~', $arr[6])) {
            $result['msg'] = '휴대폰번호가가 유효하지 않니다.';
            return $result;
        }

        // 입력유형 유효성 검사
        if (preg_match('~[^0-9]~', $arr[12])) {
            $result['msg'] = '입력유형이 유효하지 않습니다.';
            return $result;
        }

        // 요청사유 유효성 검사
        if (preg_match('~[^0-9]~', $arr[14])) {
            $result['msg'] = '입력유형이 유효하지 않습니다.';
            return $result;
        }

        // API 키 유효성 검사
        if (!$arr[15]) {
            $result['msg'] = 'API키가 유효하지 않습니다.';
            return $result;
        }

        // 리턴 URI
        if (!$arr[11]) {
            print_r($data);
            $result['msg'] = '리턴 URI가 유효하지 않습니다.';
            return $result;
        }

        // 요청 URI
        if (!$arr[18]) {
            $result['msg'] = '요청 URI가 유효하지 않습니다.';
            return $result;
        }

        // 액션 URI
        if (!$action_uri) {
            $result['msg'] = '액션 URI가 유효하지 않습니다.';
            return $result;
        }

        // 암호화
        $output = null;
        //print_r($arr); exit;
        $cert_result = okname($arr, $output);
        if ($cert_result == 0) {
            // 성공
            $cert_data = explode("\n", $output);
            $cert_code = $cert_data[0];
            $cert_msg = $cert_data[1];
            $enc_str = $cert_data[2];
            if ($cert_code != 'B000') {
                $result['msg'] = 'Error Code : ' . $cert_code . "\n" . $cert_msg;
                return $result;
            }
        } elseif ($cert_result <= 200) {
            $result['msg'] = 'Error Code : ' . sprintf("B%03d", $cert_result) . "\n모듈 실행과정에 오류가 발생하였습니다.";
            return $result;
        } else {
            $result['msg'] = 'Error Code : ' . sprintf("S%03d", $cert_result) . "\n모듈 실행과정에 오류가 발생하였습니다.";
            return $result;
        }

        $content = '<form name="cert_form" method="post" action="' . $action_uri . '">' . "\n";
        $content .= '<input type="hidden" name="tc" ';
        $content .= 'value="kcb.oknm.online.safehscert.popup.cmd.P901_CertChoiceCmd" />' . "\n";
        $content .= '<input type="hidden" name="rqst_data"				value="' . $enc_str . '" />' . "\n";
        $content .= '</form>' . "\n";
        $content .= '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'document.cert_form.submit();' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";

        $result['code'] = 'success';
        $result['content'] = $content;

        // 토큰 생성
        Session::setSession('ss_cert_token', $ct_id);

        return $result;
    }

    /**
     * 휴대폰 > 오케이네임 본인 인증 응답
     * @param array $data
     * @return array
     */
    private static function responsePhoneOkName($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // API 요청 경로
        File::makeDirectory(KEY_PATH . '/certification');
        $key_path = KEY_PATH . '/certification/safecert_' . PHONE_KEY;
        $request_uri = 'http://safe.ok-name.co.kr/KcbWebService/OkNameService';
        if (PHONE_MODE == 'test') {
            $key_path .= '_test';
            $request_uri = 'http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService';
        }
        $key_path .= '.key';

        // API 요청모드
        $req_mode = 'SU';
        $req_mode .= (LOG_CERTIFICATION) ? 'D' : 'L';

        $arr = array(
            $key_path,                      // 0. 키파일 경로
            PHONE_KEY,                      // 1. API 키
            $request_uri,                   // 2. 요청 URI
            trim($_POST['WEBPUBKEY']),      // 3. 공개키
            trim($_POST['WEBSIGNATURE']),   // 4. 서명값
            $_POST['encInfo'],              // 5. 암호와 문자열
            LOG_PATH . '/certification',    // 6. 로그 경로
            $req_mode                       // 7. 요청 모드
        );

        // 공개키 유효성 검사
        if (preg_match('~[^0-9a-zA-Z+/=]~', $arr[3])) {
            $result['msg'] = '공개키가 유효하지 않습니다.';
            return $result;
        }

        // 서명값 유효성 검사
        if (preg_match('~[^0-9a-zA-Z+/=]~', $arr[4])) {
            $result['msg'] = '서명값이 유효하지 않습니다.';
            return $result;
        }

        // 암호화 문자열 유효성 검사
        if (preg_match('~[^0-9a-zA-Z+/=]~', $arr[5])) {
            $result['msg'] = '암호화 문자열이 유효하지 않습니다.';
            return $result;
        }

        // 복호화
        $output = null;
        $cert_result = okname($arr, $output);

        if ($cert_result == 0) {
            // 성공
            $cert_data = explode("\n", $output);
            $cert_code = $cert_data[0];
            $cert_msg = $cert_data[1];
            if ($cert_code != 'B000') {
                $result['msg'] = 'Error Code : ' . $cert_code . "\n" . $cert_msg;
                return $result;
            }
        } elseif ($cert_result <= 200) {
            $result['msg'] = 'Error Code : ' . sprintf("B%03d", $cert_result) . "\n모듈 실행과정에 오류가 발생하였습니다.";
            return $result;
        } else {
            $result['msg'] = 'Error Code : ' . sprintf("S%03d", $cert_result) . "\n모듈 실행과정에 오류가 발생하였습니다.";
            return $result;
        }

        // 토큰 검증
        $ct_id = $cert_data[2];
        $ss_cert_token = Session::getSession('ss_cert_token');
        if ($ct_id != $ss_cert_token) {
            $result['msg'] = '토큰이 유효하지 않습니다.';
            //$result['msg'] .= "\n" . $ct_id . ' / ' . $ss_cert_token;
            return $result;
        }

        $ct_di = $cert_data[4];
        $ct_ci = $cert_data[5];
        $ct_name = $cert_data[7];
        $ct_birthday = $cert_data[8];
        $ct_gender = ($cert_data[9] == '1') ? 'M' : 'F';
        $ct_nation = ($cert_data[10] == '1') ? 'N' : 'F';
        $ct_phone = $cert_data[12];

        $ct_etc1 = $cert_data[13];
        $ct_etc2 = $cert_data[14];
        $ct_etc3 = $cert_data[15];

        $return_uri = Session::getSession('ss_return_uri');
        
        $content = '<form name="cert_form" method="post" action="' . $return_uri . '">' . "\n";
        $content .= '<input type="hidden" name="ct_di" value="' . $ct_di . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_ci" value="' . $ct_ci . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_name" value="' . $ct_name . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_birthday" value="' . $ct_birthday . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_gender" value="' . $ct_gender . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_nation" value="' . $ct_nation . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_phone" value="' . $ct_phone . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_etc1" value="' . $ct_etc1 . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_etc2" value="' . $ct_etc2 . '" />' . "\n";
        $content .= '<input type="hidden" name="ct_etc3" value="' . $ct_etc3 . '" />' . "\n";
        $content .= '</form>' . "\n";
        $content .= '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'document.cert_form.submit();' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";

        $result['code'] = 'success';
        $result['content'] = $content;

        Session::setSession('ss_cert_token', null);
        Session::setSession('ss_return_uri', null);

        return $result;
    }
}

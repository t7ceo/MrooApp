<?php
/**
 * 메시지 유틸리티 클래스
 * @file    Msg.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Msg
{
    /**
     * DB 정보 (Table, PK)
     * @var string
     */
    public static $sms_table = 'tbl_sms';
    public static $email_table = 'tbl_email';

    /**
     * SMS 발송
     * @param array $arr
     * @return array
     */
    public static function sendSms($arr)
    {
        $arr = self::convertSms($arr);
        $result = self::validateSms($arr);
        if ($result['code'] == 'failure') {
            return $result;
        }

        return self::sendSmsByCurl($arr);
    }

    /**
     * SMS 발송 정보 변환
     * @param array $arr
     * @return array
     */
    private function convertSms($arr)
    {
        // 발신번호
        $arr['sm_sender_no'] = SMS_SENDER;
        $arr['sm_sender_no'] = str_replace('-', '', $arr['sm_sender_no']);
        $arr['sm_sender_no'] = str_replace('.', '', $arr['sm_sender_no']);
        $arr['sm_sender_no'] = str_replace(' ', '', $arr['sm_sender_no']);

        // 수신번호
        $arr['sm_receiver_no'] = str_replace('-', '', $arr['sm_receiver_no']);
        $arr['sm_receiver_no'] = str_replace('.', '', $arr['sm_receiver_no']);
        $arr['sm_receiver_no'] = str_replace(' ', '', $arr['sm_receiver_no']);

        return $arr;
    }

    /**
     * SMS 발송 정보 유효성 검사
     * @param array $arr
     * @return array
     */
    private function validateSms($arr)
    {
        $result = array(
            'code' => 'failure'
        );

        // 발신번호 검사
        if (!$arr['sm_sender_no']) {
            $result['msg'] = '발신번호가 유효하지 않습니다.';
            return $result;
        }

        if ($arr['sm_sender_no'] != SMS_SENDER) {
            $result['msg'] = '발신번호가 유효하지 않습니다.';
            return $result;
        }

        // 수신번호 검사
        if (!$arr['sm_receiver_no'] || preg_match("/[^0-9]+/i", $arr['sm_receiver_no'])) {
            $result['msg'] = '수신번호가 유효하지 않습니다.';
            return $result;
        }

        // 메시지내용
        if (!$arr['sm_content']) {
            $result['msg'] = '메시지 내용이 유효하지 않습니다.';
            return $result;
        }

        $result['code'] = 'success';
        return $result;
    }

    /**
     * CURL을 통해 SMS 발송 정보 전송
     * @param array $arr
     * @return array
     */
    private function sendSmsByCurl($arr)
    {
        /*$result = array(
            'code'  => 'failure'
        );

        $uri = SMS_URI;
        $uri = str_replace('{sm_sender_no}', $arr['sm_sender_no'], $uri);
        $uri = str_replace('{sm_receiver_no}', $arr['sm_receiver_no'], $uri);
        $uri = str_replace('{sm_content}', urlencode(iconv('UTF-8', 'EUC-KR', $arr['sm_content'])), $uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $send_result = curl_exec($ch);
        curl_close($ch);
        $xml_arr = json_decode(json_encode(simplexml_load_string($send_result)), true);

        if ($xml_arr[0] == 'OK') {
            $result['code'] = 'success';
            $arr['sm_state'] = 'S';
        } else {
            $arr['sm_state'] = 'F';
            $result['msg'] = '발송이 실패하였습니다.';
        }

        global $member;
        $arr['reg_id'] = $member['mb_id'];
        $arr['reg_time'] = NOW_DATETIME;
        Db::insertByArray(static::$sms_table, $arr);

        return $result;*/
    }
}

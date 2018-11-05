<?php
/**
 * OTP 유틸리티 클래스
 * @file    Otp.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Otp
{
    /**
     * DB 정보 (Table, PK)
     * @var string
     */
    public static $otp_table = 'tbl_otp';
    public static $otp_pk = 'ot_id';

    /**
     * OTP 발송
     * @param array $data
     * @return array
     */
    public static function sendOtp($data)
    {
        $ot_type = $data['ot_type'];
        $ot_target = $data['ot_target'];
        $ot_name = $data['ot_name'];

        // 동일한 5분 이내에 아이피로 이미 인증 시도를 했는지 검사
        $db_where = "WHERE ot_type = '$ot_type' AND ot_ip = '" . USER_IP . "' ";
        $chk_time = date('Y-m-d H:i:s', strtotime(NOW_DATETIME) - 5 * 60);
        $cnt = Db::selectCount(static::$otp_table, $db_where . "AND reg_time >= '$chk_time'");
        if ($cnt > 5) {
            $result = array(
                'code'  => 'failure',
                'msg'   => "동일한 아이피에서 인증 시도를 너무 많이 요청하였습니다.\n잠시 후 다시 시도해주세요."
            );
            return $result;
        }

        $ot_no = Str::makeRandString(6);
        if ($ot_type == 'S') {
            $sm_content = '[' . HOMEPAGE_TITLE . '] ';
            $sm_content .= '인증번호 [ ' . $ot_no . ' ]를 입력해주세요.';

            $sms_arr = array(
                'sm_receiver_no'    => $ot_target,
                'sm_receiver_name'  => $ot_name,
                'sm_content'    => $sm_content
            );
            $result = Msg::sendSms($sms_arr);
            if ($result['code'] == 'failure') {
                return $result;
            }
        } elseif ($ot_type == 'E') {
            // toto
        }
        Db::update(static::$otp_table, "ot_state = 'E'", $db_where . " AND ot_target = '$ot_target' ");

        global $member;
        $arr = array(
            'ot_type'   => $ot_type,
            'ot_target' => $ot_target,
            'ot_ip' => USER_IP,
            'ot_no' => $ot_no,
            'ot_state'  => 'W',
            'ot_attempt'    => 0,
            'reg_id'    => $member['mb_id'],
            'reg_time'  => NOW_DATETIME
        );
        Db::insertByArray(static::$otp_table, $arr);

        $result = array(
            'code'  => 'success',
            'msg'   => "인증번호를 발송하였습니다.\n인증번호를 정확히 입력해주세요." . "\n" . $ot_no
        );

        return $result;
    }

    /**
     * OTP 유효성 검사
     * @param array $data
     * @return array
     */
    public static function validateOtp($data)
    {
        $ot_type = $data['ot_type'];
        $ot_target = $data['ot_target'];
        $ot_no = $data['ot_no'];

        $chk_time = date('Y-m-d H:i:s', strtotime(NOW_DATETIME) - 5 * 60);
        $db_where = "WHERE reg_time >= '$chk_time' AND ot_type = '$ot_type' AND ot_ip = '" . USER_IP . "' ";
        $db_where .= "AND ot_state = 'W' AND ot_target = '$ot_target'";

        Db::update(static::$otp_table, "ot_attempt = ot_attempt + 1", $db_where);
        $data = Db::selectOnce(static::$otp_table, "*", $db_where, '');

        if ($data['ot_no'] != $ot_no) {
            if ($data['ot_attempt'] > 10) {
                Db::update(static::$otp_table, "ot_state = 'F'", $db_where);
            }

            $result = array(
                'code'  => 'failure',
                'msg'   => "인증번호가 정확하지 않습니다." . "\n" . $data['ot_no'] . ' / ' . $ot_no
            );
        } else {
            Db::update(static::$otp_table, "ot_state = 'E'", $db_where);
            $result = array(
                'code'  => 'success'
            );
        }

        return $result;
    }
}

<?php
/**
 * 문자열 유틸리티 클래스
 * @file    Str.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Str
{
    /**
     * XSS 필터링
     * @param string $str
     * @return string
     */
    public static function filterXss($str)
    {
        global $oFilter;
        if (!isset($oFilter)) {
            return $str;
        }

        $str = str_replace('<br>', '<br />', $str);
        $str = stripslashes($str);
        $str = $oFilter->purify($str);
        return addslashes($str);
    }

    /**
     * 빈값 없이 리턴
     * @param string $str
     * @param string $null
     * @return string
     */
    public static function getWithoutNull($str, $null = '-')
    {
        if (!$str || $str == '--'
            || $str == '0000-00-00' || $str == '0000-00-00 00:00:00'
            || $str == '0000.00.00' || $str == '0000.00.00 00:00:00') {
            $str = $null;
        }
        return $str;
    }

    /**
     * 텍스트 자르기
     * @param string $str
     * @param string $len
     * @param string $suffix
     * @return string
     */
    public static function cutString($str, $len, $suffix = '..')
    {
        $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
        $str_len = count($arr_str);

        if ($str_len >= $len) {
            $slice_str = array_slice($arr_str, 0, $len);
            $str = join("", $slice_str);

            $result = $str . ($str_len > $len ? $suffix : '');
        } else {
            $str = join("", $arr_str);
            $result = $str;
        }

        return $result;
    }

    /**
     * 마스킹 처리된 문자열 리턴
     * @param string $str
     * @param int $term
     * @param string $mask
     * @return string
     */
    public static function maskString($str, $term = 0, $mask = '*')
    {
        $str_len = strlen($str);
        $new_str = '';
        for ($i = 0; $i < $str_len; $i++) {
            $chr = substr($str, $i, 1);
            if ($i == 0 || $i == $str_len - 1 || $chr == '.' || $chr == '-' || ($term > 0 && $i % $term == 0)) {
                $new_str .= $chr;
            } else {
                $new_str .= $mask;
            }
        }

        return $new_str;
    }

    /**
     * 숫자를 보기 좋게 출력
     * @param float $val
     * @param int $point
     * @return string
     */
    public static function beautifyNumber($val, $point = 0)
    {
        if (!is_numeric($val)) {
            return 0;
        }
        $result = number_format($val, $point);

        for ($i = 0; $i < $point; $i++) {
            if (substr($result, -1, 1) == '0') {
                $result = substr($result, 0, strlen($result) - 1);
            }
        }

        if (substr($result, -1, 1) == '.') {
            $result = substr($result, 0, strlen($result) - 1);
        }

        return $result;
    }

    /**
     * 일시를 보기 좋게 출력
     * @param string $date_time
     * @param bool $flag_use_korean
     * @param bool $flag_timestamp
     * @return string
     */
    public static function beautifyDateTime($date_time, $flag_use_korean = false, $flag_timestamp = false)
    {
        if (!$flag_timestamp) {
            $date_time = strtotime($date_time);
        }

        if (!$date_time || ($date_time < 100000000)) {
            return  '';
        }

        if ($flag_use_korean) {
            $result = date('Y년 m월 d일', $date_time);
        } else {
            $result = date('Y.m.d', $date_time);
        }

        $week = date('w', $date_time);
        $week_arr = explode(',', '일,월,화,수,목,금,토');
        $result .= ' (' . $week_arr[$week] . ') ';

        if ($flag_use_korean) {
            $result .= date('A h시 i분', $date_time);
        } else {
            $result .= date('H:i', $date_time);
        }

        return $result;
    }

    /**
     * 파일 용량을 보기 좋게 출력
     * @param float $file_size
     * @return string
     */
    public static function beautifyFileSize($file_size)
    {
        $bf_size = null;
        $unit_arr = explode(',', ',k,m,g,t');
        for ($i = 0; $i < count($unit_arr); $i++) {
            if ($file_size < 1024) {
                $bf_size = $file_size . $unit_arr[$i];
                break;
            }
            $file_size = round($file_size / 1024, 1);
            if ($i < 2) {
                $file_size = round($file_size);
            }
        }

        return $bf_size;
    }

    /**
     * 문자열 암호화
     * @param string $str
     * @return string
     */
    public static function encryptString($str)
    {
        $str = hash('sha256', 'sFramework_' . $str, true);
        $str = base64_encode($str);

        return $str;
    }

    /**
     * 한글 1글자의 유니코드를 반환
     * @param string $ch
     * @return int
     */
    public static function getUnicode($ch)
    {
        $n = ord($ch{0});

        if ($n < 128) {
            return $n;
        }

        if ($n < 192 || $n > 253) {
            return null;
        }

        $arr = array(1 => 192,
            2 => 224,
            3 => 240,
            4 => 248,
            5 => 252,
        );

        $range = 0;
        $char = array();
        foreach ($arr as $key => $val) {
            if ($n >= $val) {
                $char[] = ord($ch{$key}) - 128;
                $range = $val;
            } else {
                break;
            }
        }

        $return_val = ($n - $range) * pow(64, count($char));

        foreach ($char as $key => $val) {
            $pow = count($char) - ($key + 1);
            $return_val += $val * pow(64, $pow);
        }

        return $return_val;
    }

    /**
     * 마지막 종성이 있는지 검사
     * @param string $str
     * @return int
     */
    public static function checkLastFinalSound($str)
    {
        $str = mb_convert_encoding($str, 'UTF-16BE', 'UTF-8');
        $str = str_split(substr($str, strlen($str) - 2));
        $code_point = (ord($str[0]) * 256) + ord($str[1]);
        if ($code_point < 44032 || $code_point > 55203) {
            return null;
        }
        return ($code_point - 44032) % 28;
    }

    /**
     * 난수 문자열 생성
     * @param int $len
     * @param int $src_type
     * @return string
     */
    public static function makeRandString($len = 6, $src_type = 0)
    {
        srand((double) microtime() * 1000000);
        $src = '0123456789';
        if ($src_type > 0) {
            $src .= 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($src_type > 1) {
            $src .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $src_arr = str_split($src);
        $last_idx = count($src_arr) - 1;

        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $src_arr[mt_rand(0, $last_idx)];
        }

        return $str;
    }

    /**
     * 시간 코드 생성
     * @return string
     */
    public static function makeTimeCode()
    {
        $str = date('ymhHis') . substr(microtime(), 2, 3);

        $code = chr(intval(substr($str, 0, 2)) + 65);  // 년
        $code .= chr(intval(substr($str, 2, 2)) + 65);  // 월
        $code .= substr($str, 4, 2);                    // 일
        $code .= chr(intval(substr($str, 6, 2)) + 65);  // 시
        $code .= substr($str, 8, 1);                    // 분
        $code .= chr(intval(substr($str, 9, 1)) + 65);
        $code .= chr(intval(substr($str, 10, 1)) + 65); // 초
        $code .= substr($str, 11, 1);
        $code .= chr(intval(substr($str, 12, 1)) + 65); // 밀리초
        $code .= substr($str, 13, 2);

        // 난수
        $code .= chr(rand(65, 90));
        $code .= chr(rand(65, 90));
        $code .= rand(0, 9);
        $code .= chr(rand(65, 90));
        $code .= chr(rand(65, 90));
        $code .= rand(0, 9);
        $code .= chr(rand(65, 90));
        $code .= chr(rand(65, 90));

        return $code;
    }

    /**
     * 시간 해시 생성
     * @return string
     */
    public static function makeTimeHash()
    {
        return md5(date('ymhHis') . substr(microtime(), 2, 3) . '_' . strval(rand(0, 99999999)));
    }
}

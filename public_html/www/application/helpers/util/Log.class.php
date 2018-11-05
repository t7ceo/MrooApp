<?php
/**
 * 로그 유틸리티 클래스
 * @file    Log.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Log
{
    /**
     * Query 로깅
     * @param string $str
     * @param array $result
     */
    public static function query($str, $result)
    {
        File::makeDirectory(LOG_PATH . '/query');
        $log_file = LOG_PATH . '/query' . '/' . str_replace('-', '.', NOW_DATE) . '.log';

        global $layout, $member;
        $mb_id = $member['mb_id'];
        if (!$mb_id) {
            $mb_id = 'guest';
        }

        $content = '[' . NOW_DATETIME . '][' . USER_IP . '][' . $layout . '][' . $mb_id . ']	' . $str . "\n";
        $content .= 'Result : ';
        if (is_object($result) || $result) {
            $content .= 'Success';
        } else {
            $content .= 'Failure';
        }
        $content .= "\n";

        @file_put_contents($log_file, $content, FILE_APPEND);
        @chmod($log_file, 0707);
    }

    /**
     * Debug 로깅
     * @param array $data
     */
    public static function debug($data)
    {
        File::makeDirectory(LOG_PATH . '/debug');
        $log_file = LOG_PATH . '/debug' . '/' . str_replace('-', '.', NOW_DATE) . '.log';

        global $layout, $member;
        $mb_id = $member['mb_id'];
        if (!$mb_id) {
            $mb_id = 'guest';
        }

        $content = '[' . NOW_DATETIME . '][' . USER_IP . '][' . $layout . '][' . $mb_id . ']	';
        if (is_array($data) || is_object($data)) {
            ob_start();
            print_r($data);
            $content .= ob_get_contents();
            ob_end_clean();
        } else {
            $content .= $data;
        }

        $content .= "\n";

        @file_put_contents($log_file, $content, FILE_APPEND);
        @chmod($log_file, 0707);
    }

    /**
     * Ajax 로깅
     * @param array $data
     */
    public static function ajax($data)
    {
        File::makeDirectory(LOG_PATH . '/ajax');
        $log_file = LOG_PATH . '/ajax' . '/' . str_replace('-', '.', NOW_DATE) . '.log';

        global $layout, $member;
        $mb_id = $member['mb_id'];
        if (!$mb_id) {
            $mb_id = 'guest';
        }

        $content = '[' . NOW_DATETIME . '][' . USER_IP . '][' . $layout . '][' . $mb_id . ']	';
        if (is_array($data) || is_object($data)) {
            ob_start();
            print_r($data);
            $content .= ob_get_contents();
            ob_end_clean();
        } else {
            $content .= $data;
        }

        $content .= "\n";

        @file_put_contents($log_file, $content, FILE_APPEND);
        @chmod($log_file, 0707);
    }
}

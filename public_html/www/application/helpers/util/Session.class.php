<?php
/**
 * 세션 유틸리티 클래스
 * @file    Session.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Session
{
    /**
     * 세션 저장
     * @param string $ss_name
     * @param $value
     */
    public static function setSession($ss_name, $value)
    {
        if (PHP_VERSION < '5.3.0') {
            session_register($ss_name);
        }
        $$ss_name = $_SESSION[$ss_name] = $value;
    }

    /**
     * 세션 조회
     * @param string $ss_name
     * @return string
     */
    public static function getSession($ss_name)
    {
        return isset($_SESSION[$ss_name]) ? $_SESSION[$ss_name] : '';
    }

    /**
     * 쿠키 저장
     * @param string $ck_name
     * @param string $value
     * @param int $expires
     */
    public static function setCookie($ck_name, $value, $expires = 86400)
    {
        $ck_name = md5($ck_name);
        $value = base64_encode($value);
        setcookie($ck_name, $value, time() + $expires, '/');
    }

    /**
     * 쿠키 조회
     * @param string $ck_name
     * @return string
     */
    public static function getCookie($ck_name)
    {
        $cookie = md5($ck_name);
        if (array_key_exists($cookie, $_COOKIE)) {
            $value = base64_decode($_COOKIE[$cookie]);
            return $value;
        } else {
            return '';
        }
    }

    /**
     * 쿠키 삭제
     * @param string $ck_name
     */
    public static function deleteCookie($ck_name)
    {
        self::setCookie($ck_name, '', -1);
    }
}

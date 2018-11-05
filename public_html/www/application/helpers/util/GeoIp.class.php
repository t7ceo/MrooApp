<?php
/**
 * Geo IP 유틸리티 클래스
 * @file    GeoIp.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class GeoIp
{
    /**
     * DB 정보 (Table, PK)
     * @var string
     */
    public static $ip_table = 'tbl_ip';

    /**
     * IP를 통해 국가 코드 조회
     * @param string $ip
     * @return string
     */
    public static function selectCountryCode($ip)
    {
        $long_ip = ip2long($ip);
        $db_where = "WHERE ip_s_long <= '$long_ip' AND ip_e_long >= '$long_ip'";
        $data = Db::selectOnce(static::$ip_table, 'ip_country_code', $db_where, '');
        return $data['ip_country_code'];
    }

    /**
     * IP를 통해 국가명 조회
     * @param string $ip
     * @return string
     */
    public static function selectCountryName($ip)
    {
        $long_ip = ip2long($ip);
        $db_where = "WHERE ip_s_long <= '$long_ip' AND ip_e_long >= '$long_ip'";
        $data = Db::selectOnce(static::$ip_table, 'ip_country_name', $db_where, '');
        return $data['ip_country_name'];
    }
}

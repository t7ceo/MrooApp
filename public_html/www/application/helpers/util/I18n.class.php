<?php
/**
 * 국제화 유틸리티 클래스
 * @file    I18n.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package utin
 */
namespace sFramework;

class I18n
{
    /**
     * 기본 언어, 화폐 단위 정의
     * @var string
     */
    public static $default_language = 'kor';
    public static $default_unit = 'krw';
    public static $unit_symbol_arr = array(
        'usd'   => '$',
        'krw'   => '￦',
        'jpy'   => '￥',
        'cny'   => '￥',
        'eur'   => '€'
    );

    /**
     * 콘텐츠 지역화
     * @param string $content
     * @param boolean $flag_msg
     * @param string $lang_code
     * @return string
     */
    public static function localizeContent($content, $flag_msg = false, $lang_code = null)
    {
        if (!$lang_code) {
            $lang_code = static::getLanguageCode();
        }

        global $trs_arr;
        foreach ($trs_arr as $key => $arr) {
            $trs_str = $arr[$lang_code];
            if (!$trs_str) {
                $trs_str = $key;
            }
            $src = ($flag_msg) ? $key : '{' . $key . '}';
            $content = str_replace($src, $trs_str, $content);
        }

        return $content;
    }

    /**
     * 자료 지역화
     * @param array $data
     * @param string $lang_columns
     * @param string $unit_columns
     * @return array
     */
    public static function localizeData($data, $lang_columns = null, $unit_columns = null)
    {
        if ($lang_columns) {
            $lang_code = Session::getCookie('ck_lang_code');
            if (!$lang_code) {
                $lang_code = static::getLocalLanguage();
                Session::setCookie('ck_lang_code', $lang_code);
            }

            $column_arr = explode(',', $lang_columns);
            for ($i = 0; $i < count($column_arr); $i++) {
                $key = $column_arr[$i];
                $data['lc_' . $key] = $data[$key . '_' . $lang_code];
                if (!$data['lc_' . $key]) {
                    $data['lc_' . $key] = $data[$key . '_' . static::$default_language];
                }
            }
        }

        if ($unit_columns) {
            $unit_data = static::getUnitData();
            $data = array_merge($data, $unit_data);

            $unit_code = $unit_data['unit_code'];
            $local_rate = $unit_data['local_rate'];

            $column_arr = explode(',', $unit_columns);
            for ($i = 0; $i < count($column_arr); $i++) {
                $key = $column_arr[$i];
                $data['lc_' . $key] = static::localizePrice($data[$key], $unit_code, $local_rate);
            }
        }

        return $data;
    }

    /**
     * 지역 언어 반환
     * @return string
     */
    public static function getLocalLanguage()
    {
        //사용자의 아이피 값으로 나라코드 가져오기
		$country_code = GeoIp::selectCountryCode(USER_IP);
        $language_code = 'kor';
        if ($country_code == 'US') {
            $language_code = 'eng';
        } elseif ($country_code == 'JP') {
            $language_code = 'jpn';
        } elseif ($country_code == 'CN') {
            $language_code = 'chn1';
        }

        return $language_code;
    }

    /**
     * 지역 화폐 단위 반환
     * @return string
     */
    public static function getLocalUnit()
    {
        $country_code = GeoIp::selectCountryCode(USER_IP);
        $language_code = 'krw';
        if ($country_code == 'US') {
            $language_code = 'usd';
        } elseif ($country_code == 'JP') {
            $language_code = 'jpy';
        } elseif ($country_code == 'CN') {
            $language_code = 'cny';
        } elseif ($country_code == 'EU') {
            $language_code = 'eur';
        }

        return $language_code;
    }

    /**
     * 언어 코드 반환
     * @return string
     */
    public static function getLanguageCode()
    {
        $lang_code = Session::getCookie('ck_lang_code');
        if (!$lang_code) {
            $lang_code = static::getLocalLanguage();
            Session::setCookie('ck_lang_code', $lang_code);
        }
        return $lang_code;
    }

    /**
     * 가격 지역화
     * @param float $price
     * @param string $unit_code
     * @param float $local_rate
     * @return float
     */
    public static function localizePrice($price, $unit_code, $local_rate)
    {
        if ($unit_code == 'krw') {
	        $local_price = $price * $local_rate;
            $local_price = round($local_price);
        } else if ($unit_code == 'jpy') {
	        $local_price = ($price / 1000) * $local_rate;
	        $local_price = round($local_price);
        } else {
	        $local_price = ($price / 1000) * $local_rate;
            $local_price = round($local_price, 2);
        }
        return $local_price;
    }

    /**
     * 화폐단위 정보 반환
     * @param string $unit_code
     * @return array
     */
    public static function getUnitData($unit_code = '')
    {
        if (!$unit_code) {
            $unit_code = Session::getCookie('ck_unit_code');
            if (!$unit_code) {
                $unit_code = static::getLocalUnit();
                Session::setCookie('ck_unit_code', $unit_code);
            }
        }

        $local_rate = 1;
        if ($unit_code != 'krw') {
            global $oExchange;
            if (!isset($oExchange)) {
                $oExchange = new Exchange();
                $oExchange->init();
            }
            $ec_data = $oExchange->selectCurrent();
            $local_rate = $ec_data['ec_' . $unit_code];
        }

        if (!$local_rate) {
            $unit_code = static::$default_unit;
            Session::setCookie('ck_unit_code', $unit_code);
            $local_rate = 1;
        }

		//
        $data = array(
            'unit_code' => $unit_code,
            'bt_unit_code'  => strtoupper($unit_code),
            'unit_symbol'   => static::$unit_symbol_arr[$unit_code],
            'local_rate'    => $local_rate
        );

        return $data;
    }
}

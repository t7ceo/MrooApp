<?php
/**
 * HTML 유틸리티 클래스
 * @file    Html.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class Html
{
    /**
     * 기본 HTML 구조를 기반으로 콘텐츠 출력
     * @param string $title
     * @param string $content
     */
    public static function printDefaultHtml($title, $content)
    {
        ob_start();
        echo '<!doctype html>' . "\n";
        echo '<html lang="ko" xml:lang="ko">' . "\n";
        echo '<head>' . "\n";
        echo '<meta charset="utf-8">' . "\n";
        echo '<title>'.$title.'</title>' . "\n";
        echo '</head>' . "\n";
        echo '<body>' . "\n";
        echo '<p>'. $content . '</p>' . "\n";
        echo '</body>' . "\n";
        echo '</html>' . "\n";

        $content = ob_get_contents();
        ob_end_clean();

        echo I18n::localizeContent($content, true);
        exit;
    }

    /**
     * 에러 메시지 출력
     * @param string $content
     */
    public static function printError($content)
    {
        if (!DISPLAY_ERROR) {
            $content = '';
        }
        self::printDefaultHtml('Error', $content);
    }

    /**
     * 페이지 이동
     * @param string $uri
     * @param bool $flag_top
     */
    public static function movePage($uri, $flag_top = true)
    {
        $content = '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        if ($flag_top) {
            $content .= 'top.';
        }
        $content .= 'location.replace("' . $uri . '");' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";
        $content .= '<noscript>' . "\n";
        $content .= '<p>' . "\n";
        $content .= '이동할 페이지 : ' . $uri . '<br />' . "\n";
        $content .= '<a href="' . $uri. '" title="페이지 이동">이동하기</a>' . "\n";
        $content .= '</p>' . "\n";
        $content .= '</noscript>';

        self::printDefaultHtml('페이지 이동', $content);
    }

    /**
     * 경고 출력
     * @param string $msg
     * @param string $uri
     */
    public static function alert($msg, $uri = '')
    {
        $content = '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'alert("' . str_replace("\n", "\\n", $msg) . '");' . "\n";
        if ($uri) {
            $content .= 'top.location.replace("' . $uri. '");' . "\n";
        } else {
            $content .= 'history.back(-1);' . "\n";
        }
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";
        $content .= '<noscript>' . "\n";
        $content .= '<p>' . "\n";
        $content .= nl2br($msg);
        if ($uri) {
            $content .= '<br />이동할 페이지 : ' . $uri . '<br />' . "\n";
            $content .= '<a href="' . $uri . '" title="페이지 이동">이동하기</a>' . "\n";
        }
        $content .= '</p>' . "\n";
        $content .= '</noscript>';

        self::printDefaultHtml('경고', $content);
    }

    /**
     * 결과를 통한 후처리
     * @param string $result
     * @param string $flag_json
     */
    public static function postProcessFromResult($result, $flag_json = '')
    {
        if (!$flag_json) {
            $uri = $result['uri'];
            $msg = $result['msg'];
            if ($msg) {
                self::alert($msg, $uri);
            } elseif ($uri) {
                self::movePage($uri);
            }
        }
    }

    /**
     * 부모창 새로고침하며 팝업창 닫기
     * @param string $msg
     * @param string $uri
     */
    public static function closeWithRefresh($msg = '', $uri = '')
    {
        $content = '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        if ($msg) {
            $content .= 'alert("' . str_replace("\n", "\\n", $msg) . '");' . "\n";
        }

        $content .= 'var href = ';
        if ($uri) {
            $content .= '"' . $uri . '"';
        } else {
            $content .= 'opener.location.href';
        }
        $content .= ';' . "\n";
        $content .= 'opener.location.replace(href);' . "\n";
        $content .= 'window.close();' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";
        $content .= '<noscript>' . "\n";
        $content .= '<p>' . "\n";
        if ($msg) {
            $content .= nl2br($msg);
        }
        if ($uri) {
            $content .= '<br />이동할 페이지 : ' . $uri . '<br />' . "\n";
            $content .= '<a href="' . $uri . '" title="페이지 이동">이동하기</a>' . "\n";
        }
        $content .= '</p>' . "\n";
        $content .= '</noscript>';

        self::printDefaultHtml('알림', $content);
    }

    /**
     * 네이티브 브릿지 호출
     * @param string $native_uri
     * @param string $return_uri
     */
    public static function callNative($native_uri, $return_uri = '')
    {
        $uri = 'native://' . $native_uri . '/' . urlencode($return_uri);
        $content = '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'top.location.replace("';
        if (defined('IS_WEBVIEW') && IS_WEBVIEW) {
            $content .= $uri;
        } else {
            $content .= $return_uri;
        }
        $content .= '")' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";
        $content .= '<noscript>' . "\n";
        $content .= '<p>' . "\n";
        $content .= '이동할 페이지 : ' . $uri . '<br />' . "\n";
        $content .= '<a href="' . $uri . '" title="페이지 이동">이동하기</a>' . "\n";
        $content .= '</p>' . "\n";
        $content .= '</noscript>';

        self::printDefaultHtml('네이티브 호출', $content);
    }

    /**
     * <tr /> > <td /> 노데이터 생성
     * @param int $colspan
     * @param string $msg
     * @return string
     */
    public static function makeNoTd($colspan, $msg = '데이터가 없습니다.')
    {
        $result = '<tr>' . "\n";
        $result .= "\t" . '<td class="no_data" colspan="' . $colspan . '">' . $msg . '</td>' . "\n";
        $result .= '</tr>';

        return $result;
    }

    /**
     * <li /> 노데이터 생성
     * @param string $msg
     * @return string
     */
    public static function makeNoLi($msg = '데이터가 없습니다.')
    {
        $result = '<li class="no_data">' . $msg . '</li>';

        return $result;
    }

    /**
     * 페이지네이션 생성
     * @param array $arr
     * @param string $query_string
     * @return string
     */
    public static function makePagination($arr, $query_string = '')
    {
        $query_string = preg_replace('/page=[0-9]+/', '', $query_string);

        $result = '';
        for ($i = 0; $i < count($arr); $i++) {
            $result .= '<li';
            if ($arr[$i]['class']) {
                $result .= ' class="' . $arr[$i]['class'] . '"';
            }
            $result .= '><a href="?page=' . $arr[$i]['page'] . $query_string;
            $result .= '" title="' . $arr[$i]['title'] . ' 페이지">' . $arr[$i]['title'];
            $result .= '</a></li>' . "\n";
        }

        return $result;
    }

    /**
     * Ajax 방식으로 페이지네이션 생성
     * @param array $arr
     * @param string $query_string
     * @param string $href
     * @param string $target
     * @param string $title
     * @return string
     */
    public static function makeAjaxPagination($arr, $query_string = '', $href = '', $target = '', $title = '')
    {
        $query_string = preg_replace('/page=[0-9]+/', '', $query_string);

        $result = '';
        for ($i = 0; $i < count($arr); $i++) {
            $result .= '<li';
            if ($arr[$i]['class']) {
                $result .= ' class="' . $arr[$i]['class'] . '"';
            }
            $result .= '><a href="' . $href . '?page=' . $arr[$i]['page'] . $query_string;
            $result .= '" class="btn_ajax" target="' . $target;
            $result .= '" title="' . $title . '">' . $arr[$i]['title'];
            $result .= '</a></li>' . "\n";
        }

        return $result;
    }

    /**
     * <input type="text" /> 생성
     * @param string $name
     * @param string $title
     * @param string $value
     * @param string $class
     * @param int $size
     * @param int $maxlength
     * @return string
     */
    public static function makeInputText($name, $title = '', $value = '', $class = '', $size = 0, $maxlength = 0)
    {
        $result = '<input type="text" name="' . $name . '" id="' . $name .'" ';
        $result .= 'value="' . $value . '" class="text';
        if ($class) {
            $result .= ' ' . $class;
        }
        $result .= '" ';

        if ($size) {
            $result .= ' size="' . $size . '"';
        }

        if ($maxlength) {
            $result .= ' maxlength="' . $maxlength . '"';
        }

        if ($title) {
            $result .= ' title="' . $title .'"';
        }

        $result .= ' />';

        return $result;
    }

    /**
     * <textarea /> 생성
     * @param string $name
     * @param string $title
     * @param string $value
     * @param string $class
     * @param int $rows
     * @param int $cols
     * @return string
     */
    public static function makeTextarea($name, $title = '', $value = '', $class = '', $rows = 0, $cols = 0)
    {
        $result = '<textarea name="' . $name . '" id="' . $name . '" class="textarea';
        if ($class) {
            $result .= ' '.$class;
        }
        $result .= '" ';

        if ($rows) {
            $result .= ' rows="' . $rows . '"';
        }

        if ($cols) {
            $result .= ' cols="' . $cols . '"';
        }

        if ($title) {
            $result .= ' title="' . $title . '"';
        }

        $result .= '>' . $value . '</textarea>';

        return $result;
    }

    /**
     * <tr /> > <td /> 생성
     * @param string $th
     * @param string $td
     * @param bool $flag_required
     * @param int $colspan
     * @return string
     */
    public static function makeTrTd($th, $td, $flag_required = false, $colspan = 0)
    {
        $result = '<tr>' . "\n";
        $result .= "\t" . '<th';
        if ($flag_required) {
            $result .= ' class="required"';
        }
        $result .= '>' . $th . '</th>';
        $result .= "\t" . '<td';
        if ($colspan) {
            $result .= ' colspan="' . $colspan . '"';
        }
        $result .= '>' . $td . '</td>';
        $result .= '</tr>';

        return $result;
    }

    /**
     * <select /> > <option /> 생성
     * @param array $arr
     * @param string $value
     * @param int $opt
     * @return string
     */
    public static function makeSelectOptions($arr, $value, $opt = 1)
    {
        if (!is_array($arr)) {
            return '';
        }

        $result = '';
        foreach ($arr as $key => $val) {
            $opt_value = $val;
            $opt_text = $val;
            if ($opt == 1) {
                $opt_value = $key;
            } elseif ($opt == 2) {
                $opt_value = $val;
                $opt_text = $key;
            }

            $result .= '<option value="' . $opt_value . '"';
            if ($value == $opt_value) {
                $result .= ' selected="selected"';
            }
            $result .= '>' . $opt_text . '</option>' . "\n";
        }

        return $result;
    }

    /**
     * <input type="radio" /> 생성
     * @param string $name
     * @param array $arr
     * @param string $value
     * @param string $class
     * @param string $title
     * @param int $opt
     * @return string
     */
    public static function makeRadio($name, $arr, $value, $class = '', $title = '', $opt = 1)
    {
        if (!is_array($arr)) {
            return null;
        }

        $result = '';
        foreach ($arr as $key => $val) {
            $opt_name = $name . '_' . $key;
            $opt_value = $val;
            $opt_text = $val;
            if ($opt == 1) {
                $opt_value = $key;
            } elseif ($opt == 2) {
                $opt_value = $val;
                $opt_text = $key;
            }

            $result .= '<input type="radio" name="' . $name . '" ';
            $result .= 'id="' . $opt_name . '" class="radio ' . $name;
            if ($class) {
                $result .= ' ' . $class;
            }

            $result .= '" value="' . $opt_value . '"';
            if ($title) {
                $result .= ' title="' . $title . '"';
            }

            if ($value == $opt_value) {
                $result .= ' checked="checked"';
            }
            $result .= ' /><label for="' . $opt_name . '">' . $opt_text . '</label>' . "\n";
        }

        return $result;
    }

    /**
     * <input type="checkbox" /> 생성
     * @param string $name
     * @param array $arr
     * @param string $value
     * @param string $class
     * @param string $title
     * @param int $opt
     * @return string
     */
    public static function makeCheckbox($name, $arr, $value, $class = '', $title = '', $opt = 1)
    {
        if (!is_array($arr)) {
            return null;
        }

        if (is_array($value)) {
            $val_arr = $value;
        } else {
            $val_arr = explode('|', $value);
        }
        $result = '';
        foreach ($arr as $key => $val) {
            $opt_name = $name . '_' . $key;
            $opt_value = $val;
            $opt_text = $val;
            if ($opt == 1) {
                $opt_value = $key;
            } elseif ($opt == 2) {
                $opt_value = $val;
                $opt_text = $key;
            }

            $result .= '<input type="checkbox" name="' . $name;
            if (count($arr) > 1) {
                $result .= '[]';
            }
            $result .= '" id="' . $opt_name . '" class="checkbox ' . $name;
            if ($class) {
                $result .= ' ' . $class;
            }
            $result .= '" value="' . $opt_value . '"';
            if ($title) {
                $result .= ' title="' . $title . '"';
            }

            if (count($arr) > 1 && in_array($opt_value, $val_arr)) {
                $result .= ' checked="checked"';
            } elseif (count($arr) < 2 && $opt_value == $val_arr[0]) {
                $result .= ' checked="checked"';
            }
            $result .= ' /><label for="' . $opt_name . '">' . $opt_text . '</label>' . "\n";
        }

        return $result;
    }

    /**
     * <table /> 내부의 <input type="text" /> 생성
     * @param string $title
     * @param string $name
     * @param string $value
     * @param string $class
     * @param int $size
     * @param int $maxlength
     * @param int $colspan
     * @return string
     */
    public static function makeInputTextInTable(
        $title,
        $name,
        $value = '',
        $class = '',
        $size = 0,
        $maxlength = 0,
        $colspan = 0
    ) {
        $th = '<label for="' . $name . '">' . $title . '</label>';
        $td = self::makeInputText($name, $title, $value, $class, $size, $maxlength);

        $flag_required = false;
        if (strpos($class, 'required') > -1) {
            $flag_required = true;
        }

        return self::makeTrTd($th, $td, $flag_required, $colspan);
    }

    /**
     * <table /> 내부의 <textarea /> 생성
     * @param string $title
     * @param string $name
     * @param string $value
     * @param string $class
     * @param int $rows
     * @param int $cols
     * @param int $colspan
     * @return string
     */
    public static function makeTextareaInTable(
        $title,
        $name,
        $value = '',
        $class = '',
        $rows = 0,
        $cols = 0,
        $colspan = 0
    ) {
        $th = '<label for="' . $name . '">' . $title . '</label>';
        $td = self::makeTextarea($name, $title, $value, $class, $rows, $cols);

        $flag_required = false;
        if (strpos($class, 'required') > -1) {
            $flag_required = true;
        }

        return self::makeTrTd($th, $td, $flag_required, $colspan);
    }

    /**
     * 빠른 기간 선택 생성
     * @param array $date_arr
     * @param string $sch_s_date
     * @param string $sch_e_date
     * @param bool $with_today
     * @param bool $flag_use_all
     * @param string $href
     * @param string $classes
     * @return string
     */
    public static function makePeriodAnchor(
        $date_arr,
        $sch_s_date,
        $sch_e_date,
        $with_today = true,
        $flag_use_all = true,
        $href = './list.html',
        $classes = 'sButton tiny'
    ) {
        if (!is_array($date_arr)) {
            return null;
        }

        if ($with_today) {
            $new_date_arr = array();
            foreach ($date_arr as $key => $val) {
                $new_key = date('Y-m-d', strtotime($key) + 24 * 3600);
                $new_date_arr[$new_key] = $val;
            }
            $date_arr = $new_date_arr;
        }

        $result = '';
        $seq = 0;
        $first_key = null;
        foreach ($date_arr as $key => $val) {
            if (!$seq) {
                $first_key = $key;
            } else {
                $result .= '<a href="' . $href . '?sch_s_date=' . $key;
                $result .= '&sch_e_date=' . $first_key . '" class="btn_change_period';
                if ($classes) {
                    $result .= ' ' . $classes;
                }
                if ($sch_s_date == $key && $sch_e_date == $first_key) {
                    $result .= ' active';
                }
                $result .= '">' . $val . '</a>' . "\n";
            }

            $seq++;
        }

        if ($flag_use_all) {
            $result .= '<a href="' . $href . '?sch_s_date=&sch_e_date=" class="btn_change_period';
            if ($classes) {
                $result .= ' ' . $classes;
            }
            if ($sch_s_date == '' && $sch_e_date == '') {
                $result .= ' active';
            }
            $result .= '">전체</a>' . "\n";
        }

        return $result;
    }

	/**
	 * 국가번호 셀렉트박스를 만드는 함수
	 * @param string $location
	 * @param string $name
	 * @return string
	 */
	public static function makeCountryCodeSelect($location_code, $name = '')
	{
		// 국가 번호
		$code_arr = array(
			'South Korea'=>'82',
			'Afghanistan'=>'93',
			'Albania'=>'355',
			'Algeria'=>'213',
			'American Samoa'=>'1-684',
			'Andorra'=>'376',
			'Angola'=>'244',
			'Anguilla'=>'1-264',
			'Antarctica'=>'672',
			'Antigua and Barbuda'=>'1-268',
			'Argentina'=>'54',
			'Armenia'=>'374',
			'Aruba'=>'297',
			'Australia'=>'61',
			'Austria'=>'43',
			'Azerbaijan'=>'994',
			'Bahamas'=>'1-242',
			'Bahrain'=>'973',
			'Bangladesh'=>'880',
			'Barbados'=>'1-246',
			'Belarus'=>'375',
			'Belgium'=>'32',
			'Belize'=>'501',
			'Benin'=>'229',
			'Bermuda'=>'1-441',
			'Bhutan'=>'975',
			'Bolivia'=>'591',
			'Bosnia and Herzegovina'=>'387',
			'Botswana'=>'267',
			'Brazil'=>'55',
			'British Indian Ocean Territory'=>'246',
			'British Virgin Islands'=>'1-284',
			'Brunei'=>'673',
			'Bulgaria'=>'359',
			'Burkina Faso'=>'226',
			'Burundi'=>'257',
			'Cambodia'=>'855',
			'Cameroon'=>'237',
			'Canada'=>'1',
			'Cape Verde'=>'238',
			'Cayman Islands'=>'1-345',
			'Central African Republic'=>'236',
			'Chad'=>'235',
			'Chile'=>'56',
			'China'=>'86',
			'Christmas Island'=>'61',
			'Cocos Islands'=>'61',
			'Colombia'=>'57',
			'Comoros'=>'269',
			'Cook Islands'=>'682',
			'Costa Rica'=>'506',
			'Croatia'=>'385',
			'Cuba'=>'53',
			'Curacao'=>'599',
			'Cyprus'=>'357',
			'Czech Republic'=>'420',
			'Democratic Republic of the Congo'=>'243',
			'Denmark'=>'45',
			'Djibouti'=>'253',
			'Dominica'=>'1-767',
			'Dominican Republic'=>'1-809, 1-829, 1-849',
			'East Timor'=>'670',
			'Ecuador'=>'593',
			'Egypt'=>'20',
			'El Salvador'=>'503',
			'Equatorial Guinea'=>'240',
			'Eritrea'=>'291',
			'Estonia'=>'372',
			'Ethiopia'=>'251',
			'Falkland Islands'=>'500',
			'Faroe Islands'=>'298',
			'Fiji'=>'679',
			'Finland'=>'358',
			'France'=>'33',
			'French Polynesia'=>'689',
			'Gabon'=>'241',
			'Gambia'=>'220',
			'Georgia'=>'995',
			'Germany'=>'49',
			'Ghana'=>'233',
			'Gibraltar'=>'350',
			'Greece'=>'30',
			'Greenland'=>'299',
			'Grenada'=>'1-473',
			'Guam'=>'1-671',
			'Guatemala'=>'502',
			'Guernsey'=>'44-1481',
			'Guinea'=>'224',
			'Guinea-Bissau'=>'245',
			'Guyana'=>'592',
			'Haiti'=>'509',
			'Honduras'=>'504',
			'Hong Kong'=>'852',
			'Hungary'=>'36',
			'Iceland'=>'354',
			'India'=>'91',
			'Indonesia'=>'62',
			'Iran'=>'98',
			'Iraq'=>'964',
			'Ireland'=>'353',
			'Isle of Man'=>'44-1624',
			'Israel'=>'972',
			'Italy'=>'39',
			'Ivory Coast'=>'225',
			'Jamaica'=>'1-876',
			'Japan'=>'81',
			'Jersey'=>'44-1534',
			'Jordan'=>'962',
			'Kazakhstan'=>'7',
			'Kenya'=>'254',
			'Kiribati'=>'686',
			'Kosovo'=>'383',
			'Kuwait'=>'965',
			'Kyrgyzstan'=>'996',
			'Laos'=>'856',
			'Latvia'=>'371',
			'Lebanon'=>'961',
			'Lesotho'=>'266',
			'Liberia'=>'231',
			'Libya'=>'218',
			'Liechtenstein'=>'423',
			'Lithuania'=>'370',
			'Luxembourg'=>'352',
			'Macau'=>'853',
			'Macedonia'=>'389',
			'Madagascar'=>'261',
			'Malawi'=>'265',
			'Malaysia'=>'60',
			'Maldives'=>'960',
			'Mali'=>'223',
			'Malta'=>'356',
			'Marshall Islands'=>'692',
			'Mauritania'=>'222',
			'Mauritius'=>'230',
			'Mayotte'=>'262',
			'Mexico'=>'52',
			'Micronesia'=>'691',
			'Moldova'=>'373',
			'Monaco'=>'377',
			'Mongolia'=>'976',
			'Montenegro'=>'382',
			'Montserrat'=>'1-664',
			'Morocco'=>'212',
			'Mozambique'=>'258',
			'Myanmar'=>'95',
			'Namibia'=>'264',
			'Nauru'=>'674',
			'Nepal'=>'977',
			'Netherlands'=>'31',
			'Netherlands Antilles'=>'599',
			'New Caledonia'=>'687',
			'New Zealand'=>'64',
			'Nicaragua'=>'505',
			'Niger'=>'227',
			'Nigeria'=>'234',
			'Niue'=>'683',
			'North Korea'=>'850',
			'Northern Mariana Islands'=>'1-670',
			'Norway'=>'47',
			'Oman'=>'968',
			'Pakistan'=>'92',
			'Palau'=>'680',
			'Palestine'=>'970',
			'Panama'=>'507',
			'Papua New Guinea'=>'675',
			'Paraguay'=>'595',
			'Peru'=>'51',
			'Philippines'=>'63',
			'Pitcairn'=>'64',
			'Poland'=>'48',
			'Portugal'=>'351',
			'Puerto Rico'=>'1-787, 1-939',
			'Qatar'=>'974',
			'Republic of the Congo'=>'242',
			'Reunion'=>'262',
			'Romania'=>'40',
			'Russia'=>'7',
			'Rwanda'=>'250',
			'Saint Barthelemy'=>'590',
			'Saint Helena'=>'290',
			'Saint Kitts and Nevis'=>'1-869',
			'Saint Lucia'=>'1-758',
			'Saint Martin'=>'590',
			'Saint Pierre and Miquelon'=>'508',
			'Saint Vincent and the Grenadines'=>'1-784',
			'Samoa'=>'685',
			'San Marino'=>'378',
			'Sao Tome and Principe'=>'239',
			'Saudi Arabia'=>'966',
			'Senegal'=>'221',
			'Serbia'=>'381',
			'Seychelles'=>'248',
			'Sierra Leone'=>'232',
			'Singapore'=>'65',
			'Sint Maarten'=>'1-721',
			'Slovakia'=>'421',
			'Slovenia'=>'386',
			'Solomon Islands'=>'677',
			'Somalia'=>'252',
			'South Africa'=>'27',
			'South Sudan'=>'211',
			'Spain'=>'34',
			'Sri Lanka'=>'94',
			'Sudan'=>'249',
			'Suriname'=>'597',
			'Svalbard and Jan Mayen'=>'47',
			'Swaziland'=>'268',
			'Sweden'=>'46',
			'Switzerland'=>'41',
			'Syria'=>'963',
			'Taiwan'=>'886',
			'Tajikistan'=>'992',
			'Tanzania'=>'255',
			'Thailand'=>'66',
			'Togo'=>'228',
			'Tokelau'=>'690',
			'Tonga'=>'676',
			'Trinidad and Tobago'=>'1-868',
			'Tunisia'=>'216',
			'Turkey'=>'90',
			'Turkmenistan'=>'993',
			'Turks and Caicos Islands'=>'1-649',
			'Tuvalu'=>'688',
			'U.S. Virgin Islands'=>'1-340',
			'Uganda'=>'256',
			'Ukraine'=>'380',
			'United Arab Emirates'=>'971',
			'United Kingdom'=>'44',
			'United States'=>'1',
			'Uruguay'=>'598',
			'Uzbekistan'=>'998',
			'Vanuatu'=>'678',
			'Vatican'=>'379',
			'Venezuela'=>'58',
			'Vietnam'=>'84',
			'Wallis and Futuna'=>'681',
			'Western Sahara'=>'212',
			'Yemen'=>'967',
			'Zambia'=>'260',
			'Zimbabwe'=>'263'
		);


		$html = '<select class="select" name="' . $name . '">';
		$html .= '<option value="">{국가코드}</option>';
		foreach ($code_arr as $country => $code) {
			$html .= '<option value="' . $code . '"';
			if ($location_code == $code) {
				$html .= 'selected="selected"';
			}
			$html .= '>' . $country . ' +' . $code . '</option>';
		}
		$html .= '</select>';
		return $html;
	}
}

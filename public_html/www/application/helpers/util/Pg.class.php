<?php
/**
 * PG 유틸리티 클래스
 * @file    Pg.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package
 */
namespace sFramework;

class Pg
{
    /**
     * DB 정보 (Table, PK)
     * @var string
     */
    public static $pg_table = 'tbl_payment';
    public static $pg_pk = 'pa_id';

    /**
     * PG 요청
     * @param array $data
     * @return array
     */
    public static function requestPayment($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        File::makeDirectory(LOG_PATH . '/payment');

        // UID 세팅
        $data[static::$pg_pk] = Str::makeTimeCode();

        // API별로 실행
        if ($data['pa_pg_module'] == 'uplus') {
            $data['pg_id'] = UPLUS_ID;
            $data['pg_key'] = UPLUS_KEY;
            $data['pg_path'] = UPLUS_PATH;
            $result = static::requestPaymentUplus($data);
        } elseif ($data['pa_pg_module'] == 'krp') {
	        if (PG_MODE == 'service') {
		        $data['pg_id'] = KRP_ID;
		        $data['pg_key'] = KRP_KEY;
	        } else {
		        $data['pg_id'] = KRP_TEST_ID;
		        $data['pg_key'] = KRP_TEST_KEY;
	        }
            $result = static::requestPaymentKrp($data);
        } elseif ($data['pa_pg_module'] == 'coupon') {
            // 전송자료 생성
            $action_uri = LAYOUT_URI . '/order/response.html';
            $content = '<form name="pay_form" id="pay_form" method="post" action="' . $action_uri . '">' . "\n";
            foreach ($data as $key => $val) {
                $content .= '<input type="hidden" name="' . $key . '" value="' . $val . '" />' . "\n";
            }
            $content .= '</form>' . "\n";
            $content .= '<script type="text/javascript">' . "\n";
            $content .= '//<![CDATA[' . "\n";
            $content .= 'document.pay_form.submit();' . "\n";
            $content .= '//]]>' . "\n";
            $content .= '</script>' . "\n";

            $result['code'] = 'success';
            $result['content'] = $content;

            Session::setSession('ss_pay_token', $data[static::$pg_pk]);
        }

        // 결제 성공 시 세션 세팅
        Session::setSession('ss_pa_uid', $data['pa_uid']);
        Session::setSession('ss_pa_unit_code', $data['pa_unit_code']);
        Session::setSession('ss_pa_pg_module', $data['pa_pg_module']);

        return $result;
    }

    /**
     * PG 응답
     * @param array $data
     * @return array
     */
    public static function responsePayment($data = array())
    {
        $result = array(
            'code' => 'failure',
            'msg'  => '결제 과정에서 장애가 발생하였습니다.'
        );

        // 세션 정보
        $data['pa_uid'] = Session::getSession('ss_pa_uid');
        $data['pa_unit_code'] = Session::getSession('ss_pa_unit_code');
        $data['pa_pg_module'] = Session::getSession('ss_pa_pg_module');

        Session::setSession('ss_pa_uid', null);
        Session::setSession('ss_pa_unit_code', null);
        Session::setSession('ss_pa_pg_module', null);

        // API별로 실행
        if ($_POST['pa_pg_module'] == 'coupon') {
            $result['code'] = 'success';
            $result['data'][static::$pg_pk] = $_POST[static::$pg_pk];
            // 정보 세팅
            $result['data'] = array(
                static::$pg_pk  => $_POST[static::$pg_pk],
                'pa_module'     => $_POST['pa_module'],
                'pa_subject'    => $_POST['pa_subject'],
                'pa_price'      => $_POST['pa_price'],
                'pa_buyer_name' => $_POST['pa_buyer_name'],
                'pa_buyer_email'    => $_POST['pa_buyer_email'],
                'pa_buyer_tel'  => $_POST['pa_buyer_tel'],
                'pa_method' => $_POST['pa_method'],
                'pa_pay_time' => NOW_DATETIME,
                'reg_id'        => $_POST['reg_id']
            );
            $data = $_POST;
        } elseif ($data['pa_pg_module'] == 'uplus') {
            $data['pg_id'] = UPLUS_ID;
            $data['pg_key'] = UPLUS_KEY;
            $data['pg_path'] = UPLUS_PATH;
            $result = static::responsePaymentUplus($data);
        } elseif ($data['pa_pg_module'] == 'krp') {
            if (PG_MODE == 'service') {
	            $data['pg_id'] = KRP_ID;
	            $data['pg_key'] = KRP_KEY;
            } else {
	            $data['pg_id'] = KRP_TEST_ID;
	            $data['pg_key'] = KRP_TEST_KEY;
            }

            $result = static::responsePaymentKrp($data);
        }

        // 요청 성공 시 DB 처리
        if ($result['code'] == 'success') {
            $arr = $result['data'];
            $arr['pa_uid'] = $data['pa_uid'];
            $arr['pa_unit_code'] = $data['pa_unit_code'];
            $arr['pa_pg_module'] = $data['pa_pg_module'];
            $arr['pa_buyer_ip'] = USER_IP;
            if ($arr['pa_method'] == 'C' || $arr['pa_method'] == 'V'
                || $arr['pa_method'] == 'P' || $arr['pa_method'] == 'U'
                || $arr['pa_method'] == 'A' || $arr['pa_method'] == 'T' || $arr['pa_method'] == 'W'
                || $arr['pa_method'] == 'M') {
                $arr['pa_state'] = 'P';
                $arr['pa_pay_time'] = NOW_DATETIME;
            } else {
                $arr['pa_state'] = 'W';
            }

            // 같은 주문번호에 대한 이전 결제 내역 삭제
            $db_where = "WHERE pa_module = '" . $arr['pa_module'] . "' AND pa_uid = '" . $arr['pa_uid'] . "'";
            Db::delete(static::$pg_table, $db_where);
            if (Db::insertByArray(static::$pg_table, $arr)) {
                $result = array(
                    'code' => 'success',
                    'data'  => $arr
                );
            } else {
                $result = array(
                    'code'  => 'failure',
                    'msg'   => '등록 과정에서 장애가 발생하였습니다.'
                );
            }
        }

        return $result;
    }

    /**
     * 결제 영수증 정보 생성
     * @param array $data
     * @return array
     */
    public static function makeBillData($data)
    {
        // API별로 실행
        if ($data['pa_pg_module'] == 'uplus') {
            $data['pg_id'] = UPLUS_ID;
            $data['pg_key'] = UPLUS_KEY;
            $data['pg_path'] = UPLUS_PATH;
            $data = static::makeBillDataUplus($data);
        }

        return $data;
    }

    /**
     * 이전 자료 삭제
     * @param string $pa_module
     * @param string $pa_uid
     * @return array
     */
    public static function deleteOldData($pa_module, $pa_uid)
    {
        $db_where = "WHERE pa_module = '$pa_module' AND pa_uid = '$pa_uid'";
        if (!Db::delete(static::$pg_table, $db_where)) {
            $result = array(
                'code'  => 'failure',
                'msg'   => '삭제 과정에 문제가 발생하였습니다.'
            );
        } else {
            $result = array(
                'code'  => 'success'
            );
        }

        return $result;
    }

    /**
     * 결제 정보 반환
     * @param string $pa_module
     * @param string $pa_uid
     * @return array
     */
    public static function selectData($pa_module, $pa_uid)
    {
        $db_where = "WHERE pa_module = '$pa_module' AND pa_uid = '$pa_uid'";
        $data = Db::selectOnce(static::$pg_table, "*", $db_where, '');

        // 결제일시
        if ($data['pa_pay_time'] && $data['pa_pay_time'] != '0000-00-00 00:00:00') {
            $data['pa_pay_date'] = substr($data['pa_pay_time'], 0, 10);
            $data['bt_pa_pay_date'] = str_replace('-', '.', $data['pa_pay_date']);
            $data['pa_pay_datetime'] = substr($data['pa_pay_time'], 0, 16);
            $data['bt_pa_pay_datetime'] = Str::beautifyDateTime($data['pa_pay_time']);
        } else {
            $data['pa_pay_time'] = null;
            $data['pa_pay_date'] = null;
            $data['bt_pa_pay_date'] = null;
            $data['pa_pay_datetime'] = null;
            $data['bt_pa_pay_datetime'] = null;
        }

        // 취소요청일시
        if ($data['pa_cancel_time'] && $data['pa_cancel_time'] != '0000-00-00 00:00:00') {
            $data['pa_cancel_date'] = substr($data['pa_cancel_time'], 0, 10);
            $data['bt_pa_cancel_date'] = str_replace('-', '.', $data['pa_cancel_date']);
            $data['pa_cancel_datetime'] = substr($data['pa_cancel_time'], 0, 16);
            $data['bt_pa_cancel_datetime'] = Str::beautifyDateTime($data['pa_cancel_time']);
        } else {
            $data['pa_cancel_time'] = null;
            $data['pa_cancel_date'] = null;
            $data['bt_pa_cancel_date'] = null;
            $data['pa_cancel_datetime'] = null;
            $data['bt_pa_cancel_datetime'] = null;
        }

        // 환불요청일시
        if ($data['pa_refund_time'] && $data['pa_refund_time'] != '0000-00-00 00:00:00') {
            $data['pa_refund_date'] = substr($data['pa_refund_time'], 0, 10);
            $data['bt_pa_refund_date'] = str_replace('-', '.', $data['pa_refund_date']);
            $data['pa_refund_datetime'] = substr($data['pa_refund_time'], 0, 16);
            $data['bt_pa_refund_datetime'] = Str::beautifyDateTime($data['pa_refund_time']);
        } else {
            $data['pa_refund_time'] = null;
            $data['pa_refund_date'] = null;
            $data['bt_pa_refund_date'] = null;
            $data['pa_refund_datetime'] = null;
            $data['bt_pa_refund_datetime'] = null;
        }

        // 결제기관 정보
        if ($data['pa_method'] == 'C') {
            $data['bt_finance_info'] = $data['pa_finance_name'] . '/' . $data['pa_finance_no'];
        } elseif ($data['pa_method'] == 'V') {
            $data['bt_finance_info'] = $data['pa_finance_name'] . '은행';
        }

        // 영수증
        $bill_data = Pg::makeBillData($data);
        $data['pa_pg_mid'] = $bill_data['pa_pg_mid'];
        $data['pa_bill_js'] = $bill_data['pa_bill_js'];
        $data['pa_bill_auth'] = $bill_data['pa_bill_auth'];

        return $data;
    }

    /**
     * 유플러스 > PG 요청
     * @param array $data
     * @return array
     */
    protected static function requestPaymentUplus($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        File::makeDirectory(LOG_PATH . '/payment');
        // 전송 정보 세팅
        $arr = array(
            'CST_PLATFORM' => PG_MODE,  // 서비스모드 (test, service)
            'CST_MID' => $data['pg_id'], // 상점 아이디
            'LGD_MID' => (PG_MODE == 'test') ? 't' . $data['pg_id'] : $data['pg_id'], // 결제 요청 상점 아이디

            'LGD_VERSION' => 'PHP_Non-ActiveX_Standard',    // 모듈 버전
            'LGD_WINDOW_VER' => '2.5',  // 버전
            'LGD_CUSTOM_SKIN' => 'red', // 스킨 (red, purple, yellow)
            'LGD_CUSTOM_PROCESSTYPE' => 'TWOTR',    // 트랜잭션 처리방식 (수정불가)

            'LGD_ENCODING' => 'UTF-8',  // 쇼핑몰 -> LGU+로 상품 정보 등을 전송할 때 사용되는 인코딩
            'LGD_ENCODING_RETURNURL' => 'UTF-8',    // LGU+ -> 쇼핑몰로 결제 결과를 전송할 때 사용되는 인코딩 (mall.conf와 통일)
            'LGD_ENCODING_NOTEURL' => 'UTF-8',      // LGU+ -> 쇼핑몰로 가상계좌(무통장) 입금 결과를 전송할 때 사용되는 인코딩 (mall.conf와 통일)
            'LGD_WINDOW_TYPE' => 'submit',  // 결제창 호출 방식 (submit, iframe)
            'LGD_CUSTOM_SWITCHINGTYPE' => 'SUBMIT', // 결제 인증 후 페이지 전환 방식 (IFRAME, SUBMIT)

            'LGD_OID' => $data[static::$pg_pk],    // 결제고유번호
            'LGD_PRODUCTINFO' => $data['pa_subject'],   // 결제명
            'LGD_PRODUCTCODE' => $data['pa_module'],  // 결제원본모듈
            'LGD_AMOUNT' => $data['pa_price'],  // 결제금액

            'LGD_BUYER' => $data['pa_buyer_name'],  // 구매자명
            'LGD_BUYERID' => $data['reg_id'],    // 구매자 아이디
            'LGD_BUYEREMAIL' => $data['pa_buyer_email'],    // 구매자 이메일
            'LGD_BUYERPHONE' => $data['pa_buyer_tel'],  // 구매자 휴대폰
            'LGD_BUYERIP' => USER_IP,   // 구매자 아이피


            'LGD_TIMESTAMP' => NOW_TIME,    // 타임스탬프
            'LGD_PAYKEY' => '', // 공개키

            'LGD_CASNOTEURL' => $data['pa_casnote_uri'],   // 가상계좌(무통장) 입금 결과 수신 및 DB 처리 페이지
            'LGD_RETURNURL' => $data['pa_response_uri'],   // 결제 결과 수신 페이지

            'LGD_OSTYPE_CHECK' => (IS_MOBILE) ? 'M' : 'P',  // PC/모바일 여부 (P, M)
            'LGD_ESCROW_USEYN' => 'Y',   // 에스크로 사용 여부

            'LGD_KVPMISPAUTOAPPYN'	=> 'N',			// 모바일ISP 앱 OS : 안드로이드
            'LGD_MTRANSFERAUTOAPPYN'	=> 'N'		// 모바일계좌이체 앱 OS : 안드로이드
        );

        if ($data['pa_method'] == 'C') {
            $arr['LGD_CUSTOM_USABLEPAY'] = 'SC0010';    // 결제수단
        } elseif ($data['pa_method'] == 'V') {
            $arr['LGD_CUSTOM_USABLEPAY'] = 'SC0030';    // 결제수단
            $arr['LGD_CASHRECEIPTYN'] = 'Y';    // 현금영수증 발행 여부
        } elseif ($data['pa_method' == 'B']) {
            $arr['LGD_CUSTOM_USABLEPAY'] = 'SC0040';    // 결제수단
            $arr['LGD_CASHRECEIPTYN'] = 'Y';    // 현금영수증 발행 여부
        }

        // PG 정보 유효성 검사
        if (!$arr['CST_PLATFORM'] || !$arr['CST_MID'] || !$arr['LGD_RETURNURL'] || !$data['pg_key']) {
            $result['msg'] = 'PG 정보가 유효하지 않습니다.';
            return $result;
        }

        // 결제정보 유효성 검사
        if (!$arr['LGD_OID'] || !$arr['LGD_PRODUCTINFO'] || !$arr['LGD_PRODUCTCODE'] || !$arr['LGD_AMOUNT']) {
            $result['msg'] = '결제정보가 유효하지 않습니다.';
            return $result;
        }

        // 구매자 정보
        if (!$arr['LGD_BUYER'] || !$arr['LGD_BUYERID'] || !$arr['LGD_BUYEREMAIL'] || !$arr['LGD_BUYERPHONE']) {
            $result['msg'] = '구매자 정보가 유효하지 않습니다.';
            return $result;
        }

        // 암호화
        if (!file_exists($data['pg_path'] . '/XPayClient.php')) {
            $result['msg'] = 'PG 모듈이 설치되지 않았습니다.';
            return $result;
        }

        require_once $data['pg_path'] . '/XPayClient.php';
        $xpay = &new \XPayClient($data['pg_path'], $arr['CST_PLATFORM']);
        $xpay->Init_TX($arr['LGD_MID']);
        $arr['LGD_HASHDATA'] = $arr['LGD_MID'] . $arr['LGD_OID'] . $arr['LGD_AMOUNT'];
        $arr['LGD_HASHDATA'] .= $arr['LGD_TIMESTAMP'] . $xpay->config[$arr['LGD_MID']];
        $arr['LGD_HASHDATA'] = md5($arr['LGD_HASHDATA']);

        // 전송자료 생성
        $content = '<script type="text/javascript" src="';
        $content .= 'http://xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js';
        $content .= '" charset="EUC-KR"></script>' . "\n";
        $content .= '<form name="pay_form" id="pay_form" method="post" action="' . $data['pa_return_uri'] . '">' . "\n";
        foreach ($arr as $key => $val) {
            $content .= '<input type="hidden" name="' . $key . '" value="' . $val . '" />' . "\n";
        }
        $content .= '</form>' . "\n";
        $content .= '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'lgdwin = openXpay(document.getElementById("pay_form"), "';
        $content .= $arr['CST_PLATFORM'] . '", "' . $arr['LGD_WINDOW_TYPE'] . '", null, "", "");' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";

        $result['code'] = 'success';
        $result['content'] = $content;

        Session::setSession('ss_pay_token', $data[static::$pg_pk]);

        return $result;
    }

    /**
     * 유플러스 > PG 응답
     * @param array $data
     * @return array
     */
    private static function responsePaymentUplus($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // 전송 정보 세팅
        $arr = array(
            'CST_PLATFORM' => PG_MODE,  // 서비스모드 (test, service)
            'CST_MID' => $data['pg_id'], // 상점 아이디
            'LGD_MID' => (PG_MODE == 'test') ? 't' . $data['pg_id'] : $data['pg_id'], // 결제 요청 상점 아이디
            'LGD_OID' => $_POST['LGD_OID'], // 주문번호
            'LGD_PAYKEY' => $_POST['LGD_PAYKEY']    // 공개키
        );

        // 중도 취소일 경우
        $code = $_POST['LGD_RESPCODE'];
        if ($code != '0000') {
            $result['msg'] = 'Error Code : ' . $code . "\n" . $_POST['LGD_RESPMSG'];
            return $result;
        }

        // 토큰 검사
        $pay_token = Session::getSession('ss_pay_token');
        if ($pay_token != $arr['LGD_OID']) {
            $result['msg'] = '토큰이 유효하지 않습니다.';
            return $result;
        }

        // 공개키 검사
        if (!$arr['LGD_PAYKEY']) {
            $result['msg'] = '인증키가 유효하지 않습니다.';
            return $result;
        }

        require_once $data['pg_path'] . '/XPayClient.php';
        $xpay = &new \XPayClient($data['pg_path'], $arr['CST_PLATFORM']);
        $xpay->Init_TX($arr['LGD_MID']);
        $xpay->Set("LGD_TXNAME", "PaymentByKey");
        $xpay->Set("LGD_PAYKEY", $arr['LGD_PAYKEY']);
        if ($xpay->TX()) {
            $code = $xpay->Response_Code();
            if ($code == '0000') {
                $result['code'] = 'success';
                $result['msg'] = '결제가 성공적으로 처리되었습니다.';
                $result['data'] = array(
                    static::$pg_pk => $xpay->Response('LGD_OID', 0),
                    'pa_module' => $xpay->Response('LGD_PRODUCTCODE', 0),
                    'pa_subject' => $xpay->Response('LGD_PRODUCTINFO', 0),
                    'pa_price' => $xpay->Response('LGD_AMOUNT', 0),

                    'pa_buyer_name' => $xpay->Response('LGD_BUYER', 0),
                    'pa_buyer_email' => $xpay->Response('LGD_BUYEREMAIL', 0),
                    'pa_buyer_tel' => $xpay->Response('LGD_BUYERPHONE', 0),
                    'reg_id' => $xpay->Response('LGD_BUYERID', 0),

                    'pa_pg_tid' => $xpay->Response('LGD_TID', 0),
                    'pa_auth_no' => $xpay->Response('LGD_FINANCEAUTHNUM', 0),
                    'pa_finance_code' => $xpay->Response('LGD_FINANCECODE', 0),
                    'pa_finance_name' => $xpay->Response('LGD_FINANCENAME', 0),
                    'pa_finance_no' => $xpay->Response('LGD_CARDNUM', 0) . $xpay->Response('LGD_ACCOUNTNUM', 0),
                    'pa_bill_no' => $xpay->Response('LGD_CASHRECEIPTNUM', 0)
                );

                // 결제 유형에 따른 처리
                $LGD_PAYTYPE = $xpay->Response('LGD_PAYTYPE', 0);
                if ($LGD_PAYTYPE == 'SC0010') {
                    $result['data']['pa_method'] = 'C';
                    $result['data']['pa_pay_time'] = $xpay->Response('LGD_PAYDATE', 0);
                } elseif ($LGD_PAYTYPE == 'SC0030') {
                    $result['data']['pa_method'] = 'V';
                    $result['data']['pa_pay_time'] = $xpay->Response('LGD_PAYDATE', 0);
                } elseif ($LGD_PAYTYPE == 'SC0040') {
                    $result['data']['pa_method'] = 'B';
                }
            } else {
                $err_code = $xpay->Response_Code();
                $err_msg = $xpay->Response_Msg();
                $result['msg'] = 'Error Code : ' . $err_code . "\n" . $err_msg;
            }
        } else {
            $result['msg'] = '알수 없는 오류가 발생하였습니다.';
        }

        Session::setSession('ss_pay_token', null);

        return $result;
    }

    /**
     * 유플러스 > 결제 영수증 정보 생성성
     * @param data
     * @return mixed
     */
    public static function makeBillDataUplus($data)
    {
        if (PG_MODE == 'service') {
            $data['pa_pg_mid'] = $data['pg_id'];
            $data['pa_bill_js'] = 'http://pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js';
        } elseif (PG_MODE == 'test') {
            $data['pa_pg_mid'] = 't' . $data['pg_id'];
            $data['pa_bill_js'] = 'http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js';
        }
        $data['pa_bill_auth'] = md5($data['pa_pg_mid'] . $data['pa_pg_tid'] . $data['pg_key']);

        return $data;
    }

    /**
     * KRP > PG 요청
     * @param array $data
     * @return array
     */
    protected static function requestPaymentKrp($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        File::makeDirectory(LOG_PATH . '/payment');
        // 전송 정보 세팅
        $arr = array(
            'mode'  => PG_MODE,                 // 결제 모드
            'ver'   => '210',                   // 연동 버전
            'mid'   => $data['pg_id'],          // 상점 아이디
            'txntype'   => 'PAYMENT',           // 거래 타입

            'ref'   => $data[static::$pg_pk],   // 결제고유번호
            'shop'  => HOMEPAGE_TITLE,          // 상점명

            'buyer' => $data['pa_buyer_name'],  // 구매자명
            'tel'   => $data['pa_buyer_tel'],   // 구매자연락처
            'email' => $data['pa_buyer_email'], // 구매자이메일

            'param1'    => $data['pa_module'] , // 원본모듈
            'param2'    => $data['pa_subject'], // 결제명
            'param3'    => $data['reg_id'],     // 결제자 ID

	        'item_0_product' => $data['pa_subject'],
	        'item_0_quantity' => 1,

            'charset'   => 'UTF-8',             // 언어셋
            'ostype'    => (IS_MOBILE) ? 'M' : 'P', // PC/모바일 여부 (P, M)
            'autoclose' => 'Y',                 // 자동 종료 여부(Y, N) -> N 이면 결제 완료화면이 출력됨
            'displaytype'   => 'R',             // 결제창 호출 방식 (P, I, R)

            'returnurl' => $data['pa_response_uri']  // 결제 성공 처리 Front-End URI
            //'statusurl' => $data['pa_response_uri'] // 결제 성공 처리 Back-End URI
        );

        // 결제수단
        if ($data['pa_method'] == 'C') {
            $arr['paymethod'] = 'P000'; // 신용카드
        } elseif ($data['pa_method'] == 'P') {
            $arr['paymethod'] = 'P001'; // 페이팔
        } elseif ($data['pa_method'] == 'U') {
            $arr['paymethod'] = 'P002'; // 유니온페이
        } elseif ($data['pa_method'] == 'A') {
            $arr['paymethod'] = 'P003'; // 알리페이
        } elseif ($data['pa_method'] == 'T') {
            $arr['paymethod'] = 'P004'; // 텐페이
        } elseif ($data['pa_method'] == 'W') {
	        $arr['paymethod'] = 'P141'; // 위챗
        	if (IS_WEBVIEW) {
		        $arr['paymethod'] = 'P142'; // 위챗
		        $arr['ostype'] = 'M';
	        }
        }

        // 언어
        $lang_code = I18n::getLanguageCode();
        if ($lang_code == 'jpn') {
            $arr['lang'] = 'JP';
        } elseif ($lang_code == 'chn1' || $lang_code == 'chn2') {
            $arr['lang'] = 'CN';
        } else {
            $arr['lang'] = 'EN';
        }

        // 화폐단위
        $unit_code = $data['pa_unit_code'];
        if ($unit_code == 'jpy') {
            $arr['cur'] = 'JPY';
        } elseif ($unit_code == 'eur') {
            $arr['cur'] = 'EUR';
        } elseif ($unit_code == 'cny') {
	        $tmp_local_data = I18n::getUnitData('usd');
	        $data['pa_price'] = I18n::localizePrice($data['od_real_price'], 'usd' , $tmp_local_data['local_rate']);
            $arr['cur'] = 'USD';
        } else {
            $arr['cur'] = 'USD';
        }

        // 결제금액
        $arr['amt'] = $data['pa_price'];
		$arr['item_0_unitPrice'] = $data['pa_price'];

        // PG 정보 유효성 검사
        if (!$arr['mode'] || !$arr['mid'] || !$arr['returnurl'] || !$data['pg_key']) {
            $result['msg'] = 'PG 정보가 유효하지 않습니다.';
            return $result;
        }

        // 결제정보 유효성 검사
        if (!$arr['ref'] || !$arr['param1'] || !$arr['param2'] || !$arr['amt']) {
            $result['msg'] = '결제정보가 유효하지 않습니다.';
            return $result;
        }

        // 구매자 정보
        if (!$arr['buyer'] || !$arr['email'] || !$arr['tel'] || !$arr['param3']) {
            $result['msg'] = '구매자 정보가 유효하지 않습니다.';
            return $result;
        }

        // 암호화
        $link_buf = $data['pg_key'] . '?mid=' . $arr['mid'] . '&ref=' . $arr['ref'];
        $link_buf .= '&cur=' . $arr['cur'] . '&amt=' . $arr['amt'];
        $arr['fgkey'] = hash('sha256', $link_buf);

        // 전송자료 생성
        if ($arr['mode'] == 'service') {
            $action_uri = 'https://secureapi.eximbay.com/Gateway/BasicProcessor.krp';
        } elseif ($arr['mode'] == 'test') {
            $action_uri = 'https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp';
        } else {
            $action_uri = '';
        }
        $content = '<form name="pay_form" id="pay_form" method="post" action="' . $action_uri . '">' . "\n";
        foreach ($arr as $key => $val) {
            $content .= '<input type="hidden" name="' . $key . '" value="' . $val . '" />' . "\n";
        }
        $content .= '</form>' . "\n";
        $content .= '<script type="text/javascript">' . "\n";
        $content .= '//<![CDATA[' . "\n";
        $content .= 'document.pay_form.submit();' . "\n";
        $content .= '//]]>' . "\n";
        $content .= '</script>' . "\n";

        $result['code'] = 'success';
        $result['content'] = $content;

        Session::setSession('ss_pay_token', $data[static::$pg_pk]);

        return $result;
    }

    /**
     * KRP > PG 응답
     * @param array $data
     * @return array
     */
    private static function responsePaymentKrp($data = array())
    {
        $result = array(
            'code' => 'failure'
        );

        // 중도 취소일 경우
        $rescode = $_POST['rescode'];
        if ($rescode != '0000') {
            $result['msg'] = 'Error Code : ' . $rescode . "\n" . $_POST['resmsg'];
            return $result;
        }

        // 정보 세팅
        $arr = array(
            static::$pg_pk  => $_POST['ref'],
            'pa_module'     => $_POST['param1'],
            'pa_subject'    => $_POST['param2'],
            'pa_price'      => $_POST['amt'],
            'pa_buyer_name' => $_POST['buyer'],
            'pa_buyer_email'    => $_POST['email'],
            'pa_buyer_tel'  => $_POST['tel'],
            'reg_id'        => $_POST['param3'],
            'pa_pg_tid'     => $_POST['transid'],
            'pa_finance_code'   => $_POST['paymethod'],
            'pa_finance_no' => $_POST['cardno1'] . '********' . $_POST['cardno4']
        );

        // 토큰 검사
        $pay_token = Session::getSession('ss_pay_token');
        if ($pay_token != $arr[static::$pg_pk]) {
            $result['msg'] = '토큰이 유효하지 않습니다.';
            return $result;
        }

        // 공개키 검사
        $fgkey = strtolower($_POST['fgkey']);
        if (!$fgkey) {
            $result['msg'] = '인증키가 유효하지 않습니다.';
            return $result;
        }

        $link_buf = $data['pg_key'] . '?mid=' . $_POST['mid'] . '&ref=' . $arr[static::$pg_pk];
        $link_buf .= '&cur=' .$_POST['cur'] .'&amt=' .$arr['pa_price'];
        $link_buf .= '&rescode=' . $rescode . '&transid=' .$arr['pa_pg_tid'];

        $new_fgkey = hash('sha256', $link_buf);

        if ($fgkey == $new_fgkey) {
            $result['code'] = 'success';
            $result['msg'] = '결제가 성공적으로 처리되었습니다.';
            $result['data'] = array_merge($arr, array(
                'pa_pay_time'   => ''
            ));

            // 결제 유형에 따른 처리
            $paymethod = $_POST['paymethod'];
            if ($paymethod == 'P000' || $paymethod == 'P101' || $paymethod == 'P102'
                || $paymethod == 'P103' || $paymethod == 'P104') {
                $result['data']['pa_method'] = 'C';
                if ($paymethod == 'P101') {
                    $result['data']['pa_finance_name'] = 'VISA';
                } elseif ($paymethod == 'P102') {
                    $result['data']['pa_finance_name'] = 'MasterCard';
                } elseif ($paymethod == 'P103') {
                    $result['data']['pa_finance_name'] = 'AMEX';
                } elseif ($paymethod == 'P104') {
                    $result['data']['pa_finance_name'] = 'JCB';
                } else {
                    $result['data']['pa_finance_name'] = 'CreditCard';
                }
            } elseif ($paymethod == 'P001') {
                $result['data']['pa_method'] = 'P';
                $result['data']['pa_finance_name'] = 'PayPal';
                $result['data']['pa_auth_no'] = $_POST['pp_transid'];
            } elseif ($paymethod == 'P002') {
                $result['data']['pa_method'] = 'U';
                $result['data']['pa_finance_name'] = 'UnionPay';
            } elseif ($paymethod == 'P003') {
                $result['data']['pa_method'] = 'A';
                $result['data']['pa_finance_name'] = 'Alipay';
            } elseif ($paymethod == 'P004' || $paymethod == 'P141' || $paymethod == 'P142') {
                if ($paymethod == 'P141' || $paymethod =='P142') {
	                $result['data']['pa_method'] = 'W';
                    $result['data']['pa_finance_name'] = 'WeChat';
                } else {
	                $result['data']['pa_method'] = 'T';
                    $result['data']['pa_finance_name'] = 'Tenpay';
                }
            }
        } else {
	        if (PG_MODE == 'service') {
		        $refund_url = 'https://secureapi.eximbay.com/Gateway/DirectProcessor.krp';
	        } else {
		        $refund_url = 'https://secureapi.test.eximbay.com/Gateway/DirectProcessor.krp';
	        }
			$refund_data = array(
				'ver' => '210',
				'mid' => $_POST['mid'],
				'txntype' => 'REFUND',
				'refundtype' => 'F',
				'ref' => $_POST['ref'],
				'cur' => $_POST['cur'],
				'amt' => $_POST['amt'],
				'transid' => $_POST['transid'],
				'reason' => 'fgkey 불일치',
				'param1' => $_POST['param1'],
				'param2' => $_POST['param2'],
				'param3' => $_POST['param3'],
				'fgkey' => $_POST['fgkey']
			);


	        $refund_request = curl_init();
	        curl_setopt ($refund_request, CURLOPT_URL, $refund_url);
	        curl_setopt ($refund_request, CURLOPT_POST, 1);
	        curl_setopt ($refund_request, CURLOPT_POSTFIELDS, $refund_data);
	        //curl_setopt ($refund_request, CURLOPT_POSTFIELDSIZE, 0);
	        curl_setopt ($refund_request, CURLOPT_RETURNTRANSFER, 1);
	        $res = curl_exec ($refund_request);

	        curl_close($refund_request);


            $result['msg'] = 'Error Code : ' . $rescode . "\n" . 'Invalid transaction';
        }

        Session::setSession('ss_pay_token', null);

        return $result;
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

	var $newdata = array();
	var $fdata = "";
	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		

		
		$this->load->helper('url');  //redirect 사용을 위해 설정
		
		
		//=====================================================
		//전체시스템 변수 초기화=====================================
		$config['csrf_protection'] = FALSE;
		//초기접근시 페이지 세션없는 경우 0으로 설정
		if(!$this->session->userdata('page')) $this->session->set_userdata('page', 0);
		
		
		//=====================================================
		//현재컨트롤 변수초기화
		//=====================================================
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
		$this->session->set_userdata('mrbaseUrl', base_url());
	
		
		//로그인된 경우 메인페이지로 간다.
		if($this->session->userdata('memid')) redirect(rtPathP('homect')."homect");
		
		$plink = array("md"=>"login", "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		$param = array_merge($plink, array("fmemid" => "0"));
		
		
		//=====================================================
		
	

			
		
			
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		if($this->session->userdata('memid')){
			//echo "login ok";
			redirect(rtPathP('homect')."homect") ;
		}else{
			

			$plink = array("md"=>"login", "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
			$param = array_merge($plink, array("fmemid" => "0"));
			

			//$param['qqq'] = $cap;
			$this->load->view("common/login", $param);
			
		}
	
	}
	
	
    function _auth_img()
    {
        $captcha_word = rand(12121, 99999);
        $config = array(
            'word'   => $captcha_word,
            'img_path'   => 'images/captcha/',
            'img_url'    => 'http://mroo.co.kr'.PREDIR.'/images/captcha/',
            //'font_path'  => BASEPATH . 'fonts/texb.ttf',
            'img_width'  => '150',
            'img_height' => 30,
            'expiration' => 30
        );
         
        //$this->session->set_flashdata('captcha_word', $captcha_word);
         
        return create_captcha($config);
    }  	
	
	

	public function getWebHesh(){
		
		echo $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
	
	}





	public function personJoin(){  //개인 회원가입

		$this->load->helper('captcha');
		$captcha_word = "kkkk";

        if($captcha_word != '') {
            $data['result'] = $captcha_word == $this->session->flashdata('captcha_word') ? 'SUCESS' : 'FAIL';
        } else {
            $data['result'] = '';
        }
		
		$cap = $this->_auth_img();
		$data = array(
    		'captcha_time'	=> $cap['time'],
   		 	'ip_address'	=> $this->input->ip_address(),
    		'word'	=> $cap['word']
    	);
	
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$data['cap'] = $cap;
		
	
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//모델에서 모든 업체의 정보를 가져온다.
		$coarray = $this->member->allCompanyNameId();
		
		$plink = array("md"=>"mem", "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		
		//$param = array("mode" => "personJ");
		$this->load->view("common/login", array_merge($data, $plink, array("coary"=>$coarray, "fmemid" => "0")));
	
	}
	
	//엄체회원 가입 완료
	public function onMember($md){
		
		$this->load->helper('captcha');
		$captcha_word = "kkkk";

        if($captcha_word != '') {
            $data['result'] = $captcha_word == $this->session->flashdata('captcha_word') ? 'SUCESS' : 'FAIL';
        } else {
            $data['result'] = '';
        }
		
		$cap = $this->_auth_img();
		$data = array(
    		'captcha_time'	=> $cap['time'],
   		 	'ip_address'	=> $this->input->ip_address(),
    		'word'	=> $cap['word']
    	);
	
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$data['cap'] = $cap;
		
		
		
		
		$plink = array("md"=>$md, "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		$param = array_merge($data, $plink, array("fmemid" => "0"));
		
		if($md == "cook"){
			$this->load->view("common/login", $param);
		
		}else{
		
		}
	}


	//아이디 찾기 실패로 호출
	public function findMemPw($rr){
		
		$plink = array("md"=>$rr, "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		$param = array_merge($plink, array("fmemid" => "0"));
		
		$this->load->view("common/login", $param);
	}
	
	
	//아이디 찾기 실패로 호출
	public function findMemId($rr, $mid){
		$plink = array("md"=>$rr, "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		$param = array_merge($plink, array("fmemid" => $mid));
		
		$this->load->view("common/login", $param);
	}
	
	
	
	public function companyJoinChn(){  //업체 회원가입
	
	
		$this->load->helper('captcha');
		$captcha_word = "kkkk";

        if($captcha_word != '') {
            $data['result'] = $captcha_word == $this->session->flashdata('captcha_word') ? 'SUCESS' : 'FAIL';
        } else {
            $data['result'] = '';
        }
		
		$cap = $this->_auth_img();
		$data = array(
    		'captcha_time'	=> $cap['time'],
   		 	'ip_address'	=> $this->input->ip_address(),
    		'word'	=> $cap['word']
    	);
	
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$data['cap'] = $cap;
		
	
		$plink = array("md"=>"co", "md2"=>0, "md3"=>0, "md4"=>0, "fnd"=>"0", "page"=>0, "ppn"=>0, "onmd"=>0, "coid"=>0, "secoid"=>0);
		$param = array_merge($data, $plink, array("fmemid" => "0"));
		
		$this->load->view("common/login", $param);
	
	}


	public function idOkInf(){  //아이디 중복확인을 한다.
	
		$mid = $this->input->post('memid', TRUE);
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//모델에서 로그인 처리를 한다.
		$meminf = $this->member->getMemId($mid);
		
		$rr = array('rs' => (int)$meminf[0]['su']);

		echo json_encode($rr);   //호출한 곳으로 결과를 되돌린다.
		
	
	}


	//캡챠 체크를 한다. 
	public function getCaptcha(){
	
		$this->load->model('member/member');
		
		$inf = $this->member->captchaInf(array("time"=>$this->input->post('etime', TRUE), "ip"=>$this->input->post('capip', TRUE), "word"=>$this->input->post('word', TRUE)));
	
		
		$rr = array("su"=>$inf);
		
		echo json_encode($rr);
	
	}
	
	
	//회원등록을 한다.
	public function personFormOn(){
		$day = date("Y-m-d H:i:s");
		$this->load->model('member/member');
		
		switch($this->input->post('gubun', TRUE)){
		case 1: //게열사 
			$po = 3;
		break;
		case 2:  //조합 
			$po = 2;
		break;
		case 3:   //본사
			$po = 3;
		break;
		}
		
			//회원등록을 한다.
			$data = array("memid" => $this->input->post('memid', TRUE), "name" => $this->input->post('name', TRUE), "gubun"=>1, "onday" => $day, "email"=> $this->input->post('email1', TRUE)."@".$this->input->post('email2', TRUE), "passwd"=> base64encode($this->input->post('mempass', TRUE)), "tel"=> base64encode($this->input->post('memtel', TRUE)), "cogubun"=>$this->input->post('gubun', TRUE), "potion"=>$po, "coid"=>$this->input->post('conameSe', TRUE));
			
			//회원등록을 한다.
			$meminf = $this->member->onMemberData($data);
			
			if($meminf > 0){
				//뷰어를 호출 한다.
				$this->session->set_flashdata('loginf', '회원가입 완료 하였습니다. 가입승인 후 로그인 가능합니다.');
				redirect("/home") ;
	
			}



	}


	//웹에서 로그인을 한다.
	public function authWeb(){
		
		$mid = $this->input->post('memid', TRUE);
		$pass = base64encode($this->input->post('passwd', TRUE));
	


		//echo "pass==".$pass;
		//return;
		
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		
		//모델에서 로그인 처리를 한다.
		$meminf = $this->member->getLoginW($mid, $pass);



		//echo (int)$meminf[0]['su'];
		if((int)$meminf->su > 0){
			if($meminf->stat == 1){
							//로그인 실패
				$newdata = array('id' => 0, 'memid' => '', 'password' => '', 'potion' => 0, 'coid' => 0, 'cogubun' => 0, 'desang' => 0, 'logged_in' => FALSE);
				$this->session->unset_userdata($newdata);
				
				$this->session->set_flashdata('loginf', '현재 가입승인 대기중입니다.');
				
				echo '{"rs":"no"}';
				
			}else if((int)$meminf->stat == 3){
			
										//로그인 실패
				$newdata = array('id' => 0, 'memid' => '', 'password' => '', 'potion' => 0, 'coid' => 0, 'cogubun' => 0, 'desang' => 0, 'logged_in' => FALSE);
				$this->session->unset_userdata($newdata);
				
				$this->session->set_flashdata('loginf', '로그인 정지, 관리자에게 문의하세요.');
				
				echo '{"rs":"no"}';
			
			}else{
				//로그인 했다.
				$newdata = array('id' => (int)$meminf->id,  'memid' => $mid, 'password' => $pass, 'potion' => (int)$meminf->potion, 'coid' => (int)$meminf->coid, 'cogubun' => (int)$meminf->cogubun, 'desang' => 0, 'logged_in' => TRUE, 'secoid'=>(int)$meminf->coid);
				$this->session->set_userdata($newdata);  
				
				echo '{"rs":"ok", "po":'.(int)$meminf->potion.', "coid":'.(int)$meminf->coid.', "cogb":'.(int)$meminf->cogubun.'}';
				
			}
		
		}else{
				//로그인 실패
				$newdata = array('id' => 0, 'memid' => '', 'password' => '', 'potion' => 0, 'coid' => 0, 'cogubun' => 0, 'desang' => 0, 'logged_in' => FALSE);
				$this->session->unset_userdata($newdata);
				
				$this->session->set_flashdata('loginf', '로그인 실패하였습니다. 아이디와 비번을 다시 확인하세요.');
				
				echo '{"rs":"no"}';
		}
		
		

	}


}





?>
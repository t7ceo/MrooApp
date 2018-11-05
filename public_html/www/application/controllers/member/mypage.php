<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mypage extends CI_Controller{

	var $newdata = array();
	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');   //redirect 사용을 위해 설정
		
		//echo base_url();
		//echo current_url();
		//$ci = get_instance();

		$nowControl = $this->router->fetch_class();
		
		$this->session->set_userdata('mainMenu', $nowControl);
	
		
		
		if(!$this->session->userdata('memid')){
			redirect("/home") ;
		}else{
			$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
			
			//회원의 자격으로 열수 없는 페이지는 강제로 페이지 전환한다.
			$rra = pageGoInf("main");
			if($rra['rs']) redirect($rra['page']);
		

		}
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		//디폴트 서버메뉴를 설정 한다.
		//set_defaultSub();
		
		
		if($this->session->userdata('memid')){
			if($this->session->userdata('potion') > SAWON){
				//관리자 이상인 경우
				if(!$this->session->userdata('main')) $gg = 1;
				else $gg = $this->session->userdata('main');
			}else{
				$gg = 4;  //관리자 이하는 마이페이지만 접근 가능하다.
			}
			$this->getView($gg);

			
		}else{
			//echo "login no";
			redirect("/home") ;
		}

	}

	//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md, $md2, $md3 = 0, $md4 = 0, $fnd="0", $page=0){
		$pid = $md2;
		
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		
	
		$this->session->set_userdata('mypage', $md);
		$this->session->set_userdata('desang', $pid);

		$param = array("mode" => "main", "md" => $md, "md2"=>1);
		$this->load->view("common/head", $param);
		
		//관리자 이하는 무조건 마이페이지로 간다.
		if($this->session->userdata('potion') < ADMIN) $md = 1; 
		
		//if($md == 2) $md = 1;
		
		
		$pt = "";
		switch($md){
		case 1:  //정보수정
		
			$pt = get_subMenuNam("mypage", $md);
			$this->load->model('member/member');
			$meminf = $this->member->myInfo($pid);  //회원정보 수정을 위해 정보를 가져온다.
			
			//모델에서 모든 업체의 정보를 가져온다.
			$coarray = $this->member->allCompanyNameId();
			//echo count($coarray);
			//var_dump($coarray);
			
			$miobj = array("myinfo" => $meminf, "coary" => $coarray);
			$this->load->view("member/memEdit", $miobj);

		break;
		case 2:  //상세보기 
			$pt = get_subMenuNam("mypage", $md);
			$this->load->model('member/member');
			$meminf = $this->member->myInfoRow($pid);  //회원 상세보기
			
		
			$miobj = array("row" => $meminf);
			$this->load->view("member/sangse", $miobj);
		
		break;
		}
		

		
		$this->load->view("common/foot", $plink);
	
	}
	
	

	


	public function logout(){
			$newdata = array('memid' => '', 'password' => '', 'main' => '', 'logged_in' => FALSE);
			$this->session->unset_userdata($newdata);
			redirect("/home");
	}



	
		//업체정보를 수정 한다..
	public function coFormEdit(){

		$this->load->model('member/member');


			$rtt = "정보수정이 완료되었습니다.";
			//업체 정보를 수정한다.
			if( $this->input->post('passchn', TRUE) == "ok"){   //비밀번호 변경한다.--------------------
				$npass =  base64encode($this->input->post('newcopass', TRUE));
				
				//기존 비밀번호를 가져온다.
				$pass = $this->member->myPass($this->input->post('corecid', TRUE));
				if(base64encode($this->input->post('copass', TRUE)) != $pass->passwd){
					
					$rtt = "기존 비밀번호 오류 입니다. 다시 확인하세요.";
					
				}else{
				
					if($this->input->post('oldEmail', TRUE) != $this->input->post('coemail1', TRUE)."@".$this->input->post('coemail2', TRUE)){  //이메일 수정한다.
						//비밀번호와 이메일을 변경한다.
						$data = array("tel" => base64encode($this->input->post('cotel', TRUE)),  "coname"=>$this->input->post('coname', TRUE), "name"=>$this->input->post('name', TRUE), "conum"=> $this->input->post('cosaupnum', TRUE),  "post"=> $this->input->post('copost', TRUE), "address"=>$this->input->post('coaddress', TRUE), "email"=> $this->input->post('coemail1', TRUE)."@".$this->input->post('coemail2', TRUE), "passwd"=> $npass);
					}else{  //이메일 수정하지 않는다.
						//비밀번호만 변경한다.
						$data = array("tel" => base64encode($this->input->post('cotel', TRUE)), "coname"=>$this->input->post('coname', TRUE), "name"=>$this->input->post('name', TRUE), "conum"=> $this->input->post('cosaupnum', TRUE),  "post"=> $this->input->post('copost', TRUE), "address"=>$this->input->post('coaddress', TRUE), "passwd"=> $npass);
					}
					
					//업체 정보를 수정한다.
					$meminf = $this->member->edtCoData($data, $this->input->post('corecid', TRUE));
				
				}
			
			}else{  //비밀번호 변경하지 않는다.---------------------------------------
				if($this->input->post('oldEmail', TRUE) != $this->input->post('coemail1', TRUE)."@".$this->input->post('coemail2', TRUE)){  //이메일 수정한다.
					//이메일을 변경한다.
					$data = array("tel" => base64encode($this->input->post('cotel', TRUE)), "coname"=>$this->input->post('coname', TRUE), "name"=>$this->input->post('name', TRUE), "conum"=> $this->input->post('cosaupnum', TRUE),  "post"=> $this->input->post('copost', TRUE), "address"=>$this->input->post('coaddress', TRUE), "email"=> $this->input->post('coemail1', TRUE)."@".$this->input->post('coemail2', TRUE));
				}else{  //이메일과 비밀번호 수정하지 않는다.
				
					$data = array("tel" => base64encode($this->input->post('cotel', TRUE)), "coname"=>$this->input->post('coname', TRUE), "name"=>$this->input->post('name', TRUE), "conum"=> $this->input->post('cosaupnum', TRUE),  "post"=> $this->input->post('copost', TRUE), "address"=>$this->input->post('coaddress', TRUE) );
				}
				
				//업체 정보를 수정한다.
				$meminf = $this->member->edtCoData($data, $this->input->post('corecid', TRUE));
				
				
			}    //--------------------------------------------------------
			
			

				//뷰어를 호출 한다.
				$this->session->set_flashdata('coedit', $rtt);
				redirect("/member/mypage/getView/1/". $this->input->post('corecid', TRUE)) ;
	
			


	}
	


	
	//회원수정을 한다.
	public function personFormEdit(){
		$day = date("Y-m-d H:i:s", time());
		$this->load->model('member/member');
		
		
			//회원수정을 한다.
			$rtt = "개인정보 수정 완료 하였습니다.";
			
			if( $this->input->post('passchn', TRUE) == "ok"){   //비밀번호 변경한다.--------------------
			
				$npass =  base64encode($this->input->post('newmempass', TRUE));
				//기존 비밀번호를 가져온다.
				$pass = $this->member->myPass($this->input->post('memrecid', TRUE));
				if(base64encode($this->input->post('mempass', TRUE)) != $pass->passwd){
					
					$rtt = "기존 비밀번호 오류 입니다. 다시 확인하세요.";
					
				}else{
			
					if($this->input->post('oldEmail', TRUE) != $this->input->post('email1', TRUE)."@".$this->input->post('email2', TRUE)){  //이메일 수정한다.
						//비밀번호와 이메일을 변경한다.
						$data = array("name"=>$this->input->post('name', TRUE) ,"email"=> $this->input->post('email1', TRUE)."@".$this->input->post('email2', TRUE), "passwd"=> $npass, "tel"=> base64encode($this->input->post('memtel', TRUE)));
					}else{  //이메일 수정하지 않는다.
						//비밀번호만 변경한다.
						$data = array("name"=>$this->input->post('name', TRUE) , "passwd"=> $npass, "tel"=> base64encode($this->input->post('memtel', TRUE)));
					}
			
					//회원정보 수정을 한다.
					$meminf = $this->member->edtMemberData($data, $this->input->post('memrecid', TRUE));
			
				}
			
			}else{  //비밀번호 변경하지 않는다.---------------------------------------
				if($this->input->post('oldEmail', TRUE) != $this->input->post('email1', TRUE)."@".$this->input->post('email2', TRUE)){  //이메일 수정한다.
					//이메일을 변경한다.
					$data = array("name"=>$this->input->post('name', TRUE) , "email"=> $this->input->post('email1', TRUE)."@".$this->input->post('email2', TRUE), "tel"=> base64encode($this->input->post('memtel', TRUE)));
				}else{  //이메일과 비밀번호 수정하지 않는다.
					$data = array("name"=>$this->input->post('name', TRUE) , "tel"=> base64encode($this->input->post('memtel', TRUE)));
				}
				
				//회원정보 수정을 한다.
				$meminf = $this->member->edtMemberData($data, $this->input->post('memrecid', TRUE));
			}    //--------------------------------------------------------
			

			
				//뷰어를 호출 한다.
				$this->session->set_flashdata('memedit', $rtt);
				redirect("/member/mypage/getView/1/".$this->input->post('memrecid', TRUE)) ;
	

		}




}





?>
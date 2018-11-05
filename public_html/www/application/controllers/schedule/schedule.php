<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Schedule extends CI_Controller{

	var $newdata = array();
	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');   //redirect 사용을 위해 설정
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
	

		
		if(!$this->session->userdata('memid')){
			redirect("/home") ;
		}
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		if($this->session->userdata('memid')){
			
			if(!$this->session->userdata('schedule')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();		
			}else $gg = $this->session->userdata('schedule');
			
			$this->getView($gg);
		
		}else{
			//echo "login no";
			redirect("/home") ;
		}
	
	}
	
		//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md = 1, $md2 = 1, $md3 = 0, $md4 = 0, $fnd="0"){
		
		if($this->session->userdata("cogubun") == JOHAPG) $md = 2;
		
		

		$this->config->set_item('Vmd',$md);
		
		$this->session->set_userdata('schedule', $md);
	
		$this->load->model('schedule/schedulem');



		if(!$md3){
			$year = date( "Y" ); 
		}else{
			$year = $md3;
		}
		if(!$md4){
			$month = date( "m" ); 
		}else{
			$month = $md4;
		}
		
		
		//==================================
		$pagePerNum = PAGELINE;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>0, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		//==================================
			
		$param = array("mode" => "schedule", "md"=>$md, "md2"=>$md2);
		$this->load->view("common/head", $param);
		
		
		
		$pt = "";
		

		//날짜사이를 전체 스케줄을 가져온다.-coid를 전달한다.
		function getSchedule($today, $md, $coid){
			$aa = new Schedulem;
			
			
			$list = $aa -> getList($today, $md, $coid);
			$len = count($list);
			

			$html = '';
			$i = 1;
			foreach($list as $rows){   
				$html .= "<span style='display:inline-block; width:100%;background-color:".$rows->color."'>";
				$html .= "<a href='/schedule/schedule/getView/".$md."/3/".$rows->id."'><span style='color:white;'>".$rows->title."</span></a>";
				$html .= "</span><br>";
				
				$i++;
			}

			return $html;
		}

		

		switch($md){
		case 1:
			$pt = "본사 스케줄";	
			
			//$list = $this->schedulem->getList($today='');		

			if($md2 == 1){
				//$list = $this->scene->getList($sstion);
				//자사스케줄은 coid 로 전달한다.
				
				$this->load->view("schedule/viewCald", array("onmd"=>$md2, "md"=>$md, "year"=>$year, "month"=>$month, "coid"=>BONSAID));
			}else if($md2 == 2){
				
				//본사직원이 등록한다.
				$this->load->view("schedule/bonsaOnput", array("onmd"=>$md2, "md"=>$md, "coid"=>BONSAID));
			}else if($md2 == 3){
				$rr = $this->schedulem->getView($md3);			

				$this->load->view("schedule/view", array("onmd"=>$md2, "md"=>$md, "bd"=>$rr));
			}else if($md2 == 4){
				
				$rr = $this->schedulem->getView($md3);
				$this->load->view("schedule/modify", array("onmd"=>$md2, "id"=>$md3, "bd"=>$rr));
			}
			

		break;
		case 2: 
			$pt = "조합 스케줄";
			
			if($md2 == 1){
				
				$cid = 0;
				if($this->session->userdata("cogubun") == BONSA) $cid = 0;
				else if($this->session->userdata("cogubun") == JOHAPG) $cid = $this->session->userdata("coid");
				
				
				$this->load->view("schedule/viewCald", array("onmd"=>$md2, "md"=>$md, "year"=>$year, "month"=>$month, "coid"=>$cid));			
			}else if($md2 == 2){
				
				//본사 직원과 조합 직원이 등록한다.
				$this->load->view("schedule/bonsaOnput", array("onmd"=>$md2, "md"=>$md, "coid"=>$this->session->userdata("coid")));
			}else if($md2 == 3){
				$rr = $this->schedulem->getView($md3);		
				$this->load->view("schedule/view", array("onmd"=>$md2, "md"=>$md, "bd"=>$rr));
			}else if($md2 == 4){
				$rr = $this->schedulem->getView($md3);
				
				//echo var_dump($rr);

				$this->load->view("schedule/modify", array("onmd"=>$md2, "id"=>$md3, "bd"=>$rr));
			}

		break;
		case 3: 
			$pt = "자사 스케줄";
			
			if($md2 == 1){
				
				$cid = 9999999;
				if($this->session->userdata("cogubun") == BONSA) $cid = 0;
				else if($this->session->userdata("cogubun") == JASA) $cid = $this->session->userdata("coid");
				
				
				$this->load->view("schedule/viewCald", array("onmd"=>$md2, "md"=>$md, "year"=>$year, "month"=>$month, "coid"=>$cid));			
			}else if($md2 == 2){
				
				//본사 직원과 계열사 직원이 등록한다.
				$this->load->view("schedule/bonsaOnput", array("onmd"=>$md2, "md"=>$md, "coid"=>$this->session->userdata("coid")));
			}else if($md2 == 3){
				$rr = $this->schedulem->getView($md3);		
				$this->load->view("schedule/view", array("onmd"=>$md2, "md"=>$md, "bd"=>$rr));
			}else if($md2 == 4){
				$rr = $this->schedulem->getView($md3);

				$this->load->view("schedule/modify", array("onmd"=>$md2, "id"=>$md3, "bd"=>$rr));
			}

		break;
		case 4:
			$this->load->model('schedule/schedulem');
			$this->load->view("schedule/viewCald", array("onmd"=>$md2));
		
		break;
		}
		
	
		
		$this->load->view("common/foot", $plink);
	
	}






	public function onputSchedule(){
		$this->load->model('schedule/schedulem');

		$md = $this->input->post("md",true);
		$md2 = $this->input->post("md2",true);
		$coid = $this->input->post("coid",true);

		$title = $this->input->post("title",true);
		$start_dt = $this->input->post("start_dt",true);
		$end_dt = $this->input->post("end_dt",true);
		$color = $this->input->post("color",true);
		$content = $this->input->post("content",true);
		$regdate = date('Y-m-d H:i:s');
		$type = $this->input->post("type",true);



		if($type == "insert"){
			$arr = array("title"=>$title, "coid"=>$coid, "start_dt"=>$start_dt, "end_dt"=>$end_dt, "color"=>$color, "content"=>$content, "memid"=>$this->session->userdata('id'), "regdate"=>$regdate, "gubun"=>$md);
			$result = $this->schedulem->setEvent($arr);
		}else{
			$id = $this->input->post("id",true);

			$arr = array("id"=>$id, "title"=>$title, "coid"=>$coid, "start_dt"=>$start_dt, "end_dt"=>$end_dt, "color"=>$color, "content"=>$content, "moddate"=>$regdate);
			$result = $this->schedulem->editEvent($arr);
		}

		redirect("/schedule/schedule/getView/".$md."/1");
	}
	
	public function setEvent(){
		
		$this->load->model('schedule/schedulem');
		$arr = array("evid"=>$this->input->post("evid",true) , "bdgubun"=>$this->input->post("bdgb",true) ,"title"=>$this->input->post("title",true) ,"startdate"=>$this->input->post("start",true), "enddate"=>$this->input->post("end",true));
		$rr = $this->schedulem->setEvent($arr);
		
		//if($rr > 0){
			$arr2 = array("bdgubun"=>$this->input->post("bdgb",true) , "start"=>$this->input->post("start",true) ,"end"=>$this->input->post("end",true));
			$rr2 = $this->schedulem->getScjul($arr2);
		//}


		echo json_encode($rr2);
	
	}
	
	
	//이벤트 수정
	public function editEvent(){
	
		$this->load->model('schedule/schedulem');
		
		$evid = $this->input->post("evid",true);
		$txt = $this->input->post("memo", true);
		$stt = $this->input->post("stval",true);
		$ett = $this->input->post("edval",true);
		
		$arr = array("evid"=>$evid, "memo"=>$txt, "stt"=>$stt, "ett"=>$ett);

		$rr = $this->schedulem->editEvent($arr);
		
		echo json_encode(array("rs"=>$rr));


	
	}
	
	//이벤트 삭제
	public function delEvent($param1, $param2){
	
		$this->load->model('schedule/schedulem');
		$rr = $this->schedulem->delEvent($param2);

		redirect("/schedule/schedule/getView/".$param1);

	}
	
	
	
	
	public function getJson(){
					/*
					{
						title: 'All Day Event',
						start: new Date(y, m, 28),
						end: new Date(y, m, 29)
					},
					{
						title: 'Birthday Party',
						start: new Date(y, m, d+1, 19, 0),
						end: new Date(y, m, d+1, 22, 30),
						allDay: false
					},
					{
						title: 'Click for Google',
						start: new Date(y, m, 28),
						end: new Date(y, m, 29),
						url: 'http://google.com/'
					}
					*/
		
		$this->load->model('schedule/schedulem');
		$arr = array("bdgubun"=>$this->input->post("bdgb",true) , "start"=>$this->input->post("start",true) ,"end"=>$this->input->post("end",true));
		$rr = $this->schedulem->getScjul($arr);
		
		echo json_encode($rr);
	}
	
	

	public function logout(){
			logout();
	}



}





?>
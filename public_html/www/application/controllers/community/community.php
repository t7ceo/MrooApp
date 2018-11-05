<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Community extends CI_Controller{
	
	public $mybd;
	
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
		
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		
		
		if($this->session->userdata('memid')){
			
			if(!$this->session->userdata('community')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();	
			}else{
				
				$gg = $this->session->userdata('community');
			}
			
			$this->getView($gg);
		
		}else{
			//echo "login no";
			redirect("/home") ;
		}
	
	}

		//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md, $md2 = 1, $md3=0, $md4=0, $fnd="0", $page=0){
				
		if($this->session->userdata('main') != $md){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}	
		
		//게시판의 아이디 설정===================
		/*
		if($md != 1 and $md != 2){
			if(!$this->session->userdata("bdid")) $this->session->set_userdata("bdid", 0);
			if($md2 == 1){
				$mdd = explode("-", $md);
				if(count($mdd) == 1){
					if($this->session->userdata("bdid") > 0){
						$md = $mdd[0];
						$mdd[1] = $this->session->userdata("bdid");
						$mdbdid = $this->session->userdata("bdid");
					}else{
						$md = $mdd[0];
						$mdd[1] = 0;
						$mdbdid = 0;
					}

				}else{
					$md = $mdd[0];
					$mdbdid = $mdd[1];
				}
				
				$this->session->set_userdata("bdid", $mdbdid);
			}else{
				$mdbdid = $this->session->userdata("bdid");
			}
		}
		*/
		//================================
		
		
		
			
		$this->load->library('pagination');
	
		$this->session->set_userdata('main', $md);
		$this->session->set_userdata('old', $this->session->userdata("md2"));
		$this->session->set_userdata("md2",$md2);
		$this->session->set_userdata("co", 0);
		//if($fnd == "") $fnd = $md4;

		$this->load->model('community/communitybd');
		//자료실 게시판의 갯수를 구한다.
		$jaubd = $this->communitybd->allBoard(1);
		
		//자료실 게시판의 갯수를 구한다.
		$datbd = $this->communitybd->allBoard(2);

	
	
		$this->session->set_userdata('community', $md);
	

		//===================================================
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/community/community/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
		$config["per_page"] = $pagePerNum;
		$config["num_links"] = 10;
		$config["cur_page"] = $page;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')));
		//===================================================



		$param = array("mode" => "community", "md"=>$md, "md2"=>$md2, "md3"=>$md3, "datbd"=>$datbd);
		$this->load->view("common/head", $param);


		$pt = "";

		$pagePerNum = 10;


		switch($md){
		case 1:
			$pt = "공지사항";

			if($md3 == 1){   //공지리스트
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				//공지 리스트 
				$su = count($this->communitybd->gongjiTotalCount(1));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
				
				$allbd = $this->communitybd->gongjiList(1, $page,$pagePerNum);
				
				
				
				$su2 = count($this->communitybd->faqTotalCount($md));
				$config["total_rows"] = $su2;
				$this->pagination->initialize($config);
				
				$faq = $this->communitybd->faqList($md2,$page,$pagePerNum);				
				
				
				
				$su3 = count($this->communitybd->faqbdTotalCount($md));
				$config["total_rows"] = $su3;
				$this->pagination->initialize($config);
				
				$qna = $this->communitybd->faqbdList($md,$page,$pagePerNum);				
				

				
				$this->load->view("community/gongjiBonsa", array_merge($plink, array("allbd"=>$allbd, "totalCount1"=>$su, "faq"=>$faq, "totalCount2"=>$su2, "qna"=>$qna, "totalCount3"=>$su3)));
				
			}else if($md3 == 2){   //공지등록
				//공지 작성
				$this->load->view("community/bonsaOn", $plink);
				
				
			}else if($md3 == 3){
				

				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);  //사업의 상세정보를 가져온다.
				
				
				//공지보기 
				$sebd = $this->communitybd->getGongji($md4);
				
				//댓글을 가져온다.
				$detall = $this->communitybd->getDet($md4, $md);
				
				$this->load->view("community/gongjiSangse", array_merge($plink, array("sebd"=>$sebd, "det"=>$detall, "allfile" => $alladdfile)));
				
				

			}else{   //md3 == 4
			

				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);  //사업의 상세정보를 가져온다.
			
				//공지 수정
				$rr = $this->communitybd->getView($md, $md4);

				$this->load->view("community/bonsaModify", array_merge($plink, array("id"=>$md4, "bd"=>$rr, "allfile" => $alladdfile)));
				

			}


		break;
		case 2: 
			$pt = "FAQ";
			
			
			if($md3 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				//공지 리스트 
				$su = count($this->communitybd->faqTotalCount($md2));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
				
				$allbd = $this->communitybd->faqList($md2,$page,$pagePerNum);
				
				//echo $md2;
				
				
				$this->load->view("community/faqView", array_merge($plink, array("allbd"=>$allbd, "totalCount"=>$su)));
	
				
			}else if($md3 == 2){
				//공지 작성
				$this->load->view("community/bonsaOn", $plink);
				
			}else if($md3 == 3){
				//공지보기 
				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);
				
				
				$sebd = $this->communitybd->getFaq($md4);  //faq 내용을 가져온다.
				
				//댓글을 가져온다.
				$detall = $this->communitybd->getDet($md4, $md);
				
				$this->load->view("community/gongjiSangse", array_merge($plink, array("sebd"=>$sebd, "det"=>$detall, "allfile" => $alladdfile)));
				
			}else{
				//공지 수정
				
				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);
				
				
				$rr = $this->communitybd->getView($md, $md4);

				$this->load->view("community/bonsaModify", array_merge($plink, array("id"=>$md4, "bd"=>$rr, "allfile" => $alladdfile)));
			}
		
		
		
		break;
		case 3:
			$pt = "질문관리";
			
			if($md3 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				//공지 리스트 
				$su = count($this->communitybd->faqbdTotalCount($md));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
				
				$allbd = $this->communitybd->faqbdList($md,$page,$pagePerNum);
		
				
				$this->load->view("community/faqbdView", array_merge($plink, array("allbd"=>$allbd, "totalCount"=>$su)));
	
				
			}else if($md3 == 2){
				//공지 작성
				$this->load->view("community/bonsaOn", $plink);
				
			}else if($md3 == 3){
				//공지보기 
				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);
				
				
				$sebd = $this->communitybd->getFaqBd($md4);  //faq 내용을 가져온다.
				
				//댓글을 가져온다.
				$detall = $this->communitybd->getDet($md4, $md);
				
				$this->load->view("community/gongjiSangse", array_merge($plink, array("sebd"=>$sebd, "det"=>$detall, "allfile" => $alladdfile)));
				
			}else{
				//공지 수정
				
				$this->load->model('common/commondb');
				//공사의 첨부파일을 가져온다.
				$alladdfile = $this->commondb->getAddF("community", $md, $md3, $md4);
				
				
				$rr = $this->communitybd->getView($md, $md4);

				$this->load->view("community/bonsaModify", array_merge($plink, array("id"=>$md4, "bd"=>$rr, "allfile" => $alladdfile)));
			}
		
		
		break;
		}
		
		
		if(!$md2) $md2 = 0;
		if(!$md3) $md3 = 0;
		if(!$md4) $md4 = 0;
		$this->load->view("common/foot", $plink); 
	
	}
	
	//댓글 삭제 
	public function delDet($did, $md, $md2, $id){
	
		$this->load->model('community/communitybd');
		$sebd = $this->communitybd->delDet($did);
		
		if($sebd > 0){
			redirect("/community/community/getView/".$md."/".$md2."/3/".$id);
		}
		
		
	}
	
	
	//댓글을 등록한다.
	public function onputDet(){
		
		$this->load->model('community/communitybd');
		$ad_date = date("Y-m-d H:i:s");
		
		$sebd = $this->communitybd->onputDet(array("md"=>$this->input->post('md', TRUE), "gid"=>$this->input->post('gid', TRUE), "det"=>$this->input->post('det', TRUE), "onday"=>$ad_date, "wmemid"=>$this->session->userdata('memid')));
	
		if($sebd < 1) echo '{"rs":"no"}';
		else echo '{"rs":"ok"}';
		
	}
	
	
	
	//게시판 등록
	public function onborder(){

		$config['upload_path'] = './fileUp';
		// git,jpg,png 파일만 업로드를 허용한다.
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = true;
		
		
		$fnam = "";
		$fnam2 = "";
		$fnam3 = "";
		$fnam4 = "";
		$fnam5 = "";
		$this->load->library('upload', $config);
		
		
		if ( ! $this->upload->do_upload("file1"))
		{
			$fnam = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam = $frs['file_name'];
		}
		
		if ( ! $this->upload->do_upload("file2"))
		{
			$fnam2 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam2 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file3"))
		{
			$fnam3 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam3 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file4"))
		{
			$fnam4 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam4 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file5"))
		{
			$fnam5 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam5 = $frs['file_name'];
		}
		
		
		$md = $this->input->post('md', TRUE);
		
		
		$gongji = '';
		$gongji = $this->input->post('gongji', TRUE);
		if($gongji != 'Y'){
			$gongji = 'N';
		}

		if($md == 4) $bdgb = 1;
		else $bdgb = 2;

		$this->load->model('community/communitybd');

		$ad_date = date("Y-m-d H:i:s");
		
			
		$arr = array("gubun"=>$bdgb, "bdid"=>$this->input->post('mkbd', TRUE), "wrMemid"=>$this->input->post('wrMemid', TRUE), "coid"=>$this->input->post('coid', TRUE), "tit"=>$this->input->post('tit', TRUE), "content"=>$this->input->post('ir1', FALSE), "onday"=>$ad_date, "gongji"=>$gongji); 
		

		if($this->input->post('type', TRUE) == "insert"){

			$rr = $this->communitybd->onfreebd($arr, array("type"=>$this->input->post('type', TRUE), "id"=>0));  //
			
		}else{
		
			$rr = $this->communitybd->onfreebd($arr, array("type"=>$this->input->post('type', TRUE), "id"=>$this->input->post('id', TRUE)));  //
		}
		
		
		$this->load->model('common/commondb');
		$addf = array("fnam1" => $fnam, "fnam2" => $fnam2, "fnam3" => $fnam3, "fnam4" => $fnam4, "fnam5" => $fnam5);
		//컨트롤 값을 전달한다.
		$rs2 = $this->commondb->onputAddF("community", $this->input->post("md", true), $this->input->post("md2", true), $rr, $addf);		
		
		
		

		if($rr > 0){
			//푸쉬발송을 한다.
			
			
			redirect("/community/community/getView/".$md);
		}else{
			redirect("/community/community/getView/6/2/1");
		}

	}
	

	
	public function ongongji(){

		
		$config['upload_path'] = './fileUp';
		// git,jpg,png 파일만 업로드를 허용한다.
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = true;
		
		
		$fnam = "";
		$fnam2 = "";
		$fnam3 = "";
		$fnam4 = "";
		$fnam5 = "";
		$this->load->library('upload', $config);
		
		
		if ( ! $this->upload->do_upload("file1"))
		{
			$fnam = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam = $frs['file_name'];
		}
		
		if ( ! $this->upload->do_upload("file2"))
		{
			$fnam2 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam2 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file3"))
		{
			$fnam3 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam3 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file4"))
		{
			$fnam4 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam4 = $frs['file_name'];
		}
		if ( ! $this->upload->do_upload("file5"))
		{
			$fnam5 = "0";
		}	
		else
		{
			$frs = $this->upload->data();
			$fnam5 = $frs['file_name'];
		}


		

		$md = $this->input->post('md', TRUE);
		
		
		$gongji = '';
		$gongji = $this->input->post('gongji', TRUE);
		if($gongji != 'Y'){
			$gongji = 'N';
		}
		$type = $this->input->post("type",true);
		
		$ad_date = date("Y-m-d H:i:s");
		$this->load->model('community/communitybd');

			$gubunG = $this->input->post('gubun', TRUE);
			
			if($md == 2){
				$gubunG = $this->input->post('md2', TRUE);
			}else{
				$gubunG = $this->input->post('gubun', TRUE);
			}

		if($type == "insert"){
			
			$arr = array("gubun"=>$gubunG, "wrMemid"=>$this->input->post('wrMemid', TRUE), "coid"=>$this->input->post('coid', TRUE), "tit"=>$this->input->post('tit', TRUE), "content"=>$this->input->post('content', FALSE), "onday"=>$ad_date, "gongji"=>$gongji);
			
			
			if($md == 1){
				$rr = $this->communitybd->ongongji($type, $arr);  //공지사항
			}else if($md == 2){
				$rr = $this->communitybd->onFAQ($type, $arr);  //faq등록
			}else if($md == 3){
				$rr = $this->communitybd->onFAQBd($type, $arr);  //질문등록
			}


			$this->load->model('common/commondb');
			$addf = array("fnam1" => $fnam, "fnam2" => $fnam2, "fnam3" => $fnam3, "fnam4" => $fnam4, "fnam5" => $fnam5);

			$rs2 = $this->commondb->onputAddF("community", $this->input->post("md", true), $this->input->post("md3", true), $rr, $addf);
			

			if($rr > 0){
				//등록성공
				redirect("/community/community/getView/".$md."/".$this->input->post('md2', TRUE)."/1");
				//if($md == 2) redirect("/community/community/getView/".$md."/".$this->input->post('md2', TRUE)."/1");
				//else redirect("/community/community/getView/".$md."/".$this->input->post('md2', TRUE)."/1");
			}else{
				redirect("/community/community/getView/".$md."/".$this->input->post('md2', TRUE)."/1");
			}
			
			
		}else{
			//수정모드 
			
			$id = $this->input->post("id",true);

			$arr = array("id"=>$this->input->post('id', TRUE), "gubun"=>$gubunG, "wrMemid"=>$this->input->post('wrMemid', TRUE), "coid"=>$this->input->post('coid', TRUE), "tit"=>$this->input->post('tit', TRUE), "content"=>$this->input->post('content', FALSE), "onday"=>$ad_date, "gongji"=>$gongji);

			
			if($md == 1){
				$rr = $this->communitybd->ongongji($type, $arr);  //공지사항
			}else if($md == 2){
				$rr = $this->communitybd->onFAQ($type, $arr);  //faq등록
			}else if($md == 3){
				$rr = $this->communitybd->onFAQBd($type, $arr);  //질문등록
			}

			$this->load->model('common/commondb');
			$addf = array("fnam1" => $fnam, "fnam2" => $fnam2, "fnam3" => $fnam3, "fnam4" => $fnam4, "fnam5" => $fnam5);
			$rs2 = $this->commondb->onputAddF("community", $this->input->post("md", true), $this->input->post("md3", true), $rr, $addf);
	

			redirect("/community/community/getView/".$md."/".$this->input->post("md2", true)."/1");
		}
		
		

	}
	
	//공지삭제
	public function delEvent($md, $md2, $did){
		$this->load->model('community/communitybd');
		$rr = $this->communitybd->delEvent($md, $did);
	
		redirect("/community/community/getView/".$md."/".$md2."/1");
	
	}

	public function logout(){
			logout();
	}


	public function file_download($filename){
		$this->load->helper('download');

		$data = file_get_contents(dirname($_SERVER["SCRIPT_FILENAME"])."/fileUp/".$filename); // Read the file's contents

		force_download($filename, $data); 
	}

}





?>
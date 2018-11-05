<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Musicon extends CI_Controller{


	public function __construct()
    {
		
		parent::__construct();
		$this->load->helper('url');   //redirect 사용을 위해 설정
		
		//=====================================================
		//현재컨트롤 변수초기화
		//=====================================================		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
		$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		//=====================================================		
		//초기 함수 처리
		//=====================================================
		//부적절한 접근 차단
		NotReadyNotGo("musicon");
		//=====================================================		
		
    }


	public function index(){

		//=====================================================
		//getView 호출하지 않고 기본링크 호출시 실행
		//시작함수 변수초기화
		//=====================================================			

		//=====================================================		
		//초기 함수 처리
		//=====================================================		
		if($this->session->userdata('memid')){
			if(!$this->session->userdata('musicon')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();		
			}else $gg = 1; //$this->session->userdata('hjang');

			$this->getView($gg, 1);
		}else{
			redirect("/home") ;
		}
		//=====================================================			
	
	}
	
	
	
	
	//=====================================================		
	//서버메뉴에 따라 뷰어를 불러 온다.
	//=====================================================		
	public function getView($md, $md2 = 1, $md3 = 0, $md4 =0, $page = -1){

		//=====================================================
		//getView 변수 초기화
		//=====================================================					
		if($page == -1){
			$page = $this->session->userdata('page');
		}else{
			$this->session->set_userdata('page', $page);
		}
		$fnd = $this->config->item('fnd');
		
		
		if($this->session->userdata('main') != $md or ($md == 2 and $md2 == 1 and $fnd == "0--n") or ($md == 2 and $md2 == 5 and $fnd == "0--n") or ($md == 2 and $md2 == 6 and $fnd == "0--n")){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}
	
		//서브메뉴의 값을 저장한다.
		$this->session->set_userdata('musicon', $md);
		//====================================================
		//페이지 변수 초기화
		//====================================================
		$this->load->library('pagination');		
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/music/musicon/getView/'.$md.'/'.$md2."/".$md3."/".$md4;
		$config["per_page"] = $pagePerNum;
		$config["first_url"] = '/music/musicon/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/0";
		$config["num_links"] = 10;
		$config["cur_page"] = $page;  //여기 기본페이지 들어가면 base_url에 페이지 빠진다.
		$plink = array("mode" => "music", "md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')));
		//=====================================================
		//컨트롤 로드
		//=====================================================
		$this->load->view("common/head", $plink);
		$this->load->model('music/musiconm');
		//=====================================================
		
		
		
		$pt = "";
		switch($md){
		case 1:
		
			$pt = "음원관리";

			
			if($md3 == 1){
				
				//////////$dc = rmdirAll("../xxxxxx");
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				$this->load->model('music/musiconm');
							
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);
				
		/*
				foreach($list as $row){
					//echo $row->id."//";
					//$rr = $this->musiconm->musicdelAll((int)$row->id);
				}
			*/
				//echo var_dump($list);
			
			
///*			
				//키별 음원리스트
				$keylist = $this->musiconm->getKeyMusic($list, 0);
				//키이미지, 키 가사
				$keylistTxt = $this->musiconm->getKeyMusic($list, 1);
				
				//키이미지, 키 가사
				$keylistImg = $this->musiconm->getKeyMusic($list, 2);
				
				
				

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);



				//사업리스트를 출력한다.
				$obj = array("list" => $list, "keylist"=>$keylist, "keylistTxt"=>$keylistTxt, "keylistImg"=>$keylistImg, "totalCount"=>$totalCount->su);
				$this->load->view("music/musicanzList", array_merge($plink, $obj));
//*/

				
			}else if($md3 == 2){    //한곡씩 음원등록
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);
			
				//키별 음원리스트
				$keylist = $this->musiconm->getKeyMusic($list);
				

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "keylist"=>$keylist, "totalCount"=>$totalCount->su);
				$this->load->view("music/musicOnOne", array_merge($plink, $obj));

			}else if($md3 == 3){   //압축해제 방식으로 음원등록
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);
			
				//키별 음원리스트
				$keylist = $this->musiconm->getKeyMusic($list);
				

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "keylist"=>$keylist, "totalCount"=>$totalCount->su);
				$this->load->view("music/unzipmusic", array_merge($plink, $obj));
				
				
			}else if($md3 = 4){
			
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "totalCount"=>$totalCount->su);
				$this->load->view("music/unzipmusic", array_merge($plink, $obj));			
			
			}

		break;
		case 2: 

				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);
			
				//키별 음원리스트
				$keylist = $this->musiconm->getKeyMusic($list, 0);
				//키이미지, 키 가사
				$keylistTxt = $this->musiconm->getKeyMusic($list, 1);
				
				//키이미지, 키 가사
				$keylistImg = $this->musiconm->getKeyMusic($list, 2);
				

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "keylist"=>$keylist, "keylistTxt"=>$keylistTxt, "keylistImg"=>$keylistImg, "totalCount"=>$totalCount->su);
				$this->load->view("music/musicanzList", array_merge($plink, $obj));



		break;
		case 3:

				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->musiconm->allMusic_totalCount($md3);
				$list = $this->musiconm->allMusic_list($plink);
			
				//키별 음원리스트
				$keylist = $this->musiconm->getKeyMusic($list, 0);
				//키이미지, 키 가사
				$keylistTxt = $this->musiconm->getKeyMusic($list, 1);
				
				//키이미지, 키 가사
				$keylistImg = $this->musiconm->getKeyMusic($list, 2);
				

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "keylist"=>$keylist, "keylistTxt"=>$keylistTxt, "keylistImg"=>$keylistImg, "totalCount"=>$totalCount->su);
				$this->load->view("music/musicanzList", array_merge($plink, $obj));
			
		break;
		case 4:
			$pt = "통함검색";
			
			/*
			$this->load->model('scene/scenemdapp');
			
			
			if($md2 == 1){
			
				//$meminf = $this->company->allcompany();  //전체업체를 가져온다.
				//$miobj = array("allcom" => $meminf);			
				$arr = array("coid"=>$md3, "findSe"=>$md4, "findTxt"=>rawurldecode($fnd), "page" => $page, "pagePerNum" => $pagePerNum);
				//$totalCount = $this->scenemdapp->allFindGetTotalCount($arr);  //통합검색을 실행한다.
							
				
				$rs = $this->scenemdapp->allFindGet($arr);  //통합검색을 실행한다. 


	
				$aaa = array("onmd"=>$md2, "coid"=>$md3, "sef"=>$md4, "fnd"=>rawurldecode($fnd), "allco"=>$allCo, "allfnd"=>$rs, "totalCount"=>0);
				$this->load->view("scene/allfind", $aaa);
			
			}else if($md2 == 3){

					//사업의 상세정보를 가져온다.$fnd-사업아이디
					$spsangse = $this->scenemdapp->getSaupSangse($md4);  //사업의 상세정보를 가져온다.
				
					//사업의 대상자 리스트를 가져온다.
					//$sps = $this->scenemdapp->getSaupDesang($md4);  //사업아이디를 준다
				
					$this->load->view("scene/saupDesangList", array("md"=>$md, "coid"=>$md3, "md4"=>$md4, "sps"=>$spsangse)); //, "spdsList"=>$sps));
				
				
			
			}
			*/

		break;
		}
		

		if(!$md2) $md2 = 0;
		if(!$md3) $md3 = 0;
		if(!$md4) $md4 = 0;
		$this->load->view("common/foot", $plink);
	
	}
	
	//========================================
	//음원을 등록한다.
	//========================================
	public function musicfileOn(){
	
		$fnamgab = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
		$songarr = array();
		$endfix = array();
		$sex = 0; //기본은 남자
		switch($this->input->post("mkey",true)){
		case "1se":
		
			//가수의 폴더에 음원을 올린다.
			$fuplink = '../mrphp/music/1se/'.$this->input->post("gasu",true);
			$config['upload_path'] = $fuplink;
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = '*';
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);

			$prefix = array("(MR 원키)", "txt", "img");
			$arrText = array("", "orgkey", "gasa"); //, "albumimg");
			for($c = 1; $c < 3; $c++){

				if (!$this->upload->do_upload($arrText[$c]))
				{
					$fnam00 = "0";  //업로드 실패한 경우 
				}else{
					$eext = "-0".$c;
					if($c == 2) $eext = "_gasa";
					if($c == 3) $eext = "_img";
					//업로드 성공한 경우
					$frs = $this->upload->data();
					$fnam00 = $frs['file_name'];
					$extM = substr($fnam00, -4);
					$songid = "1se".$sex.$fnamgab.$eext;
					$fnamRR = $songid.$extM;
					$songarr[] = $songid;
					$endfix[] = $extM;
					
					@rename($fuplink."/".$fnam00, $fuplink."/".$fnamRR);
				}
			
			}


		break;
		case "2se":
		
			//가수의 폴더에 음원을 올린다.
			$fuplink = '../mrphp/music/2se/'.$this->input->post("gasu",true);
			$config['upload_path'] = $fuplink;
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = '*';
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);

			$prefix = array("(MR 원키)", "(Melody 포함 MR)", "txt", "img");
			$arrText = array("", "orgkey", "inmelody", "gasa"); //, "albumimg");
			for($c = 1; $c < 4; $c++){

				if (!$this->upload->do_upload($arrText[$c]))
				{
					$fnam00 = "0";  //업로드 실패한 경우 
				}else{
					$eext = "-0".$c;
					if($c == 3) $eext = "_gasa";
					if($c == 4) $eext = "_img";
					//업로드 성공한 경우
					$frs = $this->upload->data();
					$fnam00 = $frs['file_name'];
					$extM = substr($fnam00, -4);
					$songid = "2se".$sex.$fnamgab.$eext;
					$fnamRR = $songid.$extM;
					$songarr[] = $songid;
					$endfix[] = $extM;
					
					@rename($fuplink."/".$fnam00, $fuplink."/".$fnamRR);
				}
			
			}

			
		break;
		case "3se":
		
			//가수의 폴더에 음원을 올린다.
			$fuplink = '../mrphp/music/3se/'.$this->input->post("gasu",true);
			$config['upload_path'] = $fuplink;
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = '*';
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);
			
			$prefix = array("(MR 원키)", "(Melody 포함 MR)", "(MR #1)", "(MR #2)", "(MR #3)", "(MR b1)", "(MR b2)", "(MR b3)", "txt", "img");
			$arrText = array("", "orgkey", "inmelody", "shap1", "shap2", "shap3", "bb1", "bb2", "bb3", "gasa"); //, "albumimg");
			for($c = 1; $c < 10; $c++){

				if (!$this->upload->do_upload($arrText[$c]))
				{
					$fnam00 = "0";  //업로드 실패한 경우 
				}else{
					$eext = "-0".$c;
					if($c == 9) $eext = "_gasa";
					if($c == 10) $eext = "_img";
					//업로드 성공한 경우
					$frs = $this->upload->data();
					$fnam00 = $frs['file_name'];
					$extM = substr($fnam00, -4);
					$songid = "3se".$sex.$fnamgab.$eext;
					$fnamRR = $songid.$extM;
					$songarr[] = $songid;
					$endfix[] = $extM;
					
					@rename($fuplink."/".$fnam00, $fuplink."/".$fnamRR);
				}
			
			}

			
		break;
		case "4seM":
			//가수의 폴더에 음원을 올린다.
			$sex = 0;
			//가수의 폴더에 음원을 올린다.
			$fuplink = '../mrphp/music/4se/'.$this->input->post("gasu",true);
			$config['upload_path'] = $fuplink;
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = '*';
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);
			
			$prefix = array("(MR 원키)", "(Melody 포함 MR)", "(MR #1)", "(MR b1)", "(MR b2)", "(MR 여자키)", "(MR 여자키 #1)", "(MR 여자키 b1)", "(MR 여자키 b2)", "txt", "img");
			$arrText = array("", "orgkey", "inmelody", "shap1", "bb1", "bb2", "wmkey", "wshap1", "wbb1", "wbb2", "gasa"); //, "albumimg");
			for($c = 1; $c < 11; $c++){

				if (!$this->upload->do_upload($arrText[$c]))
				{
					$fnam00 = "0";  //업로드 실패한 경우 
				}else{
					$eext = "-0".$c;
					if($c == 10) $eext = "_gasa";
					if($c == 11) $eext = "_img";
					//업로드 성공한 경우
					$frs = $this->upload->data();
					$fnam00 = $frs['file_name'];
					$extM = substr($fnam00, -4);
					$songid = "4se".$sex.$fnamgab.$eext;
					$fnamRR = $songid.$extM;
					$songarr[] = $songid;
					$endfix[] = $extM;
					
					@rename($fuplink."/".$fnam00, $fuplink."/".$fnamRR);
				}
			
			}
			
		break;
		case "4seF":
			//가수의 폴더에 음원을 올린다.
			$sex = 1;
			//가수의 폴더에 음원을 올린다.
			$fuplink = '../mrphp/music/4se/'.$this->input->post("gasu",true);
			$config['upload_path'] = $fuplink;
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = '*';
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);
			
			$prefix = array("(MR 원키)", "(Melody 포함 MR)", "(MR #1)", "(MR b1)", "(MR b2)", "(MR 남자키)", "(MR 남자키 #1)", "(MR 남자키 b1)", "(MR 남자키 b2)", "txt", "img");
			$arrText = array("", "orgkey", "inmelody", "shap1", "bb1", "bb2", "mnkey", "mnshap1", "mnbb1", "mnbb2", "gasa"); //, "albumimg");
			for($c = 1; $c < 11; $c++){

				if (!$this->upload->do_upload($arrText[$c]))
				{
					$fnam00 = "0";  //업로드 실패한 경우 
				}else{
					$eext = "-0".$c;
					if($c == 10) $eext = "_gasa";
					if($c == 11) $eext = "_img";
					//업로드 성공한 경우
					$frs = $this->upload->data();
					$fnam00 = $frs['file_name'];
					$extM = substr($fnam00, -4);
					$songid = "4se".$sex.$fnamgab.$eext;
					$fnamRR = $songid.$extM;
					$songarr[] = $songid;
					$endfix[] = $extM;
					
					@rename($fuplink."/".$fnam00, $fuplink."/".$fnamRR);
				}
			
			}
			
		break;	
		}


		//========================================
		//DB에 저장 한다.
		//========================================
		$uparr = array("gasu"=>$this->input->post("gasu",true), "sede"=>$this->input->post("mkey",true), "tit"=>$this->input->post("tit",true), "sex"=>$sex, "songid"=>$songarr, "endfix"=>$endfix, "prefix"=>$prefix);
		$this->load->model('music/musiconm');
		$rr = $this->musiconm->musicOnDB($uparr);
		//========================================

		if($rr > 0){
			//저장성공
			redirect("/music/musicon/getView/1/1/1");
		}else{
			//저장 실패
			redirect("/music/musicon/getView/1/1/2");
		}
		
	
	}
	//=========================================
	
	
	
	public function musicdel($did, $md2){
	
		$this->load->model('music/musiconm');
		
		$rr = $this->musiconm->musicdelAll($did);
		
		
		redirect("/music/musicon/getView/1/".$md2."/1");
	
	}

	public function musicdelAll(){
	
		$this->load->model('music/musiconm');
		
		
		$list = $this->musiconm->allMusic_list(array("md3"=>1, "page"=>0, "ppn"=>10));
		
		foreach($list as $row){
		
			$rr = $this->musiconm->musicdelAll($row->id);
		}
	
	}





	
	public function onfile(){

		if($this->input->post("thinkchk",true) == 0) $config['upload_path'] = '../mrphp/musicorg';
		else $config['upload_path'] = '../mrphp/thinkorg';
		
		
		// git,jpg,png 파일만 업로드를 허용한다.
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = false;
		
		
		$fnam = "";
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
		
		redirect("/music/musicon/getView/1/1/3");

	}	
	
	
	
	
	
	
	
	
	
	
	
	//사업의 대상자 리스트를 가져온다.
	public function coSaupDesangList(){
	
			$this->load->model('scene/scenemdapp');
			
			if($this->input->post('md', TRUE) == "sp"){
				$pt = $this->scenemdapp->coSaupDesangList($this->input->post('coid', TRUE), $this->input->post('saup', TRUE));
			}else{
				
				$pt = $this->scenemdapp->coSangDamDesangList($this->input->post('saup', TRUE));
				//echo "99999".$this->input->post('md', TRUE).$this->input->post('saup', TRUE);
			}

			echo json_encode($pt);
	
	}
	
	
	
	
	//대상자 팝업으로 상세보기
	public function getDesangSS($seid){
		$this->load->model('scene/scenemdapp');	
		
		$rr = $this->scenemdapp->getDesangSangseId($seid);
	
		$this->load->view("scene/popDesang", array("ssinfo" => $rr));
	}
	
	//대상자 팝업으로 상세보기
	public function getSaupSS($seid){
		$this->load->model('scene/scenemdapp');	
		
		$rr = $this->scenemdapp->getSaupSS($seid);
		
		$this->load->model('common/commondb');
		//사업의 첨부파일을 가져온다.
		$alladdfile = $this->commondb->getAddF("hjang", 1, 3, $seid);  //사업의 상세정보를 가져온다.
	
		$this->load->view("scene/popSaupSS", array("gsss" => $rr, "md"=>1, "md2"=>3, "allfile" => $alladdfile));
	}

	
	//대상자 팝업으로 상세보기
	public function getGongsaSSPop($gsid){
		$this->load->model('scene/scenemdapp');	
		
					//공사 아이디와 대상자 아이디로 공사 상세보기를 한다.md3:공사아이디, md4:대상자 아이디 
					$gsss = $this->scenemdapp->getGongsaSS($gsid);
				
		$this->load->model('common/commondb');
		//사업의 첨부파일을 가져온다.
		$alladdfile = $this->commondb->getAddF("hjang", 2, 77, $gsid);  //사업의 상세정보를 가져온다. 
		
					$obj = array("gsss"=>$gsss, "md"=>2, "md2"=>77, "allfile"=>$alladdfile);
					$this->load->view("scene/popGongsa", $obj);
	}
	
	//사진 팝업 상세보기
	public function getPhotoSSPop($ptid){
		$this->load->model('scene/scenemdapp');	
		
					//공사 아이디와 대상자 아이디로 공사 상세보기를 한다.md3:공사아이디, md4:대상자 아이디 
					$gsss = $this->scenemdapp->getPhotoInfo($ptid);
				
					$obj = array("ptss"=>$gsss);
					$this->load->view("scene/popPhotoSS", $obj);
	}

	//상담 상세보기 팝업
	public function getSangdamSSPop($sdid){
		$this->load->model('scene/scenemdapp');	
		
					//공사 아이디와 대상자 아이디로 공사 상세보기를 한다.md3:공사아이디, md4:대상자 아이디 
					$gsss = $this->scenemdapp->getSangdamSS(array("id"=>$sdid));
				
					$obj = array("sss"=>$gsss);
					$this->load->view("scene/popSangdamSS", $obj);
	}

	
	
	
	public function toExcel($md1, $md2, $md3, $md4, $fnd){
		$this->load->model('scene/scene');	
		$this->load->model('scene/scenemdapp');	
		
		
		$plink = array("md"=>$md1, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>0, "ppn"=>0, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		

		
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				//업체에 속한 대상자를 가져온다.
				$arr = array_merge($plink, array("pagePerNum" => 0));  //사업아이디를 전달한다.$md4
				$ds_list = $this->scene->desangInfo($arr);
		
		
		$ds_list = $this->scenemdapp->toExcel($ds_list);
	
	}
	
	
	//엑셀로 저장한다.
	public function downExcel(){

		$this->load->model('scene/scenemdapp');	
		$arr = array("coid"=>$this->input->post("coid",true), "findSe"=>$this->input->post("saup",true), "findTxt"=>$this->input->post("ftxt",true));
		$result = $this->scenemdapp->allFindGet($arr);
		
		
		$this->load->library('excel');
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		/*

		
		$this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('통합검색');
		
		$this->excel->getActiveSheet()->setCellValue('A1', '순번');
        $this->excel->getActiveSheet()->setCellValue('B1', '사업명');
        $this->excel->getActiveSheet()->setCellValue('C1', '대상자');
		$this->excel->getActiveSheet()->setCellValue('D1', '생년월일');
		$this->excel->getActiveSheet()->setCellValue('E1', '전화');
		$this->excel->getActiveSheet()->setCellValue('F1', '주소');
        $this->excel->getActiveSheet()->setCellValue('G1', '담당자');
        $this->excel->getActiveSheet()->setCellValue('H1', '일정');
        $this->excel->getActiveSheet()->setCellValue('I1', '등록일');
        $this->excel->getActiveSheet()->setCellValue('J1', '등록자');
		$this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
		
		//헤더 다운데 정렬
		$this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		$n=2;
		$i = 1;
        foreach($result as $row):
            $this->excel->getActiveSheet()->setCellValue('A'.$n, $i);
            $this->excel->getActiveSheet()->setCellValue('B'.$n, $row->business_nm);
            $this->excel->getActiveSheet()->setCellValue('C'.$n, $row->dsname);
            $this->excel->getActiveSheet()->setCellValue('D'.$n, $row->bday);
            $this->excel->getActiveSheet()->setCellValue('E'.$n, $row->tel);
            $this->excel->getActiveSheet()->setCellValue('F'.$n, "( ".$row->post." ) ".$row->addr);
            $this->excel->getActiveSheet()->setCellValue('G'.$n, $row->memid);
            $this->excel->getActiveSheet()->setCellValue('H'.$n, $row->start_dt." ~ ".$row->end_dt);
            $this->excel->getActiveSheet()->setCellValue('I'.$n, $row->onday);
            $this->excel->getActiveSheet()->setCellValue('J'.$n, $row->wrmemid);
            $n++;
			$i++;
        endforeach;
	
	
		$filename = 'allfind_'.date('Ymd').'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');

*/

		echo '{"rs":"ok"}';
	
	}
	
	//대상자를 삭제한다.
	public function delDesang($md, $md2, $coid, $md4){

		$this->load->model('scene/scenemdapp');
		
		
		$rt = $this->scenemdapp->delDesang($md4);
	
		redirect("/scene/hjang/getView/2/".$md2."/".$coid."/0/".$this->session->userdata("backFind"));
	
	}
	
	
	//사업을 삭제한다.
	public function delSaup($md, $md2, $coid, $md4){

		$this->load->model('scene/scenemdapp');
		
		
		$rt = $this->scenemdapp->delSaup($md4);
	
		redirect("/scene/hjang/getView/1/".$md2."/".$coid."/".$md4);
	
	}
	
	
	//공사를 삭제한다.
	public function delGongsa($md, $gid, $coid){
	
		$this->load->model('scene/scenemdapp');
		
		
		$rt = $this->scenemdapp->delGongsa($gid);
	
		redirect("/scene/hjang/getView/2/6/".$coid);
	}
	

	
	
	
	//통함검색을 가져온다.
	public function allFindGet(){
		
		//$this->load->model('scene/scenemdapp');
		//$arr = array("coid"=>$this->input->post("coid",true), "findSe"=>$this->input->post("findSe",true), "findTxt"=>$this->input->post("findTxt",true));
	
		//echo "kkkk";
	
		redirect("/scene/hjang/getView/4/1/".$this->input->post("coid",true)."/".$this->input->post("findSe",true)."/".$this->input->post("findTxt",true));
	
		/*
	
		$rs = $this->scenemdapp->allFindGet($arr);  //통합검색을 실행한다.
		
		echo var_dump($rs);
		
			$aaa = array("onmd"=>$md2, "allfnd"=>$rs);
			$this->load->view("scene/allfind", $aaa);
			
		*/
			
			//echo '{"rs":"ok"}';
		
	}
	
	
	
	//대상자를 등록 한다.
	public function onputDesang(){
	
		$this->load->model('scene/scenemdapp');
		
		$ad_date = date("Y-m-d H:i:s");
		
		$arr = array("dsname"=>$this->input->post("sedeju",true), "saupid"=>$this->input->post("sangdamSaup",true), "coid"=>$this->input->post("coid",true), "bday"=>$this->input->post("bthday",true), "tel"=>$this->input->post("tel",true), "htel"=>$this->input->post("htel",true), "post"=>$this->input->post("copost",true), "addr"=>$this->input->post("coaddress",true), "addr2"=>$this->input->post("coaddress2",true), "sugub"=>$this->input->post("sugub",true), "bojang"=>$this->input->post("bojang",true), "bojangetc"=>$this->input->post("etc",true), "gagusu"=>$this->input->post("gagusu",true), "gaguinf"=>$this->input->post("gagu",true), "gagumemo"=>$this->input->post("gaguetc",true), "wrmemid"=>$this->session->userdata("memid"), "onday"=>$ad_date, "latpo"=>$this->input->post("lat",true), "langpo"=>$this->input->post("lan",true));
		
		$rs = $this->scenemdapp->onputDesang($arr, $this->input->post("mode",true), $this->input->post("listid",true), $this->input->post("dsaup", true));  //대상자 등록을 한다.
		
		redirect("/scene/hjang/getView/2/1/".$this->input->post("coid",true)."/0/".$this->session->userdata("backFind"));
	
	}
	
	//상담등록을 한다.
	public function onputSangdam(){
	
		$this->load->model('scene/scenemdapp');
		
		$ad_date = date("Y-m-d H:i:s");
		
		if($this->input->post("mode",true) == 2){
			$arr = array("coid"=>$this->input->post("coid",true), "saup"=>$this->input->post("sangdamSaup",true), "desang"=>$this->input->post("sangdamDesang",true), "tit"=>$this->input->post("tit",true), "content"=>$this->input->post("contentS",true), "memo"=>$this->input->post("memo",true), "wrMemid"=>$this->session->userdata("memid"), "sday"=>$this->input->post("sdonday",true), "onday"=>$ad_date, "moth"=>$this->input->post("moth",true), "mothetc"=>$this->input->post("mothetc",true));
			//등록모드 
			$rs = $this->scenemdapp->onputSangdam($arr);  //상담을 등록한다.
		}else{
			$arr = array("coid"=>$this->input->post("coid",true), "saup"=>$this->input->post("sangdamSaup",true), "desang"=>$this->input->post("sangdamDesang",true), "tit"=>$this->input->post("tit",true), "content"=>$this->input->post("contentS",true), "memo"=>$this->input->post("memo",true), "wrMemid"=>$this->session->userdata("memid"), "sday"=>$this->input->post("sdonday",true), "onday"=>$ad_date, "moth"=>$this->input->post("moth",true), "mothetc"=>$this->input->post("mothetc",true), "listid"=>$this->input->post("listid",true));
			
			
			$rs = $this->scenemdapp->sangdamEdit($arr);
		}
		
		
		redirect("/scene/hjang/getView/3/1/".$this->input->post("coid",true)."/".$this->input->post("saup",true));
		
	
	
	}
	
	
	//사진을 등록처리한다.
	public function onputPhoto(){
		
		$ad_date = date("Y-m-d H:i:s");
		$this->load->model('scene/scenemdapp');
		

			$rw = $this->scenemdapp->getDange($this->input->post("gsid", true));
			$dange = $this->input->post("dange", true);
			
		
	
		//대상자 아이디로 대상자의 이름을 가져온다.
		$bb = array('id'=>$rw->dsid);
		$dds = $this->scenemdapp->getDesangNam($bb);  //대상자의 아이디로 대상자의 이름을 가져온다.
		
		
		$arr = array('gsid'=>$this->input->post("gsid", true), 'dange'=>$dange, 'tit'=>$this->input->post("tit", true), 'memo'=>$this->input->post("memo", true), 'wrmemid'=>$this->session->userdata("memid"), 'dsrecid'=>$rw->dsid, 'sprecid'=>(int)$this->input->post("sp", true), 'desangmemid'=>$dds->dsname, 'onday'=>$ad_date);
		
		
		
		
		if($this->input->post("imginf", true) == "nn" or $this->input->post("imginf", true) == "insert"){
			//이미지 등록이 필수 이다.
			$config['upload_path'] = './images/scene';
			// git,jpg,png 파일만 업로드를 허용한다.
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = true;
			$config['encrypt_name'] = true;
			
			
			$fnam = "";
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload("file1") or $this->upload->do_upload("file1") == "0")
			{
				$fnam = "0";
			}	
			else
			{
				$frs = $this->upload->data();
				$fnam = $frs['file_name'];
				
				GD2_make_thumb(120,120,'thumb/s_', PREDIR0.'/images/scene/'.$fnam);  //썸네일 생성
				
			}
			
			//사진 레코드을 추가 하고 공사의 단계를 변경한다.
			$rs = $this->scenemdapp->onputPhoto($arr, $dange, $this->input->post("gsid", true), $this->input->post("mode", true), (int)$this->input->post("sp", true), $fnam);  //공사 정보를 갱신한다.
			
		}else{
			//기존 이미지를 유지 한다.
			$rs = $this->scenemdapp->onputPhoto($arr, $dange, $this->input->post("gsid", true), $this->input->post("mode", true), (int)$this->input->post("sp", true), "0");  //공사 정보를 갱신한다.
		
		}



	}
	
	//사진을 삭제한다.
	public function delPhoto(){
	
		$this->load->model('scene/scenemdapp');
		
		
		$rt = $this->scenemdapp->photoDel($this->input->post("phtid",true));
	
		echo '{"img":"'.$rt.'"}';
	}
	


	//공사를 등록한다.
	public function onputGongsa(){
	
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
		
		$ad_date = date("Y-m-d H:i:s");
		
		$this->load->model('scene/scenemdapp');
		
		$arr = array('coid'=>$this->input->post("coid", true), 'dsid'=>$this->input->post("dsGongsa", true), 'saupid'=>$this->input->post("saupGongsa", true), 'gsname'=>$this->input->post("gongsa", true), 'content'=>$this->input->post("content", true), 'wmemid'=>$this->session->userdata("memid"), 'start_dt'=>$this->input->post("start_dt", true), 'end_dt'=>$this->input->post("end_dt", true), 'onday'=>$ad_date);
		$rs = $this->scenemdapp->onputGongsa($arr, $this->input->post("gsid", true));  //사업등록을 한다.
		

		$this->load->model('common/commondb');
		$addf = array("fnam1" => $fnam, "fnam2" => $fnam2, "fnam3" => $fnam3, "fnam4" => $fnam4, "fnam5" => $fnam5);
		//컨트롤 값을 전달한다.
		$rs2 = $this->commondb->onputAddF("hjang", $this->input->post("md", true), $this->input->post("md2", true), $rs, $addf);
		
		
		redirect("/scene/hjang/getView/2/6/".$this->input->post("coid",true));

	}
	
	
	
	//사업등록 처리
	public function onputSaup(){
	
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
		
		
		
		$ad_date = date("Y-m-d H:i:s");
		

		$this->load->model('scene/scenemdapp');
		
		
		$arr = array('business_nm'=>$this->input->post("business_nm", true), 'business_explane'=>$this->input->post("business_explane", true), 'start_dt'=>$this->input->post("start_dt", true), 'end_dt'=>$this->input->post("end_dt", true), 'coid'=>$this->input->post("coid", true), 'wrmemid'=>$this->session->userdata("memid"), 'onday'=>$ad_date);
		

		$rs = $this->scenemdapp->onputSaup($arr, $this->input->post("mode", true), $this->input->post("listid", true));  //사업등록을 한다.
		
		$this->load->model('common/commondb');
		$addf = array("fnam1" => $fnam, "fnam2" => $fnam2, "fnam3" => $fnam3, "fnam4" => $fnam4, "fnam5" => $fnam5);
		$rs2 = $this->commondb->onputAddF("hjang", $this->input->post("md", true), $this->input->post("md2", true), $rs, $addf);
		
		
		redirect("/scene/hjang/getView/1/1/".$this->input->post("coid",true));
		

	}
	

	
	
	//사업관리 탭메뉴
	public function tabControl($md){
		$tg['onmd'] =$md;
		$this->load->view("scene/saupanz", $tg);

	}
	
	
	public function file_download($filename){
		$this->load->helper('download');

		$data = file_get_contents(dirname($_SERVER["SCRIPT_FILENAME"])."/fileUp/".$filename); // Read the file's contents

		force_download($filename, $data); 
	}
	
	

	public function logout(){
			logout();
	}




}





?>
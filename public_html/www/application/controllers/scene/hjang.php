<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Hjang extends CI_Controller{

	var $newdata = array();
	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');   //redirect 사용을 위해 설정
		

		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
		
	//echo "lll=".$this->session->userdata('potion');
	
		if(!$this->session->userdata('memid')){  //로그아웃
			redirect("/home") ;
		}else{
			$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
			//echo "ch=".$cihs;
			
			//회원의 자격으로 열수 없는 페이지는 강제로 페이지 전환한다.
			$rra = pageGoInf("hjang");
			if($rra['rs']) redirect($rra['page']);
		

		}
		
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		
		
		if($this->session->userdata('memid')){
			
			
			if(!$this->session->userdata('hjang')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();		
			}else $gg = 1; //$this->session->userdata('hjang');
			
			//echo "ggg=".$gg;
			$this->getView($gg, 1);
			
		
		}else{
			//echo "login no";
			redirect("/home") ;
		}
	
	}
	
		//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md, $md2 = 1, $md3 = 0, $md4 =0, $fnd="0", $page = 0){
		
		
		if($this->session->userdata('main') != $md or ($md == 2 and $md2 == 1 and $fnd == "0--n") or ($md == 2 and $md2 == 5 and $fnd == "0--n") or ($md == 2 and $md2 == 6 and $fnd == "0--n")){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}
	

		if($md2 > 0){   //특정항목의 리스트를 클릭했다.
			$this->session->set_userdata('main', $md);
			$this->session->set_userdata('old', $this->session->userdata("md2"));
			$this->session->set_userdata("md2",$md2);
			
			if($md3 > 0){
				$this->session->set_userdata("co",$md3);
			}
		}
		
		if($md3 == 0){
			if($this->session->userdata("cogubun") == BONSA or $this->session->userdata("cogubun") == JOHAPG){
				
				$md3 = 0; //$this->session->userdata("coid");
			}else{
				$md3 = $this->session->userdata("coid");
			}
		}

	
		//서브메뉴의 값을 저장한다.
		$this->session->set_userdata('hjang', $md);
	
			
			//본사, 조합은 전체 업체의 리스트를 가져온다.
			//자신의 구분과 직책에 따라 전체업체의 리스트를 가져온다.
			$this->load->model('member/member');
			$coarr = array("md"=>$md, "cogubun"=>$this->session->userdata('cogubun'), "po"=>$this->session->userdata('potion'),"coid"=>$md3);
			$allCo = $this->member->getCo($coarr);  //전체 업체의 리스트를 가져온다.
			//echo var_dump($allCo);
	
			//====================================================
				$this->load->library('pagination');		
				$pagePerNum = PAGELINE;
				$config['base_url'] = '/scene/hjang/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
				$config["per_page"] = $pagePerNum;
				$config["num_links"] = 10;
				$config["cur_page"] = $page;
				$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
			//=====================================================
	
	
		//헤드에 모드값을 전달한다.
		$param = array("mode" => "hjang", "md"=>$md, "md2"=>$md2);
		$this->load->view("common/head", $param);

		
		//$page = $md4;

		$sstion = array("memid" => $this->session->userdata('memid'), "po" => $this->session->userdata('potion'), "cogubun" => $this->session->userdata('cogubun'),  "coid" => $md3, "myid" => $this->session->userdata('id'), "page" => $page, "pagePerNum" => $pagePerNum);
		
		if(!$fnd){
			$fnd = "";
		}
		
		
		
		$pt = "";
		switch($md){
		case 1:
			$pt = "사업관리";
			$this->load->model('scene/scene');

			if($md2 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$totalCount = $this->scene->field_control_totalCount($sstion);
				$list = $this->scene->field_control_list($sstion);
				//echo count($list)."/".$totalCount->su;

				$config["total_rows"] = $totalCount->su;
				$this->pagination->initialize($config);

				

				//사업리스트를 출력한다.
				$obj = array("list" => $list, "allco"=>$allCo, "totalCount"=>$totalCount->su);
				$this->load->view("scene/saupanzList", array_merge($plink, $obj));
				
			}else if($md2 == 2){
				//echo $md2."===".$md3;
			
				//$md3 > 0 : 수정 모드
				if($md4 > 0){
					//사업 수정한다.
					$this->load->model('common/commondb');
					//사업의 첨부파일을 가져온다.
					$alladdfile = $this->commondb->getAddF("hjang", $md, $md2, $md4);  //사업의 상세정보를 가져온다.		
					
					$this->load->model('scene/scenemdapp');	
					$spsangse = $this->scenemdapp->getSaupSangse($md4);  //사업의 상세정보를 가져온다.
					$obj = array("mode"=>"edit", "allco"=>$allCo, "spss"=>$spsangse, "allfile"=>$alladdfile);
				}else{
					$obj = array("mode"=>"insert", "allco"=>$allCo);
				}

				$this->load->view("scene/saupanz", array_merge($plink, $obj));

			}else{
				
				$this->load->model('scene/scenemdapp');
				switch($md2){
				case 3: //사업상세 
					//사업의 상세정보를 가져온다.$fnd-사업아이디
					$spsangse = $this->scenemdapp->getSaupSangse($md4);  //사업의 상세정보를 가져온다.
					
					$this->load->model('common/commondb');
					//사업의 첨부파일을 가져온다.
					$alladdfile = $this->commondb->getAddF("hjang", $md, $md2, $md4);  //사업의 상세정보를 가져온다.
					
					//사업의 대상자 리스트를 가져온다.
					//$sps = $this->scenemdapp->getSaupDesang($md4);  //사업아이디를 준다
				
					$this->load->view("scene/saupDesangList", array_merge($plink, array("sps"=>$spsangse, "allfile"=>$alladdfile)));
				break;
				case 4: //대상자 상세보기-업체($md3), 대상자 아이디($md4) 필요
					$sps = $this->scenemdapp->getDesangSangse($md4);  //대상자 아이디를 준다.
					
					$this->load->view("scene/desangSangse", array_merge($plink, array("ds"=>$md4, "saup"=>$sps->saupid, "ssinfo"=>$sps)));
				break;
				case 5:  //사진관리
				
					$sps = $this->scenemdapp->getDesangPhoto($this->config->item('desang'), $this->config->item('saup'));  //대상자 아이디와 사업아이디를 넘긴다.
					
					$this->load->view("scene/desangPhoto", array_merge($plink, array("coid"=>$this->config->item('co'), "ds"=>$this->config->item('desang'), "saup"=>$this->config->item('saup'), "pinfo"=>$sps)));
				
				break;
				}
				
			}

		break;
		case 2: 

			//검색변수 초기화 
			/*
			if($md == 2 and ($md2 == 1 or $md2 == 6 or $md2 == 5) and $md3 == 0 and $md4 == 0){ 
				$this->session->set_userdata("findMd", "0");
				$this->session->set_userdata("find", "");
			}
			*/

		
			$pt = "대상자정보 관리";
			
			//$meminf = $this->member->gaip();  //가입회원의 자료를 가져온다.
			
			//$miobj = array("gaip" => $meminf);
			if($md2 == 1){
				$this->load->model('scene/scene');
				
				//$fgb = substr($fnd,0,2);
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.

				
				//업체에 속한 대상자를 가져온다.
				$arr = array_merge($plink, array("pagePerNum" => $pagePerNum));  //사업아이디를 전달한다.$md4
				$totalCount = $this->scene->desangInfoTotalCount($arr);
				$ds_list = $this->scene->desangInfo($arr);
				
				
					$config["total_rows"] = $totalCount->su;
					$this->pagination->initialize($config);
				
				//업체리스트, 사업리스트, 대상잘 리스트를 출력한다.
				$this->load->view("scene/desanganzList", array_merge($plink, array("allco"=>$allCo, "dslist"=>$ds_list, "totalCount"=>$totalCount->su)));
			
			
			
			}else if($md2 == 2){
				//대상자 등록을 한다..
				$this->load->model('scene/scenemdapp');
				//업체의 모든 사업 리스트를 가져온다.
				$allsaup = $this->scenemdapp->getAllSaup($this->session->userdata("coid"));
				
				if($md4 > 0){
					//수정 모드 이다. - 대상자의 정보를 가져온다.
					$sps = $this->scenemdapp->getDesangSangse($md4);  //대상자 아이디를 준다.
					
					//대상자의 모든 사업대상 설정값을 가져온다.
					$sinfo = $this->scenemdapp->getDesangSaupSeInfo($md4);  //대상자 아이디를 준다.
					
					$data = array_merge($plink, array("mode"=>"edit", "saup"=>$allsaup, "dsid" => $md4, "allco"=>$allCo, "dsss"=>$sps, "sinfo"=>$sinfo));
				}else{
					//등록 모드 이다.
					$data = array_merge($plink, array("mode"=>"insert", "saup"=>$allsaup, "dsid" => $md4, "allco"=>$allCo));
				}

				$this->load->view("scene/desanganz", $data);
				

			}else{
				
				$this->load->model('scene/scenemdapp');
				switch($md2){
				case 3: //사업상세 
					//사업의 상세정보를 가져온다.$md4-사업아이디
					$spsangse = $this->scenemdapp->getSaupSangse($md4);  //사업의 상세정보를 가져온다.
					//사업의 대상자 리스트를 가져온다.
					//$sps = $this->scenemdapp->getSaupDesang((int)$fnd);  //사업아이디를 준다.
					

					$this->load->model('common/commondb');
					//사업의 첨부파일을 가져온다.
					$alladdfile = $this->commondb->getAddF("hjang", $md, $md2, $md4);  //사업의 상세정보를 가져온다.
					//echo count($alladdfile);
					
			
					$this->load->view("scene/saupDesangList", array_merge($plink, array("saup"=>$md4, "sps"=>$spsangse, "allfile"=>$alladdfile)));
				break;
				case 4: //대상자 상세보기 
					$sps = $this->scenemdapp->getDesangSangse($md4);  //대상자 아이디를 준다.
					
					
					$this->load->view("scene/desangSangse", array_merge($plink, array("ds"=>$md4, "saup"=>$sps->saupid, "ssinfo"=>$sps)));
				break;
				case 44: //대상자 상세보기 
					$sps = $this->scenemdapp->getDesangSangse($md4);  //대상자 아이디를 준다.
					
					
					$this->load->view("scene/desangSangse", array_merge($plink, array("ds"=>$md4, "saup"=>$sps->saupid, "ssinfo"=>$sps)));
				break;
				case 5:  //대상자별 사진대장
					$this->load->model('scene/scene');
					
					proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
					$arr = array("coid"=>$md3, "page" => $page, "pagePerNum" => $pagePerNum);
					$totalCount = $this->scene->ds_photolistTotalCount($arr);
					$gs_list = $this->scene->ds_photolist($arr);
					
					$config["total_rows"] = $totalCount->su;
					$this->pagination->initialize($config);
					
					
					$this->load->view("scene/desangPhotoList", array_merge($plink, array("allco"=>$allCo, "gslist"=>$gs_list, "totalCount"=>$totalCount->su)));
					
				
				break;
				case 6:  //대상자별 공사 관리
					$this->load->model('scene/scene');
					proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
					//업체의 공사리스트를 가져온다.
					$arr = array("coid"=>$md3, "page" => $page, "pagePerNum" => $pagePerNum);
					$totalCount = $this->scene->ds_gongsalistTotalCount($arr);
					$gs_list = $this->scene->ds_gongsalist($arr);
					

					$config["total_rows"] = $totalCount->su;
					$this->pagination->initialize($config);


					//업체리스트, 사업리스트, 대상잘 리스트를 출력한다.
					$this->load->view("scene/desangGongsaList", array_merge($plink, array("allco"=>$allCo, "gslist"=>$gs_list, "totalCount"=>$totalCount->su)));
	
				break;
				case 7:  //공사등록
					
					//업체의 사업 리스트를 가져온다.
					$saup_list = $this->scenemdapp->getAllSaup($this->session->userdata("coid"));
					
					//등록과 수정을 구분하여 처리한다.
					if($md4 == 0){
						//등록모드 
						$obj = array_merge($plink, array("allco"=>$allCo, "mode"=>"insert",  "sauplist"=>$saup_list));
					}else{
					    //수정모드 
						//사업의 첨부파일을 가져온다.
						$this->load->model('common/commondb');
						$alladdfile = $this->commondb->getAddF("hjang", $md, $md2, $md3);  //사업의 상세정보를 가져온다.		
						
						//공사의 상세정보를 가져온다.
						$gsss = $this->scenemdapp->getGongsaSS($md3, $md4); 
						
						//echo $gsss->saupid;
						//사업아이디로 사업 대상자리스트를 가져온다.
						$ds_list = $this->scenemdapp->getSaupDesang($gsss->saupid);
						//var_dump($ds_list);
						//echo "su=".count($gsss)."/".$md3."/".$md4;
						
						$obj = array_merge($plink, array("allco"=>$allCo, "dslist"=>$ds_list, "mode"=>"edit", "sauplist"=>$saup_list, "gs"=>$gsss, "allfile"=>$alladdfile));
					}
					
					$this->load->view("scene/gongsaOn", $obj);
				
				break;
				case 77:  //공사상세보기
					//공사 아이디와 대상자 아이디로 공사 상세보기를 한다.md3:공사아이디, md4:대상자 아이디 
					$gsss = $this->scenemdapp->getGongsaSS($md3, $md4);
					$this->load->model('common/commondb');
					//공사의 첨부파일을 가져온다.
					$alladdfile = $this->commondb->getAddF("hjang", $md, $md2, $md3);  //사업의 상세정보를 가져온다.
				
					$obj = array_merge($plink, array("gsid"=>$md3, "dsid"=>$md4, "gsss"=>$gsss, "allfile"=>$alladdfile));
					$this->load->view("scene/gongsaSangse", $obj);
				
				break;
				case 8:   //사진 리스트를 가져온다.
					/*<a href="<?=$baseUrl?>hjang/getView/2/8/<?=$gsrow->coid?>/<?=$gsrow->id?>" class="btn"><span>사진보기</span></a>*/
					//공사아이디로 사진정보를 반환한다.
					$arr = array('gsid'=>$md4);
					$sps = $this->scenemdapp->getDesangPhoto($arr);  //대상자 아이디와 사업아이디를 넘긴다.
					
					//dsid/dange 를 반환한다.
					$dgds = $this->scenemdapp->getDange($md4);
					
					$this->load->view("scene/desangPhoto", array_merge($plink, array("gsid"=>$md4, "dange"=>$dgds->dange, "pinfo"=>$sps)));
				
				break;
				}

			}
		break;
		case 3:
			$pt = "상당일지관리";
			$this->load->model('scene/scenemdapp');


			if($md2 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				

				//업체와 사업에 해당하는 상담리스트를 가져온다.
				//$md3:업체 아이디, $md4:사업 아이디
				$arr = array("coid"=>$md3, "page" => $page, "pagePerNum" => $pagePerNum);
				$totalCount = $this->scenemdapp->coSangdamListTotalCount($arr);
				
				
				$sdall = $this->scenemdapp->coSangdamList($arr);

					$config["total_rows"] = $totalCount->su;
					$this->pagination->initialize($config);
					
					

				$this->load->view("scene/sangdamList", array_merge($plink, array("allco"=>$allCo, "sdlist"=>$sdall, "totalCount"=>$totalCount->su)));
				
				
			}else if($md2 == 2){   //상담등록한다.
				//상담자를 가져온다...
				//$this->load->model('scene/scenemdapp');
				//업체의 사업리스트를 가져온다.
				$allsaup = $this->scenemdapp->getAllSaup($this->session->userdata("coid"));
				
				//사업 아이디로 공사정보를 가져온다.
				//$allgangsa = $this->scenemdapp->getSaupGongsa(0);
				
				
				//$allds = $this->scenemdapp->getCoDesang($this->session->userdata("coid"));  //업체에 속한 대상자를 가져온다.
				$aaa = array_merge($plink, array("ds"=>$md2, "saup"=>$md4, "saup"=>$allsaup));   //"allds"=>$allds, 
				$this->load->view("scene/sangdam", $aaa);
			}else if($md2 == 3){
				//상담내용을 가져온다.
				//$this->load->model('scene/scenemdapp');
				$rt = $this->scenemdapp->getSangdamSS(array("id"=>$md4));  //상담 아이디로 상담 내용을 가져온다.
				//echo var_dump($rt);
				
				$this->load->view("scene/sangdamSangse", array_merge($plink, array("sid"=>$md4, "sss"=>$rt)));
			}else if($md2 == 4){
				//상담내용을 삭제한다.
				$this->scenemdapp->sangdamDel(array("id"=>$md4));  //상담의 아이디로 상담을 삭제한다.
				
				redirect("/scene/hjang/getView/3/1/".$md3."/".$md4);
			}else{   //상담을 수정한다.
				//echo var_dump($allds);
				
				//업체의 사업리스트를 가져온다.
				$allsaup = $this->scenemdapp->getAllSaup($this->session->userdata("coid"));
				
				//수정을 위해 상담 내용을 가져온다.
				$rt = $this->scenemdapp->getSangdamSS(array("id"=>$md4));  //상담 아이디로 상담 내용을 가져온다.
				
				$allds = $this->scenemdapp->coSangDamDesangList($rt->saup);  //사업 아이디로 대상자를 가져온다.
				
				//사업의 아이디로 공사 리스트를 가져온다.
				//$gs = $this->scenemdapp->getSaupGongsa($rt->saup);
				
				//echo var_dump($rt);
				$this->load->view("scene/sangdam", array_merge($plink, array("sid"=>$md4, "sss"=>$rt, "allds"=>$allds, "saup"=>$allsaup)));
			}
			
			
			
		break;
		case 4:
			$pt = "통함검색";
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
			
			

		
		break;
		case 5:  //사진 등록 
			$pt = "사진등록";    //md2:사진레코드 아이디-0보다 크면 수정모드, md3:업체아이디, md4:공사아이디, fnd:단계 
			$this->load->model('scene/scenemdapp'); 
			
			//사진의 정보를 가져온다.
			$phss = $this->scenemdapp->getGongsaPhoto($md2);
			
			$aaa = array_merge($plink, array("ptid"=>$md2, "gsid"=>$md4, "dange"=>(int)$fnd, "ptss"=>$phss));
			$this->load->view("scene/photoOn", $aaa);
		
		break;
		}
		

		if(!$md2) $md2 = 0;
		if(!$md3) $md3 = 0;
		if(!$md4) $md4 = 0;
		$this->load->view("common/foot", $plink);
	
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
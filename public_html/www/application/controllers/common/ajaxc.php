<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxc extends CI_Controller{

	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');  //redirect 사용을 위해 설정
		
		$this->load->library('email');
		
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);

    }
	
	//========================================
	//javascript 에서 php 함수 호출시 사용한다.
	//=========================================
	public function runPhpFunc(){
	
		switch($this->input->post("mode",true)){
		case "getAllGasu":
		
			$rr = getAllGasu();
			$rs = array("rs"=>$rr);
	
		break;
		}

	
		echo json_encode($rs);
	}
	//===================================
	//특정필드 한개의의 값을 DB에 설정한다. 
	//===================================
	public function proFieldSet(){
		
		$this->load->model('common/commondb');
		
		switch($this->input->post("mode",true)){
		case "gasuup":
		
			//DB에 특정 레코드를 추가 한다.--폴더 자체생성
			$arr = array("gasu"=>$this->input->post("val",true));
			$rs = $this->commondb->addRecodTb($this->input->post("mode",true), $this->input->post("tb",true), $arr);
		
		break;
		}
		
		echo json_encode($rs);

	}
	//===================================
	//특정 테이블의 레코드 삭제에 사용한다.
	//===================================
	public function recodeDel($md, $tb, $rid, $md1, $md2, $md3){
		
		$this->load->model('common/commondb');
		
		$rs = $this->commondb->recodeDel($tb, $rid);
		if($rs > 0){
			$rr = array("rs"=>"ok");

		}else{ 
			$rr = array("rs"=>"no");
		}
		
		switch($md){
		case "memberActDel":
			redirect("/control/control/getView/$md1/$md2/1") ;
		break;
		}

	}
	//===================================
	//파일을 삭제한다.
	//===================================
	public function fileDel(){
		
		$this->load->model('common/commondb');
		
		switch($this->input->post("gubun",true)){
		case "community":
		case "saup":
		case "gongsa":
		case "photoon":
			$rs = $this->commondb->fileDel($this->input->post("gubun",true), $this->input->post("recid",true), $this->input->post("num",true), $this->input->post("md",true), $this->input->post("md2",true), $this->input->post("md3",true));
			
		break;
		case "banner":
			$rs = $this->commondb->fileDel($this->input->post("gubun",true), $this->input->post("recid",true), $this->input->post("num",true), $this->input->post("md",true), $this->input->post("md2",true), $this->input->post("md3",true));
			
		break;
		}
		
		$rr = array("rs"=>$rs);
		echo json_encode($rr);
	}
	//===================================
	//javascript 에서 넘어온 실시간 ajax 를 처리한다.
	//===================================
	public function realAjax(){
		
		
		switch($this->input->post('menu', TRUE)){
		case "musicon":
		
		
		break;
		case "mainS":
		
		
		break;
		case "saleanz":
		
		break;
		case "mainod":
		
		
		break;
		case "main":
		
		break;
		case "gongji":
		
		
		break;
		case "noreAnz":
		
		
		break;
		case "community":
		
		
		break;
		case "control":
		
			$this->load->model('member/member');
			
			$rr = $this->member->memInfoId($this->input->post('memid', TRUE));
			
			$rr->rs = "ok";
		break;
		}
		
		echo json_encode($rr);
	
	}
	//===================================
	//test 코드
	//===================================
	public function test(){
		
		echo '{"rs":"ok-test"}';
	
	}
	//===================================
	
	
	
	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
			//디폴트 서버메뉴를 설정 한다.
			//set_defaultSub();		
		
			//$param = array("mode" => "personJ");
		
			//$this->load->view("common/head", $param);
			//$this->load->view("memjoinV");
			//$this->load->view("common/foot");
			
	}




	public function filecont($mode){
		switch($mode){
		case "uploadBasMb":
		
			$tmpnam = $_FILES['file']['tmp_name'];  //임시폴더에 저장된 파일을 정식 폴더로 이동한다.
			$fname = $_FILES['file']['name'];
			
			$dirPath = $this->input->post('tgPo', TRUE);
			$fnam = $this->input->post('tgName', TRUE);
			
			$kk = move_uploaded_file($tmpnam, "../mrphp/".$dirPath.$fnam);
			if($kk == 1){  //업로드 성공
			
				echo 1; ///"1===".$dirPath.$fnam;	
			
			}else{
			
				echo 0; //"0===".$dirPath.$fnam;
				
			}

			
		break;
		case "uploadBasMbCss":
		
			$tmpnam = $_FILES['fileCss']['tmp_name'];  //임시폴더에 저장된 파일을 정식 폴더로 이동한다.
			$fname = $_FILES['fileCss']['name'];
			
			$dirPath = $this->input->post('tgPoCss', TRUE);
			$fnam = $this->input->post('tgNameCss', TRUE);
			
			$kk = move_uploaded_file($tmpnam, "../mrphp/".$dirPath.$fnam);
			if($kk == 1){  //업로드 성공
			
				echo 1; ///"1===".$dirPath.$fnam;	
			
			}else{
			
				echo 0; //"0===".$dirPath.$fnam;
				
			}

			
		break;
		case "uploadMb":
		
			$tmpnam = $_FILES['file']['tmp_name'];  //임시폴더에 저장된 파일을 정식 폴더로 이동한다.
			$fname = $_FILES['file']['name'];
			$kk = move_uploaded_file($tmpnam, "upload/".$fname);
			if($kk == 1){  //업로드 성공
			
				$this->load->model('cupon/cupon');
	
				//모델에서 로그인 처리를 한다.
				$rr = $this->cupon->uploadMb($this->input->post('tit', TRUE), $this->input->post('content', TRUE), $this->input->post('email', TRUE), $fname);
				
				echo $rr;	
			
			}else{
			
				//echo 0;
				
			}

			
		break;
		case "upload":

			$ad_date = date("Y-m-d H:i:s");
			$img_id = substr($this->input->post('memid', TRUE),0,4).substr(md5($ad_date),0,7);
			
			$img_path = PREDIR0."/images/scene/";
			//썸네일 이미지 생성 업로드
			$rsfilenam = file_upload($_FILES['file'],$img_path,'gif,jpg,png',$img_id);
			
			
			
			
			
			$arrgab = array("saupRec"=>(int)$this->input->post('seSaup', TRUE), "gsRec"=>(int)$this->input->post('seRec', TRUE), "wrMem"=>$this->input->post('memid', TRUE), "memo"=>$this->input->post('memo', TRUE), "fname"=>$rsfilenam);
			
			$this->fileupPro($arrgab);
		
		break;
		}
	
	
	
	}




	//모든 첨부파일을 가져온다.
	public function getAddFile(){
		
		$this->load->model('common/commondb');
		//삭제후 모든 첨부파일의 리스트를 가져온다.
		$alladdfile = $this->commondb->getAddFaftDel($this->input->post("gubun", true), $this->input->post("md", true), $this->input->post("md2", true), $this->input->post("txtid", true));  //사업의 상세정보를 가져온다.
		
		
		//컨트롤 값을 전달한다.
		$gb = $this->input->post("gubun", true);
		if($gb == "community") $gubun = "community";
		else $gubun = "hjang";
		
		$ulli = dispAllFile($gubun, $this->input->post("md", true), $this->input->post("md2", true), "#", $alladdfile, "edit");
	
		echo $ulli;
	}
	



	public function fileupPro($arr){
	
		$this->load->model('scene/scenemdapp');

		$this->scenemdapp->imgUppro($arr);  //파일 업로드를 처리 한다.
	
	}

	public function mobileFun(){

		$mode = $this->input->post('mode', TRUE);
	
		switch($mode){
		case "setDelFile":
		
			$this->load->model('common/device');
			
			//삭제대기상태의 파일을 가져온다.
			$rr = $this->device->setDelFile($this->input->post('type', TRUE), $this->input->post('uid', TRUE), $this->input->post('name', TRUE));
			
			echo $rr;
		
		break;
		case "getDelFile":
		
			$this->load->model('common/device');
			
			//삭제대기상태의 파일을 가져온다.
			$rr = $this->device->getDelFile($this->input->post('type', TRUE), $this->input->post('uid', TRUE));
			
			echo json_encode($rr);
		
		
		break;
		case "delOn":
			$this->load->model('common/device');
			
			//파일을 삭제대기 상태로 만든다.
			$rr = $this->device->delOn($this->input->post('type', TRUE), $this->input->post('uid', TRUE), $this->input->post('name', TRUE));
			
			echo $rr;
			
			break;
		case "liveWr":
			
			$this->load->model('common/device');
	
			//새로운 영상정보를 가져온다.
			$rr = $this->device->liveWr($this->input->post('type', TRUE), $this->input->post('mess', TRUE), $this->input->post('uid', TRUE), $this->input->post('uuid', TRUE));
			
			echo $rr;
			
			break;
		case "localList":
			
			$this->load->model('common/device');
	
			//새로운 영상정보를 가져온다.
			$rr = $this->device->localList($this->input->post('type', TRUE), $this->input->post('fil', TRUE), $this->input->post('uid', TRUE), $this->input->post('uuid', TRUE));
			
			echo $rr;
			
			break;
		case "newMove":
		
			$this->load->model('common/device');
	
			//새로운 영상정보를 가져온다.
			$rr = $this->device->newMove($this->input->post('type', TRUE));
			
			echo json_encode($rr);
		
		break;
		case "passfind":
		
			$this->load->model('member/member');

			//모델에서 로그인 처리를 한다.
			$meminf = $this->member->onFindMemPw($this->input->post('email', TRUE), $this->input->post('tel', TRUE));
			
			echo json_encode($meminf);	
		
		break;
		case "songBest":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getJarangBest(8);
			
			echo json_encode($rr);
		
		break;
		case "songNew":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getJarangNew(8);
			
			echo json_encode($rr);
		
		break;
		case "findReEmail":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->findReEmail($this->input->post('email', TRUE));
			
			echo json_encode($rr);	
		
		break;
		case "getMyJarangAll":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getMyJarangAll($this->input->post('email', TRUE));
			
			echo json_encode($rr);	
		
		break;
		case "getJarangBest":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getJarangBest(0);
			
			echo json_encode($rr);	
		
		break;
		case "getJarangNew":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getJarangNew(0);
			
			echo json_encode($rr);	
		
		break;
		case "seAlbumSet":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->seAlbumSet($this->input->post('sid', TRUE), $this->input->post('alid', TRUE), $this->input->post('email', TRUE));
			
			echo '{"id":"'.$rr.'"}';	
		
		break;
		case "albumEdit":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->albumEdit($this->input->post('did', TRUE), $this->input->post('tit', TRUE));
			
			echo '{"id":"ok"}';	
		
		break;
		case "albumDel":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->albumDel($this->input->post('did', TRUE));
			
			echo '{"id":"ok"}';	
		
		break;
		case "getMyAlbumAllUl":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getMyAlbumAllUl($this->input->post('email', TRUE));
			
			echo $rr;	

		break;
		case "getMyAlbumAll":
		
			$this->load->model('cupon/cupon');

			//모델에서 로그인 처리를 한다.
			$rr = $this->cupon->getMyAlbumAll($this->input->post('email', TRUE));
			
			echo json_encode($rr);	

		break;
		case "albumAddPro";
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->albumAddPro($this->input->post('email', TRUE), $this->input->post('albumOn', TRUE));
			
			if($rr == "re"){
				echo '{"id":"re"}'; //json_encode($rr);
			}else{
				echo  '{"id":'.$rr.'}';
			}

		
		break;
		case "setDown":
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->setDown($this->input->post('cpid', TRUE), $this->input->post('sid', TRUE));
			
			if($rr == "not"){
				echo '{"id":"not"}'; //json_encode($rr);
			}else{
				echo  '{"id":'.$rr.'}';
			}
		
		break;
		case "cuponUser":
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->cuponUser($this->input->post('email', TRUE), $this->input->post('cid', TRUE));
			

			if($rr == 0){
				echo '{"id":0}'; //json_encode($rr);
			}else{
				echo  '{"id":'.$rr.'}';
			}

		break;
	    case "downmp":
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->downmp($this->input->post('email', TRUE));
			

			if($rr == "not"){
				echo '{"id":0}'; //json_encode($rr);
			}else{
				echo  json_encode($rr);
			}
				
		break;
		case "gumeMpList":
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->gumeMpList($this->input->post('email', TRUE));
			
			echo json_encode($rr);
		
		break;
		case "gumeyg":   //구매요금제 출력 
		
			$this->load->model('cupon/cupon');
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->gumeyg($this->input->post('email', TRUE));
			
			echo json_encode($rr);
		
		break;
		case "myDevice":
		
			$this->load->model('common/device');
	
			//나의 등록된 장비를 가져온닫.
			$rr = $this->device->myDevice($this->input->post('email', TRUE));
			
			echo json_encode($rr);
		
		break;
		case "deviceOnPro":
		
			$this->load->model('common/device');
			$day = date("Y-m-d H:i:s", time());
		
			$data = array("uiu"=>$this->input->post('uiu', TRUE), "cosa"=>$this->input->post('cosa', TRUE), "device"=>$this->input->post('phmd', TRUE), "email"=>$this->input->post('email', TRUE), "onday"=>$day);
		
			//쿠폰 구매처리를 한다.
			$rr = $this->device->deviceOn($data);
			
			echo '{"rs":'.$rr.'}';
		
		break;
		case "cuponGume":
		
			$this->load->model('cupon/cupon');
			$day = date("Y-m-d H:i:s", time());
		
			$data = array("gubun"=>$this->input->post('gubun', TRUE), "don"=>$this->input->post('don', TRUE), "email"=>$this->input->post('email', TRUE), "tit"=>$this->input->post('tit', TRUE), "daysu"=>$this->input->post('daysu', TRUE), "onday"=>$day);
		
			//쿠폰 구매처리를 한다.
			$rr = $this->cupon->gumeOn($data);
			
			echo '{"rs":'.$rr.'}';
		
		break;
		case "myJumunList":
			$this->load->model('jumun/jumun');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jumun->myJumunList($this->input->post('email', TRUE));
			
			echo json_encode($meminf);
		
		break;
		case "jumunComOn":
			$day = date("Y-m-d H:i:s", time());
			
			$this->load->model('jumun/jumun');
			
			$datamd = array("idmd"=>$this->input->post('idmd', TRUE));
			$data = array("jlgubun"=>$this->input->post('jlgubun', TRUE), "don"=>$this->input->post('don', TRUE), "email"=>$this->input->post('email', TRUE), "name"=>$this->input->post('name', TRUE), "tel"=>$this->input->post('tel', TRUE), "song"=>$this->input->post('song', TRUE), "gasu"=>$this->input->post('gasu', TRUE), "keymemo"=>$this->input->post('keymemo', TRUE), "jumunmemo"=>$this->input->post('jumunmemo', TRUE), "stime"=>$this->input->post('stime', TRUE), "etime"=>$this->input->post('etime', TRUE), "onday"=>$day);

			$rr = $this->jumun->jumunonput($data, $datamd);
		
			echo '{"rs":'.$rr.'}';
		
		break;
		case "getMyJumun":   //전체 간단문의 내역을 가져온다.
			$this->load->model('jumun/jumun');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jumun->myjumun($this->input->post('email', TRUE));
			
			echo json_encode($meminf);
		
		break;
		case "getFaq":
			$this->load->model('notice/notice');
		
			$gb = $this->input->post('gubun', TRUE);
			
			//모델에서 로그인 처리를 한다.
			$meminf = $this->notice->allFaq($gb);
			
			echo json_encode($meminf);
		
		break;
		case "getAllGongji":
			$this->load->model('notice/notice');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->notice->allgongji();
			
			echo json_encode($meminf);
		
		break;
		case "likeOn":
		
			$this->load->model('jarang/jarang');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jarang->likeon($this->input->post('jid', TRUE), $this->input->post('email', TRUE));
			
			echo '{"rs":'.$meminf.'}';
		
		break;
		case "likeSu":
		
			$this->load->model('jarang/jarang');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jarang->likesu($this->input->post('jid', TRUE));
			
			echo '{"rs":'.$meminf->su.'}';
		
		break;
		case "getAllJumun":
			$this->load->model('jumun/jumun');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jumun->alljumun();
			
			echo json_encode($meminf);
		
		break;
		case "getAllJrDet":  //댓글을 가져온다.
			$this->load->model('jarang/jarang');
		
			//모델에서 로그인 처리를 한다.
			$meminf = $this->jarang->getAllJrDet($this->input->post('jid', TRUE));
			
			echo json_encode($meminf);
		
		break;
		case "jrDet":   //노래자랑 댓글을 입력한다.
		
			$day = date("Y-m-d H:i:s", time());
			$this->load->model('jarang/jarang');

			$datamd = array("idmd"=>$this->input->post('idmd', TRUE), "idgab"=>$this->input->post('idgab', TRUE));

			$data = array("email"=>$this->input->post('email', TRUE), "idgab"=>$this->input->post('idgab', TRUE), "jrtext"=>$this->input->post('jrText', TRUE), "onday"=>$day);

			//모델에서 로그인 처리를 한다.
			$meminf = $this->jarang->jronput($data, $datamd);
			
			echo '{"rs":'.$meminf.'}';
		
		break;
	    case "munOnput":
			$day = date("Y-m-d H:i:s", time());
			$this->load->model('jumun/jumun');

			$datamd = array("idmd"=>$this->input->post('idmd', TRUE), "idgab"=>$this->input->post('idgab', TRUE));

			$data = array("email"=>$this->input->post('email', TRUE), "qtit"=>$this->input->post('qtit', TRUE), "qtext"=>$this->input->post('qtext', TRUE), "onday"=>$day);

			//모델에서 로그인 처리를 한다.
			$meminf = $this->jumun->munonput($data, $datamd);
			
			echo '{"rs":'.$meminf.'}';
			
		
		break;
		case "idfind":
		
			$this->load->model('member/member');

			//모델에서 로그인 처리를 한다.
			$meminf = $this->member->onFindMemId($this->input->post('name', TRUE), $this->input->post('tel', TRUE));
			
			echo json_encode($meminf);	
		
		break;
		case "joinedit":
		
			//모바일 회원가입
			$this->load->model('member/member');

			$rr = $this->member->myInfo($this->input->post('email', TRUE));
			
			$rr->tel = base64decode($rr->tel);
			
			echo json_encode($rr);
		
		
		break;
		case "passchange":
		
			$this->load->model('member/member');
			
			$datamd = array("oldpass"=>base64encode($this->input->post('oldpasswd', TRUE)), "email"=>$this->input->post('email', TRUE));
			
			$data = array("passwd"=>base64encode($this->input->post('passwd', TRUE)));
			
			$rr = $this->member->passchange($data, $datamd);
		
			if($rr == "dif"){
				echo '{"rs":"dif"}';
			}else{
				echo '{"rs":'.$rr.'}';
			}
			
		
		break;
		case "join":
			//모바일 회원가입
			$this->load->model('member/member');
			
			$telend = base64encode(substr($this->input->post('tel', TRUE), -4));
			
			$datamd = array("idmd"=>$this->input->post('idmd', TRUE), "idgab"=>$this->input->post('idgab', TRUE));
			
			$data = array("name"=>$this->input->post('name', TRUE), "tel"=>base64encode($this->input->post('tel', TRUE)), "telend"=>$telend, "birthday"=>$this->input->post('birthday', TRUE), "memid"=>$this->input->post('email', TRUE), "email"=>$this->input->post('email', TRUE), "passwd"=>base64encode($this->input->post('password', TRUE)), "nicname"=>$this->input->post('nicname', TRUE), "terms"=>$this->input->post('terms', TRUE), "privacy"=>$this->input->post('privacy', TRUE));
			
			$rr = $this->member->onMemberData($data, $datamd);
		
			if($rr == "two"){
				echo '{"rs":"two"}';
			}else{
				echo '{"rs":'.$rr.'}';
			}
			
		
		break;
		case "login":

			//회원관련 DB를 처리한다.
			$this->load->model('member/member');

			//모델에서 로그인 처리를 한다.
			$meminf = $this->member->getLogin($this->input->post('email', TRUE), base64encode($this->input->post('password', TRUE)));
			//로그인 결과를 모바일로 돌린다.
			//$this->load->view("common/homeV", array("meminf"=>$meminf));
			
			//$meminf[0]['rs'] = (int)$meminf[0]['su'];
			//$meminf[0]['tel'] = base64decode($meminf[0]['tel']);
			//$meminf[0]['name'] = base64decode($meminf[0]['name']);
			//$meminf[0]['email'] = base64decode($meminf[0]['email']);
			
			echo json_encode($meminf);

		break;
		case "autoLogin":
		
			//회원관련 DB를 처리한다.
			$this->load->model('member/member');

			//모델에서 로그인 처리를 한다.
			$meminf = $this->member->getLogin($this->input->post('email', TRUE), $this->input->post('password', TRUE));
			
			echo json_encode($meminf);
		
		break;
		case "coAllListMy":
		
			$this->allCompanyListMy($this->input->post('seco', TRUE));
		
		break;
		case "coAllList":
		
			$this->allCompanyList();
		
		break;
		case "gaipDesang":
		
			$sarray = array("memid"=>$this->input->post('memid', TRUE), "po"=>$this->input->post('po', TRUE), "cogubun"=>$this->input->post('cogubun', TRUE), "coid"=>$this->input->post('coid', TRUE), "secoid"=>$this->input->post('secoid', TRUE), "fnd"=>$this->input->post('fnd', TRUE));

			$this->gaipDesang($sarray);  //가입회원의 리스트를 가져온다.
		
		break;
		}
		

	}




	//가입된 회원의 리스트를 가져온다.
	public function gaipDesang($row){
		
			$this->load->model('member/member');
			

				$meminf = $this->member->gaip($row);  //가입회원의 리스트를 가져온다.
				
				echo json_encode($meminf);
				
	}
	


	public function allCompanyListMy($seco){  //내가 소속된 업체의 정보를 가져온다.
	
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//모델에서 로그인 처리를 한다.
		$coarray = $this->member->allCompanyNameIdMy($seco);
		
		echo json_encode($coarray);
	}




	public function allCompanyList(){  //가인된 업체의 리스트를 가져온다.
	
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//모델에서 로그인 처리를 한다.
		$coarray = $this->member->allCompanyNameId();
		
		echo json_encode($coarray);
	}




	public function personJoin(){  //개인 회원가입
	
		//회원관련 DB를 처리한다.
		$this->load->model('company');
		//모델에서 로그인 처리를 한다.
		$coarray = $this->company->allCompanyNameId();
		
	
		$param = array("mode" => "personJ");
	
			$this->load->view("common/head", $param);
			$this->load->view("memjoinV", array("coary"=>$coarray));
			$this->load->view("common/foot");
	
	}


	//모바일에서 로그인을 한다.
	public function authMb(){
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		$pss = base64encode($this->input->post('pss', TRUE));
		//모델에서 로그인 처리를 한다.
		$meminf = $this->member->getLogin($this->input->post('memid', TRUE), $pss);
		//로그인 결과를 모바일로 돌린다.
		$this->load->view("common/homeV", array("meminf"=>$meminf));
		
	}




	//사업자 등록번호 중복확인을 한다.
	public function snOkInf(){ 
	
		$sn = $this->input->post('conum', TRUE);
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//중복확인 처리를 한다.
		$meminf = $this->member->getSaupNum($sn);
		
		//$rr = array('rs' => (int)$meminf[0]['su']);
		$rr = '{"rs":'.$meminf[0]['su'].', "conum":"'.$meminf[0]['conum'].'"}';

		echo $rr;   //호출한 곳으로 결과를 되돌린다.
		
	
	}



	public function emOkInf(){  //email 중복확인을 한다.
	
		$em = $this->input->post('email', TRUE);
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//중복확인 처리를 한다.
		$meminf = $this->member->getEmailId($em);
		
		//$rr = array('rs' => (int)$meminf[0]['su']);
		$rr = '{"rs":'.$meminf.'}';

		echo $rr;   //호출한 곳으로 결과를 되돌린다.
		
	
	}


	public function idOkInf(){  //아이디 중복확인을 한다.
	
		$mid = $this->input->post('memid', TRUE);
		
		//회원관련 DB를 처리한다.
		$this->load->model('member/member');
		//모델에서 아이디 중복확인을 한다.
		$meminf = $this->member->getMemId($mid);
		
		//$rr = array('rs' => (int)$meminf[0]['su']);
		$rr = '{"rs":'.$meminf.'}';

		echo $rr;   //호출한 곳으로 결과를 되돌린다.
		
	
	}

	//회원아이디 찾기
	public function findId(){
	
		$this->load->model('member/member');
		//모델에서 로그인 처리를 한다.
		$meminf = $this->member->onFindMemId($this->input->post('idtel', TRUE), $this->input->post('idemail1', TRUE)."@".$this->input->post('idemail2', TRUE));
		
		if($meminf[0]['su'] > 0){
			$this->session->set_flashdata('loginf', '회원아이디는 <strong>"'.$meminf[0]['memid'].'"</strong> 입니다.');
			redirect("/home/findMemId/ok/".$meminf[0]['memid']) ;
		}else{
			$this->session->set_flashdata('idnotfind', '일치하는 회원정보가 없습니다.');
			redirect("/home/findMemId/not/0") ;
		}

	}
	
		//회원비밀번호 찾기
	public function findPw(){
	
		$this->load->model('member/member');
		//모델에서 회원의 비밀번호를 찾는다.
		$meminf = $this->member->onFindMemPw($this->input->post('pwtel', TRUE), $this->input->post('pwid', TRUE) ,$this->input->post('pwemail1', TRUE)."@".$this->input->post('pwemail2', TRUE));
		
		if($meminf->su > 0){
			
			$this->email->from('g1915@naver.com', 'MROO');
			$this->email->to($this->input->post('pwemail1', TRUE)."@".$this->input->post('pwemail2', TRUE)); 
			//$this->email->cc('another@another-example.com'); 
			//$this->email->bcc('them@their-example.com'); 
			$imsi = base64decode($meminf->passwd); //base64encode("1234");
			
			
			$this->email->subject('임시비밀번호 발송');
			$this->email->message('MROO 관리자 입니다. 로그인을 위한 임시비밀번호는 "'.$imsi.'" 입니다.');	
			
			$this->email->send();
			
			//echo $this->email->print_debugger();
			
			$this->session->set_flashdata('loginf', '회원님의 이메일 (<strong>"'.$this->input->post('pwemail1', TRUE)."@".$this->input->post('pwemail2', TRUE).'"</strong>) 로 <br />임시비밀번호를 발송 하였습니다.');
			redirect("/home/findMemPw/pwok") ;
		}else{
			$this->session->set_flashdata('pwnotfind', '일치하는 회원정보가 없습니다.');
			redirect("/home/findMemPw/pwnot") ;
		}

	}
	
	
	
	
	
	//업체등록 폼값을 넘긴다.
	public function coFormOn(){
		$day = date("Y-m-d H:i:s", time());
		//echo "onnn=".$this->input->post('memid');
		//회원등록을 한다.
		$this->load->model('member/member');
		$data = array("memid" =>$this->input->post('memid', TRUE), "name" =>$this->input->post('name', TRUE), "coname" => $this->input->post('coname', TRUE), "email" =>$this->input->post('coemail1', TRUE)."@".$this->input->post('coemail2', TRUE), "passwd"=> base64encode($this->input->post('copass', TRUE)), "tel"=> base64encode($this->input->post('cotel', TRUE)), "conum"=> $this->input->post('cosaupnum', TRUE), "post"=> $this->input->post('copost', TRUE), "address"=> $this->input->post('coaddress', TRUE), "gubun"=>$this->input->post('gubun', TRUE), "potion"=> $this->input->post('potion', TRUE), "cogubun"=>$this->input->post('cogubun', TRUE), "onday"=>$day);
		//모델에서 로그인 처리를 한다.
		$meminf = $this->member->onCompanyData($data);
		
		if($meminf > 0){
			//뷰어를 호출 한다.
			$this->session->set_flashdata('loginf', '회원가입 완료 하였습니다. 가입승인 후 로그인 가능 합니다.');
			redirect("/home/onMember/cook") ;

		}
		
		

	}
	
	


}





?>
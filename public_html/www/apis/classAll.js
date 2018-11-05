/*
//2.6 세션 테이블
CREATE TABLE IF NOT EXISTS  `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(16) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);

//3.0 세션 테이블
CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(40) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned 기본값 0 NOT NULL,
        `data` blob NOT NULL,
        PRIMARY KEY (id),
);

*/


var PREDIR0 = "";
var PREDIR = "/";
var ORGPATH = "http://mroo.co.kr";
var CIBASE = ORGPATH+PREDIR0;     //코드이그나이터 기본 링크 

var baseURL = CIBASE+"/";
		

var BANNERPATH = CIBASE+"/images/banner/";
var LK = CIBASE+"/mobile/push/";  //기본 링크
var LKCODE = CIBASE+"/home/";     //코드이그나이터 기본 링크 
var LKMEM = CIBASE+"/common/ajaxc/";     //코드이그나이터 회원관련 링크
//===============================================================================
var APPINF = "s";
var FEELINGGO = "Y";   //필링 가입 여부를 확인 한다.-"N"로 고정 해야 한다.
//================================================================
var TESTGO = false; //false; //true;   //테스트하기 위해 삽입한 코드의 실행 여부를 설정 

var PROJE = "nowField";

//=================================================
////uws64-181.cafe24.com/WebMysql      id:pigg1234,    pass:soho7273
//기본변수=============
//var fnName = "kkss";
var qr = "";
var param = "";

var pushBack = false;

var appStart = true;   //앱이 실행된 여부를 저장한다. 기본값은 실행전 false 이다.
var meminf;

var phoneRegid = "0";
var backStay = 1;


//복제된 클래스의 이름
var getServ, getServ2, allPlay; 
var devAudio;
var mapObj, mapObjList, mapObjSS;    //mapObj = 매장상세보기에서 출력하는 지도 ,   mapObjList = 매장리스트에서 표시하는 지도
var fileObj;

var formPro = {
	frm:null,
	farr:[],
	
	init:function(obj, arr){
		//this.frm = obj;
		//this.farr = arr;
	},
	
	setFormEditVal:function(obj, arr){
	
		for(var c = 0; c < obj.length; c++){
			if(obj[c].type != "file" && obj[c].type != "hidden"){
				if(obj[c].type == "select-one"){
					this.selectInit(obj[c], arr);
				}else if(obj[c].type == "date"){
					//alert(obj[c].type+"///"+obj[c].name+"///"+arr[obj[c].name]);
					$("input[name="+obj[c].name+"]").val(arr[obj[c].name]);
				}else{
					//alert(obj[c].type+"///"+obj[c].name+"///"+arr[obj[c].name]);
					$("input[name="+obj[c].name+"]").val(arr[obj[c].name]);
				}
			}
			if(obj[c].type == "hidden"){
				
				if(obj[c].name == "id"){
					$("input[name="+obj[c].name+"]").val(arr[obj[c].name]);
				}
			
			}
		}
		//이미지의 존재여부를 파악한다.================
		if(arr['img'] && arr['img'] != '0'){
			//그림이 존재한다.
			//배너처리
			$("table tr.oldBanner td").html("<img src='"+BANNERPATH+arr['img']+"' width='70%' />");
		}else if(arr['img'] == '0'){
			//설정된 그림이 없다 디폴트 표시
			//배너처리
			$("table tr.oldBanner td").html("없음");
		}
		//======================================
		
	},
	selectInit:function(obj, arr){  //설렉터 값을 선택하고 초기화 한다.
		$("select[name="+obj.name+"]").val(arr[obj.name]).attr("selected",true);
	}
	
	
	
}



//앱의 기본 정보
var appBasInfo = {
	ver:"1.0",
	fnName:"kkss",
	screenH:null, //window.innerHeight;
	screenW:null,
	windowH:null, //$(window).height();
	wonsiH:null,
	wonsiW:null,
	pageTopH:null,
	colorLineH:0.6,
	
	fileDownDir:"nowField",
	oldFileDownDir:"",
	
	
	imsiDet:"",
	imsiDap:"",
	
	mem:null,
	my:null,
	
	pageH:0,
	
	toggleVar:{},  //각종 토글 변수 
	
	nowViewImgLink:"", //현재 보기 선택된 이미지의 링크
	
	
	taPageGoin:false,    //다른 페이지에서 메인 페이지로 넘어온 여부를 저장 false = 타페이지 에서 온것은 아니다.
	
	appFirstInf:true,
	
	

	
	
	deviceUiu:null,
	conType:null,
	conTypeOld:null,
	resumeInf:null,
	topHeight:0,
	
	imgTouchX:20,
	imgTouchY:50,
	
	
	firstMode:"B01",
	
	

	
	leftMnuCode:{},
	leftMnuTxt:{},
	leftUpjCode:{},
	leftUpjTxt:{},	
	
	
	//왼쪽메뉴의 초기값==================
	leftMenuCode:"1010",
	leftMenuGubun:"jp",
	leftMenuDeText:"제품별",
	leftMenuText:"액자류",
	leftMenuTextAll:"액자류",
	//===============================
	
	blogOnInf: false,    //블로그에 초기값은 상품 등록하지 않는다.
	blogFindTxt:"",      //블로그에 등록하기 위해 검색어로 상품을 찾는다.
	blogTitle:"",
	blogCont:"",
	blogTel:"",
	blogCoTel:"",
	blogAllImg:"",
	blogCate:"",
	
	
	
	
	textLimitSu:34,      //일반 글자수 제한
	textLimitJeSu:34,    //재설정함 글자수 제한		
	
	nowViewCo:null,   //현재 선택된 업체의 아이디
	nowPage:"not",     //현재 보고 있는 페이지
	nowMainMenu:null,  //현재선택한 메인 메뉴 번호

	nowImgSeq:0,      //삭제 이동하기 원하는 이미지 seq
	nowImgSort:0,     //선택한 이미지의 정렬 순서값 
	allImgSu:0,       //읽어 들인 전체이미지 숫자
	
	
	
	jumunBdIndex:0, //주문게시판에서 선택한 인덱스 번호 - 참조키 (선택한 주문의 키)
	jumunBdFtxt:null,   //주문게시판의 검색어
	jumunBasDui:1,   //주문본문은 기본 등록 모드 이다.
	jumunDui:1,      //기본값은 등록 모드 - 댓글
	jumunDetSeq:0,     //주문댓글 시킨스
	jumunDapSeq:0,   //주문답글 시킨스
	
	

	
	
	nowSumCount:5,  //이미지 등록 기본갯수는 5개이다.
	
	nowJmIndx:0,     //현재 선택된 제품의 인덱스
	nowWriter:"",   //현재 제품의 등록자 
	contBasDui:1,    //컨텐츠 등록 기본 등록 모드 이다.
	contDui:1,       //기본값은 등록모드 - 댓글
	contDetSeq:0,     //컨텐츠 댓글 시킨스 
	contDapSeq:0,     //컨텐츠 답글 시킨스
	
	//푸시를 발사한다.
	//필요한 정보 글번호(this.jumunBdIndex), 댓글작성자(this.mem.UserA), 수신자(댓글 또는 답글 작성자) (jumunWr);		
	pushIndx:0,
	pushFrom:"",
	pushFName:"",
	pushTo:"",
	pushText:"",
	pushMd:"ct",   //ct:컨텐츠 관려,  jumun: 주문관려
	
	
	
	wonsiInit:function(){  //load 에서 한번만 실행하여 폰의 기본 화면크기 가져온다.
		this.wonsiW = window.innerWidth;
		this.wonsiH = window.innerHeight;
		this.pageTopH = (this.wonsiH / 100) * 9;
		this.colorLineH = 0.6;
	},
	
	init:function(){
		
		
		
		//this.beforShow() 에서 호출 한다.
		//매번 화면의 크기를 가져오고 각 페이지별 화면 디자인을 출력한다.
		this.screenW = window.innerWidth;
		this.screenH = window.innerHeight;
		this.windowH = $(window).height();
		
		
		if(this.screenW > 360){
			//큰화면의 경우
			this.screenBig = true;
			this.textLimitSu = 62;   //appBasInfo.textLimitSu
			this.textLimitJeSu = 62;
		}
		
		this.toggleVar = new Array(0, 0, 0);   //0:이미지 확대(1), 축소(0) --
		
		
					//기본적인 지도변수만 생성=========================
			//alert("kkkk");
			//매장상세보기에서 사용하는 지도를 생성한다.
			mapObj = new coMappro("coMap");
			//매장리스트에서 사용하는 지도를 생성한다.
			mapObjList = new coMappro("coMapList");
			//컨텐츠상세보기에서 지도표시
			mapObjSS = new coMappro("coMapSS");
			//===========================================
		
		
	},
	
	goFirst:function(){
		
		//'278b27e42e2f0d49'
		
	    //var encrypted = CryptoJS.RC2.encrypt("김성식", "278b27e42e2f0d49", { effectiveKeyBits: 64 });
	    //var encrypted = Base64.encode("김성식 kkkkk");
	    //var decrypted = Base64.decode(encrypted);
		
	    //alert(encrypted+"//////"+decrypted);
		
		
		var vv = this.mem;
		
		
		
		
		//앱이 처음에 실행될 때 한번만 실행하는 코드는 여기에 모두 처리한다.-꼭 한번만 실행해야 한다.
		if(this.appFirstInf){
			this.appFirstInf = false;
			//vv.onputTestMem();  //테스트회원 강제등록
			
			vv.telDash = window.sessionStorage.getItem("phoneno");

			
			
			
			if(window.localStorage.getItem("loginStat") == null) window.localStorage.setItem("loginStat", "no");
			
			//alert("llll="+window.localStorage.getItem("loginStat"));
			
			//자동 로그인 설정된 경우 로그인 한다.
			if(window.localStorage.getItem("autoLogin") == "ok" && window.localStorage.getItem("memid") && window.localStorage.getItem("memidps") && (window.localStorage.getItem("memid") != null && window.localStorage.getItem("memid") != "0") && (window.localStorage.getItem("memidps") != null && window.localStorage.getItem("memidps") != "0") && vv.loginStat == false){
				this.mem.autoLogin();
			}

			
			//기타 함수들 처리
			appUtil.init(vv);
			
			
			//왼쪽메뉴의 제품별 코드와 이름을 가져온다.
			/*
			//var alb1 = new GetServer();
			//서버에서 모든 음원을 가져온다.
			//var dom = document.querySelector(".leftCode");
			//alb1.initParam("nowFieldPro.php", "mode=C04", "leftCode", dom);
			//alb1.getPostMode(alb1, this.mem);  //서버에서 post 모드로 가져온다.
			*/
			
			
			
			//왼쪽메뉴의 업종별 코드와 이름을 가져온다.
			//var alb2 = new GetServer();
			//서버에서 모든 음원을 가져온다.
			//var dom = document.querySelector(".leftCode");
			//alb2.initParam("nowFieldPro.php", "mode=C05", "upjongCode", dom);
			//alb2.getPostMode(alb2, this.mem);  //서버에서 post 모드로 가져온다.
			

			
		}
		
	},
	
	design:function(memobj){
		
		this.mem = memobj;
		//각페이지별 호면의 디자인을 출력한다.
		this.init();  //페이지 초기화
		
		AWtrans.init(this.mem);
		
		//앱실행하면서 최초 한번만 실행하는 코드들 
		this.goFirst();

		//앱과웹을 트랜스퍼 한다.
		AWtrans.trans();
		
		
		//풋과 왼쪽메뉴 동시 출력===========================
		switch(this.nowPage){
		case "JumunBDOn":
			
			//왼쪽 메뉴 출력
			insertLeftMenu.dispMenu(memobj.loginStat);
			insertFootBar.dispFoot();
			break;
		}
		//풋메뉴1만 출력=================================
		switch(this.nowPage){
		case "Login":      //화면에 메뉴 이외의 다른 것들을 출력한다.

			break;
		}

		
		//왼쪽메뉴만 출력================================
		switch(this.nowPage){
		case "page":      //화면에 메뉴 이외의 다른 것들을 출력한다.
		case "Join":
		case "ContentOnPut":  //컨텐츠 등록
		case "JumunBDList":
		case "CoSangse":
		case "JumunBDView":
		case "ContentSS2":   //컨텐츠 상세보기 
		case "MejangList":   //매장안내
			
			//왼쪽 메뉴 출력
			insertLeftMenu.dispMenu(memobj.loginStat);
			
			break;
		}
		//기타 디자인 출력====================================
		switch(this.nowPage){
		case "page":      //화면에 메뉴 이외의 다른 것들을 출력한다.
			this.fnName = "case page:";
			//insertLeftMenu.pageMenuInitDisp();  //선택경로 표시 
			
			break;
		case "JumunBDOn":

			break;
		case "JumunBDList":

			
			break;
		case "JumunBDView":

			
			break;
		case "Login":
				
			$('input:text').css({"margin":"1px 0"});

			break;
		case "Join":

			
			break;
		case "ContentOnPut":  //컨텐츠 등록

			
			break;
		}
		//==========================================
	},
	

	//페이지 표시전 처리 루틴
	beforShow:function(){
		
		switch(this.nowPage){
		case "page":      //화면에 메뉴 이외의 다른 것들을 출력한다.
			
			if(window.localStorage.getItem("loginStat") != "ok"){
				appUtil.moveNoHistory("index.html#Login");
			}else{
				
				
				
			}
			
			
			/*
			
				if(this.taPageGoin){
					this.taPageGoin = false;
					document.getElementById("findPage").value = "";
				}
				this.pageContentGet();				
			*/
			
			break;
		case "ImageView":
			
			//this.mem.memEmp = 1;
			
			
			
			document.getElementById("ImageDown").style.display = "none";
			if(this.mem.loginStat){
				if(this.mem.memEmp == 1){
					document.getElementById("ImageDown").style.display = "block";
				}
			}
			
			
			
			
			break;
		case "JumunBDOn":

			if(!this.mem.loginStat){
				//로그인 해야 한다.
				this.leftMenuTextAll = "로그인";
				appUtil.moveOkHistory("index.html#Login");
				
			}else{
			
				//지역명을 가져와서 출력한다.
				var jbd1 = new GetServer();
				var dom1 = document.querySelector("#UserDjiy");
				jbd1.initParam("nowFieldPro.php", "mode=D05", "jumunjiy", dom1);
				jbd1.getPostMode(jbd1, this.mem);  //서버에서 post 모드로 가져온다.
				
				document.getElementById("jumunOnInf").src = "./images/bt_write.png";
				
				//수정또는 등록모드 판단하여 처리한다.
				if(this.jumunBasDui == 2){
					document.getElementById("jumunOnInf").src = "./images/bt_modify.png";
					//수정모드인 경우
					//주문상세내역을 가져온다.
					var jbd = new GetServer();
					var dom = document.querySelector(".jumunBDVTB");
					jbd.initParam("nowFieldPro.php", "mode=D03&Indx="+this.jumunBdIndex, "jumunBDV", dom);
					jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.
				}
				
			}
			
			break;
		case "JumunBDList":

			//검색어가 있는 경우 페이지 열릴때 자동 검색되게 한다.
			if(this.jumunBdFtxt){
				document.getElementById("findJBDList").value = this.jumunBdFtxt;
			}
			this.jumunBdFindGet();
			
			
			
			
			break;
		case "JumunBDView":
			
			this.fileDownDir = "nowField";
			
			
			this.jumunBasDui = 1;   //내용을 보여줄 목적으로 연다고 표시한다.
			
			//주문상세내역을 가져온다.
			var jbd = new GetServer();
			var dom = document.querySelector(".jumunBDVTB");
			jbd.initParam("nowFieldPro.php", "mode=D03&Indx="+this.jumunBdIndex, "jumunBDV", dom);
			jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.

			appBasInfo.imsiDet = "";
			appBasInfo.imsiDap = "";
			
			//댓글을 가져온다.
			jbd.jmDetTextList(this.mem);   //주문게시판의 댓글을 출력한다.

			
			break;
		case "Login":
						
				//자동로그인 체크 박스를 설정한다.
				this.mem.dispAutoLogin();
				
				document.getElementById("logpass").value = "";
				
				//회원의 아이디를 미리 표시한다.
				if(this.mem.memid && this.mem.memid != "0") document.getElementById("logid").value = this.mem.memid;

			
			break;
		case "Join":

			//자동으로 가져오는 정보 ------------------
			var devTel = window.sessionStorage.getItem("phoneno");
			var devTelDash = devTel.substr(0,3)+"-"+devTel.substr(3,4)+"-"+devTel.substr(7,4);
			var t = devTelDash.split("-");
			//-------------------------------------
			
			var $tt = $("div.noFindTitle table td.tit div.big");
			
			document.getElementById("oldPass").value = "";
			document.getElementById("goPass1").value = "";
			document.getElementById("goPass2").value = "";
			
			
			if(this.leftMenuTextAll == "회원가입"){
				/*
				document.getElementById("newPassWd").style.display = "block";   //
				document.getElementById("editPassWd").style.display = "none";
				
				
				$tt.html("회원가입");
				
				//document.getElementById("newPassWd").style.display = "none";
				
				$("a#reCheck").css({"display":"block"});
				document.getElementById("email1").disabled = false;
				document.getElementById("email2").disabled = false;
				document.getElementById("email1").style.backgroundColor = "#fff";
				document.getElementById("email2").style.backgroundColor = "#fff";
				document.getElementById("email1").style.color = "#000";
				document.getElementById("email2").style.color = "#000";
				
				document.getElementById("email1").value = "";
				document.getElementById("email2").value = "naver.com";
				document.getElementById("name").value = "";
				
				
				document.getElementById("tel1").value = t[0];
				document.getElementById("tel2").value = t[1];
				document.getElementById("tel3").value = t[2];
				
				document.getElementById("joinBtnGab").src = "./images/bt_join.png";
				*/
			}else{
				$tt.html("회원정보 수정");
				
				document.getElementById("newPassWd").style.display = "none";
				document.getElementById("editPassWd").style.display = "block";
				
				
				
				//기존의 전화번호------------------
				/*
				var getTel = this.mem.tel;
				var t2;
				if(getTel != devTelDash && (getTel != "0" && getTel != "" && getTel)){				
					t2 = getTel.split("-");
				}else{
					t2 = getTel.split("-");
				*/
				//-------------------------------------
				
				//document.getElementById("newPassWd").style.display = "block";
				
				
				$("a#reCheck").css({"display":"none"});
				document.getElementById("memid").disabled = true;
				//document.getElementById("email2").disabled = true;
				document.getElementById("memid").style.backgroundColor = "#ccc";
				//document.getElementById("email2").style.backgroundColor = "#ccc";
				document.getElementById("memid").style.color = "#fff";
				//document.getElementById("email2").style.color = "#fff";
				
				
				document.getElementById("joinBtnGab").src = "./images/bt_modify.png";
				
				//var e = this.mem.memid.split("@");
				document.getElementById("memid").value = this.mem.memid;
				/*
				if(e[1]){
					document.getElementById("email2").value = e[1];
				}else{
					document.getElementById("email2").value = "0";
				}
				*/
				this.mem.idGoOkId = this.mem.memid;
				
				
				document.getElementById("tel1").value = t[0];
				document.getElementById("tel2").value = t[1];
				document.getElementById("tel3").value = t[2];
				
				
				//회원정보를 수정한다.
				document.getElementById("name").value = this.mem.memName;
				

				
			}
			

			
			break;
		case "ContentSS2":   //컨텐츠 상세보기 
			
			//상세보기에서 지도의 토글 처리를 위한 변수 
			mapObjSS.ssMapDisp = false;
			
			
			this.fileDownDir = "nowField";
			
			
			this.contBasDui = 1;
			
			//제품의 상세정보를 출력한다.
			//상품의 등록자는 UserA 이다.
			var jbd = new GetServer();
			jbd.initParam("nowFieldPro.php", "mode=C01&Indx="+this.nowJmIndx, "ContentSS", "mu");
			jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.
			
			//이미지를 가져온다.
			//이미지의 등록자는 UserA 이다.
			jbd.initParam("nowFieldPro.php", "mode=C02&Indx="+this.nowJmIndx, "ContentSSImg", "mu");
			jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.
			
			appBasInfo.imsiDet = "";
			appBasInfo.imsiDap = "";
			
			//컨텐츠 댓글을 가져온다.
			jbd.ctDetTextList(this.mem);
			
			
			break;
		case "ContentOnPut":  //컨텐츠 등록
					
			
			
			if(!this.mem.loginStat){
				this.leftMenuTextAll = "로그인";
				appUtil.moveOkHistory("index.html#Login");
			}else{
				//
				document.getElementById("contentOnName").innerHTML = this.mem.tel+"("+this.mem.memName+")";
				document.getElementById("UserA").value = this.mem.UserA;
				

				//제품분류 설정
				var jp = document.getElementById("TypeA");
				jp.innerHTML = "";
				var len = this.leftMnuCode.length;

				var ali = document.createElement("option");
				var txt = document.createTextNode("선택");
				ali.appendChild(txt);
				ali.setAttribute("value", "0");
				jp.appendChild(ali);
				for(var c = 1; c < len; c++){
					ali = document.createElement("option");
					txt = document.createTextNode(this.leftMnuTxt[c]);
					ali.appendChild(txt);
					ali.setAttribute("value", this.leftMnuCode[c]);
					jp.appendChild(ali);
				}
				var myse1 = $("select#TypeA").val(0).attr("selected", "selected");
				myse1.selectmenu("refresh");
				
				
				
				
				var uj = document.getElementById("TypeB");
				uj.innerHTML = "";
				len = this.leftUpjCode.length;
				
				var ali = document.createElement("option");
				var txt = document.createTextNode("선택");
				ali.appendChild(txt);
				ali.setAttribute("value", "0");
				uj.appendChild(ali);
				for(var c = 1; c < len; c++){
					ali = document.createElement("option");
					txt = document.createTextNode(this.leftUpjTxt[c]);
					ali.appendChild(txt);
					ali.setAttribute("value", this.leftUpjCode[c]);
					uj.appendChild(ali);
				}
				var myse2 = $("select#TypeB").val(0).attr("selected", "selected");
				myse2.selectmenu("refresh");
				

				if(this.contBasDui == 2){
					document.getElementById("onBtnInf").src = "./images/bt_modify.png";
					
					//수정모드인 경우 값을 가져온다.
					//제품의 상세정보를 출력한다.
					var jbd = new GetServer();
					jbd.initParam("nowFieldPro.php", "mode=C01&Indx="+this.nowJmIndx, "ContentSS", "mu");
					jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.
					
					//이미지를 가져온다.
					//var jbd2 = new GetServer();
					///*
					jbd.initParam("nowFieldPro.php", "mode=C02&Indx="+this.nowJmIndx, "ContentSSImg", "mu");
					jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.
					//*/
					
					if(this.nowSumCount > 5){
						for(var c = 6; c <= this.nowSumCount; c++){
							document.getElementById("sumc"+c).style.display = "block";
						}
					}
					
					
				}else{
					document.getElementById("onBtnInf").src = "./images/bt_write.png";
					this.nowSumCount = 5;
					
					//이미지 등록을 초기화 한다.
					for(var c=(this.nowSumCount + 1); c < 11; c++){
						document.getElementById("sumc"+c).style.display = "none";
					}

				}
				
				
			}
			
			break;
		}
		
		

	},
	pageShow:function(){
		

		
		if(!AWtrans.mobileInf){
			   $("div").scroll(function(){
			        appUtil.setPageH();
			    });
		}else{
			 appUtil.setBasPageH();	
		}

		
		
		switch(this.nowPage){
		case "MejangList":


			
			this.meJangFindGet();
			
			
			mapObjList.map = null;  //지도를 초기화 한다.


			break;
		case "ContentSS2":
			mapObjSS.map = null;
			
			setTimeout(function(){
				//alert(parCo.latPo+"/"+parCo.langPo+"/"+parCo.sangho);
				mapObjSS.dispMap(parCo.latPo, parCo.langPo, parCo.sangho);				
			},1200);
				
			break;
		case "CoSangse":   //업체이 상세정볼르 가져온다.

			
			var gomod = "mode=E02&CeDept="+parCo.listIndx;
			
			//컨텐츠의 리스트를 가져온다.
			var alb = new GetServer();
			//선한메뉴의 컨텐츠를 가져온다.
			//var dom = document.querySelector(".allMJList");
			alb.initParam("nowFieldPro.php", gomod, "meJangSsDisp", "mu");
			alb.getPostMode(alb, this.mem);  //서버에서 post 모드로 가져온다.
			
			mapObj.map = null;
			//지도를 표시한다.
			mapObj.dispMap(parCo.latPo, parCo.langPo, parCo.sangho);
			
			
			break;
		case "ImageView":
			
			this.fileDownDir = "DCIM";
			
			$(".loadingImg").css({"margin":"180px 0 0"});
			
			
			//화면 넓이 보다 작은 경우
			imgResize.chW = appBasInfo.screenW;
			imgResize.scrW = appBasInfo.screenW;
			imgResize.scrH = appBasInfo.screenH;
			
			var imsi = ((imgResize.scrH - (imgResize.scrH /2)) / 2);
			
			imgResize.topRat = 0.5;
			imgResize.topM = imsi;
			imgResize.bottomM = imsi;

			imgResize.leftRat = 0.5;
			imgResize.rightM = 0;
			imgResize.leftM = 0;
			//==============================================
			
			
			//초기화 한다.
			imgResize.init("ImageViewDiv", "ImageViewImg", this.nowViewImgLink);
			
			//중심에 이미지 출력
			imgResize.imgSetCenter();
			
			//플러그인 초기설정
			imgResize.HammerInit();
			
			//핀치와 이동을 처리한다.
			imgResize.HammerProcess();


			
			break;
		case "ContentOnPut":  //컨텐츠 등록
			
			
			$(document).on("scroll", function (){
				appBasInfo.topHeight = $(document).scrollTop();
				
				//console.log("ccccccssssssss"+appBasInfo.topHeight);
				
				$(".loadingImg").css({"margin":(appBasInfo.topHeight+100)+"px 0 15px"});
				
			});
			
			break;
			
		}

		
	},
	
	calkMarin:function(sumGab){
		
		
		
		
	},
	
	pageHide:function(){
		
		
		
		switch(this.nowPage){
		case "page":

			
			break;
		}	
		
	},
	pageCreate:function(){
		
		

		
	},
	
	//엑셀에서 출력한다.
	toExcel:function(coid){
		
		meminf.seFindVal = document.getElementById("dsFindTxt").value;
		meminf.seFindMd = document.getElementById("selectMdds").value;
	
		//alert(meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
	
		location.href = CIBASE+"/scene/hjang/toExcel/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
	
	},
	
	//대상자를 삭제 한다.
	delDesang:function(md, md2, coid, md4){
	
		if(confirm("대상자관련한 상담, 공사등 모든 자료가 삭제 됩니다. 정말로 삭제 할까요?")){
			
			location.href = CIBASE+"/scene/hjang/delDesang/"+md+"/"+md2+"/"+coid+"/"+md4;
		}
	
	},
	
	//사업을 삭제 한다.
	delSaup:function(md, md2, coid, md4){
	
		if(confirm("정말로 삭제 할까요? 삭제시 관련 모든 자료가 삭제 되며 복구 불가능 합니다.")){
			
			location.href = CIBASE+"/scene/hjang/delSaup/"+md+"/"+md2+"/"+coid+"/"+md4;
		}
	
	},
	
	
	
	delGongsa:function(md, gid, coid){
	
		if(confirm("정말로 삭제 할까요?")){
			
			location.href = CIBASE+"/scene/hjang/delGongsa/"+md+"/"+gid+"/"+coid;
		}
	
	},
	
	
	delSc:function(md, did){
	
		if(confirm("정말로 삭제 할까요?")){
			
			location.href = CIBASE+"/schedule/schedule/delEvent/"+md+"/"+did;
			
			appUtil.alertgo("알림","정상적으로 삭제되었습니다.");
		}
	
	},
	
	
	
	delDet:function(did, md, md2, id){
	
		if(confirm("정말로 삭제 할까요?")){
			
			location.href = CIBASE+"/community/community/delDet/"+did+"/"+md+"/"+md2+"/"+id;

		}
	

	
	},
	
	delGongji:function(md, md2, did){
		
		if(confirm("정말로 삭제 할까요?")){
			
			location.href = CIBASE+"/community/community/delEvent/"+md+"/"+md2+"/"+did;

		}
	
		
	},
	
	
	//공지사항 댓글 등록
	onputDet:function(gid, md, md2){
		
		var tg = document.getElementById("detTxt");
		//alert(gid+"/"+tg.value);
		
		if(!tg.value){
			appUtil.alertgo("알림","댓글을 입력하세요.");
			tg.focus();
			return;
		}
		
		var qr = CIBASE+"/community/community/onputDet";
		//alert(qr+"----"+CIHS+"/"+md+"/"+tg.value+"/"+gid);
		$.ajax({type:"POST", data:{gid:gid, ci_t:CIHS, md:md, det:tg.value}, url:qr, timeout:10000, dataType:"json",success:function(data){
			
			//alert(data);
			
			if(data.rs == "ok") location.href = CIBASE+"/community/community/getView/"+md+"/"+md2+"/3/"+gid;
			
			
		},error:function(xhr,status,error){
			//alert("err3="+error);
		}
		});
	
	},


	delFileGo:function(gubun, md, md2, md3, id, num){
	
		var obj = this;
	
		switch(gubun){
		case "banner":
		case "gongsa":
		case "saup":
		case "community":
		case "photoon":
			//alert(gubun+"/"+id+"/"+md3); //common/ajaxc/fileDel/".$rows->filename2."/".$rows->id."'
			
			if(confirm("정말로 삭제 할까요?")){
				
				var qr = CIBASE+"/common/ajaxc/fileDel";
				//alert(qr);
				$.ajax({type:"POST", data:{recid:id, ci_t:CIHS, gubun:gubun, md:md, md2:md2, md3:md3, num:num}, url:qr, timeout:10000, dataType:"json",success:function(data){
					
					//alert(data.rs);
					if(data.rs > 0){
						//appUtil.alertgo("알림","삭제완료 하였습니다.");
						
						if(gubun == "banner"){
							//alert(data.rs);
							location.href = CIBASE+"/control/control/getView/"+md+"/"+md2+"/"+md3;
							
						}else if(gubun != "photoon"){
							//첨부된 파일의 리스트를 가져와서 뿌려준다.
							obj.getAddFileList(gubun, md, md2, id, num);
						}else{
							document.getElementById("fileTd1").innerHTML = "없음";
							$("#file1").removeAttr("disabled");
							$("#imginf").val("nn");
						
						}

					}
					
				},error:function(xhr,status,error){
					//alert("qr="+qr+"||err3="+error);
				}
				});	
	
			}
			
		break;
		}
	
	},
	
	//현재 첨부된 파일의 리스트를 가져와서 뿌려준다.
	getAddFileList:function(gubun, md, md2, id, num){
	

				var qr = CIBASE+"/common/ajaxc/getAddFile";
				//alert(qr+"----"+CIHS+"/"+md+"/"+md2+"/"+meminf.md3+"/"+id+"/"+num+"/"+meminf.md4+"/"+main); 
				
				var tid = 0;
				if(md == 2 && md2 == 7) tid = meminf.md3;  //공사의 글 아이디 값을 지정
				else tid = meminf.md4;
				
				if(gubun == "community") tid = meminf.md3;
				
				
				$.ajax({type:"POST", data:{recid:id, ci_t:CIHS, gubun:gubun, md:md, md2:md2, txtid:tid, num:num}, url:qr, timeout:10000, dataType:"text",success:function(data){
					
					document.getElementById("allAddFile").innerHTML = data;
					
				},error:function(xhr,status,error){
					//alert("err3="+error);
				}
				});	
	

	
	},


	
	//메인페이지에서검색하여 상품을 가져온다.
	pageContentGet:function(){
			
		var gomod = "mode="+this.firstMode+"&TypeA="+this.leftMenuCode+"&EmpHandeul="+this.mem.memEmp;
		if(document.getElementById("findPage").value){
			
			appBasInfo.leftMenuGubun = "jp";
			appBasInfo.leftMenuDeText = "제품검색";
			appBasInfo.leftMenuText = document.getElementById("findPage").value;
			appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
			
			insertLeftMenu.pageMenuInitDisp();  //선택경로 표시 
			
			gomod = "mode=B03&Keyword="+escape(document.getElementById("findPage").value)+"&EmpHandeul="+this.mem.memEmp;
		}
		
		//컨텐츠의 리스트를 가져온다.
		var alb2 = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		var dom = document.querySelector("#pageAlbum");
		alb2.initParam("nowFieldPro.php", gomod, "contentList", dom);
		alb2.getPostMode(alb2, this.mem);  //서버에서 post 모드로 가져온다.
		
	},
	
	
	//메인페이지에서검색하여 블로그에 등록한다.
	pageContentGetOnBlog:function(){
		
		var gomod = ""; //"mode="+this.firstMode+"&TypeA="+this.leftMenuCode+"&EmpHandeul="+this.mem.memEmp;
		if(appBasInfo.blogFindTxt){
			gomod = "mode=B03&Keyword="+escape(appBasInfo.blogFindTxt)+"&EmpHandeul="+this.mem.memEmp;
			//alert("go find="+gomod);
			appBasInfo.blogFindTxt = "";
		}
		
		//검색하여 직전에 등록한 상품을 가져오고 그것을 블로그에 등록한다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector("#pageAlbum");
		alb.initParam("nowFieldPro.php", gomod, "contentListOnBlog", "mu");
		alb.getPostMode(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
	},
	
	
	//주문게시판의 리스트를 가져온다.
	jumunBdFindGet:function(){
		
		var gomod = "mode=D01";
		if(document.getElementById("findJBDList").value){
			this.jumunBdFtxt = escape(document.getElementById("findJBDList").value);
			gomod = "mode=D02&Keyword="+escape(document.getElementById("findJBDList").value);
		}else{
			this.jumunBdFtxt = null;
		}
		
		//컨텐츠의 리스트를 가져온다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		var dom = document.querySelector(".allBdList");
		alb.initParam("nowFieldPro.php", gomod, "allBdList", dom);
		alb.getPostMode(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
	}, 
	
	//매장리스트를 리스트를 가져온다.
	meJangFindGet:function(){
		
		var gomod = "mode=E01";
		
		//컨텐츠의 리스트를 가져온다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		var dom = document.querySelector(".allMJList");
		alb.initParam("nowFieldPro.php", gomod, "meJangList", dom);
		alb.getPostMode(alb, this.mem);  //서버에서 post 모드로 가져온다.
		

	}, 
	
		
	//제품 삭제
	contDelPro:function(){
		
		var mm = this.mem;
		
		if(AWtrans.mobileInf){  //모바일 모드
			navigator.notification.confirm('삭제하시겠습니까?', function(button){
				if(button == 2){   //삭제한다.
			
		    		//컨텐츠의 리스트를 가져온다.
		    		var alb = new GetServer();
		    		//선한메뉴의 컨텐츠를 가져온다.
		    		//var dom = document.querySelector(".allAlbum3");
		    		var ss = "mode=R02&Indx="+appBasInfo.nowJmIndx;
		    		alb.initParam("QueryB.asp", ss, "ctDelete", "mu");
		    		alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.
					
				} 
	    	}, '질문', '취소,삭제');
		}else{
			if(confirm('삭제하시겠습니까?')){
			
		    		//컨텐츠의 리스트를 가져온다.
		    		var alb = new GetServer();
		    		//선한메뉴의 컨텐츠를 가져온다.
		    		//var dom = document.querySelector(".allAlbum3");
		    		var ss = "mode=R02&Indx="+appBasInfo.nowJmIndx;
		    		alb.initParam("QueryB.asp", ss, "ctDelete", "mu");
		    		alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.

	    	}
		}

		
	},
	
	//컨텐츠 수정 모드로 호츨 한다.
	contEditPro:function(){
		this.contBasDui = 2;
		appUtil.moveOkHistory("contentOnPut.html");
		
	},
	
	//주문게시판을 수정하기위해 호출 한다.
	jumunBDEdit:function(){
		
		this.jumunBasDui = 2;
		appUtil.moveOkHistory("jumunBDOn.html");
		
	},
	
	//주문게시판 삭제
	jmDelPro:function(){
		
		var mm = this.mem;
		
		if(AWtrans.mobileInf){  //모바일 모드
			navigator.notification.confirm('삭제하시겠습니까?', function(button){
				if(button == 2){   //삭제한다.
			
		    		//컨텐츠의 리스트를 가져온다.
		    		var alb = new GetServer();
		    		//선한메뉴의 컨텐츠를 가져온다.
		    		//var dom = document.querySelector(".allAlbum3");
		    		var ss = "mode=S03&Indx="+appBasInfo.jumunBdIndex;
		    		alb.initParam("QueryB.asp", ss, "jumunDelete", "mu");
		    		alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.
					
				} 
	    	}, '질문', '취소,삭제');
		}else{
			if(confirm('삭제하시겠습니까?')){
			
		    		//컨텐츠의 리스트를 가져온다.
		    		var alb = new GetServer();
		    		//선한메뉴의 컨텐츠를 가져온다.
		    		//var dom = document.querySelector(".allAlbum3");
		    		var ss = "mode=S03&Indx="+appBasInfo.jumunBdIndex;
		    		alb.initParam("QueryB.asp", ss, "jumunDelete", "mu");
		    		alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.

	    	}
		}

		
	},
	
	jumunBDONGo:function(){
		
			var frm = $("#FmCont2")[0];
			//alert("tit="+frm.Title.value+"/ User="+frm.UserB.value+"/"+this.mem.UserA+"/ Dui="+frm.Dui.value);
			//return;
			
			
			if(!frm.Title.value){
				appUtil.alertgo("알림","제목을 입력하세요.");
				frm.Title.focus();
				return;
			}
			
			
			if(!frm.Cont.value){
				appUtil.alertgo("알림","내용을 입력하세요.");
				frm.Cont.focus();
				return;
			}
			
			
			
				frm.Dui.value = this.jumunBasDui;
				frm.UserA.value = this.mem.UserA;
				frm.UserB.value = escape(this.mem.memName);
				frm.UserC.value = escape(this.mem.tel);			
			
				
				
			frm.Title.value = escape(frm.Title.value);
			frm.Cont.value = escape(frm.Cont.value);
			
			//alert("userD="+frm.UserD.value);
			

			var formData = new FormData(frm);
			$.ajax({url:LK+'QueryD.asp', processData: false, contentType:false, data:formData, type:'POST', success:function(data){
				
				appUtil.moveOkHistory("index.html#JumunBDList");
				
				
			}, error:function(xhr,status,error){
				//appUtil.hidePgLoading();
				if(appBasInfo.jumunBasDui == 3){
					appUtil.alertgo("알림","삭제 실패하였습니다. 다시 시도하세요."+error);
				}else{
					appUtil.alertgo("알림","등록 실패하였습니다. 다시 시도하세요."); //+error);
				}
				

			}});
			
			

		
	},
	

	
	//주문게시판에 댓글을 수정한다.
	jumunDabEdt:function(seq, daps, txt){
		this.jumunDetSeq = seq;     //주문댓글 시킨스
		this.jumunDapSeq = 0; //daps;   //주문답글 시킨스
		
		//편집용 창을 가져온다.
		var aa = document.getElementById("jumunDabPo"+seq);
		var bb = document.getElementById("jumunDap");
		bb.style.display = "block";
		aa.appendChild(bb);
		
		this.jumunDui = 2;
		
		$("#jmDapCont").val(txt);
		$("#jmwrBtnSpan").html("댓글수정");
		
	},
	
	jumunDetDel:function(seq, daps){
		
		var mm = this.mem;

		if(AWtrans.mobileInf){  //모바일 모드
			navigator.notification.confirm('삭제하시겠습니까?', function(button){
				if(button == 2){   //삭제한다.
				
					appBasInfo.jumunDetSeq = seq;     //주문댓글 시킨스
					appBasInfo.jumunDapSeq = 0; //daps;   //주문답글 시킨스
					
					appBasInfo.jumunDui = 3;
	
					//주문게시판에 댓글을 등록한다.
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=S02&Dui=3&Fndx="+appBasInfo.jumunBdIndex+"&UserA="+escape(mm.UserA)+"&UserB="+escape(mm.memName)+"&UserC="+escape(mm.tel)+"&Cont=del&Seq="+seq+"&SeqAns=0";
					alb.initParam("QueryB.asp", ss, "ContentJMDetOn", "mu");
					alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.	
					
				} 
	    	}, '질문', '취소,삭제');
		}else{
			if(confirm('삭제하시겠습니까?')){
			
					appBasInfo.jumunDetSeq = seq;     //주문댓글 시킨스
					appBasInfo.jumunDapSeq = 0; //daps;   //주문답글 시킨스
					
					appBasInfo.jumunDui = 3;
	
					//주문게시판에 댓글을 등록한다.
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=S02&Dui=3&Fndx="+appBasInfo.jumunBdIndex+"&UserA="+escape(mm.UserA)+"&UserB="+escape(mm.memName)+"&UserC="+mm.tel+"&Cont=del&Seq="+seq+"&SeqAns=0";
					alb.initParam("QueryB.asp", ss, "ContentJMDetOn", "mu");
					alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.	

	    	}
		}


		
		
	},
	
	//주문게시판에 답글을 등록한다.
	jumunDabOn:function(seq, daps, jumunWr){
		this.jumunDetSeq = 0; //seq;     //주문댓글 시킨스
		this.jumunDapSeq = seq;   //주문답글 시킨스
		
		//푸시를 발사한다.
		//필요한 정보 글번호(this.jumunBdIndex), 댓글작성자(this.mem.UserA), 수신자(댓글 또는 답글 작성자) (jumunWr);		
		
		this.pushIndx = this.jumunBdIndex;
		this.pushFrom = this.mem.UserA;
		this.pushTo = jumunWr;
		this.pushFName = this.mem.memName;
		this.pushMd = "jumun";
			
			
		
		this.jumunDui = 1;
		
		var aa = document.getElementById("jumunDabPo"+seq);
		var bb = document.getElementById("jumunDap");
		bb.style.display = "block";
		aa.appendChild(bb);
		
		$("#jmDapCont").val('');
		$("#jmwrBtnSpan").html("답글등록");
		
	},
	

	//주문게시판에 답글을 등록한다.
	jmDapOnput:function(){
		
		var aa = $("#jmDapCont").val();
		if(!aa){
			appUtil.alertgo("알림","답글을 입력하세요.");
			return;
		}
		
		var bb = document.getElementById("jumunDap");
		bb.style.display = "none";
		var bbb = document.getElementById("JumunBDView");
		bbb.appendChild(bb);
		
		
		
		//주문게시판에 댓글을 등록한다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=S02&Dui="+this.jumunDui+"&Fndx="+this.jumunBdIndex+"&UserA="+this.mem.UserA+"&UserB="+escape(this.mem.memName)+"&UserC="+this.mem.tel+"&Cont="+escape(aa)+"&Seq="+this.jumunDetSeq+"&SeqAns="+this.jumunDapSeq;
		//alert(ss);
		alb.initParam("QueryB.asp", ss, "ContentJMDetOn", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
		
		//푸시를 발사한다.
		if(this.jumunDui == 1) this.pushSend(aa, "dap");
		
	},
	
	//주문게시판에 댓글을 등록한다.
	jmDetOnput:function(){
		
		this.jumunDetSeq = 0;     //주문댓글 시킨스
		this.jumunDapSeq = 0;   //주문답글 시킨스
		
		//푸시를 발사한다.
		//필요한 정보 글번호(this.jumunBdIndex), 댓글작성자(this.mem.UserA), 수신자(댓글 또는 답글 작성자) (this.jumunWr);	
		this.pushIndx = this.jumunBdIndex;
		this.pushFrom = this.mem.UserA;
		this.pushTo = this.mem.jumunWr;
		this.pushFName = this.mem.memName;
		this.pushMd = "jumun";
		
		
		
		var aa = $("#jmDetCont").val();
		if(!aa){
			appUtil.alertgo("알림","댓글을 입력하세요.");
			return;
		}
		
		//주문게시판에 댓글을 등록한다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=S02&Dui=1&Fndx="+this.jumunBdIndex+"&UserA="+escape(this.mem.UserA)+"&UserB="+escape(this.mem.memName)+"&UserC="+escape(this.mem.tel)+"&Cont="+escape(aa)+"&Seq="+this.jumunDetSeq+"&SeqAns="+this.jumunDapSeq;
		//alert(ss);
		alb.initParam("QueryB.asp", ss, "ContentJMDetOn", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
		
		//푸시를 발사한다.
		if(this.jumunDui == 1) this.pushSend(aa, "det");
		
	},
	
	ctDabEdt:function(seq, daps, txt){
		this.contDetSeq = seq;     //컨텐츠 댓글 시킨스 
		this.contDapSeq = 0; //daps;     //컨텐츠 답글 시킨스
		
		var aa = document.getElementById("ctDabPo"+seq);
		var bb = document.getElementById("contentDap");
		bb.style.display = "block";
		aa.appendChild(bb);
		
		this.contDui = 2;
		
		$("#ctDapCont").val(txt);
		$("#ctwrBtnSpan").html("댓글수정");		
		
	},
	
	ctDetDel:function(seq, daps){
	
		var mm = this.mem;
		
		if(AWtrans.mobileInf){  //모바일 모드
			navigator.notification.confirm('삭제하시겠습니까?', function(button){
				if(button == 2){   //삭제한다.
			
					appBasInfo.contDetSeq = seq;     //컨텐츠 댓글 시킨스 
					appBasInfo.contDapSeq = 0; //daps;     //컨텐츠 답글 시킨스
	
					appBasInfo.contDui = 3;
					
					//컨텐츠의 리스트를 가져온다.
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=R03&Dui=3&Fndx="+appBasInfo.nowJmIndx+"&UserA="+escape(mm.UserA)+"&UserB="+escape(mm.memName)+"&UserC="+mm.tel+"&Cont=del&Seq="+seq+"&SeqAns=0";
					alb.initParam("QueryB.asp", ss, "ContentSSDetOn", "mu");
					alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.
					
				} 
	    	}, '질문', '취소,삭제');
		}else{
			if(confirm('삭제하시겠습니까?')){
			
					appBasInfo.contDetSeq = seq;     //컨텐츠 댓글 시킨스 
					appBasInfo.contDapSeq = 0; //daps;     //컨텐츠 답글 시킨스
	
					appBasInfo.contDui = 3;
					
					//컨텐츠의 리스트를 가져온다.
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=R03&Dui=3&Fndx="+appBasInfo.nowJmIndx+"&UserA="+escape(mm.UserA)+"&UserB="+escape(mm.memName)+"&UserC="+mm.tel+"&Cont=del&Seq="+seq+"&SeqAns=0";
					alb.initParam("QueryB.asp", ss, "ContentSSDetOn", "mu");
					alb.getPostModeTxt(alb, mm);  //서버에서 post 모드로 가져온다.

	    	}
		}

		
		
					
	},
	
	ctDabOn:function(seq, daps, dabWr){
		this.contDetSeq = 0; //seq;     //컨텐츠 댓글 시킨스 
		this.contDapSeq = seq;     //컨텐츠 답글 시킨스
		
		//푸시를 발사한다.
		//필요한 정보 글번호(this.nowJmIndx), 댓글작성자(this.mem.UserA), 수신자(댓글 또는 답글 작성자) (dabWr);
		this.pushIndx = this.nowJmIndx;
		this.pushFrom = this.mem.UserA;
		this.pushTo = dabWr;
		this.pushFName = this.mem.memName;
		this.pushMd = "ct";
		
		
		var aa = document.getElementById("ctDabPo"+seq);
		var bb = document.getElementById("contentDap");
		bb.style.display = "block";
		aa.appendChild(bb);
		
		this.contDui = 1;
		
		$("#ctDapCont").val('');
		$("#ctwrBtnSpan").html("답글등록");		
		
		
	},
	
	//컨텐츠 보기에 댓글 등록
	ssDetOnput:function(){
		
		//푸시를 발사한다.
		//필요한 정보 글번호(this.nowJmIndx), 댓글작성자(this.mem.UserA), 수신자(댓글 또는 답글 작성자) (this.contWr);
		this.pushIndx = this.nowJmIndx;
		this.pushFrom = this.mem.UserA;
		this.pushTo = this.mem.contWr;
		this.pushFName = this.mem.memName;
		this.pushMd = "ct";
		
		
		
		var aa = $("#ssDetCont").val();
		if(!aa){
			appUtil.alertgo("알림","댓글을 입력하세요.");
			return;
		}
		
		//컨텐츠의 리스트를 가져온다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=R03&Dui=1&Fndx="+this.nowJmIndx+"&UserA="+this.mem.UserA+"&UserB="+escape(this.mem.memName)+"&UserC="+this.mem.tel+"&Cont="+escape(aa)+"&Seq="+this.contDetSeq+"&SeqAns="+this.contDapSeq;
		alb.initParam("QueryB.asp", ss, "ContentSSDetOn", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
		
		//푸시를 발사한다.
		if(this.contDui == 1) this.pushSend(aa, "det");
		

	},
	
	//컨텐츠에 답글을 등록한다.
	ctDapOnput:function(){
		
		var aa = $("#ctDapCont").val();
		if(!aa){
			appUtil.alertgo("알림","답글을 입력하세요.");
			return;
		}
		
		//답글 입력 부분을 페이지의 밑으로 돌려 보낸다.
		var bb = document.getElementById("contentDap");
		bb.style.display = "none";
		var bbb = document.getElementById("ContentSS");
		bbb.appendChild(bb);
		
		
		//contDetSeq:0,     //컨텐츠 댓글 시킨스 
		//contDapSeq:0,     //컨텐츠 답글 시킨스
		
		//컨텐츠의 리스트를 가져온다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=R03&Dui="+this.contDui+"&Fndx="+this.nowJmIndx+"&UserA="+this.mem.UserA+"&UserB="+escape(this.mem.memName)+"&UserC="+this.mem.tel+"&Cont="+escape(aa)+"&Seq="+this.contDetSeq+"&SeqAns="+this.contDapSeq;
		//alert(ss);
		alb.initParam("QueryB.asp", ss, "ContentSSDetOn", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
		//푸시를 발사한다.
		if(this.contDui == 1) this.pushSend(aa, "dap");
		
	}, 
	
	//댓글과 답글에 대하여 푸시발송
	pushSend:function(txt, md){
		
		/*
		this.pushIndx = this.nowJmIndx;
		this.pushFrom = this.mem.UserA;
		this.pushTo = this.mem.contWr;
		this.pushFName = this.mem.memName;
		this.pushMd = "ct"     "jumun";
		*/
		
		//컨텐츠의 리스트를 가져온다.
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mo="+md+"&ctjmMd="+this.pushMd+"&txtNum="+this.pushIndx+"&from="+this.pushFrom+"&to="+this.pushTo+"&fnam="+this.pushFName+"&txt="+txt;
		//alert(ss);
		alb.initParamPush("allphpfile/hddPushSend.php", appUtil.input_smstext(ss, 0), "pushSendDabGo", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.		
		

	},
	

	
	addImage:function(){
		if(this.nowSumCount < 10) this.nowSumCount++;
		
		document.getElementById("sumc"+this.nowSumCount).style.display = "block";
		
	},
	
	delSeqImg:function(seq, sort){
		this.nowImgSort = sort;
		this.nowImgSeq = seq;
		
		var nowSq = this.nowImgSeq;
		
		
		if(AWtrans.mobileInf){  //모바일 모드
			navigator.notification.confirm('이미지를 삭제하시겠습니까?', function(button){
				if(button == 2){   //삭제한다.
				
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=R05&Seq="+nowSq;
					alb.initParam("QueryB.asp", ss, "deleteSeImg", "mu");
					alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
					
				} 
	    	}, '이미지 삭제', '취소,삭제');
		}else{
			if(confirm('이미지를 삭제하시겠습니까?')){
			
					var alb = new GetServer();
					//선한메뉴의 컨텐츠를 가져온다.
					//var dom = document.querySelector(".allAlbum3");
					var ss = "mode=R05&Seq="+nowSq;
					alb.initParam("QueryB.asp", ss, "deleteSeImg", "mu");
					alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.

	    	}
		}
		
		
	},
	
	chnDepyImg:function(){
		//대표이미지 변경 
		

		
	},
	
	upSeqImg:function(seq, sort){
		this.nowImgSort = sort;
		this.nowImgSeq = seq;
		
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=R04&SeqA="+this.nowImgSeq+"&Fndx="+this.nowJmIndx+"&AmgMode=1";
		alb.initParam("QueryB.asp", ss, "imgReSortNow", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
	},
	
	downSeqImg:function(seq, sort){
		this.nowImgSort = sort;
		this.nowImgSeq = seq;
		
		var alb = new GetServer();
		//선한메뉴의 컨텐츠를 가져온다.
		//var dom = document.querySelector(".allAlbum3");
		var ss = "mode=R04&SeqA="+this.nowImgSeq+"&Fndx="+this.nowJmIndx+"&AmgMode=2";
		alb.initParam("QueryB.asp", ss, "imgReSortNow", "mu");
		alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		
		
		
	},
	
	
	//appBasInfo 카테고리를 가져와서 블로그에 등록한다.
	blogOnPro:function(){
		
		if($("#BlogIn").is(":checked")){
			//체크된 상태 이다.
			appBasInfo.blogOnInf = true;
			
			
			//블로그에 등록한다.
			//setTimeout(function(){
				
				/*
				if(appBasInfo.blogOnInf){
					//상품을 블로그에 등록한다.
					appBasInfo.blogOnInf = false;
					
					var gg = new GetServer();
					//내용을 브로그에 등록한다.-test
					
					appBasInfo.blogTitle = "테스트 합니다.";
					appBasInfo.blogCont = "테스트 내용입니다.";
					appBasInfo.blogCate = "세상보기";
					appBasInfo.blogTel = "담당 : 010-1234-1234";
					appBasInfo.blogCoTel = "업종 : 010-1234-1234";
					var ff = "http://hccview.handeul.com/2.%20Knitting%20Balls(8).jpg";
					
					appBasInfo.blogAllImg = ff;
					appBasInfo.blogAllImg += "^^";
					var ff2 = "http://hccview.handeul.com/20160531_104341.jpg";
					
					appBasInfo.blogAllImg += ff2;
					appBasInfo.blogAllImg += "^^";
					
					
					var modegab = "mode=textBlogOn&tit="+appUtil.input_smstext(appBasInfo.blogTitle, 0)+"&cont="+appUtil.input_smstext(appBasInfo.blogCont, 0)+"&cate="+appUtil.input_smstext(appBasInfo.blogCate, 0)+"&tel="+appUtil.input_smstext(appBasInfo.blogTel, 0)+"&cotel="+appUtil.input_smstext(appBasInfo.blogCoTel, 0)+"&img="+appBasInfo.blogAllImg;
					//alert("blog blog="+modegab);
					
					gg.initParamPush("NowFieldPro.php", modegab, "blogWr", "mu");
					gg.getPostMode(gg, this.mem);  //서버에서 post 모드로 가져온다.
					
				}
				*/
								
			//}, 100);
			
		}else{
			//기본값은 블로그에 등록하지 않는다.
			appBasInfo.blogOnInf = false;
		}
		
		
	},
	
	
	
}





//=============================================================================================================


function allLiListSs(indx){
	
	//주문게시판에서 검색어 입력칸을 지우고 보기를 클릭하는 경우 검색어를 초기화 한다.
	var ff = document.getElementById("findJBDList").value;
	appBasInfo.jumunBdFtxt = ff;
	//-----------------------------------------------------
	
	appBasInfo.jumunBdIndex = indx;
	
	appUtil.moveOkHistory("jumunBDView.html");
	
}


//매장의 상세정보를 가져와서 지도와 같이출력한다.mmmmmmmmmmmmmmmmmmmmm
//리스트에서 매장을 선택했을 때 출력한다.
function meJangSs(coindx, indx, lat, lng, sho){

	parCo.sangho = sho;    //dat[indx].sangho;
	parCo.latPo = lat;
	parCo.langPo = lng;	
	parCo.addr = "";
	parCo.listIndx = coindx;
	parCo.coid = coindx;
	
	
	//alert(dat+"/"+indx+"/"+lat+"/"+lng+"/"+sho);
	
	
	if(indx == 9999){  //매장상세보기로 간다.
		
		//업체정보를 설정한다.
		parCo.setCoInfo(coindx);
		//업체 상세 페이지로 간다.
		appUtil.moveOkHistory("coSangse.html");
		
	}else{  //매장리스트에 지도를 표시한다.
		
		//지도를 연다.
		var tg = document.getElementById("mjList"+indx);
		var son = document.getElementById("coMapList0");		
		tg.appendChild(son);
		son.style.display = "block";

		//지도를 표시하고 위치에 마크를 표시한다.
		mapObjList.dispMap(parCo.latPo, parCo.langPo, parCo.sangho);

	}
	
}



//앨범을 상세보기 한다.
var viewAlbumPage = {
		
	
		
	
}





//1차 목록의 리스트를 출력한다.
var music1cha = {
	
	sound : {},
	playList : {},
	arrayTxt : null,
	playAllsu : 0,      //미리듣기 선택한 음원의 총 갯수
	playIndex : 0,      //현재 미리듣기 하는 음원의 인덱스 
	playInf : false,    //현재 음악의 플레이 중인 여부 확인
	nowId : 0,          //가수 리스트의 선택과 해제에 사용.
	oldId : null,       //가수 리스트의 선택과 해제에 사용.
	sdomid : "",
	playid : 0,        //현재 플레이 하는 음원의 아이디값 - 인덱스 제외
	openInf : false,
	
	mDown : function(){
		
		if(this.playInit()){
			//플레이 리스트에 있는 모든 음원을 다운로드 한다.
			for(var c = 0; c < this.playAllsu; c++){
				var uu = this.sound[Number(this.playList[c])];  //파일의 링크를 가져온다.
				//파일을 다운로드 한다.
				getServ.fileDown(uu);
				
			}			
		}
		
	},
	vList : function(domid, data){
		//각 가수별 모든 노래를 가져온다.
		
		for(var c=0; c < data.rs.length; c++){
			var ali = document.createElement("li");
			ali.className = "allMusic";
			var inx = data.rs[c].id;
			ali.setAttribute("id", inx);
			
			
			var txtn = document.createTextNode(appUtil.disp_smstext(data.rs[c].tit,0));
			ali.appendChild(txtn);
			ali.onclick = this.allMusicPlay;  //클릭시 실행하는 함수 
			
			var spanli = document.createElement("span");
			spanli.className = "titMemo";
			
			var txt = document.createTextNode(" - "+appUtil.disp_smstext(data.rs[c].gasu, 0));
			spanli.appendChild(txt);
			ali.appendChild(spanli);
			domid.appendChild(ali);
			
			
			var ali2 = document.createElement("li");
			ali2.setAttribute("id", inx+"li2");
			ali2.className = "basGenLi";
			domid.appendChild(ali2);
			
		}			
		
	},
	sList : function(data){
		//선택한 노래에 대한 모든 MR을 가져와서 출력 한다.
		this.arrayTxt = "";   //선택한 음원이 아이디값 문자열을 초기화 한다.
		
		var sdomid = document.getElementById(this.sdomid+"li2");
		$("#"+this.sdomid+"li2" ).html("");  //이전에 추가된 음원 리스트를 삭제한다.
		
		//ul을 추가 한다.----------------------------
		var ali0 = document.createElement("ul");
		ali0.setAttribute("id", this.sdomid+"ul");
		sdomid.appendChild(ali0);
		//-----------------------------------------
		
		this.sound = new Array();
		
		
		var sdomid2 = document.getElementById(this.sdomid+"ul");
		for(var c=0; c < data.rs.length; c++){
			var ali = document.createElement("li");
			ali.onclick = this.eaMusicPlay;  //클릭시 실행하는 함수 
			
			ali.className = "allTypeMusic";
			var txtn = document.createTextNode("- "+appUtil.disp_smstext(data.rs[c].pfix,0));
			ali.appendChild(txtn);

			
			var sp = document.createElement("span");
			ali.appendChild(sp);
			
			ali.setAttribute("id", data.rs[c].id+"-"+c);
			sdomid2.appendChild(ali);
			
			
			var ss = data.rs[c].dir+data.rs[c].sid+data.rs[c].endfix;
			this.sound[c] = ss;
			
		}
		sdomid2.style.display = "block";
		
		
	},
	playInit : function(){
		
		if(this.arrayTxt == ""){
			this.playAllsu = 0;
			appUtil.alertgo("알림", "가수의 음원을 먼저 선택하세요.");
			return false;
		}
		var aa = this.arrayTxt.split("/");
		this.playAllsu = (aa.length - 1);
		this.playIndex = 0;
		
		this.playList = new Array();
		for(var c=0; c < this.playAllsu; c++){
			var inx = aa[c].split("-");
			this.playid = inx[0];
			this.playList[c] = inx[1];
		}
		
		return true;
		
	},
	play : function(){
		
		//초기화 하고 play list에 곡을 담는다.
		if(this.playInit()){
			this.playIng();
		}
		
	},
	playIng : function(){
		
		this.playInf = true;  //현재 플레이 중 이다.
		var inx = this.playList[this.playIndex];
		
		$("#"+this.playid+"-"+inx+" span").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Play]");
		

		document.getElementById("audioPly").src = MUSIC+music1cha.sound[Number(inx)];
		document.getElementById("audioPly").play();
		
		this.playIndex++;
		
	},
	stop : function(){
	
		
		document.getElementById("audioPly").src = " ";
		document.getElementById("audioPly").play();

		document.getElementById("audioPly").pause();
		//this.playIndex = 0;
		this.playInf = false;  //현재 플레이 중이 아니다.
		
	},
	audioend : function(){
		//음악을 끝까지 들어면 먼저 실행되고 다음에 stoped 실행됨
		//alert("end / all="+this.playAllsu+"/ inx="+this.playIndex);
		
		//다음음악을 플레이 한다.
		if(this.playIndex < this.playAllsu){
			this.playIng();
		}else{
			
			this.stop();

			appUtil.alertgo("알림", "선택한 모든 음악의 미리듣기를 마쳤습니다.");
		}
		
	},
	stoped : function(){
		//새로운 가수 선택하여 음악 초기화, 중간에 종료시 실행 - 음악이 종료되면 무조건 실행
		//alert("stoped");
		
		this.playInf = false;  //현재 플레이 중이 아니다.
		
		var aa = (this.playIndex - 1);
		if(aa < 0) aa = 0;
		
		var inx = this.playList[aa];
		if(this.playid != "" || this.playid > 0) $("#"+this.playid+"-"+inx+" span").html("");
		
		
		
	},
	eaMusicPlay : function(){
		//각각의 음원을 play() 한다.
		//동적으로 클릭하면 실행되는 함수에서 this는 선택한 항목을 지칭한다.
		//alert(this.id);  == 1368-0
		
		//선택한 목록에 존재 여부를 확인한다.
		var aa = music1cha.arrayTxt;
		aa = aa.replaceAll(this.id+"/", "");
		if(aa != music1cha.arrayTxt){
			//기존에 선택된 것을 취소했다.
			document.getElementById(this.id).className = "allTypeMusic";
		}else{
			//신규로 새로운 것을 선택 한다.
			document.getElementById(this.id).className = "allTypeMusicSe";
			aa += this.id+"/";
		}
		music1cha.arrayTxt = aa;
		

		
	},
	allMusicPlay : function(){
		//각노래에 등록된 모든 음원을 가져온다.
		//동적으로 클릭하면 실행되는 함수에서 this는 선택한 항목을 지칭한다.
		music1cha.stop();
		
		
		music1cha.nowId = this.id;
		music1cha.sdomid = this.id;
		
		if(music1cha.oldId != null){
			
			document.getElementById(music1cha.oldId).className = "allMusic";
			document.getElementById(music1cha.oldId+"li2").style.display = "none";
			//기존에 열린 것이 있다.
			if(music1cha.openInf){
				document.getElementById(music1cha.oldId+"ul").style.display = "none";
				music1cha.openInf = false;
			}
			
			if(music1cha.oldId == music1cha.nowId){
				//기존에 열린것을 다시 클릭하면 열린것을 닫고 종료 한다.
				music1cha.oldId = null;
				return;
			}	
		}
		
		
		//----새로운 리스트를 연다.-------------------------------------------
		
			if(music1cha.openInf){
				//리스트를 닫는다. 
				document.getElementById(music1cha.sdomid+"ul").style.display = "none";
				document.getElementById(music1cha.sdomid+"li2").style.display = "none";
				
				music1cha.openInf = false;

			}else{
				//리스트를 연다.			
				music1cha.openInf = true;
				document.getElementById(music1cha.nowId).className = "allMusicSe";
				document.getElementById(music1cha.sdomid+"li2").style.display = "block";
				
				//서버에서 모든 음원을 가져온다.
				getServ2 = new GetServer();
				getServ2.initParam("getMrAll.php", "mode=allMusicS&mid="+this.id, "allMusicS", "mu");
				getServ2.getPostMode(getServ2, this.mem);  //서버에서 post 모드로 가져온다.
				
			}
			
		//--------------------------------------------------

		music1cha.oldId = this.id;
		
	}
		
		
}





//============================================
//업체정보***************
var parCo = {
	coid:null,
	latPo:0,
	longPo:0,
	cotel:"00",
	hptel:"00",
	sangho:"",
	addr:"",
	oldSangho:null,
	
	listIndx:0,
	
	coInit:function(){
		
	},
	
	setCoInfo:function(coindx){
		
		this.sangho = parCo.sangho;
		this.latPo = parCo.latPo;
		this.langPo = parCo.langPo;	
		this.addr = 	parCo.addr;
		
		this.listIndx = coindx;
		
	},
	
	setCoGPS:function(lat, long){
		
	},
}


//===============================================
//왼쪽 메뉴처리 
var insertLeftMenu = {
		
		logStat:null,
		
		memObj:null,
		
		inLeftInit:function(obj){
			this.memObj = obj;
		},
		
		dispMenu:function(stat){
			
			if(window.localStorage.getItem("loginStat") == "ok") this.logStat = true;
			else this.logStat = false;
			
			//alert(this.logStat+"/"+appBasInfo.nowPage+"/"+this.memObj.memid+"/"+appBasInfo.leftMnuCode[1]);
			

			var oo = document.querySelector("div#"+appBasInfo.nowPage+" #left-panel ul");
			oo.innerHTML = this.getAllMenu();
			
			//var oo1 = document.querySelector("div#"+appBasInfo.nowPage+" div.allPage div.leftMenuDiv div#left-panelDiv ul");
			$oo1 = $("#left-panelDiv ul"); //document.querySelector("div#"+appBasInfo.nowPage+" div.allPage div.leftMenuDiv div#left-panelDiv ul");
			$($oo1).html(this.getAllMenu());
			
			
		},
		getAllMenu:function(){
			
			var ss = "";
			
			if(AWtrans.mobileInf){
				//모바일 버젼의 경우
				ss += "<li class='leftTit' onclick='insertLeftMenu.panelClose()'><img src='./images/xx.png' onclick='insertLeftMenu.panelClose()'></li>";
			}else{
				//웹버젼의 경우 
				//ss += "<li style='text-align:center; padding:0 auto; background-color:white;'><img src='./images/loginTit2.png' style='width:80%; margin:12px 10%;'></li>";
			}
			
			
			ss += "<li>";
			ss += "<table class='leftMenuTb' style='width:100%; border-bottom:#aaa 1px solid;'>";
			//ss += "<tr><td class='left'><img src='./images/jpumRed.png'></th><td class='right'><img src='./images/ujBlack.png'></th></tr>";
			
			//왼쪽메뉴 출력
			ss += "<tr><td style='border-right:#ccc 1px solid; padding:0 0 1px;'><ul class='leftMenuLeft'>";

			/*
			var allsu = appBasInfo.leftMnuCode.length;
			var sotit = 6000;
			var sotittxt = "실사출력";
			
			var titArray = new Array(6000, 8000);
			var titArrayTxt = new Array("실사출력", "간판");
			var firstGo = true;
			

			ss += "<li class='gu' onclick='insertLeftMenu.leftM(1, 1000, \"1000\", this)'>아크릴가공</li>";
			
			var fst = 0;			
			var oldLiId = 0;
			for(var c = 1; c < allsu; c++){
				
				if(Number(appBasInfo.leftMnuCode[c]) > titArray[fst] && oldLiId < titArray[fst]){
					//새로운 리스트가 시작 되었다.
					ss += "<li class='gu' onclick='insertLeftMenu.leftM(1, "+titArray[fst]+", \""+titArray[fst]+"\", this)'>"+titArrayTxt[fst]+"</li>";
					
					fst++;
				}
				
				oldLiId = appBasInfo.leftMnuCode[c];
				
				if(oldLiId != "8000"){
					ss += "<li onclick='insertLeftMenu.leftM(1, "+c+", \""+appBasInfo.leftMnuCode[c]+"\", this)'>"+appBasInfo.leftMnuTxt[c]+"</li>";
				}
				
			}
			
			
			//alert(appBasInfo.leftMnuCode[c]);
			//*/
			
			//오른쪽 메뉴 출력
			//ss += "</ul></td>";
			
			
			
			
			
			
			
			
			//ss += "<td style='background-color:#fff; border-right:#737373 1px solid;'>";
			
			ss += "<ul class='leftMenuRight'>";
			//오른쪽 메뉴
			allsu = appBasInfo.leftUpjCode.length;
			for(var c = 1; c < (allsu - 1); c++){
				ss += "<li onclick='insertLeftMenu.leftM(2, "+c+", \""+appBasInfo.leftUpjCode[c]+"\", this)'>"+appBasInfo.leftUpjTxt[c]+"</li>";
			}
			ss += "</ul>";
			
			
			/*
			ss += "<ul class='leftMenuRight2'>";
			ss += "<li class='leftBdGo' onclick='insertLeftMenu.leftM(2, 0, \"jmBorder\", this)'><img src='./images/leftJboder.png'></li>";
			ss += "<li class='leftBdGo' onclick='insertLeftMenu.leftM(2, 30000, \"30000\", this)'><img src='./images/testp.png'></li>";
			ss += "<li class='leftBdGo' onclick='insertLeftMenu.leftM(2, 0, \"coInfo\", this)'><img src='./images/mejang.png'></li>";
			ss += "</ul>";
			*/
			
			
			ss += "<ul class='leftMBtn'>";
			
			if(window.localStorage.getItem("loginStat") == "ok"){
				ss += "<li onclick='insertLeftMenu.leftM(2, 0, \"logout\", this)'>로그아웃</li>";
				ss += "<li onclick='insertLeftMenu.leftM(2, 0, \"medit\", this)'>정보수정</li>";
			}else{
				ss += "<li onclick='insertLeftMenu.leftM(2, 0, \"login\", this)'>로그인</li>";
				//ss += "<li onclick='insertLeftMenu.leftM(2, 0, \"join\", this)'>회원가입</li>";
			}
			
			//ss += "<li class='leftWr' onclick='insertLeftMenu.leftM(2, 0, \"contentOn\", this)'><img src='./images/leftWr.png'></li>";
			ss += "</ul>";
			
			
			
			ss += "</td></tr>";
			
			

			
			//ss += "<tr><td></td><td></td></tr>";
			ss += "</table>";
			ss += "</li>";
			
			
			
			return ss;
		},
		pageMenuInitDisp:function(){
			//메인페이지 출력시 선택메뉴 기본 표시
			var uu = document.querySelectorAll("#page ul.nowLink li");
			uu[1].innerHTML = appBasInfo.leftMenuDeText;
			uu[3].innerHTML = appBasInfo.leftMenuText;
			
			
		},
		leftM:function(gubun, indx, md, obj){
			
			var lStat = this.logStat;
			var mm = this.memObj;
			
			switch(md){
			case "medit":
				
				obj.className = "RedR";
				appBasInfo.leftMenuTextAll = "정보수정";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					appUtil.moveOkHistory("index.html#Join");
					
				}, 130);
				
				return;
				break;
			case "logout":

				
				obj.className = "RedR";
				appBasInfo.leftMenuTextAll = "로그아웃";
				
				window.localStorage.setItem("loginStat", "no");
				
				
				setTimeout(function(){
					
					mm.logout();
					
				}, 130);
				
				return;
				break;
			case "login":
				
				obj.className = "RedR";
				
				appBasInfo.leftMenuTextAll = "로그인";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					appUtil.moveOkHistory("index.html#Login");
					
				}, 130);
				
				return;
				break;
			case "join":
				
				obj.className = "RedR";


				appBasInfo.leftMenuTextAll = "회원가입";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					appUtil.moveOkHistory("index.html#Join");
					
				}, 130);
				
				return;
				break;
			case "jumunBDV":   //주문 보드를 본다.
				
				setTimeout(function(){

					appUtil.moveOkHistory("jumunBDView.html");
					
				}, 130);	
				
				return;
				break;
			case "jumunOnput":   //주문게시판 등록 
					
					appBasInfo.jumunBasDui = 1;
					appUtil.moveOkHistory("jumunBDOn.html");
					
				return;
				break;
				
				
				
			case "coInfo":
				//매장안내
				obj.className = "leftBdGoSe";
				

				appBasInfo.leftMenuTextAll = "매장안내";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					appUtil.moveOkHistory("mejangList.html");
					
				}, 130);
				
				return;
				break;
			case "jmBorder":
				
				obj.className = "leftBdGoSe";
				

				appBasInfo.leftMenuTextAll = "주문게시판";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					appUtil.moveOkHistory("index.html#JumunBDList");
					
				}, 130);
				
				return;
				break;
			case "contentOn":  //컨텐츠 등록 
				
				obj.className = "leftWrSe";
				obj.firstChild.src = "./images/leftWr.png";
				
				setTimeout(function(){
					insertLeftMenu.panelClose();
					
					if(lStat){
						
						if(mm.memEmp != 1){
							appUtil.alertgo("알림", "컨텐츠 등록은 지정된 회원만 가능합니다.");
							return;
						}
						
						appBasInfo.contBasDui = 1;
						
						appBasInfo.leftMenuTextAll = "컨텐츠 등록";
						appUtil.moveOkHistory("contentOnPut.html");
					}else{
						appBasInfo.leftMenuTextAll = "로그인";
						appUtil.moveOkHistory("index.html#Login");
					}
				}, 130);
				
				return;
				break;
			}
			//========기타메뉴는 위에서 처리 하고 함수를 종료 한다.===============
			appBasInfo.leftMenuCode = md;   //선택한 상품의 코드 

			if(indx == 1000 || indx == 6000 || indx == 7000 || indx == 8000 || indx == 30000 || indx == 8010){
				var codeNam = "";
				switch(indx){
				case 1000:
					codeNam = "아크릴가공";
					break;
				case 6000:
					codeNam = "실사출력";
					break;
				case 7000:
					codeNam = "출력물기타";
					break;
				case 8000:
					codeNam = "간판";
					break;
				case 8010:
					codeNam = "간판출력";
					break;
				case 30000:
					codeNam = "시험성적서";
					
					obj.className = "leftBdGoSe";
					obj.firstChild.src = "./images/testp.png";
					
					
					

					break;
				}
				
				if(indx != 30000){
					
					appBasInfo.leftMenuGubun = "jp";
					appBasInfo.leftMenuDeText = "제품별";
					appBasInfo.leftMenuText = codeNam;
					appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
					
				}else{
					
					appBasInfo.leftMenuGubun = "uj";
					appBasInfo.leftMenuDeText = "업종별";
					appBasInfo.leftMenuText = codeNam;
					appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
					
				}
				
				
			}else{
				
				if(gubun == 1){   //제품별 메뉴
					appBasInfo.leftMenuGubun = "jp";
					appBasInfo.leftMenuDeText = "제품별";
					appBasInfo.leftMenuText = appBasInfo.leftMnuTxt[indx];
					appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
				}else if(gubun == 2){   //업종별 메뉴
					appBasInfo.leftMenuGubun = "uj";
					appBasInfo.leftMenuDeText = "업종별";
					appBasInfo.leftMenuText = appBasInfo.leftUpjTxt[indx];
					appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
				}
								
			}

			
			if(indx != 30000) obj.className = "seLeftTbTd";
			
			//처음앱이 실행될때 출력 모드
			appBasInfo.firstMode = "B02";
			
			
			//왼쪽 메뉴에서 다른 메뉴를 클릭하면 메인페이지의 검색어는 삭제된다.
			appBasInfo.taPageGoin = true;
			if(appBasInfo.nowPage == "page"){
				document.getElementById("findPage").value = "";
				appBasInfo.pageContentGet();
			}
			
			
			setTimeout(function(){
				insertLeftMenu.panelClose();
				
				if(appBasInfo.nowPage == "page"){
					
					//메인페이지의 상단에 선택 경로 표시 
					insertLeftMenu.pageMenuInitDisp();
					//왼쪽 메뉴를 다시 출력한다.
					insertLeftMenu.dispMenu(insertLeftMenu.logStat);	
					
				}else{
					appUtil.goHome();
				}
				
			
			}, 130);
			//========================================================
			
			
		},
		panelClose:function(){
			
			if(AWtrans.mobileInf) $("div#"+appBasInfo.nowPage+" #left-panel").panel("close");
		}
			
			
}




//풋바를 출력한다.
var insertFootBar = {
	txt:"Copyright(C) <span>Handeul. All Rights Reserved.</span>",
	
	dispFoot:function(){
		
		$oo = $("#"+appBasInfo.nowPage+" div.footerBar");
		$($oo).html(this.txt);
		
	},
	
	dispFoot2:function(){
		
		$oo = document.querySelector("#"+appBasInfo.nowPage+" div.footerBar2");
		$($oo).html(this.txt);
		
	}



}



//앱과 웹의 트랜스퍼 처리를 한다.
var AWtrans = {
	
		mem:null,
		mobileInf:false,
		webInf:"ie",
			
		init:function(memobj){
			
			//모바일에서 실행여부를 확인한다.==================
			this.mobileInf = false;
			var mb = navigator.userAgent;

			
			var rr2 = mb.split("Android");
			if(rr2.length > 1) this.mobileInf = true;
			var rr3 = mb.split("iPhone");
			if(rr3.length > 1) this.mobileInf = true;
			
			if(!this.mobileInf){     //
					//web 버젼 이다.
					var kk = mb.split("Chrome");
					var kk2 = mb.split("Safari");
					//alert(kk+"/"+kk2);
					if((kk.length + kk2.length) > 2){
					 	this.webInf = "chrome";
					}else{
						this.webInf = "ie";
					}
					window.localStorage.setItem("webinf", this.webInf);
			}else{
					//모바일웹과 엡에서는 이것으로 처리한다.
					this.webInf = "mobile";
					window.localStorage.setItem("webinf", "mobile");
			}
			
			//document.getElementById("textHead").innerHTML = window.localStorage.getItem("webinf");
			//alert(mb);
			
			
			//alert(window.localStorage.getItem("webinf"));
			
			//alert(appBasInfo.deviceUiu);
			
			
			//========================================
			
		
	},
	
	trans:function(){
		
		
		//앱과웹에 따라 처리 
		if(this.mobileInf){  //**************************************************************
			if($("div#"+appBasInfo.nowPage).hasClass("webPageBack")){
				$("div#"+appBasInfo.nowPage).removeClass("webPageBack");
			}
			$("div#"+appBasInfo.nowPage).addClass("webPageBackMu");
		
			//모바일 버젼 이다.
			//헤드영역처리===========================================================
			
			
			
			//body 영역처리==========================================================
			$ct = $(".bodyContent");
			$($ct).css({"width":"100%", "margin":"0", "padding":"0"});			
			
			
			$alp = $("#"+appBasInfo.nowPage+" div.allPage div.leftMenuDiv");
			$($alp).css("display","none");
			
			$alp = $("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDiv");
			$($alp).css("width", "100%");
			
			//풋영역처리===============================================================
			if(appBasInfo.nowPage == "Login"){
				$ft = $("#loginFoot");
				$($ft).css("display","block");
			}else{
				$ft = $("#"+appBasInfo.nowPage+" div.footerBar");
				$($ft).css("display","block");
			}
			
			//====상세영역=================================================
			switch(appBasInfo.nowPage){
			case "page":
				
				document.getElementById("findDivPage").style.display = "none";
				
				break;
			}
			
			
			
		}else{  //**************************************************************
		
			//alert(appBasInfo.nowPage);
		

			
			//$("div#"+appBasInfo.nowPage).addClass("webPageBack");
		
			//웹버젼 이다.
			//헤드영역처리=============================================================
			$hh = $(".noFindTitle");
			$($hh).css("display","none");
			
			$hh = $(".FindTitle");
			$($hh).css("display","none");
			
			$hh = $("#"+appBasInfo.nowPage+" div.allPage div.webTitle");
			$($hh).css("display","block");
			
			
			
			
			//body 영역처리============================================================
			
			//alert("web start "+appBasInfo.nowPage);
			$alp = $("#"+appBasInfo.nowPage+" div.allPage div.leftMenuDiv");
			//alert($alp);
			$($alp).css("display","block");
			
			$ct = $("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDiv div.bodyContent");
			$($ct).css({"width":"92%", "margin":"0 3.5% 0 2.5%"});
			
			

			$alp = $("#"+appBasInfo.nowPage+" div.allPage");
			$($alp).css({"width":"1098px", "background":"#fff url('./images/rightBack.png') 100% 0 repeat-y"});
			$alp = $("#"+appBasInfo.nowPage+" div.allPage div.leftMenuDiv");
			$($alp).css({"width":"290px", "border-right":"#dedede 1px solid", "margin":"0"});
			$alp = $("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDiv");
			$($alp).css({"width":"800px", "display":"block"});
			
			//풋영역처리 ====================================================
			//footbar 를 않보이게 한다.
			if(appBasInfo.nowPage != "Login"){
				$ft = $("#"+appBasInfo.nowPage+" div.footerBar");  //footerBar
				$($ft).css({"display":"none"});				
			}else{
				
				$ft = $("#loginFoot");  //footerBar
				$($ft).css({"display":"none"});				
			}
			
			
			//====상세영역=================================================
			switch(appBasInfo.nowPage){
			case "page":
				
				document.getElementById("findDivPage").style.display = "block";
				document.getElementById("findDivPage").style.width = "790px";
				
				break;
			case "Login":
				
				document.getElementById("loginTopTit").className = "loginTopW";
				
				$(".redWhiteBox").css({"width":"60%", "margin":"-40px 20% 0"});
				
				
				break;
			case "ContentOnPut":
			

				
				break;	
				
			}
			
		}  //*********************************************************************
		
		
		
	}
		
		
		
}


var Base64 = {


	    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789=%&",


	    encode: function(input) {
	        var output = "";
	        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
	        var i = 0;

	        input = Base64._utf8_encode(input);

	        while (i < input.length) {

	            chr1 = input.charCodeAt(i++);
	            chr2 = input.charCodeAt(i++);
	            chr3 = input.charCodeAt(i++);

	            enc1 = chr1 >> 2;
	            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
	            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
	            enc4 = chr3 & 63;

	            if (isNaN(chr2)) {
	                enc3 = enc4 = 64;
	            } else if (isNaN(chr3)) {
	                enc4 = 64;
	            }

	            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

	        }

	        return output;
	    },


	    decode: function(input) {
	        var output = "";
	        var chr1, chr2, chr3;
	        var enc1, enc2, enc3, enc4;
	        var i = 0;

	        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

	        while (i < input.length) {

	            enc1 = this._keyStr.indexOf(input.charAt(i++));
	            enc2 = this._keyStr.indexOf(input.charAt(i++));
	            enc3 = this._keyStr.indexOf(input.charAt(i++));
	            enc4 = this._keyStr.indexOf(input.charAt(i++));

	            chr1 = (enc1 << 2) | (enc2 >> 4);
	            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
	            chr3 = ((enc3 & 3) << 6) | enc4;

	            output = output + String.fromCharCode(chr1);

	            if (enc3 != 64) {
	                output = output + String.fromCharCode(chr2);
	            }
	            if (enc4 != 64) {
	                output = output + String.fromCharCode(chr3);
	            }

	        }

	        output = Base64._utf8_decode(output);

	        return output;

	    },

	    _utf8_encode: function(string) {
	        string = string.replace(/\r\n/g, "\n");
	        var utftext = "";

	        for (var n = 0; n < string.length; n++) {

	            var c = string.charCodeAt(n);

	            if (c < 128) {
	                utftext += String.fromCharCode(c);
	            }
	            else if ((c > 127) && (c < 2048)) {
	                utftext += String.fromCharCode((c >> 6) | 192);
	                utftext += String.fromCharCode((c & 63) | 128);
	            }
	            else {
	                utftext += String.fromCharCode((c >> 12) | 224);
	                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
	                utftext += String.fromCharCode((c & 63) | 128);
	            }

	        }

	        return utftext;
	    },

	    _utf8_decode: function(utftext) {
	        var string = "";
	        var i = 0;
	        var c = c1 = c2 = 0;

	        while (i < utftext.length) {

	            c = utftext.charCodeAt(i);

	            if (c < 128) {
	                string += String.fromCharCode(c);
	                i++;
	            }
	            else if ((c > 191) && (c < 224)) {
	                c2 = utftext.charCodeAt(i + 1);
	                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
	                i += 2;
	            }
	            else {
	                c2 = utftext.charCodeAt(i + 1);
	                c3 = utftext.charCodeAt(i + 2);
	                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
	                i += 3;
	            }

	        }

	        return string;
	    }

	}



window.albRf = function(str,callback){
	cordova.exec(
		function(message) {//success
		          ////console.log('success plugin callback!');
		          ////console.log('message :' + message);
		          
		          //$("#network3g4g").popup("close");
		          
		}, function(err) {
		    	 //$("#network3g4g").popup("close");
		          ////console.log('error:' + err);
		}, "webViewpage", "albumRefresh", [str,"kkkk"]);		
}




//div 넗이 자동계산하여 배치
function divAllWidth(classnam){

	var $alldiv = $("."+classnam+" div.divAllWidth");
	//전체 div의 갯수를 구한다.
	var su = $alldiv.length;
	
	var $alldiv2 = $("."+classnam+" div.divAllWidthSetW");
	//넓이를 설정한 것의 갯수를 구한다.
	var su2 = $alldiv2.length;
	
	//테이블의 전체 넓이를 구한다.
	var allWidth = parseInt($("."+classnam).css("width"));
	

	
	var wsetW = 0;
	var imsi = 0;
	if(su2 > 0){
		for(var c=0; c < su2; c++){
		
			imsi = parseInt($($alldiv2[c]).css("width"));
			
			wsetW += imsi
			$($alldiv2[c]).css({"display":"inline-block", "float":"left", "width":(imsi)+"px", "margin":"0", "padding":"0", "border":"none", "text-align":"center", "display":"block"});
		}
	}
	
	
	if(su > 0){
		var namSu = (su - su2);
		var namW = (allWidth - wsetW);
		//alert(allWidth+"///"+wsetW+"//"+namW);
		
		var suW = parseInt(namW / namSu);
		suW = (suW - 1);
		
		for(var a=0; a < su; a++){
			if(!$($alldiv[a]).hasClass("divAllWidthSetW")){
				$($alldiv[a]).css({"display":"inline-block", "float":"left", "width":(suW)+"px", "margin":"0", "padding":"0", "border":"none", "text-align":"center", "display":"block"});	
			}
		}
	}
	
	
}



//외부 프레임에서 로그아웃을 호출 한다.
function outLogout(){
	
	meminf.logout();
}

//===============================================


		//무엇보다 먼저 실행되는코드 이다.
		//온디바이스와 페이지 beforeshow 중에서 먼저 실행되는 곳에서 호출 한다.
		if(appStart){
			//내가 일등 실행이다.
			appStart = false;
			

			//insertLeftMenu.inLeftInit(meminf);
			//alert("meminf appStart"+meminf.seRecid);
					//회원정보를 처리 한다.
			meminf = new hdMem();
			meminf.memInit(meminf);

			meminf.myPotion = mypotion;
			meminf.myMemid = mymemid;
			meminf.myRecid = myrecid;
		
			//alert(MASTER+"/"+myrecid);	

		}
		

//============================================================

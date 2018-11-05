
//기타 작은 함수들
var appUtil = {
	
	memObj:null,
	
		
	init:function(memObjG){
		this.memObj = memObjG;
	},
	
	setDomFocus:function(po){
		
		var aa = document.getElementById(po);
		aa.focus();
		
	},
	
	getMap:function(){
		//주소로 위도경도를 구하여 meminf.latPo,   meminf.langPo 에 위치값을 설정한다.
	
		var add1 = $("#coaddress").val();
		var fadd = add1+" "+$("#coaddress2").val()
	
		mapObj = new coMappro("desangMap");
		mapObj.map = null;
							
		mapObj.getAddrToLatLong(fadd);
	
	},
	
	
	
	fileDownUtil:function(fnam){
		
		fileObj.fileDown(fnam);
		
        //서버상의 sample.jpg 파일을 test.jpg 라는 이름으로 로컬시스템에 저장
		/*
		$('#downloadLink').prop('href', fnam); 
		$('#downloadLink').prop('download', 'test.jpg');
		$('#downloadLink')[0].click();
		*/
		
	},
	
	//첨부파일 다운로드
	addUpfileDown:function(dfile){
		appBasInfo.nowViewImgLink = dfile;
		
		this.fileDownUtil2();
		
	},
	
	//파일다운로드처리
	fileDownUtil2:function(){
		
		appUtil.dispPgLoading();
		
		fileObj.fileDown(appBasInfo.nowViewImgLink);
		
	},
	
	setBasPageH:function(){
		
		appBasInfo.pageH = Number(window.sessionStorage.getItem("h"));
		
		var hh = appBasInfo.pageH - Number(window.sessionStorage.getItem("stH"));
		$("#"+appBasInfo.nowPage+" div.allPage").css("height", hh+"px");
		$("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDiv").css("height", hh+"px");
		
		if(appBasInfo.nowPage == "Login") $("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDivLog").css("height", hh+"px");
		
	
	},
	
	
	setPageH:function(){
		
		appBasInfo.pageH = $("#"+appBasInfo.nowPage).height();
		
		//alert(appBasInfo.pageH);
		$("#"+appBasInfo.nowPage+" div.allPage").css("height", (appBasInfo.pageH + 200)+"px");
		$("#"+appBasInfo.nowPage+" div.allPage div.pageBodyDiv").css("height", appBasInfo.pageH+"px");
		
		
	
	},
	
	callTel:function(ctel){

		//전화걸기 공통
		location.href="tel:"+ctel;
		
	}, 
	
	callTelMj:function(md){
		var ctel = "";
		if(md == 0) ctel = parCo.cotel;
		else ctel = parCo.hptel;
		
		//전화걸기 공통
		location.href="tel:"+ctel;
		
	}, 
	
	goHome:function(){
		appUtil.moveOkHistory("index.html#page");
	},
		
	
	//뒤로가기
	moveBack:function(){
		
		if(appBasInfo.nowPage == "page" || appBasInfo.nowPage == "Login"){
			
			navigator.notification.confirm("앱을 종료하시겠습니까?", appUtil.onBackKeyDownMsg, "종료", "취소, 확인");
			
		}else{
			history.go(-1);   //앞으로			
		}

	},
	
	dispPgLoading:function(){
		
		document.querySelector("#"+appBasInfo.nowPage+" .loadingDiv").style.display = "block";
		//기본 높이를 설정한다.
		var tt = 100;
		if(appBasInfo.nowPage == "ContentOnPut"){
			$("#"+appBasInfo.nowPage+" .loadingImg").css({"margin":(appBasInfo.topHeight+150)+"px 0 0"});
		}
		
	},
	
	hidePgLoading:function(){
		
		document.querySelector("#"+appBasInfo.nowPage+" .loadingDiv").style.display = "none";
		
	},
	
	moveGoback:function(){
		history.go(-1);   //앞으로		
	},
	
	exitApp:function(){
		//app exit
		navigator.app.exitApp();
	},
	
	onBackKeyDownMsg:function(button) {
	    if(button == 2) {     //종료한다.
	    	appUtil.exitApp();	
	    }
	},
	
	allTogglePro:function(tgid){
		$aa = $("#"+tgid);
		
		if($aa.css("display") == "none"){
			$aa.css("display", "block");
		}else{
			$aa.css("display", "none");
		}
		
	},

	imgOpen:function(imgurl, w, h){
	
		window.open(baseImgUrl+imgurl, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=90,left=90,width="+w+",height="+h);
	
	},


	formPost:function(){
		
		//블로그에 등록하기 위해 상품을 검색한다.
		appBasInfo.blogFindTxt = "";
		
		

			/*
			var frm = document.forms[0];
			//alert(frm.id);
			//frm.target="hidden_frame";
			//document.getElementById("UserA").value = "1002";
			//alert("sum="+frm.elements[0].value);
			frm.submit();
			*/
			
			var frm = $("#FmCont")[0];
			frm.SumCount.value = appBasInfo.nowSumCount;
			
			var selectElement = document.getElementById("TypeA");
			appBasInfo.blogCate = selectElement.options[selectElement.selectedIndex].text;
			
			if(appBasInfo.blogCate == "선택"){
				 appUtil.alertgo("알림","제품분류를 선택하세요.");
				 return;
			}
			
				if($("#BlogIn").is(":checked")){
					$("#BlogIn").val(1);
					//alert(appBasInfo.blogCate);
					
				}else{
					$("#BlogIn").val(0);
					appBasInfo.blogCate = "0";
					
				}

			
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
			
			
			
			if(frm.DSecret.checked) frm.DSecret.value = 1;  //한들동료에게 열람
			else frm.DSecret.value = 0;   //모두에게 열람
			
			
			if(frm.BlogIn.checked) frm.BlogIn.value = 1;  //블로그에 등록
			else frm.BlogIn.value = 0;   //블로그에 등록 않함
			
		
			
			var ii = frm.Title.value;
			frm.Title.value = escape(ii);
			appBasInfo.blogFindTxt = ii;
			
			
			ii = $("#Cont").val();
			$("#Cont").val(escape(ii));
			
			ii = frm.NoteA.value;
			frm.NoteA.value = escape(ii);
			
			

			
			
			//선택한 제품의 코드를 전달
			appBasInfo.leftMenuCode = frm.TypeA.value;
			appBasInfo.leftMenuGubun = "jp";
			appBasInfo.leftMenuDeText = "제품별";
			appBasInfo.leftMenuText = $("#TypeA option:selected").text();  //""; //frm.TypeA.value
			appBasInfo.leftMenuTextAll = appBasInfo.leftMenuText;
			
			
			
			if(appBasInfo.contBasDui == 3){
				//삭제의 경우 값설정
				frm.Indx.value = appBasInfo.nowJmIndx;
				frm.SumCount.value = 0;
				frm.Cont.value = "0";
			}

			appUtil.dispPgLoading();
			
			//frm.submit();
			
			
			
		
			appUtil.dispPgLoading();
			appBasInfo.firstMode = "B01";   //선택한 코드값에 해당하는 상품을 가져온다.  B01: 전체를 가져온다.
			
			var formData = new FormData(frm);
			$.ajax({url:LK+'QueryC.asp', processData: false, contentType:false, data:formData, type:'POST', success:function(data){
				
				appUtil.hidePgLoading();
				
				if(appBasInfo.contBasDui == 3){
					appUtil.alertgo("알림","삭제 완료 하였습니다.");
					appUtil.goHome();

				}else{
				
					//블로그등록처리를 하기 위해 정보를 가져온다.
					/*
					if(appBasInfo.contBasDui == 1 && appBasInfo.blogOnInf){
						//블로그에 등록하기 위해 제품정보를 검색한다.
						appBasInfo.pageContentGetOnBlog();
						
					}
					*/

				}
				
			}, error:function(xhr,status,error){
				
				appUtil.hidePgLoading();
				
				
				if(appBasInfo.contBasDui == 3){
					appUtil.alertgo("알림","삭제 실패하였습니다. 다시 시도하세요."); //+error);
				}else{
					appUtil.alertgo("알림","등록/수정 실패하였습니다. 다시 시도하세요."+error);
				}
				


			}});
			
			
		setTimeout(function(){
			
			if(appBasInfo.contBasDui == 1 || appBasInfo.contBasDui == 2){
				appUtil.hidePgLoading();
				appUtil.alertgo("알림","등록/수정 요청 하였습니다.");
				
				appUtil.goHome();
			}
			
		}, 1000);
		
		
		
		
		
		
	},
	
	
	
	//이미지컨트롤 - 이미지를 직접 클릭하는 경우 
	controlImg:function(obj){
		
		appBasInfo.nowViewImgLink = obj.src;
		
		appUtil.moveOkHistory("imageView.html");
		
	},
	
	//이미지 크게 보기 - 이미지 주변을 클릭하는 경우 
	movImg:function(flink){
		
		appBasInfo.nowViewImgLink = flink;
		
		appUtil.moveOkHistory("imageView.html");
		
	},
	
	//알림 출력
	alertgo:function(tit,msg){
		tit = "알림";
		
	    //alert(AWtrans.mobileInf+"/"+tit+"/"+msg);
		
		if(AWtrans.mobileInf){
			navigator.notification.alert(
					msg,  // message
					function(){
						
					},              // callback to invoke with index of button pressed
			      tit,            // title
			      '확인'          // buttonLabels
				);
		}else{
			
			alert("알림-"+msg);
			
		}

		
	},
	
	//에러 출력
	alertgoErr:function(xhr,status,error,fnn){
		
		var outMess;
		var outTit;
		
		if(AWtrans.mobileInf){
			if(status == "timeout"){
				outMess = "서버 응답이 없어 앱을 종료 합니다. Wifi에 장애가 있을 경우 다른 연결 방법을 선택해 주시기 바랍니다.";
				outTit = "네트워크 장애(Wifi 장애)";
				
				navigator.notification.confirm(outMess, alertDismissedWifi, "질문", '확인');

			}else{

			}
		}else{
			outTit = "에러";
			outMess = "서버 응답이 없어 앱을 종료 합니다. Wifi에 장애가 있을 경우 다른 연결 방법을 선택해 주시기 바랍니다.";
			alert(autTit+"-"+outMess);
		}

	},
	
	//메세지 전송 관련 글자 입력
	input_smstext:function(str,tsu){
		var ss = encodeURI(str);
		var rst = encodeURI(ss);
		return rst;
	},

	//줄바꿈하여 보여 준다.
	disp_rttext:function(str,tsu){
		
		var aa = unescape(str);
		aa = aa.replaceAll("\r", "");
		aa = aa.replaceAll("\n", "<br />");
		
		//aa = aa.replaceAll("%uB300", "");
		
		
		return aa;
	},
	
	//모든 내용 출력
	disp_smstext:function(str,tsu){
		
		var aa = str.replaceAll("%0A", "<br />");
		
		return decodeURI(aa);
	},

	//히스토리 않남기는 페이지 전환
	moveOkHistory:function(url){
		////console.log("appUtil.moveOkHistory go="+url);
		$.mobile.changePage(url, {transition: "none", changeHash: true, showLoadMsg:true});
	},
	//히스토리 않남기는 페이지 전환
	moveNoHistory:function(url){
		$.mobile.changePage(url, {transition: "none", changeHash: false, showLoadMsg:true});
	},

	vimgUp:function(indx){
		var oldIndx = indx;
		if(indx > 0){
			indx--;
			
			this.chnDom(indx, oldIndx);
			
		}
		
	},
	vimgDown:function(indx){
		var oldIndx = indx;
		if(indx < 9){
			indx++;
			
			this.chnDom(indx, oldIndx);

		}
		
	},
	
	chnDom:function(indx, oldIndx){
		//이동할 돔
		var ss = document.getElementById("onImgDiv"+oldIndx);
		//원래 있는 돔
		var org = document.getElementById("onImgDiv"+indx);
		org.setAttribute("id", "imsi");
		
		
		//이동할 돔을 이동시킨다.
		var tg = document.getElementById("onImg"+indx);
		tg.appendChild(ss);
		//아이디를 새로운 아이디로 변경한다.
		ss.setAttribute("id", "onImgDiv"+indx);
		
		
		var tg = document.getElementById("onImg"+oldIndx);
		tg.appendChild(org);
		//이동된 것의 아이디를 변경한다.
		org.setAttribute("id", "onImgDiv"+oldIndx);
	},
	
	openPannel:function(){
		$("#"+appBasInfo.nowPage+" #left-panel").panel("open");
		
		
	},
	
	
	closePannel:function(){
		$("#"+appBasInfo.nowPage+" #left-panel").panel("close");
	},
	
	goLogin:function(){
		
		this.alertgo("알림","로그인 하셔야 댓글 작성자 가능합니다.");
		
	},
	
	keyOnput:function(ev, md){
		
		var keyCode = ev.keyCode;
		if(keyCode == 13){
			
			document.getElementById("findGot"+md).focus();
			
			switch(md){
			case 1:
				//메인페이지에서 검색
				appBasInfo.pageContentGet();
				
				break;
			case 2:
				//주문게시판에서 검색
				appBasInfo.jumunBdFindGet();
				
				break;
			}
			
		}

	},
	
	
	pwcheck:function(str){
	
		var pw = str;
	        // 길이
        if(!/^[a-zA-Z0-9]{6,15}$/.test(pw))
        { 
            alert("비밀번호는 숫자, 영문 조합으로 6~15자리를 사용해야 합니다."); 
            return false;
        }
         
        // 영문, 숫자, 특수문자 2종 이상 혼용
        var chk = 0;
        if(pw.search(/[0-9]/g) != -1 ) chk ++;
        if(pw.search(/[a-z]/ig)  != -1 ) chk ++;
        if(chk < 2)
        { 
            alert("비밀번호는 숫자, 영문을 혼용하여야 합니다."); 
            return false;
        }
	
		
		 return true;
	},
	
	
	idcheck:function(str){
	
		var mid = str;
	        // 길이
        if(!/^[a-zA-Z0-9!@#$%^&*()?_~]{4,10}$/.test(mid))
        { 
            alert("아이디는 숫자, 영문 조합으로 4~10자리를 사용해야 합니다."); 
            return false;
        }
         
        // 영문, 숫자, 특수문자 2종 이상 혼용
        var chk = 0;
        if(mid.search(/[0-9]/g) != -1 ) chk ++;
        if(mid.search(/[a-z]/ig)  != -1 ) chk ++;
        if(chk < 1)
        { 
            alert("아이디는 숫자 또는 영문으로 설정하셔야 합니다."); 
            return false;
        }
		
		 return true;
	},
	
	
	
	
}


var dayVar = {
	nowDay : "", //disp_today();    //오늘 날짜
	nowYY : "",
	nowMM : "",
	nowDD : "",
	nowLAST : "",
	disp_today : function() { //오늘 날짜를 년-월-일로 출력
		var dy = new Date();

		var yy = (dy.getFullYear()).toString();
		var mm = (dy.getMonth() + 1).toString();
		var dd = (dy.getDate()).toString();

		if (mm.length == 1)
			mm = "0" + mm;
		if (dd.length == 1)
			dd = "0" + dd;

		this.nowYY = yy;
		this.nowMM = mm;
		this.nowDD = dd;

		this.nowLAST = (new Date(this.nowYY, this.nowMM, 0)).getDate();

		var ss = yy + "-" + mm + "-" + dd;
		this.nowDay = ss;

		return ss;
	},
	noDeshDay : function(dd) { // - 뺀날자 출력 

		var arr = dd.split("-");
		var a1 = Number(arr[1]);
		var a2 = Number(arr[2]);

		if (a1 < 10)
			arr[1] = "0" + a1.toString();
		if (a2 < 10)
			arr[2] = "0" + a2.toString();

		return arr[0] + arr[1] + arr[2];

	},
	getDateObjToStr : function(d) {
		var str = new Array();

		var _year = d.getFullYear();
		str[str.length] = _year;

		var _month = d.getMonth() + 1;
		if (_month < 10)
			_month = "0" + _month;
		str[str.length] = _month;

		var _day = d.getDate();
		if (_day < 10)
			_day = "0" + _day;
		str[str.length] = _day

		return str.join("");
	},
	getToday : function() {

		return this.getDateObjToStr(new Date());
	},
	todayGet : function() { // - 있는 날짜.

		var today = dayVar.getToday();

		var in_year = today.substr(0, 4);
		var in_month = today.substr(4, 2);
		var in_day = today.substr(6, 2);

		return in_year + "-" + in_month + "-" + in_day;

	},
	betweenDayTxt : function(seday) { //오늘 날짜와 기념일자 사이의 일수를 구한다.
		//0:이전날짜, 2: 큰 날짜

		var today = this.todayGet(); //"2015-06-16";  //new Date();

		var tdiv = today.split("-");
		var tdivY = tdiv[0];
		var tdivM = (Number(tdiv[1]) < 10) ? "0" + tdiv[1] : tdiv[1];
		var tdivD = (Number(tdiv[2]) < 10) ? "0" + tdiv[2] : tdiv[2];

		var sdiv = seday.split("-");
		var sdivY = sdiv[0];
		var sdivM = (Number(sdiv[1]) < 10) ? "0" + sdiv[1] : sdiv[1];
		var sdivD = (Number(sdiv[2]) < 10) ? "0" + sdiv[2] : sdiv[2];

		var rt = 1; //정상처리 한다.
		if ((Number(sdivY) - Number(tdivY)) > 0) { //선택한 년도가 크다.
			if ((Number(sdivM) - Number(tdivM)) > 0) {
				//선택한 월이 크다.
				rt = 2;
			} else if ((Number(sdivM) - Number(tdivM)) == 0) { //선택한 월이 같다.
				((Number(sdivD) - Number(tdivD)) <= 0) ? rt = 1 : rt = 2;
			} else {
				rt = 1; //선택한 월이 작다.
			}
		} else if ((Number(sdivY) - Number(tdivY)) == 0) { //년도가 같은 경우
			if ((Number(sdivM) - Number(tdivM)) > 0) {
				//선택한 월이 크다.
				rt = 1;
			} else if ((Number(sdivM) - Number(tdivM)) == 0) { //선택한 월이 같다.
				((Number(sdivD) - Number(tdivD)) >= 0) ? rt = 1 : rt = 0;
			} else {
				rt = 0; //선택한 월이 작다.
			}
		} else {
			rt = 0; //선택한 년도가 작다.
		}

		return rt;
	},
	betweenDayToDay : function(eday, seday) { //오늘 날짜와 기념일자 사이의 일수를 구한다.==시작일자, 종료일자
		//0:이전날짜, 2: 큰 날짜

		var today = eday; //this.todayGet(); //"2015-06-16";  //new Date();

		var tdiv = today.split("-");
		var tdivY = tdiv[0];
		var tdivM = (Number(tdiv[1]) < 10) ? "0" + tdiv[1] : tdiv[1];
		var tdivD = (Number(tdiv[2]) < 10) ? "0" + tdiv[2] : tdiv[2];

		var sdiv = seday.split("-");
		var sdivY = sdiv[0];
		var sdivM = (Number(sdiv[1]) < 10) ? "0" + sdiv[1] : sdiv[1];
		var sdivD = (Number(sdiv[2]) < 10) ? "0" + sdiv[2] : sdiv[2];

		var rt = 1; //정상처리 한다.
		if ((Number(sdivY) - Number(tdivY)) > 0) { //선택한 년도가 크다.
			if ((Number(sdivM) - Number(tdivM)) > 0) {
				//선택한 월이 크다.
				rt = 2;
			} else if ((Number(sdivM) - Number(tdivM)) == 0) { //선택한 월이 같다.
				((Number(sdivD) - Number(tdivD)) <= 0) ? rt = 1 : rt = 2;
			} else {
				rt = 1; //선택한 월이 작다.
			}
		} else if ((Number(sdivY) - Number(tdivY)) == 0) { //년도가 같은 경우
			if ((Number(sdivM) - Number(tdivM)) > 0) {
				//선택한 월이 크다.
				rt = 1;
			} else if ((Number(sdivM) - Number(tdivM)) == 0) { //선택한 월이 같다.
				((Number(sdivD) - Number(tdivD)) >= 0) ? rt = 1 : rt = 0;
			} else {
				rt = 0; //선택한 월이 작다.
			}
		} else {
			rt = 0; //선택한 년도가 작다.
		}

		return rt;
	},
	
	get0PlusDay : function() {

		var YY, MM, DD;
		if (window.localStorage.getItem("actPage") == "AAComListBox") { //재설정함에서 날짜를 가져온다.
			YY = $("#dayYYJ").val();

			MM = parseInt($("#dayMMJ").val(), 10);
			if (MM < 10) {
				MM = "0" + $("#dayMMJ").val();
			} else {
				MM = $("#dayMMJ").val();
			}

			DD = parseInt($("#dayDDJ").val(), 10);
			if (DD < 10) {
				DD = "0" + $("#dayDDJ").val();
			} else {
				DD = $("#dayDDJ").val();
			}

		} else { //날짜 설정칸에서 날짜를 가져온다.
			YY = $("#dayYY").val();

			MM = parseInt($("#dayMM").val(), 10);
			if (MM < 10) {
				MM = "0" + $("#dayMM").val();
			} else {
				MM = $("#dayMM").val();
			}

			DD = parseInt($("#dayDD").val(), 10);
			if (DD < 10) {
				DD = "0" + $("#dayDD").val();
			} else {
				DD = $("#dayDD").val();
			}

		}

		return YY + "-" + MM + "-" + DD;
	},
	//재설정함에서 날짜 초기설정
	dispTodayInputJ : function() {

		var stYY = parseInt(dayVar.nowYY, 10);
		/*
		var ss = "";
		for(var c=stYY; c < (stYY+2); c++){
			if(c == stYY){
				ss += "<option value='"+c+"' selected><span style='font-size:2em;'>"+c+"</span></option>";
			}else{
				ss += "<option value='"+c+"'><span style='font-size:2em;'>"+c+"</span></option>";			
			}
		}
		$("#dayYYJ").html(ss);
		
		var myse = $("select#dayYYJ");
		myse[0].selectedIndex = 0;
		myse.selectmenu("refresh");
		 */
		$("#dayYYJ").val(stYY);

		var stMM = parseInt(dayVar.nowMM, 10);
		/*
		for(var c=1; c <= 12; c++){
			if(c == stMM){
				ss += "<option value='"+c+"' selected>"+c+"</option>";
			}else{
				ss += "<option value='"+c+"'>"+c+"</option>";			
			}
		}
		$("#dayMMJ").html(ss);
		myse = $("select#dayMMJ");
		myse.selectmenu("refresh");
		 */
		$("#dayMMJ").val(stMM);

		var stDD = parseInt(dayVar.nowDD, 10);
		/*
		for(var c=1; c <= dayVar.nowLAST; c++){
			if(c == stDD){
				ss += "<option value='"+c+"' selected>"+c+"</option>";
			}else{
				ss += "<option value='"+c+"'>"+c+"</option>";			
			}
		}
		$("#dayDDJ").html(ss);
		
		myse = $("select#dayDDJ");
		myse.selectmenu("refresh");
		 */

		$("#dayDDJ").val(stDD);

	}

}
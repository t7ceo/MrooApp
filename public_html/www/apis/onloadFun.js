//파일 시스템을 시작 한다.
/*
window.requestFileSystem(LocalFileSystem.PERSISTENT,0,gotFS,fail);
function gotFS(FileSystem){
	FileSystem.root.getDirectory("sohoring",{create:true,exclusive:false},gotDirectory, fail);
}
function fail(FileError){
	//console.log(FileError.code);
}
//디렉토리 엔터리를 얻는다.
function gotDirectory(directoryEntry){
	//console.log(directoryEntry.fullPath);
}
*/

//파일을 복사한다.==================================
function success(Entry) {
    //console.log("New Path: " + Entry.fullPath);
}

function fail(error) {
    
}

function moveFile(Entry) {
    //console.log("*******"+Entry+"/ path=="+fileDir);
    
    var parent = window.resolveLocalFileSystemURI(fileDir, onSuccess, onError);
    parentEntry = new DirectoryEntry({fullPath:parent});
    
    //파일 엔트리를 이용하여 fileDir 이라는 목적 디렉토리로 "newFile.txt" 라는 이름으로 복사한다.
    Entry.moveTo(parentEntry, "file.copy", success, fail);
}

function onSuccess(Entry) {
    //console.log("New Path: " + Entry.fullPath);
}

function onError(error) {
   
}

//==========================================================


//====================================

	
	
function messageClose(mode){

	switch(mode){
	case 1:   //무선데이트 설
		
		window.netcon("gogo", function(echoValue) {
			
			////console.log(JSON.stringify(echoValue)); 
		 });
		
		
	break;
	case 2:   //무선데이트 닫기
		//$("#network3g4g").popup("close");
		
		appUtil.exitApp();
		
		break;
	}	

}




	function networkInf(){
		if(appBasInfo.resumeInf){
			appBasInfo.resumeInf = false;
			setTimeout("networkInf()", 3000);
			
		}else{
			var rmg = window.sessionStorage.getItem("roming");
			if(rmg == true){
				//해외 로밍을 사용 중이다.
				if(appBasInfo.conType != "wifi"){
					appUtil.alertgo("알림","해외에서 3G 또는 4G로 접속은 불가능 합니다.");
					setTimeout("messageClose(2)", 3000);
				}
				
			}else{
				if(appBasInfo.conType != "4G" && appBasInfo.conType != "4g" && appBasInfo.conType != "3G" && appBasInfo.conType != "3g" && (appBasInfo.conType == "r" || appBasInfo.conType == "R")){
					//해외 모드 
					
					if(appBasInfo.conType != "wifi"){
						appUtil.alertgo("알림","해외에서 3G 또는 4G로 접속은 불가능 합니다.");
						setTimeout("messageClose(2)", 3000);
					}else{
						//비행기 보드 확인
						if(window.sessionStorage.setItem("aplinf") == "on"){

							navigator.notification.confirm('비행기 탑승모드 사용불가, 모드변경할까요?. 취소하면 앱을 종료합니다.', function(button){
						    	if(button == 2){   //확인 
						    		messageClose(1);
						    	}else{
						    		if(navigator.network.connection.type == "none") messageClose(2);
						    	}
						    }, '질문', '취소,확인');				
							
						}
					}
					
				}else{
					//한국 국내 사용 이다.
					var lteinf = false;
					//네트워크 상태에 변동이 생겼다.-처음 실행할때 또는 변동이 생긴 경
					if(appBasInfo.conType != appBasInfo.conTypeOld){  //------------------------
						appBasInfo.conTypeOld = appBasInfo.conType;
						if(appBasInfo.conType == "none"){
							
							navigator.notification.confirm('네트워크 연결 변경하세요. 취소하면 앱을 종료합니다.', function(button){
						    	if(button == 2){   //확인 
						    		messageClose(1);
						    	}else{
						    		if(navigator.network.connection.type == "none") messageClose(2);
						    	}
						    }, '질문', '취소,확인');
														
						}else{
							if(appBasInfo.conType != "wifi"){
								lteinf = true;
							}else{
								//와이파이 상태 이다.
								//비행기 보드 확인
								if(window.sessionStorage.getItem("aplinf") == "on"){
									
									navigator.notification.confirm('비행기 탑승모드에서 사용불가, 모드변경할까요? 취소하면 앱을 종료합니다.', function(button){
								    	if(button == 2){   //확인 
								    		messageClose(1);
								    	}else{
								    		messageClose(2);
								    	}
								    }, '질문', '취소,확인');
									
									
								}
							}
						}
					}else{  //--------------------------------------
						if(appBasInfo.conType == "none"){
							
							navigator.notification.confirm('네트워크 연결 변경하세요. 취소하면 앱을 종료합니다.', function(button){
						    	if(button == 2){   //확인 
						    		messageClose(1);
						    	}else{
						    		if(navigator.network.connection.type == "none") messageClose(2);
						    	}
						    }, '질문', '취소,확인');
							
						}else{
							if(appBasInfo.conType != "wifi"){
								lteinf = true;
							}else{
								//와이파이 상태 이다.
								//비행기 보드 확인
								if(window.sessionStorage.getItem("aplinf") == "on"){									
									navigator.notification.confirm('비행기 탑승모드에서 사용불가, 모드변경할까요? 취소하면 앱을 종료합니다.', function(button){
								    	if(button == 2){   //확인 
								    		messageClose(1);
								    	}else{
								    		messageClose(2);
								    	}
								    }, '질문', '취소,확인');
									
								}
							}
						}
					}  //---------------------------

					if(lteinf && appBasInfo.conType != "none" && window.sessionStorage.getItem("wifiinf") == "init"){
						navigator.notification.confirm('데이터요금이 발생 할 수 있습니다. Wifi로 전환하시겠습니까?', function(button){
					    	if(button == 2){   //삭제한다.
					    		messageClose(1);
					    	}
					    }, '질문', '취소,확인');
						window.sessionStorage.setItem("wifiinf", "ok");
					
					}else{
					}
					
				}
			}
			
		}
	
	}
	

	
	function lodinggo(){
	    $.mobile.loading( "show", {
	        text: "Loading...",
	        textVisible: true,
	        theme: "none",
	        textonly: false,
	        html: "<div style='width:80%; margin:0 10%; text-align:center; border-radius:15px; padding:1px 0;'><img src='./images/loading2.gif' width='50px'></div>"
	    });

		//console.log("====lodinggo()++++");
	}

	


	
	function datepick(obj){
		obj.datepicker({ 
			         inline: true, 
			              dateFormat: "yy-mm-dd",    /* 날짜 포맷 */ 
			              prevText: 'prev', 
			              nextText: 'next', 
			              showButtonPanel: true,    /* 버튼 패널 사용 */ 
			              changeMonth: true,        /* 월 선택박스 사용 */ 
			              changeYear: true,        /* 년 선택박스 사용 */ 
			             showOtherMonths: true,    /* 이전/다음 달 일수 보이기 */ 
			             selectOtherMonths: true,    /* 이전/다음 달 일 선택하기 */ 
			             showOn: "button", 
			             buttonImage: "img/calendar03.gif", 
			             buttonImageOnly: true, 
			             minDate: '-30y', 
			             closeText: '닫기', 
			             currentText: '오늘', 
			             showMonthAfterYear: true,        /* 년과 달의 위치 바꾸기 */ 
			             /* 한글화 */ 
			             monthNames : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'], 
			             monthNamesShort : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'], 
			             dayNames : ['일', '월', '화', '수', '목', '금', '토'],
			             dayNamesShort : ['일', '월', '화', '수', '목', '금', '토'],
			             dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
			             showAnim: 'slideDown', 
			             /* 날짜 유효성 체크 */ 
			             onClose: function( selectedDate ) { 
			                 obj.datepicker("option","minDate", selectedDate); 
			             } 
			         }); 
			       
		
	}
	
	
	//back button 클릭
	function onBackKeyDown() {
		
		
		if(pushBack){   //푸쉬에서 넘어온 경우
			pushBack = false;
			appUtil.goHome();
		}else{
			appUtil.moveBack();
		}

	}

	
	


	//html 소스 가져오기+++++++++++++++++++++++++++++++++++++
	function httpGet(szURL){

		sHttp.open("get",szURL,false);
		sHttp.setRequestHeader("Content-type:","application/s-www-form-urlencoded");
		sHttp.setRequestHeader("Content-Encoding:","utf-8");
		sHttp.onreadystatechange = onRetriveComplete;

		try{
			sHttp.send("code=tnt2");	

		}catch(e){
			return("Not Exist");
		}

		if(sHttp.status > 200){
			return("Not Exist<br>");
		}else{

			
			
			
			return(sHttp.responseText);
		}

		function onRetriveComplete(){
		
			sHttp.onreadystatechange = noop;
			if(sHttp.readyState == 4){
			
			}
		}
	}


	function noop(){

		return false;
	}

	function getHTML(url){
		var getData = httpGet(url);
		

	}
	//++++++++++++++++++++++++++++++++++++++++++++



	function myChnNumGab(){
		return;
		

		
	}


	
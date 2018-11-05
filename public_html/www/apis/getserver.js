

//============================================
//서버에서 정보를 가져온다.
function GetServer(){
	this.urlLink = LKCODE;
	this.musicBasLink = LKCODE;
	this.imgLink = LKCODE+PREDIR0+"/images/";
	this.imgLinkThum = LKCODE+PREDIR0+"/images/ThumNail/";
	
	this.pushLink = LKCODE;

	this.dirEntry = null;
	this.fileDownUrl = null;
	this.localPo = null;
	
	
	this.qr = null;
	this.param = null;
	this.fileTrans = null;
	this.mode = null;
	this.downSu = 0;      //다운로드 완료한 음원의 숫자
	this.dispDom = null;
	this.dataLen = 0;      //데이트의 갯수 
	this.domIndx = 0;        //메인메뉴와 비슷
	this.wW = window.innerWidth;
	this.domid = new Array("#miriul");   //서버에서 가져온 값을 출력하는 위치
	this.dmode = new Array("allMusic");   //서버에서 가져오는 모드 값

	this.mem = null;   //회원관련 오브젝트

}

GetServer.prototype.initFile = function(){	

	
}

GetServer.prototype.initParam = function(asp, param, mod, domid){	
	this.qr = this.urlLink+asp;
	this.param = param;
	this.mode = mod;
	this.dispDom = domid;
	
}

GetServer.prototype.initParamPush = function(asp, param, mod, domid){	
	this.qr = this.pushLink+asp;
	this.param = param;
	this.mode = mod;
	this.dispDom = domid;
}

GetServer.prototype.initParamAll = function(asp, param, mod, domid){	
	this.qr = asp;
	this.param = param;
	this.mode = mod;
	this.dispDom = domid;
}



//사업 리스트를 가져온다.
GetServer.prototype.getSaupList = function(param, obj, memobj){
	var oo = this;
	
	this.qr = LKMEM+"mobileFun/getAllSaup";
	//alert(this.qr+"----"+param+"/"+hs);
	$.ajax({type:"POST", data:{mode:"getAllSaup", seco:meminf.memSeCoId}, url:this.qr, timeout:10000, dataType:"json",success:function(data){

		//alert(data.length);
		//담당자 리스트를 출력한다.
		var tg = document.getElementById("spdsList");
		var ss = "<option value='0'>사업선택</option>";
		for(var c=0; c < data.length; c++){
			ss += "<option value='"+data[c].id+"'>"+data[c].business_nm+"</option>";
		}
		tg.innerHTML = ss;
		
		
		
		if(param > 0){
			//사업이 선택된 경우 
			$("#spdsList").val(param).attr("selected","selected");
			
			meminf.selectSaup = param;
			oo.getSaupDesang(meminf.selectDesang, oo, meminf);
		
		
		}
		
		
		

	},error:function(xhr,status,error){
		alert("err3="+error);
	}
	});
	
}




GetServer.prototype.getSaupDesang = function(param, obj, memobj){

	this.qr = CIBASE+"/scene/hjang/coSaupDesangList";
	//alert(this.qr+"----"+param+"/"+CIHS+"/"+meminf.selectSaup);
	$.ajax({type:"POST", data:{saup:meminf.selectSaup, md:"sd"}, url:this.qr, timeout:10000, dataType:"json",success:function(data){

		//alert(data.length);
		//담당자 리스트를 출력한다.
		var tg = document.getElementById("sangdamDesang");
		var ss = "<option value='0'>대상자선택</option>";
		for(var c=0; c < data.length; c++){
			ss += "<option value='"+data[c].id+"'>"+data[c].dsname+"</option>";
		}
		
		tg.innerHTML = ss;
		
		
		
		if(param > 0){
			$("#sangdamDesang").val(param).attr("selected","selected");
		
		}
		


	},error:function(xhr,status,error){
		alert("err3="+error);
	}
	});
	
}

//선택한 사업의 공사리스트를 가져온다.
GetServer.prototype.getSaupGongsa = function(param, obj, memobj){
	
	var chnval = document.getElementById("sangdamSaup").value;
	
	this.qr = LKMEM+"mobileFun/getSaupGongsa";
	//alert(this.qr+"----"+param+"/"+this.selectSaup);
	$.ajax({type:"POST", data:{mode:"getSaupGongsa", sesaup:chnval}, url:this.qr, timeout:10000, dataType:"json",success:function(data){

		//alert(data.length);
		//담당자 리스트를 출력한다.
		var tg = document.getElementById("sangdamGongsa");
		var ss = "<option value='0'>공사선택</option>";
		for(var c=0; c < data.length; c++){
			ss += "<option value='"+data[c].id+"'>"+data[c].gsname+"</option>";
		}
		
		tg.innerHTML = ss;
		


	},error:function(xhr,status,error){
		alert("err3="+error);
	}
	});
	
}



GetServer.prototype.getDamdang = function(param, obj, memobj){

	
	this.qr = LKMEM+"mobileFun/getDamdang";
	//alert(this.qr+"----"+param+"/"+hs);
	$.ajax({type:"POST", data:{mode:"getDamdang", seco:meminf.memSeCoId}, url:this.qr, timeout:10000, dataType:"json",success:function(data){

		//alert(data.length);
		//담당자 리스트를 출력한다.
		var tg = document.getElementById("damdang");
		var ss = "<option value='0'>담당자선택</option>";
		for(var c=0; c < data.length; c++){
			ss += "<option value='"+data[c].id+"'>"+data[c].memid+"</option>";
		}
		
		tg.innerHTML = ss;
		


	},error:function(xhr,status,error){
		alert("err3="+error);
	}
	});
	
}



GetServer.prototype.chnPotionPro = function(param, hs, obj, memobj){
	
	
	this.qr = CIBASE+"/member/main/memPoChn/"+meminf.seRecid+"/"+param;
	//alert(this.qr+"----"+param+"/"+hs);
	$.ajax({type:"POST", data:{memid:param, ci_t:hs}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		if(data.mid == 0){
			
			meminf.dispAfterMess(".mess", data.rt, 3);
		}else{
			
			appUtil.alertgo("알림","직책이 변경되었습니다.");
			
			meminf.dispAfterMess(".mess", data.rt, 3);
			
			$(".jpotion span").html(meminf.poName(data.po));
			$("#tr-"+meminf.seRecid+" .tdpotion").html(meminf.poName(data.po));  //회원리스트의 직책도 변경 한다.	
			
		}
	},error:function(xhr,status,error){
		//alert("err3="+error);
	}
	});
	
}




//사업자 등록번호 중복확인을 한다.
GetServer.prototype.snMemoryInf = function(param, hs, obj, memobj){
	this.qr = LKMEM+"snOkInf";
	//alert(this.qr+"----"+param);
	$.ajax({type:"POST", data:{conum:param, ci_t:hs}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		//alert("conum=="+data.conum+"/"+data.rs);
		
		if(data.rs > 0){   //기존에 등록된 아이디 입니다.
			
			memobj.snGoOkInf = false;
			memobj.snGoOkId = "";
			appUtil.alertgo("알림", "등록된 사업자 등록번호입니다.");
				
		}else{   //존재하지 않는 아이디 이다.
			
			memobj.snGoOkInf = true;
			memobj.snGoOkId = param;
			appUtil.alertgo("알림", "사용가능한 사업자 등록번호 입니다.");
			
			
		}
		
	},error:function(xhr,status,error){
		alert("err="+error);
	}
	});
	
}




//이메일 중복확인을 한다.
GetServer.prototype.emMemoryInf = function(param, hs, obj, memobj){
	this.qr = LKMEM+"emOkInf";
	//alert(this.qr+"----"+param);
	$.ajax({type:"POST", data:{email:param, ci_t:hs}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		
		if(data.rs > 0){   //기존에 등록된 아이디 입니다.
			
			memobj.emGoOkInf = false;
			memobj.emGoOkId = "";
			appUtil.alertgo("알림", "등록된 이메일 입니다.");
				
		}else{   //존재하지 않는 아이디 이다.
			
			memobj.emGoOkInf = true;
			memobj.emGoOkId = param;
			appUtil.alertgo("알림", "사용가능한 이메일 입니다.");
			
			
		}
		
	},error:function(xhr,status,error){
		alert("err="+error);
	}
	});
	
}



//
GetServer.prototype.idMemoryInf = function(param, hs, obj, memobj){
	this.qr = LKMEM+"idOkInf";
	//alert(this.qr+"----"+param);
	$.ajax({type:"POST", data:{memid:param, ci_t:hs}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		
		if(data.rs > 0){   //기존에 등록된 아이디 입니다.
			
			memobj.idGoOkInf = false;
			memobj.idGoOkId = "";
			appUtil.alertgo("알림", "등록된 아이디 입니다.");
				
		}else{   //존재하지 않는 아이디 이다.
			
			memobj.idGoOkInf = true;
			memobj.idGoOkId = param;
			appUtil.alertgo("알림", "사용가능한 아이디 입니다.");
			
			
		}
		
	},error:function(xhr,status,error){
		alert("err="+error);
	}
	});
	
}



//웹에서로그인한다.===============================================
GetServer.prototype.webLogin = function(param, hs, obj, memobj){
	var val = param.split(":");
	this.qr = LKCODE+"authWeb";
	
	//alert(this.qr+"///"+param);
	
	//location.href = CIBASE+"/homect/homect/getView/1/1/1";
	//return;
	
	$.ajax({type:"POST", data:{memid:val[0], passwd:val[1], ci_t:hs}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		//alert(data);
	
		if(data.rs == "ok"){
			
			//회원정보를 저장한다.
			memobj.memid = val[0];    //회원아이디
			//memobj.tel = Base64.decode(data.tel);
			//memobj.UserA = data[0].UserA;
			//memobj.memName = Base64.decode(data.name);
			memobj.memPo = data.po;  //직책
			memobj.memCoId = data.coid;    //
			memobj.memSeCoId = data.coid;    //
			memobj.memGubun = data.cogb;
			
			//alert(data.coid);
			
			
			window.localStorage.setItem("memid", memobj.memid);
			window.localStorage.setItem("loginStat", "ok");
			
			memobj.loginStat = true;

			
			
			location.href = CIBASE+"/homect/homect/getView/1/1/1";
		}else{
			
			location.href = CIBASE+"/home";
		
		}
	
	},error:function(xhr,status,error){
		alert("err="+error+"///"+xhr.responseText);
	}
	});
	
}
//=======================================================================


/*
GetServer.prototype.getPostLogin = function(obj, memobj){
	var val = this.param.split(":");
	$.ajax({type:"POST", data:{memid:val[0], pss:val[1]}, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		if(data.rs > 0){   //로그인 되었다.
			
			//회원정보를 저장한다.
			memobj.memid = val[0];    //회원아이디
			memobj.tel = Base64.decode(data.tel);
			//memobj.UserA = data[0].UserA;
			memobj.memName = Base64.decode(data.name);
			memobj.memPo = data.potion;  //직책
			memobj.memCoId = data.coid;    //
			
			window.localStorage.setItem("memid", memobj.memid);
			window.localStorage.setItem("loginStat", "ok");
			
			memobj.loginStat = true;
			
				
				if(appBasInfo.nowPage == "page"){
					//왼쪽 메뉴 출력
					//insertLeftMenu.dispMenu(memobj.loginStat);
				}else{
					appUtil.goHome();
				}
				
		}else{   //로그인 않되었다.
			window.localStorage.setItem("memidps", "0");
			
			window.localStorage.setItem("loginStat", "no");
			memobj.loginStat = false;
			//로그인 실패
			appUtil.alertgo("알림","로그인 실패 하였습니다. 아이디와 비밀번호를 다시 확인하세요.");
		}
		
	},error:function(xhr,status,error){
		alert("err="+error);
	}
	});
	
}
*/


GetServer.prototype.getPostModeTxt = function(obj, memobj){

	//전체 음원리스트를 가져온다.
	//var indx = this.domIndx;
	var mode = this.mode;
	
	this.mem = memobj;
	
	//alert(mode+"/"+this.qr+"/"+this.param);
	
	$.ajax({type:"POST", data:this.param, url:this.qr, timeout:10000, dataType:"text",success:function(data){
		
		
		switch(mode){
		case "meJangList":   //매장리스트를 출력 
			//alert(data);
			
			break;
		case "PushInfoSet":
			
			//alert(data);
			
			break;
		case "pushSendDabGo":  //푸시발사결과
			
			//alert(data);
			
			
			break;	
		case "jumunDelete":   //주문게시판 삭제
			
			if(data == "[{'rs':'ok'}]"){
				
				appUtil.alertgo("알림","삭제 완료하였습니다.");
				appUtil.moveOkHistory("index.html#JumunBDList");
				
			}else{
				appUtil.alertgo("알림","삭제 실패 다시 시도해 보세요.");
			}
			
			break;
		case "ctDelete":   //주문게시판 본문 삭제 
			//이미지 재정렬
			if(data == "[{'rs':'ok'}]"){
				
				appUtil.alertgo("알림","삭제 완료하였습니다.");
				appUtil.moveOkHistory("index.html#page");
				
			}else{
				appUtil.alertgo("알림","삭제 실패 다시 시도해 보세요.");
			}

			
			break;
		case "imgReSortNow":
			//이미지 재정렬
			if(data == "[{'rs':'ok'}]"){

				//이미지를 가져온다.
				var jbd = new GetServer();
				jbd.initParam("nowFieldPro.php", "mode=C02&Indx="+appBasInfo.nowJmIndx, "ContentSSImg", "mu");
				jbd.getPostMode(jbd, memobj);  //서버에서 post 모드로 가져온다.

				
			}else{
				appUtil.alertgo("알림","삭제 실패 다시 시도해 보세요.");
			}
			
			
			
			break;
		case "deleteSeImg":     //이미지를 삭제한다.
			
			if(data == "[{'rs':'ok'}]"){

				//이미지를 가져온다.
				var jbd = new GetServer();
				jbd.initParam("nowFieldPro.php", "mode=C02&Indx="+appBasInfo.nowJmIndx, "ContentSSImg", "mu");
				jbd.getPostMode(jbd, memobj);  //서버에서 post 모드로 가져온다.

				
			}else{
				appUtil.alertgo("알림","삭제 실패 다시 시도해 보세요.");
			}
			
			break;
		case "ContentJMDetOn":   //주문게시판에 댓글을 단다.
			
			if(data == "[{'rs':'ok'}]"){
				$("#jmDetCont").val('');
				$("#jmDapCont").val('');
				
				appBasInfo.imsiDet = "";
				appBasInfo.imsiDap = "";
				
				obj.jmDetTextList(memobj);   //주문게시판의 댓글을 출력한다.
				
								
			}else{
				appUtil.alertgo("알림","등록/수정 실패입니다. 다시 시도해 보세요.");
			}
		
				break;
		case "ContentSSDetOn":    //댓글 등록 
			
			if(data == "[{'rs':'ok'}]"){
				$("#ssDetCont").val('');
				$("#ctDapCont").val('');
				
				appBasInfo.imsiDet = "";
				appBasInfo.imsiDap = "";
				
				//컨텐츠 댓글을 가져온다.
				obj.ctDetTextList(memobj);
				
			}else{
				appUtil.alertgo("알림","등록/수정 실패입니다. 다시 시도해 보세요.");
			}

			
			break;
		case "memOnputTest":
			
			//alert(data);
			
			/*
			
			if(data.rs == "ok"){
				
					//가입성공
					//memobj.memid = memobj.idGoOkId;
					appUtil.alertgo("알림","회원가입 성공하였습니다. 로그인 페이지로 갑니다.");
					appUtil.moveOkHistory("index.html#Login");

			}else{
				//가입실패
				appUtil.alertgo("알림","회원가입 실패 하였습니다. 다시 시도해 주세요.");
			}
			*/
			
			
			break;
		case "memOnput":
			
			
			if(obj.memOnPutPro(data)){
				
				if(appBasInfo.leftMenuTextAll == "회원가입"){
					//가입성공
					memobj.memid = memobj.idGoOkId;
					appUtil.alertgo("알림","회원가입 성공하였습니다. 로그인 페이지로 갑니다.");
					appUtil.moveOkHistory("index.html#Login");
				}else{
					//회원정보 수정 성공
					memobj.memid = memobj.idGoOkId;
					appUtil.alertgo("알림","개인정보 수정하였습니다. 다시 로그인 하세요.");
					appUtil.moveOkHistory("index.html#Login");
				}
				

			}else{
				//가입실패
				appUtil.alertgo("알림","회원가입 실패 하였습니다. 다시 시도해 주세요.");
			}
			
			
			
			break;
		}
		
		
	},error:function(xhr,status,error){
		alert("err="+error);
	}
	});
	
}

//주문게시판의 댓글을 가져온다.
GetServer.prototype.jmDetTextList = function(memobj){
	//주문게시판 댓글을 가져온다.
	var jbd1 = new GetServer();
	var dom1 = document.querySelector("#jmBddetList");
	jbd1.initParam("nowFieldPro.php", "mode=D04&Indx="+appBasInfo.jumunBdIndex, "jumunBDVDet", dom1);
	jbd1.getPostMode(jbd1, memobj);  //서버에서 post 모드로 가져온다.
}

//컨텐츠게시판의 댓글을 가져온다.
GetServer.prototype.ctDetTextList = function(memobj){
	//주문게시판 댓글을 가져온다.
	var jbd1 = new GetServer();
	var dom1 = document.querySelector("#ctBddetList");
	jbd1.initParam("nowFieldPro.php", "mode=C03&Indx="+appBasInfo.nowJmIndx, "ContentSSDet", dom1);
	jbd1.getPostMode(jbd1, memobj);  //서버에서 post 모드로 가져온다.
}


//생성한 인스턴스 obj와 회원 오브젝트를 넘겨 준다.
GetServer.prototype.getPostMode = function(obj, memobj){

	//전체 음원리스트를 가져온다.
	var indx = this.domIndx;
	var mode = this.mode;
	
	this.mem = memobj;
	
	//alert(this.param);
	$.ajax({type:"POST", data:this.param, url:this.qr, timeout:10000, dataType:"json",success:function(data){
		
		//alert(data.rs.length);
		
		switch(mode){
		case "fileDown":
			
			//alert("data.rs="+data.rs);
			
			break;
		case "blogWr":
			
			
			//alert(data.rs);
			
			break;
		case "jumunjiy":   //주문게시판의 지역 가져온다.
			
			obj.jumunJiy(data);
			
			break;
		case "idGoOK":   //아이디 중복확인 
			
			if(obj.idGoOkPro(data.rs)){
				appUtil.alertgo("알림","사용가능한 아이디 입니다.");
				memobj.idGoOkInf = true;
				
				var em1 = document.getElementById("email1").value;
				var em2 = document.getElementById("email2").value;
				
				memobj.idGoOkId = em1+"@"+em2;
				document.getElementById("name").focus();
			}else{
				appUtil.alertgo("알림","이미 가입된 아이디 입니다. 다른 아이디를 사용하세요.");
				memobj.idGoOkInf = false;
				document.getElementById("email1").focus();
			}
			
			break;
		case "memLoginAuto":
		case "memLogin":
			
			//alert(data.length);
			
			if(data.rs.length < 1){
				
				window.localStorage.setItem("memidps", "0");
				
				window.localStorage.setItem("loginStat", "no");
				memobj.loginStat = false;
				//로그인 실패
				appUtil.alertgo("알림","로그인 실패 하였습니다. 아이디와 비밀번호를 다시 확인하세요.");
				
			}else{
				//회원정보를 저장한다.
				memobj.memid = data.rs[0].memid;    //회원아이디
				memobj.tel = Base64.decode(data.rs[0].tel);
				//memobj.UserA = data[0].UserA;
				memobj.memName = Base64.decode(data.rs[0].name);
				memobj.memPo = data.rs[0].potion;  //직책
				memobj.memCoId = data.rs[0].coid;    //
				
//alert("로그인 성공"+memobj.memName+"/"+memobj.memPo);
				
				
				window.localStorage.setItem("memid", memobj.memid);
				window.localStorage.setItem("loginStat", "ok");
				
				memobj.loginStat = true;
				
					
					if(appBasInfo.nowPage == "page"){
						//왼쪽 메뉴 출력
						//insertLeftMenu.dispMenu(memobj.loginStat);
					}else{
						appUtil.goHome();
					}
					
				
			}
			
			
			break;
		case "jumunBDVDet":   //주문게시판의 댓글 출력 
			obj.jumunBDVDetDisp(data);
			
			break;
		case "jumunBDV":   //주문보드 게시판 상세보기
			obj.jumunBDVDisp(data);
			
			break;
		case "contentList":   //전체 이미지 리스트를 가져온다.
			
			if(AWtrans.mobileInf) obj.liAlbum3(data);
			else obj.liAlbum4(data);
			
			break;
		case "contentListOnBlog":   //블로그에 등록하기 위해 상세보기로 간다.
			
			//내용으로 검색하여 한개의 상품을 가져와서 상품의 상세보기 페이지에서 블로그에 등록처리 한다.
			appBasInfo.nowJmIndx = data[0].Indx;
			//제품의 상세정보를 가져오고 이어서 이미지 정보를 가져온 후 블로그에 등록한다.
			var jbd = new GetServer();
			jbd.initParam("nowFieldPro.php", "mode=C01&Indx="+appBasInfo.nowJmIndx, "ContentSSBlog", "mu");
			jbd.getPostMode(jbd, memobj.mem);  //서버에서 post 모드로 가져온다.
			
			
			break;
		case "ContentSS":   //컨텐츠 상세보기 
			obj.contentSSFun(data);
			
			break;
		case "ContentSSBlog":   //컨텐츠 상세보기 
			obj.contentSSBlog(data);
			
			break;
		case "ContentSSDet":   //컨텐츠 댓글 출력
			obj.contentSSDetDisp(data);
			
			break;
		case "ContentSSImg":   //컨텐츠 이미지보기
			obj.contentSSImgFun(data, obj);
			
			break;
		case "ContentSSImgBlog":   //컨텐츠 이미지보기
			obj.contentSSImgBlog(data, obj);
			
			break;
		case "allBdList":   //전체 주문게시판 리스트를 출력
			obj.allLiList(data);
			
			break;
		case "meJangList":   //매장리스트를 출력 
			obj.meJangList(data);
			
			break;
		case "meJangSsDisp":   //매장의 상세정보를 가져온다.
			obj.meJangSsDisp(data);
			
			break;
		case "leftCode":   //왼쪽 메뉴의 제품별 코드와 이름 출력한다.
			obj.leftCodeAll(data);
			
			break;
		case "upjongCode":  //왼쪽 메뉴의 업종별 코드와 이름 출력한다.
			obj.upjongCodeAll(data);
			
			break;
		}
		

		
	},error:function(xhr,status,error){

		//alert("err="+error);
		switch(mode){
		case "memLoginAuto":
		case "memLogin":
			//회원정보를 초기화 한다.
			memobj.gabInit();
			window.localStorage.setItem("loginStat", "no");
			appUtil.alertgo("알림", "로그인 실패 입니다. 다시 하세요.");
			insertLeftMenu.dispMenu(memobj.loginStat);	
			
			window.localStorage.setItem("memidps", "0");
			
			
			break;
		case "idGoOK":   //아이디 중복확인 
		case "meJangSsDisp":
		case "jumunBDVDet":   //주문게시판의 댓글 출력 
		case "jumunBDV":
		case "leftCode":   //왼쪽 메뉴의 코드와 이름 출력한다.
		case "allBdList":   //전체 주문게시판 리스트를 출력
		case "meJangList":   //매장리스트를 출력 
		case "contentList":
			appUtil.alertgo("알림", "이미지 업로드 작업중으로 잠시 지체 됩니다. 조금뒤 다시 실행해 주세요.");
			
			break;
		}
		

		
	}
	});
	
	
}

//주문게시판의 지역을 가져온다.
GetServer.prototype.jumunJiy = function(dat){
	var kk = dat.length;
	var ss = "";
	for(var c = 0; c < kk; c++){
		ss += "<option value='"+dat[c].Seq+"'>"+dat[c].SectNm+"</option>";
	}
	
	this.dispDom.innerHTML = ss;
	$("select#UserDjiy").selectmenu("refresh");		
	
	
}



//컨텐츠 이미지 모두가져오기
GetServer.prototype.contentSSImgFun = function(dat, obj){

	appBasInfo.allImgSu = dat.length;
	if(dat.length > 0){
		var dd = "#ContentSS2 div table.joinTb tr td ul ";

		
		//글과 이미지의 수정권한 부여
		this.mem.EditContInf = false;   //수정불가
		if(this.mem.UserA == dat[0].UserA){
			this.mem.EditContInf = true;  //수정가능
		}
		
		
		if(appBasInfo.contBasDui == 2){
			//수정모드 이미지 출력
			if(!this.mem.EditContInf){
				appUtil.alertgo("알림","작성자만 수정 가능 합니다.");
				return;
			}
			
			
			
			if(appBasInfo.allImgSu < 6) appBasInfo.nowSumCount = 5;
			if(appBasInfo.allImgSu > appBasInfo.nowSumCount) appBasInfo.nowSumCount = appBasInfo.allImgSu;

			var kk = appBasInfo.nowSumCount + 1;
			
			for(var c=kk; c < 11; c++){
				document.getElementById("sumc"+c).style.display = "none";
			}
			
			for(var i=0; i < dat.length; i++){
				//현재 이미지 출력
				document.querySelector("#onImg"+i+" ul li.vimg img").src = obj.imgLink+dat[i].FileNm;
				//시킨스 값을 설정한다.
				document.getElementById("seq"+(i+1)).value = dat[i].Seq;
				
			}
			
			
			
		}else{
			//상세보기 이미지 출력

			
			//대표이미지 출력
			if(appBasInfo.allImgSu > 0){
				var yy = document.querySelector(dd+"li div.deImg");
				var oo = "";
				oo += "<div id='imgClip"+dat[0].SortA+"' class='imgClip'>";
				
				//oo += "<div class='imgClipTop' onclick='appUtil.movImg(\""+obj.imgLink+dat[0].FileNm+"\")'></div>";
				
				oo += "<a href='#' onclick='appUtil.movImg(\""+obj.imgLink+dat[0].FileNm+"\")'><img src='"+obj.imgLink+dat[0].FileNm+"' style='width:100%; margin:0 0 10px;'></a>";
				
				if(this.mem.EditContInf){
					oo += '<ul class="imgUpDown">';
					oo += '<li><a href="#" onclick="appBasInfo.upSeqImg('+dat[0].Seq+', '+dat[0].SortA+')"><img src="./images/bts_up.png" width="24px;"></a></li>';
					oo += '<li><a href="#" onclick="appBasInfo.delSeqImg('+dat[0].Seq+', '+dat[0].SortA+')"><img src="./images/bts_del.png" width="24px;"></a></li>';
					oo += '<li><a href="#" onclick="appBasInfo.downSeqImg('+dat[0].Seq+', '+dat[0].SortA+')"><img src="./images/bts_down.png" width="24px;"></a></li>';
					
					//oo += '<li><a href="#" onclick="appUtil.fileDownUtil(\''+dat[0].FileNm+'\')"><span style="color:#ccc;">Down</span></a></li>';
					
					oo += '</ul>';					
				}else if(this.mem.memEmp == 1){
					//oo += '<ul class="imgUpDown">';
					//oo += '<li><a href="#" onclick="appUtil.fileDownUtil(\''+dat[0].FileNm+'\')"><span style="color:#ccc;">Down</span></a></li>';
					//oo += '</ul>';
				}
				
				
				
				oo += "</div>";
				yy.innerHTML = oo;
				
				
				
				
				//기타이미지 출력
				var ss = "";
				for(var c=1; c < appBasInfo.allImgSu; c++){
					
					ss += "<div id='imgClip"+dat[c].SortA+"' class='imgClip'>";
					
					//ss += "<div class='imgClipTop' onclick='appUtil.movImg(\""+obj.imgLink+dat[0].FileNm+"\")'></div>";
					
					ss += "<a href='#' onclick='appUtil.movImg(\""+obj.imgLink+dat[c].FileNm+"\")'><img src='"+obj.imgLink+dat[c].FileNm+"' width='100%'></a>";
					
					if(this.mem.EditContInf){
						ss += '<ul class="imgUpDown">';
						ss += '<li><a href="#" onclick="appBasInfo.upSeqImg('+dat[c].Seq+', '+dat[c].SortA+')"><img src="./images/bts_up.png"></a></li>';
						ss += '<li><a href="#" onclick="appBasInfo.delSeqImg('+dat[c].Seq+', '+dat[c].SortA+')"><img src="./images/bts_del.png"></a></li>';
						ss += '<li><a href="#" onclick="appBasInfo.downSeqImg('+dat[c].Seq+', '+dat[c].SortA+')"><img src="./images/bts_down.png"></a></li>';
						//ss += '<li><a href="#" onclick="appUtil.fileDownUtil(\''+dat[c].FileNm+'\')"><span style="color:#ccc;">Down</span></a></li>';
						ss += '</ul>';
						
					}else if(this.mem.memEmp == 1){
						//ss += '<ul class="imgUpDown">';
						//ss += '<li><a href="#" onclick="appUtil.fileDownUtil(\''+dat[0].FileNm+'\')"><span style="color:#ccc;">Down</span></a></li>';
						//ss += '</ul>';
					}
					
					
					ss += "</div>";
					
						
				}
				document.querySelector(dd+"li div.allImg").innerHTML = ss;
			
				

			}
			
		}

		
		
		
		
	}
	
}



//블로그에 등록하기 위해 컨텐트이미지를 모두 가져온다.
GetServer.prototype.contentSSImgBlog = function(dat, obj){

	//상세보기 이미지 출력
	appBasInfo.blogAllImg = "";
	appBasInfo.allImgSu = dat.length;
	if(dat.length > 0){

			
			//대표이미지 출력
			appBasInfo.blogAllImg = obj.imgLink+dat[0].FileNm+"^^";
				
	
			//기타이미지 출력
			for(var c=1; c < appBasInfo.allImgSu; c++){		
				appBasInfo.blogAllImg += obj.imgLink+dat[c].FileNm+"^^";	
			}

				//블로그관련컨텐츠를블로그에등록한다.===============
						//상품을 블로그에 등록한다.
						appBasInfo.blogOnInf = false;
						
						var gg = new GetServer();
						//내용을 브로그에 등록한다.-test
						var modegab = "mode=textBlogOn&tit="+appUtil.input_smstext(appBasInfo.blogTitle, 0)+"&cont="+appUtil.input_smstext(appBasInfo.blogCont, 0)+"&cate="+appUtil.input_smstext(appBasInfo.blogCate, 0)+"&tel="+appUtil.input_smstext(appBasInfo.blogTel, 0)+"&cotel="+appUtil.input_smstext(appBasInfo.blogCoTel, 0)+"&img="+appBasInfo.blogAllImg;				
						gg.initParamPush("NowFieldPro.php", modegab, "blogWr", "mu");
						gg.getPostMode(gg, this.mem);  //서버에서 post 모드로 가져온다.
						
				//========================================
				
		
	}
	
}



//블로그등록을 위해 상세정보를 가져온다.
GetServer.prototype.contentSSBlog = function(dat){
		
		var aa = new Array();
		var bb = new Array();
		var telgb = new Array();
		var telgb2 = new Array();
		if(!dat[0].UserNm){
			aa[0] = "담당";
			telgb[0] = "00";
			telgb[1] = "미상)";
			bb[0] = "지점";
			telgb2[0] = "00";
			telgb2[1] = "미상";
		}else{
			aa = dat[0].UserNm.split(" : ");
			telgb = aa[1].split("(");
			aa[0] = aa[0].replace("연락처", "");
			
			bb = dat[0].DeptNm.split(" : ");
			bb[0] = bb[0].replace("연락처", "");
			telgb2 = bb[1].split(" ");
		}

		
		//블로그관련초기값설정===============================
		appBasInfo.blogTitle = "";
		appBasInfo.blogCont = "";
		appBasInfo.blogTel = "";
		appBasInfo.blogCoTel = "";
		
		if(appBasInfo.blogOnInf){
			appBasInfo.blogTitle = dat[0].Title;
			appBasInfo.blogCont = appUtil.disp_rttext(dat[0].CONT, 0);
			appBasInfo.blogTel = telgb[0];
			appBasInfo.blogCoTel = telgb2[0];
		}
		//==================================================
		
		var jbd = new GetServer();
		//이미지정보를 가져와서 블로그에 등록한다.
		jbd.initParam("nowFieldPro.php", "mode=C02&Indx="+appBasInfo.nowJmIndx, "ContentSSImgBlog", "mu");
		jbd.getPostMode(jbd, this.mem);  //서버에서 post 모드로 가져온다.

		
}






//컨텐츠 상세보기-실제출력
GetServer.prototype.contentSSFun = function(dat){
	
	this.mem.contWr = dat[0].UserA;
	
	//글과 이미지의 수정권한 부여
	this.mem.EditContInf = false;   //수정불가
	if(this.mem.UserA == dat[0].UserA){
		this.mem.EditContInf = true;  //수정가능
	}
	
	
	if(appBasInfo.contBasDui == 1){   //상세보기 모드의 경우 		
		
		
		document.getElementById("editGoMain").style.display = "none";
		document.getElementById("editGoMain2").style.display = "none";
		if(this.mem.EditContInf){
			document.getElementById("editGoMain").style.display = "block";
			document.getElementById("editGoMain2").style.display = "none";
		}else{
			document.getElementById("editGoMain").style.display = "none";
			document.getElementById("editGoMain2").style.display = "block";
		}

		
		
		
		
		if(this.mem.loginStat){
			//로그인 했다.
			document.querySelector(".detTextCase").style.display = "block";
			document.querySelector(".detOnPUtTbNoLogin").style.display = "none";
		}else{
			//로그인 않했다.
			document.querySelector(".detTextCase").style.display = "none";
			document.querySelector(".detOnPUtTbNoLogin").style.display = "block";
		}
		
		

		
		if((this.mem.memEmp == 1 || this.mem.UserA == dat[0].UserA) && this.mem.loginStat){
			
			if(dat[0].FileNm){
				var dd = "<ul><li>"+dat[0].FileNm+"</li><li><img src='./images/bts_down.png' onclick='appUtil.addUpfileDown(\""+dat[0].FileNm+"\")'></li></ul>";
				document.getElementById("ssFileUpDown").innerHTML = dd;
			}else{
				document.getElementById("ssFileUpDown").innerHTML = "첨부파일없음";
			}
			
		}else{
			document.getElementById("ssFileUpDown").innerHTML = "비공개";
		}

		
		
		
		
		var dd = "#ContentSS2 div div div table.joinTb tr td ul ";
		document.querySelector(dd+"li.Indx").innerHTML = dat[0].Indx;
		document.querySelector(dd+"li.SectNm").innerHTML = dat[0].SectNm;
		document.querySelector(dd+"li.TypeC").innerHTML = dat[0].TypeC;
		document.querySelector(dd+"li.TypeD").innerHTML = dat[0].TypeD;
		
		document.querySelector(dd+"li.Title").innerHTML = dat[0].Title;
		document.querySelector(dd+"li div.CONT").innerHTML = appUtil.disp_rttext(dat[0].CONT, 0);
		document.querySelector(dd+"li.Keyword").innerHTML = dat[0].Keyword;
		appBasInfo.nowWriter = dat[0].UserA;   //현재 제품의 등록자		

		
		var aa = new Array();
		var bb = new Array();
		var telgb = new Array();
		var telgb2 = new Array();
		if(dat[0].UserNm == null){
			aa[0] = "담당";
			telgb[0] = "00";
			telgb[1] = "미상)";
			bb[0] = "지점";
			telgb2[0] = "00";
			telgb2[1] = "미상";
		}

		if(dat[0].UserNm){
				
			aa = dat[0].UserNm.split(" : ");
			telgb = aa[1].split("(");
			aa[0] = aa[0].replace("연락처", "");
			
			bb = dat[0].DeptNm.split(" : ");
			bb[0] = bb[0].replace("연락처", "");
			telgb2 = bb[1].split(" ");
		
		}
		
		//지도관련 정보를 구한다.
		var ll = dat[0].DeptMap.split(", ");
		
		
		
		document.querySelector(dd+"li span.UserNm").innerHTML = aa[0]+" : "+telgb[0]+" ("+telgb[1]+" <img src='./images/tel.png' onclick='appUtil.callTel(\""+telgb[0]+"\")'></a>"; //dat[0].UserNm;
		
		
		document.querySelector(dd+"li span.DeptNm").innerHTML = bb[0]+" : "+telgb2[0]+" "+telgb2[1]+" <img src='./images/tel.png' onclick='appUtil.callTel(\""+telgb2[0]+"\")'><span class='mapSpan'><a href='#' onclick='mapObjSS.getMapSSD()'><img src='./images/m_bt_map.png'></a></span>";
	
		
		parCo.latPo = Number(ll[0]);
		parCo.langPo = Number(ll[1]);
		parCo.sangho = dat[0].Title;
		
	
	}else{
		
		if(!this.mem.EditContInf){
			appUtil.alertgo("알림","작성자만 수정 가능 합니다.");
			return;
		}
		
		
		//수정모드의 경우
		$("#Dui").val(appBasInfo.contBasDui);
		$("#Indx").val(dat[0].Indx);
		
		//수정모드의 경우

		var ccc = dat[0].TypeC;
		var tyC = ccc.split(" ~");
		$("select#TypeC").val(tyC[0]).attr("selected", "selected");
		$("#TypeC").selectmenu("refresh");	
		
		//작업금액
		ccc = dat[0].TypeD;
		var tyD = ccc.split(" ~");
		$("#TypeD").val(tyD[0].replace("0000",""));

		
		$("#Title").val(dat[0].Title);
		
		$("#Cont").val(dat[0].CONT);
		$("#NoteA").val(dat[0].Keyword);

		//alert("user="+dat[0].UserA+"/ indx="+dat[0].Indx);
		
		$("#SumCount").val(5);
		$("#UserA").val(dat[0].UserA);
		
		
		$("select#TypeA").val(dat[0].TypeA).attr("selected", "selected");
		$("#TypeA").selectmenu("refresh");
		
		$("select#TypeB").val(dat[0].TypeB).attr("selected", "selected");
		$("#TypeB").selectmenu("refresh");		
			
		

		if(!dat[0].DSecret) dat[0].DSecret = 2;
		if(dat[0].DSecret == 1){
			$("#DSecret").attr("checked", true);
			$("#DSecret").checkboxradio("refresh");
		}else{
			$("#DSecret").attr("checked", false);
			$("#DSecret").checkboxradio("refresh");
		}

		
	}


}

//중복확인 결과 처리한다.
GetServer.prototype.memOnPutPro = function(dat){

	var rt = false;
	if(dat == "[{'rs':'ok'}]"){
		//회원가입 완료
		rt = true;
	}
	
	return rt;
}

//중복확인 결과 처리한다.
GetServer.prototype.idGoOkPro = function(dat){

	var rt = false;
	if(dat.length < 1){
		//사용가능한 이메일
		rt = true;
		
	}else{
		//사용불가능한 아이디
		rt = false;
		
	}
	
	return rt;
}



//컨텐츠 댓글 출력 
GetServer.prototype.contentSSDetDisp = function(dat){
	
	var kk = dat.length;
	var td = document.querySelectorAll(".jumunBDVTBDet td");  //전체 댓글의 갯수 출력
	td[1].innerHTML = kk;
	
	var ss = "";
	for(var c = 0; c < kk; c++){
		ss += "<li class='detLineLi'>";
		ss += "<ul><li class='userB'>"+dat[c].UserB+"</li><li class='dateR'>"+dat[c].DateR+"</li></ul>";
		ss += "<div id='Cont"+dat[c].Seq+"' class='Cont'>"+appUtil.disp_rttext(dat[c].Cont, 0)+"</div>";
		
		
		if(this.mem.loginStat && (this.mem.UserA  == dat[c].UserA)){
			ss += "<ul class='dapWrBtn'>";
			ss += "<li><a href='#' onclick='appBasInfo.ctDabEdt("+dat[c].Seq+", 0, \""+dat[c].Cont+"\")'><span>수정</span></a></li>";
			ss += "<li><a href='#' onclick='appBasInfo.ctDetDel("+dat[c].Seq+", 0)'><span>삭제</span></a></li>";
			//ss += "<li><a href='#' onclick='appBasInfo.ctDabOn("+dat[c].Seq+", "+dat[c].Seq+", \""+dat[c].UserA+"\")'><span>답글</span></a></li>";
			ss += "</ul>";
			
			ss += "<div id='ctDabPo"+dat[c].Seq+"' style='width:100%;'></div>";
		}else if(this.mem.loginStat && ((this.mem.contWr == this.mem.UserA && this.mem.UserA  != dat[c].UserA) || (this.mem.contWr == dat[c].UserA && this.mem.UserA != dat[c].UserA))){
				ss += "<ul class='dapWrBtn'>";
				ss += "<li><a href='#' onclick='appBasInfo.ctDabOn("+dat[c].Seq+", "+dat[c].Seq+", \""+dat[c].UserA+"\")'><span>답글</span></a></li>";
				ss += "</ul>";
				
				ss += "<div id='ctDabPo"+dat[c].Seq+"' style='width:100%;'></div>";
		}

		ss += "</li>";
	}
	
	//alert("ss2="+ss);
	
	this.dispDom.innerHTML = ss;
	
	$("#ssDetCont").val(appBasInfo.imsiDet);
	$("#ctDapCont").val(appBasInfo.imsiDap);
	
	
}


//주문게시판 댓글 및 답글 출력
GetServer.prototype.jumunBDVDetDisp = function(dat){
	var kk = dat.length;
	var td = document.querySelectorAll(".jumunBDVTBDet td");  //전체 댓글의 갯수 출력
	td[1].innerHTML = kk;
	
	var ss = "";
	for(var c = 0; c < kk; c++){
		ss += "<li class='detLineLi'>";
		ss += "<ul><li class='userB'>"+dat[c].UserB+"</li><li class='dateR'>"+dat[c].DateR+"</li></ul>";
		ss += "<div id='Cont"+dat[c].Seq+"' class='Cont'>"+appUtil.disp_rttext(dat[c].Cont, 0)+"</div>";
		
		if(this.mem.loginStat && (this.mem.UserA  == dat[c].UserA)){
			//주문게시판의 작성자 이거나 댓글 또는 답글의 작성자 이면 관리가능하다.
			ss += "<ul id='dapWrBtn' class='dapWrBtn'>";
			ss += "<li><a href='#' onclick='appBasInfo.jumunDabEdt("+dat[c].Seq+", 0, \""+dat[c].Cont+"\")'><span>수정</span></a></li>";
			ss += "<li><a href='#' onclick='appBasInfo.jumunDetDel("+dat[c].Seq+", 0)'><span>삭제</span></a></li>";
			//ss += "<li><a href='#' onclick='appBasInfo.jumunDabOn("+dat[c].Seq+", "+dat[c].Seq+", \""+dat[c].UserA+"\")'><span>답글</span></a></li>";
			ss += "</ul>";
			ss += "<div id='jumunDabPo"+dat[c].Seq+"' style='width:100%;'></div>";
		}else if(this.mem.loginStat && ((this.mem.jumunWr == this.mem.UserA && this.mem.UserA  != dat[c].UserA) || (this.mem.jumunWr == dat[c].UserA && this.mem.UserA != dat[c].UserA))){
			ss += "<ul class='dapWrBtn'>";
			ss += "<li><a href='#' onclick='appBasInfo.ctDabOn("+dat[c].Seq+", "+dat[c].Seq+", \""+dat[c].UserA+"\")'><span>답글</span></a></li>";
			ss += "</ul>";
			
			ss += "<div id='ctDabPo"+dat[c].Seq+"' style='width:100%;'></div>";
		}

		ss += "</li>";
	}
	
	//alert("ss1="+ss);
	this.dispDom.innerHTML = ss;
	
	$("#jmDetCont").val(appBasInfo.imsiDet);
	$("#jmDapCont").val(appBasInfo.imsiDap);
	
}




//주문게시판의 내용을 가져온다.
GetServer.prototype.jumunBDVDisp = function(dat){
	//작성자 : UserA
	//주문게시판의 작성자 아이디.
	this.mem.jumunWr = dat[0].UserA;
	
	//alert("fnam="+dat[0].FileNm);
	

	//글과 이미지의 수정권한 부여
	this.mem.EditContInf = false;   //수정불가
	if(this.mem.UserA == dat[0].UserA){
		this.mem.EditContInf = true;  //수정가능
	}

	if(appBasInfo.jumunBasDui == 1){
		//상세보기 화면으로 연다.
		if(this.mem.loginStat){
			document.querySelector(".detTextCase").style.display = "block";
			document.querySelector(".detOnPUtTbNoLogin").style.display = "none";
		}else{
			document.querySelector(".detTextCase").style.display = "none";
			document.querySelector(".detOnPUtTbNoLogin").style.display = "block";
		}
	
		
		
		var tt = document.querySelectorAll(".jumunBDVTB td");
		
		var dd = dat[0].UserB.split("-");
		
		//this.mem.memEmp = 1;
		
		if((this.mem.memEmp == 1 || this.mem.UserA == dat[0].UserA) && this.mem.loginStat){
			tt[1].innerHTML = dat[0].UserB+" (연락처:"+dat[0].UserC+")";
			
			if(dat[0].FileNm){
				var dd = "<ul><li>"+dat[0].FileNm+"</li><li><img src='./images/bts_down.png' onclick='appUtil.addUpfileDown(\""+dat[0].FileNm+"\")'></li></ul>";
				document.getElementById("addUpFile").innerHTML = dd;
			}else{
				document.getElementById("addUpFile").innerHTML = "첨부파일없음";
			}
			
		}else{
			tt[1].innerHTML = dd[0];
			
			document.getElementById("addUpFile").innerHTML = "비공개";
		}
		
		
		
		
		tt[3].innerHTML = dat[0].Title;
		tt[4].innerHTML = appUtil.disp_rttext(dat[0].Cont, 0);
		
		//글과 이미지의 수정권한 부여
		this.mem.EditContInf = false;   //수정불가
		document.getElementById("editGoMain").style.display = "none";
		if(this.mem.UserA == dat[0].UserA){
			this.mem.EditContInf = true;  //수정가능
		}		
		
		
		document.getElementById("editGoMain").style.display = "none";
		document.getElementById("editGoMain2").style.display = "none";
		if(this.mem.EditContInf){
			document.getElementById("editGoMain").style.display = "block";
			document.getElementById("editGoMain2").style.display = "none";
		}else{
			document.getElementById("editGoMain").style.display = "none";
			document.getElementById("editGoMain2").style.display = "block";
		}

		
	}else{
		
		if(!this.mem.EditContInf){
			appUtil.alertgo("알림","작성자만 수정 가능 합니다.");
			return;
		}
		
	
		//수정화면으로 연다.
		$("#Title").val(dat[0].Title);
		$("select#UserDjiy option[value="+dat[0].UserD+"]").attr("selected","selected");
		$("#UserDjiy").selectmenu("refresh");
		
	
		$("#jumunInTextArea").val(dat[0].Cont);
		
		$("#Dui").val(appBasInfo.jumunBasDui);
		$("#UserA").val(dat[0].UserA);
		$("#UserB").val(dat[0].UserB);
		$("#UserC").val(dat[0].UserC);
		$("#Indx").val(dat[0].Indx);
		
	}
	
}

//메인페이지에서 컨텐츠를 검색한다.
GetServer.prototype.findPageCnt = function(dat){
	var kk = dat.length;
	var ss1 = "";
	var ss2 = "";
	for(var c = 0; c < kk; c++){
		ss1 += "-"+dat[c].TypeB;
		ss2 += "-"+dat[c].TypeBNm;
	}
	appBasInfo.leftUpjCode = ss1.split("-");
	appBasInfo.leftUpjTxt = ss2.split("-");
	
	insertLeftMenu.dispMenu(this.mem.loginStat);
	
	
}

//업종별 코드와 코드명을 가져온다.
GetServer.prototype.upjongCodeAll = function(dat){
	var kk = dat.length;
	var ss1 = "";
	var ss2 = "";
	for(var c = 0; c < kk; c++){
		ss1 += "-"+dat[c].TypeB;
		ss2 += "-"+dat[c].TypeBNm;
	}
	appBasInfo.leftUpjCode = ss1.split("-");
	appBasInfo.leftUpjTxt = ss2.split("-");
	
	insertLeftMenu.dispMenu(this.mem.loginStat);
	
	
}
//제품별 코드와 코드명을 가져온다.
GetServer.prototype.leftCodeAll = function(dat){
	var kk = dat.length;
	var ss1 = "";
	var ss2 = "";
	for(var c = 0; c < kk; c++){
		ss1 += "-"+dat[c].TypeA;
		ss2 += "-"+dat[c].TypeANm;
	}
	
	appBasInfo.leftMnuCode = ss1.split("-");
	appBasInfo.leftMnuTxt = ss2.split("-");
	
	
	insertLeftMenu.dispMenu(this.mem.loginStat);
}


//세로로 리스트를 모두 출력 한다.
//주문게시판의 리스트를 모두 가져온다.
GetServer.prototype.allLiList = function(dat){
	
	this.dataLen = dat.length;

	var dd = this.dispDom;
	dd.innerHTML = "";       //모든 내용을 지우고 초기화 한다.
	var ss = "";
	for(var c = 0; c < this.dataLen; c++){
		ss += "<li><a href='#' onclick='allLiListSs("+dat[c].Indx+")'>";
		ss += "<ul><li>"+(this.dataLen - c)+"</li><li>"+dat[c].Title+"</li>";
		
		var hh = dat[c].UserB.split("-");
		ss += "<li>"+hh[0]+"</li></ul>";
		ss += "</a></li>";		
	}
	dd.innerHTML = ss;
	
}

//매장이 상세정보를 가져온다.
GetServer.prototype.meJangSsDisp = function(dat){
	
	var dpmap = dat[0].DeptMap.split(",");
	parCo.latPo = Number(dpmap[0].trim());
	parCo.langPo = Number(dpmap[1].trim());
	
	
	parCo.coid = dat[0].CeDept;
	parCo.listIndx = parCo.coid;
	
	var dd = document.getElementById("mjNam");
	dd.innerHTML = dat[0].DeptNm;
	parCo.sangho = dat[0].DeptNm;
	
	
	dd = document.getElementById("mjJy");
	dd.innerHTML = dat[0].NoteB;
	
	dd = document.getElementById("mjAddr");
	dd.innerHTML = dat[0].DeptAddr;
	parCo.addr = dat[0].DeptAddr;
	
	
	dd = document.getElementById("mjPhonNam");
	dd.innerHTML = dat[0].DeptPone;
	parCo.cotel = dat[0].DeptPone;
	
	
	dd = document.getElementById("usPhonNam");
	dd.innerHTML = dat[0].UserNm+" "+dat[0].UserPone;
	parCo.hptel = dat[0].UserPone;
	
	
	
	dd = document.getElementById("faxPhonNam");
	dd.innerHTML = dat[0].DeptFax;

	dd = document.getElementById("mjImage");
	dd.src = this.imgLink+dat[0].DeptAmg;
	
	dd = document.getElementById("usImage");
	dd.src = this.imgLink+dat[0].UserAmg;
	
	
	
	
}

//매장리스트를 출력한다.
GetServer.prototype.meJangList = function(dat){
	//dat : 를 인수로 받아서 출력한다.
	var dat2 = 99;
	
	this.dataLen = dat.length;
	
	var dd = this.dispDom;
	dd.innerHTML = "";       //모든 내용을 지우고 초기화 한다.
	var ss = "";
	for(var c = 0; c < this.dataLen; c++){
		ss += "<li id='mjList"+c+"'>"; //"+dat[c].Indx+")'>";
		
		var latlan = dat[c].DeptMap.split(",");
		var lat = Number(latlan[0].trim());
		var lan = Number(latlan[1].trim());
		
		//alert(Number(lat.trim())+"/"+Number(lan.trim()));
		
		ss += "<table><tr>";
		//지도가 바로 밑으로 열리게한다. - dat 대신에 임시로 99를 전달
		ss += "<td onclick='meJangSs("+dat[c].CeDept+", "+c+", "+lat+", "+lan+", \""+dat[c].DeptNm+"\")'>"+dat[c].NoteB+"</td><td onclick='meJangSs("+dat[c].CeDept+", "+c+", "+lat+", "+lan+", \""+dat[c].DeptNm+"\")'><img src='./images/m_bt_map.png' width='84%'></td>";
		ss += "<td onclick='meJangSs("+dat[c].CeDept+", 9999, "+lat+", "+lan+", \""+dat[c].DeptNm+"\")'>"+dat[c].DeptNm+"</td><td onclick='appUtil.callTel(\""+dat[c].DeptPone+"\")'><img src='./images/tel.png' width='84%'></td>";
		ss += "<td onclick='meJangSs("+dat[c].CeDept+", 9999, "+lat+", "+lan+", \""+dat[c].DeptNm+"\")'>"+dat[c].DeptPone+"</td>";
		ss += "</tr>";
		ss += "</table>";
		
		ss += "</li>";		
	}
	dd.innerHTML = ss;
	
}





//가로3개로 앨범형태로 이미지를 출력한다.
GetServer.prototype.liAlbum3 = function(dat){
	var albmH3 = Number(((this.wW * 0.94) * 0.32) * 0.72);  //가로로 3개 표시하는 컨텐츠의 이미지 높이
	
	if(!AWtrans.mobileInf) albmH3 = 184;
	
	
	this.dataLen = dat.length;
	
	var dd = this.dispDom;
	dd.innerHTML = "";       //모든 그림을 지우고 초기화 한다.
	dd.className = "allAlbum3";   //그림을 가로로 3개씩 표시
	//var ss = "";
	for(var c = 0; c < this.dataLen; c++){
		var ali = document.createElement("li");
		ali.style.height = albmH3+"px";
		
		//ss += " / "+dat[c].FileNm;
		
		var pp = dat[c].FileNm;
		if(dat[c].FileNm){
			pp = pp.replace(".png", ".jpg");
		}
		
		ali.style.backgroundImage = "url('"+this.imgLinkThum+"s_"+pp+"')";
		ali.onclick = this.albumView;  //클릭시 실행하는 함수 
		ali.setAttribute("id", dat[c].Indx);
		dd.appendChild(ali);
	}
	//alert(ss);
	
	
}

//가로3개로 앨범형태로 이미지를 출력한다.
GetServer.prototype.liAlbum4 = function(dat){
	var albmH4 = Number(((this.wW * 0.94) * 0.25) * 0.72);  //가로로 3개 표시하는 컨텐츠의 이미지 높이
	
	//웹버젼 이미지의 높이
	if(!AWtrans.mobileInf){
		albmH4 = 144;
	}

	
	this.dataLen = dat.length;
	
	var dd = this.dispDom;
	dd.innerHTML = "";       //모든 그림을 지우고 초기화 한다.
	dd.className = "allAlbum4";   //그림을 가로로 3개씩 표시
	//var ss = "";
	for(var c = 0; c < this.dataLen; c++){
		var ali = document.createElement("li");
		ali.style.height = albmH4+"px";
		
		var pp = dat[c].FileNm;
		if(dat[c].FileNm){
			pp = pp.replace(".png", ".jpg");
		}
		
		
		ali.style.backgroundImage = "url('"+this.imgLinkThum+"s_"+pp+"')";
		
		ali.onclick = this.albumView;  //클릭시 실행하는 함수 
		
		ali.setAttribute("id", dat[c].Indx);
		dd.appendChild(ali);
	}
	//alert(ss);
	
	
}




GetServer.prototype.albumView = function(){

	appBasInfo.nowJmIndx = this.id;
	appUtil.moveOkHistory("contentSS2.html");
	
	
}

GetServer.prototype.dispLi = function(dindx, data, ltrl){
	
	//출력할 위치를 설정
	var tg = document.querySelector(this.domid[dindx]);
	//전체 음원리스트를 출력한다.
	ltrl.vList(tg, data);
	
}
GetServer.prototype.dispLiSs = function(dindx, data, ltrl){
	
	//전체 음원리스트를 출력한다.
	ltrl.sList(data);
	
}


//파일관련 설정을 한다.
//파일 오브젝트는 fileObj로 설정 한다.
GetServer.prototype.fileSysGet = function(){ 
	var dirEnt = this.dirEntry;
	var localPo = this.localPo;
	
	//로컬에 앱폴더의 존재 여부를 확인하고 없으면 생성한다.
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fs){
		fs.root.getDirectory(appBasInfo.fileDownDir, {create:true,exclusive:false}, function (directoryEntry){
			
			//파일 다운로드 폴더를 변경할 때 기준이다.
			appBasInfo.oldFileDownDir = appBasInfo.fileDownDir;
			
			//디렉토리 엔터리를 구한다.
			dirEnt = directoryEntry;
			//디렉토리의 전체경로를 구한다.
			localPo = directoryEntry.toURL();
			
			fileObj.dirEntry = dirEnt;
			fileObj.localPo = localPo;
			
			
		}, function(FileError){

			//console.log(FileError.code);
		});
	},function(FileError){

		//console.log(FileError.code);
	});
	
}
//파일을 다운로드 한다.
GetServer.prototype.fileDown = function(mlink){
	
	//파일 다운로드 폴더를 변경한다.
	var timeDl = 1;
	if(appBasInfo.oldFileDownDir != appBasInfo.fileDownDir){
		this.fileSysGet();
		timeDl = 1100;
	}
	
	var fobj = this;

	setTimeout(function(){
		var durl = "";
		if(mlink.substr(0,5) == "http:" || mlink.substr(0,5) == "file:"){
			durl = mlink;
		}else{
			durl = fobj.imgLink+mlink;
		}
		
		//파일을 다운로드 한다.
		fobj.fileTrans = new FileTransfer();	
		//다운로드하는 파일의 링크
		fobj.fileDownUrl = encodeURI(durl); //"1se/01c0c4606d/1se557-6e6a410.mp3");	
		//다운로드한 파일의 절대경로를 구한다.
		var urlObj = $.mobile.path.parseUrl(fobj.fileDownUrl);
		
		//서버에 있는 원본파일을 로컬로 다운한다.
		fobj.fileTrans.download(fobj.fileDownUrl, fobj.localPo+urlObj.filename, function(entry){
			appUtil.hidePgLoading();
			
			var pp = fobj.localPo+urlObj.filename;
			pp = pp.replace("file:///", "");  //경로에서 "file:///" 빼고 넘긴다.
			window.albRf(pp, function(echoValue) {
				
				console.log("dddddddd===="+echoValue); 
			 });			
		
			appUtil.alertgo("알림", "다운로드 완료하였습니다."); //endtry="+entry.toURL());
			
		}, function(error){
			appUtil.hidePgLoading();
			appUtil.alertgo("알림", "error="+error.code);
			
		}, false, { 
			//headers:{"Authorization": "Basic dGVzdHVzZXJuYW1lOnRlc3RwYXNzd29yZA=="}
			}
		);
		
	}, timeDl);
	
}


//=====================================
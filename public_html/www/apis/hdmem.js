


//=============================================
//회원정보 --- meminf로 인스턴스를 생성 한다.
//this.objMem = new GetServer();
//this.objMem.chnPotionPro(this.seMemval, CIHS, this.objMem, meminf);
function hdMem(){
	this.myMemid = "";  //로그인한 회원의 아이디
	this.myRecid = 0;  //로그인한 회원의 레코드 아이디 
	this.myPotion = 0; //로그인한 회원의 포지션
	this.sePo = 0;
	
	this.susinMem = "";   //수진자의 리스트
	
	
	this.seMemid = "";   //현잭 선택된 회원의 아이디 
	this.seRecid = 0;
	this.seMemval = 0;
	this.webFindTxt = "";



	this.eventId = "";
	this.eventTxt = "";


	this.latPo = 35.0305396;
	this.langPo = 128.81388960000004;
	
	

	
	this.memid = "0";    //회원아이디
	this.memName = "";
	this.tel = null;
	this.telDash = null;   //-있는 전화번호 - 앱실행시 폰에서 가져온다.
	this.email = null;
	this.memPo = null;   //회원의 자격-직책
	this.memCoId = null;  //회원의 업체 아이디
	this.memCoName = null; //회원의 업체 이름
	this.loginStat = false;  //로그인 여부를 저장
	this.idGoOkInf = false;     //아이디 중복확인 여부
	this.idGoOkId = "";         //중복확인에 승인된 아이디 저장
	this.emGoOkInf = false;     //이메일 중복확인 여부
	this.emGoOkId = "";         //중복확인에 승인된 아이디 저장
	this.snGoOkInf = false;     //사업자 번호 중복확인 여부
	this.snGoOkId = "";         //사업자 번호 중복확인에 승인된 아이디 저장
	this.seCoRecId = 0;
	
	this.email2inf = false;   //이메일 두번째값의 정상입력 여부 확인
	

	this.memSeCoId = 0;  //선택한 업체의 아이디
	this.selectSaup = 0;    //선택한 사업의 아이디
	this.selectDesang = 0;  //선택한 대상자의 아이디
	this.selectDesangMemid = "";  //선택한 대상자 아이디
	this.seFindVal = 0;           //통합검색에서 선택한 검색값
	this.seFindMd = 0;
	this.memGubun = 0;
	
	this.md1 = 0;
	this.md2 = 0;
	this.md3 = 0;
	this.md4 = 0;
	this.fnd = "";
	this.page = 0;
	
	
	
	
	this.UserA = "";   //회원의 고유번호
	this.EditContInf = false;   //내용의 수정 권한
	this.EditDabDetInf = false;   //답글과 댓글의 수정 권한
	

	this.jumunWr = 0;   //주문게시판의 작성자
	this.contWr = 0;   //콘텐츠의 작성자
	
	this.memEmp = 0;

	this.objMem = null;


	
	this.my = null;

}

//회원구분 변경에 따라 회원 리스트를 다시 가져온다.
hdMem.prototype.chnSelect = function(obj, gubun){
	
	
	//console.log("chnSelect==22==="+obj.id+"/ val="+obj.value+"/ gubun="+gubun+"/ CIHS="+CIHS);
	
	

	
	switch(obj.id){
	case "selectFF":
							
						var Aff = "A0";
						Aff = document.getElementById("selectFF").value;
						//if(document.getElementById("selectFF").value != "A0") Aff = document.getElementById("selectFF").value;
						//else if(document.getElementById("selectBJ").value != "B0") Aff = document.getElementById("selectBJ").value;
						//else if(document.getElementById("selectGG").value != "C0") Aff = document.getElementById("selectGG").value;
						
						///*
						meminf.seFindVal = document.getElementById("dsFindTxt").value;
						if(meminf.seFindVal == ""){
							document.getElementById("dsFindTxt").value = Aff;
							//meminf.seFindVal = Aff;
						}
						//*/
						
						
						meminf.seFindMd = document.getElementById("selectMdds").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+Aff+meminf.seFindVal;
			
	
	
	break;
	case "selectBJ":
							
						var Aff = "B0";
						Aff = document.getElementById("selectBJ").value;
						//if(document.getElementById("selectFF").value != "A0") Aff = document.getElementById("selectFF").value;
						//else if(document.getElementById("selectBJ").value != "B0") Aff = document.getElementById("selectBJ").value;
						//else if(document.getElementById("selectGG").value != "C0") Aff = document.getElementById("selectGG").value;
						
						///*
						meminf.seFindVal = document.getElementById("dsFindTxt").value;
						if(meminf.seFindVal == ""){
							document.getElementById("dsFindTxt").value = Aff;
							//meminf.seFindVal = Aff;
						}
						//*/
						
						
						meminf.seFindMd = document.getElementById("selectMdds").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+Aff+meminf.seFindVal;
			
	
	
	break;
	case "selectGG":
							
						var Aff = "C0";
						Aff = document.getElementById("selectGG").value;
						//if(document.getElementById("selectFF").value != "A0") Aff = document.getElementById("selectFF").value;
						//else if(document.getElementById("selectBJ").value != "B0") Aff = document.getElementById("selectBJ").value;
						//else if(document.getElementById("selectGG").value != "C0") Aff = document.getElementById("selectGG").value;
						
						///*
						meminf.seFindVal = document.getElementById("dsFindTxt").value;
						if(meminf.seFindVal == ""){
							document.getElementById("dsFindTxt").value = Aff;
							//meminf.seFindVal = Aff;
						}
						//*/
						
						
						meminf.seFindMd = document.getElementById("selectMdds").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+Aff+meminf.seFindVal;
			
	
	
	break;
	case "sangdamSaup":   //상담 등록에서 사업을 변경했다.
		this.selectSaup = obj.value;
		//alert(obj.value);
		//선택한 사업의 공사리스트를 가져온다.
			if(obj.value > 0){

				var qr = CIBASE+"/scene/hjang/coSaupDesangList";
				$.ajax({type:"POST", data:{saup:meminf.selectSaup, md:"sd", ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
			
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
			

			

	break;	
	case "saupGongsa":   //공사등록에서 사업 선택 
		this.selectSaup = obj.value;
		
			if(obj.value > 0){

				var qr = CIBASE+"/scene/hjang/coSaupDesangList";
				$.ajax({type:"POST", data:{saup:meminf.selectSaup, md:"sd", ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
			
					//담당자 리스트를 출력한다.
					var tg = document.getElementById("dsGongsa");
					var ss = "<option value='0'>대상자선택</option>";
					for(var c=0; c < data.length; c++){
						ss += "<option value='"+data[c].id+"'>"+data[c].dsname+" ("+data[c].htel+")</option>";
					}
					
					tg.innerHTML = ss;
					
					//alert(ss);
					
					
					if(param > 0){
						$("#dsGongsa").val(param).attr("selected","selected");
					
					}
			
				},error:function(xhr,status,error){
					alert("err3="+error);
				}
				});
			
			}

	
	break;
	case "dsGongsa":   //공사등록에서 대상자 선택
		this.selectDesang = obj.value;
	
	break;	
	case "findSe":   //통합검색
		this.seFindVal = obj.value;
	
		break;	
	case "spdsList":
		//사업을 선택하면 대상자를 가져온다.
		this.selectSaup = obj.value;
		
		//대상자 리스트를 가져온다.
		if(gubun == 1) location.href = CIBASE+"/scene/hjang/getView/2/"+gubun+"/"+this.memSeCoId+"/"+this.selectSaup;
		else if(gubun == 3){
			
			if(obj.value > 0){
				//업체를 선택하면 담당자를 가져온다.
				var aa = new GetServer();
				aa.getDamdang("", aa, meminf);
			
			}
			
		}else if(gubun == 4){
			//사업의 대상자를 가져온다.
			if(obj.value > 0){
				//업체를 선택하면 사업의 대상자를 가져온다.
				var aa = new GetServer();
				aa.getSaupDesang(0, aa, meminf);
			
			}
		}else if(gubun == 5){
			//상담에서 선택한 사업의 상담 리스트를 가져온다.
			location.href = CIBASE+"/scene/hjang/getView/3/1/"+this.memSeCoId+"/"+this.selectSaup;
			
		}
		
	break;
	case "sauList":
		this.memSeCoId = obj.value;
		location.href = CIBASE+"/scene/hjang/getView/"+gubun+"/1/"+this.memSeCoId;
	break;
	case "dsOnsp":  //대상자 등록에서 사업을 선택 한다.
		this.selectSaup = obj.value;
	

	break;
	case "dsSaupAll":  //dsSaupAll
		this.selectSaup = obj.value;
	
	break;
	case "allfind":
		this.memSeCoId = obj.value;

		location.href = CIBASE+"/scene/hjang/getView/4/1/"+this.memSeCoId;
	
	break;
	case "dsConame":
		//대상자 등록에서 업체를 선택하면 사업리스트를 가져온다.
		this.memSeCoId = obj.value;
		
		switch(gubun){
		case 2:
		
			location.href = CIBASE+"/scene/hjang/getView/"+gubun+"/1/"+this.memSeCoId;
		
		/*
			if(obj.value > 0 && gubun > 0){
				//사업리스트를 가져온다.
				var aa = new GetServer();     //spdsList 에 사업리스트를 출력한다.
				aa.getSaupList(0, aa, meminf);
			}
			*/
		
		break;
		case 3:  //상담일지관리에서 업체를 클릭했다.
		
			location.href = CIBASE+"/scene/hjang/getView/"+gubun+"/1/"+this.memSeCoId;
		
		break;
		case 5:
		
			location.href = CIBASE+"/scene/hjang/getView/2/"+gubun+"/"+this.memSeCoId;
		
		break;
		case 6:  //공사관리
			location.href = CIBASE+"/scene/hjang/getView/2/"+gubun+"/"+this.memSeCoId;
		
		break;
		}

	
	break;
	case "supgubun":
		//사업등록에서 업체를 선택하면 담당자를 선택할 수 있는 리스트가 있다.
		this.memSeCoId = obj.value;
		
		if(obj.value > 0){
			//업체를 선택하면 담당자를 가져온다.
			var aa = new GetServer();
			aa.getDamdang("", aa, meminf);
		
		}

	break;
	case "sdgubun":
		//업체를 선택하고 업체에 사업리스트를 가져온다.
		
		this.memSeCoId = obj.value;
		//alert(obj.value+"/"+obj.id);
		
		
		if(obj.value > 0){
			//사업리스트를 가져온다.
			var aa = new GetServer();     //spdsList 에 사업리스트를 출력한다.
			aa.getSaupList(0, aa, meminf);
		}
		
	break;
	case "sangdamDesang":
		this.selectDesang = obj.value;
		
	
	break;
	case "memgubun":
		//alert(obj.value);
		switch(gubun){
		case 1:  //미가입회원
			location.href = CIBASE+"/member/main/getView/"+gubun+"/1/"+obj.value;
		break;
		case 2:  //가입회원
			location.href = CIBASE+"/member/main/getView/"+gubun+"/1/"+obj.value;
		break;
		case 3:  //차단회원
			location.href = CIBASE+"/member/main/getView/"+gubun+"/1/"+obj.value;
		break;
		}

	break;
	}
	


}





//로그인한 사람의 자격에 따라 기능의 실행 여부를 결정하여 true 또는 false 로 돌려 준다.
hdMem.prototype.keyMan = function(mode, obj){
	var rt = false;
	
	switch(mode){
	case "pochn":  //자격변경의 처리 여부 
		if(obj.cgb == 2 || obj.po == 2){
			
			rt = false;  //조합의 경우 직책변경이 불가능 하다.
			
		}else{  //조합이 아닌 경우

			if(this.myPotion == MASTER){  //마스터로 로그인한 경우 
				if(obj.po == MASTER) rt = false;  //마스터는 마스터를 변경할 수 없다.
				else rt = true;
			}else{
				if(this.myPotion == SUPER || this.myPotion == ADMIN){
					//자신의 업체관련 정보만 출력된 상태라는 것이 기본전체조건
					if(this.myRecid == obj.coid){
						if(this.myPotion <= obj.po) rt = false;
						else rt = true;
					}else{
						rt = false;
					}
				}else{
					rt = false;
				}
			}
			//업체회원의 경우 직책변경 불가능하고 무조건 슈퍼관리자 이다.
			if(rt && obj.gb == 1) rt = true;
			else rt = false;
		
		}
	break;
	}


	return rt;
}

//상당등록을 한다.
hdMem.prototype.sangdamOnPut = function(){
	var obj = document.getElementById("frmSangdamOn");
	
	if(!obj.tit.value){
		appUtil.alertgo("알림","제목을 입력하세요.");
		obj.tit.focus();
		return;
	}

	if(obj.sdgubun.value == 0 || obj.spdsList.value == 0 || obj.sangdamDesang.value == 0){
		appUtil.alertgo("알림","업체, 사업, 대상자를 선택하세요.");
		obj.sdgubun.focus();
		return;
	}
	
	if(!obj.content.value){
		appUtil.alertgo("알림","내용을 입력하세요.");
		obj.content.focus();
		return;
	}
	
	if(!obj.memo.value){
		appUtil.alertgo("알림","견해를 입력하세요.");
		obj.memo.focus();
		return;
	}
	
	if(!obj.sdonday.value){
		appUtil.alertgo("알림","상담일자를 입력하세요.");
		obj.sdonday.focus();
		return;
	}
	
	obj.coid.value = this.memSeCoId;
	obj.saup.value = this.selectSaup;
	obj.desang.value = this.selectDesang;
	

	obj.submit();

}



//대상자를 등록 한다.
hdMem.prototype.desangOn = function(){
	var obj = document.getElementById("frmDsang");
	var dsaup = "";




	
	var c = 0;
	$("input[name=saupchk]:checkbox").each(function() {
		
			if($(this).is(":checked")){
				if(c > 0) dsaup += "-";
				dsaup += $(this).val();
				c++;
			}
	});
	/*
	if(dsaup == ""){
		appUtil.alertgo("알림","대상자가 소속된 사업을 모두 선택하세요.");
		return;
	}
	*/
	obj.dsaup.value = dsaup;


	if(!obj.sedeju.value){
		appUtil.alertgo("알림","세대주의 이름을 입력하세요.");
		obj.sedeju.focus();
		return;
	}
	

	if(!obj.htel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.htel.focus();
		return;
	}
	
	if(!obj.copost.value){
		appUtil.alertgo("알림","우편번호를 검색하여 선택하세요.");
		obj.copost.focus();
		return;
	}
	if(!obj.coaddress.value){
		appUtil.alertgo("알림","주소를 검색하여 선택하세요.");
		obj.coaddress.focus();
		return;
	}



	///*
	if(obj.bojang.value == 5 && !obj.etc.value){
		appUtil.alertgo("알림","의료보장 기타내용을 간단하게 입력하세요.");
		obj.etc.focus();
		return;
	}

	if(obj.gagu.value == 5 && !obj.gaguetc.value){
		appUtil.alertgo("알림","가구 특기사항 기타내용을 간단하게 입력하세요.");
		obj.gaguetc.focus();
		return;
	}
	//*/
	

	if(obj.mode.value == "edit"){
		//alert(imsiLat+"/"+imsiLang+"///"+meminf.latPo+"/"+meminf.langPo);
		obj.lat.value = meminf.latPo;
		obj.lan.value = meminf.langPo;
		
	}else{
		obj.lat.value = meminf.latPo;
		obj.lan.value = meminf.langPo;
	}
	
	
	


	obj.submit();

}





//회원검색을 한다.
hdMem.prototype.memFind = function(md){
	

	
}



hdMem.prototype.memInit = function(obj){
	this.my = obj;
	

	
}

hdMem.prototype.poName = function(po){
	var rt = "";
	
	switch(po){
	case USER:
		rt = "회원";
	break;
	case JOHAP:
		rt = "조합";
	break;
	case SAWON:
		rt = "직원";
	break;
	case ADMIN:
		rt = "관리자";
	break;
	case SUPER:
		rt = "슈퍼관리자";
	break;
	case MASTER:
		rt = "마스터";
	break;
	}
	
	return rt;
}


hdMem.prototype.poChange = function(rid, obj, md, po){

	if(obj.value == 0) return;
	
	if(md == "p"){
		meminf.seRecid = rid;
		
		this.seMemval = obj.value;  //변경하는 직책

		document.getElementById("allBg").style.display = "block";
	
		document.getElementById("popupBox").style.display = "none";
		document.getElementById("popupBoxChadan").style.display = "none";
		document.getElementById("popupBoxOnOk").style.display = "none";
		document.getElementById("popupBoxOnRt").style.display = "none";
		document.getElementById("popupBoxPo").style.display = "block";

	}else{
		
		document.getElementById("allBg").style.display = "none";
		this.objMem = new GetServer();
		this.objMem.chnPotionPro(this.seMemval, CIHS, this.objMem, meminf);
	
	}




}


//처리결과를 출력한다.
hdMem.prototype.dispAfterMess = function(obj, mess, tim){

	$(obj).html(mess).css("display","block");
	
				setTimeout(function(){
					$(obj).css("display","none");
					}, (tim * 1000));
				
}



//테스트 회원등록
hdMem.prototype.onputTestMem = function(){
	
	var mid = "test";
	var nam = Base64.encode("이순신");
	var ttel = Base64.encode("01012341234");
	var inPass = Base64.encode("1234");
	
	
	this.objMem = new GetServer();
	//서버에서 모든 음원을 가져온다.
    var modegab = "mode=memOnputTest&memid="+mid+"&UserPw="+inPass+"&UserNm="+nam+"&Pone="+ttel;
	//alert("modegab="+modegab);
	this.objMem.initParam("nowFieldPro.php", modegab, "memOnputTest", "mu");
	this.objMem.getPostModeTxt(this.objMem, this);  //서버에서 post 모드로 가져온다.
	
}

hdMem.prototype.seEmailSet = function(obj, md){
	
	var e2 = document.getElementById(md+"email2");
	if(obj.value != 0){
		e2.value = obj.value;
		this.email2inf = true;
		emailgab2 = true;
	}else{
		e2.value = "";
		this.email2inf = false;
	}
	
}


hdMem.prototype.conameChange = function(obj){
	
	this.seCoRecId = obj.value;
	//alert(this.seCoRecId);

}

hdMem.prototype.gubunChange = function(obj){
	var oo = document.getElementById("conameSeT");   //구분의 텍스트 입력칸
	var se = document.getElementById("myCompanySe");
	//this.seCoRecId = obj.value;
	
	var gbT = $("#seGubunID option:selected").text();
	if(obj.value == 0){  //선택않됨
		se.style.display = "none";
		oo.style.display = "block";
		oo.value = "미선택";
		this.seCoRecId = 0;
	}else if(obj.value == 1){  //계열사 선택
		se.style.display = "block";
		oo.style.display = "none";
		this.seCoRecId = 0;
	}else{    //조합, 본사 선택
		se.style.display = "none";
		oo.style.display = "block";
		oo.value = gbT;
		if(gbT == "조합") this.seCoRecId = 5;  //조합의 레코드 아이디 
		else this.seCoRecId = 3;  //본사의 레코드 아이디
	}
	
}


//사업자 번호 중복확인
hdMem.prototype.conumOkInf = function(hs, txt){

	var sn = document.getElementById(txt+"saupnum");
	var st = sn.value;
	
	if(!st){
		appUtil.alertgo("알림","사업자 등록번호를 입력하세요.");
		sn.focus();
		return;
	}
	
	if(st.length < 10 || st.length > 10){
		appUtil.alertgo("알림","사업자 등록번호를 다시 확인하세요.");
		sn.focus();
		return;
	}
	
	

		this.objMem = new GetServer();
		this.objMem.snMemoryInf(st, hs, this.objMem, this.my);  //서버에서 post 모드로 가져온다.-아이디 중복확인을 한다.
	

}


//이메일 중복확인
hdMem.prototype.emailOkInf = function(hs, txt){

	var em1 = document.getElementById(txt+"email1");
	var em2 = document.getElementById(txt+"email2");

	
	if(!em1.value){
		appUtil.alertgo("알림","이메일을  입력하세요.");
		em1.focus();
		return;
	}
	
	if(!em2.value){
		appUtil.alertgo("알림","이메일 주소를 입력하세요.");
		em2.focus();
		return;
	}
	var emm = em1.value+"@"+em2.value;
	
		this.objMem = new GetServer();
		this.objMem.emMemoryInf(emm, hs, this.objMem, this.my);  //서버에서 post 모드로 가져온다.-아이디 중복확인을 한다.
	

}


//아이디 중복확인
hdMem.prototype.memidGoOk = function(hs, txt){
	var obj = document.getElementById("frmMem"+txt);
	var mm = obj.memid.value;
	
	if(!mm){
		appUtil.alertgo("알림","아이디를 입력하세요.");
		obj.memid.focus();
		return;
	}
	
	if(appUtil.idcheck(mm)){
		
		this.objMem = new GetServer();
		this.objMem.idMemoryInf(mm, hs, this.objMem, this.my);  //서버에서 post 모드로 가져온다.-아이디 중복확인을 한다.
	}

	
}





//업체등록
hdMem.prototype.onCompany = function(){
	var obj = document.getElementById("frmMemco");
	
	if(!obj.memid.value){
		appUtil.alertgo("알림","회원아이디를 입력하세요.");
		obj.memid.focus();
		return;
	}
	
		if((obj.memid.value != this.idGoOkId) || this.idGoOkInf == false){
			appUtil.alertgo("알림","아이디 중복확인을 하세요.");
			return;
		}
	
	
	if(!obj.coname.value){
		appUtil.alertgo("알림","업체명을 입력하세요.");
		obj.coname.focus();
		return;
	}
	
	if(!obj.name.value){
		appUtil.alertgo("알림","대표자명을 입력하세요.");
		obj.name.focus();
		return;
	}
	
	if(!obj.coemail1.value){
		appUtil.alertgo("알림","이메일을  입력하세요.");
		obj.coemail1.focus();
		return;
	}
	
	if(!obj.coemail2.value){
		appUtil.alertgo("알림","이메일 주소를 입력하세요.");
		obj.coemail2.focus();
		return;
	}	
	
	var em = obj.coemail1.value+"@"+obj.coemail2.value;
	
		if((em != this.emGoOkId) || this.emGoOkInf == false){
			appUtil.alertgo("알림","이메일 중복확인을 하세요.");
			return;
		}
		

	if(!obj.copass.value){
		appUtil.alertgo("알림","비밀번호를 입력하세요.");
		obj.copass.focus();
		return;
	}
	
	if(!appUtil.pwcheck(obj.copass.value)){
		return;
	}
	
	
	
	if(!obj.corepass.value){
		appUtil.alertgo("알림","비밀번호 확인을 입력하세요.");
		obj.corepass.focus();
		return;
	}
	
	
	if(obj.corepass.value != obj.copass.value){
		appUtil.alertgo("알림","비밀번호와 비밀번호 확인이 서로 다릅니다. 다시 확인하세요.");
		obj.corepass.focus();
		return;
	}
	
	
	
	if(!obj.cotel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.cotel.focus();
		return;
	}
	
	var gg = obj.cotel.value;
	gg = gg.replaceAll("-","");
	
	///*
	if(gg.length < 10 || gg.length > 11){
		appUtil.alertgo("알림","휴대폰 번호를 다시확인하고 입력하세요.");
		obj.cotel.focus();
		return;
	}
	//*/
	obj.cotel.value = gg;
	
	
	
	
	
	if(!obj.cosaupnum.value){
		appUtil.alertgo("알림","사업자 등록번호를 입력하세요.");
		obj.cosaupnum.focus();
		return;
	}
	var gg = obj.cosaupnum.value;
	obj.cosaupnum.value = 	gg.replaceAll("-","");
	
		if((obj.cosaupnum.value != this.snGoOkId) || this.snGoOkInf == false){
			appUtil.alertgo("알림","사업자 등록번호 중복확인을 하세요.");
			return;
		}
	
	
	if(!obj.copost.value){
		appUtil.alertgo("알림","우편번호를 입력하세요.");
		obj.copost.focus();
		return;
	}
	
	if(!obj.coaddress.value){
		appUtil.alertgo("알림","사업장 주소를 입력하세요.");
		obj.coaddress.focus();
		return;
	}
	
	
	if(!obj.cocaptcha.value){
		appUtil.alertgo("알림","자동가입방지 값을 입력하세요.");
		obj.cocaptcha.focus();
		return;
	}


	
		var qr = CIBASE+"/home/getCaptcha";
		$.ajax({type:"POST", data:{etime:obj.captcha_time.value, capip:obj.ip_address.value, word:obj.cocaptcha.value, ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
	
			if(data.su > 0){
				obj.submit();
			}else{
				appUtil.alertgo("알림","자동가입 방지 문자를 다시 확인하세요.");
				obj.cocaptcha.focus();
			
			}
	
		},error:function(xhr,status,error){
			//alert("err3="+error);
		}
		});

	
}

//비밀번호찾기
hdMem.prototype.findPw = function(){
	var obj = document.getElementById("frmFindPw");
	
	if(!obj.pwtel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.pwtel.focus();
		return;
	}
	
	var gg = obj.pwtel.value;
	gg = gg.replaceAll("-","");
	
	if(gg.length < 10 || gg.length > 11){
		appUtil.alertgo("알림","휴대폰 번호를 다시확인하고 입력하세요.");
		obj.pwtel.focus();
		return;
	}
	obj.pwtel.value = gg;
	
	
	if(!obj.pwid.value){
		appUtil.alertgo("알림","아이디를 입력하세요.");
		obj.pwid.focus();
		return;
	}
		
		
	if(!obj.pwemail1.value){
		appUtil.alertgo("알림","이메일을  입력하세요.");
		obj.pwemail1.focus();
		return;
	}
	
	if(!obj.pwemail2.value){
		appUtil.alertgo("알림","이메일 주소를 입력하세요.");
		obj.pwemail2.focus();
		return;
	}	
	
	var em = obj.pwemail1.value+"@"+obj.pwemail2.value;
	

	obj.submit();

}

//사진등록을 한다.
hdMem.prototype.onputPhoto = function(fn){
	var obj = document.getElementById("frmPhoto");
	
	

	if(!obj.tit.value){
		appUtil.alertgo("알림","제목을 입력하세요.");
		obj.tit.focus();
		return;
	}
	

	
         var form = $('form')[0];
         var formData = new FormData();
		 
		 formData.append("memo",$("#memo").val());
		 formData.append("tit",$("#tit").val());


	if(obj.imginf.value == "insert"){
		//등록모드-이미지의 선택 여부를 확인한다. - 파일 선택하지 않으면 않넘어 간다.
			if(!$("input[name=file1]").val()){
				appUtil.alertgo("알림","파일을 선택 하세요..");
				return;
			}
			formData.append("file1",$("input[name=file1]")[0].files[0]);
	}else{
		//수정모드 이미지의 존재 여부를 확인한다.
		if(obj.imginf.value == "nn"){
			//기존이미지가 존재 하지 않는다.-이미지를 등록해야 한다.
			if(!$("input[name=file1]").val()){
				appUtil.alertgo("알림","파일을 선택 하세요..");
				return;
			}
			formData.append("file1",$("input[name=file1]")[0].files[0]);
		}else{
			//기존이미지가 존재 한다.-이미지를 등록하면 않된다.
			//alert("gggg");
			
		}
	}
	
	//alert("end");
	//return;

	
		 formData.append("imginf",$("#imginf").val());
		 formData.append("mode",obj.mode.value);
		 
		
		 formData.append("ci_t",CIHS);
		 var gsid = $("#gsid").val();
		 var coid = $("#coid").val();
		 formData.append("gsid", gsid);
		 formData.append("sp",$("#sp").val());
		 formData.append("dange",obj.dange.value);
		 
		 //alert(obj.dange.value+"/"+obj.mode.value+"/"+gsid);

		 
             $.ajax({
                url: CIBASE+"/scene/hjang/onputPhoto",
                processData: false,
                contentType: false,
				//dataType:"text",
				//data:{ufile:formData, business_nm:obj.business_nm.value, business_explane:obj.business_explane.value, start_dt:obj.start_dt.value, end_dt:obj.end_dt.value, coid:obj.supgubun.value, memid:obj.damdang.value, ci_t:CIHS},
				
                data:formData,
                type: 'POST',
                success: function(result){
					
					if(obj.mode.value == "edit") appUtil.alertgo("알림", "사진을 수정하였습니다.");
					else appUtil.alertgo("알림", "사진을 등록하였습니다.");
					
                    
					//http://mroo.co.kr/scene/hjang/getView/1/5/51/4/3
					//http://mroo.co.kr/scene/hjang/getView/2/5/54/1/2
					location.href = CIBASE+"/scene/hjang/getView/2/8/"+coid+"/"+gsid;
					
                },error: function(error){
					//alert("업로드 실패");
				}
            });

}


hdMem.prototype.photoDel = function(pid, imgnam){

			if(confirm('이미지를 삭제하시겠습니까?')){
			

				$.ajax({
					url: CIBASE+"/scene/hjang/delPhoto",
					dataType:"json",
					data:{phtid:pid, imgnam:imgnam, ci_t:CIHS},
					type: 'POST',
					success: function(result){
						
						if(result.img == imgnam){
							appUtil.alertgo("알림", "이미지를 삭제하였습니다.");
							location.reload();
							//location.href = CIBASE+"/scene/hjang/getView/2/8/"+$("#coid").val()+"/"+$("#gsid").val();
						}else{
							appUtil.alertgo("알림", "이미지 삭제 실패하였습니다.");
						
						}
						
						
					},error: function(error){
						//alert("업로드 실패");
					}
				});



	    	}

}






//아이디찾기
hdMem.prototype.findId = function(){
	var obj = document.getElementById("frmFindId");
	
	if(!obj.idtel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.idtel.focus();
		return;
	}
	
	var gg = obj.idtel.value;
	gg = gg.replaceAll("-","");
	
	if(gg.length < 10 || gg.length > 11){
		appUtil.alertgo("알림","휴대폰 번호를 다시확인하고 입력하세요.");
		obj.idtel.focus();
		return;
	}
	obj.idtel.value = gg;
	
		
	if(!obj.idemail1.value){
		appUtil.alertgo("알림","이메일을  입력하세요.");
		obj.idemail1.focus();
		return;
	}
	
	if(!obj.idemail2.value){
		appUtil.alertgo("알림","이메일 주소를 입력하세요.");
		obj.idemail2.focus();
		return;
	}	
	
	var em = obj.idemail1.value+"@"+obj.idemail2.value;
	

	obj.submit();

}



//업체 수정
hdMem.prototype.edtCompany = function(){
	var obj = document.getElementById("frmMemco");
	var psgoinf = true;

	if(!obj.coname.value){
		appUtil.alertgo("알림","업체명을 입력하세요.");
		obj.coname.focus();
		return;
	}
	
	if(!obj.name.value){
		appUtil.alertgo("알림","대표자의 이름을 입력하세요.");
		obj.name.focus();
		return;
	}

	var newem = obj.coemail1.value+"@"+obj.coemail2.value;
	//alert("pppp="+emailgab2+"/"+this.email2inf+"/"+obj.oldEmail.value);
	if(newem != obj.oldEmail.value){
		//이메일 변경되었다.
		//입력여부를 확인하고 유효성여부를 검사한다.
		if(!obj.coemail1.value){
			appUtil.alertgo("알림","이메일을 입력하세요.");
			obj.coemail1.focus();
			return;
		}
		
		if(!obj.coemail2.value){
			appUtil.alertgo("알림","이메일을 입력하세요.");
			obj.coemail2.focus();
			return;
		}	
		
		//유효성 검사 결과로 처리한다.
		if(emailgab1 || emailgab2){
		
			if((newem != this.emGoOkId) || this.emGoOkInf == false){
				appUtil.alertgo("알림","이메일 중복확인을 하세요.");
				return;
			}		
			
		}else{
			appUtil.alertgo("알림","이메일을 다시 확인하여 주세요.");
			obj.coemail1.focus();
			return;
		}
	}else{
		this.emGoOkId = newem;
		this.emGoOkInf = true;
	}
	
	

	if(obj.copass.value || obj.newcopass.value || obj.newcorepass.value){    //
			if(!obj.copass.value || !obj.newcopass.value || !obj.newcorepass.value){
				appUtil.alertgo("알림","기존 비밀번호 또는 신규 비밀번호와 비밀번호 확인을 모두 입력 하세요.");
				obj.copass.focus();
				psgoinf = false;
				return;	
			}
			if(obj.copass.value == obj.newcopass.value){
				appUtil.alertgo("알림","기존비밀번호와 동일한 번호를 설정 하셨습니다. 다시 입력하세요.");
				obj.newcopass.focus();
				psgoinf = false;
				return;	
			}
			if(obj.newcopass.value != obj.newcorepass.value){
				appUtil.alertgo("알림","신규 비밀번호와 신규비밀번호 확인이 일치하지 않습니다.");
				obj.newcopass.focus();
				psgoinf = false;
				return;	
			}
			
			if(!appUtil.pwcheck(obj.newcopass.value)){
				obj.passchn.value = "no";
				return;
			}else{
				obj.passchn.value = "ok";
			}
	}else{
		obj.passchn.value = "no";
	}


	
	if(!obj.cotel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.cotel.focus();
		return;
	}
	
	var gg = obj.cotel.value;
	gg = gg.replaceAll("-","");
	
	///*
	if(gg.length < 10 || gg.length > 11){
		appUtil.alertgo("알림","휴대폰 번호를 다시확인하고 입력하세요.");
		obj.cotel.focus();
		return;
	}
	//*/
	obj.cotel.value = gg;
	
	


	if(!obj.cosaupnum.value){
		appUtil.alertgo("알림","사업자 등록번호를 입력하세요.");
		obj.cosaupnum.focus();
		return;
	}


	if(obj.oldConum.value != obj.cosaupnum.value){
	
		var gg = obj.cosaupnum.value;
		obj.cosaupnum.value = 	gg.replaceAll("-","");
	
		if((obj.cosaupnum.value != this.snGoOkId) || this.snGoOkInf == false){
			appUtil.alertgo("알림","사업자 등록번호 중복확인을 하세요.");
			return;
		}
	
	}else{
		this.snGoOkId = obj.cosaupnum.value;
		this.snGoOkInf = true;
	}


	
	obj.submit();

}




//회원정보 수정
hdMem.prototype.edtMember = function(){
	var obj = document.getElementById("frmMem");
	var psgoinf = true;
	
		if(!obj.name.value){
			appUtil.alertgo("알림","이름을 입력하세요.");
			obj.name.focus();
			return;
		}
	
	var newem = obj.email1.value+"@"+obj.email2.value;
	//alert("pppp="+emailgab2+"/"+this.email2inf+"/"+obj.oldEmail.value);
	if(newem != obj.oldEmail.value){
		//이메일 변경되었다.
		//입력여부를 확인하고 유효성여부를 검사한다.
		if(!obj.email1.value){
			appUtil.alertgo("알림","이메일을 입력하세요.");
			obj.email1.focus();
			return;
		}
		
		if(!obj.email2.value){
			appUtil.alertgo("알림","이메일을 입력하세요.");
			obj.email2.focus();
			return;
		}	
		
		if(emailgab1 || emailgab2){
		
			if((newem != this.emGoOkId) || this.emGoOkInf == false){
				appUtil.alertgo("알림","이메일 중복확인을 하세요.");
				return;
			}		
			
		}else{
			appUtil.alertgo("알림","이메일을 다시 확인하여 주세요.");
			obj.email1.focus();
			return;
		}
	}else{
		this.emGoOkId = newem;
		this.emGoOkInf = true;
	}
	


	if(obj.mempass.value || obj.newmempass.value || obj.newmemrepass.value){    //
			var psgoinf = true;
			if(!obj.mempass.value || !obj.newmempass.value || !obj.newmemrepass.value){
				appUtil.alertgo("알림","기존 비밀번호 또는 신규 비밀번호와 비밀번호 확인을 모두 입력 하세요");
				obj.mempass.focus();
				psgoinf = false;
				return;	
			}
			if(obj.mempass.value == obj.newmemrepass.value){
				appUtil.alertgo("알림","기존비밀번호와 동일한 번호를 설정 하셨습니다. 다시 입력하세요.");
				obj.newmempass.focus();
				psgoinf = false;
				return;	
			}
			if(obj.newmempass.value != obj.newmemrepass.value){
				appUtil.alertgo("알림","신규 비밀번호와 신규비밀번호 확인이 일치하지 않습니다.");
				obj.newmempass.focus();
				psgoinf = false;
				return;	
			}
			
			if(!appUtil.pwcheck(obj.mempass.value)){
				obj.passchn.value = "no";
				return;
			}else{
				obj.passchn.value = "ok";
			}
	}else{
		obj.passchn.value = "no";
	}
	
	///*
	if(obj.memtel.value){
		var tt = obj.memtel.value;
		if(tt.length < 10 || tt.length > 11){
			appUtil.alertgo("알림","전화번호를 다시확인하고 입력하세요.");
			obj.memtel.focus();
			return;
		}
	}
	//*/
	
	/*
	if(obj.gubun.value == 1){
		this.seCoRecId = obj.conameSe.value;
	}
	*/
	/*
	if(obj.gubun.value == 1 && this.seCoRecId == 0){
		appUtil.alertgo("알림","회사명을 선택 하세요.");
		obj.conameSe.focus();
		return;
	}
	*/
	//alert(obj.passchn.value+"/"+obj.memtel.value+"/"+this.seCoRecId);
	
	
	obj.submit();

}





//회워등록
hdMem.prototype.onMember = function(){
	var obj = document.getElementById("frmMem");
	

	if(!obj.memid.value){
		appUtil.alertgo("알림","아이디를 입력하세요.");
		obj.memid.focus();
		return;
	}
	
		if((obj.memid.value != this.idGoOkId) || this.idGoOkInf == false){
			appUtil.alertgo("알림","아이디 중복확인을 하세요.");
			return;
		}
		
		
	if(!obj.email1.value){
		appUtil.alertgo("알림","이메일을  입력하세요.");
		obj.email1.focus();
		return;
	}
	
	if(!obj.email2.value){
		appUtil.alertgo("알림","이메일 주소를 입력하세요.");
		obj.email2.focus();
		return;
	}	
	
	var em = obj.email1.value+"@"+obj.email2.value;
	
	//alert(em+"/"+this.emGoOkId+"/"+this.emGoOkInf);
		
		if((em != this.emGoOkId) || this.emGoOkInf == false){
			appUtil.alertgo("알림","이메일 중복확인을 하세요.");
			return;
		}
		
	if(!obj.name.value){
		appUtil.alertgo("알림","이름을 입력하세요.");
		obj.name.focus();
		return;
	}
	
	
	if(!obj.mempass.value){
		appUtil.alertgo("알림","비밀번호를 입력하세요.");
		obj.mempass.focus();
		return;
	}
	
	if(!appUtil.pwcheck(obj.mempass.value)){
		return;
	}
	
	
	if(!obj.memrepass.value){
		appUtil.alertgo("알림","비밀번호 확인을 입력하세요.");
		obj.memrepass.focus();
		return;
	}
	
	
	if(obj.memrepass.value != obj.mempass.value){
		appUtil.alertgo("알림","비밀번호와 비밀번호 확인이 서로 다릅니다. 다시 확인하세요.");
		obj.memrepass.focus();
		return;
	}
	
	if(!obj.memtel.value){
		appUtil.alertgo("알림","휴대폰 번호를 입력하세요.");
		obj.memtel.focus();
		return;
	}
	
	var gg = obj.memtel.value;
	gg = gg.replaceAll("-","");
	
	
	///*
	if(gg.length < 10 || gg.length > 11){
		appUtil.alertgo("알림","휴대폰 번호를 다시확인하고 입력하세요.");
		obj.memtel.focus();
		return;
	}
	//*/
	
	/*
	if(!telgab){
		appUtil.alertgo("알림","전화번호를 다시확인하고 입력하세요.");
		obj.memtel.focus();
		return;
	}
	*/
	
	obj.memtel.value = gg;
	
	
	
	if(obj.gubun.value == 0){
		appUtil.alertgo("알림","회원구분을 선택 하세요.");
		obj.gubun.focus();
		return;
	}
	
	
	if(this.seCoRecId == 0){
		appUtil.alertgo("알림","회사명을 선택 하세요.");
		obj.conameSe.focus();
		return;
	}


	if(!obj.captcha.value){
		appUtil.alertgo("알림","자동가입방지 값을 입력하세요.");
		obj.captcha.focus();
		return;
	}


		var qr = CIBASE+"/home/getCaptcha";
		$.ajax({type:"POST", data:{etime:obj.captcha_time.value, capip:obj.ip_address.value, word:obj.captcha.value, ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
	
			if(data.su > 0){
				obj.submit();
			}else{
				appUtil.alertgo("알림","자동가입 방지 문자를 다시 확인하세요.");
				obj.captcha.focus();
			
			}
	
		},error:function(xhr,status,error){
			//alert("err3="+error);
		}
		});



}



//회원등록 
hdMem.prototype.onputMem = function(){
	
	var em1 = document.querySelector("#email1");
	var em2 = document.querySelector("#email2");
	var nowEm = em1.value+"@"+em2.value;
	
	var nam = document.querySelector("#name");
	var ps1 = document.querySelector("#goPass1");
	var ps2 = document.querySelector("#goPass2");
	var ps3 = document.querySelector("#goPass3");
	var ps4 = document.querySelector("#goPass4");
	var oldps;
	var tel1 = document.querySelector("#tel1");
	var tel2 = document.querySelector("#tel2");
	var tel3 = document.querySelector("#tel3");
	
	var inPass = "";

	
	var txt = "";
	if(appBasInfo.leftMenuTextAll == "회원가입"){
		
		if((nowEm != this.idGoOkId) || this.idGoOkInf == false){
			appUtil.alertgo("알림","아이디 중복확인을 하세요.");
			return;
		}
		
		
		if(!ps3.value){
			appUtil.alertgo("알림", "패스워드를 입력하세요.");
			ps3.focus();
			return;
		}
		

		//가입하는 비밀번호
		if(!ps4.value){
			appUtil.alertgo("알림", "패스워드확인을 입력하세요.");
			ps4.focus();
			return;
		}
		if(ps3.value != ps4.value){
			appUtil.alertgo("알림","패스워드와 패스워드확인이 서로 다릅니다. 다시 확인 하세요.");
			return;
		}
		inPass = ps3.value;
		
	}else{
		//회원정보 수정
		if(ps1.value){
			//새비밀번호가 입력된 경우 
			if(!ps2.value){
				appUtil.alertgo("알림", "새 패스워드확인을 입력하세요.");
				ps2.focus();
				return;
			}
			
			if(ps1.value != ps2.value){
				appUtil.alertgo("알림","새 패스워드와 새 패스워드확인이 서로 다릅니다. 다시 확인 하세요.");
				return;
			}
			
			//새로운 비밀번호
			inPass = ps1.value;
			
		}else{
			inPass = "0";
		}
		
		//수정을 위해 비밀번호 일치 확인
		oldps = document.querySelector("#oldPass");
		//회원정보 수정 
		if(window.localStorage.getItem("memidps") != oldps.value){
			appUtil.alertgo("알림","비밀번호 오류 입니다.");
			return;
		}

		
		
		if(inPass != "0"){
			//비밀번호를 변경한다.
			if(oldps.value == inPass){
				appUtil.alertgo("알림","새비밀번호가 기존비밀번호와 같은 번호입니다. 다시 입력하세요.");
				return;
			}
			
		}else{
			//비밀번호를 변경하지 않는다.
			inPass = oldps.value;
		}
		
	}
		


	if(!em1.value){
		appUtil.alertgo("알림", "이메일을  입력하세요.");
		em1.focus();
		return;
	}
	if(!em2.value){
		appUtil.alertgo("알림", "이메일 주소를 입력하세요.");
		em2.focus();
		return;
	}
	
	if(!nam.value){
		appUtil.alertgo("알림", "이름을 입력하세요.");
		nam.focus();
		return;
	}
	
	
	if(!tel1.value){
		appUtil.alertgo("알림", "전화번호 첫번째자리를 입력하세요.");
		tel1.focus();
		return;
	}
	if(!tel2.value){
		appUtil.alertgo("알림", "전화번호 두번째자리를 입력하세요.");
		tel2.focus();
		return;
	}
	if(!tel3.value){
		appUtil.alertgo("알림", "전화번호 세번째자리를 입력하세요.");
		tel3.focus();
		return;
	}
	var ttel = tel1.value+"-"+tel2.value+"-"+tel3.value;
	
	
	this.objMem = new GetServer();
	//서버에서 모든 음원을 가져온다.
	var modegab = "";
	modegab = "mode=P01&UserDn="+em1.value+"@"+em2.value+"&UserPw="+inPass+"&UserNm="+escape(nam.value)+"&PoneNm="+ttel;
	
	if(appBasInfo.leftMenuTextAll == "회원가입"){
		modegab = "mode=P01&UserDn="+em1.value+"@"+em2.value+"&UserPw="+inPass+"&UserNm="+escape(nam.value)+"&PoneNm="+ttel;
	}else{
		//회원정보 수정 
		modegab = "mode=P02&Dui=2&UserA="+this.UserA+"&UserDn="+em1.value+"@"+em2.value+"&UserPw="+inPass+"&UserNm="+escape(nam.value)+"&PoneNm="+ttel;
	}
	
	
//	alert("QueryB.asp?"+modegab);
	this.objMem.initParam("QueryB.asp", modegab, "memOnput", "mu");
	this.objMem.getPostModeTxt(this.objMem, this.my);  //서버에서 post 모드로 가져온다.
	
}

//알림삭제 처리 
hdMem.prototype.delNotice = function(mid, md){
	this.seMemId = mid;
	
	document.getElementById("allBg").style.display = "block";
	document.getElementById("popupMessDel").style.display = "none";
	document.getElementById("popupMailDel").style.display = "none";
	document.getElementById("popupPushDel").style.display = "none";

	
	switch(md){
	case "mess":
		document.getElementById("popupMessDel").style.display = "block";
	break;
	case "mail":
		document.getElementById("popupMailDel").style.display = "block";
	break;
	case "push":
		document.getElementById("popupPushDel").style.display = "block";
	break;
	}

}

//이벤트 관련 처리를 한다
hdMem.prototype.anzEvent = function(lid, md){

	this.eventId = lid;
	document.getElementById("allBg").style.display = "block";

	document.getElementById("popupEvent").style.display = "block";
	/*
	switch(md){
	case "del":
		document.getElementById("popupBdDel").style.display = "block";
	break;
	}
	*/
	

}







//게시판 관련 처리 
hdMem.prototype.anzBd = function(lid, md){

	this.seMemId = lid;
	document.getElementById("allBg").style.display = "block";

	document.getElementById("popupBdDel").style.display = "none";
	switch(md){
	case "del":
		document.getElementById("popupBdDel").style.display = "block";
	break;
	}
	

}






//회원삭제 취소
hdMem.prototype.noticeDelOk = function(md){
	document.getElementById("allBg").style.display = "none";
	
	switch(md){
	case "anzevEdit":  //이벤트 수정
	
		var txt = document.getElementById("pEvent");
		if(!txt.value){
			appUtil.alertgo("알림","이벤트 내용을 입력하세요.");
			txt.focus();
			return;
		}
	
		var txt2 = document.getElementById("stday");
		var txt3 = document.getElementById("sttime");
		var stval = txt2.value+" "+txt3.value+":00";
		
		txt2 = document.getElementById("endday");
		txt3 = document.getElementById("edtime");
		var edval = txt2.value+" "+txt3.value+":00";
		
		
		var qr = CIBASE+"/schedule/schedule/editEvent";
		//alert(this.qr+"----"+param+"/"+hs);
		$.ajax({type:"POST", data:{evid:this.eventId, memo:txt.value, stval:stval, edval:edval, ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
	
			//alert(data.rs);
			location.reload();

	
	
		},error:function(xhr,status,error){
			//alert("err3="+error);
		}
		});

		
	break;
	case "anzevDel":  //이벤트 삭제
	
			if(confirm("이벤트 삭제 할까요?")){
				//이벤트를 삭제한다.
				location.href = CIBASE+"/schedule/schedule/delEvent/"+this.eventId+"/"+bdGubun;	

			}
	
	break;
	case "mkbd":
		//생성한 게시판 삭제 
		location.href = CIBASE+"/control/control/mkbdDel/2/"+this.seMemId;
	break;
	case "mess":
		location.href = CIBASE+"/notice/gongji/notiDel/1/"+this.seMemId;
	break;
	case "mail":
		location.href = CIBASE+"/notice/gongji/notiDel/2/"+this.seMemId;
	break;
	case "push":
		location.href = CIBASE+"/notice/gongji/notiDel/3/"+this.seMemId;  //<?=$baseUrl?>main/memOnBack/<?=$rows->id?>
	break;
	}
	
	
	
}





//회원삭제
hdMem.prototype.delMem = function(mid, md, po, gb){
	this.seMemId = mid;
	document.getElementById("allBg").style.display = "block";
	
	document.getElementById("popupBox").style.display = "none";
	document.getElementById("popupBoxChadan").style.display = "none";
	document.getElementById("popupBoxOnOk").style.display = "none";
	document.getElementById("popupBoxOnRt").style.display = "none";
	document.getElementById("popupBoxPo").style.display = "none";
	switch(md){
	case "del":
		meminf.sePo = po;
		if(po > 4){
			$("#popupBox.deldiv div#BoxMess.deldiv").html("업체의 대표계정을 삭제할 경우 소속되어 있는 모든 직원들도 삭제되어 집니다.<br />그래도 삭제하시겠습니까?<br /><br />");
		}else{
			$("#popupBox.deldiv div#BoxMess.deldiv").html("정말로 삭제 할까요?<br />삭제하시면 복구 불가능합니다.<br /><br />");
		}
		document.getElementById("popupBox").style.display = "block";
	break;
	case "chadan":
		meminf.sePo = po;
		if(po > 4){
			//alert(po);
			$("#popupBoxChadan div#BoxMess.chadan").html("업체의 대표계정을 차단할 경우 소속되어 있는 모든 직원들도 차단되어 집니다.<br />그래도 차단하시겠습니까?<br /><br />");
		}else{
			$("#popupBoxChadan div#BoxMess.chadan").html("회원자격 차단 할까요?<br />차단시 로그인 불가능 합니다.<br /><br />");
		}
		document.getElementById("popupBoxChadan").style.display = "block";
	break;
	case "onok":
		//업체 슈퍼관리자의 존재 여부를 확인한다.
		//슈퍼관리자가 없는 경우 가입 승인 불가 
		//alert(po);
		if(po > 4 || gb == 2) document.getElementById("popupBoxOnOk").style.display = "block";
		else{
		
				$.ajax({
					url: CIBASE+"/member/main/getCoSuperInf",
					dataType:"json",
					data:{memid:mid, ci_t:CIHS},
					type: 'POST',
					success: function(result){
						
						if(result.rs == 2){
							document.getElementById("popupBoxOnOk").style.display = "block";
						}else{
							document.getElementById("allBg").style.display = "none";
							appUtil.alertgo("알림", "업체의 슈퍼관리자가 존재하지 않습니다. 슈퍼관리자 부터 먼저 승인 처리 하여야 합니다.");
						}
						
						
						
					},error: function(error){
						alert("err="+error);
					}
				});		
		}
				
		
	break;
	case "onrt":
		document.getElementById("popupBoxOnRt").style.display = "block";
	break;
	case "po":
		document.getElementById("popupBoxPo").style.display = "block";
	break;
	}
	
}
//회원삭제 취소
hdMem.prototype.memDelNo = function(){
	
	document.getElementById("allBg").style.display = "none";
	
}
//회원삭제,회원차단 취소
hdMem.prototype.memDelOk = function(md){
	document.getElementById("allBg").style.display = "none";
	
	switch(md){
	case "del":
		//alert(this.sePo);
		//return;
		location.href = CIBASE+"/member/main/memDeleteOk/"+this.seMemId+"/"+this.sePo;
	break;
	case "chadan":
		location.href = CIBASE+"/member/main/memOnNo/"+this.seMemId;
	break;
	case "onok":
		//alert(this.seMemId+"/"+meminf.md1);
	
		location.href = CIBASE+"/member/main/memOnOk/"+this.seMemId+"/"+meminf.md1;  //미가입 / 차단에 따라 처리 방식이 다름 
	break;
	case "onrt":
		location.href = CIBASE+"/member/main/memOnBack/"+this.seMemId;  //<?=$baseUrl?>main/memOnBack/<?=$rows->id?>
	break;
	case "po":
		location.href = CIBASE+"/member/main/memOnBack/"+this.seMemId;  //<?=$baseUrl?>main/memOnBack/<?=$rows->id?>
	break;
	}
	
	
	
}




//회원수정 
hdMem.prototype.edtMem = function(){
	
}
//login


hdMem.prototype.login = function(hs){
	
	var getId = document.getElementById("logid");
	var getPass = document.getElementById("logpass");
	

	if(!getId.value){
		appUtil.alertgo("알림", "아이디를 입력하세요.");
		getId.focus();
		return;
	}
	if(!getPass.value){
		appUtil.alertgo("알림", "비밀번호를 입력하세요.");
		getPass.focus();
		return;
	}
	
	//var enpass = Base64.encode(getPass.value);
	//window.localStorage.setItem("memidps", enpass);
	//location.href = LKCODE+"authWeb/"+getId.value+"/"+enpass;	
	
	var mm = getId.value+":"+getPass.value;
	
	this.objMem = new GetServer();
	this.objMem.webLogin(mm, hs, this.objMem, this.my);  //서버에서 post 모드로 가져온다.-아이디 중복확인을 한다.
	
}






hdMem.prototype.autoLogin = function(){
	
	this.objMem = new GetServer();
	//자동로그인을 한다.
	var md = "mode=memLoginAuto&LognDn="+window.localStorage.getItem("memid")+"&LognPw="+window.localStorage.getItem("memidps");
	//alert(md);
	this.objMem.initParam("nowFieldPro.php", md, "memLoginAuto", "mu");
	this.objMem.getPostMode(this.objMem, this.my);  //서버에서 post 모드로 가져온다.
	
}

hdMem.prototype.loginInf = function(){
	if(window.localStorage.getItem("autoLogin") == null){
		window.localStorage.setItem("autoLogin", "ok");
	}
	
	var rt = false;
	if(window.localStorage.getItem("autoLogin") == "ok"){
		if(window.localStorage.getItem("memid") != "0" && window.localStorage.getItem("memid") != null) rt = true;  //로그인된 상태 이다.
	}else{
		rt = false;   //수동으로 로그인해야 한다.
	}
	
	
	return rt;
}

hdMem.prototype.setAutoLogin = function(){
	
	if(window.localStorage.getItem("autoLogin") == "ok"){
		window.localStorage.setItem("autoLogin", "no");
	}else{
		window.localStorage.setItem("autoLogin", "ok");
		
		
	}
	
	//버튼을 출력한다.
	this.dispAutoLogin();
	
}
hdMem.prototype.dispAutoLogin = function(){
	
	//console.log("hdMem.prototype.dispAutoLogin = "+window.localStorage.getItem("autoLogin"));
	
	if(window.localStorage.getItem("autoLogin") == "ok"){
		document.querySelector("div.autoLog div.left img").src = "./images/check-on.png";
	}else{
		document.querySelector("div.autoLog div.left img").src = "./images/check-off.png";
	}
	
}

hdMem.prototype.logout = function(){
	//웹버젼의 경우 리로드해야 한다.
	
	//공통적인 로그아웃========================
	this.gabInit();
	window.localStorage.setItem("autoLogin", "no");
	//==============================================
	
	if(AWtrans.mobileInf){
		//모바일 모드의 경우
		insertLeftMenu.panelClose();
		
		if(appBasInfo.nowPage == "page"){
			//왼쪽 메뉴 출력
			//insertLeftMenu.dispMenu(this.loginStat);
			appUtil.moveNoHistory("index.html#Login");
		}else{
			//appUtil.goHome();
			appUtil.moveNoHistory("index.html#Login");

		}
	}else{
		window.localStorage.setItem("autoLogin", "no");
		parent.topMnu.dispBtn();
		if(appBasInfo.nowPage == "page"){
			//왼쪽 메뉴 출력
			insertLeftMenu.dispMenu(this.loginStat);
		}else{
			appUtil.goHome();
		}
		
			
	}

}
hdMem.prototype.gabInit = function(){
	
	this.tel = "0";
	this.UserA = "0";
	this.memName = "0";
	this.memEmp = 0;
	
	this.loginStat = false;
	
}
//---------------------------------------



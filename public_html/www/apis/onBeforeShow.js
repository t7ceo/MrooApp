//
String.prototype.replaceAll = replaceAll;
function replaceAll(str1, str2){
	var strTemp = this;
	strTemp = strTemp.replace(new RegExp(str1, "g"), str2);
	return strTemp;
}

//============================================================



		var oldtel, oldId = "";
		var telgab = false;
		var idgab = false;
		var emailgab1 = false;
		var emailgab2 = false;


//현재 열려있는 페이지에 대한 기능 설정================================================
	//live -> ready -> load
	$(document).ready(function($){
		
		//FastClick.attach(document.body);
		
		$( document ).bind( 'mobileinit', function(){
		  	$.mobile.loader.prototype.options.text = "Loading...";
		  	$.mobile.loader.prototype.options.textonly = true;
		  	$.mobile.loader.prototype.options.textVisible = true;
		  	$.mobile.loader.prototype.options.theme = "none";
		  	//$.mobile.loader.prototype.options.html = "<div style='width:100%; text-align:center; z-index:999; background-color:white; border-radius:30px; padding:1px 0;'><img src='./images/loading.png' width='150px'></div>";
	
		  	$.mobile.selectmenu.prototype.options.nativeMenu = false;
		});


		
		
			var date = new Date();
			var d = date.getDate();
			var m = (date.getMonth() + 1);
			var y = date.getFullYear();



       // 닫기(close)를 눌렀을 때 작동합니다.
        $('.windowClose .close').click(function (e) {
            e.preventDefault();
            $('.mask, .windowClose').hide();
        });
 
        // 뒤 검은 마스크를 클릭시에도 모두 제거하도록 처리합니다.
        $('.mask').click(function () {
            //$(this).hide();
            //$('.window').hide();
        });	

		
		
		
		$("#transExl").click(function(){
			
			var conam = document.getElementById("dsConame").value;
			var saup = document.getElementById("findSe").value;
			var fndtxt = document.getElementById("allFindTxt").value;
			//alert(conam+"/"+saup+"/"+fndtxt);
			//alert(CIBASE+'/scene/hjang/setEvent');
			//return;
			
						$.ajax({
							type:"POST",
							url: CIBASE+'/scene/hjang/downExcel',
							dataType: 'json',
							data: {
								// our hypothetical feed requires UNIX timestamps
								coid: conam,
								saup: saup,
								ftxt: fndtxt,
								ci_t:CIHS
							},
							success: function(doc) {
								
								alert(doc.rs);
								
							}, error:function(xhr, status, error){
								alert("err="+error);
							}
						});
				
				
				
			
		});
		

		
		
		//========================================
		//필드한개 짜리 페이지 전환없이 ajax 처리
		//=========================================
		$(".gasuName").click(function(e){
			e.preventDefault();
			var classname = this.className;
			
			
			if(classname.indexOf("gasuName") != -1){ //==============================
				var frm = document.getElementById("musicOn");
				var val = frm.gasuadd.value;
				if(!val){
					alert("아티스트의 이름을 입력하세요.");
					frm.gasuadd.setfocus();
					return;
				}
				
						$.ajax({
							type:"POST",
							url: CIBASE+'/common/ajaxc/proFieldSet',
							dataType: 'json',
							data: {
								// our hypothetical feed requires UNIX timestamps
								mode: "gasuup",
								tb: "mr_s_AAgasu_dir",
								val: val,
								ci_t:CIHS
							},
							success: function(doc) {
								
								//alert(doc);								
								//alert(doc.rs+"//"+doc.fdir);
								runPhpFunc("getAllGasu", doc.fdir);
								
								
							}, error:function(xhr, status, error){
								alert("err="+error);
							}
						});

			}else{   //===========================================
			
			
			}
			
			
		});
		//========================================
		//삭제를 여기서 모두 처리 한다.
		//========================================
		$(".adminDel").click(function(e){
			e.preventDefault();
			nowRecId = this.id;
			
			var classname = this.className;
			
			if(classname.indexOf("adminDel") != -1){
				if(!nowRecId){
					alert("설정된 권한이 없습니다.");
					return;
				}
			}			
			
			if(confirm("정말로 삭제 할까요?")){ //================================
				
				if(classname.indexOf("adminDel") != -1){
					if(!nowRecId){
						alert("설정된 권한이 없습니다.");
						return;
					}
					
					//alert(this.className+"///gogogo");
					location.href = CIBASE+"/common/ajaxc/recodeDel/memberActDel/memberAct/"+nowRecId+"/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3;
				}else{
				
				
				}

				
			
			
			} //===========================================
	
		});
		//========================================
		//세대별 키 선택 처리 
		//========================================
		$("input[name=mkey]").change(function(e){
			
			var se1 = '<tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>';
			
			var se2 = '<tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>';
			se2 += '<tr class="addTr"><th><span class="pilsu">*</span><span>Melody 포함 :</span></th><td><input type="file" name="inmelody" /></td></tr>';
			
			var se3 = '<tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>#1 :</span></th><td><input type="file" name="shap1" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>#2 :</span></th><td><input type="file" name="shap2" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>#3 :</span></th><td><input type="file" name="shap3" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>b1 :</span></th><td><input type="file" name="bb1" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>b2 :</span></th><td><input type="file" name="bb2" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>b3 :</span></th><td><input type="file" name="bb3" /></td></tr>';
			se3 += '<tr class="addTr"><th><span class="pilsu">*</span><span>Melody 포함 :</span></th><td><input type="file" name="inmelody" /></td></tr>';
			
			var se4M = '<tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>#1 :</span></th><td><input type="file" name="shap1" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>b1 :</span></th><td><input type="file" name="bb1" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>b2 :</span></th><td><input type="file" name="bb2" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>여자키 :</span></th><td><input type="file" name="wmkey" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>여자키 #1 :</span></th><td><input type="file" name="wshap1" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>여자키 b1 :</span></th><td><input type="file" name="wbb1" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>여자키 b2 :</span></th><td><input type="file" name="wbb2" /></td></tr>';
			se4M += '<tr class="addTr"><th><span class="pilsu">*</span><span>Melody 포함 :</span></th><td><input type="file" name="inmelody" /></td></tr>';	
			
			var se4F = '<tr class="addTr"><th><span class="pilsu">*</span><span>원키 :</span></th><td><input type="file" name="orgkey" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>#1 :</span></th><td><input type="file" name="shap1" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>b1 :</span></th><td><input type="file" name="bb1" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>b2 :</span></th><td><input type="file" name="bb2" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>남자키 :</span></th><td><input type="file" name="mnkey" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>남자키 #1 :</span></th><td><input type="file" name="mnshap1" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>남자키 b1 :</span></th><td><input type="file" name="mnbb1" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>남자키 b2 :</span></th><td><input type="file" name="mnbb2" /></td></tr>';
			se4F += '<tr class="addTr"><th><span class="pilsu">*</span><span>Melody 포함 :</span></th><td><input type="file" name="inmelody" /></td></tr>';			
			
			$(".addTr").remove();
			
			switch(this.value){
			case "1se":
				$("#musicOnOneTb").append(se1);
			break;
			case "2se":
				$("#musicOnOneTb").append(se2);
			break;
			case "3se":
				$("#musicOnOneTb").append(se3);
			break;
			case "4seM":
				$("#musicOnOneTb").append(se4M);
			break;
			case "4seF":
				$("#musicOnOneTb").append(se4F);
			break;
			}

			
		});


		
			//엔터키 무시
		$("#bdtit").keydown(function(e){
			
			switch(e.keyCode){
			case 13:
				//무시한다.
				return false;
				
			break;
			}

			
		});
		
		
		//
		
		
		//검색 설렉터를 초기화 한다.
		$("#selectMd, #selectMdsaup, #selectMdGBonsa, #selectMdmess, #selectMdmail, #selectMdsd, #selectMdds, #selectMdgongsa, #selectMdpt").change(function(){
			var obj = this;
			var val = this.value;
			
			switch(obj.id){
			case "selectMd":
			
				if(val == "0"){
					document.getElementById("gaipFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/member/main/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdsaup":
			
				if(val == "0"){
					document.getElementById("saupFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdGBonsa":
			
				if(val == "0"){
					document.getElementById("bonsaFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/community/community/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdmess":
			
				if(val == "0"){
					document.getElementById("messFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdmail":
			
				if(val == "0"){
					document.getElementById("mailFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdsd":
			
				if(val == "0"){
					document.getElementById("sdFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdds":
			
				if(val == "0"){
					document.getElementById("dsFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdgongsa":
			
				if(val == "0"){
					document.getElementById("gongsaFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			case "selectMdpt":
			
				if(val == "0"){
					document.getElementById("ptFindTxt").value = "";
					meminf.seFindVal = "";
					meminf.seFindMd = "0";
					location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				}
			
			break;
			}
			

		});
		
		
			
			//엔터키 처리를 한다.-텍스트 입력칸에서 엔터키
		$("#allFindTxt, #musicFindTxt, #gaipFindTxt, #saupFindTxt, #bonsaFindTxt, #messFindTxt, #mailFindTxt, #sdFindTxt, #dsFindTxt, #gongsaFindTxt, #ptFindTxt").keydown(function(e){
			
			var obj = this;
			

			
			switch(e.keyCode){
			case 13:
				switch(obj.id){
				case "musicFindTxt":
				
					if((!document.getElementById("musicFindTxt").value || document.getElementById("musicFindTxt").value == "") && document.getElementById("selectMdmusic").value != 0){
							appUtil.alertgo("알림","검색어를 입력하세요.");
							return;
					}
					
					meminf.seFindVal = document.getElementById("musicFindTxt").value;           //통합검색에서 선택한 검색값
					meminf.seFindMd = document.getElementById("selectMdmusic").value;
					//alert(meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4);
					location.href = CIBASE+"/music/musicon/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					
				
				break;
				case "allFindTxt":
				
					var ff = document.getElementById("allFindTxt");
					meminf.webFindTxt = ff.value;
					meminf.memSeCoId = document.getElementById("allfind").value;
					meminf.seFindVal = document.getElementById("findSe").value;
					
					location.href = CIBASE+"/scene/hjang/getView/4/1/"+meminf.memSeCoId+"/"+meminf.seFindVal+"/"+meminf.webFindTxt;
				
				break;
				case "gaipFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMd").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMd").value;
						//alert(meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4);
						location.href = CIBASE+"/member/main/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				break;
				case "saupFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdsaup").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdsaup").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
						//location.href = CIBASE+"/member/main/getView/2";///"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				break;
				case "bonsaFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdGBonsa").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdGBonsa").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/community/community/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				case "messFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdmess").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdmess").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				case "mailFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdmail").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdmail").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				case "sdFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdsd").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdsd").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				case "dsFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdds").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						
						var Aff = "A0";
						if(document.getElementById("selectFF").value != "A0") Aff = document.getElementById("selectFF").value;
						else if(document.getElementById("selectBJ").value != "B0") Aff = document.getElementById("selectBJ").value;
						else if(document.getElementById("selectGG").value != "C0") Aff = document.getElementById("selectGG").value;
						
						
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdds").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+Aff+meminf.seFindVal;
					}
				
				break;
				case "gongsaFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdgongsa").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdgongsa").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				case "ptFindTxt":
					if((!obj.value || obj.value == "") && document.getElementById("selectMdpt").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						//return;
					}else{
						meminf.seFindVal = obj.value;           //통합검색에서 선택한 검색값
						meminf.seFindMd = document.getElementById("selectMdpt").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					}
				
				break;
				}	
				
			break;
			}

			
		});
			
		
		//회원검색을 한다.-검색버튼 클릭
		$("#gaipFind, #musicFind, #bonsaFind, #messFind, #mailFind, #sdFind, #dsFind, #gongsaFind, #ptFind").click(function(){
			var obj = this;
			var inv, md, fg;
			switch(obj.id){
			case "gaipFind":
				
				if((!document.getElementById("gaipFindTxt").value || document.getElementById("gaipFindTxt").value == "") && document.getElementById("selectMd").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
				meminf.seFindVal = document.getElementById("gaipFindTxt").value;           //통합검색에서 선택한 검색값
				meminf.seFindMd = document.getElementById("selectMd").value;
				//alert(meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4);
				location.href = CIBASE+"/member/main/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				
			break;
			case "musicFind":
				if((!document.getElementById("musicFindTxt").value || document.getElementById("musicFindTxt").value == "") && document.getElementById("selectMdmusic").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
				meminf.seFindVal = document.getElementById("musicFindTxt").value;           //통합검색에서 선택한 검색값
				meminf.seFindMd = document.getElementById("selectMdmusic").value;
				//alert(meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4);
				location.href = CIBASE+"/music/musicon/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
				
			
			break;
			case "bonsaFind":
				if((!document.getElementById("bonsaFindTxt").value || document.getElementById("bonsaFindTxt").value == "") && document.getElementById("selectMdGBonsa").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("bonsaFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdGBonsa").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/community/community/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
					
			break;
			case "messFind":
				if((!document.getElementById("messFindTxt").value || document.getElementById("messFindTxt").value == "") && document.getElementById("selectMdmess").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("messFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdmess").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
			
			break;
			case "mailFind":
				if((!document.getElementById("mailFindTxt").value || document.getElementById("mailFindTxt").value == "") && document.getElementById("selectMdmail").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("mailFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdmail").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/notice/gongji/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
			
			break;
			case "sdFind":
				if((!document.getElementById("sdFindTxt").value || document.getElementById("sdFindTxt").value == "") && document.getElementById("selectMdsd").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("sdFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdsd").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
			
			break;
			case "dsFind":
				if((!document.getElementById("dsFindTxt").value || document.getElementById("dsFindTxt").value == "") && document.getElementById("selectMdds").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						var Aff = "A0";
						if(document.getElementById("selectFF").value != "A0") Aff = document.getElementById("selectFF").value;
						else if(document.getElementById("selectBJ").value != "B0") Aff = document.getElementById("selectBJ").value;
						else if(document.getElementById("selectGG").value != "C0") Aff = document.getElementById("selectGG").value;
						
						//alert(Aff);
						
						meminf.seFindVal = document.getElementById("dsFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdds").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+Aff+meminf.seFindVal;
			
			break;
			case "gongsaFind":
				if((!document.getElementById("gongsaFindTxt").value || document.getElementById("gongsaFindTxt").value == "") && document.getElementById("selectMdgongsa").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("gongsaFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdgongsa").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
			
			break;
			case "ptFind":
				if((!document.getElementById("ptFindTxt").value || document.getElementById("ptFindTxt").value == "") && document.getElementById("selectMdpt").value != 0){
						appUtil.alertgo("알림","검색어를 입력하세요.");
						return;
				}
				
						meminf.seFindVal = document.getElementById("ptFindTxt").value;
						meminf.seFindMd = document.getElementById("selectMdpt").value;
						//alert(CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal);
						location.href = CIBASE+"/scene/hjang/getView/"+meminf.md1+"/"+meminf.md2+"/"+meminf.md3+"/"+meminf.md4+"/"+meminf.seFindMd+"--"+meminf.seFindVal;
			
			break;
			}
			
		});
		
	
		
		
		//통합검색 클릭
		$("#allFindGet").click(function(){
			
			var ff = document.getElementById("allFindTxt");
			meminf.webFindTxt = ff.value;
			//alert("fffff"+ff.value);
			meminf.memSeCoId = document.getElementById("allfind").value;
			meminf.seFindVal = document.getElementById("findSe").value;
			
			
			location.href = CIBASE+"/scene/hjang/getView/4/1/"+meminf.memSeCoId+"/"+meminf.seFindVal+"/"+meminf.webFindTxt;
			
			/*
			var qr = CIBASE+"/scene/hjang/allFindGet";
			//alert(qr+"----/"+CIHS+"/"+meminf.webFindTxt+"/"+meminf.memSeCoId+"/"+meminf.seFindVal);
			$.ajax({type:"POST", data:{coid:meminf.memSeCoId, findSe:meminf.seFindVal, findTxt:meminf.webFindTxt, ci_t:CIHS}, url:qr, timeout:10000, dataType:"json",success:function(data){
		
					//alert(data);
		
			},error:function(xhr,status,error){
				//alert("err3="+error);
			}
			});
			//*/
			
			
		});
		
		//엑셀로 변환 한다.
		$("#transExl").click(function(){
		
			
		});
		
		
		

		
		//메시지 내용보기 
		$(".messView, .pushView, .mailView").click(function(){
			var md = 0;
			switch($(this).attr('class')){
			case "messView":
				md = 1;
			break;
			case "mailView":
				md = 2;
			break;
			case "pushView":
				md = 3;
			break;
			}

			location.href = CIBASE+"/notice/gongji/getView/"+md+"/3/"+this.id;
			
		});
		
			
		
		//onsubmit 처리===========
		$("#messSendGo, #pushSendGo, #mailSendGo").click(function(){
			
			var objForm;
			switch(this.id){
			case "mailSendGo":
				objForm = document.getElementById("frmMail");
				
	
				meminf.susinMem = "";
				if(document.getElementById("mailChkAll").checked){
					meminf.susinMem = "all";
				}else{
					var aa = document.querySelectorAll(".mailSend");
					for(var c=0; c < aa.length; c++){
						if(aa[c].checked){
							if(meminf.susinMem != "") meminf.susinMem += "-";
							meminf.susinMem += aa[c].value;
						}
					}
				}
			
				if(meminf.susinMem == ""){
					appUtil.alertgo("알림","메일 수신자를 선택하세요.");
					return;
				}
			
				//alert(meminf.susinMem);
			
				objForm.susin.value = meminf.susinMem;
				objForm.sendCo.value = document.getElementById("mailMem").value;
				
			
				var tit = $("#mailTit");
				var mess = $("#mailMess");
				
				
				
				if(!$(tit).val()){
					appUtil.alertgo("알림","제목을 입력하세요.");
					tit.focus();
					return;
				}
								
				if(!$(mess).val()){
					appUtil.alertgo("알림","내용을 입력하세요.");
					mess.focus();
					return;
				}
				
				objForm.submit();
			
			
			break;
			case "pushSendGo":
				objForm = document.getElementById("frmPush");
				
	
				meminf.susinMem = "";
				if(document.getElementById("pushChkAll").checked){
					meminf.susinMem = "all";
				}else{
					var aa = document.querySelectorAll(".pushSend");
					for(var c=0; c < aa.length; c++){
						if(aa[c].checked){
							if(meminf.susinMem != "") meminf.susinMem += "-";
							meminf.susinMem += aa[c].value;
						}
					}
				}
			
				if(meminf.susinMem == ""){
					appUtil.alertgo("알림","푸쉬 수신자를 선택하세요.");
					return;
				}
			
				//alert(meminf.susinMem);
			
				objForm.susin.value = meminf.susinMem;
				objForm.sendCo.value = document.getElementById("pushMem").value;
				
			
				var tit = $("#pushTit");
				var plink = $("#pushLink");
				//var ee = plink.value;
				//ee = ee.replace("http://", "");
				//plink.value = "http://"+ee;
				
				var mess = $("#pushMess");
				
				
				
				if(!$(tit).val()){
					appUtil.alertgo("알림","제목을 입력하세요.");
					tit.focus();
					return;
				}
								
				if(!$(mess).val()){
					appUtil.alertgo("알림","내용을 입력하세요.");
					mess.focus();
					return;
				}
				
				objForm.submit();
			
			
			break;
			case "messSendGo":
				objForm = document.getElementById("frmMess");
				
				//alert("kkk"+objForm.messTit.value);
				
				meminf.susinMem = "";
				if(document.getElementById("messChkAll").checked){
					meminf.susinMem = "all";
				}else{
					var aa = document.querySelectorAll(".messSend");
					for(var c=0; c < aa.length; c++){
						if(aa[c].checked){
							if(meminf.susinMem != "") meminf.susinMem += "-";
							meminf.susinMem += aa[c].value;
						}
					}
				}
			
				if(meminf.susinMem == ""){
					appUtil.alertgo("알림","메시지 수신자를 선택하세요.");
					return;
				}
			
				//alert(meminf.susinMem);
			
				objForm.susin.value = meminf.susinMem;
				objForm.sendCo.value = document.getElementById("messMem").value;
				
			
				var tit = $("#messTit");
				var mess = $("#messMess");
				
				if(!$(tit).val()){
					appUtil.alertgo("알림","제목을 입력하세요.");
					tit.focus();
					return;
				}
								
				if(!$(mess).val()){
					appUtil.alertgo("알림","내용을 입력하세요.");
					mess.focus();
					return;
				}
				
				objForm.submit();
			
			break;
			}
			
			
			
			
		});

		
		$("#messMem, #pushMem, #mailMem, #freeBd, #dataBd").change(function(){
			//alert(this.value);	
			var gubun;
			switch(this.id){
			case "messMem":
				gubun = 1;
				location.href = CIBASE+"/notice/gongji/getView/"+gubun+"/2/"+this.value;
			break;
			case "pushMem":
				gubun = 3;
				location.href = CIBASE+"/notice/gongji/getView/"+gubun+"/2/"+this.value;
			break;
			case "mailMem":
				gubun = 2;
				location.href = CIBASE+"/notice/gongji/getView/"+gubun+"/2/"+this.value;
			break;
			case "freeBd":
				location.href = CIBASE+"/community/community/getView/4/1/0/"+this.value;
			
			break;
			case "dataBd":
				location.href = CIBASE+"/community/community/getView/3/1/0/"+this.value;
			break;
			}
			
			
		});
		
		
		$(".messSend, .pushSend, .mailSend").click(function(){
			switch($(this).attr('class')){
			case "messSend":
				document.getElementById("messChkAll").checked = false;
			break;
			case "mailSend":
				document.getElementById("mailChkAll").checked = false;
			break;
			case "pushSend":
				document.getElementById("pushChkAll").checked = false;
			break;
			}

		
		});
		
		
		
		$("#messChkAll, #pushChkAll, #mailChkAll").click(function(){
			var obj = this;
			var cssall = "";
			switch(this.id){
			case "messChkAll":
				cssall = ".messSend";
			break;
			case "mailChkAll":
				cssall = ".mailSend";
			break;
			case "pushChkAll":
				cssall = ".pushSend";
			break;
			}
			
			var aa = document.querySelectorAll(cssall);
			if(obj.checked){
				//전체 체크한다.
				for(var c = 0; c < aa.length; c++){
					aa[c].checked = true;
				}
			}else{
				//전체 체크해제한 경우 
				for(var c = 0; c < aa.length; c++){
					aa[c].checked = false;
				}
			}
			
		});
		
		


		
		
		
		//가입회원, 미가입회원, 차단회원 리스트 클릭시 상세보기 출력한다.
		$(".desangList").click(function (){
			var obj = this;
			var vv = obj.id.split("-");
			//현재선택된 대상회원의 정보를 저장한다.
			meminf.seRecid = Number(vv[1]);
			
			//alert(obj.id+"/"+vv[1]+"/meminf="+meminf.seRecid);
			
			var md = 0;
			switch(vv[0]){
			case "ga":
				md = 2;
			break;
			case "no":
				md = 1;
			break;
			case "ch":
				md = 3;
			break;
			}
			
			var ml = $("#memgubun").val();  //업체 구분
			
			location.href = CIBASE+"/member/main/getView/"+md+"/2/"+ml+"/"+meminf.seRecid+"/0/"+meminf.page;  //상세보기 페이지로 이동한다.
			
		});
		

		//숫자 유효성 검사 
		var old = "";
		$("#bthday1").keyup(function(ev){
			var keyID = ev.keyCode;
			
						var inputtel = $(this).val();
						if(inputtel.length > 6){
							$(this).val(old);
							return;
						}else{
							old = $(this).val();
						}
			
			
			if( ( keyID >=48 && keyID <= 57 ) || ( keyID >=96 && keyID <= 105 ) ){}
				

			else{
				
				if(keyID != 37 && keyID != 39 && keyID != 38 && keyID != 40 && keyID != 91 && keyID != 8 && keyID != 27 && keyID != 13){
					appUtil.alertgo("알림","숫자만 입력가능 합니다.");
					$(this).val("");
					return;
				}

			}
		});

		
		//전화번호 유효성 검사
		///^01[016789]-[0-9]{3,4}-[0-9]{4}$/;
		///^[가-힁]{2,10}$/;  //한글만 2~10자 입력
		///^[a-z0-9]{5,20}$/   //[]는 한글자를 의미 한다. 알파벳소문자, 숫자 5~20 글자 여부를 확인한다.
		$("#idtel, #pwtel, #memtel, #edtmemtel, #cotel, #dshtel, #dstel").keyup(function(ev){
			var keyID = ev.keyCode;
			
			if( ( keyID >=48 && keyID <= 57 ) || ( keyID >=96 && keyID <= 105 ) ){}
			else{
				
				//alert(keyID);
				
				if(keyID != 37 && keyID != 39 && keyID != 38 && keyID != 40 && keyID != 91 && keyID != 8 && keyID != 27 && keyID != 13){
					appUtil.alertgo("알림","숫자만 입력가능 합니다.");
					$(this).val("");
					return;
				}

			}
			
			
			var inputtel = $(this).val();
			//console.log("keyup==="+inputtel);
			if(inputtel.length == 0){
				oldtel = "";
				return;
			}
			
			var regTel = /^01[0-9]{1}[0-9]{3,4}[0-9]{4}$/; ////^\d{3}\d{3,4}\d{4}$/;
			//var regTel2 = /^01[0-9]{1}[0-9]{3,4}[0-9]{4}$/; ////^\d{3}\d{3,4}\d{4}$/;
			if(regTel.test(inputtel)){
				//oldtel = inputtel;
				telgab = true;
			}else{
				//$(this).val(oldtel);
				telgab = false;
			}
			if(telgab){
				if(telgab.length < 10 || telgab.length > 11) telgab = false;
			}
			
		});
		
		
		$("#idtel, #pwtel, #memtel").focusout(function(){
			oldtel = "";
		});
		//아이디 유효성 검사
		$("#pwid, #memid, #cmemid").keyup(function(){
			var inputid = $(this).val();
			
			var regId = /^[a-zA-Z0-9]{4,10}$/;
			if(regId.test(inputid)){
				idgab = true;
			}else{
				idgab = false;
			}
		});
		//이메일 유효성 검사
		$("#idemail1, #pwemail1, #email1, #coemail1").keyup(function(){
			var inputid = $(this).val();
			//console.log("keyup==="+inputid);
			
			var regId = /^[a-zA-Z0-9*&%^!~#-_=]{4,20}$/;
			if(regId.test(inputid)){
				oldId = inputid;
				emailgab1 = true;
			}else{
				emailgab1 = false;
				//alert("not");
				//$(this).val(oldId);
			}
		});
		//이메일 주소유효성검사
		$("#idemail2, #pwemail2, #email2, #coemail2").keyup(function(){
			var inputid = $(this).val();
			
			var regId = /^[a-zA-Z0-9]{2,25}[.]{1,1}[a-zA-Z0-9]{2,25}$/;
			if(regId.test(inputid)){
				oldId = inputid;
				emailgab2 = true;
			}else{
				emailgab2 = false;
				//alert("not");
				//$(this).val(oldId);
			}
		});

	
		
});



	
	function onBackKeyDown(){
	
	}

	function onDeviceReady(){
		//처음한번만 실행한다. 
		//웹버젼에서는 작동 않함
		
		
		//navigator.splashscreen.show();
		//앱시작전 배경화면	
		//navigator.splashscreen.hide();
		appBasInfo.deviceUiu = device.uuid;
		window.sessionStorage.setItem("deviceUiu",appBasInfo.deviceUiu);

		//파일처리를 한다.
		fileObj = new GetServer();
		fileObj.fileSysGet();
		

		
		
		//푸시관련 처리
		///*
		if(device.platform.toUpperCase() == 'ANDROID'){
			//안드로이드 
	        window.plugins.pushNotification.register(successHandler,errorHandler, {
	          "senderID" : "1052452546002", // Google GCM 서비스에서 생성한 Project Number를 입력한다.1052452546002
	          "ecb" : "onNotificationGCM" // 디바이스로 푸시가 오면 onNotificationGCM 함수를 실행할 수 있도록 ecb(event callback)에 등록한다.
	        });
	      } else {
	    	//아이폰 
	        // PushPlugin을 설치했다면 window.plugins.pushNotification.register를 이용해서 iOS 푸시 서비스를 등록한다.
	        window.plugins.pushNotification.register(tokenHandler, errorHandler, {
	          "badge":"true", // 뱃지 기능을 사용한다.
	          "sound":"true", // 사운드를 사용한다.
	          "alert":"true", // alert를 사용한다.
	          "ecb": "onNotificationAPN" // 디바이스로 푸시가 오면 onNotificationAPN 함수를 실행할 수 있도록 ecb(event callback)에 등록한다.
	        });
	      }		
		//*/

		
		
		
		
		window.sessionStorage.setItem("wifiinf", "init");
		
		appBasInfo.conType = navigator.network.connection.type;
		if(appBasInfo.conType != "none"){   //네트워크 연결 되엇다. 

			


		}
		
		

		//페이지 표시 이후에 처리된다.
		//앱을 처음 실행할 때 로그인 여부를 확인한다.
		if(appBasInfo.nowPage == "page"){
			

				
		}
		
		
		
		
	}


	


	
//====================================================================================================
//PUSH-----------------------------------------------------------------------------------------------
//====================================================================================================================
	var PS = "http://mroo.co.kr/sohoring/push/images/";   //푸시 이미지 링크
	//푸시관련 
	var pushMd = "jd";  //ev:event, jd:전단 , ps:일반 푸시
	var pushRecid = 0;   //공지사항의 레코드 아이디
	var pushImg = "";  //푸시 이미지
	var pushCall = false;   //푸시에서 호출 여부 저장 
	var pushBack = false;   //푸시보기에서 빽을 클릭하는 경우 index 로 가도록 처리 여부
	//=================================================================

	//deviceready 에 Project Id 를 설정 한다.
	pushRecid = window.sessionStorage.getItem("pushRecid");
	/**
	 * tokenHandler
	 *
	 * @param result
	 *
	 * 디바이스 토큰핸들러 콜백함수.
	 * 푸시 서비스를 활성화 하였을 때, window.plugins.pushNotification.register 메소드가 실행되면서 디바이스 토큰을 가져와서 출력한다.
	 * 만약에 푸시 서버로 디바이스 토큰을 보내야할 경우 이 함수 안에서 서버로 디바이스 토큰을 전송하면 된다.
	 */
	function tokenHandler(result){
	  	//alert('deviceToken:' + result);
	}

	/**
	 * errorHandler
	 *
	 * @param err
	 *
	 * 에러 핸들러 콜백 함수.
	 */
	function errorHandler(err){
	  	//alert('error:' + err);
	}

	/**
	 * successHandler
	 *
	 * @param result
	 *
	 * 디바이스로 푸시 메세지를 받았을 때 뱃지처리 이후 호출하는 콜백함수
	 */
	function successHandler(result){
		
		
	  //alert('result:'+result);
	}	
	
	
	/**
	 * onNotificationAPN
	 *
	 * @param event
	 *
	 * iOS 디바이스로 푸시 메세지를 받을 때 호출되는 콜백함수, window.plugins.pushNotification.register 옵션 설정에서 ecb의 이름에 매칭된다.
	 *ios-------------------------/
	function onNotificationAPN (event){
	  // 푸시 메세지에 alert 값이 있을 경우
	  if (event.alert){
	    navigator.notification.alert(event.alert);
	  }

	  // 푸시 메세지에 sound 값이 있을 경우

	  // 푸시 메세지에 bage 값이 있을 경우
	  if (event.badge){
	    window.plugins.pushNotification.setApplicationIconBadgeNumber(successHandler, errorHandler, event.badge);
	  }
	}

	----------------------------------/**
	 * onNotificationGCM
	 *
	 * @param e
	 *
	 * 안드로이드 디바이스로 푸시 메세지를 받을 때 호출되는 함수, window.plugins.pushNotification.register 옵션에 설정에서 ecb의 이름에 매칭된다.
	 */
	//regId를 반환받아서 서버에 저장 한다.
	function onNotificationGCM (e){
		
	  switch (e.event) {
	  case 'registered': // 안드로이드 디바이스의 registerID를 획득하는 event 중 registerd 일 경우 호출된다.
	    //regId를 반환 받는다.
	  	//alert('registerID:' + e.regid);
	  
	  	//register 를 gcimid 에 저장 한다.
		setPushDB(e.regid);
	  
	  
	    break;
	  case 'message': // 안드로이드 디바이스에 푸시 메세지가 오면 호출된다.
	    {
		  
		  //payload 는 php에서 배열에 설정한 값을 가져온다.
		  //alert("mode="+e.payload.listInf+"/"+e.payload.msgcnt+"/"+e.payload.defaults);
		  
		  
		  if (e.foreground){ // 푸시 메세지가 왔을 때 앱이 실행되고 있을 경우
			 //앱이 실행중인 상태
			  
	        	navigator.notification.beep(2);
	        	
	        	if(AWtrans.mobileInf){
	        		
	        		if(((appBasInfo.nowPage == "ContentSS2") && (e.payload.listInf == "ct")) && appBasInfo.nowJmIndx == e.payload.notId){
	        			//페이지 이동을 하지 않는다.
	        			//댓글을 다시 가져온다.
	        		    //작성중인 댓글을 복원하기 위해 댓글을 저장한다.
	        			appBasInfo.imsiDet = $("#ssDetCont").val();
	        			appBasInfo.imsiDap = $("#ctDapCont").val();
	        			
	        			
	        			var jbd = new GetServer();
	        			//컨텐츠 댓글을 가져온다.
	        			jbd.ctDetTextList(meminf);
	        			
	        			
	        		}else if(((appBasInfo.nowPage == "JumunBDView") && (e.payload.listInf == "jumun")) && (appBasInfo.jumunBdIndex == e.payload.notId)){
	        			//페이지 이동을 하지 않는다.
	        			//댓글을 다시 가져온다.
	        		    //작성중인 댓글을 복원하기 위해 댓글을 저장한다.
	        			appBasInfo.imsiDet = $("#jmDetCont").val();
	        			appBasInfo.imsiDap = $("#jmDapCont").val();
	        			
	        			
	        			//주문상세내역을 가져온다.
	        			var jbd = new GetServer();
	        			//댓글을 가져온다.
	        			jbd.jmDetTextList(meminf);   //주문게시판의 댓글을 출력한다.
	        			
	        			
	        		}else{
	        			//페이지 이동을 한다.
	        			var pageInf = "주문게시판";
	        			if(e.payload.listInf == "ct") pageInf = "컨텐츠"
	        			
	        			
		        		navigator.notification.confirm(pageInf+'에 댓글/답글이 달렸습니다. 이동할까요?', function(button){
		        	    	if(button == 2){   //삭제한다.

		        	        	pushViewGo(1, e.payload.notId, e.payload.listInf);
		        	        	
		        	    	} 
		        	    }, '질문', '아니오,예');
	        			
	        		}
	        		
	        		

	        		
	        	}
	        	
	      	
	      	} else { // 푸시 메세지가 왔을 때 앱이 백그라운드로 실행되거나 실행되지 않을 경우
	      		//푸시가 오는 당시에 앱이 종료 상태 이면 앱이 실행 되는 순간 아래 부분이 실행 된다.
	      		
	      		
	      		
	        	if (e.coldstart) { // 푸시 메세지가 왔을 때 푸시를 선택하여 앱이 열렸을 경우
	          		//console.log("알림 왔을 때 앱이 열리고 난 다음에 실행 될때");
	        		
	          		pushViewGo(1, e.payload.notId, e.payload.listInf);
	        	
	        	} else { // 푸시 메세지가 왔을 때 앱이 백그라운드로 사용되고 있을 경우
	          		//console.log("앱이 백그라운드로 실행될 때");
	        
	          		pushViewGo(2, e.payload.notId, e.payload.listInf);
	        
	        	}
	      	}
	      
	    }
	    break;
	  case 'error': // 푸시 메세지 처리에 에러가 발생하면 호출한다.
	    alert('error:' + e.payload.message);
	    break;
	  case 'default':
	    alert('알수 없는 이벤트');
	    break;
	  }
	}

	//앱을 푸시 DB에 등록 한다
	function setPushDB(regid){
		
		phoneRegid = regid;
		
		//alert(regid);
		if(regid != "0"){
			var ss = "regid="+regid+"&phonenum="+window.sessionStorage.getItem("phoneno")+"&proje="+PROJE+"&udid="+appBasInfo.deviceUiu+"&memid="+meminf.UserA;	
			//컨텐츠의 리스트를 가져온다.
			var alb = new GetServer();
			//선한메뉴의 컨텐츠를 가져온다.
			//var dom = document.querySelector(".allAlbum3");
			alb.initParamPush("allphpfile/gcmidinput.php", ss, "PushInfoSet", "mu");
			alb.getPostModeTxt(alb, this.mem);  //서버에서 post 모드로 가져온다.
		}
		
	}



	//푸시창에서 보기 클릭한 경우 
	function pushViewGo(md, tid, listMd){
		//2: 두번 실행됨 - 백그라운드 실행중인 경우 
		//1: 한번 실행 - 앱이 종료된 상태 
		//alert("off md="+md);
		

		if(md == 1){
			//navigator.notification.beep(2);
			
			if(listMd == "ct"){
				appBasInfo.nowJmIndx = tid;
				appUtil.moveOkHistory("contentSS2.html");
			}else{
				appBasInfo.jumunBdIndex = tid;
				appUtil.moveOkHistory("jumunBDView.html");
			}
		}else{
			if(backStay == 1){  //한번만 출력하기 위해서 변수를 사용했다.
				//앱이 백그라운드에서 실행 상태이니 댓글을 다시 가져온다.
				//navigator.notification.beep(2);
	      		
				
				if(appBasInfo.nowPage == "ContentSS2" && listMd == "ct"){
					//페이지 이동을 하지 않는다.
        			//댓글을 다시 가져온다.
        		    //작성중인 댓글을 복원하기 위해 댓글을 저장한다.
        			appBasInfo.imsiDet = $("#ssDetCont").val();
        			appBasInfo.imsiDap = $("#ctDapCont").val();
        				
        			var jbd = new GetServer();
        			//컨텐츠 댓글을 가져온다.
        			jbd.ctDetTextList(meminf);

					
				}else if(appBasInfo.nowPage == "JumunBDView" && listMd == "jumun"){
					//페이지 이동을 하지 않는다.
        			//댓글을 다시 가져온다.
        		    //작성중인 댓글을 복원하기 위해 댓글을 저장한다.
        			appBasInfo.imsiDet = $("#jmDetCont").val();
        			appBasInfo.imsiDap = $("#jmDapCont").val();
        			
        			
        			//주문상세내역을 가져온다.
        			var jbd = new GetServer();
        			//댓글을 가져온다.
        			jbd.jmDetTextList(meminf);   //주문게시판의 댓글을 출력한다.

					
				}else{
					//페이지 이동을 한다.
					if(listMd == "ct"){
						appBasInfo.nowJmIndx = tid;
						appUtil.moveOkHistory("contentSS2.html");
					}else{
						appBasInfo.jumunBdIndex = tid;
						appUtil.moveOkHistory("jumunBDView.html");
					}
				}
				
				backStay++;
			}else{
				backStay = 1;
			}
		}
				
		
	}



	
	function resize(){

		
		//$('.resizable').resizable();
		
	}
	
	//이미지 축소 확대 이동 center 방식
	var imgResizeC = {
			
			divDomTxt:"",
			divImgTxt:"",
			scrH:0,
			scrW:0,
			imgW:0,  //원본이미지 넓이
			imgH:0,  //원본이미지 높이
			imgRt:0,  //이미지의 넖이로 높이를 구하는 스케일
			
			imgLeftC:0,  //이미지의 왼쪽에서 센터 
			imgTopC:0,   //이미지의 위쪽에서 센터
			
			scrLeftC:0,  //스크린의 왼쪽 센터 
			scrTopC:0,   //스크린의 윗쪽 센터
			
			imgLeftSai:0,   //이미지 왼쪽의 여유 또는 부족 공간 
			imgTopSai:0,  //이미지 윗쪽의 여유 또는 부족 공간
			
			imgLeftMv:0,   //이미지가 왼쪽으로 움직일 수 있는 거리 
			imgTopMv:0,    //이미지가 위쪽으로 움직일 수 있는 거리 
			
			
			init:function(divDom, imgDom, vimg){
				this.divDomTxt = divDom;
				this.divImgTxt = imgDom;
				this.scrH = appBasInfo.screenH;
				this.scrW = appBasInfo.screenW;
				
				
				$("#"+divDom).css({"height":this.scrH+"px", "max-height":appBasInfo.screenH+"px"});
				$("#"+imgDom).attr("src", vimg);  //이미지를 출력한다.
				
				//이미지의 크기를 구한다.
				this.getImgSize();
				//이미지와 스크린의 센터값을 구한다.
				this.getCenter();
				//이미지의 크기를 스크린과 비교하고 맞춘다.
				this.getImgSize();
				//이미지의 이동가능한 거리를 구한다.
				this.getMoveSai();
				
			},
			
			getCenter:function(){
			
				this.imgLeftC = (this.imgW / 2);
				this.imgTopC = (this.imgH / 2);
				
				this.scrLeftC = (this.scrW / 2);
				this.scrTopC = (this.scrH / 2);
				
			},
			
			getImgSize:function(){
				this.imgH = $("#"+this.divImgTxt).height();
				this.imgW = $("#"+this.divImgTxt).width();
				
				//넓이로 높이 구하는 변수 
				this.imgRt = (this.imgH / this.imgW);
				
				
				var saW = (this.imgW / 2);
				var aa = (this.scrLeftC - saW);  //0보다 크면 이미지가 화면 보다 작다.
				if(aa >= 0){
					//이미지가 화면보다 작아 화면에 맞춘다.
					this.imgLeftC = this.scrLeftC;
					this.imgW = this.scrW;
					this.imgH = (this.imgW * this.imgRt);
					
					this.imgLeftSai = 0;
				}else{
					this.imgLeftSai = aa;
				}
				
				var saH = (this.imgH / 2);
				var aa = (this.scrTopC - saH);   //0보다 크면 이미지 높이가 화면 보다 작다.
				if(aa >= 0) this.imgTopSai = 0;    //이미지가 화면 보다 작으면 위쪽으로 움직이지 못한다.
				
			}, 
			
			//이미지의 이동가능한 거리를 구한다.
			getMoveSai:function(){
				this.getImgSize();
				
				this.imgLeftMv = Math.abs(this.imgLeftSai);
				this.imgTopMv = Math.abs(this.imgTopSai);
			},
			
			
			
	}
	


	
	
	//이미지 크기 다시 설정Margin 방식
	var imgResize = {
			
		divDomTxt:"",
		divImgTxt:"",
		scrH:0,
		scrW:0,
		imgW:0,  //원본이미지 넓이
		imgH:0,  //원본이미지 높이
		imgRt:0,  //이미지의 넖이로 높이를 구하는 스케일
		
		imgWAddRat:25,   //이미지 넓이의 증가량
		imgMaxW:2000,    //화면의 최대크기
		
		
		chnImgH:0,  //화면에 맞게 수정된 높이
		
		pinch:null,
		rotate:null,
		
		hm:null,
		
		
		topM:0,    //위쪽 마진
		topMM:0,
		bottomM:0,  //아랫쪽 마진
		
		
		rightM:0,
		leftM:0,
		leftMM:0,
		leftRat:0,
		
		imsiMM:0,
		
		topM:0,
		bottomM:0,
		topRat:0,
		
		
		oldSc:0,
		
		chW:0,
		
		panSumX:0,
		panSumY:0,
		panCount:0,
		panGo:2,
		
		
		//pan처리 변수 
		imgNowTop:0,    //이미지의 현재 top 위치
		imgNowLeft:0,   //이미지의 현재 left 위치 
		imgNowWidth:0,  //현재 이미지의 넓이
		imgNowHeight:0,  //현재 이미지의 높이
		
		imgNowCenterX:0, //이미지의 중심 x위치 
		imgNowCenterY:0, //이미지의 중심 y위치 
		
		
		panX:0,
		panY:0,
		moveYup:0,
		moveYdown:0,
		moveXup:0,
		moveXdown:0,
		
		
			
		init:function(divDom, imgDom, vimg){
			this.divDomTxt = divDom;
			this.divImgTxt = imgDom;
			this.scrH = appBasInfo.screenH;
			
			
			$("#"+divDom).css({"height":this.scrH+"px", "max-height":appBasInfo.screenH+"px"});
			$("#"+imgDom).attr("src", vimg);  //이미지를 출력한다.
			
			this.imgH = $("#"+this.divImgTxt).height();
			this.imgW = $("#"+this.divImgTxt).width();
			//넓이로 높이 구하는 변수 
			this.imgRt = (this.imgH / this.imgW);
			
		},
		
		//화면을 이동처리 한다.
		moveImage:function(mvX, mvY){
			//imgResize.topM
			//imgResize.leftM
			//이미지의 현재 위치저장 
			//imgResize.imgNowTop = imsi;
			//imgResize.imgNowLeft = 0;
			
			
			//x 방향 처리를 한다.==================================
			var imsiR = imgResize.rightM + mvX;  //왼쪽 
			var imsiL = imgResize.leftM + mvX;
			

			
			if(mvX < 0){
				//오른쪽 초과분이 0보다 크면 작동
				//왼쪽으로 이동 - 왼쪽초과분이 늘어 나는 만큼 오른쪽 초과분은 감소 한다.
				//오른쪽초과분이 0이면 더이상 이동하지 않는다.
				//왼쪽으로 이동처리 한다.
				//alert(imgResize.rightM+"/ rM="+(imgResize.rightM + mvX)+"/ olm="+imgResize.leftM+"/ lM="+(imgResize.leftM + mvX));
				if(imsiR > 0){
					//작동한다.
					imgResize.rightM = imsiR;
					imgResize.leftM = imsiL;
					
					imgResize.imgNowLeft += mvX;
				}
			}else if(mvX > 0){
				//왼쪽 초과분이 0보다 작으면 작동
				//오른쪽으로 이동 - 오른쪽 초과분 증가하는 왼쪽 초과분은 감소한다.
				//왼쪽 초과분이 0이면 더이상 이동하지 않는다.
				//왼쪽으로 이동처리 한다.
				//alert(imgResize.rightM+"/ rM="+(imgResize.rightM + mvX)+"/ olm="+imgResize.leftM+"/ lM="+(imgResize.leftM + mvX));
				if(imsiL < 0){
					//작동한다.
					imgResize.rightM = imsiR;
					imgResize.leftM = imsiL;
					
					imgResize.imgNowLeft += mvX;
				}
			}
			//y 방향 처리를 한다.=====================================
			var imsiU = imgResize.topM + mvY;  //윗쪽
			var imsiD = imgResize.bottomM + mvY;
			if(mvY < 0){
				//아랫쪽 초과분이 0보다 크면 작동
				//위로 이동 - 위쪽초과분이 늘어 나는 만큼 아랫쪽 초과분은 감소 한다.
				//아랫쪽초과분이 0이면 더이상 이동하지 않는다.
				if(imsiD > 0){
					//작동한다.
					imgResize.topM = imsiU;
					imgResize.bottomM = imsiD;
					
					imgResize.imgNowTop += mvY;
				}
				//alert(imgResize.topM+"/ uM="+(imgResize.topM + mvY)+"/ olm="+imgResize.bottomM+"/ dM="+(imgResize.bottomM + mvY));
			}else if(mvY > 0){
				//위쪽 초과분이 0보다 작으면 작동
				//아랫쪽으로 이동 - 아랫쪽 초과분 증가하고 윗쪽 초과분은 감소한다.
				//윗쪽 초과분이 0보다 크면 더이상 이동하지 않는다.
				if(imsiU < 0){
					imgResize.topM = imsiU;
					imgResize.bottomM = imsiD;
					
					imgResize.imgNowTop += mvY;
				}
				//alert(imgResize.topM+"/ uM="+(imgResize.topM + mvY)+"/ olm="+imgResize.bottomM+"/ dM="+(imgResize.bottomM + mvY));
			}
			
			//그림이 화면 크기보다 작은 경우 화면의 중앙에 놓이게 한다.
			if(imgResize.imgNowHeight < imgResize.scrH){
				var imsi = (imgResize.scrH - imgResize.imgNowHeight) / 2;
				imgResize.topM = imsi;
				
				imgResize.imgNowTop = imsi;
				imgResize.imgNowLeft = 0;
			}
			
			console.log("******* x = "+imgResize.imgNowLeft+" / y = "+imgResize.imgNowTop+" *******");
			//새로운 위치를 출력한다.
			$("#ImageViewImg").css({"margin":imgResize.topM+"px 0 0 "+imgResize.leftM+"px"});
			
			
			
			/*
			var goX = (0 - (imgResize.imgNowWidth * Math.abs(imgResize.imgNowLeft)));
			var goY = 0;
			if(imgResize.topM > 0){
				goY = (imgResize.imgNowHeight * Math.abs(imgResize.imgNowTop));
			}else{
				goY = (0 - (imgResize.imgNowHeight * Math.abs(imgResize.imgNowTop)));
			}
			$("#ImageViewImg").css({'transform': 'translate('+goX+'px, '+goY+'px)'});
			*/
		},
		
		imgMark:function(mark){
			
			var mk = document.getElementById(mark);
			
			if(this.imgNowHeight > this.scrH){
				//이미지가 화면 보다 큰 경우 
				mk.style.marginTop = (this.scrH - 60)+"px";
				mk.style.marginLeft = (this.scrW - 260)+"px";
				
			}else{
				
				var imsi = (this.topM + (this.imgNowHeight * 0.74));
				
				//이미지가 화면보다 작다.
				mk.style.marginTop = imsi+"px";
				mk.style.marginLeft = (this.scrW - 260)+"px";
				
			}
			
			
		},
		
		dispBtn:function(btnGo, btnDown){
			
			var btGo = document.getElementById(btnGo);
			var btDown = document.getElementById(btnDown);
			
			if(this.imgNowHeight > this.scrH){
				//이미지가 화면 보다 큰 경우 
				btGo.style.marginTop = "12px";
				btGo.style.left = (this.scrW - 60)+"px";
				
				btDown.style.marginTop = "12px";
				btDown.style.left = (this.scrW - 100)+"px";
				
			}else{
				
				//이미지가 화면보다 작다.
				btGo.style.marginTop = "12px";
				btGo.style.left = (this.scrW - 60)+"px";
				
				btDown.style.marginTop = "12px";
				btDown.style.left = (this.scrW - 100)+"px";	
				
			}
			
		},
		
		
		HammerProcess:function(){
			
			
			
			this.hm.on('pinch pan panmove drag', function(ev) {
				console.log(ev.scale+"/ type="+ev.type);
				
				switch(ev.type){
				case "panmove":
					
					//this.hm.off("pan panmove");
					/*
					var target = document.getElementById("ImageViewImg");
					$(target).css({
						'transform':'translate('+ev.deltaX+'px, '+ ev.deltaY +'px)'
						
					});
					*/
					
					
					console.log("panmove "+ev);
					
					if(imgResize.leftM == 0 && imgResize.rightM == 0){
						console.log("============return");
						
						return;
					}else{
						++imgResize.panCount;
						imgResize.panSumX += ev.deltaX;
						imgResize.panSumY += ev.deltaY;
						if(imgResize.panCount >= imgResize.panGo){
							imgResize.panCount=0;
							
							var dtX = imgResize.panSumX / imgResize.panGo;
							var dtY = imgResize.panSumY / imgResize.panGo;
							
							
							imgResize.panSumX = 0;
							imgResize.panSumY = 0;
							
							imgResize.moveImage(dtX, dtY);
							
						}						
					}
					
					
					
					break;
				case "pan":
					
					/*
					if(imgResize.leftM == 0 && imgResize.rightM == 0){
						console.log("============return");
						
						return;
					}else{
						++imgResize.panCount;
						imgResize.panSumX += ev.deltaX;
						imgResize.panSumY += ev.deltaY;
						if(imgResize.panCount >= imgResize.panGo){
							imgResize.panCount=0;
							
							var dtX = imgResize.panSumX / imgResize.panGo;
							var dtY = imgResize.panSumY / imgResize.panGo;
							
							
							imgResize.panSumX = 0;
							imgResize.panSumY = 0;
							
							imgResize.moveImage(dtX, dtY);
							
						}						
					}
					*/
					
					break;
				case "pinch":
					
					//이미지 버튼을 출력한다.
					imgResize.dispBtn("ImageClose", "ImageDown");
					imgResize.imgMark("ImageMark");
					
					
					
					
					//두손가락 컨트롤 하는 경우 
					
						//이미지 크기 변경을 한다.===============
						var sc = ev.scale;
						var ms = (imgResize.imgWAddRat * sc);   //전체 넓이의 증가량
						
						if(sc > imgResize.oldSc){
							//이전보다 증가 이미지 확대 
							imgResize.chW += ms;   //화면 확대값을 구한다.
							console.log("++++width="+imgResize.chW+"/ ms="+ms);
							
						}else if(sc < imgResize.oldSc){
							//이전보다 감소 이미직 축소 
							imgResize.chW -= ms;    //화면 축소값을 구한다.
							console.log("-----width="+imgResize.chW+"/ ms="+ms);
						}else{
							//정지된 상태
							
						}

						imgResize.oldSc = sc;
						//=================================
						
						
						
						//변경된 이미지의 높이
						imgResize.chnImgH = (imgResize.chW * imgResize.imgRt);  //변경된 이미지의 높이
						
						

						if(imgResize.chW <= imgResize.scrW){
							//화면 넓이 보다 작은 경우
							imgResize.chW = imgResize.scrW;      //변경된 이미지의 넓이
							
							var imsi = ((imgResize.scrH - imgResize.chnImgH) / 2);
							
							imgResize.topRat = 0.5;
							imgResize.topM = imsi;
							imgResize.bottomM = imsi;

							imgResize.leftRat = 0.5;
							imgResize.rightM = 0;
							imgResize.leftM = 0;
							
							//이미지의 현재 위치저장 
							imgResize.imgNowTop = imsi;
							imgResize.imgNowLeft = 0;
							
						}
						
						
						//증가율 계산 오른쪽 나누기 왼쪽 
						var absL = Math.abs(imgResize.leftM);
						var absR = Math.abs(imgResize.rightM);
						
						if(absL == absR){
							imgResize.leftRat = 0.5;//왼쪽여백
						}else{
							var sm = absL + absR;
							imgResize.leftRat = (absL / sm);
						}
						
						
						//위쪽 증가율 아래 / 위 
						var absU = Math.abs(imgResize.topM);
						var absD = Math.abs(imgResize.bottomM);
						if(absU == absD) imgResize.topRat = 0.5;
						else{
							var sm = absU + absD;
							imgResize.topRat = absU / sm;
						}
						
						
						//이미지가 최대크기 보다 크다 
						if(imgResize.chW > imgResize.imgMaxW){  //이미지가 최대크기 보다 크다.
							//가로세로 증가량 계산
							
							imgResize.chW = imgResize.imgMaxW;  
							var allW = imgResize.chW - imgResize.scrW;              //이미지의 전체초과량 
							
							var lgb = (0 - (allW * imgResize.leftRat));
							imgResize.leftM = lgb;            //이미지 왼쪽 초과분 
							//오른쪽은 항상 0보다 크다.
							imgResize.rightM = (allW * (1 - imgResize.leftRat));  //이미지 오른쪽 초과분
							
							
							imgResize.imgNowLeft = lgb;
							
						}				
						console.log("lrat="+imgResize.leftRat+" / topRat="+imgResize.topRat+" / 절대값 left = "+absL+"/ 절대값 right="+absR+"/ 왼쪽여백의 율="+imgResize.leftRat+"/ 윗쪽 절대값 = "+absU+" / 아랫쪽 절대값="+absD+"/ 윗쪽율="+imgResize.topRat);
						

						

						
						///*
						//이미지의 높이가 변경된 경우 
						imgResize.topM = 0;  //높이의 마진값,
						if(imgResize.chnImgH <= imgResize.scrH){
							//이미지의 높이가 화면 높이 이내
							var imsi = imgResize.scrH - imgResize.chnImgH;
							imgResize.topM = (imsi / 2);  //이미지의 위쪽 여유분 
							imgResize.bottomM = (imsi / 2);  //이미지의 아랫쪽 여유분
							
							
							imgResize.imgNowTop = imgResize.topM;
							
							
						}else{
							//이미지의 높이가 화면 높이 이상
							var imsi = (imgResize.chnImgH - imgResize.scrH);   //이미지의 높이 전체초과량
							
							var lgb = (0 - (imsi * imgResize.topRat));   //위쪽 초과분 계산 
							imgResize.topM = lgb;    //이미지의 윗쪽 초과분
							imgResize.bottomM = (imsi * (1 - imgResize.topRat));     //이미지의 아랫쪽 초과분
							imgResize.topMM = (imsi * imgResize.topRat);
							
							imgResize.imgNowTop = lgb;
							
						}
						
						
						//이미지 넓이가 변경된 경우 
						imgResize.leftM = 0;  //왼쪽 여백을 구한다.
						//chW 는 항상 ww 보다 크거나 같다.
						if(imgResize.chW > imgResize.scrW){
							var imsi = imgResize.chW - imgResize.scrW;  //넓이 전체 초과량
							
							var lgb = (0 - (imsi * imgResize.leftRat))
							imgResize.leftM = lgb;   //이미지의 왼쪽 초과분 
							imgResize.rightM = (imsi * (1 - imgResize.leftRat));
							imgResize.leftMM = (imsi * imgResize.leftRat);
							
							
							imgResize.imgNowLeft = lgb;
						}
						//*/
						

						
						imgResize.imgNowWidth = imgResize.chW
						imgResize.imgNowHeight = imgResize.chnImgH;
						
						
						imgResize.imsiMM = imgResize.leftMM;
						
						$("#ImageViewImg").css({"width":imgResize.chW+"px", "height":imgResize.chnImgH+"px", "margin":imgResize.topM+"px 0 0 "+imgResize.leftM+"px"});
						//$("#ImageViewImg").css({'transform':'translate('+imgResize.leftM+'px, '+imgResize.topM+'px)'});
						$("#ImageViewDiv").css({"width":imgResize.chW+"px", "min-width":imgResize.scrW+"px", "max-width":imgResize.maxW+"px", "height":imgResize.chnImgH+"px", "min-height":imgResize.scrH+"px"});
						
						
						
					
					
					break;
				}

			});
			
			
			
		},
		
		HammerInit:function(){
			
			this.pinch = new Hammer.Pinch();
			this.rotate = new Hammer.Rotate();
			//var swipeup = new Hammer.Swipe();
			//var swipe = new Hammer.Swipe();
			this.pinch.recognizeWith(this.rotate);
			
			this.hm = new Hammer(document.getElementById(this.divDomTxt));
			this.hm.add([this.pinch, this.rotate]);
			this.hm.get("pan").set({direction: Hammer.DIRECTION_ALL, threshold: 5});
			
		},
			
		imgSetCenter:function(){
			//화면의 중심에 이미지 출력
			this.scrW = appBasInfo.screenW;
			//이미지의 높이를 구한다.
			this.chnImgH = (this.scrW * this.imgRt);
			
			
			this.topM = 0;  //높이의 마진값,
			if(this.chnImgH <= this.scrH){
				//이미지의 높이가 화면 높이 이내
				var imsi = this.scrH - this.chnImgH;
				this.topM = (imsi / 2);
				this.bottomM = this.topM;
				
			}else{
				//이미지의 높이가 화면 높이 이상
				var imsi = (this.chnImgH - this.scrH);
				//마이너스 마진값 설정
				this.topM = (0 - (imsi / 2));
				//플러스 마진값 설정
				this.bottomM = (imsi / 2);
			}
			
			//중심에 이미지 출력
			$("#"+this.divImgTxt).css({"width":this.scrW+"px", "height":this.chnImgH+"px", "margin":this.topM+"px 0 0 0"});
			
		}
		
		
			
	}
	
//====================================================================================================
//PUSH-END---------------------------------------------------------------------------------------------
//====================================================================================================================
	
	
	//지도객체를 생성한다.
	function coMappro(mapDomTxt){
		
		this.map = null;
		this.comapDomTxt = mapDomTxt;   //지도를 표시하는 div 아이디 이름
		this.mapDispDom = null;         //지도를 표시하는 div 객체의 복사본
		this.mapLocation = null; //new google.maps.LatLng('36.322473', '127.412501'); // 지도에서 가운데로 위치할 위도와 경도
		this.markLocation = null; //new google.maps.LatLng('36.322473', '127.412501'); // 마커가 위치할 위도와 경도

		this.mapOptions = null;

		this.infowindow = null;
		this.content = "Hi! <br/> Your map."; // 말풍선 안에 들어갈 내용
		this.icon = null;
		this.title = null;
		
		this.latPo = 0;
		this.langPo = 0;
		
		
		this.ssMapDisp = false;
		
	}

	//지도를 초기화 한다.
	coMappro.prototype.init = function(lat, long, sangho){	
		
		this.latPo = lat;
		this.langPo = long;
		this.content = sangho;
		
		this.mapLocation = this.mapCenter(lat, long);  //지도의 디폴트 위치를 설정한다.
		
		this.mapDispDom = document.getElementById(this.comapDomTxt);
		this.icon = '/images/mapB.png';
		this.title = "서대전내거리역이지롱..";
		
		this.mapOptions = { 
		        zoom: 15, 
		        center: this.mapLocation, 
		        
		        panControl:true,
		        zoomControl:true,
		        mapTypeControl:true,
		        scaleControl:true,
		        streetViewControl:true,
		        overviewMapControl:true,
		        rotateControl:true,
		        mapTypeId: google.maps.MapTypeId.ROADMAP 
		 };
		
	}
	//위도경도값으로 지도에 보여줄 위치를 설정한다.
	coMappro.prototype.mapCenter = function(lat, lng){	
		return new google.maps.LatLng(lat, lng); //'36.322473', '127.412501'); // 지도에서 가운데로 위치할 위도와 경도
	}

	
	//지도에 마크를 찍는다.
	coMappro.prototype.addMark = function(lat, lng, sangho){
		
		this.content = sangho; //"이곳은 서대전네거리역이다! <br/> 지하철 타러 가자~"; // 말풍선 안에 들어갈 내용
		this.mapLocation = this.mapCenter(lat, lng);  //지도의 디폴트 위치를 설정한다.
		this.markLocation = this.mapCenter(lat, lng);  //마크의 위치를 설정한다.
		
		//지도에 마크를 표시한다.
		var marker = new google.maps.Marker({
		       position: this.markLocation, // 마커가 위치할 위도와 경도(변수)
		       map: this.map,
		       icon: this.icon, // 마커로 사용할 이미지(변수)
		       //info: '말풍선 안에 들어갈 내용',
		       title: this.title // 마커에 마우스 포인트를 갖다댔을 때 뜨는 타이틀
		});
		
		// 마커를 클릭했을 때의 이벤트. 말풍선 뿅~
		this.infowindow = new google.maps.InfoWindow({ content: this.content});
		var inf = this.infowindow;
		
		var iii = this.map;
		google.maps.event.addListener(marker, "click", function() {
		    inf.open(iii, marker);
		});
	}


	coMappro.prototype.getAddrToLatLong = function(addr){
		var obj = this;
		var geocode = new google.maps.Geocoder();
		console.log("getAddrToLatLong 주소="+addr);
		geocode.geocode({'address' : addr, "partialmatch":true}, function(results, status){
			
			if (status == "OK" && results.length > 0) {
				
				obj.latPo = results[0].geometry.location.lat();
				obj.langPo = results[0].geometry.location.lng();
				
				meminf.latPo = obj.latPo;
				meminf.langPo = obj.langPo;
				
				mapObj.dispMap(meminf.latPo, meminf.langPo, "위치");
				
				
				
				console.log("*******getAddrToLatLong===lat="+meminf.latPo+" / long="+meminf.langPo);
				
			}else{
				
				console.log("좌표추출 실패 : "+status);
				
			}
			
		});
		
	}



	coMappro.prototype.newMap = function(){
		
		var mobj = this;   //객체를 변수로 넘긴다.
		
		//지도를 특정위치를 중심으로 표시 한다.
		this.map = new google.maps.Map(this.mapDispDom, this.mapOptions); 
		
		//새로고침 컨트롤 버튼을 출력한다.
		  var control = document.createElement('DIV');
		  control.style.padding = '5px';
		  control.style.margin = '4px 4px 0 0';
		  control.style.border = '1px solid #000';
		  control.style.backgroundColor = 'white';
		  control.style.cursor = 'pointer';
		  control.innerHTML = '새로고침';
		  control.index = 1;

		  google.maps.event.addDomListener(control, 'click', function() {
			 
			  //새로운 지도를 생성한다.
			  mobj.newMap();
			  
			  //마크를 표시 한다.
			  mobj.map.panTo(new google.maps.LatLng(mobj.latPo, mobj.langPo));
			  mobj.addMark(mobj.latPo, mobj.langPo, mobj.content);
			  
		  });
		  //새로고침의 위치를 결정한다.
		  this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(control);
		
	}

	//지도를 출력한다.
	coMappro.prototype.dispMap = function(lat, long, sangho){
		
		this.latPo = lat;
		this.langPo = long;
		this.content = sangho;
		
		
		//지도의 생성여부를 확인하여 생성않되었으면 생성하고 생성되었으면 지도의 기본위치를 먼저 출력하고 
		//업체의 위치로 이동하여 마크를 찍는다.
		if(this.map == null){
			if(lat != 0){   //초기화시 null 값이 들어가면 오류가 난다.
				//지도출력 위치를 초기화 한다.
				this.init(lat, long, sangho);
				//지도를 출력한다.
				this.newMap();
				console.log("***************dispMap map ++++++++++ New lat="+lat+"/"+long+"/"+sangho);
			}
		}else{
			console.log("*****************Map dispMap ++++++++++++ map.panTo lat="+lat+"/"+long+"/"+sangho);
			
			//this.newMap();
			//마크를 표시 한다.
			this.map.panTo(new google.maps.LatLng(lat, long));
		}
		
		//console.log("*********"+appBasInfo.nowPage+"///PPPPP********Map dispMap ++++++++++++ map.panTo lat="+lat+"/"+long+"/"+sangho);
		
		this.addMark(lat, long, sangho);	
		
	}


	//컨텐츠상세보기에서 지도를 출력한다.
	coMappro.prototype.getMapSSD = function(){	
		
		
		if(this.ssMapDisp){
			this.ssMapDisp = false;
			document.getElementById("ContentSS2Td").style.display = "none";
			
		}else{
			this.ssMapDisp = true;
			mapObjSS.map = null;
			//지도를 표시한다.
			document.getElementById("ContentSS2Td").style.display = "block";
			
			setTimeout(function(){
				mapObjSS.dispMap(parCo.latPo, parCo.langPo, parCo.sangho);
			}, 30);
			
		}

		
	}


		function bdONEdit(){
			var ff = document.getElementById("frmBd");
			
			if(!ff.bdtit.value){
				appUtil.alertgo("알림","게시판 이름을 입력하세요.");
				ff.bdtit.focus();
				return;
			}
			
			if(ff.cogubunWR.value == 0){
				appUtil.alertgo("알림","게시판 노출설정을 선택 하세요.");
				ff.cogubunWR.focus();
				return;
			}
			
			ff.submit();	
		}
		
		
	function realAjax(md, para, obj){
	
		var qr = LKMEM+"realAjax";
		var param = para;
		
		$.ajax({type:"POST", data:appUtil.input_smstext(param,0), url:qr, timeout:10000, dataType:"json",success:function(data){

			switch(data.rs){
			case "ok":

				switch(md){
				case "adminOn":
					formPro.setFormEditVal(obj, data);
					
					$("select[name=actgubun]").val(0).attr("selected",true);
					
				break;
				}
				
				
				break;
			}
			
		},error:function(xhr,status,error){
			//alert("error="+error);
		}
		});
	
	}
	

	function genAjaxPost(fname, para, msg, playfun){
		appBasInfo.fnName = "genAjax(fname, para, msg, playfun)";
		
		
		var qr = LK+fname;
		var param = para;
		$.ajax({type:"POST", data:input_smstext(param,0), url:qr, timeout:10000, dataType:"json",success:function(data){

			switch(data.rs){
			case "ok":
				if(msg != ""){
					alert(msg);
					
					if(playfun != ""){
						eval(playfun);					
					}
				}
				
				break;
			case "end":
				
				break;
			case "link":
				
				if(appBasInfo.nowPage == "page"){
					
					navigator.notification.confirm('업그레이드된 버젼이 있습니다. 지금 업그레이드 하시겠습니까?', function(button){
				    	if(button == 2){   //삭제한다.
							location.href=data.url+"?"+data.par;
				    	
				    	} 
				    }, '업그레이드', '나중에 하기, 지금하기');

				}

				break;
			}
			
			
			
			paramAlert(param,appBasInfo.fnName);
		},error:function(xhr,status,error){
			
		}
		});
	}


//=======================================
//php 함수를 실행하여 자료를 반환받는다.
//=========================================
function runPhpFunc(mode, segab){
	
	var urlg = CIBASE+'/common/ajaxc/runPhpFunc';
	var fun = "";

	var modeg = mode;
	switch(mode){
	case "getAllGasu":
	
		fun = "getAllGasu";
	
	break;
	}


						$.ajax({
							type:"POST",
							url: urlg,
							dataType: 'json',
							data: {
								// our hypothetical feed requires UNIX timestamps
								mode: modeg,
								playfun:fun,
								ci_t:CIHS
							},
							success: function(doc) {
								
								//alert(doc);
								switch(mode){
								case "getAllGasu":
									//alert("+++++++++"+doc);
									$("select[name=gasu]").html("");
									$("select[name=gasu]").html(doc.rs);
									$("select[name=gasu]").val(segab).attr("selected",true);
	
								break;
								}
								
							}, error:function(xhr, status, error){
								alert("errgetAllGasu="+error);
							}
						});

}
		

//==========팝업처리=================//
		
    function wrapWindowByMask(mdclass){
        // 화면의 높이와 너비를 변수로 만듭니다.
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
 
        // 마스크의 높이와 너비를 화면의 높이와 너비 변수로 설정합니다.
        $('.mask').css({'width':maskWidth,'height':maskHeight});
 
        // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
        $('.mask').fadeIn(1000);
        $('.mask').fadeTo("slow",0.8);
 
        // 레이어 팝업을 가운데로 띄우기 위해 화면의 높이와 너비의 가운데 값과 스크롤 값을 더하여 변수로 만듭니다.
        var left = ( $(window).scrollLeft() + ( $(window).width() - $(mdclass).width()) / 2 );
        var top = ( $(window).scrollTop() + ( $(window).height() - $(mdclass).height()) / 2 );
 
        // css 스타일을 변경합니다.
        $(mdclass).css({'left':left,'top':top, 'position':'absolute'});
 
        // 레이어 팝업을 띄웁니다.
        $(mdclass).show();
    }
 
 






/*
	navigator.geolocation.getCurrentPosition(function(position){
						meminf.latPo = position.coords.latitude;  
				meminf.langPo = position.coords.longitude;
				
				console.log("위치이동을 표시한다. "+meminf.latPo+" / "+meminf.langPo);
		});
*/

			//실시간으로 위치이동 처리 
			/*
			navigator.geolocation.watchPosition(function(position) {
				alert("pppp");
				
				meminf.latPo = position.coords.latitude;  
				meminf.langPo = position.coords.longitude;
				
				console.log("위치이동을 표시한다. "+meminf.latPo+" / "+meminf.langPo);
				
					//주소를 구한다.
					/*
					mapAll.getAddress(meminf.latPo, meminf.langPo, "my");
					if(appBasInfo.nowPage == "MapAllCo" && appBasInfo.nowMainMenu == 4){
						mapAll.addMark(meminf.latPo, meminf.langPo, "나의 위치");
						console.log("위치이동을 표시한다. "+meminf.latPo+" / "+meminf.langPo);
					}	
					*/
					//위치이동을 한다.
					//mapAll.map.panTo(new google.maps.LatLng(vv.latPo, vv.langPo));

            //});



	//=====================================	
	
	



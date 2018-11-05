
		String.prototype.replaceAll = replaceAll;
		var setSH = true;
		
		
		//로그인 여부에 따른 화면 처리
		function dispLogin(){
			if(memid == "0"){
				//로그아웃 상태
				window.sessionStorage.setItem("setSH", "H");
				document.getElementById("contBtn").style.display = "none";
				document.getElementById("pageBodyR").style.display = "none";
			}else{
				//로그인 상태 
				document.getElementById("contBtn").style.display = "block";
				document.getElementById("pageBodyR").style.display = "block";
			}
			
			var gg = window.sessionStorage.getItem("setSH");
			if(gg == "V"){
				document.getElementById("pageBodyR").style.display = "block";
			}else{
				document.getElementById("pageBodyR").style.display = "none";
			}

		}
		
		
		//설정창 보이기 또는 숨기기
		function setShowHide(){
			var gg = window.sessionStorage.getItem("setSH");
			if(gg == "H"){
				document.getElementById("pageBodyR").style.display = "block";
				window.sessionStorage.setItem("setSH", "V");
			}else{
				document.getElementById("pageBodyR").style.display = "none";
				window.sessionStorage.setItem("setSH", "H");
			}
		}
		
		
		
		//로그인 한다.
		function goLogin(){
			var mid = document.getElementById("mid").value;
			var pass = document.getElementById("pass").value;
			
			if(!mid){
				alert("회원 아이디를 입력하세요.");
				document.getElementById("mid").focus();
				return;
			}
			
			if(!pass){
				alert("비밀번호를 입력하세요.");
				document.getElementById("pass").focus();
				return;
			}
			
			document.getElementById("mid").value = "";
			document.getElementById("pass").value = "";
			
			
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=8&mid="+mid+"&pass="+pass;
				var chn = input_smstext(param,0);
				
				//alert(chn);
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "err"){
						alert("Error !!!!");
						return false;
					}else{
						
						setSH = true;
						locationHome();
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
		
		}

		function goLogout(mid){
		
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=9&mid="+mid;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "err"){
						alert("Error !!!!");
						return false;
					}else{
						
						setSH = false;
						locationHome();
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
		
		}



		function pushEdit2(eid){
			editId = eid;
			window.sessionStorage.setItem("setSH", "V");
			locationgo(1);
		}

		function goPage(gpg){
			location.href = "http://callmms.co.kr/app/push/"+gpg+".php";
		
		}

		function locationHome(){
			location.href = gurl+"/app/push/mmsset.php";
		}


		function locationgo(md){
			switch(md){
			case 1:  //mms 설정
				location.href = gurl+"/app/push/mmsset.php?vid="+editId+"&findg="+findg+"&ilsumd="+ilsumd;
			break;
			case 2:  //회원관리
				location.href = gurl+"/app/push/member.php?findg="+findg;
			break;
			case 3:  //수신거부 설정
				location.href = gurl+"/app/push/susinno.php?findg="+findg;
			break;
			}
			
		}
		function locationgoNew(){
			window.sessionStorage.setItem("setSH", "V");
			location.href = gurl+"/app/push/mmsset.php?vid=0&findg="+findg+"&ilsumd="+ilsumd;
		}
		function locationgoDel(){
			location.href = gurl+"/app/push/mmsset.php?vid=0&findg="+findg+"&ilsumd="+ilsumd;
		}

		function ilsuGet(ilmd){
			ilsumd = ilmd;
			locationgo(1);
		
		}


		function cfind(md){
			
			findg = document.getElementById("findg").value;
			
			//md:1설정정보, 2:회원검색, 3:수신거부
			locationgo(md);
		
		
		}
		function cfindAll(md){
			document.getElementById("findg").value = "";
			cfind(md);
		
		}
		
		

		function pushEdit(eid){
			
			editId = eid;
			
			//업체의 내용을 가져와서 뿌려준다.
			var qr = all_path+"mmsAllCoList.php";
			var param = "mode=2&eid="+eid;
			var chn = input_smstext(param,0);
			
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
										
					document.getElementById("tit").value = disp_smstext1(data.tit, 0);
					document.getElementById("gtit1").value = disp_smstext1(data.mess, 0);
					document.getElementById("url").value = disp_smstext1(data.url, 0);
					document.getElementById("telu").value = disp_smstext1(data.telu, 0);
					document.getElementById("telmu").value = disp_smstext1(data.telmu, 0);
					document.getElementById("sangho").value = disp_smstext1(data.sangho, 0);
					document.getElementById("sendday").value = data.daysu;
					document.getElementById("datepicker1").value = data.sday;
					document.getElementById("datepicker2").value = data.eday;
					
					if(data.img1 == "0") document.getElementById("fdimg1").src = lk+"xx.png";
					else document.getElementById("fdimg1").src = lk+data.img1;
					if(data.img2 == "0") document.getElementById("fdimg2").src = lk+"xx.png";
					else document.getElementById("fdimg2").src = lk+data.img2;
					if(data.img3 == "0") document.getElementById("fdimg3").src = lk+"xx.png";
					else document.getElementById("fdimg3").src = lk+data.img3;
					if(data.img4 == "0") document.getElementById("fdimg4").src = lk+"xx.png";
					else document.getElementById("fdimg4").src = lk+data.img4;
					
					document.getElementById("memo1").value = disp_smstext1(data.memo1, 0);
					document.getElementById("memo2").value = disp_smstext1(data.memo2, 0);
					document.getElementById("memo3").value = disp_smstext1(data.memo3, 0);
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});
		
		}
		
		//이미지를 삭제한다.
		function delimg(num){
			if(document.getElementById("fdimg"+num).src == "xx.png"){
				return;
			}
			//alert("go");
			//업체를 삭제한다.
			var qr = all_path+"mmsAllCoList.php";
			var param = "mode=4&coid="+editId+"&img=img"+num;
			var chn = input_smstext(param,0);
			
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
					
					locationgo(1);

					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});			
			
			
		}
		
		
		//회원등록
		function input_memon(){
			var frm= eval(document.memberOn);
			
			
			if(!frm.memid.value){
				alert("회원아이디를 입력하세요.");
				frm.memid.focus();
				return;
			}
			
			if(!frm.wmemid.value){
				alert("등록자 아이디를 입력하세요.");
				frm.wmemid.focus();
				return;
			}
			
			
			if(!frm.pass1.value){
				alert("비밀번호를 입력하세요.");
				frm.pass1.focus();
				return;
			}
			
			if(!frm.pass2.value){
				alert("비밀번호 확인을 입력하세요.");
				frm.pass2.focus();
				return;
			}
			
			
			frm.wmemid.value = memid;

			frm.submit();
			
		}

		
		
				
				//mms 설정
		function input_susinno(){
			var frm= eval(document.notel);
			
			
			if(!frm.tel.value){
				alert("수신거분 전화번호를 입력하세요.");
				frm.tel.focus();
				return;
			}
			
			if(!frm.gtit1.value){
				alert("수신거부 이유를 간단하게 입력하세요.");
				frm.gtit1.focus();
				return;
			}
			

			frm.submit();
			
		}

		
		
		
				//mms 설정
		function input_mms(){
			if(window.sessionStorage.getItem("setSH") == "H"){
				setShowHide();
				if(editId > 0) return;
			}
			
			var frm= eval(document.incamp);
			
			frm.mode.value = "input";
			
			if(!frm.gtit1.value){
				alert("MMS 내용을 입력하세요.");
				frm.gtit1.focus();
				return;
			}
			if(!frm.tit.value){
				alert("MMS 제목을 입력하세요.");
				frm.tit.focus();
				return;
			}
			
			if(!frm.url.value){
				frm.url.value = "no";
			}
			if(frm.url.value != "no"){
				var ss = frm.url.value;
				ss = ss.replaceAll("http://","");
				ss = "http://"+ss;
				frm.url.value = ss;
			}

			if(!frm.sday.value){
				alert("계약시작일자를 입력하세요.");
				frm.sday.focus();
				return;
			}

			if(!frm.eday.value){
				alert("계약종료일자를 입력하세요.");
				frm.eday.focus();
				return;
			}
			
			//alert(frm.sday.value+"/"+frm.eday.value);
			
			
			if(!frm.telu.value){
				alert("업체의 유선전화 번호를 입력하세요.");
				frm.telu.focus();
				return;
			}
			frm.telu.value = frm.telu.value.replaceAll("-","");
			
			
			if(!frm.telmu.value){
				alert("MMS 발송용 모바일전화 번호를 입력하세요.");
				frm.telmu.focus();
				return;
			}
			frm.telmu.value = frm.telmu.value.replaceAll("-","");
			
			if(!frm.sangho.value){
				alert("상호를 입력하세요.");
				frm.sangho.focus();
				return;
			}
			if(!frm.sendday.value){
				alert("MMS 발송주기를 입력하세요.(0:매번발송, 1이상:1일 이상 경과한 날짜");
				frm.sendday.focus();
				return;
			}
			if(!frm.desang.value){
				frm.desang.value = "010-1234-1234";
			}
			frm.desang.value = frm.desang.value.replaceAll("-","");
									
			if(!frm.pass.value){
				alert("비밀번호를 입력하세요.");
				frm.pass.focus();
				return;
			}

			frm.submit();
			
			
			
		}

		
		
		
		//mms를 발송한다.
		function sendMMS(){
			var frm= eval(document.incamp);
		
			frm.mode.value = "send";

			if(!frm.telu.value){
				alert("업체의 유선전화 번호를 입력하세요.");
				frm.telu.focus();
				return;
			}
			frm.telu.value = frm.telu.value.replaceAll("-","");
		
		
			if(!frm.telmu.value){
				alert("MMS 발송용 모바일전화 번호를 입력하세요.");
				frm.telmu.focus();
				return;
			}
			frm.telmu.value = frm.telmu.value.replaceAll("-","");
			
		
			if(!frm.desang.value){
				alert("MMS 수신자의 번호를 입력하세요.");
				frm.desang.focus();
				return;
			}
			frm.desang.value = frm.desang.value.replaceAll("-","");
						
			if(!frm.pass.value){
				alert("비밀번호를 입력하세요.");
				frm.pass.focus();
				return;
			}
		
			frm.submit();
		}

		
		//회원정보를 가져온다.
		function getMember(){
			
			var qr = all_path+"mmsAllCoList.php";
			var param = "mode=7&fnd="+findg;
			var chn = input_smstext(param,0);
			//alert(qr+chn);
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
			
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{

					//alert(data);
				
					var allsu = data.rs.length;
					
					
					var ss = "<table width='100%'>";
					ss += "<tr><td colspan='7' style='text-align:center; padding:7px 0;'>회원자격 5 이상인 경우 회원 자격변경, 비번초기화, 회원 삭제 가능 합니다.</td></tr>";
					ss += "<tr><th>순번</th><th>회원아이디</th><th>자격</th><th>등록일자</th><th>비번변경</th><th>비번 초기화</th><th>삭제</th></tr>";
					
					//if(data.rs[0].id > 0){

							for(var c=0; c < allsu; c++){
								ss += "<tr>";
								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+(allsu - c)+"</td>";
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px; text-align:center;'>"+data.rs[c].memid+"</td>";
								
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px; text-align:center;'>";
								
								if(mempo > 4){
									ss += "<table width='100%'><tr><td><input type='text' id='mempo' value='"+data.rs[c].po+"'></td>";
									ss += "<td><span class='r5button' onclick='poChn("+data.rs[c].id+", \""+data.rs[c].po+"\")'>자격변경</span></td></tr></table>";
								}else{
									ss += data.rs[c].po;
								}
								
								ss += "</td>";
								
								
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px; text-align:center;'>"+data.rs[c].onday+"</td>";
								
								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>";
								ss += "<table width='100%'><tr><td><input type='text' id='oldpass"+data.rs[c].id+"' value='' placeholder='현재비번'></td>";
								ss += "<td><input type='text' id='newpass"+data.rs[c].id+"' value='' placeholder='새로운 비번'></td>";
								ss += "<td><span class='r5button' onclick='passChn("+data.rs[c].id+")'>비번변경</span></td></tr></table>";
								ss += "</td>";

								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>";
								
								if(mempo > 4){
									ss += "<span class='r5button' onclick='passInit("+data.rs[c].id+")'>초기화</span>";
								}else{
									ss += "불가";
								}
								
								ss += "</td>";
	
								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>";
								
								if(mempo > 4){
									ss += "<span class='r5button' onclick='pushDel("+data.rs[c].id+", 3)'>삭제</span>";
								}else{
									ss += "불가";
								}
								
								ss += "</td>";
								
								ss += "</tr>";
							}	
					
					//}

					ss += "</table>";				
				
					document.getElementById("pushSendList").innerHTML = ss;
					
					//if(editId > 0) pushEdit(editId);
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});

		
		}

		
		
		
		
		
		
		
		//수신거부 리스트를 가져온다.
		function getSusinNo(){
			
			var qr = all_path+"mmsAllCoList.php";
			var param = "mode=6&proj="+proje+"&fnd="+findg;
			var chn = input_smstext(param,0);
			//alert(qr+chn);
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
			
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{

					//alert(data);
				
					var allsu = data.rs.length;
					
					
					var ss = "<table width='100%'>";
					ss += "<tr><th>순번</th><th>거부번호</th><th>메모</th><th>등록일자</th><th>등록자 아이디</th><th>수정</th></tr>";
					
					//if(data.rs[0].id > 0){
					
							for(var c=0; c < allsu; c++){
								ss += "<tr>";
								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+(allsu - c)+"</td>";
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+data.rs[c].tel+"</td>";
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].memo,0)+"</td>";
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+data.rs[c].onday+"</td>";
								ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+data.rs[c].wmemid+"</td>";
								
								ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>";
								ss += "<span class='r5button' onclick='pushDel("+data.rs[c].id+", 2)'>삭제</span>";
								
								ss += "</td></tr>";
							}	
					
					//}

					ss += "</table>";				
				
					document.getElementById("pushSendList").innerHTML = ss;
					
					if(editId > 0) pushEdit(editId);
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});

		
		}

		
		
		
		

		function getPushList(){
			
			var qr = all_path+"mmsAllCoList.php";
			var param = "mode=1&proj="+proje+"&fnd="+findg+"&ilsumd="+ilsumd;
			var chn = input_smstext(param,0);
			//alert(qr+chn);
			$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
			
				if(data.rs == "err"){
					alert("Error !!!!");
					return false;
				}else{
				
					var allsu = data.rs.length;
					var ss = "<table width='100%'>";
					ss += "<tr><th>순번</th><th>상호</th><th>업체유선</th><th>업체무선(MMS발송)</th><th>제목</th><th>내용</th><th>메모1</th><th>메모2</th><th>메모3</th><th>계약기간</th><th>잔여일수</th><th>링크</th><th>발송주기</th><th>이미지</th><th style='width:90px;'>수정</th></tr>";
					if(allsu > 0){
						for(var c=0; c < allsu; c++){
							ss += "<tr>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+(allsu - c)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].sangho,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].telco,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].telmu,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+disp_smstext1(data.rs[c].tit,0)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+hanstrcut(disp_smstext1(data.rs[c].mess,0), 15)+"</br>";
							
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+hanstrcut(disp_smstext1(data.rs[c].memo1,0), 15)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+hanstrcut(disp_smstext1(data.rs[c].memo2,0), 15)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+hanstrcut(disp_smstext1(data.rs[c].memo3,0), 15)+"</td>";
							
							/*
							if(data.rs[c].memo1 || data.rs[c].memo2 || data.rs[c].memo3){
								ss += "--------------------------------------------------------------------------------------------</br>";
							}
							if(data.rs[c].memo1){
								ss += "메모1: "+disp_smstext1(data.rs[c].memo1,0)+"</br>";
							}
							if(data.rs[c].memo2){
								ss += "메모2: "+disp_smstext1(data.rs[c].memo2,0)+"</br>";
							}
							if(data.rs[c].memo3){
								ss += "메모3: "+disp_smstext1(data.rs[c].memo3,0)+"</br>";
							}
							*/
							
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px; text-align:center;'>"+data.rs[c].sday+"<br />~"+data.rs[c].eday+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px; text-align:right;'>"+data.rs[c].ilsu+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; padding:8px 15px;'>"+engcut(disp_smstext1(data.rs[c].url,0), 15)+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+data.rs[c].su+"</td>";
							
							var tt = ""; 
							if(data.rs[c].img1 == "0"){
								tt += "NoImage<br />";
							}else{
								tt += data.rs[c].img1+"<br />";
							}
							if(data.rs[c].img2 == "0"){
								tt += "NoImage<br />";
							}else{
								tt += data.rs[c].img2+"<br />";
							}
							if(data.rs[c].img3 == "0"){
								tt += "NoImage<br />";
							}else{
								tt += data.rs[c].img3+"<br />";
							}
							if(data.rs[c].img4 == "0"){
								tt += "NoImage<br />";
							}else{
								tt += data.rs[c].img4+"";
							}
							
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center;'>"+tt+"</td>";
							ss += "<td style='border-bottom:#dedede 1px solid; text-align:center; width:09px;'>";
							
							if(memid != "0"){
								ss += "<span class='r5button' onclick='pushDel("+data.rs[c].id+", 1)'>삭제</span>";
								
								if(data.rs[c].wrec == 1){
									ss += "<span class='r5button' onclick='setDef("+data.rs[c].id+", \""+disp_smstext1(data.rs[c].telmu,0)+"\")'>기본</span>";
								}else{
									ss += "<span class='grayBtn' onclick='setDef("+data.rs[c].id+", \""+disp_smstext1(data.rs[c].telmu,0)+"\")'>보조</span>";
								}
								ss += "<span class='r5button' onclick='pushEdit2("+data.rs[c].id+")'>수정</span>";
							}
							
							ss += "</td></tr>";
						}
					}
					ss += "</table>";				
				
					document.getElementById("pushSendList").innerHTML = ss;
					
					if(editId > 0) pushEdit(editId);
					
					
				}
			},error:function(xhr,status,error){
				alert("err="+xhr+status+error);
			}
			});

		
		}

		function setDef(id, mutel){
		
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=5&rid="+id+"&mutel="+mutel;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "err"){
						alert("Error !!!!");
						return false;
					}else{
						
						getPushList();
						
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
		
		}

		//비밀번호를 변경한다.
		function passChn(mid){
		
				var newpass = document.getElementById("newpass"+mid).value;
				var oldpass = document.getElementById("oldpass"+mid).value;
				
				if(newpass == "" || oldpass == ""){
					alert("비번을 입력하세요.");
					return;
				}
				
				if(newpass == oldpass){
					alert("현재비번과 변경할 비번이 같습니다.");
					return;
				}
				
				//회원자격을 변경한다.
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=12&mid="+mid+"&newpass="+newpass+"&oldpass="+oldpass;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "no"){
						alert("비밀번호를 다시 확인 하세요.");
						return;
					}else{
						
						alert("비번을 "+oldpass+"에서 "+newpass+"로 변경하였습니다.");
						getMember();
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
		
		
		}



		function passInit(did){
			if(confirm("비밀번호를 초기화 할까요?")){
				//업체를 삭제한다.
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=10&did="+did;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "no"){
						alert("비밀번호 초기화 실패 했습니다.");

					}else{
						alert("비밀번호를 1234로 초기화 했습니다.");
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
			
			}
	
		}
		
		
		function poChn(mid, po){
				
				var chnpo = document.getElementById("mempo").value;
				if(po == chnpo){
					alert("기존 자격과 같은 값으로 변경은 불필요 합니다.");
					return;
				}
				
				//회원자격을 변경한다.
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=11&mid="+mid+"&po="+chnpo;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "no"){
						alert("자격 변경이 불가능 합니다.");
						return;
					}else if(data.rs == "not"){
						alert("9는 최고관리자만 설정가능한 자격 입니다.");
						return;
					}else{
						alert("회원자격을 "+po+"에서 "+chnpo+"로 변경하였습니다.");
						getMember();
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
		
		}


		
		function pushDel(did, md){
			if(confirm("정말로 삭제 할까요?")){
				//업체를 삭제한다.
				var qr = all_path+"mmsAllCoList.php";
				var param = "mode=3&did="+did+"&md="+md;
				var chn = input_smstext(param,0);
				
				$.ajax({type:"POST", data:chn, url:qr, timeout:400000, dataType:"json",success:function(data){
					if(data.rs == "err"){
						alert("Error !!!!");
						return false;
					}else{
						
						if(md == 1){
							locationgoDel();
							
						}else if(md == 3){
							
							//alert("kkk"+data.rt);
							getMember();
						
						}else{
							//document.getElementById("tel").value = "";
							//$("#gtit1").val("");
							getSusinNo();
						}
					
					}
				},error:function(xhr,status,error){
					alert("err="+xhr+status+error);
				}
				});			
			
			}
	
		}
		
		
		
		
		
		function replaceAll(str1, str2){
			var strTemp = this;
			strTemp = strTemp.replace(new RegExp(str1, "g"), str2);
			return strTemp;
		}

		//메세지 전송 관련 글자 입력
		function input_smstext(str,tsu){
			
			var ss = encodeURI(str);
			var rst = encodeURI(ss);
			
			
			return rst;
		}
		
		
		//모든 내용 출력
		function disp_smstext1(str,tsu){
			//var rst = str;
			var rst = decodeURI(str);
			
			//&기호 처리
			rst = rst.replaceAll("~and~", "&");
			rst = rst.replaceAll("~pls~", "+");
		
			
			return rst;
		}
		

function encode64(str){
	return encode(escape(str));
}


function encode(input){
	var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	var output = "";
	 var chr1, chr2, chr3;
	 var enc1, enc2, enc3, enc4;
	 var i =0;
	 do{
	  chr1 = input.charCodeAt(i++);
	  chr2 = input.charCodeAt(i++);
	  chr3 = input.charCodeAt(i++);
	  enc1 = chr1 >> 2;
	  enc2 = ((chr1 & 3) << 4) | (chr2 >> 4 );
	  enc3 = ((chr2 & 15) << 2) | (chr3 >> 6 );
	  enc4 = chr3 & 63;
	  if(isNaN(chr2)){
	   enc3 = enc4 =64;
	  }else if(isNaN(chr3)){
	   enc4 = 64;
	  }
	  output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4);
	 }while(i<input.length);
	 
	 return output;
}


function engcut(str, len){

	return str.substring(0, len);
}



function hanstrcut(str,len) {
	  var str2 = str;
       var s = 0;
       var tlen = str.length;
       var rs = "";
       
       //alert(str2);
       
       for (var i=0; i < len; i++){
    	   if(i > tlen) break;
    	   
      		s += (str.charCodeAt(i) > 128) ? 2 : 1;
       }
       
       if (s > len){
            rs = str.substring(0,s)+'...';
       }else{
    	   rs = str2;
       }
       
        return rs;
}

		

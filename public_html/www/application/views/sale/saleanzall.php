<?php
	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = $totalCount;



?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      
      

<script language = "javascript">
function fnSearch(){
	if(document.searchform.search_text.value == ''){
		alert('검색어를 입력하세요.');
		document.searchform.search_text.focus();
		return;
	}

	document.searchform.submit();
}
</script>
  
  
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <div class="srch">
		<select id="selectMdGBonsa">
        	<option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
			<option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>제목</option>
			<option value="content" <?=($this->session->userdata("findMd") == "content")? "selected='selected'":""?>>제목+내용</option>
            <option value="wr" <?=($this->session->userdata("findMd") == "wr")? "selected='selected'":""?>>작성자</option>
		</select>
        
        <input type="text" name="bonsaFindTxt" id="bonsaFindTxt" value="<?=$this->session->userdata("find")?>"/>
		<p><a href="#" class="btn" id="bonsaFind"><span>검색</span></a></p>
      </div>


      <table class="table_list">
      <caption>aaa</caption>
      <colgroup>
      <col width="100%">
      </colgroup>
      <tbody>
      <tr><td class="td1">

        <div class="divAllWidth">

			<p>이용권 현황</p>
        
      <table class="table_list3">
      <caption>이용권 현황</caption>
      <colgroup>
      <col width="28%">
      <col width="15%">
      <col width="15%">
      <col width="12%">
      <col width="10%">
      <col width="10%">
      <col width="10%">
      </colgroup>
      <thead>
      <tr>
        <th>이용권 명</th>
        <th>결제 금액</th>
        <th>활인율</th>
        <th>다운로드 가능수</th>
        <th>판매현황</th>
        <th colspan="2">처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="7">등록된 상품이 없습니다.</td></tr>

<?   }else{
	
		
	foreach($gumeAnz as $rows){   
	
?>   
      <tr>
        <td><?=$rows->tit?></td>
        <td><?=$rows->don?></td>
        <td><?=$rows->rate?></td>
        <td><?=$rows->downsu?></td>
        <td><?=$rows->su?></td>
        <td>삭제</td>
        <td>수정</td>
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
      


<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:94%; text-align:center; margin:7px 0;"><a href="#" class="btn_gray adminAdd"><span>이용권 추가</span></a></div>
<? } ?>


		</div>


        <div class="divAllWidth">

			<p>주문제작상품 현황</p>
        
      <table class="table_list3">
      <caption>이용권 현황</caption>
      <colgroup>
      <col width="28%">
      <col width="15%">
      <col width="15%">
      <col width="12%">
      <col width="10%">
      <col width="10%">
      <col width="10%">
      </colgroup>
      <thead>
      <tr>
        <th>주문제작 명</th>
        <th>결제 금액</th>
        <th>활인율</th>
        <th>다운로드 가능수</th>
        <th>판매현황</th>
        <th colspan="2">처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="7">등록된 상품이 없습니다.</td></tr>

<?   }else{
	
		
	foreach($jumunAnz as $rows){   
	
?>   
      <tr>
        <td><?=$rows->tit?></td>
        <td><?=$rows->don?></td>
        <td><?=$rows->rate?></td>
        <td><?=$rows->downsu?></td>
        <td><?=$rows->su?></td>
        <td>삭제</td>
        <td>수정</td>
      </tr>
<? } }?>      
      
      

      
      </tbody>
      </table>
      


<? if((keyMan("bonsaadmin", "po")) or ($md == 2 and keyMan("johap", "po"))){ ?>	
		<div style="width:94%; text-align:center; margin:7px 0;"><a href="#" class="btn_gray adminAdd2"><span>주문제작상품 추가</span></a></div>
<? } ?>


		</div>


        
	</td></tr></tbody></table>



<!------레이어 팝업------------------>
		<div class="mask"></div>
       	<div class="windowAddAdmin windowClose windowStyle" style="width:400px;">
        	<ul class="btton1Head"><li>설치요청 상세보기</li><li><a href="#" class="close">닫기</a></li></ul>


  <div id="view_deviceCall" class="join_mem finder_div" style="position:relative; margin:60px auto 0; height:auto; border:none; display:block;">
    
 
        <table class="onputPage">
        <tr><th style="width:100px;"><span>제목</span></th><td style="width:250px;">
            <input type="text" name="tit" value="" disabled/>
        </td><td rowspan="7" style="width:50%;">
        	<img src="" id="devImg" style="width:90%;" />
        </td></tr>
        <tr><th><span>내용</span></th><td style="width:250px;">
			<textarea name="content"></textarea>
        </td></tr>
        <tr><th><span>처리메모</span></th><td style="width:250px;">
			<textarea name="memo"></textarea>
        </td></tr>
        <tr><th><span>대상장비</span></th><td style="width:250px;">
			<input type="text" name="devGb" value="" disabled/>
        </td></tr>
        <tr><th><span>요청자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="mejang" value="" disabled/>
        </td></tr>
        <tr><th><span>담당자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="gisa" value="" />
        </td></tr>
        <tr><th><span>상태</span></th><td style="width:250px;">
			<input type="text" name="stat" value="" />
        </td></tr>     
    	</table>
   
        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org adminAddgo"><span>확인</span></a>
        <a href="#" class="btn_gray close"><span>닫기</span></a>
        </p>
        

  </div>
        </div>
        
        
        
        
       	<div class="windowAddAdmin2 windowClose windowStyle" style="width:400px;">
        	<ul class="btton1Head"><li>주문제작 상품 추가</li><li><a href="#" class="close">닫기</a></li></ul>


  <div id="view_deviceCall" class="join_mem finder_div" style="position:relative; margin:60px auto 0; height:auto; border:none; display:block;">
    
 
        <table class="onputPage">
        <tr><th style="width:100px;"><span>제목</span></th><td style="width:250px;">
            <input type="text" name="tit" value="" disabled/>
        </td><td rowspan="7" style="width:50%;">
        	<img src="" id="devImg" style="width:90%;" />
        </td></tr>
        <tr><th><span>내용</span></th><td style="width:250px;">
			<textarea name="content"></textarea>
        </td></tr>
        <tr><th><span>처리메모</span></th><td style="width:250px;">
			<textarea name="memo"></textarea>
        </td></tr>
        <tr><th><span>대상장비</span></th><td style="width:250px;">
			<input type="text" name="devGb" value="" disabled/>
        </td></tr>
        <tr><th><span>요청자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="mejang" value="" disabled/>
        </td></tr>
        <tr><th><span>담당자<br />(연락처)</span></th><td style="width:250px;">
			<input type="text" name="gisa" value="" />
        </td></tr>
        <tr><th><span>상태</span></th><td style="width:250px;">
			<input type="text" name="stat" value="" />
        </td></tr>     
    	</table>
   
        
        <p style="text-align:center; padding:25px 0;">
        <a href="#" class="btn_org adminAddgo"><span>확인</span></a>
        <a href="#" class="btn_gray close"><span>닫기</span></a>
        </p>
        

  </div>
        
 
        </div>
<!------레이어 팝업 종료--------------->





<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


		
		//관리자 추가를 클릭시 작동하며 검은 마스크 배경과 레이어 팝업을 띄웁니다.
		$('.adminAdd').click(function(e){
            // preventDefault는 href의 링크 기본 행동을 막는 기능입니다.
            e.preventDefault();
			nowRecId = this.id;
			
				
			//var frm = document.getElementById("deviceCall");
			var aj = 'menu=getDeviceCall&callid='+nowRecId;
			realAjax("getDeviceCall", aj, "mu");
			
			
			$('.windowAddAdmin').css({'width':'700px','height':'500px'});
			
            wrapWindowByMask('.windowAddAdmin');
        });
		

		
		//관리자 추가를 클릭시 작동하며 검은 마스크 배경과 레이어 팝업을 띄웁니다.
		$('.adminAdd2').click(function(e){
            // preventDefault는 href의 링크 기본 행동을 막는 기능입니다.
            e.preventDefault();
			nowRecId = this.id;
			
				
			//var frm = document.getElementById("deviceCall");
			var aj = 'menu=getDeviceCall&callid='+nowRecId;
			realAjax("getDeviceCall", aj, "mu");
			
			
			$('.windowAddAdmin2').css({'width':'700px','height':'500px'});
			
            wrapWindowByMask('.windowAddAdmin2');
        });
		
				
		
		
		
		
		$('.adminAddgo').click(function(e){
			
			/*
			var frmA = document.getElementById("frmAdminOn");
			
			if(frmA.actgubun.value == 0){
				alert("권한을 선택하세요.");
				return false;
			}
			
			
			try {
				frmA.submit();
			} catch(e) {
				//alert("errrr"+e);
			}
			*/
		
		});
		


</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

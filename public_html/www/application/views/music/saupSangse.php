<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

/*

$si = ($mem[0]['stat'] == 2)? $si = "승인완료" : $si = "승인대기";

$cogubun = "계열사";
if($mem[0]['cogubun'] == 2) $cogubun = "조합";
else $cogubun = "본사";
*/


?>

		<div id="gaipSangseMess" class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">사업 상세보기</a></li>
          <li><a href="#">대상자 상세보기</a></li>
          <li><a href="#">사진관리</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->
      
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>자료실</caption>
      <colgroup>

      <col width="20%">
      <col width="80%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      
      <tr><td class="titcell">사업명</td><td></td></tr>
      <tr><td class="titcell">사업설명</td><td></td></tr>
      <tr><td class="titcell">첨부파일</td><td></td></tr>
      <tr><td class="titcell">일정</td><td></td></tr>
      <tr><td class="titcell">대상자</td><td></td></tr>
      <tr><td class="titcell">담당자</td><td></td></tr>
      </tbody>
      </table>

  </div>
  


 		<div style="width:755px; text-align:right;">
        <a href="#" class="btn_gray" onclick="appBasInfo.delSaup(<?=$md?>, <?=$gsss->id?>, <?=$gsss->coid?>)"><span>삭제</span></a>
        <!--<a href="<?=$baseUrl?>hjang/getView/3/5" class="btn_gray"><span>수정</span></a>-->
        <a href="<?=$baseUrl?>hjang/getView/1/1/<?=$onmd?>" class="btn_gray"><span>목록1</span></a>
        </div>  


      

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "notice/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.




?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">메시지 상세보기</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!--회원 상세보기 -->
      
    <div id="join_mem" class="join_mem finder_div" style="position:relative; width:100%; padding:0; margin:10px 0 10px; border:none; display:block;">
    
 
      <table class="table_list" style="margin:0;">
      <caption>메시지 상세보기</caption>
      <colgroup>

      <col width="30%">
      <col width="70%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>구분</th>
        <th>내용</th>
      </tr>
      </thead>
      <tbody>
      <tr><td class="titcell">제목</td><td><?=$mess->tit?></td></tr>
      <tr><td class="titcell">내용</td><td><?=$mess->content?></td></tr>
      <tr><td class="titcell">참조링크</td><td><?=$mess->plink?></td></tr>
      <tr><td class="titcell">발신자</td><td><?=$mess->wrMemid?></td></tr>
      <tr><td class="titcell">수신일시</td><td><?=$mess->onday?></td></tr>
      </tbody>
      </table>

  </div>
 
      
 		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>gongji/getView/3/1" class="btn_gray"><span>목록</span></a></div>
      

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

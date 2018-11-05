<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "community/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="#">자료실</a></li>
        </ul>
      </div>
      <!-- //tab -->
      

  
  
  
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">메시지 건수 <strong><?=$su?></strong> 건 </p>
      <div class="srch">
        <input type="text" id="gaipFindTxt" value="<?=$this->session->userdata("find")?>" name="findRec"/>
        <p><a href="#" class="btn" id="gaipFind"><span>검색</span></a></p>
      </div>
      <table class="table_list">
      <caption>자료실</caption>
      <colgroup>
      <col width="10%">
      <col width="25%">
      <col width="15%">
      <col width="10%">
      <col width="15%">
      <col width="25%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>첨부파일</th>
        <th>작성자</th>
        <th>일시</th>
        <th>처리</th>
      </tr>
      </thead>
      <tbody>
      
<? 
	$c = 0;
	//foreach($gaip as $rows){   
?>   
      <tr>
		<td></td><td></td><td></td><td></td><td></td><td></td>
      </tr>
<? //} ?>      
      
      </tbody>
      </table>

<? if(keyMan("bonsaadmin", "po")){ ?>	
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>community/getView/3/2" class="btn_gray"><span>글쓰기</span></a></div>
<? } ?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);

</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');

$baseImgUrl = $baseUrl."images/scene/";

$baseUrl .= "scene/";



$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

/*사진대장-------
//<a href="<?=$baseUrl?>hjang/getView/5/<?=$gsrow->saupid?>/<?=$gsrow->coid?>/<?=$gsrow->id?>" class="btn"><span>사진보기</span></a>
*/

$su = count($pinfo);
?>

	<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <div class="tab">
        <ul>
          <li><a href="<?=$baseUrl?>hjang/getView/2/5/<?=$coid?>">대상자별 사진대장</a></li>
          <li class="on"><a href="#">사진대장</a></li>
        </ul>
      </div>
      <!-- //tab -->
      

      
      <!-------------------------------------------------------------------->
      
            <!-- list -->
      <p class="total">총 사진 <strong><?=$su?></strong> 컷 
      
      </p>
      <div class="srch">

 
      </div>
      <table class="table_list">
      <caption>대상자관리</caption>
      <colgroup>
      <col width="8%">
      <col width="8%">
      <col width="12%">
      <col width="72%">
      <col>
      </colgroup>
      <thead>
      <tr>
        <th>순번</th>
        <th>단계</th>
        <th>이미지</th>
        <th>설명</th>
      </tr>
      </thead>
      <tbody>
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="6">등록된 사진이 없습니다.</td></tr>

<?   }else{
	
	$c = 0;
	$saupid = 0;
	$dsid = 0;
	$gsid = 0;
	foreach($pinfo as $dsrow){   
		$gsid = $dsrow->gsid;
		$saupid = $dsrow->sprecid;
		$dsid = $dsrow->dsrecid;
		$size = getimagesize(PREDIR0."/images/scene/".$dsrow->imgname);

		$dgtxt = "전";
		if($dsrow->dange == 2) $dgtxt = "중";
		else if($dsrow->dange == 3) $dgtxt = "후";


?>   
      <tr>
		<td><?=($su - $c++)?></td><td><?=$dgtxt?></td><td><a href="#" onclick="appUtil.imgOpen('<?=$dsrow->imgname?>', <?=$size[0]?>, <?=$size[1]?>)"><div style="width:90px; height:80px; background:url('<?=$baseImgUrl."thumb/s_".$dsrow->imgname?>') 50% 50% no-repeat; background-size:100%;"></div></a></td><td style="text-align:right;">
		
			<div style="width:90%; margin:9px 5% 6px; text-align:left;"><span style="font-weight:bold; color:black;"><?=$dsrow->tit?></span></br>
			<?=$dsrow->memo?></div>
            
            대상자 : <?=$dsrow->desangmemid?>  &nbsp;&nbsp;
            /&nbsp;&nbsp;  등록 : <?=$dsrow->onday?>  &nbsp;&nbsp;
            /&nbsp;&nbsp;  작성자 : <?=$dsrow->wrmemid?> &nbsp;&nbsp; 
            
<? if($this->session->userdata("memid") == $dsrow->wrmemid){   ?>    
            <a href="#" class="btn" onclick="meminf.photoDel(<?=$dsrow->id?>, '<?=$dsrow->imgname?>')"><span>삭제</span></a>
            <a href="<?=$baseUrl?>hjang/getView/5/<?=$dsrow->id?>/<?=$coid?>/<?=$gsid?>/<?=$dange?>" class="btn"><span>수정</span></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
<? }else{ ?>            
&nbsp;&nbsp;&nbsp;&nbsp;
<? } ?>            
        
        </td>
      </tr>
<? } } ?>      
      
      </tbody>
      </table>
<?
if(keyMan("admin", "po")){
	
	 ?>
		
		<div style="width:755px; text-align:right;"><a href="<?=$baseUrl?>hjang/getView/5/0/<?=$coid?>/<?=$gsid?>/<?=$dange?>" class="btn_gray"><span>사진등록</span></a></div>

<? }?>

<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


</script>    
      
      
            <!-- botton -->
      <!--<a href="#" class="btn_gray"><span>글쓰기</span></a>
      <a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

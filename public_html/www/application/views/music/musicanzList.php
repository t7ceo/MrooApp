<?php


	//미가입회원관리
	$baseUrl = $this->session->userdata('mrbaseUrl');
	$baseUrl .= "music/";

	$baseUrl = $seMenu['sub'][($md-1)]['url'];
	$baseUrlRoot = substr($baseUrl,0, -2);
	$tabmenu = $seMenu['sub'][($md-1)]['sub2'];
	$wrlink = substr($tabmenu[$md2-1]['url'], 0, -2);
	
		
	$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
	
	$su = $totalCount;
?>

		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
        <? 
			$ii = 0;
			foreach($tabmenu as $rowtab){ 
			$oninf = ($ii == ($md3 - 1))? "class='on'" : "" ;
		?>
          <li <?=$oninf?>><a href="<?=$rowtab['url']?>"><?=$rowtab['title']?></a></li>
        <? 
				$ii++;
			} 
		?>          

        </ul>
      </div>
      <!-- //tab -->
        
  
      <!-------------------------------------------------------------------->
 
            <!-- list -->
      <p class="total">총 건수 <strong><?=$su?></strong> 건</p>

      <div class="srch">
      

      
      <select id="selectMdmusic">
      <option value="0" <?=($this->session->userdata("findMd") == "0")? "selected='selected'":""?>>선택</option>
      <option value="tit" <?=($this->session->userdata("findMd") == "tit")? "selected='selected'":""?>>제목</option>
      <option value="gasu" <?=($this->session->userdata("findMd") == "gasu")? "selected='selected'":""?>>아티스트</option>
      </select>      
      
      
        <input type="text" id="musicFindTxt" name="musicFindTxt" value="<?=$this->session->userdata("find")?>" />
        <p><a href="#" class="btn" id="musicFind"><span>검색</span></a></p>
      </div>



      <table class="table_list">
      <caption>사업관리</caption>
      <colgroup>
      <col width="11%">
      <col width="22%">
      <col width="10%">
      <col width="10%">
      <col width="10%">
      <col width="27%">
      <col width="10%">
      </colgroup>
      <thead>
      <tr><td colspan="7" style="border-bottom:#ccc 2px solid;"><audio id="audioPly" src="" controls onended="audioend()" onpause="stoped()"></audio>
	  </td></tr>
      <tr>
        <th>번호</th>
        <th>노래제목</th>
        <th>가수이름</th>
        <th>가사</th>
        <th>이미지</th>
        <th>미리듣기</th>
        <th>관리</th>
      </tr>
      </thead>
      <tbody>
     
<? 
	if($su < 1){
?>		
	
		<tr><td colspan="7">등록된 음원이 없습니다.</td></tr>

<?   }else{
	

	$c = 0;
	
		$num = ($page * ($ppn / $ppn));
	foreach($list as $rows){   

		//if(!$rows->dssu) $rows->dssu = 0;
		

?>   
      <tr>
		<td><?=($su - $num++)?></td>
        <td><?=rawurldecode($rows->tit)?></td>
		<td><?=rawurldecode($rows->gasu)?></td>
        <td><?=$keylistTxt[$rows->id]?></td>
        <td><?=$keylistImg[$rows->id]?></td>
		<td><?=$keylist[$rows->id]?></td>
		<td><a href="#" onclick="membdel(<?=$rows->id?>, <?=$md2?>)"><span>삭제</span></a></td>
        <!--<td><a href="#" onclick="membdelAll()"><span>삭제</span></a></td>-->
      </tr>
<? } } ?>      
      
      
      </tbody>
      </table>
      
		<div class="paging"><?=$this->pagination->create_links();?></div>


<script>
	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


	$(document).ready(function($){
		var coid = <?=$coid?>;
		meminf.memSeCoId = coid;
		if(coid==0){
			var obj = document.getElementById("sauList");
			//console.log("documentid="+obj.id+"/coid="+coid);
			//meminf.memSeCoId = coid;
			//meminf.chnSelect(obj, 1);
		}
		
		$("#sauList").val(coid).attr("selected", "selected");
		
		
	});


var LK = "http://mroo.co.kr/allphpfile/";

//음원관리 리스트
function webplay(sid, endf, f){
	
				var bb = "http://mroo.co.kr/";
	
				var aa = bb+f+"/"+sid+endf;
				//alert(aa);
				
				document.getElementById("audioPly").src = aa;
				document.getElementById("audioPly").play();		

				
				//window.sessionStorage.setItem("komcaid", data.rid);			
	
}


function membdel(mid, md2){
	
	if (confirm('정말로 삭제하시겠습니까?   ')){
		location.href = "http://mroo.co.kr/music/musicon/musicdel/"+mid+"/"+md2+"/1";
	}

	
}


function membdelAll(){
	

		location.href = "http://mroo.co.kr/music/musicon/musicdelAll";

	
}



</script>    
      
      
            <!-- botton -->
      
      <!--<a href="#" class="btn_org"><span>삭제</span></a>-->
      <!-- //botton -->

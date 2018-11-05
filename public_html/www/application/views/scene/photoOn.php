<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "scene/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.

$mode = "insert";
if($ptid > 0) $mode = "edit";


//$aaa = array("md"=>$md, "sup"=>$md2, "coid"=>$md3, "gsid"=>$md4, "dange"=>(int)$fnd);
?>




		<div class="mess" style="position:absolute; margin:-30px 0 0; width:755px;"><?=$this->session->flashdata('transErr')?></div>

      <!-- tab -->
      <div class="tab">
        <ul>
          <li class="on"><a href="<?=$baseUrl?>hjang/getView/1/2">사진등록</a></li>
        </ul>
      </div>
      <!-- //tab -->
      
      <!-- 상담등록 -->
      
 
  <div id="join_mem" class="join_mem finder_div2" style="position:relative; margin:25px auto 0; height:auto; border:none; display:block;">
    
    				<form id="frmPhoto" action="<?=$baseUrl?>scene/hjang/onputPhoto" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name= "ci_t" value="<?=$cihs?>">
                    <input type="hidden" id="gsid" name= "gsid" value="<?=$gsid?>" />
                    <input type="hidden" id="sp" name= "sp" value="<?=$ptid?>" />
                    <input type="hidden" id="md" name= "md" value="<?=$md?>" />
                    <input type="hidden" name= "mode" value="<?=$mode?>" />
                    <input type="hidden" id="coid" name= "coid" value="<?=$coid?>" />
                    
 
         <table class="onputPage">
        <tr><th><span>공사단계 (*)</span></th><td>
            <span width="18%"><label for="dange1"><input type="radio" name="dange" id="dange1" value="1" <?=($dange == 1)? "checked":"";?> /> 전 </label></span>&nbsp;&nbsp;
        	<span width="18%"><label for="dange2"><input type="radio" name="dange" id="dange2" value="2" <?=($dange == 2)? "checked":"";?> /> 중 </label></span>&nbsp;&nbsp;
      	  	<span width="18%"><label for="dange3"><input type="radio" name="dange" id="dange3" value="3" <?=($dange == 3)? "checked":"";?> /> 후 </label></span>
        </td></tr>
        <tr><th><span>제목 (*)</span></th><td><input type="text" name="tit" id="tit" value="<?=($mode == "edit")? $ptss->tit : ""?>" style="width:90%;" /></td></tr>
        <tr><th colspan="2"><span>사진설명</span></th></tr>
        <tr><td colspan="2" class="longTd" >
         
         
    <textarea id="memo" name="memo" style="width:99%; height:100px" placeholder="사진설명"><?=($mode == "edit")? $ptss->memo : ""?></textarea>
         
         
         
        </td></tr>
        
<? 
$f1 = "img";
if($mode == "edit"){ ?>


	<tr><td colspan="2" style="padding:0;">
    
    <?
    	$f1 = "이미지 없음";
		$f2 = "oo";
		if($ptss->imgname == "0"){
			 $f2 = "nn";   //이미지 없음-이미지 선택 해야 한다.
		}else $f1 = "<a href='#' onclick='appBasInfo.delFileGo(\"photoon\", ".$md.", ".$md2.", ".$md3.", ".$ptid.", 1)'>".$ptss->imgname." <img src='".PREDIR."/images/common/btn_commt_del.gif' alt='파일삭제' style='vertical-align:midddle;'></a>";
	
	?>
    	<table style="width:100%; margin:0; height:auto; border-bottom:#ccc 2px solid;">
        <tr><th style="width:22%;">이미지파일</th><td style="width:78%;" id="fileTd1">
			<?=$f1?><br />
        	<? if($f2 != "nn"){ ?> <img src="<?=PREDIR?>images/scene/<?=$ptss->imgname?>" style="width:100%;"> <? } ?>
        </td>
        </table>
               <input type="hidden" id="imginf" name= "imginf" value="<?=$f2?>" />
    </td></tr>
  
    
        <tr><th><span>이미지파일 :</span></th><td><input type="file" id="file1" name="file1" <?=($f2 != "nn")? "disabled" : ""?> /></td></tr>
        </table>
        
<? }else{ ?> 
        <tr><th><span>첨부파일 (*)</span></th><td><input type="file" name="file1" /></td></tr>
        </table>
		<input type="hidden" id="imginf" name= "imginf" value="insert" />
<? } ?>
        
        
<div style="width:100%; text-align:center; padding:20px 0;">
        
        

        <?
			if($f1 == "없음"){
				
		?>
        <a href="#" class="btn_org" onclick="meminf.onputPhoto(0)"><span><?=($mode == "edit")? "사진수정" : "사진등록"?></span></a>
        
        <?		
			}else{
		?>
		<a href="#" class="btn_org" onclick="meminf.onputPhoto(1)"><span><?=($mode == "edit")? "사진수정" : "사진등록"?></span></a>
        
        <?
			}
			if($md == 5 and $md2 > 0){   //사진보기 내의 리스트에서 클릭해다.
		?>
        
        <a href="<?=$baseUrl?>hjang/getView/2/8/<?=$coid?>/<?=$gsid?>"  class="btn_gray"><span>목록</span></a>
        
        <?
			}else{   //공사리스트에서 클릭 했다.
		?>
        
        <a href="<?=$baseUrl?>hjang/getView/2/5"  class="btn_gray"><span>목록</span></a>
        
        <?
			}
			?>
        
 </div>       

        
         <div class="mess"><?=$this->session->flashdata('memedit')?></div>
 

				</form>
    

  </div>
  
  


<script>

	setTimeout(function(){
		$(".mess").css("display","none");
		}, 3000);


</script>    
      

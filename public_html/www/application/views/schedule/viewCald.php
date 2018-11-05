<?php
//미가입회원관리
$baseUrl = $this->session->userdata('mrbaseUrl');
$baseUrl .= "schedule/";

$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


$su = 0; //count($gaip);

	if(keyMan('bonsaadmin',0) or ($md == 1 and keyMan('bonsa', 0)) or ($md == 2 and (keyMan('johap', 0) or keyMan('bonsa', 0))) or ($md == 3 and keyMan('jasa', 0))){
?>
<div class="srch"><p><a href="<?=$baseUrl?>schedule/getView/<?=$md?>/2" class="btn_gray" id="transExl"><span>일정등록</span></a></p></div>
<? } ?>


<div>
<? 
/****************************** 
달력 
******************************/ 

/********** 사용자 설정값 **********/ 
$startYear        = 2007; 
$endYear        = date( "Y" ) + 4; 

/********** 입력값 **********/ 

$doms            = array( "c_sun", "c_mon", "c_tue", "c_wed", "c_thu", "c_fri", "c_sat" ); 

/********** 계산값 **********/ 
$mktime            = mktime( 0, 0, 0, $month, 1, $year );      // 입력된 값으로 년-월-01을 만든다 
$days            = date( "t", $mktime );                        // 현재의 year와 month로 현재 달의 일수 구해오기 
$startDay        = date( "w", $mktime );                        // 시작요일 알아내기 

// 지난달 일수 구하기 
$prevDayCount    = date( "t", mktime( 0, 0, 0, $month, 0, $year ) ) - $startDay + 1; 

$nowDayCount    = 1;                                            // 이번달 일자 카운팅 
$nextDayCount    = 1;                                          // 다음달 일자 카운팅 

// 이전, 다음 만들기 
$prevYear        = ( $month == 1 )? ( $year - 1 ) : $year; 
$prevMonth        = ( $month == 1 )? 12 : ( $month - 1 ); 
$nextYear        = ( $month == 12 )? ( $year + 1 ) : $year; 
$nextMonth        = ( $month == 12 )? 1 : ( $month + 1 ); 

// 출력행 계산 
$setRows        = ceil( ( $startDay + $days ) / 7 ); 
?>

<table border="0" cellpadding="0" cellspacing="0" class="nostyle" align="left">
	<tr>
		<td style="font-size:25px">
		<a href="<?=$baseUrl?>schedule/getView/<?=$md?>/<?=$onmd?>/<?=$prevYear?>/<?=$prevMonth?>" class='font2'>◀</a>
		</td>
		<td valign="bottom">
		<?
		$year_img1 = substr($year,0,1);
		$year_img2 = substr($year,1,1);
		$year_img3 = substr($year,2,1);
		$year_img4 = substr($year,3,1);								
		?>
		<img src="<?=PREDIR?>images/calendar/Num/2/<?=$year_img1?>.gif" align="absmiddle"><img src="<?=PREDIR?>images/calendar/Num/2/<?=$year_img2?>.gif" align="absmiddle"><img src="<?=PREDIR?>images/calendar/Num/2/<?=$year_img3?>.gif" align="absmiddle"><img src="<?=PREDIR?>images/calendar/Num/2/<?=$year_img4?>.gif" align="absmiddle"><br>
		</td>
		<td valign="bottom">
		&nbsp;<img src="<?=PREDIR?>images/calendar/txt_year.gif" align="absmiddle" width="11" height="13" alt="년"><br>
		</td>
		<td width="20">
		</td>
		<td>
		<?
		if($month < 10){
		?>
			<img src="<?=PREDIR?>images/calendar/Num/1/<?=(int)$month?>.gif" align="absmiddle" alt="<?=(int)$month?>"><br>
		<?
		}else if($month >= 10){
			$month_img1 = substr($month,0,1);
			$month_img2 = substr($month,1,1);
		?>
			<img src="<?=PREDIR?>images/calendar/Num/1/<?=$month_img1?>.gif" align="absmiddle" alt="<?=$month_img1?>">
			<img src="<?=PREDIR?>images/calendar/Num/1/<?=$month_img2?>.gif" align="absmiddle" alt="<?=$month_img2?>">
		<?
		}
		?>
		</td>
		<td valign="bottom">
		<img src="<?=PREDIR?>images/calendar/txt_month.gif" align="absmiddle" width="15" height="17" alt="월"><br>
		</td>
		<td style="font-size:25px">
		<a href="<?=$baseUrl?>schedule/getView/<?=$md?>/<?=$onmd?>/<?=$nextYear?>/<?=$nextMonth?>" class='font2'>▶</a>
		</td>
	</tr>
</table>

<table width="100%" border="1" cellspacing="1" cellpadding="10" style="background-color:#EEEEEE;width: 100%;border-collapse: collapse;">
	<tr>
		<?for( $i = 0; $i < count( $doms ); $i++ ){?> 
			<?if($i == 0){?>
				<td align="center" height="20" width="15%" style="background-color:#db8a8a;">
			<?}else if($i == 6){?>
				<td align="center" width="15%" style="background-color:#a4c3e5;">
			<?}else{?>
				<td align="center" width="14%" style="background-color:#CCCCCC;">
			<?}?>
			<img src="<?=PREDIR?>images/calendar/<?=$doms[$i]?>.gif"><br>
		</td>
		<?}?>											
	</tr>
	<?for( $rows = 0; $rows < $setRows; $rows++ ){?> 
	<tr style="background-color:#FFFFFF">
		<? 
		for( $cols = 0; $cols < 7; $cols++ ){ 
			// 셀 인덱스 만들자 
			$cellIndex    = ( 7 * $rows ) + $cols; 
			// 이번달이라면 
			if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { 
				$fn_var['regist_dt'] = $year . "-" . $month . "-" . $nowDayCount;

				if((int)$month < 10){
					$month = '0'.(int)$month;
				}
				if($nowDayCount < 10){
					$nowDayCount = '0'.$nowDayCount;
				}
				$today = $year . "-" .$month . "-". $nowDayCount;
		?> 
				<?
				if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ){
					$fday = 2;
				?> 
					<td <?if($today == date('Y-m-d')){?>style='background-color:yellow;'<?}else{?>style='border: 2px solid #bcbcbc;'<?}?> onMouseOver="this.style.backgroundColor='#DFF9FF';return true;" <?if($today == date('Y-m-d')){?>onMouseOut="this.style.backgroundColor='yellow';return true;"<?}else{?>onMouseOut="this.style.backgroundColor='';return true;"<?}?>>
				<?
				} else if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0 ){
					$fday = 3;
				?> 
					<td <?if($today == date('Y-m-d')){?>style='background-color:yellow;'<?}else{?>style='border: 2px solid #bcbcbc;'<?}?> onMouseOver="this.style.backgroundColor='#FFF5DF';return true;" <?if($today == date('Y-m-d')){?>onMouseOut="this.style.backgroundColor='yellow';return true;"<?}else{?>onMouseOut="this.style.backgroundColor='';return true;"<?}?>>               
				<?
				} else {
					$fday = 1;
				?> 
					<td <?if($today == date('Y-m-d')){?>style='background-color:yellow;'<?}else{?>style='border: 2px solid #bcbcbc;'<?}?> onMouseOver="this.style.backgroundColor='#EEEEEE';return true;" <?if($today == date('Y-m-d')){?>onMouseOut="this.style.backgroundColor='yellow';return true;"<?}else{?>onMouseOut="this.style.backgroundColor='';return true;"<?}?>>
				<?}?>													
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="right">
							<img src="<?=PREDIR?>images/calendar/Day/<?=$fday?>/<?=(int)$nowDayCount++?>.gif" border="0"><br>
							</td>
						</tr>
						<tr>
							<td height="60">
<?

if(count(getSchedule($today, $md, $coid)) > 0){
	echo getSchedule($today, $md, $coid);
}
?>
							</td>
						</tr>
					</table>
				</td>
		<?
			// 이전달이라면 
			} else if ( $cellIndex < $startDay ) { ?> 
				<td bgcolor='' style='border: 2px solid #bcbcbc;' onMouseOver="this.style.backgroundColor='#EEEEEE';return true;" onMouseOut="this.style.backgroundColor='';return true;">&nbsp;</td>
			<? 
			// 다음달 이라면 
			} else if ( $cellIndex >= $days ) { ?> 
				<td bgcolor='' style='border: 2px solid #bcbcbc;' onMouseOver="this.style.backgroundColor='#EEEEEE';return true;" onMouseOut="this.style.backgroundColor='';return true;">&nbsp;</td>
			<? } ?>
		<?
		}
		?>											
	</tr>
	<?}?>										
</table>
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

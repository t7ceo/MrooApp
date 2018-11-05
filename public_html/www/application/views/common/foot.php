<?php 
$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.


?>
    
        </div>

  </div> <!----container---->


</div> <!--  wrapper -->

    <!-- footer -->
    <div id="footer">
    <div class="copy"> Copyright ⓒ <strong>MROO</strong> All rights reserved. </div>
    </div>
    <!-- //footer -->


	<script>
	//코드이그나이터 헤시값을 가져온다.
    var CIHS = "<?=$cihs?>";
	var MASTER = <?=MASTER?>;
	var SUPER = <?=SUPER?>;
	var ADMIN = <?=ADMIN?>;
	var SAWON = <?=SAWON?>;
	var JOHAP = <?=JOHAP?>;
	var USER = <?=USER?>;
	var PREDIR = "<?=PREDIR?>";
	var mainUrl = "<?=$seMenu['mainUrl']?>";
	
	

	
	
	
	var mypotion = 0;
	var myrecid = 0;
	var mymemid = "";
	<? if($this->session->userdata("logged_in")){ ?>
	mypotion = <?=$this->session->userdata("potion")?>;
	myrecid = <?=$this->session->userdata("id")?>;
	mymemid = "<?=$this->session->userdata("memid")?>";
	<? } ?>
	

	           var bdGubun = <?=$this->config->item("Vmd")?>;


			//엔터키 처리를 한다.
		$("#logid, #logpass").keydown(function(e){
			
			switch(e.keyCode){
			case 13:
				meminf.login(CIHS);
			break;
			}

			
		});

		

	
    </script>

	<!--<script src='/fullcalendar/lib/moment.min.js'></script>-->
	<!--<script src='/fullcalendar/fullcalendar.min.js'></script>-->
        

	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onloadFun.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/onBeforeShow.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/hdmem.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/apputil.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/classAll.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/getserver.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/base64.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/alltxt.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=PREDIR?>apis/printThis.js"></script>
    
    


<script>

	meminf.md1 = <?=$md?>;
	meminf.md2 = <?=$md2?>;
	meminf.md3 = <?=$md3?>;
	meminf.md4 = <?=$md4?>;
	meminf.fnd = "<?=$fnd?>";
	meminf.page = <?=$page?>;

	$(document).ready(function(e) {
        
			
		divAllWidth("td1");	
		divAllWidth("td2");	
		divAllWidth("td3");	
		divAllWidth("memlist");
		divAllWidth("noreAll");
		divAllWidth("gongjiAll");
		divAllWidth("mrsaleAll");
		
		
		
	
		switch(pageMode){
		case "hjang":
		
	
	/*
								if(pageMd == 2 && pageMd2 == 2){  //현장의 대상자 등록,
									mapObj = new coMappro("desangMap");
									mapObj.map = null;
								
									if(meminf.md4 > 0){
										//alert("eeeeeee"+imsiLang);
										meminf.latPo = imsiLat;
										meminf.langPo = imsiLang;
									}
								
									mapObj.dispMap(imsiLat, imsiLang, "위치");
	
								
								}else if((pageMd == 2 && pageMd2 == 4) || (pageMd == 2 && pageMd2 == 44)){  //대상자 상세보기, 
									meminf.latPo = imsiLat;
									meminf.langPo = imsiLang;
									mapObj = new coMappro("dsmap");
									mapObj.map = null;
								
									mapObj.dispMap(imsiLat, imsiLang, "위치");
								
								}else if(pageMd == 3 && pageMd2 == 3){
									meminf.latPo = imsiLat;
									meminf.langPo = imsiLang;
									mapObj = new coMappro("dsmap");
									mapObj.map = null;
								
									mapObj.dispMap(imsiLat, imsiLang, "위치");
									
								}
	*/
	
		break;
		case "community":
		
		 
		
		break;
		}
	
	

	
	
			  $.datepicker.setDefaults({
				dateFormat: 'yy-mm-dd',
				prevText: '이전 달',
				nextText: '다음 달',
				monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				dayNames: ['일', '월', '화', '수', '목', '금', '토'],
				dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				showMonthAfterYear: true,
				yearSuffix: '년'
			  });
			$("#start_dt, #end_dt, #bthday, #sdonday").datepicker();			
		

		
    });


		function limouseov(obj){
			
			obj.style.width = "86%";
			obj.style.marginLeft = "3%";
			obj.style.borderRadius = "10px";
			obj.style.backgroundColor = "#e1e1e1";
			obj.style.color = "white";
		
		}
	
		function limouseout(obj){
			obj.style.width = "86%";
			obj.style.marginLeft = "3%";
			obj.style.backgroundColor = "#f1f1f1";
			obj.style.color = "black";
		}
	

 




</script>


</body>



</html>
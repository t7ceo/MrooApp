// 탭메뉴 공통적으로 사용
//ex) tabOn(1,1);
function tabOn(tabid,a) {
	for (i=1;i<=10;i++) {
		if(i<10){inn="0"+i;} else {inn=""+i;}
		tabMenu = document.getElementById("tab"+tabid+"m"+i);
		tabContent = document.getElementById("tab"+tabid+"c"+i);
		tabMore = document.getElementById("tab"+tabid+"more"+i);
		if (tabMenu) { //객체가존재하면
			if (tabMenu.tagName=="IMG") { tabMenu.src = tabMenu.src.replace("_on.", "_off."); } //이미지일때
			if (tabMenu.tagName=="A") { tabMenu.className=""; } //앵커일때
		}
		if (tabContent) { tabContent.style.display="none"; }
		if (tabMore) { tabMore.style.display="none"; }

	}
	if(a<10){ann="0"+a;} else {ann=""+a;}
	tabMenu = document.getElementById("tab"+tabid+"m"+a);
	tabContent = document.getElementById("tab"+tabid+"c"+a);
	tabMore = document.getElementById("tab"+tabid+"more"+a);
//	alert(tabMenu.tagName);
	if (tabMenu) { //객체가존재하면
		if (tabMenu.tagName=="IMG") { tabMenu.src = tabMenu.src.replace("_off.", "_on."); } //이미지일때
		if (tabMenu.tagName=="A") { tabMenu.className="on"; } //앵커일때
	}
	if (tabContent) { tabContent.style.display="block"; }
	if (tabMore) { tabMore.style.display="block"; }
} 

$(document).ready(function(){
	//이미지 롤오버 
	 $(".overimg").mouseover(function (){
		var file = $(this).attr('src').split('/');
		var filename = file[file.length-1];
		var path = '';
		for(i=0 ; i < file.length-1 ; i++){
		 path = ( i == 0 )?path + file[i]:path + '/' + file[i];
		}
		$(this).attr('src',path+'/'+filename.replace('_off.','_on.'));
		
	 }).mouseout(function(){
		var file = $(this).attr('src').split('/');
		var filename = file[file.length-1];
		var path = '';
		for(i=0 ; i < file.length-1 ; i++){
		 path = ( i == 0 )?path + file[i]:path + '/' + file[i];
		}
		$(this).attr('src',path+'/'+filename.replace('_on.','_off.'));
	 });
});

jQuery(function($){
	//lnb
	var total=$('#lnb .depth1').length;
	$('#lnb .depth1 a.tit').append('<span></span>');
	$('#lnb .depth1 a.tit').mouseenter(function(){
		$('#lnb .tit').removeClass('on').next('.top2m').hide();
		$(this).addClass('on').next('div').show();
		$(this).find('img').attr("src", $('img',this).attr("src").split("_off.png").join("_on.png"));
	}).focusin(function(){
		$('.top2m').hide();
		$(this).addClass('on').next('div').show();
		$(this).find('img').attr("src", $('img',this).attr("src").split("_off.png").join("_on.png"));
	});
	$('#lnb .depth1').mouseleave(function(){
		$(this).find('.tit').removeClass('on').next('div').hide();
		$('.top2m').hide();
		$(this).find('a.tit').find('img').attr("src", $('img',this).attr("src").split("_on.png").join("_off.png"));
	});
	$('#lnb .top2m li:last-child()').focusout(function(){
		$(this).parents('li.depth1').find('div').hide().prev('a.tit').removeClass('on');
		for(i=1;i<=total;i++){
		$('#lnb .depth1:nth-child('+i+') a.tit img').attr("src", $('img','#lnb .depth1:nth-child('+i+') a.tit').attr("src").split("_on.png").join("_off.png"))
		};
	});
});


/*******************************************************************************************************
* 프리뷰 이미지 레이어
* 사용법 (#표시는 필수)
	보이기 : ShowPreView(#이미지코드, 회사코드, 타이틀, 설명, #사용값, #가로사이즈, #세로사이즈, 쿠키사용여부, #이미지주소);
	숨기기 : HidePreView();

	/common/default.css 의 [#chartid] 부분 필수 참조.
	쿠키 사용 시 republic.js에 추가한 set_cookie, get_cookie 사용 필수 참조.
*******************************************************************************************************/

var offsetfrommouse=[0, 0]; //image x,y offsets from cursor position in pixels. Enter 0,0 for no offset
var chart_width = 750;	// maximum image width.
var chart_height = 580;	// maximum image height.


var xcoord;
var ycoord;


if (document.getElementById || document.all) {
	document.write('<div id="chartid" style="width:750px; height:0px; min-height:580px; z-index:1000; display:none;">');
	document.write('</div>');
}


function gettrailobj() {
  if (document.getElementById) return document.getElementById("chartid").style
	else if (document.all) return document.all.trailimagid.style
}



function gettrailobjnostyle() {
	if (document.getElementById) return document.getElementById("chartid")
	else if (document.all) return document.all.trailimagid
}

function truebody() {
	return (!window.opera && document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body;
}

function ShowPreView(n) {
	$('#chart_Box').show();
	chart_width = $('.pop_chart').width();
	chart_height = $('.pop_chart').height();

	document.getElementById("chartid").style.display = "";
	followmouse();
	
	newHTML ="";
	newHTML = $('.chart'+n).clone(true);
	
	$('#chartid').html(newHTML);
	$('#chartid .pop_chart').show();
	$('#chartid').css('visibility','visible');

}

function HidePreView() {
	$('#chartid').css('visibility','hidden');
	newHTML ="";
	$('#chartid').html(newHTML);

	document.onmousemove="";
	gettrailobj().left="-1000px";
	$('#chart_Box').hide();
}



var getNowScroll = function() {
	var de = document.documentElement;
	var b = document.body;
	var now = {};

	now.X = (document.all != "undefined") ? (!de.scrollLeft ? b.scrollLeft : de.scrollLeft) : (window.pageXOffset ? window.pageXOffset : window.scrollX);
	now.Y = (document.all != "undefined") ? (!de.scrollTop ? b.scrollTop : de.scrollTop) : (window.pageYOffset ? window.pageYOffset : window.scrollY);

	return now;
}

function followmouse(e) {

	// 이미지 사이즈 한번더 체크
	chart_width = $('.pop_chart').width();
	chart_height = $('.pop_chart').height();

	xcoord=offsetfrommouse[0];
	ycoord=offsetfrommouse[1];
	
	//현재화면 : 브라우저 문서 창크기
	var docwidth=document.all? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth-15;
	var docheight=document.all? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(window.innerHeight);
	
	obj = document.getElementById("chart_Box");

	var inBodytop = getObjectTop(obj) - getNowScroll().Y;
	//var inBodyleft = getObjectLeft(obj) - getNowScroll().X;
		
	var a = getNowScroll().Y;

	xcoord  = (docwidth - 980)/2 + 230 ;

	// height
	if (event.clientY > chart_height + 50)
	{ // to Top
		ycoord = event.clientY - inBodytop - chart_height - 155;
	}
	else if((docheight - event.clientY) > chart_height + 60)
	{ // to Down
		ycoord = event.clientY - inBodytop - 30;
	}
	else
	{ // to Middle
		if (inBodytop >= 0)
		{
			ycoord = 200 - inBodytop;
		}
		else
		{
			ycoord = Math.abs(inBodytop) + 50;
		}
	}

	console.log("내용크기 : " + chart_height);
	console.log("마우스위치 Y : " + event.clientY);
	console.log("창크기 : " + docheight);
	console.log("y : " + ycoord);
	console.log("inBodytop : " + a);


	if (xcoord) {
		gettrailobj().left=xcoord+"px";
		gettrailobj().top=ycoord+"px";
	}

	/*
	//Value test
	alr_str = "현재화면 w : "+docwidth+"\n";
	alr_str += "현재화면 h : "+docheight+"\n";
	alr_str += "이미지 w : "+chart_width+"\n";
	alr_str += "이미지 h : "+chart_height+"\n";
	alr_str += "마우스위치 x : "+e.pageX+"\n";
	alr_str += "마우스위치 y : "+e.pageY+"\n";
	alr_str += "스크롤 x : "+getNowScroll().X+"\n";
	alr_str += "스크롤 y : "+getNowScroll().Y+"\n";
	alr_str += "안쪽레이어 x : "+getObjectLeft(obj)+"\n";
	alr_str += "안쪽레이어 y : "+getObjectTop(obj)+"\n";
	alr_str += "inBody x : "+inBodyleft+"\n";
	alr_str += "inBody y : "+inBodytop+"\n";
	alr_str += "뿌려지는 위치 x : "+xcoord+"\n";
	alr_str += "뿌려지는 위치 y : "+ycoord+"\n";
	alert(alr_str);
	*/
	xcoord = 0;
	ycoord = 0;
	inBodytop = 0;
	inBodyleft = 0;

}

function getObjectTop(obj)
{
    if(obj.offsetParent == document.body)
        return obj.offsetTop;
    else
        return obj.offsetTop + getObjectTop(obj.offsetParent);
}

function getObjectLeft(obj)
{
    if(obj.offsetParent == document.body)
       return obj.offsetLeft;
   else
       return obj.offsetLeft + getObjectLeft(obj.offsetParent);
}


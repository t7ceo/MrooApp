<?

if(!$_GET['mode']) $lightInf = "off";

switch($_GET['mode']){
case "lon":
	$lightInf = "on";

break;
case "loff":
	$lightInf = "off";
break;
}

/*  602422291128      AIzaSyA_0Do9RnCuuHX_fH_3NqYMl4_RMbK8VuA */

?>

<!DOCTYPE html> 
<html>
<head>

	<meta charset="euc-kr">
	<meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
        
	<title></title>

    <link rel="manifest" href="app/manifest.json">
    
    <style>
 
/* ----------------------------------------------
 * Generated by Animista on 2018-10-30 20:58:19
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

@-webkit-keyframes rotate-90-cw{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(90deg);transform:rotate(90deg)}}
@keyframes rotate-90-cw{
	0%{-webkit-transform:rotate(0);transform:rotate(0)}
	25%{-webkit-transform:rotate(90deg);transform:rotate(90deg)}
	50%{-webkit-transform:rotate(180deg);transform:rotate(180deg)}
	75%{-webkit-transform:rotate(270deg);transform:rotate(270deg)}
	100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
	
	}
	
	/* ----------------------------------------------
 * Generated by Animista on 2018-11-1 15:1:27
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation jello-horizontal
 * ----------------------------------------
 */
@-webkit-keyframes jello-horizontal {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
            transform: scale3d(1.25, 0.75, 1);
  }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
            transform: scale3d(0.75, 1.25, 1);
  }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
            transform: scale3d(1.15, 0.85, 1);
  }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
            transform: scale3d(0.95, 1.05, 1);
  }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
            transform: scale3d(1.05, 0.95, 1);
  }
  100% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
}
@keyframes jello-horizontal {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
            transform: scale3d(1.25, 0.75, 1);
  }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
            transform: scale3d(0.75, 1.25, 1);
  }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
            transform: scale3d(1.15, 0.85, 1);
  }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
            transform: scale3d(0.95, 1.05, 1);
  }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
            transform: scale3d(1.05, 0.95, 1);
  }
  100% {
    -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
  }
}


/* ----------------------------------------------
 * Generated by Animista on 2018-11-1 15:36:28
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation vibrate-1
 * ----------------------------------------
 */
@-webkit-keyframes vibrate-1 {
  0% {
    -webkit-transform: translate(0);
            transform: translate(0);
  }
  20% {
    -webkit-transform: translate(-2px, 2px);
            transform: translate(-2px, 2px);
  }
  40% {
    -webkit-transform: translate(-2px, -2px);
            transform: translate(-2px, -2px);
  }
  60% {
    -webkit-transform: translate(2px, 2px);
            transform: translate(2px, 2px);
  }
  80% {
    -webkit-transform: translate(2px, -2px);
            transform: translate(2px, -2px);
  }
  100% {
    -webkit-transform: translate(0);
            transform: translate(0);
  }
}
@keyframes vibrate-1 {
  0% {
    -webkit-transform: translate(0);
            transform: translate(0);
  }
  20% {
    -webkit-transform: translate(-2px, 2px);
            transform: translate(-2px, 2px);
  }
  40% {
    -webkit-transform: translate(-2px, -2px);
            transform: translate(-2px, -2px);
  }
  60% {
    -webkit-transform: translate(2px, 2px);
            transform: translate(2px, 2px);
  }
  80% {
    -webkit-transform: translate(2px, -2px);
            transform: translate(2px, -2px);
  }
  100% {
    -webkit-transform: translate(0);
            transform: translate(0);
  }
}

	
	
	#panda{
		height:300px;
		animation-name: jello-horizontal;
		animation-duration:1.5s;
		animation-iteration-count:infinite;

	}
	
    </style>
    

</head>


<body  topmargin="0" leftmargin="0" style="width:1280px; height:720px; background:url(mainbgDark.png) no-repeat; overflow:hidden;">

<div id="panddd">

<?
$h = 20;
$w = 2;
for($i = 0; $i < 30; $i++){
?>

<img id="panda" src="./panda.png" style="position:absolute; height:300px; left:<?=$h?>px; top:<?=$w?>px; z-index:50;">

<?

$h += 10;
$w += 2;
}
?>

</div>




<img id = "airconImg" src="./aircon.png" style="position:absolute; height:300px; top:270px; left:250px; z-index:50;">

<? if($lightInf == "on"){ ?>
	<img id="lightSun" src="./mainbgLight.png" style="position:absolute; width:100%; left:0; top:0; z-index:100;">
	<img id = "lightImg" src="./lightOn.png" style="position:absolute; top:190px; left:385px; z-index:50;">
    <img id="lightSun" src="./mainbg.png" style="position:absolute; width:100%; left:0; top:0; z-index:1;">
    
    <img id="lightSun" src="./mainbgLight.png" style="position:absolute; width:1px; left:0; top:0; z-index:100;">
	<img id = "lightImg" src="./light.png" style="position:absolute; width:1px; top:190px; left:385px; z-index:50;">
    <img id="lightSun" src="./mainbgDark.png" style="width:1px; position:absolute; left:0; top:0; z-index:1;">
    <img id="lightSun" src="./mainbg.png" style="width:1px; position:absolute; left:0; top:0; z-index:1;">
<? }else{ ?>
	<img id="lightSun" src="./mainbgLight.png" style="position:absolute; width:1px; left:0; top:0; z-index:100;">
	<img id = "lightImg" src="./lightOn.png" style="width:1px; position:absolute; top:190px; left:385px; z-index:50;">
    <img id="lightSun" src="./mainbg.png" style="position:absolute; width:1px; left:0; top:0; z-index:1;">

	<img id="lightSun" src="./mainbgLight.png" style="position:absolute; width:1px; left:0; top:0; z-index:100;">
	<img id = "lightImg" src="./light.png" style="position:absolute; top:190px; left:385px; z-index:50;">
    <img id="lightSun" src="./mainbgDark.png" style="position:absolute; width:100%; left:0; top:0; z-index:1;">
    <img id="lightSun" src="./mainbg.png" style="position:absolute; width:100%; left:0; top:0; z-index:1;">
<? } ?>




<script src="js/main.js"></script>




</script>

</body>

</html>

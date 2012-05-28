<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Foodiewheel | What shall we eat today?</title>

<!-- meta info -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta itemprop="image" content="images/foodie_favicon.png">
<meta name="description" content="What shall we eat today? Have fun spinning the foodiewheel to decide what to eat everyday.">
<meta name="keywords" content="foodiewheel, food, nutrition, healthcare, choices, what, shall, we, eat, today">
<link rel='shortcut icon' href='images/foodie_favicon.png' />

<link rel="stylesheet" href="960.css" media="all" type="text/css">
<link rel="stylesheet" href="designCSS.css" media="all" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-weight: bold;
	color: #999999;
	margin-top:5px;
	margin-bottom:5px;
}
.style3 {color: #000000}
.white-color {color:white;}
-->
</style>
<script type="text/javascript">
				   
var southIndianFoods = [
	"Idli", 
	"Rava Idli",
	"Dosa",
	"Rava Dosa", 
	"Vada", 
	"Adai",
	"Upma", 
	"Sevai",
	"Avvil",
	"Uthappam",
	"Pongal",
	"Appam",
	"Idiappam",
	"Ragi Roti"
	];

var northIndianFoods = [
	"Paratha",
	"Chilla",
	"Kichdi",
	"Poori", 
	"Sabudana Kichdi",
	"Daliya",
	"Poha",
	"Sooji halwa",
	"Thepla",
	"Dokhla",
	"Egg burji"	
	];
	
var continentalFoods = [
	"Omlette",
	"Toast",
	"Sandwich",
	"Porridge",
	"Oats",
	"Muesli",
	"Corn flakes",
	"Pancakes",
	"Noodles"
	];				   

var lowcalFoods = [
	"Daliya",
	"Appam",
	"Ragi Roti",
	"Idli", 
	"Rava Idli",
	"Dosa",
	"Sevai",
	"Avvil",
	"Uthappam",
	"Appam",
	"Idiappam",
	"Ragi Roti",
	"Toast",
	"Sandwich",
	"Porridge",
	"Oats",
	"Muesli"
	];	

var foodChoices = northIndianFoods;
				   				   
</script>
<?php include_once("analytics.php"); ?>
<!--[if IE]><script src="excanvas.js"></script><![endif]-->
<script type="application/javascript" src="mealwheel.js"></script>
<script type="text/javascript" src="../jquery/jquery-1.7.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		
		//initializing the wheel with default choices;
		foodChoices = northIndianFoods;
		numChoices = northIndianFoods.length;
		arc = Math.PI / (numChoices/2);
		drawRouletteWheel();
		
		//spin_button event
		$('#spin_button').click(function() {
			spin();
			$.post("addSpins.php",{pagename:"mealwheel"});
  			_gaq.push(['_trackEvent', 'wheelspin', 'spin']);
			
		});
		
		//cuisine_select event
		$('#cuisine_select').click(function () {
			//change the wheel based on the cuisine selection
			selection = $(this).attr('value');

			//analytics tracking
  			_gaq.push(['_trackEvent', 'cuisine-change', 'cuisine-choice', selection]);
			
			switch(selection)
			{
				case "northindian":
					foodChoices = northIndianFoods;
					numChoices = northIndianFoods.length;
					arc = Math.PI / (numChoices/2);
					drawRouletteWheel();
					break;
					
				case "southindian":
					foodChoices = southIndianFoods;
					numChoices = southIndianFoods.length;
					arc = Math.PI / (numChoices/2);
					drawRouletteWheel();
					break;
					
				case "continental":
					foodChoices = continentalFoods;
					numChoices = continentalFoods.length;
					arc = Math.PI / (numChoices/2);
					drawRouletteWheel();
					break;

				case "lowcal":
					foodChoices = lowcalFoods;
					numChoices = lowcalFoods.length;
					arc = Math.PI / (numChoices/2);
					drawRouletteWheel();
					break;

			}
		});
	});
	
</script>
</head>
<body>
<!-- start facebook code -->
        <div id="fb-root"></div>
        <script>
		window.fbAsyncInit = function() {
		FB.init({appId: '395538253791057', status: true, cookie: true,
		xfbml: true});
		
		FB.Event.subscribe('edge.create',
			function(response){				
			//analytics tracking
  			_gaq.push(['_trackEvent', 'FB_Like', 'wheel_name','No_name']);

			});
		};
		
		(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
	</script>
<!-- end facebook code -->

<p align="center" class="style1">What shall we <span class="style3">eat</span> today?
		<!-- start facebook code -->
        <fb:like data-href="http://www.foodiewheel.in" data-send="false" data-layout="button_count" data-width="10" data-show-faces="false" data-font="tahoma"/>
        <!-- end facebook code -->

<br/>
<p align="center">Let the <span class="style3 bold-weight">foodiewheel</span> help you decide what to eat.<br/><span class="style3 bold-weight">Spin</span> it. <span class="style3 bold-weight">Save</span> it. <span class="style3 bold-weight">Share</span> it. </p>
<div class="container_12" style="border:0px solid #ccc">
		<div class="grid_3" style="border:0px solid #ccc">
		<!-- left side container -->

			<span class="bold-weight">Choose a foodiewheel:</span><br/>
			<select id="cuisine_select" width="30px">
				<option value="northindian">North Indian</option>
				<option value="southindian">South Indian</option>
				<option value="continental">Continental</option>
				<option value="lowcal">Low calorie</option>
			</select>
            <span class="small_grey_label">Choose from cuisine options</span> 

            <br/>
            <p style="padding:0 0 0 30px; font-weight:bold;">OR</p>
            
            <form id="build_wheel_form" method="post" action="cuisineChoose.php">
				<button class="green_round_button small_button">Build your own foodie-wheel</button>
            </form>

            <br/>
            <p style="padding:0 0 0 30px; font-weight:bold;">OR</p>
		
        	<!-- search wheel form -->
            <span class="bold-weight">Find custom wheels:</span> 
			<form id="searchWheelForm" method="post" action="searchWheel.php">
	            <input type="text" id="searchWheelInput" name="searchWheelInput" placeholder="Wheel name (at least 3 chars)" title="Choose name of the wheel to search" pattern=".{3,}" size="30px" required/><br/ >
				<button class="green_round_button small_button">Search</button>              
			</form>
            
			</div>

		<div class="grid_1 divider">&nbsp;<!-- vertical divider between two containers --></div>

		<div class="grid_6" style="border:0px solid #ccc">
        <!-- right side container begins -->
			<div align="center">
			  <button id="spin_button" class="green_round_button small_button">click to spin >></button>
              <!--<span class="small_grey_label">&nbsp;&nbsp;Spun <b id="spinCount">xx</b> times</span>-->
			  <canvas id="mealwheel" width="450" height="450">	
			  </canvas>
              
              <!-- callout design -->
              	<div id="info_callout" class="callout" style="display:none;">
    				<b class="notch"></b>
				</div>
		      <!-- end callout design -->

            </div>
		</div>
		<div class="clear"></div>
        
        <!-- footer starts here -->
        <div id="footer" class="grid_12">
       	  <hr class="footerline">
       	  <div class="pull_center"><a class="footerlinks" href="why.html">why</a> | <a class="footerlinks" href="what.html">what</a> | <a class="footerlinks" href="who.html">who</a> | <a class="footerlinks" href="/blog">blog</a></div>
           <p>&nbsp;</p>
		   <div id="copyright_note" class="pull_center small_grey_label">Copyright (c) 2012 VV&GG <br/> Works best on Chrome, Firefox and HTML5-compliant browsers. </div>	 
        </div>
</div>
</body>
</html>
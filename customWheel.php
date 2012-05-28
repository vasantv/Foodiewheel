<?php
/* Objective: to obtain custom saved wheels */

//obtain wheel id; get wheel items based on id;
include_once("codes/masterfunctions.php");
$wheelId = $_GET["id"];
$wheel = getWheel($wheelId);
if($wheel == NULL)
{
	//display message indicating that the wheel is not found	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Foodiewheel | Custom wheel | What shall we eat today?</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<!-- meta info -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta itemprop="image" content="images/foodie_favicon.png">
<meta name="description" content="What shall we eat today? Have fun spinning the foodiewheel to decide what to eat everyday.">
<meta name="keywords" content="foodiewheel, food, nutrition, healthcare, choices, what, shall, we, eat, today">
<link rel='shortcut icon' href='images/foodie_favicon.png' />

<!-- facebook meta tags -->
<meta property="og:title" content="foodiewheel" />
<meta property="og:type" content="activity" />
<meta property="og:description" content="What shall we eat today? Have fun spinning the foodiewheel to decide what to eat everyday." />
<meta property="og:url" content="http://www.foodiewheel.in/customWheel.php" />
<meta property="og:site_name" content="Foodiewheel" />
<meta property="fb:admins" content="500073300" />
<meta property="og:image" content="http://www.foodiewheel.in/images/foodielogo.jpg" />

<!-- javascripts -->
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

var foodChoices = [ 

<?php
/*  obtain menu items from the submitted form */
foreach ($wheel as $key => $value) 
{
	$pattern = '/^item_/';
	if(preg_match($pattern,$key) and strlen($value) != 0)
	{
		echo '"'.$value.'",'; 
	}
}
	echo "];";
?>			   
			   				   
</script>
<?php include_once("analytics.php") ?>
<!--[if IE]><script src="excanvas.js"></script><![endif]-->
<script type="application/javascript" src="mealwheel.js"></script>
<script type="text/javascript" src="../jquery/jquery-1.7.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		
		//initializing the wheel with default choices;
		numChoices = foodChoices.length;
		arc = Math.PI / (numChoices/2);
		drawRouletteWheel();
		
		//spin_button event
		$('#spin_button').click(function() {
			spin();
			$.post("addSpins.php",{pagename:"customwheel"});
  			_gaq.push(['_trackEvent', 'wheelspin', 'spin']);
		});
				
	});
	

</script>
</head>
<body>
<p align="center" class="style1">What shall we <span class="style3">eat</span> today?<br/>
<div class="container_12" align="center" style="margin-bottom:15px;">
  <div class="grid_12">
Let the <span class="style3 bold-weight">foodiewheel</span> help you decide what to eat.<br/><span class="style3 bold-weight">Spin</span> it. <span class="style3 bold-weight">Save</span> it. <span class="style3 bold-weight">Share</span> it.
</div>

</div>
<div class="container_12" style="border:0px solid #ccc">
		<div class="grid_3" style="border:0px solid #ccc">        
         <p><span class="bold-weight">Like this foodiewheel? Share it</span> with friends. </p>
            
        <!-- start facebook code -->
        <div id="fb-root"></div>
        <script>
		window.fbAsyncInit = function() {
		FB.init({appId: '395538253791057', status: true, cookie: true,
		xfbml: true});
		
		FB.Event.subscribe('edge.create',
			function(response){				
			//analytics tracking
  			_gaq.push(['_trackEvent', 'FB_Like', 'wheel_name','<?php echo $wheel["wheelName"]; ?>']);

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

        <div class="fb-like" data-href="http://www.foodiewheel.in/customWheel.php?id=<?php echo $wheelId; ?>" data-send="true" data-layout="button_count" data-width="20" data-show-faces="false" data-font="tahoma"></div>
        <!-- end facebook code -->
     
        <!-- start twitter code -->
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="Nice foodiewheel. Hoho!" data-via="foodiewheel" data-hastags="food">Tweet it</a>
		<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
        <!-- end twitter code -->

		<br />
        <br/>
        <hr class="underline" />
        <br/>
          
		<form id="build_wheel_form" method="post" action="cuisineChoose.php">
        	<button class="green_round_button small_button">Build your own foodiewheel</button>
		</form>
        
        <br/>
        <p style="padding:0 0 0 30px; font-weight:bold;">OR</p>
		
        <!-- search wheel form -->
        <span class="bold-weight">Search more wheels:</span> 
		<form id="searchWheelForm" method="post" action="searchWheel.php">
	    	<input type="text" id="searchWheelInput" name="searchWheelInput" placeholder="Wheel Name" title="Choose name of the wheel to search" pattern=".{3,}" width="200" required/><br/ >
			<button class="green_round_button small_button">Search</button>              
		</form>
            
  </div>
		<div class="grid_1 divider">&nbsp;</div>
		<div class="grid_6" style="border:0px solid #ccc">
			<div align="center">
	        <div id="wheelname_banner" style="font-size:large; font-weight:bold;"><?php echo $wheel["wheelName"]; ?></div>
              <?php
			  if($wheel == NULL) //wheel not found
			  {	echo '<p style="font-weight:bold; font-size: large; color:red;">Oops! The foodie-wheel\'s run away!</p>'; }
			  else {?>
			  <input type="button" id="spin_button" value="click to spin >>" class="green_round_button small_button"/>
			  <canvas id="mealwheel" width="450" height="450">	
			  </canvas>
              <?php } ?>
		    </div>
		</div>
		<div class="clear"></div>

		<!-- footer begins -->
        <div id="footer" class="grid_12">
       		<hr class="footerline">
        	<div class="pull_center"><a class="footerlinks" href="mealwheel.php">home</a> | <a class="footerlinks" href="why.html">why</a> | <a class="footerlinks" href="what.html">what</a> | <a class="footerlinks" href="who.html">who</a> | <a class="footerlinks" href="/blog">blog</a></div> 
            <p>&nbsp;</p>
		   <div id="copyright_note" class="pull_center small_grey_label">Copyright (c) 2012 VV&GG </div>	 
        </div>        
</div>
</body>
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Foodiewheel | Custom wheel | What shall we eat today?</title>

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
<meta property="og:url" content="http://www.foodiewheel.in/updateWheel.php" />
<meta property="og:site_name" content="Foodiewheel" />
<meta property="fb:admins" content="500073300" />
<meta property="og:image" content="http://www.foodiewheel.in/images/images/foodielogo.jpg " />

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
foreach ($_POST as $key => $value) 
{
	echo '"'.$value.'",'; 
}
	echo "];";
?>			   
			   				   
</script>
<?php include_once("analytics.php"); ?>
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
			$.post("addSpins.php",{pagename:"updatewheel"});
			_gaq.push(['_trackEvent', 'wheelspin', 'spin']);

		});
		
		$("#custom_name").keyup(function() {
			
			//enable name saving if character length is more than 2
			if($(this).val().length >= 3)
			{
				$("#save_wheel").removeClass("inactive_button");
				$("#save_wheel").attr("disabled",false);
			}
			if($(this).val().length < 3)
			{
				$("#save_wheel").addClass("inactive_button");
				$("#save_wheel").attr("disabled",true);
			}
						
			//show wheelname_banner
			$("#wheelname_banner").show();
			$("#wheelname_banner").html($(this).val());
		});
		
		$("#customname_form").submit(function() {
						
				//submit form to store custom wheel + items
				$.post("saveWheel.php",{wheelName: $("#custom_name").val(),<?php				
				/* build menu items into the saveWheel form submission */
				foreach ($_POST as $key => $value) 
				{
					echo $key.':"'.$value.'",'; 
				}
				echo '},'
				?> function(data){
					if(data == 0) {
						//issues with storing
						$("#save_notification").html("Error! Boohoo. I'm so pained.");
						$("#save_notification").addClass("red_color");
						$("#save_notification").show("fast").delay(2000).hide("slow");													
					}
					else{ 				
					//show save is complete
					$("#save_notification").show("fast").delay(1000).hide("slow");
					
					//refresh to load custom wheel id page
					document.location.href = "http://www.foodiewheel.in/customWheel.php?id="+data;	
					}
				});
			return false;				
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

		<!-- starting the custom wheel name + save form -->
        <form method="post" action="" id="customname_form">		
			Name your foodiewheel:<br/>
			<span class="bold-weight">
            <input type="text" id="custom_name" size="30px" maxlength="25" placeholder="Name (atleast 3 chars)" title="Name your foodie-wheel" pattern=".{3,}" required/>
			</span>		
			<br/>
        <span class="small_grey_label">E.g. "Maya's wheel"</span> 
            <br/>
		  <button type="submit" id="save_wheel" value="save wheel" class="green_round_button small_button inactive_button" disabled="true">save wheel</button>
        
         <div id="save_notification" style="display:none; font-size:small; color:green;">Saved!</div>
        </form>

        <br/>
        <hr class="underline" />
         <br/>
         <p><span class="bold-weight">Share your foodiewheel</span> with friends. Help them find new eats.</p>
            
        <!-- start facebook code -->
        <div id="fb-root"></div>
        <script>
		window.fbAsyncInit = function() {
		FB.init({appId: '395538253791057', status: true, cookie: true,
		xfbml: true});
		
		FB.Event.subscribe('edge.create',
			function(response){
				//analytics tracking
  				_gaq.push(['_trackEvent', 'FB_Like', 'wheel_name','"'+$("#custom_name").val()+'"']);
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

        <div class="fb-like" data-send="true" data-layout="button_count" data-width="20" data-show-faces="false" data-font="tahoma"></div>
        <!-- end facebook code -->
     
        <!-- start twitter code -->
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="Nice foodiewheel. Hoho!" data-via="foodiewheel" data-hastags="food">Tweet it</a>
		<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
        <!-- end twitter code -->
                   
  </div>
		<div class="grid_1 divider">&nbsp;</div>
		<div class="grid_6" style="border:0px solid #ccc">
			<div align="center">
	        <div id="wheelname_banner" style="display:none; font-size:large; font-weight:bold;"></div>

			  <input type="button" id="spin_button" value="click to spin >>" class="green_round_button small_button"/>
			  <canvas id="mealwheel" width="450" height="450">	
			  </canvas>
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
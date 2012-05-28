<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>Foodiewheel | Search wheels | What shall we eat today?</title>

<!-- meta info -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta itemprop="image" content="images/foodie_favicon.png">
<meta name="description" content="What shall we eat today? Have fun spinning the foodiewheel to decide what to eat everyday.">
<meta name="keywords" content="foodiewheel, food, nutrition, healthcare, choices, what, shall, we, eat, today">
<link rel='shortcut icon' href='images/foodie_favicon.png' />

<!-- CSS & Javascript headers -->
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
<script type="text/javascript" src="../jquery/jquery-1.7.min.js"></script>
<script type="text/javascript">	

	$(document).ready(function(){
		
	});
	
</script>
<?php include_once("analytics.php") ?>
</head>
<body>

<!-- standard header -->
<p align="center" class="style1">
<p align="center" class="style1">What shall we <span class="style3">eat</span> today?<br/>
<p align="center">Let the <span class="style3 bold-weight">mealwheel</span> help you decide what to eat.<br/><span class="style3 bold-weight">Spin</span> it. <span class="style3 bold-weight">Save</span> it. <span class="style3 bold-weight">Share</span> it. </p>

<!-- body container -->
<div class="container_12" style="border:0px solid #ccc">
		<div id="top_grid" class="grid_12" style="border:0px solid #ccc">        
        <!-- top grid with search input -->
        
            <form id="searchWheelForm" method="post" action="searchWheel.php">
                <label class="bold-weight">Search custom foodie-wheels</label>
                <br />
              <input type="text" id="searchWheelInput" name="searchWheelInput" placeholder="Wheel Name" title="Choose name of the foodie-wheel" pattern=".{3,}" width="600" class="input_super_large" required/>
              <button class="green_round_button small_button">Search</button>
            </form>
        
		</div>

        <div id="bottom_grid" class="grid_12">
        <!-- bottom grid with search results -->
        <p class="bold-weight" style="margin-bottom:0px;">Matching foodie-wheels </p>
            <hr class="underline greyline" />
			
            <div id="result_display_1" class="grid_5">
            
            <!-- code to retrieve search display here -->
            <?php
				include_once("codes/masterfunctions.php");

				$searchInput = $_POST["searchWheelInput"];
				
				/* note: wheelLinks is an array of links to wheel-pages with (key = wheelName, value = wheelLink) */
				$wheelLinks = searchWheel($searchInput);
			?>

            <!-- code to display retrieved search results here -->          
            <?php			
				if($wheelLinks == NULL) //no matching wheel found: returns NULL
				{
					echo '<p style="color:grey; font-size:small;">Sorry. No wheel found matching your search input</p>';
				}
				else
				{
					$linksCount = count($wheelLinks); //number of links
					echo '<p>';
					$wheelNum = 0;
					foreach($wheelLinks as $key=>$value)
					{
						$wheelNum++;
						echo $wheelNum.'. <a style="text-decoration:underline" href="'.$value.'">'.$key.'</a><br />';
					}
					echo '</p>';
					echo '<p style="font-size:small; color:grey">(Click to see custom wheel)</p>';
				}			
			?>
            
            </div>
            <div id="result_display_2" class="grid_5">
			<p><!--test --></p>
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
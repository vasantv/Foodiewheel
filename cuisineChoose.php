<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Foodiewheel | Choose your cuisine | What shall we eat today?</title>

<!-- meta info -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta itemprop="image" content="images/foodie_favicon.png">
<meta name="description" content="What shall we eat today? Have fun spinning the foodiewheel to decide what to eat everyday.">
<meta name="keywords" content="foodiewheel, food, nutrition, healthcare, choices, what, shall, we, eat, today">
<link rel='shortcut icon' href='images/foodie_favicon.png' />

<!-- stylesheets -->
<link rel="stylesheet" href="960.css" media="all" type="text/css">
<link rel="stylesheet" href="designCSS.css" media="all" type="text/css">
<script type="text/javascript" src="../jquery/jquery-1.7.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		var items_array = new Array();
		var items_added = 1;
		
		$('#add_item_button').click(function() {

			var input_text = $('#item_choice').val();
			if (input_text == "") //a basic validation
			{
				return true;
			}
					
			if(items_added > 10) 
			{ 
				alert("Maximum 10 items added. Delete some!");	
			}

			var row_id = "#row_" + items_added;
			$(row_id).find('td:nth-child(2)').html(input_text);
			
			//store items in an array, for ease in any subsequent removal
			items_array[items_added] = input_text;  //check syntax		

			items_added = items_array.length;
			
			//clear the input box
			$('#item_choice').val("");		

		});
		
		$('.minus_button').click(function() {
					
			//find row id code here
			var remove_id = $(this).attr("id").substr(16);
						
			//remove item from items array
			items_array.splice(remove_id,1);
			items_added = items_array.length;
			
			//correct the array	display		
			for (row_num = remove_id; row_num<=items_array.length; row_num++)
			{				
				var row_id = "#row_" + row_num;
				$(row_id).find('td:nth-child(2)').html(items_array[row_num]);
			}

			//clear the rest of the display elements
			for (row_num = items_array.length; row_num<=10; row_num++)
			{
				var row_id = "#row_" + row_num;
				$(row_id).find('td:nth-child(2)').html("");					
			}
			
		});

		$('#item_choice').keypress(function(e) {
			//catching the 'enter' key press in the item choice box
			if(e.which == 13) {	
				$('#add_item_button').click();
				return false;
			}
		});
		
		//auto-complete of the input_box items
		/* server-side code loading */
		
		var availableItems;
		/*
		$.get('availableItems.txt', function (data) {
			availableItems = $.csv()(data);
		});
		*/
		
		/* local system alternative for debugging */
/*		availableItems = [ 
		"Idli", 
		"Dosa", 	
		"Upma" 
		];*/
				
		$('#item_form').submit(function(){

			//adding the selected items to the item form			
			for (i in items_array)
			{
				input = $("<input>").attr("type","hidden").attr("name","item_"+i).val(items_array[i]);
				$(this).append($(input));
			}
			return true;
		});
			
	});
	
</script>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	font-weight: bold;
	color: #999999;
}

.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 28px;
	font-weight: bold;
	color: #999999;
}

.style3 {color: #000000}
.white-color {color:white;}
.style9 {font-size: 24px}
-->
</style>
<?php include_once("analytics.php") ?>
</head>
<body>

<div class="container_12">
	<div class="grid_10">
		<p align="center" class="style1"><span class="style3">Choose</span> your <span class="style3">cuisine</span> options</p>
		<p align="center" class="style2">What shall we <span class="style3">eat</span> today?</p>
    </div>

	<div class="grid_12">
    	<form method="post" id="item_form" action="updateWheel.php">
    	<span class="bold-weight">Choose </span>items to create your own meal-wheel:<br/><br/>
        <table width="75%">
        <tr>
   		 <td width="17%">Meal item:</td><td width="64%"><input type="text" id="item_choice" size="50" class="ui-autocomplete-input"/>&nbsp;<span align="center" class="plus_button" id="add_item_button">+</span></td>
   		 <td width="19%" rowspan="2"><button type="submit" class="green_round_button small_button">Update wheel</button></td>
        </tr>
        <tr>
         <td>&nbsp;</td><td><span class="small_grey_label">E.g., "Pongal"</span></td>
         </tr>
        </table>
     	</form>
	</div>
	<div class="grid_12">
		<table width="50%" height="300" border="0" align="left" id="choice_table">
			<tr id="row_1">
			  <td width="4%"><div align="center" class="style9">1</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_1">-</span></td>
			</tr>
			<tr id="row_2">
			  <td width="4%"><div align="center" class="style9">2</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_2">-</span></td>
			</tr>
			<tr id="row_3">
			  <td width="4%"><div align="center" class="style9">3</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_3">-</span></td>
			</tr>
			<tr id="row_4">
			  <td width="4%"><div align="center" class="style9">4</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_4">-</span></td>
             </tr>
			<tr id="row_5">
			  <td width="4%"><div align="center" class="style9">5</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_5">-</span></td>
             </tr>
			<tr id="row_6">
			  <td width="4%"><div align="center" class="style9">6</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_6">-</span></td>
			</tr>
			<tr id="row_7">
			  <td width="4%"><div align="center" class="style9">7</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_7">-</span></td>
			</tr>
			<tr id="row_8">
			  <td width="4%"><div align="center" class="style9">8</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_8">-</span></td>
			</tr>
			<tr id="row_9">
			  <td width="4%"><div align="center" class="style9">9</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_9">-</span></td>
			</tr>
			<tr id="row_10">
			  <td width="4%"><div align="center" class="style9">10</div></td><td class="outerbox" width="86%"></td><td width="10%">&nbsp;<span class="minus_button" id="rem_item_button_10">-</span></td>
			</tr>
	  </table>	
	</div>
		<!-- footer begins -->
        <div id="footer" class="grid_12">
		    <p>&nbsp;</p>    
       		<hr class="footerline">
        	<div class="pull_center"><a class="footerlinks" href="mealwheel.php">home</a> | <a class="footerlinks" href="why.html">why</a> | <a class="footerlinks" href="what.html">what</a> | <a class="footerlinks" href="who.html">who</a> | <a class="footerlinks" href="/blog">blog</a></div>
           <p>&nbsp;</p>
		   <div id="copyright_note" class="pull_center small_grey_label">Copyright (c) 2012 VV&GG </div>  
        </div>
</div>
</body>
</html>
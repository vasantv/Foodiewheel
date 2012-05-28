<?php include("codes/masterfunctions.php"); ?>
<?php
	//store post values into local variables
	$wheelName=$_POST["wheelName"];
	
	$pattern = '/^item_/';
	$numitems = 0;
	foreach ($_POST as $key => $value)
	{
		if(preg_match($pattern,$key) == 1) //if there is a match on the item_* pattern
		{
			$items[$numitems] = $value;
			$numitems = $numitems +1;
		}
	}
	
	$wheelId = storeWheel($wheelName,$items);
	//if inserting the wheel into database succeeds
/*	if($wheel
	{	
		//confirm back that the wheel has been stored Ok
		echo 1;  
	}
	else { echo 0; }
*/
	echo $wheelId;
?>
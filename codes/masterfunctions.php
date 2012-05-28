<?php 

/*
	Master functions available
	dbConnect() - connects to 'saapad' database; returns the connection
	userLogin() - validates username and password, and creates a user login session; returns true to success
	userLogout() - destroys the user sesssion

*/


/* master variables */
$hostname = "localhost";
$dbUser = "saapaduser";
$dbPass = "saapad123"; 
$dbName = "saapad";

/* Objective: connect to master database
	Inputs: None
	Returns: Connection to database */
function dbConnect()
{
	global $hostname,$dbUser,$dbPass,$dbName;

    $con = mysql_connect($hostname,$dbUser,$dbPass) or die ("Couldn't connect to database!");
    mysql_select_db($dbName,$con) or die ("Couldn't select database $dbName!");

	return ($con);
}

/* Objective: validate user login and create a user session
	Inputs: $user- username, $pass - user provided password
	Returns: true - if valid, false - if invalid
*/
function userLogin ($user,$pass)
{
  //connect to database
  $con = dbConnect();

   //confirm user validity in database
  $loginTable = "userDb";
  
  $query = "SELECT * FROM $loginTable WHERE user='$user' AND pass='$pass'";
  $result = mysql_query($query,$con);
  if (!$result)
  {
    die('Error: ' . mysql_error());
    mysql_close ($con);
  }
  if(mysql_num_rows($result)==1) //successful user login
  {
    mysql_close($con);

    //register session variables
    session_start();

    //register user session
    $_SESSION['user'] = $user;

	return true;
	
  }
  else
  	return false;
}

/* Objective: destroy's session and logs user out
	Inputs: nothing
	Returns: nothing
*/
function userLogout()
{
	$_SESSION['user'] = "";
	session_destroy();
}

/* Objective: Insert an email id into the alpha_requests table
	Inputs: email id
	Returns: true - if insert succeeds, false - if insert fails
*/
function insertAlpha ($emailId)
{
  //connect to database
  $con = dbConnect();

  //alpha table
  $alphaTable = "alpha_requests";
  
  /*construct query and run into database*/ 
  $query = "INSERT INTO $alphaTable (`email`) VALUES ('$emailId')";
  $result = mysql_query($query,$con);
  if (!$result) 
  {
    print('Error: ' . mysql_error());
    mysql_close ($con);
	return false;
  }
  return true;	
}

/* Objective: Send an email to the given emailId(s) with the provided subject and message
	Inputs: emailId(s), subject, message
	Returns: true - if send succeeds, false - if send fails
*/
function sendMail($to, $subject, $message)
{
	/* code credits: http://www.alexkorn.com/blog/2011/04/sending-email-aws-php-with-amazonses/ */
	
	//include the PHP SDK
	include_once("/home/ec2-user/AWSSDKforPHP/sdk.class.php");
	
	//defining the email variables and the validations
	$AWS_SES_FROM_EMAIL = "hoohaafolk@gmail.com";
	
	$amazonSES = new AmazonSES();
 
    $response = $amazonSES->send_email($AWS_SES_FROM_EMAIL,
        array('ToAddresses' => array($to)),
        array(
            'Subject.Data' => $subject,
            'Body.Text.Data' => $message,
        )
    );
    if (!$response->isOK())
    {
        // handle error
		return false;
    }
	return true;
}

/* Objective: Store the custom wheel into the database
	Inputs: wheel name and items array
	Returns: true - if store succeeds, false - if store fails
*/
function storeWheel($wheelName, $items)
{
  //connect to database
  $con = dbConnect();

  //wheel table
  $wheelTable = "wheel_store";
  
  /*construct query and run into database*/
  //add slashes to ensure no sql errors where needed
  $wheelName = addslashes($wheelName); 
  
  //construct a random 5 digit number as wheel-id
  $wheelId = mt_rand( 10000, 99999 );
 
  $query = "INSERT INTO $wheelTable VALUES ('$wheelId','$wheelName'";
  
  for ($i = 0; $i<10; $i++)
  {
	  $items[$i] = addslashes($items[$i]);
	  $query = $query.",'".$items[$i]."'";
  }
  $query = $query.")";
  
  
  $result = mysql_query($query,$con);
  if (!$result) 
  {
    error_log('Error: ' . mysql_error());
	return 0;
  }
  mysql_close ($con);
  return $wheelId;	
}

/* Objective: Search for a custom wheel from the database
	Inputs: search pattern of meal wheel name
	Returns: Array of links with (key = wheelName, value = wheelLink); NULL if none found
*/
function searchWheel($searchPattern)
{
  //connect to database
  $con = dbConnect();

  //wheel table
  $wheelTable = "wheel_store";
  
  /*construct query and run into database*/
  $query = "SELECT * FROM $wheelTable WHERE wheelName LIKE '%".$searchPattern."%'";
  $result = mysql_query($query,$con);
  if (!$result)
  {
    die('Error: ' . mysql_error());
  }
  mysql_close($con);
  
  if(mysql_num_rows($result)==0) //no matches
  {	  
	return NULL;
  }
  elseif(mysql_num_rows($result)>0) //matches exist
  {
     //construct links array
	 $customWheelPath = "http://www.foodiewheel.in/customWheel.php";
	 while($row = mysql_fetch_array($result))
	 {
		 $linksArray[$row["wheelName"]] = $customWheelPath."?id=".$row["wheelId"];		 
	 }
	 return $linksArray;
  }
}

/* Objective: Get wheel items based on a custom wheel Id
	Inputs: wheelId of the custom saved wheel
	Returns: Returns the wheel; NULL if wheelId is not found
*/
function getWheel($wheelId)
{
  //connect to database
  $con = dbConnect();

  //wheel table
  $wheelTable = "wheel_store";
  
  /*construct query and run into database*/
  $query = "SELECT * FROM $wheelTable WHERE wheelId='".$wheelId."'";
  $result = mysql_query($query,$con);
  if (!$result)
  {
    die('Error: ' . mysql_error());
  }
  mysql_close($con);
  
  if(mysql_num_rows($result)==0) //no matches
  {	  
	return NULL;
  }
  elseif(mysql_num_rows($result)>0) //matches exist
  {
     //construct the items array
	 $row = mysql_fetch_array($result);
	 foreach($row as $key=>$value)
	 {
		if($value != "") {
		$itemsArray[$key] = $value; }
	 }
	 return $itemsArray;
  }
}

/* Objective: Store spins of the wheel into the database
	Inputs: none - name of the page
	Returns: true - none (internal error reporting)
*/
function newSpin($pageName)
{
  //connect to database
  $con = dbConnect();

  //wheel table
  $spinTable = "wheelSpins";

  $query = "SELECT * FROM $spinTable WHERE pageName='$pageName'";
  $result = mysql_query($query,$con);  
  $row = mysql_fetch_array($result);
  $counter = $row["spinVal"];
  $counter = $counter+1;

  $query = "UPDATE $spinTable SET spinVal=$counter WHERE pageName='$pageName'"; 
  $result = mysql_query($query,$con);    
  mysql_close($con);
  return $query;
}

?>
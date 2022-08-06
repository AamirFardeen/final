
<?php

$host = "localhost";
$username = "n0889143";
$password = "aHb890zh";
$db = "m_itec30151_n0889143";

 
$con = mysqli_connect($host, $username, $password, $db);

if(mysqli_connect_errno() )
	{  
	echo "Failed to connect to MySQL: " . mysqli_connect_error();  
	}

else    {  
	echo "Success";
	} 

?>






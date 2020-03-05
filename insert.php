<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

if (!empty($name)|| !empty($email) || !empty($subject) || !empty($message)){
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname  = "myweb";

	//creating connection 

	$conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

	if (mysqli_connect_error()){
		die('Connection Error('.mysqli_connect_error().')'. mysqli_connect_error());
	}else{
		$SELECT = "SELECT email From user_info Where email = ? Limit 1 "; 
		$INSERT = "INSERT Into user_info (name,email,subject,message) values (?, ?, ?, ?)";

		//Prepare statement

		$stmt = $conn->Prepare($SELECT);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if ($rnum == 0 ) {
			$stmt->close();

			$stmt = $conn->Prepare($INSERT);
			$stmt->bind_param('ssss',$name,
				$email,$subject,$message);
			$stmt->execute();
			echo "Thankyou for submitting the form";
		}
		else
		{
			echo "This email is already used";
		}
		$stmt->close();
		$conn->close()''

	}


}
else
{
	echo "All field are required";
	die();
}
?> 	
</body>
</html>
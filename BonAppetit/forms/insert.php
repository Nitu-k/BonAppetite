<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];


if(!empty($name) || !empty($email) || !empty($phone) || !empty($message))
{	
	$dbhost = 'localhost:3306';
	$username = 'root';
	$password = 'root';
	$dbselect = "demo";
	
	$conn = new mysqli($dbhost, $username, $password, $dbselect );

	if(mysqli_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	} else {

		$SELECT = "SELECT email From shared_receipe Where email = ? Limit 1";
		$INSERT = "INSERT into shared_receipe (name, email, phone, message) values(?, ?, ?, ?)";

		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$rnum = $stmt->num_rows;
       
	   if($rnum==0) {
	   	   $stmt->close();

		   $stmt = $conn->prepare($INSERT);
		   $stmt->bind_param("ssis", $name, $email, $phone, $message);
		   $stmt->execute();
		   echo " Your Receipe is submitted";
		} else {
			echo "Somebody already submitted with this email";
		}
		$stmt->close();
		}

} else {
	echo " All fields are required";
	die();
}

?>

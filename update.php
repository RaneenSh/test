<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "task2";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$fname = $_POST['first'];
	$lname = $_POST['last'];
	$city = $_POST['city'];
	$gender = $_POST['gender'];
	echo $gender;
	if(isset ($_POST['update'])){
		echo "The account created successfully<br>";
		
		$stmt = $conn->prepare("UPDATE  signup SET first_name = ?, last_name = ?, city = ?, gender = ? WHERE id = ?");
		$pass = $_SESSION['password'];
		$password = crypt($pass, 123);
		echo $_SESSION['password'];
		$stmt->bind_param("sssss", $fname, $lname, $city, $gender, $_SESSION['id']);
		$stmt->execute();

		$stmt->close();
	}
	
$referrer = $_SERVER['HTTP_REFERER']; 

header ("Refresh: 0;URL='$referrer'"); 
}
echo '<script language="javascript">';
		echo 'alert("account successfully updated")';
		echo '</script>';
?>

<!DOCTYPE HTML>
	<html> 
	<body>
<form action="C:\wamp64\www\test1\PersonalInfo\PersonalInfo.php" method="post">
	<input type = "submit" value = "Back">
	</form>
	<br>
	
	</body>
	</html>

	
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
	function GetImageExtension($imagetype){
		if(empty($imagetype)) return false;
		switch($imagetype){
           case 'image/bmp': return '.bmp';
           case 'image/gif': return '.gif';
           case 'image/jpeg': return '.jpg';
           case 'image/png': return '.png';
           default: return false;
		}
    }
	
	if (!empty($_FILES["uploadedimage"]["name"])) {
		$file_name=$_FILES["uploadedimage"]["name"];
		$temp_name=$_FILES["uploadedimage"]["tmp_name"];
		$imgtype=$_FILES["uploadedimage"]["type"];
		$ext= GetImageExtension($imgtype);
		$imagename=$_FILES["uploadedimage"]["name"];
		$target_path = "images/".$imagename;
		if(move_uploaded_file($temp_name, $target_path)) {
			$stmt = $conn->prepare("UPDATE  signup SET images_path = ? WHERE password = ?");
			$pass = $_SESSION['password'];
			$password = crypt($pass, 123);
			$stmt->bind_param("ss", $target_path, $password);
			$stmt->execute();
		}	
	}
	else{
		exit("Error While uploading image on the server");
	}
	header('Location: PersonalInfo.php');
}
	
?>
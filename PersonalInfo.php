
<!DOCTYPE HTML>
<html>  

	<head>
	<style>
	div{
		margin: auto;
		margin-top: 0px;
		margin-left: 0px;
	}
	#f{
		width:300px;
		margin: auto;
		margin-top: 10px;
		border: 1px solid black;
		padding: 50px 30px 50px 80px;
	}
	</style>
	</head>
	<body>
	<div align="center" border ="1px solid">
	
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
	$_SESSION['i'] = 0;
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $_POST['password'];
	}
	$stmt = $conn->prepare('SELECT * FROM signup WHERE email = ?');
	$stmt->bind_param('s', $_SESSION['email']);
	$stmt->execute();
	$result = $stmt->get_result();
	if(count($result)){
		while ($row = $result->fetch_assoc()) {		
			if(crypt($_SESSION['password'], 123) == $row["password"] && $row["email"] == $_SESSION['email']) {
				global $first;
				global $last;
				global $city;
				global $gender;
				global $image;
				$last = $row['last_name'];
				$first = $row['first_name'];
				$city = $row['city'];
				$gender = $row['gender'];
				$image = $row['images_path'];
				$_SESSION['i'] = 1;
				echo "<p style = 'padding-top: 0px; padding-right: 30px; padding-bottom: 50px; padding-left: 80px;'>";
				echo "<p style = 'margin-left:1000px; margin-top:30;'>" . $first . " " . $last . "<br>";
				echo '<form action = "logout.php">
				<input style = "margin-left:1000px; margin-top:30;" name = "logout" type = "submit" value = "logout">
				</form></p>';
				echo '<img src="' . $image . '" style="width:250px;height:200px;">';
				echo "<div><h1>Personal Informaion</h1></div> <br>";
				echo '<form action = "update.php" method = "post">
				First Name:  <input name="first" value= '. $first.' type="text" > <br><br>
				Last Name: <input name = "last" value = '. $last .' type = "text"> <br><br>
				City: <select name="cars">
				<option value= ' . $city . ' >' . $city . ' </option>
				<option value="nablus">Nablus</option>
				<option value="jenin">Jenin</option>
				<option value="ramallah">Ramallah</option>
				</select><br><br>
				<br><br>';
				if ($gender == 'male'){
					echo'
					<input type="radio" name="gender" value="male" checked> Male
					<input type="radio" name="gender" value="female"> Female<br> 
					<br><br>';
				}
				elseif ($gender == 'female'){
					echo '<input type="radio" name="gender" value="male"> Male
					<input type="radio" name="gender" value="female" checked> Female<br> 
					<br><br>';
				}
				echo '<input type = "submit" name = "update" value = "update">';
				echo '<br><br></form>';
				echo '<form action="upload.php" method="post" enctype="multipart/form-data">
					  Select image to upload:<input name="uploadedimage" type="file"><br><br>
				      <input name="Upload Now" type="submit" value="Upload Image">
					  </form>';
				echo "</p>";
				break;
		
			}
		}
		if($_SESSION['i'] == 0){
			echo "the account is not exist";
			header('Location: login.php');
		}
	}		
	mysqli_close($conn);

?>

	<form action="http://localhost/test1/login.php" method="post">
	<input type = "submit" value = "Back">
	</form>
	
	</div>
	</body>
</html>


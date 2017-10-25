<!DOCTYPE HTML>
	<html>  
	<head>
	<style>
	div {
		width:300px;
		margin: auto;
		margin-top: 100px;
		border: 1px solid black;
		padding: 50px 30px 50px 80px;
	}
	</style>
	</head>
	<body>
	<div>
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	First name: <input type="text" name="first_name"><br><br>
	Last name: <input type="text" name="last_name"><br><br>
	E-mail: <input type="text" name="email"><br><br>
	Password: <input type = "password" name = "password"><br><br>
	Password confir: <input type = "password" name = "password_con"><br><br>
	City: <select name="cars">
    <option value="nablus">Nablus</option>
    <option value="jenin">Jenin</option>
    <option value="ramallah">Ramallah</option>
	</select>
	<br><br>
	<input type="radio" name="gender" value="male"> Male
    <input type="radio" name="gender" value="female"> Female<br>
    <br><br>
	<input type="submit" name = "submit"><br><br>
	</form>
	<br>
	<form action="task2.php" method="post">
	<input type = "submit" value = "Back">
	</form>
	<br>
	

	</div>
	</body>
	</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "task2";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$t = 0;
	if (isset($_POST["submit"])) {
		if (isset($_POST["gender"])){
			$fname = $_POST['first_name'];
			$lname = $_POST['last_name'];
			$email = $_POST['email'];
			$pass1 = $_POST['password'];
			$pass2 = $_POST['password_con'];
			$city = $_POST['cars'];
			$gender = $_POST['gender'];
			if ($pass1 != $pass2){
				echo"error in your password please try again<br>";
				$t = 1;
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo("$email is invalid email address");
				$t = 1;
			}
			
			$sql = "SELECT * FROM signup";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if ($row['email'] == $email){
						echo $row['email'] . $row['password'];
						$t=1;
						break;
					}
				}
			}
			if ($t == 0){
				$image = "images/defaultimage.jpg";
				$password = crypt($pass1, 123);
				if (crypt($pass1, $password) == $password) {
					$stmt = $conn->prepare("INSERT INTO signup (first_name, last_name, email, password, city, gender, images_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("sssssss", $fname, $lname, $email, $password, $city, $gender, $image);
					$stmt->execute();
					echo "The account created successfully<br>";
					echo '<script language="javascript">';
					echo 'alert("account successfully created")';
					echo '</script>';
					$stmt->close();
				}
			}
		}else{
			$t = 1;
			echo "you have to select a gender<br>";
		}			
	}
}

?>
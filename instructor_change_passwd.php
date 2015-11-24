<!DOCTYPE html> 


<html>
<head>

</head>


<body>
<p>Change Password</p>	
<form action="instructor_change_passwd.php" method="get">
	<label>Password
		<input type="password" name="password1"/><br>
	</label>
	<label>Password Again
		<input type="password" name="password2"/><br>
	</label>
	<input type="submit" name="submit" value="submit"/>

</form>

<?php
session_start();
if(isset($_SESSION["user_id"])) 
	$user_id=$_SESSION["user_id"];
else
	echo "Invalid User!";
$db_hostname='localhost';
$db_username='root';
$db_password='mysql';
$db_database='test';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){
	die(connect_error);
}
if(isset($_GET['submit'])){
	$password1=$_GET["password1"];
	$password2=$_GET["password2"];
	if(!empty($password1)&&!empty($password2)){
		if($password1==$password2){
			$query="update user_pwd set password='$password2' where user_id='$user_id'";
			$result=$connection->query($query);			
			$connection->commit();
			if($result){
				session_destroy();
				header('Location: index.html');				
			} else
				echo "Password not changed!";
			//sleep(5);
			
		}else{
			echo "Password not equal!";
		}
	}else{
		echo "Password can not be empty!";
	}
	

}


?>





</body>


</html>

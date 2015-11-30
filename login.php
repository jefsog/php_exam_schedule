<?php
session_start();
//require 'db_connect.php';
$username=$_GET["user_name"];
$password=$_GET["password"];
$db_hostname='localhost';
$db_username='root';
$db_password='';
$db_database='test';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){
	die(connect_error);
}
//echo "Connect sucessfully!";
$query="select * from user_pwd where name='$username' and password='$password'";
$result=$connection->query($query);

//print($result->num_rows);
$row_fetched=$result->num_rows;
//print_r($result->fetch_assoc()['usr_grp']);
if($row_fetched>0)
{//$result->fetch_assoc()['user_id'] can only be used once,after that, it loses all information.
	$fetched_row=$result->fetch_assoc();
	//print_r($fetched_row);
	
	$user_id=$fetched_row['user_id'];
	//print_r($result->fetch_assoc());
	$user_grp=$fetched_row['usr_grp'];
	$_SESSION["user_id"]=$user_id;
	$_SESSION["user_name"]=$username;
	$_SESSION["user_grp"]=$user_grp;
	
	
	if($user_grp=="instructor"){//instructor
		
		header('Location:instructor_exam_schedule.php');
	}else if($user_grp=="adm"){
		header('Location:admin_main.php');
	}else{
		//print_r($user_grp);
		header('Location: index.html');
	}
	
	
}
else
{
	echo "Invalid User!"."<br/>";
	echo "<a href='index.html'>Return</a>";
}

mysqli_close($connection);	



?>
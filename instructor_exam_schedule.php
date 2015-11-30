<!DOCTYPE html>
<html>

<head>
<title>View Current Schedule</title>
<style>
	body{
		background:#fff;
	}
	#main_container{
		width: 960px;
		margin-left: auto;
		margin-right: auto;
	}
	#header{
		position:relative;
		
	}
	#header #navigation{
		position: absolute;
		top:50px;
		left:400px;
	}
	#navigation ul li{
		float:left;
		list-style: none;
		margin-left: 10px
	}
	#navigation ul li a{
		
		display: block;
		width:110px;

		text-align: center;
	}


	#content{

		position:relative;
		top:70px;
		background-color:#ffc;
		
		
	}

	table, th, td{
		border:1px solid black;
		border-collapse: collapse;
		padding: 5px
	}

</style>

</head>

<body>
<div id="main_container">
	<div id="header">
		<h1>Current Schedule-By Jianfeng Song</h1>
		<div id="navigation">
			<ul>
				<li><a href="instructor_exam_schedule.php">My Schedule</a></li>
				<li><a href="instructor_set_schedule.php">Set Schedule</a></li>
				<li><a href="instructor_change_passwd.php">Change Password</a></li>
				<li><a href="logout.php">Log Out</a></li>
			</ul>

		</div>


	</div>
	<div id="content">
		<h2>To Schedule</h2>
		<table>
			<tr>
				<th>Course_Section_ID</th>
				<th>Course_Name</th>
				<th>Faculty_Name</th>
				
			</tr>
<?php
session_start();
if(isset($_SESSION["user_id"])) 
	$user_id=$_SESSION["user_id"];
else{
	echo "Invalid User!";
	
	header('Location: index.html');	
	return;
}
	


require_once 'db_connect.php';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){die(connect_error);}

$query="SELECT * FROM `course_sec` cs 
				JOIN user_pwd on cs.user_id=user_pwd.user_id 
				join course c on cs.c_id=c.c_id
				where (cs.user_id='$user_id' 
					and cs.c_sec_id NOT in (select exam.c_sec_id from exam))";

//$query="select * from course_sec where user_id='$user_id'";
$result=$connection->query($query);
//print_r($result);
$num_of_rows=$result->num_rows;
for($i=0;$i<$num_of_rows;$i++){
	$row=$result->fetch_assoc();
echo "<tr>
	<td>".$row['c_sec_id']."</td>
	<td>".$row['c_name']."</td>
	
	<td>".$row['name']."</td>
	
";


}
?>
			</tr>
		</table>
<h2>Already Scheduled</h2>	
<table>
			<tr>
				<th>Course Section_ID</th>
				<th>Course Name</th>
				<th>Faculty Name</th>
				<th>Date</th>
				<th>Time Period</th>
				<th>Class Room</th>
			</tr>
<?php

/*
$db_hostname='localhost';
$db_username='root';
$db_password='mysql';
$db_database='test';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){die(connect_error);}
*/
$query="select exam.c_sec_id, course.c_name, user_pwd.name, 
exam_date.exam_date, exam.time_slot, exam.room_id from exam
join exam_date on exam.exam_date=exam_date.date_id
join course_sec on exam.c_sec_id=course_sec.c_sec_id
join user_pwd on course_sec.user_id=user_pwd.user_id
join course on course_sec.c_id=course.c_id
where user_pwd.user_id='$user_id'";

//$query="select * from course_sec where user_id='$user_id'";
$result=$connection->query($query);
//print_r($result);
$num_of_rows=$result->num_rows;
for($i=0;$i<$num_of_rows;$i++){
	$row=$result->fetch_assoc();
echo "<tr>
	<td>".$row['c_sec_id']."</td>
	<td>".$row['c_name']."</td>
	
	<td>".$row['name']."</td>
	<td>".$row['exam_date']."</td>
	<td>".$row['time_slot']."</td>
	
	<td>".$row['room_id']."</td>
	
</tr>";
}
?>

		</table>		

	</div>
</div>
</body>

</html>
<?php 
session_start();
if($_SESSION['user_name']!="admin"){
//header('Location: logout.php');	
}
?>


<!DOCTYPE html>

<html>
<head>
<title>admin view schedule</title>

</head>

<body>

<div><a href="admin_main.php">Manage User</a></div>

<?php
require_once 'db_connect.php';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){die(connect_error);}
$query="select distinct(course.c_name) from exam
join course_sec on exam.c_sec_id=course_sec.c_sec_id
join course on course_sec.c_id=course.c_id";
$result_course_name=$connection->query($query);

$query="select distinct(user_pwd.name) from exam
join course_sec on exam.c_sec_id=course_sec.c_sec_id
join user_pwd on course_sec.user_id=user_pwd.user_id";
$result_faculty_name=$connection->query($query);
//print_r($result_faculty_name);

$query="select DISTINCT(exam_date.exam_date) from exam 
join exam_date on exam.exam_date=exam_date.date_id";
$result_date=$connection->query($query);

$query="select distinct(exam.room_id) from exam";
$result_room=$connection->query($query);

?>



<table>
	<form>
		<input type="submit" name="view" value="View"/>

		<tr>
			<th></th>
			<th>Course Section_ID</th>
			<th>
				<label>Course Name
					<select name="choose_course" size="1">
						<option value=""></option>
						<?php
						$num_of_rows=$result_course_name->num_rows;
						for ($i=0; $i<$num_of_rows; $i++) {
							# code...
							$row=$result_course_name->fetch_assoc();
							foreach ($row as $key => $value) {
								# code...
								echo "<option value=".$row['c_name'].">".$row[$key]."</option>";
							}
							
						}
						?>
						
					</select>
				</lable>
			</th>
			<th>
				<label>Faculty Name
					<select name="choose_faculty" size="1">
						<option value=""></option>
						<?php
						$num_of_rows=$result_faculty_name->num_rows;
						for ($i=0; $i<$num_of_rows; $i++) {
							# code...
							$row=$result_faculty_name->fetch_assoc();
							foreach ($row as $key => $value) {
								# code...
								echo "<option value=".$row['name'].">".$row[$key]."</option>";
							}
							
						}
						?>
						
					</select>
				</label>
			</th>
			<th>
				<label>Date
					<select name="choose_date" size="1">
						<option value=""></option>
						<?php
						$num_of_rows=$result_date->num_rows;
						for ($i=0; $i<$num_of_rows; $i++) {
							# code...
							$row=$result_date->fetch_assoc();
							foreach ($row as $key => $value) {
								# code...
								echo "<option value=".$row[$key].">".$row[$key]."</option>";
							}
							
						}
						?>
					</select>	
				</label>
			</th>
			<th>Time Period</th>
			<th>
				<label>Class Room
					<select name="choose_room" size="1">
						<option value=""></option>
						<?php
						$num_of_rows=$result_room->num_rows;
						for ($i=0; $i<$num_of_rows; $i++) {
							# code...
							$row=$result_room->fetch_assoc();
							foreach ($row as $key => $value) {
								# code...
								echo "<option value=".$row[$key].">".$row[$key]."</option>";
							}
							
						}
						?>
					</select>	
				</label>
			</th>
		</tr>
	</form>
<?php

if(isset($_GET['view'])){
	$query="select exam.c_sec_id, course.c_name, user_pwd.name, 
	exam_date.exam_date, exam.time_slot, exam.room_id from exam
	join exam_date on exam.exam_date=exam_date.date_id
	join course_sec on exam.c_sec_id=course_sec.c_sec_id
	join user_pwd on course_sec.user_id=user_pwd.user_id
	join course on course_sec.c_id=course.c_id";
	if(!empty($_GET['choose_course'])||!empty($_GET['choose_faculty'])||
		!empty($_GET['choose_date'])||!empty($_GET['choose_room'])){
		$query.=" where";
		$is_first=TRUE;
	}
	if(!empty($_GET['choose_course'])){
		if($is_first){
			$is_first=FALSE;
		}else{
			$query.=" and";
		}
		$query.=" course.c_name='".$_GET['choose_course']."'";
	}
	if(!empty($_GET['choose_faculty'])){
		if($is_first){
			$is_first=FALSE;
		}else{
			$query.=" and";
		}
		$query.=" user_pwd.name='".$_GET['choose_faculty']."'";
	}
	if(!empty($_GET['choose_date'])){
		if($is_first){
			$is_first=FALSE;
		}else{
			$query.=" and";
		}
		$query.=" exam_date.exam_date='".$_GET['choose_date']."'";
	}
	if(!empty($_GET['choose_room'])){
		if($is_first){
			$is_first=FALSE;
		}else{
			$query.=" and";
		}
		$query.=" exam.room_id='".$_GET['choose_room']."'";
	}
	//echo $query;
}else{
	$query="select exam.c_sec_id, course.c_name, user_pwd.name, 
	exam_date.exam_date, exam.time_slot, exam.room_id from exam
	join exam_date on exam.exam_date=exam_date.date_id
	join course_sec on exam.c_sec_id=course_sec.c_sec_id
	join user_pwd on course_sec.user_id=user_pwd.user_id
	join course on course_sec.c_id=course.c_id";
}

$result=$connection->query($query);
$num_of_rows=$result->num_rows;
for($i=0;$i<$num_of_rows;$i++){
	$row=$result->fetch_assoc();
	echo "<tr>";
	echo "<td>";
	echo "<form>";
	echo '<input type="submit" name="delete" value="Delete"/>';
	echo '<input type="hidden" name="c_sec_id" value="'.$row['c_sec_id'].'"/>';
	echo "</form>";
	echo "</td>";
	foreach ($row as $key => $value) {
		# code...
		
		echo "<td>".$row[$key]."</td>";
	}
	
	echo "</tr>";
}
?>
<?php
if(isset($_GET['delete'])){
	$query="delete from exam where c_sec_id='".$_GET['c_sec_id']."'";
	$result_delete=$connection->query($query);
	header("location:admin_view_schedule.php");
}

?>

</table>	
<div><a href="logout.php">Log Out</a></div>



</body>
</html>
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
		
	<?php
	session_start();
	if(isset($_SESSION["user_id"])) 
		$user_id=$_SESSION["user_id"];
	else
		echo "Invalid User!";


	require_once "db_connect.php";
	$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
	if($connection->connect_error){die(connect_error);}
	?>






		<form action="instructor_set_schedule.php" method="get">
			<?php if(isset($_GET['confirm_schedule'])) echo "hi";?>
			<fieldset>
			<legend>Choose Course, Date, Time Slot</legend>
			<label>Course:
			<select name='choose_course' size='1'>
				<?php //populate course needed to be schedule

				if(true || isset($_GET['confirm_schedule'])){
					$query="SELECT * FROM `course_sec` cs 
					JOIN user_pwd on cs.user_id=user_pwd.user_id 
					join course c on cs.c_id=c.c_id
					where (cs.user_id='$user_id' 
						and cs.c_sec_id NOT in (select exam.c_sec_id from exam))";
					//NOT need a bracket around the condition;
					$result=$connection->query($query);
					//print_r($result);
					$num_of_rows=$result->num_rows;
					for($i=0;$i<$num_of_rows;$i++){
						$row=$result->fetch_assoc();
					echo "<option value=".$row['c_name'].">".$row['c_name']."</option>";
					}
				}
				
				?>
			</select>
			</label>


			<label>Date:
			<select name='date' size='1'>
				<?php
				$query="SELECT * FROM `exam_date`";
				//$query="select * from course_sec where user_id='$user_id'";
				$result=$connection->query($query);
				//print_r($result);
				$num_of_rows=$result->num_rows;
				for($i=0;$i<$num_of_rows;$i++){
					$row=$result->fetch_assoc();
				echo "<option value=".$row['exam_date'].">".$row['exam_date']."</option>";
				}
				?>
			</select>
			</label>

			<label>Time Slot:
			<select name='time_slot' size='1'>
				<?php //populate user's time_slot list(keep a blank space after <?php)
				$query="SELECT * FROM `time_slot`";
				//$query="select * from course_sec where user_id='$user_id'";
				$result=$connection->query($query);
				//print_r($result);
				$num_of_rows=$result->num_rows;
				for($i=0;$i<$num_of_rows;$i++){
					$row=$result->fetch_row();
				echo "<option value=".$row[0].">".$row[0]."</option>";
				}
				?>
			</select>
			</label>


			
			<input type="submit" name="view_room" value="View Possible Room"/>
			</fieldset>

			

		</form>


		<form action="instructor_set_schedule.php" method="get">

		<fieldset>
			<legend>Choose Classroom</legend>
			<input type="text" name="course_name" 
			value="<?php if(isset($_GET['choose_course'])) echo $_GET['choose_course'];?>" readonly >
			<input type="text" name="exam_date" 
			value="<?php if(isset($_GET['date'])) echo $_GET['date'];?>" readonly >
			<input type="text" name="decided_time_slot" 
			value="<?php if(isset($_GET['time_slot'])) echo $_GET['time_slot'];?>" readonly >
			<fieldset>
				<legend>Available Room</legend>
				<?php //populate availabe room at selected time
				if(isset($_GET['choose_course'])&&isset($_GET['date'])
					&&isset($_GET['time_slot'])){
					$course=$_GET['choose_course'];
					$exam_date=$_GET['date'];
					$time_slot=$_GET['time_slot'];
					
					$query="select * from room 
							where (room.room_id not in 
							(select exam.room_id from exam 
							join exam_date on exam.exam_date=exam_date.date_id 
							where exam_date.exam_date='$exam_date' 
							and exam.time_slot='$time_slot') )";
					$result=$connection->query($query);
					$num_of_rows=$result->num_rows;
					
					for($i=0; $i<$num_of_rows; $i++){
						$row=$result->fetch_assoc();						
						echo '<input type="radio" name="availe_room" 
								value='.$row['room_id']. '>'.$row['room_id'].' <br/>';
						//can not use /> above after room_id, $_GET would read that / in		
					}
					
				
				}
				?>
				<!--
				<input type="radio" id="r1" name="cook-type" value="Lightly Cooked"/> Lightly Cooked<br/>
				<input type="radio" id="r2" name="cook-type" value="Normal" checked/> Normal<br/>
				<input type="radio" id="r3" name="cook-type" value="Extra Cooked"/> Extra Cooked<br/>-->
			</fieldset>
			<input type="submit" name="confirm_schedule" value="Confirm"/>
			<?php
			if(isset($_GET['confirm_schedule'])){
				if(isset($_GET['availe_room'])){
					$user_name=$_SESSION['user_name'];					
					$course=$_GET['course_name'];					
					$exam_date=$_GET['exam_date'];					
					$time_slot=$_GET['decided_time_slot'];
					//query has to use double quotation outside, and leave single used inside					
					$query="select course_sec.c_sec_id from course_sec 
    						join user_pwd on course_sec.user_id=user_pwd.user_id
    						join course on course_sec.c_id=course.c_id
    						where user_pwd.name='$user_name' and course.c_name='$course'";
    				$result=$connection->query($query);    								
    				$row=$result->fetch_assoc();
    				$course_section_id=$row['c_sec_id'];
    				
    				$query="select exam_date.date_id from exam_date where exam_date.exam_date='$exam_date'";
    				$result=$connection->query($query);    								
    				$row=$result->fetch_assoc(); 
    				$exam_date_id=$row['date_id'];
    				$room_id=$_GET['availe_room'];
    				
    				$query="INSERT INTO `exam` (`c_sec_id`, `room_id`, `exam_date`, `time_slot`) 
							VALUES (
							    '$course_section_id',
							    '$room_id',
							    '$exam_date_id',
							    '$time_slot')";
					$result=$connection->query($query);
					print_r($result);
					if($result)
						header('Location:instructor_exam_schedule.php');
				}else{
					echo "choose a room!";
				}				
			}

			?>
		</fieldset>


		
		
		</from>
	</div>
</div>
</body>

</html>
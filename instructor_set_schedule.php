<HTML>
<HEAD>
<TITLE>Set Course Schedule</TITLE>
<META content="Cutepage 2.0" name=GENERATOR></HEAD>
<META content="text/html; charset=iso-8859-1" http-equiv=Content-Type>
<STYLE type=text/css>
<!--
A:link {text-decoration:none; color:"#0000ff"}
A:visited {text-decoration:none}
A:hover {text-decoration:underline; color:"#FF0033"}

body { font-family:"Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt}

p {  font-family:"Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt}

td {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt}

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
		top:25px;
}

table, th, td{
		
		border-collapse: collapse;
		padding: 10px
}

.field_set{
    border-color:#35a8a5;
    border-style: solid;
	font-weight: bold;
	padding: 15px;
}
-->
</STYLE>
</HEAD>
<BODY background=./image/blackground.gif bgColor=#ffffff>
<TABLE border=0 cellPadding=0 cellSpacing=0 height=55 width=1175>
  <TR>
    <TD background=./image/top.gif colSpan=2 rowSpan=2>
      <DIV align=center><b><font color="#ffffcc" size="5" face="Arial, Helvetica, sans-serif">Exam Schedule</font></b></DIV>
	</TD>
    <TD bgColor=#00b2eb height=1 width=868><IMG height=1 src="./image/pixel.gif" width=1></TD>
  </TR>
  <TR>
    <TD bgColor=#ffffff vAlign=bottom>
      <DIV align=right></DIV>
	</TD>
  </TR>
</TABLE>
<TABLE width="1166" height="608" border=0 cellPadding=0 cellSpacing=0>
  <TR>
    <TD colSpan=2 height=24>&nbsp;</TD>
    <TD bgColor=#00b2eb rowSpan=9 width=10><IMG height=1 src="./image/pixel.gif" width=1> </TD>
    <TD rowSpan=6 width=10>&nbsp;</TD>
    <TD height=24 width=997>&nbsp;</TD>
  </TR>
  <TR>
    <TD colSpan=2 vAlign=top>
      <TABLE align=right border=0 cellPadding=4 cellSpacing=4 height=270 width=141>
        <TR bgColor=#29a8cd>
          <TD>
            <DIV align=center><B><a href="instructor_exam_schedule.php"><FONT color=#ffffff size=2>My Schedule</FONT></A></B></DIV>
		  </TD>
		</TR>
        <TR bgColor=#35a8a5>
          <TD>
            <DIV align=center><b><a href="instructor_set_schedule.php"><font color="#ffffff" size="2">Set Course Schedule</font></a></b></DIV>
		  </TD>
		</TR>
        <TR bgColor=#37a67c>
          <TD>
            <DIV align=center><b><a href="instructor_change_passwd.php"><font color="#ffffff" size="2">Change Password</font></a></b></DIV>
		  </TD>
		</TR>
        <TR bgColor=#339966>
          <TD>
			<DIV align=center><p><b><a href="logout.php"><font color="#ffffff" size="2">LOG OUT</font></a></b></p></DIV>
		  </TD>
        </TR>
      </TABLE>
      <P align=right>&nbsp;</P>
	</TD>
    <td width="997" valign="top"><p><div id="main_container">
	<div id="header">
		<h1>Set Course Schedule</h1>
	</div>
	<div id="content">		
		
	<?php
	ob_start();
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
			<fieldset class="field_set">
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

		<fieldset class="field_set">
			<legend>Choose Classroom</legend>
			<input type="text" name="course_name" 
			value="<?php if(isset($_GET['choose_course'])) echo $_GET['choose_course'];?>" readonly >
			<input type="text" name="exam_date" 
			value="<?php if(isset($_GET['date'])) echo $_GET['date'];?>" readonly >
			<input type="text" name="decided_time_slot" 
			value="<?php if(isset($_GET['time_slot'])) echo $_GET['time_slot'];?>" readonly >
			<fieldset class="field_set">
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
			</fieldset><br>
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
					echo "Please Choose a Room!";
				}				
			}
			?>
			</fieldset>
		</from>
	</div>
</div>
</p>
      </td>
  </tr>
  <tr> 
    <td colspan="2" rowspan="4">&nbsp;</td>
    <td width="997" valign="bottom" rowspan="4"> 
      <div align="right"> 
        <table width="480" border="0" cellspacing="0" cellpadding="0" height="29" background="image/button5.gif">
          <tr valign="top"> 
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div align="center"> </div>
    </td>
  </tr>
  <tr> </tr>
  <tr> </tr>
  <tr> </tr>
</table>
</body>
</html>
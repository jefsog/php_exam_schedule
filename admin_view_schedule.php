<HTML>
<HEAD>
<TITLE>Admin View Schedules</TITLE>
<META content="Cutepage 2.0" name=GENERATOR></HEAD>
<META content="text/html; charset=iso-8859-1" http-equiv=Content-Type>
<STYLE type=text/css>
<!--
A:link {text-decoration:none; color:"#0000ff"}
A:visited {text-decoration:none}
A:hover {text-decoration:underline; color:"#FF0033"}

body { font-family:"Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt}

p {  font-family:"Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt}

table {
	border-collapse: collapse;
}

td, th {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif";
	font-size: 9pt;
	padding: 10px;
    text-align: left;
}

.tableHeaders {
		background-color: #29a8cd;
		color: white;
}
-->

</STYLE>
</HEAD>
<BODY background=./image/blackground.gif bgColor=#ffffff>
<TABLE border=0 cellPadding=0 cellSpacing=0 height=55 width=1175>
  <TR>
    <TD background=./image/top.gif colSpan=2 rowSpan=2>
      <DIV align=center><b><font color="#ffffcc" size="5" face="Arial, Helvetica, sans-serif">Exam Schedule Admin</font></b></DIV>
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
            <DIV align=center><B><a href="admin_main.php"><FONT color=#ffffff size=2>User Management</FONT></A></B></DIV>
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
    <td width="997" valign="top"><p>
		<?php 
		session_start();
		if($_SESSION['user_name']!="admin"){
		//header('Location: logout.php');	
		}
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


<h2>View Schedule</h2>
	<table border="1">
		<form>
		<tr>
			<th class="tableHeaders"><input type="submit" name="view" value="Filter Results"/></th>
			<th class="tableHeaders">Course Section_ID</th>
			<th class="tableHeaders">
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
			<th class="tableHeaders">
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
			<th class="tableHeaders">
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
			<th class="tableHeaders">Time Period</th>
			<th class="tableHeaders">
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

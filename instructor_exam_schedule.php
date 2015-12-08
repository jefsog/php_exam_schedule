<HTML>
<HEAD>
<TITLE>My Schedule</TITLE>
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
	top: 25px;
	position:relative;
}

table, th, td{
	border-collapse: collapse;
	padding: 10px;
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
    <td width="997" valign="top">
		<p><div id="main_container">
				<div id="header">
					<h1>Current Schedule</h1>
				</div>
			<div id="content">
				<h2>To Schedule</h2>
				<table border="1">
				<tr>
					<th class="tableHeaders">Course_Section_ID</th>
					<th class="tableHeaders">Course_Name</th>
					<th class="tableHeaders">Faculty_Name</th>
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
				}?>
			</tr>
		</table>
		<h2>Already Scheduled</h2>	
		<table border="1">
				<tr>
					<th class="tableHeaders">Course Section_ID</th>
					<th class="tableHeaders">Course Name</th>
					<th class="tableHeaders">Faculty Name</th>
					<th class="tableHeaders">Date</th>
					<th class="tableHeaders">Time Period</th>
					<th class="tableHeaders">Class Room</th>
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
		}?>
		<?php mysqli_close($connection); ?>
		</table>		
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
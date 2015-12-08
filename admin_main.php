<HTML>
<HEAD>
<TITLE>Admin</TITLE>
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
            <DIV align=center><B><A href="admin_view_schedule.php"><FONT color=#ffffff size=2>View Schedule</FONT></A></B></DIV>
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
			header('location: logout.php');
		}
		require_once 'db_connect.php';
		$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
		if($connection->connect_error){die(connect_error);}
		$query="select * from user_pwd where usr_grp='instructor'";
		$result=$connection->query($query);
		//print_r($result);
		?>
		<h2>User Management</h2>
			<table border="1">
				<tr>
					<th class="tableHeaders">Reset Password</th>
					<th class="tableHeaders">User ID</th>
					<th class="tableHeaders">User Name</th>
					<th class="tableHeaders">Password</th>
					<th class="tableHeaders">User Type</th>
					<th class="tableHeaders">Delete User</th>
				</tr>
				<tr>
				<?php
				$num_of_rows=$result->num_rows;
				for($i=0; $i<$num_of_rows; $i++){
					$row=$result->fetch_assoc();
					echo '<form action="admin_main.php" method="get">';
					echo "<tr>";
					echo '<td>
					<input type="submit" name="psw_rst" value="Reset Password"/>
					</td>';
					foreach ($row as $key => $value) {
						# code...
						echo "<td>".$value."</td>";
					}
					echo '
						<td>
							<input type="hidden" name="user_id" value="'.$row['user_id'].'"/>
							<input type="submit" name="delete" value="Delete"/>
						</td>';
					echo "</tr>";
				if(isset($_GET['psw_rst'])){
					$psw_rand=rand(100,999);
					$query="UPDATE `user_pwd` SET `password` = '".$psw_rand."' WHERE `user_pwd`.`user_id` = ".$_GET['user_id'];
					$connection->query($query);
					header('Location:admin_main.php'); //no matter that I put in the form or outside the form, the database date has been updated, but the webpage is not updated, I have to reload the webpage again.
				}
				echo "</form>";
				}
				?>
				<!--
				<td>hi</td>
				<form>
					<td>
						<input type="hidden" name="user_id" value=""/>
						<input type="submit" name="delete" value="Delete"/>
					</td>
				</form>
				-->
			</tr>	
		</table>
		<?php
		if(isset($_GET['delete'])){
			$query="delete from user_pwd where user_id=".$_GET['user_id'];
			//echo $query;
			$connection->query($query);
		header('Location:admin_main.php');
		}
		?>
		<?php mysqli_close($connection); ?>
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
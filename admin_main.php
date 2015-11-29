<?php 
session_start();
if($_SESSION['user_name']!="admin"){
	header('location: logout.php');
}
?>


<!DOCTYPE html>

<html>
<head>
<title>admin main</title>

</head>

<body>

<div><a href="admin_view_schedule.php">View Schedule</a></div>

<?php
require_once 'db_connect.php';
$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error){die(connect_error);}
$query="select * from user_pwd where usr_grp='instructor'";
$result=$connection->query($query);
//print_r($result);
?>

<table>
	<tr>
		<?php
		$num_of_rows=$result->num_rows;
		for($i=0; $i<$num_of_rows; $i++){
			$row=$result->fetch_assoc();
			echo '<form action="admin_main.php" method="get">';
			echo "<tr>";
			echo '<td><input type="submit" name="psw_rst" value="Reset Psw"/></td>';
			foreach ($row as $key => $value) {
				# code...
				echo "<td>".$value."</td>";
			}
			echo 
			'
			<td>
			<input type="hidden" name="user_id" value="'.$row['user_id'].'"/>
			<input type="submit" name="delete" value="Delete"/>
			</td>
			</form>';
			echo "</tr>";
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
}
if(isset($_GET['psw_rst'])){
$psw_rand=rand(100,999);
$query="UPDATE `user_pwd` SET `password` = '".$psw_rand."' WHERE `user_pwd`.`user_id` = ".$_GET['user_id'];
$connection->query($query);
}


?>

<div><a href="logout.php">Log Out</a></div>



</body>
</html>
<?php session_start();?>


<!DOCTYPE html>

<html>
<head>
<title>admin main</title>

</head>

<body>
<div>Hello</div>
<div><?php echo $_SESSION["user_name"];?></div>
<div><?php echo "Your User_Id is ".$_SESSION["user_id"];?></div>
<div><?php echo $_SESSION["user_grp"];?></div>

<div><a href="index.html">Return</a></div>
</body>
</html>
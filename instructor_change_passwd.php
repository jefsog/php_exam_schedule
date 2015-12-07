<HTML>
<HEAD>
<TITLE>Change User Password</TITLE>
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
-->

</STYLE>
</HEAD>
<BODY background=./image/blackground.gif bgColor=#ffffff>
<TABLE width=1382 height=55 border=0 cellPadding=0 cellSpacing=0>
  <TR>
    <TD background=./image/top.gif colSpan=2 rowSpan=2>
      <DIV align=center><b><font color="#ffffcc" size="5" face="Arial, Helvetica, sans-serif">Change Password</font></b></DIV>
	</TD>
    <TD bgColor=#00b2eb height=1 width=1145><IMG height=1 src="./image/pixel.gif" width=1></TD>
  </TR>
  <TR>
    <TD bgColor=#ffffff vAlign=bottom>
      <DIV align=right></DIV>
	</TD>
  </TR>
</TABLE>
<TABLE width=865 height="341" border=0 cellPadding=0 cellSpacing=0>
  <TR>
    <TD colSpan=2 height=24 width=244>&nbsp;</TD>
    <TD bgColor=#00b2eb rowSpan=9 width=1><IMG height=1 src="./image/pixel.gif" width=1> </TD>
    <TD rowSpan=6 width=10>&nbsp;</TD>
    <TD height=24 width=495>&nbsp;</TD>
  </TR>
  <TR>
    <TD colSpan=2 vAlign=top width=244><P align=right>&nbsp;</P>
	</TD>
    <td width="494" valign="top"> 
      <table width="480" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3"> 
            <div align="center"><font face="Times New Roman, Times, serif"><b><font face="Courier New, Courier, mono">Please enter new credentials</font></b></font></div>
          </td>
        </tr>
        <tr> 
          <td width="150" height="18"> 
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <form action="instructor_change_passwd.php" method="get">
        <tr> 
          <td colspan="3"> 
              <div align="left"> 
                <blockquote>New Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                  <input type="password" name="password1">
                </blockquote>
              </div>
          </td>
        </tr>
        <tr> 
          <td colspan="3"> 
              <div align="left"> 
                <blockquote> Retype New Password: 
                  <input type="password" name="password2">
                </blockquote>
              </div>
          </td>
        </tr>
        <tr> 
          <td colspan="3"> 
              <div align="center"> 
                <input type="submit" name="submit" value="Change Password">
              </div>
          </td>
        </tr>
		
      </table>
	  <?php
		session_start();
		if(isset($_SESSION["user_id"])) 
			$user_id=$_SESSION["user_id"];
		else
		echo "Invalid User!";
		require_once "db_connect.php";
		$connection=new mysqli($db_hostname,$db_username,$db_password,$db_database);
		if($connection->connect_error){
			die(connect_error);
		}
		if(isset($_GET['submit'])){
			$password1=$_GET["password1"];
			$password2=$_GET["password2"];
			if(!empty($password1)&&!empty($password2)){
				if($password1==$password2){
				$query="update user_pwd set password='$password2' where user_id='$user_id'";
				$result=$connection->query($query);			
				$connection->commit();
			if($result){
				session_destroy();
				header('Location: index.html');				
			} else
				echo "Password not changed!";
			//sleep(5);
			
		}else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password not equal!";
		}
		}else{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password can not be empty!";
		}	
	}?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" rowspan="4" width="244">&nbsp;</td>
    <td width="494" valign="bottom" rowspan="4"> 
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

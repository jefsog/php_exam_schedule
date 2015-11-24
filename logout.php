<?php //must use session_start before session_destroy.
session_start();
session_destroy();
header('Location: index.html');	

?>
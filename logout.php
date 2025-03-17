<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	header("location: front2.php");
	exit;
?>
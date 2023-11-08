<?php
	require 'includes/header.php';

	$_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
    echo "<script>window.alert('Logged out of system!');</script>";
    header("location: login.php");
?>
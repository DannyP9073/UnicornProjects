<?php
	session_start();
	require 'db.php';

	if (isset($_SESSION['ID']))
	{
    	$role = $_SESSION['role'];
		if ($role == 'admin') 
    	{
    		header('location: logout.php');
    	}
    	else $loggedin = TRUE;
    }
    else $loggedin = FALSE;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>GuchuSys</title>
		<link rel="stylesheet" type="text/css" href="src/css/styles.css" media="screen">
		<link rel="stylesheet" href="src/css/w3.css" media="screen">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script type="text/javascript">
			function validateReg(form)
			{
  				fail = validateEmail(form.email.value)
  				fail += validatePassword(form.psw.value)

  				if (fail == "") 
  				{
    				return true
  				}
  				else
  				{
    				window.alert("Successfully registered!");
  				}
			}

			function validateLog(form)
			{
				fail = validateUsername(form.uname.value)
				fail += validateLogPassword(form.psw.value)

				if (fail == "") 
				{
					return true
				}
				else
				{
					window.alert("Successfully logged in!");
				}
			}
		</script>
		<script type="text/javascript" src="src/js/javascript.js"></script>
	</head>
	<body>
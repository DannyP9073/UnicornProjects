<?php
	session_start();
	require 'db.php';

	if (isset($_SESSION['ID']))
	{
    	$role = $_SESSION['role'];
		if ($role == 'user') 
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
		<title>Tasty Cake Shop: Admin</title>
		<link rel="stylesheet" type="text/css" href="src/css/admin.css" media="screen">
		<link rel="stylesheet" href="src/css/w3.css" media="screen">
    	<script type="text/javascript" src="src/js/javascript.js">
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
	</head>
	<body>
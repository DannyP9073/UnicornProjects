<?php
  /* header contains access to database */
  require 'includes/header.php';
  
  if($loggedin == TRUE) header("location:index.php");
  else $nav ='includes/nav.php';

  require $nav;

    /* Post sign in */
      if(isset($_POST['signin']))
    {
        $uname = $_POST['uname'];
        $password = $_POST['psw'];
        $role = "user";

        $checkUser = "SELECT * FROM admin WHERE (username ='$uname' OR email = '$uname') AND (password = '$password' AND role = '$role')";

        $result = $connection->query($checkUser);

        $rows = $result->num_rows;

        if($rows == 0)
        {
          echo "<script>window.alert('Failed to sign in!');</script>";
        } 
        else
        {
          for ($i=0; $i < $rows; $i++) { 
            
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $uID = $row['aID'];
            $role = $row['role'];
          }

          $_SESSION['ID'] = $uID;
          $_SESSION['role'] = $role;
          $_SESSION['logged_in'] = 'TRUE';

          header("location:index.php");

        }
    }
?>	

<!-- html login form  -->

<form action="login.php" method="post" onsubmit="return validateLog(this)">

  <div class="container">
    <h1>Sign in</h1>
    <p>Please fill in this form to sign in.</p>
    <hr>

    <label for="uname"><b>Username/Email</b></label>
    <input type="text" placeholder="Enter Username/Email" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <p>Don't have an account? <a href="register.php" style="color:dodgerblue">Register</a>.</p>

    <div class="clearfix">
      <button type="submit" class="signupbtn" name="signin">Sign in</button>
    </div>
  </div>
</form>

<?php
	require 'includes/footer.php';
?>
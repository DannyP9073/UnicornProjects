<?php
  require 'includes/header.php';
  
  if($loggedin == TRUE) header("location:index.php");

      if(isset($_POST['signin']))
    {
        $uname = $_POST['uname'];
        $password = $_POST['psw'];
        $role = "admin";

        $checkUser = "SELECT * FROM admin WHERE (username ='$uname' OR email = '$uname') AND (password = '$password' AND role = '$role')";

        $result = $connection->query($checkUser);

        $rows = $result->num_rows;

        if($rows == 0)
        {
          echo "Failure to sign in!";
        } 
        else
        {
          for ($i=0; $i < $rows; $i++) { 
            
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $uID = $row['aID'];
            $fname = $row['f_name'];
            $lname = $row['s_name'];
            $username = $row['username'];
            $email = $row['email'];
            $role = $row['role'];
            $pass = $row['password'];

          }

          $_SESSION['ID'] = $uID;
          $_SESSION['fname'] = $fname;
          $_SESSION['lname'] = $lname;
          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;
          $_SESSION['role'] = $role;
          $_SESSION['pass'] = $pass;
          $_SESSION['logged_in'] = 'TRUE';

          header("location:index.php");

        }
    }
?>	

<form action="login.php" method="post" onsubmit="return validateLog(this)">

  <div class="container">
    <h1>Sign in</h1>
    <p>Please fill in this form to sign in.</p>
    <hr>

    <label for="uname"><b>Username/Email</b></label>
    <input type="text" placeholder="Enter Username/Email" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <p>Don't have an account? Sign in with an existing admin userr to create a new admin.</p>

    <div class="clearfix">
      <button type="submit" class="signupbtn" name="signin">Sign in</button>
    </div>
  </div>
</form>

<?php
	require 'includes/footer.php';
?>
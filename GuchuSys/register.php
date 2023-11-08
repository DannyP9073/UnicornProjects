<?php
	require 'includes/header.php';

	if($loggedin == TRUE) header("location:index.php");
    else $nav ='includes/nav.php';

    require $nav;

/* post register */
    if(isset($_POST['signup']))
    {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $uname = $_POST['uname'];
        $location = $_POST['location'];
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $role = "user";

        $addUser = "INSERT INTO admin(f_name, s_name, username, email, role, address, password) VALUES('$fname','$lname','$uname','$email','$role','$location','$password')"; 

        $checkUser = "SELECT * FROM admin WHERE username='$uname' OR email = '$email'";

        $result = $connection->query($checkUser);
        if($result->num_rows)
        {
            echo "<script>window.alert('User already exists!');</script>";
        } 
        else
        {
            $result = $connection->query($addUser);
            if (!$result)
            {
                echo"<script>window.alert('Unexpected error occured!');</script>"; 
            }
            else
            {
                $getUser = "SELECT * FROM admin WHERE (username ='$uname' OR email = '$uname') AND (password = '$password' AND role = '$role')";

                $result = $connection->query($getUser);

                $rows = $result->num_rows;

                if($rows == 0)
                {
                echo "<script>window.alert('Failed to sign in!');</script>";
                } 
                else
                {

                    for ($i=0; $i < $rows; $i++)
                    { 
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
        }
    }
?>

<!-- register form -->
<form action="register.php" method="post" style="border:1px solid #ccc" onsubmit="return validateReg(this)">
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="name"><b>First Name</b></label>
    <input type="text" placeholder="Enter First Name" name="fname" required>

    <label for="name"><b>Last Name</b></label>
    <input type="text" placeholder="Enter Last Name" name="lname" required>

    <label for="name"><b>Username Name</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="name"><b>Address</b></label>
    <input type="text" placeholder="Enter your location" name="location" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <p>Already have an account? <a href="login.php" style="color:dodgerblue">Login</a>.</p>

    <div class="clearfix">
      <button type="submit" class="signupbtn" name="signup">Sign Up</button>
    </div>
  </div>
</form>

<?php
	require 'includes/footer.php';
?>
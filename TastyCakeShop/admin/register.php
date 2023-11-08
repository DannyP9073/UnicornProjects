<?php
	require 'includes/header.php';

    require 'includes/navconnected.php';

    if(isset($_POST['signup']))
    {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $role = "admin";

        $addUser = "INSERT INTO users(f_name, s_name, username, email, role, password) VALUES('$fname','$lname','$uname','$email','$role','$password')"; 

        $checkUser = "SELECT * FROM users WHERE username='$uname' OR email = '$email'";

        $result = $connection->query($checkUser);
        if($result->num_rows)
        {
            echo "That username already exists";
        } 
        else
        {
            $result = $connection->query($addUser);
            if (!$result)
            {
                die("Unexpected error occured!"); 
            }
            else
            {

                echo "Admin user created! sign out and sign back into start using new account.";
            }
        }
    }
?>

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
    <input type="text" placeholder="Enter First Name" name="uname" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <div class="clearfix">
      <button type="submit" class="signupbtn" name="signup">Sign Up</button>
    </div>
  </div>
</form>

<?php
	require 'includes/footer.php';
?>
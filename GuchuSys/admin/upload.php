<?php
	require 'includes/header.php';

	if($loggedin == TRUE) require 'includes/navconnected.php';
	else header('location: login.php');

	// File upload path
    $targetDir = "src/img/";

	if(isset($_POST['upload']))
    {

            // File upload path
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        $name = $_POST['rname'];
        $description = $_POST['description'];
        $tag = $_POST['tag'];
        $price = $_POST['price'];

        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes))
        {
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath))
            {
                $addRemedy = "INSERT INTO remedies(name, description, picture, tag, price) VALUES('$name','$description','$fileName','$tag','$price')"; 

                $result = $connection->query($addRemedy);
                if (!$result)
                {
                    echo "Unexpected error occured!"; 
                }
                else
                {
                    echo "Remedy Added!";
                }
            }
        }
    }
?>
<h2 style="text-align:center">GuchuSys: Admin/Upload!</h2>

	<div class="w3-container w3-card-4">
		<form action="upload.php" method="post" enctype="multipart/form-data">

 			 <div class="container">
    			<h1>Upload Remedy</h1>
    			<p>Please fill in this form.</p>
    			<hr>

    			<label for="name"><b>Remedy Name</b></label>
   				<input type="text" placeholder="Enter remedy name" name="rname" required>

    			<label for="description"><b>Remedy Description</b></label>
    			<input type="text" placeholder="Enter Description" name="description" required>

    			<label for="tag"><b>Remedy Tags</b></label>
    			<input type="text" placeholder="Enter search tag" name="tag" required>

    			<label for="price"><b>Remedy Price</b></label>
    			<input type="text" placeholder="Enter Price" name="price" required>

    			<label for="description"><b>Remedy Image</b></label>
    			<input type="file" placeholder="upload Image" name="image" required>


    			<div class="clearfix">
      				<button type="submit" class="signupbtn" name="upload">Upload</button>
   				</div>
  			</div>
		</form>
	</div>
<?php
	require 'includes/footer.php';
?>
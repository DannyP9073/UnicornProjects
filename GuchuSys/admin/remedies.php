<?php 
	require 'includes/header.php';

	if($loggedin == TRUE) require 'includes/navconnected.php';
	else header('location: login.php');

/*update a remedy*/
	if (isset($_POST['update'])) {
		$id = $_POST['update'];
		$name = $_POST['r_name'];
		$description = $_POST['r_description'];
		$tag = $_POST['r_tag'];
		$price = $_POST['r_price'];

		$updateOrder = "UPDATE remedies SET name = '$name', description = '$description', tag = '$tag', price = '$price' WHERE rID = '$id'";

		$result = $connection->query($updateOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Remedy has been Updated!');</script>";
	}
/* remove remedy */
		if (isset($_POST['delete'])) {
		$id = $_POST['delete'];
		$pic = $_POST['file'];
		
		$deleteOrder = "DELETE FROM remedies WHERE rID = '$id'";

		$result = $connection->query($deleteOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Remedy has been Deleted!');</script>";

		if (file_exists($pic)) {
    		unlink($pic);
    	}
	}
?>
<!--  show all remedies -->
	<h2 style="text-align:center">GuchuSys: Admin/Remedies!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Remedy</th>
					<th>Tags</th>
					<th>Price</th>
					<th>Action</th>
				</tr>
			<?php
				$getProcucts = "SELECT * FROM remedies";

                $result = $connection->query($getProcucts);

                $rows = $result->num_rows;

                if($rows == 0)
                {
                	echo "<script>window.alert('Failed to retrieve products!');</script>";
                } 
                else
                {
					for ($i=0; $i < $rows; $i++)
                    { 
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        $r_ID = $row['rID'];
                        $r_name = $row['name'];
                        $r_description = $row['description'];
                        $r_picture = $row['picture'];
                        $r_tag = $row['tag'];
                        $r_price = $row['price'];

				?>
				<tr>
					<form action="remedies.php" method="post">
						<td><a href="remedy.php?rID=<?= $r_ID;?>"><img src="src/img/<?= $r_picture;?>" alt="product" style="width:100%;max-width:200px"></a></td>
						<td><input type="text" name="r_name" value="<?= $r_name;?>"><br><input type="text" name="r_description" value="<?= $r_description;?>">
						</td>
						<td><input type="text" name="r_tag" value="<?= $r_tag;?>"></td>
						<td><input type="text" name="r_price" value="<?= $r_price;?>"></td>
						<td>
							<input type="hidden" name="file" value="src/img/<?= $r_picture;?>">
							<button name="update" value="<?= $r_ID;?>">Update</button><br>
							<button name="delete" value="<?= $r_ID;?>">Delete</button></td>
						</td>
					</form>
				</tr>
			<?php 
					}
				} 

				?>
			</table>
	</div>
<?php
	require 'includes/footer.php';
?>
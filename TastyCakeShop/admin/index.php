<?php
	require 'includes/header.php';

	if($loggedin == TRUE) require 'includes/navconnected.php';
	else header('location: login.php');

	if (isset($_POST['update'])) {
		$id = $_POST['update'];
		$status = $_POST['status'];

		$updateOrder = "UPDATE admin SET status = '$status' WHERE Order_ID = '$id'";

		$result = $connection->query($updateOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been Updated!');</script>";
	}

		if (isset($_POST['delete'])) {
		$id = $_POST['delete'];
		
		$deleteOrder = "DELETE FROM admin WHERE Order_ID = '$id'";

		$result = $connection->query($deleteOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been Deleted!');</script>";
	}
?>


<h2 style="text-align:center">Tasty Cake Shop: Admin!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Customer</th>
					<th>Location</th>
					<th>Cake</th>
					<th>Quantity</th>
					<th>Order to Delivery Date</th>
					<th>Total</th>
					<th>Status</th>
				</tr>
<?php
				$getOrders = "SELECT * FROM admin INNER JOIN products ON (admin.Product_ID = products.ID) INNER JOIN users ON (admin.User_ID = users.uID) ORDER BY admin.Order_date" ;

                $result = $connection->query($getOrders);

                $rows = $result->num_rows;

                if($rows == 0)
                {
                	echo "Failed to retrieve order list!";
                } 
                else
                {
										for ($i=0; $i < $rows; $i++)
                    { 
                      $row = $result->fetch_array(MYSQLI_ASSOC);
                      $u_fname = $row['f_name'];
                      $u_sname = $row['s_name'];
                      $u_location = $row['address'];
                      $p_name = $row['name'];
                      $a_quantity = $row['p_quantity'];
                      $a_order_date = $row['Order_date'];
                      $a_delivery_date = $row['delivery_date'];
                      $a_total = $row['total'];
                      $a_status = $row['status'];
                      $a_id = $row['Order_ID'];

			?>
				<tr>
					<form action="index.php" method="post">
						<td><?= $u_fname." ".$u_sname;?></td>
						<td><?= $u_location;?></td>
						<td><?= $p_name;?></td>
						<td><?= $a_quantity;?></td>
						<td><?= $a_order_date;?><- -><?= $a_delivery_date;?></td>
						<td><?= $a_total;?></td>
						<td><input type="text" name="status" value="<?= $a_status;?>"><br>
							<button name="update" value="<?= $a_id;?>">Update</button><br>
							<button name="delete" value="<?= $a_id;?>">Delete</button></td>
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
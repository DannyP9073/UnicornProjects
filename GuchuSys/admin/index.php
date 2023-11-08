<?php
	require 'includes/header.php';

	if($loggedin == TRUE) require 'includes/navconnected.php';
	else header('location: login.php');

	if (isset($_POST['update'])) {
		$id = $_POST['update'];
		$status = $_POST['status'];

		$updateOrder = "UPDATE orders SET status = '$status' WHERE oID = '$id'";

		$result = $connection->query($updateOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been Updated!');</script>";
	}

		if (isset($_POST['delete'])) {
		$id = $_POST['delete'];
		
		$deleteOrder = "DELETE FROM orders WHERE oID = '$id'";

		$result = $connection->query($deleteOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been Deleted!');</script>";
	}
?>


<h2 style="text-align:center">GuchuSys: Admin!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Order No.</th>
					<th>Customer</th>
					<th>Location</th>
					<th>Remedies<br>(ID:Name)</th>
					<th>Dates<br>(Order:Delivery)</th>
					<th>Total</th>
					<th>Status</th>
				</tr>

				<!-- show all orders  -->
<?php
				$getOrders = "SELECT * FROM orders INNER JOIN admin ON (orders.User_ID = admin.aID) ORDER BY orders.Order_date" ;

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
                      $a_fname = $row['f_name'];
                      $a_sname = $row['s_name'];
                      $a_location = $row['address'];
                      $remedies = unserialize($row['remedies']);
                      $o_order_date = $row['Order_date'];
                      $o_delivery_date = $row['delivery_date'];
                      $o_total = $row['total'];
                      $o_status = $row['status'];
                      $o_id = $row['oID'];

			?>
				<tr>
					<form action="index.php" method="post">
						<td><?= $o_id;?></td>
						<td><?= $a_fname."<br>".$a_sname;?></td>
						<td><?= $a_location;?></td>
						<td>
							<?php 
								foreach ($remedies as $key => $value) 
								{
							?>
								<?= $value['rID'];?>:<?= $value['rName'];?><br>
							<?php
								} 
							?>
						</td>
						<td><?= $o_order_date;?>:<br><?= $o_delivery_date;?></td>
						<td><?= $o_total;?></td>
						<td><input type="text" name="status" value="<?= $o_status;?>"><br>
							<button name="update" value="<?= $o_id;?>">Update</button><br>
							<button name="delete" value="<?= $o_id;?>">Delete</button></td>
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
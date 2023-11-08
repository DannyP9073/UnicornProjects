<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

	if (isset($_POST['cancel'])) {
		$id = $_POST['cancel'];

		$deleteOrder = "UPDATE admin SET status = 'cancelled' WHERE Order_ID = '$id'";

		$result = $connection->query($deleteOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been cancelled!');</script>";
	}
?>
<h2 style="text-align:center">Orders!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Details</th>
					<th>Order to Delivery Date</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Order Status</th>
				</tr>
			<?php

				$uID = $_SESSION['ID'];
				$getOrders = "SELECT * FROM admin INNER JOIN products ON (admin.Product_ID = products.ID) WHERE (admin.User_ID = '$uID' AND status != 'cancelled') ORDER BY admin.delivery_date";

                $result = $connection->query($getOrders);

                $rows = $result->num_rows;
 				if($rows == 0)
                {
                	echo "You have no orders currently!";
                } 
                else
                {
					for ($i=0; $i < $rows; $i++)
                    { 
                    	$row = $result->fetch_array(MYSQLI_ASSOC);
                    	$oID = $row['Order_ID'];
                    	$pImage = $row['picture'];
                		$pName = $row['name'];
                		$pDescription = $row['description'];
                    	$quantity = $row['p_quantity'];
                      	$order_date = $row['Order_date'];
                      	$delivery_date = $row['delivery_date'];
                      	$total = $row['total'];
                      	$status = $row['status'];
				?>
				<tr>
					<form action="orders.php" method="post">
						<td><img src="src/img/<?= $pImage;?>" alt="product" style="width:100%;max-width:200px"></td>
						<td><h4><?= $pName;?></h4><br><?= $pDescription;?></td>
						<td><?= $order_date;?> <-<br>-> <?= $delivery_date;?></td>
						<td><?= $quantity;?></td>
						<td><?= $total;?></td>
						<td><?= $status;?><br><br><button class="w3-button w3-black" name="cancel" value="<?= $oID;?>"><i class="fa fa-remove"></i></button></td>
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
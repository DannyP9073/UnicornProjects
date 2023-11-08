
<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

/* post order cancel */
	if (isset($_POST['cancel'])) {
		$id = $_POST['cancel'];

		$cancelOrder = "UPDATE orders SET status = 'cancelled' WHERE oID = '$id'";

		$result = $connection->query($cancelOrder);
		if (!$result) echo"<script>window.alert('Unexpected error occured!');</script>";
		else  echo"<script>window.alert('Order has been cancelled!');</script>";
	}
?>
<h2 style="text-align:center">Orders!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Order No.</th>
					<th>Details</th>
					<th>Order to Delivery Date</th>
					<th>Total</th>
					<th>Order Status</th>
				</tr>
			<?php

				$uID = $_SESSION['ID'];
				$getOrders = "SELECT * FROM orders WHERE (User_ID = '$uID' AND status != 'cancelled') ORDER BY delivery_date";

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
                    	$oID = $row['oID'];
                    	$remedies = unserialize($row['remedies']);
                      	$order_date = $row['Order_date'];
                      	$delivery_date = $row['delivery_date'];
                      	$total = $row['total'];
                      	$status = $row['status'];

                      	foreach ($remedies as $key => $value) {
                      		
                      	}
				?>

				<!-- order table row form -->
				<tr>
					<form action="orders.php" method="post">
						<td><?=$oID;?></td>
						<td>
							<?php
							    foreach ($remedies as $key => $value)
							    {
                      		?>
                      		<?=$value['rName'];?>|<img src="admin/src/img/<?= $value['rImage'];?>" alt="product" style="width:100%;max-width:100px"><br>	
                      		<?php  
                      			}
							?>
						</td>
						<td><?= $order_date;?> <-<br>-> <?= $delivery_date;?></td>
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
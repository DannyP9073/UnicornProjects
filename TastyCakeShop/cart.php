<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

	if (isset($_GET['action'])) 
	{
		if($_GET['action'] == 'delete')
		{
			foreach ($_SESSION['shopping_cart'] as $key => $value) 
			{
				if ($value['pID'] == $_GET['id']) 
				{
					unset($_SESSION['shopping_cart'][$key]);
					echo "<script>window.alert('Updated cart!');</script>";
				}
			}
		}
	}

	if (isset($_POST['pid'])) {

		foreach ($_SESSION['shopping_cart'] as $key => $value) 
			{
				if ($value['pID'] == $_POST['pid']) 
				{
					$_SESSION['shopping_cart'][$key]['pQuantity'] = $_POST['quantity']; 
					echo "<script>window.alert('Updated cart!');</script>";
				}
			}
	}
?>

<!-- Main cart Page view -->
<h2 style="text-align:center">Cart!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
		<tr>
			<th>Image</th>
			<th>Details</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Action</th>
		</tr>

		<!-- Cart loader from session -->
		<?php
			if(!empty($_SESSION['shopping_cart']))
			{
				$total = 0;
				foreach ($_SESSION['shopping_cart'] as $key => $value) 
				{
		?>
		<tr>
			<form action="cart.php" method="post">
			<td><img src="src/img/<?= $value['pImage']; ?>" style="width:100%;max-width:200px"></td>
			<td><h4><?= $value['pName']; ?></h4><br><?= $value['pDescription']; ?></td>
			<td>
					<input style="max-width: 75px" id="icon_prefix" type="number" name="quantity" min="1" value="<?= $value['pQuantity'];?>" class="validate"><br>
					<button class="w3-button" name="pid" style="max-width: 75px" value="<?= $value['pID'];?>"><i class="fa fa-check-circle" style="font-size:48px"></i></button>
			</td>
			<td>R <?= $value['pPrice']; ?></td>
			<td>
				<a href="cart.php?action=delete&id=<?= $value['pID']; ?>"><i class="material-icons" style="font-size:48px;color:red">remove_shopping_cart</i></a>
			</td>
			</form>
		</tr>
		<?php
					$total = $total + ($value['pQuantity'] * $value['pPrice']);
				}
		?>
		<tr>
			<td colspan="3"> Total</td>
			<td align="right">R <?= $total; ?></td>
			<td><button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Checkout <i class="fa fa-shopping-cart"></i></button></td>
		</tr>
		<?php
			}
		?>
	</table>
<!-- Pop up window after check out button clicked -->
  <div id="id01" class="w3-modal w3-animate-opacity">
    <div class="w3-modal-content w3-card-4">
      <header class="w3-container w3-black"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-large w3-display-topright">&times;</span>
        <h2>Order Review:</h2>
      </header>
      <div class="w3-container">

      	<!-- checkout login confirmation -->
      	<?php
      		if($loggedin == TRUE)
      		{
      			$uID = $_SESSION['ID'];

      			$getUserInfo = "SELECT * FROM users WHERE uID ='$uID'";

      			$result = $connection->query($getUserInfo);

      			$rows = $result->num_rows;

      			if ($rows==0) 
      			{
      				echo "<script>window.alert('Failed to retrieve user, please try again!');</script>";
      			}
      			else
      			{
      				for ($i=0; $i < $rows; $i++) 
      				{ 
      					$row = $result->fetch_array(MYSQLI_ASSOC);
      					$u_name = $row['f_name'].' '.$row['s_name'];
      					$u_location = $row['address'];
      					$u_email = $row['email'];
      				}
      			}
      			$today_date = date('Y/m/d');

      			if (isset($_POST['checkout'])) 
				{

					$order_date = date('Y/m/d');
					$delivery_date = $_POST['delivery_date'];
					$status = 'pending';

					$total = 0;
					foreach ($_SESSION['shopping_cart'] as $key => $value) 
					{
						$total = $value['pQuantity'] * $value['pPrice'];

						$item_id = $value['pID'];
						$item_quantity = $value['pQuantity'];

						$placeOrder = "INSERT INTO admin(User_ID, Product_ID, p_quantity, Order_date, delivery_date, total, status) VALUES('$uID', '$item_id', '$item_quantity', '$order_date', '$delivery_date', '$total', '$status')";

						$result = $connection->query($placeOrder);      				
            			if (!$result)
            			{
                			echo "<script>window.alert('Unexpected error occurred!');</script>"; 
            			}
            			else
            			{
            				echo "<script>window.alert('Successfully placed order!');
            				window.location.reload();
            				</script>";
            				foreach ($_SESSION['shopping_cart'] as $key => $value) 
							{
									unset($_SESSION['shopping_cart'][$key]);
							}
            			}
					}
					$delivery = 100;

					$total_order = $total + $delivery;

				}
      	?>
      	<!-- if logged in display order review form -->
      	<form action="cart.php" class="w3-container w3-card-4 w3-light-grey w3-margin" method="post">
			<h2 class="w3-center">Details:</h2>

			<div class="w3-row w3-section ">
				<div class="w3-half">
  					<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    				<div class="w3-rest">
      					<p><?= $u_name; ?></p>
    				</div>
    			</div>

    			<div class="w3-half">
    				<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
    				<div class="w3-rest">
      					<p><?= $today_date; ?></p>
    				</div>
    			</div>
			</div>

			<div class="w3-row w3-section ">
				<div class="w3-half">
  				<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
    			<div class="w3-rest">
      				<p><?= $u_email; ?></p>
    			</div>
    			</div>

    			<div class="w3-half">
  					<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar-check-o"></i></div>
    				<div class="w3-rest">
    					<label for="delivery_date">Delivery date:</label>
      					<input type="date" name="delivery_date" placeholder="YYYY/MM/DD" value="<?= date('Y/m/d', strtotime($today_date. '+ 5 days'));?>">
    				</div>
    			</div>
			</div>
 
			<div class="w3-row w3-section ">
  				<div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-map-marker"></i></div>
    			<div class="w3-rest">
      				<p><?= $u_location; ?></p>
    			</div>
			</div>

			<h2 class="w3-center">Cart:</h2>
			<table class="w3-table w3-striped">
				<tr>
					<th>Product</th>
					<th>Quantity</th>
					<th>Price P/U</th>
					<th>Total</th>
				</tr>

				<?php

				$total = 0;
				foreach ($_SESSION['shopping_cart'] as $key => $value) 
				{
		?>
				<tr></tr>
				<tr>
					<td><?= $value['pName']; ?></td>
					<td><?= $value['pQuantity']; ?></td>
					<td>R <?= $value['pPrice']; ?></td>
					<td>R <?= $value['pQuantity'] * $value['pPrice']; ?></td>
				</tr>
						<?php
						$total = $total + ($value['pQuantity'] * $value['pPrice']);
				}


					$delivery = 100;

					$total_order = $total + $delivery;


		?>
				<tr>
					<td colspan="2"></td>
					<td> <h6>Subtotal</h6></td>
					<td align="right"><h6>R <?= $total; ?></h6></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td> <h6>Delivery Fee</h6></td>
					<td align="right"><h6>R <?= $delivery; ?></h6></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td> <h4>Total</h4></td>
					<td align="right"><h4>R <?= $total_order; ?></h4></td>
				</tr>
			</table>

			<p class="w3-center">
				<button type="submit" name="checkout">Place Order</button>
			</p>
		</form>

		<!-- if not logged in prompt sign in form -->
      	<?php 
      		}
      		else
      		{
      			if(isset($_POST['login']))
    			{
        			$uname = $_POST['uname'];
        			$password = $_POST['psw'];
        			$role = "user";

        			$checkUser = "SELECT * FROM users WHERE (username ='$uname' OR email = '$uname') AND (password = '$password' AND role = '$role')";

        			$result = $connection->query($checkUser);

			        $rows = $result->num_rows;

        			if($rows == 0)
        			{
          				echo "<script>window.alert('Failed to login!');</script>";
        			} 
        			else
        			{
          				for ($i=0; $i < $rows; $i++) 
          				{ 
            				$row = $result->fetch_array(MYSQLI_ASSOC);
            				$uID = $row['uID'];
            				$role = $row['role'];
            			}

          				$_SESSION['ID'] = $uID;
          				$_SESSION['role'] = $role;
          				$_SESSION['logged_in'] = 'TRUE';

          				echo "<script>window.alert('Successfully logged in!');
            				window.location.reload();
            				</script>";

        			}
    			}
      	?>
      	<!-- sign in form -->
      	<form action="cart.php" method="post" class="w3-container w3-card-4 w3-light-grey w3-margin">
			<div class="container">
    			<label for="uname"><b>Username/Email</b></label>
    			<input type="text" placeholder="Enter Username/Email" name="uname" required>

    			<label for="psw"><b>Password</b></label>
   				<input type="password" placeholder="Enter Password" name="psw" required>

    			<button type="submit" name="login">Login</button>
  			</div>
		</form>
      	<?php
      		} 
      	?>
      </div>
      <footer class="w3-container w3-green">
        <p>Ecommerce shop.</p>
      </footer>
    </div>
  </div>
</div>

<?php
	require 'includes/footer.php';
?>
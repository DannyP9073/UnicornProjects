<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

	if (isset($_POST['add'])) 
	{
			$pID = $_POST['add'];
			$pName = $_POST['p_name'];
			$pPrice = $_POST['p_price'];
			$pQuantity = $_POST['quantity'];
			$pImage = $_POST['p_image'];
			$pDescription = $_POST['p_description'];


            if (isset($_SESSION['shopping_cart'])) 
			{
				$item_array_id = array_column($_SESSION['shopping_cart'], "pID");
				if(!in_array($pID, $item_array_id))
				{
					$count = count($_SESSION["shopping_cart"]);
					$item_array = array(
					'pID' => $pID,
					'pName' => $pName,
					'pPrice' => $pPrice,
					'pQuantity' => $pQuantity,
					'pImage' => $pImage,
					'pDescription' => $pDescription
					);
					$_SESSION['shopping_cart'][$count] = $item_array;
				}
			}
			else
			{
				$item_array = array(
					'pID' => $pID,
					'pName' => $pName,
					'pPrice' => $pPrice,
					'pQuantity' => $pQuantity,
					'pImage' => $pImage,
					'pDescription' => $pDescription 
				);
				$_SESSION['shopping_cart'][0] = $item_array;
			}
    }
?>

	<h2 style="text-align:center">Tasty Cake Shop!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Details</th>
					<th>Quantity</th>
					<th>Price</th>
					<th></th>
				</tr>
			<?php
				$getProcucts = "SELECT * FROM products";

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
                        $p_ID = $row['ID'];
                        $p_name = $row['name'];
                        $p_description = $row['description'];
                        $p_picture = $row['picture'];
                        $p_quantity = $row['quantity'];
                        $p_price = $row['price'];

				?>
				<tr>
					<form action="index.php" method="post">
						<td><img src="src/img/<?= $p_picture;?>" alt="product" style="width:100%;max-width:200px"></td>
						<td>
							<h4><?= $p_name;?></h4><br>
							<?= $p_description;?>
						</td>
						<td><input id="icon_prefix" type="number" name="quantity" min="1" max="<?= $p_quantity; ?>" class="validate" required></td>
						<td>R <?= $p_price;?></td>
						<td>
							<input type="hidden" name="p_name" value="<?= $p_name;?>">
      						<input type="hidden" name="p_image" value="<?= $p_picture;?>">
      						<input type="hidden" name="p_price" value="<?= $p_price;?>">
      						<input type="hidden" name="p_description" value="<?= $p_description;?>">
							<button type="submit" name="add" value="<?= $p_ID; ?>">Add to Cart <i class="fa fa-cart-plus"></i></button>
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
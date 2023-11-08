 <?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

	/* adding items to cart through sessions */
	if (isset($_POST['add'])) 
	{
			$rID = $_POST['add'];
			$rName = $_POST['r_name'];
			$rPrice = $_POST['r_price'];
			$rImage = $_POST['r_image'];


            if (isset($_SESSION['shopping_cart'])) 
			{
				$item_array_id = array_column($_SESSION['shopping_cart'], "rID");
				if(!in_array($rID, $item_array_id))
				{
					$count = count($_SESSION["shopping_cart"]);
					$item_array = array(
					'rID' => $rID,
					'rName' => $rName,
					'rPrice' => $rPrice,
					'rImage' => $rImage
					);
					$_SESSION['shopping_cart'][$count] = $item_array;
				}
			}
			else
			{
				$item_array = array(
					'rID' => $rID,
					'rName' => $rName,
					'rPrice' => $rPrice,
					'rImage' => $rImage
				);
				$_SESSION['shopping_cart'][0] = $item_array;
			}
    }
?>
<!-- Main body with product list -->
	<h2 style="text-align:center">GuchuSys!</h2>

	<div class="w3-container w3-card-4">
			<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Remedy</th>
					<th>Price</th>
					<th></th>
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
				<!-- Table row with action form -->
				<tr>
					<form action="index.php" method="post">
						<td><a href="remedy.php?rID=<?= $r_ID;?>"><img src="admin/src/img/<?= $r_picture;?>" alt="product" style="width:100%;max-width:200px"></a></td>
						<td>
							<h4><?= $r_name;?></h4>
						</td>
						<td>R <?= $r_price;?></td>
						<td>
							<input type="hidden" name="r_name" value="<?= $r_name;?>">
      						<input type="hidden" name="r_image" value="<?= $r_picture;?>">
      						<input type="hidden" name="r_price" value="<?= $r_price;?>">
							<button type="submit" name="add" value="<?= $r_ID; ?>">Add to Cart <i class="fa fa-cart-plus"></i></button>
						</td>
					</form>
				</tr>
			<?php 
					}
				} 

				?>
			</table>
	</div>
	
	<!-- include page footer at bottom of website -->
<?php
	require 'includes/footer.php';
?>
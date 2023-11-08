<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;

	$rID =$_GET['rID'];

	$getRemedy = "SELECT * FROM remedies WHERE rID = '$rID'";

	$result = $connection->query($getRemedy);

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

        }


?>
<!--  add to cart  -->
<?php 
	if (isset($_POST['add'])) 
	{
			$rID = $_POST['add'];
			$rName = $_POST['r_name'];
			$rPrice = $_POST['r_price'];
			$rImage = $_POST['r_image'];
			$rDescription = $_POST['r_description'];


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
<!-- Remedy view -->
<h2 style="text-align:center"><?= $r_name;?>!</h2>
<div class="container">
				<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Details</th>
					<th>Price</th>
					<th></th>
				</tr>
				<tr>
					<form action="index.php" method="post">
						<td><a href="remedy.php?rID=<?= $r_ID;?>"><img src="admin/src/img/<?= $r_picture;?>" alt="product" style="width:100%;max-width:200px"></a></td>
						<td><?= $r_description;?></td>
						<td>R <?= $r_price;?></td>
						<td>
							<input type="hidden" name="r_name" value="<?= $r_name;?>">
      						<input type="hidden" name="r_image" value="<?= $r_picture;?>">
      						<input type="hidden" name="r_price" value="<?= $r_price;?>">
							<button type="submit" name="add" value="<?= $r_ID; ?>">Add to Cart <i class="fa fa-cart-plus"></i></button>
						</td>
					</form>
				</tr>
			</table>
</div>

<?php
	}
	require 'includes/footer.php';
?>
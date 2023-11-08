<?php
	require 'includes/header.php';

	if($loggedin == TRUE) $nav ='includes/navconnected.php';
	else $nav ='includes/nav.php';

	require $nav;
?>
<!-- The form -->
<div class="w3-container ">
<div class="w3-card-4">
<form action="search.php" method="post">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit" name="query"><i class="fa fa-search"></i></button>
</form>
</div>
<table class="w3-table w3-striped">
				<tr>
					<th>Image</th>
					<th>Remedy</th>
				</tr>
<?php 

/* post search remedy */
	if (isset($_POST['query'])) {
		$query = $_POST['search'];

		$searchQuery = "SELECT * FROM remedies WHERE tag LIKE '".$query."%'";

        $result = $connection->query($searchQuery);

        $rows = $result->num_rows;

        if($rows == 0)
        {
          echo "<script>window.alert('Could not find anything that fitted the search parameters!');</script>";
        } 
        else
        {
          for ($i=0; $i < $rows; $i++) 
          { 
            
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $rID = $row['rID'];
            $rname = $row['name'];
            $rpic = $row['picture'];

          ?>
          	<tr>
          		<td><a href="remedy.php?rID=<?= $rID;?>"><img src="admin/src/img/<?= $rpic;?>" alt="product" style="width:100%;max-width:200px"></a></td>
          		<td><h4><?= $rname;?></h4></td>
          	</tr>
          <?php 

          }

        }
	}

?>
</div>
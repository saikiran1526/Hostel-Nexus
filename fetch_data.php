<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM hostel WHERE hostel_status = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND hostel_distance BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "
		 AND room_type IN('".$brand_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND category IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND amenties IN('".$storage_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-4 col-md-4">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:550px;">
					<img src="images/'. $row['hostel_image'] .'" alt="" class="img-responsive" >
					<p align="center"><strong><a href="#">'. $row['hostel_name'] .'</a></strong></p>
					<!-- <h4 style="text-align:center;" class="text-danger" >'. $row['hostel_distance'] .'</h4> -->
					Room Type : '. $row['room_type'] .' <br />
					Category : '. $row['category'] .' <br />
					Amenties : '. $row['amenties'] .' </p>
					<p>Rating : '. $row['rating'].' <br />

				</div>

			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>
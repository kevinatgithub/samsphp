<?php include 'config/config.php';

checkAccess();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DTR</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
  </head>
  <body>
  	<div class="container">
      <?php include('top-nav.php'); ?>
  		<h1>--</h1>
  		<div class="row">
  			<div class="col-md-12">
  				<table class="table table-condensed table-hover">
  					<thead>
  						<tr>
  							<th>Employee No.</th>
  							<th>Employee Name</th>
  							<th>Position</th>
  							<th>Office</th>
  							<td>Export</td>
  						</tr>
  					</thead>
  					<tbody>
  						<?php
  							$employee = mysqli_query($con,"SELECT * FROM employee");
  							while($row = mysqli_fetch_array($employee)) {
  								print '
		  						<tr>
		  							<td>'.$row['employee_no'].'</td>
		  							<td>'.$row['lname'].', '.$row['fname'].' '.$row['mname'].'</td>
		  							<td>'.$row['position'].'</td>
		  							<td>'.$row['office'].'</td>
		  							<td><a class="btn btn-success" href="select2.php?employee_no='.$row['id'].'" role="button" target="_blank">Export</a></td>
		  						</tr>
  								';
  							}
  						?>
  					</tbody>
  				</table>
  			</div>
  		</div>
  	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
$("table").dataTable();
});
</script>
  </body>
</html>
<?php 
include 'config/config.php';

$employee_no = $_GET['employee_no']; 
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
  </head>
  <body>
  	<div class="container">
  		<h1>--</h1>
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Select Cut-off</h3>
            </div>
            <div class="panel-body">
              <form action="dtr.php" method="POST" role="form">
                <label for="">Employee No.</label>
                <input type="text" name="employee_no" id="employee_no" class="form-control" value="<?php print $employee_no; ?>" required="required">
                <h3>
                  
                </h3>
                <div class="form-group">
                  <label for="">Year</label>
                  <input type="text" name="year" id="year" class="form-control" value="2017" required="required">
                </div>                   
                <div class="form-group">
                  <label for="">Month</label>
                  <select id="month" name="month" class="form-control" required="required">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>                     
                <div class="form-group">
                  <label for="">Cut-off</label>
                  <select id="cutoff" name="cutoff" class="form-control" required="required">
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">Full</option>
                  </select>
                </div>              
                
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
  			</div>
  		</div>
  	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
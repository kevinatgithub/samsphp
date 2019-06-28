<?php 
include 'config/config.php';
checkAccess();
$employee_no = mysqli_real_escape_string($con,$_GET['employee_no']); 
$employee = mysqli_query($con,"SELECT * FROM employee where id = '$employee_no'");
$emp = mysqli_fetch_object($employee);
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
      <?php include('top-nav.php'); ?>
  		<h1>--</h1>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">DTR Print Options</h3>
        </div>
        <div class="panel-body">
          <form action="dtr.php" method="POST" role="form" target="_blank" onsubmit="goback()">
            <div class="row">
              <div class="col-md-6">
                <label for="">Employee</label>
                <input type="hidden" name="employee_no" id="employee_no" class="form-control" value="<?php print $employee_no; ?>" required="required">
                <input type="text" class="form-control" value="<?=$emp->fname.' '.$emp->lname?>" readonly>
                <div class="form-group">
                  <label for="">Year</label>
                  <input type="text" name="year" id="year" class="form-control" value="2019" required="required">
                </div>                   
                <div class="form-group">
                  <label for="">Month</label>
                  <select id="month" name="month" class="form-control" required="required">
                    <?php
                      $d = date('d');
                      $m = $d < 16 ? date('m',strtotime('-1 month')) : date('m');
                    ?>
                    <option value="01" <?=$m==1?'selected' : ''?>>January</option>
                    <option value="02" <?=$m==2?'selected' : ''?>>February</option>
                    <option value="03" <?=$m==3?'selected' : ''?>>March</option>
                    <option value="04" <?=$m==4?'selected' : ''?>>April</option>
                    <option value="05" <?=$m==5?'selected' : ''?>>May</option>
                    <option value="06" <?=$m==6?'selected' : ''?>>June</option>
                    <option value="07" <?=$m==7?'selected' : ''?>>July</option>
                    <option value="08" <?=$m==8?'selected' : ''?>>August</option>
                    <option value="09" <?=$m==9?'selected' : ''?>>September</option>
                    <option value="10" <?=$m==10?'selected' : ''?>>October</option>
                    <option value="11" <?=$m==11?'selected' : ''?>>November</option>
                    <option value="12" <?=$m==12?'selected' : ''?>>December</option>
                  </select>
                </div>                     
                <div class="form-group">
                  <label for="">Cut-off</label>
                  <select id="cutoff" name="cutoff" class="form-control" required="required">
                    <option value="1"<?=$d < 16 ? '' : 'selected'?>>1st</option>
                    <option value="2"<?=$d < 16 ? 'selected' : ''?>>2nd</option>
                    <option value="3">Full</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Signatory</label>
                  <input type="text" name="signatory" class="form-control" value="MARITES B. ESTRELLA, RN, MM, MDM">
                </div>
                <div class="form-group">
                  <label for="">Position</label>
                  <input type="text" name="position" class="form-control" value="Program Manager, NVBSP">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Saturdays</label>
                    <input type="text" name="saturdays" class="form-control" placeholder="Enter Day separated by comma (,) e.i, 15,22,29">
                  </div>
                  <div class="form-group">
                    <label for="">Sundays</label>
                    <input type="text" name="sundays" class="form-control" placeholder="Enter Day separated by comma (,) e.i, 15,22,29">
                  </div>
                  <div class="form-group">
                    <label for="">Holidays</label>
                    <input type="text" name="holidays" class="form-control" placeholder="Enter Day separated by comma (,) e.i, 15,22,29">
                  </div>
                  <div class="form-group">
                    <label for=""><input type="checkbox" name="ot" checked>Show O.T. Remark</label>
                  </div>
                  <div class="form-group">
                    <label for="">Absents</label>
                    <input type="text" name="absents" class="form-control" placeholder="Enter Day separated by comma (,) e.i, 15,22,29">
                  </div>
                  <div class="form-group">
                    <label for="">Off</label>
                    <input type="text" name="off" class="form-control" placeholder="Enter Day separated by comma (,) e.i, 15,22,29">
                  </div>
                  
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
      function goback(){
        window.setTimeout(function(){
          close()
        },50)
      }
    </script>
  </body>
</html>
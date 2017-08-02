<?php 
include 'config/config.php'; 

$Message = '';

  if(isset($_POST['cmdLogin'])){
    $username = mysql_real_escape_string(trim($_POST['txtUN']));
    $password = md5(mysql_real_escape_string(trim($_POST['txtPW'])));

    if($username&&$password){
      $query  = " SELECT * FROM `user` WHERE `username` = '".$username."' ";
      $result = mysqli_query($con,$query) or die(mysqli_error($con));
      while($row = mysqli_fetch_array($result)){
        $fullname = $row['name'];
        $username = $row['username'];
        $dbpassword = $row['password'];

        if($password == $dbpassword){
          /* start session */
          session_name('dtr_session');
          $_SESSION['name'] = $fullname;
          $_SESSION['username'] = $username;
          exit("<script>document.location.href='main.php';</script>\n");   
        }
        else{
          $Message = '
          <div class="alert alert-danger">
            <strong>Invalid Login!</strong> Either the Username/Password is incorrect.
        </div>
          ';
        }

        
      }/* end while*/
    }else{
      $Message = '
      <div class="alert alert-danger">
          <strong>Empty Username/Password</strong> - Please enter your correct Username/Password.
      </div>
      '; 
    }/* end if*/
  }/* end if isset */

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
  		<h1><span class='glyphicon glyphicon-user'></span>&nbsp;User Login</h1>
  		<div class="row">
  			<div class="col-md-12">

            <div class="container">
              <div class="row"><?php echo $Message; ?></div>
                <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-blue">
                      <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                      <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" method="POST">
                                <fieldset>
                            <div class="form-group">
                              <input class="form-control" placeholder="Username" name="txtUN" type="text">
                          </div>
                          <div class="form-group">
                            <input class="form-control" placeholder="Password" name="txtPW" type="password">
                          </div>
                          <input class="btn btn-lg btn-primary btn-block" type="submit" name="cmdLogin" value="LOGIN">
                        </fieldset>
                          </form>
                      </div>
                  </div>
                </div>
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
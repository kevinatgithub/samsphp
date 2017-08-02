<?php include 'config/config.php'; 


session_name( 'dtr_session' );
$fullname = $_SESSION['name'];
$username = $_SESSION['username'];
session_destroy();

//redirrect user in the index page
echo "<script>document.location.href='index.php'</script>\n";
exit();

?>
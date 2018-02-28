<?PHP

include("includes/lib.php");

session_start();

$sisifoConf  = new Configuracion ( "sisifo.xml" );

$sisifoConf -> closeDb();
$_SESSION['login']="";
$_SESSION['ip']="";

// session_unregister ("login");
// session_unregister ("ip");
// session_unregister ("login");
// session_unregister ("ip");
// session_unregister ("login");
// session_unregister ("ip");

session_destroy();

header("Location: index.php\n\n");

?>

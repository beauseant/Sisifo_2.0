<!DOCTYPE html>
<html lang="es">
<head>
	<title>Sísifo 2.0</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
<?PHP
	session_start();


	require ("includes/lib.php");


	$sisifoConf  = new Configuracion ("sisifo.xml" );
	$sisifoInfo = $sisifoConf  -> getSisifoConf ();

	

	$_SESSION ['base_url'] = $sisifoInfo  -> getBaseurl();
	$_SESSION ['fichero'] = $sisifoInfo  -> getBasepath() . "/sisifo.xml";

	if (!isset($_REQUEST['act'])) $_REQUEST['act'] = 'firsttimeentry';

	if($_REQUEST['act'] == "bad") {

		echo '
			<div class="alert alert-danger">
					<strong>¡Error!</strong> Nombre de usuario o contraseña incorrectos.
			</div>
		';
	}


	if(($_REQUEST['act'] == "login") && ($_REQUEST['ulogin'] != "")) {

	 	$validacion = new SisifoAutenticadorLdap ( $_REQUEST['ulogin'] , 
			$_REQUEST['password'] );
		//echo $validacion -> valida();
		//exit();
		
		//try{
		if (  $validacion -> valida() ) {
			$validacion -> valida() ;
			// session_register("login");
			$_SESSION['login'] = $_REQUEST['ulogin'];
			// session_register("myip");
			$_SESSION['myip'] = $_SERVER['REMOTE_ADDR'];
			//echo ( '<a href="mostrar.php">ir </a>');exit();

			header("Location: mostrar.php");
	    } 
		else {
		//catch (Exception $e){
			//echo "hasta aquí bien";
			//exit();
			header("Location: index.php?act=bad");

	   }

	} else {
		
		echo '
				<div class="limiter">
					<div class="container-login100">
						<div class="wrap-login100">

							<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
								<span class="login100-form-title-1">
									Sísifo 2.0
								</span>
							</div>

							<form class="login100-form validate-form" action="./index.php" method=POST name="loginform">
								<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
									<span class="label-input100">usuario</span>
									<input class="input100" type="text" id="nombreUsuario" name="ulogin" placeholder="Introduzca el nombre de usuario">
									<span class="focus-input100"></span>
								</div>

								<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
									<span class="label-input100">contraseña</span>
									<input class="input100" type="password" name="password" placeholder="Introduzca la contraseña">
									<span class="focus-input100"></span>
								</div>
                                <input type="hidden" name="act" value="login">

								<div class="flex-sb-m w-full p-b-30">
								</div>

								<div class="container-login100-form-btn">
									<button type="submit" class="login100-form-btn">
										entrar
									</button>
								</div>
							</form>							
						</div>						
					</div>
				</div>
		';
	}


?>



<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script src="js/main.js"></script>

    <script type="text/javascript">
        document.getElementById("nombreUsuario").focus();
    </script>


</body>
</html>
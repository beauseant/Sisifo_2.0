<?PHP

	$sisifoConf     = new Configuracion ( $_SESSION ['fichero'] );
	$uploaddir = $sisifoConf -> getRutaTmp ();







	$maxSize = 9000000;
	$uploadSize = $_FILES['adjunto']['size'];

	#en disco lo guardamos con un nombre aleatorio:
	$name_path = md5 ($_FILES['adjunto']['name']) . (string)(rand(1, 100)) . $_FILES['adjunto']['name'] ;

	if ( ($uploadSize<$maxSize) && (move_uploaded_file($_FILES['adjunto']['tmp_name'], $uploaddir . $name_path)) ) {
	     	#echo "File is valid, and was successfully uploaded.\n";
	        $size = $_FILES['adjunto']['size'];
	        $type = $_FILES['adjunto']['type'];	        

			$size = file_size ( $size );


			$fichero = new SisifoUpload ();
			$fichero -> insertar ( $pid, $mensaje ->getId(), $_FILES['adjunto']['name'], $size, $name_path, $type );

	}else {

		echo '
			<div class="alert alert-danger">
			    No se ha podido adjuntar el fichero, compruebe el tamaño (del fichero)...
			</div>
		';

	}






?>	
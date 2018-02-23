<?PHP

		echo '
              <div class="card-header">
                <i class="fa fa-paper-plane"> Mensajes de la incidencia <b>'. $pid .'</b></i>
              </div>
        ';

	     $cc = $Incidencia -> getCC ();		
	       
	    $sisifoConf  	= new Configuracion ( $_SESSION ['fichero'] );
	    $inci_mail 	= $sisifoConf -> getIncimail();
     	$auten = new SisifoAutenticadorLdap ("", "");

     	$lista_mensajes = new SisifoArchivoMensaje ( $pid );
     
        $mensajes = $lista_mensajes -> buscar() ;
      	$salida = '<div class="card-header"><div class="table-responsive"> <table class="table table-bordered" id="example" class="display" cellspacing="0" width="100%">
              <thead><tr><th>fecha</th><th>de</th><th>a</th><th>cc</th><th>adjunto</th><th>contenido</th></tr>
              </thead>
              <tbody>
            ';
		$fila = '';
		foreach ($mensajes as $i) {

			if ( $i -> getDe() == 0 ) {
				$de = $inci_mail;
			} else {
				$de =  $auten -> getLogin ( $i -> getDe() );
			}

			if ( $i -> getA() == 0 ) {
				$a = $inci_mail;
			} else {
				$a =  $auten -> getLogin ( $i -> getA() );
			}


      $adjunto = '';
      if ($i -> getAdjunto()[0]){
        $adjunto = '<a href="' . $i -> getAdjunto()[3] . '" target="_blank" ><i class="fa fa-fw fa-paperclip"></i></a>';
      }

        	$fila = $fila. '<tr>' .
        	      '<td>'. $i -> getfecha(). '</td>' .                  
                  '<td>'. $de . '</td>' .
                  '<td>'. $a . '</td>' .
                  '<td>'. $cc . '</td>' .
                  '<td>'. $adjunto . '</td>' .
                  '<td>'. $i -> gettexto(). '</td>' .
                '</tr>';
      	}
      	
      	$salida = $salida . $fila . '</tbody></table></div></div>';

      	echo $salida;
?>
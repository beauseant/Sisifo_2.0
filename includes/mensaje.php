<?PHP



	    $sisifoConf  	= new Configuracion ( $_SESSION ['fichero'] );
	    $inci_mail 	= $sisifoConf -> getIncimail();
       $auten = new SisifoAutenticadorLdap ("", "");


     	$lista_mensajes = new SisifoArchivoMensaje ( $pid );

       
      $mensajes = $lista_mensajes -> buscar() ;


      //Valor inicial, si existen se machaca este valor:
      $salida = 'No existen mensajes para esa incidencia...';
      $fila = '';


      
      if (sizeof ($mensajes)  > 0) {


          $i = $mensajes[0];


          if ( $i -> getDe() == 0 ) {
            $de = $inci_mail;
          } else {
            $de =  $auten -> getLogin ( $i -> getDe() );
          }

        
          $cc = $Incidencia -> getCC ();    

          if ( $i -> getA() == 0 ) {
            $a = $inci_mail;
          } else {
            $a =  $auten -> getLogin ( $i -> getA() );
          }
        
          echo '
          <div class="card-header">
            <ul class="list-group">
              <li class="list-group-item list-group-item-info">de: '. $de .', a: '. $a. ' (con copia a: ' .  $cc . ')</li>
            </ul>
          </div>
        ';


        $salida = '<div class="card-header"><div class="table-responsive"> <table class="table-sm table table-bordered" id="example" class="display" cellspacing="0" width="100%">
              <thead><tr><th>fecha</th></th><th>adjunto</th><th>contenido</th></tr>
              </thead>
              <tbody>
            ';
        $fila = '';      
      }
      
  		foreach ($mensajes as $i) {

        $adjunto = '';
        if ($i -> getAdjunto()[0]){
          $adjunto = '<a href="' . $i -> getAdjunto()[3] . '"  title="'. $i -> getAdjunto()[2] .'" target="_blank" ><i class="fa fa-fw fa-paperclip"></i></a>';
        }

          	$fila = $fila. '<tr>' .
          	      '<td>'. $i -> getfecha(). '</td>' .                  
                    '<td>'. $adjunto . '</td>' .
                    '<td style="white-space: pre-line;">'. $i -> gettexto(). '</td>' .
                  '</tr>';
        	}
        	
        	$salida = $salida . $fila . '</tbody></table></div></div>';

        	echo $salida;
?>


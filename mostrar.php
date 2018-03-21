  <?php
      session_start(); 
      include ("includes/lib.php");
      include("includes/generic_page.php"); 

      require_once("classes/class.SisifoIncidencia.php");
      require_once("classes/class.SisifoArchivo.php");        

      $sisifoConf  = new Configuracion ( "sisifo.xml" );
      
        
       if(isLoggedIn()) {
        #echo 'Conectado como <b>' . $_SESSION ['login'];
        echo '
              <div class="card-header">
                <i class="fa fa-paper-plane"> Incidencias enviadas por el usuario <b>'. $_SESSION ['login'] .'</b></i>
              </div>
            ';

      $uid = getUID($_SESSION['login']);
       }else {
          echo '
              <div class="alert alert-warning">
                    <strong>Acceso no autorizado</strong> ¿Ha probado a <A href="index.php">registrarse</A>?.
              </div>
          ';
            exit();
       }


    $SisifoInfo = $sisifoConf -> getSisifoConf ();
    $SisifoArchivo = new SisifoArchivo();
    

    $incidencias = $SisifoArchivo->getAllInciUser ();
    

    if ( $incidencias ) {

      $fila = '';      

      $salida = '<div class="card-header"><div class="table-responsive"> <table class="table table-striped table-bordered  table-sm" id="example" class="display" cellspacing="0" width="100%">
              <thead><tr><th>Id</th><th>tipo</th><th>estado</th><th>fecha</th><th>fecha resolucion</th><th width="20">descripción</th><th>con copia a</th></tr>
              </thead>
              <tbody>
            ';
      


      #el color de la letra depende del estado de la incidencia:
      $bg = getBgColor ();

      foreach ($incidencias as $i) {  
      
        $fila = $fila. 
                  '<tr>' .                  
                    '<td>
                        <form METHOD="POST" id="'. $i['id'] . '" action="detalles.php" >
                            <a style="text-decoration: underline;" href="#" onclick="document.getElementById(\''. $i['id'] .'\' ).submit()"> '. $i['id']. '</a>
                            <input type="hidden" name="pid" value="'. $i['id'] . '"</input>
                            <input type="hidden" name="tipo_incidencia" value="'. $i['tipo'] . '"</input>
                        </form>
                    </td>' .
                    '<td>'. $i['tipo']. '</td>' .
                    '<td class="'. $bg[$i['estado']] . '">'. $i['estado']. '</td>' .
                    '<td>'. $i['fecha_llegada']. '</td>' .
                    '<td>'. $i['fecha_resolucion']. '</td>' .
                    '<td>'. $i['desc_breve']. '</td>' .
                    '<td>'. $i['cc']. '</td>' .
                  '</tr>
                  ';

      }
      $salida = $salida . $fila . '</tbody></table></div></div>';

      echo $salida;

    }else {   
          echo '
                    <div class="alert alert-warning">
                    Usted aún no ha enviado ninguna incidencia al sistema.
              </div>
          ';
    }   
          
  ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <!-- Scroll to Top Button-->

    <?php
      include ("includes/logout_modal.php");
      include ("includes/generic_footer.html");

    ?>

    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>


    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <script type="text/javascript">
      // For demo to fit into DataTables site builder...
      $('#example')
        .removeClass( 'display' )
        .addClass('tdisplay').dataTable({
      "columns": [
        { "width": "5%" },
        { "width": "15%" },
        { "width": "15%" },
        { "width": "15%" },
        { "width": "15%" },
        { "width": "30%" },
        { "width": "5%" }
      ],
      "order":[[0,'desc']]
        });
    </script>




  </div>


</body>

</html>

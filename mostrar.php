<?php include("includes/generic_page.html"); ?>
  <?php

  
    session_start(); 

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
        echo"Ha probado a <A href=\"index.php\">registrarse</A>?";
      exit();
       }


    $SisifoInfo = $sisifoConf -> getSisifoConf ();
    $SisifoArchivo = new SisifoArchivo();
    

    $incidencias = $SisifoArchivo->getAllInciUser ();
    

    if ( $incidencias ) {

      $fila = '';

      $salida = '<div class="card-header"><div class="table-responsive"> <table class="table table-bordered" id="example" class="display" cellspacing="0" width="100%">
              <thead><tr><th>Id</th><th>estado</th><th>tipo</th><th>fecha</th><th>fecha resolucion</th><th width="20">descripción</th><th>con copia a</th></tr>
              </thead>
              <tbody>
            ';
      foreach ($incidencias as $i) {        
        $fila = $fila. '<tr>' .
                  '<td><a href="detalles.php?pid='.$i['id'] . '&tipo_incidencia=' .  $i['tipo'] .'"</a>'. $i['id']. '</td>' .
                  '<td>'. $i['estado']. '</td>' .
                  '<td>'. $i['tipo']. '</td>' .
                  '<td>'. $i['fecha_llegada']. '</td>' .
                  '<td>'. $i['fecha_resolucion']. '</td>' .
                  '<td>'. $i['desc_breve']. '</td>' .
                  '<td>'. $i['cc']. '</td>' .
                '</tr>';
      }
      $salida = $salida . $fila . '</tbody></table></div></div>';

      echo $salida;

    }else {   
      echo '<center>Usted aun no ha enviado ninguna incidencia al sistema</center>';
    }   
          
  ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>

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
        { "width": "5%" },
        { "width": "5%" },
        { "width": "25%" },
        { "width": "25%" },
        { "width": "30%" },
        { "width": "5%" }
      ]     
        });
    </script>



  </div>


</body>

</html>

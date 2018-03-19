<?php 
    session_start(); 
    include ("includes/libAdmin.php");

    require_once("includes/generic_page.php"); 
  	set_include_path(get_include_path() . PATH_SEPARATOR . '../');
    require_once("../includes/lib.php");
    require_once("../classes/class.SisifoIncidencia.php");
    require_once ("../classes/iterator/class.IncidenciaIterator.php");
    require_once ("../classes/iterator/class.TipoIncidenciaIterator.php");
    require_once ("../classes/iterator/class.EstadoIncidenciaIterator.php");
    require_once ("../classes/autenticar/class.SisifoAutenticador.php");


    $sisifoConf  = new Configuracion ( "../sisifo.xml" );



    if( !isset($_SESSION['login'] ) ) {
            echo '
                <div class="alert alert-warning">
                      <strong>Acceso no autorizado</strong> ¿Ha probado a <A href="../index.php">registrarse</A>?.
                </div>
            ';
              exit();
    }


    $uid = getUID($_SESSION['login']);


    if( ($uid == 0 ) ) {
            echo '
                <div class="alert alert-warning">
                      <strong>Acceso no autorizado</strong> ¿Ha probado a <A href="../index.php">registrarse</A>?.
                </div>
            ';
              exit();
    }

    	if (!  esAdmin() ) {

        echo '
            <div class="alert alert-warning">
                  <strong>Acceso no autorizado</strong>. Debe ser administrador para acceder a esta zona.
            </div>
        ';
          exit();


    	}


      $uid = getUID($_SESSION['login']);  

      $sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

      $SisifoInfo = $sisifoConf -> getSisifoConf ();  
      $limit_admin = $SisifoInfo -> getLimitAdmin();

      $posInicio = 0;
      if ( isset ($_REQUEST['posInicio']) ) {
        $posInicio = $_REQUEST['posInicio'];
      }


      if (! isset ($_REQUEST['estado']) ) {
        $estado = "";
        $tipo = "";
      }else {
        $estado = $_REQUEST['estado'];
        $tipo = $_REQUEST['tipo'];
      }

      //$ordenfecha = $_REQUEST['ordenfecha'];

      if ( ! isset($estado) || ($estado == "") ) {
        $estado = 3;
      }




      if ( (!isset($ordenfecha)) || ($ordenfecha == "")) {
        if (isset ($_REQUEST['ordenfecha'])){
          $ordenfecha = $_REQUEST['ordenfecha'];
        }else {
          $ordenfecha = "";
        }
      }

      if ( $ordenfecha == "DESC") {
        $fichero_img = '<i class="fa fa-sort-down"></i>';
        $ordenfecha = "DESC";
        
      }else if( $ordenfecha == "ASC") {
        $fichero_img = '<i class="fa fa-sort-up"></i>';
        $ordenfecha = "ASC";
        
      }
      else {
        $fichero_img = '<i class="fa fa-sort-down"></i>';
        $ordenfecha = "DESC";
        
      }




      $sql = sacarCadenaSQL ( $tipo, $estado, $ordenfecha );

      $_SESSION ['incidencias_totales'] = sacarNumInci ( $sql );

      #print 'mostrar:' . $limit_admin . ' desde pos:' . $posInicio . 'para tipo:' . $tipo ;
      if( ($uid != 0 ) ) {
        $iterator = new IncidenciaIterator ( $sql, $limit_admin, $posInicio  );
      }

      
      $validacion = new SisifoAutenticadorLdap ( "","");



  ?>
<div class="card-header">
  <i class="fa fa-paper-plane"> Incidencias enviadas por todos los usuarios:</i>
        <table cellpadding=0 cellspacing=0 border=0 align="center">
         
          <tr>   
            <td>
              <form name="opciones" action="mostrar.php" method=POST>
                <input type="hidden" name="id">
                <input type="hidden" name="posInicio" value=0>
                <input type="hidden" name="ordenfecha">
                <table>
                  <tr>
                    <td>
                      <select class="form-control"  name=estado>
                        <option value="-1" SELECTED>todas
                        <?php
                          mostrarEstadosInci ($estado);
                        ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control"  name=tipo>
                        <option value="-1">todas
                        <?php
                          mostrarTiposInci ( $tipo );
                        ?>
                      </select>
                    </td> 
                    <td>
                      <input class="btn btn-primary" type=submit value="Mostrar">          
                    </td>
                      
                  </tr>
                </table>
            </form>
            </table>
</div>

<?php 
    include ("includes/pintarTablaInci.php");  
?>




          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

    <?php
      include ("../includes/logout_modal.php");
      include ("../includes/generic_footer.html");
    ?>



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
  </div>


</body>

</html>

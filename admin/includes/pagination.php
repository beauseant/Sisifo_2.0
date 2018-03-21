<?php	

    
    $num_pages =  round ($_SESSION['incidencias_totales'] / $limit_admin, 0);

    if ($_SESSION['incidencias_totales'] % $limit_admin > 0){

        $num_pages++;
    }
    
    
    
    if ($num_pages > $limit_admin*2) {

        $num_pages_real = $num_pages;
        $num_pages = $limit_admin;
    }

    if ($posInicio < 0){
        $posInicio = 1;
    }


    $contador = 1;

    if ((isset ($num_pages_real)) && ($num_pages_real == $posInicio)) {    
        $contador = $num_pages_real - $limit_admin;
    }

    $num_pages = ( $posInicio > $num_pages  ) ? $posInicio : $num_pages;



    echo '
                <nav aria-label="admin pagination">
                    <form id="buscar" method="POST" action="mostrar.php" enctype="multipart/form-data">                    
                        <input type="hidden" name="estado" value="'. $estado . '"</input> 
                        <input type="hidden" name="tipo" value="'. $tipo . '"</input> 
                        <input type="hidden" name="posInicio" value="'. 1 . '"</input> 
                        <ul class="pagination justify-content-end">
    ';
    for($i = $contador; $i<=$num_pages; $i++) {
                if ($i == $posInicio){
                    echo '<li class="page-item active"><a class="page-link" id="patata" onclick="newPos ('. $i .')">'. $i . '</a></li>';
                }else{
                    echo '<li class="page-item"><a class="page-link" onclick="newPos ('. $i .')">'. $i . '</a></li>';
                }
    }


    if (($posInicio == $num_pages ) && (isset ($num_pages_real)) && ( $posInicio < $num_pages_real ) ){
        $posInicio++;
        echo '<li class="page-item"><a class="page-link" onclick="newPos ('. $posInicio .')">'. $posInicio . '</a></li>';
    }
    


    if (isset ($num_pages_real)){
        echo '<li class="page-item"><a class="page-link" href="#">...</a></li>';
        echo '<li class="page-item"><a class="page-link" id="patata" onclick="newPos ('. $num_pages_real .')">'. $num_pages_real . '</a></li>';

    }

    echo '
                    </ul>
                </form>
                </nav>
                ';

?>

<script>
   function newPos (pos)
   {
      //formName is the name of your form, submitType is the name of the submit button.
      document.forms["buscar"].elements["posInicio"].value = pos;
      document.getElementById('buscar').submit()


   }
</script>
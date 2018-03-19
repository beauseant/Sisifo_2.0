<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="msgModaLabel"><i class="fa fa-paper-plane"> <?php echo 'Mensajes de la incidencia '. $pid ; ?></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php

              include ('includes/mensaje.php');
              
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adjModal">enviar nuevo mensaje</button>

      </div>
    </div>
  </div>
</div>

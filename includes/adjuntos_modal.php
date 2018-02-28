<div class="modal fade" id="adjModal" tabindex="-1" role="dialog" aria-labelledby="adjModaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adjModaLabel"><i class="fa fa-paper-plane"> <?php echo 'Enviar mensaje para la incidencia: '. $pid ; ?></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
              include ('includes/enviarmsg.php');
        ?>

      </div>
    </div>
  </div>
</div>

<?PHP

	echo '
          <div class="card-header">
            <i class="fa fa-envelope">to: '. $inci_mail .'</i><br>
            <i class="fa fa-clone"> cc: '. $Incidencia -> getCC().'</i>
			<div class="form-group">
  				<textarea class="form-control" rows="5" id="comment"></textarea>
  				<button type="button" class="btn btn-success">Enviar</button>
			</div>
		</div>
	';

?>	


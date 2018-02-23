
<?PHP

	echo '
		<form method="POST" action="detalles.php" enctype="multipart/form-data">
	          <div class="card-header">
	            <i class="fa fa-envelope">to: '. $inci_mail .'</i><br>
	            <i class="fa fa-clone"> cc: '. $Incidencia -> getCC().'</i>
				<div class="form-group">
	  				<textarea class="form-control" rows="5" name="texto" id="idtexto"></textarea>
	  				<input type="submit" class="btn btn-success" value="Enviar">	  				
					<label class="custom-file">
						<input type="file" name="adjunto" id="fileinput" />
					</label>
					<input type="hidden" name="pid" value="'. $pid . '"</input>
                    <input type="hidden" name="tipo_incidencia" value="'. $tipo_incidencia . '"</input>
                    <input type="hidden" name="cc" value="'. $Incidencia -> getCC() . '"</input>
                    <input type="hidden" name="inci_mail" value="'. $inci_mail . '"</input>
				</div>
			  </div>
		</form>
	';

?>	



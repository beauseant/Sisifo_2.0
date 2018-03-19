<?php
#        extract($_REQUEST);
	extract($_REQUEST);

	if (!isset($id)){

		$id = "";
	}

	if (!isset($newPos2)){
		$newPos2 = "";
	}


?>
		<div class="card-header"><div class="table-responsive">

		<table class="table table-striped  table-sm" width="100%">			
			 <thead>
			    <tr>
					<th class="sorting_desc">Id</th>
					<th>Usuario</th>
					<th>Descripcion</th>
					<th>Tipo</th>
					<th>Fecha llegada
						<?php echo  '<a href="javascript: OrdenarFecha(\'' . $ordenfecha . '\')"'?>						
						<?php echo $fichero_img; ?>
	 					</a></th>
					<th>Estado</th>
			    </tr>
			  </thead>
			<tbody>
			<?php
				while ( !($iterator -> EOF() ) ) {
					$incidencia = $iterator -> fetch ();
					if ( ( $incidencia -> getId() ) == $id ) {
						$bgColor = "6699FF";
					}
					$camposInci = mostrarIncidencias ( $validacion, $incidencia, $posInicio );
					echo '<tr>
								<td>
									<form METHOD="POST" id="'. $camposInci[0] . '" action="detalles.php" >
										<input class="btn btn-success" type="submit" value="'. $camposInci[0] . '"></input>
										<input type="hidden" name="pid" value="'. $camposInci[0] . '"</input>
										<input type="hidden" name="tipo_incidencia" value="'. $camposInci[3] . '"</input>
									</form>
								</td>
								<td>' . $camposInci[1] . '</td>
								<td>' . $camposInci[2] . '</td>
								<td>' . $camposInci[3] .'</td>
								<td>' . $camposInci[4] .'</td>
								<td>' . $camposInci[5] .'</td>
						  </tr>
						  ';										
				}
			?>
		</tbody>
		</table>
	
	</div>
	<div class="row bg-secondary">
		<div class="col-md-8">
			<table>
				<tr>

					<td  bgcolor="#dddddd"> 
					<?php
						echo '<input type="hidden" name="posInicio" VALUE="'.$newPos2. '">';
						$newPos2 = $posInicio - $limit_admin;
						if ( $newPos2 >= 0 ) {
							echo '<form method="POST" action="mostrar.php" enctype="multipart/form-data">' . 
								 '		<input type="hidden" name="posInicio" value="'. $newPos2 . '"</input>' .
								 '		<input type="hidden" name="estado" value="'. $estado . '"</input>' .
								 '		<input type="hidden" name="tipo" value="'. $tipo . '"</input>' .
								 '		<button type="submit" class=""><i class="fa fa-arrow-circle-left"></i></button>' .
								 '</form>'
								 ;							
						}
					?>						
					</td>
				
					<td bgcolor="#dddddd"> 
					<?php
						$newPos = $posInicio + $limit_admin;
						if ($newPos < $_SESSION['incidencias_totales']){
							echo '<form method="POST" action="mostrar.php" enctype="multipart/form-data">' . 
								 '		<input type="hidden" name="posInicio" value="'. $newPos . '"</input>' .
								 '		<input type="hidden" name="estado" value="'. $estado . '"</input>' .
								 '		<input type="hidden" name="tipo" value="'. $tipo . '"</input>' .
								 '		<button type="submit" class=""><i class="fa fa-arrow-circle-right"></i></button>' .
								 '</form>'
								 ;

						}
					?>
				</tr>
			</table>
		</div>
		<div class="col-md-4">
						<?php echo '[' . $newPos . '/' . $_SESSION['incidencias_totales'] . ']';?>
		</div>
	</div>

					



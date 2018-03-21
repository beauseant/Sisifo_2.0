<?php
#        extract($_REQUEST);
	extract($_REQUEST);


	if (!isset($id)){

		$id = "";
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
					<th>Fecha llegada</th>
					<th>Estado</th>
			    </tr>
			  </thead>
			<tbody>

			<?php

				$bg = getBgColor();
				while ( !($iterator -> EOF() ) ) {
					$incidencia = $iterator -> fetch ();

					
					$camposInci = mostrarIncidencias ( $validacion, $incidencia, $posInicio );
					echo '<tr>
								<td>
									<form METHOD="POST" id="'. $camposInci[0] . '" action="detalles.php" >
										<a style="text-decoration: underline;" href="#" onclick="document.getElementById(\''. $camposInci[0] .'\' ).submit()"> '. $camposInci[0] . '</a>
										<input type="hidden" name="pid" value="'. $camposInci[0] . '"</input>
										<input type="hidden" name="tipo_incidencia" value="'. $camposInci[3] . '"</input>
									</form>
								</td>
								<td>' . $camposInci[1] . '</td>
								<td>' . $camposInci[2] . '</td>
								<td>' . $camposInci[3] .'</td>
								<td>' . $camposInci[4] .'</td>
								<td class="'. $bg[$camposInci[5]] . '">' . $camposInci[5] .'</td>
						  </tr>
						  ';										
				}
			?>
		</tbody>
		</table>
	
	</div>


<?php	
	include ('includes/pagination.php')


?>					



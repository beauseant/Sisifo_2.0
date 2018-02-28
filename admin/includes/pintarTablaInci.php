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

		<table class="table table-striped" width="100%">			
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
		<center>
			<table width=100%>
				<tr>					
					<td align="right" valign="middle" bgcolor="#dddddd"> 
					<?php
						$newPos = $posInicio + $limit_admin;
						if ($newPos < $_SESSION['incidencias_totales']){
							echo '<a href="javascript: calcularInicioAdminInci(\'' . $newPos . '\')">';
							echo '<img src="../Documentos/Imagenes/ver.gif" border=0 title="Ver siguientes" alt="Ver siguientes"></a>';	
						}
					?>
						
					<?php
						echo '<input type="hidden" name="posInicio" VALUE="'.$newPos2. '">';
						$newPos2 = $posInicio - $limit_admin;
						if ( $newPos2 >= 0 ) {
							echo '<a href="javascript: calcularInicioAdminInci(\'' . $newPos2 . '\')">';
							echo '<img src="../Documentos/Imagenes/atras.gif" border=0 title="Ver anteriores" alt="Ver anteriores"></a>';
						}
						echo ' <br>[' . $newPos . '/' .
						$_SESSION['incidencias_totales'] . ']';
					?>
						
					</td>
				</tr>
			</table>
		</center>
	</td>
			
</tr>
</table>		

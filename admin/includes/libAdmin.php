<?php		

function sacarCadenaSQL ( $tipo, $estado, $ordenfecha )  {

	$sql = "SELECT id FROM incidencia ";
	
	if ( (!$estado) || ($estado == "-1") ) {
		$sql_estado = "WHERE id_estado > 0";
	}else {
		$sql_estado = "WHERE id_estado = " . $estado;
	}
	
	if ( (!$tipo) || ($tipo == "-1") ) {
		$sql_tipo = " AND tipo > 0";
	}else {
		$sql_tipo = " AND tipo = " . $tipo;
	}
	$sql = $sql . $sql_estado . $sql_tipo . " ORDER BY fecha_llegada " . $ordenfecha;
	
	return $sql;

}

function sacarNumInci ( $sql ) {
		 $iterator = new IncidenciaIterator ( $sql,
			 -1, -1  );
		return $iterator -> size();

}


function mostrarEstadosInci ( $estado ) {
	
	$iteratorEstadoInc = new EstadoIncidenciaIterator ();
	$contador = 1;
	while ( !($iteratorEstadoInc -> EOF() ) ) {
		$resultado = $iteratorEstadoInc ->fetch();
		echo '<option value="' . $contador;
		if ( $estado == $contador ) {
			echo '" SELECTED>';
		}else {
			echo '">';
		}
		echo  $resultado ;
		$contador++;
	}
}

function mostrarTiposInci ( $tipo ) {

	$iteratorTipoInc = new TipoIncidenciaIterator ();
	$contador = 1;
	while ( !($iteratorTipoInc -> EOF() ) ) {
		$resultado = $iteratorTipoInc ->fetch();
		echo '<option value="' . $contador;
		if ( $tipo == $contador ) {									
			echo '" SELECTED>';
		}else {
			echo '">';
		}
		echo  $resultado ;
		$contador++;
	}
}


//modificada 2018
function mostrarIncidencias ( $validacion, $incidencia, $posInicio ) {

$mailusr = $validacion -> getLogin ( $incidencia -> getIdUsuario() );

$linkVerInci ='"<A href="javascript: abrirAdminInci (\''. $_SESSION ['base_url'] .
			 '/admin/\',\'' . $incidencia ->getId() .'\',\'' . $posInicio . '\')">
		<img alt="' . $incidencia ->getId() .'" title="Incidencia ' . $incidencia ->getId() .'"
			src="../Documentos/Imagenes/ver.gif" border=0></A>"';

return ( [$incidencia -> getId(), $mailusr, $incidencia -> getDescBreve(), 
			$incidencia -> getTipo(), $incidencia -> getFechaLlegada(), 
			$incidencia -> getEstado(), $linkVerInci
		]
	);
}


?>
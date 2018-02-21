<?php 

	//require_once ( "phplot/phplot.php" );
 	require_once ("class.SisifoIncidencia.php");
	require_once ('singleton/class.Configuracion.php');
    	require_once ("autenticar/class.SisifoAutenticador.php");


class SisifoEstadisticas {


var $db;
var $data;
var $meses;

	function SisifoEstadisticas () {

		$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
		$this -> db = $sisifoConf -> getBd();
		$this -> meses = array('Enero','Febrero','Marzo','Abril','Mayo',
			'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
			'Noviembre', 'Diciembre');
	}

function mmmr($array, $output = 'mean'){
    if(!is_array($array)){
        return FALSE;
    }else{
        switch($output){
            case 'mean':
                $count = count($array);
                $sum = array_sum($array);
                $total = $sum / $count;
            break;
            case 'median':
                rsort($array);
                $middle = round(count($array) / 2);
                $total = $array[$middle-1];
            break;
            case 'mode':
                $v = array_count_values($array);
                arsort($v);
                foreach($v as $k => $v){$total = $k; break;}
            break;
            case 'range':
                sort($array);
                $sml = $array[0];
                rsort($array);
                $lrg = $array[0];
                $total = $lrg - $sml;
            break;
        }
        return $total;
    }
} 


	function listaYears () {
	        $sql = "SELECT EXTRACT(YEAR FROM fecha_llegada) as fecha FROM incidencia group by fecha order by fecha;";
                $resultUsuario = $this -> db -> Execute ( $sql );
		$salida = array ();

		while ( ! $resultUsuario  -> EOF ) {
			array_push ( $salida, $resultUsuario -> fields['fecha']);
			$resultUsuario-> MoveNext();		
		}
                return  ($salida);
	}

	function tiempoResolucion () {
		$sql = "select   extract (epoch from ( fecha_resolucion - fecha_llegada )/3600)  from incidencia where id_estado=1";
		$resultUsuario = $this -> db -> Execute ( $sql );
		$salida = array ();

                while ( ! $resultUsuario  -> EOF ) {
                        array_push ( $salida, $resultUsuario -> fields['fecha']);
                        $resultUsuario-> MoveNext();
                }
		return $salida;
	}


	function getNumIncis ( $y ) {
		$sql = "select count(id) from list_by_year where fecha='" . $y ."'";
                $result = $this -> db -> Execute ( $sql );
		return $result -> fields [0];

	}

	function estadisResoluc () {


		$validacion = new SisifoAutenticadorLdap ( "","");
		$sql = "SELECT COUNT(*) from incidencia where id_estado = 1";
		$resultUsuario = $this -> db -> Execute ( $sql );
                $numtotal = $resultUsuario  -> fields['0'];


		$sql = "SELECT DISTINCT(id_usuario) from anotacion where texto like '%RESUELTA%'";
		$resultSetEstado = $this -> db -> Execute ( $sql );	
		$cadena = "<UL>";
		while ( ! $resultSetEstado  -> EOF ) {
                        $id_usuario = $resultSetEstado -> fields['id_usuario'];
			$sql = "SELECT COUNT(*) FROM anotacion WHERE texto like '%RESUELTA%' AND id_usuario='" . $id_usuario. "'";
			$resultUsuario = $this -> db -> Execute ( $sql );
			$numincis = $resultUsuario  -> fields['0'];
			$usuario = $validacion -> getLogin ( $id_usuario );
			$cadena = $cadena . "<OL> El administrador <B>" .  $usuario . "</B> ha cerrado " . $numincis . " incidencias (" . ($numincis / $numtotal) * 100 . " %)";
			$resultSetEstado -> MoveNext();
		}
		
		$cadena = $cadena . "</UL>";	
		return $cadena;
	}

	function estadisTipoResumen ( $year, $id_usr  ) {

		$sql = "SELECT * FROM tipo_incidencia";
		$resultSetEstado = $this -> db -> Execute ( $sql );
		$resultado = array();
		$contador = 1;
		
		// /************* esto se lo he añadido yo **********/
		$resultado2 = array();
		$resultado2 [0] = "Tipos";
		
		//echo " id usuario " . $id_usr;
		//echo " año " . $year;

		while ( ! $resultSetEstado  -> EOF ) {
			$id_tipo = $resultSetEstado -> fields['id'];
			$desc_tipo = $resultSetEstado -> fields['descripcion'];
			
			$sql = "SELECT COUNT(*) as \"numInci\" FROM Incidencia WHERE
				 tipo = " . $id_tipo;

			if ( $id_usr == -1) {
				$sql = $sql . " AND id_usuario > 0";
			} else {
				$sql = $sql . " AND id_usuario = " . $id_usr;
			}
			if ( $year ) {
				$sql = $sql . " AND date_trunc('year',fecha_llegada) = TIMESTAMP '". $year . "-01-01 00:00:00'";
			}
	
			//echo "<          !!!!resultado!!!!: >" . $sql;
			
			// $resultSet = $this -> db -> Execute ( $sql );
			// $contador2 = $contador + 1;
			// $resultado [$contador] = array();
			// $resultado [$contador][0] = $desc_tipo;
			// $aux = 1;
			// while ( $aux < $contador2 ) {
				// $resultado[$contador][$aux]='';
				// $aux++;
			// }
			// $resultado [$contador][$contador2] = $resultSet -> fields  ['numInci'];
			// $resultSetEstado -> MoveNext();
			// $contador++;
		// }
				
	
				$resultSet = $this -> db -> Execute ( $sql );
				$resultado2 [$contador] = (int)$resultSet -> fields  ['numInci'];
				$resultSetEstado -> MoveNext();
				$contador++;

			}
			
		$resultado[0]=$resultado2;
		
		$this -> data = $resultado;
	}

	function estadisEstadoResumen ( $year, $id_usr  ) {

		$sql = "SELECT * FROM estado_inci";
		$resultSetEstado = $this -> db -> Execute ( $sql );
		$resultado = array();
		$contador = 1;
		
		$resultado2 = array();
		$resultado2 [0] = "Tipos";

		// echo " id usuario " . $id_usr;
		// echo " año " . $year;
		
		while ( ! $resultSetEstado  -> EOF ) {
			$id_estado = $resultSetEstado -> fields['id_estado_in'];
			$desc_estado = $resultSetEstado -> fields['descripcion'];
			
			$sql = "SELECT COUNT(*) as \"numInci\" FROM Incidencia WHERE
				 id_estado = " . $id_estado;

			if ( $id_usr == -1 ) {
				$sql = $sql . " AND id_usuario > 0";
			} else {
				$sql = $sql . " AND id_usuario = " . $id_usr;
			}
			if ( $year ) {
				$sql = $sql . " AND date_trunc('year',fecha_llegada) = TIMESTAMP '". $year . "-01-01 00:00:00'";
			}
	
			//echo "<          !!!!resultado!!!!: >" . $sql;
	
			// $resultSet = $this -> db -> Execute ( $sql );
			// $resultado [$contador] = array();
			// $resultado [$contador][0] = $desc_estado;
			// $contador2 = $contador + 1;
			// $aux = 1;
			// while ( $aux < $contador2 ) {
				// $resultado[$contador][$aux]='';
				// $aux++;
			// }
			// $resultado [$contador][$contador2] = $resultSet -> fields  ['numInci'];
			

			// $resultSetEstado -> MoveNext();
			// $contador++;
		// }
		
				$resultSet = $this -> db -> Execute ( $sql );
				$resultado2 [$contador] = (int)$resultSet -> fields  ['numInci'];
				$resultSetEstado -> MoveNext();
				$contador++;

			}
			
		$resultado[0]=$resultado2;
		$this -> data = $resultado;

	}

	function estadisTipoCompleta ( $year, $id_usr  ) {
	
		
		$resultado = array();
		for ( $contadormes = 0 ; $contadormes < 12 ; $contadormes++ ) {
			$resultado [$contadormes] = array();
			$resultado [$contadormes][0] = $this -> meses[$contadormes];
			$sql = "SELECT * FROM tipo_incidencia";
			$resultSetEstado = $this -> db -> Execute ( $sql );
			$contador = 1;
			while ( ! $resultSetEstado  -> EOF ) {
				$id_tipo = $resultSetEstado -> fields['id'];
				$desc_tipo = $resultSetEstado -> fields['descripcion'];
			
				$sql = "SELECT COUNT(*) as \"numInci\" FROM Incidencia WHERE
						tipo = " . $id_tipo;
				if ( $id_usr == -1) {
					$sql = $sql . " AND id_usuario > 0";
				} else {
					$sql = $sql . " AND id_usuario = " . $id_usr;
				}
				$contadormesstr = $contadormes + 1;	
				if ( $contadormesstr < 10 ) {
					$contadormesstr = "0".$contadormesstr;
				}
				if ( $year ) {
					$sql = $sql . " AND date_trunc('month',fecha_llegada) = TIMESTAMP '". $year . 
						"-" . $contadormesstr . "-01 00:00:00'";
				}
				
				//echo "<          !!!!resultado!!!!: >\n" . $sql;
				
				$resultSet = $this -> db -> Execute ( $sql );
				$resultado [$contadormes][$contador] = $resultSet -> fields  ['numInci'];
				$resultSetEstado -> MoveNext();
				$contador++;
			}
		}
		$this -> data = $resultado;
	}


	function estadisEstadoCompleta ( $year, $id_usr  ) {

	
		
		$resultado = array();
		for ( $contadormes = 0 ; $contadormes < 12 ; $contadormes++ ) {
			$resultado [$contadormes] = array();
			$resultado [$contadormes][0] = $this -> meses[$contadormes];
			$sql = "SELECT * FROM estado_inci";
			$resultSetEstado = $this -> db -> Execute ( $sql );
			$contador = 1;
			while ( ! $resultSetEstado  -> EOF ) {
				$id_estado = $resultSetEstado -> fields['id_estado_in'];
				$desc_estado = $resultSetEstado -> fields['descripcion'];
			
				$sql = "SELECT COUNT(*) as \"numInci\" FROM Incidencia WHERE
						id_estado = " . $id_estado;
				if ( $id_usr == -1 ) {
					$sql = $sql . " AND id_usuario > 0";
				} else {
					$sql = $sql . " AND id_usuario = " . $id_usr;
				}
				$contadormesstr = $contadormes + 1;	
				if ( $contadormesstr < 10 ) {
					$contadormesstr = "0".$contadormesstr;
				}
				if ( $year ) {
					$sql = $sql . " AND date_trunc('month',fecha_llegada) =  TIMESTAMP '". $year . 
						"-" . $contadormesstr . "-01 00:00:00'";
				}
				
				//echo "<          !!!!resultado!!!!: >\n" . $sql;
				
				$resultSet = $this -> db -> Execute ( $sql );
				$resultado [$contadormes][$contador] = $resultSet -> fields  ['numInci'];
				$resultSetEstado -> MoveNext();
				$contador++;
			}
		}
		$this -> data = $resultado;
	}




	function getData () {
		return $this -> data;
	}	

	function pintar ( ) {

	}


}

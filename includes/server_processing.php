<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'listAllInci';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
#incidencia.id,estado_inci.descripcion, incidencia.id_usuario AS estado,tipo_incidencia.descripcion AS tipo, fecha_llegada,fecha_resolucion,desc_breve,cc
$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array( 'db' => 'estado',  'dt' => 'estado' ),
    array( 'db' => 'id_usuario',  'dt' => 'id_usuario' ),
    array( 'db' => 'tipo',   'dt' => 'tipo' ),
    array( 'db' => 'fecha_llegada','dt' => 'fecha_llegada'),
    array( 'db' => 'fecha_resolucion','dt' => 'fecha_resolucion'),
    array( 'db' => 'desc_breve','dt' => 'desc_breve' ),
    array( 'db' => 'cc','dt' => 'cc' )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'dbadmin',
    'pass' => 'Mpv32125@Up',
    'db'   => 'incisisifo',
    'host' => '192.168.151.207'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

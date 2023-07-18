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
$table = 'tb_pricelist';

// Table's primary key
$primaryKey = 'id_pricelist';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`gambar_produk`', 'dt' => 1, 'field' => 'gambar_produk' ),
	array( 'db' => '`u`.`judul_produk`',  'dt' => 2, 'field' => 'judul_produk' ),
	array( 'db' => '`ud`.`nama_ktg`', 'dt' => 3, 'field' => 'nama_ktg' ),
	array( 'db' => '`u`.`berat_produk`', 'dt' => 4, 'field' => 'berat_produk'),
	array( 'db' => '`u`.`harga`', 'dt' => 5, 'field' => 'harga' ),
	//array( 'db' => '`u`.`update_time`', 'dt' => 6, 'field' => 'update_time' ),
	array( 'db' => '`u`.`kode_produk`',  'dt' => 6, 'field' => 'kode_produk' )
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `tb_pricelist` AS `u` JOIN `tb_kategori` AS `ud` ON (`ud`.`id_ktg` = `u`.`ktg_produk`)";
$extraWhere = "";
$groupBy = "";
$having = "";

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
);

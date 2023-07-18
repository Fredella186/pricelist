<?php

 include "connect.php";
 buka_koneksi(); 

require_once '../Classes_excel/PHPExcel.php';
require_once '../Classes_excel/PHPExcel/Writer/Excel2007.php';
require_once '../Classes_excel/PHPExcel/IOFactory.php';

try {
    $filename      = 'contoh.xlsx';
    $inputFileType = \PHPExcel_IOFactory::identify($filename);
    $objReader     = \PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel   = $objReader->load($filename);
}
catch (Exception $e) {
    die('Error loading file "' . pathinfo($filename, \PATHINFO_BASENAME) . '": ' . $e->getMessage());
}

$sheet      = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
echo $highestRow;
echo '<br/>';

for ($row = 1; $row <= $highestRow; $row++) {
    $rowData = $sheet->rangeToArray('A' . $row . ':C' . $row, NULL, TRUE, FALSE);
    //$rowData = $rowData[0];

    $judul = $rowData[0][1];
    echo '<pre>';
    //print_r($rowData);

    $query =  mysql_query("SELECT * FROM tb_pricelist WHERE judul_produk LIKE '$judul' ");

    //print_r($query);

    while($data = mysql_fetch_array($query))
    {
        if ($judul === $data['judul_produk']){

            $id_pr = $data['id_pricelist'];
            
            $query = "UPDATE tb_pricelist SET status_view =1 WHERE id_pricelist = ".$id_pr;
            mysql_query($query);

            echo 'produk dihidden: '.$data['judul_produk'];

        } else {
            echo 'Tidak sama';
        }
        
    }
}
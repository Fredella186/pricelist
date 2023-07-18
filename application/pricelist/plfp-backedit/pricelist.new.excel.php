<?php
session_start();
include "connect.php";
buka_koneksi();

/** PHPExcel */
require_once '../Classes_excel/PHPExcel.php';

$object = new PHPExcel();
$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'font' => array('size'=>20)
);
$style2 = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'font' => array('size'=>12,'color' => array('rgb' => 'FFFFFF'),'bold'=>true),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FF0000')
    )
);
// Add some data
$object->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$object->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$object->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$object->getActiveSheet()->mergeCells('A1:C1');
$object->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style);
$object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'FastPrint - Price List')
            ->setCellValue('A4', 'Nama Produk')
            ->setCellValue('C4', 'SKU');
            // ->setCellValue('C4', 'Harg');
$object->getActiveSheet()->getStyle('A4:C4')->applyFromArray($style2);


    // Rename sheet
$object->getActiveSheet()->setTitle('export_pricelist_'.date('Y-m-d'));



 $ke = 5;
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$ex = $object->setActiveSheetIndex(0);
$mysql = mysql_query("SELECT *  FROM `tb_pricelist` WHERE `ktg_produk` = 10 AND `judul_produk` LIKE '%HP%' ORDER BY judul_produk ASC");
while($d = mysql_fetch_array($mysql)){

    $ex->setCellValue("A".$ke,$d['judul_produk']);
    $ex->setCellValue("B".$ke,$d['kode_produk']);
    $ex->setCellValue("C".$ke,"CISS Infus Modifikasi");
    // $ex->setCellValue("B".$ke,"Rp " . number_format($d['harga'],2,',','.'));
    // $ex->setCellValue("C".$ke,$d['berat_produk'].' Gr');
    


    $ke++;

}










 
 
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="export_pricelist_'.date('Y-m-d').'.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
$objWriter->save('php://output');
header('location:index.php');
?>
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

    $arr_list_stok = array(
                        'stok' => 'PUSAT',
                        'stok_jkt' => 'JKT',
                        'stok_bdg' => 'BDG',
                        'stok_mks' => 'MKS',
                    );
    // Add some data
    $object->getActiveSheet()->getColumnDimension('A')->setWidth(50);
    $object->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $object->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $object->getActiveSheet()->mergeCells('A1:C1');
    $object->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style);
    $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'FastPrint - Price List')
                ->setCellValue('A3', 'Nama Produk')->mergeCells('A3:A4')
                ->setCellValue('B3', 'SKU')->mergeCells('B3:B4')
                ->setCellValue('C3', 'Harga')->mergeCells('C3:C4')
                ->setCellValue('D3', 'Berat')->mergeCells('D3:D4');
                

    $col_stok_awal = 'D';
    foreach ($arr_list_stok as $cstok => $nstok) {
        $col_stok_awal++;
        $object->setActiveSheetIndex(0)
                ->setCellValue(''.$col_stok_awal.'4', $nstok);
    }

    $object->setActiveSheetIndex(0)
        ->setCellValue('E3', 'STOK')->mergeCells('E3:'.$col_stok_awal.'3');

    $object->getActiveSheet()->getStyle('A3:'.$col_stok_awal.'4')->applyFromArray($style2);


    // Rename sheet
    $object->getActiveSheet()->setTitle('export_pricelist_'.date('Y-m-d'));



    $ke = 5;
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $ex = $object->setActiveSheetIndex(0);
    // $mysql = mysql_query('SELECT * FROM `tb_pricelist` ORDER BY id_pricelist DESC');
    if($_SESSION['excel']['query'] != '' && $_SESSION['excel']['query'] != 'all'){
        $mysql = mysql_query($_SESSION['excel']['query']);

    }else{
        $mysql = mysql_query('SELECT * FROM `tb_pricelist` ORDER BY id_pricelist DESC');    
    }

    while($d = mysql_fetch_array($mysql)){

        $ex->setCellValue("A".$ke,$d['judul_produk']);
        $ex->setCellValue("B".$ke,$d['kode_produk']);
        $ex->setCellValue("C".$ke,"Rp " . number_format($d['harga'],2,',','.'));
        $ex->setCellValue("D".$ke,$d['berat_produk'].' Gr');
        
        $col_stok_awal = 'E';
        foreach ($arr_list_stok as $cstok => $nstok) {

            $ket_stok = 'READY';
            if($d[$cstok] == 0){
                $ket_stok = 'KOSONG';
            }

            $ex->setCellValue(''.$col_stok_awal.$ke,$ket_stok);
            $col_stok_awal++;
        }

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
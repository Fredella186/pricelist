<?php

    // get the HTML
    ob_start();
    $cat = $_GET['cat'];
    include('pl_pdf.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once('plugins/html2pdf/vendor/autoload.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
        //~ $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('test.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    //~ require_once('plugins/tcpdf/tcpdf.php');
    //~ require_once('connect.php');

    //~ buka_koneksi();

    //~ $cat = $_GET['cat'];
    //~ $a = mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$cat."'");
    //~ $ktg = mysql_fetch_array($a);


    //~ $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //~ // set document (meta) information
    //~ $pdf->SetCreator(PDF_CREATOR);
    //~ $pdf->SetAuthor('FastPrint Indonesia');
    //~ $pdf->SetTitle('PDF - Price List '.date('Y').' FP');
    //~ $pdf->SetSubject('PDF FP Price List');
    //~ $pdf->SetKeywords('FP, PDF, Price List, Report');

    //~ // set default header data
    //~ $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    //~ $pdf->setFooterData(PDF_PAGE_FORMAT, array(0,64,0), array(0,64,128));

    //~ // set header and footer fonts
    //~ $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    //~ $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //~ // set default monospaced font
    //~ $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //~ // set margins
    //~ $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //~ $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //~ $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //~ // set auto page breaks
    //~ $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //~ // set image scale factor
    //~ $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //~ // set font
    //~ $pdf->SetFont('helvetica', '', 10);
    //~ $pdf->setFontSubsetting(false);

    //~ // add a page
    //~ $pdf->AddPage();

    //~ // -----------------------------------------------------------------------------

    //~ $html = '
    //~ <style>
        //~ th{
            //~ text-align: center;
            //~ font-weight: bold;
            //~ background-color: #ccc;
        //~ }
        //~ .center {
            //~ height: 100px;
            //~ line-height:100px;
        //~ }
        //~ p {
            //~ font-size: 14pt;
            //~ font-weight: bold;
        //~ }
    //~ </style>
    //~ <p align="center">Price List '.$ktg['nama_ktg'].' '.date('Y').'</p>
    //~ <br>
    //~ <br>
    //~ <table border="1">
        //~ <tr>
          //~ <th height="25" width="30">#</th>
          //~ <th height="25" width="100">Gambar</th>
          //~ <th height="25" width="400">Nama</th>
          //~ <th height="25" width="175">Harga</th>
          //~ <th height="25" width="120">Harga 10%</th>
          //~ <th height="25" width="70">Berat</th>
          //~ <th height="25" width="60">Link</th>
        //~ </tr>';

    //~ $qPL = mysql_query("SELECT * FROM tb_pricelist WHERE ktg_produk = '".$cat."'");
    //~ $no = 1;
    //~ while($data = mysql_fetch_assoc($qPL)){
        //~ $html .= '<tr>
            //~ <td align="center">'.$no.'</td>
            //~ <td class="center" align="center"><br><img src="assets/images/'.$data['gambar_produk'].'" width="70" height="70" /></td>
            //~ <!--td> '.$data['gambar_produk'].'</td-->
            //~ <td> '.$data['judul_produk'].'<br> Kode : '.$data['kode_produk'].'</td>
            //~ <td valign="middle" align="center"> <b>'.rupiah($data['harga']).'</b><br>
            //~ <table border="1">
                //~ <tr>
                    //~ <th>Qty</th>
                    //~ <th>Satuan</th>
                //~ </tr>';
            //~ $qGR = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$data['kode_produk']."'");
            //~ var_dump("SELECT * FROM tb_wholesale WHERE id_produk = '".$data['kode_produk']."'");exit;
            //~ while($datas = mysql_fetch_array($qGR)){
                //~ $html .= '<tr>
                    //~ <td align="left"> '.$datas['rentang_qty'].' pcs</td>
                    //~ <td>'.rupiah($datas['harga_wholesale']).'</td>
                //~ </tr>';
            //~ }
        //~ $html .= '</table></td>
            //~ <td align="center"> '.rupiah($data['harga_10']).'</td>
            //~ <td align="center"> '.berat($data['berat_produk']).'</td>
            //~ <td align="center"><a href='.$data['link_produk'].'>Link FP</a></td>
        //~ </tr>';
        //~ $no++;
    //~ }

    //~ $html .= '</table>';

    //~ $pdf->writeHTML($html, true, false, false, false, '');

    //~ //Close and output PDF document
    //~ $pdf->Output('PriceList-'.$ktg['nama_ktg'].'-'.date('Y').'.pdf', 'F');
    //~ tutup_koneksi();
    //============================================================+
    // END OF FILE
    //============================================================+

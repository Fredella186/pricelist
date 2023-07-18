<?php
session_start();
include "connect.php";
buka_koneksi();
require('../fpdf/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}



$pdf=new PDF_MC_Table();
//Table with 20 rows and 4 columns
$pdf->AddPage("P");
$pdf->SetFont('Arial','B',18);
// Move to 8 cm to the right
$pdf->Cell(80,0);
// Centered text in a framed 20*10 mm cell and line break
$pdf->Cell(20,10,'FastPrint - Price List',0,1,'C');

$pdf->SetFont('Helvetica','B',12);

$pdf->SetWidths(array(15,105,40,30));
$pdf->Row(array('NO','NAMA PRODUK','HARGA','BERAT'));
$ke=1;
$mysql = mysql_query('SELECT * FROM `tb_pricelist` ORDER BY id_pricelist DESC');
$pdf->SetFont('Helvetica','',10 );

while($d = mysql_fetch_array($mysql)){
    
    //$gmbar = 'assets/images/'.$d['gambar_produk'];

    $pdf->Row(array($ke,$d['judul_produk'],"Rp " . number_format($d['harga'],2,',','.'),$d['berat_produk'].' Gr'));


    $ke++;

}

$pdf->Output('pricelist_'.date('Y-m-d').'.pdf', 'I');




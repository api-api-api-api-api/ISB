<?php
//////////
$this->layout='report';
error_reporting(E_ALL);
App::import('Vendor', 'excel', array('file' => 'excel/PHPExcel.php'));
App::import('Model','User');
$user = new User();
//error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);
date_default_timezone_set('Asia/Jakarta');
// Panggil class PHPExcel nya
$excel = new PHPExcel();
//var_dump($headLaporan);exit();
//set nama nama file render
$namaFile=$namesheet1;
//var_dump($namaFile);exit();
// Settingan awal fil excel
$excel  ->getProperties()->setCreator('EDP')
        ->setLastModifiedBy($namaFile)
        ->setTitle($namaFile)
        ->setSubject($namaFile)
        ->setDescription($namaFile)
        ->setKeywords($namaFile);

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
    'font'        => array('bold' => true), // Set font nya jadi bold
    'alignment'   => array(
        'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical'    => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top'     => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left'    => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
    'alignment' => array(
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
    'borders' => array(
        'top'     => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left'    => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);
$style_noborders = array(
    'font'        => array('bold' => true), // Set font nya jadi bold
    'alignment'   => array(
        'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical'    => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    )
);
$styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                 'color' => array('argb' => '00000000'), 
                ), 
            ), 
        );
// buat array untuk kolom
$array = Array();//karakter untuk A sampai Z
for( $i = 65; $i < 91; $i++){
    $array[] = chr($i);
}
$array2 = Array();//karakter untuk A sampai ZZ
for($x='A';$x<'ZZ';$x++){
    $array2[]=$x;
}     
$excel->createSheet();
$excel->setActiveSheetIndex(0);
$worksheet = $excel->getActiveSheet();
//set baris;
$baris=3;
$n=0;
$txtHead=$headLaporan;
$columnDimension=[];
$columnDimensionHead=[];

// BODY
$worksheet->setCellValue('A1',$namesheet1);
//$worksheet->getStyle('A1:D3')->applyFromArray($style_col);
//txtHead
    $pecah=explode("|",$txtHead);
    $n=0; 
    $k=0;
    foreach($pecah as $pch){
        if(empty($columnDimension[$n])){$columnDimension[$n]=strlen($pch);}
        if((int)strlen($pch)>(int)$columnDimension[$n]){$columnDimension[$n]=strlen($pch);}else{$columnDimension[$n]=$columnDimension[$n];}       
        $worksheet->SetCellValue($array2[$n].$baris.'', $pch);
       
        $worksheet->getStyle($array2[$n].$baris)->applyFromArray($style_noborders);
        $n++;
    }   
    $baris++; 

    
// End Txt Head
$txtBody=$bodyLaporan;
//var_dump($txtBody);exit();
    
    $pecah2=explode("^",substr($txtBody,0,strlen($txtBody)-1));
    $m=0;
   //var_dump($pecah2);
    //exit();
    foreach($pecah2 as $pch2){
        $pecah3=explode("|",substr($pch2,0,strlen($pch2)-1));
        $h=0;
        //var_dump($kueri);
        foreach($pecah3 as $pch3){  
          if(empty($columnDimension[$h])){$columnDimension[$h]=strlen($pch3);}
          if(strlen($pch3)>intval($columnDimension[$h])){$columnDimension[$h]=strlen($pch3);}else{$columnDimension[$h]=intval($columnDimension[$h]);}
          $worksheet->SetCellValue($array2[$h].$baris.'',$pch3);          
            $h=$h+1;
        }
            //exit();
        $baris++;             
        $m++;
    }

// END BODY

for($j=0;$j<count($columnDimension);$j++){ 
    if($columnDimension[$j]==""||$columnDimension[$j]<=5){$lebar=6;}else{$lebar=$columnDimension[$j] *1.2;}
    $excel->getActiveSheet()->getColumnDimension($array2[$j])->setWidth(($lebar));    
}
$worksheet = $excel->getActiveSheet()->setTitle($namesheet1);
   //$excel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($style_row);
   // var_dump($array2[0]."1".':'.$array2[$n-1].($baris-$k));exit(); 
   // $excel->getDefaultStyle($array2[0]."1".':'.$array2[$m-30].($baris-$k))->applyFromArray($styleArray);
   // $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$worksheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$worksheet->getPageMargins()->setTop(1);
$worksheet->getPageMargins()->setRight(0.5);
$worksheet->getPageMargins()->setLeft(0.5);
$worksheet->getPageMargins()->setBottom(0.5);
$worksheet->getPageSetup()->setHorizontalCentered(true);
//$worksheet->getPageSetup()->setPrintArea('A1:'.$array2[$n-1].$baris.'');
$worksheet->getPageSetup()->setPrintArea('A1:D5');
$worksheet->getPageSetup()->setFitToPage(true);
 //var_dump($headKPDM);exit();
    //end KPDM

$filename=trim($namaFile.".xls");
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();

$write->save('php://output');

exit;	

?>
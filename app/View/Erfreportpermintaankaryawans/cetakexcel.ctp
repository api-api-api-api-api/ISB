<?php
$this->layout='report';
error_reporting(E_ALL);
App::import('Vendor', 'excel', array('file' => 'excel/PHPExcel.php')); 	
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');
    if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
                
    $excel = new PHPExcel();
    
    App::import('Model','User');
    $user = new User();
    
    $excel->createSheet();
    $excel->setActiveSheetIndex(0);
    $worksheet = $excel->getActiveSheet();
    $namaFile="Report ".$namaSheet;
    //var_dump($namaFile);exit();
    $excel->getProperties()->setCreator("EDP")
											 ->setLastModifiedBy("EDP")
											 ->setTitle($namaFile)
											 ->setSubject($namaFile)
											 ->setDescription($namaFile)
											 ->setKeywords($namaFile)
											 ->setCategory("REPORT EMPLOYEE RECRUITMENT");		
                                                             			 
		    // merubah style border pada cell yang aktif (cell yang terisi)
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
                $styleArray = array( 'borders' => 
                                array( 'allborders' => 
                                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                    'color' => array('argb' => '00000000'), 
                                        ), 
                                ), 
                            );
                
                // melakukan pengaturan pada header kolom
                $fontHeader = array( 
                                'font' => array(
                                    'bold' => true
                                    ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation'   => 0,
                                    ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                
                                    )
                            );
                $fontHeaderC = array( 
                                'font' => array(
                                    'bold' => true
                                    ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation'   => 0,
                                    ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                
                                    )
                            );
                            
                // mengatur font list right dengan border
               
                $FLR = array( 
                    'font' => array(
                        'bold' => false
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                'rotation'   => 0,
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                
                            )
                        );
                // mengatur font list left
                $FLL = array( 
                        'font' => array(
                            'bold' => false
                            ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            )
                        );
                // mengatur font list center dengan border
                $FLC = array( 
                        'font' => array(
                            'bold' => false
                            ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            )
                        );
                        
                $FLr = array( 
                        'font' => array(
                            'bold' => false
                            ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            ),
                        );
                       

                      
                        
                        $txtHead="no|tanggal|pemohon|Dasar Permintaan|Jumlah^|||1|2|3|4|5|"; 
                        $array = Array();
                        $array2 = Array();
                        for( $i = 65; $i < 91; $i++){
                            $array[] = chr($i);
                        }
                        for($x='A';$x<'ZZ';$x++){
                            $array2[]=$x;
                        }
                        $baris=1;
                        $worksheet->SetCellValue($array2[0].$baris.'', $reportPermintaan);      
                        $worksheet->SetCellValue($array2[0].'2'.'','Bulan :'. $bulan);       
                        $worksheet->SetCellValue($array2[0].'3'.'', 'Tahun :'.$tahun);   
                       
                        //var_dump($k);exit();
                        $columnDimension=[];
                        $columnDimensionHead=[];
                        $k=0;
                       
                        $baris=4;
                        if(strpos($txtHead,"^")>0){
                            $pecah1=explode("^",substr($txtHead,0,strlen($txtHead)));
                                //var_dump($txtHead);exit();
                            foreach($pecah1 as $pch1){
                                $pecah=explode("|",$pch1);            
                                $n=0;
                                foreach($pecah as $pch){
                                    if(strlen($pch)>intval($columnDimension[$n])){$columnDimension[$n]=strlen($pch);}
                                    $worksheet->SetCellValue($array2[$n].$baris.'', $pch);
                                    if($pch=='Dasar Permintaan'){
                                        $worksheet->mergeCells($array2[$n].$baris.':'.$array2[$n+4].$baris);
                                        $n=$n+4;
                                    }
                                    
                                    if($n>1 && $n % 2 == 0&&$baris==1){
                                        $worksheet->mergeCells($array2[$n].$baris.':'.$array2[$n+1].$baris);
                                        $worksheet->getStyle($array2[$n].$baris.':'.$array2[$n+1].$baris)->getAlignment()->setWrapText(true);
                                    }
                                    $n++;
                                }
                                $baris++; 
                                $k++;
                            }
                        }else{
                            $pecah=explode("|",$txtHead);
                            $n=0; 
                            foreach($pecah as $pch){                            
                                if(empty($columnDimension[$n])){$columnDimension[$n]=strlen($pch);}
                                if((int)strlen($pch)>(int)$columnDimension[$n]){$columnDimension[$n]=strlen($pch);}else{$columnDimension[$n]=$columnDimension[$n];}                                   
                                $worksheet->SetCellValue($array2[$n].$baris.'', $pch);
                                    //var_dump($pch);
                                    // if($array2[$n]=='A'){
                                    //   $worksheet->mergeCells(array2[$n].'1:'.array2[$n].'2');
                                    // }
                                    //var_dump($columnDimensionHead);
                                $worksheet->getStyle($array2[$n].$baris)->applyFromArray($style_col);
                                $n++;
                            }
                                //$worksheet->mergeCells('A1:A2');
                            $baris++; 
                            $k++;
                        }
                                $baris=6;
                                $pecahBuffer=explode("!",substr($buffer,0,strlen($buffer)));
                                $txtBody=$pecahBuffer[0];
                                $jmlTotP1=$pecahBuffer[1];
                                $jmlTotP2=$pecahBuffer[2];
                                $jmlTotP3=$pecahBuffer[3];
                                $jmlTotP4=$pecahBuffer[4];
                                $jmlTotP5=$pecahBuffer[5];      
                                $jumTotPengajuan=$pecahBuffer[6]; 
                                $pecah2=explode("^",substr($txtBody,0,strlen($txtBody)-1));
                                    
                                    $m=1;
                                    //var_dump($pecah2);
                                    foreach($pecah2 as $pch2){
                                       
                                    $pecah3=explode("|",substr($pch2,0,strlen($pch2)));
                                   
                                    $h=0;
                                   
                                    //var_dump($kueri);
                                    $worksheet->SetCellValue($array2[0].$baris.'',$m);
                                    foreach($pecah3 as $pch3){  
                                      if(empty($columnDimension[$h])){$columnDimension[$h]=strlen($pch3);}
                                      if(strlen($pch3)>intval($columnDimension[$h])){$columnDimension[$h]=strlen($pch3);}else{$columnDimension[$h]=intval($columnDimension[$h]);}
                                      
                                    //   $pch3pecah=explode("~",substr($pch3,0,strlen($pch3)));
                                    //   var_dump($pch3pecah);
                                    //   exit();
                                    //   if($pch3pecah[0]=='01'){
                                    //     $worksheet->getCell($array2[$h].$baris.'')
                                    //     ->setValueExplicit(trim($pch3pecah[1]), PHPExcel_Cell_DataType::TYPE_STRING);
                                     
                                    //   }else{
                                    //     $worksheet->SetCellValue($array2[$h].$baris.'',trim($pch3pecah[0]));
                                    //   }
                                      
                                        $worksheet->SetCellValue($array2[$h].$baris.'',$pch3);
                                        $worksheet->getStyle($array2[$h].$baris.':'.$array2[$h+1].$baris)->getAlignment()->setWrapText(true);
                                    //  var_dump($h);
                                     
                                        $h=$h+1;
                                        };
                                       
                                        //exit();
                                    $baris++; 
                                    $m++;
                                };
                                    
                                $worksheet->SetCellValue($array2[0].$baris.'', 'Jumlah');
                                $worksheet->mergeCells($array2[0].$baris.':'.$array2[2].$baris);
                                $worksheet->SetCellValue($array2[3].$baris.'', $jmlTotP1);
                                $worksheet->SetCellValue($array2[4].$baris.'', $jmlTotP2);
                                $worksheet->SetCellValue($array2[5].$baris.'', $jmlTotP3);
                                $worksheet->SetCellValue($array2[6].$baris.'', $jmlTotP4);
                                $worksheet->SetCellValue($array2[7].$baris.'', $jmlTotP5); 
                                $worksheet->SetCellValue($array2[8].$baris.'', $jumTotPengajuan); 
                                //var_dump($txtHead);exit();   
                                // exit();
                            //var_dump($columnDimension);exit();
                            for($j=0;$j<count($columnDimension);$j++){
                                //$columnDimension[$j];
                                
                              if($columnDimension[$j]==""||$columnDimension[$j]<=5){$lebar=6;}else{$lebar=$columnDimension[$j] *1.2;}
                              //var_dump($lebar.$array2[$j]);
                              $excel->getActiveSheet()->getColumnDimension($array2[$j])->setWidth(($lebar));
                              
                            
                              }
                              //exit();
                            //   /var_dump($baris);exit();
                            // Get sheet dimension
                        
                            $namesheet1=$tahun."-".$bulan;
                            //   // Apply text format to numbers
                            // $worksheet->getStyle($sheet_dimension)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                            $worksheet = $excel->getActiveSheet()->setTitle($namaFile);
                            //$worksheet = $excel->getActiveSheet()->setTitle($namesheet1);
                           //$excel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($style_row);
                            // var_dump($array2[0]."1".':'.$array2[$n-1].($baris-$k));exit();
                            $worksheet->getStyle($array2[0]."4".':'.$array2[$n-1].($baris))->applyFromArray($styleArray);
                            // $excel->getDefaultStyle($array2[0]."1".':'.$array2[$m-30].($baris-$k))->applyFromArray($styleArray);
                            // $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                            $worksheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                            $worksheet->getPageMargins()->setTop(1);
                            $worksheet->getPageMargins()->setRight(0.5);
                            $worksheet->getPageMargins()->setLeft(0.5);
                            $worksheet->getPageMargins()->setBottom(0.5);
                            $worksheet->getPageSetup()->setHorizontalCentered(true);
                            $worksheet->getPageSetup()->setPrintArea('A1:'.$array2[$n-1].$baris.'');
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
                        // We'll be outputting an excel file
                        // /header('Content-type: application/vnd.ms-excel');

                        // It will be called file.xls
                       // header('Content-Disposition: attachment; filename="file.xls"');
                        $write->save('php://output');
                
            exit();
            
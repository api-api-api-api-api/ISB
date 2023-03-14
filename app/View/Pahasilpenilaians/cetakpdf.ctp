<?php 
$this->layout='report';
App::import('Vendor', 'PDF', array('file' => 'dompdf/autoload.inc.php'));
//App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));

use Dompdf\Dompdf;

$dompdf = new Dompdf();

//$query = mysqli_query($koneksi,"select * from tb_siswa");

/*

if(strpos($dataRnd,"|")>0){
        $pecah1=explode("|",substr($dataRnd,0,strlen($dataRnd)));
        
        
            $tbodyProdRecord="";
            $id=$pecah1[0];
            $kodeProd=$pecah1[1];
            $namaProd=$pecah1[2];
            $deskripsi=$pecah1[3];
            $tglInput=$pecah1[4];
            $fase=$pecah1[5];
            $status=$pecah1[6];
            $review=$pecah1[7];
            $idUserInput=$pecah1[8];
            $nmUserInput=$pecah1[9];
            //$jmlRow=count($namaProd);
            
            // var_dump($tglNie);exit();
           
        $tbodyProdRecord.="<tr><td>".$namaProd."</td></tr>";              
}

// 
$html='<html>';
               
$html='<style>
        hr{border: 3px solid black;
        margin:0 !important;}
        h1,h2,h3,h4,h5{margin:5px 0;}
        .tblStyle{
            font-size: 12px !important;
            font-family: verdana, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top:10px;
        }
        .tblStyle tr{
            page-break-before: always;
        }
        .tblStyle td{
            border: 1px solid black;
            text-align: center;
            //padding: 8px;
            padding: 0;
            margin: 0;

        }
        .tblStyle table.inner{
            width: 100%;
            margin: 0;
        }
        .tblStyle table.inner td{
            padding: 0;
            width: 50%;
            margin: 0;
            padding: 0;
            border: 0;
        }
        .tblStyle table.inner tr td{
            border-bottom: 1px solid black;
        }
        .tblStyle table.inner tr:last-child td{
            border-bottom: none;
        }
        .tblStyle th {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
            background-color: #dddddd;
        }
        .break{
            page-break-before: always;
        }
        </style>';
$html .= '<h3>Rnd REPORT</h3><hr/><br/>';
$html .= '
<table  width="100%">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td styel="padding-top:10px;" width="15%">Product Code</td>
                    <td width="2%">:</td>
                    <td width="25%">'.$kodeProd.'</td>
                    <td width="16%"></td>
                    <td width="15%" styel="padding-top:10px;">Phase</td>
                    <td width="2%"></td>
                    <td width="25%"></td>
                </tr>
                <tr>
                     <td styel="padding-top:10px;">User Input</td>
                     <td>:</td>
                     <td>'.$nmUserInput.'</td>
                     <td></td>
                     <td align="center" colspan="3"  style="font-size: 20px;font-weight: bold;border-top:1px solid #333;border-bottom:1px solid #333">'.$fase.'</td>
                 </tr>
                <tr>
                    <td styel="padding-top:10px;">Date Input</td>
                    <td>:</td>
                    <td>'.$tglInput.'</td>
                    <td></td>
                    <td>Status</td>
                    <td>:</td>
                    <td>'.$status.'</td>
                </tr> 
                <tr>
                    <td colspan="7"><h4 style="margin-bottom:0;">Record Product</h4></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <table  class="tblStyle" width="100%"  >
                            <thead><tr>
                                <th style="border-bottom:1px solid grey" width="100%">Product Name</th>
                                </tr>
                            </thead>
                            <tbody>'.$tbodyProdRecord.'
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <table  class="tblStyle" width="100%" >
                            <thead><tr>
                                <th style="border-bottom:1px solid grey" width="100%">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr><td height="150px">'.$deskripsi.'</td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
$html .= '<h4>Phase History</h4><hr/>';

$pecah2=explode("~",substr($dataHistory,0,strlen($dataHistory)-1));
        if($pecah2[0]=='Empt'){
            $html .= '<table width="100%"><tr><td alighn="center" style="height:200px;border:1px solid #333;"><h4>No Phase History</h4></td></tr></table>';
        }else{
            $jml=count($pecah2);
            
            $h=1;
            $html .='';
            foreach($pecah2 as $pch2){
                
                $getFase=explode("#",substr($pch2,0,strlen($pch2)-1));
                $html .='<strong><p>'.$getFase[0].'</p></strong>';
                //$pdf->Cell(190,5,$getFase[0],"" );
                
               
                $pecah3=explode("^",substr($getFase[1],0,strlen($getFase[1])));
                
                $jml=count($pecah3);
                foreach($pecah3 as $pch3){
                   
                    $data=explode("|",substr($pch3,0,strlen($pch3)));
                    
                    // $pdf->Cell(190,5,$data[1],'T',0,'L');
                    // $pdf->Ln();

                        $hisid=$data[0];
                        $hisidProd=$data[1];
                        $hiskodeProd=$data[2];
                        $hisFase=$data[3];
                        $hisoption=$data[4];
                        $histglInput=$data[5];
                        $hisreview=$data[6];
                        $hisIdUserInput=$data[7];
                        $hisNmUserInput=$data[8];
                       
                        $html .='<table  class="tblStyle" width="100%" style="margin:5px;padding:10px;">';
                       
                        $html .='<tr><td width="100px"><em>Date input </em>: </td><td width="300px"><strong>'.$histglInput.'</strong></td><td width="100px"><em>User Input </em>:</td><td><strong>'. $hisNmUserInput.'</strong></td></tr>
                                <tr><td colspan="4" style="padding-top:10px;"><em>Review Information</em></td></tr>
                                <tr><td colspan="4" style="height:100px;min-height:100px;border:1px solid #333;padding:10px;">'.$hisreview.'</td></tr>';
                                
                        $html .='</table>';
                      

                    $h++;
                               
                }
                
                
            }
           
            $html .='';
            
        }
        
*/
 

// $no = 1;
// while($row = mysqli_fetch_array($query))
// {
//  $html .= "<tr>
//  <td>".$no."</td>
//  <td>".$row['nama']."</td>
//  <td>".$row['kelas']."</td>
//  <td>".$row['alamat']."</td>
//  </tr>";
//  $no++;
// }
$html = $data;

$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');

// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('Rnd-report.pdf',array('Attachment'=>false));

exit();
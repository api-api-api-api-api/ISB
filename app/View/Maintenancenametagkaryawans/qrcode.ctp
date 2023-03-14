<?php
App::import('Vendor', 'PDF', array('file' => 'dompdf/autoload.inc.php'));
//App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));
App::import('Vendor', 'phpqrcode', array('file' => 'phpqrcode/qrlib.php'));



use Dompdf\Dompdf;

$dompdf = new Dompdf();

App::import('Model','User');
$user = new User();



        
     $txtData="";
     $style="";
     $dataId=explode('^',$isiId);
       //var_dump($dataId);exit();
     foreach($dataId as $value){
     	//var_dump($value);exit();
       $query="SELECT * FROM anumet.karyawans k 
					INNER JOIN anumet.anumets an ON an.nik=k.nik
					LEFT JOIN anumet.departemens de ON k.departemenId=de.id
					LEFT JOIN anumet.divisis di ON k.divisiId=di.id
					LEFT JOIN anumet.jabatans j ON k.jabatanId=j.id
					LEFT JOIN anumet.areas ar ON k.areaId=ar.id WHERE k.id='$value'";

			$tampil=$user->query($query);
			$nik=$tampil[0]['k']['nik'];
			QRcode::png($nik,"qrcode/".str_replace("/","_",$nik).".png","H",4,4);
       }
       //exit(0);
$html='<style>
        body { margin: 20px 10px 20px 10px; }
        hr{border: 3px solid black;margin:0 !important;}
        h1,h2,h3,h4,h5{margin:5px 0;}
       
        .tblStyle{font-family: arial;border-collapse: collapse;width: 100%;margin-top:5px;}
        .tblStyle td{text-align: center;/*padding: 8px;*/padding: 0;margin: 0;}
        .center{ margin-left: auto; 
  			margin-right: auto;}
        .break{page-break-before: always;}
        .tblHeader {
        	font-size: 11px !important;border-collapse: collapse;/*width:100%;*/margin-top:5px;
        	width: 200px;
        	/*background-image: url("'.$this->webroot.'qrcode/image/mkt1.jpg");*/
        	/*background-image: url("'.$this->webroot.'qrcode/image/bg.jpg");*/
        	/*background-image: url("qrcode/image/mkt1.jpg");*/
        	background-image: url("qrcode/image/bg.jpg");
        	background-size:100% 100p%;
        }
        
        .tblHeader tr td{text-align: center; padding:3px;font-weight:500;font-size:11px;width:200.3px;color:#ffffff}
        /*.image {background-color:#f8f8f8 !important;}*/
        .tblContent {font-size: 11px !important;border-collapse: collapse;width: 25%;margin-top:10px;}
        .tblContent tr td{border-bottom: 0.5px solid black;padding: 4px 8px;}
        .tblStyle  tr:last-child td{border-bottom: none;}
        .tblNofub {font-size: 11px !important;border-collapse: collapse;width: 100%;margin-top:20px;}
        .tblFooter {font-size: 11px !important;font-family: arial;border-collapse: collapse;width: 100%;margin-top:20px;}
        .tblFooter td{/*padding: 8px;*/padding: 0;margin: 0;vertical-align:top;border:0.5px solid black;}
        .tblFooter table.inner{width: 100%;margin: 0;}
        .tblFooter table.inner td{padding: 0;margin: 0;padding: 0;border: 0;}
        .tblFooter table.inner tr td{border-bottom: none;}
        .tblFooter table.inner tr:last-child td{border-bottom: none;}
        .tblFooter th {border: 1px solid black;text-align: center;padding: 8px;background-color: #dddddd;}
		.circle{		
			border-radius: 68px;
			width:136px;
			height:136px;
			margin-top:62px;
			margin-left:6px;
		}
		.barcode{
			width:50px;
			height:50px;
			margin-bottom:20px;
		}
        </style>';

$html.='<html>';
//$isi=$_POST['pilihHidden'];
$isi=explode('^',$isi);
$html .='<table class="tblStyle">';
$kanan=3;
$bawah=4;
$k=1;
foreach ($isi as $key=>$value) {
	//echo $key;

	$explodeLg=explode('~',$value);
	if($k==1){
		$html.="<tr>";
	}
//var_dump($explodeLg);exit();
	$id=$explodeLg[0];
	$nik=$explodeLg[1];
	$nama=$explodeLg[2];
	$jabatan=$explodeLg[3];
	$divisi=$explodeLg[4];
	$html .='<td width="33.3%" height="302.36px">';
	$html .='<table class="tblHeader center" >';
	//$html .="<tr><td height='195px'><img src=\"".$this->webroot."qrcode/image/poto.jpg\" width=\"30%\" class=\"circle\"></td></tr>";
	$html .="<tr><td height='195px'><img src=\"qrcode/image/poto.jpg\" width=\"30%\" class=\"circle\"></td></tr>";
	$html .='<tr><td>'.$nama.'</td></tr>';
	$html .='<tr><td>'.$jabatan.'</td></tr>';
   // $html .='<tr><td>'.$divisi.'</td></tr>';
    //$html .="<tr><td><img src=\"qrcode/".str_replace("/","_",$nik).".png\"></td></tr>";
	//$html .="<tr><td height='80px'><img src=\"".$this->webroot."qrcode/".str_replace("/","_",$nik).".png\" class=\"barcode\"></td></tr>";
	$html .="<tr><td height=80px'><img src=\"qrcode/".str_replace("/","_",$nik).".png\" class=\"barcode\"></td></tr>";
	$html .="</table>";
	$html .="</td>";
	if($k %3==0){
		$html.="</tr><tr>";
	}
	$k++;
}

$html .="</table>";
echo $html;exit(0);
//var_dump($html);exit();
//echo $html;//exit(0);
$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');            
 // Rendering dari HTML Ke PDF
$dompdf->render();

            // Melakukan output file Pdf
$dompdf->stream("dompdf_out.pdf",array('Attachment'=>0));
//$file_to_save = 'qrcode/';
//  $pdf = $dompdf->output();
//  $savein = $this->webroot.'qrcode/';
// file_put_contents( "file.pdf", $pdf); 

exit(0);
<?php 
//$this->layout='report';
App::import('Vendor', 'PDF', array('file' => 'dompdf/autoload.inc.php'));
//App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));

use Dompdf\Dompdf;

$dompdf = new Dompdf();

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
$html='<html>';


App::import('Model','User');
$user = new User();
$pdfQuery=$user->query("SELECT * FROM dpfdplnew.fupbs  WHERE generateID='$pdf' AND primCompatitor ='true'");
//var_dump($queryOriginator);exit();

$html.='<style>
        body { margin: 30px 30px 30px 40px; }
        hr{border: 3px solid black;margin:0 !important;}
        h1,h2,h3,h4,h5{margin:5px 0;}
        .tblStyle{font-family: Times New Roman;border-collapse: collapse;width: 100%;margin-top:10px;}
        .tblStyle td{text-align: center;/*padding: 8px;*/padding: 0;margin: 0;}
        .tblStyle table.inner{width: 100%;margin: 0;}
        .tblStyle table.inner td{padding: 0;width: 50%;margin: 0;padding: 0;border: 0;}
        .tblStyle table.inner tr td{border-bottom: 1px solid black;}
        .tblStyle table.inner tr:last-child td{border-bottom: none;}
        .tblStyle th {border: 1px solid black;text-align: center;padding: 8px;background-color: #dddddd;}
        .break{page-break-before: always;}
        .tblHeader {font-family: Times New Roman;border-collapse: collapse;width: 100%;margin-bottom:20px;}
        .tblHeader tr td{text-align: center; padding:0;}
        .tblContent {width:100%;}
        .tblContent tr td{padding:8px 0;}
        .tblFooter {font-family: Times New Roman;border-collapse: collapse;width: 100%;}
        </style>';

$html .='<table class="tblHeader">';
$html .='<tr><td><h3>PERSETUJUAN PRODUK BARU</h3></td></tr>';
$html .='<tr><td>'.$pdfQuery[0]['fupbs']['noFUPB'].'</td></tr>';
$html .='<tr><td style=" text-align: justify;text-justify: inter-word;padding-top:10px;">Berdasarkan hasil keputusan management, bersama ini kami minta kepada Tim R&D untuk melakukan trial dan menyiapkan dokumen registrasi terhadap produk berikut ini:</td></tr></table>';
$html .='<table class="tblContent">';
$html .='<tr><td style="width:30%;">Nama Produk</td><td style="width:3%;">:</td>';
$html .='<td>'.$pdfQuery[0]['fupbs']['prodName'].'</td></tr>';
$html .='<tr><td style="width:30%;">Perusahaan Originator</td><td style="width:3%;">:</td>';
$html .='<td>'.$pdfQuery[0]['fupbs']['brandName'].' - '.$pdfQuery[0]['fupbs']['namaCompany'].' (kompetitor utama)</td></tr>';
$html .='<tr><td style="width:30%;vertical-align: top !important;">Komposisi & Kemasan</td><td style="width:3%;vertical-align: top">:</td>';
$html .='<td>Tiap tablet mengandung: <br>'.$pdfQuery[0]['fupbs']['komposisi'].' <br> '.$pdfQuery[0]['fupbs']['unitPack'].' </td></tr>';
$html .='<tr><td style="width:30%;">Diminta Oleh</td><td style="width:3%;">:</td>';
$html .='<td style="font-weight:bold">'.$pdfQuery[0]['fupbs']['divName'].'</td></tr>';
$html .='<tr><td style="width:30%;vertical-align: top !important;">Komposisi & Kemasan</td><td style="width:3%;vertical-align: top">:</td>';
$html .='<td>Tiap tablet mengandung: <br>'.$pdfQuery[0]['fupbs']['komposisi'].' <br> '.$pdfQuery[0]['fupbs']['kemasan'].'</td></tr>';
$html .='<tr><td colspan="3"></td></tr>';
$html .='<tr><td colspan="3">Demikian hal ini kami informasikan dengan harapan dapat segera ditindaklanjuti.</td></tr>';
$html .='<tr><td colspan="3">Atas perhatian dan kerjasama yang baik, kami ucapkan terima kasih.</td></tr>';
$html .='<tr><td colspan="3">Jakarta, '.tgl_indo(date('Y-m-d')).'</td></tr>';
$html .='<tr><td colspan="3"></td></tr>';
$html .='<tr><td colspan="3">Diminta oleh,</td></tr></table>';
$divisiID=$pdfQuery[0]['fupbs']['divName'];
$queryUserAPP="SELECT*FROM dpfdplnew.fupbhistoryapprovals h INNER JOIN 
( SELECT * FROM dpfdplnew.linkuserfupbapprovals li WHERE li.divisiID IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals li WHERE li.divisiID = '$divisiID') AS li 
ON li.poinApp = h.poin INNER JOIN  (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id=li.userID WHERE h.generateID = '$pdf' ORDER BY h.poin ASC";
//var_dump($queryUserAPP);exit();
$pdfUserApp=$user->query($queryUserAPP);
$userProdev='';$jabatanProdev='';$imgttdProdev='';
$userProman='';$jabatanProman='';$imgttdProman='';
$userScient='';$jabatanScient='';$imgttdScient='';
$userBusdev='';$jabatanBusdev='';$imgttdBusdev='';
$userMkt='';$jabatanMkt='';$imgttdMkt='';
foreach($pdfUserApp AS $dataUserAPP){
    $pointtd=$dataUserAPP['h']['poin'];

    if(file_exists('img/fupb/'.$pdf.'_ttd_'.$pointtd.'.png')){
        $img='<img src="img/fupb/'.$pdf.'_ttd_'.$pointtd.'.png" style="width:200px;">';
        }else{
        $img='<img src="img/signatureicon.png" style="width:100px;">';
    }
   
    if($dataUserAPP['h']['poin']=='1'){
        $userProdev=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanProdev=$dataUserAPP['Us']['keterangan'];
        $imgttdProdev=$img;
    }elseif($dataUserAPP['h']['poin']=='21'){
        $userMkt=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanMkt=$dataUserAPP['Us']['keterangan'];
        $imgttdMkt=$img;
    }elseif($dataUserAPP['h']['poin']=='22'){
        $userScient=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanScient=$dataUserAPP['Us']['keterangan'];
        $imgttdScient=$img;
    }elseif($dataUserAPP['h']['poin']=='23'){
        $userProman=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanProman=$dataUserAPP['Us']['keterangan'];
        $imgttdProman=$img;
    }elseif($dataUserAPP['h']['poin']=='3'){
        $userBusdev=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanBusdev=$dataUserAPP['Us']['keterangan'];
        $imgttdBusdev=$img;
    }
}
$html .='<table class="tblFooter">';
$html .='<tr><td style="width:33%">'.$imgttdMkt.'</td><td style="width:33%"></td><td style="width:33%;">'.$imgttdProman.'</td></tr>';
$html .='<tr><td style="vertical-align:top;">Nama: '.$userMkt.'<br>'.$jabatanMkt.'</td><td></td><td  style="vertical-align:top;padding-left:10px;">Nama: '.$userProman.'<br>'.$jabatanProman.'</td></tr>';
$html .='<tr><td colspan="3" style="padding:10px;"></td></tr>';
$html .='<tr><td>Dibuat Oleh,</td><td></td><td style="padding-left:10px;">Disetujui Oleh,</td></tr>';
$html .='<tr><td>'.$imgttdProdev.'</td><td>'.$imgttdScient.'</td><td>'.$imgttdBusdev.'</td></tr>';
$html .='<tr><td  style="vertical-align:top;">Nama: '.$userProdev.'<br>'.$jabatanProdev.'</td><td  style="vertical-align:top;">Nama: '.$userScient.'<br>'.$jabatanScient.'</td><td style="vertical-align:top;padding-left:10px;">Nama: '.$userBusdev.'<br>'.$jabatanBusdev.'</td></tr>';
$html .='</table>';





//var_dump($html);exit();



$html .= '</html>';
 
$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
 
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('FUPB-.pdf',array('Attachment'=>false));
exit();
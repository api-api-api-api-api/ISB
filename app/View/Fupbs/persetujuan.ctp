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
$html='<style>
        body { margin: 25px 25px 25px 40px; }
        hr{border: 3px solid black;margin:0 !important;}
        h1,h2,h3,h4,h5{margin:5px 0;}
        .tblStyle{font-family: Century Gothic;border-collapse: collapse;width: 100%;margin-top:10px;}
        .tblStyle td{text-align: center;/*padding: 8px;*/padding: 0;margin: 0;}
        .tblStyle table.inner{width: 100%;margin: 0;}
        .tblStyle table.inner td{padding: 0;width: 50%;margin: 0;padding: 0;border: 0;}
        .tblStyle table.inner tr td{border-bottom: 1px solid black;}
        .tblStyle table.inner tr:last-child td{border-bottom: none;}
        .tblStyle th {border: 1px solid black;text-align: center;padding: 8px;background-color: #dddddd;}
        .break{page-break-before: always;}
        .tblHeader {font-family: Century Gothic;border-collapse: collapse;width: 100%;margin-bottom:20px;}
        .tblHeader tr td{text-align: center; padding:0;}
        .tblContent {width:100%;}
        .tblContent tr td{padding:5px 0;}
        .tblFooter {font-family: Century Gothic;border-collapse: collapse;width: 100%;}
        .tblFooter td{}
        </style>';
$html.='<html>';


App::import('Model','User');
$user = new User();
$pdfQuery=$user->query("SELECT * FROM dpfdplnew.fupbs f INNER JOIN dpfdplnew.fupbcompetitors  fc ON fc.fupbId=f.id WHERE f.id='$pdf' AND fc.primCompatitor ='true'");
//$pdfQuery=$user->query("SELECT * FROM dpfdplnew.fupbs  WHERE generateID='$pdf' AND primCompatitor ='true'");
//var_dump($queryOriginator);exit();



$html .='<table class="tblHeader">';
$html .='<tr><td><h3>PERSETUJUAN PRODUK BARU</h3></td></tr>';
$html .='<tr><td>'.$pdfQuery[0]['f']['noFUPB'].'</td></tr>';
$html .='<tr><td style=" text-align: justify;text-justify: inter-word;padding-top:10px;">Berdasarkan hasil keputusan management, bersama ini kami minta kepada Tim R&D untuk melakukan trial dan menyiapkan dokumen registrasi terhadap produk berikut ini:</td></tr></table>';
$html .='<table class="tblContent">';
$html .='<tr><td style="width:30%;">Nama Produk</td><td style="width:3%;">:</td>';
$html .='<td>'.$pdfQuery[0]['f']['prodName'].'</td></tr>';
$html .='<tr><td style="width:30%;">Perusahaan Originator</td><td style="width:3%;">:</td>';
$html .='<td>'.$pdfQuery[0]['fc']['brandName'].' - '.$pdfQuery[0]['fc']['namaCompany'].' (kompetitor utama)</td></tr>';
$html .='<tr><td style="width:30%;vertical-align: top !important;">Komposisi & Kemasan</td><td style="width:3%;vertical-align: top">:</td>';
$html .='<td>Tiap tablet mengandung: <br>'.$pdfQuery[0]['f']['komposisi'].' <br> '.$pdfQuery[0]['fc']['unitPack'].' </td></tr>';
$html .='<tr><td style="width:30%;">Diminta Oleh</td><td style="width:3%;">:</td>';
$html .='<td style="font-weight:bold">'.$pdfQuery[0]['f']['divName'].'</td></tr>';
$html .='<tr><td style="width:30%;vertical-align: top !important;">Komposisi & Kemasan</td><td style="width:3%;vertical-align: top">:</td>';
$html .='<td>Tiap tablet mengandung: <br>'.$pdfQuery[0]['f']['komposisi'].' <br> '.$pdfQuery[0]['f']['kemasan'].'</td></tr>';
$html .='<tr><td colspan="3"></td></tr>';
$html .='<tr><td colspan="3">Demikian hal ini kami informasikan dengan harapan dapat segera ditindaklanjuti.</td></tr>';
$html .='<tr><td colspan="3">Atas perhatian dan kerjasama yang baik, kami ucapkan terima kasih.</td></tr>';
$html .='<tr><td colspan="3">Jakarta, '.tgl_indo(date('Y-m-d')).'</td></tr>';
$html .='<tr><td colspan="3"></td></tr>';
$html .='<tr><td colspan="3">Diminta oleh,</td></tr></table>';
$divisiID=$pdfQuery[0]['f']['divName'];
// $queryUserAPP="SELECT*FROM dpfdplnew.fupbhistoryapprovals h INNER JOIN 
// (SELECT * FROM dpfdplnew.linkuserfupbapprovals li WHERE li.divisiID IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals li WHERE li.divisiID = '$divisiID') AS li 
// ON li.poinApp = h.poin INNER JOIN  (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id=li.userID WHERE h.fupbId = '$pdf' ORDER BY h.poin ASC";
//var_dump($queryUserAPP);exit();
$queryUserAPP1="SELECT fhis.id,fhis.fupbId,fhis.poin,fhis.statusApp,fhis.tanggalApp,link.id,link.userID,link.Usernama,link.poinApp,link.divisiID,Us.id,Us.penanggungJawab,Us.keterangan
FROM  dpfdplnew.fupbhistoryapprovals fhis INNER JOIN dpfdplnew.linkuserfupbapprovals link ON (link.poinApp = fhis.poin AND divisiID IS NULL) INNER JOIN (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id = link.userID WHERE  fhis.fupbId = '$pdf' ORDER BY fhis.poin ASC";
//OR CONCAT(link.poinApp,link.divisiID) = fhis.poin 
$pdfUserApp=$user->query($queryUserAPP1);
$userProdev='';$jabatanProdev='';$imgttdProdev='';
$userProman='';$jabatanProman='';$imgttdProman='';
$userScient='';$jabatanScient='';$imgttdScient='';
$userBusdev='';$jabatanBusdev='';$imgttdBusdev='';
$userMkt='';$jabatanMkt='';$imgttdMkt='';
foreach($pdfUserApp AS $dataUserAPP){
    $pointtd=$dataUserAPP['fhis']['poin'];

    if(file_exists('img/fupb/'.$pdf.'_ttd_'.$pointtd.'.png')){
        $img='<img src="img/fupb/'.$pdf.'_ttd_'.$pointtd.'.png" style="width:150px;">';
        }else{
        $img='';
    }
   
    if($dataUserAPP['fhis']['poin']=='1'){
        $userProdev=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanProdev=$dataUserAPP['Us']['keterangan'];
        $imgttdProdev=$img;
    }elseif($dataUserAPP['fhis']['poin']=='21'){
        $userMkt=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanMkt=$dataUserAPP['Us']['keterangan'];
        $imgttdMkt=$img;
    }elseif($dataUserAPP['fhis']['poin']=='22'){
        $userScient=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanScient=$dataUserAPP['Us']['keterangan'];
        $imgttdScient=$img;
    }elseif($dataUserAPP['fhis']['poin']=='23'){
        $userProman=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanProman=$dataUserAPP['Us']['keterangan'];
        $imgttdProman=$img;
    }elseif($dataUserAPP['fhis']['poin']=='3'){
        $userBusdev=$dataUserAPP['Us']['penanggungJawab'];
        $jabatanBusdev=$dataUserAPP['Us']['keterangan'];
        $imgttdBusdev=$img;
    }
}
$queryUserAPP2="SELECT fhis.id,fhis.fupbId,fhis.poin,fhis.statusApp,fhis.tanggalApp,link.id,link.userID,link.Usernama,link.poinApp,link.divisiID,Us.id,Us.penanggungJawab,Us.keterangan
FROM  dpfdplnew.fupbhistoryapprovals fhis INNER JOIN dpfdplnew.linkuserfupbapprovals link ON (CONCAT(link.poinApp,link.divisiID) = fhis.poin ) INNER JOIN (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id = link.userID WHERE  fhis.fupbId = '$pdf' ORDER BY fhis.poin ASC";
$pdfUserApp2=$user->query($queryUserAPP2);
$jumDiv=count($pdfUserApp2);

$userMkt=[];
$jabatanMkt=[];
$imgeMkt=[];

foreach($pdfUserApp2 as $dataUserAPP2){
    $pointtdDiv=$dataUserAPP2['fhis']['poin'];
    if(file_exists('img/fupb/'.$pdf.'_ttd_'.$pointtdDiv.'.png')){
        $img='<img src="img/fupb/'.$pdf.'_ttd_'.$pointtdDiv.'.png" style="width:150px;">';
        }else{
        $img='';
    }
    $userMkt[]=$dataUserAPP2['Us']['penanggungJawab'];
    $jabatanMkt[]=$dataUserAPP2['link']['divisiID'];
    $imgeMkt[]=$img;
}


if($jumDiv==1){
   //var_dump($pointtdDiv);exit();
    $html .='<table class="tblFooter">';
    $html .='<tr><td style="width:33%;height:120px;">'.$imgeMkt[0].'</td><td style="width:33%"></td><td style="width:33%">'.$imgttdProman.'</td></tr>';
    $html .='<tr><td style="vertical-align:top;">Nama: '.$userMkt[0].'<br>'.$jabatanMkt[0].'</td><td></td><td  style="vertical-align:top;padding-left:10px;">Nama: '.$userProman.'<br>'.$jabatanProman.'</td></tr>';
    $html .='</table>';
}else if($jumDiv==2){
    $html .='<table class="tblFooter">';
    $html .='<tr><td style="width:33%;height:120px;">'.$imgeMkt[0].'</td><td style="width:33%">'.$imgeMkt[1].'</td><td style="width:33%">'.$imgttdBusdev.'</td></tr>';
    $html .='<tr><td style="vertical-align:top;">Nama: '.$userMkt[0].'<br>'.$jabatanMkt[0].'</td><td style="vertical-align:top;">Nama: '.$userMkt[1].'<br>'.$jabatanMkt[1].'</td><td  style="vertical-align:top;padding-left:10px;">Nama: '.$userProman.'<br>'.$jabatanProman.'</td></tr>';
    $html .='</table>';
}else if($jumDiv==3){
    $html .='<table class="tblFooter">';
    $html .='<tr><td style="width:33%;height:120px;">'.$imgeMkt[0].'</td><td style="width:33%">'.$imgeMkt[1].'</td><td style="width:33%">'.$imgeMkt[2].'</td></tr>';
    $html .='<tr><td style="vertical-align:top;">Nama: '.$userMkt[0].'<br>'.$jabatanMkt[0].'</td><td style="vertical-align:top;">Nama: '.$userMkt[1].'<br>'.$jabatanMkt[1].'</td><td  style="vertical-align:top;padding-left:10px;">Nama: '.$userMkt[2].'<br>'.$jabatanMkt[2].'</td></tr>';
    $html .='<tr><td style="width:33%">'.$imgttdProman.'</td><td style="width:33%"></td><td style="width:33%"></td></tr>';
    $html .='<tr><td style="vertical-align:top;">Nama: '.$userProman.'<br>'.$jabatanProman.'</td><td></td><td  style="vertical-align:top;padding-left:10px;"></td></tr>';
    $html .='</table>';
}

$html .='<table class="tblFooter">';
$html .='<tr><td colspan="3" style="padding:10px;"></td></tr>';
$html .='<tr><td>Dibuat Oleh,</td><td></td><td style="padding-left:10px;">Disetujui Oleh,</td></tr>';
$html .='<tr><td style="width:33%;height:120px;">'.$imgttdProdev.'</td><td>'.$imgttdScient.'</td><td>'.$imgttdBusdev.'</td></tr>';
$html .='<tr><td  style="vertical-align:top;">Nama: '.$userProdev.'<br>'.$jabatanProdev.'</td><td style="vertical-align:top;">Nama: '.$userScient.'<br>'.$jabatanScient.'</td><td style="vertical-align:top;padding-left:10px;">Nama: '.$userBusdev.'<br>'.$jabatanBusdev.'</td></tr>';
$html .='</table>';

//$html .='$jumDiv==2</tr>';
//$html .='<tr><td style="vertical-align:top;">Nama: '.$userMkt.'<br>'.$jabatanMkt.'</td><td></td><td  style="vertical-align:top;padding-left:10px;">Nama: '.$userProman.'<br>'.$jabatanProman.'</td></tr>';



//var_dump($html);exit();



$html .= '</html>';
// echo $html;
// exit();
$dompdf->loadHtml($html);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
 
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('FUPB-Persetujuan-Produk-Baru-'.$pdf.'.pdf',array('Attachment'=>false));
exit();
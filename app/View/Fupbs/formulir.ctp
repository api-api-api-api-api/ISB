<?php 
//$this->layout='report';
App::import('Vendor', 'PDF', array('file' => 'dompdf/autoload.inc.php'));
//App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));

use Dompdf\Dompdf;

$dompdf = new Dompdf();
//var_dump($_POST);exit();
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
        .tblHeader {font-size: 12px !important;border-collapse: collapse;width: 100%;margin-top:10px;}
        .tblHeader tr td{text-align: center;border: 0.5px solid black; padding:5px;font-weight:bold;font-size:12px;}
        .tblContent {font-size: 12px !important;border-collapse: collapse;width: 100%;margin-top:10px;}
        .tblContent tr td{border-bottom: 0.5px solid black;padding: 4px 8px;}
        .tblStyle  tr:last-child td{border-bottom: none;}
        .tblNofub {font-size: 12px !important;border-collapse: collapse;width: 100%;margin-top:20px;}
        .tblFooter {font-size: 12px !important;font-family: Times New Roman;border-collapse: collapse;width: 100%;margin-top:20px;}
        .tblFooter td{/*padding: 8px;*/padding: 0;margin: 0;vertical-align:top;border:0.5px solid black;}
        .tblFooter table.inner{width: 100%;margin: 0;}
        .tblFooter table.inner td{padding: 0;margin: 0;padding: 0;border: 0;}
        .tblFooter table.inner tr td{border-bottom: none;}
        .tblFooter table.inner tr:last-child td{border-bottom: none;}
        .tblFooter th {border: 1px solid black;text-align: center;padding: 8px;background-color: #dddddd;}
        </style>';
        
$html.='<html>';
App::import('Model','User');
$user = new User();
// <td style='width:10%;font-weight: bold;'>Nama Project</td>
// <td style='width:3%; text-align:center;'>:</td>
// <td style='width:70%' colspan='5'>".$prodName."</td>
$pdfQuery=$user->query("SELECT * FROM dpfdplnew.fupbs f INNER JOIN dpfdplnew.fupbcompetitors  fc ON fc.fupbId=f.id WHERE f.id='$pdf' AND fc.primCompatitor ='true'");

    $nd=$pdfQuery[0]['f']['nd'];
    $tb=$pdfQuery[0]['f']['tb'];
    $noFUPB=$pdfQuery[0]['f']['noFUPB'];;
    $tanggal=tgl_indo($pdfQuery[0]['f']['tanggalFUPB']);
    $prodName=$pdfQuery[0]['f']['prodName'];
    $divID=$pdfQuery[0]['f']['divID'];
    $divName=$pdfQuery[0]['f']['divName'];
    $komposisi=$pdfQuery[0]['f']['komposisi'];
    $dosis=$pdfQuery[0]['f']['dosis'];
    $indikasi=$pdfQuery[0]['f']['indikasi'];
    $aturanPakai=$pdfQuery[0]['f']['aturanPakai'];
    $sediaan=$pdfQuery[0]['f']['sediaan'];
    $explodeSediaan=explode("~",$sediaan);
    //var_dump(count($explodeSediaan));exit();
    $kemasan=$pdfQuery[0]['f']['kemasan'];
    $jumlahKompetitor=$pdfQuery[0]['f']['jumlahKompetitor'];
    $jalurRegistrasi=$pdfQuery[0]['f']['jalurRegistrasi'];
    $statusKebutuhanMarketing=$pdfQuery[0]['f']['statusKebutuhanMarketing'];
    $primCompatitor=$pdfQuery[0]['fc']['primCompatitor'];
    $brandName=$pdfQuery[0]['fc']['brandName'];
    $namaCompany=$pdfQuery[0]['fc']['namaCompany'];
    $idPengaju=$pdfQuery[0]['f']['idPengaju'];
    $namaPengaju=$pdfQuery[0]['f']['namaPengaju'];
    if(!empty($primCompatitor)){
        $KompetitorUtama=$brandName.' - '.$namaCompany;
    }
   
$html .='<table class="tblHeader" >';
$html .='<tr><td style="width:30%" rowspan="3"><img src="img/logoBerno.png"  style="width:150px;"></td><td style="width:40%">FORMULIR</td><td style="width:30%"></td></tr>';
$html .='<tr><td style="border-bottom:0.5px solid white;padding-bottom:0">DEPARTEMENT</td><td style="border-bottom:0.5px solid white;padding-bottom:0;text-align:left;">ND : '.$nd.'</td></tr>';
$html .='<tr><td style="padding-top:0"><em>BUSINESS DEVELOPMENT</em></td><td style="padding-top:0;text-align:left;">TB : '.$tb.'</td></tr>';
$html .='<tr><td colspan="3">USULAN PRODUK BARU</td></tr>';
$html .='</table>';
$html .='<table class="tblNofub">';
$html .='<tr><td  style="width:15%;">No.</td><td style="width:3%;text-align: center;">:</td><td>'.$noFUPB.'</td></tr>';
$html .='<tr><td>Tanggal</td><td style="text-align: center;">:</td><td>'.$tanggal.'</td></tr>';
$html .='</table>';
$html .='<table class="tblContent">';
$html .='<tr>
            <td style="width:25%;font-weight: bold;border-top:0.5px solid black;border-left:0.5px solid black;">Nama Project</td>
            <td style="width:3%;text-align:center;font-weight: bold;border-top:0.5px solid black">:</td>
            <td colspan="5" style="border-top:0.5px solid black;width:73%;border-right:0.5px solid black">'.$prodName.'</td>
        </tr>';
$html .='<tr><td style="font-weight: bold;border-left:0.5px solid black;">Divisi</td><td style="text-align:center;font-weight: bold;">:</td><td colspan="5" style="border-right:0.5px solid black">'.$divName.'</td></tr>';
$html .='<tr>
            <td style="font-weight: bold;border-left:0.5px solid black;border-bottom: 0 !important;">Komposisi & Dosis </td>
            <td style="text-align:center;font-weight: bold;border-bottom: 0 !important;">:</td>
            <td colspan="5" style="border-right:0.5px solid black;border-bottom: 0 !important;"></td></tr>';
$html .='<tr><td style="border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">Tiap tablet mengandung:<br> '.$komposisi.'</td></tr>';
$html .='<tr>
            <td style="font-weight: bold;border-left:0.5px solid black;border-bottom: 0 !important;">Indikasi</td>
            <td style="text-align:center;font-weight: bold;border-bottom: 0 !important;">:</td>
            <td colspan="5" style="border-right:0.5px solid black;border-bottom: 0 !important;"></td></tr>';
$html .='<tr><td style="border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">'.$indikasi.'</td></tr>';
$html .='<tr>
            <td style="font-weight: bold;border-left:0.5px solid black;border-bottom: 0 !important;">Aturan Pakai</td>
            <td style="text-align:center;font-weight: bold;border-bottom: 0 !important;">:</td>
            <td colspan="5" style="border-right:0.5px solid black;border-bottom: 0 !important;"></td></tr>';
$html .='<tr><td style="border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">'.$aturanPakai.'</td></tr>';
$html .='<tr>
            <td style="font-weight: bold;border-left:0.5px solid black;border-bottom: 0 !important;">Spesifikasi Sediaan</td>
            <td style="text-align:center;font-weight: bold;border-bottom: 0 !important;">:</td>
            <td colspan="5" style="border-right:0.5px solid black;border-bottom: 0 !important;"></td></tr>';
$html .='<tr><td style="border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">
            <table class="table" width="100%" style="border:none !important;">
            <tr>
                <td style="width:8%;border:none !important;">Bentuk</td>
                <td style="width:35%;border:none !important;">: '.$explodeSediaan[0].'</td>
                <td style="width:8%;border:none !important;">Warna</td>
                <td style="width:35%;border:none !important;">: '.$explodeSediaan[2].'</td>
            </tr>
            <tr>
                <td style="border:none !important;">Rasa</td>
                <td style="border:none !important;">: '.$explodeSediaan[1].'</td>
                <td style="border:none !important;">Aroma</td>
                <td style="border:none !important;">: '.$explodeSediaan[3].'</td>
            </tr>
            </table></td></tr>';
$html .='<tr>
            <td style="font-weight: bold;border-left:0.5px solid black;border-bottom: 0 !important;">Spesifikasi Kemasan</td>
            <td style="text-align:center;font-weight: bold;border-bottom: 0 !important;">:</td>
            <td colspan="5" style="border-right:0.5px solid black;border-bottom: 0 !important;"></td></tr>';
$html .='<tr><td style="border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7" style="border-right:0.5px solid black;" >'.$kemasan.'</td></tr>';
$html .='<tr><td style="font-weight: bold;border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">Kompetitor</td></tr>';
$html .='<tr><td style="font-weight: bold;border-right: 0.5px solid black;border-left:0.5px solid black;" colspan="2">Jumlah Kompetitor</td><td colspan="5" style="border-right:0.5px solid black">'.$jumlahKompetitor.'</td></tr>';
$html .='<tr><td style="font-weight: bold;border-right: 0.5px solid black;border-left:0.5px solid black;" colspan="2">Kompetitor Utama</td><td colspan="5" style="border-right:0.5px solid black">'.$KompetitorUtama.'</td></tr>';

$html .='<tr>
            <td style="text-align:center;background:#f5f5f5 !important;border-right: 0.5px solid black;border-left:0.5px solid black;" colspan="2">Brand Name</td>
            <td style="text-align:center;background:#f5f5f5 !important;border-right: 0.5px solid black;">Company</td>
            <td style="background:#f5f5f5 !important;border-right: 0.5px solid black;">Dosage Form</td>
            <td style="text-align:center;background:#f5f5f5 !important;border-right: 0.5px solid black;">Unit/Pack</td>
            <td style="text-align:center;background:#f5f5f5 !important;border-right: 0.5px solid black;">Price/Pack</td>
            <td style="text-align:center;background:#f5f5f5 !important;border-right:0.5px solid black">Price/Pack</td>
        </tr>';
        
        $queryBrandCompatitors=$user->query("SELECT brand.companyId,brand.namaCompany,brand.primCompatitor,brand.brandName,brand.dosageForm,brand.unitPack,brand.pricePack,brand.priceUnit  FROM  dpfdplnew.fupbcompetitors brand WHERE brand.fupbId='$pdf' ORDER BY brand.id ASC");
        
        $KompetitorUtama='';
        $txtBrand='';
        foreach($queryBrandCompatitors as $dataBrand){
            $companyId=$dataBrand['brand']['companyId'];
            $namaCompany=$dataBrand['brand']['namaCompany'];
            $primCompatitor=$dataBrand['brand']['primCompatitor'];
            $brandName=$dataBrand['brand']['brandName'];
            $dosageForm=$dataBrand['brand']['dosageForm'];
            $unitPack=$dataBrand['brand']['unitPack'];
            $pricePack=$dataBrand['brand']['pricePack'];
            $priceUnit=$dataBrand['brand']['priceUnit'];
            if(!empty($primCompatitor)){
                $KompetitorUtama=$brandName.' - '.$namaCompany;
            }
           
            $txtBrand.="<tr>
                            <td style='text-align:center;border-right: 0.5px solid black;border-left:0.5px solid black;' colspan='2'>".$brandName."</td>
                            <td style='text-align:center;border-right: 0.5px solid black;'>".$namaCompany."</td>
                            <td style='text-align:center;border-right: 0.5px solid black;'>".$dosageForm."</td>
                            <td style='text-align:center;border-right: 0.5px solid black;'>".$unitPack."</td>
                            <td style='text-align:right;border-right: 0.5px solid black;'>Rp. ".number_format($pricePack,0,"",".")."</td>
                            <td style='text-align:right;border-right:0.5px solid black'>Rp. ".number_format($priceUnit,0,"",".")."</td>
                        </tr>";
        }
        
$html.=$txtBrand;


$html .='<tr><td style="width:10%;font-weight: bold;border-right: 0.5px solid black;border-left:0.5px solid black;" colspan="2">Jalur Registrasi</td><td colspan="5" style="border-right: 0.5px solid black;">'.$jalurRegistrasi.'</td></tr>';
$html .='<tr><td style="width:10%;font-weight: bold;border-bottom: 0 !important;border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">Status Kebutuhan Marketing</td></tr>';
$html .='<tr><td style="width:10%;border-right:0.5px solid black;border-left:0.5px solid black;" colspan="7">'.$statusKebutuhanMarketing.'</td></tr>';

$html .='</table>';

$ttdAppNama='';
$ttdAppJab='';
$queryAPP=$user->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals fhis INNER JOIN (SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID = '$divName') As link ON link.poinApp = fhis.poin INNER JOIN  (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id=link.userID AND fhis.fupbId = '$pdf' AND fhis.poin=1");
//var_dump($queryAPP);exit();
$ttdAppNama=$queryAPP[0]['Us']['penanggungJawab'];
$ttdAppJab=$queryAPP[0]['Us']['keterangan'];
//var_dump($queryAPP);exit();
$queryPembuat=$user->query("SELECT * FROM dpfdplnew.users WHERE id='$idPengaju'");
$ttdUserNama=$queryPembuat[0]['users']['penanggungJawab'];
$ttdUserJab=$queryPembuat[0]['users']['keterangan'];
$html.='<table class="tblFooter">
            <tr>
                <td style="width:50%">
                    <table class="inner" >
                        <tr><td style="width:25%;font-weight:bold;">Dibuat oleh</td><td style="width:3%;">:</td><td>'.$ttdUserNama.'</td></tr>
                        <tr><td>Departemen</td><td>:</td><td>'.$ttdUserJab.'</td></tr>
                        <tr><td>Tanda Tangan</td><td>:</td></tr>
                        <tr><td colspan="3"><img src="img/fupb/'.$pdf.'.png" style="width:150px;"/></td></tr>
                    </table>
                </td>
                <td style="width:50%">
                    <table class="inner">
                        <tr><td style="width:25%;font-weight:bold;">Disetujui Oleh</td><td style="width:3%;">:</td><td>'.$ttdAppNama.'</td></tr>
                        <tr><td >Tanda Tangan</td><td>:</td><td></td></tr>
                        <tr><td colspan="3" style="text-align:center">';
                            if(file_exists('img/fupb/'.$pdf.'_ttd_'.'1.png')){
                                $html.='<img src="img/fupb/'.$pdf.'_ttd_1.png" style="width:150px;">';
                            }else{
                                $html.='';
                            }
                        $html.='</td></tr>
                    </table>
                </td>
            </tr>
        </table>';
// <tr>
//                 <td width="50%">
//                     <table class="tblTtd" width="100%" style="margin-bottom:unset;">
//                         <tr><td style="font-weight: bold;width:25%">Dibuat oleh</td><td>: $namaPengaju</td></tr>
//                         <tr><td style="font-weight: bold;">Departemen</td><td>: </td></tr>
//                         <tr><td>Tanda Tangan</td><td>:</td></tr>
//                         <tr><td colspan="2" style="text-align:center">
//                         <img src="img/fupb/'.$pdf.'.png" styl="width:200;>
//                         </td></tr>
//                     </table>
//                 </td>
//                 <td>
//                     <table class="tblTtd" width="100%" style="margin-bottom:unset;">
//                         <tr><td style="font-weight: bold;width:25%">Disetujui oleh</td><td>: '.$ttdAppNama.'</td></tr>
//                         <tr><td style="font-weight: bold;">Departemen</td><td>: '.$ttdAppJab.'</td></tr>
//                         <tr><td>Tanda Tangan</td><td>:</td></tr>
//                         <tr><td colspan="2" style="text-align:center"><img src="img/fupb/'.$pdf.'_ttd_'.'1.png" style="width:200;">
//                         </td></tr>
//                     </table>
//                 </td>
//             </tr>
//$html.="</table>";
            //var_dump($html);exit();


$dompdf->loadHtml($html);

            // Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
             
            // Rendering dari HTML Ke PDF
$dompdf->render();
            // Melakukan output file Pdf
$dompdf->stream('FUPB-Persetujuan-Produk-Baru-'.$pdf.'.pdf',array('Attachment'=>false));
exit();
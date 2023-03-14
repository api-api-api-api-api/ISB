 <?php
App::uses('AppController', 'Controller');
/**
 * Laporandpfs Controller
 *
 */
class LaporandpfbrngensController extends AppController {
public $components = array('Function','Paginator');
function index(){
		// Initialise the framework sessions

		echo $this->Function->cekSession($this);
			}
			

public function showDetail(){
	 $this->render('showdetail'); 
	 }
public function showDetail2(){
	 $this->render('showdetail2'); 
	 }	 
public function getData(){
		$this->loadModel('Dpfbrngen');
		
		$this->autoRender = false;
		$bulan=$_POST['bulan'];
		$tahun=$_POST['tahun'];
		$outlet=$_POST['outlet'];
		//$periodeDPF=$this->Function->dateluar($_POST['periode']);
		//if($_POST['periode']==''){$periodeDPF='';}
		//$nomorDPF=$_POST['nomorDPF'];
		//$outlet=explode("!",$_POST['outlet']);
		
		/*if(count($outlet)>1){
			$comId=$outlet[0];
			$outletId=$outlet[1];
			}
		else{
			$comId='';
			$outletId='';
			}	
		*/
		$hm=$_POST['hal'];
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		$groupId=$this->Session->read('dpfdpl_groupId');
		if($groupId==2){
		$rs=$this->Dpfbrngen->getDataDPFLaporanArco($bulan,$tahun,$outlet,$this->Session->read('dpfdpl_userId'),$groupId);
		$hasil = $this->Dpfbrngen->getDataDPFLaporanArcoPaginate($bulan,$tahun,$outlet,$this->Session->read('dpfdpl_userId'),$groupId,$hm,$limit);
		
			}
		else{
		$rs=$this->Dpfbrngen->getDataDPFLaporanNonArco($bulan,$tahun,$outlet,$groupId,$this->Session->read('dpfdpl_pejabatId'));
		$hasil = $this->Dpfbrngen->getDataDPFLaporanNonArcoPaginate($bulan,$tahun,$outlet,$groupId,$this->Session->read('dpfdpl_pejabatId'),$hm,$limit);
			}
		
		/*if($groupId==5){
		$rs=$this->Dpfbrngen->getDataDPFLaporanKacabDist($bulan,$tahun,$this->Session->read('dpfdpl_userId'),$groupId);
			}
		if($groupId==6){			
		$rs=$this->Dpfbrngen->getDataDPFLaporanSM($bulan,$tahun,$this->Session->read('dpfdpl_pejabatId'),$groupId);
			}	
		if($groupId==7){			
		$rs=$this->Dpfbrngen->getDataDPFLaporanGSM($bulan,$tahun,$this->Session->read('dpfdpl_pejabatId'),$groupId);
			}		
		if($groupId==10){			
		$rs=$this->Dpfbrngen->getDataDPFLaporanFIN($bulan,$tahun,$this->Session->read('dpfdpl_pejabatId'),$groupId);
		
			}
		if($groupId==9){
			
		$rs=$this->Dpfbrngen->getDataDPFLaporanPusatDist($bulan,$tahun,$this->Session->read('dpfdpl_userId'),$groupId);
			}	*/
		
		$jum=count($rs);	
		if($jum==0){echo "not found";exit();}
		$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		//$hasil = $rs;
		
		$txt='';
		$hsl='';
		$jum2=count($hasil);
		if($jum2>0){
			$ord='odd';
			foreach($hasil as $hsl){	
			$stat=explode(",",$hsl['0']['status']);
			//get Approver
			$approver='';
			if($stat[0]=='diajukan'){
				$rsApprover=$this->Dpfbrngen->query("select * from users where pejabatId='".$hsl['Dpfbrngen']['smId']."'");
				$approver=$rsApprover["0"]["users"]["penanggungJawab"];
				}
			elseif($stat[0]=='disetujuism'){
				$rsApprover=$this->Dpfbrngen->query("select * from users where pejabatId='".$hsl['Dpfbrngen']['gsmId']."'");
				$approver=$rsApprover["0"]["users"]["penanggungJawab"];
				}
			elseif($stat[0]=='disetujuigsm'){
				$rsApprover=$this->Dpfbrngen->query("select * from users where pejabatId='".$hsl['Dpfbrngen']['finId']."'");
				$approver=$rsApprover["0"]["users"]["penanggungJawab"];
				}		
			$txt=$txt."<tr>
			<td><a  title=\"Detail\" class=\"\" href=\"laporandpfbrngens/showdetail/".$hsl["Dpfbrngen"]["noDPF"]."\" >".$hsl['Dpfbrngen']['noDPF']."</a></td>
			<td>".$this->Function->dateindo($hsl['Dpfbrngen']['tanggalInput'])."</td>
			<td>".$hsl['Dpfbrngen']['namaTP']."</td>
			<td>".$hsl['Dpfbrngen']['kodeDist']."</td>
			<td>".$hsl['Dpfbrngen']['distributor']."</td>
			<td>".$hsl['out']['nama_outlet'].'#'.$hsl['out']['alamat']."</td>
			<td>".$hsl['Dpfbrngen']['periode']."</td>
			<td>".$stat[0]."</td>	
			<td>".$approver."</td>";
			if($stat[0]=='finish'){	
			//$txt.="<a  title=\"Detail\" class=\"\" href='laporandpfbrngens/cetakLaporanPDF?noDPF=".$hsl["Dpfbrngen"]["noDPF"]."'  >Print PDF</a> | ";	
			}
			$txt.="</tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			}
			}
		
		
			echo $txt."!".$linkHal."!".$sum;
		
	}	
public function getDataDetail(){
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$noDPF=$_POST['noDPF'];
		
		$hm=1;
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		
		$groupId=$this->Session->read('dpfdpl_groupId');					
		$rs=$this->Dpfbrngen->getDataDPFDetil('noDPF',$noDPF,$groupId);
		
		$jum=count($rs);
		if($jum==0){echo "not found";exit();}
		$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		$hasil = $rs;
		
		$txt='';
		$hsl='';
		$jum2=count($hasil);
		if($jum2>0){
			$ord='odd';
			
			foreach($hasil as $hsl){	
			$namaTP=$hsl['Dpfbrngen']['namaTP'];
			$periode=$hsl['Dpfbrngen']['periode'];
			$kodeDist=$hsl['Dpfbrngen']['kodeDist'];
			$distributor=$hsl['Dpfbrngen']['distributor'];
			$outlet=$hsl['out']['nama_outlet'].'#'.$hsl['out']['alamat'];
			$txt=$txt."<tr>
			<td>".$hsl['Dpfbrngen']['id']."</td>
			<td>".$hsl['Dpfbrngen']['produkId']."</td>
			<td>".$hsl['Dpfbrngen']['namaProduk']."</td>
			<td style='text-align:right'>".$this->Function->nf($hsl['Dpfbrngen']['hna'])."</td>
			<td style='text-align:right'>".$this->Function->nf($hsl['Dpfbrngen']['hna2'])."</td>
			<td style='text-align:right'>".$hsl['Dpfbrngen']['unit']."</td>
			<td style='text-align:right'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi1'])."</td>
			<td style='text-align:right'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi'])."</td>
			
			<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipal']."</td>

			<td style='text-align:right'>".$hsl['Dpfbrngen']['offFaktur']."</td>

			<td style='text-align:right'>".$hsl['Dpfbrngen']['discDist']."</td>
			<td style='text-align:right'>".$hsl['Dpfbrngen']['totalDisc']."</td>
			<td>".$hsl['Dpfbrngen']['keterangan']."</td>	
			<td>".$hsl['Dpfbrngen']['statusDPF']."</td>	
			</tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			}
			}
			/*<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalAsli']."</td>
					<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalSM']."</td>
							<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalGSM']."</td>
									<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalFin']."</td>
											
											<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturAsli']."</td>
													<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturSM']."</td>
															<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturGSM']."</td>
																	<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturFin']."</td>*/
		echo $namaTP.'!'.$periode.'!'.$kodeDist.'!'.$distributor.'!'.$outlet.'!'.$txt;
		
	}
public function getDataDetail2(){
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$noDPF=$_POST['noDPF'];
		
		$hm=1;
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		
		$groupId=$this->Session->read('dpfdpl_groupId');					
		$rs=$this->Dpfbrngen->getDataDPFDetil('noDPF',$noDPF,$groupId);
		
		$jum=count($rs);
		if($jum==0){echo "not found";exit();}
		$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		$hasil = $rs;
		
		$txt='';
		$hsl='';
		$jum2=count($hasil);
		if($jum2>0){
			$ord='odd';
			foreach($hasil as $hsl){	
$tanggalFinish='';
if($hsl['Dpfbrngen']['statusDPF']=='finish'){$tanggalFinish=$this->Function->dateindo($hsl['Dpfbrngen']['tanggalApproval']);}

$onFaktur=floatval($hsl['Dpfbrngen']['discPrinsipal'])+floatval($hsl['Dpfbrngen']['discDist']);
			$namaTP=$hsl['Dpfbrngen']['namaTP'];
			$periode=$hsl['Dpfbrngen']['periode'];
			$kodeDist=$hsl['Dpfbrngen']['kodeDist'];
			$distributor=$hsl['Dpfbrngen']['distributor'];
if($hsl['mo']['nama']==NULL){
			$outlet=$hsl['out']['nama_outlet'].'#'.$hsl['out']['alamat'];
}
else{$outlet=$hsl['mo']['nama'].'#'.$hsl['mo']['keterangan'];}			
$txt=$txt."<tr>
			<td>".$hsl['Dpfbrngen']['id']."</td>
			<td>".$hsl['mp']['kode_prod']."</td>
			<td>".$hsl['mp']['nama']."</td>
			<td style='text-align:right' class='textBuff'>".$this->Function->nf($hsl['Dpfbrngen']['hna'])."</td>
			<td style='text-align:right' class='textBuff'>".$this->Function->nf($hsl['Dpfbrngen']['hna2'])."</td>
			<td style='text-align:right'>".$hsl['Dpfbrngen']['unit']."</td>
			<td style='text-align:right' class='textBuff'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi1'])."</td>
			<td style='text-align:right' class='textBuff'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi'])."</td>
			
			<td style='text-align:right' class='textBuff'>".$hsl['Dpfbrngen']['discPrinsipal']."</td>

			<td style='text-align:right' class='textBuff'>".$hsl['Dpfbrngen']['offFaktur']."</td>

			<td style='text-align:right'>".$onFaktur."</td>
			<td style='text-align:right' class='textBuff'>".$hsl['Dpfbrngen']['totalDisc']."</td>
			<td class='textBuff'>".$hsl['Dpfbrngen']['keterangan']."</td>	
			<td class='textBuff'>".$hsl['Dpfbrngen']['statusDPF']."</td>
			<td>".$tanggalFinish."</td>	
			</tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			}
			}
			/*<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalAsli']."</td>
					<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalSM']."</td>
							<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalGSM']."</td>
									<td style='text-align:right'>".$hsl['Dpfbrngen']['discPrinsipalFin']."</td>
											
											<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturAsli']."</td>
													<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturSM']."</td>
															<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturGSM']."</td>
																	<td style='text-align:right'>".$hsl['Dpfbrngen']['offFakturFin']."</td>*/
		echo $namaTP.'!'.$periode.'!'.$kodeDist.'!'.$distributor.'!'.$outlet.'!'.$txt;
		
	}		
public function prosesApproval(){
		
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$noDPF=$_POST['noDPF'];
		$statusApproval=$_POST['statusApproval'];
		$keteranganApproval=$_POST['keteranganApproval'];		
		$this->Dpfbrngen->prosesApproval($this->Session->read('dpfdpl_userId'),$this->Session->read('dpfdpl_namaUser'),$this->Session->read('dpfdpl_groupId'),$noDPF,$statusApproval,$keteranganApproval);
		
		}
public function saveDPFDetail(){}		
	
public function cetakLaporanPDF(){

//$timeLimit=ini_get('max_execution_time');		
set_time_limit(3600);
//$timeLimit.="--".ini_get('max_execution_time');
//echo $timeLimit;exit();
$noDPFAll="";
$countVar=$this->params['url']['countVar'];

for($j=0;$j<$countVar-1;$j++){

	$noDPFAll.=$this->params['url']['noDPF'.($j+1)].",";
	}

$noDPFAll=substr($noDPFAll,0,strlen($noDPFAll)-1);
if(trim($noDPFAll)==''){echo "Harap pilih item yang akan dicreate";exit();}
if(isset($this->params['url']['isExcel'])){
$isExcel=$this->params['url']['isExcel'];}
else{$isExcel='';}
$noDPFAll=explode(",",$noDPFAll);

App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));
$this->autoRender = false;
if($isExcel=='yes'){

App::import('Vendor', 'Excel', array('file' => 'excel/PHPExcel.php'));

		$this->loadModel('Matching_outlet');
		$this->loadModel('Xmatch_dist');
		$this->loadModel('Xmatch_product');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');
if (PHP_SAPI == 'cli')
die('This example should only be run from a Web Browser');

}
foreach($noDPFAll as $noDPF)
{
    // Instanciation of inherited class
$pdf = new myPDF();
$pdf->AddPage('P');
$pdf->SetFont('Arial','B',12);
 // Title
 $pdf->SetTextColor(255,255,255);
$pdf->Cell(190,10,'DISCOUNT PROPOSAL FORM (DPF)',0,0,'C',1);
$pdf->Ln(12);  
$this->loadModel('Dpfbrngen');
$this->loadModel('Historyapprovaldpfbrngen');
$this->autoRender = false;
$hm=1;
$limit=12;
if(empty($hm)||$hm==1){	$start=0; }
else{ $start=($hm-1)*$limit; }	
$groupId=$this->Session->read('dpfdpl_groupId');					
$rs=$this->Dpfbrngen->getDataDPFByStatus('noDPF',$noDPF,$groupId,'finish');

$rec=1;	
foreach($rs as $hsl){	
			$noDPF=$hsl['Dpfbrngen']['noDPF'];
			$namaTP=$hsl['Dpfbrngen']['namaTP'];
			$periode=$hsl['Dpfbrngen']['periode'];
			$kodeDist=$hsl['Dpfbrngen']['kodeDist'];
			$distributor=$hsl['Dpfbrngen']['distributor'];
			$kodeOutlet=$hsl['Dpfbrngen']['comId'].'_'.$hsl['Dpfbrngen']['outletId'];
			$namaOutlet=$hsl['out']['nama_outlet'];
			$alamat=$hsl['out']['alamat'];
			$keterangan=$hsl['Dpfbrngen']['keterangan'];
			$namaSM=explode('#',$hsl['out']['SM']);
			$namaGSM=explode('#',$hsl['out']['GSM']);
			$namaFin=explode('#',$hsl['out']['FIN']);
			$approvalSM=$this->Historyapprovaldpfbrngen->getDataByNomorDPFByStatus($noDPF,'disetujuism');
		
			$approvalGSM=$this->Historyapprovaldpfbrngen->getDataByNomorDPFByStatus($noDPF,'disetujuigsm');
			$finish=$this->Historyapprovaldpfbrngen->getDataByNomorDPFByStatus($noDPF,'finish');
			$tglApprovalSM="";
			$tglApprovalGSM="";
			$tglFinish="";
			if(count($approvalSM)>0){
			$tglApprovalSM=$this->Function->dateindo2($approvalSM[0]['Historyapprovaldpfbrngen']['tanggalApproval']);}
			if(count($approvalGSM)>0){
			$tglApprovalGSM=$this->Function->dateindo2($approvalGSM[0]['Historyapprovaldpfbrngen']['tanggalApproval']);}
			if(count($finish)>0){
			$tglFinish=$this->Function->dateindo2($finish[0]['Historyapprovaldpfbrngen']['tanggalApproval']);}
			if($rec==1){
				$pdf->SetFont('Arial','B',7);
				$w=array('20','5','70','20','5','70');
				$pdf->SetWidths($w);
				$pdf->SetAligns(array('L','L','L','L','L','L'));
				
				$pdf->Row(array('Nama TP',':',$namaTP,'Dist',':',$kodeDist));
				$pdf->Row(array('Kode Outlet',':',$kodeOutlet,'Cabang',':',$distributor));
				$pdf->Row(array('Nama Outlet',':',str_replace("\r", "",str_replace("\n", "", $namaOutlet)),'Periode',':',$periode));
				$pdf->Row(array('Alamat Outlet',':',str_replace("\r", "",str_replace("\n", "", $alamat)),'No. DPF',':',$noDPF));
				$pdf->Row(array('Ket',':',$keterangan,'Tgl FINISH',':',$tglFinish));	
				$pdf->Ln();
				$pdf->SetDrawColor(128,0,0);
				$pdf->SetLineWidth(.3);
				$pdf->SetFont('','B');
			   
				// Color and font restoration
			   // $this->SetFillColor(224,235,255);
				$pdf->SetTextColor(0);
				$pdf->SetFont('');
				 
			  //Set Header
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(7,12,"No",1,0,'R');
					$pdf->Cell(8,12,"ProId",1,0,'L');
					$pdf->Cell(60,12,"Nama Prod",1,0,'L');
					$pdf->Cell(20,12,"Hna",1,0,'R');
					$pdf->Cell(20,12,"Hna2",1,0,'R');
					$pdf->Cell(10,12,"Unit",1,0,'R');
					$pdf->Cell(20,12,"Harga Jadi",1,0,'R');
					$pdf->Cell(45,12,"Diskon",1,0,'C');
					$pdf->Cell(0,4,"",0,1,'L');
					$pdf->Ln();
					 //header line 2
					$pdf->SetX(155);
					$pdf->Cell(15,4,"Disk Prins",1,0,'L');
					$pdf->Cell(15,4,"Disk Dist",1,0,'L');
					$pdf->Cell(15,4,"Tot Disc",1,0,'L');
					 //header line 3
					
					$pdf->Ln();
				}
				$w=array('7','8','60','20','20','10','20','15','15','15','15','15');
				$pdf->SetWidths($w);
				$pdf->SetAligns(array('R','L','L','R','R','R','R','R','R','R','R','L'));
				$pdf->SetFont('Arial','',7);
				$pdf->Row(array($rec.".", $hsl['Dpfbrngen']['produkId'],$hsl['Dpfbrngen']['namaProduk'],$this->Function->nf($hsl['Dpfbrngen']['hna']),$this->Function->nf($hsl['Dpfbrngen']['hna2']),$this->Function->nf($hsl['Dpfbrngen']['unit'])
				,$this->Function->nf($hsl['Dpfbrngen']['hargaJadi']),
				$hsl['Dpfbrngen']['discPrinsipal'],$hsl['Dpfbrngen']['discDist'],$hsl['Dpfbrngen']['totalDisc']),true);	
		
		$rec++;	
		if($isExcel=='yes'){
			//get matching	
			
     $kodeCabDist="";
	 $cabDist="";
	 $distOutId="";
	 $distOutlet="";
	 $distAlamatOutlet="";
	 $distProId="";
	 $distProduct="";
			$groupDisId=$this->Matching_outlet->getGroupDisId($hsl['Dpfbrngen']['comId'],$hsl['Dpfbrngen']['outletId']);
			if(count($groupDisId)>0){
			$distDist=$this->Xmatch_dist->getMatchingDist($hsl['Dpfbrngen']['comId'],$groupDisId[0][0]["disId"],$hsl['Dpfbrngen']['kodeDist']);
	
			if(count($distDist)>0){
				$kodeCabDist=$distDist[0]['Xmatch_dist']['KODE'];
				$cabDist=$distDist[0]['Xmatch_dist']['KOTA'];
				
				$outletDist=$this->Matching_outlet->getMatchingOutlet($hsl['Dpfbrngen']['comId'],$distDist[0]['Xmatch_dist']['DISID'],$hsl['Dpfbrngen']['outletId']);
				
				if(count($outletDist)>0){
					$distOutId=$outletDist[0]['Matching_outlet']['kode'];
					$distOutlet=$outletDist[0]['Matching_outlet']['nama'];
					$distAlamatOutlet=$outletDist[0]['Matching_outlet']['keterangan'];
					$productDist=$this->Xmatch_product->getMatchingProduct($hsl['Dpfbrngen']['comId'],$distDist[0]['Xmatch_dist']['DISID'],$hsl['Dpfbrngen']['produkId']);
					
					if(count($productDist)>0){
						$distProId=$productDist[0]['Xmatch_product']['kode'];
						$distProduct=$productDist[0]['Xmatch_product']['nama'];
						}
					else{
						$distProId="";
						$distProduct="";
						}	
					}
				else{
					$distOutId="";
					$distOutlet="";
					$distAlamatOutlet="";
					}	
				}
			else{
				$kodeCabDist="";
				$cabDist="";
				}	
			}
			
		
		
			
			if(!isset($objPHPExcel[$kodeDist])){
				$barisGroupDist[$kodeDist]=2;
				$namaFile='DPF_BRN_ETH_'.date('d-M-Y').'.pdf';
	//	Start Excel
// Create new PHPExcel object
$objPHPExcel[$kodeDist] = new PHPExcel();

// Set document properties
$objPHPExcel[$kodeDist]->getProperties()->setCreator("EDP")
							 ->setLastModifiedBy("EDP")
							 ->setTitle($namaFile)
							 ->setSubject($namaFile)
							 ->setDescription($namaFile)
							 ->setKeywords($namaFile)
							 ->setCategory("Laporan");

// Set page orientation and size and margin
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$margin=0.5; // in inch
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageMargins()->setTop($margin);
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageMargins()->setBottom($margin);
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageMargins()->setLeft($margin);
$objPHPExcel[$kodeDist]->getActiveSheet()->getPageMargins()->setRight($margin);

// Set fonts
/*$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setName('Consolas');
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);*/

// Set alignments
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('A:I')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
// Set thin black border
$ltr = array(
	'borders' => array(
		'left' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
	),
);
$lr = array(
	'borders' => array(
		'left' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
	),
);
$lrb = array(
	'borders' => array(
		'left' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
	),
);
$t = array(
	'borders' => array(
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
	),
);

// Rename worksheet
$objPHPExcel[$kodeDist]->getActiveSheet()->setTitle('Laporan PA');

// Set column widths
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('F')->setWidth(8);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('H')->setWidth(8);
$objPHPExcel[$kodeDist]->getActiveSheet()->getColumnDimension('I')->setWidth(8);



// Set cell number formats
/*$objPHPExcel->getActiveSheet()->getStyle('E4:E13')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);*/



//Judul
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('A1:AL1')->getFont()->setBold(true);



// Add some data
$objPHPExcel[$kodeDist]->setActiveSheetIndex(0)
            ->setCellValue('A1', 'id')
            ->setCellValue('B1', 'noDPF')
            ->setCellValue('C1', 'namaTP')
            ->setCellValue('D1', 'periode')
            ->setCellValue('E1', 'kodeDist')
            ->setCellValue('F1', 'distributor')
            ->setCellValue('G1', 'comId')
            ->setCellValue('H1', 'outletId')
            ->setCellValue('I1', 'produkId')
            ->setCellValue('J1', 'namaProduk')
            ->setCellValue('K1', 'hna')
            ->setCellValue('L1', 'hna2')
            ->setCellValue('M1', 'unit')
            ->setCellValue('N1', 'hargaJadi')
            ->setCellValue('O1', 'discPrinsipalAsli')
            ->setCellValue('P1', 'discDistAsli')
            ->setCellValue('Q1', 'totalDistAsli')
            ->setCellValue('R1', 'discPrinsipal')
            ->setCellValue('S1', 'discDist')
            ->setCellValue('T1', 'totalDist')
            ->setCellValue('U1', 'keterangan')
            ->setCellValue('V1', 'SMId')
            ->setCellValue('W1', 'GSMId')
            ->setCellValue('X1', 'FinId')
            ->setCellValue('Y1', 'statusDPF')
            ->setCellValue('Z1', 'tanggalInput')
            ->setCellValue('AA1', 'tanggalApproval')
            ->setCellValue('AB1', 'keteranganApproval')
            ->setCellValue('AC1', 'namaFile')
            ->setCellValue('AD1', 'PDFCreated')
            ->setCellValue('AE1', 'dateCreated')
            ->setCellValue('AF1', 'kodeCabDist')
            ->setCellValue('AG1', 'cabDist')
            ->setCellValue('AH1', 'distProId')
            ->setCellValue('AI1', 'distProduct')
            ->setCellValue('AJ1', 'distOutId')
            ->setCellValue('AK1', 'distOutlet')
            ->setCellValue('AL1', 'distAlamatOutlet');
				$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('A1:AL1')->applyFromArray($ltr);
				
				}	
				
				$objPHPExcel[$kodeDist]->setActiveSheetIndex(0)
            ->setCellValue('A'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['id'])
            ->setCellValue('B'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['noDPF'])
            ->setCellValue('C'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['namaTP'])
            ->setCellValue('D'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['periode'])
            ->setCellValue('E'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['kodeDist'])
            ->setCellValue('F'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['distributor'])
            ->setCellValue('G'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['comId'])
            ->setCellValue('H'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['outletId'])
            ->setCellValue('I'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['produkId'])
            ->setCellValue('J'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['namaProduk'])
            ->setCellValue('K'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['hna'])
            ->setCellValue('L'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['hna2'])
            ->setCellValue('M'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['unit'])
            ->setCellValue('N'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['hargaJadi'])
            ->setCellValue('O'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['discPrinsipalAsli'])
            ->setCellValue('P'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['discDistAsli'])
            ->setCellValue('Q'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['totalDiscAsli'])
            ->setCellValue('R'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['discPrinsipal'])
            ->setCellValue('S'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['discDist'])
            ->setCellValue('T'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['totalDisc'])
            ->setCellValue('U'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['keterangan'])
            ->setCellValue('V'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['smId'])
            ->setCellValue('W'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['gsmId'])
            ->setCellValue('X'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['finId'])
            ->setCellValue('Y'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['statusDPF'])
            ->setCellValue('Z'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['tanggalInput'])
            ->setCellValue('AA'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['tanggalApproval'])
            ->setCellValue('AB'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['keteranganApproval'])
            ->setCellValue('AC'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['namaFile'])
            ->setCellValue('AD'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['pdfCreated'])
            ->setCellValue('AE'.$barisGroupDist[$kodeDist], $hsl['Dpfbrngen']['dateCreated'])
            ->setCellValue('AF'.$barisGroupDist[$kodeDist],$kodeCabDist)
            ->setCellValue('AG'.$barisGroupDist[$kodeDist],$cabDist)
            ->setCellValue('AH'.$barisGroupDist[$kodeDist], $distProId)
            ->setCellValue('AI'.$barisGroupDist[$kodeDist], $distProduct)
            ->setCellValue('AJ'.$barisGroupDist[$kodeDist],$distOutId)
            ->setCellValue('AK'.$barisGroupDist[$kodeDist],$distOutlet)
            ->setCellValue('AL'.$barisGroupDist[$kodeDist],$distAlamatOutlet);
$objPHPExcel[$kodeDist]->getActiveSheet()->getStyle('A'.$barisGroupDist[$kodeDist].":".'AL'.$barisGroupDist[$kodeDist])->applyFromArray($ltr);
			$notrain=1;
			
		
		$barisGroupDist[$kodeDist]=$barisGroupDist[$kodeDist]+1;
				}
			}
			 $pdf->Ln();
			 $w=array('40','10','40','10','40');
			$pdf->SetWidths($w);
			$pdf->SetAligns(array('C','L','C','L','C'));
			 $pdf->Row(array('SM','','GSM','','Finance'));	
			 $pdf->Row(array($tglApprovalSM,'',$tglApprovalGSM,'',$tglFinish));	
			 $pdf->Ln();
			 $pdf->Ln();
		    $pdf->Ln();	
			 $pdf->Ln();	
			  $pdf->Ln();	
				$pdf->SetFont('','B');
			   
			 $pdf->Row(array($namaSM[0],'',$namaGSM[0],'',$namaFin[0]));	
if(isset($this->params['url']['perusahaan'])){

$pdf->Output('resultCreate/'.$kodeDist.'/BERNO/DPF GEN/LaporanDPF_'.$noDPF.'_'.$kodeDist.'_'.$distributor.'.pdf','F');	
	}
else{				 
$pdf->Output('result/LaporanDPF'.$noDPF.'_'.$kodeDist.'_'.$distributor.'.pdf','D');
}
}
if($isExcel=='yes'){
$jmlObj=count($objPHPExcel);
$keyObj="";

	foreach($objPHPExcel as $key => $value){
		
		$objWriter = PHPExcel_IOFactory::createWriter($value, 'Excel5')
                                             ->save('resultCreate/'.$key.'/BERNO/DPF GEN/DPF_BRN_GEN'.date('d-M-Y_H-i-s').'.xls');
		
	
	}
	}
exit();
	}
}

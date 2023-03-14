<?php
App::uses('AppController', 'Controller');
/**
 * Approvaldpfbrngens Controller
 *
 */
class ApprovalsubsidisController extends AppController {
public $components = array('Function','Paginator');
function index(){
		// Initialise the framework sessions
		echo $this->Function->cekSession($this);
			}
public function showDetail(){
	 $this->render('showdetail'); 
	 }
 
public function getData(){
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$namaKolom=$_POST['namaKolom'];
		$strCari=$_POST['strCari'];
		$hm=$_POST['hal'];
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		$groupId=$this->Session->read('dpfdpl_groupId');
		if($groupId==13){			
		$rs=$this->Dpfbrngen->getDataDPFByGroupIdByDMId($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'));
		$hasil=$this->Dpfbrngen->getDataDPFByGroupIdByDMIdPaginate($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'),$hm,$limit);
		
			}
		if($groupId==6){			
		$rs=$this->Dpfbrngen->getDataDPFByGroupIdBySMId($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'));
		$hasil=$this->Dpfbrngen->getDataDPFByGroupIdBySMIdPaginate($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'),$hm,$limit);
		
			}
		if($groupId==7){			
		$rs=$this->Dpfbrngen->getDataDPFByGroupIdByGSMId($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'));
		$hasil=$this->Dpfbrngen->getDataDPFByGroupIdByGSMIdPaginate($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'),$hm,$limit);
		
			}		
		if( $groupId==10){			
		$rs=$this->Dpfbrngen->getDataDPFByGroupIdByFinId($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'));
		$hasil=$this->Dpfbrngen->getDataDPFByGroupIdByFinIdPaginate($namaKolom,$strCari,$groupId,$this->Session->read('dpfdpl_pejabatId'),$hm,$limit);
			}
		/*if($groupId==9){
			
		$rs=$this->Dpfbrngen->getDataDPFByGroupIdByGroupDist('namaPemohon',$strCari,$groupId,$this->Session->read('dpfdpl_userId'));
			}	*/	
		$jum=count($rs);
		if($jum==0){echo "not found";exit();}
		$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
	//	$hasil = $rs;
		
		$txt='';
		$hsl='';
		$jum2=count($hasil);
		if($jum2>0){
			$ord='odd';
			$detIndex=0;
			foreach($hasil as $hsl){
		
			$txt=$txt."<tr class='panel-heading'>
			<td><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse$detIndex\">".$hsl['Dpfbrngen']['noDPF']."</a></td>
			<td>".$this->Function->dateindo($hsl['Dpfbrngen']['tanggalInput'])."</td>
			<td>".$hsl['Dpfbrngen']['namaTP']."</td>
			<td>".$hsl['Dpfbrngen']['kodeDist']."</td>
			<td>".$hsl['Dpfbrngen']['distributor']."</td>
			<td>".$hsl['out']['nama_outlet'].'#'.$hsl['out']['alamat']."</td>
			<td align='right'>".$hsl[0]['jmlProd']."</td>
			<td align='right'>".$this->Function->nf($hsl[0]['gsv'])."</td>
			<td align='right'>".$this->Function->nf($hsl[0]['hgJd2'])."</td>
			<td align='right'>".round((floatval($hsl[0]['gsv'])-floatval($hsl[0]['hgJd2']))/floatval($hsl[0]['gsv'])*100,3)."</td>
			<td>".$hsl['Dpfbrngen']['periode']."</td>
			</tr>
			<tr ><td colspan='11' class='zeroPadding'>
			<div id=\"collapse$detIndex\" class=\"collapse out\"><br>
			<table class=\"table table-striped table-bordered\">
			<tr>
			<td><textarea  id='keteranganApproval".$hsl['Dpfbrngen']['noDPF']."' name='keteranganApproval".$hsl['Dpfbrngen']['noDPF']."' class='form-control' placeholder='Isikan ket approval'></textarea></td>
			<td><a title=\"Setuju\" class=\"\" href=\"#\" onclick=\"prosesApproval('setuju','".$hsl["Dpfbrngen"]["noDPF"]."')\"><i class='fa fa-check'>Proses</i></a><br>
			<table class='table table-responsive'><tr><td>Jml Prod</td><td>:</td><td align='right'>".$hsl[0]['jmlProd']."</td></tr>
			<tr><td>gsv+ppn</td><td>:</td><td align='right'>".$this->Function->nf($hsl[0]['gsv'])."</td></tr>
			<tr><td>nsv2+ppn</td><td>:</td><td align='right'>".$this->Function->nf($hsl[0]['hgJd2'])."</td></tr>
			<tr><td>% Disc</td><td>:</td><td align='right'>".round((floatval($hsl[0]['gsv'])-floatval($hsl[0]['hgJd2']))/floatval($hsl[0]['gsv'])*100,3)."</td></tr></table>
			</td><td>
			<a  title=\"Tolak\" class=\"\" href=\"#\" onclick=\"prosesApproval('tolak','".$hsl["Dpfbrngen"]["noDPF"]."')\"><i class='fa fa-remove'>Tolak All</i></a></td>
			</tr>
			</table>
                                <table class=\"table table-striped table-bordered\" >
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>ProId</th>
                                            <th>NamaProduk</th>
                                            <th>gsv</th>
                                            <th>gsv+ppn</th>
                                            <th>gsv2</th>
                                            <th>Unit</th>
                                            <th>nsv1 + ppn</th>
                                            <th>nsv2 + ppn</th>
                                            <th>HJM</th>
                                            <th>Tot Disc</th>
                                            <th>Disc Pric</th>
                                            <th>Disc Dist</th>
                                            <th>Off Faktur</th>
                                            <th>Keterangan</th>											
                                            <th>Reject</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody id='tblDetailDPFBody'>";
                                   $txt.=$this->getDataDetail($hsl['Dpfbrngen']['noDPF']);   
                                 $txt.="</tbody>
                                </table></div>
                                </td></tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			$detIndex++;
			}
			}
		
		
		echo $txt."!".$linkHal."!".$sum;
		
	}	
public function getDataDetail($noDPF){
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		//$noDPF=$_POST['noDPF'];
		$divisiId=2;
		$this->loadModel('Product');
		$rsSetDiscDist=$this->Product->query("select * from setdiscdists where divisiId='".$divisiId."'");
		$setDiscDist=$rsSetDiscDist[0]['setdiscdists']['discDist'];
		if($setDiscDist==0){
			$disabled='disabled=disabled';
			}
		else{$disabled='';}	
		$hm=1;
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		$groupId=$this->Session->read('dpfdpl_groupId');					
		$rs=$this->Dpfbrngen->getDataDPFApproval('noDPF',$noDPF,$groupId);
		
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
				$groupId=$this->Session->read('dpfdpl_groupId');
			if($groupId==13){
				$hjm=$hsl['hjm']['prosenDM'];
				}	
			if($groupId==6){
				$hjm=$hsl['hjm']['prosenSM'];
				}	
			
			if($groupId==7){
				
				$hjm=$hsl['hjm']['prosenGSM'];
				}
			if($groupId==10){			
				$hjm=$hsl['hjm']['prosenFinance'];
				}	
			if($hsl['Dpfbrngen']['totalDisc']>$hjm){
				$txt=$txt."<tr id='baris_".$hsl['Dpfbrngen']['id']."' class='blink-element'>";
				}	
			else{
				$txt=$txt."<tr id='baris_".$hsl['Dpfbrngen']['id']."'>";
				}
			$txt=$txt."<td>".$hsl['Dpfbrngen']['id']."</td>
			<td>".$hsl['Dpfbrngen']['produkId']."</td>
			<td>".$hsl['Dpfbrngen']['namaProduk']."</td>
			<td style='text-align:right' id='hna_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna'])."</td>
			<td style='text-align:right' id='hna_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna']+(0.1*$hsl['Dpfbrngen']['hna']))."</td>
			<td style='text-align:right' id='hna2_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna2'])."</td>
			<td>".$hsl['Dpfbrngen']['unit']."</td>
<td style='text-align:right' id='hargaJadi1_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi1'])."</td>
			<td style='text-align:right' id='hargaJadi_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi'])."</td>";
		$txt.="<td style='text-align:right' id='hjm_".$hsl['Dpfbrngen']['id']."'>".$hjm."</td>";	
			
			$txt.="<td id='totalDisc_".$hsl['Dpfbrngen']['id']."'>".$hsl['Dpfbrngen']['totalDisc']."</td><td><input id='discPrinsipal_".$hsl['Dpfbrngen']['id']."' name='discPrinsipal_".$hsl['Dpfbrngen']['id']."' type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['discPrinsipal'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",this.value,document.forms[0].offFaktur_".$hsl['Dpfbrngen']['id'].".value,document.forms[0].discDist_".$hsl['Dpfbrngen']['id'].".value)' onfocusout=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','false')\"></td>
			<td><input id='discDist_".$hsl['Dpfbrngen']['id']."' name='discDist_".$hsl['Dpfbrngen']['id']."' $disabled type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['discDist'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",document.forms[0].discPrinsipal_".$hsl['Dpfbrngen']['id'].".value,document.forms[0].offFaktur_".$hsl['Dpfbrngen']['id'].".value,this.value)'></td>
			<td><input id='offFaktur_".$hsl['Dpfbrngen']['id']."' name='offFaktur_".$hsl['Dpfbrngen']['id']."' type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['offFaktur'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",document.forms[0].discPrinsipal_".$hsl['Dpfbrngen']['id'].".value,this.value,document.forms[0].discDist_".$hsl['Dpfbrngen']['id'].".value)' onfocusout=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','false')\"></td>
			<td>".$hsl['Dpfbrngen']['keterangan']."</td>
			<td><input type='checkbox' name='reject' id='reject_".$hsl['Dpfbrngen']['id']."'></td>
			<td><a title=\"Setuju\" class=\"\" href=\"#\" onclick=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','true')\"><i class='fa fa-check'></i></a>
			</td></tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			}
			}
		
		
		return $txt;
		
	}
public function getDataDetailPrint(){
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$noDPF=$_POST['noDPF'];
		$divisiId=$this->Session->read('dpfdpl_divisiId');
		$this->loadModel('Product');
		$rsSetDiscDist=$this->Product->query("select * from setdiscdists where divisiId='".$divisiId."'");
		$setDiscDist=$rsSetDiscDist[0]['setdiscdists']['discDist'];
		if($setDiscDist==0){
			$disabled='disabled=disabled';
			}
		else{$disabled='';}	
		$hm=1;
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }
		$groupId=$this->Session->read('dpfdpl_groupId');					
		$rs=$this->Dpfbrngen->getDataDPFApproval('noDPF',$noDPF,$groupId);
		
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
				$groupId=$this->Session->read('dpfdpl_groupId');
			if($groupId==13){
				$hjm=$hsl['hjm']['prosenDM'];
				}	
			if($groupId==6){
				$hjm=$hsl['hjm']['prosenSM'];
				}	
			
			if($groupId==7){
				
				$hjm=$hsl['hjm']['prosenGSM'];
				}
			if($groupId==10){			
				$hjm=$hsl['hjm']['prosenFinance'];
				}	
			if($hsl['Dpfbrngen']['totalDisc']>$hjm){
				$txt=$txt."<tr id='baris_".$hsl['Dpfbrngen']['id']."' class='blink-element'>";
				}	
			else{
				$txt=$txt."<tr id='baris_".$hsl['Dpfbrngen']['id']."'>";
				}
			$txt=$txt."<td>".$hsl['Dpfbrngen']['id']."</td>
			<td>".$hsl['Dpfbrngen']['produkId']."</td>
			<td>".$hsl['Dpfbrngen']['namaProduk']."</td>
			<td style='text-align:right' id='hna_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna'])."</td>
			<td style='text-align:right' id='hna_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna']+(0.1*$hsl['Dpfbrngen']['hna']))."</td>
			<td style='text-align:right' id='hna2_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hna2'])."</td>
			<td>".$hsl['Dpfbrngen']['unit']."</td>
<td style='text-align:right' id='hargaJadi1_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi1'])."</td>
			<td style='text-align:right' id='hargaJadi_".$hsl['Dpfbrngen']['id']."'>".$this->Function->nf($hsl['Dpfbrngen']['hargaJadi'])."</td>";
		$txt.="<td style='text-align:right' id='hjm_".$hsl['Dpfbrngen']['id']."'>".$hjm."</td>";	
			
			$txt.="<td id='totalDisc_".$hsl['Dpfbrngen']['id']."'>".$hsl['Dpfbrngen']['totalDisc']."</td><td><input id='discPrinsipal_".$hsl['Dpfbrngen']['id']."' name='discPrinsipal_".$hsl['Dpfbrngen']['id']."' type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['discPrinsipal'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",this.value,document.forms[0].offFaktur_".$hsl['Dpfbrngen']['id'].".value,document.forms[0].discDist_".$hsl['Dpfbrngen']['id'].".value)' onfocusout=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','false')\"></td>
			<td><input id='discDist_".$hsl['Dpfbrngen']['id']."' name='discDist_".$hsl['Dpfbrngen']['id']."' $disabled type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['discDist'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",document.forms[0].discPrinsipal_".$hsl['Dpfbrngen']['id'].".value,document.forms[0].offFaktur_".$hsl['Dpfbrngen']['id'].".value,this.value)'></td>
			<td><input id='offFaktur_".$hsl['Dpfbrngen']['id']."' name='offFaktur_".$hsl['Dpfbrngen']['id']."' type='text'  class='form-control' value='".trim($hsl['Dpfbrngen']['offFaktur'])."' style='width:50px;text-align:right' onfocus='nilaiLama=this.value;' onfocus='nilaiLama=this.value;' onkeyup='updateNilaiDetil(".$hsl['Dpfbrngen']['id'].",document.forms[0].discPrinsipal_".$hsl['Dpfbrngen']['id'].".value,this.value,document.forms[0].discDist_".$hsl['Dpfbrngen']['id'].".value)' onfocusout=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','false')\"></td>
			<td>".$hsl['Dpfbrngen']['keterangan']."</td>
			<td><input type='checkbox' name='reject' id='reject_".$hsl['Dpfbrngen']['id']."'></td>
			<td><a title=\"Setuju\" class=\"\" href=\"#\" onclick=\"saveDPFDetail('".$hsl['Dpfbrngen']['noDPF']."','".$hsl['Dpfbrngen']['id']."','".$this->Session->read('dpfdpl_groupId')."','".$this->Session->read('dpfdpl_group')."','true')\"><i class='fa fa-check'></i></a>
			</td></tr>";
			if($ord=='odd'){$ord='even';}else{$ord='odd';}
			}
			}
		
		
		return $txt;
		
	}			
public function cetakLaporanPDF(){
	
App::import('Vendor', 'PDF', array('file' => 'fpdf/myPDF.php'));
$this->autoRender = false;

    // Instanciation of inherited class
$pdf = new myPDF();
$pdf->AddPage('L');
$pdf->SetFont('Arial','B',12);
 // Title
$pdf->Cell(0,5,'DAFTAR DPF',0,0,'C');
$pdf->Ln(7);  
$this->loadModel('Dpfbrngen');
$this->autoRender = false;
$noDPF=$this->params['url']['noDPF'];
$hm=1;
$limit=12;
if(empty($hm)||$hm==1){	$start=0; }
else{ $start=($hm-1)*$limit; }					
$rs=$this->Dpfbrngen->getDataDPF('noDPF',$noDPF);

$rec=1;
foreach($rs as $hsl){	
			$namaPemohon=$hsl['Dpfbrngen']['namaPemohon'];
			$periode=$hsl['Dpfbrngen']['periode'];
			$kodeDist=$hsl['Dpfbrngen']['kodeDist'];
			$distributor=$hsl['Dpfbrngen']['distributor'];
			$outlet=$hsl['out']['nama_outlet'].'#'.$hsl['out']['alamat'];
			
			if($rec==1){
				$pdf->SetFont('Arial','B',8);
				$w=array('30','5','100');
				$pdf->SetWidths($w);
				$pdf->SetAligns(array('L','L','L'));
				$pdf->SetFont('Arial','',8);
				$pdf->Row(array('Nama TP',':',$namaTP));
				$pdf->Row(array('Periode',':',$periode));
				$pdf->Row(array('Kode Dist',':',$kodeDist));
				$pdf->Row(array('Distributor',':',$distributor));
				$pdf->Row(array('Outlet',':',$outlet));	
				$pdf->Ln();
				$pdf->SetDrawColor(128,0,0);
				$pdf->SetLineWidth(.3);
				$pdf->SetFont('','B');
			   
				// Color and font restoration
			   // $this->SetFillColor(224,235,255);
				$pdf->SetTextColor(0);
				$pdf->SetFont('');
				 
			  //Set Header
			
					$pdf->Cell(10,12,"No",1,0,'R');
					$pdf->Cell(10,12,"ProId",1,0,'L');
					$pdf->Cell(60,12,"Nama Prod",1,0,'L');
					$pdf->Cell(40,12,"Hna",1,0,'R');
					$pdf->Cell(40,12,"Hna2",1,0,'R');
					$pdf->Cell(40,12,"Unit",1,0,'R');
					
					$pdf->Cell(50,12,"Keterangan",1,0,'R');
					$pdf->Cell(0,4,"",0,1,'L');
					 //header line 2
					$pdf->SetX(145);
					$pdf->Cell(15,4,"Beban",1,0,'L');
					$pdf->Cell(15,4,"Beban",1,0,'L');
					$pdf->Cell(15,4,"Dist",1,0,'L');
					$pdf->Cell(15,4,"Berno",1,0,'L');
					$pdf->Ln();
					 //header line 3
					$pdf->SetX(145);
					$pdf->Cell(15,4,"Dist",1,0,'L');
					$pdf->Cell(15,4,"Berno",1,0,'L');
					$pdf->Cell(15,4,"Claim Berno",1,0,'L');
					$pdf->Cell(15,4,"Claim Dist",1,0,'L');	
					$pdf->Ln();
				}
				$w=array('10','10','60','40','15','15','15','15','15','50');
				$pdf->SetWidths($w);
				$pdf->SetAligns(array('L','L','L','R','R','R','R','R','R','L'));
				$pdf->SetFont('Arial','',8);
				$pdf->Row(array($rec.".", $hsl['Dpfbrngen']['produkId'],$hsl['Dpfbrngen']['namaProduk'],$hsl['Dpfbrngen']['hna'],$hsl['Dpfbrngen']['hna2'],
				$hsl['Dpfbrngen']['unit'],$bebanBerno,$hsl['Dpfbrngen']['hargaJadi'],$hsl['Dpfbrngen']['discPrinsipal'],$hsl['Dpfbrngen']['keterangan']));	
		
		$rec++;	
			}
$pdf->Output('LaporanDPF.pdf','D');
exit();
	}			
public function prosesApproval(){
		
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$noDPF=$_POST['noDPF'];
		$statusApproval=$_POST['statusApproval'];
		$keteranganApproval=$_POST['keteranganApproval'];	
		$idRejectCols=$_POST['idRejectCols'];	
		
		$this->Dpfbrngen->prosesApproval($this->Session->read('dpfdpl_userId'),$this->Session->read('dpfdpl_namaUser'),$this->Session->read('dpfdpl_groupId'),$noDPF,$statusApproval,$keteranganApproval,$idRejectCols);
	$cekCSV=$this->Dpfbrngen->cekCreateCsv($noDPF);
		if(count($cekCSV)<=0){
		$this->createCsv($this->Dpfbrngen->cekData3($noDPF,'finish'));}
		}
public function saveDPFDetail(){
		try{
		
		$this->loadModel('Dpfbrngen');
		$this->autoRender = false;
		$dpfId=$_POST['DPFId'];
		$groupId=$_POST['groupId'];
		$group=$_POST['group'];
		$discPrinsipal=$_POST['discPrinsipal'];
		$discDist=$_POST['discDist'];
		$offFaktur=$_POST['offFaktur'];
		$hargaJadi1=$_POST['hargaJadi1'];
		$hargaJadi=$_POST['hargaJadi'];
		$totalDisc=$_POST['totalDisc'];
		$getDPFById=$this->Dpfbrngen->findById($dpfId);
		if($groupId==13){
			$offFakturCol="offFakturDM";
			$discPrinsipalCol="discPrinsipalDM";
			$discDistCol="discDistDM";
			$totalDiscCol="totalDiscDM";
			}
		if($groupId==6){
			$offFakturCol="offFakturSM";
			$discPrinsipalCol="discPrinsipalSM";
			$discDistCol="discDistSM";
			$totalDiscCol="totalDiscSM";
			}
		if($groupId==7){
			$offFakturCol="offFakturGSM";
			$discPrinsipalCol="discPrinsipalGSM";
			$discDistCol="discDistGSM";
			$totalDiscCol="totalDiscGSM";}
		if($groupId==10){
			$offFakturCol="offFakturFIN";
			$discPrinsipalCol="discPrinsipalFin";
			$discDistCol="discDistFin";
			$totalDiscCol="totalDiscFin";}
		$singleRecData = array(
							'Dpfbrngen' => array(								
								'discPrinsipal' => $discPrinsipal,				
								'offFaktur' => $offFaktur,		
								'discDist' => $discDist,	
								'hargaJadi1' => $hargaJadi1,		
								'hargaJadi' => $hargaJadi,		
								'totalDisc' => $totalDisc,
								$discPrinsipalCol=>$discPrinsipal,
								$offFakturCol=>$offFaktur,
								$discDistCol=>$discDist,
								$totalDiscCol=>$totalDisc,
								'keteranganEdit' => 'edited by '.$group									
								)
						);	
			$this->Dpfbrngen->id=$dpfId;			
		 	$this->Dpfbrngen->save($singleRecData);
			echo "Data berhasil diupdate";
			}
		catch(Exception $e){echo $e->getMessage();}
		
		}		
public function createCsv($dataCsv){
		
		//var_dump($dataCsv);
		foreach($dataCsv as $dnama){	
		
		foreach($dataCsv as $cekCsv){
				$ada=0;
				$b=0;
				if($cekCsv['Dpfbrngen']['distributor']==$cekCsv['m_out']['kotaid']){
					$kotaDist=$cekCsv['Dpfbrngen']['distributor'];
					$kotaOut=$cekCsv['m_out']['kotaid'];
					$kotaFile=$cekCsv['Dpfbrngen']['distributor'];
					$ada++;
					break;
				}else{
					$b++;
					$kotaDist=$dataCsv[0]['Dpfbrngen']['distributor'];
					$kotaOut=$dataCsv[0]['m_out']['kotaid'];
					$kotaFile=$dataCsv[0]['m_out']['kotaid'];
						}
				}
				
				if($kotaFile=='JKT1'){$kotaFile='JKT';}
				if($kotaFile=='BMA'){$kotaFile='BIM';}
				if($kotaFile=='GTL'){$kotaFile='GTO';}
				if($kotaFile=='KND'){$kotaFile='KDR';}
				if($kotaFile=='BJM'){$kotaFile='BMS';}
				
				$namaFile=trim($kotaFile).".".trim($dnama["Dpfbrngen"]["tanggalApproval"]).".".trim($dnama["Dpfbrngen"]["noDPF"]);
			//echo $ada."***".$b."***".$kotaDist."***".$kotaOut;
		
		$kodeDistributor=$dnama["Dpfbrngen"]["kodeDist"];
			
		}
		// jika KodeDistributor TSJ
		if($kodeDistributor=="TSJ"){
		
		
		App::import('Vendor', 'PHPExcel', array('file' => 'excel/PHPExcel.php'));    
		$this->autoRender = false;
				
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Asia/Jakarta');
		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');
		
		//require_once '../functions/phpExcel/PHPExcel.php';
		//echo "jalan";
		//var_dump($dataCsv);
		//exit();
		/*$rsGroup=$dbCon->execute("SELECT * FROM datatsj GROUP BY kodecabtsj2,tgl_pk,referensi,no_sppk HAVING kodecabtsj2<>''
		AND tgl_pk<>'' AND referensi<>'' AND no_sppk<>''");*/
		//array_map('unlink', glob("../hasilCSV/*"));
		
		
		//while($dtGroup=$dbCon->getArray($rsGroup)){
		//$ref=substr($dtGroup['referensi'],3,strpos($dtGroup['referensi']," ")-3);
		//var_dump($dataCsv);
		//exit();
		
		
		
		
		
		//	Start Excel
		// Create new PHPExcel object
		
		
		$objPHPExcel = new PHPExcel();
		//var_dump($dataCsv); exit(); 
				// Set document properties
		$objPHPExcel->getProperties()->setCreator("EDP")
									 ->setLastModifiedBy("EDP")
									 ->setTitle($namaFile)
									 ->setSubject($namaFile)
									 ->setDescription($namaFile)
									 ->setKeywords($namaFile)
									 ->setCategory("Laporan");
		
		// Set page orientation and size and margin
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$margin=0.5; // in inch
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
		
		// Set fonts
		/*$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setName('Consolas');
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(20);
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);*/
		
		// Set alignments
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A:N')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
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
		$objPHPExcel->getActiveSheet()->setTitle('DPF_BERNO_GEN_DIST');
		
		// Set column widths
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(8);
		
		
			$baris=1;
			$no=1;
			$dCsv=array();
		
			$i=0;
			
				
				foreach($dataCsv as $dCsv){
					
				if($ada==1){
				if($dCsv['Dpfbrngen']['distributor']==$kotaDist&&$dCsv['m_out']['kotaid']==$kotaOut){
								
				$tgl=explode("-",trim($dCsv['Dpfbrngen']['tanggalApproval']));
				$tglCsv=$tgl[2]."/".$tgl[1]."/".$tgl[0];
				$period=explode("-",$dCsv["Dpfbrngen"]["periode"]);
				
				$kotacabang=strtoupper($dCsv["cab_dists"]["alamat"]); // blm fix
				$kotaid=$dCsv["cab_dists"]["nama_cabang"];
				if($kotaid=='JKT1'){$kotaid='JKT';}
				if($kotaid=='BMA'){$kotaid='BIM';}
				if($kotaid=='GTL'){$kotaid='GTO';}
				if($kotaid=='KND'){$kotaid='KDR';}
				if($kotaid=='BJM'){$kotaid='BMS';}
				$comOutId=$dCsv["Dpfbrngen"]["comId"]."-".$dCsv["Dpfbrngen"]["outletId"];
				$noDPF=$dCsv["Dpfbrngen"]["noDPF"]; // blm fix
				$noDPFPecah=explode("-",$noDPF);
				
				$tanggalInput=$dCsv["Dpfbrngen"]["tanggalInput"];
				$bebanDistributor='0'; // blm fix
				$data4=''; // blm fix
				$kode=$dCsv["m_out"]["kode"];
				$namaOutlet=$dCsv["m_out"]["nama"];
				$kode_prod=$dCsv["m_pro"]["kode_prod"];
				$nama_prod=$dCsv["m_pro"]["nama"];
				$produkId=$dCsv["Dpfbrngen"]["produkId"];
				$qty=$dCsv["Dpfbrngen"]["unit"];
				$diskonOn=$dCsv["Dpfbrngen"]["discPrinsipal"]+$dCsv["Dpfbrngen"]["discDist"]; // blm fix
				$hna=$dCsv["Dpfbrngen"]["hna2"];
				$periode1=$period[1]."".$period[0];
				$periode2=$period[1]."".$period[0];
				$data6=''; 
				
				$mkt=substr($dCsv["Dpfbrngen"]["divisi"],-1,1)."".substr($dCsv["Dpfbrngen"]["subDivisi"],-1,1); // blm fix
				
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$baris,$kotacabang, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('B'.$baris,$kotaid)
					->setCellValueExplicit('C'.$baris,$comOutId, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('D'.$baris,$noDPFPecah[1])
					->setCellValue('E'.$baris,$tanggalInput)
					->setCellValue('F'.$baris,$bebanDistributor)
					->setCellValueExplicit('G'.$baris,$data4, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('H'.$baris,$kode)
					->setCellValue('I'.$baris,$namaOutlet)
					->setCellValue('J'.$baris,$kode_prod)
					->setCellValue('K'.$baris,$nama_prod)
					->setCellValue('L'.$baris,$produkId)
					->setCellValue('M'.$baris,$qty)
					->setCellValue('N'.$baris,$diskonOn)
					->setCellValue('O'.$baris,$hna)
					->setCellValue('P'.$baris,$periode1)
					->setCellValue('Q'.$baris,$periode2)
					->setCellValue('R'.$baris,$data6)
					->setCellValue('S'.$baris,$mkt);
					
							
				
				$no++;
				$baris=$baris+1;
				$i++;
				}}
				else if($b>=1){
				if($dCsv['Dpfbrngen']['distributor']==$kotaDist&&$dCsv['m_out']['kotaid']==$kotaOut){
								
				$tgl=explode("-",trim($dCsv['Dpfbrngen']['tanggalApproval']));
				$tglCsv=$tgl[2]."/".$tgl[1]."/".$tgl[0];
				$period=explode("-",$dCsv["Dpfbrngen"]["periode"]);
				
				$kotacabang=strtoupper($dCsv["cab_out"]["alamat"]); // blm fix
				$kotaid=$dCsv["m_out"]["kotaid"];
				$comOutId=$dCsv["Dpfbrngen"]["comId"]."-".$dCsv["Dpfbrngen"]["outletId"];
				$noDPF=$dCsv["Dpfbrngen"]["noDPF"]; // blm fix
				$tanggalInput=$dCsv["Dpfbrngen"]["tanggalInput"];
				$bebanDistributor='0'; // blm fix
				$noDPFPecah=explode("-",$noDPF);
				$data4=''; // blm fix
				$kode=$dCsv["m_out"]["kode"];
				$namaOutlet=$dCsv["m_out"]["nama"];
				$kode_prod=$dCsv["m_pro"]["kode_prod"];
				$nama_prod=$dCsv["m_pro"]["nama"];
				$produkId=$dCsv["Dpfbrngen"]["produkId"];
				$qty=$dCsv["Dpfbrngen"]["unit"];
				$diskonOn=$dCsv["Dpfbrngen"]["discPrinsipal"]+$dCsv["Dpfbrngen"]["discDist"]; // blm fix
				$hna=$dCsv["Dpfbrngen"]["hna2"];
				$periode1=$period[1]."".$period[0];
				$periode2=$period[1]."".$period[0];
				$data6=''; 
				
				$mkt=substr($dCsv["Dpfbrngen"]["divisi"],-1,1)."".substr($dCsv["Dpfbrngen"]["subDivisi"],-1,1); // blm fix
				
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$baris,$kotacabang, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('B'.$baris,$kotaid)
					->setCellValueExplicit('C'.$baris,$comOutId, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('D'.$baris,$noDPFPecah[1])
					->setCellValue('E'.$baris,$tanggalInput)
					->setCellValue('F'.$baris,$bebanDistributor)
					->setCellValueExplicit('G'.$baris,$data4, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('H'.$baris,$kode)
					->setCellValue('I'.$baris,$namaOutlet)
					->setCellValue('J'.$baris,$kode_prod)
					->setCellValue('K'.$baris,$nama_prod)
					->setCellValue('L'.$baris,$produkId)
					->setCellValue('M'.$baris,$qty)
					->setCellValue('N'.$baris,$diskonOn)
					->setCellValue('O'.$baris,$hna)

					->setCellValue('P'.$baris,$periode1)
					->setCellValue('Q'.$baris,$periode2)
					->setCellValue('R'.$baris,$data6)
					->setCellValue('S'.$baris,$mkt);
					
							
					$notrain=1;
					
				$no++;
				$baris=$baris+1;
				$i++;
				}	
			}
			}
			
			
			
			
		
		
		//$objPHPExcel->setActiveSheetIndex(0)
		//           ->setCellValue('H'.$baris, "Dicetak Tanggal : ".date('d-M-Y'));
		
		// Redirect output to a client's web browser (Excel5)
		/*header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$ref.'".xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0*/
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')->setDelimiter('|')
													 ->setEnclosure('')
													 ->setLineEnding("|\r\n")
													 ->save('data_dpl_dpf/internal/'.$kodeDistributor.'/dpf/gen/'.$namaFile.'.csv');
		//$objWriter->save('../hasilCSV/'.$namaFile.'.csv');
			
		//echo "Data CSV berhasil diproses";	
	exit();
		
		
		}// end jika KodeDistributor TSJ
		
		}	
	
	}
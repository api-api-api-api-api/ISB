<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopupsuppliersController extends AppController {
	public $components = array('Function','Paginator');	
	public function index(){
	echo $this->Function->cekSession($this);
	}
	public function getData(){
	$this->autoRender = false;
	
	$txtOutlet=$_POST['txtOutlet'];
	$hm=$_POST['hal'];
	$txtData='';
	$limit=10;
	$this->loadModel('Penawaranfpb');
	/*$order=$_POST['order'];
	if(empty($order)){$order=="nama";}*/
	if(empty($hm)||$hm==1){
		$start=0; 
	}else{ 
		$start=($hm-1)*$limit; 
	}
		// $cProduct="SELECT DISTINCT prod_divisis.proid,prod_divisis.nama_produk,prod_divisis.hna  FROM prod_divisis inner join (select distinct proId,nama from matc_prods) matc_prods on prod_divisis.proId=matc_prods.proId WHERE divid='$divisiId' AND nama_produk like '%$txtOutlet%' order by nama_produk";
		$cSupplier="SELECT * FROM  suppliers ORDER BY idsupplier";
		
	
	$resSupplier=$this->Penawaranfpb->query($cSupplier);
	$jumSupplier=count($resSupplier);
	
	
	$sum=ceil($jumSupplier/$limit);
	/* -----------------------------Navigasi Record ala google style ----------------------------- */
	$linkHal=$this->Function->pageNav($hm,$sum,$limit);
	/* -----------------------------End Navigasi Record ala google style ----------------------------- */
	$rsTampil=$this->Penawaranfpb->query($cSupplier." limit $start, $limit");
	
	$n=$start+1;
		$txtHead="<tr>
			
			<td align=\"center\"></td>
			<td align=\"center\" >supid</td>
			<td align=\"center\">Nama Supplier</td>
			
			</tr>";
	foreach($rsTampil as $dataProduct){
		$supId=$dataProduct['suppliers']['idsupplier'];
		$nama=$dataProduct['suppliers']['nama'];
		
		$txtData.="<tr>
			<td align=\"center\"><input type='checkbox' name='pilih' id='pilih".$supId."'></td>
			<td id='id".$supId."' align=\"center\" >".$supId."<input type='hidden' name='supid' id='supid".$supId."' value='$supId'></td>
			<td id='txtNama".$supId."' align=\"left\">$nama</td>
			</tr>";
			$n++;
			
		}
	echo $txtHead."!".$txtData."!".$linkHal;
	
	}	
}
<?php
App::uses('AppController', 'Controller');
/**
 * Master supplier
 *
 */
class MastersuppliersController extends AppController {
	public $components = array('Function','Paginator');	
	public function index(){
	echo $this->Function->cekSession($this);
	}
	public function getData(){
		$this->autoRender = false;
	
	$txtSupplier=$_POST['txtSupplier'];
	$getFilter=$_POST['getFilter'];
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
		$cSupplier="SELECT * FROM  definance.suppliers WHERE suppliers.".$getFilter." like '%$txtSupplier%' ORDER BY nama asc";
		
	
	$resSupplier=$this->Penawaranfpb->query($cSupplier);
	$jumSupplier=count($resSupplier);
	
	
	$sum=ceil($jumSupplier/$limit);
	/* -----------------------------Navigasi Record ala google style ----------------------------- */
	$linkHal=$this->Function->pageNav($hm,$sum,$limit);
	/* -----------------------------End Navigasi Record ala google style ----------------------------- */
	$rsTampil=$this->Penawaranfpb->query($cSupplier." limit $start, $limit");
	$ord='odd';
	$detIndex=0;	
	if ($jumSupplier=='' || $jumSupplier==Null) {
		$txtHead="<tr>
			
			<td align=\"center\"></td>
			<td align=\"center\" style=\"display:none\" >supid</td>
			<td align=\"center\">supplier</td>
			<td align=\"center\">deskripsi</td>
			<td align=\"center\">alamat</td>
			<td align=\"center\" style=\"display:none\">kode pos</td>
			<td align=\"center\" style=\"display:none\">telp</td>
			<td align=\"center\" style=\"display:none\">fax</td>
			<td align=\"center\" style=\"display:none\">email</td>
			<td align=\"center\" style=\"display:none\">dengan PPN</td>
			</tr>";
			$txtData.="<tr>
			<td colspan='11' align=\"center\"> Kosong </td>
			</tr>";
	}else{
		$n=$start+1;
		$txtHead="<tr>
			<td align=\"center\"></td>
			<td align=\"center\" style=\"display:none\">supid</td>
			<td align=\"center\" >supplier</td>
			<td align=\"center\">deskripsi</td>
			<td align=\"center\">alamat</td>
			<td align=\"center\" style=\"display:none\">kode pos</td>
			<td align=\"center\" style=\"display:none\">telp</td>
			<td align=\"center\" style=\"display:none\">fax</td>
			<td align=\"center\" style=\"display:none\">email</td>
			<td align=\"center\" style=\"display:none\">dengan PPN</td>
			</tr>";
	foreach($rsTampil as $dataProduct){
		$supId=$dataProduct['suppliers']['idsupplier'];
		$nama=$dataProduct['suppliers']['nama'];
		$deskripsi=$dataProduct['suppliers']['deskripsi'];
		$alamat=$dataProduct['suppliers']['alamat'];
		$kodepos=$dataProduct['suppliers']['kodepos'];
		$notelp=$dataProduct['suppliers']['notelp'];
		$nofax=$dataProduct['suppliers']['nofax'];
		$email=$dataProduct['suppliers']['email'];
		$denganPPN=$dataProduct['suppliers']['denganPPN'];
		$txtData.="<tr>
			<td align=\"center\">$n</td>
			<td align=\"center\" style='display:none'><input type='checkbox' name='pilih' id='pilih".$supId."'></td>
			<td id='id".$supId."' align=\"center\" style=\"display:none\" >".$supId."<input type='hidden' name='supid' id='supid".$supId."' value='$supId'></td>
			<td id='txtNama".$supId."' align=\"left\"><a href='javascript:void(0)' onClick='updateToData(\"".$supId."\")'>$nama</a>&nbsp&nbsp</a></td>
			<td id='txtDeskripsi".$supId."' align=\"left\">$deskripsi</td>
			<td id='txtAlamat".$supId."' align=\"left\">$alamat</td>
			<td id='txtKodePos".$supId."' align=\"left\" style=\"display:none\">$kodepos</td>
			<td id='txtNoTelp".$supId."' align=\"left\" style=\"display:none\">$notelp</td>
			<td id='txtNoFax".$supId."' align=\"left\" style=\"display:none\">$nofax</td>
			<td id='txtEmail".$supId."' align=\"left\" style=\"display:none\">$email</td>
			<td id='txtDenganPPN".$supId."' align=\"center\" style=\"display:none\">$denganPPN</td>
			</tr>";
			
			$n++;
			
		}
	}
	echo $txtHead."!".$txtData."!".$linkHal;
	}
}
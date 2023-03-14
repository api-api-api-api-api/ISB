<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopupproduksController extends AppController {
public $components = array('Function','Paginator');	

public function index(){
	
	echo $this->Function->cekSession($this);
	}
public function cekProdukDist(){
	$this->autoRender = false;
	$kodeDists=$_POST['kodeDists'];
	$cabangDists=$_POST['cabangDists'];
	$proId=$_POST['proId'];
	$namaProd=$_POST['namaProd'];
	$kodeDists=explode("-!-",$kodeDists);
	$cabangDists=explode("-!-",$cabangDists);
	$proId=explode("-!-",$proId);
	$namaProd=explode("-!-",$namaProd);
	$this->loadModel('Mastersektorbrngen');
	$jum=count($proId);
	$jml=count($kodeDists);
	$matchProd='belumMatch';
	for($j=0;$j<$jum;$j++){
		$produkId=$proId[$j];
		$namaProduk=$namaProd[$j];
	for($n=0;$n<$jml;$n++){
		
		if(trim($kodeDists[$n])<>'' ){
		$kodeDist=explode("#",$kodeDists[$n]);
		//$cabangDist=explode("#",$cabangDists[$n]);
		
		$kodeDist=$kodeDist[1];
		//$cabangDist=$cabangDist[3];
		if(trim($kodeDist)<>'' ){
			
			$cekOutlet=$this->Mastersektorbrngen->query("select * from matc_prods where kode_dist='$kodeDist' and proId='$produkId'");
			
			if(count($cekOutlet)>0){
				$matchProd='sudahMatch';
				}
			else{echo 'belumMatch'."-!-".$namaProduk."-!-".$kodeDist;exit();}	
			}
	}
		}
	}
		
	echo $matchProd;
	}		
public function getSetDiscDist(){
	$this->autoRender = false;
	$divisiId=$this->Session->read('dpfdpl_divisiId');
	$this->loadModel('Product');
	$rsSetDiscDist=$this->Product->query("select * from setdiscdists where divisiId='".$divisiId."'");
	$setDiscDist=$rsSetDiscDist[0]['setdiscdists']['discDist'];
	echo $setDiscDist;
	}
public function getData(){
	$this->autoRender = false;
	$divisiId=$this->Session->read('dpfdpl_divisiId');
	if($divisiId==2){
		$subDivisi=$_POST['subDivisi'];
		
	}
	$subDivisi=$this->Session->read('dpfdpl_subDivisi');
	
	$prodDivisiLain=$_POST['prodDivisiLain'];
	$txtOutlet=$_POST['txtOutlet'];
	$hm=$_POST['hal'];
	$txtData='';
	$limit=10;
		$this->loadModel('Setting');
	/*$order=$_POST['order'];
	if(empty($order)){$order=="nama";}*/
		if(empty($hm)||$hm==1){$start=0; }
		else{ $start=($hm-1)*$limit; }
		$cProduct="SELECT DISTINCT prod_divisis.proid,prod_divisis.nama_produk,prod_divisis.hna  FROM prod_divisis inner join (select distinct proId,nama from matc_prods) matc_prods on prod_divisis.proId=matc_prods.proId WHERE divid='$divisiId' AND nama_produk like '%$txtOutlet%' order by nama_produk";
		
	if($divisiId==2){
		$cProduct="SELECT DISTINCT prod_divisis.proid,prod_divisis.nama_produk,prod_divisis.hna  FROM prod_divisis inner join  (select distinct proId,nama from matc_prods) matc_prods on prod_divisis.proId=matc_prods.proId WHERE divid='$divisiId'
					and subDiv='$subDivisi' AND nama_produk like '%$txtOutlet%' order by nama_produk";
		if($subDivisi=='GTR'){
				$cProduct="SELECT DISTINCT prod_divisis.proid,prod_divisis.nama_produk,prod_divisis.hna  FROM prod_divisis inner join  (select distinct proId,nama from matc_prods) matc_prods on prod_divisis.proId=matc_prods.proId WHERE divid='$divisiId'
					 AND nama_produk like '%$txtOutlet%' order by nama_produk";
			}			
		
		
	}
	if($prodDivisiLain=='true'){
			$cProduct="SELECT DISTINCT prod_divisis.proid,prod_divisis.nama_produk,prod_divisis.hna  FROM prod_divisis inner join (select distinct proId,nama from matc_prods) matc_prods on prod_divisis.proId=matc_prods.proId WHERE nama_produk like '%$txtOutlet%' order by nama_produk";
			}
	$resProduct=$this->Setting->query($cProduct);
	$jumProduct=count($resProduct);
	
	
	$sum=ceil($jumProduct/$limit);
	/* -----------------------------Navigasi Record ala google style ----------------------------- */
	$linkHal=$this->Function->pageNav($hm,$sum,$limit);
	/* -----------------------------End Navigasi Record ala google style ----------------------------- */
	$rsTampil=$this->Setting->query($cProduct." limit $start, $limit");
	
	$n=$start+1;
		$txtHead="<tr>
			
			<td align=\"center\"></td>
			<td align=\"center\" >proid</td>
			<td align=\"center\">Nama</td>
			<td align=\"center\">Hna</td>
			
			</tr>";
	foreach($rsTampil as $dataProduct){
		$proId=$dataProduct['prod_divisis']['proid'];
		$nama=$dataProduct['prod_divisis']['nama_produk'];
		$hna=$dataProduct['prod_divisis']['hna'];
		
		
	
		
		$txtData.="<tr>
			<td align=\"center\"><input type='checkbox' name='pilih' id='pilih".$proId."'></td>
			<td id='id".$proId."' align=\"center\" >".$proId."<input type='hidden' name='proid' id='proid".$proId."' value='$proId'></td>
			<td id='txtNama".$proId."' align=\"left\">$nama</td>
			<td id='txtHna".$proId."' align=\"left\">".number_format($hna,0,",",".")."</td>
			
			</tr>";
			$n++;
			
		}
	echo $txtHead."!".$txtData."!".$linkHal;
	
	}			
}

<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopupitemsController extends AppController {
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
		if(empty($hm)||$hm==1){
		$start=0; 
		}else{ 
			$start=($hm-1)*$limit; 
		}
		$cItems="SELECT * FROM  masterbarangs mbr ORDER BY id";
	
		$resitems=$this->Penawaranfpb->query($cItems);
		$jumItems=count($resitems);

	
		$sum=ceil($jumItems/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,$limit);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$rsTampil=$this->Penawaranfpb->query($cItems." limit $start, $limit");

		$n=$start+1;
		$txtHead="<tr>
			<td align=\"center\"></td>
			<td align=\"center\" >id</td>
			<td align=\"center\">item barang</td>
			<td align=\"center\">kategori</td>
			<td align=\"center\">jenis</td>
			</tr>";
		foreach($rsTampil as $dataItem){
			$itemId=$dataItem['mbr']['id'];
			$nama=$dataItem['mbr']['namaBarang'];
			$kategori=$dataItem['mbr']['kategori'];
			$jenis=$dataItem['mbr']['jenis'];
			
			$txtData.="<tr>
				<td align=\"center\"><input type='checkbox' name='pilih' id='pilih".$itemId."'></td>
				<td id='id".$itemId."' align=\"center\" >".$itemId."<input type='hidden' name='itemId' id='itemid".$itemId."' value='$itemId'></td>
				<td id='txtNama".$itemId."' align=\"left\">$nama</td>
				<td id='txtkategori".$itemId."' align=\"left\">$kategori</td>
				<td id='txtJenis".$itemId."' align=\"left\">$jenis</td>
				</tr>";
				$n++;
		}
		echo $txtHead."!".$txtData."!".$linkHal;
	}
}
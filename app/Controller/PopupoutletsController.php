<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopupoutletsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}

public function getData(){
		$this->autoRender = false;
		$this->loadModel('Outlet');
		$namaKolom=$_POST['namaKolom'];
		$strCari=$_POST['strCari'];
		$hm=$_POST['hal'];
		$comId=$_POST['comId'];
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }		
		$rs=$this->Outlet->getData($comId,$namaKolom,$strCari);
		
		$jum=count($rs);
		$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		$hasil =$this->Outlet->paginate($comId,$namaKolom,$strCari,$start,$limit);
		
		$txt='';
		$hsl='';
		$jum2=count($hasil);
		if($jum2>0){
			foreach($hasil as $hsl){	
			$txt=$txt."outlet|".$hsl['Outlet']['comid']."|".$hsl['Outlet']['outid']."|".$hsl['Outlet']['nama']."|".$hsl['Outlet']['alamat_ktr']."|".$hsl['Outlet']['kota_ktr']."|^";
			}
			
			}
		$keterangan="Record ".($start+1)." to ".($start+count($hasil));
		echo $txt."!".$linkHal."!".$sum."!".$keterangan."!";
		
	}			
}

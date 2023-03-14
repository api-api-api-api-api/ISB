<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutletlaps Controller
 *
 */
class PopupoutletlapsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}

public function getData(){
		$this->autoRender = false;
		$this->loadModel('Dpl');
		$namaKolom=$_POST['namaKolom'];
		$periodeDPL='';
		$nomorDPL='';
		$comId='';
		$outletId='';
		$strCari=$_POST['strCari'];
		$hm=$_POST['hal'];
		
		$groupId=$this->Session->read('dpfdpl_groupId');
		$limit=12;
		if(empty($hm)||$hm==1){	$start=0; }
		else{ $start=($hm-1)*$limit; }		
		//$rs=$this->Outlet->getData($comId,$namaKolom,$strCari);
		
		//$jum=count($rs);
		//$sum=ceil($jum/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		//$linkHal=$this->Function->pageNav($hm,$sum,9);
		
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		if($groupId==2){
		$rs=$this->Dpl->getDataOutletLaporanArco($namaKolom,$strCari,$periodeDPL,$nomorDPL,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}
		if($groupId==5){
		$rs=$this->Dpl->getDataOutletLaporanKacabDist($namaKolom,$strCari,$periodeDPL,$nomorDPL,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}
		if($groupId==6){			
		$rs=$this->Dpl->getDataOutletLaporanSM($namaKolom,$strCari,$periodeDPL,$nomorDPL,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}	
		if($groupId==7 || $groupId==8){			
		$rs=$this->Dpl->getDataOutletLaporanGSMDir($namaKolom,$strCari,$periodeDPL,$nomorDPL,$comId,$outletId);
			}
			if($groupId==9){
			
		$rs=$this->Dpl->getDataOutletLaporanPusatDist($namaKolom,$strCari,$periodeDPL,$nomorDPL,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}	
		
		$txt='';
		$hsl='';
		$jum2=count($rs);
		if($jum2>0){
			foreach($rs as $hsl){	
			$txt=$txt."outlet|".$hsl['out']['comid']."|".$hsl['out']['outid']."|".$hsl['out']['nama']."|".$hsl['out']['alamat_ktr']."|".$hsl['out']['kota_ktr']."|^";
			}
			
			}
		$keterangan="Record ".($start+1)." to ".($start+count($hasil));
		echo $txt."!".$linkHal."!".$sum."!".$keterangan."!";
		
	}			
}

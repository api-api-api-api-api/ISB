<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutletsektorlaps Controller
 *
 */
class PopupoutletsektorlapsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}

public function getData(){
		$this->autoRender = false;
		$this->loadModel('Dpf');
		$namaKolom=$_POST['namaKolom'];
		$periodeDPF='';
		$nomorDPF='';
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
			
		$rs=$this->Dpf->getDataOutletLaporanArco($namaKolom,$strCari,$periodeDPF,$nomorDPF,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
				}
		if($groupId==5){
		$rs=$this->Dpf->getDataOutletLaporanKacabDist($namaKolom,$strCari,$periodeDPF,$nomorDPF,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}
		if($groupId==6){			
		$rs=$this->Dpf->getDataOutletLaporanSM($namaKolom,$strCari,$periodeDPF,$nomorDPF,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}	
		if($groupId==7 || $groupId==8){			
		$rs=$this->Dpf->getDataOutletLaporanGSMDir($namaKolom,$strCari,$periodeDPF,$nomorDPF,$comId,$outletId);
			}
			if($groupId==9){
			
		$rs=$this->Dpf->getDataOutletLaporanPusatDist($namaKolom,$strCari,$periodeDPF,$nomorDPF,$comId,$outletId,$this->Session->read('dpfdpl_userId'));
			}	
		
		$txt='';
		$hsl='';
		$jum2=count($rs);
		if($jum2>0){
			foreach($rs as $hsl){	
			$txt=$txt."outlet|".$hsl['out']['COMID']."|".$hsl['out']['OUTID']."|".$hsl['out']['nama_outlet']."|".$hsl['out']['alamat']."|^";
			}
			
			}
		$keterangan="Record ".($start+1)." to ".($start+count($rs));
		echo $txt."!!!".$keterangan."!";
		
	}			
}

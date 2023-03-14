<?php
App::uses('AppModel', 'Model');
/**
 * Mastersektorqtmgen Model
 *
 */
class Mastersektorqtmgen extends AppModel {
public function getDataByNamaOutlet($namaOutlet){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'nama_outlet LIKE' => "%".$namaOutlet."%"
				),
				'fields' => array('Mastersektorqtmgen.*'),
				'order' => 'Mastersektorqtmgen.nama_outlet'
			));
	}	
public function getDataByNamaOutletPaginate($namaOutlet,$start,$limit){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'nama_outlet LIKE' => "%".$namaOutlet."%"
				),
				'fields' => array('Mastersektorqtmgen.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Mastersektorqtmgen.nama_outlet'
			));
	}	
public function getData($comId,$outId,$namaKolom,$strCari){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'COMID' =>$comId,
				  	'OUTID' =>$outId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorqtmgen.*'),
				'order' => 'Mastersektorqtmgen.nama_outlet'
			));
	}
public function paginate($comId,$namaKolom,$strCari,$start,$limit){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'comid' =>$comId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorqtmgen.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Mastersektorqtmgen.nama_outlet'
			));
	}
}

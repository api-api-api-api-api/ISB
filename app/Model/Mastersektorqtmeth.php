<?php
App::uses('AppModel', 'Model');
/**
 * Mastersektorqtmeth Model
 *
 */
class Mastersektorqtmeth extends AppModel {
public function getDataByNamaOutlet($namaOutlet){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'nama_outlet LIKE' => "%".$namaOutlet."%"
				),
				'fields' => array('Mastersektorqtmeth.*'),
				'order' => 'Mastersektorqtmeth.nama_outlet'
			));
	}
public function getDataByNamaOutletPaginate($namaOutlet,$start,$limit){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'nama_outlet LIKE' => "%".$namaOutlet."%"
				),
				'fields' => array('Mastersektorqtmeth.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Mastersektorqtmeth.nama_outlet'
			));
	}		
public function getData($comId,$outId,$namaKolom,$strCari){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'COMID' =>$comId,
				  	'OUTID' =>$outId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorqtmeth.*'),
				'order' => 'Mastersektorqtmeth.nama_outlet'
			));
	}
public function paginate($comId,$namaKolom,$strCari,$start,$limit){
	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'comid' =>$comId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorqtmeth.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Mastersektorqtmeth.nama_outlet'
			));
	}
}

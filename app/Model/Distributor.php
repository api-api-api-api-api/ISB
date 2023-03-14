<?php
App::uses('AppModel', 'Model');
/**
 * Distributor Model
 *
 */
class Distributor extends AppModel {
public function cekData($namaDistributor){
		return $this->find('all', array(
				'conditions' => array(
					'nama' => $namaDistributor
				),
				'fields' => array('Distributor.*')
			));
	}	
public function getDataDistributor($namaKolom,$strCari){
	
	return $this->find('all', array(
   				  'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Distributor.*'),
				'order' => $namaKolom
			));
	}
public function getDataDepartemenFix($namaKolom,$strCari){
	return $this->find('all', array(
   				  'conditions' => array(
					$namaKolom=> $strCari
				),
				'fields' => array('Departemen.*'),
				'order' => 'namaDepartemen'
			));
	}


}

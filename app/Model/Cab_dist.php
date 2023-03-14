<?php
App::uses('AppModel', 'Model');
/**
 * Cab_dist Model
 *
 */
class Cab_dist extends AppModel {
public function cekData($namaCabang){
		return $this->find('all', array(
				'conditions' => array(
					'nama' => $namaCabang
				),
				'fields' => array('Cabdist.*')
			));
	}	
public function getDataCabang($namaKolom,$strCari){
	return $this->find('all', array(
   				  'conditions' => array(
					$namaKolom => $strCari
				),
				'fields' => array('Cab_dist.*'),
				'order' => 'nama_cabang'
			));
	}





}

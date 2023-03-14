<?php
App::uses('AppModel', 'Model');
/**
 * Hargajualminimum Model
 *
 */
class Hargajualminimum extends AppModel {
public $useTable = 'hargajualminimum';	
public function getDataHargajualminimum($proId){
	return $this->find('all', array( 
   				  'conditions' => array(
					'proid' => $proId
				),
				'fields' => array('*')
			));
	}
}
<?php
App::uses('AppModel', 'Model');
/**
 * Hargajualminimum Model
 *
 */
class Hargajualminimumnew extends AppModel {
public $useTable = 'hargajualminimumnew';	
public function getDataHargajualminimum($proId){
	return $this->find('all', array( 
   				  'conditions' => array(
					'proid' => $proId
				),
				'fields' => array('*')
			));
	}
}
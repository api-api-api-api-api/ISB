<?php
App::uses('AppModel', 'Model');
/**
 * Xmatch_product Model
 *
 */
class Xmatch_product extends AppModel {
 public $useTable = 'xmatch_product';	
 public $useDbConfig = 'newautosales';
public function getMatchingProduct($comId,$disId,$proId){
	return $this->find('all', array(
						'joins' => array(				
						
						
					), 
   				  'conditions' => array(
					'comId' => $comId,
					'disId' => $disId,
					'id' => $proId,
				),
				'fields' => array('Xmatch_product.*')
			));
	}




}

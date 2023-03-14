<?php
App::uses('AppModel', 'Model');
/**
 * Xmatch_dist Model
 *
 */
class Xmatch_dist extends AppModel {
 public $useTable = 'xmatch_dist';	
 public $useDbConfig = 'newautosales';
public function getMatchingDist($comId,$disId,$id_dist){
	return $this->find('all', array(
						'joins' => array(				
						
						
					), 
   				  'conditions' => array(
					'comId' => $comId,
					'disId in ('.$disId.')',
					'id_dist' => $id_dist,
				),
				'fields' => array('Xmatch_dist.*')
			));
	}




}

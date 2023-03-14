<?php
App::uses('AppModel', 'Model');
/**
 * Historyapprovaldpf Model
 *
 */
class Historyapprovaldpfbrngen extends AppModel {
			public function getDataByNomorDPFByStatus($noDPF,$status){
		return $this->find('all', array(
				'conditions' => array(
					'noDPF' => $noDPF
					,'statusApproval' => $status
				),
				'fields' => array('Historyapprovaldpfbrngen.*')
			));
	}
}

<?php
App::uses('AppModel', 'Model');
/**
 * Dpfbrngen Model
 *
 */
class Penawaranfpb extends AppModel {

	function maxIdLenght($bln,$tgl){
		$pref=$bln.$tgl;
		
		$maxRec=$this->find('all', array(
				'conditions' => array(
					'substring(penawaranId,1,'.strlen($pref).')' => $pref
				),
				'fields' => array('max(penawaranId) penawaranId')
			));
		$jmlRec=count($maxRec);
		$maxRecVal=$maxRec[0][0]["penawaranId"];
		$prefId=substr($maxRecVal,0,strlen($pref));
		if(empty($maxRec[0][0]["penawaranId"])){$maxId=$pref."001";}
		else
		if($prefId != $pref){$maxId=$pref."001";}
		else if($prefId == $pref)
		{
			$maxId=substr($maxRecVal,-3);
			$maxId=$maxId+1001;
			$maxId=substr($maxId,1,3);
			$maxId=$pref.$maxId;
			
		}
	  	return $maxId;
	}

}
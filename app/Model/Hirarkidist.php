<?php
App::uses('AppModel', 'Model');
/**
 * Mastersektorbrngen Model
 *
 */
class Hirarkidist extends AppModel {

public function getData($kodeDist,$namaUser){
	return $this->query("SELECT * FROM  hirarkidists a INNER JOIN matc_users b
ON a.`sm`=b.`pejabat_id`
WHERE b.`kode_dist`='".$kodeDist."'
AND b.`nama_user`='".$namaUser."'");
	/*return $this->find('all', array(
						
   				  'conditions' => array(
				  	'COMID' =>$comId,
				  	'OUTID' =>$outId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorbrngen.*'),
				'order' => 'Mastersektorbrngen.nama_outlet'
			));*/
	}
	public function paginate($kodeDist,$namaUser,$start,$limit){
		return $this->query("SELECT * FROM  hirarkidists a INNER JOIN matc_users b
ON a.`sm`=b.`pejabat_id`
WHERE b.`kode_dist`='".$kodeDist."'
AND b.`nama_user`='".$namaUser."' limit $start,$limit");
	/*	return $this->find('all', array(
						
   				  'conditions' => array(
				  	'comid' =>$comId,
				  	$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Mastersektorbrngen.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Mastersektorbrngen.nama_outlet'
			));*/
	}
}

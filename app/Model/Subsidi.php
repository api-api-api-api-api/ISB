<?php
App::uses('AppModel', 'Model');
/**
 * Dpfbrngen Model
 *
 */
class Subsidi extends AppModel {
public function cekData($namaTP,$periode,$comId,$outId,$proId){
		return $this->find('all', array(
				'conditions' => array(
					'namaTP' => $namaTP,
					'periode' => $periode,
					'comId' => $comId,
					'outletId' => $outletId,
					'produkId' => $proId,
				),
				'fields' => array('Dpfbrngen.*')
			));
	}
public function cekData2($periode,$comId,$outletId,$proId,$keterangan){
		return $this->find('all', array(
				'conditions' => array(
					'periode' => $periode,
					'comId' => $comId,
					'outletId' => $outletId,
					'produkId' => $proId,
					'keterangan' => $keterangan,
				),
				'fields' => array('Dpfbrngen.*')
			));
	}	
public function cekData3($noDPF,$statusDPF){
		return $this->find('all', array(
				'joins' => array(
						array(
							'table' => 'distributors',
							'alias' => 'distributors',
							'type' => 'inner',
							'conditions' => array(
								'distributors.nama= Dpfbrngen.kodeDist',
								)
						),

						array(
							'table' => 'cab_dists',
							'alias' => 'cab_dists',
							'type' => 'inner',
							'conditions' => array(
								'cab_dists.dist_id= distributors.id',
								'cab_dists.nama_cabang= Dpfbrngen.distributor'
								)
						),						
						array(
							'table' => 'matc_prods',
							'alias' => 'm_pro',
							'type' => 'inner',
							'conditions' => array(
								'm_pro.proid= Dpfbrngen.produkId',
								'm_pro.kode_dist= Dpfbrngen.kodeDist'
							)
						),
						
					
						
						array(
							'table' => 'matc_outlets',
							'alias' => 'm_out',
							'type' => 'inner',
							'conditions' => array(
								'm_out.comid= Dpfbrngen.comId',
								'm_out.outid= Dpfbrngen.outletId',
								'm_out.distri= Dpfbrngen.kodeDist'
							)
						),
						
						array(
							'table' => 'cab_dists',
							'alias' => 'cab_out',
							'type' => 'inner',
							'conditions' => array(
								'cab_out.dist_id= distributors.id',
								'cab_out.nama_cabang= m_out.kotaid'
								)
						)
						
						
					),
				'conditions' => array(
					'noDPF' => $noDPF,
					'statusDPF' => $statusDPF
				),
				'fields' => array('Dpfbrngen.*','cab_dists.*','m_pro.*','m_out.*','cab_out.*')
			));
	}			
function maxNoSubsidiGenerator($pref,$thn,$bln){
	$pref=$pref.$thn.$bln;
	$maxRec=$this->find('all', array(
				'conditions' => array(
					'substring(noSubsidi,1,'.strlen($pref).')' => $pref
				),
				'fields' => array('max(noSubsidi) noSubsidi')
			));
		
	$jmlRec=count($maxRec);
	
	if($maxRec==0){$maxId=$prefId."0001";}
	else{
		$maxId=$maxRec[0][0]["noSubsidi"]; 
			$maxId=substr($maxId,strlen($pref),strlen($maxId));
			$maxId=$maxId+10001;
			$maxId=substr($maxId,1,5);
			$maxId=$pref.$maxId;
		}	
  	return $maxId;
}


//Get Data DPF Berdasar Hirarki(Untuk Approval)

public function getDataDPFByStatusByArcoIdByPeriode($status,$arcoId,$tanggalA,$tanggalB){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
				'tanggalApproval>='."'".$tanggalA."'",
				'tanggalApproval<='."'".$tanggalB."'",
				'statusDPF in ('.$status.')',
				'Dpfbrngen.arcoId' => $arcoId
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFByGroupIdByDMId($namaKolom,$strCari,$groupId,$DMId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.DMId'=>$DMId
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}
public function getDataDPFByGroupIdByDMIdPaginate($namaKolom,$strCari,$groupId,$DMId,$start,$limit){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.DMId'=>$DMId
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}			
public function getDataDPFByGroupIdBySMId($namaKolom,$strCari,$groupId,$SMId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.SMId'=>$SMId
				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFByGroupIdBySMIdPaginate($namaKolom,$strCari,$groupId,$SMId,$start,$limit){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.SMId'=>$SMId
				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	

public function getDataDPFByGroupIdByGSMId($namaKolom,$strCari,$groupId,$GSMId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'(`jenjanghirarki`.`groupId` = "'.$groupId.'")'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.GSMId'=>$GSMId				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*','jenjanghirarki.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFByGroupIdByGSMIdPaginate($namaKolom,$strCari,$groupId,$GSMId,$start,$limit){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'(`jenjanghirarki`.`groupId` = "'.$groupId.'")'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.GSMId'=>$GSMId,
				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*','jenjanghirarki.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
		
public function getDataDPFByGroupIdByFinId($namaKolom,$strCari,$groupId,$FINId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'(`jenjanghirarki`.`groupId` = "'.$groupId.'")'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.FINId'=>$FINId,
					
				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*','jenjanghirarki.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFByGroupIdByFinIdPaginate($namaKolom,$strCari,$groupId,$FINId,$start,$limit){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'(`jenjanghirarki`.`groupId` = "'.$groupId.'")'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				'Dpfbrngen.FINId'=>$FINId,
					
				),
				'fields' => array('Dpfbrngen.*','count(produkId) jmlProd','sum(DISTINCT hna+(0.1*hna)) gsv','sum(DISTINCT hargaJadi) hgJd2','out.*','jenjanghirarki.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFTakeoverByGroupId($namaKolom,$strCari,$groupId,$idAtasan,$groupIdBawahan,$idBawahan){
	if($groupId==7){$qryAtasan='Dpfbrngen.GSMId';}
	elseif($groupId==10){$qryAtasan='Dpfbrngen.FinId';}
	if($groupIdBawahan==6){$qryBawahan='Dpfbrngen.SMId';}
	elseif($groupIdBawahan==7){$qryBawahan='Dpfbrngen.GSMId';}
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'`jenjanghirarki`.`groupId`'=>$groupIdBawahan
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hirarkis',
							'alias' => 'hirarki',
							'type' => 'LEFT',
							'conditions' => array(
								'hirarki.nik= Dpfbrngen.smId',
								'hirarki.linknik= Dpfbrngen.finId'
							)
						),
						array(
							'table' => 'hirarkis',
							'alias' => 'hirarki2',
							'type' => 'LEFT',
							'conditions' => array(
								'hirarki2.nik= Dpfbrngen.smId',
								'hirarki2.linknik= Dpfbrngen.finId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				$qryAtasan=>$idAtasan,
				$qryBawahan=>$idBawahan,
				'IF(statusDPF="diajukan",!ISNULL(hirarki.linknik),ISNULL(hirarki.linknik) OR !ISNULL(hirarki.linknik))',
				'IF(statusDPF="disetujuism",!ISNULL(hirarki2.linknik),ISNULL(hirarki2.linknik) OR !ISNULL(hirarki2.linknik))'
					
				),
				'fields' => array('Dpfbrngen.*','out.*','jenjanghirarki.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFTakeoverByGroupIdPaginate($namaKolom,$strCari,$groupId,$idAtasan,$groupIdBawahan,$idBawahan,$start,$limit){
if($groupId==7){$qryAtasan='Dpfbrngen.GSMId';}
	elseif($groupId==10){$qryAtasan='Dpfbrngen.FinId';}
	if($groupIdBawahan==6){$qryBawahan='Dpfbrngen.SMId';}
	elseif($groupIdBawahan==7){$qryBawahan='Dpfbrngen.GSMId';}
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'`jenjanghirarki`.`groupId`'=>$groupIdBawahan
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hirarkis',
							'alias' => 'hirarki',
							'type' => 'LEFT',
							'conditions' => array(
								'hirarki.nik= Dpfbrngen.smId',
								'hirarki.linknik= Dpfbrngen.finId'
							)
						),
						array(
							'table' => 'hirarkis',
							'alias' => 'hirarki2',
							'type' => 'LEFT',
							'conditions' => array(
								'hirarki2.nik= Dpfbrngen.smId',
								'hirarki2.linknik= Dpfbrngen.finId'
							)
						)
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
				$qryAtasan=>$idAtasan,
				$qryBawahan=>$idBawahan,
				'IF(statusDPF="diajukan",!ISNULL(hirarki.linknik),ISNULL(hirarki.linknik) OR !ISNULL(hirarki.linknik))',
				'IF(statusDPF="disetujuism",!ISNULL(hirarki2.linknik),ISNULL(hirarki2.linknik) OR !ISNULL(hirarki2.linknik))'
					
				),
				'fields' => array('Dpfbrngen.*','out.*','jenjanghirarki.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}				
public function getDataDPFByGroupIdByGroupDist($namaKolom,$strCari,$groupId,$MKTId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.comid= Dpfbrngen.comId',
								'out.outid= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
			

//Get Data DPF Setelah Baca Data DPF
public function getDataDPF($namaKolom,$strCari,$groupId){
	
	return $this->find('all', array(
				'joins' => array(
					
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
							)
						),						
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hargajualminimum',
							'alias' => 'hjm',
							'type' => 'LEFT',
							'conditions' => array(
								'hjm.proId= Dpfbrngen.produkId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom => $strCari
				),
				'fields' => array('DISTINCT Dpfbrngen.*','out.*','hjm.*'),
				'order' => 'Dpfbrngen.id'
			));
	}
	public function getDataDPFDetil($namaKolom,$strCari,$groupId){
	
		return $this->find('all', array(
				'joins' => array(
						
						/*array(
								'table' => 'jenjanghirarkigens',
								'alias' => 'jenjanghirarki',
								'type' => 'INNER',
								'conditions' => array(
										'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
								)
						),*/
array(
								'table' => 'matc_prods',
								'alias' => 'mp',
								'type' => 'LEFT',
								'conditions' => array(
										'mp.proid= Dpfbrngen.produkId','mp.kode_dist= Dpfbrngen.kodeDist'
								)
						),
						array(
								'table' => '(Select * from mastersektorbrngens group by COMID,OUTID,subDivisi)',
								'alias' => 'out',
								'type' => 'LEFT',
								'conditions' => array(
										'out.subDivisi=Dpfbrngen.subDivisi',
										'out.COMID= Dpfbrngen.comId',
										'out.OUTID= Dpfbrngen.outletId'
								)
						),
array(
								'table' => 'matc_outlets',
								'alias' => 'mo',
								'type' => 'LEFT',
								'conditions' => array(
										'mo.outid= Dpfbrngen.outletId','mo.comid= Dpfbrngen.comid','mo.distri= Dpfbrngen.kodedist','mo.kotaid= Dpfbrngen.distributor'
								)
						),
						array(
								'table' => 'hargajualminimum',
								'alias' => 'hjm',
								'type' => 'LEFT',
								'conditions' => array(
										'hjm.proId= Dpfbrngen.produkId'
								)
						),
						
				),
				'conditions' => array(
						$namaKolom => $strCari
				),
				'fields' => array('DISTINCT Dpfbrngen.*','out.*','hjm.*','mp.*','mo.*'),
				'order' => 'Dpfbrngen.id'
		));
	}
public function getDataDPFApproval($namaKolom,$strCari,$groupId){
	
	return $this->find('all', array(
				'joins' => array(
					
						array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.groupId'=>$groupId
							)
						),						
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.subDivisi=Dpfbrngen.subDivisi',
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hargajualminimumnew',
							'alias' => 'hjm',
							'type' => 'LEFT',
							'conditions' => array(
								'hjm.proId= Dpfbrngen.produkId'
							)
						),
						
					), 
				'conditions' => array(
				'statusDPF<>"tolak"',
					$namaKolom => $strCari
				),
				'fields' => array('DISTINCT Dpfbrngen.*','out.*','hjm.*','jenjanghirarki.*','if(totalDisc>if(groupId=6,prosenSM,if(groupId=7,prosenGSM,prosenFinance)),"over","tidak") as cekOver'),
				'order' => array('cekOver','Dpfbrngen.namaProduk')
			));
	}

public function paginate($namaKolom,$strCari,$start,$limit){
			return $this->find('all', array(
			'joins' => array(
					
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hargajualminimum',
							'alias' => 'hjm',
							'type' => 'LEFT',
							'conditions' => array(
								'hjm.proId= Dpfbrngen.produkId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom => $strCari
				),
				'fields' => array('Dpfbrngen.*','out.*','hjm.*'),
				'start' => $start,
				'limit' => $limit,
				'order' => 'id'
			));
	}	
//Get Data DPF untuk Laporan
public function getDataDPFByStatus($namaKolom,$strCari,$groupId,$statusDPF){
	
	return $this->find('all', array(
				'joins' => array(
					array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						array(
							'table' => 'hargajualminimum',
							'alias' => 'hjm',
							'type' => 'LEFT',
							'conditions' => array(
								'hjm.proId= Dpfbrngen.produkId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom => $strCari,
					'statusDPF'=>$statusDPF
				),
				'fields' => array('DISTINCT Dpfbrngen.*','out.*','hjm.*','jenjanghirarki.*'),
				'order' => 'Dpfbrngen.id'
			));
	}
public function getDataDPFLaporanArco($bulan,$tahun,$outlet,$arcoId,$groupId){
	
	if(trim($bulan)<>''){
		$bulan=intval($bulan);
		}
	return $this->find('all', array(
				'joins' => array(
					array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'nama_outlet LIKE' => "%".$outlet."%",
					'Dpfbrngen.arcoId' => $arcoId
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFLaporanArcoPaginate($bulan,$tahun,$outlet,$arcoId,$groupId,$start,$limit){
	if(trim($bulan)<>''){
		$bulan=intval($bulan);
		}
	return $this->find('all', array(
				'joins' => array(
					array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'nama_outlet LIKE' => "%".$outlet."%",
					'Dpfbrngen.arcoId' => $arcoId
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}
public function getDataDPFLaporanNonArco($bulan,$tahun,$outlet,$groupId,$userId){
	if(trim($bulan)<>''){
		$bulan=intval($bulan);
		}
	if($groupId==13){$kolomUserId='Dpfbrngen.dmId';}
	if($groupId==6){$kolomUserId='Dpfbrngen.smId';}
	if($groupId==7){$kolomUserId='Dpfbrngen.gsmId';}
	if($groupId==10){$kolomUserId='Dpfbrngen.finId';}	
	return $this->find('all', array(
				'joins' => array(
					/*array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
							)
						),*/
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
							
										'out.subDivisi=Dpfbrngen.subDivisi',
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'nama_outlet LIKE' => "%".$outlet."%",
					$kolomUserId => $userId
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFLaporanNonArcoPaginate($bulan,$tahun,$outlet,$groupId,$userId,$start,$limit){
	if(trim($bulan)<>''){
		$bulan=intval($bulan);
		}
	if($groupId==13){$kolomUserId='Dpfbrngen.dmId';}
	if($groupId==6){$kolomUserId='Dpfbrngen.smId';}
	if($groupId==7){$kolomUserId='Dpfbrngen.gsmId';}
	if($groupId==10){$kolomUserId='Dpfbrngen.finId';}		
	return $this->find('all', array(
				'joins' => array(
					/*array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
							)
						),*/
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
										'out.subDivisi=Dpfbrngen.subDivisi',
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'nama_outlet LIKE' => "%".$outlet."%",
					$kolomUserId => $userId
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	

public function getDataDPFLaporanCreatePDF($tahun){
	/*if(trim($bulan)<>''){
		$bulan=intval($bulan);
		}*/
	return $this->find('all', array(
				'joins' => array(
					array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF'
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'Dpfbrngen.statusDPF="finish"',
					'(pdfCreated<>TRUE OR ISNULL(pdfCreated))'
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}		
public function getDataDPFLaporanSM($bulan,$tahun,$SMId,$groupId){
	return $this->find('all', array(
				'joins' => array(	
				array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),					
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'Dpfbrngen.SMId'=>$SMId
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
public function getDataDPFLaporanGSM($bulan,$tahun,$GSMId,$groupId){
	return $this->find('all', array(
				'joins' => array(						
				array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'Dpfbrngen.GSMId'=>$GSMId
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	

public function getDataDPFLaporanFIN($bulan,$tahun,$FINId,$groupId){
	return $this->find('all', array(
				'joins' => array(
				array(
							'table' => 'jenjanghirarkigens',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.statusInHandle=Dpfbrngen.statusDPF',
								'jenjanghirarki.groupId'=>$groupId
							)
						),
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",-1) LIKE' => "%".$tahun."%",
					'SUBSTRING_INDEX(Dpfbrngen.periode, "-",1) LIKE' => "%".$bulan,
					'Dpfbrngen.FINId'=>$FINId
					
				),
				'fields' => array('Dpfbrngen.*','group_concat(statusDPF  ORDER BY statusDPF asc) status','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.noDPF')
			));
	}	
	
//Get Data Outlet untuk Laporan
public function getDataOutletLaporanArco($namaKolom,$strCari,$periode,$noDPF,$comId,$outletId,$arcoId){
	return $this->find('all', array(
				'joins' => array(					
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
					'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
					'Dpfbrngen.periode LIKE' => "%".$periode."%",
					'Dpfbrngen.noDPF LIKE' => "%".$noDPF."%",
					'Dpfbrngen.comId LIKE' => "%".$comId."%",
					'Dpfbrngen.outletId LIKE' => "%".$outletId."%",
					'Dpfbrngen.arcoId' => $arcoId
					
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.comId','Dpfbrngen.outletId')
			));
	}	
public function getDataOutletLaporanSM($namaKolom,$strCari,$periode,$noDPF,$comId,$outletId,$SMId){
	return $this->find('all', array(
				'joins' => array(
						
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
					'Dpfbrngen.periode LIKE' => "%".$periode."%",
					'Dpfbrngen.noDPF LIKE' => "%".$noDPF."%",
					'Dpfbrngen.comId LIKE' => "%".$comId."%",
					'Dpfbrngen.outletId LIKE' => "%".$outletId."%",
					'Dpfbrngen.SMId'=>$SMId
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.comId','Dpfbrngen.outletId')
			));
	}	
public function getDataOutletLaporanGSMDir($namaKolom,$strCari,$periode,$noDPF,$comId,$outletId){
	return $this->find('all', array(
				'joins' => array(
						array(
							'table' => 'mastersektorbrngens',
							'alias' => 'out',
							'type' => 'LEFT',
							'conditions' => array(
								'out.COMID= Dpfbrngen.comId',
								'out.OUTID= Dpfbrngen.outletId'
							)
						),
						
					), 
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%",
					'Dpfbrngen.periode LIKE' => "%".$periode."%",
					'Dpfbrngen.noDPF LIKE' => "%".$noDPF."%",
					'Dpfbrngen.comId LIKE' => "%".$comId."%",
					'Dpfbrngen.outletId LIKE' => "%".$outletId."%"
				),
				'fields' => array('Dpfbrngen.*','out.*'),
				'order' => array('Dpfbrngen.namaTP','Dpfbrngen.noDPF'),
    			'group' => array('Dpfbrngen.comId','Dpfbrngen.outletId')
			));
	}	
			
public function getColumnValue($row,$kolomIndex){
		 	$srow=$row."|";
			$nilai="";
			for ($i=0;$i<$kolomIndex;$i++){
				$nilai = substr($srow,0,strpos($srow,"|"));
				$srow=substr($srow,strpos($srow,"|") + 1,strlen($srow));
			};
			return $nilai;
		 }
public function saveDataDPF($noNota,$tanggal,$arcoId,$namaTP,$periode,$kodeDist,$distributor,$comId,$outletId,$keterangan,$dmId,$smId,$gsmId,$finId,$buffer,$isAllNew){
		
		$dataSource = $this->getdatasource();

		try{					 
			$dataSource->begin();
			$data=$buffer;
			
			   //loop save
			while (strrpos($data,"^")!=false){
				$iValue= substr($data,0,strpos($data,"^"));
				
				if (substr(strrev($iValue),0,20)<>"|||||||||||||||||||||||"){
					$iValue=$iValue."||||||||||||||||||||||||";
				}
				else{$iValue=$iValue;}
				$data= substr($data, strpos($data,"^")+1,strlen($data));
				$tablename = trim($this->getColumnValue($iValue, 1));
				if(trim($tablename)=="dpf") {
					
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$id=$cValue;}
						if ($i==2){$produkId=$cValue;}	
						if ($i==3){$namaProduk=$cValue;}	
						if ($i==4){$hna=$cValue;}									
						if ($i==5){$hna2=$cValue;}									
						if ($i==6){$unit=$cValue;}									
						if ($i==7){$hargaJadi=$cValue;}									
						if ($i==8){$discPrinsipal=$cValue;}									
						if ($i==9){$discDist=$cValue;}										
						if ($i==10){$offFaktur=$cValue;}										
						if ($i==11){$totalDisc=$cValue;}										
						if ($i==12){$namaFile=$cValue;}										
						if ($i==13){$edit=$cValue;}
						$i++;		
					}
					// simpan addnew
					if($totalDisc==0 or trim($totalDisc)==''){
						continue;
						}
					$singleRecData = array(
							'Dpfbrngen' => array(
								'noDPF' => $noNota,
								'namaTP' => $namaTP,
								'periode' => $periode,
								'kodeDist' => $kodeDist,
								'distributor' => $distributor,
								'comId' => $comId,
								'outletId' => $outletId,
								'produkId' => $produkId,
								'namaProduk' => $namaProduk,
								'hna' => $hna,
								'hna2' => $hna2,
								'unit' => $unit,
								'hargaJadi' => $hargaJadi,
								'discPrinsipalAsli' => $discPrinsipal,
								'discDistAsli' => $discDist,
								'offFakturAsli' => $offFaktur,
								'totalDiscAsli' => $totalDisc,
								'discPrinsipal' => $discPrinsipal,
								'discDist' => $discDist,
								'offFaktur' => $offFaktur,
								'totalDisc' => $totalDisc,
								'keterangan' => $keterangan,
								'dmId' => $dmId,
								'smId' => $smId,
								'gsmId' => $gsmId,
								'finId' => $finId,
								'statusDPF' => 'diajukan',
								'tanggalInput' =>date("Y-m-d"),
								'namaFile' =>$namaFile,
								'userId' =>$arcoId,
								'arcoId' =>$arcoId
								)
						);	
									
					if (substr($id,0,1)=="N"){
						
						$this->create();
						// save the data
						$this->save($singleRecData);
						
					}// end simpan addnew
					// simpan update
					elseif (substr($id,0,1)=="-"){
						//delete history permintaan pum
						$this->delete(substr($id,1,strlen($id)));
					
						}
					elseif(substr($id,0,1)!="N" and (substr($id,0,1)!="-" )){
				
						if($edit=='edit'){
						$this->id=$id;
						$this->save($singleRecData);
						
						}
						}	
					  
				}
			} //end loop save
			echo "Data Berhasil Disimpan";
			$dataSource->commit();
		}
		catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}		   
		
	}
public function saveDataSubsidi($noNota,$tanggal,$userId,$arcoId,$namaTP,$tanggalAwal,$tanggalAkhir,$kodeDist,$distributor,$comId,$outletId,$keterangan,$nomorSP,$nilaiSP,$tipeProgram,$dmId,$smId,$gsmId,$finId,$buffer,$isAllNew,$pejId,$divisi,$subDivisi){
		
		$dataSource = $this->getdatasource();

		try{					 
			$dataSource->begin();
			$data=$buffer;
			
			   //loop save
			while (strrpos($data,"^")!=false){
				$iValue= substr($data,0,strpos($data,"^"));
				
				if (substr(strrev($iValue),0,20)<>"|||||||||||||||||||||||||||"){
					$iValue=$iValue."|||||||||||||||||||||||||||";
				}
				else{$iValue=$iValue;}
				$data= substr($data, strpos($data,"^")+1,strlen($data));
				$tablename = trim($this->getColumnValue($iValue, 1));
				if(trim($tablename)=="insert") {
					
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$produkId=$cValue;}	
						if ($i==2){$namaProduk=$cValue;}	
						if ($i==3){$onFaktur=$cValue;}									
						if ($i==4){$offFaktur=$cValue;}									
						if ($i==5){$onFakturSub=$cValue;}									
						if ($i==6){$offFakturSub=$cValue;}							
						if ($i==7){$edit=$cValue;}
						$i++;		
					}
					// simpan addnew
					//if($totalDisc==0 or trim($totalDisc)==''){
				//		continue;
				//		}
					$singleRecData = array(
							'Subsidi' => array(
								'noSubsidi' => $noNota,
								'tipeProgram' => $tipeProgram,
								'namaTP' => $namaTP,
								'pejId' => $pejId,
								'divisi' => $divisi,
								'subDivisi' => $subDivisi,
								'tanggalAwal' => $tanggalAwal,
								'tanggalAkhir' => $tanggalAkhir,
								'kodeDist' => $kodeDist,
								'distributor' => $distributor,
								'comId' => $comId,
								'outletId' => $outletId,
								'produkId' => $produkId,
								'namaProduk' => $namaProduk,
								'onFaktur' => $onFaktur,
								'offFaktur' => $offFaktur,
								'onFakturSub' => $onFakturSub,
								'offFakturSub' => $offFakturSub,
								'nomorSP' => $nomorSP,
								'nilaiSP' => $nilaiSP,
								'onFakturAsli' => $onFaktur,
								'offFakturAsli' => $offFaktur,
								'onFakturSubAsli' => $onFakturSub,
								'offFakturSubAsli' => $offFakturSub,								
								'onFaktur' => $onFaktur,
								'offFaktur' => $offFaktur,
								'onFakturSub' => $onFakturSub,
								'offFakturSub' => $offFakturSub,
								'keterangan' => $keterangan,
								'dmId' => $pejId,
								'smId' => $smId,
								'gsmId' => $gsmId,
								'finId' => $finId,
								'asdirId' => '9999',
								'statusSubsidi' => 'diajukan',
								'tanggalInput' =>date("Y-m-d"),
								'userId' =>$userId,
								'arcoId' =>$arcoId
								)
						);	
						
						$this->create();
						// save the data
						$this->save($singleRecData);
										
						
					  
				}
			} //end loop save
			echo "Data Berhasil Disimpan";
			$dataSource->commit();
		}
		catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}		   
		
	}	
function isBolehDikirim($nilaiPengajuan,$limitBawah,$limitAtas){
			$return='false';

					if($limitBawah==0 && $limitAtas==0){
											$return='false';
											
					}
					elseif($limitBawah==0 && $limitAtas !=0){
						if ($nilaiPengajuan <= $limitAtas) {
											$return='true';
											
							}							
					}
					elseif($limitBawah!=0 && $limitAtas !=0){
						
						if ( $nilaiPengajuan <= $limitAtas) {
											$return= 'true';
											
							}							
					}
					elseif($limitBawah!=0 && $limitAtas ==0){
						if ($nilaiPengajuan >= $limitBawah ) {
											$return='true';
											
							}							
					}
				
			
		
		return $return;
	}		
public function prosesApproval($userId,$userName,$groupId,$noSubsidi,$statusApproval,$keteranganApproval,$idRejectCols){
		
		$dataSource = $this->getdatasource();
		$jh=ClassRegistry::init('Jenjanghirarkigen');	
		$hjm=ClassRegistry::init('Hargajualminimumnew');	
		$had=ClassRegistry::init('Historyapprovaldpfbrngen');	
		$idRejectColsFix=substr($idRejectCols,0,strlen($idRejectCols)-1);
		if(strlen(trim($idRejectColsFix))==0){$idRejectColsFix='""';}
		$idRejectCols=explode(",",$idRejectCols);	
		$txtc="";
		$jmlReject=count($idRejectCols)-1;
		try{					 
			$dataSource->begin();
			if($statusApproval=='setuju'){
				
				$cjh=$jh->getDataJenjanghirarki('groupId',$groupId);
				
				//$statusApproval='finish';	
				$dataDPF=$this->getDataDPFApproval('noSubsidi',$noSubsidi,$groupId);
					
			//	$isBolehDikirim='true';	
				
				foreach($dataDPF as $dDPF){
				
				$isReject='false';	
				for($d=0;$d<$jmlReject;$d++){
					if($dDPF['Dpfbrngen']['id']==$idRejectCols[$d]){						
						$isReject='true';						
						break;
						}
					}	
				
				if($isReject==='false'){	
									
					
					
					/*$singleRecData = array(
							'Dpfbrngen' => array(
								'statusDPF' => $statusApproval,
								'tanggalApproval' => date("Y-m-d"),
								'keteranganApproval' => $keteranganApproval
								)
						);		
				$this->id=$dDPF['Dpfbrngen']['id'];
				$this->save($singleRecData);	*/
					}
				else{
					$singleRecData = array(
							'Dpfbrngen' => array(
								'statusDPF' => 'tolak',
								'tanggalApproval' => date("Y-m-d"),
								'keteranganApproval' => $keteranganApproval
								)
						);		
				$this->id=$dDPF['Dpfbrngen']['id'];
				$this->save($singleRecData);	}	
			
				
				
				$chjm=$hjm->getDataHargajualminimum($dDPF['Dpfbrngen']['produkId']);	
				if(count($chjm)==0){
					echo "Harga Jual Minimum untuk produk ".$dDPF['Dpfbrngen']['namaProduk']." belum ada";
					exit();
					}			
				$limitBawah=0;
				$limitAtas=0;
				if($cjh[0]['Jenjanghirarkigen']['groupId']==13){
					$limitBawah=0;
					$limitAtas=$chjm[0]['Hargajualminimumnew']['prosenDM'];
					
					}
				if($cjh[0]['Jenjanghirarkigen']['groupId']==6){
					$limitBawah=$chjm[0]['Hargajualminimumnew']['prosenDM']+1;
					$limitAtas=$chjm[0]['Hargajualminimumnew']['prosenSM'];
					
					}
				if($cjh[0]['Jenjanghirarkigen']['groupId']==7){
					$limitBawah=$chjm[0]['Hargajualminimumnew']['prosenSM']+1;
					$limitAtas=$chjm[0]['Hargajualminimumnew']['prosenGSM'];
					}
				if($cjh[0]['Jenjanghirarkigen']['groupId']==10){
					$limitBawah=$chjm[0]['Hargajualminimumnew']['prosenFinance'];
					$limitAtas=0;
					}
					
					
				
					$statusApproval=$cjh[0]['Jenjanghirarkigen']['nextStatus'];
			/* 	if($this->isBolehDikirim($dDPF['Dpfbrngen']['totalDisc'],$limitBawah,$limitAtas)<>'true' && $isReject<>'true'){						
				$statusApproval=$cjh[0]['Jenjanghirarkigen']['nextStatus'];
				
				
							}} */
							
					$this->updateAll(
									array('statusDPF' => "'".$statusApproval."'",
								'tanggalApproval' => "'".date("Y-m-d")."'",
								'keteranganApproval' => "'".$keteranganApproval."'"),
									// conditions
									array('Dpfbrngen.noSubsidi' => $noSubsidi,
										'Dpfbrngen.id not in ('.$idRejectColsFix.')',
										'Dpfbrngen.statusDPF<>"tolak"')
								); 
				}
			
			elseif($statusApproval=='tolak'){
			$this->updateAll(
									array('statusDPF' => "'".$statusApproval."'",
								'tanggalApproval' => "'".date("Y-m-d")."'",
								'keteranganApproval' => "'".$keteranganApproval."'"),
									// conditions
									array('Dpfbrngen.noSubsidi' => $noSubsidi)
								); 
			}
			echo "Approval berhasil";
			$singleRecDataHistory = array(
							'Historyapprovaldpfbrngen' => array(
								'noSubsidi' => $noSubsidi,
								'idVerificator' => $userId,
								'namaVerificator' => $userName,
								'groupVerificator' => $groupId,
								'tanggalApproval' => date("Y-m-d H:i:s"),
								'statusApproval' => $statusApproval,
								)
						);	
		
			$had->create();
			$had->save($singleRecDataHistory);			
			$dataSource->commit();
		}
		catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}		   
		
	}
public function cekCreateCsv($noSubsidi){
	/*if(trim($bulan)<>''){
	 $bulan=intval($bulan);
	 }*/
	 
	 return $this->find('all', array(
				'conditions' => array(
					'Dpfbrngen.noSubsidi' => $noSubsidi,
					'(Dpfbrngen.statusDPF<>"tolak" AND Dpfbrngen.statusDPF<>"finish")'
				),
				'fields' => array('Dpfbrngen.*')
			));
	
	}		
}

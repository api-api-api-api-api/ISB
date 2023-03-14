<?php
App::uses('AppModel', 'Model');
/**
 * Hirarki Model
 *
 */
class Hirarki extends AppModel {

public function cekData($nik,$nikInHandle){
		return $this->find('all', array(
				'conditions' => array(
					'nik' => $nik,'linknik' => $nikInHandle
				),
				'fields' => array('Hirarki.*')
			));
	}
public function cekHirarki2($nik,$nikInHandle,$status){
	
		return $this->find('all', array(
				'joins' => array(
						array(
							'table' => 'jenjanghirarkis',
							'alias' => 'jenjanghirarki',
							'type' => 'INNER',
							'conditions' => array(
								'jenjanghirarki.jenjangHirarki= Hirarki.jenjangHirarki',
								'jenjanghirarki.group="'.$status.'"'
							)
						)),
				'conditions' => array(
					'nik' => $nik,'linknik' => $nikInHandle
				),
				'fields' => array('Hirarki.*','jenjanghirarki.*')
			));
	}	
public function getDataHirarki($namaKolom,$strCari){
	return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'users',
							'alias' => 'user',
							'type' => 'LEFT',
							'conditions' => array(
								'user.pejabatId= Hirarki.nik'
							)
						),
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.ID = user.groupId'
							)
						),
							array(
							'table' => 'users',
							'alias' => 'user2',
							'type' => 'LEFT',
							'conditions' => array(
								'user2.pejabatId = Hirarki.linknik'
							)
						),
						array(
							'table' => 'groups',
							'alias' => 'group2',
							'type' => 'LEFT',
							'conditions' => array(
								'group2.ID = user2.groupId'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Hirarki.*', 'user.*','group.*', 'user2.*','group2.*'),
				'order' => array('user2.namaUser','Hirarki.id')
			));
	}
public function getDataHirarkiBawahan($atasanId,$perusahaanId,$divisi){
	return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'users',
							'alias' => 'user',
							'type' => 'LEFT',
							'conditions' => array(
								'user.pejabatId= Hirarki.nik'
							)
						),
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.ID = user.groupId'
							)
						),
							array(
							'table' => 'users',
							'alias' => 'user2',
							'type' => 'LEFT',
							'conditions' => array(
								'user2.pejabatId = Hirarki.linknik'
							)
						),
						array(
							'table' => 'groups',
							'alias' => 'group2',
							'type' => 'LEFT',
							'conditions' => array(
								'group2.ID = user2.groupId'
							)
						)
					), 
				
				'conditions' => array(
					'Hirarki.linknik' => $atasanId,
					'user.perusahaanId' => $perusahaanId,
					'IF(`user`.groupId=7,ISNULL(`user`.`divisi`) OR `user`.`divisi`="",`user`.`divisi`="'.$divisi.'") ',
					
				),
				'fields' => array('Hirarki.*', 'user.*','group.*', 'user2.*','group2.*'),
				'order' => array('user2.namaUser','Hirarki.id')
			));
	}	
	public function getDataHirarkiDanaRPD($namaKolom,$strCari,$namaKolom2,$strCari2){
	return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'karyawans',
							'alias' => 'kary',
							'type' => 'LEFT',
							'conditions' => array(
								'kary.nik = Hirarki.nik',
								$namaKolom2.' LIKE' => "%".$strCari2."%"
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab',
							'type' => 'LEFT',
							'conditions' => array(
								'jab.id = kary.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept',
							'type' => 'LEFT',
							'conditions' => array(
								'dept.id = jab.divisiId'
							)
						),
							array(
							'table' => 'karyawans',
							'alias' => 'kary2',
							'type' => 'LEFT',
							'conditions' => array(
								'kary2.nik = Hirarki.linknik'
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab2',
							'type' => 'LEFT',
							'conditions' => array(
								'jab2.id = kary2.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept2',
							'type' => 'LEFT',
							'conditions' => array(
								'dept2.id = jab2.divisiId'
							)
						),
						array(
							'table' => 'kaspersonalrpds',
							'alias' => 'kp',
							'type' => 'INNER',
							'conditions' => array(
								'kp.nik = kary.nik',
								'kp.tr = "M"',
								'kp.saldo>0'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('DISTINCT Hirarki.*', 'kary.*','dept.*', 'jab.*', 'kary2.*','dept2.*', 'jab2.*'),
				'order' => array('kary.namaKaryawan','Hirarki.id')
			));
	}
public function getDataHirarkiDanaPA($namaKolom,$strCari,$namaKolom2,$strCari2){
	return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'karyawans',
							'alias' => 'kary',
							'type' => 'LEFT',
							'conditions' => array(
								'kary.nik = Hirarki.nik',
								$namaKolom2.' LIKE' => "%".$strCari2."%"
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab',
							'type' => 'LEFT',
							'conditions' => array(
								'jab.id = kary.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept',
							'type' => 'LEFT',
							'conditions' => array(
								'dept.id = jab.divisiId'
							)
						),
							array(
							'table' => 'karyawans',
							'alias' => 'kary2',
							'type' => 'LEFT',
							'conditions' => array(
								'kary2.nik = Hirarki.linknik'
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab2',
							'type' => 'LEFT',
							'conditions' => array(
								'jab2.id = kary2.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept2',
							'type' => 'LEFT',
							'conditions' => array(
								'dept2.id = jab2.divisiId'
							)
						),
						array(
							'table' => 'kaspersonals',
							'alias' => 'kp',
							'type' => 'INNER',
							'conditions' => array(
								'kp.nik = kary.nik',
								'kp.tr = "M"',
								'kp.saldo>0'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('DISTINCT Hirarki.*', 'kary.*','dept.*', 'jab.*', 'kary2.*','dept2.*', 'jab2.*'),
				'order' => array('kary.namaKaryawan','Hirarki.id')
			));
	}
public function paginate($namaKolom,$strCari,$start,$limit){
		return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'karyawans',
							'alias' => 'kary',
							'type' => 'LEFT',
							'conditions' => array(
								'kary.nik = Hirarki.nik'
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab',
							'type' => 'LEFT',
							'conditions' => array(
								'jab.id = kary.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept',
							'type' => 'LEFT',
							'conditions' => array(
								'dept.id = jab.divisiId'
							)
						),
							array(
							'table' => 'karyawans',
							'alias' => 'kary2',
							'type' => 'LEFT',
							'conditions' => array(
								'kary2.nik = Hirarki.linknik'
							)
						),
						array(
							'table' => 'jabatans',
							'alias' => 'jab2',
							'type' => 'LEFT',
							'conditions' => array(
								'jab2.id = kary2.jabatanId'
							)
						),
						array(
							'table' => 'divisis',
							'alias' => 'dept2',
							'type' => 'LEFT',
							'conditions' => array(
								'dept2.id = jab2.divisiId'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Hirarki.*', 'kary.*','dept.*', 'jab.*', 'kary2.*','dept2.*', 'jab2.*'),
				'page' => $start,'limit' => $limit,
				'order' => array('kary.namaKaryawan','Hirarki.id')
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
public function saveDataHirarki($buffer){
		
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
				if(trim($tablename)=="hirarki") {
					
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$id=$cValue;}	
						if ($i==2){$nik=$cValue;}	
						if ($i==3){$linkNik=$cValue;}									
						if ($i==4){$namaVerificator=$cValue;}								
						if ($i==5){$jenjangHirarki=trim($cValue);}								
						if ($i==6){$limitBawah=$cValue;}								
						if ($i==7){$limitAtas=$cValue;}										
						if ($i==8){$edit=$cValue;}
						$i++;		
					}
					
					// simpan addnew
					$singleRecData = array(
							'Hirarki' => array(
								'nik' => $nik,
								'linknik' => $linkNik,
								'jenjangHirarki' => $jenjangHirarki,
								'limitBawah' => $limitBawah,
								'limitAtas' => $limitAtas,
								'keterangan' => ''
								)
						);	
										
					if (substr($id,0,1)=="N"){
						//cek data apakah sudah ada
						/*$cek=$this->cekData($namaKaryawan[0],$namaKaryawanDihandle[0]);
						if(count($cek)>0){
							echo "Data yang anda input sudah ada";
							exit();
							}*/
						$this->create();
						// save the data
						$this->save($singleRecData);
						}// end simpan addnew
					// simpan update
					elseif (substr($id,0,1)=="-"){
						$this->delete(substr($id,1,strlen($id)));
						}
					elseif(substr($id,0,1)!="N" and (substr($id,0,1)!="-" and $edit=='edit')){
						/*$cek=$this->cekData($namaKaryawan[0],$namaKaryawanDihandle[0]);
						if(count($cek)>0 && $cek[0]["Workinhandle"]["id"]<>$id){
							echo "Data yang anda input sudah ada";
							exit();
							}*/
						$this->id=$id;
						$this->save($singleRecData);
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








}

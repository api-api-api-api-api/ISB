<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

public function cekData($namaUser){
		return $this->find('all', array(
				'conditions' => array(
					'namaUser' => $namaUser
				),
				'fields' => array('User.*')
			));
	}	
function login($namaUser,$pass){
		//var_dump("test");exit();
		return $this->find('all', array(
   					'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.ID= User.groupId'
							)
						),
							array(
							//'table' => 'divisis',
							'table' => 'divisis1',
							'alias' => 'div',
							'type' => 'LEFT',
							'conditions' => array(
								'div.nama_divisi= User.divisi'
							)
						),
						
					),
				
				'conditions' => array(
					'namaUser' => $namaUser,
					'pword' => $pass
				),
				'fields' => array('*')
			));
		}

public function getDataUserById($namaKolom,$strCari){
	
		return $this->find('all', array(
   				 
				
				'conditions' => array("id='".$strCari."'"),
				'fields' => array('User.*'),
				'order' => 'groupId,namaUser'
			));
		}
public function getDataUser($namaKolom,$strCari){
	
		return $this->find('all', array(
   				 
				
				'conditions' => array($namaKolom.' LIKE' => "%".$strCari."%"),
				'fields' => array('User.*'),
				'order' => 'groupId,namaUser'
			));
		}		
public function getDataUserByGroupId($namaKolom,$strCari,$groupId){
	
		return $this->find('all', array(
   				 'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.ID= User.groupId'
							)
						),
						
						
					),
				
				'conditions' => array($namaKolom.' LIKE' => "%".$strCari."%",
				'groupId in ('.$groupId.')'
				),
				'fields' => array('User.*','group.*'),
				'order' => 'groupId,namaUser'
			));
		}
public function paginate($namaKolom,$strCari,$start,$limit){
	return $this->find('all', array(
   				 
				
				'conditions' => array($namaKolom.' LIKE' => "%".$strCari."%"),
				'fields' => array('User.*','perush.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'namaUser'
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
public function saveDataUser($buffer){
		
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
				if(trim($tablename)=="user") {
					
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$id=$cValue;}
						if ($i==2){$namaUser=$cValue;}	
						if ($i==3){$pword=$cValue;}	
						if ($i==4){$group=$cValue;}
						if ($i==5){$statusLog=$cValue;}
						if ($i==6){$idUser=$cValue;}		
						if ($i==7){$edit=$cValue;}
						$i++;		
					}
					
					// simpan addnew
					$group=explode("#",$group);
					$singleRecData = array(
							'User' => array(
								'namaUser' => $nik,
								'pword' => $namaKaryawan,
								'groupId' => $group[0],
								
								'idUser' => $idUser
								)
						);					
					if (substr($id,0,1)=="N"){
						//cek data apakah sudah ada
						$cek=$this->cekData($namaUser);
						if(count($cek)>0){
							echo "Data yang anda input sudah ada";
							exit();
							}
						$this->create();
						// save the data
						$this->save($singleRecData);
						}// end simpan addnew
					// simpan update
					elseif (substr($id,0,1)=="-"){
						$this->delete(substr($id,1,strlen($id)));
						}
					elseif(substr($id,0,1)!="N" and (substr($id,0,1)!="-" and $edit=='edit')){
						$cek=$this->cekData($namaUser);
						if(count($cek)>0 && $cek[0]["User"]["id"]<>$id){
							echo "Data yang anda input sudah ada";
							exit();
							}
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
public function gantiPassword($userId,$passwordBaru){
	$dataSource = $this->getdatasource();
		
		try{			$singleRecData = array(
							'User' => array(								
								'pword' => $passwordBaru
								)
						);	
						$this->id=$userId;
						$this->save($singleRecData);	
						echo "Password berhasil diganti";		
			
			}
		catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}		
}

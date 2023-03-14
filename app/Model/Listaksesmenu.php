<?php
App::uses('AppModel', 'Model');
/**
 * Listaksesmenu Model
 *
 */
class Listaksesmenu extends AppModel {
	
public function cekData($groupId,$menuId){
		return $this->find('all', array(
				'conditions' => array(
					'groupId' => $groupId,'menuId' => $menuId
				),
				'fields' => array('Listaksesmenu.*')
			));
	}
public function getDataListaksesmenu($namaKolom,$strCari){
	return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.id = Listaksesmenu.groupId'
							)
						),
						array(
							'table' => 'listmenus',
							'alias' => 'listmenu',
							'type' => 'LEFT',
							'conditions' => array(
								'listmenu.id = Listaksesmenu.menuId'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Listaksesmenu.*', 'listmenu.*', 'group.*'),
				'order' => 'listmenu.namaMenu'
			));
	}

public function paginate($namaKolom,$strCari,$start,$limit){
		return $this->find('all', array(
					'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'LEFT',
							'conditions' => array(
								'group.id = Listaksesmenu.groupId'
							)
						),
						array(
							'table' => 'listmenus',
							'alias' => 'listmenu',
							'type' => 'LEFT',
							'conditions' => array(
								'listmenu.id = Listaksesmenu.menuId'
							)
						)
					), 
				
				'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Listaksesmenu.*', 'listmenu.*', 'group.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'listmenu.namaMenu'
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
public function copyAksesMenu($asal,$tujuan){
	
	}		 
public function saveDataListaksesmenu($buffer){
		
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
				if(trim($tablename)=="listaksesmenu") {
					
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$id=$cValue;}	
						if ($i==2){$groupId=$cValue;}									
						if ($i==3){$menuId=$cValue;}									
						if ($i==4){$namaMenu=$cValue;}										
						if ($i==5){$edit=$cValue;}
						$i++;		
					}
					
					// simpan addnew
					
					$singleRecData = array(
							'Listaksesmenu' => array(
								'groupId' => $groupId,
								'menuId' => $menuId
								)
						);	
										
					if (substr($id,0,1)=="N"){
						//cek data apakah sudah ada
						$cek=$this->cekData($groupId,$menuId);
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
						$cek=$this->cekData($groupId,$menuId);
						if(count($cek)>0 && $cek[0]["Listaksesmenu"]["id"]<>$id){
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
}
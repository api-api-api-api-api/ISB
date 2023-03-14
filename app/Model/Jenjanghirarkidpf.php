
<?php
App::uses('AppModel', 'Model');
/**
 * Jenjanghirarkidpf Model
 *
 */
class Jenjanghirarkidpf extends AppModel {
public function cekData($groupId,$statusInHandle){
		return $this->find('all', array(
				'conditions' => array(
					'groupId' => $groupId,'statusInHandle' => $statusInHandle
				),
				'fields' => array('Jenjanghirarkidpf.*')
			));
	}	
public function getDataJenjanghirarki($namaKolom,$strCari){
	return $this->find('all', array(
						'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'INNER',
							'conditions' => array(
								'group.ID= Jenjanghirarkidpf.groupId'
							)
						),
						
						
					), 
   				  'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Jenjanghirarkidpf.*','group.*'),
				'order' => 'Jenjanghirarkidpf.id'
			));
	}
public function getDataJenjanghirarki2($namaKolom,$strCari){
	return $this->find('all', array(
   				  'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('DISTINCT Jenjanghirarkidpf.jenjangHirarki'),
				'order' => 'id'
			));
	}
public function paginate($namaKolom,$strCari,$start,$limit){
	return $this->find('all', array(
   					'joins' => array(
						array(
							'table' => 'groups',
							'alias' => 'group',
							'type' => 'INNER',
							'conditions' => array(
								'group.ID= Jenjanghirarkidpf.groupId'
							)
						)
						
						
					), 
   				  'conditions' => array(
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Jenjanghirarkidpf.*','group.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => 'Jenjanghirarkidpf.id'
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
public function saveDataJenjanghirarki($buffer){
		
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
				if(trim($tablename)=="jenjanghirarki") {
					$i=0;
					while(!strrpos($iValue,"|")===false){
						$lenIValue=(int) strlen($iValue);
						$cValue=substr($iValue,0,strpos($iValue,"|"));
						$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
						if ($i==1){$id=$cValue;}
						if ($i==2){$groupUser=$cValue;}										
						if ($i==3){$statusInHandle=$cValue;}										
						if ($i==4){$nextStatus=$cValue;}										
						if ($i==5){$limitBawah=$cValue;}										
						if ($i==6){$limitAtas=$cValue;}									
						if ($i==7){$edit=$cValue;}
						$i++;		
					}
					$groupUser=explode("#",$groupUser);
					// simpan addnew
					$singleRecData = array(
							'Jenjanghirarkidpf' => array(
								'groupId' => $groupUser[0],
								'statusInHandle' => $statusInHandle,
								'nextStatus' => $nextStatus,
								'limitBawah' => $limitBawah,
								'limitAtas' => $limitAtas
								)
						);					
					if (substr($id,0,1)=="N"){
						//cek data apakah sudah ada
						$cek=$this->cekData($groupUser[0],$statusInHandle);
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
						$cek=$this->cekData($groupUser[0],$statusInHandle);
						if(count($cek)>0 && $cek[0]["Jenjanghirarkidpf"]["id"]<>$id){
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

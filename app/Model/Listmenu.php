<?php
App::uses('AppModel', 'Model');
/**
 * Listmenu Model
 *
 */
class Listmenu extends AppModel {
function getGroupMenuAll(){
	return $this->find('all', array(
					'conditions' => array(
					'level' => 0
				),
				'fields' => array('Listmenu.*'),
				'order' => ' parentId,id'
			));
	}
function getChildrenAll($parent){
	return $this->find('all', array(
					'conditions' => array(
					'parentId' => $parent
				),
				'fields' => array('Listmenu.*'),
				'order' => ' menuOrder'
			));
	}
function getSubAndMenuAll(){
	return $this->find('all', array(
					'conditions' => array(
					'tipeMenu in ' => array('menu','subMenu')
				),
				'fields' => array('Listmenu.*'),
				'order' => ' parentId,id'
			));
	}
	
function getMenu($namaKolom,$strCari){
	return $this->find('all', array(
					'conditions' => array(
					'tipeMenu' => 'menu',
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Listmenu.*'),
				'order' => ' parentId,id'
			));
	}
function getMenu2($namaKolom,$strCari){
	return $this->find('all', array(
					'conditions' => array(
					'tipeMenu in ("subMenu","menu")',
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Listmenu.*'),
				'order' => 'tipeMenu DESC,namaMenu'
			));
	}
function getMenuPaginate($namaKolom,$strCari,$start,$limit){
		return $this->find('all', array(
					'conditions' => array(
					'tipeMenu' => 'menu',
					$namaKolom.' LIKE' => "%".$strCari."%"
				),
				'fields' => array('Listmenu.*'),
				'page' => $start,
				'limit' => $limit,
				'order' => ' parentId,id'
			));
	
	}						
function getGroupMenu($userId){
	return $this->query("select * from listmenus where id in(select distinct parentId from users a 
			inner join listaksesmenus b on a.groupId=b.groupId 
			inner join listmenus c on b.menuId=c.id
			where a.id='".$userId."') and level=0 order by menuOrder");
		
	}
function getChildren($parent,$userId,$perusahaanId,$divisi){			
$kueri="SELECT * FROM listmenus WHERE parentId='$parent'and if(tipeMenu='menu', id in
			(select distinct menuId from users a inner join listaksesmenus b on a.groupId=b.groupId where a.id='".$userId."'),id in (SELECT DISTINCT parentId FROM users a INNER JOIN listaksesmenus b 
ON a.groupId=b.groupId INNER JOIN listmenus c ON b.menuId=c.id where a.id='".$userId."')) ";
	if(strlen(trim($perusahaanId))>0 && strlen(trim($divisi))==0){
		$kueri.=" and if(tipeMenu='menu',if(isnull(perusahaanId),isnull(perusahaanId),perusahaanId='$perusahaanId'),perusahaanId='$perusahaanId' or isnull(perusahaanId)) ";
		}			
	if(strlen(trim($perusahaanId))==0 && strlen(trim($divisi))>0){
		$kueri.=" and if(tipeMenu='menu',if(isnull(divisi),isnull(divisi),divisi='$divisi'),isnull(divisi)) ";
		}	
		
	if(strlen(trim($perusahaanId))>0 && strlen(trim($divisi))>0){
		$kueri.=" and if(tipeMenu='menu',if(isnull(perusahaanId),isnull(perusahaanId),perusahaanId='$perusahaanId'),perusahaanId='$perusahaanId' or isnull(perusahaanId)) and if(tipeMenu='menu',if(isnull(divisi),isnull(divisi),divisi='$divisi'),isnull(divisi))";
		}					
		$kueri.=" order by menuOrder";
		
	return $this->query($kueri);
		}
		
}

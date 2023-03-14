<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
 	
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	
	public function getSetting(){
		$this->autoRender = false;
		$this->loadModel('Setting');
		$rsSetting=$this->Setting->query("Select * from settings");
		echo $rsSetting[0]["settings"]["headerText"]."!".$this->webroot."img/".$rsSetting[0]["settings"]["logo"];
		
	}	
	public function cekDokter(){
				$this->autoRender = false;
		header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
		$jenis=$_GET['jenis'];
		$dokterId=$_GET['dokterId'];
		$dokterId=rtrim($dokterId,",");
		$dokterIdPecah=explode(",",$dokterId);
		
			$dokterId="";
foreach($dokterIdPecah as $dp){
	if(trim($dp)!=''){
	$dokterId.="'".$dp."',";}
	}
	$dokterId=substr($dokterId,0,strlen($dokterId)-1);
		$dokterId=rtrim($dokterId,",");
		$dokterIdPecah2=explode(",",$dokterId);
			$jml=count($dokterIdPecah2);
		$this->autoRender = false;
		$this->loadModel('Bernofarmpengirimandana');
			$rsCek1=$this->Bernofarmpengirimandana->query("SELECT DISTINCT bernofarmdokter.id FROM  bernodb.bernofarmdokter WHERE  bernodb.bernofarmdokter.id IN ($dokterId)");
		
	//echo "SELECT * FROM matc_outlets WHERE CONCAT(comid,outid) IN ($outlet)";exit();
		if(count($rsCek1)<$jml){echo "Ada yg bukan id dokter";}
		else{
		
			$rsCek=$this->Bernofarmpengirimandana->query("SELECT distinct bernofarmdokter.id FROM bernodb.bernofarmdokter 
INNER JOIN bernodb.specdokterkpdm ON bernodb.bernofarmdokter.`spec`=bernodb.specdokterkpdm.`spec`
WHERE bernodb.bernofarmdokter.id IN ($dokterId)");
		if($jenis=='KPDM'){
			if(count($rsCek)<$jml){echo "Tidak sesuai";}
			else{echo "Sesuai";}
			}
		else{
			if(count($rsCek)==0){echo "Sesuai";}
			else{echo "Tidak sesuai";}
			}
		}
		}
		public function cekOutlet(){
					$this->autoRender = false;
		header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
		$outlet=$_GET['outlet'];
		
		if(substr(trim($outlet), -1, 1)==","){
		$outlet=substr(trim($outlet),0,strlen(trim($outlet))-1);}
	$outletPecah=explode(",",$outlet);
	$jml=count($outletPecah);
	$outlet="";
foreach($outletPecah as $op){
	$outlet.="'".$op."',";
	}
	$outlet=substr($outlet,0,strlen($outlet)-1);

		$this->autoRender = false;
		$this->loadModel('User');
	
			$outletTidakAda='';
			$rsCek=$this->User->query("SELECT DISTINCT comid,outid FROM mastersektors mastersektorbrneths WHERE CONCAT(comid,outid) IN ($outlet)");
			$outletPecah=explode(",",$outlet);
			for($k=0;$k<count($outletPecah);$k++){
				$ada='';
				foreach($rsCek as $dataCek){
					
					if($outletPecah[$k]=="'".$dataCek['mastersektorbrneths']['comid'].$dataCek['mastersektorbrneths']['outid']."'"){
						$ada='ada';
						break;
						}
						else{
						
						}
					}
					if($ada==''){
						$outletTidakAda.=$outletPecah[$k].",";
						}
				}
				$outletTidakAda=substr($outletTidakAda,0,strlen($outletTidakAda)-1);
			
	//echo "SELECT * FROM matc_outlets WHERE CONCAT(comid,outid) IN ($outlet)";exit();
			if(count($rsCek)<$jml){echo "Tidak sesuai";}
			else{echo "Sesuai";}
		
		
		}	
public function getNamaOutlet(){
			$this->autoRender = false;
		header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
		$comId=$_GET['comId'];$outId=$_GET['outId'];
			$this->autoRender = false;
		$this->loadModel('User');
			$outletTidakAda='';
			$rsCek=$this->User->query("SELECT distinct outlet,alamat FROM mastersektors mastersektorbrneths WHERE comId='".$comId."' and outId='".$outId."'");
			$outletPecah=explode(",",$outlet);
			
				if(count($rsCek)>0){
						echo "Sesuai~!~".$rsCek[0]['mastersektorbrneths']['outlet'].' '.$rsCek[0]['mastersektorbrneths']['alamat']."~!~".$rsCek[0]['mastersektorbrneths']['outlet'];
						
						}
						else{
						echo "Tidak sesuai~!~";
						}
					exit();
		if(substr(trim($outlet), -1, 1)==","){
		$outlet=substr(trim($outlet),0,strlen(trim($outlet))-1);}
	$outletPecah=explode(",",$outlet);
	$jml=count($outletPecah);
	$outlet="";
	var_dump($outletPecah);exit();
foreach($outletPecah as $op){
	$outlet.="'".$op."',";
	}
	$outlet=substr($outlet,0,strlen($outlet)-1);

		$this->autoRender = false;
		$this->loadModel('User');
			$outletTidakAda='';
			$rsCek=$this->User->query("SELECT distinct nama_outlet,alamat FROM mastersektors mastersektorbrneths WHERE CONCAT(comid,outid) IN ($outlet)");
			$outletPecah=explode(",",$outlet);
			for($k=0;$k<count($outletPecah);$k++){
				$ada='';
				foreach($rsCek as $dataCek){
					
					if($outletPecah[$k]=="'".$dataCek['mastersektorbrneths']['comid'].$dataCek['mastersektorbrneths']['outid']."'"){
						echo "Sesuai~!~".$dataCek['mastersektorbrneths']['nama_outlet'].$dataCek['mastersektorbrneths']['alamat'];
						break;
						}
						else{
						echo "Tidak sesuai~!~";
						}
					}
					if($ada==''){
						$outletTidakAda.=$outletPecah[$k].",";
						}
				}
				$outletTidakAda=substr($outletTidakAda,0,strlen($outletTidakAda)-1);
			
	//echo "SELECT * FROM matc_outlets WHERE CONCAT(comid,outid) IN ($outlet)";exit();
			if(count($rsCek)<$jml){echo "Tidak sesuai~!~";}
			else{echo "Sesuai~!~".$dataCek['mastersektorbrneths']['nama_outlet']." ".$dataCek['mastersektorbrneths']['alamat']."~!~".$dataCek['mastersektorbrneths']['nama_outlet'];}
		
		
		}		
	public function getProdDivisi(){
		header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
		$this->autoRender = false;
		$uname=$_GET['uname'];
		$pword=$_GET['pword'];
		$this->loadModel('User');
		//cek user
		$rsCek=$this->User->query("Select * from users where namaUser='$uname' and pword='$pword'");
		if(count($rsCek)>0){
			if($uname=='isbapi'){
				$rsProd=$this->User->query("select * From (select `id`,
  `proid`,
  `nama_produk`,
  0 `hna`,
  '' `corp`,
  `divid`,
  replace(replace(divisi,'MKT1A','MKT1'),'MKT1B','MKT1') divisi,
  
  replace(replace(subdiv,'MKT1A','MKT1'),'MKT1B','MKT1') subdiv,
  '' `jns_prod`,
  '' `jns_ktgr`,
  '' `ktgr_prod`,
  '' `status`,
  '' `nie`,
  '' `edNie`,
  '' `dot`,
  '' `suhu`,
  '' `kode_pricipal`,
  '' `satuan_jual`,
  '0' `carton`,
  '' `pack_box`,
  '0' `dmb_p`,
  '0' `dmb_l`,
  '0' `dmb_t`,
  '0' `dmb_b`,
  '0' `mb_p`,
  '0' `mb_l`,
  '0' `mb_t`,
  '0'  `mb_b`,
 `satuan`,
   `hnasatuan`  from prod_divisis where divisi in ('MKT1','MKT3')) prod_divisis");
				echo json_encode($rsProd);		
				}
			}
		else{$return=array("returnVal"=>"gagal login");
			echo json_encode($return);}	
		
		
	}	
	public function logProcess(){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			  // ajax request
			} else {
			  die('anda tidak boleh disini!');
			}
		$this->loadModel('User');
		$this->autoRender = false;
		
		$namaUser=$_POST['namaUser'];
		$pass=$_POST['pass'];
	
		$dataUser=$this->User->login($namaUser,$pass);

		$arcoId='';
		$arcoIdBudget='';
		if(count($dataUser)>0){	
		if($dataUser[0]['User']['groupId']==2){
			$arcoId=$dataUser[0]['User']['ID'];
			$arcoIdBudget=$dataUser[0]['User']['arcoId'];
			}
		else{
		
			$rsArco=$this->User->query("select * from users where groupId=2 and comId='".$dataUser[0]['User']['comId']."'");
			if(count($rsArco)){
			$arcoId=$rsArco[0]['users']['ID'];
			$arcoIdBudget=$dataUser[0]['User']['arcoId'];
				}
			}		
			$this->Session->write('dpfdpl_userId',$dataUser[0]['User']['ID']);
			$this->Session->write('dpfdpl_namaUser',$dataUser[0]['User']['namaUser']);
			$this->Session->write('dpfdpl_penanggungJawab',$dataUser[0]['User']['penanggungJawab']);
			$this->Session->write('dpfdpl_groupId',$dataUser[0]['User']['groupId']);
			$this->Session->write('dpfdpl_group',$dataUser[0]['group']['namaGroup']);
			$this->Session->write('dpfdpl_pejabatId',$dataUser[0]['User']['pejabatId']);
			$this->Session->write('dpfdpl_perusahaanId',$dataUser[0]['User']['perusahaanId']);
			$this->Session->write('dpfdpl_divisiId',$dataUser[0]['div']['id']);	
			$this->Session->write('dpfdpl_groupDivisi',$dataUser[0]['div']['groupDivisi']);	
			$this->Session->write('dpfdpl_divisi',$dataUser[0]['User']['divisi']);	
			$this->Session->write('dpfdpl_subDivisi',$dataUser[0]['User']['subDivisi']);	
			$this->Session->write('dpfdpl_reguler',$dataUser[0]['User']['reg']);	
			$this->Session->write('dpfdpl_comId',$dataUser[0]['User']['comId']);	
			$this->Session->write('dpfdpl_inisial',$dataUser[0]['User']['inisial']);	
			$this->Session->write('dpfdpl_namaKaryawan',$dataUser[0]['User']['namaKaryawan']);	
			$this->Session->write('dpfdpl_tanggalLahir',$dataUser[0]['User']['tanggalLahir']);	
			$this->Session->write('dpfdpl_extAppMenu','');	
			$this->Session->write('dpfdpl_arcoId',$arcoId);	
			$this->Session->write('dpfdpl_arcoIdBudget',$arcoIdBudget);	
			
			App::import('Vendor', 'JWT', array('file' => 'JWT.php'));   
			$token = array();
			$token[0] = 'true';
			$token[1] = $dataUser[0]['User']['ID'];
			$token[2] = 'login';
			$token=JWT::encode($token,'rahasiabro');
			/*	$token=JWT::decode($token,'rahasiabro');*/
			$this->Session->write('dpfdpl_logistikState',0);
			$this->Session->write('dpfdpl_logistikToken',$token);
						
			}
			
		else{
			echo "gagal";
			}
		}
	public function openPage($userId,$namaUser,$groupId,$group,$pejabatId,$url,$extAppMenu){
		$this->autoRender = false;
		
			$this->Session->write('dpfdpl_userId',$userId);
			$this->Session->write('dpfdpl_namaUser',$namaUser);
			$this->Session->write('dpfdpl_penanggungJawab',$dataUser[0]['User']['penanggungJawab']);
			$this->Session->write('dpfdpl_groupId',$groupId);
			$this->Session->write('dpfdpl_group',$dataUser[0]['group']['namaGroup']);
			$this->Session->write('dpfdpl_pejabatId',$dataUser[0]['User']['pejabatId']);
			$this->Session->write('dpfdpl_perusahaanId',$dataUser[0]['User']['perusahaanId']);		
			$this->Session->write('dpfdpl_divisiId',$dataUser[0]['div']['id']);	
			$this->Session->write('dpfdpl_groupDivisi',$dataUser[0]['div']['groupDivisi']);	
			$this->Session->write('dpfdpl_divisi',$dataUser[0]['User']['divisi']);	
			$this->Session->write('dpfdpl_subDivisi',$dataUser[0]['User']['subDivisi']);	
			$this->Session->write('dpfdpl_reguler',$dataUser[0]['User']['reg']);	
			$this->Session->write('dpfdpl_comId',$dataUser[0]['User']['comId']);	
			$this->Session->write('dpfdpl_inisial',$dataUser[0]['User']['inisial']);	
			$this->Session->write('dpfdpl_arcoId',$arcoId);	
			$this->Session->write('dpfdpl_extAppMenu','1234');	
			header('location:http://localhost/ISBerno/'.$url);
		}	
	public function logout(){
		$this->autoRender = false;
		$this->Session->delete('dpfdpl_userId');
			$this->Session->delete('dpfdpl_namaUser');
			$this->Session->delete('dpfdpl_penanggungJawab');
			$this->Session->delete('dpfdpl_groupId');
			$this->Session->delete('dpfdpl_group');
			$this->Session->delete('dpfdpl_pejabatId');
			$this->Session->delete('dpfdpl_perusahaanId');
			$this->Session->delete('dpfdpl_divisiId');	
			$this->Session->delete('dpfdpl_groupDivisi');	
			$this->Session->delete('dpfdpl_divisi');	
			$this->Session->delete('dpfdpl_subDivisi');	
			$this->Session->delete('dpfdpl_comId');	
			$this->Session->delete('dpfdpl_inisial');	
			$this->Session->delete('dpfdpl_reguler');
			$this->Session->delete('dpfdpl_arcoId');	
			$this->Session->delete('dpfdpl_logistikState');
			$this->Session->delete('dpfdpl_extAppMenu');
		header('location:../ISB');exit();
		}
	
}

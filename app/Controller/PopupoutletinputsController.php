<?php
App::uses('AppController', 'Controller');
/**
 * Popupoutlets Controller
 *
 */
class PopupoutletinputsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	
	echo $this->Function->cekSession($this);
	}
public function cekOutletDist(){
	$this->autoRender = false;
	$kodeDists=$_POST['kodeDists'];
	$cabangDists=$_POST['cabangDists'];
	$kodeOutlet=$_POST['kodeOutlet'];
	$kodeDists=explode("-!-",$kodeDists);
	$cabangDists=explode("-!-",$cabangDists);
	$kodeOutlet=explode("_",$kodeOutlet);
	
	$this->loadModel('Mastersektorbrngen');
	$jml=count($kodeDists);
	$matchOutlet='belumMatch';
	
	for($n=0;$n<$jml;$n++){
		
		if(trim($kodeDists[$n])<>'' && trim($cabangDists[$n])<>''){
		$kodeDist=explode("#",$kodeDists[$n]);
		$cabangDist=explode("#",$cabangDists[$n]);
		
		$kodeDist=$kodeDist[1];
		$cabangDist=$cabangDist[3];
		if(trim($kodeDist)<>'' && trim($cabangDist)<>''){
			$cekOutlet=$this->Mastersektorbrngen->query("select * from matc_outlets where distri='$kodeDist' and COMID='$kodeOutlet[0]' and OUTID='$kodeOutlet[1]'");
			
			if(count($cekOutlet)>0){
				$matchOutlet='sudahMatch';
				}
			else{$matchOutlet='belumMatch';break;}	
			}
	}
		}
	echo $matchOutlet;
	}	
public function getData(){
	$this->autoRender = false;
	$filterByDM=$_POST['filterByDM'];
	
	$txtOutlet=$_POST['txtOutlet'];
	$hm=$_POST['hal'];
	$limit=20;
	$txtHead="";
	$txtData="";
		$this->loadModel('Mastersektorbrngen');
	/*$order=$_POST['order'];
	if(empty($order)){$order=="nama";}*/
		if(empty($hm)||$hm==1){$start=0; }
		else{ $start=($hm-1)*$limit; }
	
	$groupDivisi=$this->Session->read('dpfdpl_groupDivisi');
	$divisiId=$this->Session->read('dpfdpl_divisiId');
	$subDivisi=$this->Session->read('dpfdpl_subDivisi');
	$masterSektor='';
	if($groupDivisi=='MKT1'){
		$masterSektor='mastersektorbrneths';
		}
	elseif($groupDivisi=='MKT2'){
		$masterSektor='mastersektorbrngens';
		}	
	/*elseif($subDivisi=='MKT4'){
		$masterSektor='mastersektorbrnmkt4s';
		}	
	elseif($subDivisi=='OTC'){
		$masterSektor='mastersektorbrnotcs';
		}	
	elseif($subDivisi=='GTR'){
		$masterSektor='mastersektorbrngtrs';
		}	
		
	elseif($subDivisi=='TEAM A'){
		$masterSektor='mastersektorbrngenas';
		}
	elseif($subDivisi=='TEAM B'){
		$masterSektor='mastersektorbrngenbs';
		}		
	elseif($subDivisi=='GEN'){
		$masterSektor='mastersektorbrngens';
		}	*/
	/*if($divisiId==1){
		$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,smId DM,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  mastersektorbrneths msg
INNER JOIN matc_outlets mc ON msg.comid=mc.comid AND msg.outid=mc.outid   where nama_outlet like '%$txtOutlet%' ORDER BY nama_outlet";
	
		}
	else{	
		$subDivisi=$_POST['subDivisi'];
		
		if($subDivisi=='A'){
			$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,smId DM,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  mastersektorbrngenas msg
INNER JOIN matc_outlets mc ON msg.comid=mc.comid AND msg.outid=mc.outid   where nama_outlet like '%$txtOutlet%' ORDER BY nama_outlet";
			
		}
		if($subDivisi=='B'){
			$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,smId DM,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  mastersektorbrngenbs msg
INNER JOIN matc_outlets mc ON msg.comid=mc.comid AND msg.outid=mc.outid   where nama_outlet like '%$txtOutlet%' ORDER BY nama_outlet";
			
		}
		
	}*/
	/*if($groupDivisi=='MKT1'){$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  $masterSektor msg
INNER JOIN matc_outlets mc ON msg.comid=mc.comid AND msg.outid=mc.outid   where subDivisi='$subDivisi' and nama_outlet like '%$txtOutlet%'  ORDER BY nama_outlet";}
	else{*/
	if($filterByDM=='true'){$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,dmId DM,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  $masterSektor msg where subDivisi='$subDivisi' and nama_outlet like '%$txtOutlet%' and dmId='".$this->Session->read('dpfdpl_pejabatId')."' ORDER BY nama_outlet";}
	else{
		$cOutlet="SELECT nama_outlet,alamat,msg.COMID,msg.OUTID,dmId DM,smId SM,gsmId GSM,finId FIN,SM namaDM,SM namaSM,GSM namaGSM,FIN namaFIN FROM  $masterSektor msg where subDivisi='$subDivisi' and nama_outlet like '%$txtOutlet%'  ORDER BY nama_outlet";
		}
	
	/*}*/

	$resOutlet=$this->Mastersektorbrngen->query($cOutlet);
	
	
	$jumOutlet=count($resOutlet);
	
	
	$sum=ceil($jumOutlet/$limit);
	/* -----------------------------Navigasi Record ala google style ----------------------------- */
	$linkHal=$this->Function->pageNav($hm,$sum,$limit);
	/* -----------------------------End Navigasi Record ala google style ----------------------------- */
	$rsTampil=$this->Mastersektorbrngen->query($cOutlet." limit $start, $limit");

	$n=$start+1;
	foreach($rsTampil as $dataOutlet){
	
		$nama=$dataOutlet['msg']['nama_outlet'];
		$alamat=$dataOutlet['msg']['alamat'];
		$kodeOutlet=$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID'];
		if($groupDivisi=='MKT1'){$DMId=$this->Session->read('dpfdpl_pejabatId');
		}
		else{
		$DMId=$dataOutlet['msg']['DM'];
		}
		$SMId=$dataOutlet['msg']['SM'];
		$GSMId=$dataOutlet['msg']['GSM'];
		$finId=$dataOutlet['msg']['FIN'];
$namaDM=substr($dataOutlet['msg']['namaDM'],0,strpos($dataOutlet['msg']['namaDM'],"#"));
$namaSM=substr($dataOutlet['msg']['namaSM'],0,strpos($dataOutlet['msg']['namaSM'],"#"));
$namaGSM=substr($dataOutlet['msg']['namaGSM'],0,strpos($dataOutlet['msg']['namaGSM'],"#"));
$namaFIN=substr($dataOutlet['msg']['namaFIN'],0,strpos($dataOutlet['msg']['namaFIN'],"#"));
$ketApprover="SM= ".$namaSM.", GSM= ".$namaGSM.", FIN= ".$namaFIN;
		$txtHead="<tr>
			<td align=\"center\">No</td>
			<td align=\"center\" style='display:none'>ID</td>
			<td align=\"center\">Nama Outlet</td>
			<td align=\"center\">Alamat</td>
			<td align=\"center\">Kode Outlet</td>
			<td align=\"center\" style=\"display:none\">DMId</td>
			<td align=\"center\" style=\"display:none\">SMId</td>
			<td align=\"center\" style=\"display:none\">GSMId</td>
			<td align=\"center\" style=\"display:none\">FinId</td>
			<td></td>
			</tr>";
		$txtData.="<tr>
			<td align=\"center\">$n</td>
			<td id='id".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"center\" style=\"display:none\">".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."</td>
			<td id='txtNama".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"left\">$nama</td>
			<td id='txtAlamat".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"left\">$alamat</td>
			<td id='txtKodeOutlet".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"left\">$kodeOutlet</td>
			<td id='txtDMId".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"center\" style=\"display:none\" >$DMId</td>
			<td id='txtSMId".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"center\" style=\"display:none\">$SMId</td>
			<td id='txtGSMId".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"center\" style=\"display:none\">$GSMId</td>
			<td id='txtFinId".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' align=\"center\" style=\"display:none\">$finId</td>
			<td align=\"center\">
<label id='txtApprover".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."' style='display:none'>
$ketApprover
</label>
<a href='#' onClick='addToData(\"".$dataOutlet['msg']['COMID']."_".$dataOutlet['msg']['OUTID']."\")'>pilih</a>&nbsp&nbsp</a></td><br />
			</tr>";
			$n++;
			
	}
	echo $txtHead."!".$txtData."!".$linkHal;
	}			
}

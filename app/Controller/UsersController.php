<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}
public function getDataComboSM(){
		$this->autoRender = false;
		$txtSM="";
		$k=0;
		$hasilSM=$this->User->getDataUser('groupId','6');	
		if(count($hasilSM)>0){
			foreach($hasilSM as $hsl){	
			$txtSM=$txtSM."<option  style='padding-bottom:5px;font-family:\"Courier New\", Courier, monospace' value='".$hsl['User']['ID']."'>".$hsl['User']['namaUser']."</option>";
			$k=$k+1; 
			}
			}
	echo $txtSM;
	}
public function openPage($userId,$namaUser,$groupId,$group,$pejabatId,$url){
		$this->autoRender = false;
			
			$this->Session->write('userId',$userId);
			$this->Session->write('namaUser',$namaUser);
			$this->Session->write('groupId',$groupId);
			$this->Session->write('group',$dataUser[0]['group']['namaGroup']);
			$this->Session->write('pejabatId',$dataUser[0]['User']['pejabatId']);
			header('location:http://'.$_SERVER['SERVER_ADDR'].'/newDPL/'.$url);exit();
		}
public function onLoadHandler(){
	
		
		$display='';
		
	//get divisi
	$rsdivisi=$this->User->query("SELECT * FROM divisis ORDER BY ID");
	$txtDivisi="<option value=''>---Pilih Divisi---</option>";
	foreach($rsdivisi as $jumDivisi){
	$txtDivisi.="<option value='".$jumDivisi['divisis']['nama_divisi']."'>".$jumDivisi['divisis']['nama_divisi']."</option>";	}
	//get Sub Divisi
	$rsgroupdivisi=$this->User->query("SELECT * FROM subDivisis ORDER BY ID");
	$txtSubDivisi="<option value=''>---Pilih Sub Divisi---</option>";
	foreach($rsgroupdivisi as $jumSubDivisi){
	$txtSubDivisi.="<option value='".$jumSubDivisi['subDivisis']['divisi']."-^-".$jumSubDivisi['subDivisis']['subDivisi']."'>".$jumSubDivisi['subDivisis']['subDivisi']."</option>";	}
    
	$this->loadModel('Communication_point');
	//get Cabang		
	$rsCabang=$this->Communication_point->query("SELECT comid,nama_area FROM communication_points order by nama_area");
	$txtCabang="<option value=''>---Pilih Cabang---</option>";
	foreach($rsCabang as $jumCabang){
	
	$txtCabang.="<option value='".$jumCabang['communication_points']['comid']."'>".$jumCabang['communication_points']['nama_area']."</option>";				}
	
	//get groups
	$rsgroups=$this->User->query("SELECT * FROM groups ORDER BY ID");
	$txtGroups="<option value=''>---Pilih Groups---</option>";
	foreach($rsgroups as $jumGroups){
	$txtGroups.="<option value='".$jumGroups['groups']['ID']."'>".$jumGroups['groups']['namaGroup']."</option>";				}
	
	$kueri="SELECT * from perusahaans order by id";
			
	$rsPerusahaan=$this->User->query($kueri);
	$txtPerusahaan="<option value=''>---Pilih Perusahaan---</option>";
	foreach($rsPerusahaan as $jumPerusahaan){
		$txtPerusahaan.="<option value='".$jumPerusahaan['perusahaans']['id']."'>".$jumPerusahaan['perusahaans']['namaPerusahaan']."</option>";}
		

	
	echo $display."!".$txtCabang."!".$txtDivisi."!".$txtGroups."!".$txtPerusahaan."!".$txtSubDivisi;	
exit();
	}
public function getData(){
		$this->autoRender = false;
	try{		
		 
		$dataSource = $this->User->getdatasource();
		$dataSource->begin();
		$txtCari=$_POST['txtCari'];
		$hm=$_POST['hal'];
		$limit=20;
	/*$order=$_POST['order'];
	if(empty($order)){$order=="nama";}*/
		if(empty($hm)||$hm==1){$start=0; }
		else{ $start=($hm-1)*$limit; }
		
		$txtData='';
		
		$cekUser="SELECT u.*, g.namaGroup, p.namaPerusahaan,cp.nama_area FROM users u 
		LEFT JOIN groups g ON g.ID=u.groupId
		LEFT JOIN perusahaans p ON p.id=u.perusahaanId
		LEFT JOIN communication_points cp ON cp.comid=u.comId
		WHERE u.namaUser LIKE '%$txtCari%'
		ORDER BY u.ID" ;
		$i=0; 
		$n=$start+1;
		//echo $cekPrinter;
		$hasilUser=$this->User->query($cekUser);
		$jumUser=count($hasilUser);
			
		
		$sum=ceil($jumUser/$limit);
		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->Function->pageNav($hm,$sum,$limit);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		
		$rsTampil=$this->User->query($cekUser." limit $start, $limit");
		
		foreach($rsTampil as $resUser){
		$ID=$resUser['u']['ID'];
		$nama=$resUser['u']['namaUser'];
		$penanggungjawab=$resUser['u']['penanggungJawab'];
		$pejabatid=$resUser['u']['pejabatId'];
		$groupsId=$resUser['u']['groupId'];
		$groups=$resUser['g']['namaGroup'];
		$divisi=$resUser['u']['divisi'];
		$subDivisi=$resUser['u']['subDivisi'];
		$cabang=$resUser['cp']['nama_area'];
		$perusahaan=$resUser['p']['namaPerusahaan'];
		$reguler=$resUser['u']['reg'];
		$keterangan=$resUser['u']['keterangan'];
			$txtHead="<tr>
			<td align=\"center\">No</td>
			<td align=\"center\" style='display:none'>ID</td>
			<td align=\"center\">Nama User</td>
			<td align=\"center\">Penanggungjawab</td>
			<td align=\"center\">Pejabat ID</td>
			<td align=\"center\">Groups</td>
			
			<td align=\"center\">Divisi</td>
			<td align=\"center\">Sub Divisi</td>
			<td align=\"center\">Perusahaan</td>
			<td align=\"center\">Reguler</td>
			<td align=\"center\">Keterangan</td>
			<td></td>
			
			</tr>";
			
			$txtData.="<tr>
			<td align=\"center\">$n</td>
			<td id='id".$resUser['u']['ID']."' align=\"center\" style=\"display:none\">$ID</td>
			<td id='txtNama".$resUser['u']['ID']."' align=\"left\">$nama</td>
			<td id='txtPenanggungjawab".$resUser['u']['ID']."' align=\"left\">$penanggungjawab</td>
			<td id='txtPejabatId".$resUser['u']['ID']."' align=\"left\">$pejabatid</td>
			<td id='txtGroupsId".$resUser['u']['ID']."' align=\"center\" style=\"display:none\">$groupsId</td>
			<td id='txtGroups".$resUser['u']['ID']."' align=\"center\">$groups</td>
			<td id='txtCabangID".$resUser['u']['ID']."' align=\"center\" style=\"display:none\">".$resUser['u']['comId']."</td>
			<td id='txtDivisi".$resUser['u']['ID']."' align=\"center\">$divisi</td>
			<td id='txtSubDivisi".$resUser['u']['ID']."' align=\"center\">$subDivisi</td>
			<td id='txtPerusahaanId".$resUser['u']['ID']."' align=\"center\" style=\"display:none\">".$resUser['u']['perusahaanId']."</td>
			<td id='txtPerusahaan".$resUser['u']['ID']."' align=\"center\">$perusahaan</td>
			<td id='txtReguler".$resUser['u']['ID']."' align=\"center\">$reguler</td>
			<td id='txtKeterangan".$resUser['u']['ID']."' align=\"left\">$keterangan</td>
			<td><a href='#' onclick='editData(".$resUser['u']['ID'].")'>edit</a>&nbsp&nbsp|&nbsp&nbsp<a href='#' onclick='hapusData(".$resUser['u']['ID'].")'>hapus</a></td>
			
			</tr>";
		$i++;	
		$n++;
		}
				
				
		
		
	if($i==0){
		$txtHead="<tr>
			<td align=\"center\">No</td>
			<td align=\"center\" style='display:none'>ID</td>
			<td align=\"center\">Nama User</td>
			<td ialign=\"center\">Penanggungjawab</td>
			<td align=\"center\">Pejabat ID</td>
			<td align=\"center\">Groups</td>
			<td align=\"center\">Cabang</td>
			<td align=\"center\">Divisi</td>
			<td align=\"center\">Sub Divisi</td>
			<td align=\"center\">Perusahaan</td>
			<td align=\"center\">Reguler</td>
			<td align=\"center\">Keterangan</td>
			<td></td>
			
			</tr>";
			
		$txtData.="<tr>
			<td align=\"center\" colspan=\"10\">Tidak Ada Data Users</td>
			</tr>";
		echo "!Tidak Ada Data Users!".$txtHead."!".$txtData."!".$linkHal;
		}else{
	echo $i."!Data Users!".$txtHead."!".$txtData."!".$linkHal;
	}
	$dataSource->commit();	 
		}
		catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}

	
	}
	
public function saveData(){
	

$this->autoRender = false;
	try{		
		 
		$dataSource = $this->User->getdatasource();
		$dataSource->begin();
	$saveMode=$_POST['saveMode'];
	$id=$_POST['id'];
	$nama=$_POST['nama'];
	$penanggungjawab=$_POST['penanggungjawab'];
	$pejabatid=$_POST['pejabatid'];
	$groups=$_POST['groups'];
	$divisi=$_POST['divisi'];
	
	$subDivisi=explode("-^-",$_POST['subDivisi']);
	if(count($subDivisi)>1){
		
	$divisi=$subDivisi[0];
	$subDivisi=$subDivisi[1];
		}
	else{
	$divisi="";
	$subDivisi="";}	
	$cabang=$_POST['cabang'];
	$perusahaan=$_POST['perusahaan'];
	$reguler=$_POST['reguler'];
	$keterangan=$_POST['keterangan'];
	if($saveMode=="input"){
	//modeinput

	$cek=$this->User->query("SELECT * FROM users WHERE namaUser='$nama' AND groupId='$groups' AND penanggungJawab='$penanggungjawab' AND pejabatId='$pejabatid' AND perusahaanId='$perusahaan' AND reg='$reguler' AND divisi='$divisi' AND subDivisi='$subDivisi'");
	$jum=count($cek);
	if($jum<=0){
	$qInsert="INSERT INTO `users`(`namaUser`, `pword`, `groupId`, `idUser`, `penanggungJawab`, `keterangan`, `pejabatId`, `perusahaanId`, `reg`, `divisi`, `subDivisi`) VALUES ( '$nama', '12345', '$groups', '0', '$penanggungjawab', '$keterangan', '$pejabatid', '$perusahaan', '$reguler', '$divisi', '$subDivisi')";
	//echo $qInsert;
	$rsSimpan=$this->User->query($qInsert);
	}else{
		echo "Data Sudah Ada, Silahkan edit dari Data yang sudah ada";
		exit();
		}
	}//end modeinput
	elseif($saveMode=="edit"){
		$qEdit="UPDATE `users` SET  `namaUser` = '$nama', `groupId` = '$groups', `penanggungJawab` = '$penanggungjawab', `keterangan` = '$keterangan', `pejabatId` = '$pejabatid', `perusahaanId` = '$perusahaan', `reg` = '$reguler', `divisi` = '$divisi', `subDivisi` = '$subDivisi' WHERE `ID` = '$id';";
		//echo $qEdit;
		$rsEdit=$this->User->query($qEdit);
		}
	
	echo "Penyimpanan Berhasil";
		$dataSource->commit();
		
	}
	catch(Exception $e){
		var_dump($e->getTrace());
			$dataSource->rollback();
		}
	
	
	
	}	
	
public function hapusData(){
	
$this->autoRender = false;
	try{
	$dataSource = $this->User->getdatasource();
		$dataSource->begin();
	$id=$_POST['id'];
	
	$cek=$this->User->query("DELETE FROM `users` WHERE `ID` = '$id'");
	
	echo "User Telah Dihapus";
		$dataSource->commit();
		
	}
	catch(Exception $e){
		var_dump($e->getTrace());
			$dataSource->rollback();
		}
	
	
	
	}			
}

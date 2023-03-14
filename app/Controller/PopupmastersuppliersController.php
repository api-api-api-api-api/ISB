<?php
App::uses('AppController', 'Controller');
/**
 * popup master supplier Controller
 *
 */
class PopupmastersuppliersController extends AppController {
	public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
	}
	
	public function onLoadHandler(){
	$this->autoRender = false;
	$idsupplier=$_POST['idsupplier'];
	$this->loadModel('User');
	
	$supplierdata="SELECT * FROM definance.jenisusahas order by jenis";
	
	$resultsupdata=$this->User->query($supplierdata);
	$txtJenisUsaha.="<option value=''>Jenis Usaha</option>";
	if(count($resultsupdata)>0){
		foreach($resultsupdata as $hslJenis){
			$txtJenisUsaha.="<option value='".$hslJenis["jenisusahas"]["id"]."'>".$hslJenis["jenisusahas"]["jenis"]."</option>";
			}
		}
	$supplierBank="select * from definance.`banks` order by namaBank";
	
	$resultsupBank=$this->User->query($supplierBank);
	$txtBank="<option value=''>Nama Bank</option>";
	if(count($resultsupBank)>0){
		foreach($resultsupBank as $hslBank){
			$txtBank.="<option value='".$hslBank["banks"]["id"]."|".$hslBank["banks"]["namaBank"]."'>".$hslBank["banks"]["namaBank"]."</option>";
			}
		}
	echo $txtJenisUsaha."!".$txtBank;
	}
	
	public function getDataIsi(){
	$this->autoRender = false;
	$idsupplier=$_POST['idsupplier'];
	$this->loadModel('User');
	
	$supplierdata="SELECT * FROM definance.suppliers spl  WHERE spl.`idsupplier`='$idsupplier'";
	
	$resultsupdata=$this->User->query($supplierdata);
	// $dataArray=[];
	// array_push($dataArray,$resultsupdata);
	echo json_encode($resultsupdata);
	}

	//fungsi get deskripsi untuk auto complate
	
	function selectDeskripsi(){
		$this->autoRender = false;
		$this->loadModel('User');  
		//var_dump("SELECT id,nama_divisi FROM dpfdplnew.divisis1 ORDER BY nama_divisi");exit();
		$hasil=$this->User->query("SELECT DISTINCT deskripsi FROM definance.`suppliers` WHERE deskripsi <>'' ORDER BY deskripsi");

		$txtdata=[];
		$txtData2=[];
		foreach($hasil as $dataDivisi){ 
		$txtdata[]= array('label'=>$dataDivisi["suppliers"]["deskripsi"],'value'=>$dataDivisi["suppliers"]["deskripsi"]);
		//$txtData2[]=array($dataDivisi["suppliers"]["deskripsi"]);
		array_push($txtData2,preg_replace("/[^a-zA-Z0-9\ \.]/","",$dataDivisi["suppliers"]["deskripsi"]));
		} 
		echo json_encode($txtData2);
	}


	public function saveData(){
		$this->autoRender = false;
		echo $this->Function->cekSession($this);
		$this->loadModel('User');
		$dataArray=[];
		//sumber pilih aksi 

		$txtSupid=$_POST['txtSupId'];
		$txtBtnAksi=$_POST['txtBtnAksi'];
		// informasi supplier
		$txtNamaSupplier=$_POST['txtNamaSupplier'];
		$txtDeskripsi=$_POST['txtDeskripsi'];
		$txtAlamat=str_replace("~","-",$_POST['txtAlamat']);
		$txtKodePos=$_POST['txtKodePos'];
		if($txtKodePos=='' || $txtKodePos==Null){
			$txtKodePos='Null';
		}
		$txtNoTelp=$_POST['txtNoTelp'];
		$txtFax=$_POST['txtFax'];
		$txtEmail=$_POST['txtEmail'];
		$txtNpwp=$_POST['txtNpwp'];
		$denganPPN=$_POST['ppn'];
		// informasi penanggungjawab
		$txtNamaKontak=$_POST['txtNamaKontak'];
		$txtAlamatKontak=$_POST['txtAlamatKontak'];
		$txtNoHpKontak=$_POST['txtNoHpKontak'];
		$txtEmailKontak=$_POST['txtEmailKontak'];
		$txtJabatanKontak=$_POST['txtJabatanKontak'];
		// informasi bank yang digunakan 

		$txtBank=explode("|",$_POST['txtBank']);
		if($txtBank[0]==''){
			$txtIdBank='';
			$txtNamaBank='';
		}else{
			$txtIdBank=$txtBank[0];
			$txtNamaBank=$txtBank[1];
		}
		
		

		$txtAlamatBank=$_POST['txtAlamatBank'];
		$txtNorek=$_POST['txtNorek'];
		$txtAtasNama=$_POST['txtAtasNama'];
		$txtTos=$_POST['txtTos'];
		$txtKeteranganTos=$_POST['txtKeteranganTos'];
		$txtStatusSupplier=$_POST['txtStatusSupplier'];
		$jenisUsaha=$_POST['jenisUsaha'];
		//var_dump($txtDeskripsi);exit();
		// mulai simpan
		
		if($txtSupid=="Null" and $txtBtnAksi=="Tambah"){
			
			$cekData="SELECT * FROM definance.suppliers spl WHERE spl.nama='$txtNamaSupplier'  AND spl.deskripsi='".$txtDeskripsi."' AND spl.alamat='$txtAlamat'";
			
			$resultCekData=$this->User->query($cekData);
			$jumlahSupplier=count($resultCekData);
			if(!empty($jumlahSupplier)){
				echo "notNull";
				exit();
			}else{
				
				$idsupplier=$this->maxIdSupp('SP');//prefiks harus 2 karakter
				
				$simpanSupplier="INSERT INTO definance.suppliers (idsupplier,nama,deskripsi,alamat,kodepos,notelp,nofax,email,npwp,namaKontak,alamatKontak,noHPKontak,emailKontak,jabatanKontak,idBank,namaBank,alamatBank,noRekening,atasNamaRekening,TOS,keteranganTOS,status,denganPPN,jenisUsaha)VALUES('$idsupplier','$txtNamaSupplier','$txtDeskripsi','$txtAlamat','$txtKodePos','$txtNoTelp','$txtFax','$txtEmail','$txtNpwp','$txtNamaKontak','$txtAlamatKontak','$txtNoHpKontak','$txtEmailKontak','$txtJabatanKontak','$txtIdBank','$txtNamaBank','$txtAlamatBank','$txtNorek','$txtAtasNama','$txtTos','$txtKeteranganTos','$txtStatusSupplier','$denganPPN','$jenisUsaha')";
				
				//echo $simpanSupplier;exit();
				$this->User->query($simpanSupplier);

				if($txtDeskripsi=='Online'){
					$simpanVendor="INSERT INTO definance.vendortikethotels(namaVendor,kota,telp,hp)VALUES('$txtNamaSupplier','$txtAlamat','$txtNoTelp','$txtNoHpKontak')";
					$this->User->query($simpanVendor);
				}
				//var_dump($idsupplier);
				echo "simpan";
				exit();
			}		

		}else{
			if($txtDeskripsi=='Online'){
				
				//$getNamaVendorDariSup="SELECT nama FROM definance.suppliers WHERE idsupplier='$txtSupid'";
				$cekVendor=$this->User->query("SELECT * FROM definance.vendortikethotels WHERE CONCAT(namaVendor,telp)=(SELECT CONCAT(nama,notelp) FROM definance.suppliers WHERE idsupplier='".$txtSupid."')");
				
				//$hasil=$this->User->query($getNamaVendorDariSup);
				if(count($cekVendor)>0){
					$idVendor=$cekVendor[0]['vendortikethotels']['id'];
					//var_dump($idVendor);exit();
					//$getIdVendor="SELECT id FROM definance.vendortikethotels WHERE namaVendor='$namaVendor'";
					$updateVendorOnline="UPDATE definance.vendortikethotels SET namaVendor='$txtNamaSupplier',kota='$txtAlamat',telp='$txtNoTelp',hp='$txtNoHpKontak'  WHERE id='$idVendor'";
					//var_dump($updateVendorOnline);exit();
					$this->User->query($updateVendorOnline);					
				}
				
			}

			
			$updateSupplier="UPDATE definance.suppliers SET nama='$txtNamaSupplier', deskripsi ='$txtDeskripsi',alamat ='$txtAlamat',kodepos ='$txtKodePos',notelp ='$txtNoTelp',nofax ='$txtFax',email ='$txtEmail',npwp ='$txtNpwp',namaKontak = '$txtNamaKontak',alamatKontak = '$txtAlamatKontak',noHPKontak ='$txtNoHpKontak',emailKontak ='$txtEmailKontak',jabatanKontak ='$txtJabatanKontak',idBank ='$txtIdBank',namaBank ='$txtNamaBank',alamatBank ='$txtAlamatBank',noRekening ='$txtNorek',atasNamaRekening ='$txtAtasNama',TOS ='$txtTos',keteranganTOS ='$txtKeteranganTos',status ='$txtStatusSupplier',denganPPN ='$denganPPN', jenisUsaha='$jenisUsaha' WHERE idsupplier='$txtSupid'";
			
			$this->User->query($updateSupplier);

			
			echo "update";
			exit();
		}
		


		//userInput
		//$nik=$_POST['txtPejabatId'];
	}
	
	function maxIdSupp($pref){
	$pref=$pref;
	
	$this->loadModel('User');
	$this->autoRender = false;
	
	$maxRec=$this->User->query("SELECT MAX(idsupplier) idsupplier FROM definance.`suppliers` WHERE SUBSTRING(idsupplier,1,'".strlen($pref)."')='".$pref."'");
	
	
	$jmlRec=count($maxRec);
	
	if($maxRec==0){$maxId=$pref."001";}
	else{
		$maxId=$maxRec[0][0]["idsupplier"]; 
			$maxId=substr($maxId,strlen($pref),strlen($maxId));
			
			$maxId=$maxId+1001;
			$maxId=substr($maxId,1,4);
			$maxId=$pref.$maxId;
		}	
  	return $maxId;
}
	
}
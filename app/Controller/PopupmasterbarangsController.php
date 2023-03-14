<?php
App::uses('AppController', 'Controller');
/**
 * popup master barang Controller
 *
 */
class PopupmasterbarangsController extends AppController {
	public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
	}
	public function getDataIsi(){
	$this->autoRender = false;
	$itemid=$_POST['itemid'];
	$this->loadModel('Masterbarang');
	
	$masterbarangdata="SELECT * FROM definance.masterbarangs mbr  WHERE mbr.`id`='$itemid'";
	$resitems=$this->Masterbarang->query($masterbarangdata);

	// $dataArray=[];
	// array_push($dataArray,$resultsupdata);
	echo json_encode($resitems);
	// var_dump($resitems);
	// exit();
	}
	// public function getPostId(){
	// 	$this->autoRender = false;
	// 	$this->loadModel('Masterbarang');

	// 	$id=$_POST['id'];
	// 	$selected='';
	// 	$txtPost='';

	// 	$postId="SELECT * FROM definance.postids ";
	// 	$respostId=$this->Masterbarang->query($postId);
	// 	$dataArray=[];
	// 	$txt1="<option value=''>Pilih POST</option>";	
	// 	foreach($respostId as $dataPostId){
	// 		$idPost=$dataPostId['postids']['postId'];
	// 		if($id===$idPost){
	// 			$selected='selected';
	// 		}else{$selected='';}
	// 		$txtPost.="<option value='".$dataPostId['postids']['postId']."' $selected>".$dataPostId['postids']['namaPost']."</option>";
	// 	}
	// 	echo $txt1."".$txtPost;
	// }

	public function getPostId(){
		$this->autoRender = false;
		$this->loadModel('User');

		//var_dump($_POST);exit();
		$hasil='';
		$aksi=$_POST['aksi'];
		if($aksi=='Tambah'){
			$postData=$_POST['postData'];

			$idPost=($postData=='INVENTARIS'? 29:($postData=='ATK'? 31:($postData=='PROMOSI'? 111:null)));

			//var_dump($idPost);exit();
			$postId="SELECT * FROM definance.postids WHERE postId='$idPost'";
			$respostId=$this->User->query($postId);
			foreach($respostId as $dataPostId){
				$hasil=$dataPostId['postids']['postId'].'^'.$dataPostId['postids']['namaPost'];
			}
			return $hasil;
		}else{
			$postData=$_POST['postData'];
			$postId="SELECT * FROM definance.postids WHERE postId='$postData'";
			$respostId=$this->User->query($postId);
			foreach($respostId as $dataPostId){
				$hasil=$dataPostId['postids']['postId'].'^'.$dataPostId['postids']['namaPost'];
			}
			return $hasil;
		}
		
		
	}

	public function getJenis(){
		$this->autoRender = false;
		$this->loadModel('User');
		$idKategori=$_POST['idKategori'];
		$id=$_POST['id'];
		//var_dump($id);exit();
		$selected='';
		$txtJenis='';
		$jenisbar="SELECT * FROM definance.jenisbarangs WHERE kategoriId='$idKategori' ORDER BY nama";
		$resjenisbar=$this->User->query($jenisbar);
		
		// $dataArray=[];
		
		$txt1="<option value=''>Pilih Jenis</option>";	
			
		foreach($resjenisbar as $datajenisbarang){
			$jenId=$datajenisbarang['jenisbarangs']['id'];
			if($id===$jenId){
				$selected='selected';
			}else{$selected='';}
			$txtJenis.="<option value='".$datajenisbarang['jenisbarangs']['id']."' $selected >".$datajenisbarang['jenisbarangs']['nama']."</option>";
			
		}
		echo $txt1."".$txtJenis;
	}
	public function getKategori(){
		$this->autoRender = false;
		$this->loadModel('User');
		$selected='';
		$txtKategori='';
		$id=$_POST['id'];
		$groupFPB=$_POST['groupFPB'];
		
		//var_dump($id);exit();
		$txt1="<option value=''>Pilih Kategori</option>";
		$katbar="SELECT * FROM definance.kategoribarangs WHERE groupFPB='$groupFPB' ORDER BY nama";
		
		$katbarId=$this->User->query($katbar);
		$dataArray=[];
		foreach($katbarId as $datakatbarId){
			$katId=$datakatbarId['kategoribarangs']['id'];
			if($id===$katId){
				$selected='selected';
			}else{$selected='';}
			
			$txtKategori.="<option value='".$datakatbarId['kategoribarangs']['id']."' $selected >".$datakatbarId['kategoribarangs']['nama']."</option>";
			//array_push($dataArray,$datakatbarId);
		}
		
		echo $txt1."".$txtKategori;
	}

	//function get satuan
	public function getSatuan(){
		$this->autoRender = false;
		$this->loadModel('User');
		$selected='';
		//$txtKategori='';
		$dataValue=$_POST['dataValue'];
		//$groupFPB=$_POST['groupFPB'];
		
		//var_dump($dataValue);exit();
		$txtData="<option value=''>Pilih Satuan</option>";
		$satuan="SELECT DISTINCT mb.`satuan` FROM definance.`masterbarangs` mb WHERE mb.`satuan`<>'' ORDER BY mb.`satuan`";
		
		$satuanQuery=$this->User->query($satuan);
		$dataArray=[];
		foreach($satuanQuery as $dataSatuan){
			$satVal=$dataSatuan['mb']['satuan'];
			if($dataValue===$satVal){
				$selected='selected';
			}else{$selected='';}
			
			$txtData.="<option value='".$dataSatuan['mb']['satuan']."' $selected >".$dataSatuan['mb']['satuan']."</option>";
			//array_push($dataArray,$datakatbarId);
		}
		
		echo $txtData;
	}
	function selectSatuan(){
		$this->autoRender = false;
		$this->loadModel('User');  
		
		$hasil=$this->User->query("SELECT DISTINCT mb.`satuan` FROM definance.`masterbarangs` mb WHERE mb.`satuan`<>'' ORDER BY mb.`satuan`");


		$txtdata=[];
		foreach($hasil as $dataSatuan){ 
			//var_dump($dataSatuan);exit();
			array_push($txtdata,preg_replace("/[^a-zA-Z0-9\ \.]/","",$dataSatuan["mb"]["satuan"]));
		} 
		echo json_encode($txtdata);
	}


	public function saveData(){
		$this->autoRender = false;
		echo $this->Function->cekSession($this);
		$this->loadModel('User');
		try{
			$dataSource = $this->User->getdatasource();
			$dataSource->begin();
				

				$dataArray=[];
				$callBack="";
				//var_dump($_POST);exit();
				//sumber pilih aksi 
				$txtItemId=$_POST['txtItemId'];
				$txtBtnAksi=$_POST['txtBtnAksi'];
				
				// informasi Item Barang
				$namaBrg=$_POST['txtNamaBrg'];
				$kategoriBrg=$_POST['txtKategoriBrg'];
				$jenisBrg=$_POST['txtJenisBrg'];
				$editAbleVal=$_POST['txtEditAbleVal'];
				$isAktif=$_POST['txtIsAktif'];
				$isUsef=$_POST['txtIsUsed'];
				$group=$_POST['txtGroup'];
				//$postId=$_POST['txtPostId'];
				$namaGambar=$_POST['namagambar'];
				
				//penentuan postid
				// if($group=="ATK"){
				// 	$postId='31';
				// }elseif($group=="INVENTARIS"){
				// 	$postId='29';
				// }else{
				// 	$postId='111';	
				// 	}
				$postId=($group=='INVENTARIS'? 29:($group=='ATK'? 31:($group=='PROMOSI'? 111:null)));
				
				//informasi stok barang
				$txtSAMasuk=$_POST['txtSAMasuk'];
				$txtStockMinimum=$_POST['txtStockMinimum'];
				$txtKeterangan=$_POST['txtKeterangan'];
				
				if(!empty($txtStockMinimum)){
					$txtStockMinimum=$txtStockMinimum;
				}else{
					$txtStockMinimum='0';
				}

				
				//  echo $namaBrg.'!'.$kategoriBrg.'!'.$jenisBrg.'!'.$editAbleVal.'!'.$isAktif.'!'.$isUsef.'!'.$group.'!'.$postId;
				//  exit();
				// mulai simpan
				$nik=$this->Session->read('nik');
				$nikPusat='PCH1';
						//var_dump($nik);exit();
						
				$getCabang="SELECT cabangId FROM definance.alamatpengirimans WHERE nikPenerima='".$nikPusat."' GROUP BY cabangId";
						//var_dump($getCabang);exit();
				$resGetCabang=$this->User->query($getCabang);
				if(count($resGetCabang)>0){
					foreach($resGetCabang as $hslGetCabang){
						$posisi=$hslGetCabang["alamatpengirimans"]["cabangId"];
					}
				}
				
				if($txtItemId=="Null" and $txtBtnAksi=="Tambah"){
					//echo $txtItemId;exit();
					$satuan=$_POST['txtSatuan'];
					$cekData="SELECT * FROM definance.masterbarangs mbr WHERE mbr.`namabarang`='$namaBrg'";
					$resultCekData=$this->User->query($cekData);
					$jumlahBarang=count($resultCekData);
					
					if(!empty($jumlahBarang)){
						$callBack="notNull";
						
						//var_dump($jumlahBarang.'1');exit();
						return $callBack;
					}else{
						
						$simpanbarang="INSERT INTO definance.masterbarangs (namaBarang,jenisId,kategoriId,`group`,postId,stokMinimal,satuan,namafile)VALUES('$namaBrg','$jenisBrg','$kategoriBrg','$group','$postId','$txtStockMinimum','$satuan','$namaGambar')";
						//var_dump($simpanbarang);exit();
						$this->User->query($simpanbarang);
						
						if(!empty($txtSAMasuk)){
							$date=date("Y-m-d");
							$ambilKdBarang=$this->User->query("SELECT id FROM definance.masterbarangs WHERE namaBarang='$namaBrg' AND jenisId='$jenisBrg'");
							
							if(count($ambilKdBarang)>0){
								foreach($ambilKdBarang as $getKdBrng){
									$kdbarang=$getKdBrng["masterbarangs"]["id"];
									}
								}
								
							$rcek=$this->User->query("SELECT kodeBarang, posisi FROM definance.kartustoks WHERE kodebarang='$kdbarang' AND posisi='$posisi'");
							
							if(count($rcek)<=0 AND $txtSAMasuk>=1){
								// var_dump($row);exit();
								$noTransaksi='';
								$idref='';
								
								
								$kdbarang=$kdbarang;
								$namaBarang=$namaBrg;
								$spesifikasi='';

								$divisi='PURCH';
								$tr='SA';
								
								$stokAwal='0';
								$masuk=$txtSAMasuk;
								
								$keluar='0';
								$saldo=$txtSAMasuk;
								
								$asal='';
								$tujuan=$nikPusat;
								
								//$posisi=$worksheet->getCellByColumnAndRow(13, $row)->getValue();
								$keterangan=$txtKeterangan;
								
								$saveSaldoAwal="INSERT INTO definance.kartustoks (noTransaksi,idref,tanggal,kodeBarang,namaBarang,spesifikasi,divisi,tr,stokAwal,masuk,keluar,saldo,asal,tujuan,posisi,keterangan)VALUES('$noTransaksi','$idref','$date','$kdbarang','$namaBarang','$spesifikasi','$divisi','$tr','$stokAwal','$masuk','$keluar','$saldo','$asal','$tujuan','$posisi','$keterangan')";
								//var_dump($saveSaldoAwal);exit();
										// var_dump("INSERT INTO definance.kartuStoks (noTransaksi,idref,tanggal,kodeBarang,namaBarang,divisi,tr,stokAwal,masuk,keluar,saldo,asal,tujuan,posisi,keterangan)VALUES('$noTransaksi','$idref','$tanggal','$kdbarang','$namaBarang','$divisi','$tr','$stokAwal','$masuk','$keluar','$saldo','$asal','$tujuan','$posisi','$keterangan')");exit();
								$this->User->query($saveSaldoAwal);
							}
						}
						$callBack="simpan";
						//var_dump($idMasterbarang);
							echo $callBack;
						}		
					}else{
						// var_dump($_POST);exit();
						$satCek=$_POST['satCek'];
						$INSERTSAT=($satCek==0?",satuan='".$_POST['txtSatuan']."'":"");
						//var_dump($INSERTSAT);exit();
						$updatebarang="UPDATE definance.masterbarangs SET namaBarang='$namaBrg',jenisId='$jenisBrg',kategoriId='$kategoriBrg',`group`='$group',postId='$postId',stokMinimal='$txtStockMinimum', namafile='$namaGambar' $INSERTSAT WHERE id=$txtItemId";
						$this->User->query($updatebarang);
						$callBack="update";
						
						echo $callBack;
					}
			$dataSource->commit();	
			}
		catch(Exception $e){
				var_dump($e->getTrace());
					$dataSource->rollback();
			}
	}


	//fungsi paging
	public function pageNavMulti($curHal,$maxHal,$jmlTampil,$fungsi){
		$linkHal='';
		$angka='';
		$halTengah=round($jmlTampil/2);
		if($maxHal>1){
			if($curHal > 1){
				$previous=$curHal-1;
				$linkHal=$linkHal."<ul class='pagination'><li class='page-item'><a class='page-link' onclick='".$fungsi."(1)'> First</a></li>";
				$linkHal=$linkHal."<li class='page-item'><a class='page-link' onclick='".$fungsi."($previous)'>Prev</a></li>";
			}elseif(empty($curHal)||$curHal==1){
				$linkHal=$linkHal."<ul class='pagination'><li class='page-item'><a class='page-link'>First</a></li><li class='page-item'><a class='page-link'>Prev</a></li> ";
			}
			
			for($i=$curHal-($halTengah-1);$i<$curHal;$i++) {
				if ($i < 1)
				continue;
				$angka .= "<li class='page-item'><a class='page-link' onclick='".$fungsi."($i)'>$i</a></li>";
			}
			$angka .= "<li class='page-item active'><span class='page-link'><b >$curHal</b> <span class='sr-only'>(current)</span></span></li>";
			for($i=$curHal+1;$i<($curHal +$halTengah);$i++) {
				if ($i > $maxHal)
				break;
				$angka .= "<li class='page-item'><a class='page-link' onclick='".$fungsi."($i)'>$i</a></li> ";
			}
			$linkHal=$linkHal.$angka;
			if($curHal < $maxHal){
				$next=$curHal+1;
				$linkHal=$linkHal."<li class='page-item'><a class='page-link'onclick='".$fungsi."($next)'>Next </a></li><li class='page-item'>
				<a class='page-link' onclick='".$fungsi."($maxHal)'>Last</a></li> </ul>";
			} else {
				$linkHal=$linkHal." <li class='page-item'><a class='page-link'>Next</a></li><li class='page-item'><a class='page-link'>Last</a></li></ul>";
			  }
			}
			return $linkHal;
	  }
	  
	  public function kirimData(){
		$this->autoRender = false;
		$this->loadModel('User');
		$gambar = $_POST['gambar'];
		$id = $_POST['id'];
		$aksi = $_POST['aksi'];
		
		if($id=="Null" and $aksi=="Tambah"){
			$idGambar=$this->maxId("masterbarangs","id","definance");
		}else{
			$idGambar=$id;}
		file_put_contents("masterbarang/".$idGambar.".jpg",file_get_contents($gambar));
		echo $idGambar.".jpg";
	  }
	  
	  public function maxId($tabel,$field,$database){
		$this->loadModel('User');
		$this->autoRender = false;
	
		$res=$this->User->query("select max($field) a from $database.$tabel");
		
		foreach($res as $hsl){
			
			if($hsl["0"]["a"]==NULL || $hsl["0"]["a"]==""){
			$maxId=1;
			}else{ $maxId=$hsl["0"]["a"]+1;
				
				}}
		//if (count($res)<=0){ $maxId=1; }
		//else{ $maxId=(count($res))+1; }
		return $maxId;
}	
	 
	
}
	
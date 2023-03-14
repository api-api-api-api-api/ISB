<?php
App::uses('AppController', 'Controller');

 
class VerifikasigasController extends AppController {
	public $components = array('Function','Paginator');	
	public $uses = array();
	public function index(){
		echo $this->Function->cekSession($this);
	}

public function alokasidata(){
$this->autoRender = false;	
$this->loadModel('User');

$nik = $_POST['nik'];
$harga = $_POST['harga'];
$idpermintaan = $_POST['idpermintaan'];
$notransaksi = $_POST['notransaksi'];
$kodebarang = $_POST['kodebarang'];
$namabarang = $_POST['namabarang'];
$namakaryawan = $_POST['namakaryawan'];
$divisi = $_POST['divisi'];
$stokawal = $_POST['stokawal'];
$keluar = $_POST['keluar'];
$asal = $_POST['asal'];
$posisi = $_POST['posisi'];
$tanggalpermintaan = $_POST['tanggalpermintaan'];
$jumlahpermintaan = $_POST['jumlahpermintaan'];
$jumlahalokasi = $_POST['jumlahalokasi'];
$permintaankurang = $_POST['permintaankurang'];
$userga='GAHARMONI';


$jumlahupdate = $jumlahpermintaan - $jumlahalokasi;
$stokupdate = $stokawal - $jumlahalokasi;
$saldo= $stokawal - $jumlahalokasi;

if($permintaankurang=="0"){
$jumlahupdate="0";
$statusalokasi='permintaan di alokasi';
}elseif($permintaankurang>0){
$statusalokasi='di alokasi sebagian';	
}


//if($dapatalokasi<0){
//$jumlahupdate="0";
//$statusalokasi='permintaan di alokasi';
//}elseif($jumlahupdate==$jumlahpermintaan){
//$statusalokasi='tidak teralokasi';
//}elseif($jumlahupdate=='0'){
//$statusalokasi='permintaan di alokasi';
//}elseif($jumlahupdate>0){
//$statusalokasi='di alokasi sebagian';	
//}

//$stokupdate=$stokawal-$jumlahpermintaan;
//if($stokupdate<0){
//$stokupdate="0";
//}
$tanggalini=date("Y/m/d");

	$sql4 = "INSERT INTO definance.rekapAlokasis(noTransPermintaan, permintaanId, tanggalAlokasi, nik, namaKaryawan, divisi, namaBarang, harga, jumlahPermintaan, alokasiKurang, statusAlokasi, asalBarang, tujuanBarang,jumlahAlokasi) values('$notransaksi', '$idpermintaan', '$tanggalini', '$nik', '$namakaryawan', '$divisi', '$namabarang', '$harga', '$jumlahpermintaan', '$permintaankurang', '$statusalokasi', '$asal', '$userga','$jumlahalokasi')";
	$query4 = $this->User->query($sql4);

	$sql4b = "SELECT id from definance.rekapAlokasis where noTransPermintaan='$notransaksi' and permintaanId='$idpermintaan'";
	$query4b = $this->User->query($sql4b);
	foreach ($query4b as $row4b) {
		$idref="SK".$row4b['rekapAlokasis']['id'];
	}

	$sql1 = "UPDATE definance.masterstoks SET stok='$stokupdate' where idBarang='$kodebarang' and posisi='$userga'";
	$query1 = $this->User->query($sql1);

	$sql2 = "UPDATE definance.permintaanfpbfinals SET jumlah='$jumlahupdate', statusAlokasi='$statusalokasi' where permintaanId='$idpermintaan' and noTransPermintaan='$notransaksi'";
	$query2 = $this->User->query($sql2);

	$sql3 = "INSERT INTO definance.kartuStoks(noTransaksi, idref, tanggal, kodeBarang, namaBarang, divisi, tr, stokAwal, masuk, keluar, saldo, asal, tujuan, posisi, keterangan) Values('$notransaksi', '$idref', '$tanggalini','$kodebarang', '$namabarang', '$divisi','SK', '$stokawal', '0', '$jumlahalokasi', '$saldo', '$userga', '$divisi', '$userga', 'Alokasi')";
	$query3 = $this->User->query($sql3);


	echo "berhasil melakukan alokasi";



}


public function getData(){
$this->autoRender = false;
$this->loadModel('User');

$userga="GAHARMONI";

$sql = "SELECT permintaanfpbfinals.tanggalPermintaan as tanggalpermintaan, permintaanfpbfinals.noTransPermintaan as notranspermintaan, permintaanfpbfinals.nik as nik, permintaanfpbfinals.namaKaryawan as namakaryawan, permintaanfpbfinals.namaDivisi as namadivisi, permintaanfpbfinals.namaJabatan as namajabatan
	from definance.permintaanfpbfinals where permintaanfpbfinals.status = 'bolehdiproses'  and permintaanfpbfinals.statusAlokasi = '' OR permintaanfpbfinals.statusAlokasi = null 
    GROUP BY permintaanfpbfinals.noTransPermintaan,permintaanfpbfinals.namaKaryawan,permintaanfpbfinals.nik,permintaanfpbfinals.tanggalPermintaan,permintaanfpbfinals.namaJabatan,permintaanfpbfinals.namaDivisi order by permintaanfpbfinals.noTransPermintaan DESC
	";

$querys = $this->User->query($sql);

$x = 1;
$i = 1;
foreach($querys as $row) {


$tombol="<div class='btn-group'> <a href='#' id='detail".$i."' data-toggle='modal' data-target='#formdetail' 
data-notranspermintaan='".$row['permintaanfpbfinals']['notranspermintaan']."'
data-tanggalpermintaan='".$row['permintaanfpbfinals']['tanggalpermintaan']."'
data-namakaryawan='".$row['permintaanfpbfinals']['namakaryawan']."'
data-nik='".$row['permintaanfpbfinals']['nik']."'
data-namadivisi='".$row['permintaanfpbfinals']['namadivisi']."'
 onclick='detailpermintaan(".$i.")' style='  background-color: #66ccff; color: white;padding: 14px 25px;text-align: center;text-decoration: none;display: inline-block;width: 100%;'>  Alokasi Barang</a></div>";



$output="

          <tr>
              <td>".$row['permintaanfpbfinals']['notranspermintaan']."</td>                    
              <td>".$row['permintaanfpbfinals']['nik']."</td>
              <td>".$row['permintaanfpbfinals']['namakaryawan']."</td>
              <td>".$row['permintaanfpbfinals']['namajabatan']."</td>
              <td>".$row['permintaanfpbfinals']['namadivisi']."</td>
              <td>".$row['permintaanfpbfinals']['tanggalpermintaan']."</td>
              <td style='width:15%'>".$tombol."</td>
              </tr>
   			";


echo $output;

$i++;

}//foreach 


}//end get


public function getData2(){
$this->autoRender = false;
$this->loadModel('User');

$userga="GAHARMONI";
$notranspermintaan=$_POST['notranspermintaan'];
$sql = "SELECT permintaanfpbfinals.permintaanId as permintaanid, permintaanfpbfinals.tanggalPermintaan as tanggalpermintaan, permintaanfpbfinals.jenisPermintaan as jenispermintaan, permintaanfpbfinals.noTransPermintaan as notranspermintaan, permintaanfpbfinals.nik as nik, permintaanfpbfinals.namaKaryawan as namakaryawan, permintaanfpbfinals.namaDivisi as namadivisi, permintaanfpbfinals.masterBarangId as masterbarangid, permintaanfpbfinals.namaBarang as namabarang, permintaanfpbfinals.harga as harga, permintaanfpbfinals.jumlah as jumlahpermintaan, masterstoks.stok as stoktersedia, masterstoks.posisi as lokasibarang ,permintaanfpbfinals.spesifikasi as spesifikasi
	from definance.permintaanfpbfinals left join definance.masterstoks
	on permintaanfpbfinals.masterBarangId = masterstoks.idBarang
	where permintaanfpbfinals.noTransPermintaan = '$notranspermintaan' and masterstoks.posisi = '$userga' 
	";

$querys = $this->User->query($sql);

$x = 1;
$i = 1;
foreach($querys as $row) {

$jpermintaan=$row['permintaanfpbfinals']['jumlahpermintaan'];
$spermintaan=$row['masterstoks']['stoktersedia'];
$slokasibarang=$row['masterstoks']['lokasibarang'];
if($spermintaan==""){
	$spermintaan="0";
}

if($slokasibarang==""){
	$slokasibarang="-";
}

$data1=$row['permintaanfpbfinals']['permintaanid'];
$data2=$row['permintaanfpbfinals']['notranspermintaan'];

$tombol="<div class='btn-group'> <a href='#' id='link".$i."' data-toggle='modal' data-target='#formalokasi' 
data-notranspermintaan='".$row['permintaanfpbfinals']['notranspermintaan']."'
data-permintaanid='".$row['permintaanfpbfinals']['permintaanid']."'
data-tanggalpermintaan='".$row['permintaanfpbfinals']['tanggalpermintaan']."'
data-namakaryawan='".$row['permintaanfpbfinals']['namakaryawan']."'
data-namabarang='".$row['permintaanfpbfinals']['namabarang']."'
data-jumlahpermintaan='".$row['permintaanfpbfinals']['jumlahpermintaan']."'
data-spermintaan='".$spermintaan."'
data-nik='".$row['permintaanfpbfinals']['nik']."'
data-namadivisi='".$row['permintaanfpbfinals']['namadivisi']."'
data-harga='".$row['permintaanfpbfinals']['harga']."'
data-slokasibarang='".$slokasibarang."'
data-masterbarangid='".$row['permintaanfpbfinals']['masterbarangid']."'
data-jenispermintaan='".$row['permintaanfpbfinals']['jenispermintaan']."'
 onclick='alokasi(".$i.")' style='  background-color: #66ccff; color: white;padding: 14px 25px;text-align: center;text-decoration: none;display: inline-block;width: 100%;'>  Alokasi Barang</a></div>";



$output="

          <tr>
              <td>".$row['permintaanfpbfinals']['permintaanid']."</td>                    
              <td>".$row['permintaanfpbfinals']['jenispermintaan']."</td>
              <td>".$row['permintaanfpbfinals']['namabarang']."</td>
              <td>".$row['permintaanfpbfinals']['spesifikasi']."</td>
              <td>".$row['permintaanfpbfinals']['jumlahpermintaan']."</td>
              <td>".$row['masterstoks']['stoktersedia']."</td>
              <td style='width:15%'>".$tombol."</td>
              </tr>
   			";


echo $output;

$i++;

}//foreach 


}//end get


public function getData3(){
$this->autoRender = false;
$this->loadModel('User');

$userga="GAHARMONI";

$sql = "SELECT permintaanfpbfinals.permintaanId as permintaanid, permintaanfpbfinals.tanggalPermintaan as tanggalpermintaan, permintaanfpbfinals.jenisPermintaan as jenispermintaan, permintaanfpbfinals.noTransPermintaan as notranspermintaan, permintaanfpbfinals.nik as nik, permintaanfpbfinals.namaKaryawan as namakaryawan, permintaanfpbfinals.namaDivisi as namadivisi, permintaanfpbfinals.masterBarangId as masterbarangid, permintaanfpbfinals.namaBarang as namabarang, permintaanfpbfinals.harga as harga, permintaanfpbfinals.jumlah as jumlahpermintaan, masterstoks.stok as stoktersedia, masterstoks.posisi as lokasibarang 
	from definance.permintaanfpbfinals left join definance.masterstoks
	on permintaanfpbfinals.masterBarangId = masterstoks.idBarang
	where permintaanfpbfinals.status = 'bolehdiproses' and masterstoks.posisi = '$userga' and permintaanfpbfinals.statusAlokasi = '' OR permintaanfpbfinals.statusAlokasi = null
	";

$querys = $this->User->query($sql);

$x = 1;
$i = 1;
foreach($querys as $row) {

$jpermintaan=$row['permintaanfpbfinals']['jumlahpermintaan'];
$spermintaan=$row['masterstoks']['stoktersedia'];
$slokasibarang=$row['masterstoks']['lokasibarang'];
if($spermintaan==""){
	$spermintaan="0";
}

if($slokasibarang==""){
	$slokasibarang="-";
}

$data1=$row['permintaanfpbfinals']['permintaanid'];
$data2=$row['permintaanfpbfinals']['notranspermintaan'];

$tombol="<div class='btn-group'> <a href='#' id='link".$i."' data-toggle='modal' data-target='#formalokasi' 
data-notranspermintaan='".$row['permintaanfpbfinals']['notranspermintaan']."'
data-permintaanid='".$row['permintaanfpbfinals']['permintaanid']."'
data-tanggalpermintaan='".$row['permintaanfpbfinals']['tanggalpermintaan']."'
data-namakaryawan='".$row['permintaanfpbfinals']['namakaryawan']."'
data-namabarang='".$row['permintaanfpbfinals']['namabarang']."'
data-jumlahpermintaan='".$row['permintaanfpbfinals']['jumlahpermintaan']."'
data-spermintaan='".$spermintaan."'
data-nik='".$row['permintaanfpbfinals']['nik']."'
data-namadivisi='".$row['permintaanfpbfinals']['namadivisi']."'
data-harga='".$row['permintaanfpbfinals']['harga']."'
data-slokasibarang='".$slokasibarang."'
data-masterbarangid='".$row['permintaanfpbfinals']['masterbarangid']."'
data-jenispermintaan='".$row['permintaanfpbfinals']['jenispermintaan']."'
 onclick='alokasi(".$i.")' style='  background-color: #66ccff; color: white;padding: 14px 25px;text-align: center;text-decoration: none;display: inline-block;width: 100%;'>  Alokasi Barang</a></div>";



$output="


          <tr>
              <td>".$row['permintaanfpbfinals']['permintaanid']."</td> 
              <td>".$row['permintaanfpbfinals']['notranspermintaan']."</td>                    
              <td>".$row['permintaanfpbfinals']['jenispermintaan']."</td>
              <td>".$row['permintaanfpbfinals']['nik']."</td>
              <td>".$row['permintaanfpbfinals']['namakaryawan']."</td>
              <td>".$row['permintaanfpbfinals']['namadivisi']."</td>
              <td>".$row['permintaanfpbfinals']['masterbarangid']."</td>
              <td>".$row['permintaanfpbfinals']['namabarang']."</td>
              <td>".$row['permintaanfpbfinals']['jumlahpermintaan']."</td>
              <td>".$spermintaan."</td>
              <td>".$slokasibarang."</td>
              <td>".$row['permintaanfpbfinals']['tanggalpermintaan']."</td>
              <td>".$row['permintaanfpbfinals']['harga']."</td>
              <td>".$tombol."</td>
              </tr>
   			";


echo $output;

$i++;

}//foreach 


}//end get



public function okProses(){
	$this->autoRender = false;	
$this->loadModel('User');

	$idpermintaan=$_POST['idpermintaan'];
	$statusAlokasi=$_POST['statusorder'];
	$notransaksi=$_POST['notranspermintaan'];

	$nik=$_POST['nik'];
	$divisi=$_POST['namadivisi'];
	$harga=$_POST['harga'];

	$namakaryawan=$_POST['namakaryawan'];
	$namabarang=$_POST['namabarang'];
	$jumlahpermintaan=$_POST['jumlahpermintaan'];

	$permintaankurang=$_POST['permintaankurang'];
	$jumlahalokasi=$_POST['jumlahalokasi'];

	$asal=$_POST['lokasibarang'];

	$stoktersedia=$_POST['stoktersedia'];
	$kodebarang=$_POST['kodebarang'];
	$jenispermintaan=$_POST['jenispermintaan'];

	$jumlahpo=$_POST['jumlahpo'];

	$stokupdate=$stoktersedia-$jumlahalokasi;

	$userga='GAHARMONI';



	if($statusAlokasi=="ditolakGA"){
		$statusini="ditolakGA";
			$sql2 = "UPDATE definance.permintaanfpbfinals SET status='$statusini',qtyAlokasi='$jumlahalokasi',qtyVerifikasi='$jumlahpo',statusAlokasi='$statusAlokasi' where permintaanId='$idpermintaan' and noTransPermintaan='$notransaksi'";
	$query2 = $this->User->query($sql2);
	}else{
		$statusini="distujuiGA";
			$sql2 = "UPDATE definance.permintaanfpbfinals SET status='$statusini',qtyAlokasi='$jumlahalokasi',qtyVerifikasi='$jumlahpo',statusAlokasi='$statusAlokasi' where permintaanId='$idpermintaan' and noTransPermintaan='$notransaksi'";
	$query2 = $this->User->query($sql2);
	}



	//////////////////////////////

	$tanggalini=date("Y/m/d");

	if($statusAlokasi=="dialokasisebagian"){///if1

	$sql4 = "INSERT INTO definance.rekapAlokasis(noTransPermintaan, permintaanId, tanggalAlokasi, nik, namaKaryawan, divisi, namaBarang, harga, jumlahPermintaan, alokasiKurang, statusAlokasi, asalBarang, tujuanBarang,jumlahAlokasi) values('$notransaksi', '$idpermintaan', '$tanggalini', '$nik', '$namakaryawan', '$divisi', '$namabarang', '$harga', '$jumlahpermintaan', '$permintaankurang', '$statusAlokasi', '$asal', '$userga','$jumlahalokasi')";
	$query4 = $this->User->query($sql4);

	$sql4b = "SELECT id from definance.rekapAlokasis where noTransPermintaan='$notransaksi' and permintaanId='$idpermintaan'";
	$query4b = $this->User->query($sql4b);
	foreach ($query4b as $row4b) {
		$idref="SK".$row4b['rekapAlokasis']['id'];
	}

	$sql1 = "UPDATE definance.masterstoks SET stok='$stokupdate' where idBarang='$kodebarang' and posisi='$userga'";
	$query1 = $this->User->query($sql1);

	$sql3 = "INSERT INTO definance.kartuStoks(noTransaksi, idref, tanggal, kodeBarang, namaBarang, divisi, tr, stokAwal, masuk, keluar, saldo, asal, tujuan, posisi, keterangan) Values('$notransaksi', '$idref', '$tanggalini','$kodebarang', '$namabarang', '$divisi','SK', '$stoktersedia', '0', '$jumlahalokasi', '$stokupdate', '$asal', '$divisi', '$userga', 'Alokasi')";
	$query3 = $this->User->query($sql3);

	$sql5 = "INSERT INTO definance.rekapVerifikasi(jenisPermintaan,nik,namaKaryawan,divisi,kodeBarang,namaBarang,jumlahPermintaan,harga,tanggalPermintaan,statusVerifikasi,jumlahVerifikasi,jumlahAlokasi) VALUES('$jenispermintaan','$nik','$namakaryawan','$divisi','$kodebarang','$namabarang','$jumlahpermintaan','$harga','$tanggalini','$statusAlokasi','$jumlahpo','$jumlahalokasi')";
	$query5 = $this->User->query($sql5);

/*
echo "'$jenispermintaan','$nik','$namakaryawan','$divisi','$kodebarang','$namabarang','$jumlahpermintaan','$harga','$tanggalini','$statusAlokasi','$jumlahpo','$jumlahalokasi'";
*/
		}//endif1
	elseif($statusAlokasi=="dialokasikeseluruhan"){//else if1

	$sql4x = "INSERT INTO definance.rekapAlokasis(noTransPermintaan, permintaanId, tanggalAlokasi, nik, namaKaryawan, divisi, namaBarang, harga, jumlahPermintaan, alokasiKurang, statusAlokasi, asalBarang, tujuanBarang,jumlahAlokasi) values('$notransaksi', '$idpermintaan', '$tanggalini', '$nik', '$namakaryawan', '$divisi', '$namabarang', '$harga', '$jumlahpermintaan', '$permintaankurang', '$statusAlokasi', '$asal', '$userga','$jumlahalokasi')";
	$query4x = $this->User->query($sql4x);

	$sql4bx = "SELECT id from definance.rekapAlokasis where noTransPermintaan='$notransaksi' and permintaanId='$idpermintaan'";
	$query4bx = $this->User->query($sql4bx);
	foreach ($query4bx as $row4bx) {
		$idrefx="SK".$row4bx['rekapAlokasis']['id'];
	}

	$sql1x = "UPDATE definance.masterstoks SET stok='$stokupdate' where idBarang='$kodebarang' and posisi='$userga'";
	$query1x = $this->User->query($sql1x);

	$sql3x = "INSERT INTO definance.kartuStoks(noTransaksi, idref, tanggal, kodeBarang, namaBarang, divisi, tr, stokAwal, masuk, keluar, saldo, asal, tujuan, posisi, keterangan) Values('$notransaksi', '$idrefx', '$tanggalini','$kodebarang', '$namabarang', '$divisi','SK', '$stoktersedia', '0', '$jumlahalokasi', '$stokupdate', '$asal', '$divisi', '$userga', 'Alokasi')";
	$query3x = $this->User->query($sql3x);


	}//end else if1
	elseif($statusAlokasi=="disetujuikeseluruhan"){//else if2

	$sql5 = "INSERT INTO definance.rekapVerifikasi(jenisPermintaan,nik,namaKaryawan,divisi,kodeBarang,namaBarang,jumlahPermintaan,harga,tanggalPermintaan,statusVerifikasi,jumlahVerifikasi,jumlahAlokasi) VALUES('$jenispermintaan','$nik','$namakaryawan','$divisi','$kodebarang','$namabarang','$jumlahpermintaan','$harga','$tanggalini','$statusAlokasi','$jumlahpo','$jumlahalokasi')";
	$query5 = $this->User->query($sql5);

	}elseif($statusAlokasi=="ditolakGA"){
		echo "Di Tolak GA";
	}

	//end else if2


}//end okproses
	}//end class

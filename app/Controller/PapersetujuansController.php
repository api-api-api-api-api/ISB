<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Pa Persetujuan
 *  referent DB kpireg
 */
class  PapersetujuansController extends AppController {
	public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
	}

	function getData(){
		$this->autoRender = false;
		$this->loadModel('User');
		$this->loadModel('Asset');
		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

		if($this->Session->read("dpfdpl_groupId")!=100){
			$sql = "SELECT users.namaUser,nama,masteridmkts.divisi,nik,ket FROM users LEFT JOIN uploadsales.masteridmkts ON users.namaUser=uploadsales.masteridmkts.id WHERE namaUser='".$this->Session->read('dpfdpl_namaUser')."' ORDER BY nama;";
			$result = $this->User->query($sql);
		
			if(count($result)>0){
				foreach($result  as $row){
					$rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row['masteridmkts']['nik']."'");
					if(count($rsKaryawan)<=0){
						$this->User->setDataSource('local');
						$rsKaryawan=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
					}
					$namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
					$tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
					$nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
				}
			}
		}else{
		   $rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$this->Session->read("dpfdpl_namaUser")."'");
		   
			//jika data belum ada di master
			if(count($rsKaryawan)<=0){
				$this->User->setDataSource('local');
				$rsKaryawan=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
			$namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
			$tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
			$nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}

		//ambil nik kabag atau kadep
		$iduserlogin 	='';
		$NIKUSERLOGIN 	="2090099";
		$NAMAUSERLOGIN 	="DENNY ARDIA RAHMAN";
		$TGLLAHIRUSERLOGIN="1985-03-14";
		
		$iduserlogin 	='';
		// $NIKUSERLOGIN 	=$nikCari;
		// $NAMAUSERLOGIN 	=$namaKaryawan;
		// $TGLLAHIRUSERLOGIN=$tglLahir;

		$periode="";
		$queryPeriode=$this->Asset->query("SELECT * FROM kpireg.`paperiodepenilaians` periode  WHERE periode.status='OPEN' ORDER BY periode.id");
		$jumKategori=count($queryPeriode);
		//var_dump($queryPeriode);exit();
		if($jumKategori<1){
			$periode ='Belum ada periode yang dibuka';
			$txtData="
			<tr>
			<td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
			</tr>";
		}else{
			$periodeId=$queryPeriode[0]['periode']['id'];
			$periodeStart   =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeStart']));
			$periodeEnd     =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeEnd']));
			$tahun          =$queryPeriode[0]['periode']['tahun'];
			$periodeNama	=$queryPeriode[0]['periode']['namaPeriode'];
			
			$periode 		=$periodeNama.' ('.$periodeStart.' s/d '.$periodeEnd.') '.'^'.$periodeId;
		}

		$txtData="";
		$hm=$_POST['hal'];
		$fungsi="getData";
		$limit=10;
		if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

		//query sementara
		//$querytext="SELECT * FROM kpireg.`pahirarkis`  INNER JOIN kpireg.`papenilaikaryawans` ppk ON ppk.idKry=pahirarkis.idkry WHERE idatasan='$iduserlogin' AND (pahirarkis.sebagai='kabag' OR pahirarkis.sebagai='kadep') AND ppk.`status` NOT IN ('atasan','finish');";//query by id
		// $querytext="SELECT * FROM kpireg.`pahirarkis`  INNER JOIN kpireg.`papenilaikaryawans` ppk ON (ppk.`namaKaryawan`=pahirarkis.`nmkry` AND ppk.`tglLahirKaryawan`=pahirarkis.`tglLahirKaryawan`) WHERE pahirarkis.`nmatasan`='$NAMAUSERLOGIN' AND pahirarkis.`tglLahirAtasan`='$NAMAUSERLOGIN' AND (pahirarkis.sebagai='kabag' OR pahirarkis.sebagai='kadep') AND ppk.`status` NOT IN ('atasan','finish') AND ppk.`periode`='$periodeId'";//query by nama dan tanggal lhir
		// var_dump($querytext);exit();

		//karena optional tidak berperngaruh di status
		$querytext="SELECT * FROM kpireg.`pahirarkis` INNER JOIN kpireg.`papenilaikaryawans` ppk ON (ppk.`namaKaryawan`=pahirarkis.`nmkry` AND ppk.`tglLahirKaryawan`=pahirarkis.`tglLahirKaryawan`) 
		WHERE pahirarkis.`nmatasan`='$NAMAUSERLOGIN' AND pahirarkis.`tglLahirAtasan`='$TGLLAHIRUSERLOGIN' 
		AND ((pahirarkis.`sebagai`='kabag' AND ppk.`komentarKabag` IS NULL) OR (pahirarkis.`sebagai`='kadep' AND ppk.`komentarKadep` IS NULL)) AND ppk.`periode`='$periodeId'";
		//var_dump($querytext);exit();
		// $querytext="SELECT * FROM (SELECT * FROM kpireg.`pahirarkis` WHERE nmatasan='$NAMAUSERLOGIN' AND tglLahirAtasan='$TGLLAHIRUSERLOGIN' AND sebagai='atasan')pahirarkis LEFT JOIN (SELECT SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idkrynew, SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikkrynew,mk.namakry AS nmkrynew,mk.tgllahir AS tglLahirKaryawannew FROM absensi.master_karyawan mk WHERE  mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir) mk 
		// ON (mk.`nmkrynew`=pahirarkis.`nmkry` AND mk.`tglLahirKaryawannew`=pahirarkis.`tglLahirKaryawan`) ORDER BY pahirarkis.`nmkry`";
		//var_dump($querytext);exit();
		$query=$this->Asset->query($querytext);

		//var_dump($query);exit();
		$jumQuery=count($query);
        $sum=ceil($jumQuery/$limit);

		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$Qtampil=$this->Asset->query($querytext." limit $start, $limit");

//var_dump($query);exit();
		$no=$start+1;
		$txtHead="<tr>
			<td align='center'>NO</td>
			<td align=\"center\">NIK KARYAWAN</td>
			<td align=\"center\">NAMA KARYAWAN</td>
			</tr>";
		if($jumQuery==0 || $jumQuery==Null){
			$txtData="
			<tr>
			<td colspan=\"9\" style=\"text-align:center;\"> Empty data </td>
			</tr>";
			return $txtHead."^".$txtData."^".$linkHal."^".$periode."^".$NIKUSERLOGIN."^".$NAMAUSERLOGIN."^".$TGLLAHIRUSERLOGIN."^";
		}

		$sebagai='';
		foreach($Qtampil as $dataRow){
			$idkry				= $dataRow['pahirarkis']['idkry'];
			$nikkry     		= $dataRow['pahirarkis']['nikkry'];
			$nmkry      		= $dataRow['pahirarkis']['nmkry'];
			$tglLahirKaryawan	= $dataRow['pahirarkis']['tglLahirKaryawan'];
			$sebagaival	= $dataRow['pahirarkis']['sebagai'];
			if($sebagaival=='kabag'){
				$sebagai='KEPALA BAGIAN';
			}else{
				$sebagai='KEPALA DEPARTEMENT';
			}
			//var_dump($sebagai);exit();


			$txtData.="<tr id=\"tr$nikkry\" class=\"tab\"><td align=\"center\">$no</td>";
			$txtData.="<td align=\"center\">$nikkry</td>";
			$txtData.="<td align=\"left\">$nmkry</td>";
			$txtData.="<td align=\"left\">
			<input type=\"hidden\" class='atasanSbg' name=\"atasanSbg\" value=\"$sebagaival\">
			<input type=\"hidden\" name=\"kryID\" value=\"$idkry\">
			<input type=\"hidden\" name='tdnikkry' value=\"$nikkry\">
			<input type=\"hidden\" name='tdnamakry' value=\"$nmkry\">
			<input type=\"hidden\" name='tdtgllahirkry' value=\"$tglLahirKaryawan\">
			</td></tr>";
			//$txtData.="<td align=\"left\"><input type=\"hidden\" name=\"inpNik\" value=\"$nikkry\"></td></tr>";
			//$txtData.="<td align=\"left\" style='display:none;'></td></tr>";
			$no++;
        }


		
		

		echo $txtHead."^".$txtData."^".$linkHal."^".$periode."^".$NIKUSERLOGIN."^".$NAMAUSERLOGIN."^".$TGLLAHIRUSERLOGIN."^".$sebagai."^".$iduserlogin;

	}

	function setData(){
		$this->autoRender = false;
		$this->loadModel('User');
		//variable kosong
		$txtData='';
		//load model db
		$this->loadModel('Asset');

		//$nik 	=$_POST['nik'];
		$periode		=$_POST['periode'];
		$sebagai		=$_POST['sebagai'];
		$idkry 			= $_POST['kryID'];
		$nikkry 		= $_POST['nikkry'];
		$namakry 		= $_POST['namakry'];
		$tgllahirkry 	= $_POST['tgllahirkry'];

		//$periode= $_POST['periode'];
		//var_dump($nik);exit();
		
		//ambil data karyawan
		$txtData='';
		
		//$queryKaryawan="SELECT * FROM kpireg.`pamasterkaryawans` mk WHERE id='$idkry' limit 1";//get data karyawan from id 

		$queryKaryawan="SELECT * FROM absensi.`master_karyawan` mk WHERE namakry='$namakry' AND tgllahir='$tgllahirkry' ORDER BY id DESC limit 1";//get data karyawan from nama dan tanggal lahir 
		//$queryKaryawan="SELECT * FROM absensi.master_karyawan mk WHERE kodenik='$nik' limit 1";
		$query=$this->Asset->query($queryKaryawan);
		$jumQuery=count($query);
		if($jumQuery>1){
			return $txtData;
		}

		
		$nik 		=$query[0]['mk']['kodenik'];
		$namakry 	=$query[0]['mk']['namakry'];
		$tglmasuk 	=date('d-m-Y',strtotime($query[0]['mk']['tglmasuk']));
		$jabatan 	=$query[0]['mk']['jabatan'];
		$statuskry 	='';

		$txtData.=$idkry.'~'.$nik.'~'.$namakry.'~'.$tgllahirkry.'~'.$tglmasuk.'~'.$jabatan.'^';


		//cek query ada
		//$cekppkready=$this->Asset->query("SELECT * FROM kpireg.`papenilaikaryawans` ppk  WHERE ppk.idKry='$idkry' AND ppk.periode='$periode' AND ppk.`status` NOT IN ('atasan','finish','$sebagai')");// get data from id
		if($sebagai=='kabag'){
			$qKomentar=' AND  ppk.`komentarKabag` IS NULL';
		}
		if($sebagai=='kadep'){
			$qKomentar=' AND ppk.`komentarKadep` IS NULL';
		}

		//  $cekppkready=$this->Asset->query("SELECT * FROM kpireg.`papenilaikaryawans` ppk  WHERE ppk.namaKaryawan='$namakry' AND ppk.tglLahirKaryawan='$tgllahirkry' AND ppk.periode='$periode' AND ppk.`status` NOT IN ('atasan','finish','$sebagai')");// get data from nama dan tanggal lahir
		// var_dump("SELECT * FROM kpireg.`papenilaikaryawans` ppk  WHERE ppk.namaKaryawan='$namakry' AND ppk.tglLahirKaryawan='$tgllahirkry' AND ppk.periode='$periode' AND ppk.`status` NOT IN ('atasan','finish','$sebagai')");exit();
		
		$cekppkready=$this->Asset->query("SELECT * FROM kpireg.`papenilaikaryawans` ppk  WHERE ppk.`namaKaryawan`='$namakry' AND ppk.`tglLahirKaryawan`='$tgllahirkry' AND ppk.`periode`='$periode' ".$qKomentar);// get data from nama dan tanggal lahir
		
		$jumcekppkready=count($cekppkready);
		
		
		if($jumcekppkready<1){
			$txtData.="<div class=\"well well-lg\">Penilaian untuk nik $nik periode ini sudah dilakukan, untuk informasi detailnya bisa dilihat di laporan penilaian karyawan</div>";
			return $txtData;
		}
		$idPA=$cekppkready[0]['ppk']['id'];
		
		

		$queryKategori= $this->Asset->query("SELECT id, kategori FROM kpireg.`pabanksoals` ppkb WHERE ppkb.statusSoal='top'");
		$jumKategori=count($queryKategori);
		
		$n=1;
		$skor1=0;
		$skor2=0;
		foreach($queryKategori as $kategori){
			$kategoriLabel=$kategori['ppkb']['kategori'];
			$txtData.="<div class='panel panel-primary'>";
			$txtData.="<div class='panel-heading'><div class='row'>
			<div class='col-md-8'>".$n.".$kategoriLabel</div>
			<div class='col-md-2'></div>
			<div class='col-md-2'></div></div></div>";
			$txtData.="<div  class='panel-body table-responsive' style='height:300px;max-height: 300px;overflow-y:auto;padding:0 !important'>";
			
			$txtData.="<table class='table' width='100%' class='table' >";
			$txtData.="<thead>
			<tr>
			<th class='info'>No</th>
			<th class='info'>Soal</th>
			<th class='info'>Tingkat Penilaian</th><th class='info'>Skor</th></tr></thead><tbody>";

			$TotalSkor=0;

			// $detail="SELECT ppk.*,hn.tingkatpenilaian,hn.angka,bs.kategori,bs.id,bs.soal,bs.bobot,(hn.angka * hn.bobot) AS total FROM kpireg.`papenilaikaryawans` ppk 
			// 		INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
			// 		INNER JOIN kpireg.`pabanksoals` bs ON bs.id=hn.idsoal WHERE ppk.id='$idPA' AND bs.kategori='$kategoriLabel'";
			// var_dump($detail);exit();
			$detail="SELECT ppk.*,hn.id,hn.tingkatpenilaian,hn.angka,hn.kategori,hn.idsoal,hn.nmsoal,hn.bobot,(hn.angka * hn.bobot) AS total FROM kpireg.`papenilaikaryawans` ppk 
			INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
			WHERE ppk.id='$idPA' AND hn.kategori='$kategoriLabel'";

			

			$queryDetail=$this->Asset->query($detail);
			$jumDetail=count($queryDetail);
			if($jumDetail<1){
				return;
			}
			$i=1;
			
			foreach($queryDetail as $data){
				//var_dump($data);exit();
				$id					= $data['hn']['id'];
				$idSoal 			= $data['hn']['idsoal'];
				$soal       		= $data['hn']['nmsoal'];
				$bobot     			= $data['hn']['bobot'];
				$tingkatpenilaian	= $data['hn']['tingkatpenilaian'];
				$total 				= $data[0]['total'];
				$TotalSkor=(int)$TotalSkor+(int)$total;

				$txtData.="<tr><td>$i</td>";
				$txtData.="<td class='soal' width='65%'>$soal</td>";
				$txtData.="<td class='tingkatpenilaian'>$tingkatpenilaian</td>";
				$txtData.="<td class='total' align='right'>$total</td>";				
				$i++;
			}
			$txtData.="<tr><td colspan='3'><strong>total Skor</strong></td><td>$TotalSkor</td></tr>";
			$txtData.="</tbody></table>";
			$txtData.="</div></div>";
			$n++;
		}
		
		
		$txtData.="<div class='panel panel-primary'>
				 	<div class='panel-heading'>
				 		".$n.". Penilaian (Scooring) 
				 	</div>
					<div class='panel-body table-responsive'  style='height:300px;max-height: 300px;overflow-y:auto;padding:0 !important'>";
		$txtData.="<table class='table' width='100%' class='table'>";
		//$txtData.="<thead><tr><th></th><th>Skor Total</th><th>Formula</th><th>Skor Akhir</th></thead>";
		$totalAkhir=0;
		
		$j=1;
		foreach($queryKategori as $kategori){
			$idKategori=$kategori['ppkb']['id'];
			$kategoriHead=$kategori['ppkb']['kategori'];
			//var_dump("$NIKUSERLOGIN");exit();
			
			$grandTotal="SELECT SUM(hn.angka * hn.bobot) AS grandTotal ,hn.bobotKategori
						FROM kpireg.`papenilaikaryawans` ppk
						INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
						
						WHERE ppk.namaKaryawan='$namakry' AND ppk.`tglLahirKaryawan`='$tgllahirkry' AND ppk.`periode`='$periode' AND hn.kategori='$kategoriHead' 
						GROUP BY hn.kategori";
						//var_dump($grandTotal);exit();

			$querygrandTotal=$this->Asset->query($grandTotal);
			$skorTotalVal=(int)$querygrandTotal[0][0]['grandTotal'];
						
			$formula='x  x '.$querygrandTotal[0]['hn']['bobotKategori'];
			//var_dump($formula);exit();
			$grandTotal=$skorTotalVal  * 0.2 * (float)$querygrandTotal[0]['hn']['bobotKategori'];  
			// if($idKategori==1){
			// 	$grandTotal=$skorTotalVal  * 0.2 * 0.4;
			// 	$formula='x 0,2 x 0,4';
			// }else{
			// 	$grandTotal=$skorTotalVal  * 0.2 * 0.6;
			// 	$formula='x 0,2 x 0,6';
			// }
			$totalAkhir=(int)$totalAkhir+(int)$grandTotal;
			$txtData.="<tr><th width='5%'>$n.$j</th><th colspan='7'>$kategoriHead</th></tr>";
			$txtData.="<tr><td></td><td align='center'>Total Skor<span class='form-control'>$skorTotalVal</span></td><td style='vertical-align:middle;'>x</td><td style='vertical-align:middle;'>0,2</td><td style='vertical-align:middle;'>x</td><td align='center'>Bobot Nilai<span class='form-control'>".$querygrandTotal[0]['hn']['bobotKategori']."</span></td><td style='vertical-align:middle;text-align:center;'>Skor Akhir<br>$grandTotal</td></tr>";
			$j++;
		}
		
		//dengan periode
		//$querySkorAkhir=$this->Asset->query("SELECT * FROM kpireg.`paskorakhirs` ppks WHERE  ppks.batasBawah <= '$totalAkhir' AND ppks.batasAtas >='$totalAkhir' AND ppks.periode='$periode';");

		//tanpa periode
		$querySkorAkhir=$this->Asset->query("SELECT * FROM kpireg.`paskorakhirs` ppks WHERE  ppks.batasBawah <= '$totalAkhir' AND ppks.batasAtas >='$totalAkhir';");
			$keterangan=$querySkorAkhir[0]['ppks']['keterangan'];
			$txtData.="<tr><td></td><td colspan='3' align='right'><h3>Nilai Keseluruhan</h3>Keterangan</td><td colspan='3'><h3>$totalAkhir</h3>$keterangan</td></tr>";
			//var_dump($txtData);exit();

		$txtData.="</table>";
		$txtData.="</div>
					<div class='panel-footer'>
						
					</div>
				</div>";

			//tampil jawaban soal uraian
			$queryJSU=$this->Asset->query("SELECT *  FROM kpireg.`pahasilsoaluraians` ppkhs INNER JOIN kpireg.`pasoaluraians` ppksu ON ppksu.id=ppkhs.idsoal   WHERE ppkhs.idpa='$idPA'");
			$jumSoalUraian=count($queryJSU);
			if($jumSoalUraian>0){
				
				foreach($queryJSU AS $dataJSU){
					$n++;
					$idJSU 		 		=$dataJSU['ppkhs']['id'];
					$ppksuSoal 	 		=$dataJSU['ppksu']['soal'];
					$ppkhasilkomentar 	=$dataJSU['ppkhs']['hasilKomentar'];
					$txtData.="<div class='panel panel-primary'>";
					$txtData.="<div class='panel-heading'>".$n.". $ppksuSoal</div>";
					$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$ppkhasilkomentar</div>";
					$txtData.="</div>";
				}
				 	
			}
			
			$n=$n+1;

			if($sebagai=='kabag'){
				$headKomentar='Komentar kepala bagian (Comments from chief of division)';
			}
			if($sebagai=='kadep'){
				$headKomentar='Komentar Kepala Department (Comments from chief of department)';
			}
			// var_dump($headKomentar);exit();
			$txtData.="<input type='hidden' name='idPA' id='idPA' value='$idPA'>";
			$txtData.="<div class=\"alert alert-success\" role=\"alert\" style=\"margin: 15px 0;\"><strong>#</strong> Harap isi kolom komentar dibawah ini</div>";

			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'>".$n.". $headKomentar  </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'><textarea class='form-control' id='komentar' name='komentar' ></textarea></div>";
			$txtData.="</div>";
			$txtData.="<button type='button' class='btn btn-primary' onclick='simpan()' style='margin-top:15px;'> Simpan Komentar</button>";

		echo  $txtData;

		exit();

		//var_dump($jumcekppkready);exit();
	}

	function simpan(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
			try{
			$dataSource = $this->Asset->getdatasource();

			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");
			
			$date=date('Y-m-d H:i:s');
			$periode 				=$_POST['periode'];
			$idPA 					=$_POST['idPA'];
			$iduser 				=$_POST['iduser'];
			$nikuser 				=$_POST['nikuser'];
			$namauser 				=$_POST['namauser'];
			$sebagai 				=$_POST['sebagai'];

			$nikkry 				=$_POST['nikkry'];
			$namakry 				=$_POST['namakry'];
			$komentar 				=$_POST['komentar'];

			
			$insertppkhistoriapp=$this->Asset->query("INSERT INTO kpireg.`pahistoryapp` (idpa,nik,nama,tgl,sebagai,`status`)VALUES('$idPA','$nikuser','$namauser ','$date','$sebagai','approved')");
			//var_dump($_POST);exit();
			$cekAllHistory=$this->Asset->query("SELECT * FROM kpireg.`pahistoryapp` ppkhis WHERE ppkhis.idpa='$idPA'");
			$jmlRow=count($cekAllHistory);
			if($jmlRow>3){
				$statusApp='finish';
			}else{
				$statusApp=$sebagai;
			}
			// -- status='$statusApp',
			if($sebagai=='kabag'){
				$sql="UPDATE kpireg.`papenilaikaryawans`  SET 
                komentarKabag='$komentar'
                WHERE id = '$idPA' AND periode='$periode'";
                //var_dump($sql);exit();
                $this->Asset->query($sql);
			}
			// -- status='$statusApp',
			if($sebagai=='kadep'){
				$sql="UPDATE kpireg.`papenilaikaryawans`  SET 
                komentarKadep='$komentar '
                WHERE id = '$idPA' AND periode='$periode'";
                //var_dump($sql);exit();
                $this->Asset->query($sql);
			}

			//update table papenilaikaryawans
			  

            //insert history app
			
			echo "sukses";
			$dataSource->commit(); 
			}
			catch(Exception $e){
				var_dump($e->getTrace());
				$dataSource->rollback();
			}


	}

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

}
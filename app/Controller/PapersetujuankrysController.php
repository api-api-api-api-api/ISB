<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Pa Persetujuan Karyawan, ini menu di bagian karyawan
 *  referent DB kpireg
 */
class  PapersetujuankrysController extends AppController {
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


		// $idkry  			='2720';
		// $NIKUSERLOGIN 		="21906481";
		// $NAMAUSERLOGIN 		="GINANJAR ART MANGKUPARIHEN";
		// $TGLLAHIRUSERLOGIN	="1994-09-12";

		$idkry  			='';
		$NIKUSERLOGIN 		=$nikCari;
		$NAMAUSERLOGIN 		=$namaKaryawan;
		$TGLLAHIRUSERLOGIN	=$tglLahir;
		
		$txtData="";
		$hm=$_POST['hal'];
		$fungsi="getData";
		$limit=10;
		if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

		$periode="";
		$queryPeriode=$this->Asset->query("SELECT * FROM kpireg.paperiodepenilaians periode  WHERE periode.status='OPEN' ORDER BY periode.id");
		$jumQueryPeriode=count($queryPeriode);
		if($jumQueryPeriode<1){
			$periode="0";
			echo $periode."^".$NIKUSERLOGIN."^".$NAMAUSERLOGIN."^^^^^".$idkry;
			return;
		}
		
		//$jumKategori=count($queryPeriode);
		
		$periodeId=$queryPeriode[0]['periode']['id'];
		$periodeStart   =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeStart']));
		$periodeEnd     =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeEnd']));
		$tahun          =$queryPeriode[0]['periode']['tahun'];

		$periodeNama	=$queryPeriode[0]['periode']['namaPeriode'];
		$periode 		=$periodeNama.' ('.$periodeStart.' s/d '.$periodeEnd.') '.'^'.$periodeId;
		
		//query get data karyawan from masterkaryawan
		//$queryKaryawan="SELECT * FROM kpireg.pamasterkaryawans mk WHERE id='$idkry' limit 1";//query by idkry
		$queryKaryawan="SELECT * FROM absensi.`master_karyawan` mk WHERE namakry='$NAMAUSERLOGIN' AND tgllahir='$TGLLAHIRUSERLOGIN' ORDER BY id DESC limit 1";//get data karyawan by nama dan tanggal lahir
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
		
		$txtData="";
		//cek data ada
		//$queryTableUtama= $this->User->query("SELECT * FROM kpireg.papenilaikaryawans ppk WHERE ppk.idKry='$idkry' AND ppk.periode='$periodeId' AND status='atasan'");// get by idkry
		$queryTableUtama= $this->Asset->query("SELECT * FROM kpireg.papenilaikaryawans ppk WHERE ppk.`namaKaryawan`='$NAMAUSERLOGIN' AND ppk.`tglLahirKaryawan`='$TGLLAHIRUSERLOGIN' AND ppk.`periode`='$periodeId'");// get by nama dan tanggal lahir
		//var_dump("SELECT * FROM kpireg.papenilaikaryawans ppk WHERE ppk.`namaKaryawan`='$NAMAUSERLOGIN' AND ppk.`tglLahirKaryawan`='$TGLLAHIRUSERLOGIN' AND ppk.`periode`='$periodeId'");exit();
		$jumQueryTU=count($queryTableUtama);
		
		if($jumQueryTU<1){
			$txtDataKomentar="";
			$txtData="<div class=\"well well-lg\">Tidak ada penilaian untuk NIK : $nik</div>";
			echo $periode."^".$nik."^".$namakry."^".$tglmasuk."^".$jabatan."^".$txtData."^".$txtDataKomentar;
			return;

		}else{
			//$queryTableUtama= $this->User->query("SELECT * FROM kpireg.papenilaikaryawans ppk WHERE ppk.idKry='$idkry' AND ppk.periode='$periodeId' AND status='atasan'");// get by idkry
			$idPA=$queryTableUtama[0]['ppk']['id'];
			
			$queryHistoriKaryawan=$this->Asset->query("SELECT * FROM kpireg.pahistoryapp pahis WHERE pahis.`idpa`='$idPA' AND pahis.`sebagai`='karyawan' AND pahis.`status`='approved'");
			//$queryTableUtama1= $this->Asset->query("SELECT * FROM kpireg.papenilaikaryawans ppk WHERE ppk.`namaKaryawan`='$NAMAUSERLOGIN' AND ppk.`tglLahirKaryawan`='$TGLLAHIRUSERLOGIN' AND ppk.`periode`='$periodeId' AND ppk.`status`='atasan'");// get by nama dan tanggal lahir
			$jumQueryTU1=count($queryHistoriKaryawan);
			if($jumQueryTU1>0){
				$txtDataKomentar="";
				$txtData="<div class=\"well well-lg\">Terima kasih sudah mengkonfirmasi di form ini</div>";
				echo $periode."^".$nik."^".$namakry."^".$tglmasuk."^".$jabatan."^".$txtData."^".$txtDataKomentar;
				return;
			}
			// else{
			// 	$idPA=$queryTableUtama1[0]['ppk']['id'];
			// }

		}
		
		
		//var_dump($idPPK);exit();
		
		

		$queryKategori= $this->Asset->query("SELECT id, kategori FROM kpireg.pabanksoals ppkb WHERE ppkb.statusSoal='top'");
		$jumKategori=count($queryKategori);
		$n=1;
		$skor1=0;
		$skor2=0;
		
		foreach($queryKategori as $kategori){
			$kategoriLabel=$kategori['ppkb']['kategori'];
			$collapsed='';
			if($n==1){$collapsed='in';}
			
			$txtData.="<div class='panel panel-primary panelCheck'>";
			$txtData.="<div class='panel-heading' role='tab' >
							<h4 class='panel-title'>
								<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseOne$n' aria-expanded='true' aria-controls='collapseOne'>$n .$kategoriLabel</a>
							</h4>
						</div>
					<div  class='panel-collapse table-responsive'  role='tabpanel' aria-labelledby='headingOne$n' style='height:300px;max-height: 300px;overflow-y:auto;padding:0 !important'>";
			$txtData.="<table class='table' width='100%' class='table'>";
			$txtData.="<thead>
			<tr>
				<th class='info'>No</th>
				<th class='info'>Soal</th>
				<th class='info'>Tingkat Penilaian</th>
				<th class='info'>Skor</th>
			</tr></thead><tbody>";

			$TotalSkor=0;
			// $detail="SELECT ppk.*,hn.tingkatpenilaian,hn.angka,bs.kategori,bs.id,bs.soal,bs.bobot,(hn.angka * hn.bobot) AS total FROM kpireg.`papenilaikaryawans` ppk 
			// 		INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
			// 		INNER JOIN kpireg.`pabanksoals` bs ON bs.id=hn.idsoal WHERE ppk.id='$idPA' AND bs.kategori='$kategoriLabel'";

			$detail="SELECT ppk.*,hn.tingkatpenilaian,hn.idsoal,hn.angka,hn.kategori,hn.id,hn.nmsoal,hn.bobot,(hn.angka * hn.bobot) AS total FROM kpireg.`papenilaikaryawans` ppk 
			INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
			WHERE ppk.id='$idPA' AND hn.kategori='$kategoriLabel'";
			//var_dump($detail);exit();

			$queryDetail=$this->Asset->query($detail);
			
			$jumDetail=count($queryDetail);
			if($jumDetail<1){
				return;
			}

			
			$i=1;
			foreach($queryDetail as $data){
				
				//var_dump($data);exit();
				$id		 			= $data['hn']['id'];
				$idSoal 			= $data['hn']['idsoal'];
				$soal       		= $data['hn']['nmsoal'];
				$bobot     			= $data['hn']['bobot'];
				$tingkatpenilaian	= $data['hn']['tingkatpenilaian'];
				$total 				= $data[0]['total'];
				$TotalSkor=(float)$TotalSkor+(float)$total;

				$txtData.="<tr><td>$i</td>";
				$txtData.="<td class='soal'>$soal</td>";
				$txtData.="<td class='tingkatpenilaian'>$tingkatpenilaian</td>";
				$txtData.="<td class='total' align='right'>$total</td>";				
				$i++;
			}
			$txtData.="<tr><td colspan='3'><strong>total Skor</strong></td><td>$TotalSkor</td></tr>";
			$txtData.="</tbody></table>";
			$txtData.="</div></div>";
			$n++;
			
		}

		$txtData.="<div class='panel panel-info'>
				 	<div class='panel-heading'>
				 		".$n.". Penilaian (Scooring) 
				 	</div>
					<div class='panel-body'  style='overflow-y:auto;'>";
		$txtData.="<table class='table' width='100%' class='table'>";
		$txtData.="<thead><tr><th>Kategori penilaian</th><th>Skor Total</th><th>Formula</th><th>Skor Akhir</th></thead>";
		$totalAkhir=0;
		
		foreach($queryKategori as $kategori){
			$idKategori=$kategori['ppkb']['id'];
			$kategoriHead=$kategori['ppkb']['kategori'];
			
			$grandTotal="SELECT SUM(hn.angka * hn.bobot) AS grandTotal ,hn.bobotKategori
						FROM kpireg.papenilaikaryawans ppk
						INNER JOIN kpireg.`pahasilnilai` hn ON hn.idpa=ppk.id
						WHERE ppk.namaKaryawan='$NAMAUSERLOGIN' AND ppk.tglLahirKaryawan='$TGLLAHIRUSERLOGIN' AND ppk.periode='$periodeId' AND hn.kategori='$kategoriHead' 
						GROUP BY hn.kategori";
						
			$querygrandTotal=$this->Asset->query($grandTotal);
			
			$skorTotalVal=(int)$querygrandTotal[0][0]['grandTotal'];
			
			$formula='x 0,2 x '.$querygrandTotal[0]['hn']['bobotKategori'];
			//var_dump($formula);exit();
			$grandTotal=$skorTotalVal  * 0.2 * (float)$querygrandTotal[0]['hn']['bobotKategori'];  
			// if($idKategori==1){
				
			// 	$formula='x 0,2 x 0,4';
			// }else{
			// 	$grandTotal=$skorTotalVal  * 0.2 * 0.6;
			// 	$formula='x 0,2 x 0,6';
			// }
			
			$totalAkhir=(float)$totalAkhir+(float)$grandTotal;
			$txtData.="<tr><td>$kategoriHead</td><td>$skorTotalVal</td><td>$formula</td><td>$grandTotal</td></tr>";
		}
		
		//var_dump("SELECT * FROM kpireg.`paskorakhirs` ppks WHERE  ppks.batasBawah <= '$totalAkhir' AND ppks.batasAtas >='$totalAkhir' AND ppks.periode='$periodeId';");exit();
		//periode dihilangkan
		$querySkorAkhir=$this->Asset->query("SELECT * FROM kpireg.`paskorakhirs` ppks WHERE  ppks.batasBawah <= '$totalAkhir' AND ppks.batasAtas >='$totalAkhir' ");
		
			$keterangan=$querySkorAkhir[0]['ppks']['keterangan'];
			$txtData.="<tr><td colspan='3' align='right'><h3>Nilai Keseluruhan</h3>Keterangan</td><td><h3>$totalAkhir</h3>$keterangan</td></tr>";
			
			
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
					$txtData.="<div class='panel panel-info'>";
					$txtData.="<div class='panel-heading'>".$n.". $ppksuSoal</div>";
					$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$ppkhasilkomentar</div>";
					$txtData.="</div>";
				}
				 	
			}
			$n=$n+1;
			$txtDataKomentar="<input type='hidden' name='idPA' id='idPA' value='$idPA'>";
			$txtDataKomentar.="<div class=\"alert alert-success\" role=\"alert\"><strong>#</strong> Harap isi kolom komentar dibawah ini</div>";

			$txtDataKomentar.="<div class='panel panel-info'>";
			$txtDataKomentar.="<div class='panel-heading'>".$n.". Komentar dan usul-usul karyawan terhadap pelaksanaan kebijaksanaan (policy) perusahaan pada umumnya (Comments or suggestions from employee  reagrding general company's policy implementation) </div>";
			$txtDataKomentar.="<div class='panel-body'  style='overflow-y:auto;'><textarea class='form-control' id='komentarKaryawan' name='komentarKaryawan' ></textarea></div>";
			$txtDataKomentar.="</div>";


			$n=$n+1;
			$txtDataKomentar.="<div class='panel panel-info'>";
			$txtDataKomentar.="<div class='panel-heading'><div class='row'>
			<div class='col-md-8'>".$n.".Persetujuan Karyawan: Apakah Anda dapat menerima penilaian prestasi kerja ini? (Employee's Agreement: Do you able to accept this performance appraisal?)<input type='hidden' name='checkPersetujuan' id='checkPersetujuan' value=''></div>
			<div class='col-md-2'><input type='radio' name='pilihPersetujuan' value='Yes' onclick='pilih(this.value)'> Yes </div>
			<div class='col-md-2'><input type='radio' name='pilihPersetujuan' Value='No' onclick='pilih(this.value)'> No </div></div></div>";
			$txtDataKomentar.="<div class='panel-body'  style='overflow-y:auto;'><textarea class='form-control' id='keteranganKaryawan' name='keteranganKaryawan'  placeholder='If it is \"No, please explain:'></textarea></div>";
			$txtDataKomentar.="</div>";
			$txtDataKomentar.="<button type='button' class='btn btn-primary' onclick='simpan()' style='margin-top:15px;'> Simpan Komentar</button>";
			
			//var_dump($queryJSU);exit();


		//var_dump($queryDetail);exit();
		echo $periode."^".$nik."^".$namakry."^".$tglmasuk."^".$jabatan."^".$txtData."^".$txtDataKomentar."^".$idkry;
	}


	function tampilpenilaian(){
		$this->autoRender = false;
		$this->loadModel('User');
		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 


	}

	function simpan(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
			try{
			$dataSource = $this->Asset->getdatasource();

			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");
			//var_dump($_POST);exit();
			$date=date('Y-m-d H:i:s');
			$periode 				=$_POST['periode'];
			$idPA					=$_POST['idPA'];
			$iduser					=$_POST['iduser'];
			$nikkry 				=$_POST['nikkry'];
			$namakry 				=$_POST['namakry'];
			$komentarKaryawan 		=$_POST['komentarKaryawan'];
			$checkPersetujuan 		=$_POST['checkPersetujuan'];
			$keteranganKaryawan 	=$_POST['keteranganKaryawan'];

			//update table ppkpenilaikaryawans
			// $sql="UPDATE kpireg.`papenilaikaryawans`  SET 
            //     persetujuanKaryawan='$checkPersetujuan', 
            //     keteranganPersetujuan='$keteranganKaryawan',
            //     status='karyawan',
            //     komentarKaryawan='$komentarKaryawan'
            //     WHERE id = '$idPA' AND periode='$periode'";
            //     //var_dump($sql);exit();
            //    $this->Asset->query($sql);
			//status langsung finish
			$sql="UPDATE kpireg.`papenilaikaryawans`  SET 
                persetujuanKaryawan='$checkPersetujuan', 
                keteranganPersetujuan='$keteranganKaryawan',
                status='finish',
                komentarKaryawan='$komentarKaryawan'
                WHERE id = '$idPA' AND periode='$periode'";
                //var_dump($sql);exit();
               $this->Asset->query($sql);

            //insert history app
               //$insertppkhistoriapp=$this->Asset->query("INSERT INTO kpireg.`pahistoryapp` (idpa,iduser,nik,nama,tgl,sebagai,`status`)VALUES('$idPA','$iduser','$nikkry','$namakry ','$date','karyawan','approved')");
			   //tanpa id user
			   $insertppkhistoriapp=$this->Asset->query("INSERT INTO kpireg.`pahistoryapp` (idpa,nik,nama,tgl,sebagai,`status`)VALUES('$idPA','$nikkry','$namakry ','$date','karyawan','approved')");
			
			echo "sukses";
			$dataSource->commit(); 
			}
			catch(Exception $e){
				var_dump($e->getTrace());
				$dataSource->rollback();
			}


	}

}
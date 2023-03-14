<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  pahasilpenilaiansController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}


function detail(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		//variable kosong
		$txtData='';
		//load model db

		//$nik 	=$_POST['nik'];
		$periode		=$_POST['periode'];
		//$sebagai		=$_POST['sebagai'];
		$idkry 			= $_POST['kryID'];
		$nikkry 		= $_POST['nikkry'];
		$namakry 		= $_POST['namakry'];
		$tgllahirkry 	= $_POST['tgllahirkry'];

		//$periode= $_POST['periode'];
		//var_dump($_POST);exit();
		
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

		$cekppkready=$this->Asset->query("SELECT * FROM kpireg.`papenilaikaryawans` ppk  WHERE ppk.`namaKaryawan`='$namakry' AND ppk.`tglLahirKaryawan`='$tgllahirkry' AND ppk.`periode`='$periode' ");// get data from nama dan tanggal lahir
		
		$jumcekppkready=count($cekppkready);
		
		
		if($jumcekppkready<1){
			$txtData.="<div class=\"well well-lg\">Penilaian untuk nik $nik periode ini sudah dilakukan, untuk informasi detailnya bisa dilihat di laporan penilaian karyawan</div>";
			return $txtData;
		}
		$idPA=$cekppkready[0]['ppk']['id'];

		$komentarKryIsi=$cekppkready[0]['ppk']['komentarKaryawan'];
		$komentarAtasanIsi=$cekppkready[0]['ppk']['komentarAtasan'];
		$komentarKabagIsi=$cekppkready[0]['ppk']['komentarKabag'];
		$komentarKadepIsi=$cekppkready[0]['ppk']['komentarKadep'];
		$persetujuanKry=$cekppkready[0]['ppk']['persetujuanKaryawan'];
		if($persetujuanKry==''){
			$persetujuanKry="";
		}else{
			$persetujuanKry='<strong><h5><i class="fa fa-dot-circle-o" aria-hidden="true"></i> '.$persetujuanKry.'</h5></strong>';			
		}
		//$persetujuanKry=$cekppkready[0]['ppk']['persetujuanKaryawan'];
		$isiPersetujuan=$cekppkready[0]['ppk']['keteranganPersetujuan'];

		
		

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

			
			$headKry="Komentar dan usul-usul karyawan terhadap pelaksanaan kebijaksanaan (policy) perusahaan pada umumnya (Comments or suggestions from employee reagrding general company's policy implementation)";
			// var_dump($headKomentar);exit();
			
			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'>".$n.". $headKry  </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$komentarKryIsi</div>";
			$txtData.="</div>";
			$n=$n+1;
			$headPersetujuan="Persetujuan Karyawan: Apakah Anda dapat menerima penilaian prestasi kerja ini? (Employee's Agreement: Do you able to accept this performance appraisal?)";
			// var_dump($headKomentar);exit();
			
			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'><div class='row'><div class='col-xs-8'>".$n.". $headPersetujuan</div><div col-xs-3><strong>$persetujuanKry</strong></div></div> </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$isiPersetujuan</div>";
			$txtData.="</div>";
			$n=$n+1;
		
			// $persetujuanKry=$cekppkready[0]['ppk']['persetujuanKaryawan'];
			// $isiPersetujuan=$cekppkready[0]['ppk']['keteranganPersetujuan'];
			$headKomentar='Komentar atasan langsung (comments from direct boss/ supervisor)';
			// var_dump($headKomentar);exit();
			
			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'>".$n.". $headKomentar  </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$komentarAtasanIsi</div>";
			$txtData.="</div>";
			$n=$n+1;

			
			$headKomentarKabag='Komentar kepala bagian (Comments from chief of division)';
			// var_dump($headKomentar);exit();
			
			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'>".$n.". $headKomentarKabag  </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$komentarKabagIsi</div>";
			$txtData.="</div>";

			$n=$n+1;

			
			$headKomentarKadep='Komentar Kepala Department (Comments from chief of department)';
			// var_dump($headKomentar);exit();
			
			$txtData.="<div class='panel panel-info'>";
			$txtData.="<div class='panel-heading'>".$n.". $headKomentarKadep  </div>";
			$txtData.="<div class='panel-body'  style='overflow-y:auto;'>$komentarKadepIsi</div>";
			$txtData.="</div>";

			//var_dump($txtData);exit();
		echo  $txtData;

		exit();

		//var_dump($jumcekppkready);exit();
	}




public function getdata(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');


	
		//var_dump($_POST);exit();
      
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];

       	$periode=$_POST['periode'];
       	$filterdivisi=$_POST['filterdivisi'];
        $nikkry=$_POST['nikkry'];
        $userTampil=$_POST['userTampil'];
       
        
		if($this->Session->read('dpfdpl_groupId')=='37'){
			$qHrd='';
		}else{
			
				if($this->Session->read("dpfdpl_groupId")!=100){
			$sql = "SELECT users.namaUser,nama,masteridmkts.divisi,nik,ket FROM users LEFT JOIN uploadsales.masteridmkts ON users.namaUser=uploadsales.masteridmkts.id WHERE namaUser='".$this->Session->read('dpfdpl_namaUser')."' ORDER BY nama;";
			$result = $this->Asset->query($sql);
		
			if(count($result)>0){
				foreach($result  as $row){
					$rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row['masteridmkts']['nik']."'");
					if(count($rsKaryawan)<=0){
						$this->Asset->setDataSource('local');
						$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
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
				$this->Asset->setDataSource('local');
				$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
		   $namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
		   $tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
		   $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}



		 $iduserlogin='';
		$nikCari="";
		// $NAMAUSERLOGIN="DENNY ARDIA RAHMAN";
		// $TGLLAHIRUSERLOGIN="1985-03-14";
		$NIKUSERLOGIN=$nikCari;
		$NAMAUSERLOGIN=$namaKaryawan;
		$TGLLAHIRUSERLOGIN=$tglLahir;

			$qHrd=" AND a.`namaPenilai`='$NAMAUSERLOGIN' AND a.`tglLahirPenilai`='$TGLLAHIRUSERLOGIN'";
		}
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
		
		//$qHrd='';


		// $sql="SELECT c.jabatan,a.*,b.periodeStart,b.periodeEnd FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT * FROM absensi.`master_karyawan` mk  WHERE mk.tglkeluar >CURDATE() group by mk.namakry,mk.tgllahir)as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) $qHrd ";
		// $sql="SELECT c.jabatan,a.*,b.periodeStart,b.periodeEnd FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT * FROM absensi.`master_karyawan` mk  WHERE mk.tglkeluar >CURDATE() group by mk.namakry,mk.tgllahir)as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where b.id='$periode' and (c.kodedept like '%$filterdivisi%') and a.nikKaryawan like '%$nikkry%' group by a.nikKaryawan ".$qHrd." order by id desc  ";
		//update filter
		$filterdivisi=!empty($filterdivisi)? " WHERE ds.`namaDivisi`='$filterdivisi'":"";
		
		$sql="SELECT c.jabatan,a.*,b.periodeStart,b.periodeEnd FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT 
		ps.`namakry`,ps.`tgllahir`,bs.`namaJabatan` jabatan FROM kpireg.`paperuntukansoals` ps 
		INNER JOIN kpireg.`pabanksoals` bs ON bs.`id`=ps.`idSoal` 
		INNER JOIN kpireg.`padivisisoals` ds ON ds.`id`=bs.`divisiId` 
		INNER JOIN kpireg.`pajabatansoals` jab ON jab.`id`=bs.`jabatanId` $filterdivisi GROUP BY  ps.`namakry`,ps.`tgllahir`)as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where b.id='$periode'  and a.nikKaryawan like '%$nikkry%' $qHrd group by a.nikKaryawan order by id desc  ";
		//var_dump($sql);exit();
        
        
        //var_dump($sql);exit();
        $querysql=$this->Asset->query($sql);
        //var_dump($querysql);exit();
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->Asset->query($sql." limit $start, $limit");
		//var_dump($sql);exit();
        $n=$start+1;
        
        if($jumQuery==0 || $jumQuery==Null){
                
        $txtData=' <tr><td colspan="4"><center>Data masih kosong</center></td></tr>';
    

          }else{
          	$txtData="";
          	$no=1;
				foreach($rsTampil as $data){

					//var_dump();exit();
					

						$sql2="
SELECT ROUND((SELECT SUM(a.total * 0.2 * a.bobotKategori) FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."' AND a.bobotKategori=0.4),2) AS totalA,
ROUND((SELECT SUM(a.total * 0.2 * a.bobotKategori) FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."' AND a.bobotKategori=0.6),2) AS totalB,
SUM(a.total * 0.2 * a.bobotKategori) AS jumlahnilai FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."'";

				
						//$sql2="SELECT a.*,b.bobotTable,SUM(a.total * 0.2 * b.bobotTable) AS jumlahtotal FROM ppkhasilnilai AS a JOIN ppkbanksoals AS b ON a.idsoal=b.id WHERE a.idppk='".$data['a']['id']."'";
						$querysql2=$this->Asset->query($sql2);
						$jumlahnilai=0;
							foreach($querysql2 as $data2){
								//$hasilnilai=$data2['a']['angka']*$data2['a']['bobot'];
								$totalnilai=$data2[0]['jumlahnilai'];
								if($totalnilai==0 or $totalnilai==Null or $totalnilai==""){
										$totalnilai=0;
								}
							}
						//$totalnilai=$jumlahnilai*0.2;
						//$totalnilai=$totalnilai*$data2['b']['bobotTable'];
				

					$periodepenilaian=$data['b']['periodeStart']." sampai ".$data['b']['periodeEnd'];

					$hasilnilai="";
					$sql3="SELECT keterangan FROM kpireg.paskorakhirs as a WHERE batasAtas>='$totalnilai' ORDER BY batasBawah ASC LIMIT 1";
					$querysql3=$this->Asset->query($sql3);
					foreach($querysql3 as $data3){
						$hasilnilai=$data3['a']['keterangan'];
					}

					$txtData2="<table width='100%'>";
					$sql4="SELECT a.*,b.*,c.namaKaryawan FROM kpireg.pasoaluraians AS a JOIN kpireg.pahasilsoaluraians AS b ON a.id=b.idsoal JOIN kpireg.papenilaikaryawans AS c ON b.idpa = c.id where c.id='".$data['a']['id']."'";
					
					$querysql4=$this->Asset->query($sql4);
					$n=1;
					foreach($querysql4 as $data4){
						$txtData2.="<tr>";
						$txtData2.="<td ><b>".$n.". ".$data4['a']['soal']."</b></td>";
						$txtData2.="</tr>";
						$txtData2.="<tr>";
						$txtData2.="<td>".$data4['b']['hasilKomentar']."</td>";
						$txtData2.="</tr>";
						$n++;

					}
					$txtData2.="</table>";


				$karID="";
				$nikKar=$data['a']['nikKaryawan'];
				$nmKar=$data['a']['namaKaryawan'];
				$tglLahirKaryawan=$data['a']['tglLahirKaryawan'];
				$periode=$data['a']['periode'];
					
				$txtData.=" <tr>";
			//	$txtData.="<td><a onclick='tropen(".$no.")'>".$no."</a></td>";
				$txtData.="<td>".$no."</td>";
				$txtData.="<td>".$periodepenilaian."</td>";
				$txtData.="<td>".$data['a']['nikKaryawan']." - ".$data['a']['namaKaryawan']."</td>";
				$txtData.="<td>".$data['c']['jabatan']."</td>";
				$txtData.="<td>".$data['a']['namaPenilai']."</td>";
				$txtData.="<td>".(int)$totalnilai."</td>";
				$txtData.="<td>".$hasilnilai."</td>";

				$detail='detail("","'.$nikKar.'","'.$nmKar.'","'.$tglLahirKaryawan.'","'.$periode.'")';
				//$txtData.="<td><a onclick='tropen(".$no.")'>".$data['a']['status']."</a></td>";
				//$txtData.="<td><button type='button' class='btn btn-success btn-sm' onclick='hapus(".$data['a']['id'].")'>Hapus</button></td>";
				$cetakPdf='cetakpdf("'.$nikKar.'|'.$nmKar.'|'.$tglLahirKaryawan.'|'.$periode.'")';
				$txtData.="<td><button type='button'  id='' style='color:brown;font-size:11px;' class='btn btn-default btn-sm' onclick='$detail'><i class='fa fa-eye' aria-hidden='true'></i> Lihat Penilaian</button></td>";
				$txtData.="<td><button type='button'  id='' style='font-size:11px;' class='btn btn-danger btn-sm' onclick='$cetakPdf'><i class='fa fa fa-file-pdf-o' aria-hidden='true'></i>  Cetak</button></td>";
				$txtData.=" </tr>
				<tr id='tropen".$no."' class='trhide'>
					<td colspan='8'>".$txtData2."</td>
				</tr>";
					
		
			   $no++;
			}
		}
		  echo $txtData."!".$linkHal;
	}





public function caridata(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;
		
		$idUser=$this->Session->read('dpfdpl_userId');
	

		
      
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       	$periode=$_POST['periode'];
       	$filterdivisi=$_POST['filterdivisi'];
        $nikkry=$_POST['nikkry'];
        $userTampil=$_POST['userTampil'];

		
/*
        		$iduserlogin='';
				$NIKUSERLOGIN="";
				$NAMAUSERLOGIN="DENNY ARDIA RAHMAN";
				$TGLLAHIRUSERLOGIN="1985-03-14";
				*/

				
	
		// $namaKaryawan="DENNY ARDIA RAHMAN";
		// $tglLahir="1985-03-14";
				


        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}



        if($this->Session->read('dfpdpl_groupId')=='37'){
				$qHrd='';
			}else{
				
			if($this->Session->read("dpfdpl_groupId")!=100){
			$sql = "SELECT users.namaUser,nama,masteridmkts.divisi,nik,ket FROM users LEFT JOIN uploadsales.masteridmkts ON users.namaUser=uploadsales.masteridmkts.id WHERE namaUser='".$this->Session->read('dpfdpl_namaUser')."' ORDER BY nama;";
			$result = $this->Asset->query($sql);
		
			if(count($result)>0){
				foreach($result  as $row){
					$rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row['masteridmkts']['nik']."'");
					if(count($rsKaryawan)<=0){
						$this->Asset->setDataSource('local');
						$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
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
				$this->Asset->setDataSource('local');
				$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
		   $namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
		   $tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
		   $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}

		$NIKUSERLOGIN=$nikCari;
		$NAMAUSERLOGIN=$namaKaryawan;
		$TGLLAHIRUSERLOGIN=$tglLahir;

				$qHrd=" AND a.`namaPenilai`='$NAMAUSERLOGIN' AND a.`tglLahirPenilai`='$TGLLAHIRUSERLOGIN'";
		}
		

		//$sql="SELECT c.jabatan,a.*,b.periodeStart,b.periodeEnd FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join kpireg.pamasterkaryawans as c on a.idKry=c.id where b.id=$periode and c.kodedept like '%$filterdivisi%' and a.nikKaryawan like '%$nikkry%'order by id desc";
/*
				$sql="SELECT a.*,b.periodeStart,b.periodeEnd,c.kodedept as kdep,c.tglmasuk,c.jabatan  FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT * FROM kpireg.pamasterkaryawans mk WHERE mk.tglkeluar >CURDATE() ) as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where b.id=$periode and (c.kodedept like '%$filterdivisi%') and a.nikKaryawan like '%$nikkry%' group by a.nikKaryawan order by id desc";
				*/





		$sql="SELECT c.jabatan,a.*,b.periodeStart,b.periodeEnd FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT * FROM absensi.`master_karyawan` mk  WHERE mk.tglkeluar >CURDATE() group by mk.namakry,mk.tgllahir)as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where b.id=$periode and (c.kodedept like '%$filterdivisi%') and a.nikKaryawan like '%$nikkry%' group by a.nikKaryawan ".$qHrd." order by id desc  ";

		

       

        //var_dump($sql);exit();
        
        //var_dump($sql);exit();
        $querysql=$this->Asset->query($sql);
        //var_dump($querysql);exit();
        $jumQuery=count($querysql);
        $sum=ceil($jumQuery/$limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->Asset->query($sql." limit $start, $limit");
        $n=$start+1;
        
        if($jumQuery==0 || $jumQuery==Null){
                
        $txtData=' <tr><td colspan="4"><center>Data masih kosong</center></td></tr>';
    

          }else{
          	$txtData="";
          	$no=1;
				foreach($rsTampil as $data){

					//var_dump();exit();
						$totalnilai="belum keluar";

			$sql2="SELECT ROUND((SELECT SUM(a.total * 0.2 * a.bobotKategori) FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."' AND a.bobotKategori=0.4),2) AS totalA,
			ROUND((SELECT SUM(a.total * 0.2 * a.bobotKategori) FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."' AND a.bobotKategori=0.6),2) AS totalB,
			SUM(a.total * 0.2 * a.bobotKategori) AS jumlahnilai FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."'";


						//$sql2="SELECT a.*,b.bobotTable,SUM(a.total * 0.2 * b.bobotTable) AS jumlahtotal FROM ppkhasilnilai AS a JOIN ppkbanksoals AS b ON a.idsoal=b.id WHERE a.idppk='".$data['a']['id']."'";
						$querysql2=$this->Asset->query($sql2);
						$jumlahnilai=0;
							foreach($querysql2 as $data2){
								//$hasilnilai=$data2['a']['angka']*$data2['a']['bobot'];
								$totalnilai=$data2[0]['jumlahnilai'];
								if($totalnilai==0 or $totalnilai==Null or $totalnilai==""){
										$totalnilai=0;
								}
							}
						//$totalnilai=$jumlahnilai*0.2;
						//$totalnilai=$totalnilai*$data2['b']['bobotTable'];
				
					$periodepenilaian=$data['b']['periodeStart']." sampai ".$data['b']['periodeEnd'];

					$hasilnilai="";
					$sql3="SELECT keterangan FROM kpireg.paskorakhirs as a WHERE batasAtas>=$totalnilai ORDER BY batasBawah ASC LIMIT 1";
					$querysql3=$this->Asset->query($sql3);
					foreach($querysql3 as $data3){
						$hasilnilai=$data3['a']['keterangan'];
					}

					$txtData2="<table width='100%'>";
					$sql4="SELECT a.*,b.*,c.namaKaryawan FROM kpireg.pasoaluraians AS a JOIN kpireg.pahasilsoaluraians AS b ON a.id=b.idsoal JOIN kpireg.papenilaikaryawans AS c ON b.idpa = c.id where c.id='".$data['a']['id']."'";
					$querysql4=$this->Asset->query($sql4);
					$n=1;
					foreach($querysql4 as $data4){
						$txtData2.="<tr>";
						$txtData2.="<td ><b>".$n.". ".$data4['a']['soal']."</b></td>";
						$txtData2.="</tr>";
						$txtData2.="<tr>";
						$txtData2.="<td>".$data4['b']['hasilKomentar']."</td>";
						$txtData2.="</tr>";
						$n++;

					}
					$txtData2.="</table>";



				$karID="";
				$nikKar=$data['a']['nikKaryawan'];
				$nmKar=$data['a']['namaKaryawan'];
				$tglLahirKaryawan=$data['a']['tglLahirKaryawan'];
				$periode=$data['a']['periode'];
					
				$txtData.=" <tr>";
			//	$txtData.="<td><a onclick='tropen(".$no.")'>".$no."</a></td>";
				$txtData.="<td>".$no."</td>";
				$txtData.="<td>".$periodepenilaian."</td>";
				$txtData.="<td>".$data['a']['nikKaryawan']." - ".$data['a']['namaKaryawan']."</td>";
				$txtData.="<td>".$data['c']['jabatan']."</td>";
				$txtData.="<td>".$data['a']['namaPenilai']."</td>";
				$txtData.="<td>".(int)$totalnilai."</td>";
				$txtData.="<td>".$hasilnilai."</td>";

				$detail='detail("","'.$nikKar.'","'.$nmKar.'","'.$tglLahirKaryawan.'","'.$periode.'")';
				//$txtData.="<td><a onclick='tropen(".$no.")'>".$data['a']['status']."</a></td>";
				//$txtData.="<td><button type='button' class='btn btn-success btn-sm' onclick='hapus(".$data['a']['id'].")'>Hapus</button></td>";
				$txtData.="<td><button type='button'  id='' style='color:brown;font-size:11px;' class='btn btn-default btn-sm' onclick='$detail'><i class='fa fa-eye' aria-hidden='true'></i> Lihat Penilaian</button></td>";
				$txtData.=" </tr>
				<tr id='tropen".$no."' class='trhide'>
					<td colspan='8'>".$txtData2."</td>
				</tr>";
					
		
			   $no++;
			}
		}
		  echo $txtData."!".$linkHal;
	}






public function cetakpdf(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;

		if($this->Session->read('dpfdpl_groupId')=='37'){
			$qHrd='';
		}else{
			
		//by user login atasan
		if($this->Session->read("dpfdpl_groupId")!=100){
			$sql = "SELECT users.namaUser,nama,masteridmkts.divisi,nik,ket FROM users LEFT JOIN uploadsales.masteridmkts ON users.namaUser=uploadsales.masteridmkts.id WHERE namaUser='".$this->Session->read('dpfdpl_namaUser')."' ORDER BY nama;";
			$result = $this->Asset->query($sql);
		
			if(count($result)>0){
				foreach($result  as $row){
					$rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row['masteridmkts']['nik']."'");
					if(count($rsKaryawan)<=0){
						$this->Asset->setDataSource('local');
						$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
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
				$this->Asset->setDataSource('local');
				$rsKaryawan=$this->Asset->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
		   $namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
		   $tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
		   $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}
		// $nikCari="";
		// $namaKaryawan="DENNY ARDIA RAHMAN";
		// $tglLahir="1985-03-14";
		$NIKUSERLOGIN=$nikCari;
		$NAMAUSERLOGIN=$namaKaryawan;
		$TGLLAHIRUSERLOGIN=$tglLahir;

			$qHrd=" AND a.`namaPenilai`='$NAMAUSERLOGIN' AND a.`tglLahirPenilai`='$TGLLAHIRUSERLOGIN'";
		}

       	$periode=$_GET['periode'];
       	$filterdivisi=$_GET['filterdivisi'];
       	$nikkry=$_GET['nikkry'];
       //	$filterdivisi=$_GET['filterdivisi'];

	   


	   if($periode==''){
			$periode='';
		}else{
			$periode=" a.periode='$periode' AND "; 
		}
		//$qHrd='';
		$filterdivisi=!empty($filterdivisi)? " WHERE ds.`namaDivisi`='$filterdivisi'":"";
       	//$sql="SELECT a.*,b.periodeStart,b.periodeEnd,c.kodedept as kdep,c.tglmasuk,c.jabatan  FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT * FROM absensi.`master_karyawan` mk  WHERE mk.tglkeluar >CURDATE() group by mk.namakry,mk.tgllahir) as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where $periode (c.kodedept like '%$filterdivisi%') and a.nikKaryawan like '%$nikkry%' $qHrd order by id desc";
		//var_dump($periode);exit();
		$sql="SELECT a.*,b.periodeStart,b.periodeEnd,c.divisi,c.jabatan  FROM kpireg.papenilaikaryawans AS a join kpireg.paperiodepenilaians as b on a.periode=b.id join (SELECT 
		ps.`namakry`,ps.`tgllahir`,ds.`namaDivisi` divisi,jab.`namaJabatan` jabatan FROM kpireg.`paperuntukansoals` ps 
		INNER JOIN kpireg.`pabanksoals` bs ON bs.`id`=ps.`idSoal` 
		INNER JOIN kpireg.`padivisisoals` ds ON ds.`id`=bs.`divisiId` 
		INNER JOIN kpireg.`pajabatansoals` jab ON jab.`id`=bs.`jabatanId` $filterdivisi 
		GROUP BY  ps.`namakry`,ps.`tgllahir`) as c on (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) where $periode a.nikKaryawan like '%$nikkry%' $qHrd order by id desc";
		//var_dump($sql);exit();
        $querysql=$this->Asset->query($sql);
		
		$txtData="";
		$no=1;
				
		if(count($querysql)==0){
			$data='<center>
					<p>
					Penilaian Prestasi Kerja<br>
					Untuk Supervisor ke Atas-Kantor Pusat<br>
					(Performance appraisal for supervisors to top-Office)<br>
					</p>
					<h1>TIDAK ADA DATA</h1>
					</center>';
			$this->set('data',$data);
			$this->render('cetakpdf');
			return;
		}
		//var_dump();exit();
        foreach($querysql as $data){

			//var_dump();exit();
        	$countkategori=1;
        	$listkategori="";
					$sql1b="SELECT DISTINCT(kategori) AS kategori, bobotKategori FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."'";
					$querysql1b=$this->Asset->query($sql1b);
					$totalnilai=0;
					$dataisi="";
					foreach($querysql1b as $data1b){
						$sql1bplus="SELECT ROUND(SUM(total * 0.2 * bobotKategori),2) AS total  FROM kpireg.pahasilnilai AS a WHERE a.idpa='".$data['a']['id']."' AND a.kategori='".$data1b['a']['kategori']."'";
						$querysql1bplus=$this->Asset->query($sql1bplus);
						foreach($querysql1bplus as $data1bplus){
							$totalnilai=$totalnilai+$data1bplus[0]['total'];
							$dataisi.="<tr><td colspan='3'>".$data1b['a']['kategori']."</td><td colspan='2'>".$data1bplus[0]['total']."</td></tr>";
						}	
					}

					/*
				
					$datakategori=explode("@@",$listkategori);
					$cdatakategori=count($datakategori);
					for ($x = 0; $x <= $cdatakategori; $x++) {
					  	
					  	$totalnilai=val($totalnilai)+val($datakategori[$x]);
					}
					*/
					//$NilaiA=40;
					//$NilaiB=30;

					if($totalnilai==0 || $totalnilai==Null || $totalnilai==""){
						$totalnilai=0;
					}
					/*
						$sql2="
					SELECT ROUND((SELECT SUM(a.total * 0.2 * b.bobotTable) FROM performanceappraisal.pahasilnilai AS a JOIN performanceappraisal.pabanksoals AS b ON a.idsoal=b.id WHERE a.idpa='".$data['a']['id']."' AND b.bobotTable=0.4),2) AS totalA,
					ROUND((SELECT SUM(a.total * 0.2 * b.bobotTable) FROM performanceappraisal.pahasilnilai AS a JOIN performanceappraisal.pabanksoals AS b ON a.idsoal=b.id WHERE a.idpa='".$data['a']['id']."' AND b.bobotTable=0.6),2) AS totalB,
					SUM(a.total * 0.2 * b.bobotTable) AS jumlahnilai FROM performanceappraisal.pahasilnilai AS a JOIN performanceappraisal.pabanksoals AS b ON a.idsoal=b.id WHERE a.idpa='".$data['a']['id']."'";

						//$sql2="SELECT a.*,b.bobotTable,SUM(a.total * 0.2 * b.bobotTable) AS jumlahtotal FROM ppkhasilnilai AS a JOIN ppkbanksoals AS b ON a.idsoal=b.id WHERE a.idppk='".$data['a']['id']."'";
						$querysql2=$this->User->query($sql2);
						$jumlahnilai=0;
								$totalnilai="belum keluar";
							foreach($querysql2 as $data2){
								//$hasilnilai=$data2['a']['angka']*$data2['a']['bobot'];
								$NilaiA=$data2[0]['totalA'];
								$NilaiB=$data2[0]['totalB'];
								$totalnilai=$data2[0]['jumlahnilai'];
								if($totalnilai==0 or $totalnilai==Null or $totalnilai==""){
										$totalnilai=0;
								}
							}
							*/
						//$totalnilai=$jumlahnilai*0.2;
						//$totalnilai=$totalnilai*$data2['b']['bobotTable'];
			

					$periodepenilaian=date('d-m-Y',strtotime($data['b']['periodeStart']))." sampai ".date('d-m-Y',strtotime($data['b']['periodeEnd']));
					$hasilnilai="";
					
					$sql3="SELECT keterangan FROM kpireg.paskorakhirs as a WHERE batasAtas>=$totalnilai ORDER BY batasBawah ASC LIMIT 1";
					$querysql3=$this->Asset->query($sql3);
					foreach($querysql3 as $data3){
						$hasilnilai=$data3['a']['keterangan'];
					}
					$dataisi.="<tr><td colspan='3'>Total Nilai: </td><td colspan='2'> ".(int)$totalnilai." / ".$hasilnilai."</td></tr>";
					$txtData2="<table width='100%'>";
					$sql4="SELECT a.*,b.*,c.namaKaryawan FROM kpireg.pasoaluraians AS a JOIN kpireg.pahasilsoaluraians AS b ON a.id=b.idsoal JOIN kpireg.papenilaikaryawans AS c ON b.idpa = c.id where c.id='".$data['a']['id']."'";
					$querysql4=$this->Asset->query($sql4);
					$n=1;
					foreach($querysql4 as $data4){
						$txtData2.="<tr>";
						$txtData2.="<td ><b>".$n.". ".$data4['a']['soal']."</b></td>";
						$txtData2.="</tr>";
						$txtData2.="<tr>";
						$txtData2.="<td>".$data4['b']['hasilKomentar']."</td>";
						$txtData2.="</tr>";
						$n++;
					}
					$txtData2.="</table>";
					/*
					if(floatval($totalnilai)<floatval(39)){
						$hasilnilai="Kurang";
					}elseif (floatval($totalnilai)>floatval(39) and floatval($totalnilai)<=floatval(59)) {
						$hasilnilai="Perlu Perbaiikan";
					}elseif (floatval($totalnilai)>floatval(59) and floatval($totalnilai)<=floatval(79)) {
						$hasilnilai="Cukup";
					}elseif (floatval($totalnilai)>floatval(79) and floatval($totalnilai)<=floatval(89)) {
						$hasilnilai="Diatas Cukup";
					}elseif (floatval($totalnilai)>floatval(89) and floatval($totalnilai)<=floatval(100)) {
						$hasilnilai="Istimewa";
					}
					*/
				$txtData.="<table border='1' style='border-collapse: collapse; font-size:12px;' width='100%'>
			        	<tr style='background-color: #bfbfbf'>
			        	<td width='5%'>No</td>
			        	<td width='25%'>Karyawan</td>
			        	<td width='20%' style='display:none'>Tgl Masuk</td>
			        	<td width='20%'>Jabatan</td>
			        	<td width='20%'>Divisi</td>
			        	<td width='20%' >Penilai</td>
			        	<td width='20%' style='display:none'>Nilai Sikap</td>
			        	<td width='20%' style='display:none'>Pelaksanaan Pekerjaan</td>
			        	<td width='20%' style='display:none'>Total Nilai</td>
			        	<td width='20%' style='display:none'>Hasil</td>
			        	</tr>";

				$txtData.=" <tr>";
				$txtData.="<td>".$no."</td>";
				$txtData.="<td>".$data['a']['nikKaryawan']." - ".$data['a']['namaKaryawan']."</td>";
				//$txtData.="<td style='display:none'>".$data['c']['tglmasuk']."</td>";
				$txtData.="<td>".$data['c']['jabatan']."</td>";
				$txtData.="<td>".$data['c']['divisi']."</td>";
				$txtData.="<td >".$data['a']['namaPenilai']."</td>";
				//$txtData.="<td style='display:none'>".$NilaiA."</td>";
				//$txtData.="<td style='display:none'>".$NilaiB."</td>";
				$txtData.="<td style='display:none'>".(int)$totalnilai."</td>";
				$txtData.="<td style='display:none'>".$hasilnilai."</td>";
				//$txtData.="<td><button type='button' class='btn btn-success btn-sm' onclick='hapus(".$data['a']['id'].")'>Hapus</button></td>";
				$txtData.=" </tr>";

				$txtData.="<tr>
			        	<td colspan='5' style='background-color: #bfbfbf'><center><b>Hasil Nilai</b></center></td>
			        	</tr>
			        
			        	".$dataisi."";	
	

				$txtData.="<tr>
			        	<td colspan='5' style='background-color: #bfbfbf'><center><b>Pertanyaan Tambahan</b></center></td>
			        	</tr>
			        	<tr>
			        	<td colspan='5'>
			        	".$txtData2."
			        	</td>
			        	</tr>
			        	</table><br>";	
			   $no++;
		}

$data="<center>
        	<p>
        	Penilaian Prestasi Kerja<br>
			Untuk Supervisor ke Atas - Kantor Pusat<br>
			(Performance appraisal for supervisors to top - Office)<br>
        	</p>
        	Periode ".$periodepenilaian."
        	</center>
			".$txtData."";
		$this->set('data',$data);
		$this->render('cetakpdf');
	}



	public function getperiode(){
	
		//$this->loadModel('Group');
		$this->loadModel('Asset');
		$this->autoRender = false;

       
		$sql="SELECT * FROM kpireg.paperiodepenilaians as a";
        $querysql=$this->Asset->query($sql);
     			$txtData="";
				foreach($querysql as $data){
					
				if ($data['a']['status']=='OPEN'){
					$selected='selected';
				}else{
					$selected='';
				}
				
				$txtData.="<option value='".$data['a']['id']."' $selected>".$data['a']['periodeStart']." sampai ".$data['a']['periodeEnd']."</option>";
			}
			//var_dump ($txtData);exit();
		echo $txtData;
		  
	}


		public function getfilterdivisi(){


	$this->loadModel('Asset');
		$this->autoRender = false;

       
		//$sql="SELECT kodedept FROM absensi.master_karyawan AS a GROUP BY a.kodedept";

		$sql="SELECT * FROM kpireg.padivisisoals AS a GROUP BY a.namaDivisi";
     
        $querysql=$this->Asset->query($sql);

  		 $txtdata=[];
    $txtdata[]=array('label'=>'-Please Select-','value'=>'^');
    foreach($querysql as $hsl){ 
      $txtdata[]= array('label'=>$hsl["a"]["namaDivisi"],'value'=>$hsl["a"]["namaDivisi"]);
      } 

    echo json_encode($txtdata);

	}


			public function getfilternamakry(){


	$this->loadModel('Asset');
		$this->autoRender = false;

       
		$sql="SELECT a.nikKaryawan ,a.namaKaryawan  FROM kpireg.papenilaikaryawans AS a JOIN kpireg.paperiodepenilaians AS b ON a.periode=b.id JOIN (SELECT * FROM absensi.master_karyawan mk  WHERE mk.tglkeluar >CURDATE() group by mk.namakry,mk.tgllahir) AS c ON (a.namaKaryawan=c.namakry AND a.tglLahirKaryawan=c.tgllahir) group by a.nikKaryawan";


        $querysql=$this->Asset->query($sql);

  		 $txtdata=[];
    $txtdata[]=array('label'=>'-Please Select-','value'=>'^');
    foreach($querysql as $hsl){ 
      $txtdata[]= array('label'=>$hsl["a"]["namaKaryawan"],'value'=>$hsl["a"]["nikKaryawan"]);
      } 

    echo json_encode($txtdata);

	}
	
	public function savedata(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$tglstart=$_POST['tglstart'];
			$tglend=$_POST['tglend'];
			$tahun = explode('-', $tglstart);


			$queryInsert="INSERT INTO kpireg.paperiodepenilaians (periodeStart,periodeEnd,tahun,status)VALUES('$tglstart','$tglend','$tahun[0]','aktif')";

			//echo $queryInsert;exit();

			$this->Asset->query($queryInsert);

			$dataSource->commit();
			echo "berhasil insert data";
		}catch(Exception $e){
			var_dump($e->getTrace());
			$dataSource->rollback();
		}
	}

		public function savedatauraian(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			
			$idUser=$this->Session->read('dpfdpl_userId');


			//get variable
			$soal=$_POST['soal'];
			$inputkomentar=$_POST['inputkomentar'];
			$inputpersetujuan=$_POST['inputpersetujuan'];
			$inputtanggal=$_POST['inputtanggal'];
			$inputsignature=$_POST['inputsignature'];
			$tambahkansoal=$_POST['tambahkansoal'];
			$tipesoal=$_POST['tipesoal'];
			$tanggalinput=date("Y-m-d H:i:s");

			$queryInsert="INSERT INTO kpireg.paperiodepenilaianuraians (soal,inputKomentar,inputPersetujuan,inputTanggal,inputSignature,tambahkanSoal,tanggalInput,'tipeSoal')VALUES('soal','$inputkomentar','$inputpersetujuan','$inputtanggal','$inputsignature','$tambahkansoal','$tanggalinput','$tipesoal')";

			//echo $queryInsert;exit();

			$this->Asset->query($queryInsert);

			$dataSource->commit();
			echo "berhasil insert data";
		}catch(Exception $e){
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
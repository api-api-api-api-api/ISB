<?php
App::uses('AppController', 'Controller');
/**
 *  Controller form penilaian 
 *  referent DB kpireg
 */
class  PaformsController extends AppController {
	public $components = array('Function','Paginator');
	public function index(){
		echo $this->Function->cekSession($this);
	}

	function getData(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		$this->loadModel('User');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

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

		$NIKUSERLOGIN=$nikCari;
		$NAMAUSERLOGIN=$namaKaryawan;
		$TGLLAHIRUSERLOGIN=$tglLahir;

		$iduserlogin='';
		$NIKUSERLOGIN="2010494";
		$NAMAUSERLOGIN="FENURIA HASAN";
		$TGLLAHIRUSERLOGIN="1982-02-10";

		
		
		$periode="";
		$queryPeriode=$this->Asset->query("SELECT * FROM kpireg.`paperiodepenilaians` periode  WHERE periode.`status`='OPEN' ORDER BY periode.id");
		$jumKategori=count($queryPeriode);

		if($jumKategori<1){
			$periode='close';
			echo $periode;
			exit();
		}

		//var_dump($queryPeriode);exit();
		$periodeId=$queryPeriode[0]['periode']['id'];
		$namaPeriode=$queryPeriode[0]['periode']['namaPeriode'];
		$periodeStart   =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeStart']));
		$periodeEnd     =date('d-m-Y',strtotime($queryPeriode[0]['periode']['periodeEnd']));
		$tahun          =$queryPeriode[0]['periode']['tahun'];

		//$periode 		= $periodeStart.' s/d '.$periodeEnd.' ('.$tahun.')^'.$periodeId;
		$periode		= $namaPeriode.' ('.$periodeStart.' s/d '.$periodeEnd.')^'.$periodeId;


		$txtData="";
		$hm=$_POST['hal'];
		$fungsi="getData";
		$limit=10;
		if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

		//query sementara get bawahan
		//$querytext="SELECT * FROM kpireg.`pahirarkis` WHERE idatasan='$iduserlogin' AND sebagai='atasan' ;";//by id atasan
		//$querytext="SELECT * FROM kpireg.`pahirarkis` WHERE nmatasan='$NAMAUSERLOGIN' AND tglLahirAtasan='$TGLLAHIRUSERLOGIN' AND sebagai='atasan'";//by nama dan tanggal lahir 
		$querytext="SELECT * FROM (SELECT * FROM kpireg.`pahirarkis` WHERE nmatasan='$NAMAUSERLOGIN' AND tglLahirAtasan='$TGLLAHIRUSERLOGIN' AND sebagai='atasan')pahirarkis LEFT JOIN (SELECT SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idkrynew, SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikkrynew,mk.namakry AS nmkrynew,mk.tgllahir AS tglLahirKaryawannew FROM absensi.master_karyawan mk WHERE  mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir) mk 
		ON (mk.`nmkrynew`=pahirarkis.`nmkry` AND mk.`tglLahirKaryawannew`=pahirarkis.`tglLahirKaryawan`) ORDER BY pahirarkis.`nmkry`";
		//var_dump($querytext);exit();
		$query=$this->Asset->query($querytext);

		$jumQuery=count($query);
        $sum=ceil($jumQuery/$limit);

		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$Qtampil=$this->Asset->query($querytext." limit $start, $limit");

		$no=$start+1;
		$txtHead="<tr>
			<td align='center'>NO</td>
			<td align=\"center\">NIK KARYAWAN</td>
			<td align=\"center\">NAMA KARYAWAN</td>
			</tr>";
		if($jumQuery==0 || $jumQuery==Null){
			$txtData="
			<tr>
			<td colspan=\"9\" style=\"text-align:center;\">--Tidak ada karyawan yang dinilai--</td>
			</tr>";
			return $txtHead."^".$txtData."^".$linkHal."^".$periode."^";
		}

		
		foreach($Qtampil as $dataRow){			
			$idkry				= $dataRow['mk']['idkrynew'];
			$nikkry 			= $dataRow['mk']['nikkrynew'];
			$nmkry      		= $dataRow['pahirarkis']['nmkry'];
			$tglLahirKaryawan	= $dataRow['pahirarkis']['tglLahirKaryawan'];
			//$queryReadySoal=$this->Asset->query("SELECT * FROM kpireg.`paperuntukansoals` WHERE idkry='$idkry' ");//query set soal bawahan  by id cek ada atau tidak
			$queryReadySoal=$this->Asset->query("SELECT * FROM kpireg.`paperuntukansoals` WHERE namakry='$nmkry' AND tgllahir='$tglLahirKaryawan'");//query set soal bawahan  by nama tanggal lahir cek ada atau tidak
			$cekDataAda=count($queryReadySoal);
			if($cekDataAda<1){
				continue;
			}

			$txtData.="<tr id=\"tr$idkry\" class=\"tab\"><td align=\"center\">$no</td>";
			$txtData.="<td align=\"center\">$nikkry</td>";
			$txtData.="<td align=\"left\">$nmkry</td>";
			//$txtData.="<td align=\"left\"><input type=\"hidden\" name=\"inpNik\" value=\"$nikkry\"></td></tr>";
			$txtData.="<td align=\"left\" style='display:none;'>
			<input type=\"hidden\" name='tdidkry' value=\"$idkry\">
			<input type=\"hidden\" name='tdnikkry' value=\"$nikkry\">
			<input type=\"hidden\" name='tdnamakry' value=\"$nmkry\">
			<input type=\"hidden\" name='tdtgllahirkry' value=\"$tglLahirKaryawan\"></td></tr>";
			$no++;
        }


		



		echo $txtHead."^".$txtData."^".$linkHal."^".$periode."^".$NIKUSERLOGIN."^".$NAMAUSERLOGIN."^".$iduserlogin."^".$TGLLAHIRUSERLOGIN;

	}

	public function crud(){
		$this->autoRender = false;
		$this->loadModel('Asset');
		try{
			$dataSource = $this->Asset->getdatasource();
			$dataSource->begin();
			 date_default_timezone_set("Asia/Jakarta");
			//var_dump($_POST);exit();
			
			$periode 				=$_POST['periode'];
			$iduser 				=$_POST['iduser'];
			$nikuser 				=$_POST['nikuser'];
			$namauser 				=$_POST['namauser'];
			$tgllahiruser 			=$_POST['tgllahiruser'];
			$idkry 					=$_POST['idkry'];
			$nikkry 				=$_POST['nikkry'];
			$namakry 				=$_POST['namakry'];
			$tgllahirkry 			=$_POST['tgllahirkry'];
			$txtKomentarAtasan		=$_POST['txtKomentarAtasan'];
			$ketidakhadiranmonth	=$_POST['ketidakhadiranmonth'];
			$ketidakhadiranday		=$_POST['ketidakhadiranday'];

			$date=date('Y-m-d H:i:s');
			$jumSoal=count($_POST['idSoal']);

			
			$tingkatpenilaian = array("1"=>"Tidak Memuaskan (Not Satisfactory)", "2"=>"Perlu Perbaikan (Needs improvement)", "3"=>"Cukup (Adequate)","4"=>"Memuaskan (Satisfactory)","5"=>"Sangat Memuaskan (Very satisfactory)");
			if($jumSoal>0){

				$insertpapenilaikaryawans="INSERT INTO kpireg.`papenilaikaryawans` (nikPenilai,namaPenilai,idKry,nikKaryawan,namaKaryawan,`status`,dateCreate,periode,komentarAtasan,tglLahirPenilai,tglLahirKaryawan,tdkHadirBln,tdkHadirHari)VALUES('$nikuser','$namauser','$idkry','$nikkry','$namakry','atasan','$date','$periode','$txtKomentarAtasan','$tgllahiruser','$tgllahirkry','$ketidakhadiranmonth','$ketidakhadiranday')";

				//var_dump($insertpapenilaikaryawans);exit();
				$this->Asset->query($insertpapenilaikaryawans);

				//ambil pa id dari papenilaikaryawan yang baru di input
				//$getId=$this->Asset->query("SELECT id FROM kpireg.`papenilaikaryawans` WHERE idPenilai='$iduser' AND idKry='$idkry' AND status='atasan' AND periode='$periode' order by id desc limit 1");	//get by id penilai dan id karyawan	
				$getId=$this->Asset->query("SELECT id FROM kpireg.`papenilaikaryawans` WHERE namaPenilai='$namauser' AND tglLahirPenilai='$tgllahiruser' AND namaKaryawan='$namakry' AND tglLahirKaryawan='$tgllahirkry' AND status='atasan' AND periode='$periode' order by id desc limit 1");	//get by nama,tgl penilai dan nama,tanggal karyawan
				if(count($getId)>0){
					foreach($getId as $data){
						$idpa=$data["papenilaikaryawans"]["id"];
					}
				}
				//dengan idUser
				// $insertpahistoryapp=$this->Asset->query("INSERT INTO kpireg.pahistoryapp (idpa,iduser,nik,nama,tgl,sebagai,status)VALUES('$idpa','$iduser','$nikuser','$namauser','$date','atasan','approved')");

				//tanpa idUser
				$insertpahistoryapp=$this->Asset->query("INSERT INTO kpireg.pahistoryapp (idpa,nik,nama,tgl,sebagai,status)VALUES('$idpa','$nikuser','$namauser','$date','atasan','approved')");

				//input ke table hasilnilai
				
				foreach($_POST['idSoal'] as $soal){
					
					//$idSoal=$soal;
					$valueTp=$_POST['valueTp'.$soal];
					$tpstring=$tingkatpenilaian[$valueTp];
					$kategoriinsert=$_POST['kategori'.$soal];
					$bobotKategori=(float)$_POST['bobotKategori'.$soal];
					//var_dump($bobotKategori);exit();
					$nmsoal=$this->Function->replacequote($_POST['nmsoal'.$soal]);
					$bobot=$_POST['bobotVal'.$soal];
					$total=(int)$valueTp * (int)$bobot;

					//var_dump ($nmsoal);
					$inserthasilnilai="INSERT INTO kpireg.`pahasilnilai` (idpa,idsoal,nmsoal,tingkatpenilaian,angka,bobot,total,kategori,bobotKategori)VALUES('$idpa','$soal','$nmsoal','$tpstring','$valueTp','$bobot','$total','$kategoriinsert','$bobotKategori')";
					
					$this->Asset->query($inserthasilnilai);

				}
				
				//input ke table hasil soal uraian
				foreach($_POST["idSoalUraian"] as $soalUraian){
					$txtSoalUraian=$this->Function->replacequote($_POST['txtSoalUraian'.$soalUraian]);
					$inserthasilsoaluraian="INSERT INTO kpireg.`pahasilsoaluraians` (idpa,idsoal,hasilKomentar,tanggalInput)VALUES('$idpa','$soalUraian','$txtSoalUraian','$date')";
					
					$this->Asset->query($inserthasilsoaluraian);
				}
			}
			//;exit();
			echo "sukses";

			$dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }

	}

	public function setsoal()
	{
		$this->autoRender = false;
		$this->loadModel('Asset');
		//variable kosong
		$txtData='';
		//load model db
		$this->loadModel('Users');

		$idkry 	= $_POST['idkry'];
		$periode= $_POST['periode'];
		$namakry= $_POST['namakry'];
		$tgllahirkry= $_POST['tgllahirkry'];
		
		//$queryKaryawan="SELECT * FROM kpireg.`pamasterkaryawans` mk WHERE id='$idkry' limit 1";//get data karyawan by idkry

		$queryKaryawan="SELECT * FROM absensi.`master_karyawan` mk WHERE namakry='$namakry' AND tgllahir='$tgllahirkry' ORDER BY id DESC limit 1";//get data karyawan by nama dan tanggal lahir
		//var_dump($queryKaryawan);exit();
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

		$txtData.=$idkry.'~'.$nik.'~'.$namakry.'~'.$tglmasuk.'~'.$jabatan.'^';
		
		//cek data ready untuk periode penilaian sekarang
		//$queryCekDataReady="SELECT * FROM  kpireg.`papenilaikaryawans` ps WHERE ps.`idKry`='$idkry' AND periode='$periode'";// query data ready by idkry
		$queryCekDataReady="SELECT * FROM  kpireg.`papenilaikaryawans` ps WHERE ps.`namaKaryawan`='$namakry' AND tglLahirKaryawan='$tgllahirkry' AND periode='$periode'";// query data ready by nama dan tanggal lahir
		//var_dump($queryCekDataReady);exit();
		$queryCDR=$this->Asset->query($queryCekDataReady);
		$jumQueryCRR=count($queryCDR);
		//var_dump($jumQueryCRR);exit();
		if($jumQueryCRR>0){
			$txtData.="<div class=\"well well-lg\">Penilaian untuk nik $nik periode ini sudah dilakukan, untuk informasi detailnya bisa dilihat di laporan penilaian karyawan</div>";
			return $txtData;
		}
		
		//$queryperuntukan="SELECT * FROM  kpireg.`paperuntukansoals` ps WHERE ps.`idkry`='$idkry'";
		$queryperuntukan="SELECT * FROM  kpireg.`paperuntukansoals` ps WHERE ps.`namakry`='$namakry' AND tgllahir='$tgllahirkry' ";
		
		$queryP=$this->Asset->query($queryperuntukan);
		$jumQueryP=count($queryP);
		if($jumQueryP<1){
			$txtData.="<div class=\"well well-lg\">Tidak ada  penilaian untuk nik $nik</div>";
			return $txtData;
		}



		$txtData.="";

		//query form soal
		$queryKategori= $this->Asset->query("SELECT  * FROM kpireg.`pabanksoals` ppkb WHERE ppkb.statusSoal='top'");
		$jumKategori=count($queryKategori);
		
		$n=1;
		// $option="<option value='' selected> -----</option>
		// 	<option value='1'>Tidak Memuaskan (Not Satisfactory)</option>
		// 	<option value='2'>Perlu Perbaikan (Needs improvement)</option>
		// 	<option value='3'>Cukup (Adequate)</option>
		// 	<option value='4'>Memuaskan (Satisfactory)</option>
		// 	<option value='5'>Sangat Memuaskan (Very satisfactory)</option>";
		$txtData.="<div class='well'><u>Keterangan Poin :</u> <span> (<strong>5</strong>) Sangat Memuaskan (Very satisfactory).</span><span> (<strong>4</strong>) Memuaskan (Satisfactory).</span><span> (<strong>3</strong>) Cukup (Adequate).</span><span> (<strong>2</strong>) Perlu Perbaikan (Needs improvement).</span><span> (<strong>1</strong>) Tidak Memuaskan (Not Satisfactory)</span></div>";

		foreach($queryKategori as $kategori){
			$kategoriLabel 	=$kategori['ppkb']['kategori'];
			$bobotTable 	=$kategori['ppkb']['bobotTable'];
			$katId 	=$kategori['ppkb']['id'];

			$collapsed='';
			if($n==1){$collapsed='in';}
			
			$txtData.="<div class='panel panel-primary panelCheck'>";
			$txtData.="<div class='panel-heading' role='tab' id='headingOne$n'>
							<h4 class='panel-title'>
								<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseOne$n' aria-expanded='true' aria-controls='collapseOne'>$n .$kategoriLabel</a>
							</h4>
						</div>";
			// panel dengan scrol
			// <div class='panel-body table-responsive' id='returnValSK' style='height:500px;max-height: 500px;overflow-y:auto;'>
			$txtData.="<div class='panel-body table-responsive' id='returnValSK' style=''>
										<div class='col-md-12 divhead '><div class='row'>
											<div class='col-md-7'><div class='row'>
												<div class='col-md-1'>No</div>
												<div class='col-md-10'>Pertanyaan</div>
												<div class='col-md-1'>Bobot (Weight value)</div>
											</div></div>
											<div class='col-md-5'><div class='row'>
												<div class='col-xs-2 '>5</div>
												<div class='col-xs-2 '>4</div>
												<div class='col-xs-2 '>3</div>
												<div class='col-xs-2 '>2</div>
												<div class='col-xs-2 '>1</div>
												<div class='col-xs-2 '>Jml Nilai</div>
											</div></div>
										</div></div>";
			// $txtData.="<table class='table' width='100%' class='table' style='display:none;'>";
			// $txtData.="<thead><tr><th colspan='2' width='50%'></th>";
			// $txtData.="<th width='5%' >Bobot (Weight value)</th>";
			// $txtData.="<th>5</th><th>4</th><th>3</th><th>2</th><th>1</th></tr></thead><tbody>";
			$bobotTotal=0;
			//$querySoal="SELECT * FROM kpireg.`pabanksoals` bs INNER JOIN kpireg.`paperuntukansoals` ps ON ps.`idSoal`=bs.`id` WHERE   ps.`idkry`='$idkry' AND bs.`kategori`='$kategoriLabel'";

			$querySoal="SELECT * FROM kpireg.`pabanksoals` bs INNER JOIN kpireg.`paperuntukansoals` ps ON ps.`idSoal`=bs.`id` WHERE   ps.`namakry`='$namakry' AND tgllahir='$tgllahirkry' AND bs.`kategori`='$kategoriLabel' AND bs.`divisiId` IS NOT NULL AND bs.`divisiId`<>'' AND bs.`jabatanId` IS NOT NULL AND bs.`jabatanId`<>'' ";
			if($kategoriLabel=='Sikap (Attitude)'){
				$querySoal="SELECT * FROM kpireg.`pabanksoals` bs INNER JOIN kpireg.`paperuntukansoals` ps ON ps.`idSoal`=bs.`id` WHERE ps.`namakry`='$namakry' AND tgllahir='$tgllahirkry' AND bs.`kategori`='$kategoriLabel' ";
			}
			
			//echo $querySoal;exit();
			$sqlSoal=$this->Asset->query($querySoal);
			
			$i=1;
			$disabled='';
			$setIDTotalBobot='';
			$clsDisabled='';
			foreach($sqlSoal as $soaldata){
				$checked    ="";
				$idSoal 	= $soaldata['bs']['id']; 
				$soal       = $soaldata['bs']['soal'];
				$bobot      = $soaldata['bs']['bobot'];
				$tipesoal   = $soaldata['bs']['tipeSoal'];
				$bobotTotal=(int)$bobotTotal+(int)$bobot;
				$txtData.="<div class='col-md-12 trdiv trdiv$katId' style='border-bottom:1px solid #ddd;'><div class='row'>";
				$txtData.="<div class='col-md-7'><div class='row'>";
				$txtData.="<div class='col-md-1 tdisi column1'>".$i."</div>";
				$txtData.="<div class='tdisi column2' style='display:none'><input type='text' name='idSoal[]' id='idSoal".$idSoal."' value='$idSoal'/><textarea type='text' name='nmsoal".$idSoal."' id='nmSoal".$idSoal."'>$soal</textarea></div>";
				$txtData.="<div class='soal col-md-10 tdisi column3'>$soal</div>";
				if($bobot==''){
					$txtData.="<div class='bobot col-md-1 tdisi column4'><input type='text' name='bobotVal".$idSoal."' id='bobotVal".$idSoal."' value='0' class='roundIt$katId roundIt' onKeyUp='upAngka(this),cekTotalBobot(this,$katId);' maxlength='3'></div>";
					$disabled='disabled';
					$clsDisabled='aktif'.$katId;
				}else{
					$txtData.="<div class='bobot col-md-1 tdisi column4'>$bobot<input type='hidden' name='bobotVal".$idSoal."' id='bobotVal".$idSoal."' value='$bobot' class='roundIt$katId' onKeyUp='upAngka(this),cekTotalBobot(this,$katId)' maxlength='3'></div>";
				}
				
				$txtData.="</div></div>";
				$txtData.="<div class='col-md-5'><div class='row'>";
				$txtData.="<div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>5</label><input type='radio' name='pilihTp".$idSoal."' id='pilihTp".$idSoal."' value='5' onclick='tes(this.value,$idSoal,$katId)' class='radio form-control $clsDisabled' $disabled></div>";
				$txtData.="<div class='col-md-1-5 col-xs-2 '><label class='LabelPoin'>4</label><input type='radio' name='pilihTp".$idSoal."' id='pilihTp".$idSoal."' value='4' onclick='tes(this.value,$idSoal,$katId)' class='radio form-control $clsDisabled' $disabled></div>";
				$txtData.="<div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>3</label><input type='radio' name='pilihTp".$idSoal."' id='pilihTp".$idSoal."' value='3' onclick='tes(this.value,$idSoal,$katId)' class='radio form-control $clsDisabled' $disabled></div>"; 
				$txtData.="<div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>2</label><input type='radio' name='pilihTp".$idSoal."' id='pilihTp".$idSoal."' value='2' onclick='tes(this.value,$idSoal,$katId)' class='radio form-control $clsDisabled' $disabled></div>";
				$txtData.="<div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>1</label><input type='radio' name='pilihTp".$idSoal."' id='pilihTp".$idSoal."' value='1' onclick='tes(this.value,$idSoal,$katId)' class='radio form-control $clsDisabled' $disabled></div>";
				$txtData.="<div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>Jml Nilai</label><p class='lpoin$katId' id='jmlNilai".$idSoal."' style='margin:unset;font-size: large;font-weight: 700;'></p></div>";
				$txtData.="<div class='col-xs-2 tp' style='display:none;'><input type='text' name='valueTp".$idSoal."' id='valueTp".$idSoal."'></div>";
				$txtData.="<div class='col-xs-2 tp' style='display:none;'><input type='text' name='kategori".$idSoal."'  id='kategoriTp".$idSoal."' value='".$kategoriLabel."'></div>";
				$txtData.="<div class='col-xs-2 tp' style='display:none;'><input type='text' name='bobotKategori".$idSoal."'  id='bobotKategoriTp".$idSoal."' value='".$bobotTable."'></div>";
				
				$txtData.="</div></div>";
				$txtData.="</div></div>";

				
				// $txtData.="<tr><td>$i</td>";
				// $txtData.="<td style='display:none' width='10%'><input type='text' name='idSoal[]' id='idSoal".$idSoal."' value='$idSoal'/><textarea type='text' name='nmsoal".$idSoal."'' id='nmSoal".$idSoal."'>$soal</textarea></td>";
				// $txtData.="<td class='soal'>$soal </td>";
				// $txtData.="<td class='bobot'>$bobot<input type='text' name='bobotVal".$idSoal."' id='bobotVal".$idSoal."' value='$bobot' ></td>";
				// //$txtData.="<td class='tp'><select name='pilihTp' id='pilihTp".$idSoal."' class='form-control'>".$option."</select></td></tr>";
				// $txtData.="<td class='tp'><input type='radio' name='pilihTp".$idSoal."'' id='pilihTp".$idSoal."' value='5' onclick='tes(this.value,$idSoal)' class='radio'></td>";
				// $txtData.="<td class='tp'><input type='radio' name='pilihTp".$idSoal."'' id='pilihTp".$idSoal."' value='4' onclick='tes(this.value,$idSoal)' class='radio'></td>";
				// $txtData.="<td class='tp'><input type='radio' name='pilihTp".$idSoal."'' id='pilihTp".$idSoal."' value='3' onclick='tes(this.value,$idSoal)' class='radio'></td>";
				// $txtData.="<td class='tp'><input type='radio' name='pilihTp".$idSoal."'' id='pilihTp".$idSoal."' value='2' onclick='tes(this.value,$idSoal)' class='radio'></td>";
				// $txtData.="<td class='tp'><input type='radio' name='pilihTp".$idSoal."'' id='pilihTp".$idSoal."' value='1' onclick='tes(this.value,$idSoal)' class='radio'></td>";
				// $txtData.="<td class='tp' style='display:block'><input type='text' name='valueTp".$idSoal."' id='valueTp".$idSoal."'></td>";
				// $txtData.="<td class='tp' style='display:block'><input type='text' name='kategori".$idSoal."'  id='kategoriTp".$idSoal."' value='".$kategoriLabel."'></td>";
				// $txtData.="<td class='tp' style='display:block'><input type='text' name='bobotKategori".$idSoal."'  id='bobotKategoriTp".$idSoal."' value='".$bobotTable."'></td></tr>";
				
				$i++;

			}
			//untuk menambahkan tombol tambah soal:kondisi sementara di none kan;
			if($katId==2){
				$txtData.="<div class='col-md-12' style='display:none'><div class='btn btn-block btnAddSoal'><button type='button' class='btn btn-block btn-info' data-katid='$katId' data-bobotTable='$bobotTable' data-kategoriLabel='$kategoriLabel' onclick='tambahSoal(this)'>TAMBAH SOAL</button></div></div>";
			}
			// $txtData.="<tr><td colspan='2'><strong>total bobot soal</strong></td><td>$bobotTotal</td><td></td><td></td><td></td><td></td><td></td></tr>";
			// $txtData.="</tbody></table>";
			// $txtData.="</div>
			// 	<div class='panel-footer'>
			// 		<div class='row'>
			// 			<div class='col-md-12 divFooter'>
			// 				<div class='row'>
			// 					<div class='col-md-7'>
			// 						<div class='row'>
			// 							<div class='col-md-1'></div>
			// 							<div class='col-md-10'>Total Bobot</div>
			// 							<div class='col-md-1' id='totalBobot$katId'>$bobotTotal</div>
			// 						</div>
			// 					</div>	
			// 				</div>
			// 			</div>
			// 		</div>
			// 	</div>
			// </div>";
			$txtData.="</div>
				<div class='panel-footer'>
					<div class='row'>
						<div class='col-md-12 divFooter'>
							<div class='row'>
								<div class='col-md-7 col-total'>
									<div class='row'>
										<div class='col-md-1'></div>
										<div class='col-md-10 col-total-text'>Total Bobot</div>
										<div class='col-md-1 clsTotalBobot' id='totalBobot$katId'>$bobotTotal</div>
										<div style='display:none;'>$kategoriLabel</div>	
									</div>
								</div>	
								<div class='col-xs-5 col-total'>
									<div class='row'>
										<div class='col-md-1'></div>
										<div class='col-md-10 col-total-text'>Total Jumlah Nilai</div>
										<div class='col-md-1' id='totalJumNilai$katId'></div>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>";

			$n++;
		}
		// $txtData.="<div class='form-group' style='margin-top:15px;'><button type='button' class='btn btn-danger' id='lock'><i class='fa fa-lock' aria-hidden='true'></i> Kunci Penilaian</button></div>";
		//tampilan skor penilaian
		$getInfoPenilaian=$this->Asset->query("SELECT * FROM kpireg.`pabanksoals` PBS WHERE PBS.`statusSoal`='top'");
		
		$j=1;
		$txtData.="<div class='panel panel-danger panelCheck'>";
			$txtData.="<div class='panel-heading' role='tab' id='headingOne$n'>
							<h4 class='panel-title'>
								<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseOne$n' aria-expanded='true' aria-controls='collapseOne'>$n Penilaian </a>
								
						</div>
					<div  class='panel-collapse' role='tabpanel' aria-labelledby='headingOne$n'>";
					$txtData.="<table class='table' width='100%' class='table'>";
					foreach($getInfoPenilaian as $dataKategori){
						$idKat=$dataKategori['PBS']['id'];
						$namaKategori=$dataKategori['PBS']['kategori'];
						$keteranganKategori=$dataKategori['PBS']['soal'];
						$bobotHitungPerkategori=$dataKategori['PBS']['bobotTable'];
						//create row tabel per kategori;
						$txtData.="<tr><th>$n.$j</th><th colspan='7'>$namaKategori</th></tr>";
						$txtData.="<tr><td></td><td colspan='7'>$keteranganKategori</td></tr>";
						$txtData.="<tr>
									<td></td>
									<td width='30%'><input type='text' class='form-control' name='valtotalJumNilai$idKat' placeholder='total jumlah nilai $namaKategori'readonly></td>
									<td width='10%'>X</td>
									<td width='10%'>0.2</td>
									<td width='10%'>X</td>
									<td width='10%'>$bobotHitungPerkategori<input type='hidden' id='bobotHitung$idKat' value='$bobotHitungPerkategori'></td>
									<td width=''>=</td>
									<td width='30%'><input type='text' class='form-control hasilNilai' name='hasilNilai' id='hasilNilai$idKat' placeholder='Hasil nilai $namaKategori'readonly></td>
								</tr>";

						$j++;
					}

					$getSkorAkhir=$this->Asset->query("SELECT * FROM kpireg.`paskorakhirs` ORDER BY id");
					$txtData.="<tr><th>$n.$j</th><th colspan='7'>Nilai keseluruhan (Total result) [b] + [d]:</th></tr>";
						$txtData.="<tr><td></td><td colspan='7' align='center'><h1 id='nilaiKeseluruhan'></h1></td></tr>";
						$txtData.="<tr><td></td>
						<td colspan='7'>";
						$txtData.="<div class='col-md-1'></div>";
							foreach($getSkorAkhir as $dataSkor){
								$idSkor=$dataSkor['paskorakhirs']['id'];
								$batasBawah=$dataSkor['paskorakhirs']['batasBawah'];
								$batasAtas=$dataSkor['paskorakhirs']['batasAtas'];
								$keterangan=$dataSkor['paskorakhirs']['keterangan'];
								$txtData.="
								<div class='col-md-2 '>           
                                    <div class='panel panel-default'>
                                        <div class='panel-heading' style='text-align:center;'>
											$idSkor
                                        </div>
										<ul class='list-group' style='text-align:center;'>
											<li class='list-group-item'>$batasBawah-$batasAtas</li>
										</ul>
                                        <div class='panel-body' style='text-align:center;min-height:80px;'>
											$keterangan
                                        </div>
                                    </div>
                                </div>
								";
							}
							
						$txtData.="</td></tr>";
					$txtData.="</table>";
			$txtData.="</div>
			</div>";
			$n++;

		$querySoalUraians= $this->Asset->query("SELECT *  FROM kpireg.pasoaluraians ppks  WHERE ppks.statusSoal='true'");
		$jumSoalUraian=count($querySoalUraians);  

		foreach($querySoalUraians as $dataSoal){
			$idSoalUraian=$dataSoal['ppks']['id'];
			$soalUraian=$dataSoal['ppks']['soal'];
			$pilihanSoal=$dataSoal['ppks']['pilihanSoal'];
			$panelBody='';
			if($pilihanSoal==''){
				$panelBody="<textarea class='form-control' name='txtSoalUraian".$idSoalUraian."' id='soalUraian".$idSoalUraian."' placeholder='komentar atau keterangan masih kosong'></textarea>";
			}else{
				//var_dump();exit();
				$pilihanSoal=explode('@@',substr($pilihanSoal,2,strlen($pilihanSoal)));
				$panelBody.="<table class='table' width='100%' class='table'>";
				$panelBody.="<thead><tr><th colspan='2' width='50%'>Beri tanda pada kolom yang dipilih</th>";
				$panelBody.="</thead><tbody>";

				foreach($pilihanSoal as $pilihanSoal){
					$pilihanSoal=$this->Function->replacequote($pilihanSoal);
					$panelBody.="<tr><td><input type='radio' name='txtSoalRadio".$idSoalUraian."' value='$pilihanSoal' onclick='pilih(this.value,$idSoalUraian)' class='radio'></td><td>$pilihanSoal</td></tr>";
				}
				//$panelBody.="<tr><td colspan='2'></td></tr>";
				$panelBody.="<input type='hidden' name='txtSoalUraian".$idSoalUraian."' id='soalUraian".$idSoalUraian."' value=''>";
				$panelBody.="</tbody></table>";
				$panelBody.="<table class='table table-bordered'><tr><td> <div class='form-inline'><div class='form-group'> <label for='ketidakhadiranmonth'>Ketidakhadiran / sakit (Absence/ illness) (12 months):</label> <input type='text' id='ketidakhadiranmonth' class='form-control' name='ketidakhadiranmonth' onkeypress='return hanyaAngka(this)'  placeholder='isi dengan angka'></div></div></td><td><div class='form-inline'><div class='form-group'> <label for='ketidakhadiranday'>Hari (day):</label><input type='text' id='ketidakhadiranday' class='form-control' name='ketidakhadiranday' onkeypress='return hanyaAngka(this)' placeholder='isi dengan angka'></div></div></td></tr></table>";

				
			}

			$txtData.="<div class='panel panel-info panelCheck'>";
			$txtData.="<div class='panel-heading' role='tab' id='headingOne$n'>
							<h4 class='panel-title'>
								<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseOne$n' aria-expanded='true' aria-controls='collapseOne'>$n .$soalUraian </a>
								<input type='hidden' name='idSoalUraian[]' class='idSoalUraian' value='$idSoalUraian'> 
							</h4>
						</div>
					<div  class='panel-collapse' role='tabpanel' aria-labelledby='headingOne$n'>";
					$txtData.=$panelBody;
			$txtData.="</div>
			</div>";

			$n++;


		}
			//$txtData.="<div class=\"well well-lg\">Tidak ada form penilaian untuk nik </div>";
			$txtData.="<div class='panel panel-info panelCheck'>";
			$txtData.="<div class='panel-heading' role='tab' id='headingOne$n'>
							<h4 class='panel-title'>
								<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseOne$n' aria-expanded='true' aria-controls='collapseOne'>$n .Komentar atasan langsung (comments from direct boss/ supervisor) </a>
							</h4>
						</div>
					<div  class='panel-collapse  ' role='tabpanel' aria-labelledby='headingOne$n'><textarea class='form-control' name='txtKomentarAtasan' id='komentarAtasan' placeholder='komentar atau keterangan masih kosong'></textarea>";
			$txtData.="</div>
			</div>";
		
		$txtData.="</br><button type=\"button\" class=\"btn btn-primary\" id=\"btnsimpan\" onclick='simpan()'>Simpan penilaian</button>";
		// $txtData.="<div class=\"panel-footer\">
		// 			<button type=\"button\" class='btn btn-primary'>Simpan Penilaian</button>		
		// 			</div>";
		 //var_dump($txtData);exit();
		
		echo $txtData;
	}

	//pagination
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
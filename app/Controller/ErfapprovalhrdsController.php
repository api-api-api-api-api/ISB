<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  ErfapprovalhrdsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}


public function ambilPermintaan(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="";

		//$atasan1=$this->hirarkiatasan();
	
		$queryPermintaan=$this->User->query("
SELECT a.*,b.hasilPenilaian FROM erfpermintaankaryawans AS a LEFT JOIN erfpelamarlinks AS b ON a.nomorErf=b.nomorErf WHERE
 (a.statusPengajuan='dihrd' OR a.statusPengajuan='ajukanpembatalan' OR (a.nomorErf IN(SELECT c.nomorErf FROM erfpelamarlinks AS c WHERE hasilPenilaian!='')))  AND a.statusPengajuan!='finish' group by a.nomorErf");

		$no=1;
		foreach($queryPermintaan AS $dtPermintaan){ 

			if($dtPermintaan["a"]["statusPengajuan"]=="dihrd"){
				$tipeApproval="Proses ERF HRD";
				
			}
		//	else if($dtPermintaan["a"]["statusPengajuan"]=="dihrd" && $dtPermintaan["b"]["penilaian"]!=""){
	//			$tipeApproval="Approval penyelesaian";
	//			}
			else{
				$tipeApproval="Approval pembatalan";
			}

			$pemohon=explode("#",$dtPermintaan["a"]["pemohon"]);
			$pemohon=$pemohon[1];
			if($dtPermintaan["a"]["posisi"]=='Lainnya'){
				$posisi=$dtPermintaan["a"]["posisilainnya"];
			}else{
				$posisi=$dtPermintaan["a"]["posisi"];
			}
			$listPinjaman.="
			  <tr style='cursor: pointer;' onclick=\"modalPermintaan('{$dtPermintaan["a"]["nomorErf"]}')\">
			        <td>".$no."
<input type='hidden' id='idErf_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["id"]."'>
<input type='hidden' id='nomorErf_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["nomorErf"]."'>
<input type='hidden' id='tglPengajuan_".$dtPermintaan["a"]["nomorErf"]."' value='".date('d-m-Y',strtotime($dtPermintaan["a"]["tglPengajuan"]))."'>
<input type='hidden' id='pemohon_".$dtPermintaan["a"]["nomorErf"]."' value='".$pemohon."'>
<input type='hidden' id='divisi_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["divisi"]."'>
<input type='hidden' id='jabatan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["jabatan"]."'>
<input type='hidden' id='dasarPermintaan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["dasarPermintaan"]."'>
<input type='hidden' id='posisi_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["posisi"]."'>
<input type='hidden' id='tglDibutuhkan_".$dtPermintaan["a"]["nomorErf"]."' value='".date('d-m-Y',strtotime($dtPermintaan["a"]["tglDibutuhkan"]))."'>
<input type='hidden' id='posisilainnya_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["posisilainnya"]."'>
<input type='hidden' id='statusKaryawan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["statusKaryawan"]."'>
<input type='hidden' id='ketStatusKaryawan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["ketStatus"]."'>
<input type='hidden' id='jenisKelamin_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["jenisKelamin"]."'>
<input type='hidden' id='pendidikan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["pendidikan"]."'>
<input type='hidden' id='pendidikanLain_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["pendidikanLain"]."'>
<input type='hidden' id='pengalamanKerja_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["pengalamanKerja"]."'>
<input type='hidden' id='pengalamanSecara_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["pengalamanSecara"]."'>
<input type='hidden' id='penguasaanBahasa_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["penguasaanBahasa"]."'>
<input type='hidden' id='penempatan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["penempatan"]."'>
<input type='hidden' id='penempatanDetail_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["penempatanDetail"]."'>
<input type='hidden' id='keterampilan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["keterampilan"]."'>
<input type='hidden' id='keterampilanLain_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["keterampilanLain"]."'>
<input type='hidden' id='persyaratanLainnya_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["persyaratanLainnya"]."'>
<input type='hidden' id='ttjOrlainnya_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["ttjOrlainnya"]."'>
<input type='hidden' id='statusPengajuan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["statusPengajuan"]."'>
<input type='hidden' id='tipeApproval_".$dtPermintaan["a"]["nomorErf"]."' value='".$tipeApproval."'>
<input type='hidden' id='keteranganPembatalan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["keteranganPembatalan"]."'>   
<input type='hidden' id='keteranganApproval_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["keteranganApproval"]."'>   
			        </td>
			        
			        <td>".$pemohon."</td>
					<td>".$dtPermintaan["a"]["nomorErf"]."</td>
					<td>".date("d-m-Y",strtotime($dtPermintaan["a"]["tglPengajuan"]))."</td>
					<td>".$dtPermintaan["a"]["dasarPermintaan"]."</td>
					<td>".$posisi."</td>
					<td>".date("d-m-Y",strtotime($dtPermintaan["a"]["tglDibutuhkan"]))."</td>
			        <td>".$tipeApproval."</td>
			        


			        <td style='display:none'><button type='button' class='btn btn-primary' onclick='approve(".$dtPermintaan["a"]["nomorErf"].")'>Approve</button>
			        <button type='button' class='btn btn-danger' style='display: none' onclick='tolak(".$dtPermintaan["a"]["nomorErf"].")'>Tolak</button>
			        </td>
			   </tr>
			";
			$no++;
			
		}
	echo $listPinjaman;

}



public function dataPelamar(){
	$this->autoRender=false;
	$this->loadModel('Asset');
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="";
		$adaData="";

		//$atasan1=$this->hirarkiatasan();
		$nomorErf=$_POST['nomorErf'];
	
		//$queryPermintaan=$this->User->query("SELECT * FROM erfpelamarlinks AS a JOIN dtrecruitment.pelamars AS b ON a.idPelamar = b.id where a.nomorErf='$nomorErf' ");
		// $queryERF=$this->User->query("SELECT group_concat(concat(\"'\",a.idPelamar,\"'\")) pelamar FROM dpfdplnew.erfpelamarlinks AS a WHERE a.nomorErf='".$nomorErf."'");
		// if($queryERF[0][0]['pelamar']==""){$queryERF[0][0]['pelamar']="''";}
		// $queryPermintaan=$this->Asset->query(" SELECT b.* FROM dtrecruitment.pelamars AS b WHERE b.id IN(".$queryERF[0][0]['pelamar'].") ");

		$queryListPelamar=$this->User->query("SELECT * FROM dpfdplnew.`erfpermintaankaryawans` erf 
        INNER JOIN(SELECT * FROM `dpfdplnew`.erfpelamarlinks  WHERE nomorErf='$nomorErf' ) a ON a.`idErf`=erf.`id`
        INNER JOIN `dtrecruitment`.pelamars b ON `b`.id=`a`.idPelamar ORDER BY `b`.id");


		$no=1;
		foreach($queryListPelamar as $dtPermintaan){ 
			
			$idPelamar=$dtPermintaan["b"]["id"];
			$idLink=$dtPermintaan["a"]["id"];
			$nomorErf=$dtPermintaan["a"]["nomorErf"];
			$tglMasuk=empty($dtPermintaan["a"]["tanggalMasuk"])?"":date('d-m-Y',strtotime($dtPermintaan["a"]["tanggalMasuk"]));
			$terpilih=$dtPermintaan["a"]["terpilih"];

			//var_dump($tglMasuk);exit();
			//$idPelamarLink=$dtPermintaan2["a"]["idPelamar"];
			// $queryPermintaan2=$this->User->query("SELECT c.id as id,terpilih FROM dpfdplnew.erfpelamarlinks as c where c.idPelamar='$idPelamar'");
			// foreach($queryPermintaan2 as $dtPermintaan2){ 
			// 	$idPelamarLink=$dtPermintaan2["c"]["id"];
			// 	$terpilih=$dtPermintaan2["c"]["terpilih"];
			// }

			$radioTerpilih="";
			$radioTidakTerpilih="";
// 	if($terpilih=="ya"){ 
//     $radioTerpilih='<input type="radio" class="form-check-'.$idPelamarLink.'" name="optradio-'.$idPelamarLink.'" checked>Terpilih';
//    }else{
//    	$radioTerpilih='<input type="radio" class="form-check-input-'.$idPelamarLink.'" name="optradio-'.$idPelamarLink.'" >Terpilih';
//    }

//    	if($terpilih=="tidak"){ 
//     $radioTidakTerpilih='<input type="radio" class="form-check-input-'.$idPelamarLink.'" name="optradio-'.$idPelamarLink.'" checked>Tidak';
//    }else{
//    	$radioTidakTerpilih='<input type="radio" class="form-check-input-'.$idPelamarLink.'" name="optradio-'.$idPelamarLink.'" >Tidak';
//    }
// $pelamarTerpilih='<div class="form-check" onclick="pilihPelamar('.$idPelamarLink.')">
//   	<label class="form-check-label-'.$idPelamarLink.'">
//     	'.$radioTerpilih.'
//   	</label>
// </div>
// <div class="form-check" onclick="tidakPilihPelamar('.$idPelamarLink.')">
//   <label class="form-check-label-'.$idPelamarLink.'">
//     '.$radioTidakTerpilih.'
//   </label>
// </div>';
if($terpilih=="ya"){ 
    	$radioTerpilih='<input type="radio" class="form-check-'.$idLink.'" id="terpilih'.$idLink.'" name="optradio-'.$idLink.'" value="ya" checked>';
   }else{
   		$radioTerpilih='<input type="radio" class="form-check-'.$idLink.'" id="terpilih'.$idLink.'"  name="optradio-'.$idLink.'" value="ya" >';
   }

if($terpilih=="tidak"){ 
    	$radioTidakTerpilih='<input type="radio" class="form-check-input-'.$idLink.'" id="tidak'.$idLink.'" name="optradio-'.$idLink.'" value="tidak"  checked>';
   }else{
   		$radioTidakTerpilih='<input type="radio" class="form-check-input-'.$idLink.'" id="tidak'.$idLink.'" name="optradio-'.$idLink.'" value="tidak" >';
}


$pelamarTerpilih="
	<div class='row'>
		<div class='col-lg-12' onclick='pilihPelamar(".$idLink.")'>
			<div class='input-group'>
				<span class='input-group-addon'>
					$radioTerpilih
				</span>
				<label class='form-control'>Terpilih</label>
			</div>
		</div>
	</div></br>
	<div class='row'>
		<div class='col-lg-12' onclick='tidakPilihPelamar(".$idLink.")'>
			<div class='input-group'>
				<span class='input-group-addon'>
					$radioTidakTerpilih
				</span>
				<label  class='form-control'>Tidak</label>
			</div>
		</div>
	</div>
	<div class='row' style='display:none;'>
		<div class='col-lg-12'>
			<div class='input-group'>
				<span class='input-group-addon'>
					cek
				</span>
				<input type='text' class='form-control cekTerpilih'  value='$terpilih'/>
			</div>
		</div>
	</div>
";

		// if($terpilih=="ya"){ 
		// 	$radioTerpilih='<input type="radio" class="form-check-'.$idLink.'" name="optradio" value="'.$idLink.'">';
		// }else{
		// 	$radioTerpilih='<input type="radio" class="form-check-input-'.$idLink.'" name="optradio"  value="'.$idLink.'">';
		// }

		// // onclick="pilihPelamar('.$idLink.')"
		// $pelamarTerpilih='<div class="form-check" >
		// 	<label class="form-check-label-'.$idLink.'">
		// 		'.$radioTerpilih.'
		// 	</label>
		// </div>';
		
		if(empty($dtPermintaan["a"]["hasilPenilaian"])){
			$buttonFeedback="Belum ada feedback";
		}else{
			$buttonFeedback=$dtPermintaan["a"]["hasilPenilaian"]=="direkomendasi"?"<button type='button' class='btn btn-info btn-sm btnGetRekomendasi' data-id='$idLink' data-erf='$nomorErf'><i class='fa fa-info-circle fa-lg' aria-hidden='true'></i> Direkomendasikan</button>":($dtPermintaan["a"]["hasilPenilaian"]=="dicadangkan"?"<button type='button' class='btn btn-info btn-sm  btnGetRekomendasi' data-id='$idLink' data-erf='$nomorErf'><i class='fa fa-info-circle fa-lg' aria-hidden='true'></i> Dicadangkan</button>":("<button type='button' class='btn btn-info btn-sm  btnGetRekomendasi' data-id='$idLink' data-erf='$nomorErf'><i class='fa fa-info-circle fa-lg' aria-hidden='true'></i> Tidak Direkomendasikan</button>"));
		}
		// list sebelum update
		// <tr style='cursor: pointer;' >
		// 	        <td>".$no."</td>
		// 	        <td>".$dtPermintaan["b"]["nama"]."</td>
		// 	        <td>".$dtPermintaan["b"]["tanggalLahir"]."</td>
		// 	        <td>".$dtPermintaan["b"]["jenisKelamin"]."</td>
		// 	        <td>".$dtPermintaan["b"]["agama"]."</td>
		// 	        <td>".$dtPermintaan["b"]["handphone"]."</td>
		// 	        <td>".$dtPermintaan["b"]["tinggiBadan"]."/".$dtPermintaan["b"]["beratBadan"]."</td>
		// 	        <td>".$dtPermintaan["b"]["jabatanSekarang"]."</td>
		// 	        <td>".$dtPermintaan["b"]["melamarJabatan"]."</td>
		// 			<td align='center'>".$pelamarTerpilih."</td>
		// 	        <td>$buttonFeedback</td>
		// 	     <td><button type='button' class='btn btn-danger btn-sm' onclick='hapusPelamar(".$idPelamarLink.")'>X</button></td>

		// 	   </tr>
			$pelamarInfo="<div class='panel panel-default' style='margin-bottom:0;'>
				<div class='panel-heading text-center'>
					<strong>".$dtPermintaan["b"]["nama"]."</center>
				</div>
				<div class='panel-body text-center'>
					<img src='".$dtPermintaan['b']['foto']."' class='img-rounded' alt='' width='120px'>
				</div>
				<div class='panel-footer'>
					<button type='button' class='btn btn-default btn-sm btn-block' onclick='openDetil(".$dtPermintaan['a']['idPelamar'].")'>Detail Pelamar</button>
				</div>
			</div>";
			$listPinjaman.="
			  <tr style='cursor: pointer;' >
			        <td>".$no."</td>
			        <td>".$pelamarInfo." </td>
			        <td><input type='text' class='form-control inputTanggalMasuk' name='inputTglMasuk$idLink' placeholder='Tentukan tanggal masuk' value='$tglMasuk' style='min-width:250px;'></td>
					<td align='center'>".$pelamarTerpilih."</td>
			        <td>$buttonFeedback</td>
			     <td><button type='button' class='btn btn-danger ' onclick='hapusPelamar(".$idLink.")'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>

			   </tr>
			";
			$no++;
			$adaData="ada";
		}

		if($listPinjaman==""){

			$listPinjaman.="
			  <tr style='cursor: pointer;'>
			        <td colspan='15'>
			        		<center>Belum Ada Data Pelamar Yang di Tambahkan</center>
			        </td>
			   </tr>
			";
			$adaData="tidak";
		}

	echo $listPinjaman."^".$adaData;

}
public function getDetilRekomendasi(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
	
	$idLink=$_POST['idLink'];

	$txtData="";
	$queryListPelamar="SELECT * FROM dpfdplnew.`erfpermintaankaryawans` erf 
	INNER JOIN(SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE id='$idLink') link ON link.`idErf`=erf.`id`
	INNER JOIN `dtrecruitment`.pelamars ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";
	//var_dump($queryListPelamar);exit();
	$listPelamar=$this->User->query($queryListPelamar);
	foreach($listPelamar as $pelamar){
		$untukJabatan=$pelamar['erf']['posisi'];
		if($untukJabatan=='Lainnya'){
			$untukJabatan=$pelamar['erf']['posisilainnya'];
		}
		$diwawancaraiOleh=explode('#',$pelamar['erf']['pemohon'])[1];
		$Jabatan=$pelamar['erf']['jabatan'];
		$untukPosisi=$pelamar['erf']['posisi'];
		$unitOrganisasi=$pelamar['erf']['divisi'];
		$tglDibutuhkan=date('d-m-Y',strtotime($pelamar['erf']['tglDibutuhkan']));
		

		$pelamarId=$pelamar['pelamars']['id'];
		$pelamarNama=$pelamar['pelamars']['nama'];
		$pelamartanggalLahir=$pelamar['pelamars']['tanggalLahir']=='0000-00-00'?'-':date('d-m-Y',strtotime($pelamar['pelamars']['tanggalLahir']));
		$pelamarjenisKelamin=$pelamar['pelamars']['jenisKelamin'];
		$pelamaragama=$pelamar['pelamars']['agama'];
		$pelamaralamatTinggal=$pelamar['pelamars']['alamatTinggal'];
		$pelamarfoto=$pelamar['pelamars']['foto'];

		$linkId=$pelamar['link']['id'];
		$idErf=$pelamar['link']['idErf'];
		$nomorErf=$pelamar['link']['nomorErf'];
		$hasilPenilaian=$pelamar['link']['hasilPenilaian'];
		$displayNone=!empty($hasilPenilaian)?'style="display:none;"':'';
		$penilaian1=$pelamar['link']["penampilan"];
		$penilaian2=$pelamar['link']["stabilitas"];
		$penilaian3=$pelamar['link']["motivasi"];
		$penilaian4=$pelamar['link']["keakraban"];
		$penilaian5=$pelamar['link']["keterampilan"];
		$penilaian6=$pelamar['link']["komunikasi"];
		$penilaian7=$pelamar['link']["ketajaman"];  
		$penilaian8=$pelamar['link']["tingkatPergaulan"];
		$keterangan=$pelamar['link']["keterangan"];

		if(empty($pelamar['link']['tglInterview'])){
			$tglInterView="";
			$img="*tanda tangan di bawah";
		}else{
			$tglInterView=date('d-m-Y',strtotime($pelamar['link']['tglInterview']));
			$img="<img src=\"erffile/rekomendasiBalik_".$linkId."_".$nomorErf.".png\" style=\"width:35%;\">";
		}
		
		
		$txtData.="
		
				<center><font style='font-size: 16px;'>PENILAIAN CALON KARYAWAN</font></center>
				<center><font style='font-size: 16px;'>APPLICANT EVALUATION FORM</font></center>
				<hr style='border: 1px solid #404040; margin-bottom: 5px;'>
					<span >
						Formulir ini setelah diisi lengkap, Harap diserahkan ke unit Sumber Daya Manusia PT. Bernofarm<br>
						<em>Please fil this form and submit to Human Resources Department of </em>PT. Bernofarm
					</span>
				<hr style='border: 1px solid #404040;margin-top: 5px;'>
				<table class='tabelAef' style='border: 1px solid #404040;border-collapse: collapse; width: 100%;padding: 1px;'>
					<tr style='border: 1px solid #404040;border-collapse: collapse;'>
					<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;'>
						Nama pelamar / Name of Applicant   
						</td>
						<td style='width:1%;  border-left-style: none;border-right-style: none;'>
							:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtNamaPelamar'>".strtoupper($pelamarNama)."</div>
						</td>
						<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;'>
							Diwawancarai oleh / Interviewd by :
						</td>
						<td style='width:1%;border-left-style: none;border-right-style: none;'> 
						:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtWawancaraOleh'>".$diwawancaraiOleh."</div>
						</td>
					</tr>
					<tr style='border: 1px solid #404040;border-collapse: collapse;'>
					<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;'>
						Untuk Jabatan / Position  
						</td>
						<td style='width:1%;  border-left-style: none;border-right-style: none;'>
							:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtUntukJabatan'>".$untukJabatan."</div>
						</td>
						<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;'>
							Jabatan/Pangkat / Position :
						</td>
						<td style='width:1%;border-left-style: none;border-right-style: none;'> 
						:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtPangkatPosisi'>".$Jabatan."</div>
						</td>
					</tr>
					<tr style='border: 1px solid #404040;border-collapse: collapse;'>
					<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;'>
						Unit Organisasi / Organization   
						</td>
						<td style='width:1%;  border-left-style: none;border-right-style: none;'>
							:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtUnitOrganisasi'>".$unitOrganisasi."</div>
						</td>
						<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;'>
							Tanggal / date :
						</td>
						<td style='width:1%;border-left-style: none;border-right-style: none;'> 
						:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtTanggal'>".$tglInterView."</div>
						</td>
					</tr>
					<tr style='border: 1px solid #404040;border-collapse: collapse;'>
					<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;'>
						Tgl Dibutuhkan / Estimated Accepet Date   
						</td>
						<td style='width:1%;  border-left-style: none;border-right-style: none;'>
							:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							<div id='txtTglDibutuhkan'>".$tglDibutuhkan."</div>
						</td>
						<td style='width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;'>
							Tanda Tangan / Signature :
						</td>
						<td style='width:1%;border-left-style: none;border-right-style: none;'> 
						:
						</td>
						<td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
							$img
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td><b>Penilaian Pokok / Main Apprisial</b></td>
					</tr>
					<tr>
						<td>(A = Istimewa &nbsp;&nbsp;&nbsp; B = Baik &nbsp;&nbsp;&nbsp; C = Cukup &nbsp;&nbsp;&nbsp; D = Kurang - berilah tanda X pada kotak yang dipilih)</td>
					</tr>
					<tr>
						<td>(A = Excelent &nbsp;&nbsp;&nbsp; B = Good &nbsp;&nbsp;&nbsp; C = Fair &nbsp;&nbsp;&nbsp; D = Poor - Please Mark X on the selected box)</td>
					</tr>
				</table>
				<table class='table table-bordered' width='100%' ;>
					<tr>
						<td style='width:2%;text-align:center;font-weight'><strong>No</strong></td>
						<td style='width:35%;text-align:center;'><strong>Penilaian / Appraisal</strong></td>
						<td style='width:43%;text-align:center;'><center><strong>Penjelasan / Remark</strong></center></td>
						<td style='width:5%;text-align:center;'><strong>A</strong></td>
						<td style='width:5%;text-align:center;'><strong>B</strong></td>
						<td style='width:5%;text-align:center;'><strong>C</strong></td>
						<td style='width:5%;text-align:center;'><strong>D</strong></td>
					</tr>";
					$penilaianAppraisal=['Penampilan / Apperance','Stabilitas / Stability','Motivasi / Motivation ','Keakraban / Familiarity','Keterampilan Kerja / Job Competency','Komunikasi Lisan / Oral Communication','Ketajaman Berpikir / Sharp of thinks','Tingkat Pergauluan /interaction'];
					$penjelasan=[
						"Kesan yang diperoleh dan cara berpakaian, dandan, sopan santun dan pembawaan diri pelamar / Personal grooming, politeness, and gestures of the applicant's",
						"Pertimbangan kematangan emosional, kedewasaan, kepercayaan diri dan kemampuan menyesuaikan diri pelamar / Please consider the applicant's emotional, mature, confidence and his/her stability",
						"Pertimbangan minat pelamar atas pekerjaan yang dilamar / Please consider the applicant's interest on the position he/she applies",
						"Pertimbangkan dari cara bicara, kata-kata yang dipergunakan, mimik, gerak tubuh, tingkat keluwesan bergaul Please consider the way to speak, word chosen, expression, gesture and the flexibility to associate",
						"Pertimbangkan pengalaman kerja pelamar dibandingkan posisi yang dilamar / Please consider applicants work experience compared to the proposed position",
						"Kemampuan pelamar mengutarakan pendapat/jawaban/kseimpulan deng+an jelas dan singkat (seperlunya) / Applicants ability to express opinions/response/ conclusions in a clear and concise",
						"Pertimbangkan kecekatan/ketajaman berpikir serta daya analisa pelamar / please consider applicant's the way of thinking and analitical ability",
						"Pertimbangkan lingkup pergaulan, hobi dan aktivitas di luar kantor / Please consider the applicant's sociality background. hobbies, and activities after office hour"
					];
					$button="";
					$ketDisabled=empty($keterangan)?'':'disabled';
					$penilaianNameInput=['penampilan','stabilitas','motivasi','keakraban','keterampilan','komunikasi','ketajaman','tingkatPergaulan'];
					//$queryPermintaan=$this->User->query("SELECT a.* FROM erfapplicantevaluations as a where a.idLinkPelamar='$linkId' order by id limit 1");
					//var_dump($queryPermintaan);exit();
					if(empty($hasilPenilaian)){
						for($i=0;$i<8;$i++){
							$no=$i+1;
							$txtData.="<tr>";
							$txtData.="<td style='width:2%;'>$no.</td>";
							$txtData.="<td style='width:35%;'>$penilaianAppraisal[$i]</td>";
							$txtData.="<td style='width:43%;'>$penjelasan[$i]</td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><i class='fa fa-square-o' aria-hidden='true'></i></td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><i class='fa fa-square-o' aria-hidden='true'></i></td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><i class='fa fa-square-o' aria-hidden='true'></i></td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><i class='fa fa-square-o' aria-hidden='true'></i></td>";
							$txtData.="</tr>";
						}
					}else{
						$penilaianArray=[$penilaian1,$penilaian2,$penilaian3,$penilaian4,$penilaian5,$penilaian6,$penilaian7,$penilaian8];
	
						for($i=0;$i<8;$i++){
							$no=$i+1;
							$txtData.="<tr>";
							$txtData.="<td style='width:2%;'>$no.</td>";
							$txtData.="<td style='width:35%;'>$penilaianAppraisal[$i]</td>";
							$txtData.="<td style='width:43%;'>$penjelasan[$i]</td>";
							$selectedA=$penilaianArray[$i]=='a'?'checked':'';
							$selectedB=$penilaianArray[$i]=='b'?'checked':'';
							$selectedC=$penilaianArray[$i]=='c'?'checked':'';
							$selectedD=$penilaianArray[$i]=='d'?'checked':'';
							$jawabanA=$penilaianArray[$i]=='a'?'<i class=\'fa fa-check fa-lg\' aria-hidden=\'true\'></i>':'';
							$jawabanB=$penilaianArray[$i]=='b'?'<i class=\'fa fa-check fa-lg\' aria-hidden=\'true\'></i>':'';
							$jawabanC=$penilaianArray[$i]=='c'?'<i class=\'fa fa-check fa-lg\' aria-hidden=\'true\'></i>':'';
							$jawabanD=$penilaianArray[$i]=='d'?'<i class=\'fa fa-check fa-lg\' aria-hidden=\'true\'></i>':'';

							//var_dump($selectedA);exit();
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'>$jawabanA</td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'>$jawabanB</td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'>$jawabanC</td>";
							$txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'>$jawabanD</td>";
							$txtData.="</tr>";
						}
						
					}
					
					$txtData.="
				</table>
				<div class=''>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<strong>Penilaian/Komentar Tambahan /<em> Apprisial/Additional Comments</em></strong> 
						</div>
						<div class='panel-body'>
							<textarea name='keteranganRekomendasi' cols='30' rows='10' class='form-control'  $ketDisabled>$keterangan</textarea>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-xs-12'>
						Kesimpulan (Harap dibubuhkan paraf dibawah pilihan anda)
						<br>
						<em>conlusion(Please provide initial under chosen remarks)</em>
						<br>";
	
						if(!empty($hasilPenilaian)){
							$rekomendasi=$hasilPenilaian=='direkomendasi'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
							$cadangkan=$hasilPenilaian=='dicadangkan'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
							$tdkRekomendasi=$hasilPenilaian=='tidak direkomendasi'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
						}else{
							$rekomendasi='';
							$cadangkan='';
							$tdkRekomendasi='';
						}	
						$txtData.="<table width='100%'>
							<tr>
								<td>$rekomendasi</td>
								<td>direkomendasikan/diusulkan <br><em> recomended</em></td>
								<td>$cadangkan</td>
								<td>dicadangkan/dapat dipertimbangkan <br><em> reserved</em></td>
								<td>$tdkRekomendasi</td>
								<td>tidak direkomendasikan <br><em> not recomended</em></td>
							</tr>
						</table>
						<br>                                                 
					</div>
				</div>  
		";
	
	}
	echo $txtData;exit();

}
public function pilihPelamar(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

	$idPelamarLink=$_POST['idPelamarLink'];
	$terpilih=$_POST['terpilih'];

	if($terpilih=='ya'){
		$tanggalMasuk=date('Y-m-d',strtotime($_POST['tanggalMasuk']));
		$sql = "UPDATE erfpelamarlinks as a SET a.terpilih='$terpilih',tanggalMasuk='$tanggalMasuk' where a.id='$idPelamarLink'";
	}else{
		$sql = "UPDATE erfpelamarlinks as a SET a.terpilih='$terpilih',tanggalMasuk=NULL where a.id='$idPelamarLink'";
	}

	
	$result = $this->User->query($sql);

	echo "sukses";
}


public function hapusPelamar(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

	$idlink=$_POST['idlink'];
	$idErf=$_POST['idErf'];

	$sql = "DELETE from `dpfdplnew`.erfpelamarlinks where id='$idlink'";
	$result = $this->User->query($sql);

	$cekLinkErfAktif=$this->User->query("SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$idErf'");

	if(empty($cekLinkErfAktif)){
		$queryUpdate=$this->User->query("UPDATE `dpfdplnew`.erfpermintaankaryawans as a SET a.linkAktif=NULL WHERE a.id='".$idErf."'");
	}


	echo "berhasil insert pelamar";
}


public function listPelamar(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->loadModel('Asset');
	$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="";
   		$nomorErf=$_POST['nomorErf'];
		//$atasan1=$this->hirarkiatasan();
		// var_dump("SELECT group_concat(concat(\"'\",b.`idPelamar`,\"'\")) pelamar FROM `dpfdplnew`.erfpelamarlinks AS b JOIN `dpfdplnew`.erfpermintaankaryawans AS c ON b.`nomorErf`=c.`nomorErf` WHERE b.`hasilPenilaian` IS NULL OR b.`terpilih`='ya'");exit();
		$queryERF=$this->User->query("SELECT group_concat(concat(\"'\",b.`idPelamar`,\"'\")) pelamar FROM `dpfdplnew`.erfpelamarlinks AS b JOIN `dpfdplnew`.erfpermintaankaryawans AS c ON b.`nomorErf`=c.`nomorErf` WHERE b.`hasilPenilaian` IS NULL OR b.`terpilih`='ya'");

		if($queryERF[0][0]['pelamar']==""){$queryERF[0][0]['pelamar']="''";}
		$queryPermintaan=$this->Asset->query("SELECT * FROM dtrecruitment.pelamars AS a WHERE a.id NOT IN(".$queryERF[0][0]['pelamar'].") AND a.hasilInterview='belum ditentukan'");

		$no=1;
		foreach($queryPermintaan as $dtPermintaan){ 
			$pelamarId="";
			$listPinjaman.="
			  <tr style='cursor: pointer;'>
			        <td>".$no++."</td>
					<td><button type='button' class='btn btn-success' onclick='insertPelamar(".$dtPermintaan["a"]["id"].")'>+</button></td>
			        <td><img src='".$dtPermintaan["a"]["foto"]."' width='150px' height='150px'></td>
			        <td>".$dtPermintaan["a"]["nama"]."</td>
			        <td>".$dtPermintaan["a"]["tempatLahir"]."/".$dtPermintaan["a"]["tanggalLahir"]."</td>
			        <td>".$dtPermintaan["a"]["jenisKelamin"]."</td>
			        <td>".$dtPermintaan["a"]["agama"]."</td>
			        <td>".$dtPermintaan["a"]["statusPerkawinan"]."/".$dtPermintaan["a"]["tahunStatusPerkawinan"]."</td>
			        <td>".$dtPermintaan["a"]["handphone"]."</td>
			        <td>".$dtPermintaan["a"]["tinggiBadan"]."/".$dtPermintaan["a"]["beratBadan"]."</td>
			        <td>".$dtPermintaan["a"]["jabatanSekarang"]."</td>
			        <td>".$dtPermintaan["a"]["kotaDilamar"]."</td>
			        <td>".$dtPermintaan["a"]["melamarJabatan"]."</td>
			        

			   </tr>
			";
			$no++;
			
		}

		if($listPinjaman==""){

			$listPinjaman.="
			  <tr style='cursor: pointer;'>
			        <td colspan='9'>
			        		<center>Belum Ada Data Pelamar Yang di Tambahkan</center>
			        </td>
			   </tr>
			";
		}

	echo $listPinjaman;

}

public function insertPelamar(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

	$idErf=$_POST['idErf'];
	$nomorErf=$_POST['nomorErf'];
	$idPelamar=$_POST['idPelamar'];
	// var_dump("INSERT INTO erfpelamarlinks(idErf,nomorErf,idPelamar,penilaian) values('$idErf','$nomorErf','$idPelamar','')");exit();
	//$sql = "INSERT INTO erfpelamarlinks(idErf,nomorErf,idPelamar,penilaian) values('$idErf','$nomorErf','$idPelamar','')";
	$sql = "INSERT INTO erfpelamarlinks(idErf,nomorErf,idPelamar) values('$idErf','$nomorErf','$idPelamar')";
	$result = $this->User->query($sql);

	$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.linkAktif='true' WHERE a.id='".$idErf."'";
	$result1 = $this->User->query($queryUpdate);

	echo "berhasil insert pelamar";

}


public function ambilhirarki(){
	   $this->autoRender = false;
		$this->loadModel('Asset');

		$idUser=$this->Session->read('dpfdpl_userId');
		$jabatan="false";


		$queryKaryawan=$this->Asset->query("SELECT * from newasset.bpkbhirarki as a where userId='".$idUser."'");

		
		foreach($queryKaryawan as $dtKaryawan){ 
			
			$jabatan=$dtKaryawan["a"]["posisi"];
		}
		echo $jabatan;

}

public function hirarkiatasan(){
	$this->autoRender = false;


	if($this->Session->read("dpfdpl_groupId")!=100){
		$this->loadModel('User');
			$this->loadModel('Asset');
            $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

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
			$this->loadModel('Asset');
            $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");


		   $rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$this->Session->read("dpfdpl_namaUser")."'");
		   
			//jika data belum ada di master
			if(count($rsKaryawan)<=0){
				$this->User->setDataSource('local');
				$rsKaryawan=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
		   $namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
		   $tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
		   $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}
		
		


			
		
			return $namaKaryawan."#".$tglLahir;

	
}

	
	public function approve(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		
			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			//$isittd=$_POST['isittd'];
			$nama="hrd";
			$tanggal=date("Y/m/d");

			/*
			$img = str_replace('data:image/jpeg;base64,', '', $isittd);
			$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $output_file="erfFile\img\hrdttd_approve_".$idErf."_".$nomorErf.".png";
            file_put_contents($output_file,$data);
            */


			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='disetujuihrd',a.linkAktif='true' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','hrd','$tanggal','disetujui','')";
			$this->User->query($queryInsertHistory);

			echo "berhasil approve";

	}

		public function penyelesaian(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
		try{
			$dataSource = $this->User->getdatasource();
			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");
		
		


		//var_dump($_POST);exit();
			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			//$isittd=$_POST['isittd'];
			$nama="hrd";
			$tanggal=date("Y-m-d H:i:s");

			//$idLink=$_POST["idLink"];
			// $inputTanggalMasuk=$_POST["inputTanggalMasuk"];

			// $queryAllLink="UPDATE `dpfdplnew`.erfpelamarlinks as a SET a.`terpilih`='tidak' WHERE a.`idErf`='".$idErf."'";
			// $this->User->query($queryAllLink);

			// $queryLinkTerpilih="UPDATE `dpfdplnew`.erfpelamarlinks as a SET a.`terpilih`='ya',a.`tanggalMasuk`='".date('Y-m-d',strtotime($inputTanggalMasuk))."' WHERE a.`id`='".$idLink."'";
			// $this->User->query($queryLinkTerpilih);
			/*
			$img = str_replace('data:image/jpeg;base64,', '', $isittd);
			$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $output_file="erfFile\img\hrdttd_penyelesaian_".$idErf."_".$nomorErf.".png";
            file_put_contents($output_file,$data);
            */

			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='finish',a.linkAktif='false' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','hrd','$tanggal','finish','')";
			$this->User->query($queryInsertHistory);

			echo "sukses";
            
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }

	}

		public function pembatalan(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			//$isittd=$_POST['isittd'];
			$nama="hrd";
			$tanggal=date("Y/m/d");

			/*
			$img = str_replace('data:image/jpeg;base64,', '', $isittd);
			$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $output_file="erfFile\img\atasanttd_pembatalan_".$nomorErf.".png";
            file_put_contents($output_file,$data);
            */

			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='batal',a.linkAktif='' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','hrd','$tanggal','dibatalkan','')";
			$this->User->query($queryInsertHistory);

			echo "berhasil melakukan pembatalan";

	}


	
	public function tolak(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			
			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			$nama="hrd";
			$tanggal=date("Y/m/d");

			
			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='ditolakhrd' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','hrd','$tanggal','ditolak','')";
			$this->User->query($queryInsertHistory);

			echo "permintaan di tolak";

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
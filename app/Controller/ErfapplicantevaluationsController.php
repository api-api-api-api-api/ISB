<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  ErfapplicantevaluationsController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}


public function ambilPermintaan(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="";
		$idPelamarLink=$_POST['idPelamar'];
	

		//$atasan1=$this->hirarkiatasan();
		$queryPermintaan=$this->User->query("SELECT c.*,d.* FROM erfpelamarlinks as c join erfpermintaankaryawans as d on c.idErf=d.id where c.id='$idPelamarLink' ");

		foreach($queryPermintaan AS $dtPermintaan){ 
				$pemohon=explode("@@",$dtPermintaan["d"]["pemohon"]);
				$txtWawancaraOleh=$pemohon[0];
				$txtUntukJabatan=$dtPermintaan["d"]["jabatan"];
				if($dtPermintaan["d"]["posisi"]=="Lainya"){
					$txtPangkatPosisi=$dtPermintaan["d"]["posisilainya"];
				}else{
					$txtPangkatPosisi=$dtPermintaan["d"]["posisi"];
				}
				$txtUnitOrganisasi=$dtPermintaan["d"]["divisi"];
				$txtTanggal=$dtPermintaan["d"]["tglPengajuan"];
				$txtTglDibutuhkan=$dtPermintaan["d"]["tglDibutuhkan"];
				$txtTandaTangan="";
				$idErf=$dtPermintaan["c"]["idErf"];
				

			$queryPermintaan2=$this->User->query("SELECT b.*  FROM dtrecruitment.pelamars as b where b.id='".$idPelamarLink."'");
			foreach($queryPermintaan2 AS $dtPermintaan2){ 
				$txtNamaPelamar=$dtPermintaan2["b"]["nama"];
			}
			
		}
	$listPinjaman=$txtWawancaraOleh."@@".$txtUntukJabatan."@@".$txtUntukJabatan."@@".$txtPangkatPosisi."@@".$txtUnitOrganisasi."@@".$txtTanggal."@@".$txtTglDibutuhkan."@@".$txtTandaTangan."@@".$idErf;
	echo $listPinjaman;

}



public function ambilPenilaian(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="kosong";
		$idPelamarLink=$_POST['idPelamar'];
	

		//$atasan1=$this->hirarkiatasan();
		$queryPermintaan=$this->User->query("SELECT a.* FROM erfapplicantevaluations as a where a.idLinkPelamar='$idPelamarLink' order by id limit 1");

		foreach($queryPermintaan AS $dtPermintaan){ 
				
		$penilaian1=$dtPermintaan["a"]["penampilan"];
		$penilaian2=$dtPermintaan["a"]["stabilitas"];
		$penilaian3=$dtPermintaan["a"]["motivasi"];
		$penilaian4=$dtPermintaan["a"]["keakraban"];
		$penilaian5=$dtPermintaan["a"]["keterampilan"];
		$penilaian6=$dtPermintaan["a"]["komunikasi"];
		$penilaian7=$dtPermintaan["a"]["ketajaman"];
		$penilaian8=$dtPermintaan["a"]["tingkatPergaulan"];
		$keterangan=$dtPermintaan["a"]["keterangan"];
		$hasilpenilaian=$dtPermintaan["a"]["hasilpenilaian"];
		
		$listPinjaman=$penilaian1."@@".$penilaian2."@@".$penilaian3."@@".$penilaian4."@@".$penilaian5."@@".$penilaian6."@@".$penilaian7."@@".$penilaian8."@@".$keterangan."@@".$hasilpenilaian;
			
		}

	echo $listPinjaman;

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


	if($this->Session->read("dpfdpl_groupId")==6 || $this->Session->read("dpfdpl_groupId")==7 || $this->Session->read("dpfdpl_groupId")==13){
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

	
	public function simpan(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			
			$idLinkPelamar=$_POST['idLinkPelamar'];
			$noErf=$_POST['noErf'];

			$penampilan=$_POST['penampilan'];
			$stabilitas=$_POST['stabilitas'];
			$motivasi=$_POST['motivasi'];
			$keakraban=$_POST['keakraban'];
			$keterampilan=$_POST['keterampilan'];
			$komunikasi=$_POST['komunikasi'];
			$ketajaman=$_POST['ketajaman'];
			$tingkatPergaulan=$_POST['pergaulan'];
			$keterangan=$_POST['keterangan'];
			$isittd=$_POST['isittd'];
			$hasilpenilaian=$_POST['hasilpenilaian'];

			$img = str_replace('data:image/jpeg;base64,', '', $isittd);
			$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $output_file="erfFile\img\atasanttd_apeva_".$idLinkPelamar."_".$noErf.".png";
            file_put_contents($output_file,$data);

			$queryInsertHistory="INSERT INTO erfapplicantevaluations(noErf,idLinkPelamar,penampilan,stabilitas,motivasi,keakraban,keterampilan,komunikasi,ketajaman,tingkatPergaulan,keterangan,hasilpenilaian) values('$noErf','$idLinkPelamar','$penampilan','$stabilitas','$motivasi','$keakraban','$keterampilan','$komunikasi','$ketajaman','$tingkatPergaulan','$keterangan','$hasilpenilaian')";
			$this->User->query($queryInsertHistory);

			echo "berhasil menyimpan data";

	}

		public function update(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			
			$idLinkPelamar=$_POST['idLinkPelamar'];
			$noErf=$_POST['noErf'];

			$penampilan=$_POST['penampilan'];
			$stabilitas=$_POST['stabilitas'];
			$motivasi=$_POST['motivasi'];
			$keakraban=$_POST['keakraban'];
			$keterampilan=$_POST['keterampilan'];
			$komunikasi=$_POST['komunikasi'];
			$ketajaman=$_POST['ketajaman'];
			$tingkatPergaulan=$_POST['pergaulan'];
			$keterangan=$_POST['keterangan'];
			$hasilpenilaian=$_POST['hasilpenilaian'];

			$queryUpdate="UPDATE erfapplicantevaluations as a SET a.penampilan='$penampilan',a.stabilitas='$stabilitas',a.motivasi='$motivasi',a.keakraban='$keakraban',a.keterampilan='$keterampilan',a.komunikasi='$komunikasi',a.ketajaman='$ketajaman',a.tingkatPergaulan='$tingkatPergaulan',a.keterangan='$keterangan',a.hasilpenilaian='$hasilpenilaian' WHERE a.idLinkPelamar='".$idLinkPelamar."'";

			$this->User->query($queryUpdate);

			echo "berhasil update data";

	}






	
	public function tolak(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			
						
			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			$nama=$this->hirarkiatasan();
			$tanggal=date("Y/m/d");
			

			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='ditolakatasan1' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','atasan1','$tanggal','ditolak','')";
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
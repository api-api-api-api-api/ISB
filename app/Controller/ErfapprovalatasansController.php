<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  ErfapprovalatasansController extends AppController {
public $components = array('Function','Paginator');	
public function index(){
	echo $this->Function->cekSession($this);
	}


public function ambilPermintaan(){
	$this->autoRender=false;
	$this->loadModel('User');
	$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

		$listPinjaman="";

	//	$atasan1=$this->hirarkiatasan();
	$atasan1=$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");
		$queryPermintaan=$this->User->query("SELECT * FROM erfpermintaankaryawans as a where a.statusPengajuan='diajukan' AND a.atasan1='$atasan1'");
		$no=1;
		foreach($queryPermintaan AS $dtPermintaan){ 

			$listPinjaman.="
			  <tr style='cursor: pointer;' onclick=\"modalPermintaan('{$dtPermintaan["a"]["nomorErf"]}')\">
			        <td>".$no++."
<input type='hidden' id='idErf_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["id"]."'>
<input type='hidden' id='nomorErf_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["nomorErf"]."'>
<input type='hidden' id='tglPengajuan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["tglPengajuan"]."'>
<input type='hidden' id='pemohon_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["pemohon"]."'>
<input type='hidden' id='divisi_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["divisi"]."'>
<input type='hidden' id='jabatan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["jabatan"]."'>
<input type='hidden' id='dasarPermintaan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["dasarPermintaan"]."'>
<input type='hidden' id='posisi_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["posisi"]."'>
<input type='hidden' id='tglDibutuhkan_".$dtPermintaan["a"]["nomorErf"]."' value='".$dtPermintaan["a"]["tglDibutuhkan"]."'>
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
   
			        </td>
			        <td>".$dtPermintaan["a"]["posisi"]."</td>
			        <td>".$dtPermintaan["a"]["pemohon"]."</td>
			        <td>".$dtPermintaan["a"]["tglDibutuhkan"]."</td>


			        <td style='display:none'><button type='button' class='btn btn-primary' onclick='approve(".$dtPermintaan["a"]["nomorErf"].")'>Approve</button>
			        <button type='button' class='btn btn-danger' style='display: none' onclick='tolak(".$dtPermintaan["a"]["nomorErf"].")'>Tolak</button>
			        </td>
			   </tr>
			";
			$no++;
			
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

	
	public function approve(){
		$this->autoRender = false;
		//$this->loadModel('User');
		$this->loadModel('User');

		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

			
			$idErf=$_POST['idErf'];
			$nomorErf=$_POST['nomorErf'];
			$isittd=$_POST['isittd'];
			$nama=$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");;
			$tanggal=date("Y/m/d");

			$img = str_replace('data:image/jpeg;base64,', '', $isittd);
			$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $output_file="erfFile\img\atasanttd_".$nama."__".$nomorErf.".png";
            file_put_contents($output_file,$data);

			$queryUpdate="UPDATE erfpermintaankaryawans as a SET a.statusPengajuan='dihrd' WHERE a.nomorErf='".$nomorErf."'";
			$this->User->query($queryUpdate);

			$queryInsertHistory="INSERT INTO erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$nama','atasan1','$tanggal','disetujui','')";
			$this->User->query($queryInsertHistory);

			echo "berhasil approve";

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
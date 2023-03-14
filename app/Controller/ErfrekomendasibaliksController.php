<?php
App::uses('AppController', 'Controller');
/*
    Employee Reqruitment Form Return Rekomendasi
*/ 
class ErfrekomendasibaliksController extends AppController{
    public $components = array('Function','Paginator');
    function index(){
        echo $this->Function->cekSession($this);
    }

    public function getData(){
        // get user login dahulu
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

		/*if($this->Session->read("dpfdpl_groupId")!=100){
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
            //marketing
		}else{
		   $rsKaryawan=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$this->Session->read("dpfdpl_namaUser")."'");
		   
			//jika data belum ada di master
			if(count($rsKaryawan)<=0){
				$this->User->setDataSource('local');
				$rsKaryawan=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$this->Session->read("dpfdpl_namaUser")."'");
			}
            //non marketing
		   $namaKaryawan=$rsKaryawan[0]['master_karyawan']["namakry"];
		   $tglLahir=$rsKaryawan[0]['master_karyawan']["tgllahir"];
		   $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
		   
		}
*/
        $pengaju='#'.$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");
         //var_dump();exit();
        // get list rekomendasi
        $queryListRekomendasi="SELECT * FROM (SELECT id,nomorErf,dasarPermintaan FROM `dpfdplnew`.erfpermintaankaryawans WHERE `statusPengajuan`='dihrd' AND linkaktif='true' AND pemohon LIKE '%$pengaju%') erf
        INNER JOIN (SELECT * FROM `dpfdplnew`.`erfpelamarlinks` link WHERE  (link.`tanggalMasuk` IS NULL OR link.`tanggalMasuk`='')) link  ON link.`idErf`=erf.`id`  GROUP BY erf.`id` ";
        //var_dump( $queryListRekomendasi);exit();
        $nomorRekomendasi=$this->User->query($queryListRekomendasi);

       $txtData="";
       $no=1;
        foreach($nomorRekomendasi as $data){
            $id=$data['erf']['id'];
            $nomorErf=$data['erf']['nomorErf'];
            $dasarPermintaan=$data['erf']['dasarPermintaan'];
            //var_dump($data);exit();
            $txtData.="<tr>";
            $txtData.="<td>".$no."</td>";
            $txtData.="<td>".$nomorErf."</td>";
            $txtData.="<td>".$dasarPermintaan."</td>";
            $txtData.="<td><button type='button' class='btnGetPelamar' data-id='$id' data-erf='$nomorErf'>Lihat Detail Rekomendasi Pelamar</button></td>";
            $txtData.="</tr>";
            $no++;
        }

        echo $txtData."^";

    }

    public function getPelamar()
    {
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

        $idErf=$_POST['idErf'];
       
        // query yang setelah simpan rekomendasi balik langsung hilang;
        // $queryListPelamar="SELECT * FROM (SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$idErf' AND (penilaian='' OR penilaian IS  NULL)) link 
        // INNER JOIN `dtrecruitment`.pelamars  ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";

        // query yang setelah simpan rekomendasi balik masih tetap;memberi info pergantian status;
        // $queryListPelamar="SELECT * FROM (SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$idErf') link 
        // INNER JOIN `dtrecruitment`.pelamars  ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";
        $queryListPelamar="SELECT * FROM dpfdplnew.`erfpermintaankaryawans` erf 
        INNER JOIN(SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$idErf' ) link ON link.`idErf`=erf.`id`
        INNER JOIN `dtrecruitment`.pelamars ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";
        

        //var_dump($queryListPelamar);exit();
        $listPelamar=$this->User->query($queryListPelamar);
        // /var_dump($queryListPelamar);exit();
        $txtData="";
        $nomor=1;
        foreach($listPelamar as $pelamar){
           
            $untukJabatan=$pelamar['erf']['posisi'];
            if($untukJabatan=='Lainnya'){
                $untukJabatan=$pelamar['erf']['posisilainnya'];
            }
            $diwawancaraiOleh=explode('#',$pelamar['erf']['pemohon'])[1];
            $Jabatan=$pelamar['erf']['jabatan'];
            $untukPosisi=$pelamar['erf']['posisi'];
            $unitOrganisasi=$pelamar['erf']['divisi'];
            //$tglDibutuhkan=date('d-m-Y',strtotime($pelamar['erf']['tglDibutuhkan']));
            
            //detail pengajuan
            $dasarPermintaan            =$pelamar['erf']['dasarPermintaan'];
            $posisi                     =$pelamar['erf']['posisi']=='Lainnya'?$pelamar['erf']['posisilainnya']:$pelamar['erf']['posisi'];
            $tglDibutuhkan              =$pelamar['erf']['tglDibutuhkan']=='0000-00-00'?'-':date('d-m-Y',strtotime($pelamar['erf']['tglDibutuhkan']));
            $statusKaryawanDibutuhkan   =$pelamar['erf']['statusKaryawan'];
            $ketStatus                  =$pelamar['erf']['ketStatus'];
            $jenisKelamin               =$pelamar['erf']['jenisKelamin'];
            $pendidikan                 =$pelamar['erf']['pendidikan']=='Lainnya'?$pelamar['erf']['pendidikanLain']:$pelamar['erf']['pendidikan'];
            $pengalamanKerja            =$pelamar['erf']['pengalamanKerja'];
            $pengalamanSecara           =$pelamar['erf']['pengalamanSecara'];
            $penguasaanBahasa           =$pelamar['erf']['penguasaanBahasa'];
            $penempatan                 =$pelamar['erf']['penempatan'];
            $penempatanDetail           =$pelamar['erf']['penempatanDetail'];
            $keterampilan               =$pelamar['erf']['keterampilan']=='Lainnya'?$pelamar['erf']['keterampilanLain']:$pelamar['erf']['keterampilan'];
            $persyaratanLainnya         =$pelamar['erf']['persyaratanLainnya'];
            //end info detail pengajuan

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
            $penilaianLink=$pelamar['link']['hasilPenilaian'];
            $displayNone=!empty($penilaianLink)?'style="display:none;"':'';
            $btnModalPenilaian=empty($penilaianLink)?"<button type='button' class='btn btn-info btn-sm btnModalPenilaian' data-namaPelamar='$pelamarNama' data-linkid='$linkId' data-erf='$idErf' data-nomorErf='$nomorErf' ><i class='fa fa-chevron-circle-right' aria-hidden='true'></i> Lakukan Penilaian</button>":($penilaianLink=='direkomendasi'?"<div class='alert alert-info' role='alert'>Direkomendasi</div>":($penilaianLink=='dicadangkan'?"<div class='alert alert-info' role='alert'>Dicadangkan</div>":"<div class='alert alert-info' role='alert'>Tidak direkomendasi</div>"));
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
                $tglInterView="<input type='text' name='tglInterview' id='tglInterview$linkId' class='form-control tglInterview' placeholder='inputkan tanggal interview'/>";
                $img="*tanda tangan di bawah";
            }else{
                $tglInterView=date('d-m-Y',strtotime($pelamar['link']['tglInterview']));
                $img="<img src=\"erffile/rekomendasiBalik_".$linkId."_".$nomorErf.".png\" style=\"width:25%;\">";
            }
            
            //$pelamarLinkPhoto=$pelamar['pelamars'][''];

            $txtData.="<tr>";
            $txtData.="<td align='center'>$nomor</td>";
            $txtData.="<td>
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <div class='panel panel-default'>
                                        <div class='panel-body'>
                                            <img src='$pelamarfoto' class='img-rounded' alt='' width='120px'>
                                        </div>
                                        <div class='panel-footer'>
                                            <button type='button' class='btn btn-default btn-sm btn-block' onclick='openDetil(".$pelamarId.")'>Detail Pelamar</button>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </td>";
            $txtData.="<td>
            <table width='100%' class='table table-bordered '>
                                 <tr><th width='30%'>Nama</th><td>$pelamarNama</td></tr>  
                                 <tr><th>Tanggal Lahir</th><td>".$pelamartanggalLahir."</td></tr>  
                                 <tr><th>Jenis Kelamin</th><td>".$pelamarjenisKelamin."</td></tr>  
                                 <tr><th>Agama</th><td>".$pelamaragama."</td></tr>  
                                 <tr><th>Domisili</th><td>".$pelamaralamatTinggal."</td></tr>  
                             </table> 
            </td>";
            $txtData.="<td>$dasarPermintaan </td>";

            $buildTableSpesifikasiKebutuhan="<table class='TableSpesifikasiKebutuhan '>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Posisi / Position</td><td>:</td><td>$posisi</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Dibutuhkan Tanggal / Required date</td><td>:</td><td>$tglDibutuhkan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Status Karyawan / Status Of Employees</td><td>:</td><td>$statusKaryawanDibutuhkan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Jenis Kelamin / Gender</td><td>:</td><td>$jenisKelamin</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Pendidikan / Education</td><td>:</td><td>$pendidikan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Pengalaman Kerja / Working Experience</td><td>:</td><td>$pengalamanKerja</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Penguasaan Bahasa / Language Proficiency</td><td>:</td><td>$penguasaanBahasa</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Penempatan / Station</td><td>:</td><td>$penempatan<br>$penempatanDetail</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Ketrampilan / Skills</td><td>:</td><td>$keterampilan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><th>Persyaratan Lainnya / Other Requirement</td><td>:</td><td>$persyaratanLainnya</td></tr>";
            $buildTableSpesifikasiKebutuhan.="</table>";
            $txtData.="<td>$buildTableSpesifikasiKebutuhan</td>";
            $txtData.="<td style='vertical-align:middle'>
                            <div class='col-xs-12 text-center'>
                                <div class='form-group'>$btnModalPenilaian</div>
                            </div>
                        </td>";

            // dengan form applicant evaluation form
            $txtData.="<td style='display:none;'>
                        <div class='alert alert-danger' role='alert' $displayNone>
                            <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>
                            <strong>Harap diperhatikan,</strong> sebelum anda melakukan aksi simpan, pastikan data yang anda inputkan sudah sesuai !!!
                        </div>
                        <p class='bg-danger'> </p>
                        <div class='panel panel-default'>
                            <div class='panel-body' style='padding:35px;'>
                                <div style='display:none;'>
                                <center><font style='font-size: 16px;'>PENILAIAN CALON KARYAWAN</font></center>
                                <center><font style='font-size: 16px;'>APPLICANT EVALUATION FORM</font></center>
                                <hr style='border: 1px solid #404040; margin-bottom: 5px;'>
                                    <span >
                                        Formulir ini setelah diisi lengkap, Harap diserahkan ke unit Sumber Daya Manusia PT. Bernofarm<br>
                                        <em>Please fil this form and submit to Human Resources Department of </em>PT. Bernofarm
                                    </span>
                                <hr style='border: 1px solid #404040;margin-top: 5px;'>
                                </div>
                                <table class='tabelAef' style='border: 1px solid #404040;border-collapse: collapse; width: 100%;padding: 1px;display:none;'>
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
                                <table style='display:none;'>
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
                                <div class='panel panel-default'>
                                        <div class='panel-body'>
                                            <div class='row'>
                                                <div class='col-xs-12'> 
                                                    <strong>Penilaian Pokok / Main Apprisial</strong> 
                                                </div>
                                                <div class='col-xs-12'>
                                                    <div class='row'>
                                                        <div class='col-xs-3'>
                                                            <div class=''> 
                                                                <div class='form-horizontal'>
                                                                    <div class='form-group'>
                                                                        <label class='col-sm-2 control-label'> <span class='badge'>A</span></label>
                                                                        <div class='col-sm-10'>
                                                                            <p class='form-control-static'>Istimewa / Excelent</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='col-xs-3'>
                                                            <div class=''>
                                                                <div class='form-horizontal'>
                                                                    <div class='form-group'>
                                                                        <label class='col-sm-2 control-label'><span class='badge'>B</span></label>
                                                                        <div class='col-sm-10'>
                                                                            <p class='form-control-static'>Baik / Good</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='col-xs-3'>
                                                            <div class=''>
                                                                <div class='form-horizontal'>
                                                                    <div class='form-group'>
                                                                        <label class='col-sm-2 control-label'><span class='badge'>C</span></label>
                                                                        <div class='col-sm-10'>
                                                                            <p class='form-control-static'>Cukup / Fair</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='col-xs-3'>
                                                            <div class=''>
                                                                <div class='form-horizontal'>
                                                                    <div class='form-group'>
                                                                        <label class='col-sm-2 control-label'><span class='badge'>D</span></label>
                                                                        <div class='col-sm-10'>
                                                                            <p class='form-control-static'>Kurang / Poor</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        if(empty($penilaianLink)){
                                            for($i=0;$i<8;$i++){
                                                $no=$i+1;
                                                $txtData.="<tr>";
                                                $txtData.="<td style='width:2%;'>$no.</td>";
                                                $txtData.="<td style='width:35%;'>$penilaianAppraisal[$i]</td>";
                                                $txtData.="<td style='width:43%;'>$penjelasan[$i]</td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input type='radio' class='form-control' id='penilaian".$no."_a' name='$penilaianNameInput[$i]$linkId' value='a'></td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input type='radio' class='form-control' id='penilaian".$no."_b' name='$penilaianNameInput[$i]$linkId' value='b'></td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input type='radio' class='form-control' id='penilaian".$no."_c' name='$penilaianNameInput[$i]$linkId' value='c'></td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input type='radio' class='form-control' id='penilaian".$no."_d' name='$penilaianNameInput[$i]$linkId' value='d'></td>";
                                                $txtData.="</tr>";
                                            }
                                            $button="<div class='col-xs-12'> 
                                                <div class='form-group'>   
                                                    <div class='alert alert-danger' role='alert'>
                                                        <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>
                                                        <strong>Harap diperhatikan,</strong> sebelum anda melakukan aksi simpan, pastikan data yang anda inputkan sudah sesuai !!!
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class='col-xs-12 text-center'>
                                                <div class='form-group'><button type='button' class='btn btn-primary btnSubmitRekomendasi' data-linkid='$linkId' data-erf='$idErf' data-nomorErf='$nomorErf' ><i class='fa fa-hdd-o' aria-hidden='true'></i> Simpan</button></div>
                                            </div>";   
                                            // onclick='simpan($linkId)'
                                                    
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
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input style='display:none;' type='radio' class='form-control' id='penilaian".$no."_a' name='penilaian$no' value='a' $selectedA> $jawabanA</td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input style='display:none;' type='radio' class='form-control' id='penilaian".$no."_b' name='penilaian$no' value='b' $selectedB>$jawabanB</td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input style='display:none;' type='radio' class='form-control' id='penilaian".$no."_c' name='penilaian$no' value='c' $selectedC>$jawabanC</td>";
                                                $txtData.="<td style='width:5%;text-align:center;vertical-align: middle;'><input style='display:none;' type='radio' class='form-control' id='penilaian".$no."_d' name='penilaian$no' value='d' $selectedD>$jawabanD</td>";
                                                $txtData.="</tr>";
                                            }
                                            $button="<div class='col-xs-12'> 
                                                <div class='form-group'>   
                                                    <div class='alert alert-danger' role='alert'>
                                                        <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>
                                                        <strong>Harap diperhatikan,</strong> sebelum anda melakukan aksi simpan, pastikan data yang anda inputkan sudah sesuai !!!
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class='col-xs-12 text-center'>
                                                <div class='form-group'><button type='button' class='btn btn-success' onclick='update($linkId)'><i class='fa fa-hdd-o' aria-hidden='true'></i> Update</button></div>
                                            </div>";   
                                        }
                                    
                            $txtData.="
                                    </table>
                                
                                <div class=''>
                                    <div class='panel panel-default'>
                                        <div class='panel-heading'>
                                            <strong>Penilaian/Komentar Tambahan /<em> Apprisial/Additional Comments</em></strong> 
                                        </div>
                                        <div class='panel-body'>
                                            <textarea name='keteranganRekomendasi' id='keteranganRekomendasi$linkId' cols='30' rows='10' class='form-control'  $ketDisabled>$keterangan</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-xs-12'>
                                           Kesimpulan (Harap dibubuhkan paraf dibawah pilihan anda)
                                        <br>
                                        <em>conlusion(Please provide initial under chosen remarks)</em>
                                        <br>";

                                        if(!empty($penilaianLink)){
                                            // $rekomendasi=$penilaianLink=='direkomendasi'?'checked':'disabled';
                                            // $cadangkan=$penilaianLink=='dicadangkan'?'checked ':'disabled';
                                            // $tdkRekomendasi=$penilaianLink=='tidak direkomendasi'?'checked ':'disabled';
                                            $rekomendasi=$penilaianLink=='direkomendasi'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
                                            $cadangkan=$penilaianLink=='dicadangkan'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i> ':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
                                            $tdkRekomendasi=$penilaianLink=='tidak direkomendasi'?'<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i> ':'<i class="fa fa-square-o fa-lg" aria-hidden="true"></i>';
                                        }else{
                                            $rekomendasi="<input type='radio' class='hp1 form-control' name='rekomendasi$linkId' value='direkomendasi'  >";
                                            $cadangkan="<input type='radio' class='hp2 form-control' name='rekomendasi$linkId' value='dicadangkan'  >";
                                            $tdkRekomendasi="<input type='radio' class='hp3 form-control' name='rekomendasi$linkId' value='tidak direkomendasi'   >";
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
                                        <div $displayNone>                                      
                                            <div class='sigPad' id='linear' style='width:300px;' >
                                                <ul class='sigNav'>
                                                    <li class='drawIt'><a href='#draw-it' >Diserahkan Oleh</a></li>
                                                    <li class='clearButton'><a href='#clear'>Hapus</a></li>
                                                </ul>
                                                <div class='sig sigWrapper' style='height:auto;border-color:white;'>
                                                    <div class='typed'></div>
                                                    <center><canvas class='pad' style='border: 1px solid #ddd;' width='300px' height='150px' id='canvas__$linkId'></canvas></center>
                                                    <input type='hidden' name='output' class='output'>
                                                </div>
                                            </div>  
                                        </div>                                                  
                                    </div>
                                </div>

                            </div> 
                            <div class='panel-footer' $displayNone>
                                <div class='row'>
                                    $button  
                                </div>
                            </div>
                        </div>    
                    </td>";

            
            //tanpa form
            // $txtData.="<td>
            //                 <table width='100%' class='table table-bordered'>
            //                     <tr><th width='30%'>Nama</th><td>$pelamarNama</td></tr>  
            //                     <tr><th>Tanggal Lahir</th><td>".$pelamartanggalLahir."</td></tr>  
            //                     <tr><th>Jenis Kelamin</th><td>".$pelamarjenisKelamin."</td></tr>  
            //                     <tr><th>Agama</th><td>".$pelamaragama."</td></tr>  
            //                     <tr><th>Domisili</th><td>".$pelamaralamatTinggal."</td></tr>  
            //                 </table>      
            //             </td>";
            // $txtData.="<td  style='vertical-align:middle;'>
            //                 <select class='form-control' name='rekomendasi$linkId' id='rekomendasi$linkId'>
            //                     <option value='' selected>Pilih Rekomendasi</option>
            //                     <option value='direkomendasi'>Direkomendasi</option>
            //                     <option value='tidak direkomendasi'>Tidak Direkomendasi</option>
            //                     <option value='dicadangkan'>Dicadangkan</option>
            //                 </select>
            //             </td>";
            // $txtData.="<td style='vertical-align:middle;'><textarea class='form-control' name='keteranganRekomendasi$linkId' id='keteranganRekomendasi$linkId' cols='30' rows='5' ></textarea></td>";
            // $txtData.="<td style='vertical-align:middle;'><button type='button' class='btn btn-primary btnSubmitRekomendasi' data-linkid='$linkId' data-erf='$idErf'>Submit</button></td>";
            $txtData.="</tr>";
            $nomor++;
        }
       
        echo $txtData."^";
        exit();
        //var_dump($listPelamar);exit();
    }

    //function simpan
    public function simpan(){
        $this->autoRender = false;
		$this->loadModel('User');
		try{
			$dataSource = $this->User->getdatasource();
			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");
            //var_dump($_POST);exit();
            $linkId             =$_POST['linkId'];
            $idErf              =$_POST['idErf'];
            $nomorErf           =$_POST['nomorErf'];
            $tglInterview       =date('Y-m-d',strtotime($_POST['tglInterview']));
            $penampilan         =$_POST["penampilan"];
            $stabilitas         =$_POST["stabilitas"];
            $motivasi           =$_POST["motivasi"];
            $keakraban          =$_POST["keakraban"];
            $keterampilan       =$_POST["keterampilan"];
            $komunikasi         =$_POST["komunikasi"];
            $ketajaman          =$_POST["ketajaman"];
            $tingakatPergaulan  =$_POST["tingakatPergaulan"];
           
            $rekomendasi=$_POST['rekomendasi'];
            $keteranganRekomendasi=$_POST['keteranganRekomendasi'];
            $isittd=$_POST['isittd'];
            
            //simpan signature rekomendasi balik
            // $img = str_replace('data:image/jpeg;base64,', '', $isittd);
            
			// $img = str_replace(' ', '+', $img);
            // $data = base64_decode($img);
            // $namaFile="/rekomendasiBalik_".$linkId."_".$nomorErf.".png";
            // $output_file="erfFile".$namaFile;
            // file_put_contents($output_file,$data);

            //update link erf pelamar
            $queryUpdate="UPDATE `dpfdplnew`.erfpelamarlinks SET
            -- tglInterview='$tglInterview',
            penampilan='$penampilan',
            stabilitas='$stabilitas',
            motivasi='$motivasi',
            keakraban='$keakraban',
            keterampilan='$keterampilan',
            komunikasi='$komunikasi',
            ketajaman='$ketajaman',
            tingkatPergaulan='$tingakatPergaulan',
            hasilPenilaian='$rekomendasi',
            keterangan='$keteranganRekomendasi'
            WHERE  id='".$linkId."'";
            $this->User->query($queryUpdate);

            $tanggalApp=date('Y-m-d H:i:s');
            $pengaju='#'.$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");


            $queryInsertHistory="INSERT INTO `dpfdplnew`.erfhistorys(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) values('$idErf','$nomorErf','$pengaju','pemohon',' $tanggalApp','rekomendasi balik','$rekomendasi')";
            $this->User->query($queryInsertHistory);
            
           


            echo "sukses";
            
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    } 

    // function get_web_page( $url )
    // {
    //     $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    //     $options = array(

    //         CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
    //         CURLOPT_POST           =>false,        //set to GET
    //         CURLOPT_USERAGENT      => $user_agent, //set user agent
    //         CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
    //         CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
    //         CURLOPT_RETURNTRANSFER => true,     // return web page
    //         CURLOPT_HEADER         => false,    // don't return headers
    //         CURLOPT_FOLLOWLOCATION => true,     // follow redirects
    //         CURLOPT_ENCODING       => "",       // handle all encodings
    //         CURLOPT_AUTOREFERER    => true,     // set referer on redirect
    //         CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
    //         CURLOPT_TIMEOUT        => 120,      // timeout on response
    //         CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    //     );

    //     $ch      = curl_init( $url );
    //     curl_setopt_array( $ch, $options );
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     $content = curl_exec( $ch );
    //     $err     = curl_errno( $ch );
    //     $errmsg  = curl_error( $ch );
    //     $header  = curl_getinfo( $ch );
    //     curl_close( $ch );

    //     $header['errno']   = $err;
    //     $header['errmsg']  = $errmsg;
    //     $header['content'] = $content;
    //     return $header;
    // }

	public function getUrlDetilKaryawan(){
		$this->loadModel('User');
		$this->autoRender = false;
	
            $url=$_POST['urlDetilPelamar'];
			
			$result = $this->get_web_page($url);
            echo $result['content'] ;exit();
            if ( $result['errno'] != 0 )
            var_dump($result['errno']);

            if ( $result['http_code'] != 200 )
                var_dump($result['http_code']);

		    $page = $result['content'];
            var_dump($page);exit();
            echo $page;exit();
    }

}

// <div class='form-horizontal'>
// <div class='form-group'>
// <label class='col-sm-4 control-label'>Nama</label>
// <div class='col-sm-8'>
//     <p class='form-control-static'>$pelamarNama</p>
// </div>
// </div>
// <div class='form-group'>
// <label for='inputPassword' class='col-sm-4 control-label'>Tanggal Lahir</label>
// <div class='col-sm-8'>
//     <p class='form-control-static'>".date('d-m-Y',strtotime($pelamartanggalLahir))."</p>
// </div>
// </div>
// <div class='form-group'>
// <label for='inputPassword' class='col-sm-4 control-label'>Jenis Kelamin</label>
// <div class='col-sm-8'>
//     <p class='form-control-static'>".$pelamarjenisKelamin."</p>
// </div>
// </div>
// <div class='form-group'>
// <label for='inputPassword' class='col-sm-4 control-label'>Agama</label>
// <div class='col-sm-8'>
//     <p class='form-control-static'>".$pelamaragama."</p>
// </div>
// </div>
// <div class='form-group'>
// <label for='inputPassword' class='col-sm-4 control-label'>Domisili</label>
// <div class='col-sm-8'>
// <p class='form-control-static'>".$pelamaralamatTinggal."</p>
// </div>
// </div>
// </div>
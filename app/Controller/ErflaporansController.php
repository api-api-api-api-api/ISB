<?php
App::uses('AppController', 'Controller');
/*
    Employee Reqruitment Form Return Rekomendasi
*/ 
class ErflaporansController extends AppController{
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

		/*if($this->Session->read("dpfdpl_groupId")==13 || $this->Session->read("dpfdpl_groupId")==6 || $this->Session->read("dpfdpl_groupId")==7){
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
		   
		}*/
        //filter
        $bulan=$_POST['bulan'];
        $tahun=$_POST['tahun'];
        //var_dump($_POST);exit();
        $filterBulanTahun="";
        if(!empty($tahun)){
            $filterBulanTahun.=$tahun;
        }

        if(!empty($bulan)){
            $bulan=(int)$bulan<10?"0".$bulan:$bulan;
            $filterBulanTahun.='-'.$bulan;
        }

        $filterBulanTahun="AND DATE_FORMAT(erf.`tglPengajuan`,'%Y-%m')='$filterBulanTahun'";
        
        if(empty($bulan) && empty($tahun)){
            $filterBulanTahun='';
        }
        
        
        $hm=$_POST['hal'];
        $fungsi=$_POST['fungsi'];
       
        
        
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        $sessionGroupId=$this->Session->read("dpfdpl_groupId");
        //$sessionGroupId=37;
        if($sessionGroupId==37){
            $pengaju="";
        } else{
            $pengaju='#'.$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");
        }
        $pengaju="";
        //$pengaju='#'.$this->Session->read("dpfdpl_namaKaryawan")."#".$this->Session->read("dpfdpl_tanggalLahir");
        // get list rekomendasi
        // $queryListRekomendasi="SELECT * FROM (SELECT * FROM `dpfdplnew`.erfpermintaankaryawans WHERE `statusPengajuan`='diapprovehrd' AND linkaktif='true' AND pemohon LIKE '%$pengaju%') erf
        // INNER JOIN `dpfdplnew`.`erfpelamarlinks` link ON link.idErf=erf.id GROUP BY erf.id ";
        $queryListRekomendasi="SELECT * FROM `dpfdplnew`.erfpermintaankaryawans erf WHERE   erf.`pemohon` LIKE '%$pengaju%' $filterBulanTahun ORDER BY erf.`id` DESC";
        //var_dump($queryListRekomendasi);exit();
        $nomorRekomendasi=$this->User->query($queryListRekomendasi);

        //$querysql=$this->User->query($sql);
        
        $jumQuery=count($nomorRekomendasi);
        $sum=ceil($jumQuery/$limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $rsTampil=$this->User->query($queryListRekomendasi." limit $start, $limit");
        $n=$start+1;

       $txtData="";
       $no=1;
        foreach($rsTampil as $data){
            $id                         =$data['erf']['id'];
            $nomorErf                   =$data['erf']['nomorErf'];
            $pengaju                    =$data['erf']['pemohon'];
            $tglPengajuan               =$data['erf']['tglPengajuan']=='0000-00-00'?'-':date('d-m-Y',strtotime($data['erf']['tglPengajuan']));
            $dasarPermintaan            =$data['erf']['dasarPermintaan'];
            $posisi                     =$data['erf']['posisi']=='Lainnya'?$data['erf']['posisilainnya']:$data['erf']['posisi'];
            $tglDibutuhkan              =$data['erf']['tglDibutuhkan']=='0000-00-00'?'-':date('d-m-Y',strtotime($data['erf']['tglDibutuhkan']));
            $statusKaryawanDibutuhkan   =$data['erf']['statusKaryawan'];
            $ketStatus                  =$data['erf']['ketStatus'];
            $jenisKelamin               =$data['erf']['jenisKelamin'];
            $pendidikan                 =$data['erf']['pendidikan']=='Lainnya'?$data['erf']['pendidikanLain']:$data['erf']['pendidikan'];
            $pengalamanKerja            =$data['erf']['pengalamanKerja'];
            $pengalamanSecara           =$data['erf']['pengalamanSecara'];
            $penguasaanBahasa           =$data['erf']['penguasaanBahasa'];
            $penempatan                 =$data['erf']['penempatan'];
            $penempatanDetail           =$data['erf']['penempatanDetail'];
            $keterampilan               =$data['erf']['keterampilan']=='Lainnya'?$data['erf']['keterampilanLain']:$data['erf']['keterampilan'];
            $persyaratanLainnya         =$data['erf']['persyaratanLainnya'];

            //cek status tiap pengajuan
            $statusPengajuan            =$data['erf']['statusPengajuan'];
            $linkAktif                  =$data['erf']['linkaktif'];
            $infoStatus="";
            $btnRekomendasiPelamar="";
            if($sessionGroupId==37){
                if($statusPengajuan=='diajukan'){
                    $infoStatus="<div class='alert alert-info' role='alert'>Menunggu Persetujuan Atasan</div>";
                    
                }
    
                // if($statusPengajuan=='dihrd'){
                //     $infoStatus="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                //     
                // }
                if($statusPengajuan=='dihrd' && empty($linkAktif)){
                    $infoStatus="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                    
                }
    
                if($statusPengajuan=='dihrd' && !empty($linkAktif)){
                    $infoStatus.="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                    $btnRekomendasiPelamar="<a href='#collapse$no' data-toggle='collapse'  class='btn btn-default' data-parent='#accordion' style='margin-bottom:15px;' >Lihat rekomendasi pelamar <i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i></a>";
                    
                }
                if($statusPengajuan=='ajukanpembatalan'){
                    $infoStatus="<div class='alert alert-danger' role='alert'>Menunggu persetujuan pembatalan dari HRD</div>";
                }
                 if($statusPengajuan=='finish' || $statusPengajuan=='batal'){
                   $infoStatus.="<div class='alert alert-info' role='alert'>".strtoupper($statusPengajuan)."</div>";
                    $btnRekomendasiPelamar="<a href='#collapse$no' data-toggle='collapse'  class='btn btn-default' data-parent='#accordion' style='margin-bottom:15px;' >Lihat rekomendasi pelamar <i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i></a>";
                }
            }else{
                if($statusPengajuan=='diajukan'){
                    $infoStatus="<div class='alert alert-info' role='alert'>Menunggu Persetujuan Atasan</div>";
                    $infoStatus.="<div class='alert alert-danger' role='alert'>Jika pengajuan ini akan dibatalkan, tekan tombol di dibawah ini dan isikan alasan pembatalan <button type='button' class='btn btn-danger btn-block btn-sm btnBatal' data-set='$id' data-nomor='$nomorErf' data-pengaju='$pengaju'> <i class='fa fa-ban' aria-hidden='true'></i> Batal</button></div>";
                }
    
                // if($statusPengajuan=='dihrd'){
                //     $infoStatus="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                //     $infoStatus.="<div class='alert alert-danger' role='alert'>Jika pengajuan ini akan dibatalkan, tekan tombol di dibawah ini dan isikan alasan pembatalan <button type='button' class='btn btn-danger btn-block btn-sm btnBatal' data-set='$id' data-nomor='$nomorErf' data-pengaju='$pengaju'> <i class='fa fa-ban' aria-hidden='true'></i> Batal</button></div>";
                // }
                if($statusPengajuan=='dihrd' && empty($linkAktif)){
                    $infoStatus="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                    $infoStatus.="<div class='alert alert-danger' role='alert'>Jika pengajuan ini akan dibatalkan, tekan tombol di dibawah ini dan isikan alasan pembatalan <button type='button' class='btn btn-danger btn-block btn-sm btnBatal' data-set='$id' data-nomor='$nomorErf' data-pengaju='$pengaju'> <i class='fa fa-ban' aria-hidden='true'></i> Batal</button></div>";
                }
    
                if($statusPengajuan=='dihrd' && !empty($linkAktif)){
                    $infoStatus.="<div class='alert alert-info' role='alert'>Proses HRD</div>";
                    $btnRekomendasiPelamar="<a href='#collapse$no' data-toggle='collapse'  class='btn btn-default' data-parent='#accordion' style='margin-bottom:15px;' >Lihat rekomendasi pelamar <i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i></a>";
                    $infoStatus.="<div class='alert alert-danger' role='alert'>Jika pengajuan ini akan dibatalkan, tekan tombol di dibawah ini dan isikan alasan pembatalan <button type='button' class='btn btn-danger btn-block btn-sm btnBatal' data-set='$id' data-nomor='$nomorErf' data-pengaju='$pengaju'> <i class='fa fa-ban' aria-hidden='true'></i> Batal</button></div>";
                }
                if($statusPengajuan=='ajukanpembatalan'){
                    $infoStatus="<div class='alert alert-danger' role='alert'>Menunggu persetujuan pembatalan dari HRD</div>";
                }
                 if($statusPengajuan=='finish' || $statusPengajuan=='batal'){
                   $infoStatus.="<div class='alert alert-info' role='alert'>".strtoupper($statusPengajuan)."</div>";
                    $btnRekomendasiPelamar="<a href='#collapse$no' data-toggle='collapse'  class='btn btn-default' data-parent='#accordion' style='margin-bottom:15px;' >Lihat rekomendasi pelamar <i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i></a>";
                }
            }
            

            

            $buildTableSpesifikasiKebutuhan="<table class='TableSpesifikasiKebutuhan'>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Posisi / Position</td><td>:</td><td>$posisi</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Dibutuhkan Tanggal / Required date</td><td>:</td><td>$tglDibutuhkan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Status Karyawan / Status Of Employees</td><td>:</td><td>$statusKaryawanDibutuhkan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Jenis Kelamin / Gender</td><td>:</td><td>$jenisKelamin</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Pendidikan / Education</td><td>:</td><td>$pendidikan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Pengalaman Kerja / Working Experience</td><td>:</td><td>$pengalamanKerja<br>Secara / in :$pengalamanSecara</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Penguasaan Bahasa / Language Proficiency</td><td>:</td><td>$penguasaanBahasa</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Penempatan / Station</td><td>:</td><td>$penempatan<br>$penempatanDetail</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Ketrampilan / Skills</td><td>:</td><td>$keterampilan</td></tr>";
            $buildTableSpesifikasiKebutuhan.="<tr><td>Persyaratan Lainnya / Other Requirement</td><td>:</td><td>$persyaratanLainnya</td></tr>";
            $buildTableSpesifikasiKebutuhan.="</table>";

            $queryListPelamar="SELECT * FROM (SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$id') link INNER JOIN `dtrecruitment`.pelamars  ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";

            $listPelamar=$this->User->query($queryListPelamar);

            $tablePelamar="";
            foreach($listPelamar as $pelamar){
                $linkId=$pelamar['link']['id'];
                $idErf=$pelamar['link']['idErf'];
                
                if($pelamar['link']['terpilih']=='ya'){
                    $terpilih="<i class='fa fa-check-circle fa-4x' aria-hidden='true'></i>";
                    $terpilihHead="<tr  class='success'><td colspan='2' style='padding:5px;text-align:center;'><strong>TERPILIH</strong></td></tr>";
                    $terPilihTglMasuk="<tr  class='success'><td style='padding:5px;text-align:center;'><strong>Tanggal Masuk</strong></td><td  style='padding:5px;'><strong>".date("d-m-Y",strtotime($pelamar['link']['tanggalMasuk']))."</strong></td></tr>";
                }else{
                    $terpilih="";
                    $terpilihHead="";
                    $terPilihTglMasuk="";
                }
                $pelamarId=$pelamar['pelamars']['id'];
                $pelamarNama=$pelamar['pelamars']['nama'];
                $pelamartanggalLahir=$pelamar['pelamars']['tanggalLahir']=='0000-00-00'?'-':date('d-m-Y',strtotime($pelamar['pelamars']['tanggalLahir']));
                $pelamarjenisKelamin=$pelamar['pelamars']['jenisKelamin'];
                $pelamaragama=$pelamar['pelamars']['agama'];
                $pelamaralamatTinggal=$pelamar['pelamars']['alamatTinggal'];
                $pelamarfoto=$pelamar['pelamars']['foto'];


                $tablePelamar.="<div class='col-md-4'><table class='table table-bordered' style='min-height:300px;'>";
                $tablePelamar.=$terpilihHead;  
                    $tablePelamar.="<tr><td width='200px'><div class='row'>
                                            <div class='col-xs-12'>
                                                <div class='thumbnail'>
                                                    <img src='$pelamarfoto' alt='' width='100%'>
                                                </div>
                                            </div>
                                        </div>";
                    $tablePelamar.="<td>
                                    <table width='100%' class='table table-bordered'>
                                        <tr><th width='30%'>Nama</th><td>$pelamarNama</td></tr>  
                                        <tr><th>Tanggal Lahir</th><td>".$pelamartanggalLahir."</td></tr>  
                                        <tr><th>Jenis Kelamin</th><td>".$pelamarjenisKelamin."</td></tr>  
                                        <tr><th>Agama</th><td>".$pelamaragama."</td></tr>  
                                        <tr><th>Domisili</th><td>".$pelamaralamatTinggal."</td></tr>  
                                    </table>      
                                </td></tr>";
                    $tablePelamar.=$terPilihTglMasuk;
                    $tablePelamar.="<tr><td colspan='2' style='padding:5px;text-align:center;color:#66A594'>$terpilih</td></tr>";            
                    $tablePelamar.="</table></div>";
            }    
            
            //var_dump($data);exit();
            $txtData.="<tr>";
            $txtData.="<td>".$no."</td>";
            $txtData.="<td style='font-size:14px;height: 34px;font-weight:700;'>".$nomorErf.$btnRekomendasiPelamar." </td>";
            $txtData.="<td>".$tglPengajuan."</td>";
            $txtData.="<td>".$dasarPermintaan."</td>";
            $txtData.="<td>$buildTableSpesifikasiKebutuhan</td>";
            $txtData.="<td style='vertical-align:middle;'>$infoStatus </td>";
            $txtData.="</tr>";
            $txtData.="<tr class='trEven' style='height:0px;'>
            <td colspan='10' style='background-color:#FFF; border-top:unset'>
                <div id='collapse$no' class='collapse out'>
                    <div class='col-md-12 well' style='margin-bottom:10px;margin-top:10px;'>
                        <div class='panel panel-default' style='margin-bottom:0px;'>          
                            <div class='panel-body'>
                                <div class='col-md-12'>
                                    <div class='row'> 
                                        
                                        $tablePelamar
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </td>
                </tr>";
            $no++;
        }

        echo $txtData."^".$linkHal;

    }

    public function pembatalan(){
        $this->autoRender = false;
		$this->loadModel('User');
		try{
			$dataSource = $this->User->getdatasource();
			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");

            //var_dump($_POST);exit();
            $idErf=$_POST['idErf'];
            $nomor=$_POST['nomor'];
            $pengaju=$_POST['pengaju'];
            $ket=$_POST['alasanPembatalan'];
            $tanggalApp=date('Y-m-d H:i:s');
            $sebagai='pemohon';
            $update="UPDATE dpfdplnew.erfpermintaankaryawans SET `statusPengajuan`='ajukanpembatalan',keteranganPembatalan='$ket' WHERE id='$idErf'";
            $this->User->query($update);


            $queryHistoryInsert="INSERT INTO dpfdplnew.erfhistorys (idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan)
            VALUES('$idErf','$nomor','$pengaju','$sebagai','$tanggalApp','ajukanpembatalan','$ket')";
            $this->User->query($queryHistoryInsert);
            //var_dump($_POST);exit();
            echo "sukses";
            
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }
    public function getPelamar()
    {
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
		$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

        $idErf=$_POST['idErf'];
       
        $queryListPelamar="SELECT * FROM (SELECT * FROM `dpfdplnew`.erfpelamarlinks WHERE idErf='$idErf' AND (penilaian='' OR penilaian IS  NULL)) link 
        INNER JOIN `dtrecruitment`.pelamars  ON `pelamars`.id=`link`.idPelamar ORDER BY `pelamars`.id";

        $listPelamar=$this->User->query($queryListPelamar);
        // /var_dump($queryListPelamar);exit();
        $txtData="";
        $no=1;
        foreach($listPelamar as $pelamar){
            $linkId=$pelamar['link']['id'];
            $idErf=$pelamar['link']['idErf'];
            $pelamarId=$pelamar['pelamars']['id'];
            $pelamarNama=$pelamar['pelamars']['nama'];
            $pelamartanggalLahir=$pelamar['pelamars']['tanggalLahir']=='0000-00-00'?'-':date('d-m-Y',strtotime($pelamar['pelamars']['tanggalLahir']));
            $pelamarjenisKelamin=$pelamar['pelamars']['jenisKelamin'];
            $pelamaragama=$pelamar['pelamars']['agama'];
            $pelamaralamatTinggal=$pelamar['pelamars']['alamatTinggal'];
            $pelamarfoto=$pelamar['pelamars']['foto'];


            //$pelamarLinkPhoto=$pelamar['pelamars'][''];

            $txtData.="<tr>";
            $txtData.="<td>$no</td>";
            $txtData.="<td><div class='row'>
                            <div class='col-xs-12'>
                                <img src='$pelamarfoto' alt='' width='100%'>
                            </div>
                        </div>";
            $txtData.="<td>
                            <table width='100%' class='table table-bordered'>
                                <tr><th width='30%'>Nama</th><td>$pelamarNama</td></tr>  
                                <tr><th>Tanggal Lahir</th><td>".$pelamartanggalLahir."</td></tr>  
                                <tr><th>Jenis Kelamin</th><td>".$pelamarjenisKelamin."</td></tr>  
                                <tr><th>Agama</th><td>".$pelamaragama."</td></tr>  
                                <tr><th>Domisili</th><td>".$pelamaralamatTinggal."</td></tr>  
                            </table>      
                        </td>";
            $txtData.="<td  style='vertical-align:middle;'>
                            <select class='form-control' name='rekomendasi$linkId' id='rekomendasi$linkId'>
                                <option value='' selected>Pilih Rekomendasi</option>
                                <option value='direkomendasi'>Direkomendasi</option>
                                <option value='tidak direkomendasi'>Tidak Direkomendasi</option>
                                <option value='dicadangkan'>Dicadangkan</option>
                            </select>
                        </td>";
            $txtData.="<td style='vertical-align:middle;'><textarea class='form-control' name='keteranganRekomendasi$linkId' id='keteranganRekomendasi$linkId' cols='30' rows='5' ></textarea></td>";
            $txtData.="<td style='vertical-align:middle;'><button type='button' class='btn btn-primary btnSubmitRekomendasi' data-linkid='$linkId' data-erf='$idErf'>Submit</button></td>";
            $txtData.="</tr>";
            $no++;
        }
       
        echo $txtData."^";
        exit();
        //var_dump($listPelamar);exit();
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
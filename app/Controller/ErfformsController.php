<?php
App::uses('AppController', 'Controller');
/*
    formulir black book
*/ 
class ErfformsController extends AppController{
    public $components = array('Function','Paginator');
	public  $pejIdAtasan="";
	public  $nikAtasan="";
    function index(){
        echo $this->Function->cekSession($this);
    }
public function getPejidAtasan($pejId){
  $this->autoRender = false;
  $this->loadModel('Bernofarmpengirimandana');
  $this->loadModel('User');

  $rsAtasan=$this->User->query("SELECT * FROM bernodb.old_maker_cheker INNER JOIN (SELECT * FROM bernodb.pejabat_divisi_lama WHERE tahun=".date('Y')." AND bulan=".date('m').")
pejabat_divisi_lama ON old_maker_cheker.cheker=pejabat_divisi_lama.pejid WHERE thn='".date('Y')."' AND bln=".date('m')." AND  maker='".$pejId."'");

  if(count($rsAtasan)>0){
   if(strpos($rsAtasan[0]['pejabat_divisi_lama']['nama_pejabat'],"vacant")!==FALSE){
   
    $this->getPejidAtasan($rsAtasan[0]['pejabat_divisi_lama']['pejid']);
    }
   else{
    
    $this->pejIdAtasan=$rsAtasan[0]['pejabat_divisi_lama']['pejid'];
    $this->nikAtasan=$rsAtasan[0]['pejabat_divisi_lama']['nik'];
   
    } 
   }
  
 }
    //onload get data awal
    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

	/*	if($this->Session->read("dpfdpl_groupId")!=100){
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
        $namaKaryawan=$this->Session->read("dpfdpl_namaKaryawan");
		$tglLahir=$this->Session->read("dpfdpl_tanggalLahir");
           //var_dump($namaKaryawan);exit();
		  // $nikCari=$rsKaryawan[0]['master_karyawan']["kodenik"];
        $dataAtasan=$this->getDataList();

        // $nikuserlogin="2010494";
		// $namaKaryawan="FENURIA HASAN";
		// $tglLahir="1982-02-10";

		$txtData="";  
		
		$querytext="SELECT * FROM (SELECT SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idkrynew,
            SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikkrynew,
            SUBSTRING_INDEX(GROUP_CONCAT(mk.jabatan ORDER BY mk.id ASC),',',-1) AS jabatannew,
            SUBSTRING_INDEX(GROUP_CONCAT(mk.kodedivisi ORDER BY mk.id ASC),',',-1) AS kodedivisinew,
            mk.namakry AS nmkrynew,mk.tgllahir AS tglLahirKaryawannew FROM absensi.master_karyawan mk WHERE mk.namakry like '%$namaKaryawan%' AND mk.tgllahir ='$tglLahir' AND mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir) mk ";
		$query=$this->Asset->query($querytext);
        $nikNew=$query[0]['mk']['nikkrynew'];
        $nmKryNew=$query[0]['mk']['nmkrynew'];
        $tglLahirNew=$query[0]['mk']['tglLahirKaryawannew'];
        $kodedivisiNew=$query[0]['mk']['kodedivisinew'];
        $jabatanNew=$query[0]['mk']['jabatannew'];

        //$txtData=$query[];
        echo $nikNew.'#'.$nmKryNew.'#'.$tglLahirNew.'~'.$nmKryNew.'~'.$kodedivisiNew.'~'.$jabatanNew.'~'.$dataAtasan;
        exit();
        
    }
    //simpan pengajuan form
    public function simpan(){
        $this->autoRender = false;
		$this->loadModel('User');
		try{
			$dataSource = $this->User->getdatasource();
			$dataSource->begin();
			date_default_timezone_set("Asia/Jakarta");
            //var_dump($_POST);exit();
            $year=date("Y");
            $month=date("m");
            $nomorErf=$this->generateNomor('erfpermintaankaryawans','nomorErf','ERF',$year,$month);
            $tglPengajuan=date('Y-m-d',strtotime($_POST['dateInput']));
            $pemohon=$_POST['pemohon'];
            $divisi=$_POST['divisi'];
            $jabatan=$_POST['jabatan'];
            $dasarPermintaan=$_POST['checkDasarPermintaanValue'];
          
                if($dasarPermintaan=='Lainnya'){
                    $dasarPermintaan=$_POST['DasarPermintaanLainnya'];
                }
           
               
            $posisi=$_POST['checkPosisiValue'];
            $posisilainnya=$_POST['posisiLainnya'];
            $tglDibutuhkan=date('Y-m-d',strtotime($_POST['tglDibutuhkan']));
               
            $statusKaryawan=$_POST['checkStatusKaryawanValue'];
            $ketStatus=$_POST['ketStatusKaryawan'];
            $jenisKelamin=$_POST['jenisKelaminValue'];
            $pendidikan=$_POST['checkPendidikanValue'];
            $pendidikanLain=$_POST['pendidikanLainnya'];
            $pengalamanKerja=$_POST['checkLamaPengalamanValue'];
            $pengalamanSecara=$_POST['secaraInValue'];
            $penguasaanBahasa=$_POST['checkBahasaValue'];//hilangkan koma dibelakang
            $checkPenempatanIndex=$_POST['checkPenempatanIndex'];
            //var_dump($_POST['penempatanDetail1']);exit();
           
            if($checkPenempatanIndex==0){
                $penempatanDetail=$_POST['penempatanDetail0'];
            }else{
                $penempatanDetail=$_POST['penempatanDetail1'];
            }
            
            
            //var_dump($checkPenempatanIndex);exit();
            $penempatan=$_POST['checkPenempatanValue'];
            //$penempatanDetail=$_POST[''];
            $keterampilan=$_POST['checkKeterampilanValue'];
            $keterampilanLain=$_POST['checkKeterampilanLain'];
            $persyaratanLainnya=$_POST['persyaratanLain'];
            $ttjOrlainnya=$_POST['ttjOrlainnya'];
            $perluApproval=$_POST['perluApproval'];//true insertkan approval,status diajukan, false status langsung dihrd
            //var_dump($perluApproval);exit();
            if($perluApproval=='true'){
                $statusPengajuan='diajukan';
                $atasan=$_POST['atasan'];
            }else{
                $statusPengajuan='dihrd';
                $atasan="";
            }
           
            //dengan pengalamanSecara
            // $queryInsertERF="INSERT INTO dpfdplnew.`erfpermintaankaryawans` (nomorErf,tglPengajuan,pemohon,divisi,jabatan,dasarPermintaan,posisi,posisilainnya,tglDibutuhkan,statusKaryawan,ketStatus,jenisKelamin,pendidikan,pendidikanLain,pengalamanKerja,pengalamanSecara,penguasaanBahasa,penempatan,penempatanDetail,keterampilan,keterampilanLain,persyaratanLainnya,ttjOrlainnya,statusPengajuan,atasan1)VALUES('$nomorErf','$tglPengajuan','$pemohon','$divisi','$jabatan','$dasarPermintaan','$posisi','$posisilainnya','$tglDibutuhkan','$statusKaryawan','$ketStatus','$jenisKelamin','$pendidikan','$pendidikanLain','$pengalamanKerja','$pengalamanSecara','$penguasaanBahasa','$penempatan','$penempatanDetail','$keterampilan','$keterampilanLain','$persyaratanLainnya','$ttjOrlainnya','$statusPengajuan','$atasan')";

            //tanpa pengalaman secara
            $queryInsertERF="INSERT INTO dpfdplnew.`erfpermintaankaryawans` (nomorErf,tglPengajuan,pemohon,divisi,jabatan,dasarPermintaan,posisi,posisilainnya,tglDibutuhkan,statusKaryawan,ketStatus,jenisKelamin,pendidikan,pendidikanLain,pengalamanKerja,penguasaanBahasa,penempatan,penempatanDetail,keterampilan,keterampilanLain,persyaratanLainnya,ttjOrlainnya,statusPengajuan,atasan1)VALUES('$nomorErf','$tglPengajuan','$pemohon','$divisi','$jabatan','$dasarPermintaan','$posisi','$posisilainnya','$tglDibutuhkan','$statusKaryawan','$ketStatus','$jenisKelamin','$pendidikan','$pendidikanLain','$pengalamanKerja','$penguasaanBahasa','$penempatan','$penempatanDetail','$keterampilan','$keterampilanLain','$persyaratanLainnya','$ttjOrlainnya','$statusPengajuan','$atasan')";
            //var_dump($queryInsertERF);exit();
            $this->User->query($queryInsertERF);
            //var_dump($atasan);exit();

            //exit();
            //get last record;

            $getId=$this->User->query("SELECT id,nomorErf,pemohon FROM dpfdplnew.`erfpermintaankaryawans` WHERE pemohon='$pemohon' order by id desc limit 1");	//get by nama,tgl penilai dan nama,tanggal karyawan
				if(count($getId)>0){
					foreach($getId as $data){
						$idErf=$data["erfpermintaankaryawans"]["id"];
                        $noErf=$data["erfpermintaankaryawans"]["nomorErf"];
                        $nama=$data["erfpermintaankaryawans"]["pemohon"];
					}
				}
            $sebagai='pemohon';
            $tanggalApp=date('Y-m-d H:i:s');
            //$statusApp='NULL';
            $insertHistoryErf="INSERT INTO dpfdplnew.`erfhistorys`(idErf,noErf,nama,sebagai,tanggalApp,statusApp,keterangan) value ('$idErf','$noErf','$nama','$sebagai','$tanggalApp',NULL,NULL)";
            //var_dump($insertHistoryErf);exit();
            $this->User->query($insertHistoryErf);

            echo "sukses";
            
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
        
    }

    //generate nomor pengajuan

    public function generateNomor($tabel,$field,$pref,$thn,$bln){
        $this->autoRender = false;
        $this->loadModel('User');
		$nomor="";
        $prefId=$pref.$thn.'-'.$bln;
       
        $query=$this->User->query("select $field from $tabel f2 WHERE f2.id = (select max(id) from $tabel)");
        $row=count($query);
        
         
        if($row==0){
            $nomor=$prefId.'-'."001";
            return $nomor;
        }

        $getLastNomor=$query[0]["f2"]["$field"];
        if(empty($getLastNomor)){
            $nomor=$prefId.'-'."001";
            return $nomor;
        }
         
        $subPrefLasNomor=substr($getLastNomor,0,10);
        if($subPrefLasNomor==$prefId){
            $maxId=substr($getLastNomor,strlen($subPrefLasNomor)+1,3);
            $maxId=$maxId+1001;
            $maxId=substr($maxId,1,3);
            $nomor=$prefId.'-'.$maxId;
        }else{
            $nomor=$prefId.'-'."001";
        }

        return $nomor;
		
    }
    //function get atasan

    function getDataList(){
        $dataNama="";
    //$dataNama[]=array('label'=>'Pilih Nama Karyawan','value'=>'-');	
        $dataNama2="";
    //$dataNama2[]=array('label'=>'Pilih Nama Karyawan','value'=>'-');	
        $this->loadModel('Asset');
        $this->loadModel('User');
        $this->autoRender = false;
        //echo $this->Session->read("dpfdpl_groupId");exit();
        if($this->Session->read("dpfdpl_groupId")==13 || $this->Session->read("dpfdpl_groupId")==6 || $this->Session->read("dpfdpl_groupId")==7){
        $atasan1=$this->getPejidAtasan($this->Session->read('dpfdpl_pejabatId'));
        $atasan1=$this->pejIdAtasan."-!-".$this->nikAtasan;
        $atasan1Pecah=explode("-!-",$atasan1);
            //var_dump($atasan1Pecah);exit();
        $rsAtasan1=$this->User->query("select * From uploadsales.masteridmkts where id='".$atasan1Pecah[1]."' ");
        if(count($rsAtasan1)>0){
                foreach($rsAtasan1  as $row){
            $rsKaryawanAtasan1=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row['masteridmkts']['nik']."'");
            
            //jika data master_karyawan belum ada (karyawan baru)
            if(count($rsKaryawanAtasan1)<=0){
                    $this->User->setDataSource('local');
                    $rsKaryawanAtasan1=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$row['masteridmkts']['nik']."'");
                    }
                $namaAtasan1=$rsKaryawanAtasan1[0]['master_karyawan']["namakry"];
                $tglLahirAtasan1=$rsKaryawanAtasan1[0]['master_karyawan']["tgllahir"];
                $jabatanAtasan1=$rsKaryawanAtasan1[0]['master_karyawan']["jabatan"];
                //$dataNama[]=array('label'=>strtoupper(str_replace("/","-",$namaAtasan1." - ".$jabatanAtasan1)),'value'=>$namaAtasan1."#".$tglLahirAtasan1);
                $dataNama=$namaAtasan1."#".$tglLahirAtasan1;
                //GET ATASAN 2 JIKA ADA
                
                    $atasan2=$this->getPejidAtasan($atasan1Pecah[0]);
                    $atasan2=$this->pejIdAtasan."-!-".$this->nikAtasan;
        $atasan2Pecah=explode("-!-",$atasan2);
        $rsAtasan2=$this->User->query("select * From uploadsales.masteridmkts where id='".$atasan2Pecah[1]."' ");
        if(count($rsAtasan2)>0){
                foreach($rsAtasan2  as $row2){
            $rsKaryawanAtasan2=$this->Asset->query("SELECT * FROM absensi.master_karyawan WHERE kodenik='".$row2['masteridmkts']['nik']."'");
            //jika data master_karyawan belum ada (karyawan baru)
            if(count($rsKaryawanAtasan2)<=0){
                    $this->User->setDataSource('local');
                    $rsKaryawanAtasan2=$this->User->query("SELECT nik kodenik,namakaryawan namakry,tanggallahir tgllahir,'' kodedept,'' jabatan FROM portalberno.dtkaryawans  master_karyawan WHERE nik='".$row2['masteridmkts']['nik']."'");
                    }
            
                $namaAtasan2=$rsKaryawanAtasan2[0]['master_karyawan']["namakry"];
                $tglLahirAtasan2=$rsKaryawanAtasan2[0]['master_karyawan']["tgllahir"];
                $jabatanAtasan2=$rsKaryawanAtasan2[0]['master_karyawan']["jabatan"];
                //$dataNama2[]=array('label'=>strtoupper(str_replace("/","-",$namaAtasan2." - ".$jabatanAtasan2)),'value'=>$namaAtasan2."#".$tglLahirAtasan2);
                $dataNama2=$namaAtasan2."#".$tglLahirAtasan2;
                }
            }
                
                }
            }
        }
        else{

                $rsAtasan=$this->Asset->query("SELECT * FROM (SELECT * FROM absensi.hirakinonmkt WHERE nik IN (SELECT kodenik FROM absensi.master_karyawan WHERE CONCAT(namakry,tgllahir) IN(
                SELECT CONCAT(namakry,tgllahir) FROM absensi.master_karyawan WHERE namakry='".$this->Session->read('dpfdpl_namaKaryawan')."' and tglLahir='".$this->Session->read('dpfdpl_tanggalLahir')."'))) hirarkinonmkt LEFT JOIN 
                absensi.master_karyawan atasan1 ON atasan1.kodenik=nikatasan1 LEFT JOIN 
                absensi.master_karyawan atasan2 ON atasan2.kodenik=nikatasan2 LEFT JOIN absensi.`hirakinonmkt` dataatasan1 ON dataatasan1.`nik`=hirarkinonmkt.nikatasan1
                LEFT JOIN absensi.`hirakinonmkt` dataatasan2 ON dataatasan2.`nik`=hirarkinonmkt.nikatasan2
                ");
            if(count($rsAtasan)<=0){
            
                    $rsAtasan=$this->Asset->query("SELECT * FROM (SELECT * FROM absensi.hirakinonmkt WHERE namakry='".$this->Session->read('dpfdpl_namaKaryawan')."' and tglLahir='".$this->Session->read('dpfdpl_tanggalLahir')."') hirarkinonmkt LEFT JOIN 
                    absensi.master_karyawan atasan1 ON atasan1.kodenik=nikatasan1 LEFT JOIN 
                    absensi.master_karyawan atasan2 ON atasan2.kodenik=nikatasan2");
                }
    
    
    
    
    if(count($rsAtasan)>0){
        //$dataNama[]=array('label'=>strtoupper(str_replace("/","-",$rsAtasan[0]['atasan1']['namakry']." - ".$rsAtasan[0]['atasan1']['jabatan'])),'value'=>$rsAtasan[0]['atasan1']['namakry']."#".$rsAtasan[0]['atasan1']['tgllahir']."#".$rsAtasan[0]['dataatasan1']['hpkaryawan']);
        $dataNama=$rsAtasan[0]['atasan1']['namakry']."#".$rsAtasan[0]['atasan1']['tgllahir'];
        if(trim($rsAtasan[0]['hirarkinonmkt']['nikatasan2'])<>''){
        //$dataNama2[]=array('label'=>strtoupper(str_replace("/","-",$rsAtasan[0]['atasan2']['namakry']." - ".$rsAtasan[0]['atasan2']['jabatan'])),'value'=>$rsAtasan[0]['atasan2']['namakry']."#".$rsAtasan[0]['atasan2']['tgllahir']."#".$rsAtasan[0]['dataatasan2']['hpkaryawan']);
        $dataNama2=$rsAtasan[0]['atasan2']['namakry']."#".$rsAtasan[0]['atasan2']['tgllahir'];
        }
        else{
           // $dataNama2[]=array('label'=>"",'value'=>"-");
            }
                
        }
    }
    //tampil atasan 1
    //var_dump ($dataNama);exit();
    return $dataNama;
    //echo json_encode($dataNama)."##".json_encode($dataNama2);
    }

}
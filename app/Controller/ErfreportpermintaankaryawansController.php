<?php
App::uses('AppController', 'Controller');
/*
    Employee Reqruitment Form Return Rekomendasi
*/ 
class ErfreportpermintaankaryawansController extends AppController{
    public $components = array('Function','Paginator');
    function index(){
        echo $this->Function->cekSession($this);
    }
    public function getData(){
        $this->autoRender = false;
        $this->loadModel('User');
           
        //var_dump($_POST);exit();

        //filter permintaan
        $tahun             =$_POST["tahun"];
        $bulan             =$_POST["bulan"]>9?$_POST["bulan"]:"0".$_POST["bulan"];
        $reportPermintaan  =$_POST["reportPermintaan"];

        if($reportPermintaan=="perbulan"){
            $filterPermintaan="";
        }elseif($reportPermintaan=="outstatnding"){
            $filterPermintaan=" AND erf.`statusPengajuan` <>'finish' AND erf.`statusPengajuan`<>'batal' AND elink.`terpilihIsi` IS NULL";
        }elseif($reportPermintaan=="realisasi"){
            $filterPermintaan=" AND elink.`jmlTerpilih` IS NOT NULL AND elink.`jmlTerpilih` <>0";
        }elseif($reportPermintaan=="finish"){
            $filterPermintaan=" AND erf.`statusPengajuan`='finish'";
        }
       
        $qry="SELECT erf.`tglPengajuan`,erf.`pemohon`,SUM(erf.1) jmlP1,SUM(erf.2) jmlP2,SUM(erf.3) jmlP3,SUM(erf.4) jmlP4,SUM(erf.5) jmlP5,
            IF(erf.jmlKandidat IS NULL,0,SUM(erf.jmlKandidat))jmlKandidat,
            IF(erf.jmlTerpilih IS NULL,0,SUM(erf.jmlTerpilih))jmlTerpilihGroup,
            IF(erf.jmlTidakTerpilih IS NULL,0,SUM(erf.jmlTidakTerpilih))jmlTidakTerpilihGroup FROM 
            (SELECT erf.`id`,erf.`tglPengajuan`,erf.`pemohon`,`erf`.statusPengajuan,
            IF(erf.`dasarPermintaan`='Rencana dan Anggaran Tahunan (RAT) HRD #Plan and Annual Budget (RAT) HRD',1,0) '1',
            IF(erf.`dasarPermintaan`='Penggantian karyawan yang mengundurkan diri  #Substitution for resigned employee',1,0) '2',
            IF(erf.`dasarPermintaan`='Penggantian sementara karyawan yang cuti/berhalangan sementara (seijin Perusahaan) #Temporary substitution for absent employee/temporary absent (permission of the Company)',1,0) '3',
            IF(erf.`dasarPermintaan`='Pengembangan usaha/volume pekerjaan yang bertambah banyak (diluar RAT HRD) #Busines development/increases in work load (outside RAT HRD)',1,0) '4',
            IF(erf.`dasarPermintaan`='Rencana dan Anggaran Tahunan (RAT) HRD #Plan and Annual Budget (RAT) HRD',0,
            IF(erf.`dasarPermintaan`='Penggantian karyawan yang mengundurkan diri  #Substitution for resigned employee',0,
            IF(erf.`dasarPermintaan`='Penggantian sementara karyawan yang cuti/berhalangan sementara (seijin Perusahaan) #Temporary substitution for absent employee/temporary absent (permission of the Company)',0,
            IF(erf.`dasarPermintaan`='Pengembangan usaha/volume pekerjaan yang bertambah banyak (diluar RAT HRD) #Busines development/increases in work load (outside RAT HRD)',0,1)))) '5',elink.*
            FROM `dpfdplnew`.`erfpermintaankaryawans` erf 
            LEFT JOIN (SELECT elink.`iderf`,elink.`nomorErf`,COUNT(elink.`nomorErf`) jmlKandidat,GROUP_CONCAT(elink.`terpilih`)terpilihIsi,SUM(elink.terpilihYa) jmlTerpilih,SUM(elink.terpilihTidak) jmlTidakTerpilih FROM 
            (SELECT elink.`idErf`,elink.`nomorErf`, elink.`terpilih`, IF(elink.`terpilih`='ya',1,0) terpilihYa, IF(elink.`terpilih`='tidak',1,0) terpilihTidak 
            FROM dpfdplnew.`erfpelamarlinks` elink) elink GROUP BY elink.idErf) elink ON elink.idErf=erf.id WHERE erf.tglPengajuan LIKE '%".$tahun."-".$bulan."%' $filterPermintaan) erf GROUP BY erf.`pemohon`,erf.`tglPengajuan`";
            //echo $qry;exit();
            
        $hsl=$this->User->query($qry);
           
        $jum=count($hsl);
        $txt=""; 
        $jmlTotP1=0;
        $jmlTotP2=0;
        $jmlTotP3=0;
        $jmlTotP4=0;
        $jmlTotP5=0;
        if($jum==0){
            $txt="";
        }else{
            $i=1;
            
            foreach($hsl as $result){
               
                $tglPengajuan=$this->Function->dateindo($result['erf']['tglPengajuan']);
                $pemohon=explode("#",$result['erf']['pemohon']);
                $pemohon=$pemohon[0]."#".$pemohon[1];
                
                $dp1=$result[0]['jmlP1'];
                $dp2=$result[0]['jmlP2'];
                $dp3=$result[0]['jmlP3'];
                $dp4=$result[0]['jmlP4'];
                $dp5=$result[0]['jmlP5'];
                $jmlKandidat=$result[0]["jmlKandidat"];
                $jmlTerpilihGroup=$result[0]["jmlTerpilihGroup"];
                $jmlTidakTerpilihGroup=$result[0]["jmlTidakTerpilihGroup"];
                
                
                $jmlPerBaris=(int)$dp1+(int)$dp2+(int)$dp3+(int)$dp4+(int)$dp5;
               
                $txt=$txt."$i|".$tglPengajuan."|".$pemohon."|".$dp1."|".$dp2."|".$dp3."|".$dp4."|".$dp5."|".$jmlPerBaris."^";
                $i++;

                $jmlTotP1=$jmlTotP1+(int)$result[0]['jmlP1'];
                $jmlTotP2=$jmlTotP2+(int)$result[0]['jmlP2'];
                $jmlTotP3=$jmlTotP3+(int)$result[0]['jmlP3'];
                $jmlTotP4=$jmlTotP4+(int)$result[0]['jmlP4'];
                $jmlTotP5=$jmlTotP5+(int)$result[0]['jmlP5'];                
            }
        }
        $jumTotPengajuan=(int)$jmlTotP1+(int)$jmlTotP2+(int)$jmlTotP3+(int)$jmlTotP4+(int)$jmlTotP5;
        //$txt=$txt."|||".$jmlTotP1."|".$jmlTotP2."|".$jmlTotP3."|".$jmlTotP4."|"$jmlTotP5."|".$jumTotPengajuan."^";
        
        //echo $txt."!".$jum."!".$qry."!".$this->Session->read('dpfdpl_namaUser');
        echo $txt."!".$jmlTotP1."!".$jmlTotP2."!".$jmlTotP3."!".$jmlTotP4."!".$jmlTotP5."!".$jumTotPengajuan;
        exit();
        
    }

    public function cetakexcel(){
        $this->autoRender = false;
        $buffer=$_POST['buffer'];
        $bulan=$_POST['bulan'];
        $tahun=$_POST['tahun'];
        $reportPermintaan=$_POST['reportPermintaan'];

        if($reportPermintaan=="perbulan"){
            $namaSheet="Report Permintaan karyawan perbulan";
        }elseif($reportPermintaan=="outstatnding"){
            $namaSheet="Report Pengajuan yang masih outstanding";
        }elseif($reportPermintaan=="realisasi"){
            $namaSheet="Report Realisasi";
        }elseif($reportPermintaan=="finish"){
            $namaSheet="Report Finish";
        }
        //var_dump($_POST);exit();
        $this->set('buffer',$buffer);
        $this->set('namaSheet',$reportPermintaan);
        $this->set('reportPermintaan',$namaSheet);
        $this->set('bulan',$bulan);
        $this->set('tahun',$tahun);
        $this->render('cetakexcel');
    }

}
<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Laporan atasan penilai
 *  berisi daftar yang dinilai oleh atasan
 *  referent DB kpireg
 */
class  PalaporanatasanpenilaisController extends AppController {
    public $components = array('Function','Paginator'); 
    public function index(){
        echo $this->Function->cekSession($this);
    }

    public function getData(){
        $this->autoRender = false;
		$this->loadModel('Asset');
		$this->loadModel('User');
		$this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

         //filter
         //var_dump($_POST);exit();
        $hm=$_POST['hal'];
                       
         
        $txtData='';
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
        
        $sqlQuery="SELECT CONCAT(hps.`nikatasan`,' - ',hps.`nmatasan`) atasan,GROUP_CONCAT(hps.`niknama`) karyawanDinilai FROM (SELECT CONCAT(h.`nikkry`,' - ',h.`nmkry`) niknama,h.* FROM kpireg.`pahirarkis` h INNER JOIN kpireg.`paperuntukansoals` ps ON ps.`namakry`=h.`nmkry` AND ps.`tgllahir`=h.`tglLahirKaryawan` WHERE h.`sebagai`='atasan'
         GROUP BY ps.`namakry`,ps.`tgllahir`) hps GROUP BY hps.`nmatasan`,hps.`tglLahirAtasan` ORDER BY hps.`nmatasan`";

        $resultQuery=$this->Asset->query($sqlQuery);

        $jumQuery=count($resultQuery);
        //$sum=ceil($jumQuery/$limit);
        //var_dump($sum);exit();

         /* -----------------------------Navigasi Record ala google style ----------------------------- */
         //$linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
         /* -----------------------------End Navigasi Record ala google style ----------------------------- */
         //$rsTampil=$this->Asset->query($sql." limit $start, $limit");
         $n=$start+1;
        
         $n=1;
         if($jumQuery==0 || $jumQuery==Null){
         
           $txtData.="
               <tr>
                    <td colspan=3 style='text-align:center;'>Kosong</td>
               </tr>";
           }else{
                foreach($resultQuery as $data){  
                    //var_dump($data);exit();    
                    $atasan=$data[0]['atasan'];
                    $karyawanDinilai=explode(',',$data[0]['karyawanDinilai']);
                    // var_dump($karyawanDinilai);exit();
                    $jmlKarDinilai=count($karyawanDinilai);
                    $txtData.="<tr class='batas'>
                        <td width='3%' style='vertical-align:middle;text-align:center' id='id".$n."' rowspan='$jmlKarDinilai'>".$n.".</td>
                        <td width='50%' style='vertical-align:middle;' rowspan='$jmlKarDinilai'>$atasan</td>
                        <td width='3%'>1. </td><td width='47%'>".$karyawanDinilai[0]."</td></tr>";
                        for($i=1;$i<$jmlKarDinilai;$i++){
                            $j=$i+1;
                            $txtData.="<tr><td  width='3%'>".$j.".</td><td width='47%'> ".$karyawanDinilai[$i]."</td></tr>";
                           }
                     
                            
                            
                   
                    $n++;
                }
               
                
           }
           echo $txtData;
        //var_dump($resultQuery);exit();
    }

    public function cetakexcel(){
        //$this->loadModel('Bernofarmpengirimandana');
        $this->loadModel('Asset');
        //$tanggal=$_GET["tanggal"];
        //$tanggalAkhir=$_GET["akhir"];
    
        //$ids=$this->Session->read('dpfdpl_userId');
        $headLaporan="no|Atasan|-|Karyawan Dinilai";
            
                
        // if(!empty($tanggal)){
        //     $tanggalLuar=$this->Function->dateluar($tanggal);
        // }
        // if(!empty($tanggalAkhir)){
        //     $tglAkhir=$this->Function->dateluar($tanggalAkhir);
        // }
        //$query="SELECT * FROM definance.transaksirekenings ta WHERE ta.tanggal between '$tglAwal' and '$tglAkhir'";
        $hasil=$this->Asset->query("SELECT CONCAT(hps.`nikatasan`,' - ',hps.`nmatasan`) atasan,GROUP_CONCAT(hps.`niknama`) karyawanDinilai FROM (SELECT CONCAT(h.`nikkry`,' - ',h.`nmkry`) niknama,h.* FROM kpireg.`pahirarkis` h INNER JOIN kpireg.`paperuntukansoals` ps ON ps.`namakry`=h.`nmkry` AND ps.`tgllahir`=h.`tglLahirKaryawan` WHERE h.`sebagai`='atasan'
        GROUP BY ps.`namakry`,ps.`tgllahir`) hps GROUP BY hps.`nmatasan`,hps.`tglLahirAtasan` ORDER BY hps.`nmatasan`");
         //$hslQuery=$this->User->query($query);
            $namaAkun="";
            $bodyLaporan="";
            if(count($hasil)>0){
                $no=1;
                foreach($hasil as $hslLaporan){
                    $atasan=$hslLaporan[0]['atasan'];
                    $karyawanDinilai=explode(',',$hslLaporan[0]['karyawanDinilai']);
                    $jmlKarDinilai=count($karyawanDinilai);
                    $bodyLaporan.=$no."|"."$atasan"."|1|".$karyawanDinilai[0]."^";
                    for($i=1;$i<$jmlKarDinilai;$i++){
                        $j=$i+1;
                        $bodyLaporan.="||".$j."|".$karyawanDinilai[$i]."^";
                    }
                $no++;			
                }
            } 

            
            //var_dump($bodyLaporan);exit();
            $this->set('namaAkun',$namaAkun);
            $this->set('headLaporan',$headLaporan);
            $this->set('bodyLaporan',$bodyLaporan);
            
            //$this->set('tanggal',$tanggal);
            //$this->set('tanggalAkhir',$tanggalAkhir);
            $this->set('namesheet1',"Laporan Atasan Penilai");
            //var_dump($bodyRekonsel);exit();
    }
}
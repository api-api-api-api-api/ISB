<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Linkperuntukan soal
 *  referent DB kpireg
 */
class  PalinkperuntukansoalsController extends AppController {
    public $components = array('Function','Paginator'); 
    public function index(){
        echo $this->Function->cekSession($this);
    }
    //ambil periode dan status periode
    function getPeriode(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        $txtData="";
        $id=$_POST['id'];
        $selected='';
        //$hasil=$this->Asset->query("SELECT * FROM kpireg.paperiodepenilaians WHERE status='EDITABLE' ORDER BY id");
        $hasil=$this->Asset->query("SELECT * FROM kpireg.paperiodepenilaians WHERE status='EDITABLE' ORDER BY id");
        $jmlPeriode=count($hasil);
        if($jmlPeriode<1){
             $txtData.="<option value='' $selected>Belum ada periode dibuka</option>";
             echo $txtData.'|NOEDITABLE';
             return;
        }

        $txtData="<option value=''>-Pilih Periode-</option>";
        foreach($hasil as $periode){
            $periodeId=$periode['paperiodepenilaians']['id'];
            $periodeStart   =date('d-m-Y',strtotime($periode['paperiodepenilaians']['periodeStart']));
            $periodeEnd     =date('d-m-Y',strtotime($periode['paperiodepenilaians']['periodeEnd']));
            $tahun          =$periode['paperiodepenilaians']['tahun'];
            if($id===$periode){
                $selected='selected';
            }else{$selected='';}
            $txtData.="<option value='".$periode['paperiodepenilaians']['id']."' $selected>".$periodeStart.' s/d '.$periodeEnd.' ('.$tahun.")</option>";
        }               
        echo $txtData."|EDITABLE";   
    }

    //ambil karyawan
    function setKaryawan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        $txtData=""; 

        //filter
        $divisi=$_POST["divisi"];
        $jabatan=$_POST["jabatan"];
        $bagian=$_POST["bagian"];
        $txttext=$_POST["txttext"];

        //get nik yang sudah di set
        $notid="";
        //$dataNik =$this->Asset->query("SELECT nik FROM kpireg.`paperuntukansoals` GROUP BY nik ");
       
        $dataId =$this->Asset->query("SELECT CONCAT(namakry,tgllahir) namatgllhr FROM kpireg.`paperuntukansoals` GROUP BY namakry,tgllahir ");
 
        if(count($dataId)> 0){
            foreach($dataId as $dataidisi){
                $idisi=$dataidisi[0]['namatgllhr'];
                $notid.="'".$idisi."',"; 
 
            }
            // $notnik=substr($notnik,0,strlen($notnik)-1);
            // $notnik=" AND ma.`kodenik` NOT IN (".$notnik.")";
            $notid=substr($notid,0,strlen($notid)-1);
            $notid=" AND ma.kodenik<>''  AND CONCAT(ma.`namakry`,ma.`tgllahir`) NOT IN (".$notid.")";

        }

       // var_dump($notnik);exit();
       $this->loadModel('Asset');
        $query="SELECT * FROM (SELECT 
        SUBSTRING_INDEX(GROUP_CONCAT(ma.id ORDER BY ma.id ASC),',',-1) AS idkrynew,
        SUBSTRING_INDEX(GROUP_CONCAT(ma.kodenik ORDER BY ma.id ASC),',',-1) AS niknew,
        SUBSTRING_INDEX(GROUP_CONCAT(ma.kodebagian ORDER BY ma.id ASC),',',-1) AS kodebagiannew,
        SUBSTRING_INDEX(GROUP_CONCAT(ma.jabatan ORDER BY ma.id ASC),',',-1) AS jabatannew,
        SUBSTRING_INDEX(GROUP_CONCAT(ma.kodedivisi ORDER BY ma.id ASC),',',-1) AS kodedivisinew,
        ma.* FROM absensi.`master_karyawan` ma WHERE ma.`tglkeluar` >CURDATE()  $notid group by ma.`namakry`,ma.`tgllahir`)ma WHERE  ma.`kodedivisinew` like '%$divisi%' AND ma.`jabatannew` like'%$jabatan%' AND ma.`kodebagiannew` like '%$bagian%' AND (ma.`niknew` like '%$txttext%' OR ma.`namakry` like '%$txttext%')  order by ma.niknew";
        //var_dump($query);exit();
        $runQuery=$this->Asset->query($query);
       
        $jumQuery=count($runQuery);
       
        if($jumQuery<1){

            $txtData="<tr><td colspan='10'>Data Kosong</td></tr>";
            echo  $txtData;
            exit();
        }


        $no=1;
        foreach($runQuery as $datain){
            $id=$datain['ma']['idkrynew'];
            $nik=$datain['ma']['niknew'];
            $nama=$datain['ma']['namakry'];
            $jabatan=$datain['ma']['jabatannew'];
            $bagian=$datain['ma']['kodebagiannew'];
            $divisi=$datain['ma']['kodedivisinew'];
            $txtData.="<tr><td width='30px'>$no</td>";
            //$txtData.="<td width='20px'><input type='checkbox' name='checknik' class='checknik' id='checknik".$nik."' value='$nik' onclick=\"checkthis('".$nik."')\"></td>";
            $txtData.="<td width='30px'><input type='checkbox' name='checkid' class='checkid' id='checkid".$id."' value='$id' onclick=\"checkthis('".$id."')\"></td>";
            $txtData.="<td id='tdNik".$id."'>$nik</td>";
            $txtData.="<td id='tdNama".$id."'>$nama</td>";
            $txtData.="<td>$jabatan</td>";
            $txtData.="<td>$bagian</td>";
            $txtData.="<td>$divisi</td></tr>";
            $no++;
            //var_dump($datain);exit();
        }
        echo $txtData;
    }


    function getData(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        $txtData="";

        $hm=$_POST['hal'];

        $fungsi="getData";
        
        //filter
        $filter = $_POST['filter'];
        $limit=10;
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}
        $this->loadModel('Asset');

        $qryGetNik="SELECT idkry,namakry,tgllahir FROM kpireg.`paperuntukansoals` ps GROUP BY namakry,tgllahir ";
        $dataReady=$this->Asset->query($qryGetNik);

        $filterIn="";
        $namaTglLhr=[];
        if(count($dataReady)>0){
            foreach($dataReady as $nmtgllahir){
                $filterIn.='"'.$nmtgllahir['ps']['namakry'].$nmtgllahir['ps']['tgllahir'].'",';
            }
            $filterIn=substr($filterIn,0,strlen($filterIn)-1);
        }else{
            $filterIn="''";
        }
       
        $query="SELECT * FROM (SELECT 
        SUBSTRING_INDEX(GROUP_CONCAT(tblMa.id ORDER BY tblMa.id ASC),',',-1) AS idnew,
        SUBSTRING_INDEX(GROUP_CONCAT(tblMa.kodenik ORDER BY tblMa.id ASC),',',-1) AS niknew,
        SUBSTRING_INDEX(GROUP_CONCAT(tblMa.kodebagian ORDER BY tblMa.id ASC),',',-1) AS bagian,
        SUBSTRING_INDEX(GROUP_CONCAT(tblMa.jabatan ORDER BY tblMa.id ASC),',',-1) AS jabatannew,
        SUBSTRING_INDEX(GROUP_CONCAT(tblMa.kodedivisi ORDER BY tblMa.id ASC),',',-1) AS divisinew,
        tblMa.* FROM absensi.master_karyawan tblMa GROUP BY tblMa.namakry,tblMa.tgllahir
        ) tblMa WHERE  CONCAT(tblMa.`namakry`,tblMa.`tgllahir`) IN ($filterIn) 
        AND (tblMa.kodenik LIKE '%$filter%' OR tblMa.namakry LIKE '%$filter%' ) ORDER BY tblMa.`namakry`";
       //var_dump($query);exit();

        
        $dataQuery=$this->Asset->query($query);
        
        $jumQuery=count($dataQuery);
        $sum=ceil($jumQuery/$limit);

        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->Asset->query($query." limit $start, $limit");
        //var_dump($Qtampil);exit();

        $no=$start+1;
      
        if($jumQuery==0 || $jumQuery==Null){
            $txtData="
            <tr>
            <td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
            </tr>";
            return $txtData."^";
        }

        foreach($Qtampil as $dataRow){
            //var_dump($dataRow);exit();
            $id         = $dataRow['tblMa']['idnew'];
            $kodenik    = $dataRow['tblMa']['niknew'];
            $namakry    = $dataRow['tblMa']['namakry'];
            $bagian     = $dataRow['tblMa']['bagian'];
            $jabatan    = $dataRow['tblMa']['jabatan'];
            $divisi     = $dataRow['tblMa']['divisinew'];
            $idKry      = $dataRow['tblMa']['idnew'];
            $tgllahir   = $dataRow['tblMa']['tgllahir'];

            $txtData.="<tr id=\"tr$kodenik\" class=\"tab\"><td align=\"center\">$no</td>";
            $txtData.="<td align=\"left\">$kodenik</td>";
            $txtData.="<td align=\"left\">$namakry</td>";
            $txtData.="<td align=\"left\">$bagian</td>";
            $txtData.="<td align=\"left\">$jabatan</td>";
            $txtData.="<td align=\"left\">$divisi</td>";
            $txtData.="<td align=\"center\"><a href='javascript:void(0)' id='btn".$id."'
                    style=\"color:brown;font-size:11px;\"class=\"linkAkses\" onclick=\"detail('$id')\" data-spy=\"scroll\" data-target=\"modal-body\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> Lihat Soal</a></td>";
            $txtData.="<td align=\"center\">
                        <button type='button' title='Hapus data'class='btnDel btn-danger btn btn-sm' data-idkry='".$idKry."' ><i class='fa fa-trash-o fa-sm' style='margin: 3px 3px;'></i></button>
                        <button type='button' title='Copy data' class='btnCopy btn-info btn btn-sm' data-idkry='".$idKry."' data-kodenik='".$kodenik."' data-nmkry='".$namakry."' data-tgllahir='".$tgllahir."' >
                        <i class='fa fa-files-o fa-sm' style='margin: 3px 1px;'></i></button></td></tr>";
            $txtData.="<td align=\"left\" style='display:none;'><input type=\"hidden\" name=\"inpId\" value=\"$id\"></td></tr>";
            $no++;
        }
        echo $txtData."^".$linkHal;

    }

    function deletedata(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
            $idKry=$_POST['idKry'];
            $getDtKry=$this->Asset->query("SELECT * FROM absensi.`master_karyawan` pkry WHERE pkry.id='$idKry'");
        
            //var_dump($getDtKry[0]['pkry']['tgllahir']);exit();
            $nikKry=$getDtKry[0]['pkry']['kodenik'];
            $nmkry=$getDtKry[0]['pkry']['namakry'];
            $tgllahir=$getDtKry[0]['pkry']['tgllahir'];

            //var_dump($_POST);exit();
            $this->Asset->query("DELETE	FROM kpireg.`paperuntukansoals` WHERE namakry='$nmkry' AND tgllahir='$tgllahir'");
            echo "sukses";
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    function simpan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
           
            //$idPeriode=$_POST['isiPeriode'];

            $checksoal=$_POST['checksoal'];
            $buffId=$_POST['buffNik'];
            //get data karyawan by id master karyawan
            $inId=" AND id IN (".substr($buffId,0,strlen($buffId)-1).")";
            $getDtKry=$this->Asset->query("SELECT * FROM absensi.master_karyawan ma WHERE ma.`tglkeluar` >CURDATE() $inId");
            //var_dump("SELECT * FROM absensi.master_karyawan ma WHERE ma.`tglkeluar` >CURDATE() $inId");exit();
            $buffId=explode(",",substr($buffId,0,strlen($buffId)-1));
            $jmlId=count($buffId);

            foreach($getDtKry as $datakry){
                $idkry=$datakry['ma']['id'];
                $namakry=$datakry['ma']['namakry'];
                $tgllahir=$datakry['ma']['tgllahir'];
                foreach($checksoal as $idSoal){
                    $this->Asset->query("INSERT INTO kpireg.`paperuntukansoals` (idSoal,idkry,namakry,tgllahir)VALUES('$idSoal','$idkry','$namakry','$tgllahir')");
                }
            }
//             exit();
//             foreach($checksoal as $idSoal){
               
//                 for($j=0;$j< $jmlId;$j++){

//                     $idkry=$buffId[$j];
//                      //var_dump($idkry);exit();
// //var_dump($nik);exit();
//                     $this->Asset->query("INSERT INTO kpireg.`paperuntukansoals` (idSoal,idkry)VALUES('$idSoal','$idkry')");
//                 }
//             }
            echo "sukses";
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }

    }

    function simpanEdit(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
            $checksoaledit=$_POST['checksoaledit'];
            $idKry=$_POST['setiddetail'];
            $getDtKry=$this->Asset->query("SELECT * FROM absensi.`master_karyawan` pkry WHERE pkry.id='$idKry'");
        
            //var_dump($checksoaledit);exit();
            $nikKry=$getDtKry[0]['pkry']['kodenik'];
            $nmkry=$getDtKry[0]['pkry']['namakry'];
            $tgllahir=$getDtKry[0]['pkry']['tgllahir'];
            //var_dump($idKry);exit();
            $this->Asset->query("DELETE	FROM kpireg.`paperuntukansoals` WHERE namakry='$nmkry' AND tgllahir='$tgllahir'");

            foreach($checksoaledit as $idSoal){
                    $this->Asset->query("INSERT INTO kpireg.`paperuntukansoals` (idSoal,idkry,namakry,tgllahir)VALUES('$idSoal','$idKry','$nmkry','$tgllahir')");
            }

            echo "sukses";
            //

            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    function setfilter(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        $txtData="";
        $txtDivisi="";
        $txtBagian="";
        $txtJabatan="";

        // $bagianfilter=$_POST['bagian'];
        // $divisifilter=$_POST['divisi'];
        // $jabatanfilter=$_POST['jabatan'];

        // //filterbagian 
        // if($bagianfilter==''){$bagianfilter=$bagianfilter;}else{$bagianfilter=" AND ma.kodebagian='$bagianfilter'";}
        // if($divisifilter==''){$divisifilter=$divisifilter;}else{$divisifilter=" AND ma.kodedivisi='$divisifilter'";}
        // if($jabatanfilter==''){$jabatanfilter=$jabatanfilter;}else{$jabatanfilter=" AND ma.jabatan='$jabatanfilter'";}
       
        //get divisi
        $this->loadModel('Asset');
        $divisi="SELECT ma.`kodedivisi` FROM absensi.master_karyawan ma WHERE ma.`tglkeluar` >CURDATE() AND ma.`kodedivisi` IS NOT NULL AND  ma.`kodedivisi`!=''  GROUP BY ma.`kodedivisi`";
        //var_dump();exit();
        $dataDivisi=$this->Asset->query($divisi);
        $txtDivisi.="<option value='' selected>Pilih Divisi</option>";

        foreach($dataDivisi as $data){
            $divisival=$data['ma']['kodedivisi'];
            $txtDivisi.="<option value='$divisival'>".$data['ma']['kodedivisi']."</option>";
        }

       
        //var_dump($dataDivisi);
 
        //get bagian

        $bagian="SELECT ma.`kodebagian` FROM absensi.master_karyawan ma WHERE ma.`tglkeluar` >CURDATE() AND ma.`kodebagian` IS NOT NULL AND  ma.`kodebagian`!=''  GROUP BY ma.`kodebagian`";
        $dataBagian=$this->Asset->query($bagian);
         $txtBagian.="<option value='' selected>Pilih Bagian</option>";

         foreach($dataBagian as $data){
            $bagianval=$data['ma']['kodebagian'];
            $txtBagian.="<option value='$bagianval'>".$data['ma']['kodebagian']."</option>";
        }


        //var_dump($dataBagian);

        //get jabatan
        $jabatan="SELECT ma.`jabatan` FROM absensi.master_karyawan ma WHERE ma.`tglkeluar` >CURDATE() AND ma.`jabatan` IS NOT NULL AND  ma.`jabatan`!=''  GROUP BY ma.`jabatan`";
        $dataJabtan=$this->Asset->query($jabatan);
        $txtJabatan.="<option value='' selected>Pilih Jabatan</option>";
        foreach($dataJabtan as $data){
            $jabatanval=$data['ma']['jabatan'];
            $txtJabatan.="<option value='$jabatanval'>".$data['ma']['jabatan']."</option>";
        }
        //var_dump($dataJabtan);

        echo $txtDivisi.'~'.$txtBagian.'~'.$txtJabatan;

    }

    function setSoal(){
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 


        //get id periode;
        $idPeriode  = $_POST['id'];     
        $mktNonMkt  = $_POST['mktNonMkt'];    
        $divisi     = $_POST['txtdivisiInput'];
        $jabatan    = $_POST['txtjabatanInput'];

        $divisi=explode('~',$divisi)[1];
		$jabatan=explode('~',$jabatan)[1];

        
        $txtData="";


        $queryKategori= $this->Asset->query("SELECT kategori FROM kpireg.pabanksoals ppkb WHERE ppkb.statusSoal='top'");

        $jumKategori=count($queryKategori);

        if($jumKategori==0 || $jumKategori==Null ){
            $txtData="<div class=\"panel panel-primary\">
                        <div class=\"panel-heading\" role=\"tab\" id=\"headingOne\">
                            <h4 class=\"panel-title\">
                                <a role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseOne\" aria-expanded=\"true\" aria-controls=\"collapseOne\">A. Sikap (Attitude)</a>
                            </h4>
                        </div>
                        <div id=\"collapseOne\" class=\"panel-collapse collapse in\" role=\"tabpanel\" aria-labelledby=\"headingOne\">
                            <div class=\"panel-body\"></div>
                        </div>
                    </div>
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\" role=\"tab\" id=\"headingTwo\">
                        <h4 class=\"panel-title\">
                        <a class=\"collapsed\" role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseTwo\" aria-expanded=\"false\" aria-controls=\"collapseTwo\">B. Pelaksanaan Pekerjaan (Job Implementation)</a>
                        </h4>
                    </div>
                    <div id=\"collapseTwo\" class=\"panel-collapse collapse\" role=\"tabpanel\" aria-labelledby=\"headingTwo\">
                        <div class=\"panel-body\"></div>
                    </div>
                </div>
                ";
            return $txtData.'^kosong';
        }

        $n=1;
        foreach($queryKategori as $kategori){
            
            $kategoriLabel=$kategori['ppkb']['kategori'];
            $collapsed='';
            if($n==1){$collapsed='in';}
            $txtData.="<div class=\"panel panel-primary\">
                    <div class=\"panel-heading\" role=\"tab\" id=\"headingOne$n\">
                        <h4 class=\"panel-title\">
                            <a role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseOne$n\" aria-expanded=\"true\" aria-controls=\"collapseOne\">$kategoriLabel</a>
                        </h4>
                        </div>
                        <div id=\"collapseOne\" class=\"panel-collapse \" role=\"tabpanel\" aria-labelledby=\"headingOne$n\" style=\"height:300px;max-height: 300px;overflow-y:auto;\">
                            ";
                           // var_dump("SELECT * FROM kpireg.ppkbanksoals ppbksoal WHERE  ppbksoal.kategori='$kategoriLabel'");exit();
                           //var_dump("SELECT * FROM kpireg.`pabanksoals` ppbksoal WHERE  ppbksoal.`kategori`='$kategoriLabel' AND ppbksoal.`peruntukanSoal`='$mktNonMkt' AND ppbksoal.`divisiId` ='$divisi' AND ppbksoal.`jabatanId`='$jabatan' AND  ppbksoal.`soal` IS NOT NULL");exit();
                            if($kategoriLabel=='Sikap (Attitude)'){
                                $sqlSoal= $this->Asset->query("SELECT * FROM kpireg.`pabanksoals` ppbksoal WHERE  ppbksoal.`kategori`='$kategoriLabel' AND  ppbksoal.`statusSoal` IS NULL");
                            }else{
                                $sqlSoal= $this->Asset->query("SELECT * FROM kpireg.`pabanksoals` ppbksoal WHERE  ppbksoal.`kategori`='$kategoriLabel' AND ppbksoal.`peruntukanSoal`='$mktNonMkt' AND ppbksoal.`divisiId` ='$divisi' AND ppbksoal.`jabatanId`='$jabatan' AND  ppbksoal.`soal` IS NOT NULL");
                            }
                          
                            
                            $i=1;
                            $txtData.="<table class='table tablesetsoal'>
                             <thead>
                                <tr>
                                    <th>no.</th>
                                    <th></th>
                                    <th width='80%'>soal</th>
                                    <th align='center'>bobot</th>
                                </tr>
                                </thead><tbody>";
                            $bobotTotal=0;
                            $bobotTotalDipilih=0;
                            foreach($sqlSoal as $soaldata){
                                //var_dump($soaldata);exit();
                                $checked    ="";
                                $idSoal     = $soaldata['ppbksoal']['id'];
                                $soal       = $soaldata['ppbksoal']['soal'];
                                $bobot      = $soaldata['ppbksoal']['bobot'];
                                $tipesoal   = $soaldata['ppbksoal']['tipeSoal'];
                                $bobotTotal=(int)$bobotTotal+(int)$bobot;
                                if($tipesoal=='umum'){
                                    $checked='checked readonly=true';
                                     $bobotTotalDipilih=(int)$bobotTotalDipilih+(int)$bobot;
                                }
                                $txtData.="
                                    <tr>
                                        <td>$i</td>
                                        <td><input type='checkbox' name='checksoal[]' class='pilih pilih$n' onclick='pilih(".$n.",1)' value='$idSoal' $checked/> 
                                        <input type='hidden' name='bobot[]' class='bobot$n' value='$bobot'/></td>
                                        <td>$soal</td>
                                        <td align='center'>$bobot</td>
                                    </tr>
                               
                                ";
                                $i++;
                            }
                            $txtData.="";
                            $txtData.="</tbody></table>";
                        $txtData.="
                        </div>
                        <div class='panel-footer'>
                            <div class='row'>
                                <div class='col-md-7' >
                                    <h4>Total bobot soal yang sudah dipilih</h4>
                                </div>
                                <div class='col-md-5 col-md-offset-0 text-right'>
                                    <h4 style='margin-right:15px;'><span class='label label-primary bobottotal' id='bobottotal$n'>$bobotTotalDipilih</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>";
                $n++;
        }
        
    return $txtData.'^isi';


    }


    public function detail(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");

         //get id periode;
        $idkry = $_POST['idkry'];      
        $txtData="";

        
        $getDtKry=$this->Asset->query("SELECT * FROM absensi.`master_karyawan` pkry WHERE pkry.id='$idkry'");
        
        //var_dump($getDtKry[0]['pkry']['tgllahir']);exit();
        $nikKry=$getDtKry[0]['pkry']['kodenik'];
        $nmkry=$getDtKry[0]['pkry']['namakry'];
        $tgllahir=$getDtKry[0]['pkry']['tgllahir'];

    
        $getDivisiJabatanId=$this->Asset->query("SELECT DISTINCT pbs.`divisiId`,pbs.`jabatanId`,pbs.`peruntukanSoal` FROM  kpireg.paperuntukansoals psoal
        INNER JOIN kpireg.pabanksoals pbs ON pbs.id=psoal.idSoal WHERE pbs.kategori='Pelaksanaan Pekerjaan (Job Implementation)' AND psoal.namakry='$nmkry' AND psoal.tgllahir='$tgllahir'");
         //var_dump($getDivisiJabatanId[0]['pbs']['divisiId']);exit();
        $divisiId= $getDivisiJabatanId[0]['pbs']['divisiId'];
        $jabatanId= $getDivisiJabatanId[0]['pbs']['jabatanId'];
        $peruntukanSoal=$getDivisiJabatanId[0]['pbs']['peruntukanSoal'];
      
        //var_dump($peruntukanSoal);exit();
        $getDetail= $this->Asset->query("SELECT * FROM  kpireg.paperuntukansoals psoal
        INNER JOIN kpireg.pabanksoals pbs ON pbs.id=psoal.idSoal WHERE psoal.namakry='$nmkry' AND psoal.tgllahir='$tgllahir'");
        //var_dump($getDetail);exit();
        $idBankSoal=[];
        
        foreach ($getDetail as $data) {
            $idBankSoal[]=(int)$data['pbs']['id'];
        }
        //var_dump($idBankSoal);exit();
        //ambil inarray - if (in_array($parameter, array))
       
        //var_dump($idBankSoal);exit();


        $queryKategori= $this->Asset->query("SELECT kategori FROM kpireg.pabanksoals ppkb WHERE ppkb.statusSoal='top'");
        $n=1;
        foreach($queryKategori as $kategori){
            $kategoriLabel=$kategori['ppkb']['kategori'];
            
            $txtData.="<div class=\"panel panel-primary\">
                        <div class=\"panel-heading headkategori\" >$kategoriLabel</div>";
                        if($kategoriLabel=='Sikap (Attitude)'){
                            $sqlSoal= $this->Asset->query("SELECT * FROM kpireg.pabanksoals ppbksoal WHERE  ppbksoal.kategori='$kategoriLabel' AND  ppbksoal.`statusSoal` IS NULL");
                        }else{
                           
                            $sqlSoal= $this->Asset->query("SELECT * FROM kpireg.pabanksoals ppbksoal WHERE  ppbksoal.kategori='$kategoriLabel' AND ppbksoal.peruntukanSoal='$peruntukanSoal'  AND  ppbksoal.soal IS NOT NULL AND ppbksoal.`divisiId`='$divisiId' AND ppbksoal.`jabatanId`='$jabatanId'");
                            
                        }
                        

                            $i=1;
                            $txtData.="<table class='table'>
                             <thead>
                                <tr>
                                    <th>no.</th>
                                    <th class='ceklist' style='display:none'></th>
                                    <th width='85%'>soal</th>
                                    <th width='10%'>bobot</th>
                                </tr>
                                </thead><tbody>";
                            $bobotTotal=0;
                            foreach($sqlSoal as $soaldata){
                                //var_dump($soaldata);exit();
                                $checked    ="";
                                $idSoal     = $soaldata['ppbksoal']['id'];
                                $soal       = $soaldata['ppbksoal']['soal'];
                                $bobot      = $soaldata['ppbksoal']['bobot'];
                                $tipesoal   = $soaldata['ppbksoal']['tipeSoal'];
                                
                                if(in_array((int)$idSoal, $idBankSoal)){
                                    $checked='checked';
                                    $bobotTotal=(int)$bobotTotal+(int)$bobot;
                                }
                                $hide='';
                                if($checked==''){
                                    $hide='class="hideEdit" style="display:none"';
                                }


                                $txtData.="
                                    <tr $hide>
                                        <td class='nomor$n'>$i</td>
                                        <td class='ceklist' style='display:none'><input type='checkbox' name='checksoaledit[]' class='pilihedit pilihedit$n' onclick='pilih(".$n.",2)' value='$idSoal' $checked/>
                                        <input type='hidden' name='bobot[]' class='bobot$n' value='$bobot'/></td>
                                        <td>$soal</td>
                                        <td>$bobot</td>
                                    </tr>";
                                $i++;
                            }
                            $txtData.="<tr><td class='ceklist' style='display:none'></td><td></td><td><strong>total bobot soal</strong></td><td><input class='form-control bobotedit' name='bobotedit[]' id='bobotedit".$n."' value='".$bobotTotal."' data-kategori='".$kategoriLabel."' readonly/></td></tr>";
                            $txtData.="</tbody></table>";

                    $txtData.="</div>";

        $n++;
        }
         $txtData.="<button type='button' class='btn btn-primary btnSimpanEdit btn-block' style='display:none' ><i class='fa fa-hdd-o' aria-hidden='true'></i> Simpan Perubahan</button>";
        echo $nikKry.'~'.$nmkry.'~'.$txtData;exit();

    }


    function getDtKaryawan(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        date_default_timezone_set("Asia/Jakarta");

        $txtdata=[];
   
        $this->loadModel('Asset');

        $queryKaryawan=$this->Asset->query("SELECT * FROM( SELECT * FROM 
        (SELECT CONCAT(mk.`namakry`,mk.`tgllahir`)nmtgl,
        SUBSTRING_INDEX(GROUP_CONCAT(mk.`id` ORDER BY mk.`id` ASC),',',-1) AS idkrynew,
        SUBSTRING_INDEX(GROUP_CONCAT(mk.`kodenik` ORDER BY mk.`id` ASC),',',-1) AS nikkrynew,mk.*
        FROM (SELECT * FROM absensi.`master_karyawan` mk WHERE mk.`tglkeluar` >CURDATE() AND mk.`kodenik`<>'')mk GROUP BY mk.`namakry`,mk.`tgllahir`)mk
        LEFT JOIN 
        (SELECT CONCAT(ps.`namakry`,ps.`tgllahir`)psnmtgl FROM kpireg.`paperuntukansoals` ps GROUP BY ps.`namakry`,ps.`tgllahir`)ps ON ps.`psnmtgl`=mk.`nmtgl` WHERE psnmtgl IS NULL)mk");
        
        //var_dump($queryKaryawan[0]);exit();
        $txtdata[]=array('label'=>'-Please Select-','value'=>'~~~');
        
        foreach($queryKaryawan as $dtKaryawan){ 
            //var_dump($dtKaryawan);exit();
                $txtdata[]= array('label'=>$dtKaryawan["mk"]["nikkrynew"]." - ".$dtKaryawan["mk"]["namakry"],'value'=>$dtKaryawan["mk"]["nikkrynew"]."~".$dtKaryawan["mk"]["namakry"]."~".$dtKaryawan["mk"]["idkrynew"]."~".$dtKaryawan["mk"]["tgllahir"]);
            //echo $hsl["a"]["nik"];
        } 
        
        //$dataKategoriBB=$this->getBlackBookKategori();
               
        echo json_encode($txtdata);
    
    }

    public function copyData()
    {
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            date_default_timezone_set("Asia/Jakarta");
            $karDataCopyDari=$_POST['karDataCopyDari'];
            $karTujuan      =$_POST['karTujuan'];
            
            $pchkarDataCopy=explode('~',$karDataCopyDari);
            
            $nikDari    =$pchkarDataCopy[0];
            $namaDari   =$pchkarDataCopy[1];
            $idKryDari  =$pchkarDataCopy[2];
            $tglLhrDari =$pchkarDataCopy[3];
            //var_dump($tglLhrDari);exit();
            $pchTujuanCopy=explode(',',$karTujuan);
            $dataSudahada="";
            foreach($pchTujuanCopy as $dtKaryCopy){
                $dtKaryCopy=explode('~',$dtKaryCopy);
                $nikCopy=$dtKaryCopy[0];
                $namaCopy=$dtKaryCopy[1];
                $idCopy=$dtKaryCopy[2];
                $tglLhrCopy=$dtKaryCopy[3];
                //var_dump($dtKaryCopy);exit();
                //cek data sudah ada
                $cekData=$this->Asset->query("SELECT * FROM `kpireg`.`paperuntukansoals` WHERE namakry='$namaCopy' AND tgllahir='$tglLhrCopy'");
                
                if(count($cekData)>0){
                    $dataSudahada.=$nikCopy.'-'.$namaCopy.',';
                    continue;
                }

                $queryInsertCopy="INSERT INTO `kpireg`.`paperuntukansoals` (
                    `idSoal`,
                    `idkry`,
                    `namakry`,
                    `tgllahir`
                    ) SELECT `idSoal`,
                    '$idCopy' idkry,
                    '$namaCopy' namakry,
                    '$tglLhrCopy'  tgllahir FROM `kpireg`.paperuntukansoals WHERE namakry='$namaDari' AND tgllahir='$tglLhrDari' AND idsoal NOT IN (
                    SELECT idsoal FROM `kpireg`.paperuntukansoals WHERE namakry='$namaCopy' AND tgllahir='$tglLhrCopy'
                )";
                 //var_dump($queryInsertCopy);exit();
                $this->Asset->query($queryInsertCopy);
            }

            //var_dump($pchTujuanCopy);exit();
            echo "sukses~".$dataSudahada;
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }
    //function ambilsoal(){}

    //paging
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
<?php
App::uses('AppController', 'Controller');
/**
 *  Controller Master hirarki
 *  referent DB kpireg
 */
class  PamasterhirarkiappsController extends AppController {
    public $components = array('Function','Paginator'); 
    public function index(){
    echo $this->Function->cekSession($this);
    }

    function getDt(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        date_default_timezone_set("Asia/Jakarta");
        //$queryUser=$this->User->query(" SELECT U.ID,U.subDivisi,U.groupId,U.penanggungJawab,U.pejabatId FROM users U WHERE U.penanggungJawab <> '' and groupid in (6,7,19,32,10) ");
        //var_dump($queryUser);exit();
        $txtdata['dtatasan']=[];
        $txtdata['dtkaryawan']=[];
        $txtdata['dtkepalabagian']=[];
        $txtdata['dtkepaladepartemen']=[];
        $txtdata['dtatasan'][]=array('label'=>'-Please Select-','value'=>'~~~');
        // foreach($queryUser as $dtAtasan){ 
        //       $txtdata['dtatasan'][]= array('label'=>$dtAtasan["U"]["ID"]."-".$dtAtasan["U"]["penanggungJawab"],'value'=>$dtAtasan["U"]["ID"]."~".$dtAtasan["U"]["penanggungJawab"]."~".$dtAtasan["U"]["pejabatId"]);
        // }
        $this->loadModel('Asset');
       
        // $queryKaryawan=$this->User->query("SELECT
        //                 ka.nik AS nik,
        //                 ka.namakry AS namakry,
        //                 mstkr.kodedept AS kodedept,
        //                 mstkr.jabatan AS jabatan,
        //                 mstkr.tgllahir AS tgllahir
        //                 FROM
        //                 absensi.karyawan_aktif ka
        //                 INNER JOIN (select tglkeluar,kodenik,namakry,jabatan,tgllahir,kodedept 
        //                 from absensi.master_karyawan mk 
        //                 WHERE  (tgllahir <> '0000-00-00' AND tgllahir IS NOT NULL ) 
        //                 and tglKeluar>='".date('Y-m-d')."'
        //                 GROUP BY tglkeluar,kodenik,namakry,jabatan,tgllahir,kodedept ) AS mstkr 
        //                 ON mstkr.kodenik = ka.nik  WHERE ka.blngaji ='".date('m', strtotime("-1 months"))."' AND ka.thngaji ='".date('Y')."'");
            
            
        //query karyawan server local
        // $queryKaryawan=$this->User->query(" SELECT * FROM (SELECT ma.*,COUNT(ma.`kodenik`) AS jmlnik FROM absensi.master_karyawan ma WHERE (ma.tgllahir <=> '' OR ma.tgllahir IS NOT NULL) AND ma.tglkeluar >CURDATE() GROUP BY ma.`kodenik`) AS tblmk  INNER JOIN (SELECT ka.* FROM absensi.karyawan_aktif ka WHERE ka.`blngaji`='12' AND ka.`thngaji`='2021') AS tblka  ON (tblka.namakry=tblmk.namakry AND tblka.tgllahir=tblmk.tgllahir) GROUP BY tblka.namakry,tblka.tgllahir");
        $queryKaryawan=$this->Asset->query("SELECT SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idkrynew,
        SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikkrynew,mk.* FROM absensi.`master_karyawan` mk  WHERE mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir");
        //var_dump($queryKaryawan);exit();
        $txtdata['dtkaryawan'][]=array('label'=>'-Please Select-','value'=>'~~~');
        
        foreach($queryKaryawan as $dtKaryawan){ 
                $txtdata['dtkaryawan'][]= array('label'=>$dtKaryawan["0"]["nikkrynew"]." - ".$dtKaryawan["mk"]["namakry"],'value'=>$dtKaryawan["0"]["nikkrynew"]."~".$dtKaryawan["mk"]["namakry"]."~".$dtKaryawan["0"]["idkrynew"]."~".$dtKaryawan["mk"]["tgllahir"]);
            //echo $hsl["a"]["nik"];
        } 
    
        //$dataKategoriBB=$this->getBlackBookKategori();
               
        echo json_encode($txtdata);
    
    }

    function getDtAutocomplate(){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('Asset');
        $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        date_default_timezone_set("Asia/Jakarta");

        $concategroup=$_POST['concategroup'];

            
        $queryKaryawan=$this->Asset->query("SELECT * FROM absensi.`master_karyawan` m_k WHERE CONCAT(m_k.`namakry`,'~',m_k.`tgllahir`) NOT IN $concategroup AND m_k.`tglkeluar` >CURDATE()");
        
        $txtdata=[];
        if(count($queryKaryawan)<1){
             $txtdata[]=array('label'=>'-Empty-','value'=>'~~~');
            echo json_encode($txtdata);
            return;
        }
       
        $txtdata[]=array('label'=>'-Please Select-','value'=>'~~~');
        foreach($queryKaryawan as $dtKaryawan){
            $txtdata[]=array('label'=>$dtKaryawan["m_k"]["kodenik"]." - ".$dtKaryawan["m_k"]["namakry"],'value'=>$dtKaryawan["m_k"]["kodenik"]."~".$dtKaryawan["m_k"]["namakry"]."~".$dtKaryawan["m_k"]["id"]."~".$dtKaryawan["m_k"]["tgllahir"]);
        }
        
        echo json_encode($txtdata);
        exit();



    }
    function getData(){
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->Asset->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        $txtData="";
        $hm=$_POST['hal'];
        $fungsi="getData";
        $limit=10;

        //cekhalaman
        if(empty($hm)||$hm==1){$start=0;}else{$start=($hm-1)*$limit;}

        //filter 
        $filter = $_POST['txtfilter'];
        //query
        // $query="SELECT
        //    `nikkry`,`nmkry`,
        //     MAX(IF(`sebagai` = 'atasan', `nikatasan`, NULL)) AS `nikatasan`,
        //     MAX(IF(`sebagai` = 'atasan', `nmatasan`, NULL)) AS `nmatasan`,
        //     MAX(IF(`sebagai` = 'kabag', `nikatasan`, NULL)) AS `nikkabag`,
        //     MAX(IF(`sebagai` = 'kabag', `nmatasan`, NULL)) AS `nmkabag`,
        //     MAX(IF(`sebagai` = 'kadep', `nikatasan`, NULL)) AS `nikkadep`,     
        //     MAX(IF(`sebagai` = 'kadep', `nmatasan`, NULL)) AS `nmkadep` 
        //     FROM kpireg.pahirarkis WHERE  (nikkry LIKE '%$filter%' OR nmkry LIKE '%$filter%' )  GROUP BY `nikkry` ;";

        // $query="SELECT
        //         `nikkry`,`nmkry`,`idkry`,`tglLahirKaryawan`,
        //         MAX(IF(`sebagai` = 'atasan', `nikatasan`, NULL)) AS `nikatasan`,
        //         MAX(IF(`sebagai` = 'atasan', `nmatasan`, NULL)) AS `nmatasan`,
        //         MAX(IF(`sebagai` = 'atasan', `idatasan`, NULL)) AS `idatasan`,
        //         MAX(IF(`sebagai` = 'atasan', `sebagai`, NULL)) AS `hubungan`,
        //         MAX(IF(`sebagai` = 'atasan', `tglLahirAtasan`, NULL)) AS `tglLahirAtasan`,
        //         MAX(IF(`sebagai` = 'kabag', `nikatasan`, NULL)) AS `nikkabag`,
        //         MAX(IF(`sebagai` = 'kabag', `nmatasan`, NULL)) AS `nmkabag`,
        //         MAX(IF(`sebagai` = 'kabag', `idatasan`, NULL)) AS `idkabag`,
        //         MAX(IF(`sebagai` = 'kabag', `tglLahirAtasan`, NULL)) AS `tglLahirKabag`,
        //         MAX(IF(`sebagai` = 'kadep', `nikatasan`, NULL)) AS `nikkadep`,     
        //         MAX(IF(`sebagai` = 'kadep', `nmatasan`, NULL)) AS `nmkadep` ,
        //         MAX(IF(`sebagai` = 'kadep', `idatasan`, NULL)) AS `idkadep` ,
        //         MAX(IF(`sebagai` = 'kadep', `tglLahirAtasan`, NULL)) AS `tglLahirKadep`
        //         FROM kpireg.pahirarkis  WHERE  (nikkry LIKE '%$filter%' OR nmkry LIKE '%$filter%' )   GROUP BY `nikkry`";

        //$qsql=$this->Asset->query("select * from absensi.master_karyawan mk where mk.namakry like '%panggah dadi sulistyo%' AND mk.tglkeluar >CURDATE()");
        //var_dump($qsql);exit();
        $query="SELECT  `nikkrynew`,`nmkry`,`idkrynew`,`tglLahirKaryawan`,
                MAX(IF(`sebagai` = 'atasan', `nikatasannew`, NULL)) AS `nikatasan`,
                MAX(IF(`sebagai` = 'atasan', `nmatasan`, NULL)) AS `nmatasan`,
                MAX(IF(`sebagai` = 'atasan', `idatasannew`, NULL)) AS `idatasan`,
                MAX(IF(`sebagai` = 'atasan', `sebagai`, NULL)) AS `hubungan`,
                MAX(IF(`sebagai` = 'atasan', `tglLahirAtasan`, NULL)) AS `tglLahirAtasan`,
                MAX(IF(`sebagai` = 'kabag', `nikatasannew`, NULL)) AS `nikkabag`,
                MAX(IF(`sebagai` = 'kabag', `nmatasan`, NULL)) AS `nmkabag`,
                MAX(IF(`sebagai` = 'kabag', `idatasannew`, NULL)) AS `idkabag`,
                MAX(IF(`sebagai` = 'kabag', `tglLahirAtasan`, NULL)) AS `tglLahirKabag`,
                MAX(IF(`sebagai` = 'kadep', `nikatasannew`, NULL)) AS `nikkadep`,     
                MAX(IF(`sebagai` = 'kadep', `nmatasan`, NULL)) AS `nmkadep` ,
                MAX(IF(`sebagai` = 'kadep', `idatasannew`, NULL)) AS `idkadep` ,
                MAX(IF(`sebagai` = 'kadep', `tglLahirAtasan`, NULL)) AS `tglLahirKadep`
                FROM (SELECT * FROM kpireg.`pahirarkis` INNER JOIN 
                    (SELECT 
                    SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idkrynew,
                    SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikkrynew,mk.`namakry` namakry1,mk.`tgllahir` tgllahir1
                    FROM absensi.master_karyawan mk WHERE  mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir) mk 
                    ON (mk.`namakry1`=pahirarkis.`nmkry` AND mk.`tgllahir1`=pahirarkis.`tglLahirKaryawan`) INNER JOIN 
                    (SELECT SUBSTRING_INDEX(GROUP_CONCAT(mk.id ORDER BY mk.id ASC),',',-1) AS idatasannew,
                    SUBSTRING_INDEX(GROUP_CONCAT(mk.kodenik ORDER BY mk.id ASC),',',-1) AS nikatasannew,mk.`namakry` namakry2,mk.`tgllahir` tgllahir2
                    FROM absensi.master_karyawan mk WHERE  mk.tglkeluar >CURDATE() GROUP BY mk.namakry,mk.tgllahir)mk2 
                    ON (mk2.`namakry2`=pahirarkis.`nmatasan` AND mk2.`tgllahir2`=pahirarkis.`tglLahirAtasan`)) tblPahirarkis 
                    WHERE  (tblPahirarkis.nikkrynew LIKE '%$filter%' OR tblPahirarkis.nmkry LIKE '%$filter%' ) GROUP BY `nikkrynew`";

            //var_dump  ($query." limit $start, $limit");exit();
        $qsql=$this->Asset->query($query);
        //var_dump($qsql);exit();
        $jumQuery=count($qsql);
        
        $sum=ceil($jumQuery/$limit);

         /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->Asset->query($query." limit $start, $limit");


        $no=$start+1;
        $txtHead="<tr>
            <th align=\"center\">NO</th>
            <th align=\"center\">NIK KARYAWAN</th>
            <th align=\"center\">NAMA KARYAWAN</th>
            <th align=\"center\">NIK ATASAN</th>
            <th align=\"center\">NAMA ATASAN</th>
            <th align=\"center\">NIK KABAG</th>
            <th align=\"center\">NAMA KABAG</th>
            <th align=\"center\">NIK KADEPT</th>
            <th align=\"center\">NAMA KADEPT</th>
            <th align=\"center\">UBAH</th>
            <th align=\"center\">HAPUS</th>
            </tr>";
        if($jumQuery==0 || $jumQuery==Null){
            $txtData="
            <tr>
            <td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
            </tr>";
            return $txtHead."^".$txtData."^";
        }

        foreach($Qtampil as $dataRow){
            //var_dump ($dataRow);exit();
            $nikkry             = $dataRow['tblPahirarkis']['nikkrynew'];
            $nmkry              = $dataRow['tblPahirarkis']['nmkry'];
            $idkry              = $dataRow['tblPahirarkis']['idkrynew'];
            $tglLahirKaryawan   = $dataRow['tblPahirarkis']['tglLahirKaryawan'];
            $nikatasan          = $dataRow[0]['nikatasan'];
            $nmatasan           = $dataRow[0]['nmatasan'];
            $idatasan           = $dataRow[0]['idatasan'];
            $tglLahirAtasan     = $dataRow[0]['tglLahirAtasan'];
            $nikkabag           = $dataRow[0]['nikkabag'];
            $nmkabag            = $dataRow[0]['nmkabag'];
            $idkabag            = $dataRow[0]['idkabag'];
            $tglLahirKabag      = $dataRow[0]['tglLahirKabag'];
            $nikkadep           = $dataRow[0]['nikkadep'];
            $nmkadep            = $dataRow[0]['nmkadep'];
            $idkadep            = $dataRow[0]['idkadep'];
            $tglLahirKadep      = $dataRow[0]['tglLahirKadep'];
            $nikKabagTampil=$nikkabag==''?'-':$nikkabag;
            $nmkabagTampil=$nmkabag==''?'-':$nmkabag;
            $idkabag=$idkabag==''?'':$idkabag;
            $nikkadepTampil=$nikkadep==''?'-':$nikkadep; 
            $nmkadepTampil=$nmkadep==''?'-':$nmkadep; 
            $idkadep=$idkadep==''?'':$idkadep;
            $txtData.="<tr>
                <td align=\"center\">$no</td>
                <td id='txtnikkry".$nikkry."' align=\"left\" >".$nikkry."<input type='hidden' name='nikkry' id='nikkry".$nikkry."' value='$nikkry'></td>
                <td id='txtnmkry".$nikkry."' align=\"left\">$nmkry</td>
                <td id='txtnikatasan".$nikkry."' align=\"left\">$nikatasan</td>
                <td id='txtnmatasan".$nikkry."' align=\"left\">$nmatasan</td>
                <td id='txtnikkabag".$nikkry."' align=\"left\">$nikKabagTampil</td>
                <td id='txtnmkabag".$nikkry."' align=\"left\">$nmkabagTampil</td>
                <td id='txtnikkadep".$nikkry."' align=\"left\">$nikkadepTampil</td>
                <td id='txtnmkadep".$nikkry."' align=\"left\">$nmkadepTampil</td>
                <td id='btnEdit".$nikkry."' align=\"left\">
                    <button type='button' class='btnEdit' 
                    data-kry='$nikkry~$nmkry~$idkry~$tglLahirKaryawan'
                    data-atasan='$nikatasan~$nmatasan~$idatasan~$tglLahirAtasan'
                    data-kabag='$nikkabag~$nmkabag~$idkabag~$tglLahirKabag'
                    data-kadep='$nikkadep~$nmkadep~$idkadep~$tglLahirKadep'><i class='fa fa-pencil fa-lg' style='margin: 5px 5px;'></i></button>
                </td>
                <td id='btnDel".$nikkry."' align=\"left\">
                    <button type='button' class='btnDel btn-danger' 
                    data-kry='$nikkry~$nmkry~$idkry~$tglLahirKaryawan'
                    data-atasan='$nikatasan~$nmatasan~$idatasan~$tglLahirAtasan'
                    data-kabag='$nikkabag~$nmkabag~$idkabag~$tglLahirKabag'
                    data-kadep='$nikkadep~$nmkadep~$idkadep~$tglLahirKadep'><i class='fa fa-trash-o fa-lg' style='margin: 5px 5px;'></i></button>
                </td>
                </tr>";
                $no++;
                //<button type='button' class='btn btn-xs btn-default edtBtn'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button>
        }
        echo $txtHead."^".$txtData."^".$linkHal;

    }

    
    function saveMode(){
        $this->autoRender = false;
        echo $this->Function->cekSession($this);
        $this->loadModel('Asset');
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();

            $atasan     =$_POST['atasan'];
            $kabag      =$_POST['kabag'];
            $kadep      =$_POST['kadept'];
            $karyawan   =$_POST['karyawan'];
            $mode       =$_POST['mode'];
            
            
            $atasan         =explode('~',$atasan);
            $nikAtasan      =$atasan[0];
            $namaAtasan     =$atasan[1];
            $idAtasan       =$atasan[2];
            $tglLahirAtasan =$atasan[3];
          
           if($kabag!='~~~' && !empty($kabag)){
                $kabag          =explode('~',$kabag);
                $nikKabag       =$kabag[0];
                $namaKabag      =$kabag[1];
                $idKabag        =$kabag[2];
                $tglLahirKabag  =$kabag[3];
           }
           if($kadep!='~~~' && !empty($kadep)){
                $kadep          =explode('~',$kadep);
                $nikKadep       =$kadep[0];
                $namaKadep      =$kadep[1];
                $idKadep        =$kadep[2];
                $tglLahirKadep  =$kadep[3];
           }

            
            //var_dump($kadep);exit();
            $karyawan       =explode(',',$karyawan);
            $numKaryawan=count($karyawan);
            $nikReady='';
            if($numKaryawan>0){
                foreach($karyawan as $dataKaryawan){
                    $dataKaryawan=explode('~',$dataKaryawan);
                    $nikKaryawan        = $dataKaryawan[0];
                    $namaKaryawan       = $dataKaryawan[1];
                    $idkry              = $dataKaryawan[2];
                    $tglLahirKaryawan   = date('Y-m-d',strtotime($dataKaryawan[3]));
                    //var_dump($idkry.'-'.$mode);exit();
                    if($mode=='edit'){
                        //delete by id kry
                        //$this->Asset->query("DELETE  FROM kpireg.pahirarkis WHERE idkry='$idkry'");
                        //delete by nama dan  tanggal lahir
                        $this->Asset->query("DELETE  FROM kpireg.pahirarkis WHERE nmkry='$namaKaryawan' AND tglLahirKaryawan='$tglLahirKaryawan'");
                    }
                    if($mode=='add'){
                        //cek karyawan sudah ada atau belum by id
                        //$cekid=$this->Asset->query("SELECT * FROM kpireg.pahirarkis WHERE idkry='$idkry';");
                    
                        //cek karyawan sudah ada atau belum by nama dan tanggal lahir
                        $cekid=$this->Asset->query("SELECT * FROM kpireg.pahirarkis WHERE nmkry='$namaKaryawan' AND tglLahirKaryawan='$tglLahirKaryawan';");
                        $jmlRecord=count($cekid);
                        if($jmlRecord>0){
                            $nikReady.=$nikKaryawan.',';
                            continue;
                        }
                    }
  //var_dump ("INSERT INTO kpireg.pahirarkis(nikkry,nmkry,nikatasan,nmatasan,sebagai,idkry,idatasan)VALUES('$nikKaryawan','$namaKaryawan','$nikAtasan','$namaAtasan','atasan','$idkry','$idAtasan')");exit();
                    $insertAtasan=$this->Asset->query("INSERT INTO kpireg.pahirarkis(nikkry,nmkry,nikatasan,nmatasan,sebagai,idkry,idatasan,tglLahirKaryawan,tglLahirAtasan)VALUES('$nikKaryawan','$namaKaryawan','$nikAtasan','$namaAtasan','atasan','$idkry','$idAtasan','$tglLahirKaryawan','$tglLahirAtasan')");
                    if($kabag!='~~~' && !empty($kabag)){
                        $insertKabag =$this->Asset->query("INSERT INTO kpireg.pahirarkis(nikkry,nmkry,nikatasan,nmatasan,sebagai,idkry,idatasan,tglLahirKaryawan,tglLahirAtasan)VALUES('$nikKaryawan','$namaKaryawan','$nikKabag','$namaKabag','kabag','$idkry','$idKabag','$tglLahirKaryawan','$tglLahirKabag')");
                    }
                    if($kadep!='~~~' && !empty($kadep)){
                        $insertKadep =$this->Asset->query("INSERT INTO kpireg.pahirarkis(nikkry,nmkry,nikatasan,nmatasan,sebagai,idkry,idatasan,tglLahirKaryawan,tglLahirAtasan)VALUES('$nikKaryawan','$namaKaryawan','$nikKadep','$namaKadep','kadep','$idkry','$idKadep','$tglLahirKaryawan','$tglLahirKadep')");
                    }
                    
                }
            }

            echo $nikReady."^sukses";
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    function deleteMode(){
        $this->autoRender = false;
        echo $this->Function->cekSession($this);
        $this->loadModel('Asset');
        try{
            $dataSource = $this->Asset->getdatasource();
            $dataSource->begin();
            $dataKaryawan=$_POST['dataKry'];
            $dataKaryawan=explode('~',$dataKaryawan);
            $nikKaryawan    = $dataKaryawan[0];
            $namaKaryawan   = $dataKaryawan[1];
            $idkry          = $dataKaryawan[2];
            //var_dump($idkry);exit();
            $this->Asset->query("DELETE  FROM kpireg.pahirarkis WHERE idkry='$idkry'");
            echo $nikKaryawan.' : '.$namaKaryawan."^sukses";
            $dataSource->commit(); 
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
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
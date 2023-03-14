<?php
App::uses('AppControlle','Controller');

/*FUPB*/

class FupbsController extends AppController {
    public $components = array('Function','Paginator');

    function index()
    {
         echo $this->Function->cekSession($this);
		
		
		
    }

    function selectDivisi(){
        $this->autoRender = false;
        $this->loadModel('User');  
        //var_dump("SELECT id,nama_divisi FROM dpfdplnew.divisis1 ORDER BY nama_divisi");exit();
        $hasil=$this->User->query("SELECT id,nama_divisi FROM dpfdplnew.divisis1 ORDER BY nama_divisi");

        $txtdata=[];
        foreach($hasil as $dataDivisi){ 
            $txtdata[]= array('label'=>$dataDivisi["divisis1"]["nama_divisi"],'value'=>$dataDivisi["divisis1"]["id"]."~".$dataDivisi["divisis1"]["nama_divisi"]);
        } 
        echo json_encode($txtdata);
    }


    function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

		$jenis=$_POST['jenis'];
	
        $idUser=$this->Session->read('dpfdpl_userId');
        $userNama=$this->Session->read('dpfdpl_namaUser');
        //variable tampung
        $txtData="";
        //paging
        $hm=$_POST['hal'];
        $fungsi="getData";
        $limit=10;
        //filter
        $startDate=$_POST['startDate'];
        $endDate=$_POST['endDate'];
        $noFupbSrc=$_POST['noFupbSrc'];
        $namaProjectSrc=$_POST['namaProjectSrc'];

        $filterDate="";
        if(!empty($startDate)){
            $dateStart=$this->Function->dateluar($startDate);
            $dateEnd=$this->Function->dateluar($endDate);
            $filterDate=" AND a.tanggalFUPB between '$dateStart' and '$dateEnd'";
        }
        //var_dump($_POST);EXIT();

        //cek halaman
        if(empty($hm)||$hm==1){
            $start=0; 
        }else{ 
            $start=($hm-1)*$limit; 
        }
        if(empty($hm)||$hm==1){$start=0; }
        else{$start=($hm-1)*$limit;}
        
        //start query
        $this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");   
        //$query="SELECT a.generateID,a.noFUPB,a.nd,a.tb,a.prodName,a.divID,a.divName,a.tanggalFUPB,a.komposisi,a.dosis,a.indikasi,
        //a.aturanPakai,a.sediaan,a.kemasan,a.jumlahKompetitor,a.jalurRegistrasi,a.statusKebutuhanMarketing,a.idPengaju,a.namaPengaju,a.statusFUPB FROM dpfdplnew.fupbs a GROUP BY a.generateID";
        $query="SELECT * FROM dpfdplnew.fupbs a WHERE a.prodName LIKE '%$namaProjectSrc%' AND a.noFUPB like '%$noFupbSrc%' $filterDate  AND a.idPengaju='$idUser' ORDER BY a.id DESC";
        
	   if($jenis=='report'){
            $query="SELECT * FROM dpfdplnew.fupbs a WHERE a.prodName LIKE '%$namaProjectSrc%' AND a.noFUPB like '%$noFupbSrc%' $filterDate  ORDER BY a.id DESC";
		   }
        $qsql=$this->User->query($query);
        $jumQuery=count($qsql);
        
        $sum=ceil($jumQuery/$limit);
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->User->query($query." limit $start, $limit");
        //var_dump($query." limit $start, $limit");exit();

        $no=$start+1;
        if($jumQuery==0 || $jumQuery==Null){
            $txtData="
            <tr>
            <td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
            </tr>";
            return $txtData."^";
        }



        foreach($Qtampil as $dataRow){
            $btnPembatalan="";
            $printPembatalan="";
            if($jenis=='report'){
                $statusPembatalan=$dataRow['a']['statusFUPB'];
                //var_dump($statusPembatalan);exit();
                if($statusPembatalan == 'pembatalan' || $statusPembatalan == 'batal'){
                    $btnPembatalan="";
                }else{
                    $btnPembatalan="<button type='button' class='btn btn-xs btn-danger btlBtn'><i class='fa fa fa-ban fa-lg' style='margin: 5px 5px;'></i></button>";
                }
                
            }

            $id=$dataRow['a']['id'];
            //$generateID=$dataRow['a']['generateID'];
            $divID=$dataRow['a']['divID'];
            $divName=$dataRow['a']['divName'];
            $dataDivID=explode(",",$divID);
            $dataDivNama=explode(",",$divName);

            $jum=count($dataDivID);
            $divisiTampil="";
            for($i=0;$i<$jum;$i++){
                $divisiTampil.=$dataDivID[$i]."~".$dataDivNama[$i].",";
            }
            $divisiTampil = rtrim($divisiTampil, ", ");
            //var_dump($divisiTampil);exit();
            $noFUPB=$dataRow['a']['noFUPB'];
            $nd=$dataRow['a']['nd'];
            $tb=$dataRow['a']['tb'];
            $prodName=$dataRow['a']['prodName'];
            
            $tanggalFUPB=$dataRow['a']['tanggalFUPB'];
            $komposisi=$dataRow['a']['komposisi'];
            $dosis=$dataRow['a']['dosis'];
            $indikasi=$dataRow['a']['indikasi'];
            $aturanPakai=$dataRow['a']['aturanPakai'];
            $sediaan=$dataRow['a']['sediaan'];
            $explodeSediaan=explode("~",$sediaan);
            //var_dump($explodeSediaan);exit();
            $kemasan=$dataRow['a']['kemasan'];
            $jumlahKompetitor=$dataRow['a']['jumlahKompetitor'];
            $jalurRegistrasi=$dataRow['a']['jalurRegistrasi'];
            $statusKebutuhanMarketing=$dataRow['a']['statusKebutuhanMarketing'];
            $idPengaju=$dataRow['a']['idPengaju'];
            $namaPengaju=$dataRow['a']['namaPengaju'];
            $statusFUPB=$dataRow['a']['statusFUPB'];
            $TARGETPRICEBOX=$dataRow['a']['targetPriceBox'];
            $TARGETPRICEUNIT=$dataRow['a']['targetPriceUnit'];
            $FCTH1QTY=$dataRow['a']['forecastQtyTh1'];
            $FCTH2QTY=$dataRow['a']['forecastQtyTh2'];
            $FCTH3QTY=$dataRow['a']['forecastQtyTh3'];
            $FCTH1VALUE=$dataRow['a']['forecastValueTh1'];
            $FCTH2VALUE=$dataRow['a']['forecastValueTh2'];
            $FCTH3VALUE=$dataRow['a']['forecastValueTh3'];
            $INFOTAMBAHAN=$dataRow['a']['infoTambahan'];
            $UJIBA=$dataRow['a']['ujiBa'];

            
            $progress='';
            $return='';
            $preHeader='';
            if($statusFUPB=='On' or $statusFUPB=='appL1' or $statusFUPB=='appL2'){
                $statusFUPB='On Progress';
                $queryHisFUPB=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals hisFUPB WHERE hisFUPB.fupbId='$id' ORDER BY hisFUPB.poin ASC");
                foreach($queryHisFUPB as $key => $data){
                    //$poin=$data['hisFUPB']['poin'];
                    $poin=substr($data['hisFUPB']['poin'],0,1);
                    $statusApp=$data['hisFUPB']['statusApp'];
                    if($poin=='1' && $statusApp=='open'){
                        $progress="<span style='color: #008450;'><i class='fa fa-refresh  fa-2x fa-spin' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>";
                        break;
                    }elseif($poin=='2' && $statusApp=='open'){
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #008450;'><i class='fa fa-refresh fa-2x fa-spin' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>";
                        break;
                    }elseif($poin=='3' && $statusApp=='open'){
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #008450;'><i class='fa fa-refresh fa-2x fa-spin' style='margin: 5px 5px;'></i></span>";
                        break;
                    }else{
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>";
                    }
                }
                
            }elseif($statusFUPB=='Return' ){
                $statusFUPB=$statusFUPB;
                $queryHisFUPB=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals hisFUPB WHERE hisFUPB.fupbId='$id' AND hisFUPB.poin='1' AND hisFUPB.statusApp='Return'");
                $noteReturn=$queryHisFUPB[0]['hisFUPB']['note'];
                $progress="<span style='color: #eea236;'><i class='fa fa-undo  fa-lg' style='margin: 5px 5px;'></i></span>";
                $btbData="data-id='".$id."'
                data-noteReturn='".$noteReturn."'
                data-ND='".$nd."'
                data-TB='".$tb."'
                data-TANGGAL='".$tanggalFUPB."'
                data-NOFUPB='".$noFUPB."'
                data-NAMAPROJECT='".$prodName."'
                data-DIVISI='".$divisiTampil."'
                data-DIVISIID='".$divID."'
                data-DIVISINAMA='".$divName."'
                data-KOMPOSISI='".$komposisi."'
                data-DOSIS='".$dosis."'
                data-INDIKASI='".$indikasi."'
                data-ATURANPAKAI='".$aturanPakai."'
                data-SEDIAAN='".$sediaan."'
                data-KEMASAN='".$kemasan."'
                data-JUMLAHKOMPETITOR='".$jumlahKompetitor."'
                data-JALURREGISTRASI='".$jalurRegistrasi."'
                data-SKM='".$statusKebutuhanMarketing."'
                data-TARGETPRICEBOX='".number_format($TARGETPRICEBOX,0,'','.')."'
                data-TARGETPRICEUNIT='".number_format($TARGETPRICEUNIT,0,'','.')."'
                data-FCTH1QTY='".number_format($FCTH1QTY,0,'','.')."'
                data-FCTH2QTY='".number_format($FCTH2QTY,0,'','.')."'
                data-FCTH3QTY='".number_format($FCTH3QTY,0,'','.')."'
                data-FCTH1VALUE='".number_format($FCTH1VALUE,0,'','.')."'
                data-FCTH2VALUE='".number_format($FCTH2VALUE,0,'','.')."'
                data-FCTH3VALUE='".number_format($FCTH3VALUE,0,'','.')."'
                data-INFOTAMBAHAN='".$INFOTAMBAHAN."'
                data-UJIBA='".$UJIBA."'";

                $return="<button type='button' class='btn btn-xs btn-primary edtBtn' ".$btbData."><i class='fa fa-pencil fa-lg' style='margin: 5px 5px;'></i></button>";
            }elseif($statusFUPB=='pembatalan' or $statusFUPB=='batalappL1' or $statusFUPB=='batalappL2'){
                $preHeader='PEMBATALAN';
                $statusFUPB='Progress Pembatalan';
                $printPembatalan="<div class='col-md-2'>
                                    <div class='panel panel-default' style='border-radius: 5px;margin-bottom:0;'>
                                        <div class='panel-body'>
                                            <button type='button' class='btn btn-xs btn-danger printBtn3'><i class='fa fa-print fa-lg' style='margin: 5px 5px;' ></i></button>
                                        </div>
                                        <div class='panel-footer'>
                                            Pembatalan
                                        </div>
                                    </div>
                                </div>";
                $queryHisFUPBPembatalan=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals hisFUPB WHERE hisFUPB.fupbId='$id' ORDER BY hisFUPB.poin ASC");
                foreach($queryHisFUPBPembatalan as $key => $data){
                    //$poin=$data['hisFUPB']['poin'];
                    $poin=substr($data['hisFUPB']['poin'],0,1);
                    $statusApp=$data['hisFUPB']['statusApp'];
                    if($poin=='1' && $statusApp=='pembatalan'){
                        $progress="<span style='color: #008450;'><i class='fa fa-refresh  fa-2x fa-spin' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>";
                        break;
                    }elseif($poin=='2' && $statusApp=='pembatalan'){
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #008450;'><i class='fa fa-refresh fa-2x fa-spin' style='margin: 5px 5px;'></i></span>
                            <span style='color: #FF7800;'><i class='fa fa-refresh fa-lg' style='margin: 5px 5px;'></i></span>";
                        break;
                    }elseif($poin=='3' && $statusApp=='pembatalan'){
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #008450;'><i class='fa fa-refresh fa-2x fa-spin' style='margin: 5px 5px;'></i></span>";
                        break;
                    }else{
                        $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>
                            <span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>";
                    }
                }
                //$progress="<span style='color: brown;'><i class='fa fa-ban  fa-lg' style='margin: 5px 5px;'></i></span>";
            }
            else{
                $statusFUPB=$statusFUPB;
                $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>";
            }

            $queryBrandCompatitors=$this->User->query("SELECT brand.id,brand.companyId,brand.namaCompany,brand.primCompatitor,brand.brandName,brand.dosageForm,brand.unitPack,brand.pricePack,brand.priceUnit  FROM  dpfdplnew.fupbcompetitors brand WHERE brand.fupbId='$id' ORDER BY brand.id ASC");
            $KompetitorUtama='';
            $txtBrand='';
            $txtBrandEdit='';
            $angka=1;
            foreach($queryBrandCompatitors as $dataBrand){
                $brandID=$dataBrand['brand']['id'];
                $companyId=$dataBrand['brand']['companyId'];
                $namaCompany=$dataBrand['brand']['namaCompany'];
                $primCompatitor=$dataBrand['brand']['primCompatitor'];
                $brandName=$dataBrand['brand']['brandName'];
                $dosageForm=$dataBrand['brand']['dosageForm'];
                $unitPack=$dataBrand['brand']['unitPack'];
                $pricePack=$dataBrand['brand']['pricePack'];
                $priceUnit=$dataBrand['brand']['priceUnit'];
                if(!empty($primCompatitor)){
                    $KompetitorUtama=$brandName.' - '.$namaCompany;
                }
                $checked='';
                if(!empty($primCompatitor)){
                    $checked='checked="checked"';
                }
                $selected='';
                $txtMasterCompanyCompatitors='';
                $hasil1=$this->User->query("SELECT id,namaCompany FROM dpfdplnew.mastercompanycompatitors ORDER BY namaCompany");

                // $txtDivisi="<option value=''>All</option>";
                foreach($hasil1 as $company){
                    $comId=$company['mastercompanycompatitors']['id'];
                    if($companyId===$comId){
                        $selected='selected';
                    }else{$selected='';}
                    $txtMasterCompanyCompatitors.="<option value='".$company['mastercompanycompatitors']['id']."' $selected>".$company['mastercompanycompatitors']['namaCompany']."</option>";
                }				
                //<input type=\"text\" class=\"form-control unitPacks\" name=\"unitPack[]\" id=\"unitPack".$angka."\" value=\"".$unitPack."\">
                //data brand edit
                $txtBrandEdit.="<tr class=\"active trCompatitor\">
                                    <td style=\"vertical-align:middle;width:22%\">
                                        <input type=\"text\" class=\"form-control brands\" name=\"brand[]\" id=\"brand".$angka."\" value=\"".$brandName."\">
                                    </td>
                                    <td style=\"vertical-align:middle;width:15%\">
                                        <select class=\"form-control compatitors\" name=\"compatitor[]\" id=\"compatitor".$angka."\"  onchange=\"cekExist(this,$angka)\">
                                            <option value=''>-Select-</option>".$txtMasterCompanyCompatitors."
                                        </select>
                                    </td>
                                    <td style=\"vertical-align:middle;\">
                                        <input type=\"checkbox\" class=\"primKompetitor\"  $checked >
                                        <input type=\"hidden\" name=\"primKompetitorisi[]\" class=\"primKompetitorisi\" id=\"primKompetitorisi".$angka."\" value=\"".$primCompatitor."\">
                                    </td>
                                    <td style=\"vertical-align:middle;width:12%\">
                                        <input type=\"text\" class=\"form-control dosages\" name=\"dosage[]\" id=\"dosage".$angka."\" value=\"".$dosageForm."\">
                                    </td>
                                    <td style=\"vertical-align:middle;width:22%;\">
                                        <textarea  class=\"form-control unitPacks\" name=\"unitPack[]\" id=\"unitPack".$angka."\">".$unitPack."</textarea>
                                        
                                    </td>
                                    <td style=\"vertical-align:middle;width:12%;\">
                                        <input type=\"text\" class=\"form-control priceUnits\" name=\"priceUnit[]\" id=\"priceUnit".$angka."\" onKeyUp=\"upAngka(this)\" style=\"text-align:right;\" value=\"".number_format($priceUnit,0,'','.')."\">
                                    </td>
                                    <td style=\"vertical-align:middle;width:12%;\">
                                        <input type=\"text\" class=\"form-control pricePacks\" name=\"pricePack[]\" id=\"pricePack".$angka."\" onKeyUp=\"upAngka(this)\" style=\"text-align:right;\" value=\"".number_format($pricePack,0,'','.')."\">
                                    </td>
                                    <td align=\"center\" id=\"tdbutton".$angka."\" style=\"vertical-align:middle;width:5%;\">
                                        <button type=\"button\" class=\"btn btn-xs btn-default cancelBrand\">
                                            <span style=\"color: Tomato;\"><i class=\"fa fa-ban fa-lg\" style=\"margin: 5px 5px;\"></i></span>
                                        </button>
                                        <input type=\"hidden\" name=\"idRecord[]\" id=\"idRecord".$angka."\" value=\"".$brandID."\">
                                    </td>
                                        
                                    
                                </tr>";
                $txtBrand.="<tr>
                                <td style='text-align:center;border-right: 1px solid #ddd;' colspan='2'>".$brandName."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$namaCompany."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$dosageForm."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$unitPack."</td>
                                <td style='text-align:right;border-right: 1px solid #ddd;'>Rp. ".number_format($pricePack,0,"",".")."</td>
                                <td style='text-align:right;'>Rp. ".number_format($priceUnit,0,"",".")."</td>
                            </tr>";
                $angka++;
            }
            $txtAPP="";
            
            $APP="SELECT fhis.id,fhis.fupbId,fhis.poin,fhis.statusApp,fhis.tanggalApp,link.id,link.userID,link.Usernama,link.poinApp,link.divisiID,Us.id,Us.penanggungJawab,Us.keterangan
                  FROM  dpfdplnew.fupbhistoryapprovals fhis
                  INNER JOIN dpfdplnew.linkuserfupbapprovals link 
                  ON (link.poinApp = fhis.poin AND divisiID IS NULL) OR CONCAT(link.poinApp,link.divisiID) = fhis.poin 
                  INNER JOIN (
                            SELECT
                                id,
                                penanggungJawab,
                                keterangan
                            FROM
                                dpfdplnew.users ) as Us 
                  ON Us.id = link.userID 
                  WHERE  fhis.fupbId = '$id' ORDER BY fhis.poin ASC ";

            $queryAPP=$this->User->query($APP);
            // $queryAPP=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals fhis INNER JOIN (SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID = '$divName') As link ON link.poinApp = fhis.poin INNER JOIN  (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id=link.userID AND fhis.fupbId = '$id' ORDER BY fhis.poin ASC");
            //var_dump($queryAPP);exit();

            $trtNama="<td>Nama Approval</td>";
            $trtDepartement="<td>Departement</td>";
            $trtSimbol="<td></td>";
            $trtConfirmasi="<td>Status</td>";
            $ttdAppNama='';
            $ttdAppJab='';
            $pointtd='';
                foreach($queryAPP AS $dataAPP){
                    
                    $confirmsimbol="";
                    $confirmisi="";
                    $confirm=$dataAPP['fhis']['statusApp'];
                    //var_dump($dataAPP['Us']['keterangan']);exit();
                    $namaAPP=$dataAPP['Us']['penanggungJawab'];
                    if(!empty($dataAPP['link']['divisiID'])){
                        $Departemen=$dataAPP['link']['divisiID'];
                    }else{
                        $Departemen=$dataAPP['Us']['keterangan'];
                    }
                
                    if($confirm=='close'){
                        $confirmsimbol="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg ' style='margin: 5px 5px;'></i></span>";
                        $confirmisi="Confirm";
                    }elseif($confirm=='Return'){
                        $confirmsimbol="<span style='color: #eea236;'><i class='fa fa-undo fa-lg ' style='margin: 5px 5px;'></i></span>";
                        $confirmisi="Dikembalikan";
                    }elseif($confirm=="Terminate"){
                        $confirmsimbol="<span style='color: brown;'><i class='fa fa-ban fa-lg ' style='margin: 5px 5px;'></i></span>";
                        $confirmisi="Batal";
                    }else{$confirmsimbol="<span style='color: #008450;'><i class='fa fa-refresh  fa-2x fa-spin' style='margin: 5px 5px;'></i></span>";
                        $confirmisi="Menunggu Konfirmasi";
                    }

                    $trtNama.="<td style='background:#f5f5f5 !important;text-align:center'>".$namaAPP."</td>";
                    $trtDepartement.="<td style='text-align:center'>".$Departemen."</td>";
                    $trtSimbol.="<td style='text-align:center'>".$confirmsimbol."</td>";
                    $trtConfirmasi.="<td style='text-align:center'>".$confirmisi."</td>";

                    if($dataAPP['link']['poinApp']=='1'){
                        $ttdAppNama=$namaAPP;
                        $ttdAppJab=$Departemen;
                        $pointtd=$dataAPP['link']['poinApp'];
                        $uidTtd=$dataAPP['link']['userID'];
                    }
                    
                }
                //     <td colspan='2'>
                //     <div class='input-group'>
                //         <span class='input-group-addon' id='basic-addon1'>Bentuk</span>
                //         <span class='form-control' style='width:100%'>".$explodeSediaan[0]."</span>    
                //     </div> 
                //     <div class='input-group'>
                //         <span class='input-group-addon' id='basic-addon1'>Rasa  &nbsp;&nbsp;</span>
                //         <span class='form-control' style='width:100%'>".$explodeSediaan[1]."</span>    
                //     </div>
                // </td>
                // <td colspan='2'>
                //     <div class='input-group'>
                //         <span class='input-group-addon' id='basic-addon1'>Warna </span>
                //         <span class='form-control' style='width:100%'>".$explodeSediaan[2]."</span>    
                //     </div>   
                //     <div class='input-group'>
                //         <span class='input-group-addon' id='basic-addon1'>Aroma</span>
                //         <span class='form-control' style='width:100%'>".$explodeSediaan[3]."</span>    
                //     </div>  
                // </td>
                // <td></td>
            $txtAPP="<table class='table table-bordered tblDetail' style='margin-bottom:unset'><tr>".$trtNama."</tr><tr>".$trtDepartement."</tr><tr>".$trtSimbol."</tr><tr>".$trtConfirmasi."</tr></table>";
            
            $txtData.="<tr class='active'>
                            <td style='text-align:center;vertical-align: middle;'>".$no."</td>
                            <td style='vertical-align: middle;'><a data-toggle='collapse' data-parent='#accordion' href='#collapse$no' tooltip='Klik Untuk Melihat Detail' style='color:brown;'>".$noFUPB."</a></td>
                            <td style='text-align:center;vertical-align: middle;'>".$this->Function->dateindo($tanggalFUPB)."</td>
                            <td style='vertical-align: middle;'>".$prodName."</td>
                            <td id='tddivID".$id."' style='display:none'>".$divID."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$divName."</td>
                            <td style='text-align:center;vertical-align: middle;'>$statusFUPB</td>
                            <td style='text-align:center;vertical-align: middle;'>$progress</td>
                            <td style='vertical-align: middle;text-align:center;'>
                            ".$return.$btnPembatalan."
                            <textarea style='display:none' id='textareaBrand".$id."'>".htmlspecialchars($txtBrandEdit)."</textarea>
                            </td>
                            <td style='display:none' id='genId".$no."'>".$id."</td>
                            
                        </tr>";
            $txtData=$txtData."<tr class='trEven' style='height:0px;'>
                        <td colspan='12' style='background-color:#FFF;border-top: unset' class='zeroPadding passive'>
                            <div id='collapse$no' class='collapse out' style='padding:10px;background-color: cornsilk'>
                                <div class='row'>
                                    <div class='col-md-8 col-md-offset-2'>
                                        <div class='panel panel-default' style='border-radius: 5px;margin-bottom:10px;'>
                                            <div class='panel-body' >
                                                <div class='row'>
                                                    <input type='hidden' value='".$no."'>
                                                    <div class='col-md-2' >
                                                        <div class='panel panel-default' style='border-radius: 5px;margin-bottom:0;'>
                                                            <div class='panel-body'>
                                                                <button type='button' class='btn btn-xs btn-danger printBtn1'><i class='fa fa-print fa-lg' style='margin: 5px 5px;' ></i></button>
                                                            </div>
                                                            <div class='panel-footer'>
                                                                Lampiran 1
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <div class='panel panel-default' style='border-radius: 5px;margin-bottom:0;'>
                                                            <div class='panel-body'>
                                                                <button type='button' class='btn btn-xs btn-danger printBtn2'><i class='fa fa-print fa-lg' style='margin: 5px 5px;' ></i></button>
                                                            </div>
                                                            <div class='panel-footer'>
                                                                Lampiran 2
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ".$printPembatalan."
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col-md-8 col-md-offset-2'>
                                        <div class='panel panel-default' style='border-radius: 5px;margin-bottom:10px;'>
                                            <div class='panel-body' >
                                                <div class='panel panel-default' style='border-radius: 5px;margin-bottom:10px;'>
                                                    <div class='panel-body' style='margin-bottom:unset;padding:0 15px;'>
                                                        <div class='row'>
                                                            <table class='tblDetail table'  style='margin-bottom:unset'width='100%'>
                                                                <tr>
                                                                    <td rowspan='2' colspan='5' style='font-family:arial;width:80%; font-size: 15px !important; vertical-align: middle;'>
                                                                    <h2>$preHeader USULAN PRODUK BARU</h2></td>
                                                                    <td  style='width:20%;border-left:1px solid #ddd' colspan='2'>ND :   ".$nd." </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='border-left: 1px solid #ddd;border-top: unset;' colspan='2'>TB :    ".$tb."</td>                                                
                                                                </tr>
                                                                <tr>
                                                                    <td  colspan='7'>No. :   ".$noFUPB." </td>
                                                                </tr>
                                                                <tr>
                                                                    <td  colspan='7' style='border-top: unset;'>Tanggal :   ".$this->Function->dateindo($tanggalFUPB)."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='width:20%;font-weight: bold;'>Nama Project</td>
                                                                    <td style='width:3%; text-align:center;'>:</td>
                                                                    <td style='width:70%' colspan='5'>".$prodName."</td>  
                                                                                                                         
                                                                </tr>
                                                                <tr>
                                                                    <td style='width:20%;font-weight: bold;'>Divisi</td>
                                                                    <td style='width:3%; text-align:center;'>:</td>
                                                                    <td style='width:70%' colspan='5'>".$divName."</td>  
                                                                                                                         
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Komposisi & Dosis</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$komposisi."</td>                                                              
                                                                </tr>
                                                                <tr style='display:none;'>
                                                                    <td style='font-weight: bold;'>Dosis</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$dosis."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Indikasi</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$indikasi."</td>
                                                                </tr>
                                                                <tr>   
                                                                    <td style='font-weight: bold;'>Aturan Pakai</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$aturanPakai."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'> Spesifikasi Sediaan</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>
                                                                        <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                            <tr>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Bentuk</td>
                                                                                <td style='width:35%'>".$explodeSediaan[0]."</td>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Warna</td>
                                                                                <td style='width:35%'>".$explodeSediaan[2]."</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style='background-color:#f5f5f5 !important;'>Rasa</td>
                                                                                <td>".$explodeSediaan[1]."</td>
                                                                                <td style='background-color:#f5f5f5 !important;'>Aroma</td>
                                                                                <td>".$explodeSediaan[3]."</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Spesifikasi Kemasan</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$kemasan."</td>
                                                                    
                                                                </tr>
                                                                <tr >
                                                                        <td style='font-weight: bold;background-color:#f5f5f5 !important;' colspan='7'>Kompetitor</td>  
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;border-right: 1px solid #ddd;' colspan='2'>Jumlah Kompetitor</td>
                                                                    <td colspan='5'>".$jumlahKompetitor."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;border-right: 1px solid #ddd;' colspan='2'>Kompetitor Utama</td>
                                                                    <td colspan='5'>".$KompetitorUtama."</td>
                                                                </tr>
                                                                <tr>
                                                                    <th width='20%' colspan='2' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Brand Name</th>                  
                                                                    <th width='20%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Company</th>
                                                                    <th width='10%' style='background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Dosage Form</th>
                                                                    <th width='20%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Unit/Pack</th>
                                                                    <th width='15%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Price/Pack</th>
                                                                    <th width='15%' style='text-align:center;background:#f5f5f5 !important;'>Price/Unit</th>
                                                                </tr>
                                                                ".$txtBrand."
                                                                <tr>
                                                                    <td style='font-weight: bold;border-right: 1px solid #ddd;' colspan='2'>Jalur Registrasi</td>
                                                                    <td colspan='5'>".$jalurRegistrasi."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;border-right: 1px solid #ddd;' colspan='2'>Status Kebutuhan Marketing</td>
                                                                    <td colspan='5'>".$statusKebutuhanMarketing."</td>
                                                                </tr>
                                                            </table>
                                                            <table class='table table-bordered ' style='margin-bottom:unset;'>
                                                                <tr>
                                                                    <td width='50%'>
                                                                        <table class='tblTtd' width='100%' style='margin-bottom:unset;'>
                                                                            <tr><td style='font-weight: bold;width:25%'>Dibuat oleh</td><td>: $namaPengaju</td></tr>
                                                                            <tr><td style='font-weight: bold;'>Departemen</td><td>: </td></tr>
                                                                            <tr><td>Tanda Tangan</td><td>:</td></tr>
                                                                            <tr><td colspan='2' style='text-align:center'>
                                                                                     ";
                                                                                    if(file_exists('img/fupb/'.$id.'.png')){                                                                                     
                                                                                        $txtData.='<img src="img/fupb/'.$id.'.png" style="width:200;">';
                                                                                    }else{
                                                                                        $txtData.='';
                                                                                    }
                                                                                    $txtData.="
                                                                            </td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td>
                                                                        <table class='tblTtd' width='100%' style='margin-bottom:unset;'>
                                                                            <tr><td style='font-weight: bold;width:25%'>Disetujui oleh</td><td>: $ttdAppNama</td></tr>
                                                                            <tr><td style='font-weight: bold;'>Departemen</td><td>: $ttdAppJab</td></tr>
                                                                            <tr><td>Tanda Tangan</td><td>:</td></tr>
                                                                            <tr><td colspan='2' style='text-align:center'> ";
                                                                            if(file_exists('img/fupb/'.$id.'_ttd_'.$pointtd.'.png')){
                                                                                $txtData.='<img src="img/fupb/'.$id.'_ttd_'.$pointtd.'.png" style="width:200;">';
                                                                            }else{
                                                                                $txtData.='';
                                                                            }
                                                                            $txtData.="</td></tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class='tblDetail table'  style='margin-bottom:unset'width='100%'>
                                                                <tr>
                                                                    <td style='width:20%;font-weight: bold;vertical-align: middle;'> Target Price</td>
                                                                    <td style='width:3%;text-align:center;vertical-align: middle;'>:</td>
                                                                    <td colspan='5'>
                                                                        <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                            <tr>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Box</td>
                                                                                <td style='width:35%;text-align:right;'>Rp. ".number_format($TARGETPRICEBOX,0,"",".")."</td>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Unit</td>
                                                                                <td style='width:35%;text-align:right;'>Rp. ".number_format($TARGETPRICEUNIT,0,"",".")."</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;vertical-align: middle;'> Forecast</td>
                                                                    <td style='text-align:center;vertical-align: middle;'>:</td>
                                                                    <td colspan='5'>
                                                                        <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                            <tr><td colspan='4' style='background-color:#f5f5f5 !important;font-weight: bold;font-style: oblique;'>Thn. Pertama</td></tr>
                                                                            <tr>
                                                                            
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>QTY</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH1QTY."</td>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH1VALUE."</td>
                                                                            </tr>  
                                                                        </table>
                                                                        <table class='table table-bordered ' width='100%' style='margin:5px 0;'>
                                                                            <tr><td colspan='4' style='background-color:#f5f5f5 !important;font-weight: bold;font-style: oblique;'>Thn. Kedua</td></tr>
                                                                            <tr>
                                                                            
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>QTY</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH2QTY."</td>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH2VALUE."</td>
                                                                            </tr>  
                                                                        </table>
                                                                        <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                            <tr><td colspan='4' style='background-color:#f5f5f5 !important;font-weight: bold;font-style: oblique;'>Thn. Ketiga</td></tr>
                                                                            <tr>
                                                                                
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>QTY</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH3QTY."</td>
                                                                                <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                <td style='width:35%;text-align:right;'>".$FCTH3VALUE."</td>
                                                                            </tr>  
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Uji BA</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$UJIBA."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Info Tambahan</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$INFOTAMBAHAN."</td>    
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-8 col-md-offset-2'>
                                        <div class='panel panel-default' style='border-radius: 5px;margin-bottom:10px;'>
                                            <div class='panel-body' >
                                            ".$txtAPP."
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </td>
                        </tr>";

            $no++;

        }

        return $txtData."^".$linkHal;
        
    }


    public function getDivisi()
	{
		$this->autoRender = false;
        $this->loadModel('User');
        $txtDivisi='';
        $id=$_POST['id'];
        $selected='';
		$hasil1=$this->User->query("SELECT id,nama_divisi FROM dpfdplnew.divisis ORDER BY nama_divisi");

		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $divisi){
            $divId=$divisi['divisis']['id'];
            if($id===$divId){
				$selected='selected';
			}else{$selected='';}
			$txtDivisi.="<option value='".$divisi['divisis']['id']."' $selected>".$divisi['divisis']['nama_divisi']."</option>";
		}				
		echo $txtDivisi;	
    }
    public function getJalurRegistrasi()
	{
		$this->autoRender = false;
        $this->loadModel('User');
        $txtJalurRegistrasi='';
        $jaregPost=$_POST['jalurRegistrasi'];
        $selected='';
		$hasil1=$this->User->query("SELECT id,jalurRegistrasi FROM dpfdplnew.masterjalurregistrasis ORDER BY jalurRegistrasi");

		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $jaReg){
            $jalurRegistrasi=$jaReg['masterjalurregistrasis']['jalurRegistrasi'];
            if($jaregPost===$jalurRegistrasi){
				$selected='selected';
			}else{$selected='';}
			$txtJalurRegistrasi.="<option value='".$jaReg['masterjalurregistrasis']['jalurRegistrasi']."' $selected>".$jaReg['masterjalurregistrasis']['jalurRegistrasi']."</option>";
		}				
		echo $txtJalurRegistrasi;	
    }

    
    public function getCompanyCompatitor()
    {
        $this->autoRender = false;
        $this->loadModel('User');
        $txtMasterCompanyCompatitors='';
		$hasil1=$this->User->query("SELECT id,namaCompany FROM dpfdplnew.mastercompanycompatitors ORDER BY namaCompany");

		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $company){
			$txtMasterCompanyCompatitors.="<option value='".$company['mastercompanycompatitors']['id']."'>".$company['mastercompanycompatitors']['namaCompany']."</option>";
		}				
		echo $txtMasterCompanyCompatitors;	
    }

    public function saveFUPB(){
        $this->autoRender = false;
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
			$dataSource = $this->User->getdatasource();
            $dataSource->begin();

            $idUserInput=$this->Session->read('dpfdpl_userId');
            $userInputNama=$this->Session->read('dpfdpl_namaUser');
            
            $img = $_POST['photo'];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $fupbId=$_POST['fupbId'];
            
            //var_dump($_POST);exit();
            //variable post
            $nd=$_POST['nd'];
            $tb=$_POST['tb'];
            $tanggalFUPB=$this->Function->dateluar($_POST['tglFupb']);
            $noFUPB=$_POST['noFupb'];
            $naProd=$_POST['naProd'];
            //$divID=$_POST['divisi'];
            //$divisiNama=$_POST['divisiNama'];
            $divID=$_POST['divisDipilihiID'];
            $divisiNama=$_POST['divisiDipilihNama'];
            
            $komposisi=$_POST['komposisi'];
            $dosis=$_POST['dosis'];
            $indikasi=$_POST['indikasi'];
            $aturanPakai=$_POST['aturanPakai'];
            $sediaan=$_POST['sediaan'];
            $kemasan=$_POST['kemasan'];
            $jumKompetitor=$_POST['jumKompetitor'];
            $jalurReg=$_POST['jalurReg'];
            $statusKebMar=$_POST['statusKebMar'];

            $TARGETPRICEBOX=preg_replace("/[^0-9]/", "",$_POST['targetPriceBox']);
            $TARGETPRICEUNIT=preg_replace("/[^0-9]/", "",$_POST['targetPriceUnit']);
            $FCTH1QTY=preg_replace("/[^0-9]/", "",$_POST['fcth1qty']);
            $FCTH2QTY=preg_replace("/[^0-9]/", "",$_POST['fcth2qty']);
            $FCTH3QTY=preg_replace("/[^0-9]/", "",$_POST['fcth3qty']);
            $FCTH1VALUE=preg_replace("/[^0-9]/", "",$_POST['fcth1value']);
            $FCTH2VALUE=preg_replace("/[^0-9]/", "",$_POST['fcth2value']);
            $FCTH3VALUE=preg_replace("/[^0-9]/", "",$_POST['fcth3value']);
            $INFOTAMBAHAN=$_POST['infoTambahan'];
            $UJIBA=$_POST['ujiBa'];

            $thn=date('Y');
            $bln=date('m');
            
            $CRUD='';
            
            $startAppHisFupbLoop='';
            if(!empty($fupbId)){
                $CRUD='edit';
                $sqlFupbEdit="UPDATE dpfdplnew.fupbs fu SET fu.noFUPB='$noFUPB',fu.nd='$nd',fu.tb='$tb',fu.prodName='$naProd',fu.divID='$divID',fu.divName='$divisiNama',fu.tanggalFUPB='$tanggalFUPB',fu.komposisi='$komposisi',fu.dosis='$dosis',fu.indikasi='$indikasi',fu.aturanPakai='$aturanPakai',fu.sediaan='$sediaan',fu.kemasan='$kemasan',fu.jumlahKompetitor='$jumKompetitor',fu.jalurRegistrasi='$jalurReg',fu.statusKebutuhanMarketing='$statusKebMar',fu.idPengaju='$idUserInput',fu.namaPengaju='$userInputNama',fu.statusFUPB='On',fu.appL1='open',fu.appL2='open',fu.appL3='open',targetPriceBox='$TARGETPRICEBOX',targetPriceUnit='$TARGETPRICEUNIT',forecastQtyTh1='$FCTH1QTY',forecastValueTh1='$FCTH1VALUE',forecastQtyTh2='$FCTH2QTY',forecastValueTh2='$FCTH2VALUE',forecastQtyTh3='$FCTH3QTY',forecastValueTh3='$FCTH3VALUE',ujiBa='$UJIBA',infoTambahan='$INFOTAMBAHAN'  WHERE fu.id='$fupbId'";
                //var_dump($this->User->query($sqlFupbEdit));exit();
                $this->User->query($sqlFupbEdit);
                
                $getID=$fupbId;

                //update fupbhistory
                $QueryCRUD="DELETE	FROM dpfdplnew.fupbhistoryapprovals  WHERE SUBSTRING(fupbhistoryapprovals.poin,1,2) = '21' AND fupbhistoryapprovals.fupbId='$getID'";
                $this->User->query($QueryCRUD);


                $fupbDivName=explode(",",$divisiNama);
                $jum=count($fupbDivName);
                for($loopdiv=0;$loopdiv<$jum;$loopdiv++){
                    $poin='21'.$fupbDivName[$loopdiv];
                    $startAppHisFupbLoop.="('$getID',NULL,NULL,'$poin','open'),";
                }
                $startAppHisFupbLoop = rtrim($startAppHisFupbLoop, ", ");
                
                $queryInsertHis="INSERT INTO dpfdplnew.fupbhistoryapprovals(fupbId,idApp,userApp,poin,statusApp)Values".$startAppHisFupbLoop;
                $this->User->query($queryInsertHis);

                $sqlFupbHisEdit="UPDATE dpfdplnew.fupbhistoryapprovals fupbhis SET fupbhis.statusApp='open',fupbhis.tanggalApp = NULL,fupbhis.note = NULL  WHERE fupbhis.fupbId='$getID'";
                $this->User->query($sqlFupbHisEdit);

                   
            }else{
                $CRUD='save';
                //var_dump($CRUD);exit();
                //save table utama dan get id
                $queryInsert="INSERT INTO dpfdplnew.fupbs(noFUPB,nd,tb,prodName,divID,divName,tanggalFUPB,komposisi,dosis,indikasi,aturanPakai,sediaan,kemasan,jumlahKompetitor,jalurRegistrasi,statusKebutuhanMarketing,idPengaju,namaPengaju,statusFUPB,appL1,appL2,appL3,targetPriceBox,targetPriceUnit,forecastQtyTh1,forecastValueTh1,forecastQtyTh2,forecastValueTh2,forecastQtyTh3,forecastValueTh3,ujiBa,infoTambahan)VALUES ('$noFUPB','$nd','$tb','$naProd','$divID','$divisiNama','$tanggalFUPB','$komposisi','$dosis','$indikasi','$aturanPakai','$sediaan','$kemasan','$jumKompetitor','$jalurReg','$statusKebMar','$idUserInput','$userInputNama','On','open','open','open','$TARGETPRICEBOX','$TARGETPRICEUNIT','$FCTH1QTY','$FCTH1VALUE','$FCTH2QTY','$FCTH2VALUE','$FCTH3QTY','$FCTH3VALUE','$UJIBA','$INFOTAMBAHAN')";
               
                $this->User->query($queryInsert);

                $QuerygetID=$this->User->query("SELECT id FROM dpfdplnew.fupbs f1  order by f1.id desc limit 1");
                $getID=$QuerygetID[0]['f1']['id'];


               //insert history
                
                $loopcar=4;
                $poin='';$no=2;
                for($loop=1;$loop<=$loopcar;$loop++){
                    if($loop==1){
                        $poin=$loop;
                    }elseif($loop==4){
                        $poin='3';
                    }else{
                        $poin='2'.$no;
                        $no++;
                    }
                    $startAppHisFupbLoop.="('$getID',NULL,NULL,'$poin','open'),";
                }
                $fupbDivName=explode(",",$divisiNama);
                $jum=count($fupbDivName);
                for($loopdiv=0;$loopdiv<$jum;$loopdiv++){
                    $poin='21'.$fupbDivName[$loopdiv];
                    $startAppHisFupbLoop.="('$getID',NULL,NULL,'$poin','open'),";
                }
                
                $startAppHisFupbLoop = rtrim($startAppHisFupbLoop, ", ");
                //var_dump($startAppHisFupbLoop);exit();
                $queryInsertHis="INSERT INTO dpfdplnew.fupbhistoryapprovals(fupbId,idApp,userApp,poin,statusApp)Values".$startAppHisFupbLoop;
                $this->User->query($queryInsertHis);

            }

            $queryInsertCompatitor="INSERT INTO dpfdplnew.fupbcompetitors(fupbId,companyId,namaCompany,primCompatitor,brandName,dosageForm,unitPack,pricePack,priceUnit)VALUES";
            $jmlComp=count($_POST['brand']);
            $queryValues="";
            
            //loop compatitor form
            for($i=0;$i<$jmlComp;$i++){
                $brand=$_POST['brand'][$i];
                $compatitor=$_POST['compatitor'][$i];
                $compatitorName=$_POST['compatitorName'][$i];
                $primCompatitor=$_POST['primKompetitorisi'][$i];
                $dosage=$_POST['dosage'][$i];
                $unitPack=$_POST['unitPack'][$i];
                $priceUnit=preg_replace("/[^0-9]/", "",$_POST['priceUnit'][$i]);
                $pricePack=preg_replace("/[^0-9]/", "",$_POST['pricePack'][$i]);
                if ($CRUD=='edit'){
                    
                    $idRecord=$_POST['idRecord'][$i];
                    if(!empty($idRecord)){
                        $sqlFcEdit="UPDATE dpfdplnew.fupbcompetitors fc SET 
                                    fc.companyId='$compatitor',
                                    fc.namaCompany='$compatitorName',
                                    fc.primCompatitor='$primCompatitor',
                                    fc.brandName='$brand',
                                    fc.dosageForm='$dosage',
                                    fc.unitPack='$unitPack',
                                    fc.pricePack='$pricePack',
                                    fc.priceUnit='$priceUnit'
                                    WHERE fc.fupbId='$getID' AND fc.id='$idRecord'";
                                    //var_dump($sqlFcEdit);exit();
                    }else{
                        $sqlFcEdit=$queryInsertCompatitor."('$getID','$compatitor','$compatitorName','$primCompatitor','$brand','$dosage','$unitPack',$priceUnit,$pricePack)";
                    }
                    $this->User->query($sqlFcEdit); 
                }
                $queryValues.="('$getID','$compatitor','$compatitorName','$primCompatitor','$brand','$dosage','$unitPack',$priceUnit,$pricePack),";
            }

            if($CRUD=='save'){
                $queryValues = rtrim($queryValues, ", ");
                $queryInsertCompatitor=$queryInsertCompatitor.$queryValues;
                //var_dump($queryInsert);exit();
                $this->User->query($queryInsertCompatitor);
            }          





            $file = 'img/fupb/'.$getID.'.png';
            $success = file_put_contents($file, $data);
            //var_dump($poin);exit();

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
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
			$dataSource = $this->User->getdatasource();
            $dataSource->begin();

            $id=$_POST['id'];
            $tglPembatalan=$this->Function->dateluar($_POST['tglPembatalan']);
            $alasanPembatalan=$_POST['alasanPembatalan'];
            
            $queryUpdate="UPDATE dpfdplnew.fupbs SET tglPembatalan='$tglPembatalan',alasanPembatalan='$alasanPembatalan',statusFUPB='pembatalan',appL1='pembatalan',appL2='pembatalan',appL3='pembatalan'  WHERE id='$id'";
            $this->User->query($queryUpdate); 

            $queryUpdateHistory="UPDATE dpfdplnew.fupbhistoryapprovals SET statusApp='pembatalan',tanggalApp = NULL  WHERE fupbId='$id'";
            $this->User->query($queryUpdateHistory); 
           
            //get action CRUD
           
          
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }
    //get generate ID


    
	public function deleteRecord(){
        $this->autoRender = false;
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
			$dataSource = $this->User->getdatasource();
            $dataSource->begin();

            //var_dump($_POST);exit();
            $idRecord=$_POST['id'];
            //get action CRUD
            $QueryCRUD="DELETE	FROM dpfdplnew.fupbcompetitors WHERE id='$idRecord'";
            $this->User->query($QueryCRUD);
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }
    //cetak lampiran pdf
   //cetak pdf
    public function cetakpdf(){
        $this->autoRender = false;
        $this->loadModel('User');

        $idUser=$this->Session->read('dpfdpl_userId');
        $id=$_POST['idCetakPDF'];
        $lampiranCetak=$_POST['lampiranCetak'];
        
        $this->set('pdf',$id);
        if($lampiranCetak=='Lampiran1'){
            $this->render('formulir');
        }else{
            $this->render('persetujuan');
        }

    }

    //get generate ID

    public function maxGenerateID($tabel,$field,$pref,$kodeDivisi,$thn,$bln){
        $this->loadModel('User');

        $prefId=$pref.$kodeDivisi.$thn.$bln;
        $tableQ="'$tabel'";
        //echo $tableQ;exit();
        //var_dump("select max($field) as $field from $tabel where substring($field,1,".strlen($prefId).")='$prefId'");exit();
        //$kueri=$this->User->query("select $field from $tabel where substring($field,1,".strlen($prefId).")='$prefId' ORDER BY id DESC limit 1");
        $kueri=$this->User->query("select max($field) as $field from dpfdplnew.$tabel where substring($field,1,".strlen($prefId).")='$prefId'");
        //var_dump($kueri[0][0]["$field"]);exit();
		//$res=$dbCon->getRow($kueri);
        $jml=count($kueri);
        //var_dump($jml);exit();
		if($jml==0){
			//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
            $maxId=$prefId."00001";
            //var_dump($maxId);exit();
		}
		else{
            $maxId=$kueri[0][0]["$field"];
			$maxId=substr($maxId,strlen($prefId)+1,strlen($maxId));
			$maxId=$maxId+100001;
			$maxId=substr($maxId,1,5);
            $maxId=$prefId.$maxId;
            //var_dump($maxId);exit();
		}
		
		return $maxId;
	}
    //end form FUPB
    //page nav
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
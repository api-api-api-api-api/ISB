<?php
APP::uses('AppController','Controller');
/*FUPB REPORT*/

class FupbreportsController extends AppController{
    public $components = array('Function','Paginator');
    function index(){
        echo $this->Function->cekSession($this);
    }
    
    function getData(){
        $this->autoRender = false;
        $this->loadModel('User');

        $idUser=$this->Session->read('dpfdpl_userId');
        $userNama=$this->Session->read('dpfdpl_namaUser');
        //variable tampung
        $txtData="";
        //paging
        $hm=$_POST['hal'];
        $fungsi="getData";
        $limit=10;
        //filter

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
        $query="SELECT a.generateID,a.noFUPB,a.nd,a.tb,a.prodName,a.divID,a.divName,a.tanggalFUPB,a.komposisi,a.dosis,a.indikasi,
        a.aturanPakai,a.sediaan,a.kemasan,a.jumlahKompetitor,a.jalurRegistrasi,a.statusKebutuhanMarketing,a.idPengaju,a.namaPengaju,a.statusFUPB FROM dpfdplnew.fupbs a GROUP BY a.generateID";
       
        $qsql=$this->User->query($query);
        $jumQuery=count($qsql);
        
        $sum=ceil($jumQuery/$limit);
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->User->query($query." limit $start, $limit");


        $no=$start+1;
        if($jumQuery==0 || $jumQuery==Null){
            $txtData="
            <tr>
            <td colspan=\"9\" style=\"text-align:center;\">--Empty Data--</td>
            </tr>";
            return $txtData."^";
        }



        foreach($Qtampil as $dataRow){
            $generateID=$dataRow['a']['generateID'];
            $noFUPB=$dataRow['a']['noFUPB'];
            $nd=$dataRow['a']['nd'];
            $tb=$dataRow['a']['tb'];
            $prodName=$dataRow['a']['prodName'];
            $divID=$dataRow['a']['divID'];
            $divName=$dataRow['a']['divName'];
            $tanggalFUPB=$dataRow['a']['tanggalFUPB'];
            $komposisi=$dataRow['a']['komposisi'];
            $dosis=$dataRow['a']['dosis'];
            $indikasi=$dataRow['a']['indikasi'];
            $aturanPakai=$dataRow['a']['aturanPakai'];
            $sediaan=$dataRow['a']['sediaan'];
            $kemasan=$dataRow['a']['kemasan'];
            $jumlahKompetitor=$dataRow['a']['jumlahKompetitor'];
            $jalurRegistrasi=$dataRow['a']['jalurRegistrasi'];
            $statusKebutuhanMarketing=$dataRow['a']['statusKebutuhanMarketing'];
            $idPengaju=$dataRow['a']['idPengaju'];
            $namaPengaju=$dataRow['a']['namaPengaju'];
            $statusFUPB=$dataRow['a']['statusFUPB'];
            $progress='';
            $return='';
            if($statusFUPB=='On' or $statusFUPB=='appL1' or $statusFUPB=='appL2'){
                $statusFUPB='On Progress';
                $queryHisFUPB=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals hisFUPB WHERE hisFUPB.generateID='$generateID' ORDER BY hisFUPB.poin ASC");
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
                $progress="<span style='color: #eea236;'><i class='fa fa-undo  fa-lg' style='margin: 5px 5px;'></i></span>";
                $btbData="data-id='".$generateID."'
                data-ND='".$nd."'
                data-TB='".$tb."'
                data-TANGGAL='".$tanggalFUPB."'
                data-NOFUPB='".$noFUPB."'
                data-NAMAPROJECT='".$prodName."'
                data-DIVISI='".$divID."'
                data-KOMPOSISI='".$komposisi."'
                data-DOSIS='".$dosis."'
                data-INDIKASI='".$indikasi."'
                data-ATURANPAKAI='".$aturanPakai."'
                data-SEDIAAN='".$sediaan."'
                data-KEMASAN='".$kemasan."'
                data-JUMLAHKOMPETITOR='".$jumlahKompetitor."'
                data-JALURREGISTRASI='".$jalurRegistrasi."'
                data-SKM='".$statusKebutuhanMarketing."'";

                $return="<button type='button' class='btn btn-xs btn-primary edtBtn' ".$btbData."><i class='fa fa-pencil fa-lg' style='margin: 5px 5px;'></i></button>";
            }elseif($statusFUPB=='Terminate'){
                $statusFUPB=$statusFUPB;
                $progress="<span style='color: brown;'><i class='fa fa-ban  fa-lg' style='margin: 5px 5px;'></i></span>";
            }
            else{
                $statusFUPB=$statusFUPB;
                $progress="<span style='color: #286090;'><i class='fa fa-check-circle-o fa-lg' style='margin: 5px 5px;'></i></span>";
            }

            $queryBrandCompatitors=$this->User->query("SELECT brand.id,brand.companyId,brand.namaCompany,brand.primCompatitor,brand.brandName,brand.dosageForm,brand.unitPack,brand.pricePack,brand.priceUnit  FROM  dpfdplnew.fupbs brand WHERE brand.generateID='$generateID' ORDER BY brand.id ASC");
            $KompetitorUtama='';
            $txtBrand='';
            $txtBrandEdit='';
            $angka=1;
            foreach($queryBrandCompatitors as $dataBrand){
                $idRecord=$dataBrand['brand']['id'];
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
                $txtBrandEdit.="<tr class=\"active trCompatitor\">
                                    <td style=\"vertical-align:middle;width:22%\">
                                        <input type=\"text\" class=\"form-control brands\" name=\"brand[]\" id=\"brand".$angka."\" value=\"".$brandName."\">
                                    </td>
                                    <td style=\"vertical-align:middle;width:15%\">
                                        <select class=\"form-control compatitors\" name=\"compatitor[]\" id=\"compatitor".$angka."\" >
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
                                        <input type=\"text\" class=\"form-control unitPacks\" name=\"unitPack[]\" id=\"unitPack".$angka."\" value=\"".$unitPack."\">
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
                                        <input type=\"hidden\" name=\"idRecord[]\" id=\"idRecord".$angka."\" value=\"".$idRecord."\">
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
            
            $queryAPP=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals fhis INNER JOIN (SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals WHERE divisiID = '$divName') As link ON link.poinApp = fhis.poin INNER JOIN  (SELECT id,penanggungJawab,keterangan FROM dpfdplnew.users ) as Us ON Us.id=link.userID AND fhis.generateID = '$generateID' ORDER BY fhis.poin ASC");
            $trtNama="<td>Nama Approval</td>";$trtDepartement="<td>Departement</td>";$trtSimbol="<td></td>";$trtConfirmasi="<td>Status</td>";
            $ttdAppNama='';
            $ttdAppJab='';
            $pointtd='';
            foreach($queryAPP AS $dataAPP){
                
                $confirmsimbol="";
                $confirmisi="";
                $confirm=$dataAPP['fhis']['statusApp'];
                //var_dump($dataAPP['Us']['keterangan']);exit();
                $namaAPP=$dataAPP['Us']['penanggungJawab'];
                $Departemen=$dataAPP['Us']['keterangan'];
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

            $txtAPP="<table class='table table-bordered tblDetail' style='margin-bottom:unset'><tr>".$trtNama."</tr><tr>".$trtDepartement."</tr><tr>".$trtSimbol."</tr><tr>".$trtConfirmasi."</tr></table>";
            
            $txtData.="<tr class='active'>
                            <td style='text-align:center;vertical-align: middle;'>".$no."</td>
                            <td style='vertical-align: middle;'><a data-toggle='collapse' data-parent='#accordion' href='#collapse$no' tooltip='Klik Untuk Melihat Detail' style='color:brown;'>".$noFUPB."</a></td>
                            <td style='text-align:center;vertical-align: middle;'>".$this->Function->dateindo($tanggalFUPB)."</td>
                            <td style='vertical-align: middle;'>".$prodName."</td>
                            <td id='tddivID".$generateID."' style='display:none'>".$divID."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$divName."</td>
                            <td style='text-align:center;vertical-align: middle;'>$statusFUPB</td>
                            <td style='text-align:center;vertical-align: middle;'>$progress</td>
                            <td style='vertical-align: middle;text-align:center;'>
                            $return
                            <textarea style='display:none' id='textareaBrand".$generateID."'>".$txtBrandEdit."</textarea>
                            </td>
                            <td style='display:none' id='genId".$no."'>".$generateID."</td>
                            
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
                                                                    <h2>USULAN PRODUK BARU</h2></td>
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
                                                                    <td style='width:10%;font-weight: bold;'>Nama Project</td>
                                                                    <td style='width:3%; text-align:center;'>:</td>
                                                                    <td style='width:70%' colspan='5'>".$prodName."</td>  
                                                                                                                         
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Komposisi</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$komposisi."</td>                                                              
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Dosis</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$dosis."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='width:14%;font-weight: bold;'>Indikasi</td>
                                                                    <td style='width:3%; text-align:center;'>:</td>
                                                                    <td style='width:20%' colspan='5'>".$indikasi."</td>
                                                                </tr>
                                                                <tr>   
                                                                    <td style='font-weight: bold;'>Aturan Pakai</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$aturanPakai."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'> Spesifikasi Sediaan</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$sediaan."</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-weight: bold;'>Spesifikasi Kemasan</td>
                                                                    <td style='text-align:center;'>:</td>
                                                                    <td colspan='5'>".$kemasan."</td>
                                                                </tr>
                                                                <tr class='active'>
                                                                        <td style='font-weight: bold;' colspan='7'>Kompetitor</td>  
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
                                                                    <th width='25%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Company</th>
                                                                    <th width='10%' style='background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Dosage Form</th>
                                                                    <th width='25%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Unit/Pack</th>
                                                                    <th width='10%' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Price/Pack</th>
                                                                    <th width='10%' style='text-align:center;background:#f5f5f5 !important;'>Price/Unit</th>
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
                                                                                    <img ";
                                                                                    if(file_exists('img/fupb/'.$generateID.'.png')){                                                                                     
                                                                                        $txtData.='src="img/fupb/'.$generateID.'.png" style="width:200;"';
                                                                                    }else{
                                                                                        $txtData.='src="img/.png" style="width:100;"';
                                                                                    }
                                                                                    $txtData.=">
                                                                            </td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td>
                                                                        <table class='tblTtd' width='100%' style='margin-bottom:unset;'>
                                                                            <tr><td style='font-weight: bold;width:25%'>Disetujui oleh</td><td>: $ttdAppNama</td></tr>
                                                                            <tr><td style='font-weight: bold;'>Departemen</td><td>: $ttdAppJab</td></tr>
                                                                            <tr><td>Tanda Tangan</td><td>:</td></tr>
                                                                            <tr><td colspan='2' style='text-align:center'><img ";
                                                                            if(file_exists('img/fupb/'.$generateID.'_ttd_'.$pointtd.'.png')){
                                                                                $txtData.='src="img/fupb/'.$generateID.'_ttd_'.$pointtd.'.png" style="width:200;"';
                                                                            }else{
                                                                                $txtData.='src="img/.png" style="width:100;"';
                                                                            }
                                                                            $txtData.="></td></tr>
                                                                        </table>
                                                                    </td>
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


    //form FUPB
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
    public function getCompanyCompatitor()
    {
        $this->autoRender = false;
        $this->loadModel('User');
        $txtMasterCompanyCompatitors='';
        $id=$_POST['id'];
        $selected='';
		$hasil1=$this->User->query("SELECT id,namaCompany FROM dpfdplnew.mastercompanycompatitors ORDER BY namaCompany");

		// $txtDivisi="<option value=''>All</option>";
		foreach($hasil1 as $company){
            $comId=$company['mastercompanycompatitors']['id'];
            if($id===$comId){
				$selected='selected';
			}else{$selected='';}
			$txtMasterCompanyCompatitors.="<option value='".$company['mastercompanycompatitors']['id']."' $selected>".$company['mastercompanycompatitors']['namaCompany']."</option>";
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
            //variable post
            $img = $_POST['photo'];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $genID=$_POST['genID'];
            //var_dump($_POST);exit();
            $nd=$_POST['nd'];
            $tb=$_POST['tb'];
            $tanggalFUPB=$this->Function->dateluar($_POST['tglFupb']);
            $noFUPB=$_POST['noFupb'];
            $naProd=$_POST['naProd'];
            $divID=$_POST['divisi'];
            $divisiNama=$_POST['divisiNama'];
            $komposisi=$_POST['komposisi'];
            $dosis=$_POST['dosis'];
            $indikasi=$_POST['indikasi'];
            $aturanPakai=$_POST['aturanPakai'];
            $sediaan=$_POST['sediaan'];
            $kemasan=$_POST['kemasan'];
            $jumKompetitor=$_POST['jumKompetitor'];
            $jalurReg=$_POST['jalurReg'];
            $statusKebMar=$_POST['statusKebMar'];
            $thn=date('Y');
            $bln=date('m');
            $CRUD='';
            if(!empty($genID)){
                $CRUD='edit';
                $sqlFupbHisEdit="UPDATE dpfdplnew.fupbhistoryapprovals fupbhis SET fupbhis.statusApp='open',fupbhis.tanggalApp = NULL  WHERE fupbhis.generateID='$genID'";
                $this->User->query($sqlFupbHisEdit);

                // $DELCRUDFUPB="DELETE	FROM dpfdplnew.fupbs WHERE generateID='$genID'";
                // $this->User->query($DELCRUDFUPB);
                // $DELCRUDHISFUPB="DELETE	FROM dpfdplnew.fupbhistoryapprovals WHERE generateID='$genID'";
                // $this->User->query($DELCRUDHISFUPB);
                $getID=$genID;
            }else{
                $CRUD='save';
                $getID=$this->maxGenerateID('fupbs','generateID','FUPB',$divID,$thn,$bln);
                //var_dump ($getID);exit();
               
            }
            $queryInsert="INSERT INTO dpfdplnew.fupbs(generateID,noFUPB,nd,tb,prodName,divID,divName,tanggalFUPB,komposisi,dosis,indikasi,aturanPakai,sediaan,kemasan,jumlahKompetitor,jalurRegistrasi,statusKebutuhanMarketing,idPengaju,namaPengaju,companyId,namaCompany,primCompatitor,brandName,dosageForm,unitPack,pricePack,priceUnit,statusFUPB,appL1,appL2,appL3)VALUES";
            //$getID=$this->maxGenerateID('fupbs','generateID','FUPB',$divID,$thn,$bln);
            
            $jmlComp=count($_POST['brand']);
            $queryValues="";
           
            
            for($i=0;$i<$jmlComp;$i++){
               
                $brand=$_POST['brand'][$i];
                $compatitor=$_POST['compatitor'][$i];
                $compatitorName=$_POST['compatitorName'][$i];
                $primCompatitor=$_POST['primKompetitorisi'][$i];
                $dosage=$_POST['dosage'][$i];
                $unitPack=$_POST['unitPack'][$i];
                $priceUnit=preg_replace("/[^0-9]/", "",$_POST['priceUnit'][$i]);
                $pricePack=preg_replace("/[^0-9]/", "",$_POST['pricePack'][$i]);
                $sqlEdit='';

                $queryValues.="('$getID','$noFUPB','$nd','$tb','$naProd','$divID','$divisiNama','$tanggalFUPB','$komposisi','$dosis','$indikasi','$aturanPakai','$sediaan','$kemasan','$jumKompetitor','$jalurReg','$statusKebMar','$idUserInput','$userInputNama','$compatitor','$compatitorName','$primCompatitor','$brand','$dosage','$unitPack',$pricePack,$priceUnit,'On','open','open','open'),";
                if ($CRUD=='edit'){
                    $idRecord=$_POST['idRecord'][$i];
                    if(!empty($idRecord)){
                        $sqlEdit="UPDATE dpfdplnew.fupbs fu SET 
                                            fu.noFUPB='$noFUPB',
                                            fu.nd='$nd',
                                            fu.tb='$tb',
                                            fu.prodName='$naProd',
                                            fu.divID='$divID',
                                            fu.divName='$divisiNama',
                                            fu.tanggalFUPB='$tanggalFUPB',
                                            fu.komposisi='$komposisi',
                                            fu.dosis='$dosis',
                                            fu.indikasi='$indikasi',
                                            fu.aturanPakai='$aturanPakai',
                                            fu.sediaan='$sediaan',
                                            fu.kemasan='$kemasan',
                                            fu.jumlahKompetitor='$jumKompetitor',
                                            fu.jalurRegistrasi='$jalurReg',
                                            fu.statusKebutuhanMarketing='$statusKebMar',
                                            fu.idPengaju='$idUserInput',
                                            fu.namaPengaju='$userInputNama',
                                            fu.companyId='$compatitor',
                                            fu.namaCompany='$compatitorName',
                                            fu.primCompatitor='$primCompatitor',
                                            fu.brandName='$brand',
                                            fu.dosageForm='$dosage',
                                            fu.unitPack='$unitPack',
                                            fu.pricePack='$pricePack',
                                            fu.priceUnit='$priceUnit',
                                            fu.statusFUPB='On',
                                            fu.appL1='open',
                                            fu.appL2='open',
                                            fu.appL3='open'
                                            WHERE fu.id='$idRecord'";
                    }else{
                        $sqlEdit=$queryInsert."('$getID','$noFUPB','$nd','$tb','$naProd','$divID','$divisiNama','$tanggalFUPB','$komposisi','$dosis','$indikasi','$aturanPakai','$sediaan','$kemasan','$jumKompetitor','$jalurReg','$statusKebMar','$idUserInput','$userInputNama','$compatitor','$compatitorName','$primCompatitor','$brand','$dosage','$unitPack',$pricePack,$priceUnit,'On','open','open','open')";
                    }
                    //return $sqlEdit;exit();
                    
                    $this->User->query($sqlEdit); 
                }
                
                   
            }

            if($CRUD=='save'){
                $queryValues = rtrim($queryValues, ", ");
                $queryInsert=$queryInsert.$queryValues;
                $this->User->query($queryInsert);

                //insert history
                $startAppHisFupbLoop='';
                $loopcar=5;
                $poin='';$no=1;
                for($loop=1;$loop<=$loopcar;$loop++){
                    if($loop==1){
                        $poin=$loop;
                    }elseif($loop==5){
                        $poin='3';
                    }else{
                        $poin='2'.$no;
                        $no++;
                    }
                    $startAppHisFupbLoop.="('$getID',NULL,NULL,'$poin','open'),";
                }
                $startAppHisFupbLoop = rtrim($startAppHisFupbLoop, ", ");
                //var_dump($startAppHisFupbLoop);exit();
                $queryInsertHis="INSERT INTO dpfdplnew.fupbhistoryapprovals(generateID,idApp,userApp,poin,statusApp)Values".$startAppHisFupbLoop;
                $this->User->query($queryInsertHis);
            }
            // var_dump($sqlEdit);exit();
            // return;exit();
            
            



            //$queryAppInsert="SELECT * FROM dpfdplnew.linkuserfupbapprovals l WHERE l.`status`='active'";
            //cara 1 : by linkuserfupbapprovals
            // $divisiID=''; 
            // $getDivisi=$this->User->query("SELECT a.divName,a.generateID FROM dpfdplnew.fupbs a WHERE a.generateID='$getID' GROUP BY a.divName");
            
            // $divisiID=$getDivisi[0]['a']['divName'];
            
            // $queryAppInsert="SELECT * FROM dpfdplnew.linkuserfupbapprovals l WHERE  l.divisiID  IS NULL UNION SELECT * FROM dpfdplnew.linkuserfupbapprovals l WHERE divisiID ='$divisiID' ORDER BY poinApp ";
            // $recordQAPP=$this->User->query($queryAppInsert);

            // $startAppHisFupb='';
            // foreach($recordQAPP as $dataQAPP){
            //     $idApp=$dataQAPP[0]['userID'];
            //     $namaApp=$dataQAPP[0]['Usernama'];
            //     $poin=$dataQAPP[0]['poinApp'];
            //     $startAppHisFupb.="('$getID','$idApp','$namaApp','$poin','open'),"; 
            // }
            // $startAppHisFupb = rtrim($startAppHisFupb, ", ");
            // $queryInsertHis="INSERT INTO dpfdplnew.fupbhistoryapprovals(generateID,idApp,userApp,poin,statusApp)Values".$startAppHisFupb;
            // $this->User->query($queryInsertHis);

            //cara 2: dengan loop
            
            //var_dump($queryInsertHis);exit();

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
            $QueryCRUD="DELETE	FROM dpfdplnew.fupbs WHERE id='$idRecord'";
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
        $genID=$_POST['idCetakPDF'];
        $lampiranCetak=$_POST['lampiranCetak'];
        
        $this->set('pdf',$genID);
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
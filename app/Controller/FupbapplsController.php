<?php
App::uses('AppControlle','Controller');


class FupbapplsController extends AppController {
    public $components = array('Function','Paginator');

    function index()
    {
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
        //$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'");   
        $userPoin=$this->User->query("SELECT * FROM linkuserfupbapprovals l2 WHERE l2.userID='$idUser'");
        
        
        $poinApp=$userPoin[0]['l2']['poinApp'];
        $divisiID=$userPoin[0]['l2']['divisiID'];
        $poin=(int)substr($poinApp,0,1);

        if(!empty($divisiID)){
            $poinApp=$poinApp.$divisiID;
        }


        // $query="SELECT * FROM fupbhistoryapprovals f2 
        // INNER JOIN (SELECT 
        //             generateID,noFUPB,nd,tb,prodName,divID,divName,tanggalFUPB,komposisi,dosis,indikasi,aturanPakai,sediaan,kemasan,jumlahKompetitor,jalurRegistrasi,statusKebutuhanMarketing,idPengaju,namaPengaju,statusFUPB FROM fupbs GROUP BY generateID,noFUPB,nd,tb,prodName,divID,divName,tanggalFUPB,komposisi,dosis,indikasi,aturanPakai,sediaan,kemasan,jumlahKompetitor,jalurRegistrasi,statusKebutuhanMarketing,idPengaju,namaPengaju,statusFUPB) as f ON f.generateID =f2.generateID 
        //             AND f2.poin=$poinApp AND f.divName like '%$divisiID%'";
        $query="SELECT * FROM fupbhistoryapprovals f2 INNER JOIN fupbs f  ON f.id = f2.fupbId AND f2.poin = '$poinApp' AND f.divName like '%$divisiID%'";

        

        //var_dump($query);exit();
        $progress='';
        switch ($poin) {
            case 1:
                //$query=$query." AND statusFUPB <>'Return'"; 
                $query=$query." AND (statusFUPB ='On' OR statusFUPB ='pembatalan') AND (f2.statusApp='open' OR f2.statusApp='pembatalan')";
                break;
            case 2:
                $query=$query." AND (statusFUPB = 'appL1' OR statusFUPB ='batalappL1') AND (f2.statusApp ='open' OR IF(SUBSTRING(f2.poin,1,2)='21',f2.statusApp='pembatalan',''))";
                //var_dump($query);exit();
                break;
            case 3:
                $query=$query." AND (statusFUPB ='appL2' OR statusFUPB ='batalappL2') AND (f2.statusApp='open' OR f2.statusApp='pembatalan')";
              break;
            
          }
          //var_dump($query);exit();
        // if($poin==1){
        //     $query=$query." AND statusFUPB <>'Return'";     
        //     //echo $query;exit();
        // }else if($poin==2){
        //     $query=$query." AND statusFUPB ='appL1' AND f2.statusApp='open'";
           
        // }else if($poin==3){
        //     $query=$query." AND statusFUPB ='appL2' AND f2.statusApp='open'";
            
        // };
        //cek user poin
        
        // $query="SELECT a.generateID,a.noFUPB,a.nd,a.tb,a.prodName,a.divID,a.divName,a.tanggalFUPB,a.komposisi,a.dosis,a.indikasi,
        // a.aturanPakai,a.sediaan,a.kemasan,a.jumlahKompetitor,a.jalurRegistrasi,a.statusKebutuhanMarketing,a.idPengaju,a.namaPengaju FROM dpfdplnew.fupbs a GROUP BY a.generateID";
       //var_dump($query);exit();
        $qsql=$this->User->query($query);
        //var_dump($qsql);exit();
        $jumQuery=count($qsql);
        
        $sum=ceil($jumQuery/$limit);
       
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal=$this->pageNavMulti($hm,$sum,$limit,$fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $Qtampil=$this->User->query($query." limit $start, $limit");

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
            $id=$dataRow['f']['id'];
            //$generateID=$dataRow['f']['generateID'];
            $noFUPB=$dataRow['f']['noFUPB'];
            $nd=$dataRow['f']['nd'];
            $tb=$dataRow['f']['tb'];
            $prodName=$dataRow['f']['prodName'];
            $divID=$dataRow['f']['divID'];
            if(!empty($divisiID)){
                $divName=$divisiID;
            }else{
                $divName=$dataRow['f']['divName'];
            }
            
            $tanggalFUPB=$dataRow['f']['tanggalFUPB'];
            $komposisi=$dataRow['f']['komposisi'];
            $dosis=$dataRow['f']['dosis'];
            $indikasi=$dataRow['f']['indikasi'];
            $aturanPakai=$dataRow['f']['aturanPakai'];
            //explode by character
            $sediaan=$dataRow['f']['sediaan'];
            $explodeSediaan=explode("~",$sediaan);

            $kemasan=$dataRow['f']['kemasan'];
            $jumlahKompetitor=$dataRow['f']['jumlahKompetitor'];
            $jalurRegistrasi=$dataRow['f']['jalurRegistrasi'];
            $statusKebutuhanMarketing=$dataRow['f']['statusKebutuhanMarketing'];
            $idPengaju=$dataRow['f']['idPengaju'];
            $namaPengaju=$dataRow['f']['namaPengaju'];
            $statusFUPB=$dataRow['f']['statusFUPB'];
            $poinLink=(int)substr($dataRow['f2']['poin'],0,1);
            $statusAppHis=$dataRow['f2']['statusApp'];
            $targetPriceBox=$dataRow['f']['targetPriceBox'];
            $targetPriceUnit=$dataRow['f']['targetPriceUnit'];
            $forecastQtyTh1=$dataRow['f']['forecastQtyTh1'];
            $forecastValueTh1=$dataRow['f']['forecastValueTh1'];
            $forecastQtyTh2=$dataRow['f']['forecastQtyTh2'];
            $forecastValueTh2=$dataRow['f']['forecastValueTh2'];
            $forecastQtyTh3=$dataRow['f']['forecastQtyTh3'];
            $forecastValueTh3=$dataRow['f']['forecastValueTh3'];
            $ujiBa=$dataRow['f']['ujiBa'];
            $infoTambahan=$dataRow['f']['infoTambahan'];
            if(!empty($ujiBa)){
                if($ujiBa=='Y'){
                    $ujiBa='Yes';
                }else{
                    $ujiBa='No';
                }
            }else{
                $ujiBa='Empty';
            }

            //var_dump($statusAppHis);exit();
            //cek active
            $sigPad="<div class='sigPad' id='linear' style='width:300px;'>
                        <ul class='sigNav'>
                            <li class='drawIt'><a href='#draw-it' >Tanda Tangan</a></li>
                            <li class='clearButton'><a href='#clear'>Clear</a></li>
                        </ul>
                        <div class='sig sigWrapper' style='height:auto;border-color:white;'>
                            <div class='typed'></div>
                            <canvas class='pad' width='300px' height='150'  id='canvas__".$id."' style='border: 1px solid #ddd;'></canvas>
                            <input type='hidden' name='output__".$id."' class='output'>
                        </div>
                    </div>";
            $button='';
            $preHeader='';
            // <button type='button' class='btn btn-warning btnReturn'><i class='fa fa-undo' aria-hidden='true'></i> Return</button>
            // <button type='button' class='btn btn-danger btnTerminate' style='display:none' ><i class='fa fa-ban' aria-hidden='true'></i> Terminate</button>
            if($poin==1){
                if($statusAppHis=='open'){
                    $statusApproval="<span class='label label-primary'>Usulan Produk</span>";
                    $button="<button type='button' class='btn btn-primary btnConfirm'><i class='fa fa-check-square-o' aria-hidden='true'></i> Confirm</button>
                    <button type='button' class='btn btn-warning btnReturn'><i class='fa fa-undo' aria-hidden='true'></i> Return</button>
                    <button type='button' style='display:none' class='btn btn-danger btnTerminate'><i class='fa fa-ban' aria-hidden='true'></i> Pembatalan</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                    $sigPad=$sigPad;
                }elseif($statusAppHis=='close'){
                    $button="<button type='button' class='btn btn-default btnConfirm' disabled><i class='fa fa-check-square-o' aria-hidden='true'></i> Confirm</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                    $sigPad='<h2>Formulir</h2>';
                }elseif($statusAppHis='pembatalan'){
                    $preHeader='PEMBATALAN';
                    $statusApproval="<span class='label label-danger'>Pembatalan Produk</span>";
                    $button="<button type='button' class='btn btn-danger btnTerminate'><i class='fa fa-ban' aria-hidden='true'></i> Pembatalan</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                    $sigPad=$sigPad;
                }
            }elseif($poin==2){
                if($statusAppHis=='open'){
                    $statusApproval="<span class='label label-primary'>Usulan Produk</span>";
                    $button="<button type='button' class='btn btn-primary btnConfirm' ><i class='fa fa-check-square-o' aria-hidden='true'></i> Confirm</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                }elseif($statusAppHis=='pembatalan'){
                    $preHeader='PEMBATALAN';
                    $statusApproval="<span class='label label-danger'>Pembatalan Produk</span>";
                    $button="<button type='button' class='btn btn-danger btnTerminate'><i class='fa fa-ban' aria-hidden='true'></i> Pembatalan</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                }
                $sigPad=$sigPad;
            }elseif($poin==3){
                if($statusAppHis=='open'){
                    $statusApproval="<span class='label label-primary'>Usulan Produk</span>";
                    $button="<button type='button' class='btn btn-primary btnConfirm' ><i class='fa fa-check-square-o' aria-hidden='true'></i> Confirm</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                }elseif($statusAppHis=='pembatalan'){
                    $preHeader='PEMBATALAN';
                    $statusApproval="<span class='label label-danger'>Pembatalan Produk</span>";
                    $button="<button type='button' class='btn btn-danger btnTerminate'><i class='fa fa-ban' aria-hidden='true'></i> Pembatalan</button>
                    <input type='hidden' name='fupbhisID' value='".$dataRow['f2']['id']."'>
                    <input type='hidden' name='genID' value='".$id."'>";
                }
                $sigPad=$sigPad;
            }
            
            $queryBrandCompatitors=$this->User->query("SELECT brand.companyId,brand.namaCompany,brand.primCompatitor,brand.brandName,brand.dosageForm,brand.unitPack,brand.pricePack,brand.priceUnit  FROM  dpfdplnew.fupbcompetitors brand WHERE brand.fupbId='$id' ORDER BY brand.id ASC");
            
            $KompetitorUtama='';
            $txtBrand='';
            foreach($queryBrandCompatitors as $dataBrand){
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
                $txtBrand.="<tr>
                                <td style='text-align:center;border-right: 1px solid #ddd;' colspan='2'>".$brandName."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$namaCompany."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$dosageForm."</td>
                                <td style='text-align:center;border-right: 1px solid #ddd;'>".$unitPack."</td>
                                <td style='text-align:right;border-right: 1px solid #ddd;'>Rp. ".number_format($pricePack,0,"",".")."</td>
                                <td style='text-align:right;'>Rp. ".number_format($priceUnit,0,"",".")."</td>
                            </tr>";
            }


            $txtData.="<tr class='active'>
                            <td style='text-align:center;'>".$no."</td>
                            <td><a data-toggle='collapse' data-parent='#accordion' href='#collapse$no' tooltip='Klik Untuk Melihat Detail'>".$noFUPB."</a></td>
                            <td style='text-align:center;'>".$this->Function->dateindo($tanggalFUPB)."</td>
                            <td>".$prodName."</td>
                            <td style='text-align:center;'>".$divName."</td>
                            <td>".$namaPengaju."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$statusApproval."</span></td>
                            <td><button style='display:none' type='button' class='btn btn-xs btn-danger printBtn'><i class='fa fa-print fa-lg' style='margin: 5px 5px;' ></i></button></td>
                            <td style='display:none'>$id</td>
                        </tr>";

            
            $txtData=$txtData."<tr class='trEven' style='height:0px;'>
                            <td colspan='8' style='background-color:#FFF; class='zeroPadding passive'>
                                <div id='collapse$no' class='collapse out' style='padding:10px;background-color: cornsilk'>
                                    <div class='row' >
                                        <div class='col-md-8 col-md-offset-2'>
                                            <div class='panel panel-primary' style='border-radius: 5px;margin-bottom:10px;'>
                                                <div class='panel-body' >
                                                    <div class='panel panel-success' style='border-radius: 5px;margin-bottom:0;'>
                                                        <div class='panel-heading' style='text-align:center;background-color:#dff0d8;'>
                                                            ".$sigPad."
                                                        </div>
                                                        <div class='panel-body'  style='margin-bottom:unset;padding:0 15px;'>
                                                            <div class='row'>
                                                                <table class='tblDetail table'  style='margin-bottom:unset;padding:0 15px;'width='100%'>
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
                                                                        <td  colspan='7' style='border-top: unset;'>Tanggal :  ".$this->Function->dateindo($tanggalFUPB)."</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='width:20%;font-weight: bold;'>Nama Project</td>
                                                                        <td >:</td>
                                                                        <td style='width:70%' colspan='5'>".$prodName."</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='width:10%;font-weight: bold;'>Divisi</td>
                                                                        <td >:</td>
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
                                                                        <td style='width:14%;font-weight: bold;'>Indikasi</td>
                                                                        <td style='width:3%; text-align:center;'>:</td>
                                                                        <td colspan='5'>".$indikasi."</td>
                                                                    </tr>
                                                                    <tr>   
                                                                        <td style='font-weight: bold;'>Aturan Pakai</td>
                                                                        <td style='text-align:center;'>:</td>
                                                                        <td colspan='5'>".$aturanPakai."</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='font-weight: bold;vertical-align: middle;'> Spesifikasi Sediaan</td>
                                                                        <td style='text-align:center;vertical-align: middle;'>:</td>
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
                                                                    <tr>
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
                                                                        <th width='20%'  colspan='2' style='text-align:center;background:#f5f5f5 !important;border-right: 1px solid #ddd;'>Brand Name</th>                  
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
                                                                    <tr>
                                                                        <td style='font-weight: bold;vertical-align: middle;'> Target Price</td>
                                                                        <td style='text-align:center;vertical-align: middle;'>:</td>
                                                                        <td colspan='5'>
                                                                            <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                                <tr>
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>Box</td>
                                                                                    <td style='width:35%;text-align:right;'>Rp. ".number_format($targetPriceBox,0,"",".")."</td>
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>Unit</td>
                                                                                    <td style='width:35%;text-align:right;'>Rp. ".number_format($targetPriceUnit,0,"",".")."</td>
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
                                                                                    <td style='width:35%;text-align:right;'>".$forecastQtyTh1."</td>
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                    <td style='width:35%;text-align:right;'>".$forecastValueTh1."</td>
                                                                                </tr>  
                                                                            </table>
                                                                            <table class='table table-bordered ' width='100%' style='margin:5px 0;'>
                                                                                <tr><td colspan='4' style='background-color:#f5f5f5 !important;font-weight: bold;font-style: oblique;'>Thn. Kedua</td></tr>
                                                                                <tr>
                                                                                   
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>QTY</td>
                                                                                    <td style='width:35%;text-align:right;'>".$forecastQtyTh2."</td>
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                    <td style='width:35%;text-align:right;'>".$forecastValueTh2."</td>
                                                                                </tr>  
                                                                            </table>
                                                                            <table class='table table-bordered' width='100%' style='margin-bottom:unset;'>
                                                                                <tr><td colspan='4' style='background-color:#f5f5f5 !important;font-weight: bold;font-style: oblique;'>Thn. Ketiga</td></tr>
                                                                                <tr>
                                                                                    
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>QTY</td>
                                                                                    <td style='width:35%;text-align:right;'>".$forecastQtyTh3."</td>
                                                                                    <td style='width:15%;background-color:#f5f5f5 !important;'>Value</td>
                                                                                    <td style='width:35%;text-align:right;'>".$forecastValueTh3."</td>
                                                                                </tr>  
                                                                            </table>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='font-weight: bold;'>Uji BA</td>
                                                                        <td style='text-align:center;'>:</td>
                                                                        <td colspan='5'>".$ujiBa."</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='font-weight: bold;'>Info Tambahan</td>
                                                                        <td style='text-align:center;'>:</td>
                                                                        <td colspan='5'>".$infoTambahan."</td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class='panel-footer'>
                                                ".$button."
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
    //confirm action
    public function saveConfirm(){
        $this->autoRender = false;
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //cek variable
            //var_dump($_POST);exit();
            $tanggalApp=date("Y-m-d");
            $idHisFupb=$_POST['idHisFupb'];
           
            $img = $_POST['photo'];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            
            $this->User->query("UPDATE dpfdplnew.fupbhistoryapprovals SET tanggalApp='$tanggalApp',statusApp='close'  WHERE id='$idHisFupb'");
 
            //cek data close
            $query=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.id='$idHisFupb'");
            
            $fupbId=$query[0]['f2']['fupbId'];
            $poinHisConfirm=$query[0]['f2']['poin'];

            $poinLevel=(int)substr($poinHisConfirm,0,1);
            
            $cekDataOpen=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.fupbId='$fupbId' AND SUBSTRING(f2.poin,1,1)='$poinLevel' AND f2.statusApp='open'");
            $jmlData=count($cekDataOpen);
            if($jmlData == 0){
                //var_dump('true');exit();
                //updateLevel
                $queryUpdate="UPDATE dpfdplnew.fupbs SET";
                if($poinLevel==3){
                    $queryUpdate=$queryUpdate." statusFUPB='Finish',appL3='close'";
                }elseif($poinLevel==2){
                    $queryUpdate=$queryUpdate." statusFUPB='appL2',appL2='close'";
                }elseif($poinLevel==1){
                    $queryUpdate=$queryUpdate." statusFUPB='appL1',appL1='close'";
                }
                $queryUpdate=$queryUpdate." WHERE id='$fupbId'";
                //var_dump( $queryUpdate);exit();

                $this->User->query($queryUpdate);
            }
           
            $file = 'img/fupb/'.$fupbId.'_ttd_'.$poinHisConfirm.'.png';
            $success = file_put_contents($file, $data);

            echo "success";

            //upadte fupb
            
            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    //return action
    public function saveReturn(){
        $this->autoRender = false;
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //cek variable
            //var_dump($_POST);exit();
            $tanggalApp=date("Y-m-d");
            $idHisFupb=$_POST['idHisFupb'];
            $alasanReturn=$_POST['alasanReturn'];

            $this->User->query("UPDATE dpfdplnew.fupbhistoryapprovals SET tanggalApp='$tanggalApp',statusApp='Return',note='$alasanReturn'  WHERE id='$idHisFupb'");

            

            $query=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.id='$idHisFupb'");
            $fupbId=$query[0]['f2']['fupbId'];

            
            $this->User->query("UPDATE dpfdplnew.fupbhistoryapprovals SET tanggalApp='$tanggalApp',statusApp='Return'  WHERE fupbId='$fupbId'");
            $queryUpdate="UPDATE dpfdplnew.fupbs SET statusFUPB='Return',appL1='Return',appL2='Return',appL3='Return' WHERE id='$fupbId'";
            $this->User->query($queryUpdate);

            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    //save terminate 
    public function saveTerminate(){
        $this->autoRender = false;
		echo $this->Function->cekSession($this);
        $this->loadModel('User');
        try{
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            //cek variable
            //var_dump($_POST);exit();
            $tanggalApp=date("Y-m-d");
            $idHisFupb=$_POST['idHisFupb'];

            $img = $_POST['photo'];
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $this->User->query("UPDATE dpfdplnew.fupbhistoryapprovals SET tanggalApp='$tanggalApp',statusApp='batal'  WHERE id='$idHisFupb'");

            $query=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.id='$idHisFupb'");
            $fupbId=$query[0]['f2']['fupbId'];
            $poinHisConfirm=$query[0]['f2']['poin'];
            $poinLevel=(int)substr($poinHisConfirm,0,1);
            
            $this->User->query("UPDATE dpfdplnew.fupbhistoryapprovals SET statusApp='batal',tanggalApp=NULL  WHERE fupbId='$fupbId' AND  SUBSTRING(poin,1,1)='2' AND NOT SUBSTRING(poin,1,2)='21'");

            $cekDataOpen=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.fupbId='$fupbId' AND SUBSTRING(f2.poin,1,1)='$poinLevel' AND f2.statusApp='pembatalan'");

            
            $cekDataOpen=$this->User->query("SELECT * FROM dpfdplnew.fupbhistoryapprovals f2 WHERE f2.fupbId='$fupbId' AND SUBSTRING(f2.poin,1,1)='$poinLevel' AND f2.statusApp='pembatalan'");
            $jmlData=count($cekDataOpen);
            if($jmlData == 0){
                //var_dump('true');exit();
                //updateLevel
                $queryUpdate="UPDATE dpfdplnew.fupbs SET";
                if($poinLevel==3){
                    $queryUpdate=$queryUpdate." statusFUPB='batal',appL3='batal'";
                }elseif($poinLevel==2){
                    $queryUpdate=$queryUpdate." statusFUPB='batalappL2',appL2='batal'";
                }elseif($poinLevel==1){
                    $queryUpdate=$queryUpdate." statusFUPB='batalappL1',appL1='batal'";
                }
                $queryUpdate=$queryUpdate." WHERE id='$fupbId'";
                //var_dump( $queryUpdate);exit();

                $this->User->query($queryUpdate);
            }
            
            $file = 'img/fupb/'.$fupbId.'_ttd_batal_'.$poinHisConfirm.'.png';
            $success = file_put_contents($file, $data);
            
            echo "sukses";

            $dataSource->commit();	
        }
        catch(Exception $e){
            var_dump($e->getTrace());
                $dataSource->rollback();
        }
    }

    //cetak pdf
    public function cetakpdf(){
        $this->autoRender = false;
        $this->loadModel('User');

        $idUser=$this->Session->read('dpfdpl_userId');
        
        $genID=$_POST['idCetakPDF'];

        


        $this->set('pdf',$genID);
		$this->render('cetakpdf');


    }
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
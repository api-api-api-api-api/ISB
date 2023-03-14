<?php 
    echo $this->Html->script('h1erfrekomendasibalik.js');
    echo $this->Html->script('bundle.min.js');
    echo $this->Html->script('editor.js');
    echo $this->Html->script('jquery.signaturepad.min.js');
    echo $this->Html->css('jquery.signaturepad.css');

    echo $this->Html->css('/css/editor'); 
?>

<style>
    table{margin-bottom: 10px;}
    table tr td{padding: 5px;}
    textarea{border:unset !important;background:cornsilk !important;-webkit-box-shadow:none !important;}
    .divider-text {position: relative;text-align: center;margin-top: 15px;margin-bottom: 15px;}
    .divider-text span {padding: 7px;font-size: 12px;position: relative;z-index: 2;}
    .divider-text:after {content: "";position: absolute;width: 100%;border-bottom: 1px solid #ddd;top: 55%;left: 0;z-index: 1;}
    .bg-light {background-color: #f8f9fa!important;}
    .form-group{margin-bottom:0;}
    #linkHal1  ul {margin:0 !important;}
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
     input[type="text"] {box-shadow:unset !important;border:none }
    .input-group-addon{font-size:12px;}
    /* Select Pure Auto complate */
    .select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
    .select-pure__select {align-items: center;border-radius: 0;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 34px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
    .select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;
    overflow-y: scroll; position: absolute; top: 35px; width: 100%; z-index: 5;}
    .select-pure__select--opened .select-pure__options { display: block;}
    .select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
    .select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
    .select-pure__option--hidden { display: none;}
    .select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
    .select-pure__selected-label:last-of-type { margin-right: 0;}
    .select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
    .select-pure__selected-label i:hover {  color: #e4e4e4;}
    .select-pure__autocomplete {background: #faebcc; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 16px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}

    input[type="radio"]{box-shadow: unset;}
    input[type='radio']{height: 16px !important;cursor: pointer;}
    input[type='radio']:focus{box-shadow:unset;}
    .tglInterview{margin-bottom:0px !important;padding: 3px!important;background:cornsilk;font-size:11px; }
     #loading { z-index: 1090; } 
    /* End Select Pure Auto complate */
    #iframeDetail footer {
        position: fixed !important;
        bottom: 0px !important;
    }
    .modal-open {
        overflow: hidden !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Form Add -->
        <form id="h1form" name="formBB" method="POST">
            <h1 class="mt-4">REKOMENDASI PELAMAR</h1><hr>
            <div class="col-md-12">
                <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" >List Pengajuan
                        </div>
                        <div class="panel-body table-responsive" style="padding-top:0;padding-bottom:0;" >   
                            <div class="row">
                                <table id="tableListPengajuan" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">no</th>
                                            <th width="15%">Nomor Pengajuan</th>
                                            <th>Dasar Permintaan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Form>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalLinkPelamar" style="max-width: 80%; max-height: 95%; margin-left: 10%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 6px;min-height: unset;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.body.style.overflow = 'scroll'">
                    <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Penilaian Rekomendasi Pelamar</h4>
            </div>     
            <div class="modal-body" style="height: 750px;max-height: 750px;overflow-y:auto;">
                <input type="hidden" id="idBdclinktofupb">
                <input type="hidden" id="idFupblinktoBdc">
                <div class="panel panel-default" style="min-width:400px">
                    <div class="panel-heading clearfix" style="background-color:#696969;color:#fff">
                        <div class="row">
                            <div class="col-md-7" style="line-height: 32px;">
                                Nomor Employee Recruitment
                            </div>
                            <div class="col-md-5 col-md-offset-0 text-right"  >                  
                                <input type="text" id="nomorErfModal" class="form-control"  placeholder="NOMOR ER" style="font-size:14px;height: 34px;text-align:right;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive"  style="margin-bottom:unset;padding:0 15px; ">
                        <div class="row">
                            <table id="tableModalListPelamar" class="table table-bordered" style="margin-bottom:unset;padding:0 15px;">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;vertical-align:middle;">NO.</th> 
                                        <th width="35%" style="text-align:center;vertical-align:middle;" colspan='2'>PELAMAR</th>     
                                        <th width="20%" style="text-align:center;vertical-align:middle;">Dasar Permintaan</th>   
                                        <th width="35%" style="text-align:center;vertical-align:middle;">Spesifikasi Kebutuhan</th>   
                                        <th width="10%" style="text-align:center;vertical-align:middle;">Penilaian</th>         
                                        <!-- <th width="85%" style="text-align:center;">PENILAIAN CALON KARYAWAN</br>APPLICANT EVALUATION FORM</th> -->
                                        <!-- <th width="15%" style="text-align:center;">Hasil Akhir</th>
                                        <th width="25%" style="text-align:center;">Keterangan</th>
                                        <th width="10%" style="text-align:center;">Submit</th> -->
                                    </tr>
                                </thead> 
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    <div class="panel-footer">
                        <nav aria-label="Page navigation example " id="linkHal2" style="display:none"></nav>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-default ml-1" data-dismiss="modal" onclick="document.body.style.overflow = 'scroll'"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                    </div>
                </div>
            </div>
        </div>
  
    </div>
</div>

<!-- Modal link detail pelamar -->
<div class="modal fade" role="dialog" id="modalLinkDetailPelamar" style="max-width: 80%; max-height: 95%; margin-left: 10%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 6px;min-height: unset;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.body.style.overflow = 'hidden'">
                    <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">INFORMASI DETAIL PELAMAR</h4>
            </div>  
            <div class="modal-body" style="height:740px;max-height:740px;">  
                <iframe src="" width="100%" style="min-height:725px" id="iframeDetail" frameborder="0" onload="onLoadHandler()"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="document.body.style.overflow = 'hidden'"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Penilaian Rekomendasi -->
<div class="modal fade" role="dialog" id="modalPenilaianRekomendasi" style="max-width: 80%; max-height: 95%; margin-left: 10%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog " role="" >
        <div class="modal-content" style="border-radius: 6px;min-height: unset;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.body.style.overflow = 'hidden'">
                    <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
                </button>
                <h4 class="modal-title" id="myModalLabelPenilaianPelamar">PENILAIAN PELAMAR : NOMOR ERF:</h4>
            </div>  
            <div class="modal-body" style="height:740px;max-height:740px;overflow-y:auto;">  
                <div class='alert alert-danger' role='alert' $displayNone>
                    <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>
                    <strong>Harap diperhatikan,</strong> sebelum anda melakukan aksi simpan, pastikan data yang anda inputkan sudah sesuai !!!
                </div>

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
                        
                        <!--  -->
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
                                        <td style='width:1%;  border-left-style: none;border-right-style: none;'>:</td>
                                        <td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
                                            <div id='txtTglDibutuhkan'>".$tglDibutuhkan."</div>
                                        </td>
                                        <td style='width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;'>
                                            Tanda Tangan / Signature :
                                        </td>
                                        <td style='width:1%;border-left-style: none;border-right-style: none;'>:</td>
                                        <td style='width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;'>
                                            *tanda tangan di bawah
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
                        <!--  -->

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
                        
                        <!--  -->
                        
                        <table class='table table-bordered' width='100%' ;>
                                        <tr>
                                            <td style='width:2%;text-align:center;font-weight'><strong>No</strong></td>
                                            <td style='width:35%;text-align:center;'><strong>Penilaian / Appraisal</strong></td>
                                            <td style='width:43%;text-align:center;'><center><strong>Penjelasan / Remark</strong></center></td>
                                            <td style='width:5%;text-align:center;'><strong>A</strong></td>
                                            <td style='width:5%;text-align:center;'><strong>B</strong></td>
                                            <td style='width:5%;text-align:center;'><strong>C</strong></td>
                                            <td style='width:5%;text-align:center;'><strong>D</strong></td>
                                        </tr>
                                    <!-- start php -->
                                    <?php
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
                                            for($i=0;$i<8;$i++){
                                                $no=$i+1;?>
                                                <tr>
                                                    <td style='width:2%;'><?=$no;?>.</td>
                                                    <td style='width:35%;'><?=$penilaianAppraisal[$i];?></td>
                                                    <td style='width:43%;'><?=$penjelasan[$i];?></td>
                                                    <td style='width:5%;text-align:center;vertical-align: middle;'>
                                                    <input type='radio' class='form-control' id='penilaian<?=$no;?>_a' name='<?=$penilaianNameInput[$i];?>' value='a'></td>
                                                    <td style='width:5%;text-align:center;vertical-align: middle;'>
                                                    <input type='radio' class='form-control' id='penilaian<?=$no;?>_b' name='<?=$penilaianNameInput[$i];?>' value='b'></td>
                                                    <td style='width:5%;text-align:center;vertical-align: middle;'>
                                                    <input type='radio' class='form-control' id='penilaian<?=$no;?>_c' name='<?=$penilaianNameInput[$i];?>' value='c'></td>
                                                    <td style='width:5%;text-align:center;vertical-align: middle;'>
                                                    <input type='radio' class='form-control' id='penilaian<?=$no;?>_d' name='<?=$penilaianNameInput[$i];?>' value='d'></td>
                                                </tr>
                                            
                                            <?php } ;?>
                                        <!-- end php -->
                                    
                                    </table>      

                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <strong>Penilaian/Komentar Tambahan /<em> Apprisial/Additional Comments</em></strong> 
                            </div>
                            <div class='panel-body'>
                                <textarea name='keteranganRekomendasi' id='keteranganRekomendasi' cols='30' rows='10' class='form-control'></textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'>
                                Kesimpulan (Harap dibubuhkan paraf dibawah pilihan anda)
                                <br>
                                <em>conlusion(Please provide initial under chosen remarks)</em>
                                <br>
                                <table width='100%'>
                                    <tr>
                                        <td><input type='radio' class='hp1 form-control' name='rekomendasi' value='direkomendasi'></td>
                                        <td>direkomendasikan/diusulkan <br><em> recomended</em></td>
                                        <td><input type='radio' class='hp2 form-control' name='rekomendasi' value='dicadangkan'></td>
                                        <td>dicadangkan/dapat dipertimbangkan <br><em> reserved</em></td>
                                        <td><input type='radio' class='hp3 form-control' name='rekomendasi' value='tidak direkomendasi'></td>
                                        <td>tidak direkomendasikan <br><em> not recomended</em></td>
                                    </tr>
                                </table>
                                <br>
                                <div class='sigPad' id='linear' style='width:300px;display:none;' >
                                    <ul class='sigNav'>
                                        <li class='drawIt'><a href='#draw-it' >Diserahkan Oleh</a></li>
                                        <li class='clearButton'><a href='#clear'>Hapus</a></li>
                                    </ul>
                                    <div class='sig sigWrapper' style='height:auto;border-color:white;'>
                                        <div class='typed'></div>
                                        <center><canvas class='pad' style='border: 1px solid #ddd;' width='300px' height='150px' id='canvas__'></canvas></center>
                                        <input type='hidden' name='output' class='output'>
                                    </div>
                                </div>              
                            </div>
                        </div>
                        <!--  -->
                    </div> 
                    <div class='panel-footer'>
                        <div class='row'>
                            <div class='col-xs-12'> 
                                <div class='form-group'>   
                                    <div class='alert alert-danger' role='alert'>
                                        <i class='fa fa-exclamation-circle fa-lg' aria-hidden='true'></i>
                                        <strong>Harap diperhatikan,</strong> sebelum anda melakukan aksi simpan, pastikan data yang anda inputkan sudah sesuai !!!
                                    </div>
                                </div>
                            </div>      
                            <div class='col-xs-12 text-center'>
                                <div class='form-group' id='setButtonPenilaian'>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="document.body.style.overflow = 'hidden'"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- End modal link pelamar -->

<blockquote>Approval Employee Recruitment</blockquote>
<hr>
<body>
<?php
    echo $this->Html->script('h1Erfapprovalatasans.js');
    echo $this->Html->script('bundle.min.js');   
    echo $this->Html->script('jquery.signaturepad.min.js');
    echo $this->Html->css('jquery.signaturepad.css');

        $groupId=$this->Session->read('dpfdpl_groupId');   
    if($groupId!="24"){
         // header("Location: mainmenus");
   // die();
    }    

?>

<style>
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
    /* End Select Pure Auto complate */
</style>

<style>
    .divider-text {position: relative;text-align: center;margin-top: 15px;margin-bottom: 15px;}
    .divider-text span {padding: 7px;font-size: 12px;position: relative;z-index: 2;}
    .divider-text:after {content: "";position: absolute;width: 100%;border-bottom: 1px solid #ddd;top: 55%;left: 0;z-index: 1;}
    .bg-light {background-color: #f8f9fa!important;}
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
        width: 49%;
        color:black;
        height:20px;
    }
</style>
<body>
 <table class="table table-bordered" style="margin-left: 2px; margin-right: 2px; width: 100%;" id="tblApprovals">
    <thead>
      <tr >
        <th width="5%">No</th>
        <th width="15%">Posisi</th>
        <th width="60%">Nama Pengaju</th>
        <th width="20%">Tanggal</th>
      </tr>
    </thead>
    <tbody id="tbodyPeminjaman">
    
     
    </tbody>
  </table>
  <br>


<div id="modalPermintaan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Pengajuan</h4>
      </div>
      <div class="modal-body" id="isiModal">
   
        <table border="0" width="100%" class="table">
            <tr >
                <td style="font-size: 12px; width: 35%;">
                    Nomor
                </td>
                <td style="font-size: 12px; width: 2%;">
                    :
                </td>
                <td style="font-size: 12px; width: 50%;" id="txt_nomorErf">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;width: 35%;">
                    Tanggal Pengajuan
                </td>
                <td style="font-size: 12px;width: 2%;">
                    :
                </td>
                <td style="font-size: 12px;width: 50%;" id="txt_tglPengajuan">
                   Nama
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    pemohon
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_pemohon">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    divisi
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_divisi">
                  
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    jabatan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_jabatan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    dasar permintaan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_dasarPermintaan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Posisi
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_posisi">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Di butuhkan Tanggal
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_tglDibutuhkan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Status Karyawan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_statusKaryawan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Jenis Kelamin
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_jenisKelamin">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    pendidikan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_pendidikan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Pengalaman Kerja
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_pengalamanKerja">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Pengalaman Kerja Secara
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_pengalamanSecara">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Penguasaan Bahasa
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_penguasaanBahasa">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Penempatan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_penempatan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Keterampilan
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_keterampilan">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Persyaratan Lainya
                </td>
                <td style="font-size: 12px;">
                    :
                </td>
                <td style="font-size: 12px;" id="txt_persyaratanLainnya">
                   
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;">
                    Tugas dan tanggung jawab/Lainnya
                </td>
                <td style="font-size: 12px;" colspan="2">
                    :
                </td>
            </tr>

            <tr>
                <td style="font-size: 12px;" colspan="3">
                    <textarea rows="4" style="width:100%" id="txt_ttjOrlainnya">
                        
                    </textarea>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <div class="sigPad" id="smoothed" style="width:100%;">
                               
                                <ul class="sigNav">
                                <li class="drawIt"><a href="#draw-it" >Diserahkan Oleh</a></li>
                                <li class="clearButton"><a href="#clear">Hapus</a></li>
                                </ul>
                                <div class="sig sigWrapper" style="height:auto;">
                                <div class="typed"></div>
                                <center>
                                <canvas class="pad" style="max-width: 100%;" width="400" height="250" id="canvas__"></canvas>
                                </center>
                                <input type="hidden" name="output" class="output">
                                </div>
                                </div>
                  </div>
                </td>
            </tr>

        </table>
        <button type="button" class="btn btn-primary" onclick="approve()">Approve</button>
        <button type="button" class="btn btn-warning" onclick="tolak()">Tolak</button>
        <br><br>

  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

       
</body>  


       
</body>  

         
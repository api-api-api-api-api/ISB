
<blockquote>Form HRD Employee Recruitment</blockquote>
<hr>
<body>
<?php
    echo $this->Html->script('h1Erfapprovalhrds.js');
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

    .divider-text {position: relative;text-align: center;margin-top: 15px;margin-bottom: 15px;}
    .divider-text span {padding: 7px;font-size: 12px;position: relative;z-index: 2;}
    .divider-text:after {content: "";position: absolute;width: 100%;border-bottom: 1px solid #ddd;top: 55%;left: 0;z-index: 1;}
    .bg-light {background-color: #f8f9fa!important;}
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
        width: 49%;
        color:black;
        height:20px;
    }
    #loading { z-index: 1090; } 
    .tableDetil tr td {border-top:unset !important;}
</style>
<body>
 <table class="table table-bordered" style="margin-left: 2px; margin-right: 2px; width: 100%;" id="tblApprovals">
    <thead>
      <tr >
        <th width="2%">No</th>
        <th width="15%">Pengaju</th>
        <th width="10%">Nomor Pengajuan</th>
        <th width="8%">Tanggal Pengajuan</th>
        <th width="40%">Dasar Permintaan</th>
        <th width="5%">Posisi</th>
        <th width="8%">Tanggal Dibutuhkan</th>
        <th width="10%">Kategori Approval</th>
        
      </tr>
    </thead>
    <tbody id="tbodyPeminjaman">
    
     
    </tbody>
  </table>
  <br>


  <!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="modalPelamar" class="modal fade" role="dialog"  data-backdrop="false" style=" overflow-y: initial !important">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="reopenModalApproval()">&times;</button>
        <h4 class="modal-title">Data Pelamar Tersedia</h4>
      </div>
      <div class="modal-body " style="height:790px;max-height:790px;overflow-y:auto;overflow-x:auto;">
       <table border="0" width="100%" class="table table-bordered" >
            <tr >
                <th style="font-size: 14px; width: 2%;">
                    N0
                </th>
                <th style="font-size: 14px; width: 2%;" >
                    Add
                </th>
                <th style="font-size: 14px; width: 10%;">
                    Foto
                </th>
                <th style="font-size: 14px; width: 15%;">
                    Nama
                </th>
                <th style="font-size: 14px; width: 10%;">
                    Tempat/Tanggal Lahir
                </th>
                <th style="font-size: 14px; width: 5%;" >
                    J. Kelamin
                </th>
                <th style="font-size: 14px; width: 5%;" >
                    Agama
                </th>
                <th style="font-size: 14px; width: 7%;" >
                    Status Perkawinan
                </th>
                <th style="font-size: 14px; width: 5%;" >
                    Handphone
                </th>
                <th style="font-size: 14px; width: 5%;" >
                    Tinggi/Berat
                </th>
                <th style="font-size: 14px; width: 10%;" >
                    Jabtan Sekarang
                </td>
                <th style="font-size: 14px; width: 10%;" >
                    Kota Dilamar
                </th>
                 <th style="font-size: 14px; width: 10%;" >
                    Melamar Bagian
                </th>
                
            </tr>
            <tbody id="tbodyListPelamar">
                
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reopenModalApproval()">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="modalPermintaan" class="modal fade" role="dialog" style="overflow-y: initial !important">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DETAIL PENGAJUAN</h4>
      </div>
      <div class="modal-body" id="isiModal">
   
        <table  width='100%' class='table table-bordered'>
            <tr>
                <td width='50%'>
                    <table width="100%" class="table tableDetil">
                        <tr class='active'>
                            <th style="font-size: 14px; width: 35%; border-top:none;">NOMOR</th>
                            <th style="font-size: 14px; width: 3%; border-top:none;">:</th>
                            <th style="font-size: 14px; width: 62%; border-top:none;" id="txt_nomorErf"></th>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;width: 35%;">TANGGAL PENGAJUAN</td>
                            <td style="font-size: 14px;width: 2%;">:</td>
                            <td style="font-size: 14px;width: 50%;" id="txt_tglPengajuan">Nama</td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">PEMOHON</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_pemohon"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">DIVISI</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_divisi"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">JABATAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_jabatan"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">DASAR PERMINTAAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_dasarPermintaan"></td>
                        </tr>

                        
                    </table>
                </td>
                <td width='50%' valign="top">
                    <table width="100%" class="table tableDetil" >    
                        <tr class='active'>
                            <th style="font-size: 14px; width: 35%; border-top:none;">SPESIFIKASI KEBUTUHAN</th>
                            <th style="font-size: 14px; width: 3%; border-top:none;"></th>
                            <th style="font-size: 14px; width: 62%; border-top:none;" ></th>
                        </tr>  
                        <tr>
                            <td style="font-size: 14px;">POSISI</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_posisi"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;">DIBUTUHKAN TANGGAL</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_tglDibutuhkan"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">STATUS KARYAWAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_statusKaryawan"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">JENIS KELAMIN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_jenisKelamin"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;">PENDIDIKAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_pendidikan"></td>
                        </tr>  
                        <tr>
                            <td style="font-size: 14px;width: 35%;">PENGALAMAN KERJA</td>
                            <td style="font-size: 14px;width: 3%;">:</td>
                            <td style="font-size: 14px;width: 62%;" id="txt_pengalamanKerja"></td>
                        </tr>
                        <tr style='display:none;'>
                            <td style="font-size: 14px;">PENGALAMAN KERJA SECARA</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_pengalamanSecara"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">PENGUASAAN BAHASA</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_penguasaanBahasa"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">PENEMPATAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_penempatan"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">KETERAMPILAN</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_keterampilan"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">PERSYARATAN LAINNYA</td>
                            <td style="font-size: 14px;">:</td>
                            <td style="font-size: 14px;" id="txt_persyaratanLainnya"></td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;">TUGAS DAN TANGGUNG JAWAB /LAINNYA</td>
                            <td style="font-size: 14px;" >:</td>
                            <td style="font-size: 14px;"  id="txt_ttjOrlainnya"></td>
                        </tr>

                        <tr style='display:none;'>
                            <td style="font-size: 14px;">KETERANGAN APPROVAL</td>
                            <td style="font-size: 14px;" >:</td>
                            <td style="font-size: 14px;">
                                <textarea rows="4" class='form-control' style="width:100%" id="txt_keteranganApproval"></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <div class="form-inline">
                    <div class="form-group">
                    <h5>Rekomendasi Pelamar</h5> 
                    
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="btnTambahPelamar" onclick="tambahPelamar()"> <i class="fa fa-address-book" aria-hidden="true"></i><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> Tambah Pelamar</button>
                </div>
            </div>
            <div class="panel-body table-responsive"  style="margin-bottom:unset;padding:0px; ">
                <table width="50%" class="table table-bordered">
                    <tr>
                        <td width='50%' valign="top">
                            <table width="50%" class="table table-bordered" id="tableTambahPelamar">
                                <thead>
                                    <!-- <tr class='active'>
                                        <th style="font-size: 12px; width: 2%;">No</th>
                                        <th style="font-size: 12px; width: 20%;">Nama</th>
                                        <th style="font-size: 12px; width: 10%;">Tanggal Lahir</th>
                                        <th style="font-size: 12px; width: 10%;" >Jenis Kelamin</th>
                                        <th style="font-size: 12px; width: 10%;" >Agama</th>
                                        <th style="font-size: 12px; width: 10%;" >Handphone</th>
                                        <th style="font-size: 12px; width: 10%;" >Tinggi/Berat Badan</th>
                                        <th style="font-size: 12px; width: 10%;" >Jabtan Sekarang</td>
                                        <th style="font-size: 12px; width: 10%;" >Melamar Bagian</th>
                                        <th style="font-size: 12px; width: 10%;" >Terpilih</th>
                                        <th style="font-size: 12px; width: 10%;" >Feedback Rekomendasi</th>
                                        <th style="font-size: 12px; width: 5%;" >Delete</th>
                                    </tr> -->
                                    <tr class='active'>
                                        <th style="font-size: 12px; width: 2%;">No</th>
                                        <th style="font-size: 12px; width: 10%;">Pelamar</th>
                                        <th style="font-size: 12px; width: 15%;">Set Tanggal Masuk jika terpilih</th>
                                        <th style="font-size: 12px; width: 10%;" >Terpilih</th>
                                        <th style="font-size: 12px; width: 10%;" >Feedback Rekomendasi</th>
                                        <th style="font-size: 12px; width: 5%;" >Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPelamar">
                                </tbody>
                            
                            </table>
                            <div class="form-inline">
                                <div class="form-group " style="display:none">
                                    <input type="text" class="form-control" id="inputTanggalMasuk"  placeholder="Tentukan tanggal masuk" style="min-width:250px;">  
                                </div>
                                <button type="button" class="btn btn-success btn-sm" onclick="penyelesaian()" id="btnPenyelesaian">Penyelesaian</button>
                            </div>
                           
                            
                        </td>
                        <td  valign='middle' align='center' >
                            <div class='panel panel-default'>
			                    <div class='panel-body' style='padding:35px;' id='tampilRekomendasiBalik'>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
             
        </div>
        
        
        <br>

        <table width="100%" style="margin-top: 10px" id="tblTdd">

            <tr>
                <td >
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
        <br>
        <button type="button" class="btn btn-primary" onclick="approve()" id="btnApprove">Approve</button>
        <button type="button" class="btn btn-warning" onclick="tolak()" id="btnTolak">Tolak</button>
        <button type="button" class="btn btn-warning" onclick="pembatalan()" id="btnPembatalan">Pembatalan</button>
        
        <br><br>

  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal link detail pelamar -->
<div class="modal fade" role="dialog" id="modalLinkDetailPelamar" style="max-width: 80%; max-height: 95%; margin-left: 10%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 6px;min-height: unset;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reopenModalApproval(),$('#iframeDetail').attr('src','about:blank')">
                    <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">INFORMASI DETAIL PELAMAR</h4>
            </div>  
            <div class="modal-body" style="height:740px;max-height:740px;">  
                <iframe src="" width="100%" style="min-height:725px" id="iframeDetail" frameborder="0" onload="onLoadHandler()"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reopenModalApproval(),$('#iframeDetail').attr('src','about:blank');"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- <script>-->
       
<!-- </body>   -->


       
</body>  

         
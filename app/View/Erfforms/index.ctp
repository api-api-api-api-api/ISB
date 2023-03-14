
<?php 
    echo $this->Html->script('h1erfform.js');
    echo $this->Html->script('bundle.min.js');
    echo $this->Html->script('editor.js');
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
    /* End Select Pure Auto complate */
</style>


<div class="container-fluid">

    <div class="row">
        <!-- Form Add -->
        <form id="h1form" name="formBB" method="POST">
            <h1 class="mt-4">EMPLOYE RECRUITMENT FORM</h1><hr>
            <div class="col-xs-12">
                <div class="form-inline text-right">
                    <div class="form-group">
                        <label for="exampleInputName2">Tanggal/ Date : </label>
                        <em><span id="dateTxt"></span></em>
                        <input type="hidden" name="dateInput"  class="form-control" id="dateInput" placeholder="00-00-00">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>A. Data Pemohon / <em> Data applicant</em></strong> 
                    </div>
                    <div class="panel-body table-responsive">
                        <table width="100%"    >
                            <tr>
                                <td style="min-width:120px;">Nama / <em>Name</em></td>
                                <td width="2%">:</td>
                                <td width="88%" style="border-bottom:1px solid black;" id="labelNama">  -</td>
                            </tr>
                        </table>
                        <table width="100%" >
                            <tr>
                                <td style="min-width:120px;">Div./Dep./Area</td>
                                <td width="2%">:</td>
                                <td width="38%" style="border-bottom:1px solid black;" id="labelDivisi">-</td>
                                <td style="min-width:120px;">Jabatan / <em>Position</em></td>
                                <td width="2%">:</td>
                                <td width="38%" style="border-bottom:1px solid black;" id="labelJabatan">-</td>
                            </tr>
                        </table>
                        <input type="hidden" name="pemohon" id="pemohon" placeholder="nik#nama#tglLahir">
                        <input type="hidden" name="divisi" id="divisi"placeholder="divisi">
                        <input type="hidden" name="jabatan" id="jabatan" placeholder="jabatan">
                        <input type="hidden" name="atasan" id="atasan" placeholder="atasan"> 
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>B. Dasar Permintaan / <em> Basic Request</em></strong> 
                    </div>
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td><input type="checkbox" name="dasarPermintaan" value="Rencana dan Anggaran Tahunan (RAT) HRD #Plan and Annual Budget (RAT) HRD" class="checkDasarPermintaan"></td>
                                <td>Rencana dan Anggaran Tahunan (RAT) HRD <br><em>Plan and Annual Budget (RAT) HRD</em></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="dasarPermintaan" value="Penggantian karyawan yang mengundurkan diri  #Substitution for resigned employee" class="checkDasarPermintaan"></td>
                                <td>Penggantian karyawan yang mengundurkan diri <br><em>Substitution for resigned employee</em></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="dasarPermintaan" value="Penggantian sementara karyawan yang cuti/berhalangan sementara (seijin Perusahaan) #Temporary substitution for absent employee/temporary absent (permission of the Company)" class="checkDasarPermintaan">
                                </td>
                                <td>
                                    Penggantian sementara karyawan yang cuti/berhalangan sementara (seijin Perusahaan) <br><em>Temporary substitution for absent employee/temporary absent (permission of the Company)</em>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="dasarPermintaan" value="Pengembangan usaha/volume pekerjaan yang bertambah banyak (diluar RAT HRD) #Busines development/increases in work load (outside RAT HRD)" class="checkDasarPermintaan">
                                </td>
                                <td>
                                    Pengembangan usaha/volume pekerjaan yang bertambah banyak (diluar RAT HRD) <br><em>Busines development/increases in work load (outside RAT HRD)</em>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="dasarPermintaan" value="Lainnya" class="checkDasarPermintaan"></td>
                                <td style="border-bottom:1px solid black;">
                                    <textarea class="form-control" name="DasarPermintaanLainnya" id="DasarPermintaanLainnya" cols="30" rows="2" readonly></textarea>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="perluApproval" id="perluApproval" value="0">
                        <input type="hidden" name="checkDasarPermintaanValue"  id="checkDasarPermintaanValue" >
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>C. Spesifikasi Kebutuhan / <em> Specification Requirements</em></strong> 
                    </div>
                    <div class="panel-body table-responsive">
                        <table width="100%">
                            <tr>
                                <td style="min-width:200px;">Posisi / <em>Position</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table style="min-width:600px;">
                                        <tr>
                                            <td><input type="checkbox" name="checkPosisi" class="checkPosisi" value="Staff"></td>
                                            <td width="10%">Staff</td>
                                            <td><input type="checkbox" name="checkPosisi" class="checkPosisi" value="SPV"></td>
                                            <td width="10%">SPV</td>
                                            <td><input type="checkbox" name="checkPosisi" class="checkPosisi" value="Coord."></td>
                                            <td width="10%">Coord.</td>
                                            <td><input type="checkbox" name="checkPosisi" class="checkPosisi" value="Asc Man"></td>
                                            <td width="10%">Asc Man</td>
                                            <td><input type="checkbox" name="checkPosisi" class="checkPosisi" value="Manager"></td>
                                            <td width="10%">Manager</td>
                                            <td><input type="checkbox" name="checkPosisi"  class="checkPosisi" value="Lainnya"> </td>
                                            <td style="border-bottom:1px dashed black;"><input type="text" class="form-control" name="posisiLainnya" id="posisiLainnya" value="" style="margin-bottom:0px; border:none;" readonly></td>
                                        </tr>
                                    </table>                                    
                                </td> 
                                <td><input type="hidden" name="checkPosisiValue" id="checkPosisiValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Dibutuhkan Tanggal / <em>Required date</em></td>
                                <td width="2%">:</td>
                                <td > <input type="text" value="" name="tglDibutuhkan" id="tglDibutuhkan" class="form-control" style="width:20%;border-bottom: 1px dashed black;"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="30%">Status Karyawan / <em>Status Of Employees</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkStatusKaryawan" name="checkStatusKaryawan" value="Tetap / Permanent"></td>
                                            <td>Tetap / Permanent</td>
                                            <td><input type="checkbox" class="checkStatusKaryawan" name="checkStatusKaryawan" value="Kontrak / Contract"></td>
                                            <td> Kontrak / Contract :</td>
                                            <td style="border-bottom:1px dashed black;"> <input type="text" name="ketStatusKaryawan"  id="ketStatusKaryawan" class="form-control" style="margin-bottom:0px; border:none;" readonly></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="checkStatusKaryawanValue" id="checkStatusKaryawanValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Jenis Kelamin / <em> Gender</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="jenisKelamin" name="jenisKelamin" value="Laki-laki / Male"></td>
                                            <td>Laki-laki / Male</td>
                                            <td><input type="checkbox" class="jenisKelamin" name="jenisKelamin" value="Perempuan / Female"></td>
                                            <td>Perempuan / Female</td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="jenisKelaminValue" id="jenisKelaminValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Pendidikan / <em> Education</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="SMU"></td>
                                            <td width="10%">SMU</td>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="DIII"></td>
                                            <td width="10%">DIII</td>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="S1"></td>
                                            <td width="10%">S1</td>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="S2"></td>
                                            <td width="10%">S2</td>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="S3"></td>
                                            <td width="10%">S3</td>
                                            <td><input type="checkbox" class="checkPendidikan" name="checkPendidikan" value="Lainnya"> </td>
                                            <td style="border-bottom:1px dashed black;"><input type="text" class="form-control" name="pendidikanLainnya" id="pendidikanLainnya" value="" style="margin-bottom:0px;" readonly ></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="checkPendidikanValue" id="checkPendidikanValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Pengalaman Kerja / <em> Working Experience</em></td>
                                <td width="2%">:</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkLamaPengalaman" value="1 thn"></td>
                                            <td width="20%"> 1 thn</td>
                                            <td><input type="checkbox" class="checkLamaPengalaman" value="2 s/d 3 thn"></td>
                                            <td width="20%"> 2 s/d 3 thn</td>
                                            <td><input type="checkbox" class="checkLamaPengalaman" value="3 s/d 5 thn"></td>
                                            <td width="20%"> 3 s/d 5 thn</td>
                                            <td><input type="checkbox" class="checkLamaPengalaman" value="> 5 thn"></td>
                                            <td width="20%"> > 5 thn</td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="checkLamaPengalamanValue" id="checkLamaPengalamanValue"></td>
                            </tr>
                            <tr style="display:none;">
                                <td width="30%"></em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><label for="">Secara / In: </label></td>
                                            <td><input type="checkbox" class="secaraIn" name="secaraIn" id="secaraIn1" value="Dibidangnya / Art"></td>
                                            <td><label for="secaraIn1"  class="checkbox-inline ">Dibidangnya / Art</label>  </td>
                                            <td><input type="checkbox" class="secaraIn" name="secaraIn" id="secaraIn2"  value="Umum / General"></td>
                                            <td><label for="secaraIn2" class="checkbox-inline "> Umum / General</label></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="secaraInValue" id="secaraInValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Penguasaan Bahasa / <em>  Language Proficiency</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkBahasa" value="Inggris / English"></td>
                                            <td>Inggris / English</td>
                                            <td><input type="checkbox" class="checkBahasa" value="Mandarin"></td>
                                            <td>Mandarin</td>
                                            <td><input type="checkbox" class="checkBahasa" value="Tidak Perlu / No Need"></td>
                                            <td>Tidak Perlu / No Need</td>
                                        </tr>
                                    </table>   
                                  
                                </td> 
                                <td><input type="hidden" name="checkBahasaValue" id="checkBahasaValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Penempatan / <em> Station</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkPenempatan" value="P.jawa"> </td>
                                            <td>P.jawa</td>
                                            <td style="border-bottom:1px dashed black;"><input type="text" class="form-control" class="penempatanDetail" name="penempatanDetail0" id="penempatanDetail0" value="" style="margin-bottom:0px;" readonly></td>
                                            
                                            <td><input type="checkbox" class="checkPenempatan" value="Luar Pulau / Outer Island"></td>
                                            <td>Luar Pulau / Outer Island</td>
                                            <td style="border-bottom:1px dashed black;"><input type="text" class="form-control" class="penempatanDetail" name="penempatanDetail1" id="penempatanDetail1" value="" style="margin-bottom:0px;" readonly></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td>
                                <input type="hidden" name="checkPenempatanIndex" id="checkPenempatanIndex" value="" placeholder="penempatan index">
                                <input type="hidden" name="checkPenempatanValue" id="checkPenempatanValue" placeholder="penempatan value"></td>
                            </tr>
                            <tr>
                                <td width="30%">Ketrampilan / <em> Skills</em></td>
                                <td width="2%">:</td>
                                <td> 
                                    <table>
                                        <tr>
                                            <td><input type="checkbox" class="checkKeterampilan" value="Penggunaan Komputer/ Computer Use"></td>
                                            <td>Penggunaan Komputer <br>Computer Use</td>
                                            <td><input type="checkbox" class="checkKeterampilan" value="Mengetik 10 jari / Fluent in typing"> </td>
                                            <td> Mengetik 10 jari<br>Fluent in typing</td>
                                            <td> <input type="checkbox" class="checkKeterampilan" value="Lainnya"> </td>
                                            <td>Lainnya<br>Others</td>
                                            <td style="border-bottom:1px dashed black;"> <input type="text" class="form-control" name="checkKeterampilanLain" id="checkKeterampilanLain" value="" style="margin-bottom:0px;" readonly></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><input type="hidden" name="checkKeterampilanValue" id="checkKeterampilanValue"></td>
                            </tr>
                            <tr>
                                <td width="30%">Persyaratan Lainnya / <em> Other Requirement</em></td>
                                <td width="2%">:</td>
                                <td style="border-bottom:1px solid black;" colspan=2> 
                                    <textarea class="form-control" name="persyaratanLain" id="persyaratanLain" cols="30" rows="2" ></textarea>
                                </td> 
                            </tr>
                           
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>D. Tugas dan tanggung jawab / Lainnya <em> Job and responsibility / Others</em></strong> 
                    </div>
                    <div class="panel-body">
                        <textarea name="ttjOrlainnya" id="ttjOrlainnya" cols="30" rows="10" class="form-control" ></textarea>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-right">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-simpan" onclick="simpan()"> Simpan Employee Request</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Form Add -->
    </div>
</div>
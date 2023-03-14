
<blockquote>Approval Employee Recruitment</blockquote>
<hr>
<body>
<?php
    echo $this->Html->script('h1Erfapplicantevaluation.js');
    echo $this->Html->script('bundle.min.js');   
    echo $this->Html->script('jquery.signaturepad.min.js');
    echo $this->Html->css('jquery.signaturepad.css');

        $groupId=$this->Session->read('dpfdpl_groupId');   
    if($groupId!="24"){
         // header("Location: mainmenus");
   // die();
    }    

?>
<input type="hidden" value="<?php echo $_GET['id']; ?>" id="txtIdPelamar" name="">

<body>

<div id="erfApplicantForm">
    <center><font style="font-size: 22px;">PENILAIAN CALON KARYAWAN</font></center>
    <center><font style="font-size: 22px;">APPLICANT EVALUATION FORM</font></center>
    <br>
    <hr style="border: 1px solid #404040; margin-bottom: -1px;">
    <font style="font-size: 14px;">
    Formulir ini setelah diisi lengkap, Harap diserahkan ke unit Sumber Daya Manusia PT. Bernofarm<br>
    Please fil this form and submit to Human Resources Department of PT. Bernofarm
    </font>
    <hr style="border: 1px solid #404040;margin-top: -1px;">
</div>

<table style="border: 1px solid #404040;border-collapse: collapse; width: 100%;padding: 1px;">
    <tr style="border: 1px solid #404040;border-collapse: collapse;">
    <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;">
        Nama pelamar / Name of Applicant   
        </td>
        <td style="width:1%;  border-left-style: none;border-right-style: none;">
            :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtNamaPelamar"></div>
        </td>
        <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;">
            Diwawancarai oleh / Interviewd by :
        </td>
        <td style="width:1%;border-left-style: none;border-right-style: none;"> 
        :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtWawancaraOleh"></div>
        </td>
    </tr>
    <tr style="border: 1px solid #404040;border-collapse: collapse;">
    <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;">
        Untuk Jabatan / Position  
        </td>
        <td style="width:1%;  border-left-style: none;border-right-style: none;">
            :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtUntukJabatan"></div>
        </td>
        <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;">
            Jabatan/Pangkat / Position :
        </td>
        <td style="width:1%;border-left-style: none;border-right-style: none;"> 
        :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtPangkatPosisi"></div>
        </td>
    </tr>
    <tr style="border: 1px solid #404040;border-collapse: collapse;">
    <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;">
        Unit Organisasi / Organization   
        </td>
        <td style="width:1%;  border-left-style: none;border-right-style: none;">
            :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtUnitOrganisasi"></div>
        </td>
        <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;">
            Tanggal / date :
        </td>
        <td style="width:1%;border-left-style: none;border-right-style: none;"> 
        :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtTanggal"></div>
        </td>
    </tr>
    <tr style="border: 1px solid #404040;border-collapse: collapse;">
    <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;  border-right-style: none; padding: 2px;">
        Tgl Dibutuhkan / Estimated Accepet Date   
        </td>
        <td style="width:1%;  border-left-style: none;border-right-style: none;">
            :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            <div id="txtTglDibutuhkan"></div>
        </td>
        <td style="width:25%;border: 1px solid #404040;border-collapse: collapse;border-right-style: none;padding: 2px;">
            Tanda Tangan / Signature :
        </td>
        <td style="width:1%;border-left-style: none;border-right-style: none;"> 
        :
        </td>
        <td style="width:24%;border: 1px solid #404040;border-collapse: collapse;border-left-style: none;padding: 2px;">
            *tanda tangan di bawah
        </td>
    </tr>

</table>
<br>
<table>
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
<br>
<table width="100%">
      <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        No  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Penilaian / Apprisial 
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
            <center>Penjelasan / Remark</center>
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        A
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        B
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        C
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        D
        </td>
    </tr>
     <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        1  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Penampilan / Apperance  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Kesan yang diperoleh dan cara berpakaian, dandan, sopan santun dan pembawaan diri pelamar / Personal grooming, politeness, and gestures of the applicant's
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian1_a" name="penilaian1" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian1_b" name="penilaian1" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian1_c" name="penilaian1" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian1_d" name="penilaian1" value="d">
        </td>
    </tr>
         <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        2  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Stabilitas / Stability 
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangan kematangan emosional, kedewasaan, kepercayaan diri dan kemampuan menyesuaikan diri pelamar / Please consider the applicant's emotional, mature, confidence and his/her stability
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian2_a" name="penilaian2" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian2_b" name="penilaian2" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian2_c" name="penilaian2" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian2_d" name="penilaian2" value="d">
        </td>
    </tr>
         <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        3  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Motivasi / Motivation 
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangan minat pelamar atas pekerjaan yang dilamar / Please consider the applicant's interest on the position he/she applies
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian3_a" name="penilaian3" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian3_b" name="penilaian3" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian3_c" name="penilaian3" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian3_d" name="penilaian3" value="d">
        </td>
    </tr>
             <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        4  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Keakraban / Familiarity
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangkan dari cara bicara, kata-kata yang dipergunakan, mimik, gerak tubuh, tingkat keluwesan bergaul Please consider the way to speak, word chosen, expression, gesture and the flexibility to associate
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian4_a" name="penilaian4" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian4_b" name="penilaian4" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian4_c" name="penilaian4" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian4_d" name="penilaian4" value="d">
        </td>
    </tr>

     <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        5  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Keterampilan Kerja / Job Competency
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangkan pengalaman kerja pelamar dibandingkan posisi yang dilamar / Please consider applicants work experience compared to the proposed position
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian5_a" name="penilaian5" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian5_b" name="penilaian5" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian5_c" name="penilaian5" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian5_d" name="penilaian5" value="d">
        </td>
    </tr>

         <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        6  
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Komunikasi Lisan / Oral Communication
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Kemampuan pelamar mengutarakan pendapat/jawaban/kseimpulan dengan jelas dan singkat (seperlunya) / Applicants ability to express opinions/response/ conclusions in a clear and concise
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian6_a" name="penilaian6" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian6_b" name="penilaian6" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian6_c" name="penilaian6" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian5_d" name="penilaian6" value="d">
        </td>
    </tr>

             <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        7
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Ketajaman Berpikir / Sharp of thinks
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangkan kecekatan/ketajaman berpikir serta daya analisa pelamar / please consider applicant's the way of thinking and analitical ability
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian7_a" name="penilaian7" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian7_b" name="penilaian7" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian7_c" name="penilaian7" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian7_d" name="penilaian7" value="d">
        </td>
    </tr>

                 <tr style="border: 1px solid #404040;border-collapse: collapse;">
        <td style="width:2%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        8
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Tingkat Pergauluan /interaction
        </td>
        <td style="width:40%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;">
        Pertimbangkan lingkup pergaulan, hobi dan aktivitas di luar kantor / Please consider the applicant's sociality background. hobbies, and activities after office hour
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian8_a" name="penilaian8" value="a">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian8_b" name="penilaian8" value="b">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian8_c" name="penilaian8" value="c">
        </td>
        <td style="width:5%;border: 1px solid #404040;border-collapse: collapse;padding: 2px;"> 
        <input type="radio" id="penilaian8_d" name="penilaian8" value="d">
        </td>
    </tr>



</table>

 <table class="table table-bordered" style="margin-left: 2px; margin-right: 2px; width: 100%; display: none;" id="tblApprovals">
    <thead>
      <tr >
        <th width="5%">No</th>
        <th width="15%">Nomer Pengajuan</th>
        <th width="50%">Nama Pengaju</th>
        <th width="10%">Tanggal</th>
        <th width="10%">Status</th>
      </tr>
    </thead>
    <tbody id="tbodyPeminjaman">
    
     
    </tbody>
  </table>
  <br>

  <table width="100%">
    <tr>
        <td><b>Penilaian/Komentar Tambahan / Apprisial/Additional Comments</b></td>
    </tr>
      <tr>
        <td>
            <textarea class="form-control" width='100%' rows='4' id="txtKeterangan"></textarea>
        </td>
    </tr>
</table>
<br>
Kesimpulan (Harap dibubuhkan paraf dibawah pilihan anda)
<br>
conlusion(Please provide initial under chosen remarks)
<br>
<table width="100%">
    <tr>
        <td><input type="radio" id="hp1" name="hasilpenilaian" value="direkomendasikan">direkomendasikan/diusulkan, recomended</td>
        <td><input type="radio" id="hp2" name="hasilpenilaian" value="dicadangkan">dicadangkan/dapat dipertimbangkan, reserved</td>
        <td><input type="radio" id="hp3" name="hasilpenilaian" value="tidak direkomendasi">tidak direkomendasikan, not recomended</td>
    </tr>
</table>
<br>

 <div class="sigPad" id="smoothed" style="width:30%; margin-bottom: 20px;">
                               
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

                  <br><br>
<div id="divbtn" style="margin-left: 15px;">
    
</div>

<br><br>

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

         
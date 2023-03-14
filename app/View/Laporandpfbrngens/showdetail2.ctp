<?php
$this->layout='report'; 
?>
<script>
$(function(){$.fx.speeds._default = 1000;});
</script>

<?php
echo $this->Html->script('h1laporandpfbrngen.js');
?>
<div class='container'>
<div class="row">

<h3>Form Detail DPF Berno Gen</h3>
<form name="frmDPF" id="frmDPF" action="" method="post">

<table border="0" celspacing="0" cellpadding="0">
<tr><td>Nama TP</td><td>:</td><td>&nbsp;<label id="namaTP"></label></td></tr>
<tr><td>Periode</td><td>:</td><td>&nbsp;<label id="periodeDPF"></label></td></tr>
<tr><td>Kode Dist</td><td>:</td><td>&nbsp;<label id="kodeDist"></label></td></tr>
<tr><td>Distributor</td><td>:</td><td>&nbsp;<label id="distributor"></label></td></tr>
<tr><td>Outlet</td><td>:</td><td>&nbsp;<label id="outlet"></label></td></tr>
<tr><td>No DPF</td><td>:</td><td>&nbsp;<label id="noDPF" style="font-weight:bold"><?php if(isset($this->params["pass"]["0"])){echo $this->params["pass"]["0"];}?></label></td></tr>

</table>
</div>

  <div class="row">
    
     
                                <table class="table table-responsive table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="8%" rowspan="1" style="vertical-align:middle">Id</th>
                                            <th width="15%" rowspan="1" style="vertical-align:middle">KodeProd</th>
                                            <th width="40%" rowspan="1" style="vertical-align:middle">NamaProduk</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>GSV</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>GSV2</th>
                                            <th width="10%" rowspan="1" style="vertical-align:middle">Unit</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>NSV1 + PPN</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>NSV2 + PPN</th>
                                            <th rowspan="1" style="text-align:center" class='textBuff'>Disc Pric</th>
                                            <th rowspan="1" style="text-align:center" class='textBuff'>Off Faktur</th>
                                            <th width="10%" rowspan="1" style="vertical-align:middle">On Faktur</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>Total Disc</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>Keterangan</th>
                                            <th rowspan="1" style="vertical-align:middle" class='textBuff'>Status</th> 
                                            <th width="15%" rowspan="1" style="vertical-align:middle" >Tgl Finish</th>
                                        </tr>
                                       <!-- <tr>                                           
                                            <th>Diajukan</th>
                                            <th>By SM</th>
                                            <th>By GSM</th>

                                            <th>By Fin</th>
                                            <th>Terakhir</th>
                                            <th>Diajukan</th>
                                            <th>By SM</th>
                                            <th>By GSM</th>
                                            <th>By Fin</th>
                                            <th>Terakhir</th>
                                        </tr> -->
                                    </thead>
                                    <tbody id='tblDPFBody'>
                                      
                                    </tbody>
                                </table>
                              
                                </div>
  

    </form> 
</div>

<script>
$(document).ready(function(e) {
  showDetailDPF2(document.getElementById('noDPF').innerHTML);
});

</script>

<script>
$(function(){$.fx.speeds._default = 1000;});
</script>

<?php
echo $this->Html->script('h1laporandpfbrngen.js');
?>
<h3>Form Detail DPF Berno Gen</h3>
<form name="frmDPF" id="frmDPF" action="" method="post">
<table border="1" cellspacing="0" cellpadding="0">	
<tr>
<table border="0" celspacing="0" cellpadding="0">
<tr><td>Nama TP</td><td>:</td><td>&nbsp;<label id="namaTP"></label></td></tr>
<tr><td>Periode</td><td>:</td><td>&nbsp;<label id="periodeDPF"></label></td></tr>
<tr><td>Kode Dist</td><td>:</td><td>&nbsp;<label id="kodeDist"></label></td></tr>
<tr><td>Distributor</td><td>:</td><td>&nbsp;<label id="distributor"></label></td></tr>
<tr><td>Outlet</td><td>:</td><td>&nbsp;<label id="outlet"></label></td></tr>
<tr><td>No DPF</td><td>:</td><td>&nbsp;<label id="noDPF" style="font-weight:bold"><?php if(isset($this->params["pass"]["0"])){echo $this->params["pass"]["0"];}?></label></td></tr>
<tr><td colspan="3"><a href="<?php echo $this->webroot.'laporandpfbrngens';?>" style="font-weight:bold">Kembali ke menu laporan DPF</a></td></tr>
</table>
</tr>
	<tr><td width="950">
    <br>
  <div class="row">
     <div class="dataTable_wrapper table-responsive"  class="col-sm-13">
     
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="1" style="vertical-align:middle">Id</th>
                                            <th rowspan="1" style="vertical-align:middle">ProId</th>
                                            <th rowspan="1" style="vertical-align:middle">NamaProduk</th>
                                            <th rowspan="1" style="vertical-align:middle">GSV</th>
                                            <th rowspan="1" style="vertical-align:middle">GSV2</th>
                                            <th rowspan="1" style="vertical-align:middle">Unit</th>
                                            <th rowspan="1" style="vertical-align:middle">NSV1 + PPN</th>
                                            <th rowspan="1" style="vertical-align:middle">NSV2 + PPN</th>
                                            <th rowspan="1" style="text-align:center">Disc Pric</th>
                                            <th rowspan="1" style="text-align:center">Off Faktur</th>
                                            <th rowspan="1" style="vertical-align:middle">Disc Dist</th>
                                            <th rowspan="1" style="vertical-align:middle">Total Disc</th>
                                            <th rowspan="1" style="vertical-align:middle">Keterangan</th>
                                            <th rowspan="1" style="vertical-align:middle">Status</th>
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
                                </div>
    </td>
	</tr>
   
    <tr><td>
   
   
    </td></tr>
	<tr><td> 
   
   
    </td>
	</tr>
</table>
<input type='button' onclick="showPrint(document.getElementById('noDPF').innerHTML)" value='Print'>
    </form> 

<script>
$(document).ready(function(e) {
  showDetailDPF(document.getElementById('noDPF').innerHTML);
});
function showPrint(noDPF){
var obj_calwindow = window.open('../showdetail2/'+noDPF, 'Barang', 'resizable=0, scrollbars=0, toolbar=0, status=1, menubar=0, width=840, height=400, left=350, top=210');
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}
</script>

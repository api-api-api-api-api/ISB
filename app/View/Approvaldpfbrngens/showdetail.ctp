<script>
$(function(){$.fx.speeds._default = 1000;});
</script>

<?php
echo $this->Html->script('h1approvaldplbrngen.js');
?>
<h3>Form Detail DPL</h3>
<form name="frmDPL" id="frmDPL" action="" method="post">
<table border="1" cellspacing="0" cellpadding="0">	
<tr>
<table border="0" celspacing="0" cellpadding="0">
<tr><td>Nama Pengaju</td><td>:</td><td>&nbsp;<label id="namaPengaju"></label></td></tr>
<tr><td>Periode DPL</td><td>:</td><td>&nbsp;<label id="periodeDPL"></label></td></tr>
<tr><td>Dist</td><td>:</td><td>&nbsp;<label id="groupDist"></label></td></tr>
<tr><td>Cabang Dist</td><td>:</td><td>&nbsp;<label id="cabangDist"></label></td></tr>
<tr><td>Outlet</td><td>:</td><td>&nbsp;<label id="outlet"></label></td></tr>
<tr><td>No Nota</td><td>:</td><td>&nbsp;<label id="noDPL" style="font-weight:bold"><?php if(isset($this->params["pass"]["0"])){echo $this->params["pass"]["0"];}?></label></td></tr>
<tr><td colspan="3"><a href="<?php echo $this->webroot.'approvaldplbrngens';?>" style="font-weight:bold">Kembali ke menu approval DPL</a></td></tr>
</table>
</tr>
	<tr><td width="950">
    <br>
  <div class="row">
     <div class="dataTable_wrapper table-responsive"  class="col-sm-13">
     
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>ProId</th>
                                            <th>NamaProduk</th>
                                            <th>EstSalesPerBulan</th>
                                            <th>OnFaktur</th>
                                            <th>BebanDist</th>
                                            <th>BebanBerno</th>
                                            <th>DistClaimBerno</th>
                                            <th>BernoClaimDist</th>
                                            <th>Keterangan</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody id='tblDPLBody'>
                                      
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

    </form> 

<script>
$(document).ready(function(e) {
  showDetailDPL(document.getElementById('noDPL').innerHTML);
});

</script>
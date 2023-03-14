<?php
echo $this->Html->script('h1laporandpfbrngen.js');
?>
<h3>Laporan DPF Berno Gen</h3>

<form name="h1form" action="" method="post">



    </script>
     <div class="row">
     <div class="row">
          <div class="col-md-2"><label  class="control-label" for="periodeDPF" >Periode DPF:</label></div>
          <div class="col-md-5">
          <?php $this->Function->inp_per('bulan','tahun');?>
         </div>
          <div class="col-md-5"><script type="text/javascript">
          //  $(function () {
           //        $('#periodeDPF').datetimepicker({
            //        format: 'DD-MM-YYYY'
            //    });
            //});
        </script> </div>
        </div>
  	<div class="row">
          <div class="col-md-2"><label  class="control-label" for="Outlet" >Outlet:</label></div>
          <div class="col-md-5"><input type="text" name="outlet" id="outlet"  placeholder="Cari Nama Outlet" class="form-control"/></div>
          <div class="col-md-5"></div>
        </div>
    <!--  <div class="row">
          <div class="col-md-2"><label  class="control-label" for="Outlet" >Outlet:</label></div>
          <div class="col-md-5"><textarea type="text" name="outlet" id="outlet" onclick="cariDataOutlet();" placeholder="Klik untuk browse outlet" cols="20" rows="3" class="form-control"></textarea></div>
          <div class="col-md-5"></div>
        </div>
  <div class="row">
          <div class="col-md-2"><select name="namaKolom" class="form-control">
      <option value="namaTP">Nama TP</option>
	  </select></div>
          <div class="col-md-5"> <input type="text" name="strCari" id="strCari" onKeyPress="return event.keyCode!=13" class="form-control"/></div>
          <div class="col-md-5"></div>
        </div>-->
    
      
    <script>
	
    document.getElementById('strCari').onkeyup=function(e){
	key=e?e.which:event.keyCode;
	if(key==13){
		cariData(this.value);
		}
	else{
	
	}
	
	this.focus();
	}
    </script>
    	<div class="row">
          <div class="col-md-5"><button type="Button" value="Cari" name="Cari" onClick="cariData('',1)" class="btn btn-default"><i class='fa fa-search'></i>Cari</button>
     <button type="Button" value="ShowAll" name="ShowAll" onClick="showAll('',1)" class="btn btn-default"><i class='fa fa-refresh'></i>Show All</button></div>
          <div class="col-md-2"></div>
          <div class="col-md-5"></div>
        </div>
    
     </div>
     <div class="row">
     <div class="dataTable_wrapper table-responsive"  class="col-sm-13">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nomor DPF</th>
                                            <th>Tanggal Input</th>
                                            <th>Nama TP</th>
                                            <th>Kode Dist</th>
                                            <th>Distributor</th>
                                            <th>Outlet</th>
                                            <th>Periode</th>
                                            <th>Status DPF</th>
                                            <th>Approver</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody id='tblLaporanDPFBody'>
                                      
                                    </tbody>
                                </table>
                                </div>
                                </div>
                             <div id="linkHal" style="height:18px; font-weight:bold; display:none" ></div>
     <label id="maxHal" style="display:none"></label><br>
                          
      </form> 
                               <script>
    $(document).ready(function() {
		onLoadHandler();
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
   
<?php
echo $this->Html->script('h1masterjenisitem.js');
?>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	.form-group{margin-bottom:8px !important;}
	.form-group label,.form-group input,.form-group span{font-family:Arial !important;font-size:12px; font-weight:500;}
	#tableIsi td,#tableIsi th{vertical-align: middle;padding: 5px;}
	#tableIsi label{vertical-align: middle;padding: 5px;display: unset;font-weight:unset}
	.form-control{font-size:12px !important;}
</style>
<header class="header">MASTER JENIS</header>
<fieldset class="roundIt" style="width:100%;">
    <form  name="h1form" method="post" class="frmInput">
        <div class="row">
        <!-- col-md-offset-3 -->
        <input type="text" id="halJenis" name="halJenis" style="display:none" >
			<div class="col-md-6 ">
				<div class="form-horizontal">
					<div class="well has-warning">
                    	<div class="form-group clsJenis">
							<label for="txtJenisBrg" class="col-sm-3 control-label">Group</label>
							<div class="col-sm-3">
								<select id="txtGroup" name="txtGroup" class="form-control" onchange="getData(1)"><option value="ATK">ATK</option><option value="INVENTARIS">INVENTARIS</option><option value="PROMOSI">PROMOSI</option></select>
							</div>
							<div class="col-sm-6">
								
							</div>
						</div>
						<div class="form-group clsJenis">
							<label for="txtJenisBrg" class="col-sm-3 control-label">Tambah Jenis *</label>
							<div class="col-sm-7">
								<input type="text" id="txtJenisBrg" name="txtJenis" class="form-control" placeholder="Isi Jenis">
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-primary" onclick="saveJenis()">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
        <!-- col-md-offset-3 -->
			<div class="col-md-6 ">
			    <div class="well has-success">
				    <table id="tableIsi"  class="table">
					    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;display:none;">id</th>
                            <th style="text-align:center;" width='55%'>Nama</th>
                            <th style="text-align:center;"><input type="text" id="txtjenisBarang" class="form-control" onkeyup="getData(1)" placeholder="cari nama"></th>
                        
                        </tr>
                        </thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
        <div class="col-md-6 ">
		<center><nav id="linkHal1" style="display:none" ></nav></center>
        </div>
    </form>
</fieldset>


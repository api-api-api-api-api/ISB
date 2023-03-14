<?php
    echo $this->Html->script('jquery.signaturepad.min.js');
    echo $this->Html->script('bundle.min.js');
    echo $this->Html->script('h1fupb.js');
    echo $this->Html->css('jquery.signaturepad.css');
	$jenis='';
	if(isset($_GET['jenis']) && $_GET['jenis']=='report'){
		$jenis=$_GET['jenis'];
		}
?>
<style>
@media screen and (max-width: 1800px) {
    .col-md-5,.col-md-6,.col-md-7,.col-md-8{float: left;width:100%;}
    .col-md-offset-2 {margin-left: 0;}
}
#getDataFUPB tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important} 
#getDataFUPB tbody tr:nth-child(even) td{padding:unset;}
#getDataFUPB tbody tr td > a{color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;}
#companyAdd  tr th{font-family: Arial ; font-weight: 900;height:20px;vertical-align: middle !important;text-align: center;}
#companyAdd tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important;} 
#companyAdd tbody tr td > a {color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;font-family: Arial ; font-weight: normal;}
#companyAdd tbody tr td >label{font-family: Arial ; font-weight: normal;font-size: 12px;}
#companyAdd label{margin-bottom: unset;}
#companyAdd input,#companyAdd select{font-size:12px;}
#companyAdd th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;top:0;}
.labelAdd {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 3;background:#fff;}
#tableForm tr>td {padding: 5px;}
#tableForm input,#tableForm select,#tableForm textarea,#tableForm span{font-size:12px;}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}

/* select pure css */
/* Select Pure Auto complate */
.select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
.select-pure__select {align-items: center;border-radius: 4px;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;
  cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 44px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
.select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;
  overflow-y: scroll; position: absolute; top: 50px; width: 100%; z-index: 5;}
.select-pure__select--opened .select-pure__options { display: block;}
.select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
.select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
.select-pure__option--hidden { display: none;}
.select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
.select-pure__selected-label:last-of-type { margin-right: 0;}
.select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
.select-pure__selected-label i:hover {  color: #e4e4e4;}
.select-pure__autocomplete {background: #f9f9f8; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 16px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}

.tblDetail tr>td{padding:10px 15px !important;font-size: 12px;}
.tblTtd tr>td{padding:5px 15px !important;}
.tblFilter input,.tblFilter select{margin:3px 0;font-size:12px;}


</style>

<div class="page-header">
    <h1>FUPB<?php if($jenis=='report'){echo " REPORT";}?></h1>
</div>


<form name="fupbReport" id="fupbReport" method="post">
<input type="hidden" name='jenis' value="<?php echo $jenis?>" />
    <div class="row" style="display:block">
        <div class="col-md-4">
            <div class="panel panel-primary" style="min-width:450px;border-color: #696969;">
                <div class="panel-heading" style="background-color:#696969;color:#fff;border-color: #696969;">
                    <div class="row">
                        <div class="col-md-8">
                            <span class=""><i class="fa fa-search-plus fa-fw" aria-hidden="true"> </i> Filter By</span>
                        </div>
                        <div class="col-md-4 col-md-offset-0 text-right"></div>
                    </div>
                </div>
                <div class="panel-body" > 
                    <table class="tblFilter" width="100%">
                        <tr>
                            <td width="20%" for="startDate">Tanggal Awal</td>
                            <td width="3%">:</td>
                            <td width="35%"><input class="form-control" name="startDate" id="startDate" type="text" value=""></td>
                            <td width="10px"></td>
                           
                        </tr>
                        <tr>
                            <td  for="endDate">Tanggal Akhir</td>
                            <td>:</td>
                            <td><input class="form-control" type="text" name="endDate" id="endDate" value=""></td>
                            <td></td>
                           
                        </tr>
                        <tr>
                            <td  for="noFupbSrc">No. FUPB</td>
                            <td>:</td>
                            <td colspan="2">
                                <input class="form-control" type="text" name="noFupbSrc" id="noFupbSrc" value="">
                            </td>
                            
                            
                        </tr>
                        <tr>
                            <td  for="namaProjectSrc">Nama Project</td>
                            <td>:</td>
                            <td colspan="2">
                                <input class="form-control" type="text" name="namaProjectSrc" id="namaProjectSrc" value="">
                            </td>
                            
                            
                        </tr>
                    </table>
                </div>
                <div class="panel-footer"><button type="button" class="btn btn-info btn-xs" id="searchFupb"><i class="fa fa-search" aria-hidden="true"></i> Search</button></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" style="border-color: #696969;">
                <div class="panel-heading" style="background-color:#696969;color:#fff;border-color: #696969;">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-th-list fa-fw"></i> FUPB RECORD
                        </div>
                        <div class="col-md-6 col-md-offset-0 text-right">
                           <?php if($jenis!='report'){?>
                            <button type="button" id="btnForm" class="btn btn-xs btn-danger"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> ADD FUPB</button>
                        		<?php }?>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='getDataFUPB' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr>
                                    <th width="3%" style="text-align:center;">No</th> 
                                    <th width="20%">No. FUPB</th>                  
                                    <th width="10%" style="text-align:center;">Tanggal</th>
                                    <th width="25%">Nama Project</th>
                                    <th width="10%" style="text-align:center;">Divisi</th>
                                    <th width="" style="text-align:center;">Status FUPB</th>
                                    <th width="15%" style="text-align:center;">Progress</th>
                                    <th width="8%" style="text-align:center;"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td colspan="9" style="text-align:center;">-- Empty Data --</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example " id="linkHal1" style="display:none"></nav>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name='idCetakPDF' id="idCetakPDF">
    <input type="hidden" name='lampiranCetak' id="lampiranCetak">
</form>


<!-- modal form -->
<div class="modal fade"  id="modalFormFUPB" role="dialog" aria-labelledby="modalProsesFaseLabel" style="max-width: 80%; max-height: 91%; margin-left: 10%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FUPB FORM</h4>
                </div>
                <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
                <form name="fupbForm" id="fupbForm">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-primary" style="min-width:500px;">
                                <div class="panel-body">
                                <input type="hidden" name="fupbId" id="fupbId">
                                    <table id="tableForm" width="100%" >
                                        <tr><td width="160px">ND</td><td width="10px">:</td><td colspan="2"><input class="form-control" type="text" id="nd" name="nd" style="width:150px"></td><td width="200px"></td></tr>
                                        <tr><td>TB</td><td>:</td><td colspan="2"><input type="text" class="form-control"  id="tb" name="tb" style="width:150px"></td><td></td></tr>
                                        <tr><td>Tanggal</td><td>:</td><td colspan="2"><input type="text" class="form-control" id="tglFupb" name="tglFupb" style="width:150px"></td><td></td></tr>
                                        <tr><td>No. FUPB</td><td>:</td><td colspan="2"><input class="form-control" type="text" id="noFupb" name="noFupb" style="min-width:200px;width:50%"></td><td></td></tr>
                                        <tr><td>Nama Project</td><td>:</td><td colspan="2"><input type="text" class="form-control" id="naProd" name="naProd" style="min-width:200px;width:50%"></td><td></td></tr>
                                        <tr>
                                            <td>Divisi</td>
                                            <td>:</td>
                                            <td colspan="2">
                                                <div style="min-width:200px;width:50%">
                                                    <select name="divisi" id="divisi" class="form-control"  style='font-size:12px !important;width:150px;display:none;'></select>
                                                    <span class="autocomplete-select" id="txtDivisi" style="min-width:200px;width:50%"></span>
                                                    <input type="hidden" id="divisiDipilih" name="divisiDipilih">
                                                    <input type="hidden" id="divisiDipilihID" name="divisDipilihiID">
                                                    <input type="hidden" id="divisiDipilihNama" name="divisiDipilihNama">
                                                </div>
                                               
                                            </td>
                                            <td></td>
                                            
                                        </tr>
                                        <tr><td>Komposisi & Dosisi</td><td>:</td><td colspan="2"><input type="text" class="form-control" id="komposisi" name="komposisi" style="min-width:200px;width:50%"></td><td></td></tr>
                                        <tr style="display:none;"><td>Dosis</td><td>:</td><td colspan="2"><input type="text" class="form-control" id="dosis" name="dosis" style="min-width:400px;width:50%"></td><td></td></tr>
                                        <tr><td>Indikasi</td><td>:</td><td colspan="2"><textarea class="form-control" id="indikasi" name="indikasi" style="min-width:350px;width:100%"></textarea></td><td></td></tr>
                                        <tr><td>Aturan Pakai</td><td>:</td><td colspan="2"><textarea class="form-control" id="aturanPakai" name="aturanPakai" style="min-width:50%;width:100%"></textarea></td><td></td></tr>
                                        <tr><td>Spesifikasi Sediaan</td>
                                            <td>:</td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Bentuk</span>
                                                    <input type="text" class="form-control" id="sediaanBentuk" name="sediaanBentuk" style="width:100%">
                                                </div> 
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Rasa  &nbsp;&nbsp;</span>
                                                    <input type="text" class="form-control" id="sediaanRasa" name="sediaanRasa" style="width:100%">
                                                </div>
                                                                                                      
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Warna </span>
                                                    <input type="text" class="form-control" id="sediaanWarna" name="sediaanWarna" style="width:100%">
                                                </div>   
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Aroma</span>
                                                    <input type="text" class="form-control" id="sediaanAroma" name="sediaanAroma" style="width:100%">
                                                </div>  
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr><td>Spesifikasi Kemasan</td><td>:</td><td colspan="2"><textarea  class="form-control"  id="kemasan" name="kemasan" style="width:100%"></textarea></td><td></td></tr>
                                        <tr><td>Jumlah Kompetitor</td><td>:</td><td colspan="2"><input class="form-control" type="text" id="jumKompetitor" name="jumKompetitor" style="width:50%"></td><td></td></tr>
                                        <tr><td>Jalur Registrasi</td><td>:</td><td colspan="2"><input class="form-control" type="text" id="jalurReg" name="jalurReg" style="width:50%"></td><td></td></tr>
                                        <tr>
                                            <td>Status Kebutuhan Marketing</td>
                                            <td>:</td>
                                            <td colspan="2">
                                                <input type="radio" id="Cito" name="statusKebMar" value="Cito"  checked>
                                                <label for="Cito">Cito</label><br>
                                                <input type="radio" id="Normal" name="statusKebMar" value="Normal">
                                                <label for="Normal">Normal</label>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading clearfix" style="background-color:#696969;color:#fff">
                                        Input Kompetitor : <button type="button" class="btn btn-danger btn-sm" id="btnAddCompatitors"> <i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                                <div class="panel-body" style="overflow-x:auto;max-height: 500px;overflow-y:auto;margin-bottom:unset;padding:0 15px;">
                                    <div class="row" >
                                        <table cellpadding="0" cellspacing="0" width="100%"  class="table" id="companyAdd" style="margin-bottom:unset;padding:0 15px;">
                                            <thead>
                                                <tr class="danger">
                                                    <th>Brand Name</th>
                                                    <th>Company</th>
                                                    <th>Komp. Utama</td>
                                                    <th>Dosage</th>
                                                    <th>Unit / Pack</th>
                                                    <th>Price / Unit</th>
                                                    <th>Price / Pack</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class='panel-footer'>
                                    <div class="sigPad" id="linear" style="width:300px;">
                                        <ul class="sigNav">
                                            <li class="drawIt"><a href="#draw-it" >Tanda Tangan</a></li>
                                            <li class="clearButton"><a href="#clear">Clear</a></li>
                                        </ul>
                                        <div class="sig sigWrapper" style="height:auto;border-color:white;">
                                        <div class="typed"></div>
                                        
                                        <canvas class="pad" width="300px" height="150" id="canvas__" style="border: 1px solid #ddd;"></canvas>
                                        <input type="hidden" name="output__" class="output">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary" style="min-width:500px;">
                                <div class="">
                                    <button type="button" class="btn btn-block btn-danger" id="buttonSave" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>       
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
        </div>
    </div>
<?php if($jenis=='report'){
	?>
	<style>
    .panel-heading{
		background-color:#c9c9c9 !important;color:#000 !important;border-color: #c9c9c9 !important;
		}
    </style>
	<?php
	}?>
<!-- <form name="fupbForm" id="fupbForm">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary" style="min-width:500px;">
                <div class="panel-body">
                    <table id="tableForm" width="100%">
                        <tr><td width="160px">ND</td><td width="10px">:</td><td><input class="form-control" type="text" id="nd" name="nd" style="width:150px"></td></tr>
                        <tr><td>TB</td><td>:</td><td><input type="text" class="form-control"  id="tb" name="tb" style="width:150px"></td></tr>
                        <tr><td>Tanggal</td><td>:</td><td><input type="text" class="form-control" id="tglFupb" name="tglFupb" style="width:150px"></td></tr>
                        <tr><td>No. FUPB</td><td>:</td><td><input class="form-control" type="text" id="noFupb" name="noFupb" style="width:250px"></td></tr>
                        <tr><td>Nama Project</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="naProd" name="naProd" style="width:300px"></td></tr>
                        <tr>
                            <td>Divisi</td>
                            <td>:</td>
                            <td colspan="5">
                                <select name="divisi" id="divisi" class="form-control"  style='font-size:12px !important;width:150px'></select>
                            </td>
                        </tr>
                        <tr><td>Komposisi</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="komposisi" name="komposisi" style="width:300px"></td></tr>
                        <tr><td>Dosis</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="dosis" name="dosis" style="width:300px"></td></tr>
                        <tr><td>Indikasi</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="indikasi" name="indikasi" style="width:300px"></td></tr>
                        <tr><td>Aturan Pakai</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="aturanPakai" name="aturanPakai" style="width:300px"></td></tr>
                        <tr><td>Sediaan</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="sediaan" name="sediaan" style="width:300px"></td></tr>
                        <tr><td>Kemasan</td><td>:</td><td colspan="5"><input type="text" class="form-control" id="kemasan" name="kemasan" style="width:300px"></td></tr>
                        <tr><td>Jumlah Kompetitor</td><td>:</td><td colspan="5"><input class="form-control" type="text" id="jumKompetitor" name="jumKompetitor" style="width:300px"></td></tr>
                        <tr><td>Jalur Registrasi</td><td>:</td><td colspan="5"><input class="form-control" type="text" id="jalurReg" name="jalurReg" style="width:300px"></td></tr>
                        <tr>
                            <td>Status Kebutuhan Marketing</td>
                            <td>:</td>
                            <td colspan="5">
                                <input type="radio" id="statusKebMar1" name="statusKebMar" value="Cito"  checked>
                                <label for="statusKebMar1">Cito</label><br>
                                <input type="radio" id="statusKebMar2" name="statusKebMar" value="Normal">
                                <label for="statusKebMar2">Normal</label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-body" style="overflow-x:auto;max-height: 500px;overflow-y:auto;">
                <div class="labelAdd">
                Add Compatitors : <button type="button" class="btn btn-info btn-sm" id="btnAddCompatitors"> <i class="fa fa-plus" aria-hidden="true"></i></button><hr>
                </div>
                    <table class="table" id="companyAdd">
                        <thead>
                            <tr class="info">
                                <th>Brand Name</th>
                                <th>Company</th>
                                <th>Dosage</th>
                                <th>Unit / Pack</th>
                                <th>Price / Unit</th>
                                <th>Price / Pack</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary" style="min-width:500px;">
                <div class="panel-body">
                    <button type="button" class="btn btn-block btn-primary" id="buttonSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>    
                </div>
            </div>
        </div>
    </div>
</form> -->

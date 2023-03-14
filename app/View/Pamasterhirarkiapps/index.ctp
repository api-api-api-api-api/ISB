<?php
	echo $this->Html->script('h1pamasterhirarkiapp.js');
	echo $this->Html->script('bundle.min.js');
?>

<style>
.pagination{margin:0}
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
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
   
    /* End Select Pure Auto complate */
    @media only screen and (min-width: 650px) {
        #modalPA {
            width: 50%;
            margin-left:25%;
            margin-top:2%;
            margin-bottom:2%;
        }
    }
    .modal-body{height: 90%;}
    /* #modalPA {           
        padding:1%;
    } */
</style>
<div class="row">
    <blockquote>MASTER HIRARKI PERFORMANCE APPRAISAL</blockquote><hr>
</div>
<div class="row">  
<div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> FILTER BY:  </label></div>
<div class="form-group"><input type="text" name="txtkaryawanFilter" id="txtkaryawanFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="NIK / NAMA KARYAWAN" onkeyup="if(event.keyCode === 13){getData(1)}"></div>

 <div class="form-group">
                    
</div>
<button type="button"class='btn btn-default btn-sm' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button><hr>
<button type="button" class='btn btn-default btn-sm'  id="btnAdd"><i class="fa fa-plus-circle"> </i> TAMBAH</button><hr>
   
</div>
<div class="row">
    <div class="col-md-12">
    	<div class="row">
	   		<div class="panel panel-default">
	            <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
	                <div class="row">
	                    <table  id='tblppkhirarki' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
	                        <thead>
	                          
	                        </thead> 
	                        <tbody>
	                           
	                        </tbody>
	                    </table>
	                </div>
	           	 </div>
				<div class="panel-footer">
					<nav aria-label="Page navigation example " id="linkHal1" style="display:block"></nav>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal -->

<div class="modal fade"  id="modalPA" role="dialog" aria-labelledby="modalFormMaintenanceUser" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
				<h4 class="modal-title" id="myModalLabel">FORM HIRARKI</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto;">
				<form name="maintenanceForm" id="maintenanceForm">
					<div class="row">
					<!-- col-md-offset-1 -->
						<div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <input type="hidden" name="mode" id="mode">
                                    <div class="form-group" id='displayKaryawanEdit' style="display: none">
                                        <label class="col-md-3 control-label">Karyawan</label>
                                        <div class="col-md-9 inputGroupContainer">
                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <span class="form-control" id="txtKaryawanEdit" readonly style="height: unset;"></span>
                                            <input id="karyawanEdit" name="karyawanEdit" class="form-control"  type="hidden" readonly>
                                            
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pilih Atasan</label>
                                        <div class="col-md-9 inputGroupContainer">
                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                           
                                            <input id="nikatasan" name="nikatasan" class="form-control"  type="hidden">
                                            <span class="autocomplete-select" id="txtAtasan"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pilih Kepala Bagian</label>
                                        <div class="col-md-9 inputGroupContainer">
                                            <div class="input-group"><span class="input-group-addon"><i  class="fa fa-user" aria-hidden="true"></i></span>
                                           
                                            <input id="nikKepalaBagian" name="nikKepalaBagian" class="form-control" type="hidden">
                                            <span class="autocomplete-select" id="txtKepalaBagian"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pilih Kepala Departemen</label>
                                        <div class="col-md-9 inputGroupContainer">
                                            <div class="input-group"><span class="input-group-addon"><i  class="fa  fa-user" aria-hidden="true"></i></span>
                                           
                                            <input id="nikKepalaDept" name="nikKepalaDept" class="form-control" type="hidden">
                                            <span class="autocomplete-select" id="txtKepalaDepartemen"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group" id='displayKaryawan'>
                                    	<label class="col-md-3 control-label">Pilih Karyawan</label>
                                    	<div class="col-md-9 inputGroupContainer">
                                        	<div class="input-group"><span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
                                            
                                            <input id="nikkaryawan" name="nikkaryawan" class="form-control" required="true" type="hidden">
                                            <span class="autocomplete-select" id="txtKaryawan"></span>
                                        	</div>
                                        	 <label><em>Input karyawan bisa lebih dari 1(satu), jika dalam 1 penilai, membawahi beberapa karyawan</em></label>
                                    	</div>
                                    </div>
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="buttonSave" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN</button>  
                                </div>
                            </div>
                        </div>
                    </div>
               </form>
            </div>
		</div>
	</div>
</div>
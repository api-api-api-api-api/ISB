<?php
echo $this->Html->script('h1laporanbdcprocess.js');
// echo $this->Html->script('autocomplate.js');
echo $this->Html->script('bundle.min.js');
echo $this->Html->script('editor.js');
echo $this->Html->css('/css/editor'); 
?>
<style type="text/css">
.grid-container{display: -ms-flexbox;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;padding: 0 4px;border-radius: 5px;padding: 10px;}
.column {-ms-flex: 50%;flex: 50%;max-width: 50%;padding: 0 4px;}
.column:nth-child(odd) {
  border-right: 1px dotted #008CBA;
}
.column1 {-ms-flex: 33.33%;flex: 33.33%;max-width: 33.33%;padding: 0 4px;}
.column2{-ms-flex: 100%;flex: 100%;max-width: 100%;padding: 0 4px;}
.column3{-ms-flex: 66.66%;flex: 66.66%;max-width: 66.66%;padding: 0 4px;}
@media screen and (max-width: 1680px) {
    /* .column {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column:nth-child(odd) {
        border-right:none;
    } */
    /* .column1 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
    .column2 {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column3 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
    .column2:nth-child(odd) {border:0;border-bottom: 1px solid #eee} */
    }
@media screen and (max-width: 1500px) {
    .column {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column:nth-child(odd) {
        border-right:none;
    }
    .column1 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
    .column2 {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column3 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
    .column2:nth-child(odd) {border:0;border-bottom: 1px solid #eee}
    }
/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
    .column {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column1 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
    .column2 {-ms-flex: 100%;flex: 100%;max-width: 100%;padding:0 !important;;}
    .column3 {-ms-flex: 100%;flex: 100%;max-width: 100%;}
}

.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    width: 49%;
    color:black;
    height:20px;
}
.table{margin-bottom:0}
#tblRecordProd tr th{font-family: Arial ; font-weight: normal;height:20px;vertical-align: middle !important;text-align: center;box-shadow: 0 -10px 5px rgba(0,0,0,.1) inset;}
#tblRecordProd tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important} 
#tblRecordProd tbody{padding:5px 15px;min-height:250px;max-height: 350px;overflow-y:auto;}
#tblRecordProd tbody tr td > a {color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;}
#tblNieGroup tr td{font-family: Arial ; font-weight: normal;height:20px;vertical-align: middle !important;padding:5px;}
input,select{margin-bottom:0 !important;min-width:100px;}
#tableProdDiv tr th{font-family: Arial ; font-weight: normal;height:20px;vertical-align: middle !important;text-align: center;box-shadow: 0 -10px 5px rgba(0,0,0,.1) inset;}
#tableProdDiv{padding: 5px;}

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
.linkAkses a{color:brown;font-size:11px;}
.tblFilter tr td{padding:5px; }
.tblFilter  select{margin-bottom:0 !important;min-width:100px;}
/* #deskProdFase table{max-width:max-content !important;} */
</style>
<h1>PRODUCT DEVELOPMENT HISTORY</h1><hr>
<form name="lapbdcForm" method="post" id="lapbdcForm">
<div class="grid-container" style="border-bottom:2px solid black;padding: 10px 10px 10px 40px ;border-top:2px solid black;padding: 10px 10px 10px 10px ">
    <div class="column1"  style="padding-right:10px;min-width:450px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="panel-title"><i class="fa fa-th-list fa-fw" aria-hidden="true"> </i> Filter By</h4>
                    </div>
                    <div class="col-md-4 col-md-offset-0 text-right"></div>
                </div>
            </div>
            <div class="panel-body" style="padding:0 15px;">
                <table class="tblFilter"style="margin-top:6px;">
                    <tr>
                        <td width="90px">Month</td>
                        <td width="8px">:</td>
                        <td width="100px">
                                <select name="bulan" id="bulan" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important;margin-bottom: 0;'>
                                <option value="" selected="selected">All</option>
                                <?php
                                    for($t=1;$t<=12;$t++){
                                        if($t==date("n")){
                                        echo "<option value=$t >".$this->Function->monthName($t)."</option>\n";
                                        }
                                            else{echo "<option value=$t>".$this->Function->monthName($t)."</option>\n";}
                                        }	
                                ?>
                                </select>
                        </td>
                        
                        <td width="50px" >Year</td>
                        <td width="8px">:</td>
                        <td >
                            <div class="col-sm-12">
                                <select name="tahun" id="tahun" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important;margin-bottom: 0;'>
                                <option value="" selected="selected">All</option>
                                <?php
                                    for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                                    if($t==date("Y")){
                                            echo "<option value=$t >$t</option>\n";
                                            }
                                        else{echo "<option value=$t>$t</option>\n";}
                                    }
                                ?>
                                </select>
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>Phase</td>
                        <td width="8px">:</td>
                        <td>
                                <select name="fase" id="fase" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important;margin-bottom: 0;'>
                                    <option value="">All</option>
                                    <option value="1">Planning</option>
                                    <option value="2">Development</option>
                                    <option value="3">Registration</option>
                                </select>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Division</td> 
                        <td width="8px">:</td>
                        <td><select name="divisi" id="divisi" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important;margin-bottom: 0;'></select></div>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td width="8px">:</td>
                        <td> 
                                <select name="filterStatus" id="filterStatus" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important;margin-bottom: 0;'>
                                    <option value="">All</option>
                                    <option value="On">On Progress</option>
                                    <option value="Finish">Finish</option>
                                    <option value="Drop">Drop</option>
                                </select>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Product Name</td>
                        <td width="8px">:</td>
                        <td colspan="4"><span class="autocomplete-select" id="txtspanProduk"></span></td>
                    </tr>
                    
                </table>   
            
            </div>
            <div class="panel-footer">
            <button type="button" class="btn btn-primary" style="margin-top:6px;margin-bottom:6px;font-size:12px;" onclick="ambilData(1)"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> Get Data</button>
            </div>
        </div>
    </div>
    <!-- <div class="column1">
        <div class="form-horizontal">
            <div class="form-group" style="margin-bottom:0">
            <div class="row">
                <label class="col-sm-1 control-label" for="bulan">Bulan</label>
                <div class="col-sm-2">
                    <select name="bulan" id="bulan" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important'>
                    <option value="">All Month</option>
                    <?php
                        // for($t=1;$t<=12;$t++){
                        //     if($t==date("n")){
                        //     echo "<option value=$t selected='selected'>".$this->Function->monthName($t)."</option>\n";
                        //     }
                        //     else{echo "<option value=$t>".$this->Function->monthName($t)."</option>\n";}
                        // }	
                    ?>
                    </select>
                </div>
                <label class="col-sm-1 control-label" for="bulan">Tahun</label>
                <div class="col-sm-2">
                    <select name="tahun" id="tahun" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important'>
                    <option value="">All Year</option>
                    <?php
                        // for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                        //     if($t==date("Y")){
                        //         echo "<option value=$t selected='selected'>$t</option>\n";
                        //         }
                        //     else{echo "<option value=$t>$t</option>\n";}
                        // }
                    ?>
                    </select>
                </div>
                <label class="col-sm-1 control-label" for="fase">Fase</label>
                <div class="col-sm-2"> 
                    <select name="fase" id="fase" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important'>
                        <option value="">All Fase</option>
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                    </select>
                </div>
                <label class="col-sm-1 control-label" for="filterStatus">Status</label>
                <div class="col-sm-2"> 
                    <select name="filterStatus" id="filterStatus" class="form-control" onchange="SetAutoComplete()"  style='font-size:11px !important'>
                        <option value="">All Satus</option>
                        <option value="Update">Update</option>
                        <option value="Finish">Finish</option>
                        <option value="Drop">Drop</option>
                    </select>
                </div>
            </div>
            </div>
        </div>
    </div> -->
    <!-- <div class="column1 ">
        <div class="form-horizontal">
            <div class="form-group" style="margin-bottom:0">
                <label class="col-sm-3 control-label" for="txtspanProduk">Nama Produk</label>
                <div class="col-sm-6">
                    <span class="autocomplete-select" id="txtspanProduk"></span>
                </div>
                <button type="button" class="btn btn-primary" style="margin-top:6px;" onclick="ambilData()"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> Ambil Data</button>
               
            </div>
        </div>
    </div> -->
</div><hr><textarea name="bundleId" id="bundleId" cols="30" rows="10" style="display:none;"></textarea>
<!-- style="border: 1px solid #008CBA;margin-top:10px;" -->
<div class="" >
    <div class="column2">
        <div class="panel panel-primary">
            <div class="panel-heading" style="display:table;width:100%;table-layout:fixed;"><i class="fa fa-th-list fa-fw"></i> BDC RECORD</div>
            <div class="panel-body" style="overflow-x:auto;">
                <div class="row">
                    <table  id='getDataTable' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;" > 
                        <thead>
                            <tr>
                                <th width="30px">No</th> 
                                <th width="150px">Product Code</th>                  
                                <th width="250px">Product Name</th>
                                <th width="150px">Division</th>
                                <th width="150px" style="text-align:center;">Phase</th>
                                <th width="150px" style="text-align:center;">Date</th>
                                <th width="50px" style="text-align:center;">Day</th>
                                <th width="150px" style="text-align:center;">Status</th>
                                <th width="200px" style="text-align:center;">No. FUPB</th>
                                <th width="150px" style="text-align:center;"></th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <td colspan="10" style="text-align:center;">-- Empty Data --</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4" style=" text-align: center;"><nav aria-label="Page navigation example " id="linkHal1" style="display:none"></nav></div>
                <div class="col-md-4"></div>
            </div>
            
        </div>
                <span>* <em>Click Phase, to input <strong>Phase Information</strong></em></span><br>
                <span>* <em>Click button review, to see  <strong>detail</strong></em></span>
    </div>
    
</div>



<!-- test modal -->
<!-- Modal -->
<div class="modal fade"  id="modalProsesFase" role="dialog" aria-labelledby="modalProsesFaseLabel" style="max-width: 80%; max-height: 91%; margin-left: 10%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">Progress Update</h4>
                </div>
                <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
                    <div class="grid-container" style="border-radius: 6px;">
                        <div class="column"  style="padding-right:10px;">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-8">
                                                     <h4 class="panel-title"><i class="fa fa-th-list fa-fw" aria-hidden="true"> </i> Product Detail Information</h4>
                                                </div>
                                                <div class="col-md-4 col-md-offset-0 text-right"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                            <table class="table">
                                                <tr>
                                                    <td width="20%">Product Code</td>
                                                    <td width="3%">:</td>
                                                    <td width="42%" id="kodeProdFase"></td>
                                                    <td width="35%" align="right">
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="openFormProd()"><i class="fa fa-plus" aria-hidden="true"></i> add product</button><input type="text" name="idBdc" id="idBdc" style="display:none">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" id="addProdForm" width="100%">
                                                    <form name="tambahProduk" method="post" id="tambahProduk">
                                                        <div class="row"  style="padding:0 15px;">
                                                                <div class="panel panel-info"  style='margin-bottom: 0;'>
                                                                    <div class="panel-heading"> 
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Product Form
                                                                            </div>
                                                                            <div class="col-md-4 col-md-offset-0 text-right">
                                                                                <button type="button" class="btn btn-xs btn-info" onclick="clossFormProd()"><i class="fa fa-times-circle fa-fw" aria-hidden="true"></i> close </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-body" style="padding:5px 15px;min-height:250px;max-height: 350px;overflow-y:auto;">
                                                                    
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td style="vertical-align: middle;">Product Name</td>
                                                                                <td>:</td> 
                                                                                <td><input type="text" class="form-control" name="prodName" id="nmProd" placeholder="Input Product Name"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="vertical-align: middle;">Division</td>
                                                                                <td>:</td> 
                                                                                <td>
                                                                                    <select name="getDiv" id="getDiv" class="form-control" style='margin-bottom: 0;'></select>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td><button type="button" class="btn  btn-danger" onclick="addProd()"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i></button></td>
                                                                            </tr>
                                                                        </table><hr>
                                                                        <table class="table table-bordered" id="tableProdDiv">
                                                                            <thead>
                                                                                <th width="5%">No.</th>
                                                                                <th width="65%">Product Name</th>
                                                                                <th style="text-align:center">Division</th>
                                                                                <th width="15%"style="text-align:center"></th>
                                                                            </thead>
                                                                            <tbody></tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="panel-footer"> 
                                                                        <button type="button" class="btn btn-block  btn-info" onclick="saveProd()"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i> PRODUCT SAVE</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                      </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="info" width="100%" >
                                                        <div class="row" style="padding:0 15px;">
                                                            <table class="table table-bordered"  id="tblRecordProd" >
                                                                <thead>
                                                                    <th width="5%">#</th>
                                                                    <th width="60%">Product Name</th>
                                                                    <th width="20%">Division</th>
                                                                    <th width="15%"></th>
                                                                </thead>
                                                                <tbody ></tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td>Phase</td>
                                                    <td>:</td>
                                                    <td id="inputFaseTd" colspan="2"></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>Phase Input</td>
                                                    <td>:</td>
                                                    <td id="TampilInputFase" colspan="2" ></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="row">
                                                        <div class="col-md-6 text-left">Description </div>
                                                        <div class="col-md-6 text-right">
                                                            <button type="button" id="btnEditDesk" class="btn btn-default btn-xs"><span style="color: SteelBlue;"><i class="fa fa-pencil-square-o"  aria-hidden="true" style="margin: 5px 5px;"></i> Edit</span></button>
                                                            <button type="button" id="btnSaveEditDesk" class="btn btn-default btn-xs" style="display:none"><span style="color: SteelBlue;"><i class="fa fa-floppy-o" aria-hidden="true" style="margin: 5px 5px;"></i>Save</span></button>
                                                            <button type="button" id="btnBatalEditDesk" class="btn btn-default btn-xs" style="display:none"><span style="color: Tomato;"><i class="fa fa-ban" aria-hidden="true" style="margin: 5px 5px;"></i>Batal</span></button>
                                                        </div>
                                                        </div></td>
                                                    <td>:</td> 
                                                    <td colspan="2" style="max-width:400px">
                                                        <div class="form-control" id="deskProdFase" style="border-radius: 6px;padding:10px;min-width:400px;height:300px;max-height: 300px;overflow-x:scroll;overflow-y:visible;" ></div>
                                                       
                                                        <div id="deskripsiEdit" style="display:none;">
                                                            <div id="descriptionEditor"> </div>  
                                                        </div>
                                                                                                        
                                                        <!-- <textarea id="" class="form-control" rows="5" style="resize: vertical;" readonly></textarea> -->
                                                    </td>
                                                </tr>
                                            </table>  
                                            
                                            </div>
                                        </div>
                                       
                                    </div>
                        </div>
                        <div class="column" style="padding-left:10px;" >  
                                    <div class="form-horizontal">
                                            <input type="text" name="idProd" id="idProd" style="display:none" class="roundIt">
                                            <!-- <input type="text" name="inputFase" id="inputFase" style="display:block" class="roundIt"> -->
                                            <input type="text" name="statusFase" id="statusFase" style="display:none" class="roundIt">
                                            <input type="text" name="idHistDraft" id="idHistDraft" style="display:none" class="roundIt">
                                            <input type="text" name="idHistEdit" id="idHistEdit" style="display:none" class="roundIt">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="text-align: left;" for="txtspanProduk">Phase Update</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id='action' name='action' onchange="tampilNie()">
                                                    <option value="Update">UPDATE</option>
                                                    <option value="Finish">FINISH</option>
                                                    <option value="Drop">DROP</option>
                                                </select>
                                            </div>
                                            
                                            <label class="col-sm-1 control-label" for="txtspanProduk">Date</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="dateInput" id="dateInput">
                                            </div>
                                            <div class="col-sm-2" style="display:block;">
                                                <button type="button" class="btn btn-danger" onclick="openDraft()"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Open Draft</button>
                                            </div>
                                            
                                        </div>
                                        <!-- fase draft -->
                                        <div class="panel panel-default" id="draftPanel" style="display:none">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="panel-title"><i class="fa fa-list-alt" aria-hidden="true"></i> List Draft</h4>
                                                    </div>
                                                    <div class="col-md-4 col-md-offset-0 text-right"><i class="fa fa-chevron-down fa-fw" aria-hidden="true"></i></div>
                                                </div>
                                            </div>
                                            <div id="draftHistori" class="panel-body" style="height: 250;max-height: 250;overflow-y:auto;">
                                            </div>
                                            <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-11"></div>
                                                        <div class="col-md-0 col-md-offset-0 text-right\"><button class="btn btn-default"type="button" onclick="closeDraftPanel()"><i class="fa fa-times fa-fw" aria-hidden="true"></i></button></div>
                                                    </div>
                                            </div>
                                        </div>
                                        <!-- end fase draft -->
                                        <div class="panel panel-default"  id='groupNie' style="display:none">
                                            <div class="panel-body">
                                                <table id='tblNieGroup' width="100%">

                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group"  style="display:none">
                                           
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <textarea id="txtReview" class="form-control" rows="9" style="resize: vertical;"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <div class="col-sm-12" >
                                            <button type="button" id='btnSave' class="btn btn-primary " style="float: right;" onclick="saveFase()"><i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i> SAVE</button>
                                            <button type="button" id='btnSaveDraft' class="btn btn-default" style="float: left;" onclick="saveDraft()"><i class="fa fa-file-text fa-fw" aria-hidden="true"></i> SAVE AS DRAFT</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        <div class="column2">
                            <style>
                                .mb-3, .my-3 {margin-bottom: 1rem!important;}
                                .custom-file{ position: relative;display: inline-block;width: 100%;height: calc(1.5em + .75rem + 2px);margin-bottom: 0;}
                                .custom-file-input {position: relative;z-index: 2;width: 100%;height: calc(1.5em + .75rem + 2px);margin: 0;opacity: 0;}                                .custom-file-label {position: absolute;top: 0;right: 0;left: 0;z-index: 1;height: calc(2.2em + .75rem + 2px);padding: .375rem .75rem;font-weight: 400;line-height: 2.2;color: #495057;background-color: #fff;border: 1px solid #ced4da;border-radius: .25rem;}
                                .custom-file-input:lang(en) ~ .custom-file-label::after {content: "Browse";}
                                .custom-file-label::after {position: absolute;top: 0px;right: 0px;bottom: 0px;z-index: 3;display: block;height: calc(2.2em + 0.75rem);line-height: 2.2;color: rgb(73, 80, 87);content: "Browse";background-color: rgb(233, 236, 239);padding: 0.375rem 0.75rem;border-left: inherit;border-radius: 0px 0.25rem 0.25rem 0px;}
                            </style>
                            <div class="panel panel-default" style="min-width:400px">
                                <div class="panel-heading clearfix">
                                    
                                        <div class="col-md-6 col-md-offset-3">
                                        <!-- <div class="col-md-12" style="line-height: 32px;"> -->
                                            <form id="formUpload" method="POST">
                                                <div class="custom-file mb-3">
                                                    <input type="file" class="custom-file-input" id="customFile" name="filename">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                <div style="text-align:center;margin-top:10px;">
                                                    <button type="submit" class="btn btn-default" id="btnUpload">Submit</button>
                                                </div>
                                                <div style="text-align:center;margin-top:10px;">
                                                    <span>Maximum upload file size: 1 MB</span>
                                                </div>
                                               <div style="text-align:center;margin-top:10px;">
                                                    <span class="badge badge-pill badge-primary">.pdf</span>
                                                    <span class="badge badge-pill badge-secondary">.docx</span>
                                                    <span class="badge badge-pill badge-success">.zip</span>
                                                    <span class="badge badge-pill badge-danger">.jpg</span>
                                                    <span class="badge badge-pill badge-warning">.png</span>
                                               
                                                </div>
                                            </form>
                                        </div>
                                    
                                </div>
                                <div class="panel-body">
                                    <div id="listFile">
                                        <span>kosong</span> 
                                    </div>
                                </div>
                            </div>
                                
                           
                        </div>
                        <div class="column2" id="laporanProsesFase" style="background-color: #eee;border-radius: 6px;padding:5px 0;margin-top:10px;">
                            
                        </div>
                    </div>             
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
    </div>
</div>

<!-- iframe modal -->
<div class="modal fade" tabindex="1" role="dialog" id="modalReview" style="max-width: 80%; max-height: 91%; margin-left: 10%; margin-top: 2%;outline: 0;">
  
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 6px;border-radius: 6px;min-height: unset;">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Review</h4>
            </div>
          <!-- <table>
              <tr>
                  <td><button type="button" class="btn btn-default" data-dismiss="modal" onclick="filterstatus();"> < </button></td>
                  <td><button type="button" class="btn btn-default" data-dismiss="modal" onclick="getData(1);"> < </button></td>
                  <td><h4 class="modal-title"> Form Input Revisi </h4></td>
              </tr>
          </table> -->
        
            <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
            
                <input type="hidden" id="idpermintaan">
                <iframe src="" width="100%" height="850px" id="frameShow" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
            </div>
        </div>
    
    </div>
</div>
<!-- Modal Link Fupb -->
<div class="modal fade" role="dialog" id="modalLinkFupb" style="max-width: 34%; max-height: 75%; margin-left: 33%; margin-top: 2%;outline: 0;">
  
  <div class="modal-dialog" role="document" >
      <div class="modal-content" style="border-radius: 6px;border-radius: 6px;min-height: unset;">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                  <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Link FUPB to BDC</h4>
          </div>     
          <div class="modal-body" style="height: 600px;max-height: 500px;overflow-y:auto;">
              <input type="hidden" id="idBdclinktofupb">
              <input type="hidden" id="idFupblinktoBdc">
              <div class="panel panel-default" style="min-width:400px">
                <div class="panel-heading clearfix" style="background-color:#696969;color:#fff">
                    <div class="row">
                        <div class="col-md-5" style="line-height: 32px;">
                             Tambahkan No. FUPB
                        </div>
                        <div class="col-md-7 col-md-offset-0" >
                            <div class="input-group">
                                <input type="text" id="fupbSrc" class="form-control"  placeholder="Cari FUPB" style="font-size:12px;height: 34px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-default addTag" id="btnSrcFupb" type="button"><i class="fa fa-plus-circle" aria-hidden="true"> </i> Search</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body"  style="margin-bottom:unset;padding:0 15px;">
                    <div class="row">
                        <table id="tblFupblink" cellpadding="0" cellspacing="0" width="100%" class="table " style="margin-bottom:unset;padding:0 15px;">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center;">No</th> 
                                    <th width="80%">No. FUPB</th>                  
                                    <th width="15%" style="text-align:center;">Pilih</th>
                                </tr>
                            </thead> 
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>  
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example " id="linkHal2" style="display:none"></nav>
                </div>
                
            </div>
            <div class="input-group input-group-lg">
                <input type="text" id="txtKodeProd" class="form-control"  disabled aria-describedby="sizing-addon6" >
                <div class="input-group-addon" ><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                <input type="text" id="txtNoFUPB" class="form-control"  disabled placeholder="Pilih No. FUPB"  aria-describedby="sizing-addon6" >
            </div>
                
          </div>
          <div class="modal-footer">
            <div class="row">
                <div class="col-md-6 text-left">
                    <button type="button" id="btnSaveLink" class="btn btn-primary  mr-auto"><i class="fa fa-link" aria-hidden="true"></i> Linked</button>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-default ml-1" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
              
            </div>
              
          </div>
      </div>
  
  </div>
</div>
<!-- End Modal Link Fupb -->

<!-- 
                <div class="panel panel-primary" style="overflow-x:auto;">
                            <div class="panel-heading">BDC RECORD</div>
                                    <table id='getInformasiProduk' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;"> 
                                        <thead>
                                            <tr>
                                                <th width="10px">No</th> 
                                                <th width="150px">Kodeprod</th>                  
                                                <th width="250px">Nama Produk</th>
                                                <th width="150px">Divisi</th>
                                                <th width="150px" style="text-align:center;">Fase</th>
                                                <th width="150px" style="text-align:center;">tgl</th>
                                                <th width="150px" style="text-align:center;">day</th>
                                                <th width="150px" style="text-align:center;">Status</th>
                                                <th width="250px" style="text-align:center;">Review</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <tr>
                                                <td colspan="9" style="text-align:center;">Kosong</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

-->
<!-- modal form -->

</form>


<?php
echo $this->Html->script('jquery.signaturepad.min.js');
echo $this->Html->script('h1fupbreport.js');
echo $this->Html->css('jquery.signaturepad.css');
?>
<style>
@media screen and (max-width: 1800px) {
    .col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8{float: left;width:100%;}
    .col-md-offset-2 {margin-left: 0;}
}
#getDataFUPB tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important} 
#getDataFUPB tbody tr:nth-child(even) td{padding:unset;}

#companyAdd  tr th{font-family: Arial ; font-weight: 900;height:20px;vertical-align: middle !important;text-align: center;}
#companyAdd tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important;} 
#companyAdd tbody tr td > a {color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;font-family: Arial ; font-weight: normal;}
#companyAdd tbody tr td >label{font-family: Arial ; font-weight: normal;font-size: 12px;}
#companyAdd label{margin-bottom: unset;}
#companyAdd input,#companyAdd select{font-size:12px;}
#companyAdd th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;top:0;}
.labelAdd {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 3;background:#fff;}
#tableForm input,#tableForm select{margin:3px 0;font-size:12px;}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}

.tblDetail tr>td{padding:10px 15px !important;font-size: 12px;}
.tblTtd tr>td{padding:5px 15px !important;}
</style>
<div class="page-header">
    <h3>FUPB</h3>
</div>
<form name="fupbReport" id="fupbReport" method="post">
    <div class="row" style="display:none">
        <div class="col-md-4">
            <div class="panel panel-primary" style="min-width:450px;">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <span class=""><i class="fa fa-search-plus fa-fw" aria-hidden="true"> </i> Filter By</span>
                        </div>
                        <div class="col-md-4 col-md-offset-0 text-right"></div>
                    </div>
                </div>
                <div class="panel-body" > 
                    <table class="tblFilter" >
                        <tr>
                            <td width="90px" for="inpDivID"></td>
                            <td width="8px">:</td>
                            <td width="100px"><input class="form-control" name="inpDivID" id="inpDivID" type="text" value=""></td>
                            <td width="10px"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td  for="inpDivNama"></td>
                            <td>:</td>
                            <td><input class="form-control" type="text" name="inpDivNama" id="inpDivNama" value=""></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td  for="inpDivNama"></td>
                            <td>:</td>
                            <td>
                                <select class="form-control" name="inpTahun" id="inpTahun" class="form-control" onchange="clearTable()"  style='font-size:11px !important;margin-bottom: 0;'>
                                <option value="" selected="selected">Pilih Tahun</option>
                                <?php
                                    for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                                    if($t==date("Y")){
                                            echo "<option value=$t >$t</option>\n";
                                            }
                                        else{echo "<option value=$t>$t</option>\n";}
                                    }
                                ?>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer"><button type="button" class="btn btn-info btn-xs" onclick="searchFupb()"><i class="fa fa-search" aria-hidden="true"></i> Search</button></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading" style="background-color:#696969;color:#fff">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-th-list fa-fw"></i> FUPB RECORD
                        </div>
                        <div class="col-md-6 col-md-offset-0 text-right">
                            <button type="button" id="btnForm" class="btn btn-xs btn-danger"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> ADD FUPB</button>
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
    <div class="modal fade"  id="modalFormFUPB" role="dialog" aria-labelledby="modalProsesFaseLabel" style="max-width: 90%; max-height: 91%; margin-left: 5%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FUPB FORM</h4>
                </div>
                <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
                <form name="fupbForm" id="fupbForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-primary" style="min-width:500px;">
                                <div class="panel-body">
                                <input type="hidden" name="genID" id="genID">
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
                                                <input type="radio" id="Cito" name="statusKebMar" value="Cito"  checked>
                                                <label for="Cito">Cito</label><br>
                                                <input type="radio" id="Normal" name="statusKebMar" value="Normal">
                                                <label for="Normal">Normal</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
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
                                        <div class="sig sigWrapper" style="height:auto;">
                                        <div class="typed"></div>
                                        
                                        <canvas class="pad" style="width:100%;" id="canvas__"></canvas>
                                        <input type="hidden" name="output__" class="output">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-primary" style="min-width:500px;">
                                <div class="">
                                    <button type="button" class="btn btn-block btn-danger" id="buttonSave" onclick='simpanFUPB()'><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>    
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

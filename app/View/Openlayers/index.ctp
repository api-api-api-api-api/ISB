<style>
    .map{
        width: 100%;
        height: 500px;
    }
    .olPopupCloseBox{background: none!important;}
    html,
    body {
        font-family:Arial, Helvetica, sans-serif !important;
        height: 100%;
        width: 100%;
        padding: 0px;
        margin: 0px;
    }
    .tab{transition: transform .2s;}
    .tab:hover {cursor:pointer;transform: scale(1.03);background-color: bisque;}
    #tablePosisi thead th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;height:30px;font-size:12px;background:#0b4c6c;color:white;border: 0;}
    #tablePosisi tfoot th {position: -webkit-sticky;  position: sticky;  bottom: 0;  z-index: 2;height:30px;font-size:12px;background:#0b4c6c;color:wheat;border: 0;}
    .tblFilter input,.tblFilter select,.tblFilter .inputGroupContainer,.btnCari{margin:3px 0;font-size:12px;}
    .input-group .form-control {  position: relative;  z-index: 2;  float: left;  width: 100%;  margin-bottom: 0;  margin-top: 0;}
    #ui-datepicker-div{z-index: 5 !important;}
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
    .ui-widget-header {border: 1px solid grey;background: #0b4c6c;color: wheat;font-weight: 700;}
</style>
<h1>OPEN LAYER ABSENSI</h1><hr>
<div class="">
    <!-- start -->
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="panel-title"><i class="fa fa-search fa-fw"></i> Filter By</h4>
                                    </div>
                                    <div class="col-md-4 col-md-offset-0 text-right"></div>
                                </div>
                            </div>
                            <div class="panel-body form-horizontal" style="padding: 15px;">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Periode</label>
                                    <div class="col-md-10 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            </span>
                                            <input class="form-control" name="startDate" id="startDate" type="text" value="" placeholder="Awal" >
                                            <span class="input-group-addon">s/d</span>
                                            <input class="form-control" name="endDate" id="endDate" type="text" value="" placeholder="Akhir">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>   
                                    <div class="col-sm-10">
                                        <button type="button" class="btn btn-default btnCari" onclick="getTablePosisi()">Cari</button> 
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="form-inline" style="display:none">
                            <div class="form-group">
                                <label for="exampleInputName2">Pilih Nama</label>
                                <select name="carinama" id="carinama" class="form-control" onchange="getTablePosisi()"></select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-12" >
                    <div class="row">
                        <div class="panel panel-default ">   
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="panel-title"><i class="fa fa-th-list fa-fw" aria-hidden="true"> </i></h4>
                                    </div>
                                    <div class="col-md-4 col-md-offset-0 text-right"></div>
                                </div>
                            </div>                
                            <div class="panel-body table-responsive" style='height:350px;max-height: 350px;overflow-y:auto;padding:0 15px;'>
                                <div class="row">
                                    <table class="table" id="tablePosisi">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Lokasi</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="panel panel-default">
                           
                            <div class="panel-body form-horizontal" style="padding: 15px;">
                                <div id="mapdiv" class="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
</div>
    
    <!-- <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
    
    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <!-- <script src="js/OpenLayers.js"></script> -->
    <!-- <script src="js/script.js"></script> -->

    <?php
        echo $this->Html->script('h1openlayer.js');
    ?>
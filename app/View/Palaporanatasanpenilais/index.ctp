<?php
    echo $this->Html->script('h1palaporanatasanpenilai.js');
    echo $this->Html->script('bundle.min.js');       
?>
<style>
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: unset !important;
    }
    .tab{transition: transform .2s;}
	.tab:hover {cursor:pointer;transform: scale(1.01);
        background-image: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed) !important;
        box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75); font-weight: 700;}
	.ativetab{background:#25aae1 !important;border-top:1px solid #ddd !important; color:white; font-weight: 700;}
    /* #tabelLaporanAtasanPenilai tbody {height:400px;overflow:auto;}
	#tabelLaporanAtasanPenilai thead, #tabelLaporanAtasanPenilai tbody tr {display:table;	width:100%;	table-layout:fixed;	}
	#tabelLaporanAtasanPenilai thead {width: calc( 100%  )} */
    .batas td{border-top: 1px solid black;}
    .tableFixHead {
      width: 100%;
      table-layout: fixed;
      border-collapse: collapse;
    }
      .tableFixHead tbody {
      display: block;
      width: 100%;
      overflow: auto;
      height:400px;
    }
    .tableFixHead thead tr {
      display: block;
     
    }
    .tableFixHead thead{width: calc( 100% -1em ) !important;}
    .tableFixHead th,
    .tableFixHead  td {
      padding: 5px 10px;
      /* width: 200px; */
    }
    th {
      background: #ABDD93;
    }
    .trBorder td{border-top:1px solid black;}
</style>
<blockquote>LAPORAN ATASAN PENILAI</blockquote>
<div class="row">
    <!-- <div class="col-md-5">
        <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> Cari Data:  </label></div>
                <div class="row">
                
                    <div class="col-md-8">
                        <div  class="form-inline" style="margin-bottom:12px;">
                            <div class="form-group">
                                <input type="text" name="txtSrcDivisi" id="txtSrcDivisi" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Cari Divisi" onkeyup="if(event.keyCode === 13){getDataDivisi(1)}">
                            </div>
                            <button type="button"class='btn btn-default' style="margin-bottom:0" onclick='getDataDivisi(1)'> <i class="fa fa-search fa-fw"></i> CARI</button>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-0 text-right">
                        
                    </div>
                
        </div>
    </div> -->
</div>
<div class="row">
<div class="col-md-6">             
                <div class="col-md-12">
                    <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label"><i class="fa fa-th-list fa-fw"></i>Laporan atasan penilai</label>
                                    
                                </div>
                                <div class="col-md-7">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                            <div class="row">
                                
                            </div>  
                        </div>
                        <div class="tableFixHead">
                        <table  id='tabelLaporanAtasanPenilai' cellpadding="0" cellspacing="0" width="100%" class="table table-bordered" style="border-radius: 5px;margin-bottom:0;"> 
                                    <thead>
                                        <tr class="active">
                                            <th width="3%" style="text-align:center;vertical-align:middle">No</th> 
                                            <th width="50%" style="vertical-align:middle">Nama atasan</th>    
                                            <th width="3%" style="text-align:center;vertical-align:middle"> - </th>               
                                            <th width="47%" style="vertical-align:middle">Karyawan Dinilai</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center; background-color:#fff !important;"><div class="alert alert-info" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
                                        </tr>
                                    </tbody>
                        </table>
                        </div>
                        <div class="panel-footer">
                        <button type='button'  id='' style='color:#1b926c;font-size:11px;' class='btn btn-default btn-sm' onclick='cetakexcel()'><i class='fa fa-file-excel-o' aria-hidden='true'></i> Cetak Excel</button></td>
                            <nav aria-label="Page navigation example " id="linkHal1" style="display:block"></nav>
                        </div>
                    </div>
                    </div>
                </div>
           
        </div>
</div>
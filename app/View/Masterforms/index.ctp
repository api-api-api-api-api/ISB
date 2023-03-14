<?php
echo $this->Html->script('h1masterform.js');
//harus ada untuk semua konversi
// echo $this->Html->script('tableExport.js');
// echo $this->Html->script('jquery.base64.js');

//untuk konversi png
//echo $this->Html->script('html2canvas.js');
//untuk konversi pdf
//echo $this->Html->script('jspdf/jspdf.js');
//echo $this->Html->script('jspdf/libs/sprintf.js');
//echo $this->Html->script('jspdf/libs/base64.js');
?>
<style>
    .table>thead>tr>th{padding:0px;}
</style>
<blockquote>Master Barang</blockquote>
<form  name="h1form" method="post" class="frmInput">
<input type="text" name="" id="group" value="<?php if (isset($_GET['jenisPermintaan'])) {echo $_GET['jenisPermintaan']; }else{ echo "";}?>" style="display:none;">
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD</label></div>
        </div>
    </div>
    <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;">
        <div class="row">
        <table id="tblDetil1" style="width:100%;margin-bottom:0;" class="table table-bordered">
			<thead>
                <tr class="active">
                    <th width="2%" style="text-align:center;vertical-align:middle" rowspan="2">No</th> 
                    <th width="20%" style="text-align:center;vertical-align:middle">Nama Barang</th>
                    <th width="12%" style="text-align:center;vertical-align:middle">Kategori</th>
                    <th width="12%" style="text-align:center;vertical-align:middle">Jenis</th>
                    <th width="12%" style="text-align:center;vertical-align:middle" rowspan="2">Group</th>                  
                    
                </tr>
                <tr class="active">
                    <th width="20%" style="text-align:center;vertical-align:middle"><input type="text" class="form-control" id="txtNmBrg" onkeyup="getData(1)"></th>
                    <th width="12%" style="text-align:center;vertical-align:middle"><input type="text" class="form-control" id="txtKategoriBrg" onkeyup="if(event.keyCode === 13){getData(1)}"></th>                 
                    <th width="12%" style="text-align:center;vertical-align:middle"><input type="text" class="form-control" id="txtJenisBrg" onkeyup="if(event.keyCode === 13){getData(1)}"></th>
                </tr>
            </thead>
			<tbody></tbody>
	    </table>
        </div>
    </div>
    <div class="panel-footer">
        <nav aria-label="Page navigation example " id="linkHal1" style="display:block">...</nav>
    </div>
</div>

</form>

<?php
echo $this->Html->script('h1masterjeniskategorigroup.js');
?>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	table.scroll {width: 100%;border-spacing: 0;}
	table.scroll th,table.scroll td,table.scroll tr,table.scroll thead,table.scroll tbody { display: block; }
	table.scroll thead tr {/* fallback */ width: 97%; /* minus scroll bar width */ width: -webkit-calc(100% - 16px); width: -moz-calc(100% - 16px); width: calc(100% - 16px);}
	table.scroll tr:after {content:'';display: block;visibility: hidden;clear: both;}
	table.scroll tbody {height: 100px;overflow-y: auto;overflow-x: hidden;}
	table.scroll tbody td,table.scroll thead th {float: left;border-right: 1px solid #2A4B7C;}
	table.scroll thead tr th { height: 30px; line-height: 30px;border-bottom:1px solid #ffd662;background-color:#F3E0BE;/*text-align: left;*/}
	table.scroll tbody tr td { height: 30px; line-height: 30px;}
	table.scroll tbody tr:hover {background-color: #577284; color:#ffffff;border:1px solid black;}
	/* tbody { border-top: 2px solid black; } */
	tbody td:last-child, thead th:last-child {border-right: block !important;}
	.scroll tbody tr:last-child {border-bottom: 1px solid #000;}
</style>

<header class="header">Maintenence Group Jenis Kategori Barang</header>
<fieldset class="roundIt" style="width:100%;">
    <table style="width:100%;margin-top:1%;margin-bottom:1%;">
		<tr>
			<td style="padding-left:10px">
				<table style="width:90%;">
                    <tr>
					    <td><strong style=""> Kategori Item</strong></td>
						<td align="right">
						<input type="text" id="txtKategori" name="txtKategori" class="roundIt" placeholder="Cari Kategori">	
						<button type="button"  id="btnCariKategori"  onClick="getKategori('1')">Cari</button>	
						</td>
					</tr>
                </table>
			</td>
			<td style="padding-left:10px">
				<strong> Jenis Item</strong>
				<!-- <input type="text" id="jenId" name="jenId" class="roundIt"> -->
			</td>
			<td></td>
		</tr>
        <tr>
			<td style="width:30%" id="container">
                <table id="tableA" class="scroll" style="width:100%">
					<thead style="padding:2% 2% 0 2%;"></thead>
					<tbody style="padding:0 2% 2% 2%;"></tbody>
				</table>
            </td>
			<td style="width:30%">
				<table id="tableB" class="scroll" style="width:100%">
					<thead style="padding:2% 2% 0 2%;"></thead>
					<tbody style="padding:0 2% 2% 2%;"></tbody>
				</table>
            </td>
			<td style="width:30%">
                <table id="tableC"  class="scroll" style="width:100%;">
					<thead></thead>
					<tbody></tbody>
				</table>
			</td>
        </tr>
		<tr>
			<td style="padding-left:10px;padding-top:10px;">
				<button type="button" id="btnAdd" onClick="addKat()">Add</button>
				<button type="button" id="btnEdit" onClick="editKat()">Edit</button>
				<button type="button" id="btnDel" onClick="delKat()">Del</button>
				<form name="h1form" style="display:none" id='h1form' >
					<fieldset class="roundIt" style="margin-top:5%;width:93%;padding:5%;box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;" >	
					<table align="center"  style="width:100%;">
						<tr><td width="20%" style="padding-top:4%"><label >Kategori</label></td><td width="3%">:</td><td width="60%">
							<input type="text" id="txtKatId" name="txtJnsId" class="form-control" style="display:none">
							<input type="text" id="txtKatInput" name="txtJenisInput" class="form-control" style="margin-top:2%;margin-bottom:2%;font-size:10px;"></td><td width="3%"></td><td width="7%" align="center"><button type="button" class="form-control" id="tblSave" onClick="simpan()" style="margin-top:2%;font-size:10px;">Simpan</button></td></tr>
					</table>
					</fieldset>
				</form>
			</td>
		</tr>
    </table>
</fielset>



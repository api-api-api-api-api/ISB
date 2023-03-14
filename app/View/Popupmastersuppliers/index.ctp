<?php
$this->layout='popup';
echo $this->Html->script('h1popupmastersupplier.js');
echo $this->Html->script('bundle.min.js');
?>
<script type='text/javascript'>
	var obj_caller =parent.opener;
	var btnAksi="";
	var btnAksi=obj_caller.$("#btnAksi").val().split("|");
	var result1=btnAksi[0];
	var	result2=btnAksi[1];
	//console.log(btnAksi)
</script>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	button{ background-color: #4CAF50;width:80px;border: none;border-radius: 5px;color: white;padding: 5px 8px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;-webkit-transition-duration: 0.4s; /* Safari */ transition-duration: 0.4s; cursor: pointer;}
	button:disabled,
	button[disabled]{border: 1px solid #999999;background-color: #cccccc; color: #666666;}
	.button1 {background-color: white; color: #008CBA; border: 2px solid #008CBA;}
	.button1:hover {background-color: #008CBA;color: white;}

	
	.frmInput{ width: 150%;padding: 6px;border: 1px solid #ccc;border-radius: 4px;resize: vertical; background-color:white;}
	.header {overflow: hidden;background-color: #f1f1f1;padding: 20px 10px;}
	input[type=text], select, textarea{width: 100%;padding: 6px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;resize: vertical;}
	input:read-only {background-color: #eee;opacity: 0.7;}
	/* Style the label to display next to the inputs */
	/* Floating column for labels: 25% width */
	.col-25 {float: left;width: 25%;margin-top: 8px;}

	/* Floating column for inputs: 75% and 50% width */
	.col-75 {float:left;width:75%;margin-top: 6px;}
	.col-50 {float:left;width:50%;margin-top: 6px;margin-bottom:6px;}
	/* Clear floats after the columns */
	.row:after {content: "";display: table;clear: both;}
	.cari{width: 130px;box-sizing: border-box;border: 2px solid #ccc;border-radius: 4px;font-size: 16px;background-color: white;background-image: url('searchicon.png');background-position: 10px 10px; background-repeat: no-repeat;padding: 12px 20px 12px 40px;-webkit-transition: width 0.4s ease-in-out;transition: width 0.4s ease-in-out;}
	/* Select Pure Auto complate */
	.select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
	.select-pure__select {align-items: center;border-radius: 4px;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 44px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
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

	/*Style AutoComplate 2 */

	/*input {border: 1px solid transparentbackground-color: #f1f1f1;padding: 10px;font-size: 16px;	}
	#inpKota {background-color: #f1f1f1;width: 100%;}
	input[type=submit] {background-color: DodgerBlue;color: #fff;}*/

	.autocomplete {/*the container must be positioned relative:*/position: relative;display: inline-block;}
	.autocomplete-items {border-radius: 4px;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer;position: absolute;border-bottom: none;border-top: none;z-index: 99;/*position the autocomplete items to be the same width as the container:*/top: 100%;left: 0;right: 0;max-height: 221px;overflow-y: scroll;top: 30px;}
	.autocomplete-items div {padding: 10px;cursor: pointer;background-color: cornsilk;border-bottom: 1px solid #d4d4d4;}
	.autocomplete-items div:hover {/*when hovering an item:*/background-color: #e9e9e9;}
	.autocomplete-active {/*when navigating through the items using the arrow keys:*/ background-color: DodgerBlue !important;color: #ffffff;}


	/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
	@media screen and (max-width: 500px) {.col-25, .col-75, input[type=submit] {width: 100%;margin-top: 0;}
</style>
<form class="frmInput" name="masterSupplierForm" method="post">
	<header>Informasi Supplier</header>
	<div class="container">
		<div class="row">
			<div class="col-25">
				<label for="namaSupplier">Nama Supplier *</label>
			</div>
			<div class="col-75">
				<input type="text" id="namaSupplier"  name="txtNamaSupplier" placeholder="Nama Supplier" >
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				<label for="deskripsi">Deskripsi *</label>
			</div>
			<div class="col-75">
				
				<span class="autocomplete-select" id="txtDeskripsiSelectPure" style="min-width:200px;width:50%"></span>
				<div class="autocomplete" style="min-width:200px;width:100%">
					<input type="text" id="deskripsi" name="txtDeskripsi" placeholder="Deskripsi">
				 </div>
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				<label for="alamat">Alamat *</label>
			</div>
			<div class="col-75">
				<input type="text" id="alamat" name="txtAlamat" placeholder="Alamat">
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				<label for="kodePos">Kode Pos</label>
			</div>
			<div class="col-75">
				<input type="text" id="kodePos" name="txtKodePos" placeholder="kode pos">
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				<label for="noTelp">No. Telp/Hp *</label>
			</div>
			<div class="col-75">
				<input type="text" id="noTelp" name="txtNoTelp" placeholder="No. Telp/Hp">
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				<label for="noTelp">No. Fax</label>
			</div>
			<div class="col-75">
				<input type="text" id="noFax" name="txtFax" placeholder="No. Fax">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="email">Email</label>
			</div>
			<div class="col-75">
				<input type="text" id="email" name="txtEmail" placeholder="E-mail">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="npwp">NPWP</label>
			</div>
			<div class="col-75">
				<input type="text" id="npwp" name="txtNpwp" placeholder="NPWP">
			</div>
		</div>
        <div class="row" >
			<div class="col-25">
				<label for="npwp">dengan PPN  *</label>
			</div>
			<div class="col-75">
				<select id="ppn" name="ppn">
					<option value="ya">YA</option>
					<option value="tidak">TIDAK</option>
				</select>			
            </div>
		</div>
        <div class="row" >
			<div class="col-25">
				<label for="jenisUsaha">Jenis Usaha  *</label>
			</div>
			<div class="col-75">
				<select id="jenisUsaha" name="jenisUsaha">
					
				</select>			
            </div>
		</div>
		<header style="margin-top: 6px;">Kontak Personal / Penanggung Jawab</header>
		<div class="row" >
			<div class="col-25">
				<label for="namaKontak">Nama *</label>
			</div>
			<div class="col-75">
				<input type="text" id="namaKontak" name="txtNamaKontak" placeholder="Nama Kontak">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="alamatKontak">Alamat</label>
			</div>
			<div class="col-75">
				<input type="text" id="alamatKontak" name="txtAlamatKontak" placeholder="Alamat">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="noHpKontak">No. HP Kontak *</label>
			</div>
			<div class="col-75">
				<input type="text" id="noHpKontak" name="txtNoHpKontak" placeholder="No. HP./Telp.">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="emailKontak">Email Kontak</label>
			</div>
			<div class="col-75">
				<input type="text" id="emailKontak" name="txtEmailKontak" placeholder="Email Kontak">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="jabatanKontak">Jabatan *</label>
			</div>
			<div class="col-75">
				<input type="text" id="jabatanKontak" name="txtJabatanKontak" placeholder="Jabatan">
			</div>
		</div>

		<header style="margin-top: 6px;">Bank yang digunakan</header>
		<div class="row" >
			<div class="col-25">
				<label for="bank">Bank</label>
			</div>
			<div class="col-75">
				<select id="bank" name="txtBank">
					
				</select>
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="alamatBank">Cabang / Alamat</label>
			</div>
			<div class="col-75">
				<input type="text" id="alamatBank" name="txtAlamatBank" placeholder="Cabang / Alamat Bank">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="norek">No. Rekening</label>
			</div>
			<div class="col-75">
				<input type="text" id="norek" name="txtNorek" placeholder="Nomor Rekening">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="atasNama">Atas Nama</label>
			</div>
			<div class="col-75">
				<input type="text" id="atasNama" name="txtAtasNama" placeholder="Atas Nama">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="tos">TOS</label>
			</div>
			<div class="col-75">
				<input type="text" id="tos" name="txtTos" placeholder="TOS">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="keteranganTos">Keterangan TOS</label>
			</div>
			<div class="col-75">
				<input type="text" id="keteranganTos" name="txtKeteranganTos" placeholder="Keterangan TOS">
			</div>
		</div>
		<div class="row" >
			<div class="col-25">
				<label for="statusSupplier">Status</label>
			</div>
			<div class="col-75">
				<input type="text" id="statusSupplier" name="txtStatusSupplier" placeholder="Status Supplier">
			</div>
		</div>
		<hr>
		<div class="row" align="center">
			<input type="text" name="txtSupId" id="supid" style="display: none">
			<input type="text" name="txtBtnAksi" id="btnAksi" style="display: none">
			<button type="button" class="button1"  onClick="editData()" id="btnEdit">Edit</button>
			<button type="button" class="button1"  onClick="simpanData()" id="btnSimpan">Simpan</button>
		</div>
		<div class="row">
			<label for="note">Catatan :</label>
			<label for="isiNote">* : Pastikan semua label isian/input bertanda ( * ) terisi </label>
		</div>
	</div>
</form>
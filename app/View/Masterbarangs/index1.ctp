<?php
echo $this->Html->script('h1masterbarang.js');
?>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	/*table {	font-family:Tahoma, Arial, Helvetica, sans-serif; font-size:14px;width: 100%;}
	button{ background-color: #4CAF50;width:80px;border: none;border-radius: 5px;color: white;padding: 5px 8px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;-webkit-transition-duration: 0.4s;  transition-duration: 0.4s; cursor: pointer;}
	button:disabled,
	button[disabled]{border: 1px solid #999999;background-color: #cccccc; color: #666666;}
	.button1 {background-color: white; color: #008CBA; border: 2px solid #008CBA;}
	.button1:hover {background-color: #008CBA;color: white;}*/

	
	/*.frmInput{ width: 100%;padding: 6px;border: 1px solid #ccc;border-radius: 4px;resize: vertical;}
	.header {overflow: hidden;background-color: #f1f1f1;padding: 20px 10px;}*/
	/* Style inputs, select elements and textareas */
	/*input[type=text], select, textarea{width: 100%;padding: 12px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;resize: vertical;}*/
	/* Style the label to display next to the inputs */
	/*#tabs-1 label {padding: 12px 12px 12px 0;display: inline-block;}
	#tabs-2 label {display: inline-block;}*/
	/* Style the submit button */
	/*input[type=submit] {background-color: #4CAF50;color: white;padding: 12px 20px;border: none;border-radius: 4px;cursor: pointer;float: right;}*/
	/* Style the container */
	/*.container { width: 100%; border-radius: 5px;background-color: #f2f2f2;padding: 20px;}*/
	/* Floating column for labels: 25% width */
	/*.col-25 {float: left;width: 25%;margin-top: 6px;}*/
	/* Floating column for inputs: 75% and 50% width */
	/*.col-75 {float:left;width:75%;margin-top: 6px;}*/
	/*.col-50 {float:left;width:50%;margin-top: 6px;margin-bottom:6px;}*/
	/* Clear floats after the columns */
	/*.row:after {content: "";display: table;clear: both;}
	.cari{width: 130px;box-sizing: border-box;border: 2px solid #ccc;border-radius: 4px;font-size: 16px;background-color: white;background-image: url('searchicon.png');background-position: 10px 10px; background-repeat: no-repeat;padding: 12px 20px 12px 40px;-webkit-transition: width 0.4s ease-in-out;transition: width 0.4s ease-in-out;}*/
	/* The container */
	/*.lblContainer {display: block;position: relative;padding-left: 35px;font-size:12px; margin-bottom: 12px;cursor: pointer;-webkit-user-select: none;-moz-user-select: none; -ms-user-select: none;user-select: none;}*/
	/* Hide the browser's default checkbox */
	/*.lblContainer input {position: absolute;opacity: 0;cursor: pointer;height: 0;width: 0;}*/
	/* Create a custom checkbox */
	/*.checkmark {position: absolute;top: 0;left: 0;height: 25px;width: 25px;background-color: #eee;}*/
	/* On mouse-over, add a grey background color */
	/*.lblContainer:hover input ~ .checkmark {background-color: #ccc;}*/
	/* When the checkbox is checked, add a blue background */
	/*.lblContainer input:checked ~ .checkmark {  background-color: #2196F3;}*/
	/* Create the checkmark/indicator (hidden when not checked) */
	/*.checkmark:after {content: ""; position: absolute;display: none;}*/
	/* Show the checkmark when checked */
	/*.lblContainer input:checked ~ .checkmark:after {display: block;}*/
	/* Style the checkmark/indicator */
	/*.lblContainer .checkmark:after {left: 9px;top: 5px;width: 5px;height: 10px;border: solid white;border-width: 0 3px 3px 0;-webkit-transform: rotate(45deg); -ms-transform: rotate(45deg); transform: rotate(45deg);}*/
	/*Table CSS*/
	/*#tblBarang {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;}
	#tblBarang td, #tblBarang th {border: 1px solid #ddd;padding: 8px;}
	#tblBarang tr:nth-child(even){background-color: #f2f2f2;}
	#tblBarang tr:hover {background-color: #ddd;}
	#tblBarang th {padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;}*/
	/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
	@media screen and (max-width: 600px) {.col-25, .col-75, input[type=submit] {width: 100%;margin-top: 0;}
</style>
<header class="header">MASTER BARANG</header>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Tambah</a></li>
		<li><a href="#tabs-2">Lihat data</a></li>
	</ul>
	<div id="tabs-1">
		<form class="frmInput" name="masterBarangForm" method="post">
			<div class="container">
				<div class="row">
					<div class="col-25">
						<label for="namaBrg">Nama Barang</label>
					</div>
					<div class="col-75">
						<input type="text" id="namaBrg" name="txtNamaBrg" placeholder="Nama Barang">
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="kategoriBrg">Kategori</label>
					</div>
					<div class="col-75">
						<input type="text" id="kategoriBrg" name="txtKategoriBrg" placeholder="Kategori Barang">
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="jenisBrg">Jenis</label>
					</div>
					<div class="col-75">
						<input type="text" id="jenisBrg" name="txtJenisBrg" placeholder="Jenis Barang">
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="editAbleVal">Editable Val</label>
					</div>
					<div class="col-75">
						<input type="text" id="editAbleVal" name="txtEditAbleVal" placeholder="Value">
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="isAktif">Actived</label>
					</div>
					<div class="col-75">
						<select id="isAktif" name="txtIsAktif">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="isUsed">Is Used</label>
					</div>
					<div class="col-75" style="display: none">
						<select id="isUsed" name="txtIsUsed">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
				</div>
				<div class="row" >
					<div class="col-25">
						<label for="postId">PostId</label>
					</div>
					<div class="col-75">
						<select id="postId" name="txtPostId">
							<option value="29">29</option>
							<option value="5x">5x</option>
						</select>
					</div>
				</div>
				<div class="row">
					<button type="button" class="button1"  onClick="simpanData()" style="float: right;" >Simpan</button>
				</div>
				<div class="row">
					<label for="note">Catatan :</label>
					<label for="isiNote">* : Pastikan semua label isian/input terisi </label>
					<label for="isiNote">** : Isi dengan tanda (-) jika label isian/input memang kosong </label>
				</div>
			</div>
		</form>
	</div>
	<div id="tabs-2">
		<div id="update" >
			<form name="h1form" method="post" class="frmInput">
				<label id="Data"></label>
				<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
				<div class="container">
					<div class="row" id="tblData">
						<div class="col-25" align="right">
							<label class="lblContainer" for="filterByItemBarang">Filter By Item Barang
								<input type="checkbox" id="filterByItemBarang" onchange="getData('1')" checked="checked" value="Filter By Nama">
								<span class="checkmark"></span>
							</label>
						</div>
						<div class="col-50">
							<input type="text" id="txtItemBarang" name="txtItemBarang" class="cari" placeholder="Cari Barang">		
						</div>
						<div class="col-25">	
							<button type="button"  class="button1" id="cariNama"  onClick="getData('1')"> Cari</button>	
						</div>
					</div>
					<div id="tabelUser">
						<table width="100%">
							<tr><td>
								<div id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>
							</td></tr>
						</table>
						<table id="tblBarang" style="width:100%" >
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
					<textarea name="buffer_1" cols=50 rows=10 class="textBuff"></textarea>
				</div>
				
			</form>
		</div>
		<div align="center">
			<label id="test"></label><br>
		</div>
	</div>
</div>
<script>
 
 $(function() {
	$('#loading').ajaxStart(function(){
		$(this).fadeIn();
	}).ajaxStop(function(){
		$(this).fadeOut();
	});
});

</script>
<?php
$this->layout='popup';
echo $this->Html->script('h1popupmasterbarangold.js');
echo $this->Html->script('resample.js');
?>
<script type='text/javascript'>
	var obj_caller =parent.opener;
	var btnAksi="";
	var btnAksi=obj_caller.$("#btnAksi").val().split("|");
	var result1=btnAksi[0];
	var	result2=btnAksi[1];
	var	result3=btnAksi[2];
</script>
<style type="text/css">
	body{background-color:#FFF !important}
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	button{ background-color: #4CAF50;width:80px;border: none;border-radius: 5px;color: white;padding: 5px 8px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;-webkit-transition-duration: 0.4s; /* Safari */ transition-duration: 0.4s; cursor: pointer;}
	button:disabled,
	button[disabled]{border: 1px solid #999999;background-color: #cccccc; color: #666666;}
	.button1 {background-color: white; color: #008CBA; border: 2px solid #008CBA;}
	.button1:hover {background-color: #008CBA;color: white;}

	
	.frmInput{width: 100%;padding: 6px;border: 1px solid #ccc;border-radius: 4px; }
	.header {overflow: hidden;background-color: #f1f1f1;padding: 20px 10px;}
	input[type=text], select, textarea{width: 100%;padding: 6px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;resize: vertical;}
	/* Style the label to display next to the inputs */
	/* Floating column for labels: 25% width */
	.col-25 {float: left; width: 25%;margin-top: 8px;}

	/* Floating column for inputs: 75% and 50% width */
	.col-75 {float:left;width:75%;margin-top: 6px;}
	.col-50 {float:left;width:50%;margin-top: 6px;margin-bottom:6px;}
	/* Clear floats after the columns */
	.row:after {content: "";display: table;clear: both;}
	.cari{width: 130px;box-sizing: border-box;border: 2px solid #ccc;border-radius: 4px;font-size: 16px;background-color: white;background-image: url('searchicon.png');background-position: 10px 10px; background-repeat: no-repeat;padding: 12px 20px 12px 40px;-webkit-transition: width 0.4s ease-in-out;transition: width 0.4s ease-in-out;}

	/*css autocomplate*/
	.autocomplete {/*the container must be positioned relative:*/position: relative;display: inline-block;}
	.autocomplete-items {border-radius: 4px;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer;position: absolute;border-bottom: none;border-top: none;z-index: 99;/*position the autocomplete items to be the same width as the container:*/top: 100%;left: 0;right: 0;max-height: 221px;overflow-y: scroll;top: 30px;}
	.autocomplete-items div {padding: 10px;cursor: pointer;background-color: cornsilk;border-bottom: 1px solid #d4d4d4;}
	.autocomplete-items div:hover {/*when hovering an item:*/background-color: #e9e9e9;}
	.autocomplete-active {/*when navigating through the items using the arrow keys:*/ background-color: DodgerBlue !important;color: #ffffff;}
	/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
	@media screen and (max-width: 100%) {
		.col-25, .col-75, input[type=submit] {width: 100%;margin-top: 0;}
		}
</style>
<form class="frmInput" name="masterBarangForm" method="post" style="width:100%; background-color:#FFF !important;" >
	<header>Master Barang Form</header>
	<div class="container">
				<div class="row">
					<div class="col-25">
						<label for="namaBrg">Nama Barang *</label>
					</div>
					<div class="col-75">
						<input type="text" id="namaBrg" name="txtNamaBrg" placeholder="Nama Barang" disabled='disabled'>
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-25">
						<label for="group">Group</label>
					</div>
					<div class="col-75">
					<input type="text" id="group" name="txtGroup" readonly>
						<!-- <select id="group" name="txtGroup">
							<option value="INVENTARIS">INVENTARIS</option>
							<option value="ATK">ATK</option>
							<option value="PROMOSI">PROMOSI</option>
						</select> -->
					</div>
				</div>
				<div class="row" style="display: block">
					<div class="col-25">
						<label for="kategoriBrg">Kategori</label>
					</div>
					<div class="col-75">
						<select id="kategoriBrg" name="txtKategoriBrg" onChange="getJenis()"></select>
						<!-- <input type="text" id="kategoriBrg" name="txtKategoriBrg" placeholder="Kategori Barang"> -->
					</div>
				</div>
				<div class="row" style="display: block">
					<div class="col-25">
						<label for="jenisBrg">Jenis</label>
					</div>
					<div class="col-75">
						<select id="jenisBrg" name="txtJenisBrg"></select>
						<!-- <input type="text" id="jenisBrg" name="txtJenisBrg" placeholder="Jenis Barang"> -->
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
					<div class="col-75">
						<select id="isUsed" name="txtIsUsed">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
				</div>
				<div class="row"  style="display: none">
					<div class="col-25">
						<label for="postId">PostId</label>
					</div>
					<div class="col-75">
						<input type="text" id="postNama" readonly>
						<!-- <select id="postId" name="txtPostId"></select> -->
						<input type="text" id="postId" name="txtPostId" style="display:none">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="txtStockMinimum">Stok Minimum</label>
					</div>
					<div class="col-75">
						<input type="text" id="txtStockMinimum" name="txtStockMinimum" onkeyup="upAngka(this)" disabled='disabled'>
					</div>
				</div>

				<!-- tambah satuan -->
				<div class="row">
					<div class="col-25">
						<label for="deskripsi">Satuan</label>
					</div>
					<div class="col-75">
						<div class="autocomplete" style="min-width:200px;width:100%">
							<input type="text" class='input' id="txtSatuan" name="txtSatuan" placeholder="Satuan" disabled='disabled'>
						 </div>
						 <input type="hidden" id="satCek" name="satCek" placeholder="satCek">
					</div>
				</div>

                <div class="row" id="uploadGambar">
					<div class="col-50">
						<label for="txtStockMinimum">Upload Gambar</label>
					</div>
					<div class="col-75">
						<input id="width" type="text" value="320" style="width:15%; display:none;" />
  						<input id="height" type="text" value="320" style="width:15%; display:none;"/>
                        <input id="namagambar" name="namagambar" type="text" style="display:none;"/>
                        <input id="file" type="file" style="text-wrap:normal; text-align:center" disabled='disabled' />
                        <br /><span id="message"></span><br />
  						<div id="img" style="text-wrap:normal; text-align:center"></div>
					</div>
				</div>
				<!-- master stok -->
				<header class="ShowSA" style="margin-top: 6px;">Stok Awal</header>
				<div class="row ShowSA" style="border-bottom:1px solid #333;padding-bottom:5px;">
					<div class="col-100"> <label>*Kolom Stok Awal diinputkan sekali diawal</label></div>
					<div class="col-100"> <label>*Kosongkan jika tidak ada isian</label></div>
				</div>
				<div class="row ShowSA">
					<div class="col-25">
						<label for="txtSAMasuk">Jumlah</label>
					</div>
					<div class="col-75">
						<input type="text" id="txtSAMasuk" name="txtSAMasuk" onkeyup="upAngka(this)">
					</div>
				</div>
				
				<div class="row ShowSA">
					<div class="col-25">
						<label for="txtStockMinimum">Keterangan</label>
					</div>
					<div class="col-75">
						<textarea rows="3" id="txtKeterangan" name="txtKeterangan" ></textarea>
					</div>
				</div>
				<div class="row" align="center">
					<input type="text" name="txtItemId" id="itemid" style="display:none ">
					<input type="text" name="txtBtnAksi" id="btnAksi" style="display: none">
					<button type="button" class="button1"  onClick="editData()" id="btnEdit">Edit</button>
					<button type="button" class="button1"  onClick="simpanData()" id="btnSimpan" >Simpan</button>
				</div>
				<div class="row">
					<label for="note">Catatan :</label>
					<label for="isiNote">* : Pastikan semua label isian/input bertanda ( * ) terisi </label>
				</div>
			</div>
			
</form>
<script src="resample.js"></script>
 <script>
 (function (global, $width, $height, $file, $message, $img) {
  
  // (C) WebReflection Mit Style License
  
  // simple FileReader detection
  if (!global.FileReader)
   // no way to do what we are trying to do ...
   return $message.innerHTML = "FileReader API not supported"
  ;
  
  // async callback, received the
  // base 64 encoded resampled image
  function resampled(data) {
   $message.innerHTML = "done";
   ($img.lastChild || $img.appendChild(new Image)
   ).src = data;
   kirimdata(data);
  }
  
  // async callback, fired when the image
  // file has been loaded
  function load(e) {
   $message.innerHTML = "resampling ...";
   // see resample.js
   Resample(
     this.result,
     this._width || null,
     this._height || null,
     resampled
   );
   
  }
  
  // async callback, fired if the operation
  // is aborted ( for whatever reason )
  function abort(e) {
   $message.innerHTML = "operation aborted";
  }
  
  // async callback, fired
  // if an error occur (i.e. security)
  function error(e) {
   $message.innerHTML = "Error: " + (this.result || e);
  }
  
  // listener for the input@file onchange
  $file.addEventListener("change", function change() {
   var
    // retrieve the width in pixel
    width = parseInt($width.value, 10),
    // retrieve the height in pixels
    height = parseInt($height.value, 10),
    // temporary variable, different purposes
    file
   ;
   // no width and height specified
   // or both are NaN
   if (!width && !height) {
    // reset the input simply swapping it
    $file.parentNode.replaceChild(
     file = $file.cloneNode(false),
     $file
    );
    // remove the listener to avoid leaks, if any
    $file.removeEventListener("change", change, false);
    // reassign the $file DOM pointer
    // with the new input text and
    // add the change listener
    ($file = file).addEventListener("change", change, false);
    // notify user there was something wrong
    $message.innerHTML = "please specify width or height";
   } else if(
    // there is a files property
    // and this has a length greater than 0
    ($file.files || []).length &&
    // the first file in this list 
    // has an image type, hopefully
    // compatible with canvas and drawImage
    // not strictly filtered in this example
    /^image\//.test((file = $file.files[0]).type)
   ) {
    // reading action notification
    $message.innerHTML = "reading ...";
    // create a new object
    file = new FileReader;
    // assign directly events
    // as example, Chrome does not
    // inherit EventTarget yet
    // so addEventListener won't
    // work as expected
    file.onload = load;
    file.onabort = abort;
    file.onerror = error;
    // cheap and easy place to store
    // desired width and/or height
    file._width = width;
    file._height = height;
    // time to read as base 64 encoded
    // data te selected image
    file.readAsDataURL($file.files[0]);
    // it will notify onload when finished
    // An onprogress listener could be added
    // as well, not in this demo tho (I am lazy)
   } else if (file) {
    // if file variable has been created
    // during precedent checks, there is a file
    // but the type is not the expected one
    // wrong file type notification
    $message.innerHTML = "please chose an image";
   } else {
    // no file selected ... or no files at all
    // there is really nothing to do here ...
    $message.innerHTML = "nothing to do";
   }
  }, false);
 }(
  // the global object
  this,
  // all required fields ...
  document.getElementById("width"),
  document.getElementById("height"),
  document.getElementById("file"),
  document.getElementById("message"),
  document.getElementById("img")
 ));
 </script>
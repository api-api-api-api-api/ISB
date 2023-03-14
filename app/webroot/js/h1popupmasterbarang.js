
$(document).ready(function () {
	onLoadHandler();
});
 function onLoadHandler() {
	getData(result1,result2);
}
function getData(aksi,itemid){
	
	if(result3=="ATK"){
		document.getElementById('uploadGambar').style.display=''
		
		}else{
		document.getElementById('uploadGambar').style.display=''
		//document.getElementById('uploadGambar').style.display='none'
		
		}
	
	if(aksi=='Tambah' && itemid=='Null'){
		getPostId(aksi+'^'+result3);
		//console.log($('#postNama').val());
		getKategori();
		getJenis();
		//satuan('');
		$('#group').val(result3);
		$('#btnAksi').val(aksi);
		$('#itemid').val(itemid);
		$("#btnEdit").hide();
		$("#btnSimpan").show();
		if(result3=="PROMOSI"){
			$(".showSA").hide();
		}else{
			$(".showSA").show();
		}
		//autocomplete(document.getElementById("txtSatuan"), selectSatuan(''));
		selectSatuan('')
		return;
	}else{
		//getPostId();
		//getKategori();
		//getJenis();
		
		$('#btnAksi').val(aksi);
		$('#itemid').val(itemid);
		
		$("#btnEdit").show();
		$("#btnSimpan").hide();
		$(".showSA").hide();
		var url = 'Popupmasterbarangs/getDataIsi';
			//call jQuery AJAX function
		$.ajax({
			url: url,
			type: "POST",
			data: ({itemid:itemid}),
			dataType: "text",
			success: function(result){
				//console.log(result)
			var dataParse=JSON.parse(result)
			//console.log(dataParse)
			getPostId(aksi+'^'+dataParse[0].mbr.postId);
			getKategori(dataParse[0].mbr.kategoriId);
			getJenis(dataParse[0].mbr.jenisId);
			//satuan(dataParse[0].mbr.satuan)
			$("#namaBrg").val(dataParse[0].mbr.namaBarang)//namabarang input
			$("#labelNamaBarang").text(dataParse[0].mbr.namaBarang)//namabarang label
			//$("#kategoriBrg").val(dataParse[0].mbr.kategori)
			//$("#jenisBrg").val(dataParse[0].mbr.jenis)
			$("#group").val(dataParse[0].mbr.group)
			$("#editAbleVal").val(dataParse[0].mbr.editableVal)
			$("#isAktif").val(dataParse[0].mbr.isAktif)
			$("#isUsed").val(dataParse[0].mbr.isUsed)
			$("#txtStockMinimum").val(dataParse[0].mbr.stokMinimal);//stok barang input
			$("#labelStokMinimum").text(dataParse[0].mbr.stokMinimal);//stok minimum label
			$("#txtSatuan").val(dataParse[0].mbr.satuan);//satuan input
			$("#labelSatuan").text(dataParse[0].mbr.satuan);//satuan label
			$(".input").hide();
			$(".labelForm").show();
			//$("input").prop('disabled', true);
			$("select").prop('disabled', true);
			if(dataParse[0].mbr.namafile==''||dataParse[0].mbr.namafile==null){
				filegambar="";
			}else{
				filegambar="<img src='masterbarang/"+dataParse[0].mbr.namafile+"'>";
				}
			
			$("#img").html(filegambar)
			$("#namagambar").val(dataParse[0].mbr.namafile)
			selectSatuan('')
			// $('#jenisBrg option').removeAttr("selected");
			// $("#jenisBrg option[value='"+dataParse[0].mbr.jenisId+"']").attr("selected", "selected")
			// $('#kategoriBrg option').removeAttr("selected");
			// $("#kategoriBrg option[value='"+dataParse[0].mbr.kategoriId+"']").attr("selected", "selected")
			// $("#postId option").removeAttr("selected");
			// $("#postId option[value='"+dataParse[0].mbr.postId+"']").attr("selected", "selected")
			}
		});	
	}
}
function getKategori(data){
	var groupFPB=result3
	//alert(groupFPB)
	var url = 'Popupmasterbarangs/getKategori';
	$.ajax({
			url: url,
			type: "POST",
			data:({id:data,groupFPB:groupFPB}),
			dataType: "text",
			async:false,
			success: function(result){
			//console.log(result);return
			//	console.log(result);return
			// let data=[];
			// data.push("<option value='' selected='selected'>Pilih Kategori</option>");
  			// $.each(JSON.parse(result), function(index, eachRow ) {
			// 	data.push("<option value='"+eachRow['kategoribarangs']['id']+"'>"+eachRow['kategoribarangs']['nama']+"</option>")
			// 	//console.log(eachRow['postids']['namaPost']);
			// });
			document.getElementById('kategoriBrg').innerHTML=result;	
			// /$('#kategoriBrg').find('option').remove().end().append(data)
		}
	});	
}

function getJenis(data){
	var idKategori=$("#kategoriBrg").val();
	//alert(data+'-'+idKategori)
	var url = 'Popupmasterbarangs/getJenis';
	$.ajax({
			url: url,
			type: "POST",
			data:({id:data,idKategori:idKategori}),
			dataType: "text",
			async:false,
			success: function(result){
			//console.log(result);return
			document.getElementById('jenisBrg').innerHTML=result;		
			// let data=[];
			// data.push("<option value='' selected='selected'>Pilih Jenis</option>");
  			// $.each(JSON.parse(result), function(index, eachRow ) {
			// 	data.push("<option value='"+eachRow['jenisbarangs']['id']+"'>"+eachRow['jenisbarangs']['nama']+"</option>")
			// 	//console.log(eachRow['postids']['namaPost']);
			// });
			// $('#jenisBrg').find('option').remove().end().append(data)
		}
	});	
}
function getPostId(data){
	
	var resData = data.split("^");
	var aksi=resData[0];
	var postData=resData[1];
	
	var url = 'Popupmasterbarangs/getPostId';
	$.ajax({
			url: url,
			type: "POST",
			data:({aksi:aksi,postData:postData}),
			dataType: "text",
			//async:false,
			success: function(result){
				//console.log(result);
				result=result.split("^");
				//console.log(result);
				document.getElementById('postNama').value=result[1];	
				document.getElementById('postId').value=result[0];	
				return
			//console.log(result);return;
			// let data=[];
			// data.push("<option value='' selected='selected'>Pilih Postid</option>");
  			// $.each(JSON.parse(result), function(index, eachRow ) {
			// 	data.push("<option value='"+eachRow['postids']['postId']+"'>"+eachRow['postids']['namaPost']+"</option>")
			// 	//console.log(eachRow['postids']['namaPost']);
			// });
			//document.getElementById('postId').value=result;	
			//$('#postId').find('option').remove().end().append(data)
		}
	});	
}

//fungsi satuan
function satuan(val) {
	var dataValue=val;
	var url='Popupmasterbarangs/getSatuan';
	$.ajax({
		url:url,
		data:({dataValue:dataValue}),
		type:'POST',
		dataType:'text',
		success:function(result){
			document.getElementById('txtSatuan').innerHTML=result;		
			//console.log(result)
		}
	})
}

function selectSatuan(data){
    var url = 'Popupmasterbarangs/selectSatuan';
    var id=data
    var satuaniIsi

    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            //console.log(result)
            satuaniIsi=JSON.parse(result);
            autocomplete(document.getElementById("txtSatuan"),  satuaniIsi);
            
        }
    });	
    //return satuaniIsi;
}
function editData(){
	// $("input").prop('disabled', false);
	$("select").prop('disabled', false);
	$(".input").show();
	$(".labelForm").hide();

	if($("#txtSatuan").val()==''){
		$("#txtSatuan").prop('disabled', false);
		$("#satCek").val(0)
	}else{
		$("#txtSatuan").prop('disabled', true);
		$("#satCek").val(1)
	}

	$("#btnEdit").hide();
	$("#btnSimpan").show();
}

function simpanData(){
	if($("#namaBrg").val()==''||$("#namaBrg").val()==null){
		alert ('Nama Barang kosong');
		$("#namaBrg").focus();
		return;
	}
	// if($("#kategoriBrg").val()==''||$("#kategoriBrg").val()==null){
	// 	alert ('kategori Barang harap diisi');
	// 	$("#kategoriBrg").focus();
	// 	return;
	// }
	// if($("#jenisBrg").val()==''||$("#jenisBrg").val()==null){
	// 	alert ('jenis Barang harap diisi');
	// 	$("#jenisBrg").focus();
	// 	return;
	// }
	// if($("#editAbleVal").val()==''||$("#editAbleVal").val()==null){
	// 	alert ('Editable Val  masih kosong');
	// 	$("#editAbleVal").focus();
	// 	return;
	// }
	//if($("#postId").val()==''||$("#postId").val()==null){
//		alert ('Postid masih kosong');
//		$("#postId").focus();
//		return;
//	}

	if($("#txtSatuan").val()==''){
			alert('Satuan tidak boleh kosong');
			$("#txtSatuan").focus();
			return
		}
	
	var question =confirm('Apakah data yang ada sudah benar?');
	if(question){
		var data = $("form[name=masterBarangForm]").serializeArray();
		
		var url = 'Popupmasterbarangs/saveData';
		//console.log(data);
		$.ajax({
			url: url,
			type: "POST",
			data:data,
			success: function(result){
				 //console.log(result);
				// return
				if (result=='notNull'){
					alert('Data Item Barang sudah ada,\nCek kembali inputan barang yang Anda inputkan!');
					$("#namaBrg").focus();
					return;
				}
				if(result=='simpan'){
					
					alert('Data berhasil di simpan !');
					obj_caller.window.location.reload();
					parent.window.close();
				}
				if(result=='update'){
					alert('Data berhasil di Update !');
					//window.location.reload();
					obj_caller.window.location.reload();
					parent.window.close();
					
				}
					
	      }
		})
	}

}


//function tambahan
function formatNumberField(str) {
    // unformat the value
    var value = str.value.replace(/[^\d,]/g, '');
    // split value into (leading digits, 3*x digits, decimal part)
    // also allows numbers like ',5'; if you don't want that,
    // use /^(\d{1,3})((?:\d{3})*))((?:,\d*)?)$/ instead
    var matches = /^(?:(\d{1,3})?((?:\d{3})*))((?:,\d*)?)$/.exec(value);
    if (!matches) {
        // invalid format; deal with it however you want to
        // this just stops trying to reformat the value
        return;
    }
    // add a space before every group of three digits
    var spaceified = matches[2].replace(/(\d{3})/g, '.$1');

    // now splice it all back together
    str.value = [matches[1], spaceified, matches[3]].join('');
	
}
function upAngka(str){

	if(str.value=="-"){
		str.value=0;
		}
	if(parseInt(str.value)<0){
		str.value=str.value*(-1);
		}
	var re = /^[0-9-',']*$/;
	if (!re.test(str.value)) {
		str.value = str.value.replace(/[^0-9-',']/g,"");		
	}
	if(str.value==""||str.value=="NaN"){
		str.value=""
	}else{
	//str.value=formatCurrency(str.value,",",".", 2)
	formatNumberField(str);
	}

}
function kirimdata(gambar){
  
  
  var id=document.getElementById('itemid').value;
  
  var aksi=$('#btnAksi').val();
  var id=$('#itemid').val();
  
  $.ajax({
        type: "POST",
        url: 'Popupmasterbarangs/kirimData',
        data: {gambar:gambar,id:id,aksi:aksi},
        success: function (returnedVal) {
        //alert(returnedVal);
		document.getElementById('namagambar').value=returnedVal;
        },
        error: function (err) {
            // handle your error logic here
        }


    });
}

//function autocomplate input in text
function autocomplete(inp, arr) {
	
  /*fungsi autocomplate membutuhkan dua argumen, yang pertama argumen text field dan yang ke2 array autocomplate value*/
  var currentFocus;
  /*menjalankan fungsi ketika menulis text:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
	  //console.log( arr.length);
      for (var i = 0; i < arr.length; i++) {
      	//console.log(arr[i])
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
		  
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}


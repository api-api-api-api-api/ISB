
$(document).ready(function () {
	onLoadHandler();
});
 function onLoadHandler() {
	 var url = 'Popupmastersuppliers/onLoadHandler';
		//call jQuery AJAX function
		$.ajax({
			url: url,
			type: "POST",
			data: ({}),
			dataType: "text",
			success: function(result){
			result=result.split("!")
	 		document.getElementById('jenisUsaha').innerHTML=result[0]
			document.getElementById('bank').innerHTML=result[1]
			getData(result1,result2);
			
		}});
}
function getData(aksi,supid){
	
	if(aksi=='Tambah' && supid=='Null'){
		$('#btnAksi').val(aksi);
		$('#supid').val(supid);
		$("#btnEdit").hide();
		$("#btnSimpan").show();
		//SetAutoCompleteDeskripsi('')
		selectDeskripsi('')
		return;
	}else{
		$('#btnAksi').val(aksi);
		$('#supid').val(supid);
		$("input").prop('readonly', true);
		$("select").prop('disabled', true);
		$("#btnEdit").show();
		$("#btnSimpan").hide();
		var url = 'Popupmastersuppliers/getDataIsi';
		//call jQuery AJAX function
		$.ajax({
			url: url,
			type: "POST",
			data: ({idsupplier:supid}),
			dataType: "text",
			success: function(result){
			var dataParse=JSON.parse(result)
			console.log(dataParse)
			$("#namaSupplier").val(dataParse[0].spl.nama)
			$("#deskripsi").val(dataParse[0].spl.deskripsi)
			$("#alamat").val(dataParse[0].spl.alamat)
			$("#kodePos").val(dataParse[0].spl.kodepos)
			$("#noTelp").val(dataParse[0].spl.notelp)
			$("#noFax").val(dataParse[0].spl.nofax)
			$("#email").val(dataParse[0].spl.email)
			$("#npwp").val(dataParse[0].spl.npwp)
			$("#ppn").val(dataParse[0].spl.denganPPN)
			$("#namaKontak").val(dataParse[0].spl.namaKontak)
			$("#alamatKontak").val(dataParse[0].spl.alamatKontak)
			$("#noHpKontak").val(dataParse[0].spl.noHPKontak)
			$("#emailKontak").val(dataParse[0].spl.emailKontak)
			$("#jabatanKontak").val(dataParse[0].spl.jabatanKontak)
			$("#bank").val(dataParse[0].spl.idBank+"|"+dataParse[0].spl.namaBank)
			$("#alamatBank").val(dataParse[0].spl.alamatBank)
			$("#norek").val(dataParse[0].spl.noRekening)
			$("#atasNama").val(dataParse[0].spl.atasNamaRekening)
			$("#tos").val(dataParse[0].spl.TOS)
			$("#keteranganTos").val(dataParse[0].spl.keteranganTOS)
			$("#statusSupplier").val(dataParse[0].spl.status)
			$("#jenisUsaha").val(dataParse[0].spl.jenisUsaha)
			//SetAutoCompleteDeskripsi(dataParse[0].spl.deskripsi)
			selectDeskripsi('');
			}
		});	
	}

	
}

//auto complate deskripsi
function SetAutoCompleteDeskripsi(val){
	//alert('test')
    var data=val
    var deskripsiisi
    if(data==''){
        deskripsi=[];
    }else{
        //console.log(data);return
        //data = data.split(",");
        //console.log(data);return
        deskripsiisi=data;

    }
    var deskripsiData=selectDeskripsi('');

    //console.log(divisiIsi);return  
    $("#txtDeskripsiSelectPure").html('');
    //console.log(divisiData);
    var autocomplete = new SelectPure("#txtDeskripsiSelectPure", {
        options: deskripsiData,
        placeholder: "-Please select-",
        icon: "fa fa-times",
        value: deskripsiisi,
        multiple: false,
        autocomplete: true,
        onChange: value => {
            $("#deskripsi").val('');
            $("#DeskripsiDipilih").val('');
            if(value.length==0){

            }else{
                $("#deskripsi").val(value);
                var dataDivSplit=$("#divisiDipilih").val().split(",");
               
            }
            
        },
        
    })

}
//fungsi get deskripsi
function selectDeskripsi(data){
    var url = 'Popupmastersuppliers/selectDeskripsi';
    var id=data
    var deskripsiIsi
    var deskripsiIsiA2
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            //console.log(result)
            deskripsiIsi=JSON.parse(result);
            autocomplete(document.getElementById("deskripsi"), deskripsiIsi);
        }
    });	
    //return deskripsiIsi;
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


//fungsi edit
function editData(){
	$("input").prop('readonly', false);
	$("select").prop('disabled', false);
	$("#btnEdit").hide();
	$("#btnSimpan").show();
}

//fungsi simpan (tambah maupun edit)
function simpanData(){
	if($("#namaSupplier").val()==''||$("#namaSupplier").val()==null){
		alert ('Nama masih kosong');
		$("#namaSupplier").focus();
		return;
	}
	if($("#deskripsi").val()==''||$("#deskripsi").val()==null){
		alert ('Deskripsi harap diisi');
		$("#deskripsi").focus();
		return;
	}
	if($("#alamat").val()==''||$("#alamat").val()==null){
		alert ('alamat harap diisi');
		$("#alamat").focus();
		return;
	}
	if($("#noTelp").val()==''||$("#noTelp").val()==null){
		alert ('No. Telepon harap diisi');
		$("#noTelp").focus();
		return;
	}
	if($("#ppn").val()==''){
		alert ('Dengan PPN harap di Pilih');
		//$("#noTelp").focus();
		return;
	}
	if($("#jenisUsaha").val()==''){
		alert ('Jenis Usaha harap di Pilih');
		//$("#noTelp").focus();
		return;
	}
	
	if($("#namaKontak").val()==''||$("#namaKontak").val()==null){
		alert ('Nama penanggung jawab harap diisi');
		$("#namaKontak").focus();
		return;
	}
	if($("#noHpKontak").val()==''||$("#noHpKontak").val()==null){
		alert ('nomor penanggung jawab jawab harap diisi');
		$("#noHpKontak").focus();
		return;
	}
	if($("#jabatanKontak").val()==''||$("#jabatanKontak").val()==null){
		alert ('Jabatan penaggung jawab harap diisi');
		$("#jabatanKontak").focus();
		return;
	}

	var question =confirm('Apakah data yang ada sudah benar?');
	if(question){
		var data = $("form[name=masterSupplierForm]").serializeArray();
		var url = 'Popupmastersuppliers/saveData';
		//console.log(data);
		$.ajax({
			url: url,
			type: "POST",
			data:data,
			success: function(result){
				//console.log(result);return;
				if (result=='notNull'){
					alert('Supplier sudah ada,\nCek kembali inputan :\nnama, alamat, dan nomor telepon supplier yang anda inputkan!');
					$("#namaSupplier").focus();
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
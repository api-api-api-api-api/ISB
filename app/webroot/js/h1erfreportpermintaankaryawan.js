$(document).ready(function(e){
    onloadHandler();
})

function onloadHandler(){
    getData();
}

function getData(hal){

    //filter
    var tahun=document.getElementById("tahun").value;
    var bulan=document.getElementById("bulan").value;
    var reportPermintaan=document.getElementById("reportPermintaan").value;
    document.h1form.buffer.value="";
    var url="Erfreportpermintaankaryawans/getData"
    $.ajax({
        url:url,
        type:'POST',
        dataType:'Text',
        data:({tahun:tahun,bulan:bulan,reportPermintaan:reportPermintaan}),
        success:function(returnedValue){
            //console.log(returnedVal);return

            document.h1form.buffer.value=returnedValue;
			returnedValue=returnedValue.split("!");
			
			if(returnedValue[0]==0 || returnedValue[0]==""){

				alert("Data tidak ditemukan");
                $('#tableListPengajuan tbody').html("<tr><td colspan='10' align='center'>Data Kosong</td></tr>");
				var trFood="<tr class='active'><th colspan='3'>Jumlah</th><th>0</th><th>0</th><th>0</th><th>0</th><th>0</th><th>0</th></tr>";
				$('#tableListPengajuan tfoot').html(trFood);
                return
			}
						
			$('#tableListPengajuan tbody').html("");
			var tr="";
			var reportPermintaanKaryawan=returnedValue[0];
			reportPermintaanKaryawan=reportPermintaanKaryawan.substr(0,reportPermintaanKaryawan.length -1).split('^')
			//console.log(reportPermintaanKaryawan)
			for(var i=0;i<reportPermintaanKaryawan.length;i++){
				var splitPerRow=reportPermintaanKaryawan[i].split('|');
				//console.log(splitPerRow);
				var td="";
				td+="<th class='tdisi column"+1+"' scope='row'>"+splitPerRow[1]+"</th>";
				td+="<td class='tdisi column"+2+"'>"+splitPerRow[2]+"</td>";
				td+="<td class='tdisi column"+3+"'>"+splitPerRow[3]+"</td>";
				td+="<td class='tdisi column"+4+"'>"+splitPerRow[4]+"</td>";
				td+="<td class='tdisi column"+5+"'>"+splitPerRow[5]+"</td>";
				td+="<td class='tdisi column"+6+"'>"+splitPerRow[6]+"</td>";
				td+="<td class='tdisi column"+7+"'>"+splitPerRow[7]+"</td>";
				td+="<td class='tdisi column"+8+"'>"+splitPerRow[8]+"</td>";

				// splitPerRow.forEach(function(data,index) {
				// 	var colum='';
				// 	var indexTampil=[2,3,5,12,40,11,13,19,26,16,18,22,24,25,6,23];
				// 	if(indexTampil.includes(index)){
				// 		colum=index+1;
				// 		td+="<td class='tdisi column"+colum+"'>"+data+"</td>";
				// 	}
							
				// });	
				tr+="<tr><th scope='row'>"+splitPerRow[0]+"</th>"+td+"</tr>";
			}
            var trFood="<tr class='active'><th colspan='3'>Jumlah</th><th>"+returnedValue[1]+"</th><th>"+returnedValue[2]+"</th><th>"+returnedValue[3]+"</th><th>"+returnedValue[4]+"</th><th>"+returnedValue[5]+"</th><th>"+returnedValue[6]+"</th></tr>"
			$('#tableListPengajuan tbody').html(tr);
            $('#tableListPengajuan tfoot').html(trFood);

        }
    })
}

function cetakexcel(format){

    if (document.h1form.buffer.value.length==0){
		//parent.openDialog("Peringatan", "Ambil Data terlebih dahulu", 320, 150, "alert", "dialog");return;
		alert("Ambil Data terlebih dahulu");
		return;
	}
	else{
		if(format=="excel"){
			document.h1form.action='Erfreportpermintaankaryawans/cetakexcel';
		}
		else{
			document.h1form.action='Erfreportpermintaankaryawans/cetakhtml';
		}
		document.h1form.target='_blank';
	}
	document.h1form.submit();

    // var tahun=document.getElementById("tahun").value;
    // var bulan=document.getElementById("bulan").value;
    // var reportPermintaan=document.getElementById("reportPermintaan").value;

    // var url='Erfreportpermintaankaryawans/cetakexcel';
    // window.open("Erfreportpermintaankaryawans/cetakexcel?tahun="+tahun+"&bulan="+bulan+"&reportPermintaan="+reportPermintaan);


}
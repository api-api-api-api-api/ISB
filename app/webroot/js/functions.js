var pesan=new Array();
var theme="myCust";
pesan[1]="Kolom ini wajib diisi";
pesan[2]="Harap isi ";
pesan[3]="Harap tentukan ";
pesan[4]="Harap pilih ";
pesan[5]="Nilai harus berupa angka";
pesan[6]="Record ini tidak dapat dihapus";
pesan[7]="Dana berhasil dimutasikan";
pesan[8]="Data berhasil disimpan";
pesan[9]="Proses approval berhasil";
pesan[10]="Proses kirim dana berhasil";
pesan[11]="Data sudah ada";
pesan[12]="Form belum lengkap";
pesan[13]="Tidak ada item terpilih";
pesan[14]="Source tidak boleh sama dengan target";
pesan[15]="Proses copy akan menimpa status dana pada target Maker.<br/>Apakah anda ingin melanjutkan?";
pesan[16]="Source Maker tidak mempunyai status dana, proses copy tidak dapat dilakukan";
pesan[17]="Proses copy workflow berhasil";
pesan[18]="Harap periksa kembali apakah nilai transaksi sudah benar.<br/>Apakah anda ingin melanjutkan?";
pesan[19]="Item di nota ini telah terealisasi semuanya";
pesan[20]="Tidak ada dana DPPU baru";
pesan[21]="Anda belum melakukan entry saldo awal, <br/>pengambilan DPPU blm bisa dilakukan";
pesan[22]="Apakah anda yakin ingin keluar dari program?";
pesan[23]="Data yang ingin diedit belum dipilih";
pesan[24]="Tidak bisa menambah periode";
pesan[25]="Proses mutasi tidak dapat dilakukan karena anda masih punya sisa dana di kasir<br/>Dana dari kasir harus di mutasikan dulu sepenuhnya";
pesan[26]="Proses ini akan memutasikan seluruh dana ke arco lain.<br/>Apakah anda ingin melanjutkan?";
pesan[27]="Jumlah mutasi tidak boleh melebihi Saldo";
pesan[28]="Bulan pengiriman terkunci. anda tidak dapat melakukan pengiriman di bulan tsb";
pesan[29]="Ada nilai pengiriman yg tidak sesuai limit saldo, lakukan adjust nilai.";
pesan[30]="Lengkapi dulu data rekening tujuan";
pesan[31]="Harap periksa kembali apakah nilai pengiriman sudah benar.<br/>Proses pengiriman hanya dapat dilakukan satu kali.<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apakah anda ingin melanjutkan?";
pesan[32]="Harap periksa kembali apakah nilai realisasi sudah benar.<br/>Proses realisasi hanya dapat dilakukan satu kali.<br/>Apakah anda ingin melanjutkan?";
pesan[33]="No nota tidak ditemukan atau sudah terealisasi";
pesan[34]="Harap periksa kembali apakah nilai approval sudah benar.<br/>Proses approval hanya dapat dilakukan satu kali.<br/>Apakah anda ingin melanjutkan?";
pesan[35]="Maaf..total nilai pengeluaran melebihi nilai masuk dari DPPUId tersebut";
pesan[36]="Maaf..saldo anda tidak mencukupi untuk melakukan transaksi";
pesan[57]="Maaf..saldo awal anda tidak mencukupi untuk melakukan transaksi";
pesan[37]="Maaf nilai keluar tidak boleh melebihi Saldo";
pesan[38]="Tidak ada data untuk disimpan";
pesan[39]="Tanggal keperluan tidak mungkin kurang atau sama dengan tanggal sekarang";
pesan[40]="Nilai disetujui tidak boleh melebihi nilai diajukan";
pesan[41]="Item di nota ini telah terealisasi semuanya";
pesan[42]="Anda tidak dapat men set pembebanan pada item yang blm tersimpan";
pesan[43]="Harap pilih item yang akan diset pembebanannya";
pesan[44]="Data sudah tersimpan. System secara default membebankan 100% ke arco, anda bisa merubah melalui tombol set prosentase pembebanan";
pesan[45]="Item di nota ini telah terverifikasi semuanya";
pesan[46]="Nilai realisasi tidak boleh melebihi nilai keluar";
pesan[47]="Update limit untuk record ini tidak dimungkinkan, " +
									"Karena saldo di ARCO lebih besar dari nilai limit " +
									"harus ada penarikan dana dari ARCO";
pesan[48]="Data berhasil diverifikasi";		
pesan[49]="Pengambilan DPPU tidak boleh kurang dari periode Saldo Awal";		
pesan[50]="Periode pengambilan DPPU harus urut/ ada periode yg belum diambil";		
pesan[51]="Untuk realisasi kurang dari 100%, anda harus menentukan sisa akan dikembalikan ke ARCO atau digantung di TP";			
pesan[52]="Nilai realisasi tidak boleh melebihi saldo PA TP";		
pesan[53]="Record ini sudah terrealisasi, anda yakin ingin menghapus?";	
pesan[54]="Tanggal telah terupdate";
pesan[55]="Tidak ada data yang akan diupdate";
pesan[56]="Tidak ada titipan dana untuk arco tersebut";
var curHal=1;
 function prevRec(gridObj,currentRow,cmdPrev,cmdNext) {
	var prevRow=parseFloat(currentRow.value)-1;
	gridObj.setSelectedRows([prevRow]);
	if(prevRow>=0) {
		currentRow.value=prevRow;
		gridObj.setCurrentRow(prevRow);
		//refreshData();
	}
	if(prevRow==0) cmdPrev.disabled=true;
	cmdNext.disabled=false;
 }
 function nextRec(gridObj,currentRow,cmdPrev,cmdNext) {
	var nextRow=parseFloat(currentRow.value)+1;
	gridObj.setSelectedRows([nextRow]);
	if(nextRow<gridObj.getRowCount()) {
		currentRow.value=nextRow;
		gridObj.setCurrentRow(nextRow);
		//refreshData();
	}
	if(nextRow==(gridObj.getRowCount()-1)) cmdNext.disabled=true;
	cmdPrev.disabled=false;
 }

function actionPage(hal){
	curHal=hal;
	document.getElementById('linkHal').innerHTML=createHal(curHal,100,7);
	}
function createHal(curHal,maxHal,jmlTampil){
jmlTampil=parseInt(jmlTampil);
mod=jmlTampil % 2;
if(mod==0){alert('jml yg ditampilkan harus ganjil');return 'jml tampil harus genap, Paging tidak dapat ditampilkan';}
halTengah=Math.round(jmlTampil/2);
curHal=parseInt(curHal);	
var linkHal='';
var angka='';
	if(curHal > 1)
		{
previous=curHal-1;
linkHal=linkHal+"<a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage(1)'> First</a> |&nbsp";
linkHal=linkHal+" <a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage("+ previous +")'> Prev</a> |&nbsp";
			
		}
		else if(curHal.length==0||curHal==1)
		{
			linkHal=linkHal+"First | Previous | ";
		}
		
		for(i=curHal-(halTengah-1);i<curHal;i++)
		{
		  if (i < 1)
			  continue;
		  angka += "<a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage("+ i +")'>"+ i +"</a> ";
		}
		
		angka += " <b>"+ curHal +"</b> ";
		
		for(i=curHal+1;i<(curHal +halTengah);i++)
		{
		  if (i > maxHal)
			  break;
		  angka += "<a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage("+ i +")'>"+ i +"</a> ";
		}
		
		linkHal=linkHal+angka;

		if(curHal < maxHal)
		{
		next=curHal+1;
	     linkHal=linkHal+" | <a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage("+ next +")'>Next </a>&nbsp;|&nbsp;<a style='cursor:pointer; color:#0000FF;text-decoration:underline' onclick='actionPage("+ maxHal +")'>Last</a> ";
		}
		else
		{
			linkHal=linkHal+" | Next | Last ";
		}
	return linkHal;
	}
function inputTextColNumber(index,colNumber){
	txtField="<input type='text' id=colNum"+index+" value="+colNumber +" style='display:none;'>";
	return txtField;
	}
function inputText(index,cls){
	txtField="<input type='text' id=field"+index+" class="+cls+">";
	return txtField;
	}
function inputTahun(index){
	txtField="<select id=field"+index+" class='equal'>"+ 
          "<option value=2009>2009</option>"+
          "<option value=2010>2010</option>"+
          "<option value=2011>2011</option>"+
          "<option value=2012>2012</option>"+
          "<option value=2013>2013</option>"+
          "<option value=2014>2014</option>"+
          "<option value=2015>2015</option>"+
          "</select>";
	 return txtField;
	}
function inputBulan(index){
	txtField="<select id=field"+index+" class='equal'>"+
          "<option value=1>Januari</option>"+
          "<option value=2>Februari</option>"+
          "<option value=3>Maret</option>"+
          "<option value=4>April</option>"+
          "<option value=5>Mei</option>"+
          "<option value=6>Juni</option>"+
          "<option value=7>Juli</option>"+
          "<option value=8>Agustus</option>"+
          "<option value=9>September</option>"+
          "<option value=10>Oktober</option>"+
          "<option value=11>November</option>"+
          "<option value=12>Desember</option>"+
          "</select>";
	return txtField;
	}
function inputEquality(index){
	txtField=" <select style='display:none' id=equality"+index+">"+
          "<option value='=='>==</option>"+
          "<option value='!='>!=</option>"+
          "<option value='>'>></option>"+
          "<option value='<'><</option>"+
          "<option value='>='>>=</option>"+
          "<option value='<='><=</option>"+
          "<option value='like'>like</option>"+
          "</select>";
	return txtField;
	}	
function inputLogic(index){
	txtField="<select style='display:none' id=logic"+index+">"+
	 	"<option value='AND'>AND</option>"+
          "<option value='OR'>OR</option>"+
		  "</select>";
    return txtField;
	}
function addColumn(tblId,tipeField,cls,colNumber)
{
	
	var tblHeadObj = document.getElementById(tblId).tHead;
	jmlKolom=document.getElementById(tblId).getElementsByTagName('tr')[0].getElementsByTagName('th').length;
	indexBaru=parseInt(jmlKolom)+2;
	for (var h=0; h<tblHeadObj.rows.length; h++) {
		var newTH = document.createElement('th');
		tblHeadObj.rows[h].appendChild(newTH);
		
		newTH.setAttribute("id","head"+indexBaru);
		//newTH.setAttribute("id","head"+indexBaru);
		//newTH.width='100px';
		newTH.style.display='none';
		newTH.innerHTML=tipeField; 
		newTH.innerHTML=newTH.innerHTML+"<br><label id=hide"+indexBaru+" onclick=javascript:removeColumn("+tblId+","+indexBaru+");>hide</label"
	}

	var tblBodyObj = document.getElementById(tblId).tBodies[0];
	for (var i=0; i<tblBodyObj.rows.length; i++) {
		var newCell = tblBodyObj.rows[i].insertCell(-1);
		newCell.setAttribute("id","isi"+indexBaru);
		newCell.setAttribute("valign","top");
		newCell.style.display='';
		
		if(tipeField.toUpperCase()=='TAHUN'||tipeField.toUpperCase()=='THN')
		{insertionField=inputTahun(indexBaru);}
		else if (tipeField.toUpperCase()=='BULAN'||tipeField.toUpperCase()=='BLN'){
		 insertionField=inputBulan(indexBaru);	}
		 else{
		 insertionField=inputText(indexBaru,cls);	 
			 }
		newCell.innerHTML =inputTextColNumber(indexBaru,colNumber)+"<br>"+insertionField+"<br>"+inputEquality(indexBaru)+"<br>"+inputLogic(parseInt(indexBaru)+1);
		
	}
	
}
function deleteColumn(tblId,index)
{
	var allRows = document.getElementById(tblId).rows;
	for (var i=0; i<allRows.length; i++) {
		if (allRows[i].cells.length > 1) {
			allRows[i].deleteCell(-1);
		}
	}
}
function displayToGrid(gridobj,data) {

  tableData = new Array();
    i=0;
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);

		 rowData=new Array();

		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
       
		      		cellData=[cValue];
              		rowData=rowData.concat(cellData);
			
         }
       tableData[i++]=rowData;

   }
   gridobj.setCellText(tableData);
   gridobj.setCellData(tableData);
   gridobj.setRowCount(tableData.length);
   v=new Array();
   for (i=0;i<gridobj.getRowCount();i++){v[i]=i;}
   gridobj.setRowIndices(v);
   gridobj.refresh();
 }
function loadGridArray2(gridobj,tblName,buffer) {
displayToGrid(gridobj,buffer.value);
 }
function getFilteredData(data,kategori){
//data="...|...|^..."
//filtered="";
//lakukan filtering
//hasil : filtered="...|...|^...";	

var filtered="";
var kriteria="";
var cell=document.getElementById('tblFilter').getElementsByTagName('tr')[1].getElementsByTagName('td');
	jmlKolom=parseInt(cell.length);
for(n=2;n<=jmlKolom;n++){
		idKolom=cell[parseInt(n)-1].getAttribute("id");	
		indexIdKolom=parseInt(idKolom.substring(3,idKolom.length));
		
		idFieldLogicTerakhir="logic"+indexId;
		kolom=cell[parseInt(n)-1].style.display;
		var logicPencarian="";
		if(kolom!='none'){
			tipePencarian=document.getElementById('field'+indexIdKolom).getAttribute("class");
			equalityPencarian=document.getElementById('equality'+indexIdKolom).value;
			indexIdLogic=parseInt(idKolom.substring(3,idKolom.length))+1;
			if(n!=2){
			logicPencarian=document.getElementById('logic'+indexIdLogic).value;
			}
			field=document.getElementById('field'+indexIdKolom);
			isiField=field.value;
			indexKolom=document.getElementById("colNum"+indexIdKolom).value;
			kriteria=kriteria+indexKolom+"|"+isiField+"|"+tipePencarian+"|"+equalityPencarian+"|"+logicPencarian+"|^";
			}
	}
	while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);

		 kriteriaCari=kriteria;
		
		 var ketemu;
		 var hasilPerbandingan=true;
		
		   while(kriteriaCari.indexOf("^")>=0){
			 partKriteria=kriteriaCari.substring(0,kriteriaCari.indexOf("^"));
			 kriteriaCari=kriteriaCari.substring(kriteriaCari.indexOf("^")+1);
		
			 list=partKriteria.split("|");						
			 
		     noKolom=list[0];
			 isiKolom=list[1];		
			 tipePencarian=list[2];
			 equalityPencarian=list[3];
			 logicPencarian=list[4];

			 if(kategori=="basic"){
				 		if(tipePencarian=='equal'){
	             
						 if (getColumnValue(iValue,parseInt(noKolom)).toUpperCase().trim() == isiKolom.toUpperCase().trim()){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							// break;
							 }
						 }
						 else if(tipePencarian=='like'){
						 if (getColumnValue(iValue,parseInt(noKolom)).toUpperCase().trim().indexOf(isiKolom.toUpperCase().trim())>=0){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							 //break;
							 }
						 }
	
						  hasilPerbandingan=hasilPerbandingan && ketemu;
					//hasilPerbandingan=ketemu;
					
					
				 }
				 else if(kategori=="advance"){
						if(IsNumeric(getColumnValue(iValue,parseInt(noKolom)).toUpperCase().trim())==true){
							nilaiDicari=parseInt(getColumnValue(iValue,parseInt(noKolom)));
							}
						else if(IsNumeric(getColumnValue(iValue,parseInt(noKolom)).toUpperCase().trim())==false){
							nilaiDicari=getColumnValue(iValue,parseInt(noKolom)).toUpperCase().trim();
							}
						if(IsNumeric(isiKolom.toUpperCase().trim())==true){
							isiKolom=parseInt(isiKolom.toUpperCase().trim());
							}
						else if(IsNumeric(getColumnValue(iValue,parseInt(noKolom)))==false){
							isiKolom=isiKolom.toUpperCase().trim();
							}
						if(equalityPencarian=='=='){
						 if (nilaiDicari == isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							 //break;
							 }
						 }
						 else if(equalityPencarian=='!='){
							
						 if (nilaiDicari != isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							// break;
							 }
						 }
						  else if(equalityPencarian=='>'){
							
						 if (nilaiDicari > isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							 //break;
							 }
						 }
						  else if(equalityPencarian=='>='){
							
						 if (nilaiDicari >= isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							//break;
							 }
						 }
						  else if(equalityPencarian=='<'){
							
						 if (nilaiDicari < isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							 //break;
							 }
						 }
						  else if(equalityPencarian=='<='){
							
						 if (nilaiDicari <= isiKolom){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							// break;
							 }
						 }
						 else if(equalityPencarian=='like'){
						 if (nilaiDicari.indexOf(isiKolom)>=0){
							ketemu=true;
							 }
						 else{
							 ketemu=false;
							// break;
							 }
						 }
						 
					 if(logicPencarian=='OR'){
						 hasilPerbandingan=hasilPerbandingan || ketemu;
						 }
					 else if(logicPencarian!='OR'){
						 hasilPerbandingan=hasilPerbandingan && ketemu;
						
						 }
					 }
				
		   }
		   // alert(hasilPerbandingan);
			if(hasilPerbandingan==true){
			   filtered=filtered+iValue+"^";
			   }
			    
		
    
   }

return filtered;
}
 
 
function filterGridArray(gridobj,tblName,colNumber,colValue,buffer) {
	//alert("loading");
 	//style="display:none" 
   tableData = new Array();
    i=0;
   data = buffer.value;
  
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));

     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	 
     if(tablename==tblName) {
		 if (getColumnValue(iValue,colNumber+2)==colValue){
		 rowData=new Array();
		 firstColumn=true;
		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
       			
				if (!firstColumn){
      
		      		cellData=[cValue];
              		rowData=rowData.concat(cellData);
				}
			  firstColumn=false;
         }
       tableData[i++]=rowData;
		 }
     }
   }
   gridobj.setCellText(tableData);
   gridobj.setCellData(tableData);
   gridobj.setRowCount(tableData.length);
   v=new Array();
   for (i=0;i<gridobj.getRowCount();i++){v[i]=i;}
   gridobj.setRowIndices(v);
   gridobj.refresh();
 }
function loadGridArray(gridobj,tblName,buffer) {
	//alert("loading");
 	//style="display:none" 
   tableData = new Array();
    i=0;
  data =buffer.value;
  
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	 
	 if(tablename==tblName) {
		 rowData=new Array();
		 firstColumn=true;
		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
       			
				if (!firstColumn){
      
		      		cellData=[cValue];
              		rowData=rowData.concat(cellData);
				}
			  firstColumn=false;
         }
       tableData[i++]=rowData;
		 
     }
   }
   gridobj.setCellText(tableData);
   gridobj.setCellData(tableData);
   gridobj.setRowCount(tableData.length);
   v=new Array();
   for (i=0;i<gridobj.getRowCount();i++){v[i]=i;}
   gridobj.setRowIndices(v);
   gridobj.refresh();
 }
 
function updateDataOnBuffer(tblName,id,col,text,buffer){
  data = buffer.value;
  newData="";
   while (data.indexOf("^")>=0){
     rowValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(rowValue, 1).trim();

     if(tablename==tblName) {
		if (getColumnValue(rowValue,2)==id){
			rowValue=updateColumnValue(rowValue,parseInt(col)+2,text);
		}
		
       	 
     }
	 newData=newData+rowValue+"^";
   }
   buffer.value=newData;

 }
 function deleteDataOnBuffer(tblName,id,buffer){
	 data = buffer.value;
  newData="";
   while (data.indexOf("^")>=0){
     rowValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(rowValue, 1).trim();

     if(tablename==tblName) {
		if (getColumnValue(rowValue,2)==id){
			if (id.indexOf("N")==0) {
				rowValue="";
			}else{
			    rowValue=updateColumnValue(rowValue,2,"-"+id);
			}
		}
		
       	 
     }
	 newData=newData+rowValue+"^";
   }
   buffer.value=newData;

 }

function findData(grid,col,txtFind){
	jmlbaris=grid.getRowCount()
	for(i=0;i<=jmlbaris;i++){
	txtHasilCari=grid.getCellValue(col,i);
	if (txtHasilCari==txtFind){
			return "1";
			}
		}	
	}
function findGrid(grid,col,txtFind){
	jmlbaris=grid.getRowCount()
	for(i=0;i<=jmlbaris;i++){
	txtHasilCari=grid.getCellValue(col,i);
	txtA=txtFind.toUpperCase();
	txtB=txtHasilCari.toUpperCase();
	if (txtB.indexOf(txtA)>=0){
			grid.setSelectedRows([i]);
			grid.setCurrentRow(i);
			var lbl = document.getElementById("ditemukan");
			lbl.innerHTML=txtB;
			return;
			}
		}	
	}
function cekAllNew(grid){
	var rows = $('#'+grid).jqxGrid('getrows').length;
	isAllNew=true;
	for(n=0;n<rows;n++){
		var dataRecord = $("#"+grid).jqxGrid('getrowdata', n);
		if(dataRecord.id.trim().indexOf("N")<0){isAllNew=false;
			break;;}
		
		}

		return isAllNew;
	}
//ASCII CODE
function showKeyCode(chr)
{
var character = chr.value.substring(chr.value.length-1,chr.value.length);
var code = character.charCodeAt(0);
alert(code);
if (code<=48 || code>=57 && code!=44){
	alert('wrong');
	}
}
function check1(chr){
	var character = chr.value.substring(chr.value.length-1,chr.value.length);
	if (IsNumeric2(character)==false){
		parent.openDialog("Peringatan","Inputan selain angka tidak valid",320,150,"alert","dialog");
		if(chr.value.length==1){
		chr.value=0;	
			}
		else{
		chr.value=chr.value.substring(0,chr.value.length-1);
		}
		}
	}

function IsNumeric2(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }
function IsNumeric3(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }

function getMaxIndex(){
	var idTerbesar = 0 ;
	var data = document.forms[0].buffer.value;
	while (data.indexOf("^")>=0){
		iValue=data.substring(0,data.indexOf("^"));
		data=data.substring(data.indexOf("^")+1);
		var iID = getColumnValue(iValue, 2);
		if( iID.indexOf('N') != -1 ){
		iID = iID.substring(1, iID.length);
		if(parseInt(iID) > idTerbesar) idTerbesar = parseInt(iID);
	}}//for
	return idTerbesar;
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}
function formatUserInput(aTextField){
	var aText=aTextField.value;
	if (aText.length > 0){
		aText=removePeriodFromNumber(aText);
		aText=formatInputNumber("Double",aText);
		aTextField.value=aText;
	}
}
function isInteger(val) 
{
	var hasil = true;
	var digits="1234567890-";
	for (var i=0; i < val.length; i++) 
	{
		if (digits.indexOf(val.charAt(i)) == -1) 
		{ 
			hasil = false; 
		}
	}	
	return hasil ;
}

function isDouble(val) 
{
	var hasil = true;
	var digits="1234567890.-";
	var jmlTitik = 0 ;
	for (var i=0; i < val.length; i++) 
	{
		if (digits.indexOf(val.charAt(i)) == -1) 
		{ 
			hasil = false; 
		}
		if(val.charAt(i) == ".")
		{
			jmlTitik = jmlTitik + 1;
		}
		if(jmlTitik > 1)
		{
			hasil = false; 
		}
	}	
	return hasil ;
}


function formatInputNumber(formated, stringInput){ 
	var result = "" ;
	var isMinus=false;
	
	if(stringInput.indexOf("-")>=0){
		stringInput=stringInput.substring(1,stringInput.length);
		isMinus=true;
		}
		
	if(formated == "Integer")
	{		
		//check valid input
		if(!isInteger(stringInput) ){
			alert("Invalid input!\n"+ stringInput +" not Integer value");			
			return;
		}
		
		//format
		result = formatNumber(stringInput, "#,##0");
	}
	else if(formated == "Double")
	{		
		//pisahkan antara angkas sebelum titik, dengan angka setelah titik(ga perlu diformat)		
		var hightValue = "" ;
		var lowValue = "" ;
		
		var foundDot = false ;
		for(var x = 0; x < stringInput.length; x++){
			var charx = stringInput.charAt(x);
			
			if (charx == ".")
				foundDot = true;
				
			if(foundDot == false)
				hightValue = hightValue + charx ;
			else
				lowValue = lowValue + charx ;
		}
				
		//gabungkan
		stringInput = hightValue + lowValue ;
		
		//cek valid (untuk memeriksa, apakah inputnya salah)
		if(!isDouble(stringInput) ){
			alert("Invalid input!\n"+ stringInput +" not Double value");				
			return;
		}
		
		//format hight
		hightValue = formatNumber(hightValue, "#,##0");
		
		//gabungkan hasil dari formatef hight
		result = hightValue + lowValue ;		
				
	}	
	if(isMinus==true){result="-"+result;}
	return result ;
}
function removePeriodFromNumber2(stringNumber){
	var result = "" ;
	var stringNumber=stringNumber+'';
	for(var i = 0; i < stringNumber.length; i++){
		var chari = stringNumber.charAt(i);		
	
		if(chari != "."){			
			result = result + chari ;
		}
	}
	return result.replace(",",".") ;
} 
function removePeriodFromNumber(stringNumber){
	var result = "" ;
	var stringNumber=stringNumber+'';
	for(var i = 0; i < stringNumber.length; i++){
		var chari = stringNumber.charAt(i);		
	
		if(chari != ","){			
			result = result + chari ;
		}
	}
	return result ;
} 
     function addTrailingBlank(value,length){
     	var blankAdded = length - value.length;
     	
     	for (var i=0;i<blankAdded;i++){
     		value=value+"_";
     	}
     	return value;
     }
     function addHeadingBlank(value,length){
     	var blankAdded = length - value.length;
     	
     	for (var i=0;i<blankAdded;i++){
     		value="_"+value;
     	}
     	return value;
     }
     
     function updateColumn(row,kolomIndex,newValue,separator){
        //kolom index dimulai dari 1
     	var result="";
     	var headIndex=0;
     	var tailIndex=0;
     	var cnt=0;
     	for (var i=0;i<=row.length;i++){
     		if (row.charAt(i)==separator){
     		   if (cnt + 2 == kolomIndex){
     		   		headIndex=i;
     		   }
     		   if (cnt + 1 == kolomIndex){
     		   		tailIndex=i;
     		   }
     		   cnt++;
     		   
     		}
     	}
     	
     	var head="";
     	if (headIndex > 0){
     		head = row.substring(0,headIndex + 1);	
     	}
     	//alert("head "+head);
        var tail=row.substring(tailIndex ,row.length);
        //alert("tail "+tail);
        result = head + newValue + tail;
     	return result;
     }
     
     function getColumn(row,kolomIndex,separator){
        //row harus berupa value dari select object
        //misal document.forms[0].bahanBaku0.value
        //kolom index mulai dari 1 bukan dari nol,
        //kolom dipisahkan oleh tanda separator
        var srow=row + separator;
        var nilai="";
    	for (var i=0;i<kolomIndex;i++){
        	nilai = srow.substring(0,srow.indexOf(separator,0));
    		srow=srow.substring(srow.indexOf(separator,0) + 1,srow.length);
    	};
    	
    	return nilai;
    }
    
     function updateColumnValue(row,kolomIndex,newValue){
        //kolom index dimulai dari 1
     	var result="";
     	var headIndex=0;
     	var tailIndex=0;
     	var cnt=0;
     	for (var i=0;i<=row.length;i++){
     		if (row.charAt(i)=="|"){
     		   if (cnt + 2 == kolomIndex){
     		   		headIndex=i;
     		   }
     		   if (cnt + 1 == kolomIndex){
     		   		tailIndex=i;
     		   }
     		   cnt++;
     		   
     		}
     	}
     	
     	var head="";
     	if (headIndex > 0){
     		head = row.substring(0,headIndex + 1);	
     	}
     	//alert("head "+head);
        var tail=row.substring(tailIndex ,row.length);
        //alert("tail "+tail);
        result = head + newValue + tail;
     	return result;
     }
     function getColumnValue(row,kolomIndex){
        //row harus berupa value dari select object
        //misal document.forms[0].bahanBaku0.value
        //kolom index mulai dari 1 bukan dari nol,
        //kolom dipisahkan oleh tanda "|"
        var srow=row+"|";
        var nilai="";
    	for (var i=0;i<kolomIndex;i++){
        	nilai = srow.substring(0,srow.indexOf("|",0));
    		srow=srow.substring(srow.indexOf("|",0) + 1,srow.length);
    	};
    	
    	return nilai;
    }
    function removeSpace(nilai){
    	var result="";
    	for (var i=0;i<nilai.length;i++){
    		if (nilai.substring(i,i+1)!=" ") {
    		    result = result + nilai.substring(i,i+1);
    		}
    	}
    	return result;
    }
    function remove_(nilai){
    	var result="";
    	for (var i=0;i<nilai.length;i++){
    		if (nilai.substring(i,i+1)!="_") {
    		    result = result + nilai.substring(i,i+1);
    		}
    	}
    	return result;
    }
	function cekDateFormat(isAdate){
	    if (isAdate.indexOf("/")!=4) return false;
	    if (isAdate.lastIndexOf("/")!=7) return false;	    
		var yyyy=isAdate.substring(0,isAdate.indexOf("/",0));
		
		var mm=isAdate.substring(isAdate.indexOf("/",0)+1,isAdate.indexOf("/",0)+3);
		
		var dd=isAdate.substring(isAdate.lastIndexOf("/")+1,isAdate.lastIndexOf("/")+3);
				
		if (yyyy.length != 4) return false;
		if (parseInt(mm,10) > 12) return false;
		if (parseInt(dd,10) > 31) return false;
		return true;
	}
	
function IsNumeric(strString)
   //  check for valid numeric strings	
   {
   //var strValidChars = "0123456789.-";
   //var strValidChars = "0123456789";
   var strValidChars=/[\d.]/;
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.test(strChar) == false)
         {
         blnResult = false;
		 break;
         }
      }
   return blnResult;
   }
function formatInputNumberText(txt){
check1(txt);
nilai=txt.value;
while(nilai.indexOf(",")>0){nilai=nilai.replace(",","");}
txt.value=formatInputNumber("Double",nilai);
}
function loadImage(keterangan){
var contentLoading="<img src='../images/loading.gif' /> "+ keterangan ;
return contentLoading;
	}
function loadImage2(keterangan){
var contentLoading="<img src='../../images/loading.gif' /> "+ keterangan ;
return contentLoading;
	}
function getColumnIndex(headerText,headerNameSearch){
for(x=0;x<headerText.length;x++){
	if(headerText[x]==headerNameSearch){
		return x;
		break;
		}
	}
	}
function monthName(bln){
	var namaBulan=["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
	return namaBulan[bln];
	}
function confirmationBox(){
	document.write('<div style="display:none" name="dialogBox"><p></p></div>');
	}
//$(function(){$.fx.speeds._default = 1000;});
function dialog(stat){
	if(stat=="open"){
	document.getElementById("load").innerHTML="<img width='18' height='18' src='../images/loading29.gif' align='absmiddle'/><b> Loading.. Mohon tunggu sampai proses selesai..</b>";	
	/*<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Silakan relax dan bikin </b><img width='18' height='18' src='../images/cupCoffee.png' align='absmiddle'/>*/
	$('#load').dialog({
			width:360,height:60,
			modal: true,
			title: "Please wait...",
			headerVisible: false
		});
	$('#load').dialog('widget').find(".ui-dialog-titlebar").hide();
	
		}
	else if(stat=="destroy"){
		$('#load').dialog("destroy");
		}	
		}


function openDialog(judul,pesan,lebar,tinggi,tipe,id,callBackOk,paramCallBack,callBackCancel,paramCallBackCancel){
			//divElement=window.parent.document.getElementsByName('dialogBox')[0].setAttribute("id",id); 
		
			if(tipe=='alert' || tipe=='informasi'){
				if(tipe=='alert' ){
					ico='ui-icon ui-icon-alert';
					}
				else{ico='ui-icon ui-icon-info';}
				
				document.getElementById(id).innerHTML='<span class="'+ico+'" style="float:left; margin:0 7px 20px 0;"></span>'+pesan;
				
				$('#'+id).dialog({autoOpen: false,width:lebar,height:tinggi,
								 buttons: {
									"OK": function() {
										$(this).dialog("close"); 
										if(callBackOk!=undefined){
										return callBackOk(paramCallBack);
										}
								   }},
								  modal: true,show: 'blind',hide: 'blind',
								  title:judul
				});
				}
			else if(tipe=='konfirmasi'){
				document.getElementById(id).innerHTML='<span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span>'+pesan;
					$('#'+id).dialog({autoOpen: false, width:lebar,height:tinggi,
					closeEvent:function() {
						    $('#'+id).dialog("close"); 
								},
					buttons: {
						"Batal": function() {
							$(this).dialog("close"); 
						},
						"Ok": function() { 
							
							$(this).dialog("close"); 
							if(callBackOk!=undefined){
								return callBackOk(paramCallBack);
								}
						} 
						
					},
					modal: true,show: 'blind',hide: 'blind',title:judul
				});
				}
				
				else if(tipe=='konfirmasi2'){
				document.getElementById(id).innerHTML='<span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span>'+pesan;
					$('#'+id).dialog({autoOpen: false, width:lebar,height:tinggi,closeOnEscape:false,
	 				closeEvent:function(){
						    $('#'+id).dialog("close"); 
							if(callBackOk!=undefined){
								return callBackOk(paramCallBack);
								}	
								},
					buttons: {
						"Batal": function() {
							$(this).dialog("close"); 
							if(callBackOk!=undefined){
								return callBackOk(paramCallBack);
								}
						}, 
						"Ok": function() { 
							$(this).dialog("close"); 
							if(callBackCancel!=undefined){
								return callBackCancel(paramCallBackCancel);
								}
						} 
					},
					modal: true,show: 'blind',hide: 'blind',title:judul
				});
				}
				$('#'+id).dialog('open')	
			}
function focusGrid(gridobj,col,row){
	
	gridobj.focus();
	
	//gridobj.setCurrentRow(row);
	//gridobj.setCurrentColumn(col);
	}
function cekText(txtbox){
nilai=txtbox.value;
if(nilai.indexOf(",")>=0)
nilai=removePeriodFromNumber(nilai);
txtbox.value=formatInputNumber("Double",nilai);
}
function cekIsPeriodeLocked(tahun,bulan){
	var hasil="unlocked"; 	
	var url = '../functions/cekIsPeriodeLocked.php';	
	$.ajax({
      url: url,
      type: "POST",
	  async: false,
      data: ({tahun:tahun,bulan:bulan}),
      dataType: "text",
      success: function(returnedVal){
	 	hasil= returnedVal
      }
   	});
	return hasil;
	}
function formatNumberTextField(txtId){
txt=document.getElementById(txtId);
check1(txt);
nilai=txt.value;
nilai=removePeriodFromNumber(nilai);
txt.value=formatInputNumber("Double",nilai);
}

function Terbilang(x)
{
  array = [" ", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
  if (x < 12)
    return " " + array[x];
  else if (x < 20)
    return Terbilang(x - 10) + "belas";
  else if (x < 100)
    return Terbilang(parseInt(x / 10)) + " puluh" +  Terbilang(x % 10);
  else if (x < 200)
    return " seratus" + Terbilang(x - 100);
  else if (x < 1000)
    return Terbilang(parseInt(x / 100)) + " ratus" + Terbilang(x % 100);
  else if (x < 2000)
    return " seribu" + Terbilang(x - 1000);
  else if (x < 1000000)
    return Terbilang(parseInt(x / 1000)) + " ribu" + Terbilang(x % 1000);
  else if (x < 1000000000)
    return Terbilang(parseInt(x / 1000000)) + " juta" + Terbilang(x % 1000000);
  else if (x < 1000000000000)
    return Terbilang(parseInt(x / 1000000000)) + " milyar" + Terbilang(x % 1000000000);	
}
function getTerbilang(nilaiFormatted,labelDisplay){
	var nilaiNonFormatted=nilaiFormatted;
      if(nilaiNonFormatted!=0){
				while(nilaiNonFormatted.indexOf(',')>0){nilaiNonFormatted=nilaiNonFormatted.replace(',',"");}
		}
	  hasil=Terbilang(nilaiNonFormatted);	

	  if(hasil=="  "){
		  hasil="nol";
		  } 
	 labelDisplay.innerHTML=hasil + ' rupiah'
	}
function cekTanggalClient(deepPath){
	d=new Date();
	var curr_date = d.getDate();
	var curr_month = d.getMonth();
	curr_month++;
	var curr_year = d.getFullYear();
	var curr_hour=d.getHours();
	var curr_minute=d.getMinutes();
	var curr_second=d.getSeconds();
	if(parseInt(curr_month)<=9){
		curr_month="0"+curr_month;
		}
	if(parseInt(curr_date)<=9){
		curr_date="0"+curr_date;
		}	
	var clientDate=curr_date+"-"+curr_month+"-"+curr_year;
	
			var url = "functions/cekClientDate.php";
			$.ajax({
			  url: url,
			  type: "POST",
			  data: ({clientDate:clientDate}),
			  dataType: "text",
			  success: function(returnedVal){
			
				if(returnedVal=='invalid'){
					window.location='functions/errorDate.php';
					}
				  }
			  });
	}
 $(function() {
	$(document).ajaxStart(function(){
		$('#loading').fadeIn();
	}).ajaxStop(function(){
		$('#loading').fadeOut();
	});
	});
function gCIBN(columnName) {
        for (i = 0; i < colNames.length; i++) {
			
            if (colNames[i] == columnName) {
                return i; // return the index
            }
        }
        return -1;
   		 }	
function gCIBN2(columnName) {
        for (i = 0; i < colNames2.length; i++) {
			
            if (colNames2[i] == columnName) {
                return i; // return the index
            }
        }
        return -1;
   		 }			 
function formatNumber(number, format, print) {  // use: formatNumber(number, "format")
	
  	// CONSTANTS
	var separator = ",";  // use comma as 000's separator
	var decpoint = ".";  // use period as decimal point
	var percent = "%";
	var currency = "$";  // use dollar sign for currency

	if (print) document.write("formatNumber(" + number + ", \"" + format + "\")<br>");
    		
    if (number - 0 != number) return null;  // if number is NaN return null
    var useSeparator = format.indexOf(separator) != -1;  // use separators in number
    var usePercent = format.indexOf(percent) != -1;  // convert output to percentage
    var useCurrency = format.indexOf(currency) != -1;  // use currency format
    var isNegative = (number < 0);
    number = Math.abs (number);
    if (usePercent) number *= 100;
    format = strip(format, separator + percent + currency);  // remove key characters
    number = "" + number;  // convert number input to string

     // split input value into LHS and RHS using decpoint as divider
    var dec = number.indexOf(decpoint) != -1;
    var nleftEnd = (dec) ? number.substring(0, number.indexOf(".")) : number;
    var nrightEnd = (dec) ? number.substring(number.indexOf(".") + 1) : "";

     // split format string into LHS and RHS using decpoint as divider
    dec = format.indexOf(decpoint) != -1;
    var sleftEnd = (dec) ? format.substring(0, format.indexOf(".")) : format;
    var srightEnd = (dec) ? format.substring(format.indexOf(".") + 1) : "";

     // adjust decimal places by cropping or adding zeros to LHS of number
    if (srightEnd.length < nrightEnd.length) {
		var nextChar = nrightEnd.charAt(srightEnd.length) - 0;
		nrightEnd = nrightEnd.substring(0, srightEnd.length);
		if (nextChar >= 5) nrightEnd = "" + ((nrightEnd - 0) + 1);  // round up

		// patch provided by Patti Marcoux 1999/08/06
		while (srightEnd.length > nrightEnd.length) {
			nrightEnd = "0" + nrightEnd;
		}

		if (srightEnd.length < nrightEnd.length) {
			nrightEnd = nrightEnd.substring(1);
			nleftEnd = (nleftEnd - 0) + 1;
		}
    } else {
		for (var i=nrightEnd.length; srightEnd.length > nrightEnd.length; i++) {
			if (srightEnd.charAt(i) == "0") nrightEnd += "0";  // append zero to RHS of number
			else break;
		}
    }

	// adjust leading zeros
    sleftEnd = strip(sleftEnd, "#");  // remove hashes from LHS of format
    while (sleftEnd.length > nleftEnd.length) {
		nleftEnd = "0" + nleftEnd;  // prepend zero to LHS of number
    }

    if (useSeparator) nleftEnd = separate(nleftEnd, separator);  // add separator
    var output = nleftEnd + ((nrightEnd != "") ? "." + nrightEnd : "");  // combine parts
    output = ((useCurrency) ? currency : "") + output + ((usePercent) ? percent : "");
    if (isNegative) {
		// patch suggested by Tom Denn 25/4/2001
		output = (useCurrency) ? "(" + output + ")" : "-" + output;
    }
    return output;
}

function strip(input, chars) {  // strip all characters in 'chars' from input
    var output = "";  // initialise output string
    for (var i=0; i < input.length; i++)
		if (chars.indexOf(input.charAt(i)) == -1)
			output += input.charAt(i);
    return output;
}

function separate(input, separator) {  // format input using 'separator' to mark 000's
    input = "" + input;
    var output = "";  // initialise output string
    for (var i=0; i < input.length; i++) {
		if (i != 0 && (input.length - i) % 3 == 0) output += separator;
		output += input.charAt(i);
    }
    return output;
}
function filterInsertGrid(gridobj,tblName,colNumber,colValue,buffer) {
	//alert("loading");
 	//style="display:none" 
   tableData = new Array();
    i=0;
   data = buffer.value;
   filteredData='';
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	  if(tablename==tblName) {
		 
		 if (getColumnValue(iValue,colNumber+2)==colValue){
		 filteredData=filteredData+iValue+'^';
		 }
     }
   }
	 source2.localdata = bufferToJSon(colNames2,filteredData);
			
			$("#"+gridobj).jqxGrid('updatebounddata');
 }	 		 
function selisihHari(date1,date2)
{//date1 adalah date yang lebih baru
 date1=parseInt(Date.parse(date1),10);
 date2=parseInt(Date.parse(date2),10);
 var result=(date1-date2)/1000/60/60/24;;
 
 return result;
}
function selisihHari2(date1,date2){
	//date2 adalah yang lebih besar
	var retVal;
	var url = 'generals/hitungSelisihHari';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
	  async: false,
      data: ({tanggalAwal:date1,tanggalAkhir:date2}),
      dataType: "text",
      success: function(returnedVal){
		  retVal=returnedVal;
		  		  }
   	}
	);	
return retVal;
	}

<?php
$this->layout='popup';
echo $this->Html->script('h1popupoutletsektorlap.js');
?>
<h3>Pop Up Outlet</h3>

<form name="h1form" action="" method="post">
<table border="0" cellspacing="0" cellpadding="0">	
	<tr><td width="300">
      <script type="text/javascript">
	var colNames=['comId','outId','NamaOutlet','Alamat'];	
	var width=[0,0,200,200];
	var isHide={};
	var columntype={};
	var validation={};
	var cellsformat={};
	var isEditable={};
	var cvalchange={};
	isHide[0]=true;
	isHide[1]=true;
	columntype[1]='textbox';
	columntype[2]='textbox';
	
	
	function generateColumn(){
		var x=[];
		for(n=0;n<colNames.length;n++){
			var xSingle={}
			xSingle["datafield"]=colNames[n];			
			xSingle["text"]=colNames[n];
			xSingle["columntype"]=columntype[n];
			xSingle["validation"]=validation[n];
			xSingle["width"]=width[n];
			xSingle["hidden"]=isHide[n];
			xSingle["cellvaluechanging"]=cvalchange[1];
			x.push(xSingle);
			}
			
		return x;	
		}	
	    $(document).ready(function () {
		    onLoadHandler();

            var data =[];
			
            // prepare the data
             source =
            {
                datatype: "json",
                datafields: [
                    { name: 'comId' },
                    { name: 'outId' },
                    { name: 'NamaOutlet' },
                    { name: 'Alamat' },
                ],
                localdata: data
            };
			
			
            var dataAdapter = new $.jqx.dataAdapter(source);
			
            $("#jqxgrid").jqxGrid(
            {
                showemptyrow:false,
				source:dataAdapter,
				width: 420,
				height:220,
                theme: theme,
                columnsresize: true,
				sortable: true,
				enabletooltips: true,
				 altrows:true,
                selectionmode: 'singlecell',
                columns: generateColumn()
            });
		  //event
		 
			
		   var nilaiSebelum;
		   $("#jqxgrid").bind('rowdoubleclick', function (event) {
			  
			   var args=event.args;
			   var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', args.rowindex);
		
			   obj_caller.$('#outlet').val(dataRecord.comId+'#'+dataRecord.outId+'#'+dataRecord.NamaOutlet+'#'+dataRecord.Alamat);			
			   window.close();
			   });
		   $("#jqxgrid").bind('cellbeginedit', function (event) {
                var args = event.args;
				nilaiSebelum=args.value;  
               
            });

            $("#jqxgrid").bind('cellendedit', function (event) {});	
          $("#jqxgrid").jqxGrid('setcolumnproperty', 'NamaMenu', 'editable', false);
         
		  
		
		
		});
		
		
    </script>  <div id='jqxWidget'>
        <div id="jqxgrid"></div>
    </div></td>
	</tr>
	<tr><td> <div id="linkHal" style="height:18px; font-weight:bold; display:none" ></div>
     <label id="keterangan" style="display:none"></label>
     <label id="maxHal" style="display:none"></label>
     <select name="namaKolom" class="roundIt">
	  <option value="nama_outlet">Nama Outlet</option>
	  </select>
        <input type="text" name="strCari" id="strCari" onKeyPress="return event.keyCode!=13" class="roundIt"/>
        
    <script>
	
    document.getElementById('strCari').onkeyup=function(e){
	key=e?e.which:event.keyCode;
	if(key==13){
		cariData(this.value,1);
		}
	else{
	
	}
	
	this.focus();
	}
    </script>
 
       <button type="Button" value="Cari" name="Cari" onClick="cariData(strCari.value,1)"><img align="left" width="16" height="16" src="img/ico/Zoom.ico">Cari</button>
     <button type="Button" value="ShowAll" name="ShowAll" onClick="getData(1)"><img align="left" width="16" height="16" src="img/ico/World.ico">Show All</button>
     </td>
	</tr>
</table>
  
<br>
	<input type='hidden' name='lastId'>
	<textarea name="buffer" cols=50 rows=10 class="textBuff"></textarea>
    <textarea name="bufferHelper" cols=50 rows=10 class="textBuff"></textarea>
    </form>
<?php
echo $this->Html->script('h1approvaldpfbrngen.js');
?>
<h3>Approval Subsidi atau 9 Jari</h3>

<form name="h1form" action="" method="post">



    </script>
     <div class="row">
     <div class="col-sm-2">
     <select name="namaKolom" class="form-control">
      <option value="namaTP">Nama TP</option>
	  </select></div>
      <div class="col-sm-2">
        <input type="text" name="strCari" id="strCari" onKeyPress="return event.keyCode!=13" class="form-control"/></div>
    <script>
	
    document.getElementById('strCari').onkeyup=function(e){
	key=e?e.which:event.keyCode;
	if(key==13){
		cariData(this.value);
		}
	else{
	
	}
	
	this.focus();
	}
    </script>
    <div class="col-sm-8">
       <button type="Button" value="Cari" name="Cari" onClick="cariData(strCari.value,1)" class="btn btn-default"><i class='fa fa-search'></i>Cari</button>
     <button type="Button" value="ShowAll" name="ShowAll" onClick="strCari.value='';cariData('',1)" class="btn btn-default"><i class='fa fa-refresh'></i>Show All</button></div>
     </div>
     <div class="row">
     <div class="dataTable_wrapper table-responsive"  class="col-sm-13">

                                <table class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Nomor Subsidi</th>
                                            <th rowspan="2">Tanggal Input</th>
                                            <th rowspan="2">Nama TP</th>
                                            <th rowspan="2">Dist</th>
                                            <th rowspan="2">Cab</th>
                                            <th rowspan="2">Outlet</th>
                                            <th rowspan="2">Jml Prod</th>
                                            <th colspan="4">Value</th>
                                            <th rowspan="2">Periode</th>
                                        </tr>
                                        <tr><th>on faktur</th><th>off faktur</th><th>on faktur sub</th><th>off faktur sub</th></tr>
                                    </thead>
                                    <tbody id='tblPengajuanBody' class="panel-group" >
                                      
                                    </tbody>
                                </table>
                                </div>
                                </div><div id="linkHal" style="height:18px; font-weight:bold; display:none" ></div>
     <label id="maxHal" style="display:none"></label><br>
                           
                          
      </form> 
                               <script>
    $(document).ready(function() {
		onLoadHandler();
        $('#dataTables-example').DataTable({
                responsive: true
        });
		$('.collapse').on('show.bs.collapse', function() {
	  $(this).parent().removeClass("zeroPadding");
	});
	
	$('.collapse').on('hide.bs.collapse', function() {
	  $(this).parent().addClass("zeroPadding");
	});
	});
	function updateNilaiDetil(DPFId,discPrinsipal,offFaktur,discDist){
		if(IsNumeric(discPrinsipal)==false || parseInt(discPrinsipal)<0){
			document.getElementById('discPrinsipal_'+DPFId).value=nilaiLama;
			alert('Isian harus angka dan lebih dari 0');
			return;
			}
		if(IsNumeric(offFaktur)==false || parseInt(offFaktur)<0){
			document.getElementById('offFaktur_'+DPFId).value=nilaiLama;
			alert('Isian harus angka dan lebih dari 0');
			return;
			}	
		
		if(IsNumeric(discDist)==false || parseInt(discDist)<0){
			document.getElementById('discDist_'+DPFId).value=nilaiLama;
			alert('Isian harus angka dan lebih dari 0');
			return;
			}		
		hna=parseFloat(removePeriodFromNumber(document.getElementById('hna_'+DPFId).innerHTML));
		hna2=parseFloat(removePeriodFromNumber(document.getElementById('hna2_'+DPFId).innerHTML));
		hargaJadi=parseFloat(removePeriodFromNumber(document.getElementById('hargaJadi_'+DPFId).innerHTML));
		hjm=parseFloat(removePeriodFromNumber(document.getElementById('hjm_'+DPFId).innerHTML));
		totalDisc=parseFloat(removePeriodFromNumber(document.getElementById('totalDisc_'+DPFId).innerHTML));
		discPrinsipal=parseFloat(discPrinsipal);
		offFaktur=parseFloat(offFaktur);
		discPrinsipal=parseFloat(discPrinsipal);
		offFaktur=parseFloat(offFaktur);
		discDist=parseFloat(discDist);
		if(hna2>0){
hargaJadi1=(hna2+(hna2*(0.1)))-((hna2+(hna2*(0.1)))*((discPrinsipal+discDist)/100));		
hargaJadi=(hna2+(hna2*(0.1)))-((hna2+(hna2*(0.1)))*((discPrinsipal+offFaktur+discDist)/100));
		}
		else{
hargaJadi1=(hna*(0.1)+hna)-((hna*(0.1)+hna)*((discPrinsipal+discDist)/100));
		hargaJadi=(hna*(0.1)+hna)-((hna*(0.1)+hna)*((discPrinsipal+offFaktur+discDist)/100));
		}
document.getElementById('hargaJadi1_'+DPFId).innerHTML=formatInputNumber("Double",hargaJadi1+"");		
document.getElementById('hargaJadi_'+DPFId).innerHTML=formatInputNumber("Double",hargaJadi+"");
		//rumus total disc
		totalDisc=Math.round(((((hna*1.1)-hargaJadi) / (hna*1.1))*100)*100)/100;
		if(totalDisc>hjm){
			$('#baris_'+DPFId).addClass('blink-element');
			}
		else{$('#baris_'+DPFId).removeClass('blink-element');
			}
		if(hna2==0){
		document.getElementById('totalDisc_'+DPFId).innerHTML=totalDisc;
		}
		else{
		document.getElementById('totalDisc_'+DPFId).innerHTML=totalDisc;
		}
		}
    </script>
	   <style>
       .zeroPadding {
      padding: 0 !important;
        }
    </style>

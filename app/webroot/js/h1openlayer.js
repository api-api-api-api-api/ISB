//document.getElementById('mapdiv').innerHTML="";
epsg4326 = new OpenLayers.Projection("EPSG:4326")

var Map=OpenLayers.Map
map = new Map({
div: "mapdiv",
displayProjection: epsg4326   // With this setting, lat and lon are displayed correctly in MousePosition and permanent anchor
});
//map = new OpenLayers.Map("mapdiv");
map.addLayer(new OpenLayers.Layer.OSM());
//  map.addLayer(new OpenLayers.Layer.OSM("Wikimedia",
//    ["https://maps.wikimedia.org/osm-intl/${z}/${x}/${y}.png"],
//    {
//      attribution: "&copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, </a>",
//      "tileOptions": { "crossOriginKeyword": null }
//    })
//  );
// See https://wiki.openstreetmap.org/wiki/Tile_servers for other OSM-based layers

map.addControls([
    new OpenLayers.Control.MousePosition(),
    new OpenLayers.Control.ScaleLine(),
    //new OpenLayers.Control.LayerSwitcher(),
    new OpenLayers.Control.Permalink({ anchor: false })
]);

projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
var lonLat = new OpenLayers.LonLat(110.42049,-6.99575).transform(epsg4326, projectTo);
var zoom = 8;
if (!map.getCenter()) {
    map.setCenter(lonLat, zoom); 
}
console.log(map)
var colorList,layerName,styleArray,vectorLayer,feature,Feature, controls,setPopup=0


$(document).ready(function(){
//onLoadHandler();
$("#startDate,#endDate").datepicker({
// setDate: new Date(),
// minDate: +1,
    firstDay: 1,
    defaultDate: "d",
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    onSelect: function( selectedDate,inst ) {
        if ($(this).attr('id') == 'startDate') {
            var d =  $('#startDate').datepicker('getDate');
            d.setDate(d.getDate());
            $('#endDate').datepicker('option', 'minDate', d);
            //$('#arrivalDate').datepicker('close');
            $('#endDate').datepicker('show');
            inst.preventDefault();
        }
    }
}).keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});
var url="Openlayers/getNama";
$.ajax({
    url:url,
    type:"POST",
    dataType:"text",
    data:({}),
    async:false,
    success:function(result){
        document.getElementById("carinama").innerHTML=result
    }
})
$("#tablePosisi tbody").on('click','.tab',function() {
    $("#tablePosisi tbody tr").removeClass("ativetab");
    var index=$(this).find("input[name=index]").val();
   
    if(Feature){
        for(var i = 0; i < Feature.length; i++) {
            if(Feature[i].popup){
                Feature[i].popup.destroy()
            }
            Feature[i].destroy() 
        }
        Feature=undefined
    }
    var jumlahBaris= $("#tablePosisi tbody tr").length
    var markers=[];
    for(var i=0;i<jumlahBaris;i++){
        markers.push([$("input[name=tdLat]").eq(i).val(),$("input[name=tdLon]").eq(i).val(),$("input[name=tdKota]").eq(i).val(),$("input[name=tdTime]").eq(i).val()])
    }
    SetMarker(markers)

  
    createPopup(Feature[index])
   
});

$("#btnDelMarker").on('click',function(e){
    console.log(Feature.length)
    //console.log(feature.length)
    for(var i = 0; i < Feature.length; i++) {
        Feature[i].popup.destroy()
        
    }
    if(vectorLayer){ 
        for(var i = 0; i < vectorLayer.length; i++) {
            map.removeLayer(vectorLayer[i])
        }
    }
})

$("#btnShowAll").on('click',function(e){
    var jumlahBaris= $("#tablePosisi tbody tr").length
    var markers=[];
    for(var i=0;i<jumlahBaris;i++){
        markers.push([$("input[name=tdLat]").eq(i).val(),$("input[name=tdLon]").eq(i).val(),$("input[name=tdKota]").eq(i).val(),$("input[name=tdTime]").eq(i).val()])
    }
    SetMarker(markers)
})
})


function onLoadHandler(){

}
function SetMarker(marker){
    //console.log(marker)
    var markers=marker;
    
    
        layerName = [];styleArray=[];vectorLayer=[];Feature=[];
      

    var j = 0;
    for (var i = 0; i < markers.length; i++) {
        j++;
        layerName.push(markers[i][2]);															// If new layer name found it is created
        styleArray.push(new OpenLayers.StyleMap());
        vectorLayer.push(new OpenLayers.Layer.Vector(layerName[j], { styleMap: styleArray[j] }));
        // if (!layerName.includes(markers[i][2])) {
        // }
    
    }

    controls = {
        selector: new OpenLayers.Control.SelectFeature(vectorLayer, {  onSelect: createPopup, onUnselect: destroyPopup })
    };
    
    feature=OpenLayers.Feature.Vector
    
    for (var i = 0; i < markers.length; i++) {
        //var lokasi=markers[i][2];
        var lon = markers[i][0];
        var lat = markers[i][1];
        //console.log(lon)
        Feature[i] = new feature(
            new OpenLayers.Geometry.Point(lon, lat).transform(epsg4326, projectTo),
            {description:markers[i][2]+"<br> JAM: "+markers[i][3] },
            {externalGraphic: 'img/marker.png', graphicHeight: 33, graphicWidth: 33, graphicXOffset:-12, graphicYOffset:-25}
            // see http://dev.openlayers.org/docs/files/OpenLayers/Feature/Vector-js.html#OpenLayers.Feature.Vector.Constants for more options
        );
        
        vectorLayer[layerName.indexOf(markers[i][2])].addFeatures(Feature[i]);
        //createPopup(Feature[i])
        // if(setPopup==1){
            
        // }     
        map.addLayer(vectorLayer[i]);
        // destroyPopup(Feature)
        
    }
    

    
}


function deleteMarker(){
for(var i = 0; i < vectorLayer.length; i++) {
    map.removeLayer(vectorLayer[i])
}
}

function createPopup(feature,controls) {
feature.popup = new OpenLayers.Popup.FramedCloud("pop",
    feature.geometry.getBounds().getCenterLonLat(),
    null,
    '<div class="markerContent">'+feature.attributes.description+'</div>',
    null,
    true,
    function() { 
        //controls['selector'].unselectAll(); 
    }
);
//feature.popup.closeOnMove = true;
map.addPopup(feature.popup);
// map.addControl(controls['selector']);
// controls['selector'].activate();
}
function destroyPopup(feature) {
    feature.popup.destroy();
    feature.popup = null;
    feature.destroy();
}


function getTablePosisi(){
setPopup=0;
//var nama =document.getElementById("carinama").value;
var startDate=document.getElementById("startDate").value;
var endDate=document.getElementById("endDate").value;
    if(startDate==''){
        alert('Inputkan periode awal');
        return;
    }
    if(startDate==''){
        alert('Inputkan periode akhir');
        return
    }
var url="openlayers/posisi";
$.ajax({
    url:url,
    type:"POST",
    dataType:"text",
    data:({startDate:startDate,endDate:endDate}),
    async:false,
    success:function(result){
        //console.log(result);return
        if(result){
            $('#tablePosisi').children('tbody:first').html(result);
        
            if(Feature){
                for(var i = 0; i < Feature.length; i++) {
                    if(Feature[i].popup){
                        Feature[i].popup.destroy()
                    }
                    Feature[i].destroy() 
                }
                Feature=undefined
            }
            
            var jumlahBaris= $("#tablePosisi tbody tr").length
            var markers=[];
            for(var i=0;i<jumlahBaris;i++){
                markers.push([$("input[name=tdLat]").eq(i).val(),$("input[name=tdLon]").eq(i).val(),$("input[name=tdKota]").eq(i).val(),$("input[name=tdTime]").eq(i).val()])
            }
            //console.log(markers);
            SetMarker(markers)
            map.getExtent().toBBOX();
        }else{
          
            $('#tablePosisi').children('tbody:first').html("");
            //console.log(Feature.length)
            if(Feature){
                for(var i = 0; i < Feature.length; i++) {
                    if(Feature[i].popup){
                        Feature[i].popup.destroy()
                    }
                    Feature[i].destroy()
                }
                Feature=undefined
            }               
        }            
    }
})
}
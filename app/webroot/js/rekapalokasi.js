// global the manage memeber table 
var managedata;
   
    $(document).ready(function(){


   $("#managedata").DataTable({

    dom: 'Bfrtip',
    buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
      columnDefs: [
            {
                "targets": [0],
                "visible": false
            
            },
            {
                "targets": [1],
                "visible": false
            
            },
            {
                "targets": [3],
                "visible": false
            
            }

        ]

  });


 $('#managedata tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#managedata').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );


$('#managedata #tampiloutput').on('click', 'tr', function () {


        var data = table.row( this ).data();

        $("#notransaksi").html(data[0]);
        $("#idpermintaan").html(data[1]);
        $("#tglalokasi").html(data[2]);
        $("#nik").html(data[3]);
        $("#namakaryawan").html(data[4]);
        $("#divisi").html(data[5]);
        $("#barangpermintaan").html(data[6]);
        $("#jumlahpermintaan").html(data[7]);
        $("#permintaankurang").html(data[8]);
        $("#statusalokasi").html(data[9]);
        $("#posisi").html(data[10]);
     

    } );


    });

 


    var url = 'rekapalokasis/getData';
    //call jQuery AJAX function
    $.ajax({
      url: url,
      type: "POST",

      success: function(output){
     
          $("#tampiloutput").html(output);
          }
    });  


var stuffs = stuffs || {
    tableObject : false,
    nb_elems : 0
};


/*********************************
*   @name : bind
*   params : /
*   bind  instance  
*********************************/
stuffs.bind = function(){

}


stuffs.insertExport = function(type){
    $.ajax({
        type: "POST",
        url: base_url()+"index.php/exports/insertExport",
        dataType: 'json',
        data: {
            user_id : $('#user_id').val(),
            nb_annonces : stuffs.nb_elems,
            type : type,
            page : 'stuffs'
        },
        success: function(response){
           
        }
    });
}

/* ----- Tables ----- */
/* ------------------- */
stuffs.initTableDatatablesResponsive = function () {
    var table = $('#table');
    
    if(!stuffs.tableObject){
        stuffs.tableObject = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                
            },
            searching:true,
            /* for loadging server side. */
            "processing": true,
            "serverSide": true,
            "ajax": {
                data : {
                    user_id : $('#user_id').val()
                },
                url : base_url()+"index.php/stuffs/getAllDatatable",
            },
            buttons: [
                { 
                    extend: 'print', 
                    className: 'btn dark btn-outline',
                    orientation: 'landscape', 
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    action  : function(e, dt, button, config) {
                        stuffs.insertExport('print');
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    } 

                },{ 
                    extend: 'pdf', 
                    className: 'btn green btn-outline', 
                    orientation: 'landscape', 
                    exportOptions: {
                       columns: [ 0, 1 ]
                    },
                    action  : function(e, dt, button, config) {
                        stuffs.insertExport('pdf');
                        $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);
                    }
                },{ 
                    extend: 'csv', 
                    text: 'Excel 1',
                    className: 'btn purple btn-outline ',
                    orientation: 'landscape',
                    fieldSeparator: ',',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    },
                    action  : function(e, dt, button, config) {
                        stuffs.insertExport('csv');
                        $.fn.dataTable.ext.buttons.csvHtml5.action(e, dt, button, config);
                    }
                },{ 
                    extend: 'csv', 
                    text: 'Excel 2',
                    className: 'btn purple btn-outline ',
                    orientation: 'landscape',
                    fieldSeparator: ';',
                    exportOptions: {
                        columns: [ 0, 1]
                    },
                    action  : function(e, dt, button, config) {
                        stuffs.insertExport('excel');
                        $.fn.dataTable.ext.buttons.csvHtml5.action(e, dt, button, config);
                    }
                }

            ],
            responsive: true,
            parseTime: false,
            fnDrawCallback : function(e){
                stuffs.nb_elems = e._iRecordsDisplay;
            },
            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            "pageLength": 20,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
     });
    }

};


/*********************************
*   @name : init
*   params : /
*   init  instance  
*********************************/
stuffs.init = function(){
    stuffs.tableObject = false;
    stuffs.nb_elems = false;
 
    stuffs.initTableDatatablesResponsive();
    stuffs.bind();
}

/*********************************
*   @name : (window).load
*   params : /
*   Call init method on windows load    
*********************************/
$(document).ready(function() {     
    stuffs.init();

});



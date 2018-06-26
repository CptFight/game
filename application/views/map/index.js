

/***************
* ZIPCODES     *
***************/

var zipcodes = zipcodes || {
};


zipcodes.init = function(){
    zipcodes.google_map = "#google-map";
    zipcodes.search_button = "#search_zipcode";
    zipcodes.input_zip_code = "#zip_code";
    zipcodes.input_radius = "#radius";
    zipcodes.table = ".footable tbody";
    zipcodes.zoom_in = "#zoomIn";

    zipcodes.zoom_out = "#zoomOut";
    list_city_in_area = false;
    zipcodes.list_coord_belgium = false; 
    zipcodes.criterias = {
        zipcode : 4000,
        radius : 5000
    };


    zipcodes.init_list_coord_belgium();
    zipcodes.initTableDatatablesResponsive();
    zipcodes.setGoogleMap(4000,5000);
    zipcodes.bind();
}
   

/***************
* OTHERS       *
***************/

zipcodes.searchCitiesInTheRadius = function (lat, long, radius){

    var list = zipcodes.list_coord_belgium;
    var dist = 0;
    var list_city_in_area = [];
    for(var i=0;i<list.length;i++){
        dist = zipcodes.getDistanceFromLatLonInMeter(lat,long,list[i].lat,list[i].lng);
        if(dist <= radius){
            list_city_in_area[list_city_in_area.length] = list[i];
        }
    }
    
    zipcodes.list_city_in_area = list_city_in_area;
    return list_city_in_area;
}

zipcodes.searchZipCode = function(lat, long){
    var list = zipcodes.list_coord_belgium;
    var dist = 0;
    var radius = 10;
    var list_city_in_area = [];
    for(var i=0;i<list.length;i++){
        dist = zipcodes.getDistanceFromLatLonInMeter(lat,long,list[i].lat,list[i].lng);
        if(dist <= radius){
            list_city_in_area[list_city_in_area.length] = list[i];
        }
    }

    if(typeof list_city_in_area[list_city_in_area.length -1] != 'undefined'){
        return list_city_in_area[list_city_in_area.length -1].zip;
    }else{
        return false;
    }
    
}

zipcodes.init_list_coord_belgium = function(){
    getRemoteContent(base_url()+"assets/geolocalisations/belgium/zipcode-belgium.json", function(json){
        zipcodes.list_coord_belgium = JSON.parse(json);
    });
}

zipcodes.getDistanceFromLatLonInMeter = function(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d * 1000 - 2000;
}


zipcodes.setGoogleMap = function(zipCode,radius){

    getRemoteContent("http://maps.googleapis.com/maps/api/geocode/json?address="+zipCode+",belgium&sensor=false", function(response){
        var obj = JSON.parse(response);
        if(typeof obj.results[0].geometry != 'undefined'){
            var radius = $(zipcodes.input_radius).val();
            var result = obj.results[0].geometry.location;
      
            var location = {
                latitude : result.lat,
                longitude : result.lng
            }

            $(zipcodes.google_map).locationpicker({
                location: location,
                locationName: "",
                radius: radius,
                zoom: 10,
                scrollwheel: true,
                inputBinding: {
                    latitudeInput: null,
                    longitudeInput: null,
                    radiusInput: null,
                    locationNameInput: null
                },
                enableAutocomplete: false,
                enableReverseGeocode: true,
                onchanged: function(currentLocation, radius, isMarkerDropped) {
                    var zipcode = zipcodes.searchZipCode(currentLocation.latitude,currentLocation.longitude);
                    $(zipcodes.input_zip_code).val(zipcode);
                    zipcodes.searchCitiesInTheRadius(currentLocation.latitude,currentLocation.longitude,radius);
                }
            });

        }else{
            return false;
        }

    });
}

zipcodes.getPosFromZipcode = function(zipcode){
    getRemoteContent("http://maps.googleapis.com/maps/api/geocode/json?address="+zipcode+",belgium&sensor=false", function(response){
        var obj = JSON.parse(response);
        if(typeof obj.results[0].geometry != 'undefined'){
            var radius = $(zipcodes.input_radius).val();
            var location = obj.results[0].geometry.location;
            zipcodes.searchCitiesInTheRadius(location.lat,location.lng,radius);
           // zipcodes.printList();
        }else{
            return false;
        }
    });
}


zipcodes.bind = function(){

    $(zipcodes.search_button).click(function(e){
        e.preventDefault();
 
        var zipcode = $(zipcodes.input_zip_code).val();
        var radius = $(zipcodes.input_radius).val();
        zipcodes.setGoogleMap(zipcode,radius);

        zipcodes.getPosFromZipcode(zipcode);


        zipcodes.criterias.zipcode = $(zipcodes.input_zip_code).val();
        zipcodes.criterias.radius = $(zipcodes.input_radius).val();
       
        zipcodes.tableObject.api().ajax.reload(); 
        
    });

    $(zipcodes.zoom_in).click(function(e){
        e.preventDefault();
        var radius = $(zipcodes.input_radius).val();
        $(zipcodes.input_radius).val(parseFloat(radius) - 1000);
        $(zipcodes.search_button).trigger('click');
    });

    $(zipcodes.zoom_out).click(function(e){
        e.preventDefault();
        var radius = $(zipcodes.input_radius).val();
        $(zipcodes.input_radius).val(parseFloat(radius) + 1000);
        $(zipcodes.search_button).trigger('click');
    });


}



/*********************************
*   @name : bind
*   params : /
*   bind  instance  
*********************************/

/* ----- Tables ----- */
/* ------------------- */
zipcodes.initTableDatatablesResponsive = function () {
    var table = $('#map_table');
    
    if(!zipcodes.tableObject){
        zipcodes.tableObject = table.dataTable({
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
            searching:false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                data :function ( d ) {
                   return  $.extend(d, zipcodes.criterias);
                },
                url : base_url()+"index.php/map/getCitiesInAreas",
            },

            /* for loadging server side. */
            
            /* end param server side */

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [
                
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,
            parseTime: false,
            fnDrawCallback : function(){
                
            },

            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    }

};

$(document).ready(function(){   
    zipcodes.init();
});








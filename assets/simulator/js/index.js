$(document).ready(function() {
    $('#table').DataTable({
    	responsive: true, 
    	 "order": [
            [3, 'desc']
        ],
        "pageLength": 20,
    });
});

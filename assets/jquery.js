const $ = require('jquery');
// create global $ and jQuery variables
global.$ = global.jQuery = $;
// this "modifies" the jquery module: adding behavior to it
$(document).ready(function() {
    $('#products_list').DataTable({
        columnDefs: [
            {
                targets: 0,
                className: 'dt-body-center'
            }
        ]
    });
} );
let places = require('places.js');
(function() {
    let placesAutocomplete = places({
        appId: 'plQ1BX7SHJR4',
        apiKey: '9241b4c7a2a45e02268e191071cf6969',
        container: document.querySelector('#product_address_address'),
        useDeviceLocation: true
    });
    placesAutocomplete.on('change', function resultSelected(e) {
        document.querySelector('#product_address_latitude').value = e.suggestion.latlng.lat || '';
        document.querySelector('#product_address_longitude').value = e.suggestion.latlng.lng || '';
    });
})();
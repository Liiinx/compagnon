var places = require('places.js');
var placesAutocomplete = places({
    appId: 'plQ1BX7SHJR4',
    apiKey: '9241b4c7a2a45e02268e191071cf6969',
    container: document.querySelector('#product_address'),
    useDeviceLocation: true
});
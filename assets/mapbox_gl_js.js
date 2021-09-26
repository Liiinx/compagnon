// TO MAKE THE MAP APPEAR YOU MUST // ADD YOUR ACCESS TOKEN FROM
// mapboxgl.accessToken = 'pk.eyJ1IjoiZi10dWZmIiwiYSI6ImNrbWI0dnQzdzE0ODIydnBoOW5uMGw4ZXUifQ.-7cgcpBp7TUjYuCspjT04w';
const algoliasearch = require("algoliasearch");
mapboxgl.accessToken = token_mapbox_gl;
let map = new mapboxgl.Map({
    container: 'mapBox-map', // container id
    // style: 'mapbox://styles/mapbox/streets-v11', // style URL
    style: 'mapbox://styles/f-tuff/ckmb53dzjgyag17rya1py99ze', // style URL
    center: [-6, 45], // starting position [lng, lat]
    zoom: 3, // starting zoom
    doubleClickZoom : false
});
map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.FullscreenControl());
map.addControl(new mapboxgl.ScaleControl());
map.addControl(new mapboxgl.GeolocateControl({
        positionOptions: { enableHighAccuracy: true },
        trackUserLocation: true
    })
);

// locations.forEach(location => new mapboxgl.Marker().setLngLat([location.lng,location.lat]).addTo(map));
locations.forEach( function (location) {
    /*new mapboxgl.Marker()
        .setLngLat([location.lng,location.lat])
        .setPopup(new mapboxgl.Popup().setHTML(location.title + '<br/>' + location.category))
        .addTo(map);*/

    // console.log(location.categoryId);
    let el = document.createElement('div');
    el.style.backgroundImage = 'url(https://placekitten.com/g/40/40/)';
    el.style.width = 40 + 'px';
    el.style.height = 40 + 'px';

    let marker = new mapboxgl.Marker(el)
        .setLngLat([ location.lng,location.lat ])
        .setPopup(new mapboxgl.Popup().setHTML(location.title + '<br/>' + location.category))
        .addTo(map);

    el.addEventListener('click', (e) => {
        console.log(marker);
        marker.togglePopup();
        e.stopPropagation();
    });
    map.on('click', add_popup);
});
// map.on('dblclick', add_popup);
// map.on('click', add_popup);

/*  ---FUNCTIONS---  */
function add_popup (event) {
    let coordinates = event.lngLat;
    new mapboxgl.Popup()
        .setLngLat(coordinates)
        // .setHTML(popupForm())
        .setHTML(form)
        .addTo(map);

    (function() {
        let places = algoliasearch.initPlaces('plQ1BX7SHJR4', '9241b4c7a2a45e02268e191071cf6969');
        function updateForm(response) {
            let hits = response.hits;
            // console.log(hits);
            let suggestion = hits[0];
            if (suggestion && suggestion.locale_names && suggestion.city) {
                document.querySelector('#product_address_address').value = suggestion.locale_names.default[0] || '';
                // document.querySelector('#reverse-town').value = suggestion.city.default[0] || '';
                // document.querySelector('#reverse-zip').value = (suggestion.postcode || [])[0] || '';
                document.querySelector('#product_address_latitude').value = coordinates.lat || '';
                document.querySelector('#product_address_longitude').value = coordinates.lng || '';
            }
        }
        places.reverse({
            aroundLatLng: coordinates.lat + ',' + coordinates.lng,
            hitsPerPage: 1,
        }).then(updateForm);
    })();
}

/*function popupForm() {
    let form = '<form action="/product_map_new" method="post">\n' +
        '  <div class="form-group">\n' +
        '    <label for="title">Title</label>\n' +
        '    <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Enter title">\n' +
        '  </div>\n' +
        '  <div class="form-group">\n' +
        '    <label for="description">Description</label>\n' +
        '    <textarea class="form-control" id="description" name="description" rows="2"></textarea>\n' +
        '  </div>\n' +
        '<div class="form-group">\n' +
        '    <label for="exampleFormControlSelect2">Example multiple select</label>\n' +
        '    <select class="form-control" id="exampleFormControlSelect2">\n' +
        '        <option>1</option>\n' +
        '        <option>2</option>\n' +
        '        <option>3</option>\n' +
        '        <option>4</option>\n' +
        '        <option>5</option>\n' +
        '    </select>\n' +
        '</div>\n' +
        '  <button type="submit" class="btn btn-primary">Save</button>\n' +
        '</form>';
    return form;
}*/

// TO MAKE THE MAP APPEAR YOU MUST // ADD YOUR ACCESS TOKEN FROM
// mapboxgl.accessToken = 'pk.eyJ1IjoiZi10dWZmIiwiYSI6ImNrbWI0dnQzdzE0ODIydnBoOW5uMGw4ZXUifQ.-7cgcpBp7TUjYuCspjT04w';
mapboxgl.accessToken = token_mapbox_gl;
let map = new mapboxgl.Map({
    container: 'mapBox-map', // container id
    // style: 'mapbox://styles/mapbox/streets-v11', // style URL
    style: 'mapbox://styles/f-tuff/ckmb53dzjgyag17rya1py99ze', // style URL
    center: [-6, 45], // starting position [lng, lat]
    zoom: 3 // starting zoom
});
map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.FullscreenControl());
// locations.forEach(location => new mapboxgl.Marker().setLngLat([location.lng,location.lat]).addTo(map));
locations.forEach( function (location) {
    new mapboxgl.Marker()
        .setLngLat([location.lng,location.lat])
        .addTo(map);
});